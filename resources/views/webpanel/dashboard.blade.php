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

    <title>register-form</title>
</head>
<body>

    @extends ('webpanel/menuwebpanel')
    @section('content')
    @csrf


    <style>
        .contentArea {
            padding: 10px;
            background-color: #FFFFFF;
            border-radius: 2px;
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
    </style>

    <div class="contentArea">
        
        <span>Dashboard for Admin</span>

        <hr>
        
        <div class="row" style="justify-content: center;">
            
            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    ร้านค้าทั้งหมด<br/>
                    @if (isset($customer_all))
                    <span>{{$customer_all != '' ? $customer_all : '0' ;}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    บัญชีปกติ<br/>
                    @if (isset($count_status_normal))
                    <span>{{$customer_all != '' ? $count_status_normal : '0' ;}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    กำลังติดตาม (ปลดล็อก)<br/>
                    @if (isset($count_status_follow))
                    <span>{{$count_status_follow != '' ? $count_status_follow : '0' ;}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    ระงับบัญชี (ไม่เคลื่อนไหว)<br/>
                    @if (isset($count_status_suspend))
                    <span>{{$count_status_suspend != '' ? $count_status_suspend : '0' ;}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    ปิดบัญชี<br/>
                    @if (isset($count_status_closed))
                    <span>{{$count_status_closed != '' ? $count_status_closed : '0' ;}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

        </div>

        <hr class="my-3" style="color:#545454;">

        <div class="p-3 m-0 border-0 bd-example m-0 border-0">
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
                  {{--   <div class="progress-stacked my-2" style="height: 35px;">
                        <div class="progress" role="progressbar" aria-label="Segment one" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage_normal_customer_north .'%'}}; height: 35px;">
                            <div class="progress-bar" style="background-color:#0dc328;">{{ number_format($percentage_normal_customer_north,2) .'%'}}</div>
                          </div>
                        <div class="progress" role="progressbar" aria-label="Segment two" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage_follow_customer_north .'%'}}; height: 35px;">
                          <div class="progress-bar" style="background-color:#ffb429;">{{ number_format($percentage_follow_customer_north,2) .'%'}}</div>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Segment three" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage_suspend_customer_north .'%'}}; height: 35px;">
                          <div class="progress-bar" style="background-color:#ff0000;">{{ number_format($percentage_suspend_customer_north,2) .'%'}}</div>
                        </div>
                    </div> --}}

                {{--     <div class="col-sm-12">
                        <div class="progress my-2" role="progressbar" style="height: 50px;" aria-label="Success example" aria-valuenow="{{$percentage_north}}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: {{$percentage_north .'%'}}; height: 50px; background-color:#2196F3; font-size:12px;">{{ number_format($percentage_north,2) .'%'}}</div>
                        </div>
                    </div> --}}
                    {{-- <hr class="my-2" style="color:#545454;"> --}}
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

                @endif

                <hr style="border: solid 4px; color:#666666">
           
        
       
    </div>
    </div>

@endsection
</body>
</html>
