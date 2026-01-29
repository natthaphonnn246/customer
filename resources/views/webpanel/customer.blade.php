@extends ('layouts.webpanel')
@section('content')

    <div class="py-2"></div>
    <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/sale" class="!no-underline">ย้อนกลับ</a> | ร้านค้า</h5>
    <hr class="my-3 !text-gray-400 !border">
    
    <div class="grid grid-cols-1 mx-4 px-2 text-gray-500">

        <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
            <a href="/webpanel/customer/customer-create"  id="admin" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">เพิ่มลูกค้าใหม่</a>
            <a href="/webpanel/customer/importcustomer"  id="importMaster" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">import CSV</a>
            <a href="/webpanel/customer/updatecsv"  id="updateMaster" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Update</a>
            <a href="/webpanel/customer/groups-customer"  id="groupsCustomer" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">จัดกลุ่มลูกค้า</a>

            <a href="/webpanel/customer/export/getcsv/getcsv_customerall"  id="exportcsv" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export CSV</a>
            <a href="/webpanel/customer/export/getexcel/getexcel_customerall"  id="exportexcel" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export Excel</a>
            <a href="/webpanel/customer/export/getcsv/getcsv_certstatus"  id="exportstatus" class="btn" type="submit"  name="" style="width: 210px; padding: 8px;">Export License (vmdrug)</a>
    
        </div>

        <hr class="my-3 !text-gray-400">

        @php
            $year = (int) date('Y');
            $expireDate = \Carbon\Carbon::now();
            // $expireDate = \Carbon\Carbon::createFromFormat('d/m/Y', '30/12/'.$year);
            $checkDate  = \Carbon\Carbon::createFromFormat('d/m/Y', '31/12/'.$year);

        @endphp

        <div>
            <button 
                id="statuswating" 
                type="submit"
                class="btn btn-warning mt-2"
                {{ $expireDate->toDateString() < $checkDate->toDateString() ? 'disabled' : '' }}>
                อัปเดตสถานะใบอนุญาตเป็น : รอดำเนินการ
            </button>
        
            <p class="text-sm text-gray-500 mt-2 mb-1">
                *ปุ่มนี้ทำงานทุกวันที่ <span class="font-semibold">31/12/{{ $year }}</span>
            </p>
        </div>


        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                        document.getElementById('statuswating').addEventListener('click', function(e) {
                            e.preventDefault();
                            console.log('status_wating');
                    
                            fetch('/webpanel/customer/update-status/wating', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken // ส่ง CSRF token
                                },
                                body: JSON.stringify({
                                    status: 'waiting'
                                })
                            })
                            .then(result => result.json())
                            .then(data => {
                                //data ที่ไได้จาก json
                                if(data.status === 'waiting') {
                                    Swal.fire({
                                        title: "สำเร็จ",
                                        text: `${data.message}`,
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

                                } else {
                                    Swal.fire({
                                        title: "ล้มเหลว",
                                        text: `${data.message}`,
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
                                }

                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                        });
                    });
        </script>

        <hr class="my-3 !text-gray-400">

        <div>
            <a href="/webpanel/customer/check/cache"  id="cache" class="btn" type="submit"  name="" style="width: 220px; padding: 8px;"><i class="fa-solid fa-trash"></i> เคลียร์แคลช</a>

            <p class="text-sm text-gray-500 mt-2 mb-1" style="font-weight:400">
                *เคลียร์หลัง import csv รายงานขาย
            </p>
        </div>

        <hr class="my-3 !text-gray-400">

        @if (session('success_cache') == 'cache_clear')
            <script> 
                    $('#bg').css('display', 'none');
                    Swal.fire({
                        title: "สำเร็จ",
                        text: "เคลียร์แคลชเรียบร้อย",
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

        <div class="ms-6">
            <div class="my-2">
                <span>ส่งออกไฟล์ : </span>
            </div>
        
            {{-- Export CSV --}}
            <div class="relative inline-block mr-4">
                <button data-dropdown-toggle="dropdownCsv" class="bg-green-500 hover:bg-green-600 text-white !rounded-sm px-4 py-2">
                    Export CSV
                </button>
        
                <div id="dropdownCsv" class="z-10 hidden divide-y divide-gray-100 rounded-lg shadow w-44 absolute">
                    <a href="/webpanel/customer/export/purchase/getcsv/morethan" class="block px-4 py-2 text-sm !no-underline" id="listCsv"">ไม่สั่งสินค้าเกิน 7 วัน</a>
                    <a href="/webpanel/customer/export/purchase/getcsv/coming" class="block px-4 py-2 text-sm !no-underline" id="listCsv">ใกล้ครบกำหนด</a>
                    <a href="/webpanel/customer/export/purchase/getcsv/normal" class="block px-4 py-2 text-sm !no-underline" id="listCsv">สั่งสินค้าปกติ</a>
                    <a href="/webpanel/customer/export/purchase/getcsv/no-purchase" class="block px-4 py-2 text-sm !no-underline" id="listCsv">ไม่มีการสั่งสินค้า</a>
                </div>
            </div>
        
            {{-- Export Excel --}}
            <div class="relative inline-block">
                <button data-dropdown-toggle="dropdownExcel" class="bg-blue-500 hover:bg-blue-600 text-white !rounded-sm px-4 py-2">
                    Export Excel
                </button>
        
                <div id="dropdownExcel" class="z-10 hidden divide-y divide-gray-100 rounded-lg shadow w-44 absolute">
                    <a href="/webpanel/customer/export/purchase/getexcel/morethan" class="block px-4 py-2 text-sm !no-underline" id="listExcel">ไม่สั่งสินค้าเกิน 7 วัน</a>
                    <a href="/webpanel/customer/export/purchase/getexcel/coming" class="block px-4 py-2 text-sm !no-underline" id="listExcel">ใกล้ครบกำหนด</a>
                    <a href="/webpanel/customer/export/purchase/getexcel/normal" class="block px-4 py-2 text-sm !no-underline" id="listExcel">สั่งสินค้าปกติ</a>
                    <a href="/webpanel/customer/export/purchase/getexcel/no-purchase" class="block px-4 py-2 text-sm !no-underline" id="listExcel">ไม่มีการสั่งสินค้า</a>
                </div>
            </div>
        </div>
        
        <hr class="my-4" style="color: #8E8E8E; width: 100%;">

        <div class="row ms-6" style="justify-content: left;">

            @php
                $total_customer             = $stats->total_customer;
                $total_status_registration  = $stats->total_status_registration;
                $total_status_waiting       = $stats->total_status_waiting;
                $total_status_action        = $stats->total_status_action;
                $total_status_completed     = $stats->total_status_completed;
                $total_status_updated       = $stats->total_status_updated;
                $customer_status_inactive   = $stats->customer_status_inactive;
                $add_license_status         = $stats->add_license_status;
                $type_status_1              = $stats->type_status_1;
                $type_status_2              = $stats->type_status_2;
                $type_status_3              = $stats->type_status_3;
                $type_status_4              = $stats->type_status_4;
                $type_status_5              = $stats->type_status_5;
                $other_purchase             = $stats->other_purchase;

            @endphp

    
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                <!-- ร้านค้าทั้งหมด -->
                <div class="bg-blue-500 rounded-xl p-5 text-white">
                    <div class="text-base opacity-90">ร้านค้าทั้งหมด</div>
                    <div class="text-2xl font-bold">
                        {{ isset($total_customer) ? ($total_customer != '' ? $total_customer : '0') : 'error' }}
                    </div>
                </div>

                <!-- ลงทะเบียนใหม่ -->
                <a href="/webpanel/customer/status/new_registration"
                class="bg-sky-500 rounded-xl p-5 text-white hover:bg-sky-600 !no-underline transition block">
                    <div class="text-base opacity-90">ลงทะเบียนใหม่</div>
                    <div class="text-2xl font-bold">
                        {{ isset($total_status_registration) ? ($total_status_registration != '' ? $total_status_registration : '0') : 'error' }}
                    </div>
                </a>

                <!-- ดำเนินการแล้ว -->
                <a href="/webpanel/customer/status/completed"
                class="bg-green-500 rounded-xl p-5 text-white hover:bg-green-600 !no-underline transition block">
                    <div class="text-base opacity-90">ดำเนินการแล้ว</div>
                    <div class="text-2xl font-bold">
                        {{ isset($total_status_completed) ? ($total_status_completed != '' ? $total_status_completed : '0') : 'error' }}
                    </div>
                </a>

                <!-- รอดำเนินการ -->
                <a href="/webpanel/customer/status/waiting"
                class="bg-red-500 rounded-xl p-5 text-white hover:bg-red-600 !no-underline transition block">
                    <div class="text-base opacity-90">รอดำเนินการ</div>
                    <div class="text-2xl font-bold">
                        {{ isset($total_status_waiting) ? ($total_status_waiting != '' ? $total_status_waiting : '0') : 'error' }}
                    </div>
                </a>

                <!-- ต้องดำเนินการ -->
                <a href="/webpanel/customer/status/action"
                class="bg-yellow-500 rounded-xl p-5 text-white hover:bg-yellow-600 !no-underline transition block">
                    <div class="text-base opacity-90">ต้องดำเนินการ</div>
                    <div class="text-2xl font-bold">
                        {{ isset($total_status_action) ? ($total_status_action != '' ? $total_status_action : '0') : 'error' }}
                    </div>
                </a>

                <!-- UPDATE -->
                <a href="/webpanel/customer/status/latest_update"
                class="relative bg-gray-400 rounded-xl p-5 text-white hover:bg-gray-500 !no-underline transition block">
                    <span class="absolute top-2 right-2 bg-sky-500 text-xs px-2 py-0.5 rounded-full">
                        NEW
                    </span>
                    <div class="text-base opacity-90">UPDATE</div>
                    <div class="text-2xl font-bold">
                        {{ isset($total_status_updated) ? ($total_status_updated != '' ? $total_status_updated : '0') : 'error' }}
                    </div>
                </a>

                <!-- ปิดบัญชี -->
                <a href="/webpanel/customer/status/inactive"
                class="bg-gray-400 rounded-xl p-5 text-white hover:bg-gray-500 !no-underline transition block">
                    <div class="text-base opacity-90">ปิดบัญชี</div>
                    <div class="text-2xl font-bold">
                        {{ isset($customer_status_inactive) ? ($customer_status_inactive != '' ? $customer_status_inactive : '0') : 'error' }}
                    </div>
                </a>

                <!-- ขายส่ง -->
                <a href="/webpanel/customer/status/check-license"
                class="bg-violet-500 rounded-xl p-5 text-white hover:bg-violet-600 !no-underline transition block">
                    <div class="text-base opacity-90">ขายส่ง</div>
                    <div class="text-2xl font-bold">
                        {{ isset($add_license_status) ? ($add_license_status != '' ? $add_license_status : '0') : 'error' }}
                    </div>
                </a>

                <!-- ข.ย.1 -->
                <a href="/webpanel/customer/status/checktype-1"
                class="bg-orange-400 rounded-xl p-5 text-white hover:bg-orange-500 !no-underline transition block">
                    <div class="text-base opacity-90">ข.ย.1</div>
                    <div class="text-2xl font-bold">
                        {{ isset($type_status_1) ? ($type_status_1 != '' ? $type_status_1 : '0') : 'error' }}
                    </div>
                </a>

                <!-- ข.ย.2 -->
                <a href="/webpanel/customer/status/checktype-2"
                class="bg-orange-400 rounded-xl p-5 text-white hover:bg-orange-500 !no-underline transition block">
                    <div class="text-base opacity-90">ข.ย.2</div>
                    <div class="text-2xl font-bold">
                        {{ isset($type_status_2) ? ($type_status_2 != '' ? $type_status_2 : '0') : 'error' }}
                    </div>
                </a>

                <!-- สมพ.2 -->
                <a href="/webpanel/customer/status/checktype-3"
                class="bg-orange-400 rounded-xl p-5 text-white hover:bg-orange-500 !no-underline transition block">
                    <div class="text-base opacity-90">สมพ.2</div>
                    <div class="text-2xl font-bold">
                        {{ isset($type_status_3) ? ($type_status_3 != '' ? $type_status_3 : '0') : 'error' }}
                    </div>
                </a>

                <!-- คลินิกยา -->
                <a href="/webpanel/customer/status/checktype-4"
                class="bg-orange-400 rounded-xl p-5 text-white hover:bg-orange-500 !no-underline transition block">
                    <div class="text-base opacity-90">คลินิกยา / สถานพยาบาล</div>
                    <div class="text-2xl font-bold">
                        {{ isset($type_status_4) ? ($type_status_4 != '' ? $type_status_4 : '0') : 'error' }}
                    </div>
                </a>

                <!-- ไม่ระบุแบบอนุญาต -->
                <a href="/webpanel/customer/status/checktype-5"
                class="bg-gray-400 rounded-xl p-5 text-white hover:bg-gray-500 !no-underline transition block">
                    <div class="text-base opacity-90">ไม่ระบุแบบอนุญาต</div>
                    <div class="text-2xl font-bold">
                        {{ isset($type_status_5) ? ($type_status_5 != '' ? $type_status_5 : '0') : 'error' }}
                    </div>
                </a>

                <!-- สั่งซื้ออื่น ๆ -->
                <a href="/webpanel/customer/order/other-purchase"
                class="bg-gray-400 rounded-xl p-5 text-white hover:bg-gray-500 !no-underline transition block">
                    <div class="text-base opacity-90">สั่งซื้อ (Line, โทรศัพท์)</div>
                    <div class="text-2xl font-bold">
                        {{ isset($other_purchase) ? ($other_purchase != '' ? $other_purchase : '0') : 'error' }}
                    </div>
                </a>

            </div>

        </div>
        <hr class="my-3 !text-gray-400">
        <!--- search --->
  
        <div class="grid md:grid-cols-12 grid-cols-1 gap-3 mb-4">
            <div class="col-span-3">
                <form class="w-full mt-2 text-left" method="get" action="/webpanel/customer">
                    <span class="block mb-2">เลือกผลลัพธ์ : </span>
                    <button
                        id="dropdownDividerButton"
                        data-dropdown-toggle="dropdownDivider"
                        class="bg-green-600 py-2 w-full !rounded-lg text-white text-center px-4"
                        type="button"
                    >
                        เขตรับผิดชอบ
                    </button>
        
                    <div id="dropdownDivider" class="z-10 hidden divide-y divide-gray-100 shadow-sm text-left">
                        @if(isset($admin_area))
                            @foreach($admin_area as $row_area)
                                <a href="/webpanel/customer/adminarea/{{$row_area->admin_area}}"
                                   class="block px-4 py-2 text-sm hover:!bg-green-700 !no-underline text-white">
                                    {{$row_area->admin_area}} ({{$row_area->name}})
                                </a>
                            @endforeach
                        @endif
                    </div>
                </form>
            </div>
        
            <div class="col-span-9">
                <form class="w-full mt-2 text-left" method="get" action="/webpanel/customer">
                    <span class="block mb-2">ค้นหาร้านค้า : </span>
                    <div class="flex items-center gap-2">
                        <input
                            type="search"
                            name="keyword"
                            class="block w-full p-2 text-sm text-gray-900 border rounded-lg bg-gray-50 placeholder-gray-400"
                            placeholder="CODE | ชื่อร้านค้า"
                        />
                        <button
                            type="submit"
                            class="right-2 bottom-2 bg-blue-700 text-white rounded-lg px-3 py-2 !rounded-lg"
                        >
                            ค้นหา
                        </button>
                    </div>
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

        <div id="protected">
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">
            <table class="table table-striped">
                <thead>

                <tr>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">#</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">CODE</td>
                    {{-- <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">อีเมล</td> --}}
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">ชื่อร้านค้า</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">Admin Area</td>
                    <td scope="col" class="!text-gray-500 text-center p-3 font-semibold">STATUS</td>
                    <td scope="col" class="!text-gray-500 text-center p-3 font-semibold">UPDATE</td>
                    <td scope="col" class="!text-gray-500 text-center p-3 font-semibold">สถานะสั่งซื้อ</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">วันที่สมัคร</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">สถานะ</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">จัดการ</td>
                </tr>
                </thead>
                <tbody>
                    @if(!empty($customer))
                    <?php 
                        @$start += 1;
                    ?>
                    @foreach ($customer as $row)
                <tr>
                        <?php
                            
                            $id = $row->id;
                            $user_name = $row->customer_name;
                            $user_code = $row->customer_code;
                            $status = $row->status;
                            $status_update = $row->status_update;
                            $email = $row->email;
                            $customer_status = $row->customer_status;
                            $created_at = $row->created_at;
                            $adminArea = $row->admin_area;
                        ?>
                    
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$start++}}</td>
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$user_code}}</td>
                    {{-- <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$email}}</td> --}}
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$user_name}}</td>
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$adminArea}}</td>

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
                        
                            @if(!empty($check_purchase))
                                @php 

                                // $id_purchase = collect($check_purchase->items())->firstWhere('customer_id', $user_code)?->customer_id;

                                // $item = collect($check_purchase->items())->firstWhere('customer_id', $user_code);
                                // $id_purchase = $item?->customer_id;

                                $id_purchase = $check_purchase->firstWhere('customer_id', $user_code)?->customer_id;

                                @endphp

                                @if ($id_purchase == $user_code)

                                @php 
                                $item = $check_purchase->firstWhere('customer_id', $user_code);
                                // $item = collect($check_purchase->items())->firstWhere('customer_id', $user_code);

                          
                                @endphp
                                
                                    @if ($item)
                                        @php
                                            $check_over_5 = \Carbon\Carbon::parse($item->date_purchase)->addDays(5)->lessThan(now());
                                            $check_over_7 = \Carbon\Carbon::parse($item->date_purchase)->addDays(7)->lessThan(now());

                                        @endphp
                                    {{-- {{ $check_over_7 }} --}}
                                        <td class="text-center px-3 py-4 w-full md:w-1/5">
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
                                {{-- <a href="/webpanel/customer/delete/{{$user_code}}" id="trash"><i class="fa-regular fa-trash-can"></i></a> --}}
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

        {{-- {{$total_page}} --}}
        @if(!isset($check_keyword))
        <div class="mt-3">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                <li class="page-item">

                @if ($page == 1)
                    <a class="page-link" href="/webpanel/customer?page=<?=1 ; ?>" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @else
                    <a class="page-link" href="/webpanel/customer?page=<?= $page-1 ; ?>" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @endif
                </li>

                @if($total_page > 14)

                    @for ($i= 1; $i <= 10 ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/customer?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link">...</a></li>
                    @for ($i= $total_page-1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/customer?page={{ $i }}">{{ $i }}</a></li>
                    @endfor

                @else
                    @for ($i= 1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/customer?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                
                @endif

                <li class="page-item">
                
                @if ($page == $total_page)
                    <a class="page-link" href="/webpanel/customer?page={{ $page }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @else
                    <a class="page-link" href="/webpanel/customer?page={{ $page + 1 }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @endif
                </li>
                </ul>
            </nav>
        </div>
        <hr class="my-3 !text-gray-400">
        <div class="py-2">
            <p class="text-sm"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
        </div>
        @else
        <div class="ms-6">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                <li class="page-item">

                @if ($page == 1)
                    <a class="page-link" href="/webpanel/customer?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ 1 }}" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @else
                    <a class="page-link" href="/webpanel/customer?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $page - 1 }}" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @endif
                </li>

                @if($total_page > 14)

                    @for ($i= 1; $i <= 10 ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/customer?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link">...</a></li>
                    @for ($i= $total_page-1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/customer?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $i }}">{{ $i }}</a></li>
                    @endfor

                @else
                    @for ($i= 1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/customer?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                
                @endif

                <li class="page-item">
                
                @if ($page == $total_page)
                    <a class="page-link" href="/webpanel/customer?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $page }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @else
                    <a class="page-link" href="/webpanel/customer?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $page + 1 }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @endif
                </li>
                </ul>
            </nav>
        </div>
        <hr class="my-3 !text-gray-400">
        <div class="py-2">
            <p class="text-sm"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
        </div>
        @endif

    </div>
@endsection
@push('styles')
    <style>
        #admin {
            background-color: #007bff;
            color: #FFFFFF;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #admin:hover {
            background-color: #0b59f6;
        }
        #importMaster {
            background-color: #4e5dff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importMaster:hover {
            background-color: #3848fb;
            color: #ffffff;
        }
        #updateMaster {
            background-color: #f86060;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #updateMaster:hover {
            background-color: #ff4242;
            color: #ffffff;
        }
        #groupsCustomer {
            background-color: #ffd500;
            color: #272727;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #groupsCustomer:hover {
            background-color: #ffc800;
            color: #272727;
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
        #exportstatus {
            background-color: #0fc843;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #exportstatus:hover {
            background-color: #05b136;
            color: #ffffff;
        }
        #cache {
            background-color: #ffdb49;
            color: #383729;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #cache:hover {
            background-color: #ffd000;
            color: #2e2d1d;
        }
        #statuswating {
            background-color: #ee2a18;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #statuswating:hover {
            background-color: #f33d3d;
            color: #ffffff;
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
        #dropdownDividerExport {
            background-color: rgb(67, 68, 68);
            color: white;
            border-radius: 5px;
            
        }
        #listCsv {
            background-color: rgb(67, 68, 68);
            color: white;
            border-radius: 5px;
            
        }
        #listCsv:hover {
            background-color: rgb(8, 123, 110);
            color: white;
            border-radius: 5px;
            
        }
        #listExcel {
            background-color: rgb(67, 68, 68);
            color: white;
            border-radius: 5px;
            
        }
        #listExcel:hover {
            background-color: rgb(8, 123, 110);
            color: white;
            border-radius: 5px;
            
        }
    /*         #protected {
                    position: relative;
                    }

                    #protected::after {
                    content: "© ห้ามบันทึกภาพหน้าจอ";
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    font-size: 120px;
                    color: rgba(234, 43, 43, 0.111);
                    pointer-events: none;
                    transform: translate(-50%, -50%) rotate(-45deg);
                    white-space: nowrap;
                }
    */

    </style>
@endpush
