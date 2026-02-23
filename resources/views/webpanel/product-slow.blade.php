@extends('layouts.webpanel')
@section('content')

<div class="py-2"></div>
<h5 class="!text-gray-600 font-semibold ms-6"><a href="{{ route('webpanel.promotion.product.view') }}" class="!no-underline">ย้อนกลับ</a> | สินค้าเคลื่อนไหวช้า</h5>
<hr class="my-3 !text-gray-400 !border">

<div class="grid grid-cols-1 mx-4 px-2 text-gray-500">

    <div class="mt-2">
    </div>

    <form id="editForm">
        <div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <!-- ค้นหาสินค้า -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                        ค้นหาสินค้า
                    </label>
                    <input 
                        type="text" 
                        id="search" 
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="เช่น รหัสสินค้า | ชื่อสินค้า"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>
        
                <!-- วันที่เริ่ม -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                        วันที่เริ่ม:
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            id="fromcheck"
                            name="from"
                            value="{{ request('from') == '' ? date('Y-m-d') : request('from') }}"
                            class="w-full rounded-md border !border-gray-300
                                px-3 py-2 pr-10 text-gray-700
                                focus:outline-none focus:ring-2 focus:ring-blue-500
                                focus:border-blue-500 bg-white"
                        >
                
                        <!-- calendar icon (right) -->
                        <button
                            type="button"
                            id="openDatepickerFrom"
                            class="absolute inset-y-0 right-0 flex items-center px-3
                                border-l !border-gray-300
                                text-gray-600 hover:text-gray-600
                                bg-gray-50 border !rounded-r-md">
                            <i class="fa-regular fa-calendar"></i>
                        </button>
                    </div>
                </div>

                <!-- ถึงวันที่ -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                        ถึงวันที่:
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            id="tocheck"
                            name="to"
                            value="{{ request('to') == '' ? date('Y-m-d') : request('to') }}"
                            class="w-full rounded-md border !border-gray-300
                                px-3 py-2 pr-10 text-gray-700
                                focus:outline-none focus:ring-2 focus:ring-blue-500
                                focus:border-blue-500 bg-white"
                        >
                
                        <!-- calendar icon (right) -->
                        <button
                            type="button"
                            id="openDatepickerTo"
                            class="absolute inset-y-0 right-0 flex items-center px-3
                                border-l !border-gray-300
                                text-gray-600 hover:text-gray-600
                                bg-gray-50 border !rounded-r-md">
                            <i class="fa-regular fa-calendar"></i>
                        </button>
                    </div>
                </div>
                <!-- ปุ่ม -->
                <div class="flex gap-2">
                    <button 
                        type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium !rounded-lg px-5 py-2.5"
                    >
                        ค้นหา
                    </button>
        
                    <a href="{{ url()->current() }}" 
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg px-4 py-2.5 !no-underline !text-gray-600">
                       ล้าง
                    </a>
                </div>
        
            </div>
        </div>        
    </form>

    <div class="mb-2">

        <hr class="my-3 mt-4">
        <h5 class="!text-gray-600 py-2">
            สินค้าเคลื่อนไหวช้า :
            <span class="text-red-400" id="fromRange"></span>
            <span class="text-red-400">-</span>
            <span class="text-red-400" id="toRange"></span>
        </h5>
        
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="text-center px-2 py-2 w-12 !text-gray-700">#</th>
            
                    <th class="text-center px-2 py-2 w-28 !text-gray-700">
                        รหัสสินค้า
                    </th>
            
                    <th class="text-left px-3 py-2 w-[30%] !text-gray-700">
                        ชื่อสินค้า
                    </th>
            
                    {{-- <th class="text-left px-3 py-2 w-[25%] !text-gray-700">
                        ชื่อสามัญ
                    </th> --}}
            
                    <th class="text-center px-2 py-2 w-24 !text-gray-700">
                        คงเหลือ
                    </th>
            
                    <th class="text-center px-2 py-2 w-20 !text-gray-700">
                        หน่วย
                    </th>
            
                    <th class="text-center px-2 py-2 w-28 !text-gray-700">
                        จัดการ
                    </th>
                </tr>
            </thead>
            <tbody id="tableBody">
              
            </tbody>
        </table>
        <div class="py-2"></div>
    </div>
    
    <!-- Modal item -->
    <div id="itemView" class="fixed inset-0 bg-black/50 hidden items-center justify-center">
        
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
    
            <div class="bg-blue-600 text-white px-4 py-3">
                <span class="block text-xl text-center mt-2">รายงาน: ย้อนหลัง 3 เดือน</span>
            </div>

            <!-- Product -->
            <div class="p-4">
                <div class="mb-3">
                    <label class="text-sm text-gray-500 font-medium mb-1">รหัสสินค้า</label>
                    <input type="text" id="item_product_id"
                        class="w-full border p-2 rounded-lg bg-gray-100 text-gray-400" readonly>
                </div>
        
                <div class="mb-3">
                    <label class="text-sm text-gray-500 font-medium mb-1">ชื่อสินค้า</label>
                    <input type="text" id="item_product_name"
                        class="w-full border p-2 rounded-lg bg-gray-100 text-gray-400" readonly>
                </div>

                <div class="mb-3">
                    <label class="text-sm text-gray-500 font-medium mb-1">หน่วยสินค้า</label>
                    <input type="text" id="item_unit"
                        class="w-full border p-2 rounded-lg bg-gray-100 text-gray-400" readonly>
                </div>
        
                <!-- Months -->
                <hr>
                <p class="font-medium text-base">รายงานขายต่อเดือน</p>

                <div class="space-y-3 mx-2 border p-4 rounded-md">

                    <div>
                        <div class="flex justify-between text-sm text-gray-500 font-medium mb-1">
                            <span id="date_1">-</span>
                            {{-- <span>จำนวน</span> --}}
                        </div>
                        <input type="number" id="item_qty_1"
                            class="w-full border p-2 rounded-lg text-gray-500 font-bold text-center">
                    </div>
        
                    <div>
                        <div class="flex justify-between text-sm text-gray-500 font-medium mb-1">
                            <span id="date_2">-</span>
                            {{-- <span>จำนวน</span> --}}
                        </div>
                        <input type="number" id="item_qty_2"
                            class="w-full border p-2 rounded-lg text-gray-500 font-bold text-center">
                    </div>
        
                    <div>
                        <div class="flex justify-between text-sm text-gray-500 font-medium mb-1">
                            <span id="date_3">-</span>
                            {{-- <span>จำนวน</span> --}}
                        </div>
                        <input type="number" id="item_qty_3"
                            class="w-full border p-2 rounded-lg text-gray-500 font-bold text-center">
                    </div>
        
                </div>
        
                <!-- Buttons -->
                <div class="flex justify-end gap-2 mt-3">
                    <button onclick="closeModal()"
                        class="px-4 py-2 bg-gray-400 text-white !rounded-md hover:bg-gray-500">
                       X ปิด
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- เพิ่มสินค้า -->
    <div id="addModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
    
            <!-- Header -->
            <div class="bg-green-600 text-white px-4 py-3">
                <span class="block text-2xl text-center">เพิ่มสินค้า</span>
            </div>
    
            <!-- Body -->
            <div class="p-4 space-y-3">
    
                <!-- order id -->
                <input type="hidden" id="modal_order_id">
    
                <!-- product id -->
                <div>
                <label class="text-sm text-gray-500 font-medium mb-1">รหัสสินค้า</label>
                <input type="text" id="modal_product_id"
                    class="w-full border rounded-lg p-2 bg-gray-100 text-gray-400"
                    readonly>
                </div>

                <!-- product -->
                <div>
                    <label class="text-sm text-gray-500 font-medium mb-1">ชื่อสินค้า</label>
                    <input type="text" id="modal_product_name"
                        class="w-full border rounded-lg p-2 bg-gray-100 text-gray-400"
                        readonly>
                </div>
    
                <!-- qty + price -->
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-sm text-gray-500 font-medium mb-1">จำนวน <span class="text-red-400 text-xs">*ขั้นต่ำ 1</span></label>
                        <input type="number" id="modal_qty"
                            value="1"
                            min="1"
                            placeholder="1"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 text-gray-400">
                    </div>
    
                    <div>
                        <label class="text-sm text-gray-500 font-medium mb-1">ราคาโปร <span class="text-red-400 text-xs">*ห้ามเป็น 0</span></label>
                        <input type="number" id="modal_price"
                            value="0.01"
                            min="0.01"
                            step="0.01"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 text-gray-400">
                    </div>
                </div>
    
                <!-- total auto -->
                <div>
                    <label class="text-sm text-gray-500 font-medium mb-1">รวม</label>
                    <input type="hidden" id="modal_total"
                        class="w-full border rounded-lg p-2 bg-gray-100"
                        readonly>
                </div> 

                <div>
                    <label class="text-sm text-gray-500 font-medium mb-1">หน่วยสินค้า</label>
                    <input type="text" id="modal_unit"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 text-gray-400" readonly>
                </div>

                <div>
                    <label for="search" class="block text-sm font-medium text-red-500 mb-1">
                        วันหมดอายุ:
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            id="expire"
                            name="expire"
                            class="w-full rounded-md border !border-gray-300
                                px-3 py-2 pr-10 text-gray-700
                                focus:outline-none focus:ring-2 focus:ring-blue-500
                                focus:border-blue-500 bg-white text-gray-400"
                        >
                
                        <!-- calendar icon (right) -->
                        <button
                            type="button"
                            id="openDatepickerExpire"
                            class="absolute inset-y-0 right-0 flex items-center px-3
                                border-l !border-gray-300
                                text-gray-400 hover:text-gray-600
                                bg-gray-50 border !rounded-r-md">
                            <i class="fa-regular fa-calendar"></i>
                        </button>
                    </div>
                </div>
    
                <!-- note -->
                <div>
                    <label class="text-sm text-gray-500 font-medium mb-1">หมายเหตุ</label>
                    <textarea id="modal_note"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400"></textarea>
                </div>
    
            </div>
    
            <!-- Footer -->
            <div class="flex justify-end gap-2 p-4 border bg-gray-50">
                <button onclick="closeAddModal()"
                    class="px-4 py-2 bg-gray-400 text-white !rounded-md hover:bg-gray-500">
                    ยกเลิก
                </button>
    
                <button id="btnSubmit" onclick="submitModal()"
                    class="px-4 py-2 bg-green-600 text-white !rounded-md hover:bg-green-700">
                    บันทึก
                </button>
            </div>
    
        </div>
    </div>

