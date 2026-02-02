@extends ('layouts.webpanel')
@section('content')
@csrf

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6">แอดมิน (Admin)</h5>
        <hr class="my-3 !text-gray-400 !border">

        <div class="ms-6 py-2">
            <a href="/webpanel/admin-create"  id="" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md !no-underline" type="submit"  name="">เพิ่มแอดมิน</a>
            <a href="/webpanel/admin-group"  id="" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md !no-underline" type="submit"  name="">จัดกลุ่มไลน์</a>
    
            <form action="{{ route('line.revoktoken.all') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white !no-underline !rounded-md py-2 px-4 mt-1"
                    onclick="return confirm('คุณต้องการยกเลิกการเชื่อมต่อ LINE ใช่หรือไม่?')">
                    ยกเลิกเชื่อมต่อไลน์
                </button>
            </form>

        </div>

        <div class="mx-12">
            @if (Session::has('status_line'))
            <div class="alert alert-success mt-2"><i class="fa-solid fa-circle-check text-green-600"></i> {{ Session::get('status_line') }}</div>
            @endif
        </div>

        <hr class="my-3 !text-gray-400">

        <div class="grid mx-4 px-2 overflow-x-auto">
        <table class="table table-striped">
            <thead>
              <tr>
                <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">#</td>
                <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">CODE</td>
                <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">Admin area</td>
                <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">อีเมล</td>
                <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">ชื่อแอดมิน</td>
                <td scope="col" class="!text-gray-500 text-center p-3 font-semibold">สถานะอนุมัติ</td>
                <td scope="col" class="!text-gray-500 text-center p-3 font-semibold"><span class="!text-red-500 text-left text-xs">*ล็อกอินผิดเกิน 5 ครั้ง</span></br>ระงับบัญชี</td>
                <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">วันที่สมัคร</td>
                <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">จัดการ</td>
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
                        
                        $id = $row->id;
                        $user_name = $row->name;
                        $user_code = $row->user_code;
                        $admin_area = $row->admin_area;
                        $status_admin = $row->status_checked;
                        $is_blocked = $row->is_blocked;
                        $email = $row->email;
                        $created_at = $row->created_at;
                    ?>
                
                <td scope="row" class="!text-gray-500 text-left p-3">{{$start++}}</td>
                <td scope="row" class="!text-gray-500 text-left p-3">{{$user_code}}</td>
                <td scope="row" class="!text-gray-500 text-left p-3">{{$admin_area}}</td>
                <td scope="row" class="!text-gray-500 text-left p-3">{{$email}}</td>
                <td scope="row" class="!text-gray-500 text-left p-3">{{$user_name}}</td>
                <td scope="row" class="!text-gray-500 text-center p-3">
                  
                    @if ($user_code === '0000' || $user_code === '4494')
                        <label class="switch" style="opacity:0.6;">
                            <input type="checkbox" name="check" id="status_on{{$id}}" {{ $status_admin == 'active' ? 'checked disabled' : ''}}>
                            <span class="slider round" style="text-align: center;">
                                <span style="color: white; font-size: 10px; text-align: center;">ON</span>
                                <span style="color: white; font-size: 10px;">OFF</span>
                            </span>
                        </label>
                    @else
                        <label class="switch">
                            {{-- <input type="checkbox" name="check" id="status_on{{$id}}" {{ $status_admin == 'active' && $is_blocked == 0 ? 'checked' : ''}}> --}}
                            <input type="checkbox" name="check" id="status_on{{$id}}" {{ $status_admin == 'active' ? 'checked' : ''}}>
                            <span class="slider round" style="text-align: center;">
                                <span style="color: white; font-size: 10px; text-align: center;">ON</span>
                                <span style="color: white; font-size: 10px;">OFF</span>
                            </span>
                        </label>

                    @endif
                  
                </td>

                <td scope="row" class="!text-gray-500 text-center p-3">
                  
                    @if ($user_code == '0000' || $user_code == '4494')
                    <label class="switch">
                        <input class="is_blocked" type="checkbox" name="is_blocked" disabled>
                        <span class="slider round" style="text-align: center;">
                            <span style="color: white; font-size: 10px; text-align: center;">ON</span>
                            <span style="color: white; font-size: 10px;">OFF</span>
                        </span>
                    </label>

                    @else
                    <label class="switch">
                        <input class="is_blocked" type="checkbox" name="is_blocked" id="status_onblocked{{$id}}" {{ $is_blocked == 1 ? 'checked' : ''}}>
                        <span class="slider round" style="text-align: center;">
                            <span style="color: white; font-size: 10px; text-align: center;">ON</span>
                            <span style="color: white; font-size: 10px;">OFF</span>
                        </span>
                    </label>
                    @endif
                  
                </td>
               
                <td scope="row" class="!text-gray-500 text-left p-3">{{$created_at}}</td>

                <td class="px-4 py-3">
                    <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                
                        <!-- view -->
                        <a href="/webpanel/admin/{{$id}}"
                           class="inline-flex justify-center items-center
                                  bg-blue-600 text-white px-3 py-2.5 rounded
                                  hover:bg-blue-700 transition !no-underline">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                
                        <!-- delete -->
                        @if ($user_code == '0000')
                            <button disabled
                                class="inline-flex justify-center items-center
                                       bg-red-400 text-white px-3 py-2.5 rounded opacity-60">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        @else
                            <button id="trash{{$id}}"
                                class="inline-flex justify-center items-center
                                       bg-red-600 text-white px-3 py-2.5 rounded
                                       hover:bg-red-700 transition">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        @endif
                
                    </div>
                </td>
                
              </tr>

              @push('scripts')
                <!-- delete users table -->
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
                                            url: '/webpanel/admin/delete/{{$id}}',
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
                                        url: '/webpanel/admin/status-check',
                                        type: 'POST',
                                        data: {
                                            id_act: 2,
                                            status: 'active',
                                            is_blocked: 0,
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
                                        url: '/webpanel/admin/status-inactive',
                                        type: 'POST',
                                        data: {
                                            id_inact: 1,
                                            status_in: 'inactive',
                                            is_blocked: 1,
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

                    $(document).ready(function() {
                        // $('#status_on').prop('checked', false);
                        $('#status_onblocked{{$id}}').change(function() {
            
                            if($(this).is(':checked')) 
                            {
                                $('#status_onblocked{{$id}}').prop('checked', true);
                                console.log('ON');
                                // var admin_code = $(this).val();
                                const user_code = '{{$id}}';
                                console.log(user_code);
            
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    url: '/webpanel/admin/status-isblocked',
                                    type: 'POST',
                                    data: {
                                        is_blocked: 1,
                                        code_blocked: user_code,
                                        _token: "{{ csrf_token() }}",
                                    },
                                    success: function(response) {
            
                                        if(response == 'isblocked') {
                                            console.log('isblocked');

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
                                    url: '/webpanel/admin/status-unblocked',
                                    type: 'POST',
                                    data: {
                                        is_blocked: 0,
                                        code_blocked: user_code,
                                        _token: "{{ csrf_token() }}",
                                    },
                                    success: function(response) {
            
                                        if(response == 'unblocked') {
                                            console.log('unblocked');

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
                @endpush
              @endforeach
              @endif
            </tbody>
          </table>
        </ul>

@endsection
@push('styles')
<style>
    .contentArea {
        padding: 0px;
        background-color: #FFFFFF;
        border-radius: 2px;
        /* min-width: 100px; */
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
    .trash-admin {
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

    .is_blocked:checked + .slider {
        background-color: #f52e2e;
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

