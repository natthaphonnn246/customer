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

    <title>cutomer</title>
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

    <?php 
        
/*         $image = DB::table('customers', 'id')->select('cert_store', 'cert_medical', 'cert_commerce', 'cert_vat','cert_id')->whereIn('id', ['115'])->get();
        foreach ($image as $row) {
            $image_url = url('/storage/certs/'.$row->cert_store);
            $image_url1 = url('/storage/certs/'.$row->cert_medical);
            $image_url2 = url('/storage/certs/'.$row->cert_commerce);
            $image_url3 = url('/storage/certs/'.$row->cert_vat);
            $image_url4 = url('/storage/certs/'.$row->cert_id);
            echo '<img src="'.$image_url.'" style="width: 20%;">';
            echo '<img src="'.$image_url1.'" style="width: 20%;">';
            echo '<img src="'.$image_url2.'" style="width: 20%;">';
            echo '<img src="'.$image_url3.'" style="width: 20%;">';
            echo '<img src="'.$image_url4.'" style="width: 20%;">';
        }
            */
    
    ?>
        {{-- <img src="{{ url('/') }}/storage/certificates/img_certstore/1dcV3LQvU5DbAW2hVAMAwHyYLLng85K9aGq4TX47.jpg"> --}}
    <div class="contentArea">
        <div style="text-align: left; margin-top: 10px;">
            {{-- <span style="color: #8E8E8E;"><a href="/webpanel/admin" id="backLink">ข้อมูลแอดมิน (Admin)</a> / แบบฟอร์ม</span> --}}
            <span style="color: #8E8E8E;">ข้อมูลลูกค้า (Customer)</span>
        </div>
        <hr style="color: #8E8E8E; width: 100%;">

        <div style="text-align: left;">
            <a href="/webpanel/customer/customer-create"  id="admin" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">เพิ่มลูกค้าใหม่</a>
            <a href="/webpanel/customer/importcustomer"  id="importMaster" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">import master CSV</a>
    
        </div>

        <hr style="color: #8E8E8E; width: 100%;">
        
        <table class="table table-striped">
            <thead>

              <tr>
                <th scope="col" style="color:#838383; text-align: left;">#</th>
                <th scope="col" style="color:#838383; text-align: left;">CODE</th>
                <th scope="col" style="color:#838383; text-align: left;">อีเมล</th>
                <th scope="col" style="color:#838383; text-align: left;">ชื่อร้านค้า</th>
                <th scope="col" style="color:#838383; text-align: center;">STATUS</th>
                <th scope="col" style="color:#838383; text-align: center;">UPDATE</th>
                <th scope="col" style="color:#838383; text-align: center;">วันที่สมัคร</th>
                <th scope="col" style="color:#838383; text-align: center;">สถานะ</th>
                <th scope="col" style="color:#838383; text-align: center;">จัดการ</th>
              </tr>
            </thead>
            <tbody>
                @if(isset($customer) != '')
                <?php 
                    @$start += 1;
                ?>
                @foreach ($customer as $row)
              <tr>
                    <?php
                        
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
                <td scope="row" style="color:#9C9C9C; text-align: left;  padding:20px;">{{$user_name}}</td>

                    @if ($status == 0)
                    <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;"> <span style="border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(255, 70, 70);">รอดำเนินการ</span></td>
                    {{-- <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px;"><i class="fa-solid fa-circle" style="color: rgb(255, 70, 70);"></i> รอดำเนินการ</td> --}}
                    @elseif ($status == 1)
                    <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;"><span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(255, 182, 11);">ต้องดำเนินการ</span></td>
                    {{-- <td scope="row" style="color:#9C9C9C; text-align: left; padding:20px;"><i class="fa-solid fa-circle" style="color: rgb(251, 183, 23);"></i> ต้องดำเนินการ</td> --}}
                    @elseif ($status == 2)
                    {{-- <td scope="row" style="color:#9C9C9C; text-align: left;"><i class="fa-solid fa-circle" style="color: rgb(4, 181, 30);"></i> ดำเนินการแล้ว</td> --}}
                    <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;"> <span style="border: solid 2px; padding:10px; border-radius: 10px; color:rgb(58, 174, 19);">ดำเนินการแล้ว</span></td>
                    @else
                    <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;"> </td>
                    @endif

                    @if ($status_update == 'updated')
                    <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;"> <span style="border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(255, 70, 70);">UPDATE</span></td>
                    @else
                    <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;"><span style="border: solid 2px; padding: 10px; border-radius: 10px; color:rgb(184, 184, 184);">NULL</span></td>
                    @endif

                    <td scope="row" style="color:#9C9C9C; text-align: center; padding:20px;">{{$created_at}}</td>

                    <td scope="row" style="color:#9C9C9C; text-align: center; padding:10px;">
                  
                        <label class="switch">
                            <input type="checkbox" name="check" id="status_on{{$user_code}}" {{$customer_status == 'active' ? 'checked' : '' ;}}>
                            {{-- {{dd($customer_status);}} --}}
                            <span class="slider round" style="text-align: center;">
                                <span style="color: white; font-size: 10px; text-align: center;">ON</span>
                                <span style="color: white; font-size: 10px;">OFF</span>
                            </span>
                        </label>
                  
                    </td>

                    <td scope="row" style="color:#9C9C9C; text-align: center;  padding:10px;"><a href="/webpanel/customer/{{$user_code}}" id="edit"><i class="fa-regular fa-eye"></i></a>
                    <button type="button" id="trash"><i class="fa-regular fa-trash-can"></i></button>

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
                                        url: '/webpanel/customer/status-active',
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
                                        url: '/webpanel/customer/status-inactive',
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

                <script>
                    $(document).ready(function() {
                        $('#trash').click(function() {
                            console.log('trash');
                        });
                    });
                </script>

              @endforeach
              @endif
            </tbody>
          </table>

            <nav aria-label="Page navigation example">
                <ul class="pagination">
                <li class="page-item">

                @if ($page == 1)
                    <a class="page-link" href="/webpanel/customer?page=<?=1 ; ?>" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @else
                    <a class="page-link" href="/webpanel/customer?page=<?= $page-1 ; ?>" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @endif
                </li>

                @if($total_page > 14)

                    @for ($i= 1; $i <= 10 ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/customer?page=<?= $i ; ?>"><?php echo $i ; ?></a></li>
                    @endfor
                    <li class="page-item"><a class="page-link">...</a></li>
                    @for ($i= $total_page-1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/customer?page=<?= $i ; ?>"><?php echo $i ; ?></a></li>
                    @endfor

                @else
                    @for ($i= 1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/customer?page=<?= $i ; ?>"><?php echo $i ; ?></a></li>
                    @endfor
                
                @endif

                <li class="page-item">
                
                @if ($page == $total_page)
                    <a class="page-link" href="/webpanel/customer?page=<?= $page ; ?>" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @else
                    <a class="page-link" href="/webpanel/customer?page=<?= $page+1 ; ?>" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @endif
                </li>
                </ul>
            </nav>

    </div>

@endsection
</body>
</html>
