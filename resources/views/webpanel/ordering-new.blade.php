@extends('layouts.webpanel')
@section('content')

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6">รับสั่งสินค้า (Ordering)</h5>
        <hr class="my-3 !text-gray-400 !border">

        <!-- Alpine v3 -->
        <div class="grid grid-cols-1 mx-4 px-2 text-gray-500">
            {{-- <h2 class="text-2xl font-bold mb-4">เลือก Customer</h2> --}}
        
            <!-- Customer Search -->
            <div class="mb-2 relative w-full">
                <label class="font-medium block mb-2 text-base">ค้นหาชื่อร้านค้า:</label>
                <input 
                    type="text"
                    id="customerSearch"
                    class="border !border-gray-300 p-2 rounded w-full disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed disabled:opacity-70"
                    placeholder="ชื่อร้านค้า | Code"
                    {{ empty($orderId) ? 'disabled' : '' }}
                >
                <div id="customerDropdown" class="absolute bg-white border w-full shadow rounded z-10 max-h-48 overflow-auto hidden"></div>
            </div>

            @if(empty($orderId))
            <span class="text-green-500 mb-4 font-medium">หมายเหตุ: คุณได้เลือกร้านค้าแล้ว</span>
            @else
            <span class="text-red-500 mb-4 font-medium">หมายเหตุ: กรุณาเลือกร้านค้าก่อน</span>
            @endif

            <div class="bg-yellow-200 rounded-md mb-4 border-[2px] border-yellow-400 p-4">
                <h4 class="text-lg font-semibold !text-gray-800 mb-3">
                    ข้อมูลร้านค้า
                </h4>
            
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            
                    <!-- LEFT -->
                    <div class="space-y-2">
                        <div>
                            <p class="text-base text-gray-800 font-medium mb-1">รหัสร้านค้า</p>
                            <div id="customerCode"
                                 class="px-4 py-2 bg-yellow-50 border-[2px] border-yellow-400 rounded-lg text-gray-600 font-medium">
                                -
                            </div>
                        </div>
            
                        <div>
                            <p class="text-base text-gray-800 font-medium mb-1">ระดับราคา</p>
                            <div id="customerPriceLevel"
                                 class="px-4 py-2 bg-yellow-50 border-[2px] border-yellow-400 rounded-lg text-gray-600 font-medium">
                                -
                            </div>
                        </div>
            
                        <div>
                            <p class="text-base text-gray-800 font-medium mb-1">เครดิต</p>
                            <div
                                 class="px-4 py-2 bg-yellow-50 border-[2px] border-yellow-400 rounded-lg text-gray-600 font-medium">
                                -
                            </div>
                        </div>
                    </div>
            
                    <!-- RIGHT -->
                    <div class="space-y-2">
                        <div>
                            <p class="text-base text-gray-800 font-medium mb-1">ชื่อร้านค้า</p>
                            <div id="customerName"
                                 class="px-4 py-2 bg-yellow-50 border-[2px] border-yellow-400 rounded-lg text-gray-600 font-medium">
                                -
                            </div>
                        </div>
            
                        <div>
                            <p class="text-base text-gray-800 font-medium mb-1">สายส่ง</p>
                            <div
                                 class="px-4 py-2 bg-yellow-50 border-[2px] border-yellow-400 rounded-lg text-gray-600 font-medium">
                                -
                            </div>
                        </div>
            
                        <div>
                            <p class="text-base text-gray-800 font-medium mb-1">ที่อยู่จัดส่ง</p>
                            <div id="customerAddress"
                                 class="px-4 py-2 bg-yellow-50 border-[2px] border-yellow-400 rounded-lg text-gray-600 font-medium">
                                -
                            </div>
                        </div>
                    </div>
            
                </div>
            </div>

            <div class="my-2 relative w-full">
                <label class="font-medium block mb-2 text-base">ค้นหาชื่อสินค้า:</label>

                <input type="text"
                    id="searchProduct"
                    class="border border-gray-300 p-2 rounded w-full focus:color-red
                    focus:outline-none 
                    focus:ring-2
                    focus:ring-yellow-400 
                    focus:bg-yellow-50"
                    placeholder="รหัสสินค้า | ชื่อสินค้า">

                <div id="productDropdown"
                    class="absolute bg-white border w-full shadow rounded z-10 max-h-48 overflow-auto hidden">
                </div>
            </div>

            <!-- ตารางสินค้า -->
            <div class="mt-2 overflow-x-auto max-h-[400px] overflow-y-auto">
                <table class="w-full border mt-2" id="productTable">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border text-center">#</th>
                            <th class="p-2 border text-center">รหัสสินค้า</th>
                            <th class="p-2 border text-center">ชื่อสินค้า</th>
                            <th class="p-2 border text-center">หน่วย</th>
                            <th class="p-2 border text-center">ราคาต่อหน่วย</th>
                            <th class="p-2 border text-center">จำนวน</th>
                            <th class="p-2 border text-center">ราคารวม</th>
                            <th class="p-2 border text-center">จอง</th>
                            <th class="p-2 border text-center">ลบ</th>
                        </tr>
                    </thead>
                
                    <tbody id="productTableBody">
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="6" class="p-2 text-center font-bold">ยอดรวม</td>
                            <td class="p-2 border text-center font-bold" id="totalAmount">0.00</td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
       @php
           $countOrder = 1;
       @endphp
            <div class="flex gap-2">
                <button 
                    id="btnSaveProduct"
                    class="text-white px-3 py-2 !rounded-md mt-4 btn-save bg-blue-300 cursor-not-allowed"
                    data-order-id="{{ $orderId }}"
                    disabled
                >
                    บันทึกออเดอร์
                </button>

                <button 
                    id="btnCancelledProduct"
                    class="text-white px-3 py-2 !rounded-md mt-4 btn-cancelled bg-red-300 cursor-not-allowed"
                    data-order-id="{{ $orderId }}"
                    disabled
                >
                    ยกเลิกออเดอร์
                </button>
            </div>
            <hr>
            <span class="block mb-3 font-bold text-red-500">หมายเหตุ: หากกดบันทึกหรือยกเลิกออเดอร์แล้ว จะไม่สามารถกลับไปแก้ไขได้ กรุณาตรวจสอบข้อมูลก่อน</span>
            <!-- view item -->
            <div id="itemView"
                class="fixed inset-0 bg-black/50 flex items-center justify-center
                opacity-0 pointer-events-none transition duration-300">

                <div id="modalContent"
                    class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden
                    transform -translate-y-20 opacity-0
                    transition-all duration-400 ease-out">
            
                    <div class="bg-gray-800 text-white px-4 py-3">
                        <span class="block text-xl text-center mt-2">รายละเอียดสินค้า</span>
                    </div>
        
                    <!-- Product -->
                    <div class="mx-4 mt-3 mb-4">
                        <div class="mb-3">
                            <label class="text-base text-gray-500 font-medium mb-1">รหัสสินค้า</label>
                            <input type="text" id="item_product_id"
                                class="w-full border p-2 rounded-lg bg-gray-100 text-gray-400" disabled>
                        </div>
                
                        <div class="mb-3">
                            <label class="text-base text-gray-500 font-medium mb-1">ชื่อสินค้า</label>
                            <input type="text" id="item_product_name"
                                class="w-full border p-2 rounded-lg bg-gray-100 text-gray-400" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="text-base text-gray-500 font-medium mb-1">ชื่อสามัญทางยา</label>
                            <input type="text" id="item_generic_name"
                                class="w-full border p-2 rounded-lg bg-gray-100 text-gray-400" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="text-base text-gray-500 font-medium mb-1">ข้อบ่งใช้</label>
                            <input type="text" id="item_category"
                                class="w-full border p-2 rounded-lg bg-gray-100 text-gray-400" disabled>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="mb-3">
                                <label class="text-base text-gray-500 font-medium mb-1">สต๊อก</label>
                                <input type="text" id="item_stock_qty"
                                    class="w-full border p-2 rounded-lg bg-gray-100 text-gray-400" disabled>
                            </div>
            
                            <div class="mb-3">
                                <label class="text-base text-gray-500 font-medium mb-1">หน่วยสินค้า</label>
                                <input type="text" id="item_unit"
                                    class="w-full border p-2 rounded-lg bg-gray-100 text-gray-400" disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="text-base text-gray-500 font-medium mb-1">หมายเหตุ</label>
                            <input type="text" id=""
                                class="w-full border p-2 rounded-lg bg-gray-100 text-gray-400" disabled>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-2 mt-3">
                            <button onclick="closeModal()"
                                class="px-4 py-2 bg-red-400 text-white !rounded-md hover:bg-red-500">
                               ปิด
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>

            document.addEventListener('DOMContentLoaded', () => {

                const input = document.getElementById('searchProduct');
                const productDropdown = document.getElementById('productDropdown');
                const tableBody = document.getElementById('productTableBody');
                const totalEl = document.getElementById('totalAmount');
                const saveBtn = document.getElementById('saveBtn');
            
                let timeout;
                let customerId = '';
                let orderId = null;
                let itemDrafts = [];
                let saveTimeout;
            
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.btn-view')) {
                        const btn = e.target.closest('.btn-view');
                        const id = btn.dataset.id;
                        const name = btn.dataset.name;

                        modalItem(id, name);
                    }

                    if (e.target.closest('.btn-save')) {
                        const btnS = e.target.closest('.btn-save');
                        const id = btnS.dataset.orderId;

                        saveOrdering(id);
                    }
                });

                //แสดงปุ่ม btnsave
                function btnCountOrder(countOrder) {
                    // console.log(countOrder);
                    const btnSaveP = document.getElementById('btnSaveProduct');
                    const btnCancelled = document.getElementById('btnCancelledProduct');
                    // console.log(btn);
                    if (!btnSaveP || !btnCancelled) return;
                    
                    // console.log(btnCancelled);

                    if (countOrder > 0) {
                        btnSaveP.disabled = false;
                        btnSaveP.classList.remove('bg-blue-300', 'cursor-not-allowed');
                        btnSaveP.classList.add('bg-blue-500', 'hover:bg-blue-600');

                        btnCancelled.disabled = false;
                        btnCancelled.classList.remove('bg-red-300', 'cursor-not-allowed');
                        btnCancelled.classList.add('bg-red-400', 'hover:bg-red-500');

                    } else {
                        btnSaveP.disabled = true;
                        btnSaveP.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                        btnSaveP.classList.add('bg-blue-300', 'cursor-not-allowed');

                        btnCancelled.disabled = true;
                        btnCancelled.classList.add('bg-red-300', 'cursor-not-allowed');
                        btnCancelled.classList.remove('bg-red-400', 'hover:bg-red-500');
                    }
                }
                //เช็กจำนวน ให้ปุ่มบันทึกทำงาน
                fetch(`{{ route('webpanel.ordering.count.order') }}`, {
                     credentials: 'same-origin'
                    })
                    .then(res => res.json())
                    .then(data => {
                        btnCountOrder(parseInt(data.countOrder) || 0);
                    });
 
                let currentCount = 0; // เก็บค่า global หรือ scope ที่เข้าถึงได้

                function loadCount() {
                    fetch(`{{ route('webpanel.ordering.count.order') }}`)
                    .then(res => res.json())
                    .then(resdata => {
                        currentCount = parseInt(resdata.countOrder) || 0;
                        btnCountOrder(currentCount);
                    });

                }
                // =========================
                // โหลด customer ล่าสุด
                // =========================
                fetch(`{{ route('webpanel.ordering.lastest.header') }}`, {
                    credentials: 'same-origin'
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Network response error');
                    }
                    return res.json();
                })
                .then(res => {
                    if (res.success) {
                        customerId = res.customerCode;

                        document.getElementById('customerCode').textContent = res.customerCode ?? '-';
                        document.getElementById('customerName').textContent = res.customerName ?? '-';
                        document.getElementById('customerAddress').textContent = res.customerAddress ?? '-';
                        document.getElementById('customerPriceLevel').textContent = res.customerPriceLevel ?? '-';
                    }
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                });

                let viewId = {{ $orderId ?? 'null' }};
                // โหลด orderId ล่าสุด
                fetch(`/webpanel/ordering/view/${viewId}`, {
                    credentials: 'same-origin'
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Network response error');
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        orderId = data.orderId;
                        itemDrafts = data.itemsDraft;

                        renderDraftItems();

                        // console.log(itemDrafts[0]?.product_code);
                    }
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                });

                function renderDraftItems() {

                itemDrafts.forEach(item => {

                    const tr = document.createElement('tr');
                    tr.setAttribute('data-id', item.product_code);

                    tr.innerHTML = `
                        <td class="border p-2 text-center">${index++}</td>
                        <td class="border p-2 text-center">${item.product_code}</td>
                        <td class="border p-2">${item.name}</td>
                        <td class="border p-2 text-center">${item.unit ?? '-'}</td>
                        <td class="border p-2 text-center price">${item.price}</td>
                        <td class="border p-2 text-center">
                            <input type="number" value="${item.qty}" min="1"
                                class="qtyInput w-20 border p-1 text-center
                                 rounded-md
                                    focus:outline-none 
                                    focus:ring-2
                                    focus:ring-yellow-400 
                                    focus:bg-yellow-50"
                                >
                        </td>
                        <td class="border p-2 text-center total">${item.total_price}</td>
                        <td class="border p-2 text-center">
                            <input type="checkbox" class="reserveInput accent-red-500 w-4 h-4"
                                ${item.reserve ? 'checked' : ''}>
                        </td>
                        <td class="border p-2 text-center">
                             <button 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-2.5 py-1.5 rounded btn-view"
                                data-id="${item.product_code}"
                                data-name="${item.name}">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            <button 
                                class="bg-red-500 hover:bg-red-600 text-white px-2.5 py-1.5 rounded deleteBtn"
                                data-id="${item.product_code}">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </td>
                    `;

                    tr.dataset.productId = item.product_code;
                    tr.dataset.productName = item.name;

                    tableBody.appendChild(tr);

                    bindRowEvents(tr);
                });

                calculateTotal();
                }

                //search customer
                const inputCustomer = document.getElementById('customerSearch');
                const customerDropdown = document.getElementById('customerDropdown');

                let timeoutCustomer;

                if (!inputCustomer) {
                    console.error('ไม่เจอพบ customer');
                }

                inputCustomer.addEventListener('input', function (e) {

                    clearTimeout(timeoutCustomer);

                    timeoutCustomer = setTimeout(async () => {

                        const search = e.target.value.trim();

                        if (search.length < 2) {
                            customerDropdown.classList.add('hidden');
                            return;
                        }

                        const res = await fetch(`/webpanel/ordering/customer-search?q=${encodeURIComponent(search)}`);
                        const data = await res.json();

                        customerDropdown.innerHTML = '';

                        data.forEach(itemC => {

                            const div = document.createElement('div');
                            div.className = 'p-2 hover:bg-gray-100 cursor-pointer';
                            div.textContent = `${itemC.customer_code} - ${itemC.name}`;

                            div.addEventListener('click', () => {

                                // console.log(itemC); //เอาไป set customer ได้
                                selectCustomer(itemC);
                                customerDropdown.classList.add('hidden');
                                inputCustomer.value = itemC.name;

                            });

                            customerDropdown.appendChild(div);
                        });

                        customerDropdown.classList.remove('hidden');

                    }, 300);
                });

                // Search customer
                function selectCustomer(itemC) {
                    
                    const customerId = itemC.customer_code;
                    // console.log(customerId);

                    fetch(`/webpanel/ordering/create-header/new`, {
                        method: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json",
                            "Content-Type": "application/json" 
                        },
                        body: JSON.stringify({
                            customer_id: customerId,
    
                        })
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Network error');
                        return res.json();
                    }).then(data => {
                        
                        // console.log(data.order_id);

                        Swal.fire({
                            title: "สำเร็จ",
                            text: "คุณได้เลือกร้าน: " + data.order.customer_name,
                            icon: "success",
                            confirmButtonColor: "#2DCC61",
                            confirmButtonText: "รับทราบ"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    });
        
                }

                let currentIndex = -1;
                // Search Product (debounce) ป้องกันยิ่ง api รั่ว
                input.addEventListener('input', function (e) {

                    clearTimeout(timeout);
            
                    timeout = setTimeout(async () => {
            
                        const keyword = e.target.value.trim();
            
                        if (!customerId) {
                            productDropdown.classList.add('hidden');
                            return;
                        }
            
                        if (keyword.length < 2) {
                            productDropdown.classList.add('hidden');
                            return;
                        }
            
                        const res = await fetch(`/webpanel/ordering/product-search?q=${keyword}&code=${customerId}`);
                        const data = await res.json();
            
                        productDropdown.innerHTML = '';
                        currentIndex = -1;
            
                        data.forEach(item => {

                            const div = document.createElement('div');
                            div.className = 'p-2 hover:bg-gray-100 cursor-pointer';
                            div.textContent = `${item.product_id} - ${item.product_name}`;
            
                            div.addEventListener('click', () => {
                                selectItem(item);
                                productDropdown.classList.add('hidden');
                                input.value = '';

                                input.focus();
                            });
            
                            productDropdown.appendChild(div);
                        });
            
                        // productDropdown.classList.remove('hidden');
                        if (data.length > 0) {
                            productDropdown.classList.remove('hidden');

                            // auto highlight ตัวแรก
                            currentIndex = 0;
                            updateActive();
                        } else {
                            productDropdown.classList.add('hidden');
                        }
            
                    }, 300);
                });

                input.addEventListener('keydown', function (e) {

                const items = productDropdown.querySelectorAll('div');
                    if (!items.length) return;

                    // ลง
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        currentIndex++;
                        if (currentIndex >= items.length) currentIndex = 0;
                        updateActive();
                    }

                    // ขึ้น
                    if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        currentIndex--;
                        if (currentIndex < 0) currentIndex = items.length - 1;
                        updateActive();
                    }

                    // Enter
                    if (e.key === 'Enter') {
                        e.preventDefault();

                        if (currentIndex >= 0) {
                            items[currentIndex].click();
                        }
                    }
                });

                function updateActive() {
                    const items = productDropdown.querySelectorAll('div');

                    items.forEach((el, index) => {
                        if (index === currentIndex) {
                            el.classList.add('bg-blue-100');
                            el.scrollIntoView({
                                block: 'nearest'
                            });
                        } else {
                            el.classList.remove('bg-blue-100');
                        }
                    });
                }

                // CLICK OUTSIDE

                document.addEventListener('click', (e) => {
                    if (!productDropdown.contains(e.target) && e.target !== input) {
                        productDropdown.classList.add('hidden');
                    }
                });
            
                // SELECT ITEM

                let index = 1;
                function selectItem(item) {
                    
                    const checkProduct = document.querySelector(`[data-id="${item.product_id}"]`);

                    if (checkProduct) {
                        Swal.fire({
                            title: "สินค้าซ้ำ",
                            text: item.product_name,
                            icon: "warning",
                            // confirmButtonColor: "#2DCC61",
                            confirmButtonText: "รับทราบ"
                        })

                        checkProduct.classList.add('bg-yellow-200');

                        setTimeout(() => {
                            checkProduct.classList.remove('bg-yellow-200');
                        }, 5000);

                        const qtyInput = checkProduct.querySelector('.qtyInput');

                        // focus + select
                        qtyInput.focus();
                        qtyInput.select();

                        return;
                    }
            
                    const tr = document.createElement('tr');
                    tr.setAttribute('data-id', item.product_id);
                    // console.log(itemDrafts);
                    tr.innerHTML = `
                        <td class="border p-2 text-center">${index++}</td>
                        <td class="border p-2 text-center">${item.product_id}</td>
                        <td class="border p-2">${item.product_name}</td>
                        <td class="border p-2 text-center">${item.unit ?? '-'}</td>
                        <td class="border p-2 text-center price">${item.price}</td>
                        <td class="border p-2 text-center">
                            <input type="number" value="1" min="1"
                                class="qtyInput w-20 border p-1 text-center
                                    rounded-md
                                    focus:outline-none 
                                    focus:ring-2
                                    focus:ring-yellow-400 
                                    focus:bg-yellow-50"
                                    >
                        </td>
                        <td class="border p-2 text-center total">0</td>
                        <td class="border p-2 text-center"><input type="checkbox" class="reserveInput accent-red-500 w-4 h-4"></td>
                        <td class="border p-2 text-center">
                             <button 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-2.5 py-1.5 rounded btn-view"
                                data-id="${item.product_id}"
                                data-name="${item.name}">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            <button 
                                class="bg-red-500 hover:bg-red-600 text-white px-2.5 py-1.5 rounded deleteBtn"
                                data-id="${item.product_id}">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </td>
                    `;
            
                    tr.dataset.productId = item.product_id;
                    tr.dataset.productName = item.product_name;

                    tableBody.appendChild(tr);
            
                    bindRowEvents(tr);
                    calculateRow(tr);
                    calculateTotal();
                    triggerAutoSave();

                    const qtyInput = tr.querySelector('.qtyInput');

                    setTimeout(() => {
                        qtyInput.focus();
                        qtyInput.select();
                    }, 0);
                }

                // EVENT ROW

                function bindRowEvents(tr) {
            
                    const qtyInput = tr.querySelector('.qtyInput');
                    
                    qtyInput.addEventListener('input', () => {
                        //ป้องกันจำนวนเป็น 0 และติดลบ
                        if (qtyInput.value < 1) qtyInput.value = 1;
                        calculateRow(tr);
                        calculateTotal();

                        triggerAutoSave();

                    });

                    qtyInput.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault();

                            //อัปเดตปุ่ม
                            fetch(`{{ route('webpanel.ordering.count.order') }}`, {
                                credentials: 'same-origin'
                            })
                            .then(res => res.json())
                            .then(data => {
                                const countOrder = parseInt(data.countOrder) || 0;
                                btnCountOrder(countOrder);
                                // console.log(countOrder);
                            })
                            .catch(err => console.error(err));

                            const input = document.getElementById('searchProduct');
                            input.focus();     //กลับไปช่องค้นหา
                            input.select();    //พิมพ์ทับได้เลย
                            
                        }
                    });

                    tr.querySelector('.reserveInput').addEventListener('change', () => {
                        triggerAutoSave();
                    });
            
                    tr.querySelector('.deleteBtn').addEventListener('click', () => {
                        tr.remove();
                        calculateTotal();

                        triggerAutoSave();
                    });
                }

                // CALCULATE

                function calculateRow(tr) {
                    const price = parseFloat(tr.querySelector('.price').textContent);
                    const qty = parseInt(tr.querySelector('.qtyInput').value);
            
                    const total = price * qty;
                    tr.querySelector('.total').textContent = total.toFixed(2);

                    // debounce ป้องกันยิ่ง API รัว เดี๋ยว serve พัง
               /*      clearTimeout(saveTimeout);
                    saveTimeout = setTimeout(() => {
                        saveDraft([{
                            product_code: tr.dataset?.productId,
                            product_name: tr.dataset?.productName,
                            qty: qty,
                            price: price
                        }]);
                    }, 500); */
                }

                function collectTableData() {
                    const rows = document.querySelectorAll('#productTableBody tr');
                    const items = [];

                    rows.forEach(tr => {
                        items.push({
                            product_code: tr.dataset.productId,
                            product_name: tr.dataset.productName,
                            qty: parseInt(tr.querySelector('.qtyInput').value),
                            price: parseFloat(tr.querySelector('.price').textContent),
                            total_price: parseFloat(tr.querySelector('.total').textContent),
                            reserve: tr.querySelector('.reserveInput')?.checked || false
                        });
                    });

                    return items;
                }

                let draftTimeout;

                function triggerAutoSave() {
                    clearTimeout(draftTimeout);

                    draftTimeout = setTimeout(() => {
                        const items = collectTableData();

                        if (!items.length) return;

                        saveDraft(items);
                    }, 1500); 
                }

                const items = collectTableData();

                function saveDraft(items) {

                    // console.log(items);
                    // console.log(Array.isArray(items));

                    if (!orderId) {
                        console.warn('orderId ยังไม่มา');
                        return;
                    }

                    fetch('/webpanel/ordering/update/save-draft', {
                        method: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json",
                            "Content-Type": "application/json" 
                        },
                        body: JSON.stringify({
                            order_id: orderId,
                            items: items
                        })
                    })
                    .then(res => res.json())
                    .then(result => {
                        // console.log('saved', result);
                    })
                    .catch(err => {
                        console.error('saveDraft error:', err);
                    });
                }
            
                function calculateTotal() {
                    let sum = 0;
            
                    document.querySelectorAll('#productTableBody tr').forEach(tr => {
                        sum += parseFloat(tr.querySelector('.total').textContent || 0);
                    });
            
                    totalEl.textContent = sum.toFixed(2);
                }

                // Cancel item change status cancel
                document.addEventListener('click', function(e) {

                    if(e.target.closest('.deleteBtn')) {
                        const btnCan = e.target.closest('.deleteBtn');
                        const productIdCancel = btnCan.dataset.id;
                        const orderIdCancel = orderId;

                        // console.log(productIdC + orderIdCan);
                        cancelItem(productIdCancel, orderIdCancel)
               
                    }
                  
                });
                
                function cancelItem(productIdCancel, orderIdCancel) {

                    if (!productIdCancel || !orderIdCancel) {
                        console.warn('productId หรือ orderId ยังไม่มา');
                        return;
                    }

                    fetch(`{{ route('webpanel.ordering.cancel.item') }}`, {
                        method: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json",
                            "Content-Type": "application/json" 
                        },
                        body: JSON.stringify({
                            product_code: productIdCancel,
                            order_id: orderIdCancel
                        })
                    })
                    .then(res => res.json())
                    .then(data => {

                        if (data.success) {
                            currentCount = Math.max(0, currentCount - 1);
                            btnCountOrder(currentCount);
                            // console.log(currentCount);
                        }

                    })
                    .catch(err => console.error(err));
                }  

                // Cancel item change status cancel
                document.addEventListener('click', function(e) {

                    if(e.target.closest('.btn-cancelled')) {
                        const btnCancel = e.target.closest('.btn-cancelled');
                        const cancelOrder = orderId;

                        // console.log(productIdC + orderIdCan);
                        cancelItemAll(cancelOrder)
                    }
                });

                function cancelItemAll(cancelOrder) {
                    // console.log(orderAllCancel);
                    if (!cancelOrder) {
                        console.warn('orderId ยังไม่มา');
                        return;
                    }

                    fetch(`{{ route('webpanel.ordering.cancel.item.all') }}`, {
                        method: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json",
                            "Content-Type": "application/json" 
                        },
                        body: JSON.stringify({

                            order_id: cancelOrder
                        })
                    })
                    .then(res => res.json())
                    .then(data => {

                        if (data.success) {
                            fetch(`{{ route('webpanel.ordering.count.order') }}`, {
                                    credentials: 'same-origin'
                                })
                                .then(res => res.json())
                                .then(resdata => {
                                    const countOrder = parseInt(resdata.countOrder) || 0;
                                    currentCount = countOrder;
                                    btnCountOrder(currentCount);
                                });
                            }

                    })
                    .catch(err => console.error(err));
                }
            
            });

            //ย้ายไปด้านบน js อ่านไฟล์บนลงล่าง
            // document.addEventListener('click', function(e) {
            //     if (e.target.closest('.btn-view')) {
            //         const btn = e.target.closest('.btn-view');
            //         const id = btn.dataset.id;
            //         const name = btn.dataset.name;

            //         modalItem(id, name);
            //     }

            //     if (e.target.closest('.btn-save')) {
            //         const btnS = e.target.closest('.btn-save');
            //         const id = btnS.dataset.orderId;

            //         const items = collectTableData();

            //         saveOrdering({
            //             items: items,
            //             orderId: id
            //         });
            //     }
              
            // });

            function openModal() {
                const modal = document.getElementById('itemView');
                const content = document.getElementById('modalContent');

                modal.classList.remove('pointer-events-none');
                modal.classList.add('opacity-100');

                content.classList.remove('-translate-y-10', 'opacity-0');
                content.classList.add('translate-y-0', 'opacity-100');
            }

            function closeModal() {
                const modal = document.getElementById('itemView');
                const content = document.getElementById('modalContent');

                content.classList.remove('translate-y-0', 'opacity-100');
                content.classList.add('-translate-y-10', 'opacity-0');

                modal.classList.remove('opacity-100');

                setTimeout(() => {
                    modal.classList.add('pointer-events-none');
                }, 300);
            }

            function modalItem(id, name) {
                fetch("{{ route('webpanel.ordering.view.item') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(res => res.json())
                .then(data => {

                    if (!data.item) {
                        console.warn('No data');
                        return;
                    }

                    document.getElementById('item_product_id').value = data.item.product_id ?? '';
                    document.getElementById('item_product_name').value = data.item.product_name ?? '';
                    document.getElementById('item_unit').value = data.item.unit ?? '';
                    document.getElementById('item_generic_name').value = data.item.generic_name ?? '';
                    document.getElementById('item_category').value = data.item.subcategories_name ?? '';
                    document.getElementById('item_stock_qty').value = data.item.quantity ?? '';

                    // const modal = document.getElementById('itemView');
                    // modal.classList.remove('hidden');
                    // modal.classList.add('flex');

                    openModal();
                })
                .catch(err => console.error(err));
            }

            //saveOrdering
            function saveOrdering(id) {
                // console.log(id);

                const poId = id;

                if (!poId) {
                        console.warn('orderId ยังไม่มา');
                        return;
                    }

                    fetch(`{{ route('webpanel.ordering.confirmed.save') }}`, {
                        method: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json",
                            "Content-Type": "application/json" 
                        },
                        body: JSON.stringify({
                            order_id: poId,
                            // items: data
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        // console.log('saved', result);

                        if (data.success === true) {

                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ',
                                text: 'บันทึกข้อมูลเรียบร้อย',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            setTimeout(() => {
                                window.location.href = "{{ route('webpanel.ordering.index') }}";
                            }, 1200);

                            } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'ล้มเหลว',
                                text: data.message ?? 'เกิดข้อผิดพลาด',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            setTimeout(() => {
                                window.location.href = "{{ route('webpanel.ordering.index') }}";
                            }, 1200);
                        }
                    })
                    .catch(err => {
                        console.error('saveDraft error:', err);
                    });
                
            }
    
        </script>
    
@endsection
