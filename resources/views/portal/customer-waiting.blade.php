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

    <title>cms.vmdrug</title>
</head>
<body>

    @extends ('portal/menuportal-tailwind')
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
        #adminRole {
            background-color: #007bff;
            color: #FFFFFF;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #adminRole:hover {
            background-color: #0b59f6;
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
        #trash {
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
        #protected {
        position: relative;
        }

        #protected::after {
                    content: "© cms.vmdrug";
                    position: fixed; /* เปลี่ยนจาก absolute → fixed */
                    top: 50%;
                    left: 50%;
                    font-size: 120px;
                    /* color: rgba(234, 43, 43, 0.111); */
                    color: rgba(170, 170, 170, 0.111);
                    pointer-events: none;
                    padding-top: 30px;
                    transform: translate(-50%, -50%);
                    white-space: nowrap;
                    z-index: 9999; /* กันโดนซ่อนโดย content อื่น */
        }
        .disabled-link {
            pointer-events: none;   /* กดไม่ได้ */
            opacity: 0.4;           /* ทำให้ปุ่มจางลง */
            cursor: not-allowed;    /* เมาส์เป็นรูปห้าม */
            text-decoration: none;  /* เอาเส้นใต้ลิงก์ออก (ถ้าอยากให้ดูเหมือนปุ่ม) */
        }

        .alert-icon {
            animation: shake 1s infinite; /* 1s ต่อรอบ, ทำซ้ำไม่จำกัด */
            display: inline-block;
                }

        /* animation shake */
        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-3px); }
            50% { transform: translateX(3px); }
            75% { transform: translateX(-3px); }
            100% { transform: translateX(0); }
        }
    </style>

    <div class="contentArea">
        
            @section('col-2')

            @if(isset($user_name))
                <h6 class="mt-1" style="">{{$user_name->name}}</h6>
                @endif
            @endsection

            @section('status_alert')
            @if($user_name->rights_area != '0')
                <h6 class="justifiy-content:center;" style="">{{$count_alert}}</h6>
                @endif
            @endsection

            @section('status_all')
            @if($user_name->rights_area != '0')
                <h6 class="justifiy-content:center;" style="">{{$count_all}}</h6>
                @endif
            @endsection

            @section('status_waiting')
            @if($user_name->rights_area != '0')
                <h6 class="justifiy-content:center;" style="">{{$count_waiting}}</h6>
                @endif
            @endsection

            @section('status_action')
            @if($user_name->rights_area != '0')
                <h6 class="justifiy-content:center;" style="">{{$count_action}}</h6>
                @endif
            @endsection

            @section('status_completed')
            @if($user_name->rights_area != '0')
                <h6 class="justifiy-content:center;" style="">{{$count_completed}}</h6>
                @endif
            @endsection
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}
    
            <div class="modal fade" id="checkModal" tabindex="-1" aria-labelledby="checkModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header text-center">
                      <h5 class="modal-title w-100 text-center" style="font-size: 24px; font-weight:400; color: rgb(249, 48, 48);">ปิดแก้ไขข้อมูลลูกค้าชั่วคราว</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                    </div>
                    <div class="modal-body text-center">
                    <p style="color: red; font-size:72px;">
                        <i class="fa-regular fa-triangle-exclamation alert-icon"></i>
                    </p>
                        
                      <p style="color: rgb(0, 68, 255); font-size:24px;">กรุณากลับมาอีกครั้งในภายหลัง</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" id="acknowledgeBtn" class="btn btn-primary">รับทราบ</button>
                    </div>
                  </div>
                </div>
            </div>

            <script>
                let checkEdit = @json($check_edit); // จะได้ boolean จริง ๆ
                if(checkEdit) {
                    var myModal = new bootstrap.Modal(document.getElementById('checkModal'));
                    myModal.show();

                    document.getElementById('acknowledgeBtn').addEventListener('click', function () {
                        var modal = bootstrap.Modal.getInstance(document.getElementById('checkModal'));
                        modal.hide();
                    });

                }
            </script>
            
            <div class="py-2">
            </div>
            <span class="ms-6" style="color: #8E8E8E;">ข้อมูลลูกค้า /Status : <span style="color:rgb(255, 255, 255);  padding: 5px 10px 5px 10px; background-color: rgb(255, 70, 70); border-radius:8px;">รอดำเนินการ</span></span>
            <hr class="my-4" style="color: #8E8E8E; width: 100%; border:solid 2px;">

            <div class="ms-6 mr-6" id="protected">
            <div class="row">
                <!--- search --->
                <div style="display: flex; justify-content: center;">
                    <form class="py-3" style="width:80%;" method="get" action="/portal/customer/status/waiting">
                        {{-- <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label> --}}
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <!---icon -->
                            </div>
                            <input type="search" id="default-search" name="keyword" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="CODE" />
                            <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 my-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ค้นหา</button>
                        
                        </div>
                        <p class="py-2" id="keyword_search"></p>
                        @csrf   
                    </form>
                </div>

                {{-- <script>
                    $(document).ready(function() {
                        $('#default-search').keyup(function(e) {
                            e.preventDefault();  // Prevent form from submitting

                            $.ajax({
                                url: '/portal/customer/search/code',
                                method: 'GET',
                                data: {
                                    keyword: $(this).val(),

                                },
                                catch:false,
                                success: function(data) {
                                    
                                    $('#keyword_search').html(data);

                                }
                            });
                           /*  let keyword = $(this).val();
                            console.log(keyword ); */
                        });
                    });
                </script> --}}
 {{--                <div class="col-3" style="text-align: right; padding:5px 30px;; margin-top:10px;">

                            <div id="reports">
                                <div style="cursor: pointer; text-align: right; font-weight:500;" id="submenu">  
                                    <i class="fa-regular fa-bell" style="font-size: 25px;"></i>
                                    <sup style="background-color: #e12e49; border-radius: 20px; padding: 10px; color: white;">{{$count_waiting + $count_action}}<span style="font-size:20px;">+</span></sup>
                                </div>
                            </div>
            
                            <div class="sub-menus" style=" display: none; margin-top: 15px;">
                            
                                
                        <select class="form-control" name="" id="noti_status" >
                            <option value="1">ทั้งหมด : {{$count_waiting + $count_action + $count_completed}} ร้านค้า</option>
                            <option {{ 'waiting' == $status_customer ? 'selected': '' ;}} value="2">รอดำเนินการ : {{$count_waiting}} ร้านค้า</option>
                            <option value="3">ต้องดำเนินการ : {{$count_action}} ร้านค้า</option>
                            <option value="4">ดำเนินการแล้ว : {{$count_completed}} ร้านค้า</option>
                        </select> 

                            </div>
                </div> --}}
            </div>

        {{--  <script>
                    $(document).ready(function () {

                        $("#noti_status").change(function () {

                            let all = $(this).val();
                            
                            switch ($(this).val())
                            {
                                case "1":
                                    window.location.href ="/portal/customer";
                                    console.log('ทั้งหมด');
                                    break;
                                case "2":
                                    window.location.href ="/portal/customer/status/waiting";
                                    console.log('รอดำเนินการ');
                                    break;
                                case "3":
                                    window.location.href ="/portal/customer/status/action";
                                    console.log('ต้องดำเนินการ');
                                    break;
                                case "4":
                                    window.location.href ="/portal/customer/status/completed";
                                    console.log('ดำเนินการแล้ว');
                                    break;
                                default:
                                    window.location.href ="/portal/customer";
                                    console.log('ไม่ระบุ');
                                    break;
                            }
                        
                            // alert("Change Status");
                        });
                    });
            </script> --}}
        
       {{--  <hr style="color: #8E8E8E; width: 100%;">

        <div style="text-align: left;">
            <a href="/webpanel/customer-create"  id="admin" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">เพิ่มลูกค้าใหม่</a>
            <a href="/webpanel/admin-role"  id="adminRole" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">จัดการสิทธิ์</a>
    
        </div> --}}

        <hr style="color: #8E8E8E; width: 100%;">
        
        <div class="py-2">
        <table class="table table-striped">
            <thead>
              <tr>
                <td scope="col" style="color:#838383; text-align: left; font-weight:500; padding:20px;">#</td>
                <td scope="col" style="color:#838383; text-align: left; font-weight:500; padding:20px;">CODE</td>
                <td scope="col" style="color:#838383; text-align: left; font-weight:500; padding:20px;">อีเมล</td>
                <td scope="col" style="color:#838383; text-align: left; font-weight:500; padding:20px;">Sale area</td>
                <td scope="col" style="color:#838383; text-align: left; font-weight:500; padding:20px;">ชื่อร้านค้า</td>
                <td scope="col" style="color:#838383; text-align: center; font-weight:500; padding:20px;">สถานะ</td>
                <td scope="col" style="color:#838383; text-align: center; font-weight:500; padding:20px;">วันที่ลงทะเบียน</td>
                <td scope="col" style="color:#838383; text-align: center; font-weight:500; padding:20px;">จัดการ</td>
              </tr>
            </thead>
            <tbody>
                @if(!empty($customer_list))
                <?php 
                    $start += 1;
                ?>
                @foreach ($customer_list as $row_list)
              <tr>
                    <?php
                        
                        $id = $row_list->id;
                        $customer_name = $row_list->customer_name;
                        $customer_code = $row_list->customer_code;
                        $sale_area = $row_list->sale_area;
                        $status_admin = $row_list->sale_area;
                        $email = $row_list->email;
                        $status = $row_list->status;
                        $created_at = $row_list->created_at;
                        $customer_status = $row_list->customer_status;
                    ?>
                
                @if($customer_status == 'active')
                    <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px; ">{{$start++}}</td>
                    <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px; ">{{$customer_code}}</td>
                    <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px; ">{{$email}}</td>
                    <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px; ">{{$sale_area}}</td>
                    <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px; width: 20%;">{{$customer_name}}</td>

                        @if ($status == 'รอดำเนินการ')
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;"> <span style="border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(255, 70, 70);">รอดำเนินการ</span></td>
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px;"><i class="fa-solid fa-circle" style="color: rgb(255, 70, 70);"></i> รอดำเนินการ</td> --}}
                        @elseif ($status == 'ต้องดำเนินการ')
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;"><span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(255, 182, 11);">ต้องดำเนินการ</span></td>
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px;"><i class="fa-solid fa-circle" style="color: rgb(251, 183, 23);"></i> ต้องดำเนินการ</td> --}}
                        @elseif ($status == 'ดำเนินการแล้ว')
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: left;"><i class="fa-solid fa-circle" style="color: rgb(4, 181, 30);"></i> ดำเนินการแล้ว</td> --}}
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;"> <span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(58, 174, 19);">ดำเนินการแล้ว</span></td>
                        @else
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;"> </td>
                        @endif

                    <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px; ">{{$created_at}}</td>
{{-- 
                    <td scope="row" style="color:#9C9C9C; text-align: center; padding:15px;"><a href="/portal/customer/{{$id}}" id="edit"><i class="fa-regular fa-eye"></i></a> --}}
                    {{-- <button id="trash"><i class="fa-regular fa-trash-can"></i></button> --}}
                    @php
                        $dis_check =  $check_edit;
                        $dis_check = $dis_check > 0;
                    @endphp

                    <td scope="row" style="color:#9C9C9C; text-align:center; padding:15px;">
                        <a href="{{ $dis_check ? 'javascript:void(0)' : '/portal/customer/'.$id }}"
                            id="edit"
                            class="{{ $dis_check ? 'disabled-link' : '' }}">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                    </td>
                  
                @endif
              </tr>
    
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
{{-- {{dd($total_page);}} --}}
          @if($total_page > 1)
          <nav aria-label="Page navigation example">
            <ul class="pagination py-4">
            <li class="page-item">

            @if ($page == 1)
                <a class="page-link" href="/portal/customer/status/waiting?page={{ 1 }}" aria-label="Previous">
                <span aria-hidden="true">Previous</span>
                </a>
            @else
                <a class="page-link" href="/portal/customer/status/waiting?page={{ $page - 1 }}" aria-label="Previous">
                <span aria-hidden="true">Previous</span>
                </a>
            @endif
            </li>

            @if($total_page > 14)

                @for ($i= 1; $i <= 10 ; $i++)
                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/portal/customer/status/waiting?page={{ $i }}">{{ $i }}</a></li>
                @endfor
                <li class="page-item"><a class="page-link">...</a></li>
                @for ($i= $total_page-1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/portal/customer/status/waiting?page={{ $i }}">{{ $i }}</a></li>
                @endfor

            @else
                @for ($i= 1; $i <= $total_page ; $i++)
                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/portal/customer/status/waiting?page={{ $i }}">{{ $i }}</a></li>
                @endfor
            
            @endif

            <li class="page-item">
            
            @if ($page == $total_page)
                <a class="page-link" href="/portal/customer/status/waiting?page={{ $page }}" aria-label="Next">
                <span aria-hidden="true">next</span>
                </a>
            @else
                <a class="page-link" href="/portal/customer/status/waiting?page={{ $page + 1 }}" aria-label="Next">
                <span aria-hidden="true">next</span>
                </a>
            @endif
            </li>
            </ul>
        </nav>
        @else
        {{-- <hr> --}}
        @endif

    </div>
</div>

@endsection

        <script>

                $(document).ready(function () {

                    $("#reports").click(function () {
                        console.log("Report");
                        $(this).next('.sub-menus').slideToggle();
                        $(this).find('.dropdown').toggleClass('rotate');
                        $(this).toggleClass("submenu"); // toggle เปิดปิดแถบสีเมนู;
                        // $('.sub-menus').css("background-color", "black", "text-align", "left");
                    

                    });
                
                });

        </script>
</body>
</html>