</div>

<script>
    $(function () {
        $("#fromcheck").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2026:2031"
        });
    
        $("#openDatepickerFrom").on("click", function () {
            $("#fromcheck").focus();
        });
    });
    $(function () {
        $("#tocheck").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2026:2031"
        });
    
        $("#openDatepickerTo").on("click", function () {
            $("#tocheck").focus();
        });
    });

    $(function () {
        $("#expire").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "2026:2031"
        });
    
        $("#openDatepickerExpire").on("click", function () {
            $("#expire").focus();
        });
    });
</script>

<script>
    document.getElementById('editForm').addEventListener('submit', function (e) {
        e.preventDefault();
    
        const form = e.target;

        const params = new URLSearchParams({
            search: form.search.value,
            from: document.getElementById('fromcheck').value,
            to: document.getElementById('tocheck').value,
        });

        fetch(`{{ route('webpanel.promotion.product.slow.data') }}?${params.toString()}`, {
            credentials: 'same-origin'
        })
        .then(res => {
            if (!res.ok) throw new Error('Network error');
            return res.json();
        })
        .then(data => {
            // console.log(data);

            const el = document.getElementById('fromRange');
            if (el && data.range) {
                el.textContent = data.range.from;
            }

            const es = document.getElementById('toRange');
            if (es && data.range) {
                es.textContent = data.range.to;
            }

            let html = '';
            let index = 1;
            // <td class="border-end !text-gray-600">${item.generic_name}</td>
            data.data.dead_stock.forEach(item => {
                html += `
                    <tr>
                        <td class="text-center border-end !text-gray-600">${index++}</td>
                        <td class="text-center border-end !text-gray-600">${item.product_id}</td>
                        <td class="border-end !text-gray-600">${item.product_name}</td>
                    
                        <td class="text-center border-end !text-gray-600">${item.quantity}</td>
                        <td class="text-center border-end !text-gray-600">${item.unit}</td>
                        <td class="border-end !text-gray-600 align-middle">
                            <div class="flex flex-col md:flex-row gap-2 items-center justify-center">
                                <button 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-2.5 py-1.5 rounded btn-view"
                                    data-id="${item.product_id}"
                                    data-name="${item.product_name}">
                                    <i class="fa-regular fa-eye"></i>
                                </button>

                                <button 
                                    class="bg-green-600 hover:bg-green-700 text-white px-2.5 py-1.5 rounded btn-add"
                                    data-id="${item.product_id}"
                                    data-name="${item.product_name}"
                                    data-unit="${item.unit}">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </button>

                            </div>
                        </td>

                    </tr>
                `;
            });
    
            document.getElementById('tableBody').innerHTML = html;
        })
        .catch(err => console.error(err));
    });
    document.getElementById('editForm').dispatchEvent(new Event('submit'));

