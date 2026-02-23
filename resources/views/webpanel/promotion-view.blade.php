@extends('layouts.webpanel')
@section('content')

<div class="py-2"></div>
<h5 class="!text-gray-600 font-semibold ms-6">สร้างโปรโมชั่น (New Promotion)</h5>
<hr class="my-3 !text-gray-400 !border">

<div class="grid grid-cols-1 mx-4 px-2 text-gray-500">

    <div>
        <form action="{{ route('webpanel.promotion.create.po') }}" method="POST">
            @csrf
            <button 
                type="submit"
                class="px-4 py-2 !rounded-md text-white 
                    {{ !empty($orderId) 
                            ? 'bg-gray-400 cursor-not-allowed' 
                            : 'bg-green-500 hover:bg-green-600' }}"
                {{ !empty($orderId) ? 'disabled' : '' }}>
                เพิ่มโปรโมชั่นใหม่
            </button>
        </form>
    </div>

    <hr class="!text-gray-500 mt-3">

    @if(!empty($orderId))

        <p class="font-bold">เลือกรายการสินค้าได้จากเมนู</p>

        <div class="py-2 mb-2">
            <a href="{{ route('webpanel.promotion.product.slow.view') }}" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md text-white !no-underline">สินค้าเคลื่อนไหวช้า</a>
        </div>
        <form id="editForm">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center px-2 py-2 w-12 !text-gray-700">#</th>
                
                        <th class="text-center px-2 py-2 w-28 !text-gray-700">
                            รหัสสินค้า
                        </th>
                
                        <th class="text-left px-3 py-2 !text-gray-700">
                            ชื่อสินค้า
                        </th>
                
                        <th class="text-left px-3 py-2 !text-gray-700">
                            ราคาโปรโมชั่น
                        </th>

                        <th class="text-left px-3 py-2 !text-gray-700">
                            วันหมดอายุ
                        </th>
                
                        <th class="text-center px-2 py-2 w-24 !text-gray-700">
                            จำนวน
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

            <div class="text-start mb-3">
                <p class="text-red-500 text-sm font-bold">หมายเหตุ: กรุณาตรวจสอบข้อมูล หากกดบันทึกแล้วจะไม่สามารถแก้ไขข้อมูลได้</p>
                <hr>
                <button 
                    class="bg-blue-500 px-4 py-2 !rounded-md text-white btn-update"
                    data-order-id="{{ $orderId }}"
                    >บันทึกข้อมูล
                </button>
            </div>
        </form>
    @endif 

     <!-- เพิ่มสินค้า -->
    <div id="addModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">

            <!-- Header -->
            <div class="bg-blue-600 text-white px-4 py-3">
                <span class="block text-xl text-center mt-2">แก้ไขสินค้า</span>
            </div>

            <!-- Body -->
            <div class="p-4 space-y-3">

                <!-- order id -->
                <input type="hidden" id="modal_order_id">

                <!-- product id -->
                <div>
                <label class="text-sm font-medium text-gray-500">รหัสสินค้า</label>
                <input type="text" id="modal_product_id"
                    class="w-full border rounded-lg p-2 bg-gray-100 text-gray-400"
                    readonly>
                </div>

                <!-- product -->
                <div>
                    <label class="text-sm font-medium text-gray-500">ชื่อสินค้า</label>
                    <input type="text" id="modal_product_name"
                        class="w-full border rounded-lg p-2 bg-gray-100 text-gray-400"
                        readonly>
                </div>

                <!-- qty + price -->
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-sm font-medium text-gray-500">จำนวน <span class="text-red-400 text-xs">*ห้ามเป็น 0</span></label>
                        <input type="number" id="modal_qty"
                        min="1"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 text-gray-400">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">ราคา/หน่วย <span class="text-red-400 text-xs">*ห้ามเป็น 0</span></label>
                        <input type="number" id="modal_price"
                            min="1"
                            step="0.01"
                            class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 text-gray-400">
                    </div>
                </div>

                <!-- unit -->
                <div>
                    <label class="text-sm font-medium text-gray-500">หน่วยสินค้า</label>
                    <input type="text" id="modal_unit"
                        class="w-full border rounded-lg p-2 bg-gray-100 text-gray-400"
                        readonly>
                </div>

                <div>
                    <label for="search" class="block text-sm font-medium text-gray-500 mb-1">
                        วันหมดอายุ:
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            id="expire"
                            name="expire"
                            class="w-full rounded-md border !border-gray-300
                                px-3 py-2 pr-10 text-gray-400
                                focus:outline-none focus:ring-2 focus:ring-blue-500
                                focus:border-blue-500 bg-white"
                        >
                
                        <!-- calendar icon (right) -->
                        <button
                            type="button"
                            id="openDatepickerExpire"
                            class="absolute inset-y-0 right-0 flex items-center px-3
                                border-l !border-gray-300
                                text-gray-600 hover:text-gray-600
                                bg-gray-50 border !rounded-r-md">
                            <i class="fa-regular fa-calendar"></i>
                        </button>
                    </div>
                </div>

                <!-- note -->
                <div>
                    <label class="text-sm font-medium text-gray-500">หมายเหตุ</label>
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
                    class="px-4 py-2 bg-blue-600 text-white !rounded-md hover:bg-blue-700">
                    บันทึก
                </button>
            </div>

        </div>
    </div>
