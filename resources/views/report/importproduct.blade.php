@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">

            <div class="py-2"></div>
            <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/report/product" class="!no-underline">ย้อนกลับ</a> | นำเข้าไฟล์สินค้า</h5>
            <hr class="my-3 !text-gray-400 !border">

            <div class="mx-8">
                <span style="color: #e84545;">**นำเข้าไฟล์สินค้า <span style="font-weight: 700; color:#007bff;">Master</span> (Product from db:vmdrug) tb: Products</span>
            </div>

            @error('import_csv')

            <div class="alert alert-danger my-2" role="alert">
                {{ $message ?? '' }}
            </div>
        
            @enderror

            @if (isset($check_import))

                <div class="alert alert-success my-2" role="alert">
                    {{$check_import}}
                </div>

            @endif

            {{-- {{$check_provinces}} --}}
            <div class="mx-8">

                <form method="post" id="import" action="/webpanel/report/product/importcsv" enctype="multipart/form-data" style="margin-top: 10px;">
                    @csrf
                    <input type="file"  id="import_csv" name="import_csv" class="form-control text-muted"><br/>
                    <input type="submit" id="importProductUpdate" name="submit_csv" class="btn btn-primary mb-4" value="นำเข้าไฟล์">
                
                </form>
                
                {{-- <hr class="my-3" style="color: #8E8E8E; width: 100%;"> --}}

                @if(Session::get('success_import'))
                <div class="py-4">
                    <ul class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success_import') }}</ul>
                </div>
                @endif
            
            </div>

            <hr class="my-3" style="color: #8E8E8E; width: 100%;">


            <div class="mx-8">
                <span style="color: #e84545;">**นำเข้าไฟล์สินค้า <span style="font-weight: 700; color:#007bff;">Update สินค้าใหม่</span> (Product from db:vmdrug) tb: Products</span>
            </div>

            <div class="mx-8" style="text-align: left;">

                <form method="post" id="import" action="/webpanel/report/product/importcsv-updated" enctype="multipart/form-data" style="margin-top: 10px;">
                    @csrf
                    <input type="file"  id="import_csv" name="import_csv" class="form-control text-muted"><br/>
                    <input type="submit" id="importProductMaster" name="submit_csv" class="btn btn-primary mb-4" value="นำเข้าไฟล์">
                
                </form>

                @if(Session::get('success_import_updated'))
                <div class="py-4">
                    <ul class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success_import_updated') }}</ul>
                </div>
                @endif

            </div>
               
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">

            <div class="ms-6 mr-6" style="text-align: left;">
                <a href="/webpanel/report/product/new-product"  id="createProduct" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">เพิ่มสินค้าใหม่</a>
                <a href="/webpanel/report/product/update-cost"  id="updateProduct" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">รวมทั้งหมด</a>
                <a href="/webpanel/report/product/update-status"  id="updateStatus" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">สถานะสินค้า</a>
                <a href="/webpanel/report/product/update-type"  id="updateType" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">แบบอนุญาตขายยา</a>

            </div>
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">

            <div class="mx-8">

                    {{-- <form method="get" action="/webpanel/report/product/search"> --}}
                    <form method="get" action="/webpanel/report/product/importproduct">
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
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ระดับราคา 4</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ระดับราคา 5</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ระดับราคา 6</td>
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
                        
    
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$start++}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width:5%;">{{$product_code}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:35%;">{{$product_name ??= 'ไม่พบข้อมูล'}}</td>
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px 20px;">{{$unit ??= 'ไม่พบข้อมูล'}}</td> --}}
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$quantity}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$price_4}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$price_5}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$price_1}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{ $cost ?? '0.00' }}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$status}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 5%;">
              
                            <a class="bg-blue-500 hover:bg:blue-600 px-3 py-2.5 !rounded-md text-white" href="/webpanel/report/product/importproduct/{{$id}}" id="edit"><i class="fa-regular fa-eye"></i></a>
                            <button class="trash-customer mt-3 bg-red-500 hover:bg-red-600 !rounded-md text-white px-2 py-2" style="width:50px;" type="submit" id="trash{{$id}}"><i class="fa-regular fa-trash-can"></i></button>
                      
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
            </div>

            @if($total_page > 0)
                @if(request()->filled('keyword')) <!-- ปลอดภัยกว่า -->
                    <div class="ms-6">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                            <li class="page-item">

                            @if ($page == 1)
                                <a class="page-link" href="/webpanel/report/product/importproduct?_token={{ request('_token') }}&keyword={{ request('keyword') }}&page={{ 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @else
                            <a class="page-link" href="/webpanel/report/product/importproduct?_token={{ request('_token') }}&keyword={{ request('keyword') }}&page={{ $page - 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @endif
                            </li>

                            @if($total_page > 14)

                                @for ($i= 1; $i <= 10 ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product/importproduct?_token={{ request('_token') }}&keyword={{ request('keyword') }}&page={{ $i }}">{{ $i }}</a></a></li>
                                @endfor
                                <li class="page-item"><a class="page-link">...</a></li>
                                @for ($i= $total_page-1; $i <= $total_page ; $i++)
                                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/report/product/importproduct?_token={{ request('_token') }}&keyword={{ request('keyword') }}&page={{ $i }}">{{ $i }}</a></a></li>
                                @endfor

                            @else
                                @for ($i= 1; $i <= $total_page ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product/importproduct?_token={{ request('_token') }}&keyword={{ request('keyword') }}&page={{ $i }}">{{ $i }}</a></li>
                                @endfor
                            
                            @endif

                            <li class="page-item">
                            
                            @if ($page == $total_page)
                                <a class="page-link" href="/webpanel/report/product/importproduct?_token={{ request('_token') }}&keyword={{ request('keyword') }}&page={{ $page }}" aria-label="Next">
                                <span aria-hidden="true">next</span>
                                </a>
                            @else
                            <a class="page-link" href="/webpanel/report/product/importproduct?_token={{ request('_token') }}&keyword={{ request('keyword') }}&page={{ $page + 1 }}" aria-label="Next">
                                <span aria-hidden="true">next</span>
                                </a>
                            @endif
                            </li>
                            </ul>
                        </nav>
                    </div>
                    <hr class="mt-3" style="color: #8E8E8E; width: 100%;">
                    <div class="py-3">
                        <p class="ms-8 text-sm" style="color:#898989;"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
                    </div>
                
                <!--- search not keyword -->
                @else
                    <div class="ms-6">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                            <li class="page-item">

                            @if ($page == 1)
                                <a class="page-link" href="/webpanel/report/product/importproduct?page={{ 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @else
                                <a class="page-link" href="/webpanel/report/product/importproduct?page={{ $page - 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @endif
                            </li>

                            @if($total_page > 14)

                                @for ($i= 1; $i <= 10 ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product/importproduct?page={{ $i }}">{{ $i }}</a></li>
                                @endfor
                                <li class="page-item"><a class="page-link">...</a></li>
                                @for ($i= $total_page-1; $i <= $total_page ; $i++)
                                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/report/product/importproduct?page={{ $i }}">{{ $i }}</a></li>
                                @endfor

                            @else
                                @for ($i= 1; $i <= $total_page ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product/importproduct?page={{ $i }}">{{ $i }}</a></li>
                                @endfor
                            
                            @endif

                            <li class="page-item">
                            
                            @if ($page == $total_page)
                                <a class="page-link" href="/webpanel/report/product/importproduct?page={{ $page }}" aria-label="Next">
                                <span aria-hidden="true">next</span>
                                </a>
                            @else
                                <a class="page-link" href="/webpanel/report/product/importproduct?page={{ $page + 1 }}" aria-label="Next">
                                <span aria-hidden="true">next</span>
                                </a>
                            @endif
                            </li>
                            </ul>
                        </nav>
                    </div>
                    <hr class="mt-3" style="color: #8E8E8E; width: 100%;">
                    <div class="py-3">
                        <p class="ms-8 text-sm" style="color:#898989;"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
                    </div>
                @endif
        @else
            <div class="text-center py-8">
                <span style="background-color: #ffc637; padding:15px;">
                    ไม่พบข้อมูล
                </span>
            </div>
        @endif


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