</script>
 

<script>

    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-view')) {
            const btn = e.target.closest('.btn-view');
            const id = btn.dataset.id;
            const name = btn.dataset.name;

            modalItem(id, name);
        }

        //add product
        if (e.target.closest('.btn-add')) {
            const btn = e.target.closest('.btn-add');
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const unit = btn.dataset.unit;

            openModal(id, name, unit);
        }
    });

    // เปิด Modal ดูสินค้า
    function modalItem(id, name) {
        fetch("{{ route('webpanel.promotion.product.slow.item') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ id: id })
        })
        .then(res => res.json())
        .then(data => {

            if (!data.item || data.item.length === 0) {
                console.warn('No data');
                return;
            }

            const itemSt = data.item[0] ?? {};
            const itemNd = data.item[1] ?? {};
            const itemTh = data.item[2] ?? {};

            document.getElementById('item_product_id').value = itemSt.product_id ?? '';
            document.getElementById('item_product_name').value = name;
            document.getElementById('item_unit').value = data.unit;

            // เดือนล่าสุด
            document.getElementById('item_qty_1').value = itemSt.total ?? 0;

            // เดือนก่อนหน้า
            document.getElementById('item_qty_2').value = itemNd.total ?? 0;

            // ย้อนหลัง 2 เดือน
            document.getElementById('item_qty_3').value = itemTh.total ?? 0;

            document.getElementById('date_1').innerText = itemSt.label_th;

            document.getElementById('date_2').innerText = itemNd.label_th;

            document.getElementById('date_3').innerText = itemTh.label_th;

            document.getElementById('itemView').classList.remove('hidden');
            document.getElementById('itemView').classList.add('flex');
        })
        .catch(err => console.error(err));
    }

    // เปิด Modal เพิ่มสินค้า
    function openModal(id, name, unit) {

        fetch("{{ route('webpanel.promotion.order.id') }}", {
            credentials: 'same-origin'
        })
        .then(res => {
            if (!res.ok) throw new Error('Network error');
            return res.json();
        })
        .then(data => {
            // console.log(data.orderId);

            // set ค่าเข้า input
            document.getElementById('modal_order_id').value = data.orderId;
        })
        .catch(err => {
            console.error(err);
        });

        document.getElementById('modal_product_id').value = id;
        document.getElementById('modal_product_name').value = name;
        document.getElementById('modal_unit').value = unit;

        document.getElementById('modal_qty').value = 1;
        document.getElementById('modal_note').value = '';

        document.getElementById('addModal').classList.remove('hidden');
        document.getElementById('addModal').classList.add('flex');
    }

    // ปิด Modal
    function closeModal() {
        document.getElementById('itemView')?.classList.add('hidden');
    }

    function closeAddModal() {
        document.getElementById('addModal')?.classList.add('hidden');
    }

    // ======================
    // Submit เพิ่มสินค้า
    // ======================
    const qtyInput = document.getElementById('modal_qty');
    const priceInput = document.getElementById('modal_price');
    const totalInput = document.getElementById('modal_total');

    function calculateTotal() {
        const qty = parseFloat(qtyInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;

        totalInput.value = (qty * price).toFixed(2);
    }

    qtyInput.addEventListener('input', calculateTotal);
    priceInput.addEventListener('input', calculateTotal);

    function submitModal() {
        const btn = document.getElementById('btnSubmit');

        const order_id = document.getElementById('modal_order_id').value;
        const product_id = document.getElementById('modal_product_id').value;
        const product_name = document.getElementById('modal_product_name').value;
        const qty = document.getElementById('modal_qty').value;
        const price = document.getElementById('modal_price').value;
        const note = document.getElementById('modal_note').value;
        const expire = document.getElementById('expire').value;

        if (!product_id || !qty) {
            alert('กรุณากรอกข้อมูลให้ครบ');
            return;
        }

        btn.disabled = true;
        btn.innerText = 'กำลังบันทึก...';

        fetch("{{ route('webpanel.promotion.product.add') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                order_id,
                product_id,
                product_name,
                quantity: qty,
                price: price,
                note: note,
                expire: expire
            })
        })
        .then(res => res.json())
        .then(data => {
            
            if (data.status == 'success') {
                Swal.fire({
                    icon: 'info',
                    title: 'กำลังเพิ่มข้อมูล...',
                    text: 'กรุณารอสักครู่',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                setTimeout(() => {
                    window.location.href = "{{ route('webpanel.promotion.product.slow.view') }}";
                }, 1000); // หน่วงนิดให้เห็น animation

                closeAddModal();

                // reset form
                document.getElementById('modal_qty').value = '';
                document.getElementById('modal_price').value = '';
                document.getElementById('modal_note').value = '';
                document.getElementById('modal_total').value = '';

            }

            else if (data.status === 'error') {

                Swal.fire({
                    icon: 'warning',
                    title: 'ข้อมูลซ้ำ',
                    text: 'กรุณาตรวจสอบตะกร้า',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                    setTimeout(() => {
                        window.location.href = "{{ route('webpanel.promotion.product.slow.view') }}";
                    }, 1500); // หน่วงนิดให้เห็น animation

                    closeAddModal();
                }

            btn.disabled = false;
            btn.innerText = 'บันทึก';
        })
        .catch(err => {
            console.error(err);
            alert('error');

            btn.disabled = false;
            btn.innerText = 'บันทึก';
        });
    }
</script>
    
@endsection