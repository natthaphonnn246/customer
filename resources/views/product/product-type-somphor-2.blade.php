<!DOCTYPE html>
<html lang="en">
    @section ('title', 'customer')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" conten="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script> --}}

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
        #alertMenu {
            background-color: none;
            color: rgb(102, 102, 102);
        }
        #alertMenu:hover {
            background-color: rgb(16, 100, 89);
            color: white;
        }
        .tr-hover:hover {
            background-color: rgb(8, 123, 110);
            color: white;
            border-radius: 5px;
        }
  
        .table tbody tr:hover {
            background-color: #f0f0f0; /* สีเมื่อ hover */
            cursor: pointer; /* เปลี่ยน cursor */
        }



    </style>
    
        @if($user_id_admin == '0000')
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
        @endsection
        {{-- <img src="{{ url('/') }}/storage/certificates/img_certstore/1dcV3LQvU5DbAW2hVAMAwHyYLLng85K9aGq4TX47.jpg"> --}}

        {{-- {{$_SERVER['REMOTE_ADDR'];}} --}}

    


    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2">
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}
        </div>
        <span class="ms-6" style="color: #8E8E8E;">แบบอนุญาตขายยา / ประเภท ร้านสมุนไพร</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        <div class="mr-6" style="text-align: right;">

            <a href="/webpanel/report/product-type/khor-yor-2/export/getcsv/somphor-2"  id="exportcsv" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export CSV</a>
            <a href="/webpanel/report/product-type/khor-yor-2/export/getexcel/somphor-2"  id="exportexcel" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export Excel</a>
    
        </div>
        <hr class="my-4" style="color: #8E8E8E; width: 100%;">
        <div class="ms-6 mr-6 mb-6" style="text-align: left;">

            <div class="col-sm-8 ms-6">
                <form class="max-w-100 mx-auto mt-2" method="get" action="/webpanel/report/product-type/somphor-2">
                    <ul class="ms-2 my-2">
                        <span>ค้นหาสินค้า : </span>
                    </ul>
                    {{-- <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label> --}}
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <!---icon -->
                        </div>
                        <input type="search" id="default-search" name="keyword" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="รหัสสินค้า | ชื่อสินค้า" />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 my-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ค้นหา</button>
                    
                    </div>
                    <p class="py-2" id="keyword_search"></p>
                    @csrf   
                </form>
            </div>

            <script>
                $( function() {
                    var dateFormat = 'dd/mm/yy',
                        from = $( "#fromcheck" )
                        .datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            numberOfMonths: 1,
                            dateFormat: 'yy-mm-dd',
                        })
                        .on( "change", function() {
                            to.datepicker( "option", "minDate", getDate( this ) );
                        }),
                        to = $( "#tocheck" ).datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        dateFormat: 'yy-mm-dd',
                        numberOfMonths: 1 //จำนวนปฎิืิทิน;
                        })
                        .on( "change", function() {
                        from.datepicker( "option", "maxDate", getDate( this ) );
                        });
                
                    function getDate( element ) {
                        var date;
                        try {
                        date = $.datepicker.parseDate( dateFormat, element.value );
                        } catch( error ) {
                        date = null;
                        }
                
                        return date;
                    }
                });
            </script>

            <div class="ms-6 mr-6 mb-2" id="protected">
                <hr class="my-3 mt-4" style="color: #8E8E8E; width: 100%;">
            
                <button id="dropdownCsvBtn" data-dropdown-toggle="dropdownCsv" style="background-color: rgb(4, 179, 1); width: 220px; border-radius:5px; color:#ffffff; height:40px;">
                    เลือกร้านค้า
                </button>
        
                <div id="dropdownCsv" class="z-10 hidden divide-y divide-gray-100 rounded-lg shadow w-44 absolute">
                    <a href="/webpanel/report/product-type/khor-yor-2" class="block px-4 py-2 text-sm" id="listCsv"">ข.ย.2</a>
                    <a href="/webpanel/customer/export/purchase/getcsv/coming" class="block px-4 py-2 text-sm" id="listCsv">สมุนไพร</a>
                </div>
                <div class="relative flex w-full mr-4">
                
                    <div class="min-h-screen bg-gray-200 flex flex-col w-full">

                    <div class="flex items-center justify-between bg-white border-b p-5 shadow-sm">
                        <h1 class="text-2xl font-bold text-gray-700">ประเภทร้านค้า : สมุนไพร</h1>
                    </div>
                
                     <div class="flex flex-1">
                
                        <aside class="w-64 bg-gray-100 p-2 border-r sticky top-0 h-screen overflow-y-auto">
                            <h1 class="text-2xl font-bold py-4 ms-6">หมวดหมู่สินค้า</h1>
                        
                            <nav class="space-y-2">
                                <a href="{{ url('/webpanel/report/product-type/somphor-2') }}" 
                                   class="block px-4 py-2 rounded-lg font-medium" id="alertMenu">
                                    สินค้าทั้งหมด
                                </a>
                                <hr style="color:#838383;">
                                @if(isset($category) && count($category) > 0)
                                    @foreach($category as $row_cat)
                                        <a href="{{ url('/webpanel/report/product-type/somphor-2/' . $row_cat->categories_id) }}" 
                                           class="block px-4 py-2 rounded-lg font-medium duration-75 transition" id="alertMenu">
                                            {{ $row_cat->categories_name }}
                                        </a>
                                        <hr style="color:#838383;">
                                    @endforeach
                                @else
                                    <p class="text-gray-400 italic">ยังไม่มีหมวดหมู่สินค้า</p>
                                @endif
                            </nav>
                        </aside>
                        
                        
                
                        <main class="flex-1 p-0 bg-white w-full">
                            <div class="overflow-x-auto w-full">
                                <table class="table table-striped table-bordered table-hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:2%;">#</th>
                                            <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">รหัสสินค้า</th>
                                            <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:20%;">ชื่อสินค้า</th>
                                            <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:10%;">ชื่อสามัญทางยา</th>
                                            <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:10%;">ประเภทร้านค้า</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($som_phor_2) && count($som_phor_2) > 0) 
                                        @php 
                                            // $start = 1;
                                        @endphp
                                        
                                        @foreach($som_phor_2 as $row)
                                            <tr class="tr-hover">

                                                <td style="text-align: center; color:#6b6b6b;">{{ $start++ }}</td>
                                                <td style="text-align: center; color:#6b6b6b;">{{ $row->product_id }}</td>
                                                <td style="text-align: left; color:#05b46e;">{{ $row->product_name }}</td>
                                                <td style="text-align: left; color:#6b6b6b;">{{ $row->generic_name }}</td>
                                                <td style="text-align: center; color:#6b6b6b;">{{ $row->som_phor_2 == 1 ? 'สมุนไพร':'' }}</td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <td colspan="5" style="text-align: center; color:#6b6b6b;">ไม่พบสินค้าประเภท ร้านค้า: สมุนไพร</td>
                                        @endif
                                    </tbody>
                                        
                            </table>
                
                            </div>
                        </main>
                
                    </div>
                </div>
                
            
                
                
          
            </div>
            
        </div>

    </div>

    <div class="ms-12 mb-6">
        @if($total_page > 1)
            <nav aria-label="Page navigation example">
            <ul class="pagination py-4">
            <li class="page-item">

            @if ($page == 1)
                <a class="page-link" href="/webpanel/report/product-type/somphor-2?page=<?=1 ; ?>" aria-label="Previous">
                <span aria-hidden="true">Previous</span>
                </a>
            @else
                <a class="page-link" href="/webpanel/report/product-type/somphor-2?page=<?= $page-1 ; ?>" aria-label="Previous">
                <span aria-hidden="true">Previous</span>
                </a>
            @endif
            </li>

            @if($total_page > 14)

                @for ($i= 1; $i <= 10 ; $i++)
                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product-type/somphor-2?page={{ $i }}">{{ $i }}</a></li>
                @endfor
                <li class="page-item"><a class="page-link">...</a></li>
                @for ($i= $total_page-1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/report/product-type/somphor-2?page={{ $i }}">{{ $i }}</a></li>
                @endfor

            @else
                @for ($i= 1; $i <= $total_page ; $i++)
                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/report/product-type/somphor-2?page={{ $i }}">{{ $i }}</a></li>
                @endfor
            
            @endif

            <li class="page-item">
            
            @if ($page == $total_page)
                <a class="page-link" href="/webpanel/report/product-type/somphor-2?page={{ $page }}" aria-label="Next">
                <span aria-hidden="true">next</span>
                </a>
            @else
                <a class="page-link" href="/webpanel/report/product-type/somphor-2?page={{ $page + 1 }}" aria-label="Next">
                <span aria-hidden="true">next</span>
                </a>
            @endif
            </li>
            </ul>
            </nav>

            <hr>
            <div class="py-3">
                <p class="text-sm" style="color:#898989;"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
            </div>

        @else
        <hr>
        <div class="py-3">
            <p class="ms-8 text-sm" style="color:#898989;"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
        </div>
        @endif
    </div>
</div>
@endsection
</body>
</html>
