@extends('layouts.webpanel')
@section('content')

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6">รับสั่งสินค้า (Ordering)</h5>
        <hr class="my-3 !text-gray-400 !border">

        <!-- Alpine v3 -->
        <div class="grid grid-cols-1 mx-4 px-2 text-gray-500">
            {{-- <h2 class="text-2xl font-bold mb-4">เลือก Customer</h2> --}}
        
            <!-- Customer Search -->
            <div class="mb-4 relative w-full">
                <label class="font-medium block mb-2 text-base">ค้นหาชื่อร้านค้า:</label>
                <input type="text" id="customerSearch" class="border !border-gray-300 p-2 rounded w-full" placeholder="ชื่อร้านค้า | Code">
                <div id="customerDropdown" class="absolute bg-white border w-full shadow rounded z-10 max-h-48 overflow-auto hidden"></div>
            </div>

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
                            <div id="customerProvince"
                                 class="px-4 py-2 bg-yellow-50 border-[2px] border-yellow-400 rounded-lg text-gray-600 font-medium">
                                -
                            </div>
                        </div>
                    </div>
            
                </div>
            </div>

            <script>
            fetch('/purchase/ordering/latest-draft-po')
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        document.getElementById('customerCode').textContent = res.customerCode ?? '-';
                        document.getElementById('customerName').textContent = res.customerName ?? '-';
                        document.getElementById('customerProvince').textContent = res.customerProvince ?? '-';
                        document.getElementById('customerPriceLevel').textContent = res.customerPriceLevel ?? '-';
                    }
                });
            </script>
        
            <!-- ตารางสินค้า -->
            <table class="w-full border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">ค้นหา</th>
                        <th class="p-2 border text-center">รหัส</th>
                        <th class="p-2 border text-center">ชื่อสินค้า</th>
                        <th class="p-2 border text-center">หน่วย</th>
                        <th class="p-2 border text-center">ราคาต่อหน่วย</th>
                        <th class="p-2 border text-center">จำนวน</th>
                        <th class="p-2 border text-center">ราคารวม</th>
                        {{-- <th class="p-2 border">หมายเหตุ</th> --}}
                        <th class="p-2 border text-center">จอง</th>
                        <th class="p-2 border text-center">ลบ</th>
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
                        // <td class="p-2 border"><input class="noteInput w-full border rounded p-1"></td>
                        tr.innerHTML = `
                            <td class="p-2 border relative">
                                <input class="searchInput w-full border rounded p-1" placeholder="รหัสสินค้า/ชื่อสินค้า">
                                <div class="dropdown absolute bg-white border w-full shadow rounded z-10 max-h-44 overflow-auto hidden"></div>
                            </td>
                            <td class="p-2 border code"></td>
                            <td class="p-2 border name"></td>
                            <td class="p-2 border unit"></td>
                            <td class="p-2 border text-center"><span class="unitPrice"></span></td>
                            <td class="p-2 border"><input type="number" class="qtyInput w-20 border rounded p-1 text-center" value="1"></td>
                            <td class="p-2 border text-center">
                                <input type="number"
                                    min="1"
                                    value="1"
                                    class="priceTotal w-24 border rounded p-1 text-right"
                                    oninput="if (this.value < 1) this.value = 1">
                            </td>
                        
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
                            // tr.querySelector(".noteInput").value = data.remark ?? "";
                            tr.querySelector(".reserveInput").checked = data.reserve ?? false;

                            updateTotal();

                        }

                        return tr;
                    }

                    function attachRowEvents(tr) {
                        const search = tr.querySelector(".searchInput");
                        const dropdown = tr.querySelector(".dropdown");
                        
                        const qty = tr.querySelector('.qtyInput');
                        qty.addEventListener('input', () => {
                            let val = parseInt(qty.value);

                            if (isNaN(val) || val < 1) {
                                qty.value = 1;
                            }
                        });

                        const unitPriceEl = tr.querySelector('.unitPrice');
                        const totalPriceInput = tr.querySelector('.priceTotal');
                        // const note = tr.querySelector(".noteInput");
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
                            tr.querySelector('.qtyInput').value = '';

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

                                totalPriceInput.value = qtyVal * unitPrice; // คำนวณจริง

                                totalPriceInput.focus();  // focus input ได้
                                updateTotal();
                                autoSaveItem();
                            }
                        });

                        totalPriceInput.addEventListener('keydown', e => {
                            if(e.key === 'Enter'){
                                e.preventDefault();
                                reserve.focus();
                                autoSaveItem();
                            }
                        });

                        totalPriceInput.addEventListener('input', () => {
                            updateTotal();
                            autoSaveItem();
                            
                        });


                        // note.addEventListener('keydown',e=>{ if(e.key==='Enter'){ e.preventDefault(); reserve.focus(); autoSaveItem(); } });
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
                            // const remark = r.querySelector('.noteInput')?.value || '';
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
                                // remark: r.querySelector('.noteInput')?.value || '',
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
    
@endsection
