@extends('layouts.admin')
@section('content')
@csrf
    
      {{--   @section('status_alert')
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

        @section('username')
        <h6 class="color:#ffffff; font-weight:300;">{{$user_name}}</h6>
        @endsection --}}
        {{-- <img src="{{ url('/') }}/storage/certificates/img_certstore/1dcV3LQvU5DbAW2hVAMAwHyYLLng85K9aGq4TX47.jpg"> --}}

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6">ร้านค้า (Customer)</h5>
        <hr class="my-3 !text-gray-400 !border">

   {{--      <div class="ms-6 mr-6" style="text-align: right;">

            <a href="/admin/customer/export/getcsv/getcsv_customerall"  id="exportcsv" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">Export CSV</a>
            <a href="/admin/customer/export/getexcel/getexcel_customerall"  id="exportexcel" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">Export Excel</a>
    
        </div> --}}

        <div class="grid grid-cols-1 md:grid-cols-2 max-w-6xl py-4 px-4 ms-4 gap-8 bg-white rounded-2xl">

            <!-- ร้านค้าทั้งหมด -->
    {{--         <div>
                <div
                    class="w-full h-[90px]
                           bg-blue-500 rounded-lg
                           flex flex-col justify-between
                           px-4 py-3
                           text-white"
                >
                    <h6 class="text-sm">
                        ร้านค้าทั้งหมด
                    </h6>
        
                    <span class="text-2xl font-bold text-right leading-none">
                        {{ $total_customer ?? '0' }}
                    </span>
                </div>
            </div> --}}
        
            <!-- ลงทะเบียนใหม่ -->
            <div>
                {{-- <a href="/admin/customer/status/completed" --}}
                <div
                    class="w-full h-[90px]
                    bg-red-500 rounded-lg
                    flex flex-col justify-between
                    px-4 py-3
                    text-white !no-underline
                    {{-- hover:bg-red-600 hover:shadow-lg --}}
                    transition"
                >
            
                <h6 class="text-sm">
                    ลงทะเบียนใหม่
                </h6>
    
                <span class="text-2xl font-bold text-right leading-none">
                    {{ $total_status_register ?? '0' }}
                </span>
            </div>
                {{-- </a> --}}
            </div>
        
            <!-- กำลังดำเนินการ -->
     {{--        <div>
                <div
                   class="w-full h-[90px]
                          bg-yellow-500 rounded-lg
                          flex flex-col justify-between
                          px-4 py-3
                          text-white !no-underline
                          transition"
                >
                    <h6 class="text-sm">
                        กำลังดำเนินการ
                    </h6>
        
                    <span class="text-2xl font-bold text-right leading-none">
                        {{ $total_status_action ?? '0' }}
                    </span>
                </div>
            </div> --}}
        
            <!-- ดำเนินการแล้ว -->
          {{--   <div
                   class="w-full h-[90px]
                          bg-green-500 rounded-lg
                          flex flex-col justify-between
                          px-4 py-3
                          text-white !no-underline
                          transition"
                >
                    <h6 class="text-sm">
                        ดำเนินการแล้ว
                    </h6>
        
                    <span class="text-2xl font-bold text-right leading-none">
                        {{ $total_status_completed ?? '0' }}
                    </span>
            </div> --}}
        
        </div>
        
        <hr class="my-1 !text-gray-400">
            <!--- search --->

           {{--  <div class="col-sm-2">
                <form class="max-w-100 mx-auto mt-2" method="get" action="/admin/customer">
                  
                    <p class="py-2" id="keyword_search"></p>
                    @csrf   
                </form>
            </div> --}}

            <div class="w-full md:w-1/2 px-4 ms-4 md:px-0 mb-4">
                <div class="w-full mx-auto">
                    <p class="text-lg text-gray-500 mt-4 mb-1">
                        ค้นหาผู้ใช้ :
                    </p>
            
                    <form method="get" action="/admin/customer"
                          class="flex items-center gap-2 mt-2">
                        
                        <input
                            type="search"
                            name="keyword"
                            value="{{ request('keyword') }}"
                            placeholder="CODE | ชื่อร้านค้า"
                            class="flex-1 px-3 py-2.5 border rounded-lg focus:ring-red-500"
                        >
            
                        <button
                            type="submit"
                            class="bg-gray-600 hover:bg-gray-700
                                   text-white px-4 py-2.5 !rounded-md transition">
                            ค้นหา
                        </button>
                    </form>
                </div>
            </div>            

            <script>
                $(document).ready(function() {
                    $('#default-search').keyup(function(e) {
                        e.preventDefault();  // Prevent form from submitting

                        $.ajax({
                            url: '/webpanel/customer/search/code',
                            method: 'GET',
                            data: {
                                keyword: $(this).val(),

                            },
                            catch:false,
                            success: function(data) {
                                
                                $('#keyword_search').html(data);

                            }
                        });
                    /*  let keyword = $(this).val();
                        console.log(keyword ); */
                    });
                });
            </script>

        <div class="grid grid-cols-1 md:grid-cols-1 gap-4 px-4 md:px-6 mx-4 mb-2">
            <hr class="!text-gray-500 mb-1">
            <h4 class="!text-gray-600 mx-2">{{ $customer->count() > 0 ? 'ลงทะเบียนใหม่' : '' }}</h4>
            <div class="overflow-x-auto">
            <table class="table table-striped">
                <thead>

                    <tr>
                        <td scope="col" 
                        class="!text-gray-700 text-left font-medium p-3">
                            #
                        </td>
                    
                        <td scope="col"
                            class="!text-gray-700 text-left font-medium p-3">
                            รหัสร้านค้า
                        </td>
                    
                        <td scope="col"
                            class="!text-gray-700 text-left font-medium p-3">
                            ชื่อร้านค้า
                        </td>
                  
                        <td scope="col"
                            class="!text-gray-700 text-center font-medium p-3">
                            SAP
                        </td>

                        <td scope="col"
                            class="!text-gray-700 text-center font-medium p-3">
                            WEB
                        </td>

                        <td scope="col"
                            class="!text-gray-700 text-left font-medium p-3">
                            วันที่ลงทะเบียน
                        </td>

                        <td scope="col"
                            class="!text-gray-700 text-center font-medium p-3">
                            จัดการ
                        </td>
                    </tr>
                </thead>
                <tbody>
                @if($customer->count() > 0)
                    <?php 
                        @$start += 1;
                    ?>
                    @foreach ($customer as $row)
                <tr>
                        <?php
                            
                            $id = $row->id;
                            $customer_name = $row->customer_name;
                            $customer_code = $row->customer_code;
                            $status_sap = $row->status_sap;
                            $status_web = $row->status_web;
                            $status_update = $row->status_update;
                            $email = $row->email;
                            $customer_status = $row->customer_status;
                            $created_at = $row->created_at;
                            $slug = $row->slug;
                        ?>
                    <td scope="row" class="!text-gray-500 text-left p-3">
                        {{ $start++ }}
                    </td>
                    
                    <td scope="row" class="!text-gray-500 text-left p-3">
                        {{ $customer_code }}
                    </td>
                    
                    <td scope="row" class="!text-gray-500 text-left p-3 w-1/5">
                        {{ $customer_name }}
                    </td>

                    {{-- STATUS SAP --}}
                    @if ($status_sap === 0)
                        <td scope="row" class="text-center p-3 w-1/5">
                            <span class="inline-block border-2 border-red-500 text-red-500 px-3 py-2 rounded-lg">
                                รอดำเนินการ
                            </span>
                        </td>
                
                    @elseif ($status_sap == 1)
                        <td scope="row" class="text-center p-3 w-1/5">
                            <span class="inline-block border-2 border-green-500 text-green-600 px-3 py-2 rounded-lg">
                                ดำเนินการแล้ว
                            </span>
                        </td>
                    @endif
                    
                    {{-- STATUS web --}}
                    @if ($status_web === 0 && $status_sap === 0)
                        <td scope="row" class="text-center p-3 w-1/5">
                            <span class="inline-block border-2 border-red-500 text-red-500 px-3 py-2 rounded-lg">
                                รอดำเนินการ
                            </span>
                        </td>
                    
                    @elseif ($status_sap === 1)
                        <td scope="row" class="text-center p-3 w-1/5">
                            <span class="inline-block border-2 border-amber-400 text-amber-500 px-3 py-2 rounded-lg">
                                กำลังดำเนินการ
                            </span>
                        </td>
                    
                    @elseif ($status_web === 1)
                        <td scope="row" class="text-center p-3 w-1/5">
                            <span class="inline-block border-2 border-green-500 text-green-600 px-3 py-2 rounded-lg">
                                ดำเนินการแล้ว
                            </span>
                        </td>
                    @else
                        <td scope="row" class="p-7 w-1/5"></td>
                    @endif

                    <td scope="row" class="!text-gray-500 text-left p-3">
                        {{ $created_at }}
                    </td>

                    {{-- ACTION --}}
                    <td scope="row" class="text-center p-3 w-1/5">
                        <a href="/admin/customer/{{ $slug }}"
                        class="bg-blue-500 hover:bg-blue-600 px-3 py-2 rounded-lg text-white transition">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                    </td>
                </tr>

                <!-- delete customer table -->

                    <script>
                            $(document).ready(function() {

                                    $('#trash{{$id}}').click(function(e) {
                                        e.preventDefault();
                           
                                        let code_del = '{{$id}}';
                     

                                            swal.fire({
                                                icon: "warning",
                                                title: "คุณต้องการลบข้อมูลหรือไม่",
                                                text: '{{$customer_code.' '.'('. $customer_name.')'}}',
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
                                                            text: 'ไม่พบข้อมูล {{$customer_code.' '.'('. $customer_name.')'}}',
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
                @else
                <tr>
                    <td colspan="7" class="text-center text-muted">
                    ไม่พบข้อมูล
                    </td>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
        </div>
        @if(!isset($check_keyword) && $total_page > 1)
        <div class="ms-6">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                <li class="page-item">

                @if ($page == 1)
                    <a class="page-link" href="/admin/customer?page={{ 1 }}" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @else
                    <a class="page-link" href="/admin/customer?page={{ $page - 1 }}" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @endif
                </li>

                @if($total_page > 14)

                    @for ($i= 1; $i <= 3 ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/admin/customer?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link">...</a></li>
                    @for ($i= $total_page-1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/admin/customer?page={{ $i }}">{{ $i }}</a></li>
                    @endfor

                @else
                    @for ($i= 1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/admin/customer?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                
                @endif

                <li class="page-item">
                
                @if ($page == $total_page)
                    <a class="page-link" href="/admin/customer?page={{ $page }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @else
                    <a class="page-link" href="/admin/customer?page={{ $page + 1 }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @endif
                </li>
                </ul>
            </nav>
        </div>
        <hr class="my-1 !text-gray-500">
        <div class="py-3">
            <p class="ms-8 text-sm" style="color:#898989;"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
        </div>
        @elseif ($count_page <= 1)
        <div class="py-3">
            <p class="ms-8 text-sm" style="color:#898989;"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
        </div>
        @else
        <div class="ms-6">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                <li class="page-item">

                @if ($page == 1)
                    <a class="page-link" href="/admin/customer?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ 1 }}" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @else
                    <a class="page-link" href="/admin/customer?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $page - 1 }}" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @endif
                </li>

                @if($total_page > 14)

                    @for ($i= 1; $i <= 3 ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/admin/customer?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link">...</a></li>
                    @for ($i= $total_page-1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/admin/customer?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $i }}">{{ $i }}</a></li>
                    @endfor

                @else
                    @for ($i= 1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/admin/customer?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                
                @endif

                <li class="page-item">
                
                @if ($page == $total_page)
                    <a class="page-link" href="/admin/customer?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $page }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @else
                    <a class="page-link" href="/admin/customer?keyword={{ request('keyword') }}&_token={{ request('_token') }}&page={{ $page + 1 }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @endif
                </li>
                </ul>
            </nav>
        </div>
        <hr class="my-1 !text-gray-500">
        <div class="py-3">
            <p class="ms-8 text-sm" style="color:#898989;"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
        </div>
        @endif

    </div>
@endsection
