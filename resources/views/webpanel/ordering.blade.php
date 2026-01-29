<!DOCTYPE html>
<html lang="en">
    @section ('title', 'customer')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script> --}}
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
    {{-- <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>CMS VMDRUG System</title>
</head>
<body>

    @extends ('webpanel/menuwebpanel-tailwind')
    @section('content')
    @csrf


    <style>
        .contentArea {
            /* padding: 10px; */
            background-color: #FFFFFF;
            border-radius: 2px;
            min-width: 1500px;
            /* text-align: left; */
        }
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

            .duplicate-highlight {
                animation: flash 1s ease-in-out 0s 3;
                background-color: #fff3cd !important;
            }
            @keyframes flash {
                0% { background-color: #fff3cd; }
                50% { background-color: #ffe8a1; }
                100% { background-color: #fff3cd; }
            }



    </style>
    
       {{--  @if($user_id_admin == '0000')
            @section('profile_img')
            <img class="w-8 h-8 rounded-full me-3" src="/profile/profiles-2 copy.jpg" alt="user photo">
            @endsection
        @else
            @section('profile_img')
            <img class="w-8 h-8 rounded-full me-3" src="/profile/user.png" alt="user photo">
            @endsection
        @endif

        @section('status_alert')
        <h6 class="justifiy-content:center;" style="">{{number_format($status_alert)}}</h6>
        @endsection

        @section('status_waiting')
        <h6 class="justifiy-content:center;" style="">{{number_format($status_waiting)}}</h6>
        @endsection

        @section('status_registration')
        <h6 class="justifiy-content:center;" style="">{{number_format($status_registration)}}</h6>
        @endsection

        @section('status_updated')
        <h6 class="justifiy-content:center;" style="">{{$status_updated}}</h6>
        @endsection

        @section('text_alert')
        <h6 class="justifiy-content:center; mt-2 ms-4 mr-6" style="background-color:#cb4d4d; border-radius:20px; padding: 5px; color:#ffffff; font-weight:500;">{{$status_updated}}</h6>
        @endsection --}}
        {{-- <img src="{{ url('/') }}/storage/certificates/img_certstore/1dcV3LQvU5DbAW2hVAMAwHyYLLng85K9aGq4TX47.jpg"> --}}

        {{-- {{$_SERVER['REMOTE_ADDR'];}} --}}

    


    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2">
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}
        </div>
        <span class="ms-6" style="color: #8E8E8E;">รับสั่งสินค้า (Ordering)</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

  {{--       <div class="ms-6" style="text-align: left;">

            <a href="/webpanel/report/count-pur/exportcsv/check?from={{ request('from') }}&to={{ request('to') }}"  id="exportcsv" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export CSV</a>
            <a href="/webpanel/report/count-pur/exportexcel/check?from={{ request('from') }}&to={{ request('to') }}"  id="exportexcel" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export Excel</a>
    
        </div> --}}

        <div class="ms-6 mt-6" style="text-align: left;">
            <h2 class="text-xl font-bold mb-4">รับสั่งสินค้า (Ordering)</h2>
        </div>
        <hr class="" style="color: #8E8E8E; width: 90%;">
        <!-- Alpine v3 -->
        <div class="p-6">
            {{-- <h2 class="text-2xl font-bold mb-4">เลือก Customer</h2> --}}
        
            <!-- Customer Search -->
            <div class="mb-4 relative w-96 ms-6">
                <label class="font-bold block mb-2">ค้นหาชื่อร้านค้า:</label>
                <input type="text" id="customerSearch" class="border p-2 rounded w-full" placeholder="พิมพ์ชื่อร้านค้า...">
                <div id="customerDropdown" class="absolute bg-white border w-full shadow rounded z-10 max-h-48 overflow-auto hidden"></div>
            </div>
        
            <!-- ข้อมูลร้านค้าที่เลือก -->
            <div class="mb-4 ms-8">
                <p class="py-2">
                    <strong class="text-gray-600 font-[500]">รหัสร้านค้า :</strong> 
                    <span id="customerCode">-</span>
                  </p>
                  <p class="py-2">
                    <strong class="text-gray-600 font-[500]">ชื่อร้านค้า :</strong> 
                    <span id="customerName">-</span>
                  </p>
                  <p class="py-2">
                    <strong class="text-gray-600 font-[500]">จังหวัด :</strong> 
                    <span id="customerProvince">-</span>
                  </p>
                  <p class="py-2">
                    <strong class="text-gray-600 font-[500]">ระดับราคา :</strong> 
                    <span id="customerPriceLevel">-</span>
                  </p>
                  
                  <script>
                  fetch('/purchase/ordering/latest-draft-po') // endpoint ของ controller
                      .then(res => res.json())
                      .then(res => {
                          if(res.success){
                              document.getElementById('customerCode').textContent = res.customerCode;
                              document.getElementById('customerName').textContent = res.customerName;
                              document.getElementById('customerProvince').textContent = res.customerProvince;
                              document.getElementById('customerPriceLevel').textContent = res.customerPriceLevel;
                          }
                      });
                  </script>
                  
            </div>
        
            {{-- <h2 class="text-2xl font-bold mb-4">คีย์สินค้า</h2> --}}
        
            <!-- เลข PO -->
      {{--       <div class="mb-4">
                <label class="font-bold">เลข PO:</label>
                <input id="poNumber" class="border p-2 rounded w-48" readonly>
            </div> --}}
        
            <!-- ตารางสินค้า -->
            <table class="w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">ค้นหา</th>
                        <th class="p-2 border">รหัส</th>
                        <th class="p-2 border">ชื่อสินค้า</th>
                        <th class="p-2 border">หน่วย</th>
                        <th class="p-2 border">ราคาต่อหน่วย</th>
                        <th class="p-2 border">จำนวน</th>
                        <th class="p-2 border">ราคารวม</th>
                        <th class="p-2 border">หมายเหตุ</th>
                        <th class="p-2 border">จอง</th>
                        <th class="p-2 border">ลบ</th>
                    </tr>
                </thead>
                <tbody id="rows"></tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="p-2 text-right font-bold">ยอดรวม</td>
                        <td class="p-2 border text-right font-bold" id="totalAmount">0</td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
            </table>
        
            <div class="mt-4">
                <button id="saveBtn" class="bg-blue-600 text-white px-4 py-2 rounded">บันทึกใบสั่งซื้อ</button>
            </div>
        </div>

        <script>
            window.EDIT_MODE = {{ isset($orderId) && $orderId ? 'true' : 'false' }};
            window.INIT_ORDER_ID = "{{ $orderId ?? '' }}";
            window.INIT_CUSTOMER_CODE = "{{ $customerCode ?? '' }}";
            window.INIT_ITEMS = {!! json_encode($items ?? []) !!};
        </script>
        
        
        <script>
            
                document.addEventListener("DOMContentLoaded", () => {
                
                    // let selectedCustomerCode = null;
                    let selectedCustomerCode = window.INIT_CUSTOMER_CODE || null;
                    let selectedPriceLevel = null;
                    // let currentOrderId = null;
                    let currentOrderId = window.INIT_ORDER_ID || null;
                    let poOrderName = null;
                    let customerList = [];
                    let selectedCustomerIndex = -1;
                
                    const customerSearch = document.getElementById("customerSearch");
                    const customerDropdown = document.getElementById("customerDropdown");
                    const customerCode = document.getElementById("customerCode");
                    const customerName = document.getElementById("customerName");
                    const customerProvince = document.getElementById("customerProvince");
                    const customerPriceLevel = document.getElementById("customerPriceLevel");
                    const rowsContainer = document.getElementById("rows");
                    const totalAmount = document.getElementById("totalAmount");
                    const saveBtn = document.getElementById("saveBtn");
                
                    // -------------------
                    // เลือกลูกค้า
                    // -------------------
                    customerSearch.addEventListener("input", () => {
                        const q = customerSearch.value.trim();
                        if (!q) return customerDropdown.classList.add("hidden");
                
                        fetch(`/purchase/ordering/customer?q=${encodeURIComponent(q)}`)
                        .then(r => r.json())
                        .then(list => {
                            customerList = list;
                            selectedCustomerIndex = -1;
                            customerDropdown.innerHTML = "";
                
                            list.forEach(c => {
                                const div = document.createElement("div");
                                div.className = "px-2 py-1 cursor-pointer hover:bg-blue-100";
                                div.textContent = `${c.name} ${c.province}`;
                                div.addEventListener("click", () => selectCustomer(c));
                                customerDropdown.appendChild(div);
                            });
                            customerDropdown.classList.remove("hidden");
                        });
                    });
                
                    customerSearch.addEventListener("keydown", e => {
                        if (customerDropdown.classList.contains("hidden") || !customerList.length) return;
                        if (e.key === "ArrowDown") { e.preventDefault(); selectedCustomerIndex = (selectedCustomerIndex + 1) % customerList.length; highlightCustomer(); }
                        if (e.key === "ArrowUp")   { e.preventDefault(); selectedCustomerIndex = (selectedCustomerIndex - 1 + customerList.length) % customerList.length; highlightCustomer(); }
                        if (e.key === "Enter")     { e.preventDefault(); if(customerList[selectedCustomerIndex]) selectCustomer(customerList[selectedCustomerIndex]); }
                    });
                
                    function highlightCustomer() {
                        [...customerDropdown.children].forEach((div,i) => div.classList.toggle("bg-blue-200", i === selectedCustomerIndex));
                        const active = customerDropdown.children[selectedCustomerIndex];
                        if(active) active.scrollIntoView({block:"nearest"});
                    }
                
                    function selectCustomer(c) {
                        selectedCustomerCode = c.customer_code;
                        selectedPriceLevel = c.price_level;

                        customerCode.textContent = c.customer_code;
                        customerName.textContent = c.name;
                        customerProvince.textContent = c.province;
                        customerPriceLevel.textContent = c.price_level;

                        customerDropdown.classList.add("hidden");
                        customerSearch.value = "";

                        rowsContainer.innerHTML = "";

                        //edit mode → ห้ามสร้าง draft ใหม่
                        if (currentOrderId || window.EDIT_MODE) {
                            return;
                        }

                        //create เฉพาะหน้า create
                        fetch('/purchase/ordering/create-draft', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ customer_id: c.customer_code })
                        })
                        .then(r => r.json())
                        .then(res => {
                            currentOrderId = res.order_id;
                            createRow(); // สร้าง row แรกหลังมี order_id เท่านั้น
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire("ไม่สามารถสร้าง draft order", "", "error");
                        });
                    }


                
                    document.addEventListener("click", e => {
                        if(!customerDropdown.contains(e.target) && e.target !== customerSearch) {
                            customerDropdown.classList.add("hidden");
                        }
                    });

                
                    // -------------------
                    // สร้าง row
                    // -------------------
                    function createRow(data = null) {
                        const tr = document.createElement("tr");

                        if (data?.product_code) {
                            tr.dataset.productCode = data.product_code;
                            tr.dataset.rowKey = data.product_code;
                        }

                        tr.innerHTML = `
                            <td class="p-2 border relative">
                                <input class="searchInput w-full border rounded p-1" placeholder="รหัสสินค้า/ชื่อสินค้า">
                                <div class="dropdown absolute bg-white border w-full shadow rounded z-10 max-h-44 overflow-auto hidden"></div>
                            </td>
                            <td class="p-2 border code"></td>
                            <td class="p-2 border name"></td>
                            <td class="p-2 border unit"></td>
                            <td class="p-2 border text-right"><span class="unitPrice"></span></td>
                            <td class="p-2 border"><input type="number" class="qtyInput w-20 border rounded p-1" value="1"></td>
                            <td class="p-2 border"><input type="number" class="priceTotal w-24 border rounded p-1 text-right"></td>
                            <td class="p-2 border"><input class="noteInput w-full border rounded p-1"></td>
                            <td class="text-center border"><input type="checkbox" class="reserveInput"></td>
                            <td class="text-center border"><button class="deleteRow bg-red-500 text-white px-3 py-1 rounded">ลบ</button></td>
                        `;

                        rowsContainer.appendChild(tr);
                        attachRowEvents(tr, data);

                        if (data?.product_code || data?.code) {
                 
                            tr.dataset.productCode = data.product_code ?? data.code;
                            tr.dataset.rowKey = data.product_code ?? data.code;
                            
                            tr.querySelector(".code").textContent = data.code ?? data.product_code ?? '';


                            tr.querySelector(".name").textContent = data.name;
                            tr.querySelector(".unit").textContent = data.unit;
                            // tr.querySelector(".unitPrice").textContent = data.price;
                            tr.querySelector(".unitPrice").textContent = Number(data.price).toLocaleString();
                            tr.querySelector(".qtyInput").value = data.qty;
                            // tr.querySelector(".priceTotal").value = data.total_price;
                            tr.querySelector(".priceTotal").value = Number(data.total_price).toFixed(2);
                            tr.querySelector(".noteInput").value = data.remark ?? "";
                            tr.querySelector(".reserveInput").checked = data.reserve ?? false;

                            updateTotal();

                        }

                        return tr;
                    }

                    function attachRowEvents(tr) {
                        const search = tr.querySelector(".searchInput");
                        const dropdown = tr.querySelector(".dropdown");
                        const qty = tr.querySelector('.qtyInput');
                        const unitPriceEl = tr.querySelector('.unitPrice');
                        const totalPriceInput = tr.querySelector('.priceTotal');
                        const note = tr.querySelector(".noteInput");
                        const reserve = tr.querySelector(".reserveInput");
                        const deleteBtn = tr.querySelector(".deleteRow");
                        const unitCell = tr.querySelector(".unit");
                
                        // let unitPrice = 0;
                        let selectedIndex = -1;
                
                        // -------------------
                        // ค้นหาสินค้า
                        // -------------------
                        search.addEventListener("input", () => {
                            const q = search.value.trim();
                            if(!selectedCustomerCode) { search.value=''; dropdown.classList.add('hidden'); Swal.fire("กรุณาเลือกลูกค้าก่อน","","warning"); return; }
                            if(!q) return dropdown.classList.add("hidden");
                
                            fetch(`/purchase/ordering/product-search?q=${encodeURIComponent(q)}&code=${encodeURIComponent(selectedCustomerCode)}`)
                            .then(r=>r.json())
                            .then(list=>{
                                dropdown.innerHTML='';
                                dropdown.classList.remove('hidden');
                                dropdown.dataset.items = JSON.stringify(list);
                                list.forEach(p=>{
                                    const div=document.createElement('div');
                                    div.className='px-2 py-1 cursor-pointer hover:bg-blue-100';
                                   /*  div.textContent=`${p.product_id} - ${p.product_name} - ${p.price.toLocaleString()}`;
                                    div.addEventListener('click',()=>chooseProduct(p)); */

                                    div.textContent=`${p.product_id} - ${p.product_name} - ${p.price.toLocaleString()}`;
                                    div.addEventListener('click',()=>chooseProduct(p, tr));

                                    dropdown.appendChild(div);
                                });
                            }).catch(err=>{ console.error(err); dropdown.classList.add('hidden'); });
                        });
                
                        search.addEventListener("keydown", e => {
                            const items = JSON.parse(dropdown.dataset.items || "[]"); // ใช้ dropdown.dataset.items
                            if(dropdown.classList.contains('hidden') || !items.length) return;

                            if(e.key === 'ArrowDown'){ 
                                e.preventDefault(); 
                                selectedIndex = (selectedIndex + 1) % items.length; 
                                highlight(); 
                            }
                            if(e.key === 'ArrowUp'){ 
                                e.preventDefault(); 
                                selectedIndex = (selectedIndex - 1 + items.length) % items.length; 
                                highlight(); 
                            }
                            if(e.key === 'Enter'){ 
                                e.preventDefault(); 
                                if(items[selectedIndex]) chooseProduct(items[selectedIndex], tr); 
                            }
                        });

                
                        function highlight(){
                            [...dropdown.children].forEach((div,i)=> div.classList.toggle('bg-blue-200', i===selectedIndex));
                            const active = dropdown.children[selectedIndex];
                            if(active) active.scrollIntoView({block:"nearest"});
                        }

                        async function chooseProduct(p, tr){
                            // เช็กสินค้าซ้ำใน table
                            const existRow = [...rowsContainer.children].find(r => r.dataset.productCode === p.product_id);
                            if(existRow){
                                Swal.fire('สินค้าซ้ำ', 'สินค้านี้มีอยู่ใน draft แล้ว', 'warning');
                                existRow.classList.add('bg-yellow-200');
                                setTimeout(() => existRow.classList.remove('bg-yellow-200'), 800);
                                existRow.querySelector('.qtyInput').focus();
                                return;
                            }

                            // เช็กสินค้าซ้ำใน draft DB
                            try {
                                const res = await fetch(`/purchase/ordering/check-product?order_id=${currentOrderId}&product_code=${p.product_id}`);
                                const data = await res.json();
                                if(data.exists){
                                    Swal.fire('สินค้าซ้ำ', 'สินค้านี้มีอยู่ใน draft แล้ว (DB)', 'warning');
                                    return;
                                }
                            } catch(err){
                                console.error(err);
                            }

                            // ใส่ข้อมูลลง row
                            tr.dataset.productCode = p.product_id;
                            tr.dataset.rowKey = p.product_id;

                            tr.querySelector('.code').textContent = p.product_id;
                            tr.querySelector('.name').textContent = p.product_name;
                            tr.querySelector('.unit').textContent = p.unit ?? '-';
                            tr.querySelector('.unitPrice').textContent = p.price.toLocaleString();
                            tr.querySelector('.qtyInput').value = 1;

                            search.value = '';
                            dropdown.classList.add('hidden');
                            tr.querySelector('.qtyInput').focus();

                            updateTotal();
                            autoSaveItem();
                        }


                        // -------------------
                        // Enter ข้ามช่อง
                        // -------------------
    
                        search.addEventListener('keydown', e => {
                            // console.log('Key pressed:', e.key);
                            if(e.key === 'Enter'){
                                e.preventDefault();
                                const items = JSON.parse(dropdown.dataset.items || "[]"); 
                                if(selectedIndex >= 0){
                                    // ตรวจสอบ row ปัจจุบัน
                                    let currentRow = tr;
                                    if(!currentRow) currentRow = createRow();
                                    chooseProduct(items[selectedIndex], currentRow);
                                }
                            }
                        });

                        qty.addEventListener('keydown', e => {
                            if (e.key === 'Enter') {
                                e.preventDefault();

                                const qtyVal = parseFloat(qty.value || 0);
                                const unitPrice = parseFloat(
                                    unitPriceEl.textContent.replace(/,/g,'') || 0
                                );

                                totalPriceInput.value = qtyVal * unitPrice; // ⭐ คำนวณจริง

                                totalPriceInput.focus();  // focus input ได้
                                updateTotal();
                                autoSaveItem();
                            }
                        });

                        totalPriceInput.addEventListener('keydown', e => {
                            if(e.key === 'Enter'){
                                e.preventDefault();
                                note.focus();
                                autoSaveItem();
                            }
                        });

                        totalPriceInput.addEventListener('input', () => {
                            updateTotal();
                            autoSaveItem();
                        });


                        note.addEventListener('keydown',e=>{ if(e.key==='Enter'){ e.preventDefault(); reserve.focus(); autoSaveItem(); } });
                        // reserve.addEventListener('keydown',e=>{ if(e.key==='Enter'){ e.preventDefault(); createRow(); } });
                        reserve.addEventListener('keydown', e => {
                            if(e.key === 'Enter'){
                                e.preventDefault();

                                // ตรวจสอบว่าแถวสุดท้ายมีรหัสสินค้าแล้ว
                                const lastRow = rowsContainer.lastElementChild;
                                if(lastRow && lastRow.dataset.productCode){
                                    const newRow = createRow();
                                    newRow.querySelector('.searchInput').focus();
                                }
                            }
                        });


                        reserve.addEventListener('change',()=>{ tr.classList.toggle('bg-green-100', reserve.checked); autoSaveItem(); });
                
                        // deleteBtn.addEventListener('click',()=>{ tr.remove(); if(!rowsContainer.children.length) createRow(); updateTotal(); });
                
                        deleteBtn.addEventListener('click', () => {
                            tr.remove();
                            if(!rowsContainer.children.length) createRow();
                            updateTotal();
                            autoSaveItem();
                        });

                        qty.addEventListener('input',()=>{ updateTotal(); autoSaveItem(); });
             
                    }

                    function maybeAddNewRow() {
                        const lastRow = rowsContainer.lastElementChild;
                        if(lastRow && lastRow.dataset.productCode){
                            createRow();
                        }
                    }

                
                    function updateTotal(){
                        let sum = 0;

                        [...rowsContainer.children].forEach(tr => {
                            const qty = parseFloat(tr.querySelector('.qtyInput')?.value || 0);
                            const unitPrice = parseFloat(
                                tr.querySelector('.unitPrice')?.textContent.replace(/,/g,'') || 0
                            );

                            const rowTotal = qty * unitPrice;

                            const priceTotalInput = tr.querySelector('.priceTotal');
                            if(priceTotalInput){
                                priceTotalInput.value = rowTotal.toFixed(2);
                            }

                            sum += rowTotal;
                        });

                        totalAmount.textContent = sum.toLocaleString();
                    }

                    function autoSaveItem() {
                        //console.log('autosave', currentOrderId);
                        if (!currentOrderId) return;

                        const items = [...rowsContainer.children]
                        .filter(r => r.dataset.productCode && r.dataset.productCode !== 'undefined')
                        .map(r => {
                            const product_name = r.querySelector('.name')?.textContent || '';
                            const unit = r.querySelector('.unit')?.textContent || '';
                            const qty = parseFloat(r.querySelector('.qtyInput')?.value || 0);
                            const unitPrice = parseFloat(r.querySelector('.unitPrice')?.textContent.replace(/,/g,'') || 0);
                            const remark = r.querySelector('.noteInput')?.value || '';
                            const reserve = r.querySelector('.reserveInput')?.checked || false;

                            return {
                                product_code: r.dataset.productCode,
                                product_name,
                                unit,
                                qty,
                                price: unitPrice,
                                total_price: qty * unitPrice,
                                remark,
                                reserve
                            };
                        });


                        fetch('/purchase/ordering/save-item', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                order_id: currentOrderId,
                                items
                            })
                        }).catch(console.error);
                    }
                    // -------------------
                    // Save PO Button
                    // -------------------
                    saveBtn.addEventListener('click', () => {
                        if(!selectedCustomerCode){
                            Swal.fire("เลือกลูกค้าก่อน","","warning"); 
                            return; 
                        }
                        if(!currentOrderId){
                            Swal.fire("ยังไม่มี order_id","","warning"); 
                            return; 
                        }

                        // map ให้ตรงกับ backend + filter เฉพาะ row ที่มี product_code
                        const items = [...rowsContainer.children]
                            .filter(r => r.dataset.productCode && r.dataset.productCode.trim() !== '')
                            .map(r => ({
                                product_code: r.dataset.productCode,
                                product_name: r.querySelector('.name')?.textContent || '',
                                unit: r.querySelector('.unit')?.textContent || '',
                                qty: parseFloat(r.querySelector('.qtyInput')?.value || 0),
                                price: parseFloat(r.querySelector('.unitPrice')?.textContent.replace(/,/g,'') || 0),
                                total_price: parseFloat(r.querySelector('.priceTotal')?.value || 0),
                                remark: r.querySelector('.noteInput')?.value || '',
                                reserve: r.querySelector('.reserveInput')?.checked || false
                            }));

                        if(!items.length){
                            Swal.fire("ยังไม่มีสินค้า","","warning"); 
                            return; 
                        }

                        fetch('/purchase/ordering/save-item', {
                            method: 'POST',
                            headers: {
                                'Content-Type':'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                order_id: currentOrderId,
                                items
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if(data.success){
                                Swal.fire("บันทึกสำเร็จ","","success");
                            } else {
                                Swal.fire("บันทึกไม่สำเร็จ", data.message || "","error");
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire("บันทึกไม่สำเร็จ", err.message || "","error");
                        });
                    });

                    // -------------------
                    // สร้าง row แถวแรก
                    // -------------------
                    // createRow();
                    
                    // -------------------
                    // สร้าง row แถวแรก
                    // -------------------
                    if (window.EDIT_MODE && window.INIT_ITEMS?.length) {
                        rowsContainer.innerHTML = "";
                        window.INIT_ITEMS.forEach(item => createRow(item));
                    } else {
                        // ถ้าไม่มี item ให้สร้างแถวว่าง 1 แถว
                        if (rowsContainer.children.length === 0) {
                            createRow();
                        }
                    }




                });
        </script>
    

        <div class="ms-6">
        </div>
    </div>

</div>
@endsection
</body>
</html>
