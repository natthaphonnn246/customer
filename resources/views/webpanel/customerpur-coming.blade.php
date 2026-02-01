@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/customer" class="!no-underline">ย้อนกลับ | </a> รับผิดชอบโดย : {{$admin_name->name}} ({{$admin_name->admin_area}})</h5>
        <hr class="my-3 !text-gray-400 !border">

        <div class="mr-6" style="text-align: right;">
            <a href="/webpanel/customer/export/getcsv/getcsv_customer/{{$admin_name->admin_area}}"  id="exportcsv" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">Export CSV</a>
            <a class="ms-1 !no-underline" href="/webpanel/customer/export/getexcel/getexcel_customer/{{$admin_name->admin_area}}"  id="exportexcel" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">Export Excel</a>
    
        </div>

        <div style="text-align:left;">
            @if(Session::get('error_export') == 'เกิดข้อผิดพลาด')

            <script>
                swal.fire({
                    title: 'เกิดข้อผิดพลาด',
                    icon: 'error',
                    confirmButtonText: 'ตกลง'

                });
            </script>
            @endif
        </div>

        <hr class="my-3" style="color: #8E8E8E; width: 100%;">

        <div class="row mx-4">
            
            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span class="text-white">
                    <a class="!no-underline text-white" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}">ร้านค้าทั้งหมด</a><br/>
                    @if (isset($total_customer_adminarea))
                    <span>{{$total_customer_adminarea != '' ? $total_customer_adminarea : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span class="text-white">
                    <a class="!no-underline text-white" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}/status-waiting">รอดำเนินการ</a><br/>
                    @if (isset($total_status_waiting))
                    <span>{{$total_status_waiting != '' ? $total_status_waiting : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span class="text-white">
                    <a class="!no-underline text-white" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}/status-action">ต้องดำเนินการ</a><br/>
                    @if (isset($total_status_action))
                    <span>{{$total_status_action != '' ? $total_status_action : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span class="text-white">
                    <a class="!no-underline text-white" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}/status-completed">ดำเนินการแล้ว</a><br/>
                    @if (isset($total_status_completed))
                    <span>{{$total_status_completed != '' ? $total_status_completed : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span class="text-white">
                    <a class="!no-underline text-white" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}/new-registration">ลงทะเบียนใหม่</a><br/>
                    @if (isset($total_status_registration))
                    <span>{{$total_status_registration != '' ? $total_status_registration : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

        </div>

        <hr class="my-3" style="color: #8E8E8E; width: 100%;">

         <!--- search --->
         <div class="grid grid-cols-2 md:grid-cols-12 gap-3 mx-8">
            <div class="col-span-3">

                {{-- <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label> --}}

                <button id="dropdownDividerButton" data-dropdown-toggle="dropdownDivider" class="" style="background-color: rgb(22, 175, 98); width: 100%; border-radius:8px; color:#ffffff; height:70px;" type="button">
                    
                    เลือกวันสั่งซื้อ
                    
                </button> 

                <!-- Dropdown menu -->
                    <div id="dropdownDivider" class="z-10 hidden divide-y divide-gray-100 shadow-sm w-44" style="text-align: left;">

                        <div class="py-2">
                            <a href="/webpanel/customer/adminarea/{{ $admin_name->admin_area }}/purchase/morethan" id="dropdownlist" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-white !no-underline text-center">ไม่สั่งเกิน 7 วัน</a>
                        </div>
                        <div class="py-2">
                            <a href="/webpanel/customer/adminarea/{{ $admin_name->admin_area }}/purchase/coming" id="dropdownlist" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-white !no-underline text-center">ใกล้ครบกำหนด</a>
                        </div>
                        <div class="py-2">
                            <a href="/webpanel/customer/adminarea/{{ $admin_name->admin_area }}/purchase/normal" id="dropdownlist" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-white !no-underline text-center">สั่งซื้อตามปกติ</a>
                        </div>
                        <div class="py-2">
                            <a href="/webpanel/customer/adminarea/{{ $admin_name->admin_area }}/purchase/no-purchase" id="dropdownlist" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-white !no-underline text-center">ไม่มีการสั่งซื้อ</a>
                        </div>
                    
                    </div>

            </div>

            <div class="col-span-9">
                <form class="w-full" method="get" action="/webpanel/customer/adminarea/{{$admin_name->admin_area}}">
                   {{--  <ul class="ms-2 my-2">
                        <span>ค้นหาร้านค้า : </span>
                    </ul> --}}
                    {{-- <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label> --}}
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <!---icon -->
                        </div>
                        <input type="search" id="default-search" name="keyword" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="CODE /ชื่อร้านค้า" />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium !rounded-md text-sm px-4 py-2 my-2">ค้นหา</button>
                    
                    </div>
                    <p class="py-2" id="keyword_search"></p>
                    @csrf   
                </form>
            </div>
        </div>
        
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

        <div class="mx-8 mb-2 overflow-x-auto">
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">
            <table class="table table-striped">
                <thead>

                <tr>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">#</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">CODE</td>
                    {{-- <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">อีเมล</td> --}}
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">ชื่อร้านค้า</td>
                    <td scope="col" class="!text-gray-500 text-center p-3 font-semibold">STATUS</td>
                    <td scope="col" class="!text-gray-500 text-center p-3 font-semibold">UPDATE</td>
                    <td scope="col" class="!text-gray-500 text-center p-3 font-semibold ">สถานะสั่งซื้อ</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">วันที่สมัคร</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">สถานะ</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">จัดการ</td>
                </tr>
                </thead>
                <tbody>
                    @if(!empty($customer_list))
                    <?php 
                        $start += 1;
                    ?>
                    @foreach ($customer_list as $row)
                <tr>
                        <?php
                            
                            $id = $row->id;
                            $user_name = $row->customer_name;
                            $user_code = $row->customer_id;
                            $status = $row->status;
                            $status_update = $row->status_update;
                            $email = $row->email;
                            $customer_status = $row->customer_status;
                            $created_at = $row->created_at;
                        ?>
                    
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$start++}}</td>
                        <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$user_code}}</td>
                        {{-- <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$email}}</td> --}}
                        <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500 md:w-1/5">{{$user_name}}</td>

                        <td class="text-center px-3 py-4 w-full md:w-1/5">
                            @if ($status == 'ลงทะเบียนใหม่')
                                <span class="inline-block border-2 border-sky-400 text-sky-400 px-3 py-2 rounded-lg text-sm">
                                    ลงทะเบียนใหม่
                                </span>
                        
                            @elseif ($status == 'รอดำเนินการ')
                                <span class="inline-block border-2 border-red-400 text-red-400 px-3 py-2 rounded-lg text-sm">
                                    รอดำเนินการ
                                </span>
                        
                            @elseif ($status == 'ต้องดำเนินการ')
                                <span class="inline-block border-2 border-amber-400 text-amber-400 px-3 py-2 rounded-lg text-sm">
                                    ต้องดำเนินการ
                                </span>
                        
                            @elseif ($status == 'ดำเนินการแล้ว')
                                <span class="inline-block border-2 border-green-500 text-green-500 px-3 py-2 rounded-lg text-sm">
                                    ดำเนินการแล้ว
                                </span>
                        
                            @else
                                <span class="inline-block border-2 border-gray-400 text-gray-400 px-3 py-2 rounded-lg text-sm">
                                    ปิดบัญชี
                                </span>
                            @endif
                        </td>

                        <td class="text-center px-3 py-4 w-full md:w-1/5">
                            @if ($status_update == 'updated')
                                <span class="inline-block border-2 border-gray-400 text-gray-400 px-3 py-2 rounded-lg text-sm">
                                    UPDATE
                                </span>
                            @else
                                <span class="inline-block border-2 border-gray-400 text-gray-400 px-3 py-2 rounded-lg text-sm">
                                    NULL
                                </span>
                            @endif
                        </td>

                        @if(isset($user_code) && $user_code != '')
                            @if(!empty($check_id))
                                @php 
                                // $id_purchase = $check_id->firstWhere('customer_id', $user_code)?->customer_id;
                                $id_purchase = $check_id->contains($user_code) ? $user_code : null;
                                
                                @endphp

                                @if ($id_purchase == $user_code)

                                @php 
                                $item = $check_purchase->firstWhere('customer_id', $user_code);
                                @endphp
                                
                                    @if ($item)
                                        @php
                                            $check_over_5 = \Carbon\Carbon::parse($item->date_purchase)->addDays(5)->lessThan(now());
                                            $check_over_7 = \Carbon\Carbon::parse($item->date_purchase)->addDays(7)->lessThan(now());
                                        @endphp
                                    
                                        <td scope="row" class="text-center px-3 py-4 w-full md:w-1/5">
                                            @if ($check_over_7)
                                            <span id="less{{ $user_code }}" class="inline-block border-2 border-red-500 text-red-500 px-3 py-2 rounded-lg text-sm cursor-pointer">
                                                ไม่สั่งเกิน 7 วัน
                                            </span>
                                            
                                            <div class="modal fade" style="margin-top:40px;" id="staticBackdrop_normal{{ $user_code }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <span class="modal-title" id="staticBackdropLabel">ร้านค้า : {{ $user_code }} | {{ $user_name }}</span>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        
                                                        <div class="modal-body">
                                                            <div class="mb-2" style="text-align: left;">
                                                                เลขที่: <span id="order-number{{ $user_code }}"></span> |
                                                                <span style="background-color: #e04b30; color:white; border-radius:5px; padding:3px;" id="date-number{{ $user_code }}"></span>
                                                            </div>
                                                            <div class="relative overflow-x-auto">
                                                                <table class="w-full text-left">
                                                                    <thead style="background-color:#222222; color:rgb(255, 255, 255);">
                                                                        <tr>
                                                                            <td class="px-6 py-3 text-center">รหัสสินค้า</td>
                                                                            <td class="px-6 py-3">ชื่อสินค้า</td>
                                                                            <td class="px-6 py-3 text-center">หน่วย</td>
                                                                            <td class="px-6 py-3 text-center">จำนวน</td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="result-area{{ $user_code }}">
                                                                        <tr>
                                                                            <td colspan="4" class="text-center py-4">กำลังโหลดข้อมูล...</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    
                                                    </div>
                                                </div>
                                            </div>

                                                
                                            @elseif ($check_over_5)
                                                <span id="less{{ $user_code }}" class="inline-block border-2 border-yellow-500 text-yellow-500 px-3 py-2 rounded-lg text-sm cursor-pointer">
                                                    ใกล้ครบกำหนด
                                                </span>

                                                <div class="modal fade" style="margin-top:40px;" id="staticBackdrop_normal{{ $user_code }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <span class="modal-title" id="staticBackdropLabel">ร้านค้า : {{ $user_code }} | {{ $user_name }}</span>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            
                                                            <div class="modal-body">
                                                                <div class="mb-2" style="text-align: left;">
                                                                    เลขที่: <span id="order-number{{ $user_code }}"></span> |
                                                                    <span style="background-color: #ffa51d; color:white; border-radius:5px; padding:3px;" id="date-number{{ $user_code }}"></span>
                                                                </div>
                                                                <div class="relative overflow-x-auto">
                                                                    <table class="w-full text-left">
                                                                        <thead style="background-color:#222222; color:rgb(255, 255, 255);">
                                                                            <tr>
                                                                                <td class="px-6 py-3 text-center">รหัสสินค้า</td>
                                                                                <td class="px-6 py-3">ชื่อสินค้า</td>
                                                                                <td class="px-6 py-3 text-center">หน่วย</td>
                                                                                <td class="px-6 py-3 text-center">จำนวน</td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="result-area{{ $user_code }}">
                                                                            <tr>
                                                                                <td colspan="4" class="text-center py-4">กำลังโหลดข้อมูล...</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            @else

                                                <span id="less{{ $user_code }}" class="inline-block border-2 border-green-500 text-green-500 px-3 py-2 rounded-lg text-sm cursor-pointer">
                                                    สั่งตามปกติ
                                                </span>

                                                <div class="modal fade" style="margin-top:40px;" id="staticBackdrop_normal{{ $user_code }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <span class="modal-title" id="staticBackdropLabel">ร้านค้า : {{ $user_code }} | {{ $user_name }}</span>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            
                                                            <div class="modal-body">
                                                                <div class="mb-2" style="text-align: left;">
                                                                    เลขที่: <span id="order-number{{ $user_code }}"></span> |
                                                                    <span style="background-color: #09be0f; color:white; border-radius:5px; padding:3px;" id="date-number{{ $user_code }}"></span>
                                                                </div>
                                                                <div class="relative overflow-x-auto">
                                                                    <table class="w-full text-left">
                                                                        <thead style="background-color:#222222; color:rgb(255, 255, 255);">
                                                                            <tr>
                                                                                <td class="px-6 py-3 text-center">รหัสสินค้า</td>
                                                                                <td class="px-6 py-3">ชื่อสินค้า</td>
                                                                                <td class="px-6 py-3 text-center">หน่วย</td>
                                                                                <td class="px-6 py-3 text-center">จำนวน</td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="result-area{{ $user_code }}">
                                                                            <tr>
                                                                                <td colspan="4" class="text-center py-4">กำลังโหลดข้อมูล...</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    @endif

                                    <!-- แสดงรายการสินค้าสุดท้าย -->
                                    <script>
                                        $(document).ready(function() {
                                            const use_id = "{{ $user_code }}";
                                            const modalId = '#staticBackdrop_normal{{ $user_code }}';
                                    
                                            $('#less{{ $user_code }}').click(function(e) {
                                                e.preventDefault();
                                    
                                                fetch('/webpanel/customer/purchase', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    },
                                                    body: JSON.stringify({ use_id: use_id })
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    const resultArea  = document.getElementById('result-area{{ $user_code }}');
                                                    const orderNumber = document.getElementById('order-number{{ $user_code }}');
                                                    const datePur     = document.getElementById('date-number{{ $user_code }}');
                                    
                                                    if (Array.isArray(data.use_id) && data.use_id.length > 0) {
                                                        let rows  = '' ;
                                                        let total = 0 ;
                                                        data.use_id.forEach(item => {
                                                            rows += `
                                                                <tr>
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">${item.product_id}</td>
                                                                    <td class="border border-gray-300 px-4 py-2">${item.product_name}</td>
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">${item.unit}</td>
                                                                    <td class="border border-gray-300 px-4 py-2 text-center">${item.quantity}</td>
                                        
                                                                </tr>
                                                            `;
                                                            po_number     = `${item.purchase_order}`;
                                                            date_purchase = `${item.date_purchase}`;

                                                            total += Number(item.total_sale ?? 0);
                                                            
                                                        });

                                                            
                                                        rows += `
                                                            <tr>
                                                                <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">รวมเป็นเงิน</td>
                                                                <td class="border border-gray-300 px-4 py-2 text-center" colspan="2">฿${total.toLocaleString('th-TH', { minimumFractionDigits: 2 })}</td>
                                                            </tr>
                                                        `;
                                                                                            
                                                        resultArea.innerHTML  = rows;
                                                        orderNumber.innerHTML = po_number ?? '';
                                                        datePur.innerHTML     = date_purchase ?? '';
                                                    } else {
                                                        resultArea.innerHTML = `
                                                            <tr>
                                                                <td colspan="4" class="text-center text-red-500 py-4">ไม่พบข้อมูล</td>
                                                            </tr>
                                                        `;
                                                        orderNumber.innerHTML = '';
                                                    }
                                    
                                                    // เปิด Modal
                                                    const myModal = new bootstrap.Modal(document.querySelector(modalId));
                                                    myModal.show();
                                                })
                                                .catch(error => {
                                                    console.error('Error:', error);
                                                    const resultArea = document.getElementById('result-area{{ $user_code }}');
                                                    resultArea.innerHTML = `
                                                        <tr>
                                                            <td colspan="4" class="text-center text-red-500 py-4">เกิดข้อผิดพลาดในการโหลดข้อมูล</td>
                                                        </tr>
                                                    `;
                                                });
                                            });
                                        });
                                    </script>
                                @else
                                    <td class="text-center px-3 py-4 w-full md:w-1/5">
                                        <span class="inline-block border-2 border-sky-500 text-sky-500 px-3 py-2 rounded-lg text-sm">
                                            ไม่พบการสั่ง
                                        </span>
                                    </td>
                                @endif
                                
                            @endif

                        @else
                        <td class="text-center px-3 py-4 w-full md:w-1/5">
                            <span class="inline-block border-2 border-gray-500 text-gray-500 px-3 py-2 rounded-lg text-sm">
                                ไม่ระบุ CODE
                            </span>
                        </td>
                        @endif

                        <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$created_at}}</td>

                        <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">
                    
                            <label class="switch">
                                <input type="checkbox" name="check" id="status_on{{$id}}" {{$customer_status == 'active' ? 'checked' : ''}}>
                                {{-- {{dd($customer_status);}} --}}
                                <span class="slider round" style="text-align: center;">
                                    <span style="color: white; font-size: 10px; text-align: center;">ON</span>
                                    <span style="color: white; font-size: 10px;">OFF</span>
                                </span>
                            </label>
                    
                        </td>

                        <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">
                            <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                                <a href="/webpanel/customer/{{$id}}" id="edit"><i class="fa-regular fa-eye"></i></a>
                                <button class="trash-customer" type="submit" id="trash{{$id}}"><i class="fa-regular fa-trash-can"></i></button>    
                            </div>
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

        @if(!isset($check_keyword) && $total_page > 1)
        <div class="ms-6">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                <li class="page-item">

                @if ($page == 1)
                    <a class="page-link" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}/purchase/coming?page={{ 1 }}" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @else
                    <a class="page-link" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}/purchase/coming?page={{ $page-1 }}" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @endif
                </li>

                @if($total_page > 14)

                    @for ($i= 1; $i <= 10 ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}/purchase/coming?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link">...</a></li>
                    @for ($i= $total_page-1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}/purchase/coming?page={{ $i }}">{{ $i }}</a></li>
                    @endfor

                @else
                    @for ($i= 1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}/purchase/coming?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                
                @endif

                <li class="page-item">
                
                @if ($page == $total_page)
                    <a class="page-link" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}/purchase/coming?page={{ $page }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @else
                    <a class="page-link" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}/purchase/coming?page={{ $page + 1 }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @endif
                </li>
                </ul>
            </nav>
        </div>
        @elseif ($count_page <= 1)
        @else
        <div class="ms-6">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                <li class="page-item">

                @if ($page == 1)
                    <a class="page-link" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ 1 }}" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @else
                    <a class="page-link" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $page - 1 }}" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @endif
                </li>

                @if($total_page > 14)

                    @for ($i= 1; $i <= 10 ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link">...</a></li>
                    @for ($i= $total_page-1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $i }}">{{ $i }}</a></li>
                    @endfor

                @else
                    @for ($i= 1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                
                @endif

                <li class="page-item">
                
                @if ($page == $total_page)
                    <a class="page-link" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $page }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @else
                    <a class="page-link" href="/webpanel/customer/adminarea/{{$admin_name->admin_area}}?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $page + 1 }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @endif
                </li>
                </ul>
            </nav>
        </div>
        @endif
        <hr class="mt-3" style="color: #8E8E8E; width: 100%;">
        <div class="py-3">
            <p class="ms-8 text-sm" style="color:#898989;"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
        </div>

    </div>
@endsection
@push('styles')
<style>
    #exportcsv {
        background-color: #dddddd;
        color: #3d3d3d;
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
        color: #3d3d3d;
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
    #edit {
        background-color: #007bff;
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

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

     /* toggle off */
    .switchs {
        position: relative;
        display: inline-block;
        width: 55px;
        height: 28px;
        
    }

    /* Hide default HTML checkbox */
    .switchs input {
        opacity: 0;
        width: 0;
        height: 0;
        
    }

    .sliders {
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
    .sliders:before {
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

    input:checked + .sliders {
        background-color: #f63d3d;

    }

    input:focus + .sliders {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .sliders:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .sliders.round {
        border-radius: 34px;
    }

    .sliders.round:before {
        border-radius: 50%;
    }
    #dropdownDivider {
        background-color: rgb(67, 68, 68);
        color: white;
        border-radius: 5px;
        
    }
    #dropdownlist:hover {
        background-color: rgba(8, 123, 110, 0.544);
        color: white;
        border-radius: 5px;
        
    }
</style>
@endpush
