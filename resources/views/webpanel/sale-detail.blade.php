<!DOCTYPE html>
<html lang="en">
    @section ('title', 'admin-create')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>customer</title>
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
            text-align: left;
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
        .btn {
            background-color: #09A542;
            color:white;
        }
        .btn:hover {
            width: auto;
            height: auto;
            background-color: #118C3E;
        }
    </style>

            @section('status_alert')
            <h6 class="justifiy-content:center;" style="">{{number_format($status_alert)}}</h6>
            @endsection

            @section('status_waiting')
            <h6 class="justifiy-content:center;" style="">{{number_format($status_waiting)}}</h6>
            @endsection

            @section('status_updated')
            <h6 class="justifiy-content:center;" style="">{{$status_updated}}</h6>
            @endsection

            @section('text_alert')
            <h6 class="justifiy-content:center; mt-2 ms-4 mr-6" style="background-color:#cb4d4d; border-radius:20px; padding: 5px; color:#ffffff; font-weight:500;">{{$status_updated}}</h6>
            @endsection

    <div class="contentArea">
        <div style="text-align: left; margin-top: 10px;">
            <span style="color: #8E8E8E;"><a href="/webpanel/sale" id="backLink">ข้อมูลพนักงานขาย (Sale area)</a> / แบบฟอร์ม</span>
        </div>
        
        <hr style="color: #8E8E8E; width: 100%;">
        
        @if(isset($salearea) != null)
            <form action="/webpanel/sale-detail/update/{{$salearea->sale_area}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
            
                        <ul class="text-title" style="text-align: start; margin-top: 30px;">
                            <span style="font-size: 18px; font-weight: 500;">ระบุข้อมูลพนักงานขาย</span>
                            <hr>
                        </ul>
        
                        <div class="row text-muted">
                            <div class="col-sm-12">
                                <ul style="width: 100%;">
                                    <span>ชื่อพนักงานขาย</span>
                                    <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="sale_name" value="{{$salearea->sale_name}}">
                                </ul>
            
    
                                <ul style="width: 100%;">
                                    <span>เขตการขาย</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ ตัวอย่าง : S01</span>
                                    <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="sale_area" value="{{$salearea->sale_area}}">

                                    <div class="my-3">
                                        <span>Admin area</span>
                                        <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="admin_area" value="{{$salearea->admin_area}}" disabled>
                                    </div>

                                    <div class="mb-3 my-4">
                                        <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 18px; font-weight: 500;">เพิ่มเติม</label></label>
                                        <textarea class="form-control" style="color: grey;" id="exampleFormControlTextarea1" rows="3" name="text_add"> {{$salearea->text_add}}</textarea><br>

                                        <button type="submit" name="submit_update" class="btn py-3" style="border:none; width: 100%; color: white; padding: 10px;">บันทึกข้อมูล</button>
                                    </div>

                                        @if(Session::get('success'))
                                        <div class="alert alert-success" role="alert">
                                            <i class="fa-solid fa-circle-check" style="color:green;"></i>
                                            {{Session::get('success')}}
                                        </div>
                                        @elseif(Session::get('error'))
                                        <div class="alert alert-danger" role="alert">
                                            <i class="fa-solid fa-circle-xmark" style="color: rgb(172, 27, 27);"></i> 
                                            {{Session::get('error')}}
                                        </div>
                                        @endif
                                </ul>
                    
                            </div>
                        </div>
                    </div>
            </form>
        @else

                {{-- {{header("Refresh:0; /webpanel/sale");}} --}}
                <div>
                    <div class="alert alert-warning" role="alert">
                        <i class="fa-solid fa-exclamation-triangle" style="color:orange;"></i> 
                        ไม่พบข้อมูลพนักงานขาย
                    </div>
                    <a href="/webpanel/sale" class="btn py-3" style="border:none; width: 100%; color: white; padding: 10px;">กลับไปหน้าหลัก</a>
                </div
                </div>


        @endif
    </div>

@endsection
</body>
</html>
