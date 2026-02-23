<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderingItem;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class OrderingController extends Controller
{

    protected function userId(): ?int
    {
        return Auth::id();
    }

    protected function userName(): ?string
    {
        return Auth::user()?->name;
    }

    public function index()
    {
        $userId = $this->userId();

        $orderId = Order::where('created_by', $userId)
                    ->where('status', 'draft')
                    ->latest('id')
                    ->value('id');

        return view('webpanel.ordering-new', compact('orderId'));
    }
    public function searchCustomer(Request $request)
    {
        $q = $request->query('q', '');
        $customers = Customer::where('customer_name', 'LIKE', "%{$q}%")
            ->orWhere('customer_code', 'LIKE', "%{$q}%")
            ->limit(10)
            ->get(['customer_code', 'customer_name as name', 'price_level', 'province', 'type']);

        return response()->json($customers);
    }

    // Search product by customer_code and keyword
    public function productSearch(Request $request)
    {
        try {
            $keyword = $request->query('q', '');
            $customerCode = trim($request->query('code', ''));
    
            // ดึงข้อมูลลูกค้า
            $customer = Customer::where('customer_code', $customerCode)->first();
            if (!$customer) {
                return response()->json([]); // ถ้าไม่เจอ customer ให้ return empty array แทน 500
            }
    
            $priceLevel = $customer->price_level ?? '1';
            $customerType = $customer->type ?? '';
    
            // Mapping type -> flag column
            $typeMap = [
                'ข.ย.1' => 'khor_yor_1',
                'ข.ย.2' => 'khor_yor_2',
                'สมพ.2' => 'som_phor_2',
                'คลินิกยา/สถานพยาบาล' => 'clinic',
            ];
    
            $flagColumn = $typeMap[$customerType] ?? null;
    
            // Query product
            $productsQuery = Product::query()
                            ->where(function($q) use ($keyword){
                                $q->where('product_id', 'LIKE', "%{$keyword}%")
                                ->orWhere('product_name', 'LIKE', "%{$keyword}%");
                            })
                            ->limit(20);
    
            // ตรวจสอบ column ก่อน filter
            if ($flagColumn && Schema::hasColumn('products', $flagColumn)) {
                $productsQuery->where($flagColumn, 1);
            }
    
            $products = $productsQuery->get()->map(function($p) use ($priceLevel) {
                $priceColumn = 'price_' . $priceLevel;

                    return [
                        'product_id' => $p->product_id,
                        'product_name' => $p->product_name,
                        'unit' => $p->unit,
                        'price' => $p->{$priceColumn} ?? $p->price_1,
                    ];
                });
    
            return response()->json($products);
    
        } catch (\Exception $e) {
            Log::error('Product search error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'customer_code' => $customerCode,
                'keyword' => $keyword
            ]);
            return response()->json(['error'=>$e->getMessage()], 500);
        }
    }
    // Save PO
    public function savePO(Request $request)
    {
        $data = $request->validate([
            'po_number' => 'required|string',
            'customer_id' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|string',
            'items.*.qty' => 'required|numeric|min:0',
            'items.*.amount' => 'required|numeric|min:0',
        ]);

        // ตัวอย่างบันทึก (ปรับตาม model ของคุณ)
        // PO::create($data);

        return response()->json(['success' => true]);
    }

    // ค้นหาร้านค้า
