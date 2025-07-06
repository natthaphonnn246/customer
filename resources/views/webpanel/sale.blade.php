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
        .trash-sale {
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
        #importMaster {
            background-color: #efefef;
            color: #909090;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importMaster:hover {
            background-color: #cccccc;
            color: #3c3c3c;
        }

        /* Rounded sliders */
        .sliders.round {
            border-radius: 34px;
        }

        .sliders.round:before {
            border-radius: 50%;
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

    <div class="contentArea w-full max-w-full break-words">
        
        <div class="py-2">
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}
        </div>
        <span   class="ms-6" style="color: #8E8E8E;">เขตการขาย (Sale area)</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        <div class="ms-6 py-2" style="text-align: left;">
            <a href="/webpanel/sale-create"  id="admin" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">เพิ่มเขตการขาย</a>
            <a href="/webpanel/sale/importsale"  id="importMaster" class="btn ms-2" type="submit"  name="" style="width: 180px; padding: 8px;">import Sale CSV</a>
            {{-- <a href="/webpanel/admin-role"  id="adminRole" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">จัดการสิทธิ์</a> --}}
    
        </div>

        <hr class="my-4" style="color: #8E8E8E; width: 100%;">
        
        <ul class="ms-4 mr-5 py-1">
        <table class="table table-striped">
            <thead>
              <tr>
                <td scope="col" style="color:#838383; text-align: center; font-weight:500;">#</td>
                <td scope="col" style="color:#838383; text-align: center; font-weight:500;">Sale area</td>
                <td scope="col" style="color:#838383; text-align: left; font-weight:500;">ชื่อพนักงานขาย</td>
                <td scope="col" style="color:#838383; text-align: left; font-weight:500;">วันที่สร้าง</td>
                <td scope="col" style="color:#838383; text-align: left; font-weight:500;">จัดการ</td>
              </tr>
            </thead>
            <tbody>
                @if(!empty($salearea))

                <?php 
                    @$start = 1;
                ?>
                @foreach ($salearea as $row)
              <tr>
                    <?php
                        
                        $id = $row->id;
                        $sale_area = $row->sale_area;
                        $sale_name = $row->sale_name;
                        $created_at = $row->created_at
            
                    ?>
                
                <td scope="row" style="color:#9C9C9C; text-align: center; padding: 10px;">{{$start++}}</td>
                <td scope="row" style="color:#9C9C9C; text-align: center; padding: 10px;">{{$sale_area}}</td>
                <td scope="row" style="color:#9C9C9C; text-align: left; padding: 10px;">{{$sale_name}}</td>
                <td scope="row" style="color:#9C9C9C; text-align: left; padding: 10px;">{{$created_at}}</td>

                    <td scope="row" style="color:#9C9C9C; text-align: left; padding: 10px;"><a href="/webpanel/sale/{{$id}}" id="edit"><i class="fa-regular fa-eye"></i></a>
                    <button class="trash-sale" type="submit" id="trash{{$id}}"><i class="fa-regular fa-trash-can"></i></button>
                </td>
              </tr>
               <!-- delete saleareas table -->
                <script>
                        $(document).ready(function() {

                                $('#trash{{$id}}').click(function(e) {
                                    e.preventDefault();
                                    // console.log('delete{{$sale_area}}');
                                    let code_del = '{{$id}}';
                                    // console.log('{{$sale_area}}');

                                        swal.fire({
                                            icon: "warning",
                                            title: "คุณต้องการลบข้อมูลหรือไม่",
                                            // text: '<?= $sale_area .' '.'('. $sale_name.')' ; ?>',
                                            text: '{{$sale_area.' '.'('. $sale_name.')'}}',
                                            showCancelButton: true,
                                            confirmButtonText: "ลบข้อมูล",
                                            cancelButtonText: "ยกเลิก"
                                        }).then(function(result) {
                            
                                        if(result.isConfirmed) {
                                            $.ajax({
                                            url: '/webpanel/sale/delete/{{$id}}',
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
                                                        text: 'ไม่พบข้อมูล {{$sale_area.' '.'('. $sale_name.')'}}',
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

              @endforeach
              @endif
            </tbody>
          </table>
        </ul>
    </div>

@endsection

</body>
</html>