</div>

<script>

    let draftData = []

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('editForm');

        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
            });
        }

        fetch(`{{ route('webpanel.promotion.product.view.draft') }}`, {
            credentials: 'same-origin'
        })

        .then(res => {
            if (!res.ok) throw new Error('Network error');
            return res.json();
        })
        .then(data => {

            draftData = data.viewDraft //เก็บไว้ใช้ตอน save

            let html = '';
            let index = 1;
    
            data.viewDraft.forEach(item => {
                html += `
                    <tr>
                        <td class="text-center border-end !text-gray-600">${index++}</td>
                        <td class="text-center border-end !text-gray-600">${item.product_id}</td>
                        <td class="border-end !text-gray-600">${item.product_name}</td>
                        <td class="border-end !text-gray-600">${item.price}</td>
                          <td class="border-end !text-gray-600">${item.expire}</td>
                        <td class="text-center border-end !text-gray-600">${item.qty}</td>
                        <td class="text-center border-end !text-gray-600">${item.unit}</td>
                        <td class="border-end !text-gray-600 align-middle">
                            <div class="flex flex-col md:flex-row gap-2 items-center justify-center">
                                <button 
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-2.5 py-1.5 rounded btn-edit"
                                    data-id="${item.product_id}"
                                    data-name="${item.product_name}">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>

                                <button 
                                    class="bg-red-500 hover:bg-red-600 text-white px-2.5 py-1.5 rounded btn-del"
                                    data-id="${item.product_id}">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>

                            </div>
                        </td>

                    </tr>

                `;
            });
    
            const el = document.getElementById('tableBody');
            if (!el) return;

            document.getElementById('tableBody').innerHTML = html;
        })
        .catch(err => console.error(err));

    });

</script>

