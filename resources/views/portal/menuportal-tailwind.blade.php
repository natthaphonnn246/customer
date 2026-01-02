<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.0.0/dist/flowbite.min.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
    
    @vite('resources/css/app.css')
  </head>

  <style>
    body{
        font-family: 'Prompt', sans-serif;
    }
    li {
        font-size: 15px;
    }
    #dashboardPortal {
      background-color: none;
      color: white;
    }
    #dashboardPortal:hover {
      background-color: rgb(2, 119, 54);
      color: white;
    }
    #storePortal {
      background-color: none;
      color: white;
    }
    #storePortal:hover {
      background-color: rgb(2, 119, 54);
      color: white;
    }
    #registerPortal {
      background-color: none;
      color: white;
    }
    #registerPortal:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: white;
    }
    #storeallPortal {
      background-color: none;
      color: white;
    }
    #storeallPortal:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: white;
    }
    #alertPortal {
      background-color: none;
      color: white;
    }
    #alertPortal:hover {
      background-color: rgb(2, 119, 54);
      color: white;
    }
    #typePortal {
      background-color: none;
      color: white;
    }
    #typePortal:hover {
      background-color: rgb(2, 119, 54);
      color: white;
    }
    #alertlPortal_all {
      background-color: none;
      color: white;
    }
    #alertPortal_all:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: white;
    }
    #checkProduct {
      background-color: none;
      color: white;
    }
    #checkProduct:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: white;
    }
    #alertlPortal_waiting {
      background-color: none;
      color: white;
    }
    #alertPortal_waiting:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: white;
    }
    #alertlPortal_action {
      background-color: none;
      color: white;
    }
    #alertPortal_action:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: white;
    }
    #alertlPortal_completed {
      background-color: none;
      color: white;
    }
    #alertPortal_completed:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: white;
    }
    #logoutPortal {
      background-color: none;
      color: white;
    }
    #logoutPortal:hover {
      background-color: rgb(181, 30, 43);
      color: white;
    }
    #content_area {
      background-color: #FFFFFF;
      border-radius: 2px;
      min-width: 1700px;
    }
   
 /*    .halloween-decor {
        position: fixed;
        width: 60px;
        z-index: 999;
        pointer-events: none;
    }


    @keyframes float-up {
        0% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(10deg); }
        100% { transform: translateY(0) rotate(-10deg); }
    }

    .floating {
        animation-name: float-up;
        animation-duration: 3s;
        animation-iteration-count: infinite;
        animation-timing-function: ease-in-out;
    } */

  </style>
  <body>
 {{--    <h1 class="text-3xl font-bold underline">
      Hello world!
    </h1>
 --}}



 <nav class="fixed top-0 z-50 w-full border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700" style="background-color:rgb(24, 24, 34);">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start rtl:justify-end">
        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
               <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
         </button>
        <a href="#" class="flex ms-2 md:me-24">
          {{-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="FlowBite Logo" /> --}}
          {{-- <img src="/profile/logocat.jpg" class="h-8 me-3" alt="FlowBite Logo" style="border-radius:5px;"> --}}
          <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap" style="color:white;">cms.vmdrug</span>
        </a>
      </div>
      <div class="flex items-center">
          <div class="flex items-center ms-3">
            <span style="color:white; margin-right:10px;"><p>@yield('col-2')</p></span>
            <div>
              <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user" style="margin-right:20px;">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full" src="/profile/user.png" alt="user photo">
              </button>
            </div>
            {{-- <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
               <div class="px-4 py-2" role="none">
                 <p class="text-sm text-gray-900 dark:text-white" role="none">
                   <p>@yield('col-2')</p>
                 </p>
                 <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none" style="color:black;">
                     username@gmail.com 
                 </p>
               </div>
               <ul class="py-1" role="none">
                 <li>
                   <a href="/logout" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-200 dark:hover:text-white" role="menuitem" style="color:black;">Logout</a>
                 </li>
               </ul>
             </div> --}}
          </div>
        </div>
    </div>
  </div>
