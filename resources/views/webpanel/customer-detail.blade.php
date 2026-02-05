@extends ('layouts.webpanel')
@section('content')
@csrf
        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/customer" class="!no-underline">ย้อนกลับ</a> | กรอกข้อมูล</h5>
        <hr class="my-3 !text-gray-400 !border">

        @if(isset($customer_view) != '')

        {{-- {{dd($customer_view->customer_id)}} --}}

 
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mx-4 px-4 text-gray-500">

            <div>
                <p class="font-bold text-lg">ข้อมูลร้านค้า</p>
                <hr class="my-3 !text-gray-400">

                    <!-- Button trigger modal -->
                        <p class="mb-1">ใบอนุญาตขายยา/สถานพยาบาล <span class="text-xs text-red-500">*จำเป็นต้องระบุ</span></p>
                        <button type="button" class="bg-gray-300/70 hover:bg-gray-300 text-gray-500 w-full !rounded-sm mt-1 py-2" id="certStore" data-bs-toggle="modal" data-bs-target="#staticBackdrop_store">
                            ใบบอนุญาตขายยา/สถานพยาบาล
                        </button>
                        @if (empty($customer_view->cert_store))
                        <div class="py-2">
                            <span class="text-red-500 text-sm bg-yellow-300 py-1 px-2">*ไม่พบเอกสาร</span>
                        </div>
                        <hr class="my-2 mb-2">
                        @endif

                        <div class="modal fade" id="staticBackdrop_store" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">แก้ไขใบอนุญาตขายยา</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <span class="ms-3 py-2" style="text-align: start;">แก้ไขใบอนุญาตขายยา/สถานพยาบาล/Code : {{$customer_view->customer_code}}</span>
                            <hr class="my-2 mb-2">
                                <div class="modal-body">
                                    <form action="/webpanel/customer-detail/upload-store/{{$customer_view->customer_code}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    {{-- @if ((($customer_view->cert_store)) != '') --}}
                                    @if (!empty($customer_view->cert_store))
                                    
                                        <img 
                                            src="{{ asset('storage/' . $customer_view->cert_store) }}?v={{ time() }}"
                                            id="previewStore" 
                                            style="width: 100%; cursor: pointer;"
                                        />
                                    {{-- {{time()}} --}}
                                    @else
                                    <img src="/profile/image.jpg" width="100%" id="previewStore">
                                    @endif
                                
                                    <input type="file" id="imageStore" class="form-control" name="cert_store" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>
                                    {{-- <hr class="py-2 mt-2"> --}}
                                    
                                    <div class="modal-footer mt-4">

                                        <a href="{{ asset('storage/'.$customer_view->cert_store) }}"
                                            download
                                            class="btn btn-danger">
                                             ดาวน์โหลดภาพ
                                         </a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                        <button type="submit" name="submit_store" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                        {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                    </div>
                                
                                    </form>
                                </div>
                        
                            </div>
                        </div>
                        </div>

                        <p class="mb-1 mt-3">ใบประกอบวิชาชีพ <span class="text-xs text-red-500">*จำเป็นต้องระบุ</span></p>
                        <button type="button" class="bg-gray-300/70 hover:bg-gray-300 text-gray-500 w-full !rounded-sm mt-1 py-2" id="certMedical" data-bs-toggle="modal" data-bs-target="#staticBackdrop_medical">
                            ใบประกอบวิชาชีพ
                        </button>
                        {{-- @if ($customer_view->cert_medical == '') --}}
                        @if (empty($customer_view->cert_medical))
                        <div class="py-2">
                            <span class="text-red-500 text-sm bg-yellow-300 py-1 px-2">*ไม่พบเอกสาร</span>
                        </div>
                        <hr class="my-2 mb-2">
                        @endif

                        <div class="modal fade" id="staticBackdrop_medical" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">ใบประกอบวิชาชีพ</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <span class="ms-3 py-2" style="text-align: start;">ใบประกอบวิชาชีพ/Code : {{$customer_view->customer_code}}</span>
                            <hr class="my-2 mb-2">
                                <div class="modal-body">
                                    <form action="/webpanel/customer-detail/upload-medical/{{$customer_view->customer_code}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    {{-- @if ((($customer_view->cert_medical)) != '') --}}
                                    @if (!empty($customer_view->cert_medical))
                                    
                                        <img 
                                            src="{{ asset('storage/' . $customer_view->cert_medical) }}?v={{ time() }}"
                                            id="previewMedical" 
                                            style="width: 100%; cursor: pointer;"
                                        />
                                    {{-- {{time()}} --}}
                                    @else
                                    <img src="/profile/image.jpg" width="100%" id="previewMedical">
                                    @endif
                                
                                    <input type="file" id="imageMedical" class="form-control" name="cert_medical" style="margin-top: 10px;" accept="image/png, image/jpg, image/jpeg"/>
                                    {{-- <hr class="py-2 mt-2"> --}}
                                    <div class="modal-footer mt-4">

                                        <a href="{{ asset('storage/'.$customer_view->cert_medical) }}"
                                            download
                                            class="btn btn-danger">
                                             ดาวน์โหลดภาพ
                                         </a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                        <button type="submit" name="submit_medical" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                        {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                    </div>
                                
                                    </form>
                                </div>
                        
                            </div>
                        </div>
                        </div>
            
                        <p class="mb-1 mt-3">ใบทะเบียนพาณิชย์ <span class="text-xs text-red-500">*จำเป็นต้องระบุ</span></p>
                        <button type="button" class="bg-gray-300/70 hover:bg-gray-300 text-gray-500 w-full !rounded-sm mt-1 py-2" id="certCommerce" data-bs-toggle="modal" data-bs-target="#staticBackdrop_commerce">
                            ใบทะเบียนพาณิชย์
                        </button>
                        {{-- @if ($customer_view->cert_commerce == '') --}}
                        @if (empty($customer_view->cert_commerce))
                        <div class="py-2">
                            <span class="text-red-500 text-sm bg-yellow-300 py-1 px-2">*ไม่พบเอกสาร</span>
                        </div>
                        <hr class="my-2 mb-2" style="color: #8E8E8E; width: 100%;">
                        @endif

                        <div class="modal fade" id="staticBackdrop_commerce" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">ใบทะเบียนพาณิชย์</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <span class="ms-3 py-2" style="text-align: start;">ใบทะเบียนพาณิชย์/Code : {{$customer_view->customer_code}}</span>
                            <hr class="my-2 mb-2">
                                <div class="modal-body">
                                    <form action="/webpanel/customer-detail/upload-commerce/{{$customer_view->customer_code}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    {{-- @if ((($customer_view->cert_commerce)) != '') --}}
                                    @if (!empty($customer_view->cert_commerce))
                                    
                                        <img 
                                            src="{{ asset('storage/' . $customer_view->cert_commerce) }}?v={{ time() }}"
                                            id="previewCommerce" 
                                            style="width: 100%; cursor: pointer;"
                                        />
                                    {{-- {{time()}} --}}
                                    @else
                                    <img src="/profile/image.jpg" width="100%" id="previewCommerce">
                                    @endif
                                
                                    <input type="file" id="imageCommerce" class="form-control" name="cert_commerce" style="margin-top: 10px;" accept="image/png, image/jpg, image/jpeg"/>
                                    {{-- <hr class="py-2 mt-2"> --}}
                                    <div class="modal-footer mt-4">

                                        <a href="{{ asset('storage/'.$customer_view->cert_commerce) }}"
                                            download
                                            class="btn btn-danger">
                                             ดาวน์โหลดภาพ
                                         </a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                        <button type="submit" name="submit_commerce" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                        {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                    </div>
                                
                                    </form>
                                </div>
                        
                            </div>
                        </div>
                        </div>

                        <p class="mb-1 mt-3">ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20) <span class="text-xs text-red-500">*จำเป็นต้องระบุ</span></p>
                        <button type="button" class="bg-gray-300/70 hover:bg-gray-300 text-gray-500 w-full !rounded-sm mt-1 py-2" id="certVat" data-bs-toggle="modal" data-bs-target="#staticBackdrop_vat">
                            ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)
                        </button>
                        {{-- @if ($customer_view->cert_vat == '') --}}
                        @if (empty($customer_view->cert_vat))
                        <div class="py-2">
                            <span class="text-red-500 text-sm bg-yellow-300 py-1 px-2">*ไม่พบเอกสาร</span>
                        </div>
                        <hr class="my-2 mb-2">
                        @endif

                        <div class="modal fade" id="staticBackdrop_vat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <span class="ms-3 py-2" style="text-align: start;">ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)/Code : {{$customer_view->customer_code}}</span>
                            <hr class="my-2 mb-2">
                                <div class="modal-body">
                                    <form action="/webpanel/customer-detail/upload-vat/{{$customer_view->customer_code}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    {{-- @if ((($customer_view->cert_vat)) != '') --}}
                                    @if (!empty($customer_view->cert_vat))
                                    
                                    <img 
                                        src="{{ asset('storage/' . $customer_view->cert_vat) }}?v={{ time() }}"
                                        id="previewVat"
                                        style="width: 100%; cursor: pointer;"
                                    />
                                
                                    {{-- {{time()}} --}}
                                    @else
                                    <img src="/profile/image.jpg" width="100%" id="previewVat">
                                    @endif
                                
                                    <input type="file" id="imageVat" class="form-control" name="cert_vat" style="margin-top: 10px;" accept="image/png, image/jpg, image/jpeg"/>
                                    {{-- <hr class="py-2 mt-2"> --}}
                                    <div class="modal-footer mt-4">

                                        <a href="{{ asset('storage/'.$customer_view->cert_vat) }}"
                                            download
                                            class="btn btn-danger">
                                             ดาวน์โหลดภาพ
                                         </a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                        <button type="submit" name="submit_vat" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                        {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                    </div>
                                
                                    </form>
                                </div>
                        
                            </div>
                        </div>
                        </div>
                
                        <p class="mb-1 mt-3">สำเนาบัตรประชาชน <span class="text-xs text-red-500">*จำเป็นต้องระบุ</span></p>
                        <button type="button" class="bg-gray-300/70 hover:bg-gray-300 text-gray-500 w-full !rounded-sm mt-1 py-2" id="certId" data-bs-toggle="modal" data-bs-target="#staticBackdrop_id">
                            สำเนาบัตรประชาชน
                        </button>
                        {{-- @if ($customer_view->cert_id == '') --}}
                        @if (empty($customer_view->cert_id))
                        <div class="py-2">
                            <span class="text-red-500 text-sm bg-yellow-300 py-1 px-2">*ไม่พบเอกสาร</span>
                        </div>
                        <hr class="my-2 mb-2">
                        @endif

                        <div class="modal fade" id="staticBackdrop_id" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">สำเนาบัตรประชาชน</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <span class="ms-3 py-2" style="text-align: start;">สำเนาบัตรประชาชน/Code : {{$customer_view->customer_code}}</span>
                                <hr style="color:#a5a5a5;">
                                    <div class="modal-body">
                                        <form action="/webpanel/customer-detail/upload-id/{{$customer_view->customer_code}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @if (!empty($customer_view->cert_id))
                                        
                                        <img 
                                            src="{{ asset('storage/' . $customer_view->cert_id) }}?v={{ time() }}"
                                            id="previewId"
                                            style="width: 100%; cursor: pointer;"
                                        />
                                    
                                        {{-- {{time()}} --}}
                                        @else
                                        <img src="/profile/image.jpg" width="100%" id="previewId">
                                        @endif
                                    
                                        <input type="file" id="imageId" class="form-control" name="cert_id" style="margin-top: 10px;" accept="image/png, image/jpg, image/jpeg"/>
                                        {{-- <hr class="py-2 mt-2"> --}}
                                        <div class="modal-footer mt-4">

                                            <a href="{{ asset('storage/'.$customer_view->cert_id) }}"
                                                download
                                                class="btn btn-danger">
                                                 ดาวน์โหลดภาพ
                                             </a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" name="submit_id" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                            {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                        </div>
                                    
                                        </form>
                                    </div>
                            
                                </div>
                            </div>
                        </div>
                    
    
                <form action="/webpanel/customer-detail/update/{{$customer_view->id}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <p class="mt-3 mb-1">เลขใบอนุญาตขายยา/สถานพยาพยาล <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                <input type="text" class="form-control !text-gray-400 mt-2" name="cert_number" value="{{$customer_view->cert_number}}">
                  
                <p class="mt-3 mb-1">วันหมดอายุ <span class="text-red-500 text-xs">*จำเป็นต้องระบุ</span></p>
                @php
                    $year = (int) date('Y');
                    /*   $expireDate = \Carbon\Carbon::now();
                    $checkDate  = \Carbon\Carbon::createFromFormat('d/m/Y H:i', '31/12/'.$year.' 23:59'); */

                @endphp

                <input class="form-control !text-gray-400 mt-2" type="text" id="datepicker" name="cert_expire" value="{{ $customer_view->status === 'ดำเนินการแล้ว' ? '31/12/'.$year : $customer_view->cert_expire; }}">
                {{-- <input id="date" style="margin-top:10px;  color: rgb(171, 171, 171);" type="date"  class="form-control" name="cert_expire" value="{{$customer_view->cert_expire}}"><br> --}}

                

                        
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

                <p class="mt-4 font-bold text-lg">ข้อมูลลูกค้า <span class="text-xs text-red-500">*จำเป็นต้องระบุให้ครบทุกช่อง</span></p>
                <hr class="my-3 mb-2">
                                
                <div>
                    <p class="mt-4 mb-1">ชื่อร้านค้า/สถานพยาบาล</p>
                    <input type="text" class="form-control !text-gray-400 mt-2" name="customer_name" value="{{$customer_view->customer_name}}">

                    @error('customer_name')

                    <div class="alert alert-danger my-2" role="alert">
                        {{$message}}
                    </div>
                    
                    @enderror

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4">
                    <div>
                        <p class="mb-1">CODE <span class="text-xs text-red-500">*จำเป็นต้องระบุ</span></p>
                        <input type="text" class="form-control mt-2 !text-gray-400" id="codeId" name="customer_code" value="{{$customer_view->customer_code}}" >

                        @error('customer_code')
    
                        <div class="alert alert-danger my-2" role="alert">
                            {{$message}}
                        </div>
                        
                        @enderror
    
                    </div>
                    
                    <div>
                        <p class="mb-1">ระดับราคา <span class="text-xs text-red-500">*ลูกค้า 6 เท่ากับ 1</span></p>
                        <select class="form-select mt-2 !text-gray-400" aria-label="Default select example" name="price_level">
                        
                            <option name="price_level" {{$customer_view->price_level == 1 ? 'selected' : '' }} value="1">1</option>
                            <option name="price_level" {{$customer_view->price_level == 2 ? 'selected' : '' }} value="2">2</option>
                            <option name="price_level" {{$customer_view->price_level == 3 ? 'selected' : '' }} value="3">3</option>
                            <option name="price_level" {{$customer_view->price_level == 4 ? 'selected' : '' }} value="4">4</option>
                            <option name="price_level" {{$customer_view->price_level == 5 ? 'selected' : '' }} value="5">5</option>

                        </select>
                    
                    </div>
                </div>
                
                <div>

                    <p class="mt-3 mb-1">สะสมคะแนน</p>
                    <input type="text" class="form-control mt-2 !text-gray-400" id="points" name="points" value="{{$customer_view->points}}" >

                    <p class="mt-3 mb-1">แบบอนุญาตขายยา</p>
                    <select class="form-select mt-2 !text-gray-400" aria-label="Default select example" name="type">

                        <option {{$customer_view->type == '' ? 'selected': ''}} value="">ไม่ระบุ</option>
                        <option {{$customer_view->type == 'ข.ย.1' ? 'selected': ''}} value="ข.ย.1">ข.ย.1</option>
                        <option {{$customer_view->type == 'ข.ย.2' ? 'selected': ''}} value="ข.ย.2">ข.ย.2</option>
                        <option {{$customer_view->type == 'สมพ.2' ? 'selected': ''}} value="สมพ.2">สมพ.2</option>
                        <option {{$customer_view->type == 'คลินิกยา/สถานพยาบาล' ? 'selected': ''}} value="คลินิกยา/สถานพยาบาล">คลินิกยา/สถานพยาบาล</option>
                    
                    </select>
        
                    <p class="mt-3 mb-1">อีเมล</p>
                    <input name="email" type="email" class="form-control mt-2 !text-gray-400" name="email" value="{{$customer_view->email}}">
          
                    <p class="mt-3 mb-1">เบอร์ร้านค้า <span class="text-xs text-red-500">(ตัวอย่าง: 027534702)</span></p>
                    <input type="text" class="form-control mt-2 !text-gray-400" name="phone" value="{{$customer_view->phone}}">
    
                    <p class="mt-3 mb-1">เบอร์มือถือ <span class="text-xs text-red-500">(ตัวอย่าง: 0857534702)</span></p>
                    <input type="text" class="form-control mt-2 !text-gray-400" name="telephone" value="{{$customer_view->telephone}}">
        
                    <p class="mt-3 mb-1">การจัดส่งสินค้า <span class="text-xs text-red-500"> *ไม่ระบุ คือ จัดส่งตามรอบขนส่งทางร้าน</span></p>
                    <select class="form-select mt-2 !text-gray-400" aria-label="Default select example" name="delivery_by">
                        <option {{$customer_view->delivery_by == 'standard' ? 'selected': ''}} value="standard">ไม่ระบุ</option>
                        <option {{$customer_view->delivery_by == 'owner' ? 'selected': ''}} value="owner">ขนส่งเอกชน (พัสดุ)</option>
                    </select>
                
                    <p class="mt-3 mb-1">ต้องการใบกำกับหรือไม่</p>
                    <select class="form-select !text-red-500 !border-gray-300 p-2 rounded-lg mt-2 hover:!border-red-500" aria-label="Default select example" name="status_vat">

                        <option {{$customer_view->status_vat === 0 ? 'selected': ''}} value="0">ไม่รับ</option>
                        <option {{$customer_view->status_vat === 1 ? 'selected': ''}} value="1">รับ</option>

                    </select>

                    <p class="mt-3 mb-1">ที่อยู่จัดส่ง</p>
                    <input type="text" class="form-control mt-2 !text-gray-400" name="address" value="{{$customer_view->address}}">                              
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <p class="mt-3 mb-1">จังหวัด</p>
                        {{-- <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="province"> --}}

                        <select class="form-select mt-2 !text-gray-400" aria-label="Default select example" name="province" id="province">
                            @if(isset($province))
                                @foreach($province as $row)
                
                                    <option value="{{$row->id}}" {{$row->name_th == $customer_view->province ? 'selected' : ''}}>{{$row->name_th}}</option>
                                
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div>
                        <p class="mt-3 mb-1">อำเภอ/เขต</p>
                        <select class="form-select mt-2 !text-gray-400" aria-label="Default select example" name="amphur" id="amphures">
                            
                            @if(!isset($amphur))
                            @foreach($amphur as $row)
                                <option value="{{$row->province_id}}" {{$row->name_th == $customer_view->amphur ? 'selected' : ''}}>{{$row->name_th}}</option>
                            @endforeach

                            @else
                            <option>{{$customer_view->amphur}}</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <p class="mt-3 mb-1">ตำบล/แขวง</p>
                        <select class="form-select mt-2 !text-gray-400" aria-label="Default select example" name="district" id="districts">
                            @if(!isset($district))
                            @foreach($district as $row)
                                <option value="{{$row->amphure_id}}" {{$row->name_th == $customer_view->district ? 'selected' : ''}}>{{$row->name_th}}</option>
                            @endforeach

                            @else
                            <option>{{$customer_view->district}}</option>
                            @endif
                        </select>
                    </div>

                    <div>
                        <p class="mt-3 mb-1">รหัสไปรษณีย์ <span class="text-red-500 text-xs">*กรุณาตรวจสอบ</span></p>
                        <input type="text" class="form-control mt-2 !text-gray-400" id="zipcode" name="zip_code" value="{{$customer_view->zip_code}}">
                    </div>
                </div>

                <div class="mt-3 mb-8" style="width: 100%;">
                    <p class="mt-3 mb-1">ภูมิศาสตร์</p>
                    <input style="margin-top:10px; color:rgb(171, 171, 171);" type="text" class="form-control" id="geography" name="geography" value="{{$customer_view->geography}}">
                </div>

                <div class="mb-3 my-4 ms-2 mr-2">
                    <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 16px; font-weight: 500; color:#545454;">เพิ่มเติม</label></label>
                    <textarea class="form-control" style="color: rgb(171, 171, 171);" id="exampleFormControlTextarea1" rows="3" name="text_add">{{$customer_view->text_area}}</textarea>

                </div>

                <div class="mb-3 my-4 ms-2 mr-2">
                    <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 16px; font-weight: 500; color:#545454;">ข้อความส่งถึงแอดมินผู้ดูแล</label></label>
                    <textarea class="form-control" style="color: rgb(171, 171, 171);" id="exampleFormControlTextarea1" rows="3" name="text_admin">{{$customer_view->text_admin}}</textarea>
                </div>

            </div>
            <!--form login-->
            <div>
                <div class="form-control">
                    <ul class="text-title mr-6" style="text-align: start; margin-top: 10px;">
                        <span style="font-size: 16px; font-weight: 500; color:#545454;">ข้อมูลผู้รับผิดชอบ</span>
                        <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                    </ul>
                    <ul class="text-muted mr-6" style="padding-top: 10px;">

                        <span>แอดมินผู้ดูแล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                        <select class="form-select" style="margin-top:10px;  color: rgb(171, 171, 171);" aria-label="Default select example" name="admin_area">

                            @if(isset($admin_area_list))
                            @foreach($admin_area_list as $row)

                                @if($row->admin_area != '') <!-- ตรวจสอบสิทธิ์แอดมิน admin_area -->
                                    @if($row->rights_area == '0' || $row->role == '1')
                                    {{-- <option {{$row->admin_area == $admin_area_check->admin_area ? 'selected': '' ; }} value="{{$row->admin_area}}">{{$row->admin_area.' '. '('. $row->name. ')'}}</option> --}}
                                        <option {{$row->admin_area == $admin_area_check->admin_area ? 'selected': '' ; }} value="">{{$row->admin_area.' '. '('. $row->name. ')'}} ไม่มีสิทธิ์ดูแลลูกค้า</option>
                                    @else
                                        <option {{$row->admin_area == $admin_area_check->admin_area ? 'selected': '' ; }} value="{{$row->admin_area}}">{{$row->admin_area.' '. '('. $row->name. ')'}}</option>
                                    @endif
                                @endif

                            @endforeach
                            @endif

                            </select><br>

                        <span>พนักงานขาย/เขตการขาย</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                            <select class="form-select" style="margin-top:10px;  color: rgb(171, 171, 171);" aria-label="Default select example" name="sale_area">

                                <option {{$customer_view->sale_area == 'ไม่ระบุ' ? 'selected': ''}} value="ไม่ระบุ"> ไม่ระบุ </option>

                                @if(isset($sale_area))
                                    @foreach($sale_area as $row_sale_area)
                                        <option {{$customer_view->sale_area == $row_sale_area->sale_area ? 'selected': ''}} value="{{$row_sale_area->sale_area}}"> {{$row_sale_area->sale_area .' '. '('. $row_sale_area->sale_name.')'}} </option>
                                    @endforeach
                                @endif

                            </select><br>

                    </ul>
        
                </div>

                <div class="mb-3 my-4">
                    <div class="form-control">
                        <ul class="text-title" style="text-align: start; margin-top: 10px;">
                            <span style="font-size: 16px; font-weight: 500; color:#545454;">ตั้งค่ารหัสผ่านและสถานะบัญชี</span>
                            <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                        </ul>
                        <ul class="text-muted mr-6" style="padding-top: 10px;">

                            <span>สถานะอัปเดตใบอนุญาต</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="status">

                                    <option {{$customer_view->status == 'ลงทะเบียนใหม่' ? 'selected': ''}} value="ลงทะเบียนใหม่">ลงทะเบียนใหม่</option>
                                    <option {{$customer_view->status == 'รอดำเนินการ' ? 'selected': ''}} value="รอดำเนินการ">รอดำเนินการ</option>
                                    <option {{$customer_view->status== 'ต้องดำเนินการ' ? 'selected': ''}} value="ต้องดำเนินการ">ต้องดำเนินการ</option>
                                    <option {{$customer_view->status == 'ดำเนินการแล้ว' ? 'selected': ''}} value="ดำเนินการแล้ว">ดำเนินการแล้ว</option>
                                    <option {{$customer_view->status == 'ปิดบัญชี' ? 'selected': ''}} value="ปิดบัญชี">ปิดบัญชี (แอดมิน SAP ไม่เห็น)</option>
                            

                                </select><br>

                            <span>UPDATE</span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="status_update">

                                    <option {{$customer_view->status_update == 'updated' ? 'selected': ''}} value="updated">UPDATE</option>
                                    <option {{$customer_view->status_update == '' ? 'selected': ''}} value="">NULL</option>
                            

                            </select><br>

                            <span>รหัสผ่านลูกค้า</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                            
                            <input style="margin-top:10px; color: rgb(171, 171, 171);" type="password" class="form-control" name="password" value="{{$customer_view->password}}">
                            <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="password" value="{{$customer_view->password}}" disabled><br>

                        </ul>
            
                    </div>

                    <div class="form-control my-4">
                        <ul class="text-title mr-6" style="text-align: start; margin-top: 10px;">
                            <span style="font-size: 16px; font-weight: 500; color:#545454;">สถานะบัญชีลูกค้า</span>
                            <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                        </ul>
                        <ul class="text-muted mr-6" style="padding-top: 10px;">
                     
                            <span>สถานะบัญชี</span> <span style="font-size: 12px; color:red;">*vmdrug</span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="status_user">

                                    <option {{$customer_view->status_user == '' ? 'selected': ''}} value="">ปกติ</option>
                                    <option {{$customer_view->status_user== 'กำลังติดตาม' ? 'selected': ''}} value="กำลังติดตาม">กำลังติดตาม</option>
                                    <option {{$customer_view->status_user == 'ไม่อนุมัติ, ถูกระงับสมาชิก' ? 'selected': ''}} value="ไม่อนุมัติ, ถูกระงับสมาชิก">ไม่อนุมัติ, ถูกระงับสมาชิก</option>
                                    <option {{$customer_view->status_user == 'ไม่อนุมัติ, ถูกระงับสมาชิก, กำลังติดตาม' ? 'selected': ''}} value="ไม่อนุมัติ, ถูกระงับสมาชิก, กำลังติดตาม">ไม่อนุมัติ, ถูกระงับสมาชิก, กำลังติดตาม</option>
                                    <option {{$customer_view->status_user == 'ไม่อนุมัติ' ? 'selected': ''}} value="ไม่อนุมัติ">ไม่อนุมัติ</option>
                                    <option {{$customer_view->status_user == 'ถูกระงับสมาชิก' ? 'selected': ''}} value="ถูกระงับสมาชิก">ถูกระงับสมาชิก</option>

                            </select><br>

                        </ul>

                        <!-- สถานะเปิดใช้งาน customer_status -->
                        <ul class="text-title mr-6" style="text-align: start; margin-top: 10px;">
                            <span style="font-size: 16px; font-weight: 500; color:#545454;">สถานะเปิดใช้งาน</span>
                            <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                        </ul>
                        <ul class="text-muted mr-6">
               
                            <span>สถานะลูกค้า (Customer Status)</span> <span style="font-size: 12px; color:red;">*vmdrug ปรับตามเหมาะสม</span>
                            <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="customer_status">

                                    <option {{$customer_view->customer_status == 'active' ? 'selected': ''}} value="active">เปิด</option>
                                    <option {{$customer_view->customer_status == 'inactive' ? 'selected': ''}} value="inactive">ปิด</option>

                            </select><br>

                        </ul>
                        <ul class="text-muted mr-6">
                      
                                <span class="block mb-2">ใบอนุญาตขายยาเพิ่มติม (License) <span style="font-size: 12px; color:red;">*ใบ ขย.5 แต่ติ๊กขายส่งหรือใบขายส่ง</span></span>
                                <select class="form-select mt-1" style="color: rgb(171, 171, 171);" aria-label="Default select example" name="add_license">

                                        <option {{$customer_view->add_license == 'ไม่ระบุ' ? 'selected': ''}} value="ไม่ระบุ">ไม่ระบุ</option>
                                        <option {{$customer_view->add_license == 'ระบุขายส่ง' ? 'selected': ''}} value="ระบุขายส่ง">ระบุขายส่ง</option>

                                </select><br>

                            </ul>
            
            
                    </div>

                    <!-- Line OA -->
                    <div class="form-control my-4">
                        <ul class="text-title mr-6" style="text-align: start; margin-top: 10px;">
                            <span style="font-size: 16px; font-weight: 500; color:#545454;">สถานะการส่งข้อมูลผ่าน Line OA</span>
                            <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                        </ul>
                        <!-- sap -->
                        <h4 class="ms-8">SAP</h4>
                        
                        <ul class="text-muted mr-6" style="padding-top: 10px;">
                     
                            <span class="block !text-gray-600 font-bold">เปิดบัญชี SAP</span>
                            <select class="form-select mt-2 !text-gray-400" aria-label="Default select example" name="status_sap">
                                    <option {{$customer_view->status_sap === 0 ? 'selected': ''}} value="0">ยังไม่ดำเนินการ</option>
                                    <option {{$customer_view->status_sap === 1 ? 'selected': ''}} value="1">ดำเนินการแล้ว</option>
                            </select><br>

                            <span class="block !text-gray-600 font-bold">ส่งข้อความ SAP</span>
                            <select class="form-select mt-2 !text-gray-400" aria-label="Default select example" name="sap_send_line">
                                <option {{$customer_view->sap_send_line === 0 ? 'selected': ''}} value="0">ยังไม่ดำเนินการ</option>
                                <option {{$customer_view->sap_send_line === 1 ? 'selected': ''}} value="1">ดำเนินการแล้ว</option>
                            </select><br>

                        </ul>
                        <hr>
                        <!-- web -->
                        <h4 class="ms-8">WEB</h4>
                        
                        <ul class="text-muted mr-6" style="padding-top: 10px;">
                     
                            <span class="block !text-gray-600 font-bold">เปิดบัญชี WEB <span class="text-red-500 font-medium">*จำเป็นต้องระบุ</span></span>
                            <select class="form-select mt-2 !text-gray-400" aria-label="Default select example" name="status_web">
                                    <option {{$customer_view->status_web === 0 ? 'selected': ''}} value="0">ยังไม่ดำเนินการ</option>
                                    <option {{$customer_view->status_web === 1 ? 'selected': ''}} value="1">ดำเนินการแล้ว</option>
                            </select><br>

                            <span class="block !text-gray-600 font-bold">ส่งข้อความ WEB</span>
                            <select class="form-select mt-2 !text-gray-400" aria-label="Default select example" name="web_send_line">
                                <option {{$customer_view->web_send_line === 0 ? 'selected': ''}} value="0">ยังไม่ดำเนินการ</option>
                                <option {{$customer_view->web_send_line === 1 ? 'selected': ''}} value="1">ดำเนินการแล้ว</option>
                            </select><br>

                        </ul>
                    </div>

                    <div class="mb-3 my-4 ms-2 mr-2">
                        <span style="font-size: 16px; font-weight: 500; color:#545454;">ลงทะเบียนโดย</span>
                        <input style="margin-top:10px; color:rgb(171, 171, 171);" type="text" class="form-control" id="" name="" value="{{$customer_view->register_by}}" disabled>
                    </div>

                    <div class="mb-3 my-4 ms-2 mr-2">
                        <span style="font-size: 16px; font-weight: 500; color:#545454;">อัปเดตข้อมูลล่าสุดโดย</span>
                        <input style="margin-top:10px; color:rgb(171, 171, 171);" type="text" class="form-control" id="" name="" value="{{ ($updateBy[$customer_view->update_by] ?? '-') . ' (' . $customer_view?->update_by . ')' }}"
                        disabled>
                    </div>

                    <div class="mb-3 my-4 ms-2 mr-2">
                        <span style="font-size: 16px; font-weight: 500; color:#ff5252;">อัปเดตข้อมูล</span>
                        @if($customer_view->updated_at != '')
                        <span style="margin-top:10px; color:rgb(242, 72, 72); border: solid 1px rgb(255, 89, 89);" type="text" class="form-control" id="" name="">{{$customer_view->updated_at}}</span>
                        @endif
                    </div>
                    <hr class="mr-6 ms-6 mt-4" style="color:#8E8E8E;">

                    <div class="mb-4 my-4">
                     
                            <span style="font-size:18px; font-weight:500; color:#545454">ช่องทางการสั่งสินค้า</span><span style="font-size: 14px; color:red;"> *เลือกช่องทางที่สั่งมากสุด</span>
                            <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="purchase">
                            <option {{ $customer_view->purchase === 1 ? 'selected': '' }} value="1">สั่งซื้อผ่านทางเว็บไซต์</option>
                            <option  {{ $customer_view->purchase === 0 ? 'selected': '' }} value="0">สั่งซื้อผ่านช่องทางอื่น ๆ (เช่น LINE หรือทางโทรศัพท์)</option>
                            </select>
                        
                    </div>

                    <div style="text-align:right;">
                        <button type="submit" id="updateForm" name="submit_update" class="btn my-4" style="border:none; width: 100px; color: white; padding: 10px;">บันทึก</button>
                        <a href="/webpanel/customer/getcsv/{{$admin_area_check->customer_id}}" type="button" id="exportCsv" class="btn my-2" style="border:none; width: 120px; color: rgb(67, 67, 67); padding: 10px;">Export CSV</a>
                    </div>
            
                </div>
            </div>
            </form>
        
            <!-- updated customer; -->
                        @if (session('status') == 'updated_success')
                            <script> 
                                    $('#bg').css('display', 'none');
                                    Swal.fire({
                                        title: "สำเร็จ",
                                        text: "อัปเดตข้อมูลเรียบร้อย",
                                        icon: "success",
                                        // showCancelButton: true,
                                        confirmButtonColor: "#3085d6",
                                        // cancelButtonColor: "#d33",
                                        confirmButtonText: "ตกลง"
                                        }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                            </script>
                        @endif
                
                        @if (session('status') == 'updated_fail')
                            <script> 
                                    $('#bg').css('display', 'none');
                                    Swal.fire({
                                        title: "ล้มเหลว",
                                        text: "เกิดข้อผิดพลาด",
                                        icon: "error",
                                        // showCancelButton: true,
                                        confirmButtonColor: "#3085d6",
                                        // cancelButtonColor: "#d33",
                                        confirmButtonText: "ตกลง"
                                        }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                            </script>
                        @endif
                              
                </div>
    
         <script>
             
                $('#province').change(function(e) {
                e.preventDefault();
                let province_id = $(this).val();
                console.log(province_id);
                
                    $.ajax({
                        url: '/webpanel/customer-create/update-amphure',
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
                        url: '/webpanel/customer-create/update-geography',
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
                        url: '/webpanel/customer-create/update-district',
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
                    url: '/webpanel/customer-create/update-amphure',
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
                        url: '/webpanel/customer-create/update-district',
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
                        url: '/webpanel/customer-create/update-zipcode',
                        type: 'get',
                        data: {amphure_id: amphure_id},
                        success: function(data) {

                            $('#zipcode').val(data);
                            console.log(data);
                        
                        }
                    });
                });

                $('#districts').click(function(e) {
                e.preventDefault();
                let amphure_id = $(this).val();
                console.log(amphure_id);
                
                    $.ajax({
                        url: '/webpanel/customer-create/update-zipcode',
                        type: 'get',
                        data: {amphure_id: amphure_id},
                        success: function(data) {

                            $('#zipcode').val(data);
                            console.log(data);
                        
                        }
                    });
                });

        </script>

        <!-- preview image -->

        <!-- Modal สำหรับแสดงรูปขยาย -->
        <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content bg-dark border-0 position-relative">

                    <button type="button"
                        class="btn btn-danger position-absolute top-0 end-0 m-3 px-3 py-1"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        style="z-index: 10; font-weight: bold;">
                            ✕ ปิด
                    </button>
                        
                    <div class="modal-body p-0 d-flex justify-content-center align-items-center">
                        <img id="expandedImage" class="img-fluid rounded" alt="Expanded Preview">
                    </div>
                </div>
            </div>
        </div>

        <script>

            document.addEventListener('DOMContentLoaded', function() {
                const imageInput = document.getElementById('imageStore');
                const previewImage = document.getElementById('previewStore');
                const expandedImage = document.getElementById('expandedImage');

                // แสดงรูป preview เมื่อเลือกไฟล์ใหม่
                if (imageInput) {
                    imageInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                    });
                }

                // คลิกที่รูป preview เพื่อเปิด modal ขยาย
                if (previewImage) {
                    previewImage.addEventListener('click', function() {
                    expandedImage.src = previewImage.src;
                    const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
                    modal.show();
                    });
                }
                });

             //ตรวจสอบ image size;
             $('#imageStore').bind('change', function() {
                                    const maxSize = 1000000; //byte
                                    const mb = maxSize/maxSize;
                                    let size = this.files[0].size;
                                    if( size > maxSize ) {

                                        Swal.fire({
                                            icon:'warning',
                                            title: 'ภาพใหญ่เกิน',
                                            text: 'ขนาดภาพไม่เกิน 1 MB (ใบอนุญาตขายยา)',
                                            showConfirmButton: true,
                                            confirmButtonText: 'ตกลง'

                                        }).then(function() {
                                            $("#imageStore").val('');
                                            window.location.reload();
                                        });

                                    }

                                });
        </script>

        <!-- Modal สำหรับแสดงรูปขยาย -->
        <div class="modal fade" id="imagePreviewMedical" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content bg-dark border-0 position-relative">

                    <button type="button"
                        class="btn btn-danger position-absolute top-0 end-0 m-3 px-3 py-1"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        style="z-index: 10; font-weight: bold;">
                            ✕ ปิด
                    </button>
                        
                    {{-- <div class="modal-body p-0 text-center"> --}}
                    <div class="modal-body p-0 d-flex justify-content-center align-items-center">
                        <img id="expandedImageMedical" class="img-fluid rounded" alt="Expanded Preview">
                    </div>
                </div>
            </div>
        </div>
     

        <script>

                document.addEventListener('DOMContentLoaded', function() {
                    const imageInputMedical = document.getElementById('imageMedical');
                    const previewImageMedical = document.getElementById('previewMedical');
                    const expandedImageMedical = document.getElementById('expandedImageMedical');

                    // แสดงรูป preview เมื่อเลือกไฟล์ใหม่
                    if (imageInputMedical) {
                        imageInputMedical.addEventListener('change', function(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                            previewImageMedical.src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                        });
                    }

                    // คลิกที่รูป preview เพื่อเปิด modal ขยาย
                    if (previewImageMedical) {
                        previewImageMedical.addEventListener('click', function() {
                        expandedImageMedical.src = previewImageMedical.src;
                        const modal = new bootstrap.Modal(document.getElementById('imagePreviewMedical'));
                        modal.show();
                        });
                    }
                });

                 //ตรวจสอบ image size;
                 $('#imageMedical').bind('change', function() {
                                        const maxSize = 1000000; //byte
                                        const mb = maxSize/maxSize;
                                        let size = this.files[0].size;
                                        if( size > maxSize ) {

                                            Swal.fire({
                                                icon:'warning',
                                                title: 'ภาพใหญ่เกิน',
                                                text: 'ขนาดภาพไม่เกิน 1 MB (ใบอนุญาตขายยา)',
                                                showConfirmButton: true,
                                                confirmButtonText: 'ตกลง'

                                            }).then(function() {
                                                $("#imageMedical").val('');
                                                window.location.reload();
                                            });

                                        }

                                    });
        </script>

          <!-- Modal สำหรับแสดงรูปขยาย -->
          <div class="modal fade" id="imagePreviewCommerce" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content bg-dark border-0 position-relative">

                    <button type="button"
                        class="btn btn-danger position-absolute top-0 end-0 m-3 px-3 py-1"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        style="z-index: 10; font-weight: bold;">
                            ✕ ปิด
                    </button>
                        
                    {{-- <div class="modal-body p-0 text-center"> --}}
                    <div class="modal-body p-0 d-flex justify-content-center align-items-center">
                        <img id="expandedImageCommerce" class="img-fluid rounded" alt="Expanded Preview">
                    </div>
                </div>
            </div>
        </div>

        <script>
                 document.addEventListener('DOMContentLoaded', function() {
                    const imageInputCommerce = document.getElementById('imageCommerce');
                    const previewImageCommerce = document.getElementById('previewCommerce');
                    const expandedImageCommerce = document.getElementById('expandedImageCommerce');

                    // แสดงรูป preview เมื่อเลือกไฟล์ใหม่
                    if (imageInputCommerce) {
                        imageInputCommerce.addEventListener('change', function(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                            previewImageCommerce.src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                        });
                    }

                    // คลิกที่รูป preview เพื่อเปิด modal ขยาย
                    if (previewImageCommerce) {
                        previewImageCommerce.addEventListener('click', function() {
                        expandedImageCommerce.src = previewImageCommerce.src;
                        const modal = new bootstrap.Modal(document.getElementById('imagePreviewCommerce'));
                        modal.show();
                        });
                    }
                });

                //ตรวจสอบ image size;
                $('#imageCommerce').bind('change', function() {
                                        const maxSize = 1000000; //byte
                                        const mb = maxSize/maxSize;
                                        let size = this.files[0].size;
                                        if( size > maxSize ) {

                                            Swal.fire({
                                                icon:'warning',
                                                title: 'ภาพใหญ่เกิน',
                                                text: 'ขนาดภาพไม่เกิน 1 MB (ใบอนุญาตขายยา)',
                                                showConfirmButton: true,
                                                confirmButtonText: 'ตกลง'

                                            }).then(function() {
                                                $("#imageCommerce").val('');
                                                window.location.reload();
                                            });

                                        }

                                    });
        </script>

        <!-- Modal สำหรับแสดงรูปขยาย -->
        <div class="modal fade" id="imagePreviewVat" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content bg-dark border-0 position-relative">

                    <button type="button"
                        class="btn btn-danger position-absolute top-0 end-0 m-3 px-3 py-1"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        style="z-index: 10; font-weight: bold;">
                            ✕ ปิด
                    </button>
                        
                    {{-- <div class="modal-body p-0 text-center"> --}}
                    <div class="modal-body p-0 d-flex justify-content-center align-items-center">
                        <img id="expandedImageVat" class="img-fluid rounded" alt="Expanded Preview">
                    </div>
                </div>
            </div>
        </div>

        <script>
                 document.addEventListener('DOMContentLoaded', function() {
                    const imageInputVat = document.getElementById('imageVat');
                    const previewImageVat = document.getElementById('previewVat');
                    const expandedImageVat = document.getElementById('expandedImageVat');

                    // แสดงรูป preview เมื่อเลือกไฟล์ใหม่
                    if (imageInputVat) {
                        imageInputVat.addEventListener('change', function(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                            previewImageVat.src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                        });
                    }

                    // คลิกที่รูป preview เพื่อเปิด modal ขยาย
                    if (previewImageVat) {
                        previewImageVat.addEventListener('click', function() {
                        expandedImageVat.src = previewImageVat.src;
                        const modal = new bootstrap.Modal(document.getElementById('imagePreviewVat'));
                        modal.show();
                        });
                    }
                });

                //ตรวจสอบ image size;
                $('#imageVat').bind('change', function() {
                                        const maxSize = 1000000; //byte
                                        const mb = maxSize/maxSize;
                                        let size = this.files[0].size;
                                        if( size > maxSize ) {

                                            Swal.fire({
                                                icon:'warning',
                                                title: 'ภาพใหญ่เกิน',
                                                text: 'ขนาดภาพไม่เกิน 1 MB (ใบอนุญาตขายยา)',
                                                showConfirmButton: true,
                                                confirmButtonText: 'ตกลง'

                                            }).then(function() {
                                                $("#imageVat").val('');
                                                window.location.reload();
                                            });

                                        }

                                    });
        </script>

         <!-- Modal สำหรับแสดงรูปขยาย -->
         <div class="modal fade" id="imagePreviewId" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content bg-dark border-0 position-relative">

                    <button type="button"
                        class="btn btn-danger position-absolute top-0 end-0 m-3 px-3 py-1"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        style="z-index: 10; font-weight: bold;">
                            ✕ ปิด
                    </button>
                        
                    {{-- <div class="modal-body p-0 text-center"> --}}
                    <div class="modal-body p-0 d-flex justify-content-center align-items-center">
                        <img id="expandedImageId" class="img-fluid rounded" alt="Expanded Preview">
                    </div>
                </div>
            </div>
        </div>

        <script>

                document.addEventListener('DOMContentLoaded', function() {
                    const imageInputId = document.getElementById('imageId');
                    const previewImageId = document.getElementById('previewId');
                    const expandedImageId = document.getElementById('expandedImageId');

                    // แสดงรูป preview เมื่อเลือกไฟล์ใหม่
                    if (imageInputId) {
                        imageInputId.addEventListener('change', function(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                            previewImageId.src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                        });
                    }

                    // คลิกที่รูป preview เพื่อเปิด modal ขยาย
                    if (previewImageId) {
                        previewImageId.addEventListener('click', function() {
                        expandedImageId.src = previewImageId.src;
                        const modal = new bootstrap.Modal(document.getElementById('imagePreviewId'));
                        modal.show();
                        });
                    }
                });

                //ตรวจสอบ image size;
                $('#imageId').bind('change', function() {
                                        const maxSize = 1000000; //byte
                                        const mb = maxSize/maxSize;
                                        let size = this.files[0].size;
                                        if( size > maxSize ) {

                                            Swal.fire({
                                                icon:'warning',
                                                title: 'ภาพใหญ่เกิน',
                                                text: 'ขนาดภาพไม่เกิน 1 MB (ใบอนุญาตขายยา)',
                                                showConfirmButton: true,
                                                confirmButtonText: 'ตกลง'

                                            }).then(function() {
                                                $("#imageId").val('');
                                                window.location.reload();
                                            });

                                        }

                                    });
        </script>

      

{{-- 
        <!--- php upload ใบประกอบวิชาชีพ--->
        <script>

                $(document).ready(function(){
                    $('#certMedical').click(function(){
                        // e.preventDefault(); ปิดใช้งาน submit ปกติ
                        const now = new Date().getTime();

                        Swal.fire ({
                            html:
                            '<p style="text-align: start;">แก้ไขใบประกอบวิชาชีพ/Code : {{$customer_view->customer_code; }}</p>'
                            +'<hr>'
                            +'<form action="/webpanel/customer-detail/upload-medical/{{$customer_view->customer_code}}" method="post" enctype="multipart/form-data">'
                            +'@csrf'
                            +'@if ((($customer_view->cert_medical)) != '')'
                            +`<img src="{{asset("storage/".$customer_view->cert_medical)}}?v=${now}" id="fileImage" style="width: 100%";/>`
                            +'@else'
                            +'<img src="/profile/image.jpg" width="100%" id="fileImage">'
                            +'@endif'
                            +'<hr>'
                            +'<input type="file" id="image" class="form-control" name="cert_medical" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                            +'<hr>'
                            +'<div style="margin-top: 10px; text-align: end;">'
                            +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ปิด</button>'
                            +'<button type="submit" name="submit_medical" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>'
                            +'</div>'
                            + '</form>',
                            showConfirmButton: false, 

                            // confirmButtonText: 'บันทึก',
                            // showCancelButton: true,

           
                        
                            });
                                    /// preview image swal filre;
                                        let image = document.querySelector('#image');
                                        let fileImage = document.querySelector('#fileImage');

                                        image.onchange = evt => {
                                        const [file] = image.files;
                                        if(file) {
                                        fileImage.src = URL.createObjectURL(file);
                                        }
                                        }
                                        //ตรวจสอบ image size;
                                        $('#image').bind('change', function() {
                                        const maxSize = 1000000; //byte
                                        const mb = maxSize/maxSize;
                                        let size = this.files[0].size;
                                        if( size > maxSize ) {

                                            Swal.fire({
                                                icon:'warning',
                                                title: 'ภาพใหญ่เกิน',
                                                text: 'ขนาดภาพไม่เกิน 1 MB (ใบประกอบวิชาชีพ)',
                                                showConfirmButton: true,
                                                confirmButtonText: 'ตกลง'

                                            }).then(function() {
                                                $("#image").val('');
                                            });

                                        }
                                    });
                                });
                            });
                    //close window reload window;
                    function closeWin() {
                    Swal.close();
                    // window.location.reload();
                    }
        </script> --}}

        <!--- php upload ใบทะเบียนพาณิชย์--->
       {{--  <script>

                $(document).ready(function(){
                    $('#certCommerce').click(function(){
                        // e.preventDefault(); ปิดใช้งาน submit ปกติ
                        const now = new Date().getTime();

                        Swal.fire ({
                            html:
                            '<p style="text-align: start;">แก้ไขใบทะเบียนพาณิชย์/Code : {{$customer_view->customer_code; }}</p>'
                            +'<hr>'
                            +'<form action="/webpanel/customer-detail/upload-commerce/{{$customer_view->customer_code}}" method="post" enctype="multipart/form-data">'
                            +'@csrf'
                            +'@if ((($customer_view->cert_commerce)) != '')'
                            +`<img src="{{asset("storage/".$customer_view->cert_commerce)}}?v=${now}" id="fileImage" style="width: 100%";/>`
                            +'@else'
                            +'<img src="/profile/image.jpg" width="100%" id="fileImage">'
                            +'@endif'
                            +'<hr>'
                            +'<input type="file" id="image" class="form-control" name="cert_commerce" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                            +'<hr>'
                            +'<div style="margin-top: 10px; text-align: end;">'
                            +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ปิด</button>'
                            +'<button type="submit" name="submit_commerce" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>'
                            +'</div>'
                            + '</form>',
                            showConfirmButton: false, 

                            // confirmButtonText: 'บันทึก',
                            // showCancelButton: true,
                        
                            });

                                    /// preview image swal filre;
                                        let image = document.querySelector('#image');
                                        let fileImage = document.querySelector('#fileImage');

                                        image.onchange = evt => {
                                        const [file] = image.files;
                                        if(file) {
                                        fileImage.src = URL.createObjectURL(file);
                                        }
                                        }
                                         //ตรวจสอบ image size;
                                        $('#image').bind('change', function() {
                                        const maxSize = 1000000; //byte
                                        const mb = maxSize/maxSize;
                                        let size = this.files[0].size;
                                        if( size > maxSize ) {

                                            Swal.fire({
                                                icon:'warning',
                                                title: 'ภาพใหญ่เกิน',
                                                text: 'ขนาดภาพไม่เกิน 1 MB (ใบทะเบียนพาณิชย์)',
                                                showConfirmButton: true,
                                                confirmButtonText: 'ตกลง'

                                            }).then(function() {
                                                $("#image").val('');
                                            });

                                        }
                                    });
                                });
                            });
                    //close window reload window;
                    function closeWin() {
                    Swal.close();
                    // window.location.reload();
                    }
        </script> --}}

         <!--- php upload ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)--->
        {{--  <script>

                    $(document).ready(function(){
                        $('#certVat').click(function(){
                            // e.preventDefault(); ปิดใช้งาน submit ปกติ
                        const now = new Date().getTime();

                        Swal.fire ({
                                html:
                                '<p style="text-align: start;">แก้ไขใบภาษีมูลค่าเพิ่ม (ภ.พ.20)/Code : {{$customer_view->customer_code; }}</p>'
                                +'<hr>'
                                +'<form action="/webpanel/customer-detail/upload-vat/{{$customer_view->customer_code}}" method="post" enctype="multipart/form-data">'
                                +'@csrf'
                                +'@if ((($customer_view->cert_vat)) != '')'
                                +`<img src="{{asset("storage/".$customer_view->cert_vat)}}?v=${now}" id="fileImage" style="width: 100%";/>`
                                +'@else'
                                +'<img src="/profile/image.jpg" width="100%" id="fileImage">'
                                +'@endif'
                                +'<hr>'
                                +'<input type="file" id="image" class="form-control" name="cert_vat" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                                +'<hr>'
                                +'<div style="margin-top: 10px; text-align: end;">'
                                +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ปิด</button>'
                                +'<button type="submit" name="submit_vat" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>'
                                +'</div>'
                                + '</form>',
                                showConfirmButton: false, 

                                // confirmButtonText: 'บันทึก',
                                // showCancelButton: true,
                            
                                });

                                        /// preview image swal filre;
                                            let image = document.querySelector('#image');
                                            let fileImage = document.querySelector('#fileImage');

                                            image.onchange = evt => {
                                            const [file] = image.files;
                                            if(file) {
                                            fileImage.src = URL.createObjectURL(file);
                                            }
                                            }
                                            //ตรวจสอบ image size;
                                            $('#image').bind('change', function() {
                                            const maxSize = 1000000; //byte
                                            const mb = maxSize/maxSize;
                                            let size = this.files[0].size;
                                            if( size > maxSize ) {

                                                Swal.fire({
                                                    icon:'warning',
                                                    title: 'ภาพใหญ่เกิน',
                                                    text: 'ขนาดภาพไม่เกิน 1 MB (ใบภาษีมูลค่าเพิ่ม)',
                                                    showConfirmButton: true,
                                                    confirmButtonText: 'ตกลง'

                                                }).then(function() {
                                                    $("#image").val('');
                                                });

                                            }
                                        });
                                    });
                                });
                        //close window reload window;
                        function closeWin() {
                        Swal.close();
                        // window.location.reload();
                        }
            </script>

 --}}
         <!--- php upload สำเนาบัตรประจำตัวประชาชน--->
        {{--  <script>

                    $(document).ready(function(){
                        $('#certId').click(function(){
                            // e.preventDefault(); ปิดใช้งาน submit ปกติ
                            const now = new Date().getTime();

                            Swal.fire ({
                                html:
                                '<p style="text-align: start;">แก้ไขสำเนาบัตรประจำตัวประชาชน/Code : {{$customer_view->customer_code; }}</p>'
                                +'<hr>'
                                +'<form action="/webpanel/customer-detail/upload-id/{{$customer_view->customer_code}}" method="post" enctype="multipart/form-data">'
                                +'@csrf'
                                +'@if ((($customer_view->cert_id)) != '')'
                                +`<img src="{{asset("storage/".$customer_view->cert_id)}}?v=${now}" id="fileImage" style="width: 100%";/>`
                                +'@else'
                                +'<img src="/profile/image.jpg" width="100%" id="fileImage">'
                                +'@endif'
                                +'<hr>'
                                +'<input type="file" id="image" class="form-control" name="cert_id" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                                +'<hr>'
                                +'<div style="margin-top: 10px; text-align: end;">'
                                +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ปิด</button>'
                                +'<button type="submit" name="submit_id" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>'
                                +'</div>'
                                + '</form>',
                                showConfirmButton: false, 

                                // confirmButtonText: 'บันทึก',
                                // showCancelButton: true,
                            
                                });

                                        /// preview image swal filre;
                                            let image = document.querySelector('#image');
                                            let fileImage = document.querySelector('#fileImage');

                                            image.onchange = evt => {
                                            const [file] = image.files;
                                            if(file) {
                                            fileImage.src = URL.createObjectURL(file);
                                            }
                                            }
                                            //ตรวจสอบ image size;
                                            $('#image').bind('change', function() {
                                            const maxSize = 1000000; //byte
                                            const mb = maxSize/maxSize;
                                            let size = this.files[0].size;
                                            if( size > maxSize ) {

                                                Swal.fire({
                                                    icon:'warning',
                                                    title: 'ภาพใหญ่เกิน',
                                                    text: 'ขนาดภาพไม่เกิน 1 MB (สำเนาบัตรประชาชน)',
                                                    showConfirmButton: true,
                                                    confirmButtonText: 'ตกลง'

                                                }).then(function() {
                                                    $("#image").val('');
                                                });

                                            }
                                        });
                                    });
                                });
                        //close window reload window;
                        function closeWin() {
                        Swal.close();
                        // window.location.reload();
                        }
            </script> --}}

        
        @endif
</div>

@endsection
@push('styles')
<style>
    .contentArea {
        /* padding: 10px; */
        background-color: #FFFFFF;
        border-radius: 2px;
        text-align: left;
    }
    #submitForm {
        background-color: #4355ff;
        color:white;
    }
    #submitForm:hover {
        width: auto;
        height: auto;
        background-color: #0f21cb;
    }
    #updateForm {
        background-color: #4355ff;
        color:white;
    }
    #updateForm:hover {
        width: auto;
        height: auto;
        background-color: #0f21cb;
    }
    #exportCsv {
        background-color: #e7e7e7;
        color:white;
    }
    #exportCsv:hover {
        width: auto;
        height: auto;
        background-color: #b9b9b9;
    }
    #submitUpload {
        background-color: #4355ff;
        color:white;
        width: 90px;
        height: 40px;
    }
    #submitUpload:hover {
        width: 90px;
        height: 40px;
        background-color: #0f21cb;
    }
    #cancelUpload {
        background-color: #ebebeb;
        color:rgb(103, 103, 103);
        width: 80px;
        height: 40px;
    }
    #cancelUpload:hover {
        width: 80px;
        height: 40px;
        color:rgb(103, 103, 103);
        background-color: #cbcbcb;
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
@endpush