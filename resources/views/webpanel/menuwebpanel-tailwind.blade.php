<!doctype html>
<html>
  <head>
{{--     <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.0.0/dist/flowbite.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>


    <!-- datepicker -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

   <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
   
   <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    @vite('resources/css/app.css')
 --}}

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" />

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

    <!-- Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
 
  </head>

  <style>
   
    body{
        /* font-family: 'Prompt', sans-serif; */
        /* font-family: 'Helvetica Neue', 'Arial', sans-serif; Sarabun */
        /* font-family: "Sarabun", sans-serif;  */
      /*   font-family: "Bai Jamjuree", sans-serif;
        font-weight: 400; */
    }

    li {
        font-size: 15px;
    }
    #dashboardMenu {
      background-color: none;
      color: white;
    }
    #dashboardMenu:hover {
      background-color: rgb(16, 100, 89);
      color: white;
    }
    #adminMenu {
      background-color: none;
      color: white;
    }
    #adminMenu:hover {
      background-color: rgb(16, 100, 89);
      color: white;
    }
    #storeMenu {
      background-color: none;
      color: white;
    }
    #storeMenu:hover {
      background-color: rgb(16, 100, 89);
      color: white;
    }
    #admin_all {
      background-color: none;
      color: white;
    }
    #admin_all:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: rgb(255, 255, 255);
    }
    #saleareaMenu {
      background-color: none;
      color: white;
    }
    #saleareaMenu:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: rgb(255, 255, 255);
    }
    #store_all {
      background-color: none;
      color: white;
    }
    #store_all:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: rgb(255, 255, 255);
    }
    #reportMenu {
      background-color: none;
      color: white;
    }
    #reportMenu:hover {
      background-color: rgb(16, 100, 89);
      color: white;
    }
    #seller_all {
      background-color: none;
      color: white;
    }
    #seller_all:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: rgb(255, 255, 255);
    }
    #seller_salearea {
      background-color: none;
      color: white;
    }
    #seller_salearea:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: rgb(255, 255, 255);
    }
    #delete_sellers {
      background-color: none;
      color: white;
    }
    #delete_sellers:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: rgb(255, 255, 255);
    }
    #count_pur {
      background-color: none;
      color: white;
    }
    #count_pur:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: rgb(255, 255, 255);
    }
    #alertMenu {
      background-color: none;
      color: white;
    }
    #alertMenu:hover {
      background-color: rgb(16, 100, 89);
      color: white;
    }
    #alert_register:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: rgb(255, 255, 255);
    }
    #alert_register {
      background-color: none;
      color: white;
    }
    #alert_update:hover {
      background-color: rgba(122, 122, 122, 0.378);
      color: rgb(255, 255, 255);
    }
    #alert_update {
      background-color: none;
      color: white;
    }
    #settingMenu {
      background-color: none;
      color: white;
    }
    #settingMenu:hover {
      background-color: rgb(16, 100, 89);
      color: white;
    }
    #logoutMenu {
      background-color: none;
      color: white;
    }
    #logoutMenu:hover {
      background-color: rgb(181, 30, 43);
      color: white;
    }
    #alertMessage {
      background-color: none;
      color: white;
    }
    #alertMessage:hover {
      background-color: rgb(125, 16, 16);
      color: white;
    }
    #content_area {
      background-color: #FFFFFF;
      border-radius: 2px;
      min-width: 1600px;
    }
    .flex-container {
    display: flex;
    flex-wrap: wrap; /* อนุญาตให้ content ขึ้นบรรทัดใหม่ได้ */
  }


  </style>
  <body>

     <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
        </button>
        
        <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
            <ul>
                <div class="h-full px-3 py-2 overflow-y-auto bg-black-50" style="background-color: #081524;">
                        <a href="#" class="flex items-center ps-2.5 mb-3 my-3">
                            {{-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 me-3 sm:h-7" alt="Flowbite Logo" /> --}}
                            {{-- <img class="w-8 h-8 rounded-full me-3" src="/profile/profiles-2 copy.jpg" alt="user photo"> --}}
                            @yield('profile_img'); 
                            <span class="self-center text-xl font-semibold whitespace-nowrap" style="color:white;">cms.vmdrug</span>
                        </a>
                </div>
            </ul>
            <div class="h-full px-3 py-1 overflow-y-auto bg-black-50" style="background-color: #0f1e2f;">
              {{-- font-medium --}}
            <ul class="space-y-2">
                <li class="py-1">
                    <a href="/webpanel" class="py-2 flex items-center p-2 text-gray-900 rounded-lg" id="dashboardMenu">
                        <i class="fa-solid fa-tv" style="color:white;"></i>
                        <span class="ms-3" style="color:white;">หน้าหลัก</span>
                    </a>
                </li>
                {{-- <hr class="my-2" style="color:rgb(106, 109, 170);"> --}}
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100" id="adminMenu" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                    {{-- <i class="fa-regular fa-user"></i> --}}
                  <svg class="w-5 h-5 text-gray-800" style="color:white;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                     <path fill-rule="evenodd" d="M12 2a7 7 0 0 0-7 7 3 3 0 0 0-3 3v2a3 3 0 0 0 3 3h1a1 1 0 0 0 1-1V9a5 5 0 1 1 10 0v7.083A2.919 2.919 0 0 1 14.083 19H14a2 2 0 0 0-2-2h-1a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h1a2 2 0 0 0 1.732-1h.351a4.917 4.917 0 0 0 4.83-4H19a3 3 0 0 0 3-3v-2a3 3 0 0 0-3-3 7 7 0 0 0-7-7Zm1.45 3.275a4 4 0 0 0-4.352.976 1 1 0 0 0 1.452 1.376 2.001 2.001 0 0 1 2.836-.067 1 1 0 1 0 1.386-1.442 4 4 0 0 0-1.321-.843Z" clip-rule="evenodd"/>
                  </svg>
                   
                      <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap" style="font-size:15px;">แอดมิน</span>
                      <i class="fa-solid fa-plus m-2"></i>
                   </button>
                      <ul id="dropdown-example" class="hidden py-2 space-y-2">
                            <li style="margin-left: 35px;">
                               <a href="/webpanel/admin" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group" id="admin_all" style="font-size:14px;">ทั้งหมด</a>
                            </li>
                            <li style="margin-left: 35px;">
                              <a href="/webpanel/active-user" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group" id="saleareaMenu" style="font-size:14px;">สถานะการออนไลน์แอดมิน</a>
                           </li>
                            <li style="margin-left: 35px;">
                               <a href="/webpanel/sale" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group" id="saleareaMenu" style="font-size:14px;">เขตการขาย<span style="background-color:rgba(26, 81, 221, 0.79); padding: 5px; border-radius:20px; font-size:12px; margin-left:6px;">sale</span></a>
                            </li>
                            
                         {{--   <li>
                               <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Invoice</a>
                            </li> --}}
                      </ul>
                </li>
                {{-- <hr class="my-2" style="color:rgb(106, 109, 170);"> --}}
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-base  text-sm text-gray-900 transition duration-75 rounded-lg group" id="storeMenu" aria-controls="dropdown-customer" data-collapse-toggle="dropdown-customer">
                    <i class="fa-solid fa-store ms-1" style="color:white;"></i>
                      <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap" style="font-size:15px;">ร้านค้า</span>
                      <i class="fa-solid fa-plus m-2"></i>
                   </button>
                      <ul id="dropdown-customer" class="hidden py-2 space-y-2">
                            <li style="margin-left: 35px;">
                                <a href="/webpanel/customer" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group" id="store_all" style="font-size:14px;">ทั้งหมด</a>
                            </li>
                            <li style="margin-left: 35px;">
                                <a href="/webpanel/check-updated" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group" id="store_all" style="font-size:14px;">ตรวจสอบใบอนุญาต</a>
                           </li>
                         {{--   <li>
                               <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Invoice</a>
                            </li> --}}
                      </ul>
                </li>
                <li>
                  <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group" id="reportMenu" aria-controls="dropdown-report" data-collapse-toggle="dropdown-report">
                  {{-- <i class="fa-regular fa-user"></i> --}}
                  <svg class="w-6 h-6 text-gray-800" style="color:white;" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                     <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5"/>
                   </svg>
                   
                 
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap" style="font-size:15px;">รายงาน</span>
                    <i class="fa-solid fa-plus m-2"></i>
                 </button>
                    <ul id="dropdown-report" class="hidden py-2 space-y-2">
                          <li style="margin-left: 35px;">
                             <a href="/webpanel/report/seller" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group" id="seller_all" style="font-size:14px;">การขายสินค้า</a>
                          </li>
                          <li style="margin-left: 35px;">
                            <a href="/webpanel/report/fdareporter" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group" id="seller_all" style="font-size:14px;">แบบ ข.ย.13</a>
                         </li>
                          <li style="margin-left: 35px;">
                             <a href="/webpanel/report/product" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group" id="seller_salearea" style="font-size:14px;">สินค้าขายดี</a>
                          </li>
                          <li style="margin-left: 35px;">
                            <a href="/webpanel/report/count-purchase" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group" id="count_pur" style="font-size:14px;">จำนวนครั้งสั่งซื้อ</a>
                          </li>
                          <li style="margin-left: 35px;">
                            <a href="/webpanel/report/sum-purchase" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group" id="count_pur" style="font-size:14px;">สรุปจำนวนครั้งสั่งซื้อ</a>
                          </li>
                          <li style="margin-left: 35px;">
                            <a href="/webpanel/report/delete-sale" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group" id="delete_sellers" style="font-size:14px;">ลบข้อมูลการขาย</a>
                         </li>
                       {{--   <li>
                             <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Invoice</a>
                          </li> --}}
                    </ul>
              </li>
                <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group" id="alertMenu" aria-controls="dropdown-alert" data-collapse-toggle="dropdown-alert">
                  <i class="fa-regular fa-bell" style="font-size:18px; color:white"></i>
                     <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap" style="font-size:15px;">แจ้งเตือน</span>
                     <span class="inline-flex items-center justify-center p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300" style="color:white; padding:10px; max-height:24px; background-color:brown;"><p>@yield('status_alert')</p></span>
               </button>
               <ul id="dropdown-alert" class="hidden py-2 space-y-2">
                    <li style="margin-left: 25px;">
                        <a href="/webpanel/customer/status/waiting" class="flex items-center w-full p-2 transition duration-75 rounded-lg group" id="alert_register">
                              <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap" style="font-size:14px;">รอดำเนินการ</span>
                              <span class="inline-flex items-center justify-center text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300" style="color:white; padding:10px; max-height:24px; background-color:rgb(17, 88, 211);"><p>@yield('status_waiting')</p></span>
                        </a>
                    </li>

                    <li style="margin-left: 25px;">
                      <a href="/webpanel/customer/status/new_registration" class="flex items-center w-full p-2 transition duration-75 rounded-lg group" id="alert_update">
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap" style="font-size:14px;">ลงทะเบียนใหม่</span>
                            <span class="inline-flex items-center justify-center text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300" style="color:white; padding:10px; max-height:24px; background-color:rgb(12, 172, 220);"><p>@yield('status_registration')</p></span>
                      </a>
                    </li>

                    <li style="margin-left: 25px;">
                        <a href="/webpanel/customer/status/latest_update" class="flex items-center w-full p-2 transition duration-75 rounded-lg group" id="alert_update">
                              <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap" style="font-size:14px;">อัปเดตข้อมูล</span>
                              <span class="inline-flex items-center justify-center text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300" style="color:white; padding:10px; max-height:24px; background-color:rgb(186, 26, 69);"><p>@yield('status_updated')</p></span>
                        </a>
                    </li>
               </ul>
                {{-- <hr class="my-2" style="color:rgb(106, 109, 170);"> --}}
               <li>
                    <a href="/webpanel/setting" class="flex items-center p-2 text-gray-900 rounded-lg" id="settingMenu">
                        <i class="fa-solid fa-gear" style="color:white;"></i>
                        <span class="ms-3">ตั้งค่าระบบ</span>
                    </a>
                </li>
                {{-- <hr class="my-2" style="color:rgb(106, 109, 170);"> --}}
               <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg" id="logoutMenu">
                       <i class="fa-solid fa-power-off" style="margin-left:2px; color:white;"></i>
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
                 {{-- <hr class="my-2" style="color:rgb(106, 109, 170);"> --}}
            </ul>

            <div id="dropdown-cta" class="p-4 mt-6 rounded-lg bg-blue-50" role="alert" style="background-color:rgba(255, 0, 0, 0.201);">
                <div class="flex items-center mb-3">
                   <span class="bg-orange-100 text-orange-800 text-sm font-semibold me-2 px-2.5 py-0.5 rounded-sm">Alert</span>
                   <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-blue-50 inline-flex justify-center items-center w-6 h-6 text-blue-900 rounded-lg focus:ring-2 focus:ring-blue-400 p-1" data-dismiss-target="#dropdown-cta" aria-label="Close" style="background-color:brown; color:white;">
                      <span class="sr-only">Close</span>
                      <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                   </button>
                </div>
                <p class="mb-3 text-sm dark:text-blue-400" style="color:white;">
                  
                  <!-- อัปเดตใหม่ -->
                  <ul class="py-2">
                     <a href="/webpanel/customer/status/latest_update" class="flex items-center w-full p-2 transition duration-75 rounded-lg group" id="alertMessage">
                           <span class="flex-1 text-left rtl:text-left whitespace-nowrap" style="font-size:18px; color:white;">อัปเดต<sup style="background-color:rgba(198, 92, 92, 0.79); padding: 5px; border-radius:20px; font-size:12px; margin-left:6px; color:white;">New</sup></span>
                           <span class="inline-flex items-center justify-center text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300" style="color:white; padding:10px; max-height:24px; background-color:rgb(186, 26, 69);"><p>@yield('status_updated')</p></span>
                     </a>
                  </ul>

                  <!-- ลงทะเบียนใหม่ -->
                  <ul class="py-2">
                    <a href="/webpanel/customer/status/new_registration" class="flex items-center w-full p-2 transition duration-75 rounded-lg group" id="alertMessage">
                          <span class="flex-1 text-left rtl:text-left whitespace-nowrap" style="font-size:18px; color:white;">ลงทะเบียนใหม่</span>
                          <span class="inline-flex items-center justify-center text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300" style="color:white; padding:10px; max-height:24px; background-color:rgb(26, 101, 186);"><p>@yield('status_registration')</p></span>
                    </a>
                 </ul>
               
                    <?php date_default_timezone_set("Asia/Bangkok"); ?>
                    <blockquote style="color:white; font-size:16px; text-align:center;">
                     {{-- <span style="">@yield('text_alert')</span> --}}
                     </blockquote>
                  {{--   <br>
                    <blockquote style="color:white; font-size:16px;">@yield('text_alert')</blockquote> --}}
                </p>
                {{-- <a class="text-sm text-blue-800 underline font-medium hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" href="#">Turn new navigation off</a> --}}
             </div>
            </div>
        </aside>
 
<div id="content_area" class="flex-container p-4 sm:ml-64" style="background-color:rgb(229, 229, 229);">
  <p>@yield('content')</p>
</div>




  </body>

</html>