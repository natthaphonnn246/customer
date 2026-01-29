@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">

            <div class="py-2"></div>
            <h5 class="ms-6 !text-gray-600" style="color: #8E8E8E;"><a href="/webpanel/report/product/importproduct" class="!no-underline">ย้อนกลับ</a> | รายละเอียดสินค้า</h5>
            <hr class="my-3 !text-gray-400 !border">

            <div class="ms-6" style="text-align: left; margin-top: 10px;">
                <span style="color: #373737; font-size:18px; font-weight:400;">รายละเอียดสินค้า</span>
            </div>

            <hr class="my-3" style="color: #8E8E8E; width: 100%;">

        @if(!empty($product_all))

        <form action="/webpanel/report/product/importproduct/updated/{{ $product_all?->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div>
                        <ul class="mt-2">
                            <span style="color:#717171;">รหัสสินค้า</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="product_id" value="{{ $product_all?->product_id }}">
                        </ul>

                        <ul class="mt-2">
                            <span style="color:#717171;">ชื่อสินค้า</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="product_name" value="{{ $product_all?->product_name }}">
                        </ul>

                        <ul class="mt-2">
                            <span style="color:#717171;">ชื่อสามัญทางยา</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="generic_name" value="{{ $product_all?->generic_name }}">
                        </ul>

                        <ul class="mt-2">
                            <span style="color:#717171;">หน่วยสินค้า</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="unit" value="{{ $product_all?->unit }}">
                        </ul>

                        <ul class="mt-2">
                            <span style="color: #373737; font-size:18px; font-weight:400;">สต็อกสินค้า</span>
                        </ul>
            
                        <ul class="mt-2">
                            <span style="color:#717171;">จำนวน</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="quantity" value="{{ $product_all?->quantity }}">
                        </ul>

                        <ul class="mt-2">
                            <span style="color: #373737; font-size:18px; font-weight:400;">ต้นทุนสินค้า</span>
                        </ul>

                        <ul class="mt-2">
                            <span style="color:#717171;">ต้นทุน</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="cost" value="{{ $product_all?->cost }}">
                        </ul>

                        <ul class="mt-2">
                            <span style="color: #373737; font-size:18px; font-weight:400;">ระดับราคาสินค้า</span>
                        </ul>
            
                        <ul class="mt-2">
                            <span style="color:#717171;">ระดับราคา 1</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_1" value="{{ $product_all?->price_1 }}">
                        </ul>

                        <ul class="mt-2">
                            <span style="color:#717171;">ระดับราคา 2</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_2" value="{{ $product_all?->price_2 }}">
                        </ul>

                        <ul class="mt-2">
                            <span style="color:#717171;">ระดับราคา 3</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_3" value="{{ $product_all?->price_3 }}">
                        </ul>

                        <ul class="mt-2">
                            <span style="color:#717171;">ระดับราคา 4</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_4" value="{{ $product_all?->price_4 }}">
                        </ul>

                        <ul class="mt-2 mb-4">
                            <span style="color:#717171;">ระดับราคา 5</span>
                            <input class="form-control mt-2" style="color:#8E8E8E;" type="text" name="price_5" value="{{ $product_all?->price_5 }}">
                        </ul>

                    </div>

                    <div class="mr-8">
                        <ul class="mt-1" ">
                            <span style="color:#717171;">หมวดหมู่ยา</span><span style="font-size: 12px; color:red;"></span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" id="category" name="category">
                                
                                @if(!empty($category))
                                    @foreach($category as $row_cate)
                                        <option {{ $product_all?->category == $row_cate?->categories_id ? 'selected' : '' }} value="{{ $row_cate->categories_id }}">{{ $row_cate?->categories_name .' '. '('. $row_cate?->categories_id .')' }}</option>
                                    @endforeach
                                @endif
                               

                            </select>
                        </ul>

                        <ul class="mt-3" ">
                            <span style="color:#717171;">หมวดหมู่ยาย่อย</span><span style="font-size: 12px; color:red;"></span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" id="sub_category" name="sub_category">
                            
                                @if(!empty($subcategory))
                                    @foreach($subcategory as $row_sub)
                                        <option {{ $product_all?->sub_category == $row_sub?->subcategories_id ? 'selected' : '' }} value="{{ $row_sub->subcategories_id }}">{{ $row_sub?->subcategories_name .' '. '('. $row_sub?->subcategories_id .')' }}</option>
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
                            
                                <option {{ $product_all?->status == 'ปิด' ? 'selected' : '' }} value="ปิด">ปิด</option>
                                <option {{ $product_all?->status == 'เปิด' ? 'selected' : '' }} value="เปิด">เปิด</option>

                            </select>
                        </ul>
                        
                        <ul class="mt-2">
                            <span style="color: #373737; font-size:18px; font-weight:400;">แบบอนุญาตขายยา</span>
                        </ul>
            
                        <div style="margin-left:10px;">
                            <ul class="mt-2">
                                <span style="color:#717171;">แบบ ข.ย.1</span>
                                <select class="form-select" style="margin-top:16px; color: rgb(171, 171, 171);" aria-label="Default select example" name="khor_yor_1">
                            
                                    <option {{ $product_all?->khor_yor_1 == '0' ? 'selected' : '' }} value="0">ปิด</option>
                                    <option {{ $product_all?->khor_yor_1 == '1' ? 'selected' : '' }} value="1">เปิด</option>
    
                                </select>
                            </ul>

                            <ul class="mt-2">
                                <span style="color:#717171;">แบบ ข.ย.2</span>
                                <select class="form-select" style="margin-top:16px; color: rgb(171, 171, 171);" aria-label="Default select example" name="khor_yor_2">
                            
                                    <option {{ $product_all?->khor_yor_2 == '0' ? 'selected' : '' }} value="0">ปิด</option>
                                    <option {{ $product_all?->khor_yor_2 == '1' ? 'selected' : '' }} value="1">เปิด</option>
    
                                </select>
                            </ul>

                            <ul class="mt-2">
                                <span style="color:#717171;">แบบ สมพ.2</span>
                                <select class="form-select" style="margin-top:16px; color: rgb(171, 171, 171);" aria-label="Default select example" name="som_phor_2">
                            
                                    <option {{ $product_all?->som_phor_2 == '0' ? 'selected' : '' }} value="0">ปิด</option>
                                    <option {{ $product_all?->som_phor_2 == '1' ? 'selected' : '' }} value="1">เปิด</option>
    
                                </select>
                            </ul>

                            <ul class="mt-2">
                                <span style="color:#717171;">คลินิกยา/สถานพยาบาล</span>
                                <select class="form-select" style="margin-top:16px; color: rgb(171, 171, 171);" aria-label="Default select example" name="clinic">
                            
                                    <option {{ $product_all?->clinic == '0' ? 'selected' : '' }} value="0">ปิด</option>
                                    <option {{ $product_all?->clinic == '1' ? 'selected' : '' }} value="1">เปิด</option>
    
                                </select>
                            </ul>
                        </div>
                        <ul class="mt-2 mx-2">
                            <hr class="mt-4" style="color:#8E8E8E;">
                        </ul>
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
    </div>

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
