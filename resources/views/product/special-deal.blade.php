@extends ('layouts.webpanel')
@section('content')

    <div class="py-2"></div>
    <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/product" class="!no-underline">ย้อนกลับ</a> | ดีลพิเศษ</h5>
    <hr class="my-3 !text-gray-400 !border">

    <div class="mx-8">
        <p class="text-base font-bold text-gray-500">รหัสสินค้า : {{ $item?->product_id}}</p>
        <p class="text-base font-bold text-gray-500">ชื่อสินค้า : {{ $item?->product_name}}</p>
    </div>
    <div
        x-data="{
            deals: [
                { qty: '', price: '', stock: '', status: '0' }
            ],
            addDeal() {
                this.deals.push({ qty: '', price: '', stock: '', status: '1' });
            },
            removeDeal(index) {
                if (this.deals.length > 1) {
                    this.deals.splice(index, 1);
                }
            }
        }"
        class="grid grid-cols-1 md:grid-cols-2 mx-4 gap-3"
        >
        
        <template x-for="(deal, index) in deals" :key="index">
            <div class="border p-4 rounded-lg mt-3">
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 font-bold text-xl">
                        ดีลพิเศษ #<span x-text="index + 1"></span>
                    </span>
                </div>

                <!-- จำนวน -->
                <span class="block text-gray-500 mt-2">
                    จำนวน <span class="text-red-500 text-xs">*ขั้นต่ำ 1</span>
                </span>
                <input type="number"
                    x-model="deal.qty"
                    :name="'deals['+index+'][qty]'"
                    class="border px-2 py-2 w-full rounded-md mt-1">

                <!-- ราคา -->
                <span class="block text-gray-500 mt-2">
                    ราคาดีลพิเศษ <span class="text-red-500 text-xs">*ขั้นต่ำ 1</span>
                </span>
                <input type="number"
                    x-model="deal.price"
                    :name="'deals['+index+'][price]'"
                    class="border px-2 py-2 w-full rounded-md mt-1">

                <!-- สต๊อก -->
                <span class="block text-gray-500 mt-2">สต๊อก</span>
                <input type="number"
                    x-model="deal.stock"
                    :name="'deals['+index+'][stock]'"
                    class="border px-2 py-2 w-full rounded-md mt-1">

                <!-- สถานะ -->
                <span class="block text-gray-500 mt-2">สถานะ</span>
                <select 
                    x-model="deal.status"
                    :name="'deals['+index+'][status]'"
                    class="form-select mt-1 !text-gray-400 w-full"
                >
                    <option value="0">ปิด</option>
                    <option value="1">เปิด</option>
                </select>

                <div class="text-end">
                    <button
                    type="submit"
                    class="text-white text-sm bg-blue-500 hover:bg-blue-600 px-4 py-2 !rounded-md mt-3"
                    >
                        บันทึก
                    </button>
                    <button 
                        type="button"
                        @click="removeDeal(index)"
                        class="text-white text-sm bg-red-400 hover:bg-red-500 px-4 py-2 !rounded-md mt-3"
                    >
                        ลบ
                    </button>
                </div>

            </div>
        </template>

        <!-- ปุ่มเพิ่ม -->
        <div>
            <button 
                type="button"
                @click="addDeal"
                class="mt-3 px-4 py-2 bg-blue-500 text-white !rounded-md mb-4"
            >
                + เพิ่มดีล
            </button>
        </div>
        <div class="py-2"></div>
    </div>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection