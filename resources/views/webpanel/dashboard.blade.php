<!DOCTYPE html>
<html lang="en">
    @section ('title', 'productmaster')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <title>CMS VMDRUG System</title>
</head>
<body>

    @extends ('webpanel/menuwebpanel-tailwind')
    @section('content')
    @csrf


    <style>
        .contentArea {
            padding: 0px;
            background-color: #FFFFFF;
            border-radius: 2px;
            min-width: 1200px;
            /* text-align: left; */
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
        <h6 class="justifiy-content:center;" style="">{{$status_registration}}</h6>
        @endsection

        @section('status_updated')
        <h6 class="justifiy-content:center;" style="">{{$status_updated}}</h6>
        @endsection

        @section('text_alert')
        <h6 class="justifiy-content:center; mt-2 ms-4 mr-6" style="background-color:#cb4d4d; border-radius:20px; padding: 5px; color:#ffffff; font-weight:500;">{{$status_updated}}</h6>
        @endsection

    <div class="contentArea">
        
        <div class="py-2">
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}
            {{-- <span class="ms-6" style="color: #8E8E8E;">หน้าแรก (Dashboard)</span> --}}
        </div>
        <span class="ms-6" style="color: #8E8E8E;">หน้าหลัก (Dashboard)</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">
        
        <div class="row ms-6" style="justify-content: left;">
            
            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    ร้านค้าทั้งหมด<br/>
                    @if (isset($customer_all))
                    <span>{{$customer_all != '' ? $customer_all : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="/webpanel/customer/status/new_registration">ลงทะเบียนใหม่</a><br/>
                    @if (isset($status_registration))
                    <span>{{$status_registration != '' ? $status_registration : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    บัญชีปกติ<br/>
                    @if (isset($count_status_normal))
                    <span>{{$customer_all != '' ? $count_status_normal : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    <a href="/webpanel/customer/status/following" style="text-decoration: none; color:white;">กำลังติดตาม</a><br/>
                    @if (isset($count_status_follow))
                    <span>{{$count_status_follow != '' ? $count_status_follow : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    ระงับบัญชี (ไม่เคลื่อนไหว)<br/>
                    @if (isset($count_status_suspend))
                    <span>{{$count_status_suspend != '' ? $count_status_suspend : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    ปิดบัญชี<br/>
                    @if (isset($count_status_closed))
                    <span>{{$count_status_closed != '' ? $count_status_closed : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

        </div>

        {{-- <hr class="my-3" style="color:#545454;"> --}}
        <hr class="my-4" style="border: solid 4px; color:#666666">
        {{-- <p class="text-gray-900 dark:text-gray text-lm leading-none mt-4 ms-4" style="color: #8E8E8E;">Customer chart</p> --}}
        {{-- <hr class="my-2"> --}}
    
            <div class="row bg-white rounded-sm dark:bg-gray-800 mr-10 ms-10">

                <div class="col-sm-6">
                    <div id="radial-chart" style="width:100%; color: #8E8E8E;">All customers</div>
                    {{-- <canvas id="doughnutCustomer"></canvas> --}}
                </div>
                <div class="col-sm-6">
                    {{-- <div style="color: #8E8E8E;">Normal customer</div> --}}
                    <canvas id="barCustomer"></canvas>
                </div>

            </div> 

            <!-- charts bar--->
            <hr class="my-4" style="border: solid 4px; color:#666666">
            <p class="text-gray-900 dark:text-gray text-lm leading-none mt-4 ms-10" style="color: #8E8E8E;">Customer chart</p>
            {{-- <hr class="my-2"> --}}

                <div class="row bg-white rounded-sm dark:bg-gray-800 mr-10 ms-10">

                    <div class="col-sm-6">
                        <canvas id="myNorth" style="width:100%;"></canvas>
                        <canvas id="myEastern" style="width:100%;"></canvas>
                        <canvas id="myWestern" style="width:100%;"></canvas>
                    </div>
                    <div class="col-sm-6">
                        <canvas id="myCentral" style="width:100%;"></canvas>
                        <canvas id="myNortheast" style="width:100%;"></canvas>
                        <canvas id="mySouth" style="width:100%;"></canvas>
                    </div>

                </div> 
                
      {{--   <div class="p-3 m-0 border-0 bd-example m-0 border-0">
                <hr style="border: solid 4px; color:#666666">
                @if(isset($customer_north))

                    <div style="text-align:left;">
                        <div class="py-2">
                            <span class="form-control" style="color:#656565; font-weight:bold;">ภาคเหนือ : </span>
                            <span class="form-control" style="color:#656565; margin-top: 15px;"><i class="fa-solid fa-circle" style="color:#2196F3;"></i> รวมทั้งหมด : {{$customer_north}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#0dc328;"></i> ปกติ : {{$normal_customer_north}} ร้านค้า |
                            <i class="fa-solid fa-circle" style="color:#ffb429;"></i> ติดตาม : {{$follow_customer_north}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#ff0000;"></i> ระงับบัญชี : {{$suspend_customer_north}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#7a7a7a;"></i> ปิดบัญชี : {{$closed_customer_north}} ร้านค้า</span>
                        </div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 35px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_north}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 35px; background-color:#2196F3; font-size:12px; width: {{$percentage_north .'%'}}; ">{{ number_format($percentage_north,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_normal_customer_north}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#0dc328; font-size:11px; width: {{$percentage_normal_customer_north .'%'}}; ">{{ number_format($percentage_normal_customer_north,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_follow_customer_north}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#ffb429; font-size:11px; width: {{$percentage_follow_customer_north .'%'}}; ">{{ number_format($percentage_follow_customer_north,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_suspend_customer_north}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color: #ff0000; font-size:11px; width: {{$percentage_suspend_customer_north .'%'}}; ">{{ number_format($percentage_suspend_customer_north,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_closed_customer_north}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#7a7a7a; font-size:11px; width: {{$percentage_closed_customer_north .'%'}};">{{ number_format($percentage_closed_customer_north,2) .'%'}}</div>
                    </div>
                 
                @endif

                <hr style="border: solid 4px; color:#666666">

                @if(isset($customer_central))

                    <div style="text-align:left;">
                        <div class="py-2">
                            <span class="form-control" style="color:#656565; font-weight:bold;">ภาคกลาง : </span>
                            <span class="form-control" style="color:#656565; margin-top: 15px;"><i class="fa-solid fa-circle" style="color:#2196F3;"></i> รวมทั้งหมด : {{$customer_central}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#0dc328;"></i> ปกติ : {{$normal_customer_central}} ร้านค้า |
                            <i class="fa-solid fa-circle" style="color:#ffb429;"></i> ติดตาม : {{$follow_customer_central}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#ff0000;"></i> ระงับบัญชี : {{$suspend_customer_central}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#7a7a7a;"></i> ปิดบัญชี : {{$closed_customer_central}} ร้านค้า</span>
                        </div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 35px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_central}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 35px; background-color:#2196F3; font-size:12px; width: {{$percentage_central .'%'}}; ">{{ number_format($percentage_central,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_normal_customer_central}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#0dc328; font-size:11px; width: {{$percentage_normal_customer_central .'%'}}; ">{{ number_format($percentage_normal_customer_central,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_follow_customer_central}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#ffb429; font-size:11px; width: {{$percentage_follow_customer_central .'%'}}; ">{{ number_format($percentage_follow_customer_central,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_suspend_customer_central}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color: #ff0000; font-size:11px; width: {{$percentage_suspend_customer_central .'%'}}; ">{{ number_format($percentage_suspend_customer_central,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_closed_customer_central}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#7a7a7a; font-size:11px; width: {{$percentage_closed_customer_central .'%'}};">{{ number_format($percentage_closed_customer_central,2) .'%'}}</div>
                    </div>

                @endif

                <hr style="border: solid 4px; color:#666666">

                @if(isset($customer_eastern))
                
                    <div style="text-align:left;">
                        <div class="py-2">
                            <span class="form-control" style="color:#656565; font-weight:bold;">ภาคตะวันออก : </span>
                            <span class="form-control" style="color:#656565; margin-top: 15px;"><i class="fa-solid fa-circle" style="color:#2196F3;"></i> รวมทั้งหมด : {{$customer_eastern}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#0dc328;"></i> ปกติ : {{$normal_customer_eastern}} ร้านค้า |
                            <i class="fa-solid fa-circle" style="color:#ffb429;"></i> ติดตาม : {{$follow_customer_eastern}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#ff0000;"></i> ระงับบัญชี : {{$suspend_customer_eastern}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#7a7a7a;"></i> ปิดบัญชี : {{$closed_customer_eastern}} ร้านค้า</span>
                        </div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 35px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_eastern}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 35px; background-color:#2196F3; font-size:12px; width: {{$percentage_eastern .'%'}}; ">{{ number_format($percentage_eastern,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_normal_customer_eastern}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#0dc328; font-size:11px; width: {{$percentage_normal_customer_eastern .'%'}}; ">{{ number_format($percentage_normal_customer_eastern,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_follow_customer_eastern}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#ffb429; font-size:11px; width: {{$percentage_follow_customer_eastern .'%'}}; ">{{ number_format($percentage_follow_customer_eastern,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_suspend_customer_eastern}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color: #ff0000; font-size:11px; width: {{$percentage_suspend_customer_eastern .'%'}}; ">{{ number_format($percentage_suspend_customer_eastern,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_closed_customer_eastern}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#7a7a7a; font-size:11px; width: {{$percentage_closed_customer_eastern .'%'}};">{{ number_format($percentage_closed_customer_eastern,2) .'%'}}</div>
                    </div>

                @endif

                <hr style="border: solid 4px; color:#666666">

                @if(isset($customer_northeast))

                    <div style="text-align:left;">
                        <div class="py-2">
                            <span class="form-control" style="color:#656565; font-weight:bold;">ภาคตะวันออกเฉียงเหนือ (อีสาน) : </span>
                            <span class="form-control" style="color:#656565; margin-top: 15px;"><i class="fa-solid fa-circle" style="color:#2196F3;"></i> รวมทั้งหมด : {{$customer_northeast}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#0dc328;"></i> ปกติ : {{$normal_customer_northeast}} ร้านค้า |
                            <i class="fa-solid fa-circle" style="color:#ffb429;"></i> ติดตาม : {{$follow_customer_northeast}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#ff0000;"></i> ระงับบัญชี : {{$suspend_customer_northeast}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#7a7a7a;"></i> ปิดบัญชี : {{$closed_customer_northeast}} ร้านค้า</span>
                        </div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 35px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_northeast}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 35px; background-color:#2196F3; font-size:12px; width: {{$percentage_northeast .'%'}};">{{ number_format($percentage_northeast,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_normal_customer_northeast}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#0dc328; font-size:11px; width: {{$percentage_normal_customer_northeast .'%'}}; ">{{ number_format($percentage_normal_customer_northeast,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_follow_customer_northeast}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#ffb429; font-size:11px; width: {{$percentage_follow_customer_northeast .'%'}}; ">{{ number_format($percentage_follow_customer_eastern,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_suspend_customer_northeast}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color: #ff0000; font-size:11px; width: {{$percentage_suspend_customer_northeast .'%'}}; ">{{ number_format($percentage_suspend_customer_northeast,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_closed_customer_northeast}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#7a7a7a; font-size:11px; width: {{$percentage_closed_customer_northeast .'%'}};">{{ number_format($percentage_closed_customer_northeast,2) .'%'}}</div>
                    </div>

                @endif

                <hr style="border: solid 4px; color:#666666">

                @if(isset($customer_western))

                    <div style="text-align:left;">
                        <div class="py-2">
                            <span class="form-control" style="color:#656565; font-weight:bold;">ภาคตะวันตก : </span>
                            <span class="form-control" style="color:#656565; margin-top: 15px;"><i class="fa-solid fa-circle" style="color:#2196F3;"></i> รวมทั้งหมด : {{$customer_western}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#0dc328;"></i> ปกติ : {{$normal_customer_western}} ร้านค้า |
                            <i class="fa-solid fa-circle" style="color:#ffb429;"></i> ติดตาม : {{$follow_customer_western}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#ff0000;"></i> ระงับบัญชี : {{$suspend_customer_western}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#7a7a7a;"></i> ปิดบัญชี : {{$closed_customer_western}} ร้านค้า</span>
                        </div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 35px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_western}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 35px; background-color:#2196F3; font-size:12px; width: {{$percentage_western .'%'}}; ">{{ number_format($percentage_western,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_normal_customer_western}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#0dc328; font-size:11px; width: {{$percentage_normal_customer_western .'%'}};">{{ number_format($percentage_normal_customer_western,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_follow_customer_western}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#ffb429; font-size:11px; width: {{$percentage_follow_customer_western .'%'}};">{{ number_format($percentage_follow_customer_western,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_suspend_customer_western}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color: #ff0000; font-size:11px; width: {{$percentage_suspend_customer_western .'%'}};">{{ number_format($percentage_suspend_customer_western,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_closed_customer_western}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#7a7a7a; font-size:11px; width: {{$percentage_closed_customer_western .'%'}};">{{ number_format($percentage_closed_customer_western,2) .'%'}}</div>
                    </div>

                @endif

                <hr style="border: solid 4px; color:#666666">

                @if(isset($customer_south))
                   
                    <div style="text-align:left;">
                        <div class="py-2">
                            <span class="form-control" style="color:#656565; font-weight:bold;">ภาคใต้ : </span>
                            <span class="form-control" style="color:#656565; margin-top: 15px;"><i class="fa-solid fa-circle" style="color:#2196F3;"></i> รวมทั้งหมด : {{$customer_south}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#0dc328;"></i> ปกติ : {{$normal_customer_south}} ร้านค้า |
                            <i class="fa-solid fa-circle" style="color:#ffb429;"></i> ติดตาม : {{$follow_customer_south}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#ff0000;"></i> ระงับบัญชี : {{$suspend_customer_south}} ร้านค้า | <i class="fa-solid fa-circle" style="color:#7a7a7a;"></i> ปิดบัญชี : {{$closed_customer_south}} ร้านค้า</span>
                        </div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 35px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_south}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 35px; background-color:#2196F3; font-size:12px; width: {{$percentage_south .'%'}}; ">{{ number_format($percentage_south,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_normal_customer_western}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#0dc328; font-size:11px; width: {{$percentage_normal_customer_south .'%'}};">{{ number_format($percentage_normal_customer_south,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_follow_customer_south}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#ffb429; font-size:11px; width: {{$percentage_follow_customer_south .'%'}};">{{ number_format($percentage_follow_customer_south,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_suspend_customer_south}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color: #ff0000; font-size:11px; width: {{$percentage_suspend_customer_south .'%'}};">{{ number_format($percentage_suspend_customer_south,2) .'%'}}</div>
                    </div>
                    <div class="progress my-2" role="progressbar" style="height: 20px; border-radius: 5px;" aria-label="Success example" aria-valuenow="{{$percentage_closed_customer_south}}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="height: 20px; background-color:#7a7a7a; font-size:11px; width: {{$percentage_closed_customer_south .'%'}};">{{ number_format($percentage_closed_customer_south,2) .'%'}}</div>
                    </div>

                @endif --}}

                <hr class="my-4" style="border: solid 4px; color:#666666">
           
    </div>
    </div>

    <!--- script charts--->
        <script type="text/javascript">

                //north;
                Chart.defaults.global.defaultFontFamily = "Prompt";
                    const xValue_n = ["ร้านค้า", "ปกติ", "ระงับบัญชี", "กำลังติดตาม", "ปิดบัญชี"];
                    const yValue_n = [{{$customer_north}}, {{$normal_customer_north}}, {{$suspend_customer_north}}, {{$follow_customer_north}}, {{$closed_customer_north}}];
                    const barColor_n = ["#AED6F1", "#D1F2EB","#FADBD8","#FAE5D3","#D6DBDF"];
                    const borderColor_n = ["#3498DB","#76D7C4","#D98880","#F8C471","#AEB6BF"];
                    
                new Chart("myNorth", {
                    type: "bar",
                    type: 'horizontalBar',
                    style: {
                        display: false,
                        position: 'bottom',
                        fullWidth: true,
                        labels: {
                        boxWidth: 10,
                        padding: 50
                        }
                    },
                    data: {
                        labels: xValue_n,
                        datasets: [{
                        backgroundColor: barColor_n,
                        borderColor: borderColor_n,
                        borderWidth: 1,
                        //   label: "Wine Production",
                        fill: true,
                        lineTension: 0.1,
                        //   backgroundColor: "#AED6F1",
                        data: yValue_n,
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: "ภาคเหนือ",
                        fontSize: 15,
                        padding: 20,
                        fontFamily: "Prompt",
                        // fontStyle: "",
                        fontColor: "#555759"
                        }
                    },
                    
                });

                //central;
                Chart.defaults.global.defaultFontFamily = "Prompt";
                    const xValues = ["ร้านค้า", "ปกติ", "ระงับบัญชี", "กำลังติดตาม", "ปิดบัญชี"];
                    const yValues = [{{$customer_central}}, {{$normal_customer_central}}, {{$suspend_customer_central}}, {{$follow_customer_central}}, {{$closed_customer_central}}];
                    const barColors = ["#AED6F1", "#D1F2EB","#FADBD8","#FAE5D3","#D6DBDF"];
                    const borderColor = ["#3498DB","#76D7C4","#D98880","#F8C471","#AEB6BF"];
                    
                new Chart("myCentral", {
                    type: "bar",
                    type: 'horizontalBar',
                    style: {
                        display: false,
                        position: 'bottom',
                        fullWidth: true,
                        labels: {
                        boxWidth: 10,
                        padding: 50
                        }
                    },
                    data: {
                        labels: xValues,
                        datasets: [{
                        backgroundColor: barColors,
                        borderColor: borderColor,
                        borderWidth: 1,
                        //   label: "Wine Production",
                        fill: true,
                        lineTension: 0.1,
                        //   backgroundColor: "#AED6F1",
                        data: yValues,
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: "ภาคกลาง",
                        fontSize: 15,
                        padding: 20,
                        fontFamily: "Prompt",
                        // fontStyle: "",
                        fontColor: "#555759"
                        }
                    },
                    
                });

                //eastern;
                Chart.defaults.global.defaultFontFamily = "Prompt";
                    const xValue_e = ["ร้านค้า", "ปกติ", "ระงับบัญชี", "กำลังติดตาม", "ปิดบัญชี"];
                    const yValue_e = [{{$customer_eastern}}, {{$normal_customer_eastern}}, {{$suspend_customer_eastern}}, {{$follow_customer_eastern}}, {{$closed_customer_eastern}}];
                    const barColor_e = ["#AED6F1", "#D1F2EB","#FADBD8","#FAE5D3","#D6DBDF"];
                    const borderColor_e = ["#3498DB","#76D7C4","#D98880","#F8C471","#AEB6BF"];
                    
                new Chart("myEastern", {
                    type: "bar",
                    type: 'horizontalBar',
                    style: {
                        display: false,
                        position: 'bottom',
                        fullWidth: true,
                        labels: {
                        boxWidth: 10,
                        padding: 50
                        }
                    },
                    data: {
                        labels: xValue_e,
                        datasets: [{
                        backgroundColor: barColor_e,
                        borderColor: borderColor_e,
                        borderWidth: 1,
                        //   label: "Wine Production",
                        fill: true,
                        lineTension: 0.1,
                        //   backgroundColor: "#AED6F1",
                        data: yValue_e,
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: "ภาคตะวันออก",
                        fontSize: 15,
                        padding: 20,
                        fontFamily: "Prompt",
                        // fontStyle: "",
                        fontColor: "#555759"
                        }
                    },
                    
                });

                //north east;
                Chart.defaults.global.defaultFontFamily = "Prompt";
                    const xValue_ne = ["ร้านค้า", "ปกติ", "ระงับบัญชี", "กำลังติดตาม", "ปิดบัญชี"];
                    const yValue_ne = [{{$customer_northeast}}, {{$normal_customer_northeast}}, {{$suspend_customer_northeast}}, {{$follow_customer_northeast}}, {{$closed_customer_northeast}}];
                    const barColor_ne = ["#AED6F1", "#D1F2EB","#FADBD8","#FAE5D3","#D6DBDF"];
                    const borderColor_ne = ["#3498DB","#76D7C4","#D98880","#F8C471","#AEB6BF"];
                    
                new Chart("myNortheast", {
                    type: "bar",
                    type: 'horizontalBar',
                    style: {
                        display: false,
                        position: 'bottom',
                        fullWidth: true,
                        labels: {
                        boxWidth: 10,
                        padding: 50
                        }
                    },
                    data: {
                        labels: xValue_ne,
                        datasets: [{
                        backgroundColor: barColor_ne,
                        borderColor: borderColor_ne,
                        borderWidth: 1,
                        //   label: "Wine Production",
                        fill: true,
                        lineTension: 0.1,
                        //   backgroundColor: "#AED6F1",
                        data: yValue_ne,
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: "ภาคตะวันออกเฉียงเหนือ",
                        fontSize: 15,
                        padding: 20,
                        fontFamily: "Prompt",
                        // fontStyle: "",
                        fontColor: "#555759"
                        }
                    },
                    
                });

                //western;
                Chart.defaults.global.defaultFontFamily = "Prompt";
                    const xValue_w = ["ร้านค้า", "ปกติ", "ระงับบัญชี", "กำลังติดตาม", "ปิดบัญชี"];
                    const yValue_w = [{{$customer_western}}, {{$normal_customer_western}}, {{$suspend_customer_western}}, {{$follow_customer_western}}, {{$closed_customer_western}}];
                    const barColor_w = ["#AED6F1", "#D1F2EB","#FADBD8","#FAE5D3","#D6DBDF"];
                    const borderColor_w = ["#3498DB","#76D7C4","#D98880","#F8C471","#AEB6BF"];
                    
                new Chart("myWestern", {
                    type: "bar",
                    type: 'horizontalBar',
                    style: {
                        display: false,
                        position: 'bottom',
                        fullWidth: true,
                        labels: {
                        boxWidth: 10,
                        padding: 50
                        }
                    },
                    data: {
                        labels: xValue_w,
                        datasets: [{
                        backgroundColor: barColor_w,
                        borderColor: borderColor_w,
                        borderWidth: 1,
                        //   label: "Wine Production",
                        fill: true,
                        lineTension: 0.1,
                        //   backgroundColor: "#AED6F1",
                        data: yValue_w,
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: "ภาคตะวันตก",
                        fontSize: 15,
                        padding: 20,
                        fontFamily: "Prompt",
                        // fontStyle: "",
                        fontColor: "#555759"
                        }
                    },
                    
                });

                //south;
                Chart.defaults.global.defaultFontFamily = "Prompt";
                    const xValue_s = ["ร้านค้า", "ปกติ", "ระงับบัญชี", "กำลังติดตาม", "ปิดบัญชี"];
                    const yValue_s = [{{$customer_south}}, {{$normal_customer_south}}, {{$suspend_customer_south}}, {{$follow_customer_south}}, {{$closed_customer_south}}];
                    const barColor_s = ["#AED6F1", "#D1F2EB","#FADBD8","#FAE5D3","#D6DBDF"];
                    const borderColor_s = ["#3498DB","#76D7C4","#D98880","#F8C471","#AEB6BF"];
                    
                new Chart("mySouth", {
                    type: "bar",
                    type: 'horizontalBar',
                    style: {
                        display: false,
                        position: 'bottom',
                        fullWidth: true,
                        labels: {
                        boxWidth: 10,
                        padding: 50
                        }
                    },
                    data: {
                        labels: xValue_s,
                        datasets: [{
                        backgroundColor: barColor_s,
                        borderColor: borderColor_s,
                        borderWidth: 1,
                        //   label: "Wine Production",
                        fill: true,
                        lineTension: 0.1,
                        //   backgroundColor: "#AED6F1",
                        data: yValue_s,
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: "ภาคใต้",
                        fontSize: 15,
                        padding: 20,
                        fontFamily: "Prompt",
                        // fontStyle: "",
                        fontColor: "#555759"
                        }
                    },
                    
                });
     

                //chart dounghnut bar;
/* 
               const barColors_all = ["#F5B7B1","#C39BD3","#7FB3D5","#76D7C4","#F8C471"];

                const xValues_all = ["ภาคเหนือ", "ภาคกลาง", "ภาคตะวันออก", "ภาคตะวันออกเฉียงเหนือ", "ภาคตะวันตก", "ภาคใต้"];
                const yValues_all = [{{$customer_north}}, {{$customer_central}}, {{$customer_eastern}}, {{$customer_northeast}}, {{$customer_western}}, {{$customer_south}}];

                new Chart("doughnutCustomer", {
                    type: "doughnut",
                    data: {
                        labels: xValues_all,
                        datasets: [{
                        backgroundColor: barColors_all,
                        data: yValues_all
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: "All customers",
                        fontSize: 15,
                        padding: 20,
                        fontFamily: "Prompt",
                        fontColor: "#555759"
                        }
                    },
                    labels: ["ภาคเหนือ", "ภาคกลาง", "ภาคตะวันออก", "ภาคตะวันออกเฉียงเหนือ", "ภาคตะวันตก", "ภาคใต้"],
                        dataLabels: {
                        enabled: false,
                        },
                }); */

                //doughnut chart;
                const xValues_bar = ["ภาคเหนือ", "ภาคกลาง", "ภาคตะวันออก", "ภาคตะวันออกเฉียงเหนือ", "ภาคตะวันตก", "ภาคใต้"];
                const yValues_bar = [{{$normal_customer_north}}, {{$normal_customer_central}}, {{$normal_customer_eastern}}, {{$normal_customer_northeast}}, {{$normal_customer_western}}, {{$normal_customer_south}}];
                const barColors_bar = ["#D1F2EB", "#D1F2EB","#D1F2EB","#D1F2EB","#D1F2EB", "#D1F2EB"];
                const borderColors_bar = ["#76D7C4","#76D7C4","#76D7C4","#76D7C4","#76D7C4", "#76D7C4"];

                new Chart("barCustomer", {
                    
                        type: "bar",
                        data: {
                            labels: xValues_bar,
                            datasets: [{
                                backgroundColor: barColors_bar,
                                borderColor: borderColors_bar,
                                borderWidth: 1,
                                data: yValues_bar
                                }]
                        },
                        options: {
                            legend: {display: false},
                            title: {
                            display: true,
                            text: "Normal status customer",
                            fontSize: 15,
                            padding: 20,
                            fontFamily: "Prompt",
                            fontColor: "#555759",
                            }
                        }
                    });
        </script>

        <script type="text/javascript">    

                    const getChartOptions = () => {
                    return {
                        series:  [{{$customer_north}}, {{$customer_central}}, {{$customer_eastern}}, {{$customer_northeast}}, {{$customer_western}}, {{$customer_south}}],
                        colors: ["#EF9A9A","#C39BD3","#7FB3D5","#80CBC4","#FFCC80", "#D7CCC8"],
                        chart: {
                        height: "100%",
                        width: "100%",
                        type: "donut",
                        fontFamily: "Prompt , sans-serif",
                        },
                        stroke: {
                        colors: ["transparent"],
                        lineCap: "",
                        },
                        plotOptions: {
                        pie: {
                            donut: {
                            labels: {
                                show: true,
                                name: {
                                show: true,
                                fontFamily: "Prompt, sans-serif",
                                offsetY: 20,
                                },
                                total: {
                                showAlways: true,
                                show: true,
                                label: "All customers",
                                fontFamily: "Prompt, sans-serif",
                                fontSize: 14,
                                formatter: function (w) {
                                    const sum = w.globals.seriesTotals.reduce((a, b) => {
                                    return a + b
                                    }, 0)
                                    return sum
                                },
                                },
                                value: {
                                show: true,
                                fontFamily: "Prompt, sans-serif",
                                offsetY: -20,
                                formatter: function (value) {
                                    return value + "k"
                                },
                                },
                            },
                            size: "70%",
                            },
                        },
                        },
                        grid: {
                        padding: {
                            top: -2,
                        },
                        },
                        labels: ["ภาคเหนือ", "ภาคกลาง", "ภาคตะวันออก", "ภาคตะวันออกเฉียงเหนือ", "ภาคตะวันตก", "ภาคใต้"],
                        dataLabels: {
                        enabled: false,
                        },
                        legend: {
                        position: "bottom",
                        fontFamily: "Prompt, sans-serif",
                        },
                        yaxis: {
                        labels: {
                            formatter: function (value) {
                            return value
                            },
                        },
                        },
                        xaxis: {
                        labels: {
                            formatter: function (value) {
                            return value
                            },
                        },
                        axisTicks: {
                            show: false,
                        },
                        axisBorder: {
                            show: false,
                        },
                        }
                    }
                    }

                    if (document.getElementById("radial-chart") && typeof ApexCharts !== 'undefined') {
                    const chart = new ApexCharts(document.getElementById("radial-chart"), getChartOptions());
                    chart.render();

                  /*   // Get all the checkboxes by their class name
                    const checkboxes = document.querySelectorAll('#devices input[type="checkbox"]');

                    // Function to handle the checkbox change event
                    function handleCheckboxChange(event, chart) {
                        const checkbox = event.target;
                        if (checkbox.checked) {
                            switch(checkbox.value) {
                                case 'desktop':
                                chart.updateSeries([15.1, 22.5, 4.4, 8.4]);
                                break;
                                case 'tablet':
                                chart.updateSeries([25.1, 26.5, 1.4, 3.4]);
                                break;
                                case 'mobile':
                                chart.updateSeries([45.1, 27.5, 8.4, 2.4]);
                                break;
                                default:
                                chart.updateSeries([55.1, 28.5, 1.4, 5.4]);
                            }

                        } else {
                            chart.updateSeries([35.1, 23.5, 2.4, 5.4]);
                        }
                    }

                    // Attach the event listener to each checkbox
                    checkboxes.forEach((checkbox) => {
                        checkbox.addEventListener('change', (event) => handleCheckboxChange(event, chart));
                    }); */
                    }


        </script>
        


@endsection
</body>
</html>