/*     public function searchCustomer(Request $request)
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
    } */

    // ค้นหาสินค้า
    // public function searchProduct(Request $request)
    // {
    //     return DB::table('products')
    //         ->where(function ($q) use ($request) {
    //             $q->where('product_id', 'like', "%{$request->q}%")
    //               ->orWhere('product_name', 'like', "%{$request->q}%");
    //         })
    //         ->limit(20)
    //         ->get([
    //             'product_id',
    //             'product_name',
    //             'unit',
    //             'price'
    //         ]);
    // }

    public function createHeaderPo(Request $request)
    {
        $request->validate(['customer_id' => 'required']);

        $userId = $this->userId();
        $userName = $this->userName();

        try {
            $customer = DB::table('customers')->where('customer_code', $request->customer_id)->first();

            if (!$customer) {
                throw new \Exception("ไม่พบลูกค้า: {$request->customer_id}");
            }

            $order = Order::create([
                    'po_number'         => null,
                    'po_date'           => now(),
                    'customer_code'     => $customer->customer_code,
                    'customer_name'     => $customer->customer_name,
                    'price_level'       => $customer->price_level,
                    'status'            => 'draft',
                    'total_amount'      => 0,
                    'created_by'        => $userId ?? 0,
                    'created_by_name'   => $userName ?? 'admin',
                ]);

            return response()->json(['order' => $order]);
        } catch (\Exception $e) {
            Log::error("createDraft error: ".$e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getLatestDraftPO()
    {
        $userId = $this->userId();

        $po = Order::where('created_by', $userId)
                    ->where('status', 'draft')
                    ->latest('id')
                    ->first();

        if ($po && $po->customer) {
            $data = [
                'success' => true,
                'customerCode' => $po->customer->customer_code,
                'customerName' => $po->customer->customer_name,
                'customerAddress' => $po->customer->address,
                'customerPriceLevel' => $po->customer->price_level,
            ];
        } else {
            // กรณีไม่มี PO หรือไม่มี customer
            $data = [
                'order_id' => null,
                'po_name' => null,
                'customerCode' => '-',
                'customerName' => '-',
                'customerAddress' => '-',
                'customerPriceLevel' => '-',
            ];
        }

        return response()->json($data);
    }
    public function saveDraft(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'items' => 'required|array|min:1',
            'items.*.product_code' => 'required|string',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric',
        ]);

        foreach ($request->items as $item) {

            if (!isset($item['product_code']) || trim($item['product_code']) === '') {
                continue;
            }

            OrderingItem::updateOrCreate(
                [
                    'order_id' => $request->order_id,
                    'product_code' => $item['product_code'],
                ],
                [
                    'product_name' => $item['product_name'] ?? null,
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'total_price' => $item['total_price'] ?? 0,
                    'reserve' => $item['reserve'] ?? false,
                ]
            );
        }

        Order::where('id', $request->order_id)->update([
            'total_amount' => OrderingItem::where('order_id', $request->order_id)->sum('total_price')
        ]);

        return response()->json(['success' => true]);
    }

    public function confirm(Request $request)
    {
        Order::where('id', $request->order_id)
            ->update(['status' => 'confirmed']);

        return response()->json(['success' => true]);
    }
    public function viewDraft(Order $order)
    {
        $items = $order->items;
        // $order = Order::with('customer')->findOrFail(77);
        $userId = $this->userId();

        $orderId = Order::where('created_by', $userId)
                    ->where('status', 'draft')
                    ->latest('id')
                    ->value('id');
    
        $items = OrderingItem::where('order_id', $order->id)
                ->whereNotNull('product_code')
                ->where('product_code', '!=', 'undefined')
                ->get()
                ->map(function ($row) {
                    return [
                        // ให้ key ตรงกับ JS
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
    
        return response()->json([
                                    'orderId' => $orderId,
                                    'itemsDraft' => $items,
                                    'success' => true
                                ]);

    }

    
    public function checkProduct(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders_tb,id',
            'product_code' => 'required|string'
        ]);

        $exists = OrderingItem::where('order_id', $request->order_id)
                        ->where('product_code', $request->product_code)
                        ->exists();

        return response()->json(['exists' => $exists]);
    }
    public function viewItem (Request $request)
    {
        $id = $request->id;
        $item = Product::where('product_id', $id)
                    ->join('subcategories', 'products.sub_category', '=', 'subcategories.subcategories_id')
                    ->select('products.*', 'subcategories.subcategories_name')
                    ->first();
        
        return response()->json(['item' => $item]);
    }
    
}
