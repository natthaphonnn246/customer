@extends ('layouts.webpanel')
@section('content')

            <div class="py-2"></div>
            <h5 class="ms-6 !text-gray-600" style="color: #8E8E8E;"><a href="/webpanel/product" class="!no-underline">ย้อนกลับ</a> | รายละเอียดสินค้า</h5>
            <hr class="my-3 !text-gray-400 !border">

            <div class="ms-6" style="text-align: left; margin-top: 10px;">
                <span class="text-gray-600 font-bold text-base">รายละเอียดสินค้า</span>
            </div>

            <hr class="my-3" style="color: #8E8E8E; width: 100%;">

        @if(!empty($product_all))

        <form action="/webpanel/report/product/importproduct/updated/{{ $product_all?->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 mx-4 gap-4">
                    <div class="mb-4">

                        <span class="text-gray-500">รหัสสินค้า</span>
                        <input class="border w-full py-2 px-2 mt-1 rounded-md text-gray-400" type="text" name="product_id" value="{{ $product_all?->product_id }}">

                        <span class="block text-gray-500 mt-3">ชื่อสินค้า</span>
                        <input class="border w-full py-2 px-2 mt-1 rounded-md text-gray-400" type="text" name="product_name" value="{{ $product_all?->product_name }}">

                        <span class="block text-gray-500 mt-3">ชื่อสามัญทางยา</span>
                        <input class="border w-full py-2 px-2 mt-1 rounded-md text-gray-400" type="text" name="generic_name" value="{{ $product_all?->generic_name }}">

                        <span class="block text-gray-500 mt-3">หน่วยสินค้า</span>
                        <input class="border w-full py-2 px-2 mt-1 rounded-md text-gray-400" type="text" name="unit" value="{{ $product_all?->unit }}">

                        <p class="text-gray-500 font-bold text-xl mt-3">สต็อกสินค้า</p>
       
                        <span class="block text-gray-500">จำนวน</span>
                        <input class="border w-full py-2 px-2 mt-1 rounded-md text-gray-400" type="text" name="quantity" value="{{ $product_all?->quantity }}">
     
                        <p class="text-gray-500 font-bold text-xl mt-3">ต้นทุนสินค้า</p>

                        <span class="block text-gray-500 mt-3">ต้นทุน</span>
                        <input class="border w-full py-2 px-2 mt-1 rounded-md text-gray-400" type="text" name="cost" value="{{ $product_all?->cost }}">

                        <div class="border rounded-md p-4 mt-3">
                            <p class="text-gray-500 font-bold text-xl">ระดับราคาสินค้า</p>

                            <span class="block text-gray-500 mt-3">ระดับราคา 1</span>
                            <input class="border w-full py-2 px-2 mt-1 rounded-md text-gray-400" type="text" name="price_1" value="{{ $product_all?->price_1 }}">
        
                            <span class="block text-gray-500 mt-3">ระดับราคา 2</span>
                            <input class="border w-full py-2 px-2 mt-1 rounded-md text-gray-400" type="text" name="price_2" value="{{ $product_all?->price_2 }}">

                            <span class="block text-gray-500 mt-3">ระดับราคา 3</span>
                            <input class="border w-full py-2 px-2 mt-1 rounded-md text-gray-400" type="text" name="price_3" value="{{ $product_all?->price_3 }}">

                            <span class="block text-gray-500 mt-3">ระดับราคา 4</span>
                            <input class="border w-full py-2 px-2 mt-1 rounded-md text-gray-400" type="text" name="price_4" value="{{ $product_all?->price_4 }}">

                            <span class="block text-gray-500 mt-3">ระดับราคา 5</span>
                            <input class="border w-full py-2 px-2 mt-1 rounded-md text-gray-400" type="text" name="price_5" value="{{ $product_all?->price_5 }}">
                        </div>

                    </div>

                    <div>

                        <p class="text-gray-500 font-bold text-xl mt-3">สถานะสินค้า</p>

                        <span class="block text-gray-500 mt-3">สถานะสินค้า</span>
                        <select class="form-select mt-1 !text-gray-400" aria-label="Default select example" name="status">
                        
                            <option {{ $product_all?->status == 'ปิด' ? 'selected' : '' }} value="ปิด">ปิด</option>
                            <option {{ $product_all?->status == 'เปิด' ? 'selected' : '' }} value="เปิด">เปิด</option>

                        </select>

                        <div class="border rounded-md p-4 mt-3">
                            <p class="text-gray-500 font-bold text-xl">กลุ่มยา</p>

                            <span class="text-gray-500">หมวดหมู่ยา</span>
                            <select class="form-select mt-1 !text-gray-400" aria-label="Default select example" id="category" name="category">
                                
                                @if(!empty($category))
                                    @foreach($category as $row_cate)
                                        <option {{ $product_all?->category == $row_cate?->categories_id ? 'selected' : '' }} value="{{ $row_cate->categories_id }}">{{ $row_cate?->categories_name .' '. '('. $row_cate?->categories_id .')' }}</option>
                                    @endforeach
                                @endif
                                

                            </select>
                        
                            <span class="block text-gray-500 mt-3">หมวดหมู่ยาย่อย</span>
                            <select class="form-select !text-gray-400" aria-label="Default select example" id="sub_category" name="sub_category">
                            
                                @if(!empty($subcategory))
                                    @foreach($subcategory as $row_sub)
                                        <option {{ $product_all?->sub_category == $row_sub?->subcategories_id ? 'selected' : '' }} value="{{ $row_sub->subcategories_id }}">{{ $row_sub?->subcategories_name .' '. '('. $row_sub?->subcategories_id .')' }}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                        

                        <script>
                            document.getElementById('category').addEventListener('change', async function (e) {
                                e.preventDefault();
                            
                                const categoryId = this.value;
                                console.log('category_id:', categoryId);
                            
                                if (!categoryId) return;
                            
                                try {
                                    const response = await fetch(`/webpanel/report/product/new-product/subcategory?category_id=${categoryId}`);
                                    const data = await response.text();
                            
                                    console.log('response data (HTML):', data);

                                    const subSelect = document.getElementById('sub_category');
                                    subSelect.innerHTML = data;

                                } catch (error) {
                                    console.error('Fetch error:', error);
                                }

                            });

                        </script>
                   
                            <div class="border rounded-md p-4 mt-3">
                                <p class="text-gray-500 font-bold text-xl">แบบอนุญาตขายยา</p>
                
                                <span class="block text-gray-500 mt-2">แบบ ข.ย.1</span>
                                <select class="form-select mt-1 !text-gray-400" aria-label="Default select example" name="khor_yor_1">
                            
                                    <option {{ $product_all?->khor_yor_1 == '0' ? 'selected' : '' }} value="0">ปิด</option>
                                    <option {{ $product_all?->khor_yor_1 == '1' ? 'selected' : '' }} value="1">เปิด</option>

                                </select>
                                
                                <span class="block mt-2 text-gray-500">แบบ ข.ย.2</span>
                                <select class="form-select mt-1 !text-gray-400" aria-label="Default select example" name="khor_yor_2">
                            
                                    <option {{ $product_all?->khor_yor_2 == '0' ? 'selected' : '' }} value="0">ปิด</option>
                                    <option {{ $product_all?->khor_yor_2 == '1' ? 'selected' : '' }} value="1">เปิด</option>

                                </select>
                                
                                <span class="block mt-2 text-gray-500">แบบ สมพ.2</span>
                                <select class="form-select mt-1 !text-gray-400" aria-label="Default select example" name="som_phor_2">
                            
                                    <option {{ $product_all?->som_phor_2 == '0' ? 'selected' : '' }} value="0">ปิด</option>
                                    <option {{ $product_all?->som_phor_2 == '1' ? 'selected' : '' }} value="1">เปิด</option>

                                </select>
                        
                                <span class="block mt-2 text-gray-500">คลินิกยา/สถานพยาบาล</span>
                                <select class="form-select mt-1 !text-gray-400"  aria-label="Default select example" name="clinic">
                            
                                    <option {{ $product_all?->clinic == '0' ? 'selected' : '' }} value="0">ปิด</option>
                                    <option {{ $product_all?->clinic == '1' ? 'selected' : '' }} value="1">เปิด</option>

                                </select>
                            </div>
                     

                        <div style="text-align:right;">
                            <button type="submit" id="updateForm" name="submit_update" class="btn my-4" style="border:none; width: 100px; color: white; padding: 10px;">บันทึก</button>
                            {{-- <a href="/webpanel/customer/getcsv/{{$product_all?->id}}" type="button" id="exportCsv" class="btn my-2" style="border:none; width: 120px; color: rgb(67, 67, 67); padding: 10px;">Export CSV</a> --}}
                        </div>
                    </div>
                </div>
        </form>
        @else
        <div class="text-center py-8">
            <span style="background-color: #ffc637; padding:15px;">
                ไม่พบข้อมูล
            </span>
        </div>
    @endif

            @if (session('updated_id') == 'updated_success')
                                    <script> 
                                            $('#bg').css('display', 'none');
                                            Swal.fire({
                                                title: "สำเร็จ",
                                                text: "อัปเดตข้อมูลเรียบร้อย",
                                                icon: "success",
                                                // showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                // cancelButtonColor: "#d33",
                                                confirmButtonText: "ตกลง"
                                                }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.reload();
                                                }
                                            });
                                    </script>
            @endif

            @if (session('fail_id') == 'error')
            <script> 
                        $('#bg').css('display', 'none');
                        Swal.fire({
                            title: "เกิดข้อผิดพลา",
                            text: "อัปเดตไม่สำเร็จ",
                            icon: "error",
                            // showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            // cancelButtonColor: "#d33",
                            confirmButtonText: "ตกลง"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                </script>
            @endif
        </div>

        <script>
            $(function () {
                $("#datepickerStart").datepicker({
                    dateFormat: 'dd/mm/yy',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "2025:2031"
                });
            
                $("#openDatepickerStart").on("click", function () {
                    $("#datepickerStart").focus();
                });
            });

            $(function () {
                $("#datepickerEnd").datepicker({
                    dateFormat: 'dd/mm/yy',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "2526:2031"
                });
            
                $("#openDatepickerEnd").on("click", function () {
                    $("#datepickerEnd").focus();
                });
            });
        </script>

@endsection
@push('styles')
    <style>
        #updateForm {
            background-color: #4355ff;
            color:white;
        }
        #updateForm:hover {
            width: auto;
            height: auto;
            background-color: #0f21cb;
        }
    </style>
@endpush
