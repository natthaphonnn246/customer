<!DOCTYPE html>
<html lang="en">
    @section ('title', 'importcustomer')
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
        #importCustomer {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importCustomer:hover {
            background-color: #0b59f6;
            color: #ffffff;
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
        #backLink {
            color: #3b25ff;
            text-decoration: none;
            cursor: pointer;
        }
        #backLink:hover {
            color: #3b25ff;
            text-decoration: underline;
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
    <div class="contentArea w-full max-w-full break-words">

            <div class="py-2">
            </div>
            <span class="ms-6" style="color: #8E8E8E;"><a href="/webpanel/customer" id="backLink">ลูกค้าทั้งหมด (Customer)</a> / อัปเดตลูกค้า</span>
            
            <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

            <div class="ms-6" style="text-align: left; margin-top: 10px;">
                <span style="color: #e84545;">**อัปเดตข้อมูลลูกค้า (update customers) tb: customers</span>
            </div>

            @error('import_csv')

            <div class="alert alert-danger my-2" role="alert">
                {{ $message ?? '' }}
            </div>
        
            @enderror

            @if (isset($check_import))

                <div class="alert alert-success my-2" role="alert">
                    {{$check_import}}
                </div>

            @endif

            {{-- {{$check_provinces}} --}}
            <div class="ms-6 mr-6" style="text-align: left;">

        
                <form method="post" id="import" action="/webpanel/customer/updatecsv/updated" enctype="multipart/form-data" style="margin-top: 10px;">
                    @csrf
                    <input type="file"  id="import_csv" name="import_csv" class="form-control text-muted"><br/>
                    <input type="submit" id="importCustomer" name="submit_csv" class="btn btn-primary mb-4" value="นำเข้าไฟล์">
                
                </form>
                {{-- <hr style="color: #8E8E8E;"> --}}

                @if(Session::get('success_updated'))
                <div class="py-4">
                    <ul class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success_updated') }}</ul>
                </div>
                @endif
                <div class="" style="text-align: left; margin-top: 10px;">
                    <span style="color: #e84545;">**อัปเดตเหตุผลลูกค้าที่ปิดใช้งาน (customer cause) tb: customers</span>
                </div>
                <!--update เหตุผล -->
                <form method="post" id="import" action="/webpanel/customer/updatecsv/customer-cause" enctype="multipart/form-data" style="margin-top: 10px;">
                    @csrf
                    <input type="file"  id="import_csv" name="import_csv" class="form-control text-muted"><br/>
                    <input type="submit" id="importCustomer" name="submit_cause" class="btn btn-primary mb-4" value="นำเข้าไฟล์">
                
                </form>
                <hr style="color: #8E8E8E;">

                @if(Session::get('success_cause'))
                <div class="py-4">
                    <ul class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success_cause') }}</ul>
                </div>
                @endif
            
            </div>
          

    </div>

@endsection
</body>
</html>