<script>

    document.addEventListener('click', function(e) {

        if (e.target.closest('.btn-edit')) {
            const btn = e.target.closest('.btn-edit');
            const id = btn.dataset.id;
            const name = btn.dataset.name;

            openModal(id, name);
        }

       /*  if (e.target.closest('.btn-del')) {
            const btn = e.target.closest('.btn-del');
            const id = btn.dataset.id;

            delItemModal(id);
        } */

        if (e.target.closest('.btn-del')) {
            const id = e.target.closest('.btn-del').dataset.id;
            confirmDelete(id);
        }

        //confirmOrder
        if (e.target.closest('.btn-update')) {
            const orderId = e.target.closest('.btn-update').dataset.orderId;
            confirmOrder(orderId);
        }
    });

     // เปิด Modal เพิ่มสินค้า
     function openModal(id, name) {

        fetch(`/webpanel/promotion-view/edit/${id}`, {
            credentials: 'same-origin'
        })
        .then(res => {
            if (!res.ok) throw new Error('Network error');
            return res.json();
        })
        .then(data => {
            // console.log(data.qty);

            // set ค่าเข้า input
            document.getElementById('modal_order_id').value = data.edit.promotion_order_id;

            document.getElementById('modal_qty').value = data.edit.qty ?? '';
            document.getElementById('modal_price').value = data.edit.price ?? '';
            document.getElementById('modal_unit').value = data.edit.unit ?? '';
            document.getElementById('expire').value = data.edit.expire ?? '';
            document.getElementById('modal_note').value = data.edit.note ?? '';
        })
        .catch(err => {
            console.error(err);
        });

        document.getElementById('modal_product_id').value = id;
        document.getElementById('modal_product_name').value = name;

        document.getElementById('modal_qty').value = '';
        document.getElementById('modal_note').value = '';

        document.getElementById('addModal').classList.remove('hidden');
        document.getElementById('addModal').classList.add('flex');
    }

    function closeAddModal() {
        document.getElementById('addModal')?.classList.add('hidden');
    }

    function confirmDelete(id) {
        Swal.fire({
            icon: 'warning',
            title: 'ยืนยันการลบ?',
            text: 'ลบแล้วไม่สามารถย้อนกลับได้',
            showCancelButton: true,
            confirmButtonText: 'ลบ',
            cancelButtonText: 'ยกเลิก'
        }).then(result => {
            if (result.isConfirmed) {
                deleteItem(id); //ค่อยยิง API
            }
        });
    }
    
    function deleteItem(id) {
        Swal.fire({
            title: 'กำลังลบ...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(`/webpanel/promotion-view/item/destroy/${id}`, {
            method: 'DELETE',
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
        })
        .then(res => {
            if (!res.ok) throw new Error('Network error');
            return res.json();
        })
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'warning',
                    title: 'กำลังลบข้อมูล...',
                    text: 'กรุณารอสักครู่',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                setTimeout(() => {
                    window.location.href = "{{ route('webpanel.promotion.product.view') }}";
                }, 1000); // หน่วงนิดให้เห็น anim
            }
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด'
            });
            console.error(err);
        });
    }

    function submitModal() {
        const btn = document.getElementById('btnSubmit');

        const productId = document.getElementById('modal_product_id')?.value;
        const qty = document.getElementById('modal_qty')?.value;
        const price = document.getElementById('modal_price')?.value;
        const note = document.getElementById('modal_note')?.value;
        const expire = document.getElementById('expire')?.value;

        if (!productId || !qty) {
            alert('กรุณากรอกข้อมูลให้ครบ');
            return;
        }

        btn.disabled = true;
        btn.innerText = 'กำลังบันทึก...';

        fetch(`/webpanel/promotion-view/edit/update/${productId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                quantity: qty,
                price: price,
                note: note,
                expire: expire
            })
        })
        .then(async res => {
            const text = await res.text();
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Response not JSON:', text);
                throw new Error('Server error');
            }
        })
        .then(data => {

            if (data.status === 'success') {

                Swal.fire({
                    icon: 'warning',
                    title: 'กำลังอัปเดตตะกร้า..',
                    text: 'กรุณารอสักครู่',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                setTimeout(() => {
                    window.location.href = "{{ route('webpanel.promotion.product.view') }}";
                }, 1200);

                closeAddModal();

                // reset form
                document.getElementById('modal_qty').value = '';
                document.getElementById('modal_price').value = '';
                document.getElementById('modal_note').value = '';
                document.getElementById('expire').value = '';

            }

                btn.disabled = false;
                btn.innerText = 'บันทึก';

            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณาลองใหม่'
                });

                btn.disabled = false;
                btn.innerText = 'บันทึก';

                console.error(err);
            });
    }

    function confirmOrder(orderId) {
        // console.log(orderId);

        fetch(`/webpanel/promotion-view/confirm/order/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    // order_id: orderId,
                    products: draftData 
                })
            })
            .then(res => res.json())
            .then(data => {
                // console.log(res)

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
                        window.location.href = "{{ route('webpanel.promotion.product.view') }}";
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
                        window.location.href = "{{ route('webpanel.promotion.product.view') }}";
                    }, 1200);
                }
            });

    }

</script>
@endsection