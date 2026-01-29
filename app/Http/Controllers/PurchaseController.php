<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;



class PurchaseController extends Controller
{
    // Search customer
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
            $customerCode = trim($request->query('code')); // ไม่ต้องลบ quote
    
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
}
