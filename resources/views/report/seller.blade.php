@extends ('layouts.webpanel')
@section('content')
    
    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6">รายงานขาย</h5>
        <hr class="my-3 !text-gray-400 !border">

        <div class="mx-10">
            {{-- <a href="/webpanel/customer/customer-create"  id="admin" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">เพิ่มลูกค้าใหม่</a> --}}
            <a href="/webpanel/report/seller/importseller" class="bg-blue-500 hover:bg-blue-600 text-white !no-underline px-4 py-2 !rounded-md" type="submit"  name="">นำเข้าไฟล์</a>
            {{-- @php
                if($_GET['min_seller'])
            @endphp --}}
            <a href="/webpanel/report/seller/exportcsv/check?min_seller={{ request('min_seller') ?? ''}}&max_seller={{ request('max_seller') ?? ''}}&from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}"  class="bg-gray-400 hover:bg-gray-500 text-white !no-underline px-4 py-2 !rounded-md" type="submit">Export CSV</a>
            <a href="/webpanel/report/seller/exportexcel/check?min_seller={{ request('min_seller') ?? ''}}&max_seller={{ request('max_seller') ?? ''}}&from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}"  class="bg-gray-400 hover:bg-gray-500 text-white !no-underline px-4 py-2 !rounded-md" type="submit">Export Excel</a>
    
        </div>

        <hr class="my-4" style="color: #8E8E8E; width: 100%;">

        <div class="row mx-4">
            
            <div class="textbox" style="width: 240px; height: 90px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <span style="font-size:14px;">ใบสั่งซื้อ</span><br/>
                    {{-- @if (isset($count_purchase_range) || isset($count_customer_range)) --}}
                    @if (!empty($count_purchase_range) || !empty($count_customer_range))
                    <span>{{$count_purchase_range ?? $count_customer_range}}</span>
                    @else
                    <span>{{$count_purchase_all ?? 0}}</span>
                    @endif
                </span>
            </div>
              
            @php
                $total_sellings = 0;
                foreach ($total_report_selling as $row_selling) {
                    $total_sellings += $row_selling->total_sales;
                }

                // $total_sellings  = $total_report_selling?->total_sales;
            @endphp

            <div class="textbox" style="width: 240px; height: 90px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="" style="text-decoration: none; color:white; font-size:14px;">ร้านค้า</a><br/>
                    @if (isset($count_customer_range))
                    <span>{{$count_customer_range}}</span>
                    @else
                    <span>{{$count_customer_all}}</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 90px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="" style="text-decoration: none; color:white; font-size:14px;">ยอดรวม</a><br/>
                    <span>{{number_format($total_sellings,2) ?? 0}}</span>
                </span>
            </div>

        </div>
        <hr class="my-3" style="color: #8E8E8E; width: 100%;">
        <!--- search --->

        <div class="mx-4">
            <form method="get" action="/webpanel/report/seller/search/keyword"
                  class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end bg-white p-4 rounded-lg">
        
                {{-- รหัสร้านค้า --}}
                <div>
                    <label class="block mb-1 text-base font-medium text-gray-600">
                        ระบุรหัสร้านค้า
                    </label>
                    <input
                        type="search"
                        name="keyword"
                        value="{{ str_replace('+', ' ', request('keyword')) }}"
                        placeholder="CODE | ชื่อร้านค้า"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-500
                               focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>
        
                {{-- วันที่เริ่ม --}}
                <div>
                    <label class="block mb-1 text-base font-medium text-gray-600">
                        วันที่เริ่ม
                    </label>
                    <input
                        type="text"
                        id="from"
                        name="from"
                        value="{{ request('from') == '' ? date('Y-m-d') : request('from') }}"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-500
                               focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>
        
                {{-- ถึงวันที่ --}}
                <div>
                    <label class="block mb-1 text-base font-medium text-gray-600">
                        ถึงวันที่
                    </label>
                    <input
                        type="text"
                        id="to"
                        name="to"
                        value="{{ request('to') == '' ? date('Y-m-d') : request('to') }}"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-500
                               focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>
        
                {{-- ปุ่มค้นหา --}}
                <div class="flex justify-start md:justify-start">
                    <button
                        type="submit"
                        class="mt-2 w-full md:w-auto !rounded-md bg-blue-600 px-6 py-2 text-sm font-medium text-white
                               hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        ค้นหา
                    </button>
                </div>
        
                @csrf
            </form>
        </div>
       
        <hr class="my-3" style="color: #8E8E8E; width: 100%;">
        <script>
            $(document).ready(function() {
                $('#default-search').keyup(function(e) {
                    e.preventDefault();  // Prevent form from submitting

                    $.ajax({
                        url: '/webpanel/customer/search/code',
                        method: 'GET',
                        data: {
                            keyword: $(this).val(),

                        },
                        catch:false,
                        success: function(data) {
                            
                            $('#keyword_search').html(data);

                        }
                    });
                   /*  let keyword = $(this).val();
                    console.log(keyword ); */
                });
            });
        </script>

        <div class="mx-4 w-[95%]">
            <form method="get" action="/webpanel/report/seller"
                class="grid grid-cols-1 md:grid-cols-5 gap-4 bg-white p-4 rounded-lg">

                @csrf

                {{-- เขตการขาย --}}
                <div>
                    <label class="block mb-1 text-base font-medium text-gray-600">เขตการขาย</label>
                    <select name="salearea_seller"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-500
                                focus:border-blue-500 focus:ring-blue-500">
                        <option value="">ไม่ระบุ</option>
                        @foreach ($sale_area as $salearea_seller)
                            <option value="{{ $salearea_seller->sale_area }}"
                                {{ (request('salearea_seller') ?? '') == $salearea_seller->sale_area ? 'selected' : '' }}>
                                {{ $salearea_seller->sale_area }} ({{ $salearea_seller->sale_name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- แอดมิน --}}
                <div>
                    <label class="block mb-1 text-base font-medium text-gray-600">แอดมิน</label>
                    <select name="adminarea_seller"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-500
                                focus:border-blue-500 focus:ring-blue-500">
                        <option value="">ไม่ระบุ</option>
                        @foreach ($admin_area as $rowarea_seller)
                            <option value="{{ $rowarea_seller->admin_area }}"
                                {{ (request('adminarea_seller') ?? '') == $rowarea_seller->admin_area ? 'selected' : '' }}>
                                {{ $rowarea_seller->admin_area }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ภูมิศาสตร์ --}}
                <div>
                    <label class="block mb-1 text-base font-medium text-gray-600">ภูมิศาสตร์</label>
                    <select name="region"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-500
                                focus:border-blue-500 focus:ring-blue-500">
                        <option value="">ไม่ระบุ</option>
                        @foreach (['ภาคเหนือ','ภาคกลาง','ภาคตะวันออก','ภาคตะวันออกเฉียงเหนือ','ภาคตะวันตก','ภาคใต้'] as $region)
                            <option value="{{ $region }}"
                                {{ (request('region') ?? '') == $region ? 'selected' : '' }}>
                                {{ $region }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- การจัดส่ง --}}
                <div>
                    <label class="block mb-1 text-base font-medium text-gray-600">การจัดส่ง</label>
                    <select name="delivery"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-500
                                focus:border-blue-500 focus:ring-blue-500">
                        <option value="">ไม่ระบุ</option>
                        <option value="standard" {{ request('delivery') == 'standard' ? 'selected' : '' }}>ปกติ</option>
                        <option value="owner" {{ request('delivery') == 'owner' ? 'selected' : '' }}>เอกชน</option>
                    </select>
                </div>

                {{-- เว้นช่องให้ layout สวย --}}
                <div class="hidden md:block"></div>

                {{-- ต่ำสุด --}}
                <div>
                    <label class="block mb-1 text-base font-medium text-gray-600">ต่ำสุด</label>
                    <input type="text" name="min_seller"
                        value="{{ request('min_seller') }}"
                        placeholder="การขายต่ำสุด"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-500
                                focus:border-blue-500 focus:ring-blue-500">
                </div>

                {{-- สูงสุด --}}
                <div>
                    <label class="block mb-1 text-base font-medium text-gray-600">สูงสุด</label>
                    <input type="text" name="max_seller"
                        value="{{ request('max_seller') }}"
                        placeholder="การขายสูงสุด"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-500
                                focus:border-blue-500 focus:ring-blue-500">
                </div>

                {{-- วันที่เริ่ม --}}
                <div>
                    <label class="block mb-1 text-base font-medium text-gray-600">วันที่เริ่ม</label>
                    <input type="text" id="fromcheck" name="from"
                        value="{{ request('from') == '' ? date('Y-m-d') : request('from') }}"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-500
                                focus:border-blue-500 focus:ring-blue-500">
                </div>

                {{-- ถึงวันที่ --}}
                <div>
                    <label class="block mb-1 text-base font-medium text-gray-600">ถึงวันที่</label>
                    <input type="text" id="tocheck" name="to"
                        value="{{ request('to') == '' ? date('Y-m-d') : request('to') }}"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-500
                                focus:border-blue-500 focus:ring-blue-500">
                </div>

                {{-- ปุ่มค้นหา --}}
                <div class="flex items-end">
                    <button type="submit"
                            class="w-full !rounded-md bg-blue-600 px-6 py-2 text-sm font-medium text-white
                                hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        ค้นหา
                    </button>
                </div>

            </form>
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

    <script>
            $( function() {
                var dateFormat = 'dd/mm/yy',
                    from = $( "#fromcheck" )
                    .datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        numberOfMonths: 1,
                        dateFormat: 'yy-mm-dd',
                    })
                    .on( "change", function() {
                        to.datepicker( "option", "minDate", getDate( this ) );
                    }),
                    to = $( "#tocheck" ).datepicker({
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

        <hr class="mt-8" style="color: #8E8E8E; width: 100%;">
        <div class="ms-6 mr-6 mb-2 mt-4">

            <span class="ms-2" style="font-size:18px; color:#202020;">แสดงใบสั่งซื้อ :</span>
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">
            <table class="table table-striped">
                <thead>
                    
                <tr>
                    <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">#</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">CODE</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">Sale</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">Admin</td>
                    <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">ชื่อร้านค้า</td>
                    <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">ใบสั่งซื้อ</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">รวมเป็นเงิน</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 500;">จัดการ</td>
                </tr>
                </thead>
                <tbody>
                    @if($total_page > 0)
                    
                    @php $start = ($start ?? 0) + 1; @endphp

                    @foreach ($report_seller as $row)
                <tr>
                        <?php
                            
                            $id = $row->id;
                            // $user_name = $row->customer_name;
                            $user_code = $row->customer_id;
                            $total_sales = $row->total_sales;
                            $purchase_order = $row->purchase_order;
                        ?>
                    
                    @foreach ($customers_customer_name as $row_name)

                    <?php
                        if($user_code == $row_name->customer_id) {
                            $user_name = $row_name->customer_name; 

                        }
                       
                    ?>
                         {{--  --}}
                           
                    @endforeach
                    <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">{{$start++}}</td>
                    <td scope="row" style="color:#9C9C9C; text-align: center; width:10%; padding: 20px 8px 20px;">{{$user_code}}</td>

                    @foreach ($customers_data as $row_customers)

                    <?php
                        if($row_customers->customer_id == $user_code) {
                            $sale = $row_customers->sale_area;
                            $admin_area_seller = $row_customers->admin_area;
                        }
                    ?>
                
                    @endforeach
            
                    <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 10%;">{{$sale ??= 'ไม่พบข้อมูล'}}</td>
                    <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 15%;">{{$admin_area_seller ??= 'ไม่พบข้อมูล'}}</td>
                    <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:35%;">{{$user_name ??= 'ไม่พบข้อมูล'}}</td>

                    <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px; width:10%;"><span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(243, 103, 110);">{{$purchase_order}}</span></td>

                    {{-- {{gettype((int)$total_sales);}} --}}
                        @if ($total_sales <= 5000)
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 20%"> <span style="border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(237, 59, 59);">{{number_format($total_sales,2)}}</span></td>
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px;"><i class="fa-solid fa-circle" style="color: rgb(255, 70, 70);"></i> รอดำเนินการ</td> --}}
                        @elseif ($total_sales > 5000 AND $total_sales <= 10000)
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 20%"><span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(251, 169, 46);">{{number_format($total_sales,2)}}</span></td>
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px;"><i class="fa-solid fa-circle" style="color: rgb(251, 183, 23);"></i> ต้องดำเนินการ</td> --}}
                        @elseif ($total_sales > 10000 AND $total_sales <= 15000)
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: left;"><i class="fa-solid fa-circle" style="color: rgb(4, 181, 30);"></i> ดำเนินการแล้ว</td> --}}
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 20%"> <span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(58, 174, 19);">{{number_format($total_sales,2)}}</span></td>
                        @else
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 20%"> <span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(17, 196, 255);">{{number_format($total_sales,2)}}</span></td>
                        @endif

                        {{-- <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;">{{$created_at}}</td> --}}

                        <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px 20px; width: 10%;">
                            <a href="/webpanel/report/seller/{{$user_code}}?from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}&po={{ $purchase_order ?? ''  }}" id="edit"><i class="fa-regular fa-eye"></i></a>
                            {{-- <a href="/webpanel/customer/delete/{{$user_code}}" id="trash"><i class="fa-regular fa-trash-can"></i></a> --}}
                            {{-- <button class="trash-customer" type="submit" id="trash{{$id}}"><i class="fa-regular fa-trash-can"></i></button> --}}

                        </td>
                </tr>

                <!-- delete customer table -->

                    <script>
                            $(document).ready(function() {

                                    $('#trash{{$id}}').click(function(e) {
                                        e.preventDefault();
                                        // console.log('delete{{$user_code}}');
                                        let code_del = '{{$id}}';
                                        // console.log('{{$user_code}}');

                                            swal.fire({
                                                icon: "warning",
                                                title: "คุณต้องการลบข้อมูลหรือไม่",
                                                // text: '<?= $user_code .' '.'('. $user_name.')' ; ?>',
                                                text: '{{$user_code.' '.'('. $user_name.')'}}',
                                                showCancelButton: true,
                                                confirmButtonText: "ลบข้อมูล",
                                                cancelButtonText: "ยกเลิก"
                                            }).then(function(result) {
                                
                                            if(result.isConfirmed) {
                                                $.ajax({
                                                url: '/webpanel/customer/delete/{{$id}}',
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
                                                            text: 'ไม่พบข้อมูล {{$user_code.' '.'('. $user_name.')'}}',
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

                    <script text="type/javascript">
                            $(document).ready(function() {
                                // $('#status_on').prop('checked', false);
                                $('#status_on{{$id}}').change(function() {
                    
                                    if($(this).is(':checked')) 
                                    {
                                        $('#status_on{{$id}}').prop('checked', true);
                                        console.log('ON');
                                        // var admin_code = $(this).val();
                                        let user_code = '{{$id}}';
                                        console.log(user_code);
                    
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.ajax({
                                            url: '/webpanel/customer/status-active',
                                            type: 'POST',
                                            data: {
                                                id_act: 2,
                                                status: 'active',
                                                code_id: user_code,
                                                _token: "{{ csrf_token() }}",
                                            },
                                            success: function(response) {
                    
                                                if(response == 'success') {
                                                    console.log('success');
    
                                                }
                        
                                            },
                                            error: function(xhr, status, error) {
                                                console.log(xhr);
                                                console.log(status);
                                                console.log(error);
                                            }
                                        });
                    
                                    } else {

                                        const user_code = '{{$id}}';
                                        console.log(user_code);

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.ajax({
                                            url: '/webpanel/customer/status-inactive',
                                            type: 'POST',
                                            data: {
                                                id_inact: 1,
                                                status_in: 'inactive',
                                                code_id: user_code,
                                                _token: "{{ csrf_token() }}",
                                            },
                                            success: function(response) {
                    
                                                if(response == 'inactive') {
                                                    console.log('inactive');

                                                }
                        
                                            },
                                            error: function(xhr, status, error) {
                                                console.log(xhr);
                                                console.log(status);
                                                console.log(error);
                                            }
                                        });
                                    }
                                });
                            });
                    </script>

                {{--   <script>
                        $(document).ready(function() {
                            $('#trash').click(function() {
                                console.log('trash');
                            });
                        });
                    </script> --}}

                @endforeach
                @endif
                </tbody>
            </table>
        </div>

        @if($total_page > 0)
            {{-- @if(isset($_GET['from']) == '' || isset($_GET['to']) == '' || isset($_GET['min_seller']) == '' || isset($_GET['max_seller']) == '') --}}
            {{-- @if(!empty($_GET['keyword']))  --}}
           @if(request()->filled('from') && request()->filled('to') && !request()->filled('keyword')) <!-- ปลอดภัยกว่า -->
            <div class="ms-6">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                    <li class="page-item">

                    @if ($page == 1)
                        <a class="page-link" href="/webpanel/report/seller?_token={{ request('_token') }}&salearea_seller={{ request('salearea_seller') }}&adminarea_seller={{ request('adminarea_seller') }}&region={{ request('region') }}&delivery={{ request('delivery') }}&min_seller={{ request('min_seller') }}&max_seller={{ request('max_seller') }}&from={{ request('from') }}&to={{ request('to')}}&page={{ 1 }}" aria-label="Previous">
                        <span aria-hidden="true">Previous</span>
                        </a>
                    @else
                        <a class="page-link" href="/webpanel/report/seller?_token={{ request('_token') }}&salearea_seller={{ request('salearea_seller') }}&adminarea_seller={{ request('adminarea_seller') }}&region={{ request('region') }}&delivery={{ request('delivery') }}&min_seller={{ request('min_seller') }}&max_seller={{ request('max_seller') }}&from={{ request('from') }}&to={{ request('to')}}&page={{ $page - 1 }}" aria-label="Previous">
                        <span aria-hidden="true">Previous</span>
                        </a>
                    @endif
                    </li>

                    @if($total_page > 14)

                        @for ($i= 1; $i <= 10 ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/seller?_token={{ request('_token') }}&salearea_seller={{ request('salearea_seller') }}&adminarea_seller={{ request('adminarea_seller') }}&region={{ request('region') }}&delivery={{ request('delivery') }}&min_seller={{ request('min_seller') }}&max_seller={{ request('max_seller') }}&from={{ request('from') }}&to={{ request('to')}}&page={{ $i }}">{{ $i }}</a></li>
                        @endfor
                        <li class="page-item"><a class="page-link">...</a></li>
                        @for ($i= $total_page-1; $i <= $total_page ; $i++)
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/report/seller?_token={{ request('_token') }}&salearea_seller={{ request('salearea_seller') }}&adminarea_seller={{ request('adminarea_seller') }}&region={{ request('region') }}&delivery={{ request('delivery') }}&min_seller={{ request('min_seller') }}&max_seller={{ request('max_seller') }}&from={{ request('from') }}&to={{ request('to')}}&page={{ $i }}">{{ $i }}</a></li>
                        @endfor

                    @else
                        @for ($i= 1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/seller?_token={{ request('_token') }}&salearea_seller={{ request('salearea_seller') }}&adminarea_seller={{ request('adminarea_seller') }}&region={{ request('region') }}&delivery={{ request('delivery') }}&min_seller={{ request('min_seller') }}&max_seller={{ request('max_seller') }}&from={{ request('from') }}&to={{ request('to')}}&page={{ $i }}">{{ $i }}</a></li>
                        @endfor
                    
                    @endif

                    <li class="page-item">
                    
                    @if ($page == $total_page)
                        <a class="page-link" href="/webpanel/report/seller?_token={{ request('_token') }}&salearea_seller={{ request('salearea_seller') }}&adminarea_seller={{ request('adminarea_seller') }}&region={{ request('region') }}&delivery={{ request('delivery') }}&min_seller={{ request('min_seller') }}&max_seller={{ request('max_seller') }}&from={{ request('from') }}&to={{ request('to')}}&page={{ $page }}" aria-label="Next">
                        <span aria-hidden="true">next</span>
                        </a>
                    @else
                        <a class="page-link" href="/webpanel/report/seller?_token={{ request('_token') }}&salearea_seller={{ request('salearea_seller') }}&adminarea_seller={{ request('adminarea_seller') }}&region={{ request('region') }}&delivery={{ request('delivery') }}&min_seller={{ request('min_seller') }}&max_seller={{ request('max_seller') }}&from={{ request('from') }}&to={{ request('to')}}&page={{ $page + 1 }}" aria-label="Next">
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
            @elseif (request()->filled('keyword'))
    
                <div class="ms-6">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                        <li class="page-item">

                        @if ($page == 1)
                            <a class="page-link" href="/webpanel/report/seller/search/keyword?keyword={{ request('keyword') }}&from={{ request('from') }}&to={{ request('to') }}&_token={{ request('_token') }}&page={{ 1 }}" aria-label="Previous">
                            <span aria-hidden="true">Previous</span>
                            </a>
                        @else
                        <a class="page-link" href="/webpanel/report/seller/search/keyword?keyword={{ request('keyword') }}&from={{ request('from') }}&to={{ request('to') }}&_token={{ request('_token') }}&page={{ $page - 1 }}" aria-label="Previous">
                            <span aria-hidden="true">Previous</span>
                            </a>
                        @endif
                        </li>

                        @if($total_page > 14)

                            @for ($i= 1; $i <= 10 ; $i++)
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/seller/search/keyword?keyword={{ request('keyword') }}&from={{ request('from') }}&to={{ request('to') }}&_token={{ request('_token') }}&page={{ $i }}">{{ $i }}</a></a></li>
                            @endfor
                            <li class="page-item"><a class="page-link">...</a></li>
                            @for ($i= $total_page-1; $i <= $total_page ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/report/seller/search/keyword?keyword={{ request('keyword') }}&from={{ request('from') }}&to={{ request('to') }}&_token={{ request('_token') }}&page={{ $i }}">{{ $i }}</a></a></li>
                            @endfor

                        @else
                            @for ($i= 1; $i <= $total_page ; $i++)
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/seller/search/keyword?keyword={{ request('keyword') }}&from={{ request('from') }}&to={{ request('to') }}&_token={{ request('_token') }}&page={{ $i }}">{{ $i }}</a></li>
                            @endfor
                        
                        @endif

                        <li class="page-item">
                        
                        @if ($page == $total_page)
                            <a class="page-link" href="/webpanel/report/seller/search/keyword?keyword={{ request('keyword') }}&from={{ request('from') }}&to={{ request('to') }}&_token={{ request('_token') }}&page={{ $page }}" aria-label="Next">
                            <span aria-hidden="true">next</span>
                            </a>
                        @else
                        <a class="page-link" href="/webpanel/report/seller/search/keyword?keyword={{ request('keyword') }}&from={{ request('from') }}&to={{ request('to') }}&_token={{ request('_token') }}&page={{ $page + 1 }}" aria-label="Next">
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
                @else
                
                <div class="ms-6">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                        <li class="page-item">

                        @if ($page == 1)
                            <a class="page-link" href="/webpanel/report/seller?page={{ 1 }}" aria-label="Previous">
                            <span aria-hidden="true">Previous</span>
                            </a>
                        @else
                        <a class="page-link" href="/webpanel/report/seller?page={{ $page - 1 }}" aria-label="Previous">
                            <span aria-hidden="true">Previous</span>
                            </a>
                        @endif
                        </li>

                        @if($total_page > 14)

                            @for ($i= 1; $i <= 10 ; $i++)
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/seller?page={{ $i }}">{{ $i }}</a></a></li>
                            @endfor
                            <li class="page-item"><a class="page-link">...</a></li>
                            @for ($i= $total_page-1; $i <= $total_page ; $i++)
                                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/report/seller?page={{ $i }}">{{ $i }}</a></a></li>
                            @endfor

                        @else
                            @for ($i= 1; $i <= $total_page ; $i++)
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/seller?page={{ $i }}">{{ $i }}</a></li>
                            @endfor
                        
                        @endif

                        <li class="page-item">
                        
                        @if ($page == $total_page)
                            <a class="page-link" href="/webpanel/report/seller?page={{ $page }}" aria-label="Next">
                            <span aria-hidden="true">next</span>
                            </a>
                        @else
                        <a class="page-link" href="/webpanel/report/seller?page={{ $page + 1 }}" aria-label="Next">
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
                {{-- <hr class="mt-3" style="color: #8E8E8E; width: 100%;"> --}}
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
    #edit {
        background-color: #04a752;
        color: #FFFFFF;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
    }
</style>
@endpush
