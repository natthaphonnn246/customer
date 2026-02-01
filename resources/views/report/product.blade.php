@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6">รายการสินค้าขายดี</h5>
        <hr class="my-3 !text-gray-400 !border">

        <div class="flex flex-col sm:flex-row gap-2 sm:items-center mx-8">
            {{-- <a href="/webpanel/customer/customer-create"  id="admin" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">เพิ่มลูกค้าใหม่</a> --}}
            <a href="/webpanel/report/product/importproduct"  id="importProduct" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">สินค้าทั้งหมด</a>
            <a href="/webpanel/report/product/importcategory"  id="importCate" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">หมวดหมู่หลัก</a>
            <a href="/webpanel/report/product/importsubcategory"  id="importsubCate" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">หมวดหมู่ย่อย</a>
            {{-- @php
                if($_GET['min_seller'])
            @endphp --}}
            <a href="/webpanel/report/product/exportcsv/check?from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}&category={{ request('category') ?? ''}}&region={{ request('region') ?? ''}}"  id="exportcsv" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export CSV</a>
            <a href="/webpanel/report/product/exportexcel/check?from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}&category={{ request('category') ?? ''}}&region={{ request('region') ?? ''}}"  id="exportexcel" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export Excel</a>
    
        </div>

        <hr class="my-4" style="color: #8E8E8E; width: 100%;">

        <div class="row mx-4">
            
            <div class="textbox" style="width: 240px; height: 90px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <span style="font-size:14px;">จำนวนสินค้า</span><br/>
                    {{-- @if (isset($count_purchase_range) || isset($count_customer_range)) --}}
                    <span>{{$total_quantity ?? 0}}</span>
                </span>
            </div>
              

            <div class="textbox" style="width: 240px; height: 90px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="" style="text-decoration: none; color:white; font-size:14px;">มูลค่า</a><br/>
                    <span>{{number_format($product_value,2) ?? 0}}</span>
                </span>
            </div>

     {{--        <div class="textbox" style="width: 240px; height: 90px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="" style="text-decoration: none; color:white; font-size:14px;">ยอดรวม</a><br/>
                    <span>{{0}}</span>
                </span>
            </div> --}}


        </div>
        <hr class="my-3" style="color: #8E8E8E; width: 100%;">
        <!--- search --->
  
        <div class="mx-4">

            <div class="mx-2">
                <form method="get" action="/webpanel/report/product"
                      class="">
            
                    @csrf
            
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                         {{-- หมวดหมู่ยา --}}
                        <div>
                            <label class="block mb-2 text-base font-medium text-gray-600">
                                หมวดหมู่ยา
                            </label>
                            <select name="category"
                                    class="form-select w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-500
                                        focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- เลือกหมวดหมู่ยา --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->categories_id }}"
                                        {{ (request('category') ?? '') == $category->categories_id ? 'selected' : '' }}>
                                        {{ $category->categories_name }} ({{ $category->categories_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                
                        {{-- ภูมิศาสตร์ --}}
                        <div>
                            <label class="block mb-2 text-base font-medium text-gray-600">
                                ภูมิศาสตร์
                            </label>
                            <select name="region"
                                    class="form-select w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-500
                                        focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- เลือกภูมิศาสตร์ --</option>
                                @foreach (['ภาคเหนือ','ภาคกลาง','ภาคตะวันออก','ภาคตะวันออกเฉียงเหนือ','ภาคตะวันตก','ภาคใต้'] as $region)
                                    <option value="{{ $region }}"
                                        {{ (request('region') ?? '') == $region ? 'selected' : '' }}>
                                        {{ $region }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                        {{-- วันที่เริ่ม --}}
                        <div>
                            <label class="block mb-2 text-base font-medium text-gray-600">
                                วันที่เริ่ม
                            </label>
                            <input type="text"
                                id="from"
                                name="from"
                                value="{{ request('from') == '' ? date('Y-m-d') : request('from') }}"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-500
                                        focus:border-blue-500 focus:ring-blue-500">
                        </div>
                
                        {{-- ถึงวันที่ --}}
                        <div>
                            <label class="block mb-2 text-base font-medium text-gray-600">
                                ถึงวันที่
                            </label>
                            <input type="text"
                                id="to"
                                name="to"
                                value="{{ request('to') == '' ? date('Y-m-d') : request('to') }}"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-500
                                        focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                    {{-- ปุ่มค้นหา --}}
                    <div class="flex justify-center md:justify-end">
                        <button type="submit"
                                class="w-full md:w-auto !rounded-md mt-3 bg-blue-600 px-6 py-2 text-sm font-medium text-white
                                    hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            ค้นหา
                        </button>
                    </div>
            
                </form>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 sm:items-center mt-4 mx-2">
                {{-- <a href="/webpanel/customer/customer-create"  id="admin" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">เพิ่มลูกค้าใหม่</a> --}}
                <a href="/webpanel/report/product/sales/category"  id="byCategory" class="btn" type="submit"  name="" style="width: 200px; padding: 8px;">ขายตามหมวดหมู่ยา</a>
                <a href="/webpanel/report/product/sales/region"  id="byRegion" class="btn" type="submit"  name="" style="width: 200px; padding: 8px;">ขายตามภูมิศาสตร์</a>
        
            </div>
        </div>

        </div>

            <div class="mx-4 mt-10">

                <span class="ms-2" style="font-size:18px; color:#202020;">สินค้าขายดี :</span>
                <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                <table class="table table-striped">
                    <thead>
                        
                    <tr>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">#</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">รหัสสินค้า</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">สินค้า</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">หมวดหมู่</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">หมวดหมู่ย่อย</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">หน่วยสินค้า</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">จำนวน</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ยอดรวม</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">เฉลี่ยต่อหน่วย</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">ต้นทุน</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">กำไร</td>
                        <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">จัดการ</td>
                    </tr>
                    </thead>
                    <tbody>

                @if(!empty($report_product))

                        @php $start = ($start ?? 0) + 1; @endphp

                        @foreach ($report_product as $row)
                    <tr>
                            <?php
                                
                                $id = $row->id;
                                // $user_name = $row->customer_name;
                                $product_code = $row->product_id;
                                $product_name = $row->product_name;
                                $category = $row->category;
                                $sub_category = $row->sub_category;
                                $quantity = $row->quantity_by;
                                $total_sales = $row->total_sales;
                                $avg_cost = $row->average_cost;
                                $purchase_order = $row->purchase_order;
                                $category_name = $row->categories_name;
                                $subcategory_name = $row->subcategories_name;
                                $unit = $row->unit;
                                
                                $region = $row->geography;

                                $price_unit = (int)$total_sales/$quantity;

                              /*   if($price_unit < 1) {
                                    echo $product_code;
                                } */

                                if($price_unit > 0) {
                                    $margin = (($price_unit - $avg_cost)/$price_unit) * 100;

                                } else {
                                    $margin = 0;
                                }
                                
                            ?>
                        
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$start++}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$product_code}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">{{$product_name ??= 'ไม่พบข้อมูล'}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">{{ $category_name && $category ? $category_name . ' (' . $category . ')' : 'ไม่พบข้อมูล' }}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">{{ $subcategory_name && $sub_category ? $subcategory_name . ' (' . $sub_category . ')' : 'ไม่พบข้อมูล' }}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$unit ??= 'ไม่พบข้อมูล'}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$quantity ??= 'ไม่พบข้อมูล'}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{$total_sales ??= 'ไม่พบข้อมูล'}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{number_format($price_unit,2)}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{number_format($avg_cost,2)}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px;">{{number_format($margin,2)}}</td>
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 10%;">
                            <a href="/webpanel/product/product-detail/{{$product_code}}?from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}&category={{ request('category') ?? ''  }}&region={{ request('region') ?? '' }}" id="edit"><i class="fa-regular fa-eye"></i></a>

                        </td>
                        </tr>

    
                    @endforeach
                    @endif
                    
                    </tbody>

                </table>
            </div>
    
        @if($total_page > 0)
                @if(request()->filled('from') && request()->filled('to')) <!-- ปลอดภัยกว่า -->
                    <div class="ms-6">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                            <li class="page-item">

                            @if ($page == 1)
                                <a class="page-link" href="/webpanel/report/product?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to')}}&category={{ request('category') }}&region={{ request('region') }}&page={{ 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @else
                            <a class="page-link" href="/webpanel/report/product?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to')}}&category={{ request('category') }}&region={{ request('region') }}&page={{ $page - 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @endif
                            </li>

                            @if($total_page > 14)

                                @for ($i= 1; $i <= 10 ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to')}}&category={{ request('category') }}&region={{ request('region') }}&page={{ $i }}">{{ $i }}</a></a></li>
                                @endfor
                                <li class="page-item"><a class="page-link">...</a></li>
                                @for ($i= $total_page-1; $i <= $total_page ; $i++)
                                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/report/product?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to')}}&category={{ request('category') }}&region={{ request('region') }}&page={{ $i }}">{{ $i }}</a></a></li>
                                @endfor

                            @else
                                @for ($i= 1; $i <= $total_page ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to')}}&category={{ request('category') }}&region={{ request('region') }}&page={{ $i }}">{{ $i }}</a></li>
                                @endfor
                            
                            @endif

                            <li class="page-item">
                            
                            @if ($page == $total_page)
                                <a class="page-link" href="/webpanel/report/product?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to')}}&category={{ request('category') }}&region={{ request('region') }}&page={{ $page }}" aria-label="Next">
                                <span aria-hidden="true">next</span>
                                </a>
                            @else
                            <a class="page-link" href="/webpanel/report/product?_token={{ request('_token') }}&from={{ request('from') }}&to={{ request('to')}}&category={{ request('category') }}&region={{ request('region') }}&page={{ $page + 1 }}" aria-label="Next">
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
                                <a class="page-link" href="/webpanel/report/product?page={{ 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @else
                                <a class="page-link" href="/webpanel/report/product?page={{ $page - 1 }}" aria-label="Previous">
                                <span aria-hidden="true">Previous</span>
                                </a>
                            @endif
                            </li>

                            @if($total_page > 14)

                                @for ($i= 1; $i <= 10 ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product?page={{ $i }}">{{ $i }}</a></li>
                                @endfor
                                <li class="page-item"><a class="page-link">...</a></li>
                                @for ($i= $total_page-1; $i <= $total_page ; $i++)
                                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/report/product?page={{ $i }}">{{ $i }}</a></li>
                                @endfor

                            @else
                                @for ($i= 1; $i <= $total_page ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product?page={{ $i }}">{{ $i }}</a></li>
                                @endfor
                            
                            @endif

                            <li class="page-item">
                            
                            @if ($page == $total_page)
                                <a class="page-link" href="/webpanel/report/product?page={{ $page }}" aria-label="Next">
                                <span aria-hidden="true">next</span>
                                </a>
                            @else
                                <a class="page-link" href="/webpanel/report/product?page={{ $page + 1 }}" aria-label="Next">
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
            <div class="text-center py-8 mx-8">
                <span class="block bg-yellow-500 w-full py-2">
                    ไม่พบข้อมูล
                </span>
            </div>
        @endif

    </div>

    <script>
        $( function() {
            var dateFormat = 'dd/mm/yy',
                from = $( "#from" )
                .datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: 'yy-mm-dd',
                })
                .on( "change", function() {
                    to.datepicker( "option", "minDate", getDate( this ) );
                }),
                to = $( "#to" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                dateFormat: 'yy-mm-dd',
                numberOfMonths: 1 //จำนวนปฎิืิทิน;
                })
                .on( "change", function() {
                from.datepicker( "option", "maxDate", getDate( this ) );
                });
        
            function getDate( element ) {
                var date;
                try {
                date = $.datepicker.parseDate( dateFormat, element.value );
                } catch( error ) {
                date = null;
                }
        
                return date;
            }
        });
    </script>
@endsection
@push('styles')
<style>
    #importProduct {
        background-color: #01a930;
        color: #ffffff;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
    }
    #importProduct:hover {
        background-color: #008b27;
        color: #ffffff;
    }
    #byCategory {
        background-color: #ff68c5;
        color: #ffffff;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
    }
    #byCategory:hover {
        background-color: #fa46c7;
        color: #ffffff;
    }
    #byRegion {
        background-color: #727aff;
        color: #ffffff;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
    }
    #byRegion:hover {
        background-color: #5b63fa;
        color: #ffffff;
    }
    #importCate {
        background-color: #e0923e;
        color: #ffffff;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
    }
    #importCate:hover {
        background-color: #dd790e;
        color: #ffffff;
    }
    #importsubCate {
        background-color: #1c79d1;
        color: #ffffff;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
    }
    #importsubCate:hover {
        background-color: #075fb2;
        color: #ffffff;
    }
    #edit {
        background-color: #ffa602;
        color: #FFFFFF;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
    }
    .trash-customer {
        background-color: #e12e49;
        color: #FFFFFF;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
    }
    /* toggle off */
    .switch {
        position: relative;
        display: inline-block;
        width: 55px;
        height: 28px;
        
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
        
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 1.5px;
        right: 3px;
        bottom: 3px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        
    }

    input:checked + .slider {
        background-color: #03ae3f;

    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }
    #exportcsv {
        background-color: #dddddd;
        color: #656565;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
    }
    #exportcsv:hover {
        background-color: #cccccc;
        color: #3c3c3c;
    }
    #exportexcel {
        background-color: #dddddd;
        color: #656565;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
    }
    #exportexcel:hover {
        background-color: #cccccc;
        color: #3c3c3c;
    }
</style>
@endpush
