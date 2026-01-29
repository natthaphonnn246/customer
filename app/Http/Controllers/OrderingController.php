<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Ordering;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderingController extends Controller
{
    public function index()
    {
        return view('purchase.ordering'); // blade ที่คุณส่งมา
    }

    // ค้นหาร้านค้า
    public function searchCustomer(Request $request)
    {
        return DB::table('customers')
            ->where('name', 'like', "%{$request->q}%")
            ->limit(20)
            ->get([
                'customer_code',
                'name',
                'province',
                'price_level'
            ]);
    }

    // ค้นหาสินค้า
    public function searchProduct(Request $request)
    {
        return DB::table('products')
            ->where(function ($q) use ($request) {
                $q->where('product_id', 'like', "%{$request->q}%")
                  ->orWhere('product_name', 'like', "%{$request->q}%");
            })
            ->limit(20)
            ->get([
                'product_id',
                'product_name',
                'unit',
                'price'
            ]);
    }

    // บันทึกใบสั่งซื้อ
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'items'       => 'required|array|min:1',
        ]);
    
        return DB::transaction(function () use ($request) {

    
            // สร้าง PO
            $order = Order::create([
                'po_number'      => $this->generatePO(),
                'po_date'        => now(),
                'customer_code'  => $request->customer_id,
                'customer_name'  => DB::table('customers')
                                        ->where('customer_code', $request->customer_id)
                                        ->value('customer_name'),
                'price_level'    => DB::table('customers')
                                        ->where('customer_code', $request->customer_id)
                                        ->value('price_level'),
                'status'         => 'draft',
                'total_amount'   => collect($request->items)->sum('amount'),
                'created_by'     => Auth::id(),
            ]);
    
            // Items
            foreach ($request->items as $item) {

                $exists = Ordering::where('order_id', $request->order_id)
                    ->where('product_code', $item['product_code'])
                    ->exists();

                if ($exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'พบสินค้าซ้ำใน draft'
                    ], 422);
                }

                Ordering::create([
                    'order_id'     => $order->id,
                    'product_code' => $item['product_code'], // <-- ใช้ product_code
                    'product_name' => $item['product_name'], // ใช้ชื่อจริงจาก payload
                    'unit'         => $item['unit'],
                    'qty'          => $item['qty'],
                    'price'        => $item['amount'] / max($item['qty'], 1),
                    'total_price'  => $item['amount'],      // ตรงกับ DB
                    'remark'       => $item['note'] ?? null,
                    'reserve'      => $item['reserve'] ?? false,
                ]);
            }
    
            return response()->json([
                'success' => true,
                'order_id' => $order->id,
            ]);
        });
    }
    
    public function createDraft(Request $request)
    {
        $request->validate(['customer_id' => 'required']);

        try {
            $customer = DB::table('customers')->where('customer_code', $request->customer_id)->first();

            if (!$customer) {
                throw new \Exception("ไม่พบลูกค้า: {$request->customer_id}");
            }

            $order = Order::create([
                'po_number'     => $this->generatePO(),
                'po_date'       => now(),
                'customer_code' => $customer->customer_code,
                'customer_name' => $customer->customer_name,
                'price_level'   => $customer->price_level,
                'status'        => 'draft',
                'total_amount'  => 0,
                'created_by'    => Auth::id() ?? 1,
            ]);

            return response()->json(['order_id' => $order->id]);
        } catch (\Exception $e) {
            Log::error("createDraft error: ".$e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getLatestDraftPO()
    {
        // ดึง PO ล่าสุดของ admin ที่ล็อกอิน พร้อม customer info
        $po = Order::where('created_by', Auth::id())
                    ->where('status', 'draft')
                    ->where('id', 58)
                    ->orderBy('po_number','desc') // เรียงจากล่าสุด
                    ->first();

        if ($po && $po->customer) {
            $data = [
                'success' => true,
                'po_number' => $po->po_number,
                'po_name' => $po->po_name,
                'customerCode' => $po->customer->customer_code,
                'customerName' => $po->customer->customer_name,
                'customerProvince' => $po->customer->province,
                'customerPriceLevel' => $po->customer->price_level,
            ];
        } else {
            // กรณีไม่มี PO หรือไม่มี customer
            $data = [
                'success' => false,
                'order_id' => null,
                'po_name' => null,
                'customerCode' => '-',
                'customerName' => '-',
                'customerProvince' => '-',
                'customerPriceLevel' => '-',
            ];
        }

        return response()->json($data);
    }

    
    public function saveItem(Request $request)
    {
        // Validate input
        $request->validate([
            'order_id' => 'required|exists:orders_tb,id',
            'items'    => 'required|array|min:1',
        ]);
    
        foreach ($request->items as $item) {
            $productCode = trim($item['product_code'] ?? '');
            
            if (
                empty($item['product_code']) ||
                $item['product_code'] === 'undefined'
            ) {
                Log::warning('BLOCKED INVALID ITEM', $item);
                continue;
            }
        
        
            $qty = $item['qty'] ?? 0;
        
            Ordering::updateOrCreate(
                [
                    'order_id'     => (int) $request->order_id,
                    'product_code' => $productCode,
                ],
                [
                    'product_name' => $item['product_name'] ?? null,
                    'unit'         => $item['unit'] ?? null,
                    'qty'          => $qty,
                    'price'        => ($item['price'] ?? 0),
                    'total_price'  => $item['total_price'] ?? 0,
                    'remark'       => $item['remark'] ?? null,
                    'reserve'      => $item['reserve'] ?? false,
                ]
            );
        }
        
        
    
        // Update total_amount ของ PO
        Order::where('id', $request->order_id)
            ->update([
                'total_amount' => Ordering::where('order_id', $request->order_id)->sum('total_price')
            ]);
            Log::warning('SAVE ITEMS RAW', $request->all());
            return response()->json(['success' => true]);

    }

    public function confirm(Request $request)
    {
        Order::where('id', $request->order_id)
            ->update(['status' => 'confirmed']);

        return response()->json(['success' => true]);
    }

    private function generatePO(): string
    {
        $date = now()->format('ymd');
        $run  = Order::whereDate('created_at', today())->count() + 1;
        return "PO{$date}" . str_pad($run, 3, '0', STR_PAD_LEFT);
    }
    public function edit()
    {
        $order = Order::with('customer')->findOrFail(58);
    
        $items = Ordering::where('order_id', $order->id)
            ->whereNotNull('product_code')
            ->where('product_code', '!=', 'undefined')
            ->get()
            ->map(function ($row) {
                return [
                    // ⭐ ให้ key ตรงกับ JS
                    'product_code' => $row->product_code,
                    'name'         => $row->product_name ?? '',
                    'unit'         => $row->unit ?? '',
                    'qty'          => $row->qty ?? 0,
                    'price'        => $row->price ?? 0,
                    'total_price'  => $row->total_price ?? 0,
                    'remark'       => $row->remark ?? '',
                    'reserve'      => (bool) $row->reserve,
                ];
            });
    
        return view('webpanel/ordering', [
            'items'        => $items,
            'customerCode' => $order->customer_code,
            'priceLevel'   => $order->price_level,
            'orderId'      => $order->id,
        ]);
    }
    
    public function checkProduct(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders_tb,id',
            'product_code' => 'required|string'
        ]);

        $exists = Ordering::where('order_id', $request->order_id)
                        ->where('product_code', $request->product_code)
                        ->exists();

        return response()->json(['exists' => $exists]);
    }

    
}
