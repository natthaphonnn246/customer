@extends ('layouts.portal')
@section('content')

        <div class="py-2"></div>
        <h5 class="ms-6 !text-gray-600">ร้านค้า</h5>
        <hr class="my-3">

            <!-- check modal --->
            <div class="modal fade" id="checkModal" tabindex="-1" aria-labelledby="checkModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header text-center">
                      <h5 class="modal-title w-100 text-center" style="font-size: 24px; font-weight:400; color: rgb(249, 48, 48);">ปิดแก้ไขข้อมูลลูกค้าชั่วคราว</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p style="color: red;">
                            <img src="/icons/alarm.gif" alt="" style="width:100%; height:auto; max-width:500px;">
                        </p>                        
                        <p style="color: rgb(0, 68, 255); font-size:24px;">
                            กรุณากลับมาอีกครั้งในภายหลัง
                        </p>
                    </div>
                    
                    <div class="modal-footer">
                      <button type="button" id="acknowledgeBtn" class="btn btn-primary">รับทราบ</button>
                    </div>
                  </div>
                </div>
            </div>

             <!-- check modal waiting --->
             @if(isset($count_modal_waiting) && $count_modal_waiting > 0)
                <div class="modal fade" id="checkModalWaiting" tabindex="-1" aria-labelledby="checkModalWaitingLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                        <h5 class="modal-title w-100 text-center !text-orange-400">
                            {{-- กรุณาอัปเดตข้อมูลให้ครบ :  --}}
                            <span class="inline-block border-2 border-amber-400 text-amber-400 px-3 py-2 rounded-lg text-base">ต้องดำเนินการ</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                        </div>
                        <div class="modal-body text-left">
                            <table class="table table-bordered table-striped table-hover align-middle">
                                <thead class="table-warning">
                                    <tr>
                                        <td class="!text-center font-medium !text-gray-600">รหัสร้านค้า</td>
                                        <td class="!text-center font-medium !text-gray-600">
                                            ชื่อร้านค้า
                                        </td>
                                 
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($check_modal_waiting as $row_modal)
                                        <tr>
                                            <td class="!text-center !text-gray-500">{{ $row_modal->customer_id }}</td>
                                            <td>
                                                <a href="{{ asset('/portal/customer/'.$row_modal->slug) }}" class="!no-underline !text-gray-500">
                                                    {{ $row_modal->customer_name }}
                                                    {{-- <sup style="background-color:#e04b30; color:white; border-radius:5px; padding:3px;">Edit</sup> --}}
                                                </a>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="modal-footer">
                        <button type="button" id="acknowledgeBtnWaiting" class="btn btn-warning">รับทราบ</button>
                        </div>
                    </div>
                    </div>
                </div>
            @endif
            <!-- ต้องการเปิด 2 modal พร้อมกัน -->
            <script>
                    document.addEventListener("DOMContentLoaded", function () {
                    let checkEdit = @json($check_edit); // true/false หรือ 1/0
                    
                    if (checkEdit) {
                        // modal 1
                        var modal1 = new bootstrap.Modal(document.getElementById('checkModal'));
                        // var modal2 = new bootstrap.Modal(document.getElementById('checkModalWaiting'));

                        // เปิด modal แรก
                        modal1.show();

                        // ปุ่มปิด modal1
                        document.getElementById('acknowledgeBtn').addEventListener('click', function () {
                            var m1 = bootstrap.Modal.getInstance(document.getElementById('checkModal'));
                            m1.hide();
                        });

                        // เมื่อ modal1 ปิดแล้ว → เปิด modal2
                    /*     document.getElementById('checkModal').addEventListener('hidden.bs.modal', function () {
                            modal2.show();
                        }); */

                    } else {
                        // modal 2
                        var modal2 = new bootstrap.Modal(document.getElementById('checkModalWaiting'));
                        modal2.show();

                        // ปุ่มปิด modal2
                        document.getElementById('acknowledgeBtnWaiting').addEventListener('click', function () {
                            var m2 = bootstrap.Modal.getInstance(document.getElementById('checkModalWaiting'));
                            m2.hide();
                        });
                    }
                });

            </script>
            
            <div class="ms-6 mr-6" id="protected">
                @if(!empty($pur_report) && $pur_report->purchase_status === 1)

                <div class="grid md:grid-cols-12 grid-cols-1 gap-3 mb-4 items-center">

                    <div class="col-span-3">

                                {{-- <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label> --}}
                    
                            <button id="dropdownDividerButton" data-dropdown-toggle="dropdownDivider" class="bg-green-600 hover:bg-green-700 text-white py-4 w-full !rounded-md" type="button">
                                
                                เลือกวันสั่งซื้อ
                                  
                            </button> 
            
                            <!-- Dropdown menu -->
                            <div id="dropdownDivider" class="z-10 hidden divide-y divide-gray-100 shadow-sm w-44" style="text-align: left;">
            
                                <div class="py-2">
                                    <a href="/portal/customer/purchase/morethan" id="dropdownlist" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-white !no-underline text-center">ไม่สั่งเกิน 7 วัน</a>
                                </div>
                                <div class="py-2">
                                    <a href="/portal/customer/purchase/coming" id="dropdownlist" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-white !no-underline text-center">ใกล้ครบกำหนด</a>
                                </div>
                                <div class="py-2">
                                    <a href="/portal/customer/purchase/normal" id="dropdownlist" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-white !no-underline text-center">สั่งซื้อตามปกติ</a>
                                </div>
                                <div class="py-2">
                                    <a href="/portal/customer/purchase/no-purchase" id="dropdownlist" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-white !no-underline text-center">ไม่มีการสั่งซื้อ</a>
                                </div>
                              
                            </div>

                    </div>

                    <div class="col-span-9">
                          <!--- search --->
                          <form class="py-3" style="width:80%;" method="get" action="/portal/customer">
                            {{-- <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label> --}}
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <!---icon -->
                                </div>
                                <input type="search" id="default-search" name="keyword" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="CODE | ชื่อร้านค้า" />
                                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium !rounded-md text-sm px-4 py-2 my-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ค้นหา</button>
                            
                            </div>
                            {{-- <p class="py-2" id="keyword_search"></p> --}}
                            @csrf   
                        </form>

                        <script>
                            $(document).ready(function() {
                                $('#default-search').keyup(function(e) {
                                    e.preventDefault();  // Prevent form from submitting

                                    $.ajax({
                                        url: '/portal/customer/search/code',
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
                    </div>
                
                 
                
                </div>
                @else

                <div style="display: flex; justify-content: center;">
                    <!--- search --->
                    <form class="py-3" style="width:80%;" method="get" action="/portal/customer">
                      {{-- <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label> --}}
                      <div class="relative">
                          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                          <!---icon -->
                          </div>
                          <input type="search" id="default-search" name="keyword" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="CODE | ชื่อร้านค้า" />
                          <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium !rounded-md text-sm px-4 py-2 my-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ค้นหา</button>
                      
                      </div>
                      @csrf   
                  </form>

                  <script>
                        $(document).ready(function() {
                            $('#default-search').keyup(function(e) {
                                e.preventDefault();  // Prevent form from submitting

                                $.ajax({
                                    url: '/portal/customer/search/code',
                                    method: 'GET',
                                    data: {
                                        keyword: $(this).val(),

                                    },
                                    catch:false,
                                    success: function(data) {
                                        
                                       // $('#keyword_search').html(data);

                                    }
                                });
                            /*  let keyword = $(this).val();
                                console.log(keyword ); */
                            });
                        });
                    </script>
                </div>
                @endif

        <hr class="my-1" style="color: #8E8E8E; width: 100%;">

        <div class="overflow-x-auto">
        <table class="table table-striped">
            <thead>
              <tr>
                <td scope="col" class="!text-gray-500 text-left p-3 font-medium">#</td>
                <td scope="col" class="!text-gray-500 text-center p-3 font-medium">CODE</td>
                <td scope="col" class="!text-gray-500 text-left p-3 font-medium">อีเมล</td>
                <td scope="col" class="!text-gray-500 text-center p-3 font-medium">เขตการขาย</td>
                <td scope="col" class="!text-gray-500 text-left p-3 font-medium">ชื่อร้านค้า</td>
                <td scope="col" class="!text-gray-500 text-center p-3 font-medium">สถานะ</td>
                @if(!empty($pur_report) && $pur_report->purchase_status === 1)
                    <td scope="col" class="!text-gray-500 text-center p-3 font-medium">การสั่งซื้อ</td>
                @endif
                {{-- <td scope="col" class="!text-gray-500 text-left p-3 font-medium">วันที่ลงทะเบียน</td> --}}
                <td scope="col" class="!text-gray-500 text-left p-3 font-medium">จัดการ</td>
              </tr>
            </thead>
            <tbody>

        @if(!empty($customer_list)) <!-- ปิดลูกค้าทั้งหมด !empty = เปิด -->
                <?php 
                    $start += 1;
                ?>
                @foreach ($customer_list as $row_list)
              <tr>
                    <?php
                        
                        $id = $row_list->id;
                        $customer_name = $row_list->customer_name;
                        $customer_code = $row_list->customer_code;
                        $sale_area = $row_list->sale_area;
                        $status_admin = $row_list->sale_area;
                        $email = $row_list->email;
                        $status = $row_list->status;
                        $created_at = $row_list->created_at;
                        $customer_status = $row_list->customer_status;
                        $slug = $row_list?->slug;
                    ?>
                
                @if($customer_status == 'active')
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$start++}}</td>
                    <td scope="row" class="text-gray-400 text-center px-3 py-4 !text-gray-500">{{$customer_code}}</td>
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$email}}</td>
                    <td scope="row" class="text-gray-400 text-center px-3 py-4 !text-gray-500">{{$sale_area}}</td>
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$customer_name}}</td>
                    <td class="text-center px-3 py-4 w-full md:w-1/5">
                        @if ($status == 'รอดำเนินการ')
                        <span class="inline-block border-2 border-red-400 text-red-400 px-3 py-2 rounded-lg text-sm">
                            รอดำเนินการ
                        </span>
                
                        @elseif ($status == 'ต้องดำเนินการ')
                            <span class="inline-block border-2 border-amber-400 text-amber-400 px-3 py-2 rounded-lg text-sm">
                                ต้องดำเนินการ
                            </span>
                    
                        @else ($status == 'ดำเนินการแล้ว')
                            <span class="inline-block border-2 border-green-500 text-green-500 px-3 py-2 rounded-lg text-sm">
                                ดำเนินการแล้ว
                            </span>
                        @endif
                    </td>
                    @if(!empty($pur_report) && $pur_report->purchase_status === 1)

                            @if(!empty($check_id))
                            @php 
                            $id_purchase = $check_id->firstWhere('customer_id', $customer_code)?->customer_id;
                            @endphp

                            @if ($id_purchase == $customer_code)

                            @php 
                            $item = $check_purchase->firstWhere('customer_id', $customer_code);
                            @endphp
                            
                                @if ($item)
                                    @php
                                        $check_over_5 = \Carbon\Carbon::parse($item->date_purchase)->addDays(5)->lessThan(now());
                                        $check_over_7 = \Carbon\Carbon::parse($item->date_purchase)->addDays(7)->lessThan(now());
                                    @endphp
                                
                                    <td scope="row" class="text-gray-400 text-center px-3 py-4 !text-gray-500">
                                        @if ($check_over_7)
                                        <span id="less{{ $customer_code }}" class="inline-block border-2 border-red-500 text-red-500 px-3 py-2 rounded-lg text-sm cursor-pointer">
                                            ไม่สั่งเกิน 7 วัน
                                        </span>
                                        
                                        <div class="modal fade" id="staticBackdrop_normal{{ $customer_code }}" style="margin-top:40px;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <span class="modal-title" id="staticBackdropLabel">ร้านค้า : {{ $customer_code }} | {{ $customer_name }}</span>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    
                                                    <div class="modal-body">
                                                        <div class="mb-2" style="text-align: left;">
                                                            เลขที่: <span id="order-number{{ $customer_code }}"></span> |
                                                            <span style="background-color: #e04b30; color:white; border-radius:5px; padding:3px;" id="date-number{{ $customer_code }}"></span>
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
                                                                <tbody id="result-area{{ $customer_code }}">
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
                                            <span id="less{{ $customer_code }}" class="inline-block border-2 border-yellow-500 text-yellow-500 px-3 py-2 rounded-lg text-sm cursor-pointer">
                                                ใกล้ครบกำหนด
                                            </span>

                                            <div class="modal fade" style="margin-top:40px;" id="staticBackdrop_normal{{ $customer_code }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <span class="modal-title" id="staticBackdropLabel">ร้านค้า : {{ $customer_code }} | {{ $customer_name }}</span>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        
                                                        <div class="modal-body">
                                                            <div class="mb-2" style="text-align: left;">
                                                                เลขที่: <span id="order-number{{ $customer_code }}"></span> |
                                                                <span style="background-color: #ffa51d; color:white; border-radius:5px; padding:3px;" id="date-number{{ $customer_code }}"></span>
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
                                                                    <tbody id="result-area{{ $customer_code }}">
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

                                            <span id="less{{ $customer_code }}" class="inline-block border-2 border-green-500 text-green-500 px-3 py-2 rounded-lg text-sm cursor-pointer">
                                                สั่งซื้อตามปกติ
                                            </span>

                                            <div class="modal fade" style="margin-top:40px;" id="staticBackdrop_normal{{ $customer_code }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <span class="modal-title" id="staticBackdropLabel">ร้านค้า : {{ $customer_code }} | {{ $customer_name }}</span>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        
                                                        <div class="modal-body">
                                                            <div class="mb-2" style="text-align: left;">
                                                                เลขที่: <span id="order-number{{ $customer_code }}"></span> |
                                                                <span style="background-color: #09be0f; color:white; border-radius:5px; padding:3px;" id="date-number{{ $customer_code }}"></span>
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
                                                                    <tbody id="result-area{{ $customer_code }}">
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
                                    const use_id = "{{ $customer_code }}";
                                    const modalId = '#staticBackdrop_normal{{ $customer_code }}';
                            
                                    $('#less{{ $customer_code }}').click(function(e) {
                                        e.preventDefault();
                            
                                        fetch('/portal/customer/purchase', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({ use_id: use_id })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            const resultArea  = document.getElementById('result-area{{ $customer_code }}');
                                            const orderNumber = document.getElementById('order-number{{ $customer_code }}');
                                            const datePur     = document.getElementById('date-number{{ $customer_code }}');
                            
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
                                            const resultArea = document.getElementById('result-area{{ $customer_code }}');
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
                    @endif
                    {{-- <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$created_at}}</td> --}}

                    @php
                        $dis_check =  $check_edit;
                        $dis_check = $dis_check > 0;
                    @endphp
                    {{-- <td scope="row" style="color:#9C9C9C; text-align: center; padding:15px;"><a href="/portal/customer/{{$id}}" id="edit"><i class="fa-regular fa-eye"></i></a> --}}
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">
                        <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                            <a href="{{ $dis_check ? 'javascript:void(0)' : '/portal/customer/'.$slug }}"
                                id="edit"
                                class="{{ $dis_check ? 'disabled-link' : '' }}">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                        </div>
                    </td>
                    
                    {{-- <button id="trash"><i class="fa-regular fa-trash-can"></i></button> --}}

                @endif
              </tr>
    
              @endforeach

        @else
        <tr>
            <td colspan="8" class="text-gray-400 text-center px-3 py-4 !text-gray-500">
                ไม่พบการค้นหา
            </td>
        </tr>
        @endif
        

            </tbody>
          </table>
        </div>

          @if($total_page > 1) <!-- ปิดลูกค้าทั้งหมด น้อยกว่า 1 -->
          <nav aria-label="Page navigation example">
            <ul class="pagination py-4">
            <li class="page-item">

            @if ($page == 1)
                <a class="page-link" href="/portal/customer?page=<?=1 ; ?>" aria-label="Previous">
                <span aria-hidden="true">Previous</span>
                </a>
            @else
                <a class="page-link" href="/portal/customer?page=<?= $page-1 ; ?>" aria-label="Previous">
                <span aria-hidden="true">Previous</span>
                </a>
            @endif
            </li>

            @if($total_page > 14)

                @for ($i= 1; $i <= 10 ; $i++)
                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/portal/customer?page={{ $i }}">{{ $i }}</a></li>
                @endfor
                <li class="page-item"><a class="page-link">...</a></li>
                @for ($i= $total_page-1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/portal/customer?page={{ $i }}">{{ $i }}</a></li>
                @endfor

            @else
                @for ($i= 1; $i <= $total_page ; $i++)
                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/portal/customer?page={{ $i }}">{{ $i }}</a></li>
                @endfor
            
            @endif

            <li class="page-item">
            
            @if ($page == $total_page)
                <a class="page-link" href="/portal/customer?page={{ $page }}" aria-label="Next">
                <span aria-hidden="true">next</span>
                </a>
            @else
                <a class="page-link" href="/portal/customer?page={{ $page + 1 }}" aria-label="Next">
                <span aria-hidden="true">next</span>
                </a>
            @endif
            </li>
            </ul>
        </nav>
        @else
        
        @endif

    </div>

    <script>
            $(document).ready(function () {

                $("#reports").click(function () {
                    console.log("Report");
                    $(this).next('.sub-menus').slideToggle();
                    $(this).find('.dropdown').toggleClass('rotate');
                    $(this).toggleClass("submenu"); // toggle เปิดปิดแถบสีเมนู;
                    // $('.sub-menus').css("background-color", "black", "text-align", "left");
                

                });
            
            });

    </script>
@endsection
@push('styles')
<style>
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
    #protected {
    position: relative;
    }

    #protected::after {
                content: "© cms.vmdrug";
                position: fixed; /* เปลี่ยนจาก absolute → fixed */
                top: 50%;
                left: 50%;
                font-size: 120px;
                color: rgba(170, 170, 170, 0.111);
                pointer-events: none;
                padding-top: 30px;
                /* transform: translate(-50%, -50%) rotate(-45deg); */
                transform: translate(-50%, -50%);
                white-space: nowrap;
                z-index: 9999; /* กันโดนซ่อนโดย content อื่น */
    }
    .disabled-link {
        pointer-events: none;   /* กดไม่ได้ */
        opacity: 0.4;           /* ทำให้ปุ่มจางลง */
        cursor: not-allowed;    /* เมาส์เป็นรูปห้าม */
        text-decoration: none;  /* เอาเส้นใต้ลิงก์ออก (ถ้าอยากให้ดูเหมือนปุ่ม) */
    }
    .modal-body {
    max-height: 60vh;
    overflow-y: auto;
    }
</style>
@endpush
