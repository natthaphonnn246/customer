<div x-data="{ open: false }">

    <!-- ================= NAVBAR ================= -->
    <nav class="fixed top-0 left-0 right-0
            z-30 md:z-50
            h-14 bg-gray-800 flex items-center px-4">

        <!-- hamburger -->
        <button @click="open = true"
                class="text-white md:hidden focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <span class="flex items-center text-white font-semibold text-xl gap-1">
            {{-- <i class="fa-solid fa-gear p-2 text-blue-400"></i> --}}
            <img src="{{ asset('cms-v1.ico') }}" alt="icon" class="w-5 h-5">
            cms.vmdrug
        </span>
        

        <div class="ml-auto flex items-center text-white gap-3">
            {{ $userName }}
            <img src="/profile/user.png"
                 class="w-8 h-8 rounded-full">
        </div>
    </nav>

    <!-- ================= SIDEBAR BACKDROP (mobile) ================= -->
    <div x-show="open"
         @click="open = false"
         class="fixed inset-0 bg-black/50 z-50 md:hidden"
         x-transition></div>

    <!-- ================= SIDEBAR ================= -->
    <aside
    class="fixed top-0 left-0
           z-50 md:z-40
           h-screen w-[260px] bg-[#181822] pt-14
           transform transition-transform duration-200
           md:translate-x-0"
    :class="open ? 'translate-x-0' : '-translate-x-full'">


    <!-- ปุ่มปิด (mobile) -->
    <button
        @click="open = false"
        class="absolute top-3 right-3 text-white md:hidden
               hover:text-red-500 transition"
        aria-label="Close sidebar">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-6 h-6"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <ul class="p-3 space-y-2 text-white mt-2">
        <li>
            <a href="{{ route('portal.sign') }}"
               class="flex items-center gap-2 px-3 py-2 rounded
                      hover:bg-green-800 text-white !no-underline transition">
                <i class="fa-regular fa-address-book"></i>
                ลงทะเบียนร้านค้า
            </a>
        </li>
        <hr>
        @if($connectLine && $connectLine == 1)
        <li>
            <a href="{{ route('portal.account.profile') }}"
               class="flex items-center gap-2 px-3 py-2 rounded
                      hover:bg-green-800 !no-underline text-white transition">
                <i class="fa-regular fa-solid fa-gear"></i>
                ตั้งค่าบัญชี
            </a>
        </li>
        <hr>
        @else
            @if($allowedLine && $allowedLine === 1)
            <li>
                <a href="{{ route('portal.account.profile') }}"
                class="flex items-center gap-2 px-3 py-2 rounded
                        hover:bg-green-800 !no-underline text-white transition">
                    <i class="fa-regular fa-solid fa-gear"></i>
                    ตั้งค่าบัญชี
                </a>
            </li>
            <hr>
            @endif
        @endif
        <li>
            <a href="/logout"
               class="flex items-center gap-2 px-3 py-2 rounded
                      hover:bg-orange-800 text-white !no-underline transition">
                <i class="fa-solid fa-power-off"></i>
                ออกจากระบบ
            </a>
        </li>
    </ul>
    <div id="dropdown-cta" class="p-4 mt-6 rounded-lg bg-blue-50 bg-red-900/50 m-2" role="alert">
        <div class="flex items-center mb-3">
           <span class="bg-orange-100 text-orange-800 text-sm font-semibold me-2 px-2.5 py-0.5 rounded-sm dark:bg-orange-200 dark:text-orange-900">Alert</span>
        </div>
        <div class="mb-3 rounded-md bg-white px-4 py-3 text-sm text-red-400">
            บันทึกข้อมูลเรียบร้อยแล้ว กรุณาติดต่อผู้ดูแลระบบเพื่อเปิดใช้งาน
        </div>
        
        {{-- <a class="text-sm text-blue-800 underline font-medium hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" href="#">Turn new navigation off</a> --}}
     </div>
</aside>


    <!-- ================= CONTENT ================= -->
{{--     <main class="pt-16 px-4 md:ml-[260px]">
        @yield('content')
    </main> --}}

</div>
