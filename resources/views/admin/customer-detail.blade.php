@extends ('layouts.admin')
<div id="bg">
    @section('content')
    {{-- @csrf --}}
{{-- 
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
--}}

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6"><a href="/admin/customer" class="!no-underline">ย้อนกลับ</a> | รายละเอียด</h5>
        <hr class="my-3 !text-gray-400 !border">

        @if(isset($customer_view) != '')

        {{-- {{dd($customer_view->customer_id)}} --}}

        {{-- <form action="{{ route('admin.customer.updated', ['id' => request()->id]) }}" method="post" enctype="multipart/form-data"> --}}
          {{--   @csrf
            @method('PATCH') --}}

                <div class="grid grid-cols-1 md:grid-cols-2 text-gray-600 mr-6 md:mx-2">
                    <div>
                        <ul>
                            <p class="text-xl mt-4">ข้อมูลร้านค้า</p>
                            <hr class="!text-gray-500 mb-1">
                        </ul>
                        <ul>
                            <!-- Button trigger modal -->
                            <li class="mt-4">
                                <p class="text-gray-600 mb-1">ใบอนุญาตขายยา/สถานพยาบาล <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                                <button type="button" class="w-full !bg-gray-200 hover:!bg-gray-300 !text-gray-500 p-2 !rounded-lg mt-2" id="certStore" data-bs-toggle="modal" data-bs-target="#staticBackdrop_store">
                                    ใบบอนุญาตขายยา/สถานพยาบาล
                                </button>
                                @if ($customer_view->cert_store == '')
                                <div class="my-3">
                                    <span class="bg-yellow-300 text-red-600 p-1"">*ไม่พบเอกสาร</span>
                                </div>
                                <hr class="!text-gray-500 mb-1">
                                @endif

                                <div class="modal fade" id="staticBackdrop_store" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                
                                            <div class="modal-header">
                                                <h5 class="modal-title">ใบอนุญาตขายยา/สถาพยาบาล</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                
                                            <div class="modal-body text-center">
                                                @if(!empty($customer_view->cert_store))
                                                    <img
                                                        src="{{ Storage::url($customer_view->cert_store) }}?v={{ time() }}"
                                                        class="img-fluid rounded"
                                                    >
                                                @else
                                                    <span class="text-danger">*ไม่พบเอกสาร</span>
                                                @endif
                                            </div>
                                
                                            <div class="modal-footer">
                                                <a href="{{ asset('storage/'.$customer_view->cert_store) }}"
                                                   download
                                                   class="btn btn-primary">
                                                    ดาวน์โหลดภาพ
                                                </a>
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">
                                                    ปิด
                                                </button>
                                            </div>
                                
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="mt-4">
                                <p class="text-gray-600 mb-1">ใบประกอบวิชาชีพ <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                                <button type="button" class="w-full !bg-gray-200 hover:!bg-gray-300 !text-gray-500 p-2 !rounded-lg mt-2" id="certMedical" data-bs-toggle="modal" data-bs-target="#staticBackdrop_medical">
                                    ใบประกอบวิชาชีพ
                                </button>
                                @if ($customer_view->cert_medical == '')
                                <div class="my-3">
                                    <span class="bg-yellow-300 text-red-600 p-1"">*ไม่พบเอกสาร</span>
                                </div>
                                <hr class="!text-gray-500 mb-1">
                                @endif

                                <div class="modal fade" id="staticBackdrop_medical" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                
                                            <div class="modal-header">
                                                <h5 class="modal-title">ใบประกอบวิชาชีพ</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                
                                            <div class="modal-body text-center">
                                                @if(!empty($customer_view->cert_medical))
                                                    <img
                                                        src="{{ Storage::url($customer_view->cert_medical) }}?v={{ time() }}"
                                                        class="img-fluid rounded"
                                                    >
                                                @else
                                                    <span class="text-danger">*ไม่พบเอกสาร</span>
                                                @endif
                                            </div>
                                
                                            <div class="modal-footer">
                                                <a href="{{ asset('storage/'.$customer_view->cert_medical) }}"
                                                   download
                                                   class="btn btn-primary">
                                                    ดาวน์โหลดภาพ
                                                </a>
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">
                                                    ปิด
                                                </button>
                                            </div>
                                
                                        </div>
                                    </div>
                                </div>
                            </li>


                            <li class="mt-4">
                                <p class="text-gray-600 mb-1">ใบทะเบียนพาณิชย์</p>
                                <button type="button" class="w-full !bg-gray-200 hover:!bg-gray-300 !text-gray-500 p-2 !rounded-lg mt-2" id="certCommerce" data-bs-toggle="modal" data-bs-target="#staticBackdrop_commerce">
                                    ใบทะเบียนพาณิชย์
                                </button>
                                @if ($customer_view->cert_commerce == '')
                                <div class="my-3">
                                    <span class="bg-yellow-300 text-red-600 p-1"">*ไม่พบเอกสาร</span>
                                </div>
                                <hr class="!text-gray-500 mb-1">
                                @endif

                                <div class="modal fade" id="staticBackdrop_commerce" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                
                                            <div class="modal-header">
                                                <h5 class="modal-title">ใบทะเบียนพาณิชย์</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                
                                            <div class="modal-body text-center">
                                                @if(!empty($customer_view->cert_commerce))
                                                    <img
                                                        src="{{ Storage::url($customer_view->cert_commerce) }}?v={{ time() }}"
                                                        class="img-fluid rounded"
                                                    >
                                                @else
                                                    <span class="text-danger">*ไม่พบเอกสาร</span>
                                                @endif
                                            </div>
                                
                                            <div class="modal-footer">
                                                <a href="{{ asset('storage/'.$customer_view->cert_commerce) }}"
                                                   download
                                                   class="btn btn-primary">
                                                    ดาวน์โหลดภาพ
                                                </a>
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">
                                                    ปิด
                                                </button>
                                            </div>
                                
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="mt-4">
                                <p class="text-gray-600 mb-1">ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</p>
                                <button type="button" class="w-full !bg-gray-200 hover:!bg-gray-300 !text-gray-500 p-2 !rounded-lg mt-2" id="certVat" data-bs-toggle="modal" data-bs-target="#staticBackdrop_vat">
                                    ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)
                                </button>
                                @if ($customer_view->cert_vat == '')
                                <div class="my-3">
                                    <span class="bg-yellow-300 text-red-600 p-1"">*ไม่พบเอกสาร</span>
                                </div>
                                <hr class="!text-gray-500 mb-1">
                                @endif

                                <div class="modal fade" id="staticBackdrop_vat" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                
                                            <div class="modal-header">
                                                <h5 class="modal-title">ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                
                                            <div class="modal-body text-center">
                                                @if(!empty($customer_view->cert_vat))
                                                    <img
                                                        src="{{ Storage::url($customer_view->cert_vat) }}?v={{ time() }}"
                                                        class="img-fluid rounded"
                                                    >
                                                @else
                                                    <span class="text-danger">*ไม่พบเอกสาร</span>
                                                @endif
                                            </div>
                                
                                            <div class="modal-footer">
                                                <a href="{{ asset('storage/'.$customer_view->cert_vat) }}"
                                                   download
                                                   class="btn btn-primary">
                                                    ดาวน์โหลดภาพ
                                                </a>
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">
                                                    ปิด
                                                </button>
                                            </div>
                                
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="mt-4">
                                <p class="text-gray-600 mb-1">สำเนาบัตรประชาชน</p>
                                <button type="button" class="w-full !bg-gray-200 hover:!bg-gray-300 !text-gray-500 p-2 !rounded-lg mt-2" id="certId" data-bs-toggle="modal" data-bs-target="#staticBackdrop_id">
                                    สำเนาบัตรประชาชน
                                </button>
                                @if ($customer_view->cert_id == '')
                                <div class="my-3">
                                    <span class="bg-yellow-300 text-red-600 p-1"">*ไม่พบเอกสาร</span>
                                </div>
                                <hr class="!text-gray-500 mb-1">
                                @endif

                                <div class="modal fade" id="staticBackdrop_id" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                
                                            <div class="modal-header">
                                                <h5 class="modal-title">สำเนาบัตรประชาชน</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                
                                            <div class="modal-body text-center">
                                                @if(!empty($customer_view->cert_id))
                                                    <img
                                                        src="{{ Storage::url($customer_view->cert_id) }}?v={{ time() }}"
                                                        class="img-fluid rounded"
                                                    >
                                                @else
                                                    <span class="text-danger">*ไม่พบเอกสาร</span>
                                                @endif
                                            </div>
                                
                                            <div class="modal-footer">
                                                <a href="{{ asset('storage/'.$customer_view->cert_id) }}"
                                                   download
                                                   class="btn btn-primary">
                                                    ดาวน์โหลดภาพ
                                                </a>
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">
                                                    ปิด
                                                </button>
                                            </div>
                                
                                        </div>
                                    </div>
                                </div>
                            </li>
                           
                        </ul>
                             
                        <script>
                            $(document).ready(function () {

                                    // Datepicker
                                    $("#datepicker" ).datepicker({
                                        changeMonth: true,
                                        changeYear: true,
                                        yearRange: "2022:2029",
                                        dateFormat: "dd/mm/yy"
                                    });

                                });
                        </script>
            <form id="editForm" onsubmit="return false;">
                        <ul class="mt-5">
                            <p class="text-xl mt-4">ข้อมูลลูกค้า</p>
                            <hr class="!text-gray-500 mb-1"> 
                        </ul>
                        <div>
                            <ul>
                                <p class="mb-1 mt-4 text-xm text-gray-600">ชื่อร้านค้า <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                                <input type="text" class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" name="customer_name" value="{{$customer_view->customer_name}}">

                            </ul>
                                   
                                @error('customer_name')

                                <div class="alert alert-danger my-2" role="alert">
                                    {{$message}}
                                </div>
                               
                                @enderror

                            <div>
                                <ul class="mt-4" style="width: 100%;">
                                    <p class="mb-1 text-xm text-gray-600">รหัสร้านค้า <span class="text-red-500 text-xm">*จำเป็นต้องระบุและ<span class="underline">ห้ามซ้ำ</span></span></p>
                                    <input type="text" class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" id="codeId" name="customer_code" value="{{$customer_view->customer_code}}">

                                </ul>

                                @error('customer_code')

                                <div class="alert alert-danger my-2" role="alert">
                                    {{$message}}
                                </div>
                               
                                @enderror

                            </div>
                            
                            <div>
                                <ul class="mt-4" style="width: 100%;">
                                    <p class="mb-1 text-xm text-gray-600">ระดับราคา <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                                    <select class="form-select !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="price_level">
                                    
                                      {{--   <option name="price_level" {{$customer_view->price_level == 1 ? 'selected' : '' }} value="1">1</option>
                                        <option name="price_level" {{$customer_view->price_level == 2 ? 'selected' : '' }} value="2">2</option>
                                        <option name="price_level" {{$customer_view->price_level == 3 ? 'selected' : '' }} value="3">3</option> --}}
                                        <option name="price_level" {{$customer_view->price_level == 4 ? 'selected' : '' }} value="4">4</option>
                                        <option name="price_level" {{$customer_view->price_level == 5 ? 'selected' : '' }} value="5">5</option>

                                    </select>
                                </ul>
                            </div>

                            <div>
                                <ul class="mt-3">
                                    <p class="text-gray-600 mb-1">เลขใบอนุญาตขายยา/สถานพยาพยาล <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                                    <input class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" type="text" name="cert_number" value="{{ $customer_view?->cert_number }}">
                                </ul>
                            </div>
                            <div>

                                    @php
                                    $year = date('Y') + 543; 
                                    @endphp
                                <ul class="mt-3">
                                    <label class="block mb-1 !text-gray-600">
                                        วันหมดอายุ
                                        <span class="text-xs text-red-500">
                                            *กรุณาตรวจสอบที่ใบอนุญาตอีกรอบ
                                        </span>
                                    </label>
                                
                                    <div class="relative">
                                        <input
                                            type="text"
                                            id="datepicker"
                                            name="cert_expire"
                                            value="{{ !empty($customer_view?->cert_expire) ? $customer_view->cert_expire : '31/12/'.$year }}"
                                            class="w-full rounded-md border !border-gray-300
                                                px-3 py-2 pr-10 text-gray-700
                                                focus:outline-none focus:ring-2 focus:ring-blue-500
                                                focus:border-blue-500 bg-white"
                                        >
                                
                                        <!-- calendar icon (right) -->
                                        <button
                                            type="button"
                                            id="openDatepicker"
                                            class="absolute inset-y-0 right-0 flex items-center px-3
                                                border-l !border-gray-300
                                                text-gray-600 hover:text-red-500
                                                bg-gray-50 border !rounded-r-md">
                                            <i class="fa-regular fa-calendar"></i>
                                        </button>
                                    </div>
                                </ul>
                                
                                <script>
                                    $(function () {
                                        $("#datepicker").datepicker({
                                            dateFormat: 'dd/mm/yy',
                                            changeMonth: true,
                                            changeYear: true,
                                            yearRange: "2569:2574"
                                        });
                                    
                                        $("#openDatepicker").on("click", function () {
                                            $("#datepicker").focus();
                                        });
                                    });
                                </script>
                            </div>
                            <div>
                                <ul style="width: 100%;">
                                
                                <li class="mt-4">
                                    <p class="mb-1 text-xm text-gray-600">แบบอนุญาตขายยา</p>
                                    <select class="form-control !text-gray-400 p-2 rounded-lg mt-2" aria-label="Default select example" name="type" disabled>

                                        <option {{$customer_view->type == '' ? 'selected': ''}} value="">ไม่ระบุ</option>
                                        <option {{$customer_view->type == 'ข.ย.1' ? 'selected': ''}} value="ข.ย.1">ข.ย.1</option>
                                        <option {{$customer_view->type == 'ข.ย.2' ? 'selected': ''}} value="ข.ย.2">ข.ย.2</option>
                                        <option {{$customer_view->type == 'ย.บ.1' ? 'selected': ''}} value="ย.บ.1">ย.บ.1</option>
                                        <option {{$customer_view->type == 'คลินิกยา/สถานพยาบาล' ? 'selected': ''}} value="คลินิกยา/สถานพยาบาล">คลินิกยา/สถานพยาบาล</option>
                                    
                                    </select>
                                </li>
                                <li class="mt-4">
                                    <p class="mb-1 text-xm text-gray-600">อีเมล</p>
                                    <input class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500 placeholder:!text-gray-300" name="email" type="email" value="{{$customer_view->email}}" placeholder="ไม่ได้ระบุ">
                                </li>
                                <li class="mt-4">
                                    <p class="mb-1 text-xm text-gray-600">เบอร์โทรศัพท์ร้านค้า <span class="text-red-500 text-xs">*ตัวอย่าง: 027534701 (ห้ามขีด(-) หรือ เว้นวรรค)</span></p>
                                    <input class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500 placeholder:!text-gray-300" type="text" name="phone" value="{{$customer_view->phone}}" placeholder="ไม่ได้ระบุ">
                                </li>
                                <li class="mt-4">
                                    <p class="mb-1 text-xm text-gray-600">เบอร์โทรศัพท์มือถือ <span class="text-red-500 text-xs">*ตัวอย่าง: 0802241118 (ห้ามขีด(-) หรือ เว้นวรรค)</span></p>
                                    <input class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500 placeholder:!text-gray-300" type="text" name="telephone" value="{{$customer_view->telephone}}" placeholder="ไม่ได้ระบุ">
                                </li>
                                {{-- {{dd($customer_view->delivery_by);}} --}}
                                <li class="mt-4">
                                    <p class="mb-1 text-xm text-gray-600">ที่อยู่จัดส่ง <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                                    <textarea
                                        class="form-control resize-none !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500 placeholder:!text-gray-300"
                                        name="address"
                                        rows="2"
                                        >{{ $customer_view->address }}
                                    </textarea>                            
                                </li>
                                </ul>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 text-gray-600">
                                <div>
                                    <ul>
                                        <p class="mb-1 text-xm text-gray-600">จังหวัด</p>
                                        {{-- <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="province"> --}}
                
                                        <select class="form-select !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="province" id="province">
                                            @if(isset($province))
                                            @foreach($province as $row)
                            
                                                <option value="{{$row->id}}" {{$row->name_th == $customer_view->province ? 'selected' : ''}}>{{$row->name_th}}</option>
                                            
                                            @endforeach
                                        @endif
                                        </select>
                                    </ul>
                                </div>
                                <div>
                                    <ul>
                                        <p class="mb-1 text-xm text-gray-600">อำเภอ/เขต</p>
                                        <select class="form-select !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="amphur" id="amphures">
                                            
                                            @if(!isset($amphur))
                                            @foreach($amphur as $row)
                                                <option value="{{$row->province_id}}" {{$row->name_th == $customer_view->amphur ? 'selected' : ''}}>{{$row->name_th}}</option>
                                            @endforeach

                                            @else
                                            <option>{{$customer_view->amphur}}</option>
                                            @endif
                                        </select>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="mt-2">
                                        <p class="mb-1 text-xm text-gray-600">ตำบล/แขวง</p>
                                        <select class="form-select !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="district" id="districts">
                                            @if(!isset($district))
                                            @foreach($district as $row)
                                                <option value="{{$row->amphure_id}}" {{$row->name_th == $customer_view->district ? 'selected' : ''}}>{{$row->name_th}}</option>
                                            @endforeach

                                            @else
                                            <option>{{$customer_view->district}}</option>
                                            @endif
                                        </select>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="mt-2">
                                        <p class="mb-1 text-xm text-gray-600">รหัสไปรษณีย์ <span class="text-red-500 text-xs">*ตรวจอีกรอบ</span></p>
                                        <input style="margin-top:10px; color:rgb(171, 171, 171);" type="text" class="form-control" id="zipcode" name="zip_code" value="{{$customer_view->zip_code}}">
                                    </ul>
                                </div>

                                <input type="hidden" name="geography" value="{{ $customer_view->geography }}">
                            </div>
                        </div>
                    </div>
                    <!--form login-->
                    <div class="p-4">
                        <div class="form-control">
                            <div class="mx-3">
                                <p class="text-xl mt-4 text-gray-600">ข้อมูลผู้รับผิดชอบ</p>
                                <hr class="!text-gray-500 mb-1"> 
                            </div>
                            <div class="mx-3 mt-3">

                                <p class="mb-1 text-xm text-gray-600">แอดมินผู้ดูแล</p>
                                <select class="form-select !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="admin_area" required>

                                    @if(isset($admin_area_list))
                                    @foreach($admin_area_list as $row)

                                        @if($row->rights_area !== 0) <!-- 0 == ไม่มีสิทธิ์ดูแลลูกค้า -->
                                
                                            <option {{$row->admin_area == $admin_area_check->admin_area ? 'selected': '' ; }} value="{{$row->admin_area}}">{{$row->admin_area.' '. '('. $row->name. ')'}}</option>

                                        @endif

                                    @endforeach
                                    @endif

                                    </select><br>

                                    <p class="mb-1 text-xm text-gray-600">พนักงานขาย/เขตการขาย <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                                    <select class="form-select !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="sale_area">

                                        <option {{$customer_view->sale_area == 'ไม่ระบุ' ? 'selected': ''}} value="ไม่ระบุ"> ไม่ระบุ </option>

                                        @if(isset($sale_area))
                                            @foreach($sale_area as $row_sale_area)
                                                <option {{$customer_view->sale_area == $row_sale_area->sale_area ? 'selected': ''}} value="{{$row_sale_area->sale_area}}"> {{$row_sale_area->sale_area .' '. '('. $row_sale_area->sale_name.')'}} </option>
                                            @endforeach
                                        @endif

                                    </select><br>

                            </div>
                
                        </div>

                        <div class="mb-3 my-4">
                            <div class="form-control">
                                <div class="mx-3">
                                    <p class="text-xl mt-4 text-gray-600">การจัดส่งสินค้า</p>
                                    <hr class="!text-gray-500 mb-1"> 
                                </div>
                                <div class="mx-3 mt-3 mb-4">
    
                                    <p class="mb-1 text-xm text-gray-600">ต้องการใบกำกับหรือไม่</p>
                                        <select class="form-select !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="status_vat">
        
                                            <option {{$customer_view->status_vat === 0 ? 'selected': ''}} value="0">ไม่รับ</option>
                                            <option {{$customer_view->status_vat === 1 ? 'selected': ''}} value="1">รับ</option>
        
                                        </select>

                                    <p class="mb-1 mt-4 text-xm text-gray-600">การจัดส่งสินค้า</p>
                                        <select class="form-select !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="delivery_by">
        
                                            <option {{$customer_view->delivery_by === 'standard' ? 'selected': ''}} value="standard">ไม่ระบุ</option>
                                            <option {{$customer_view->delivery_by === 'owner' ? 'selected': ''}} value="owner">ขนส่งเอกชน</option>
        
                                        </select>

                                    <p class="mb-1 mt-4 text-xm text-gray-600">ช่องทางการสั่งซื้อ</p>
                                        <select class="form-select !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="purchase">
        
                                            <option {{$customer_view->purchase === 1 ? 'selected': ''}} value="1">สั่งซื้อผ่านทางเว็บไซต์</option>
                                            <option {{$customer_view->purchase === 0 ? 'selected': ''}} value="0">สั่งซื้อผ่านช่องทางอื่น ๆ (เช่น LINE หรือทางโทรศัพท์)</option>
        
                                        </select>
                                </div>
                    
                            </div>

                            <div class="form-control mt-4">
                                <div class="mx-3">
                                    <p class="text-xl mt-4 text-gray-600">สถานะเปิดบัญชี SAP <span class="text-red-500 text-xm">*จำเป็นต้องระบุ</span></p>
                                    <hr class="!text-gray-500 mb-1"> 
                                </div>
                                <div class="mx-3 mt-3 mb-4">
    
                                    <p class="mb-2 text-xm text-gray-600">หากบันทึกข้อมูลใน SAP แล้ว กรุณาเปลี่ยนสถานะ</p>
                                    <select 
                                        class="form-select !border-gray-300 p-2 rounded-lg 
                                        {{ $customer_view->status_sap === 0 ? 'hover:!border-red-500' : 'hover:!border-green-500' }}
                                        {{ $customer_view->status_sap === 0 ? '!text-red-500' : '!text-green-500' }}" 
                                        aria-label="Default select example" 
                                        name="status_sap"
                                    >
    
                                        <option {{$customer_view->status_sap === 0 ? 'selected': ''}} value="0">ยังไม่ดำเนินการ</option>
                                        <option {{$customer_view->status_sap === 1 ? 'selected': ''}} value="1">ดำเนินการแล้ว</option>
    
                                    </select>

                                    <p class="mb-2 mt-4 text-xm text-gray-600">สถานะเปิดบัญชี WEB</p>

                                    @if($customer_view->status_sap === 1 && $customer_view->status_web === 0)
                                    <p class="form-control !text-gray-500 p-2 rounded-lg">กำลังดำเนินการ</p>
                                    @elseif ($customer_view->status_sap === 0 && $customer_view->status_web === 0)
                                    <p class="form-control !text-gray-500 p-2 rounded-lg">รอดำเนินการ</p>
                                    @else
                                    <p class="form-control !text-gray-500 p-2 rounded-lg">ดำเนินการแล้ว</p>
                                    @endif
                                    
                                </div>
                    
                            </div>
                                    
                            <div class="mb-3 my-4 ms-2 mr-2">
                                <label for="exampleFormControlTextarea1" class="form-label">ข้อความจากเซลล์ถึงผู้เปิดบัญชี</label></label>
                                <textarea class="form-control mt-2" id="exampleFormControlTextarea1" rows="3" name="text_add" disabled>{{$customer_view->text_admin}}</textarea>

                            </div>

                            <div class="mb-3 my-4 ms-2 mr-2">
                                <p class="mb-1 text-xm text-gray-600">ลงทะเบียนโดย</p>
                                <input class="form-control !text-red-500 !border-gray-300 p-2 rounded-lg mt-2"type="text" id="" name="" value="{{$customer_view->register_by}}" disabled>
                            </div>
                           
                            <div class="text-end mr-2">
                                <button type="submit"
                                    class="bg-blue-600 px-4 py-2 hover:bg-blue-700 !rounded-lg text-white">
                                    บันทึกข้อมูล
                                </button>
                            </div>
                            
                           
                        </div>
                        
                    </div>

                </div>
            </form>
         <script>
             
                $('#province').change(function(e) {
                e.preventDefault();
                let province_id = $(this).val();
                console.log(province_id);
                
                    $.ajax({
                        url: '/admin/customer-create/update-amphure',
                        type: 'get',
                        data: {province_id: province_id},
                        success: function(data) {

                            $('#amphures').html(data);

                        }
                    });
                });

                $('#province').change(function(e) {
                e.preventDefault();
                let province_id = $(this).val();
                console.log(province_id);
                
                    $.ajax({
                        url: '/admin/customer-create/update-geography',
                        type: 'get',
                        data: {province_id: province_id},
                        success: function(data) {

                            $('#geography').val(data);

                        }
                    });
                });

                $('#amphures').change(function(e) {
                e.preventDefault();
                let amphure_id = $(this).val();
                console.log(amphure_id + 'checked');
                
                    $.ajax({
                        url: '/admin/customer-create/update-district',
                        type: 'get',
                        data: {amphure_id: amphure_id},
                        success: function(data) {

                            $('#districts').html(data);
                        
                        }
                    });
                });

                $('#province').click(function() {
    
                let province_id = $(this).val();
                
                console.log(province_id);
                
                $.ajax({
                    url: '/admin/customer-create/update-amphure',
                    type: 'get',
                    data: {province_id: province_id},
                    success: function(data) {

                        $('#amphures').html(data);

                    }
                });
                });

                $('#amphures').click(function(e) {
                e.preventDefault();
                let amphure_id = $(this).val();
                console.log(amphure_id);
                
                    $.ajax({
                        url: '/admin/customer-create/update-district',
                        type: 'get',
                        data: {amphure_id: amphure_id},
                        success: function(data) {

                            $('#districts').html(data);
                        
                        }
                    });
                });

                $('#districts').change(function(e) {
                e.preventDefault();
                let amphure_id = $(this).val();
                console.log(amphure_id);
                
                    $.ajax({
                        url: '/admin/customer-create/update-zipcode',
                        type: 'get',
                        data: {amphure_id: amphure_id},
                        success: function(data) {

                            $('#zipcode').val(data);
                            // console.log(data);
                        
                        }
                    });
                });

                $('#districts').click(function(e) {
                e.preventDefault();
                let amphure_id = $(this).val();
                console.log(amphure_id);
                
                    $.ajax({
                        url: '/admin/customer-create/update-zipcode',
                        type: 'get',
                        data: {amphure_id: amphure_id},
                        success: function(data) {

                            $('#zipcode').val(data);
                            // console.log(data);
                        
                        }
                    });
                });

        </script>

    <script>
            document.getElementById('editForm').addEventListener('submit', function (e) {
                e.preventDefault();
            
                const form = e.target;
            
                const data = {
                    customer_name: form.customer_name.value,
                    customer_code: form.customer_code.value,
                    price_level: form.price_level.value,
                    cert_number: form.cert_number.value,
                    cert_expire: form.cert_expire.value,
                    email: form.email.value,
                    phone: form.phone.value,
                    telephone: form.telephone.value,
                    delivery_by: form.delivery_by.value,
                    address: form.address.value,
                    province: form.province.value,
                    amphur: form.amphur.value,
                    district: form.district.value,
                    zip_code: form.zip_code.value,
                    admin_area: form.admin_area.value,
                    sale_area: form.sale_area.value,
                    status_vat: form.status_vat.value,
                    status_sap: form.status_sap.value,
                    purchase: form.purchase.value,
                };
            
                fetch("{{ route('admin.customer.update', $customer_view->slug) }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('HTTP error ' + res.status);
                    }
                    return res.json();
                })
                .then(result => {
                    Swal.fire({
                        icon: result.status === 'success' ? 'success' : 'warning',
                        title: result.status === 'success' ? 'สำเร็จ' : 'แจ้งเตือน',
                        text: result.message,
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: 'ไม่สามารถบันทึกข้อมูลได้ กรุณาตรวจสอบรหัสลูกค้า',
                    });
                });
            });
    </script>

        @endif
</div>
@endsection
