@props([
    'statusAlert' => 0,
    'statusWaiting' => 0,
    'statusRegistration' => 0,
    'statusUpdated' => 0,
])

<div
    x-data="{
        sidebarOpen: false,
        admin: false,
        store: false,
        report: false,
        product: false,
        alert: false
    }"
>

    {{-- ========== TOPBAR (Mobile) ========== --}}
    <header
        class="fixed top-0 left-0 right-0 z-40 h-14
               flex items-center justify-between
               bg-slate-900 text-white px-4 sm:hidden"
    >
        <button
            @click="sidebarOpen = true"
            class="p-2 rounded-lg hover:bg-slate-700"
        >
            <i class="fa-solid fa-bars"></i>
        </button>

        <span class="font-semibold">cms.vmdrug</span>

        <div class="flex items-center gap-2">
            {{ $profile ?? '' }}
        </div>
    </header>

    {{-- Overlay (mobile) --}}
    <div
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/50 z-40 sm:hidden"
        x-transition
    ></div>

    {{-- ========== SIDEBAR ========== --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed top-0 left-0 z-50 w-64 h-screen
               bg-slate-900 text-white
               transform transition-transform
               sm:translate-x-0 sm:z-30"
    >

        {{-- Header (desktop) --}}
        <div class="hidden sm:flex px-4 py-4 border-b border-slate-700 items-center gap-3 bg-slate-800">
            {{ $profile ?? '' }}
            <span class="text-xl font-semibold">cms.vmdrug</span>
        </div>

        {{-- Menu --}}
        <nav class="mx-auto text-sm text-center">
            <ul class="space-y-1 p-4 !text-base">

                {{-- Dashboard --}}
                <li>
                    <a href="/webpanel"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg hover:!bg-orange-800 text-white !no-underline">
                        <i class="fa-solid fa-tv"></i>
                        <span>หน้าหลัก</span>
                    </a>
                </li>
                <hr class="mt-2 mb-2">
                
                {{-- Admin --}}
                <li x-data="{ admin: false }">
                    <button
                        @click="admin = !admin"
                        class="flex items-center w-full gap-3 px-3 py-2 !rounded-lg hover:bg-orange-800"
                    >
                        <i class="fa-solid fa-user-shield"></i>
                        <span class="flex-1 text-left">แอดมิน</span>
                        <i class="fa-solid text-xs transition-transform duration-300"
                           :class="admin ? 'fa-minus rotate-180' : 'fa-plus'"></i>
                    </button>
                
                    <ul
                        x-ref="adminMenu"
                        class="mt-1 space-y-1 text-start overflow-hidden transition-all duration-300"
                        :style="admin
                            ? 'max-height:' + $refs.adminMenu.scrollHeight + 'px'
                            : 'max-height:0px'"
                    >
                        <li>
                            <a href="/webpanel/admin"
                               class="block px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                ทั้งหมด
                            </a>
                        </li>
                        <li>
                            <a href="/webpanel/active-user"
                               class="block px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                สถานะการออนไลน์
                            </a>
                        </li>
                        <li>
                            <a href="/webpanel/sale"
                               class="flex justify-between px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                เขตการขาย
                                <span class="text-xs bg-blue-600 px-2 rounded-full">sale</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <hr class="mt-2 mb-2">

                {{-- Store --}}
                <li x-data="{ store: false }">
                    <button
                        @click="store = !store"
                        class="flex items-center w-full gap-3 px-3 py-2 !rounded-lg hover:bg-orange-800"
                    >
                        <i class="fa-solid fa-store"></i>
                        <span class="flex-1 text-left">ร้านค้า</span>
                        <i class="fa-solid text-xs transition-transform duration-300"
                           :class="store ? 'fa-minus rotate-180' : 'fa-plus'"></i>
                    </button>
                
                    <ul
                        x-ref="storeMenu"
                        class="mt-1 space-y-1 text-start overflow-hidden transition-all duration-300"
                        :style="store
                            ? 'max-height:' + $refs.storeMenu.scrollHeight + 'px'
                            : 'max-height:0px'"
                    >
                        <li>
                            <a href="/webpanel/customer"
                               class="block px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                ทั้งหมด
                            </a>
                        </li>
                        <li>
                            <a href="/webpanel/check-updated"
                               class="block px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                ตรวจสอบใบอนุญาต
                            </a>
                        </li>
                    </ul>
                </li>
                <hr class="mt-2 mb-2">

                {{-- Report --}}
                <li x-data="{ report: false }">
                    <button
                        @click="report = !report"
                        class="flex items-center w-full gap-3 px-3 py-2 !rounded-lg hover:bg-orange-800"
                    >
                        <i class="fa-solid fa-chart-column"></i>
                        <span class="flex-1 text-left">รายงาน</span>
                        <i
                            class="fa-solid text-xs transition-transform duration-300"
                            :class="report ? 'fa-minus rotate-180' : 'fa-plus'"
                        ></i>
                    </button>
                
                    <ul
                        x-ref="reportMenu"
                        class="mt-1 space-y-1 text-start overflow-hidden transition-all duration-300"
                        :style="report
                            ? 'max-height:' + $refs.reportMenu.scrollHeight + 'px'
                            : 'max-height:0px'"
                    >
                        <li>
                            <a href="/webpanel/report/seller"
                               class="block px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                การขายสินค้า
                            </a>
                        </li>
                        <li>
                            <a href="/webpanel/report/fdareporter"
                               class="block px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                แบบ ข.ย.13
                            </a>
                        </li>
                        <li>
                            <a href="/webpanel/report/product"
                               class="block px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                สินค้าขายดี
                            </a>
                        </li>
                        <li>
                            <a href="/webpanel/report/product/deadstock"
                               class="block px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                สินค้าไม่เคลื่อนไหว
                            </a>
                        </li>
                    </ul>
                </li>
                <hr class="mt-2 mb-2">

                {{-- product --}}
                <li x-data="{ product: false }">
                    <button
                        @click="product = !product"
                        class="flex items-center w-full gap-3 px-3 py-2 !rounded-lg hover:bg-orange-800"
                    >
                        <i class="fa-solid fa-folder-open"></i>
                        <span class="flex-1 text-left">สินค้า</span>
                        <i
                            class="fa-solid text-xs transition-transform duration-300"
                            :class="product ? 'fa-minus rotate-180' : 'fa-plus'"
                        ></i>
                    </button>
                
                    <ul
                        x-ref="submenu"
                        class="mt-1 space-y-1 text-start overflow-hidden transition-all duration-300"
                        :style="product
                            ? 'max-height:' + $refs.submenu.scrollHeight + 'px'
                            : 'max-height:0px'"
                    >
                        <li>
                            <a href="/webpanel/report/product-type"
                               class="block px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                แบบอนุญาตขายยา
                            </a>
                        </li>
                        <li>
                            <a href="/webpanel/report/product/limited-sales"
                               class="block px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                สินค้าจำกัดการขาย
                            </a>
                        </li>
                        <li>
                            <a href="/webpanel/report/status-type"
                               class="block px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                สถานะการใช้งาน
                            </a>
                        </li>
                    </ul>
                </li>
                <hr class="mt-2 mb-2">

                {{-- Alert --}}
                <li x-data="{ alert: false }">
                    <button
                        @click="alert = !alert"
                        class="flex items-center w-full gap-3 px-3 py-2 !rounded-lg hover:bg-orange-800"
                    >
                        <i class="fa-regular fa-bell"></i>
                        <span class="flex-1 text-left">แจ้งเตือน</span>
                        <p class="text-xs bg-red-600 px-2 rounded-full items-center">
                            {{ $statusAlert }}
                        </p>
                    </button>
                
                    <ul
                        x-ref="alertMenu"
                        class="mt-1 space-y-1 text-start overflow-hidden transition-all duration-300"
                        :style="alert
                            ? 'max-height:' + $refs.alertMenu.scrollHeight + 'px'
                            : 'max-height:0px'"
                    >
                        <li>
                            <a href="/webpanel/customer/status/waiting"
                               class="flex justify-between px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                <span>รอดำเนินการ</span>
                                <p class="text-center text-xs bg-blue-600 px-2 rounded-full">
                                    {{ $statusWaiting }}
                                </p>
                            </a>
                        </li>
                
                        <li>
                            <a href="/webpanel/customer/status/new_registration"
                               class="flex justify-between px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                <span>ลงทะเบียนใหม่</span>
                                <p class="text-xs bg-cyan-600 px-2 rounded-full">
                                    {{ $statusRegistration }}
                                </p>
                            </a>
                        </li>
                
                        <li>
                            <a href="/webpanel/customer/status/latest_update"
                               class="flex justify-between px-3 py-2 hover:bg-orange-800 rounded-lg text-white !no-underline">
                                <span>อัปเดตข้อมูล</span>
                                <p class="text-xs bg-rose-600 px-2 rounded-full">
                                    {{ $statusUpdated }}
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <hr class="mt-2 mb-2">

                {{-- setting --}}
                <li>
                    <a href="/webpanel/setting"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-white hover:bg-orange-800 !no-underline">
                        <i class="fa-solid fa-solid fa-gear"></i>
                        <span>ตั้งค่าระบบ</span>
                    </a>
                </li>
                <hr class="mt-2 mb-2">

                {{-- Logout --}}
                <li>
                    <a href="/logout"
                        id="logout"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-red-800 text-white !no-underline">
                        <i class="fa-solid fa-power-off"></i>
                        <span>ออกจากระบบ</span>
                    </a>
                </li>

                <script>
                    document.getElementById('logout').addEventListener('click', function(event) {
                       event.preventDefault();
                       Swal.fire({
                          title: 'ออกจากระบบใช่หรือไม่?',
                          text: "กรุณายืนยัน",
                          icon: 'question',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'ออกจากระบบ',
                          cancelButtonText: 'ยกเลิก'
                       }).then((result) => {
                          if (result.isConfirmed) {
                             window.location.href = "/logout";
                          }
                       });
                    });
                </script>

            </ul>

            <div
                x-data="{ open: true }"
                x-show="open"
                x-transition
                class="mt-6 rounded-xl !bg-red-900/50 p-4 text-white shadow-lg mx-3"
                role="alert"
            >
                {{-- Header --}}
                <div class="flex items-center mb-4">
                    <span class="text-xm font-semibold bg-red-800 px-3 mx-auto py-1 rounded-full">
                        แจ้งเตือนระบบ
                    </span>

                    <button
                        @click="open = false"
                        class="ml-auto flex h-7 w-7 items-center justify-center !rounded-full hover:bg-white/30 transition"
                        aria-label="Close"
                    >
                        ✕
                    </button>
                </div>

                {{-- Alert list --}}
                <div class="space-y-3 text-sm">

                    {{-- อัปเดตใหม่ --}}
                    <a
                        href="/webpanel/customer/status/latest_update"
                        class="flex items-center justify-between rounded-lg bg-white/10 px-3 py-2 hover:bg-red-800 !no-underline transition"
                    >
                        <span class="flex items-center gap-2 text-base text-white">
                            อัปเดต
                            <span class="text-xs bg-yellow-400 text-black px-2 py-0.5 rounded-full">
                                NEW
                            </span>
                        </span>

                        <span class="text-xs font-semibold bg-red-700 px-2 py-1 rounded-full text-white">
                            {{ $statusUpdated }}
                        </span>
                    </a>

                    {{-- ลงทะเบียนใหม่ --}}
                    <a
                        href="/webpanel/customer/status/new_registration"
                        class="flex items-center justify-between rounded-lg bg-white/10 px-3 py-2 hover:bg-red-800 !no-underline transition"
                    >
                        <span class="text-base text-white">
                            ลงทะเบียนใหม่
                        </span>

                        <span class="text-xs font-semibold bg-blue-700 px-2 py-1 rounded-full text-white">
                            {{ $statusRegistration }}
                        </span>
                    </a>

                </div>

                {{-- Optional message --}}
                {{--    @hasSection('text_alert')
                        <div class="mt-4 text-center text-sm text-white/90">
                            {{ $statusRegistration }}
                        </div>
                    @endif --}}
            </div>

        </nav>
    </aside>
</div>