</nav>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar" style="background-color:rgb(24, 24, 34);">
   <div class="h-full px-3 pb-4 overflow-y-auto dark:bg-gray-800" style="background-color:rgb(24, 24, 34);">
      <ul class="space-y-2 font-medium">
         <li>
            <a href="/portal/dashboard" class="flex items-center p-2 text-gray-900 rounded-lg" id="dashboardPortal">
              {{--  <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                  <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                  <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
               </svg> --}}
               <i class="fa-solid fa-tv"></i>
               <span class="ms-3">หน้าหลัก</span>
            </a>
         </li>
         <li>
          <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg" id="storePortal" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
            <i class="fa-solid fa-store"></i>
            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">ร้านค้า</span>
            <i class="fa-solid fa-plus m-2"></i>
         </button>
            <ul id="dropdown-example" class="hidden py-2 space-y-2">
                  <li style="margin-left: 35px;">
                     <a href="/portal/signin" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11" id="registerPortal">ลงทะเบียน <span style="background-color:rgba(26, 81, 221, 0.79); padding: 5px; border-radius:20px; font-size:12px; margin-left:6px;">new</span></a>
                  </li>
                  <li style="margin-left: 35px;">
                     <a href="/portal/customer" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11" id="storeallPortal">ทั้งหมด</a>
                  </li>
               {{--   <li>
                     <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Invoice</a>
                  </li> --}}
            </ul>
         </li>
         <li>

          @if($check_type_pass || $code_pass)
          <div>
              @yield('product-type')
              <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group" id="typePortal" aria-controls="dropdown-product" data-collapse-toggle="dropdown-product">
                  <i class="fa-regular fa-folder-open"></i>
                  <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap" style="font-size:15px;">สินค้า</span>
                  <i class="fa-solid fa-plus m-2"></i>
              </button>
              <ul id="dropdown-product" class="hidden py-2 space-y-2">
                  <li style="margin-left: 35px;">
                      <a href="/portal/product-type" class="flex items-center w-full p-2 text-gray-900 pl-11 group rounded-lg" id="checkProduct" style="font-size:14px;">แบบอนุญาตขายยา</a>
                  </li>
                  <li style="margin-left: 35px;">
                      <a href="/portal/limited-sales" class="flex items-center w-full p-2 text-gray-900 pl-11 group rounded-lg"  id="checkProduct" style="font-size:14px;">สินค้าจำกัดการขาย</a>
                  </li>
                  <li style="margin-left: 35px;">
                    <a href="/portal/customer-type" class="flex items-center w-full p-2 text-gray-900 pl-11 group rounded-lg"  id="checkProduct" style="font-size:14px;">ประเภทร้านค้า</a>
                </li>
              </ul>
          </div>
        @endif
      
      
            <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg" id="alertPortal" aria-controls="dropdown-alert" data-collapse-toggle="dropdown-alert">
                  <i class="fa-regular fa-bell" style="font-size:18px;"></i>
                     <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">แจ้งเตือน</span>
                     <span class="inline-flex items-center justify-center p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300" style="color:white; padding:10px; max-height:24px; background-color:brown;"><p>@yield('status_alert')</p></span>
            </button>
            <ul id="dropdown-alert" class="hidden py-2 space-y-2">
                  <li style="margin-left: 25px;">
                     {{-- <a href="/portal/customer" class="flex items-center w-full p-2 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"> --}}
                     <a href="/portal/customer" class="flex items-center w-full p-2 transition duration-75 rounded-lg" id="alertPortal_all">
                           <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap" style="color:white;">ทั้งหมด</span>
                           <span class="inline-flex items-center justify-center text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300" style="color:white; padding:10px; max-height:24px; background-color:rgb(17, 88, 211);"><p>@yield('status_all')</p></span>
                     </a>
                  </li>
                  <li style="margin-left: 25px;">
                     <a href="/portal/customer/status/waiting" class="flex items-center w-full p-2 transition duration-75 rounded-lg" id="alertPortal_waiting">
                           <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap" style="color:white;">รอดำเนินการ</span>
                           <span class="inline-flex items-center justify-center text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300" style="color:white; padding:10px; max-height:24px; background-color:rgb(186, 26, 69);"><p>@yield('status_waiting')</p></span>
                     </a>
                  </li>
                  <li style="margin-left: 25px;">
                     <a href="/portal/customer/status/action" class="flex items-center w-full p-2 transition duration-75 rounded-lg" id="alertPortal_action">
                           <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap" style="color:white;">ต้องดำเนินการ</span>
                           <span class="inline-flex items-center justify-center text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300" style="color:white; padding:10px; max-height:24px; background-color:rgb(211, 150, 17);"><p>@yield('status_action')</p></span>
                     </a>
                  </li>
                  <li style="margin-left: 25px;">
                     <a href="/portal/customer/status/completed" class="flex items-center w-full p-2 transition duration-75 rounded-lg" id="alertPortal_completed">
                           <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap" style="color:white;">ดำเนินการแล้ว</span>
                           <span class="inline-flex items-center justify-center text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300" style="color:white; padding:10px; max-height:24px; background-color:rgb(17, 211, 49);"><p>@yield('status_completed')</p></span>
                     </a>
                  </li>
            </ul>
         </li>
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg" id="logoutPortal">
               <i class="fa-solid fa-power-off" style="margin-left:2px;"></i>
               <span id="logout" class="flex-1 ms-3 whitespace-nowrap">ออกจากระบบ</span>
            </a>

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
         </li>
      </ul>
      <div id="dropdown-cta" class="p-4 mt-6 rounded-lg bg-blue-50" role="alert" style="background-color:rgba(255, 0, 0, 0.201);">
        <div class="flex items-center mb-3">
           <span class="bg-orange-100 text-orange-800 text-sm font-semibold me-2 px-2.5 py-0.5 rounded-sm dark:bg-orange-200 dark:text-orange-900">Alert</span>
           <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 inline-flex justify-center items-center w-6 h-6 text-blue-900 rounded-lg focus:ring-2 focus:ring-blue-400 p-1 hover:bg-blue-200 dark:hover:bg-blue-800" data-dismiss-target="#dropdown-cta" aria-label="Close" style="background-color:brown; color:white;">
              <span class="sr-only">Close</span>
              <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                 <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
           </button>
        </div>
        <p class="mb-3 text-sm dark:text-blue-400" style="color:white;">
            <blockquote style="color:white; font-size:16px;">ลงทะเบียนร้านค้าสำเร็จ กรุณาแจ้งกลับด้วย</blockquote>
            <br>
            <blockquote style="color:white; font-size:16px;">โปรดตรวจสอบร้านค้าที่รับผิดชอบได้ที่เมนู "แจ้งเตือน"</blockquote>
            <br>

            @php
              $year = date('Y') + 543; 
            @endphp
            <blockquote style="color:rgb(255, 255, 255); font-size:16px;"><i style="color:rgb(255, 200, 0);" class="fa-solid fa-triangle-exclamation"></i> เริ่มอัปเดตใบอนุญาตปี {{ $year }} ได้แล้ว โปรดระบุให้ถูกต้องด้วย</blockquote>
        </p>
        {{-- <a class="text-sm text-blue-800 underline font-medium hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" href="#">Turn new navigation off</a> --}}
     </div>
   </div>
   </div>
