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
            /* min-width: 1500px; */
            /* text-align: left; */
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
        #groupsCustomer {
            background-color: #ff5cc1;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #groupsCustomer:hover {
            background-color: #ed1199;
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
        <span class="ms-6" style="color: #8E8E8E;"><a href="/webpanel/customer" id="backLink">ลูกค้าทั้งหมด (Customer)</a> / ขายส่ง</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        <div class="mr-6" style="text-align: right;">
            <a href="/webpanel/customer/export/getcsv/getcsv_waiting"  id="exportcsv" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">Export CSV</a>
            <a href="/webpanel/customer/export/getexcel/getexcel_waiting"  id="exportexcel" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">Export Excel</a>
    
        </div>

        <div style="text-align:left;">
            @if(Session::get('error_export') == 'เกิดข้อผิดพลาด')

            <script>
                swal.fire({
                    title: 'เกิดข้อผิดพลาด',
                    icon: 'error',
                    confirmButtonText: 'ตกลง'

                });
            </script>
            @endif
        </div>

        <hr class="my-3" style="color: #8E8E8E; width: 100%;">

        <div class="row" style="justify-content: left; margin-left: 20px;">
            
            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    ร้านค้าทั้งหมด<br/>
                    @if (isset($total_customer))
                    <span>{{$total_customer != '' ? $total_customer : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

            <div class="textbox" style="width: 240px; height: 80px; background-color: #3399ff; border-radius: 10px; text-align: center; margin: 20px 10px; padding: 20px;">
                <span style="color: white; text-align: center;">
                    ขายส่ง<br/>
                    @if (isset($customer_check_license))
                    <span>{{$customer_check_license != '' ? $customer_check_license : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

        </div>

        <hr class="my-3" style="color: #8E8E8E; width: 100%;">

        <div class="ms-6 mr-6 mb-2">
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">
            <table class="table table-striped">
                <thead>

                <tr>
                    <td scope="col" style="color:#838383; text-align: left; font-weight: 600;">#</td>
                    <td scope="col" style="color:#838383; text-align: left; font-weight: 600;">CODE</td>
                    <td scope="col" style="color:#838383; text-align: left; font-weight: 600;">อีเมล</td>
                    <td scope="col" style="color:#838383; text-align: left; font-weight: 600;">ชื่อร้านค้า</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 600;">STATUS</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 600;">UPDATE</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 600;">วันที่สมัคร</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 600;">สถานะ</td>
                    <td scope="col" style="color:#838383; text-align: center; font-weight: 600;">จัดการ</td>
                </tr>
                </thead>
                <tbody>
                    @if(!empty($customer))
                    <?php 
                        @$start += 1;
                    ?>
                    @foreach ($customer as $row)
                <tr>
                        <?php
                            
                            $id = $row->id;
                            $user_name = $row->customer_name;
                            $user_code = $row->customer_code;
                            $status = $row->status;
                            $status_update = $row->status_update;
                            $email = $row->email;
                            $customer_status = $row->customer_status;
                            $created_at = $row->created_at;
                        ?>
                    
                    <td scope="row" style="color:#9C9C9C; text-align: left;  padding:20px;">{{$start++}}</td>
                    <td scope="row" style="color:#9C9C9C; text-align: left;  padding:20px;">{{$user_code}}</td>
                    <td scope="row" style="color:#9C9C9C; text-align: left;  padding:20px;">{{$email}}</td>
                    <td scope="row" style="color:#9C9C9C; text-align: left;  padding:20px; width: 20%;">{{$user_name}}</td>

                        @if ($status == 'รอดำเนินการ')
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding:30px; width: 20%;"> <span style="border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(237, 59, 59);">รอดำเนินการ</span></td>
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px;"><i class="fa-solid fa-circle" style="color: rgb(255, 70, 70);"></i> รอดำเนินการ</td> --}}
                        @elseif ($status == 'ต้องดำเนินการ')
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding:30px; width: 20%;"><span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(251, 169, 46);">ต้องดำเนินการ</span></td>
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px;"><i class="fa-solid fa-circle" style="color: rgb(251, 183, 23);"></i> ต้องดำเนินการ</td> --}}
                        @elseif ($status == 'ดำเนินการแล้ว')
                        {{-- <td scope="row" style="color:#9C9C9C; text-align: left;"><i class="fa-solid fa-circle" style="color: rgb(4, 181, 30);"></i> ดำเนินการแล้ว</td> --}}
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding:30px; width: 20%;"> <span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(58, 174, 19);">ดำเนินการแล้ว</span></td>
                        @else
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding:30px; width: 20%;"> </td>
                        @endif

                        @if ($status_update == 'updated')
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding:30px;"> <span style="border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(255, 70, 70);">UPDATE</span></td>
                        @else
                        <td scope="row" style="color:#9C9C9C; text-align: center; padding:30px;"><span style="border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(184, 184, 184);">NULL</span></td>
                        @endif

                        <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;">{{$created_at}}</td>

                        <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;">
                    
                            <label class="switch">
                                <input type="checkbox" name="check" id="status_on{{$id}}" {{$customer_status == 'active' ? 'checked' : ''}}>
                                {{-- {{dd($customer_status);}} --}}
                                <span class="slider round" style="text-align: center;">
                                    <span style="color: white; font-size: 10px; text-align: center;">ON</span>
                                    <span style="color: white; font-size: 10px;">OFF</span>
                                </span>
                            </label>
                    
                        </td>

                        <td scope="row" style="color:#9C9C9C; text-align: center;  padding:20px; width: 20%;">
                            <a href="/webpanel/customer/{{$id}}" id="edit"><i class="fa-regular fa-eye"></i></a>
                            {{-- <a href="/webpanel/customer/delete/{{$user_code}}" id="trash"><i class="fa-regular fa-trash-can"></i></a> --}}
                            <button class="trash-customer" type="submit" id="trash{{$id}}"><i class="fa-regular fa-trash-can"></i></button>

                    </td>
                </tr>

                <!-- delete customer table -->

                    <script>
                            $(document).ready(function() {

                                    $('#trash{{$id}}').click(function(e) {
                                        e.preventDefault();
                                        // console.log('delete{{$user_code}}');
                                        let code_del = '{{$id}}';
                                        // console.log('{{$user_code}}');

                                            swal.fire({
                                                icon: "warning",
                                                title: "คุณต้องการลบข้อมูลหรือไม่",
                                                // text: '<?= $user_code .' '.'('. $user_name.')' ; ?>',
                                                text: '{{$user_code.' '.'('. $user_name.')'}}',
                                                showCancelButton: true,
                                                confirmButtonText: "ลบข้อมูล",
                                                cancelButtonText: "ยกเลิก"
                                            }).then(function(result) {
                                
                                            if(result.isConfirmed) {
                                                $.ajax({
                                                url: '/webpanel/customer/delete/{{$id}}',
                                                type: 'GET',
                                                success: function(data) {

                                                    let check_id = JSON.parse(data);
                                                    console.log(check_id.checkcode);

                                                    if(check_id.checkcode == code_del) 
                                                    {
                                                        swal.fire({
                                                            icon: "success",
                                                            title: "ลบข้อมูลสำเร็จ",
                                                            showConfirmButton: true,
                                                        
                                                        }).then (function(result) {
                                                            window.location.reload();
                                                        });
                                                        
                                                    } else {
                                                        Swal.fire({
                                                            icon: "error",
                                                            title: "เกิดข้อผิดพลาด",
                                                            text: 'ไม่พบข้อมูล {{$user_code.' '.'('. $user_name.')'}}',
                                                            showConfirmButton: true,
                                                        });
                                                    }

                                                },

                                            });

                                        } //iscomfirmed;
                            
                                    });   

                                });
                            
                            });

                    </script>

                    <script text="type/javascript">
                            $(document).ready(function() {
                                // $('#status_on').prop('checked', false);
                                $('#status_on{{$id}}').change(function() {
                    
                                    if($(this).is(':checked')) 
                                    {
                                        $('#status_on{{$id}}').prop('checked', true);
                                        console.log('ON');
                                        // var admin_code = $(this).val();
                                        let user_code = '{{$id}}';
                                        console.log(user_code);
                    
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.ajax({
                                            url: '/webpanel/customer/status-active',
                                            type: 'POST',
                                            data: {
                                                id_act: 2,
                                                status: 'active',
                                                code_id: user_code,
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

                                        const user_code = '{{$id}}';
                                        console.log(user_code);

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.ajax({
                                            url: '/webpanel/customer/status-inactive',
                                            type: 'POST',
                                            data: {
                                                id_inact: 1,
                                                status_in: 'inactive',
                                                code_id: user_code,
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

                {{--   <script>
                        $(document).ready(function() {
                            $('#trash').click(function() {
                                console.log('trash');
                            });
                        });
                    </script> --}}

                @endforeach
                @endif
                </tbody>
            </table>
        </div>

        @if($total_page >= 1)
        <div class="ms-6">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                <li class="page-item">

                @if ($page == 1)
                    <a class="page-link" href="/webpanel/customer/status/check-license?page={{ 1 }}" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @else
                    <a class="page-link" href="/webpanel/customer/status/check-license?page={{ $page-1 }}" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @endif
                </li>

                @if($total_page > 14)

                    @for ($i= 1; $i <= 10 ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/customer/status/check-license?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link">...</a></li>
                    @for ($i= $total_page-1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/customer/status/check-license?page={{ $i }}">{{ $i }}</a></li>
                    @endfor

                @else
                    @for ($i= 1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/customer/status/check-license?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                
                @endif

                <li class="page-item">
                
                @if ($page == $total_page)
                    <a class="page-link" href="/webpanel/customer/status/check-license?page={{ $page }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @else
                    <a class="page-link" href="/webpanel/customer/status/check-license?page={{ $page + 1 }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @endif
                </li>
                </ul>
            </nav>
        </div>
        @endif
        <hr class="mt-3" style="color: #8E8E8E; width: 100%;">
        <div class="py-3">
            <p class="ms-8 text-sm" style="color:#898989;"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
        </div>

    </div>
@endsection
</body>
</html>
