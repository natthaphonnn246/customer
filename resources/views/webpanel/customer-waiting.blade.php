@extends ('layouts.webpanel')
@section('content')
@csrf

    <div class="contentArea w-full max-w-full break-words">
        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/customer" class="!no-underline">ย้อนกลับ</a> | รอดำเนินการ</h5>
        <hr class="my-3 !text-gray-400 !border">

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
                    รอดำเนินการ<br/>
                    @if (isset($total_status_waiting))
                    <span>{{$total_status_waiting != '' ? $total_status_waiting : '0'}}</span>
                    @else
                    <span>error</span>
                    @endif
                </span>
            </div>

        </div>

        <hr class="my-3" style="color: #8E8E8E; width: 100%;">

        <div class="ms-6 mr-6 mb-2 overflow-x-auto">
            {{-- <hr class="my-3" style="color: #8E8E8E; width: 100%;"> --}}
            <table class="table table-striped">
                <thead>

                <tr>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">#</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">CODE</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">อีเมล</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">ชื่อร้านค้า</td>
                    <td scope="col" class="!text-gray-500 text-center p-3 font-semibold">STATUS</td>
                    <td scope="col" class="!text-gray-500 text-center p-3 font-semibold">UPDATE</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">วันที่สมัคร</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">สถานะ</td>
                    <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">จัดการ</td>
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
                    
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$start++}}</td>
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$user_code}}</td>
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$email}}</td>
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$user_name}}</td>

                        @if ($status == 'รอดำเนินการ')
                        <td scope="row" class="text-gray-400 px-3 py-4 text-center"> <span class="inline-block border-2 border-red-500 text-red-500 px-3 py-2 rounded-lg text-sm">รอดำเนินการ</span></td>
                        @elseif ($status == 'ต้องดำเนินการ')
                        <td scope="row" class="text-gray-400 text-left px-3 py-4 text-center"><span class="inline-block border-2 border-yellow-500 text-yellow-500 px-3 py-2 rounded-lg text-sm">ต้องดำเนินการ</span></td>
                        @elseif ($status == 'ดำเนินการแล้ว')
                        <td scope="row" class="text-gray-400 text-left px-3 py-4 text-center"> <span class="inline-block border-2 border-green-500 text-green-500 px-3 py-2 rounded-lg text-sm">ดำเนินการแล้ว</span></td>
                        @else
                        <td scope="row" class="text-gray-400 text-left px-3 py-4"> </td>
                        @endif

                        @if ($status_update == 'updated')
                        <td scope="row" class="text-gray-400 text-left px-3 py-4 text-center"> <span class="inline-block border-2 border-red-500 text-red-500 px-3 py-2 rounded-lg text-sm">UPDATE</span></td>
                        @else
                        <td scope="row" class="text-gray-400 text-left px-3 py-4 text-center"><span class="inline-block border-2 border-gray-400 text-gray-400 px-3 py-2 rounded-lg text-sm">NULL</span></td>
                        @endif

                        <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$created_at}}</td>

                        <td scope="row" class="text-gray-400 text-left px-3 py-4">
                    
                            <label class="switch">
                                <input type="checkbox" name="check" id="status_on{{$id}}" {{$customer_status == 'active' ? 'checked' : ''}}>
                                {{-- {{dd($customer_status);}} --}}
                                <span class="slider round" style="text-align: center;">
                                    <span style="color: white; font-size: 10px; text-align: center;">ON</span>
                                    <span style="color: white; font-size: 10px;">OFF</span>
                                </span>
                            </label>
                    
                        </td>

                        <td scope="row" class="text-gray-400 text-left px-3 py-4">
                            <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                                <a href="/webpanel/customer/{{$id}}" id="edit"><i class="fa-regular fa-eye"></i></a>
                                <button class="trash-customer" type="submit" id="trash{{$id}}"><i class="fa-regular fa-trash-can"></i></button>
                            </div>
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
                    <a class="page-link" href="/webpanel/customer/status/waiting?page={{ 1 }}" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @else
                    <a class="page-link" href="/webpanel/customer/status/waiting?page={{ $page-1 }}" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @endif
                </li>

                @if($total_page > 14)

                    @for ($i= 1; $i <= 10 ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/customer/status/waiting?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link">...</a></li>
                    @for ($i= $total_page-1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/customer/status/waiting?page={{ $i }}">{{ $i }}</a></li>
                    @endfor

                @else
                    @for ($i= 1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/customer/status/waiting?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                
                @endif

                <li class="page-item">
                
                @if ($page == $total_page)
                    <a class="page-link" href="/webpanel/customer/status/waiting?page={{ $page }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @else
                    <a class="page-link" href="/webpanel/customer/status/waiting?page={{ $page + 1 }}" aria-label="Next">
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
@push('styles')
<style>
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
</style>

@endpush