</aside>

<div class="p-4 sm:ml-64" id="content_area" style="background-color:rgb(229, 229, 229); margin-top:65px;">
  <p>@yield('content')</p>

</div>

{{--   <script>

      document.addEventListener('DOMContentLoaded', () => {
          const body = document.getElementById('content_area');
          const month = new Date().getMonth() + 1;

          if (month === 10) {
            body.classList.add('theme-halloween');

            const positions = []; // เก็บตำแหน่งที่ใช้แล้ว
            const minDistance = 10; // หน่วยเป็น vw (ระยะห่างขั้นต่ำ)

            for (let i = 0; i < 5; i++) {
              const decor = document.createElement('img');
              decor.src = i % 2 === 0 ? '/profile/pumpkin-1.png' : '/profile/spider.gif';
              decor.className = 'halloween-decor floating';

              let left, top, tooClose;

              // สุ่มจนกว่าจะเจอตำแหน่งที่ไม่ชนกับตัวอื่น
              do {
                left = Math.random() * 90; // 0–90vw
                top = Math.random() * 12;  // 0–10vh (แถวบน)
                tooClose = positions.some(
                  (pos) => Math.abs(pos.left - left) < minDistance
                );
              } while (tooClose);

              positions.push({ left, top });

              decor.style.right = left + 'vw';
              decor.style.top = top + 'vh';
              decor.style.animationDuration = (3 + Math.random() * 3) + 's';

              body.appendChild(decor);
            }
          }
      });

  </script> --}}

{{-- <footer class="bg-white rounded-lg shadow-sm m-4 dark:bg-gray-800">
  <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
    <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="https://flowbite.com/" class="hover:underline">Flowbite™</a>. All Rights Reserved.
  </span>
  <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
      <li>
          <a href="#" class="hover:underline me-4 md:me-6">About</a>
      </li>
      <li>
          <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
      </li>
      <li>
          <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
      </li>
      <li>
          <a href="#" class="hover:underline">Contact</a>
      </li>
  </ul>
  </div>
</footer> --}}


  </body>

</html>