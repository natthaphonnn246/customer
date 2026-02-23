<?php

namespace App\Http\Controllers;
use App\Services\PoService;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PromotionItems;
use App\Models\PromotionOrders;
use App\Models\ReportSeller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        return view('webpanel.promotion-management');
    }

    public function viewDraft(Request $request)
    {
        $userId = Auth::user()->id;
        $orderId = PromotionOrders::where('created_by_id', $userId)
                    ->where('status', 'draft')
                    ->latest('id')
                    ->value('id');

        $viewDraft = PromotionItems::where('promotion_order_id', $orderId)
                    ->get();

        return response()->json([
                                    'orderId'   => $orderId,
                                    'viewDraft' => $viewDraft
                                ]);
        // return view('webpanel.promotion-view', compact('orderId'));
    }
    public function view()
    {
        $userId = Auth::user()->id;
        $orderId = PromotionOrders::where('created_by_id', $userId)
                                    ->where('status', 'draft')
                                    ->latest('id')
                                    ->value('id');

        return view('webpanel.promotion-view', compact('orderId'));
    }

    public function viewDeadStock()
    {
        return view('webpanel.product-slow');
    }

    public function deadStock(Request $request)
    {
        $code_notin = ['0000', '4494', '7787', '9000', '9001', '9002', '9003', '9004', '9005', '9006', '9007', '9008', '9009', '9010', '9011'];
    
        $perpage = 20;
        $status_waiting = DB::table('customers')
                        ->where('status', 'รอดำเนินการ')
                        ->whereNotIn('customer_id', $code_notin)
                        ->count();
    
        $status_updated = DB::table('customers')
                        ->where('status_update', 'updated')
                        ->whereNotIn('customer_id', $code_notin)
                        ->count();
    
        $status_registration = DB::table('customers')
                            ->where('status', 'ลงทะเบียนใหม่')
                            ->whereNotIn('customer_id', $code_notin)
                            ->count();
    
        $status_alert = $status_waiting + $status_updated;
    
        $user_id_admin = $request->user()->user_id ?? null;
    
        $search = $request->search;
        $from = $request->from ?? date('Y-m-d');
        $to   = $request->to ?? date('Y-m-d');
    
        $baseQuery = DB::table('products as p')
            ->leftJoin('report_sellers as r', function ($join) use ($from, $to) {
                $join->on('p.product_id', '=', 'r.product_id')
                ->whereBetween('r.date_purchase', [$from, $to]);
            })        
            ->select(
                'p.product_id',
                'p.product_name',
                'p.generic_name',
                'p.quantity',
                'p.unit',
                'p.status'
            )
            ->whereNull('r.product_id');

        if (!empty($search)) {
            $baseQuery->where(function ($query) use ($search) {
                $query->where('p.product_id', 'like', "%{$search}%")
                        ->orWhere('p.product_name', 'like', "%{$search}%");
            });
        }            
    

        $dead_stock = (clone $baseQuery)
            // ->where('p.status','=', 'เปิด')
            ->get();
    
        return response()->json([
            'status' => 'success',
    
            'summary' => [
                'status_alert' => $status_alert,
                'status_waiting' => $status_waiting,
                'status_updated' => $status_updated,
                'status_registration' => $status_registration,
                'user_id_admin' => $user_id_admin,
            ],
    
            'counts' => [
                'dead_stock' => $dead_stock->count(),
                'product_all' => Product::count(),
                'product_notmove' => Product::where('status', 'ปิด')->count(),
            ],
    
            'data' => [
                'dead_stock' => $dead_stock,
            ],

            'range' => [
                'from' => $from,
                'to'   => $to
            ],
        ]);
    }

    public function createHeaderPo()
    {
        $userId = Auth::id();
    
        // เช็ค draft ก่อน
        $existing = PromotionOrders::where('created_by_id', $userId)
            ->where('status', 'draft')
            ->latest('id')
            ->first();
    
        if ($existing) {
            $orderId = $existing->id;
        } else {
            $orderId = DB::table('promotion_orders')->insertGetId([
                'po' => null,
                'created_by' => Auth::user()->name ?? 'system',
                'created_by_id' => $userId,
                'status' => 'draft',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        return redirect()->route('webpanel.promotion.product.view');
    }
    //check order_id api
    public function editCheck()
    {
        // $order = PromotionOrders::findOrFail($id);
        $userId = Auth::user()->id;
        $orderId = PromotionOrders::where('created_by_id', $userId)
                                ->where('status', 'draft')
                                ->latest('id')
                                ->value('id');

        return response()->json(['orderId' => $orderId]);
    }
    public function confirmPo($orderId, PoService $poService, Request $request)
    {
        return DB::transaction(function () use ($orderId, $poService, $request) {

            $order = DB::table('promotion_orders')
                ->where('id', $orderId)
                ->lockForUpdate()
                ->first();
        
            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }
        
            if ($order->po) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order นี้ถูกยืนยันแล้ว'
                ]);
            }
        
            // generate PO
            $po = $poService->generate();
        
            DB::table('promotion_orders')
                ->where('id', $orderId)
                ->update([
                    'po'         => $po,
                    'status'     => 'confirmed',
                    'order_date' => now(),
                    'updated_at' => now(),
                ]);
        
            // update items
            foreach ($request->products as $item) {
                PromotionItems::where('promotion_order_id', $orderId)
                            ->where('product_id', $item['product_id'])
                            ->update([
                                'qty' => $item['qty'],
                                'price' => $item['price'],
                                'expire' => $item['expire'],
                            ]);
            }
        
            return response()->json(['success' => true]);
        });
    }
    public function addProduct(Request $request)
    {
        $request->validate([
            'order_id'   => 'required|exists:promotion_orders,id',
            'product_id' => 'required',
            'quantity'   => 'required|numeric|min:1',
            'price'      => 'nullable|numeric|min:0',
        ]);

        $order = DB::table('promotion_orders')->where('id', $request->order_id)->first();

        if (DB::table('promotion_items')
                ->where('product_id', $request->product_id)
                ->exists()) {

            return response()->json([
                'status' => 'error',
                'message' => 'มีสินค้านี้อยู่แล้ว'
            ]);
        }

        // กันเพิ่มใน order ที่ confirm แล้ว (optional)
        if ($order->status !== 'draft') {
            return response()->json([
                'status' => 'error',
                'message' => 'Order already confirmed'
            ], 400);
        }

        $qty   = $request->quantity;
        $price = $request->price ?? 0;
        $expire = $request->expire ?? date('y-m-d');

        $unit = Product::where('product_id', $request->product_id)->value('unit');

        $item = DB::table('promotion_items')->insertGetId([
                'promotion_order_id' => $request->order_id,
                'product_id' => $request->product_id,
                'product_name' => $request->product_name,
                'qty' => $qty,
                'price' => $price,
                'expire' => $expire,
                'unit'   => $unit,
                'total' => $qty * $price,
                'note' => $request->note,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        return response()->json([
            'status' => 'success',
            'item_id' => $item
        ]);
    }
    public function addEdit($id)
    {
        $edit = PromotionItems::where('product_id', $id)->first();

        return response()->json(['edit' => $edit]);
    }
    public function addEditUpdate(Request $request, $productId)
    {
        PromotionItems::where('product_id', $productId)->update([
                            'qty'      => $request->quantity,
                            'price'    => $request->price,
                            'expire'   => $request->expire,
                            'note'     => $request->note,
                        ]);
        
        return response()->json(['status' => 'success']);
    }
    public function viewItem(Request $request)
    {
        $product_id = $request->id;
    
        $unit = Product::where('product_id', $product_id)->value('unit');
        // ดึงข้อมูล 3 เดือนล่าสุด
        $raw = ReportSeller::selectRaw('YEAR(date_purchase) as year, MONTH(date_purchase) as month, COUNT(*) as total')
                ->where('product_id', $product_id)
                ->where('date_purchase', '<', now()->startOfMonth())
                ->where('date_purchase', '>=', now()->subMonths(3)->startOfMonth())
                ->groupBy('year', 'month', 'unit')
                ->get()
                ->keyBy(function ($item) {
                    return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                });
    
        $months = [];

        \Carbon\Carbon::setLocale('th');

        for ($i = 1; $i <= 3; $i++) {
            $date = Carbon::now()->subMonth($i);
            $key = $date->format('Y-m');
        
            $months[] = [
                'month' => $date->format('m'),
                'year'  => $date->format('Y'),
                'total' => data_get($raw, "$key.total", 0),
                'product_id' => $product_id,
        
                'label_th' =>  'เดือน' . ' ' . $date->translatedFormat('M') . ' ' . ($date->year + 543),
            ];
        }
    
        return response()->json([
            'item' => $months,
            'unit' => $unit ?? 'ไม่ระบุ',
        ]);
    }
    public function destroy($id)
    {
        PromotionItems::where('product_id', $id)->delete();

        return response()->json(['status' => 'success']);
    }


}
