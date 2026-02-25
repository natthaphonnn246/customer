@extends ('layouts.webpanel')
@section('content')

            <div class="py-2"></div>
            <h5 class="!text-gray-600 font-semibold ms-6">สินค้าของเรา (Product)</h5>
            <hr class="my-3 !text-gray-400 !border">

            <div class="ms-6 mr-6" style="text-align: left;">
                <a href="/webpanel/report/product/importproduct" class="bg-blue-500 hover:bg-blue-600 !no-underline text-white px-4 py-2 rounded-md" type="submit">จัดการสินค้า</a>

            </div>

            <hr class="my-3" style="color: #8E8E8E; width: 100%;">

            <div class="mx-8">

                    {{-- <form method="get" action="/webpanel/report/product/search"> --}}
                    <form method="get" action="/webpanel/product">
                        @csrf
                        <div class="grid grid-cols-1 gap-4 mt-3">
                            <form method="get"
                                  action="/webpanel/customer"
                                  class="md:col-span-3 max-w-full">
                        
                                <!-- Label -->
                            
                        
                                <!-- Search box -->
                                <div class="relative">
                                    <label for="default-search"
                                        class="block text-base font-medium text-gray-700 mb-2">
                                        ค้นหาสินค้า
                                    </label>
                                    <!-- icon (เผื่อใส่) -->
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <!-- ใส่ svg icon ได้ -->
                                    </div>
                        
                                    <input
                                        type="search"
                                        id="default-search"
                                        name="keyword"
                                        placeholder="รหัสสินค้า | ชื่อสินค้า"
                                        class="block w-full rounded-lg border border-gray-300 bg-white
                                               px-4 py-3 pl-10 text-sm text-gray-900"
                                    />
                        
                                    <button
                                        type="submit"
                                        class="absolute right-2 top-4/5 -translate-y-4/5
                                               !rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white
                                               hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        ค้นหา
                                    </button>
                                </div>
                        
                                <!-- message -->
                                <p class="mt-2 text-sm text-gray-500" id="keyword_search"></p>
                            </form>
                        </div>
                    </form>

            </div>

            <div class="mx-8">

                <span class="ms-2" style="font-size:18px; color:#202020;">สินค้าทั้งหมด :</span>
                <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                <table class="table table-striped">
                    <thead>
                        
                    <tr>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">#</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">รหัสสินค้า</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">สินค้า</td>
                        {{-- <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">หน่วยสินค้า</td> --}}
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">จำนวน</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ราคา 4</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ราคา 5</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ราคา 6</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ต้นทุน</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">สถานะ</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">จัดการ</td>
                    </tr>
                    </thead>
                    <tbody>

                @if(!empty($product_all))

                        @php $start = ($start ?? 0) + 1; @endphp

                        @foreach ($product_all as $row)
                    <tr>
                            <?php
                                
                                $id = $row->id;
                                // $user_name = $row->customer_name;
                                $product_code = $row->product_id;
                                $product_name = $row->product_name;
                                $unit = $row->unit;
                                $quantity = $row->quantity;
                                $price_1 = $row->price_1;
                                $price_2 = $row->price_2;
                                $price_3 = $row->price_3;
                                $price_4 = $row->price_4;
                                $price_5 = $row->price_5;
                                $cost = $row->cost;
                                $status = $row->status;
                                $category_name = $row->category;
                                $subcategory_name = $row->sub_category;
                                $unit = $row->unit;
                                
                                
                            ?>
                        
                        <td scope="row" class="text-gray-400 text-center px-3 py-4 !text-gray-500">{{$start++}}</td>
                        <td scope="row" class="text-gray-400 text-center px-3 py-4 !text-gray-500">{{$product_code}}</td>
                        <td scope="row" class="text-gray-400 text-center px-3 py-4 !text-gray-500">{{$product_name ??= 'ไม่พบข้อมูล'}}</td>
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px;">{{$unit ??= 'ไม่พบข้อมูล'}}</td> --}}
                        <td scope="row" class="text-gray-400 text-center px-3 py-4 !text-gray-500">{{$quantity}}</td>
                        <td scope="row" class="text-gray-400 text-center px-3 py-4 !text-gray-500">{{$price_4}}</td>
                        <td scope="row" class="text-gray-400 text-center px-3 py-4 !text-gray-500">{{$price_5}}</td>
                        <td scope="row" class="text-gray-400 text-center px-3 py-4 !text-gray-500">{{$price_1}}</td>
                        <td scope="row" class="text-gray-400 text-center px-3 py-4 !text-gray-500">{{ $cost ?? '0.00' }}</td>
                        <td class="text-center px-3 py-4">
                            @if($status == 'เปิด')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-base font-medium bg-green-100 text-green-700">
                                    {{$status}}
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-base font-medium bg-red-100 text-red-700">
                                    {{$status}}
                                </span>
                            @endif
                        </td>
                        <td class="text-gray-500 text-left px-2 py-4 w-[100px]">
                            <div class="grid grid-cols-2 gap-2">
                        
                                <!-- ปุ่มดู -->
                                <a href="/webpanel/product/{{$id}}"
                                   class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-2.5 rounded-md flex items-center justify-center !no-underline">
                                    <i class="fa-regular fa-pen-to-square text-sm"></i>
                                </a>
                        
                                <a href="/webpanel/product/{{$id}}/special-deal"
                                    class="bg-blue-400 hover:bg-blue-500 text-white px-3 py-2.5 rounded-md flex items-center justify-center !no-underline">
                                    <i class="fa-solid fa-tags"></i> 
                                </a>
                        
                                <a href="/webpanel/product/{{$id}}/special-price"
                                    class="bg-amber-400/70 hover:bg-amber-400 text-white px-3 py-2.5 rounded-md flex items-center justify-center !no-underline">
                                    <i class="fa-solid fa-percent text-sm"></i>   
                                </a>
                        
                                <!-- ปุ่มลบ -->
                                <button
                                    class="trash-customer bg-red-400 hover:bg-red-500 text-white px-3 py-2 !rounded-md flex items-center justify-center"
                                    type="button"
                                    id="trash{{$id}}">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                        
                            </div>
                        </td>
       
                        </tr>

                        <script>
                                $(document).ready(function() {
        
                                        $('#trash{{$id}}').click(function(e) {

                                            // console.log({{ $id }});
                                            e.preventDefault();
                
                                            let code_del = '{{ $id }}';
        
                                                swal.fire({
                                                    icon: "warning",
                                                    title: "คุณต้องการลบข้อมูลหรือไม่",
                                                    text: '{{$product_code.' '.'('. $product_name.')'}}',
                                                    showCancelButton: true,
                                                    confirmButtonText: "ลบข้อมูล",
                                                    cancelButtonText: "ยกเลิก"
                                                }).then(function(result) {
                                    
                                                if(result.isConfirmed) {
                                                    $.ajax({
                                                    url: '/webpanel/report/product/importproduct/deleted/{{ $id }}',
                                                    type: 'GET',
                                                    success: function(data) {
        
                                                        let check_id = JSON.parse(data);
                                                        console.log(check_id.checkcode);
        
                                                        if(check_id.checkcode == code_del) 
                                                        {
                                                            swal.fire({
                                                                icon: "success",
                                                                title: "ลบข้อมูลสำเร็จ",
                                                                showConfirmButton: true,
                                                            
                                                            }).then (function(result) {
                                                                window.location.reload();
                                                            });
                                                            
                                                        } else {
                                                            Swal.fire({
                                                                icon: "error",
                                                                title: "เกิดข้อผิดพลาด",
                                                                text: 'ไม่พบข้อมูล {{$product_code.' '.'('. $product_name.')'}}',
                                                                showConfirmButton: true,
                                                            });
                                                        }
        
                                                    },
        
                                                });
        
                                            } //iscomfirmed;
                                
                                        });   
        
                                    });
                                
                                });
        
                    </script>
                    @endforeach
                    @endif
                    
                    </tbody>

                </table>


                <div class="py-1"></div>
                {{ $product_all->links('components.paginate-custom') }}

            </div>

            <hr class="mt-3" style="color: #8E8E8E; width: 100%;">

            <div class="py-3">
                <p class="ms-8 text-sm" style="color:#898989;"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
            </div>

@endsection
@push('styles')
    <style>
        #createProduct {
            background-color: #6ccf5b;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #createProduct:hover {
            background-color:  #3ec027;
            color: #ffffff;
        }
        #updateProduct {
            background-color: #fe0000a2;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #updateProduct:hover {
            background-color:  #fb3838e1;
            color: #ffffff;
        }
        #updateStatus {
            background-color: #e1e1e1;
            color: #6f6f6f;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #updateStatus:hover {
            background-color:  #cbcbcb;
            color: #656565;
        }
        #updateType {
            background-color: #4998ff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #updateType:hover {
            background-color:  #1375f5;
            color: #ffffff;
        }
        #importProductUpdate {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importProductUpdate:hover {
            background-color: #0b59f6;
            color: #ffffff;
        }
        #importProductMaster {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importProductMaster:hover {
            background-color: #0b59f6;
            color: #ffffff;
        }
    </style>
@endpush
