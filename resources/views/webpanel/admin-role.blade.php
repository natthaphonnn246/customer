<!DOCTYPE html>
<html lang="en">
    @section ('title', 'productmaster')
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
    </style>

    <div class="contentArea w-full max-w-full break-words">
        <div style="text-align: left; margin-top: 10px;">
            <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / หน้าที่รับผิดชอบ</span>
        </div>
        
        <hr style="color: #8E8E8E; width: 100%;">
        
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col" style="color:#838383; text-align: left;">#</th>
                <th scope="col" style="color:#838383; text-align: left;">CODE</th>
                <th scope="col" style="color:#838383; text-align: left;">อีเมล</th>
                <th scope="col" style="color:#838383; text-align: left;">ชื่อแอดมิน</th>
                <th scope="col" style="color:#838383; text-align: left;">อนุมัติบัญชี</th>
                <th scope="col" style="color:#838383; text-align: left;">วันที่สมัคร</th>
                <th scope="col" style="color:#838383; text-align: left;">จัดการ</th>
              </tr>
            </thead>
            <tbody>
                @if(isset($user_master) != '')
                <?php 
                    @$start = 1;
                ?>
                @foreach ($user_master as $row)
              <tr>
                    <?php
                        
                        $user_name = $row->name;
                        $user_code = $row->user_code;
                        $status_admin = $row->status_checked;
                        $email = $row->email;
                        $created_at = $row->created_at;
                    ?>
                
                <td scope="row" style="color:#9C9C9C; text-align: left;">{{$start++}}</td>
                <td scope="row" style="color:#9C9C9C; text-align: left;">{{$user_code}}</td>
                <td scope="row" style="color:#9C9C9C; text-align: left;">{{$email}}</td>
                <td scope="row" style="color:#9C9C9C; text-align: left;">{{$user_name}}</td>
                <td scope="row" style="color:#9C9C9C; text-align: left;">
                  
                    @if ($user_code === '0000')
                        <label class="switch" style="opacity:0.6;">
                            <input type="checkbox" name="check" id="status_on{{$user_code}}" {{ $status_admin == 'active' ? 'checked disabled' : ''}}>
                            <span class="slider round" style="text-align: center;">
                                <span style="color: white; font-size: 10px; text-align: center;">ON</span>
                                <span style="color: white; font-size: 10px;">OFF</span>
                            </span>
                        </label>
                    @else
                        <label class="switch">
                            <input type="checkbox" name="check" id="status_on{{$user_code}}" {{ $status_admin == 'active' ? 'checked' : ''}}>
                            <span class="slider round" style="text-align: center;">
                                <span style="color: white; font-size: 10px; text-align: center;">ON</span>
                                <span style="color: white; font-size: 10px;">OFF</span>
                            </span>
                        </label>
                    @endif
                  
                </td>
                {{-- <td scope="row" style="color:#9C9C9C; text-align: left;">
                  
                    <label class="switchs">
                        <input type="checkbox" name="check">
                        <span class="sliders round" style="text-align: center;">
                            <span style="color: white; font-size: 10px; text-align: center;">ON</span>
                            <span style="color: white; font-size: 10px;">OFF</span>
                        </span>
                    </label> --}}
              
            </td>
                <td scope="row" style="color:#9C9C9C; text-align: left;">{{$created_at}}</td>

                    <td scope="row" style="color:#9C9C9C; text-align: left;"><a href="/webpanel/admin/{{$user_code}}" id="edit"><i class="fa-regular fa-eye"></i></a>
                    <button id="trash"><i class="fa-regular fa-trash-can"></i></button>
                </td>
              </tr>

                <script text="type/javascript">
                        $(document).ready(function() {
                            // $('#status_on').prop('checked', false);
                            $('#status_on{{$user_code}}').change(function() {
                
                                if($(this).is(':checked')) 
                                {
                                    $('#status_on{{$user_code}}').prop('checked', true);
                                    console.log('ON');
                                    // var admin_code = $(this).val();
                                    let user_code = '{{$user_code}}';
                                    console.log(user_code);
                
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    $.ajax({
                                        url: '/webpanel/admin/status-check',
                                        type: 'POST',
                                        data: {
                                            id: 2,
                                            status: 'active',
                                            user_code: user_code,
                                            _token: "{{ csrf_token() }}",
                                        },
                                        success: function(response) {
                
                                            if(response == 'success') {
                                                console.log('success');
 
                                            }
                    
                                        },
                                        error: function(xhr, status, error) {
                                            console.log(xhr);
                                            console.log(status);
                                            console.log(error);
                                        }
                                    });
                
                                } else {

                                    let user_code = '{{$user_code}}';
                                    console.log(user_code);

                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    $.ajax({
                                        url: '/webpanel/admin/status-inactive',
                                        type: 'POST',
                                        data: {
                                            id: 1,
                                            status_in: 'inactive',
                                            user_code: user_code,
                                            _token: "{{ csrf_token() }}",
                                        },
                                        success: function(response) {
                
                                            if(response == 'inactive') {
                                                console.log('inactive');

                                            }
                    
                                        },
                                        error: function(xhr, status, error) {
                                            console.log(xhr);
                                            console.log(status);
                                            console.log(error);
                                        }
                                    });
                                }
                            });
                        });
                </script>
              @endforeach
              @endif
            </tbody>
          </table>

    </div>

@endsection

</body>
</html>
