@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">

            
        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/report/product/importproduct" class="!no-underline">ย้อนกลับ</a> | นำเข้าไฟล์สินค้า</h5>
        <hr class="my-3 !text-gray-400 !border">

        <form action="/webpanel/report/product/new-product/created" method="post" enctype="multipart/form-data">
            @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 mx-2">
                    <div>
                        <ul class="mt-2">
                            <span class="mt-4" style="color:#717171;">รหัสสินค้า</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="product_id" value="" required>
                        </ul>

                        <ul class="mt-2">
                            <span style="color:#717171;">ชื่อสินค้า</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="product_name" value="">
                        </ul>

                        <ul class="mt-2">
                            <span style="color:#717171;">ชื่อสามัญทางยา</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="generic_name" value="">
                        </ul>

                        <ul class="mt-2">
                            <span style="color:#717171;">หน่วยสินค้า</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="unit" value="">
                        </ul>

                        <ul class="mt-2">
                            <span style="color: #373737; font-size:18px; font-weight:400;">สต็อกสินค้า</span>
                        </ul>
            
                        <ul class="mt-2">
                            <span style="color:#717171;">จำนวน</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="quantity" value="">
                        </ul>

                        <ul class="mt-2">
                            <span style="color: #373737; font-size:18px; font-weight:400;">ต้นทุนสินค้า</span>
                        </ul>

                        <ul class="mt-2">
                            <span style="color:#717171;">ต้นทุน</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="cost" value="">
                        </ul>

                        <ul class="mt-2">
                            <span style="color: #373737; font-size:18px; font-weight:400;">ระดับราคาสินค้า</span>
                        </ul>
            
                        <ul class="mt-2 py-2">
                            <span style="color:#717171;">ระดับราคา 1</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_1" value="">
                        </ul>

                        <ul class="mt-2">
                            <span style="color:#717171;">ระดับราคา 2</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_2" value="">
                        </ul>

                        <ul class="mt-2">
                            <span style="color:#717171;">ระดับราคา 3</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_3" value="">
                        </ul>

                        <ul class="mt-2">
                            <span style="color:#717171;">ระดับราคา 4</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_4" value="">
                        </ul>

                        <ul class="mt-2 mb-4">
                            <span style="color:#717171;">ระดับราคา 5</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_5" value="">
                        </ul>

                    </div>

                    <div class="mr-8">
                        <ul class="mt-1" ">
                            <span style="color:#717171;">หมวดหมู่ยา</span><span style="font-size: 12px; color:red;"></span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" id="category" name="category">
                                
                                @if(!empty($category))
                                    @foreach($category as $row_cate)
                                        <option value="{{ $row_cate->categories_id }}">{{ $row_cate?->categories_name .' '. '('. $row_cate?->categories_id .')' }}</option>
                                    @endforeach
                                @endif
                               

                            </select>
                        </ul>

                        <ul class="mt-3" ">
                            <span style="color:#717171;">หมวดหมู่ยาย่อย</span><span style="font-size: 12px; color:red;"></span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" id="sub_category" name="sub_category">
                            
                                @if(!empty($subcategory))
                                    @foreach($subcategory as $row_sub)
                                        <option value="{{ $row_sub->subcategories_id }}">{{ $row_sub?->subcategories_name .' '. '('. $row_sub?->subcategories_id .')' }}</option>
                                    @endforeach
                                @endif

                            </select>
                        </ul>

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

                        <ul class="mt-3" ">
                            <span style="color:#717171;">สถานะสินค้า</span><span style="font-size: 12px; color:red;"></span>
                            <select class="form-select" style="margin-top:16px; color: rgb(171, 171, 171);" aria-label="Default select example" name="status">
                            
                                <option value="ปิด">ปิด</option>
                                <option value="เปิด">เปิด</option>

                            </select>
                        </ul>

                        <ul class="mt-2">
                            <span style="color: #373737; font-size:18px; font-weight:400;">แบบอนุญาตขายยา</span>
                        </ul>
            
                        <div style="margin-left:10px;">
                            <ul class="mt-2">
                                <span style="color:#717171;">แบบ ข.ย.1</span>
                                <select class="form-select" style="margin-top:16px; color: rgb(171, 171, 171);" aria-label="Default select example" name="khor_yor_1">
                            
                                    <option value="0">ปิด</option>
                                    <option value="1">เปิด</option>
    
                                </select>
                            </ul>

                            <ul class="mt-2">
                                <span style="color:#717171;">แบบ ข.ย.2</span>
                                <select class="form-select" style="margin-top:16px; color: rgb(171, 171, 171);" aria-label="Default select example" name="khor_yor_1">
                            
                                    <option value="0">ปิด</option>
                                    <option value="1">เปิด</option>

                                </select>
                            </ul>

                            <ul class="mt-2">
                                <span style="color:#717171;">แบบ สมพ.2</span>
                                <select class="form-select" style="margin-top:16px; color: rgb(171, 171, 171);" aria-label="Default select example" name="som_phor_2">
                            
                                    <option value="0">ปิด</option>
                                    <option value="1">เปิด</option>
    
                                </select>
                            </ul>

                            <ul class="mt-2">
                                <span style="color:#717171;">คลินิกยา/สถานพยาบาล</span>
                                <select class="form-select" style="margin-top:16px; color: rgb(171, 171, 171);" aria-label="Default select example" name="clinic">
                            
                                    <option value="0">ปิด</option>
                                    <option value="1">เปิด</option>
    
                                </select>
                            </ul>
                        </div>
                        <ul class="mt-2">
                            <hr class="mt-4 ms-2" style="color:#8E8E8E;">
                        </ul>

                        <div style="text-align:right;">
                            <button type="submit" id="updateForm" name="submit_form" class="btn my-4" style="border:none; width: 100px; color: white; padding: 10px;">บันทึก</button>
                            {{-- <a href="/webpanel/customer/getcsv/{{$product_all?->id}}" type="button" id="exportCsv" class="btn my-2" style="border:none; width: 120px; color: rgb(67, 67, 67); padding: 10px;">Export CSV</a> --}}
                        </div>

                    </div>
                </div>
            
        </form>

    </div>

            @if (session('success') == 'create-success')
                <script> 
                        $('#bg').css('display', 'none');
                        Swal.fire({
                            title: "สำเร็จ",
                            text: "เพิ่มสินค้าเรียบร้อย",
                            icon: "success",
                            // showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            // cancelButtonColor: "#d33",
                            confirmButtonText: "ตกลง"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                // window.location.reload();
                                window.location.href = '/webpanel/report/product/importproduct';

                            }
                        });
                </script>
            @endif

            @if (session('error') == 'create-error')
                <script> 
                        $('#bg').css('display', 'none');
                        Swal.fire({
                            title: "เกิดข้อผิดพลา",
                            text: "เพิ่มสินค้าไม่สำเร็จ",
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

            @if (session('fail') == 'create-fail')
                <script> 
                        $('#bg').css('display', 'none');
                        Swal.fire({
                            title: "เกิดข้อผิดพลา",
                            text: "สินค้ามีอยู่แล้ว",
                            icon: "warning",
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
