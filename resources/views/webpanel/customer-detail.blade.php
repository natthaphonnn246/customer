<!DOCTYPE html>
<html lang="en">
    @section ('title', 'CMS VMDRUG System')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
<div id="bg">
    @section('content')
    @csrf


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
        #certStore {
            background-color: #e7e7e7;
            color: rgb(161, 161, 161);
            height: 40px;
            padding: 9px;
        }
        #certStore:hover {
            width: auto;
            height: auto;
            height: 40px;
            color: rgb(161, 161, 161);
            background-color: #dadada;
        }
        #certMedical {
            background-color: #e7e7e7;
            color: rgb(161, 161, 161);
            height: 40px;
            padding: 9px;
        }
        #certMedical:hover {
            width: auto;
            height: auto;
            height: 40px;
            color: rgb(161, 161, 161);
            background-color: #dadada;
        }
        #certCommerce {
            background-color: #e7e7e7;
            color: rgb(161, 161, 161);
            height: 40px;
            padding: 9px;
        }
        #certCommerce:hover {
            width: auto;
            height: auto;
            height: 40px;
            color: rgb(161, 161, 161);
            background-color: #dadada;
        }
        #certVat {
            background-color: #e7e7e7;
            color: rgb(161, 161, 161);
            height: 40px;
            padding: 9px;
        }
        #certVat:hover {
            width: auto;
            height: auto;
            height: 40px;
            color: rgb(161, 161, 161);
            background-color: #dadada;
        }
        #certId {
            background-color: #e7e7e7;
            color: rgb(161, 161, 161);
            height: 40px;
            padding: 9px;
        }
        #certId:hover {
            width: auto;
            height: auto;
            height: 40px;
            color: rgb(161, 161, 161);
            background-color: #dadada;
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
        </div>
        <span class="ms-6" style="color: #8E8E8E;"><a href="/webpanel/customer" id="backLink">ลูกค้า (Customer)</a> / แบบฟอร์ม</span>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 3px;">

        @if(isset($customer_view) != '')

        {{-- {{dd($customer_view->customer_id)}} --}}

 
                <div class="row ms-6 mr-6 mt-8">
                    <div class="col-sm-6">
                        <ul class="text-title" style="text-align: start;">
                            <span style="font-size: 16px; font-weight: 500; color:#545454;">ลงทะเบีนนลูกค้าใหม่</span>
                            <hr class="my-3 mb-2" style="color: #8E8E8E; width: 100%;">
                        </ul>
                        <ul class="text-muted" style="padding-top: 10px;">
                           {{--  <li class="mt-2">
                            <span>ใบอนุญาตขายยา/สถานพยาบาล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certStore" >ใบอนุญาตขายยา/สถานพยาบาล</div>
                                @if ($customer_view->cert_store == '')
                                <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
                                @endif
                            <hr class="my-3 mb-2" style="color: #8E8E8E; width: 100%;">
                            </li> --}}


                            <!-- Button trigger modal -->
                            <li class="mt-4">
                                <span>ใบอนุญาตขายยา/สถานพยาบาล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <button type="button" class="btn mt-2" id="certStore" style="width:100%; border:none;" data-bs-toggle="modal" data-bs-target="#staticBackdrop_store">
                                    ใบบอนุญาตขายยา/สถานพยาบาล
                                </button>
                                @if (empty($customer_view->cert_store))
                                <div class="py-2">
                                    <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
                                </div>
                                <hr class="my-2 mb-2" style="color: #8E8E8E; width: 100%;">
                                @endif

                                <div class="modal fade" id="staticBackdrop_store" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">แก้ไขใบอนุญาตขายยา</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <span class="ms-3 py-2" style="text-align: start;">แก้ไขใบอนุญาตขายยา/สถานพยาบาล/Code : {{$customer_view->customer_code}}</span>
                                    <hr style="color:#a5a5a5;">
                                        <div class="modal-body">
                                            <form action="/webpanel/customer-detail/upload-store/{{$customer_view->customer_code}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            {{-- @if ((($customer_view->cert_store)) != '') --}}
                                            @if (!empty($customer_view->cert_store))
                                            
                                                <img src={{asset("storage/".$customer_view->cert_store)}}?v=<?php echo time(); ?>" id="previewStore" style="width: 100%";/>
                                            {{-- {{time()}} --}}
                                            @else
                                            <img src="/profile/image.jpg" width="100%" id="previewStore">
                                            @endif
                                        
                                            <input type="file" id="imageStore" class="form-control" name="cert_store" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>
                                            {{-- <hr class="py-2 mt-2"> --}}
                                            <div class="modal-footer mt-4">

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" name="submit_store" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                                {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                            </div>
                                        
                                            </form>
                                        </div>
                                
                                    </div>
                                </div>
                                </div>
                            </li>

                            <li class="mt-4">
                                <span>ใบประกอบวิชาชีพ</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <button type="button" class="btn mt-2" id="certMedical" style="width:100%; border:none;" data-bs-toggle="modal" data-bs-target="#staticBackdrop_medical">
                                    ใบประกอบวิชาชีพ
                                </button>
                                {{-- @if ($customer_view->cert_medical == '') --}}
                                @if (empty($customer_view->cert_medical))
                                <div class="py-2">
                                    <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
                                </div>
                                <hr class="my-2 mb-2" style="color: #8E8E8E; width: 100%;">
                                @endif

                                <div class="modal fade" id="staticBackdrop_medical" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">ใบประกอบวิชาชีพ</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <span class="ms-3 py-2" style="text-align: start;">ใบประกอบวิชาชีพ/Code : {{$customer_view->customer_code}}</span>
                                    <hr style="color:#a5a5a5;">
                                        <div class="modal-body">
                                            <form action="/webpanel/customer-detail/upload-medical/{{$customer_view->customer_code}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            {{-- @if ((($customer_view->cert_medical)) != '') --}}
                                            @if (!empty($customer_view->cert_medical))
                                            
                                                <img src={{asset("storage/".$customer_view->cert_medical)}}?v=<?php echo time(); ?>" id="previewMedical" style="width: 100%";/>
                                            {{-- {{time()}} --}}
                                            @else
                                            <img src="/profile/image.jpg" width="100%" id="previewMedical">
                                            @endif
                                        
                                            <input type="file" id="imageMedical" class="form-control" name="cert_medical" style="margin-top: 10px;" accept="image/png, image/jpg, image/jpeg"/>
                                            {{-- <hr class="py-2 mt-2"> --}}
                                            <div class="modal-footer mt-4">

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" name="submit_medical" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                                {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                            </div>
                                        
                                            </form>
                                        </div>
                                
                                    </div>
                                </div>
                                </div>
                            </li>


                            <li class="mt-4">
                                <span>ใบทะเบียนพาณิชย์</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <button type="button" class="btn mt-2" id="certCommerce" style="width:100%; border:none;" data-bs-toggle="modal" data-bs-target="#staticBackdrop_commerce">
                                    ใบทะเบียนพาณิชย์
                                </button>
                                {{-- @if ($customer_view->cert_commerce == '') --}}
                                @if (empty($customer_view->cert_commerce))
                                <div class="py-2">
                                    <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
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
                                    <hr style="color:#a5a5a5;">
                                        <div class="modal-body">
                                            <form action="/webpanel/customer-detail/upload-commerce/{{$customer_view->customer_code}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            {{-- @if ((($customer_view->cert_commerce)) != '') --}}
                                            @if (!empty($customer_view->cert_commerce))
                                            
                                                <img src={{asset("storage/".$customer_view->cert_commerce)}}?v=<?php echo time(); ?>" id="previewCommerce" style="width: 100%";/>
                                            {{-- {{time()}} --}}
                                            @else
                                            <img src="/profile/image.jpg" width="100%" id="previewCommerce">
                                            @endif
                                        
                                            <input type="file" id="imageCommerce" class="form-control" name="cert_commerce" style="margin-top: 10px;" accept="image/png, image/jpg, image/jpeg"/>
                                            {{-- <hr class="py-2 mt-2"> --}}
                                            <div class="modal-footer mt-4">

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" name="submit_commerce" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                                {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                            </div>
                                        
                                            </form>
                                        </div>
                                
                                    </div>
                                </div>
                                </div>
                            </li>

                            <li class="mt-4">
                                <span>ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <button type="button" class="btn mt-2" id="certVat" style="width:100%; border:none;" data-bs-toggle="modal" data-bs-target="#staticBackdrop_vat">
                                    ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)
                                </button>
                                {{-- @if ($customer_view->cert_vat == '') --}}
                                @if (empty($customer_view->cert_vat))
                                <div class="py-2">
                                    <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
                                </div>
                                <hr class="my-2 mb-2" style="color: #8E8E8E; width: 100%;">
                                @endif

                                <div class="modal fade" id="staticBackdrop_vat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <span class="ms-3 py-2" style="text-align: start;">ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)/Code : {{$customer_view->customer_code}}</span>
                                    <hr style="color:#a5a5a5;">
                                        <div class="modal-body">
                                            <form action="/webpanel/customer-detail/upload-vat/{{$customer_view->customer_code}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            {{-- @if ((($customer_view->cert_vat)) != '') --}}
                                            @if (!empty($customer_view->cert_vat))
                                            
                                                <img src={{asset("storage/".$customer_view->cert_vat)}}?v=<?php echo time(); ?>" id="previewVat" style="width: 100%";/>
                                            {{-- {{time()}} --}}
                                            @else
                                            <img src="/profile/image.jpg" width="100%" id="previewVat">
                                            @endif
                                        
                                            <input type="file" id="imageVat" class="form-control" name="cert_vat" style="margin-top: 10px;" accept="image/png, image/jpg, image/jpeg"/>
                                            {{-- <hr class="py-2 mt-2"> --}}
                                            <div class="modal-footer mt-4">

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" name="submit_vat" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                                {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                            </div>
                                        
                                            </form>
                                        </div>
                                
                                    </div>
                                </div>
                                </div>
                            </li>

                            <li class="mt-4">
                                <span>สำเนาบัตรประชาชน</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <button type="button" class="btn mt-2" id="certId" style="width:100%; border:none;" data-bs-toggle="modal" data-bs-target="#staticBackdrop_id">
                                    สำเนาบัตรประชาชน
                                </button>
                                {{-- @if ($customer_view->cert_id == '') --}}
                                @if (empty($customer_view->cert_id))
                                <div class="py-2">
                                    <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
                                </div>
                                <hr class="my-2 mb-2" style="color: #8E8E8E; width: 100%;">
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
                                            
                                                <img src={{asset("storage/".$customer_view->cert_id)}}?v=<?php echo time(); ?>" id="previewId" style="width: 100%";/>
                                            {{-- {{time()}} --}}
                                            @else
                                            <img src="/profile/image.jpg" width="100%" id="previewId">
                                            @endif
                                        
                                            <input type="file" id="imageId" class="form-control" name="cert_id" style="margin-top: 10px;" accept="image/png, image/jpg, image/jpeg"/>
                                            {{-- <hr class="py-2 mt-2"> --}}
                                            <div class="modal-footer mt-4">

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" name="submit_id" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>
                                                {{-- <button type="button" class="btn btn-primary">บันทึก</button> --}}

                                            </div>
                                        
                                            </form>
                                        </div>
                                
                                    </div>
                                </div>
                                </div>
                            </li>
                           

                           {{--  <li class="mt-4">
                            <span>ใบประกอบวิชาชีพ</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certMedical" >ใบประกอบวิชาชีพ</div>
                                @if ($customer_view->cert_medical == '')
                                <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
                                @endif
                            <hr class="my-3 mb-2" style="color: #8E8E8E; width: 100%;">
                            </li> --}}
                            {{-- <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_medical" accept="image/png, image/jpg, image/jpeg"><br> --}}
{{-- 
                            <li class="mt-4">
                            <span>ใบทะเบียนพาณิชย์</span>
                                <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certCommerce" >ใบทะเบียนพาณิชย์</div>
                                @if ($customer_view->cert_commerce == '')
                                <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
                                @endif
                            <hr class="my-3 mb-2" style="color: #8E8E8E; width: 100%;">
                            </li> --}}
                            {{-- <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_commerce" accept="image/png, image/jpg, image/jpeg"><br> --}}

                          {{--   <li class="mt-4">
                            <span>ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</span>
                                <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certVat" >ใบทะเบียนภาษีมูลค่าเพิ่ม (ภ.พ.20)</div>
                                @if ($customer_view->cert_vat == '')
                                <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
                                @endif
                            <hr class="my-3 mb-2" style="color: #8E8E8E; width: 100%;">
                            </li> --}}
                            {{-- <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_vat" accept="image/png, image/jpg, image/jpeg"><br> --}}

                          {{--   <li class="mt-4">
                            <span>สำเนาบัตรประชาชน</span>
                                <div class="btn btn-primary my-2" style="width:100%; border:none;" id="certId" >สำเนาบัตรประชาชน</div>
                                @if ($customer_view->cert_id == '')
                                <span style="font-size: 14px; color:red; background-color:#f6ff94; padding:5px; font-weight:500;">**ไม่พบเอกสาร</span>
                                @endif
                            <hr class="my-3 mb-2" style="color: #8E8E8E; width: 100%;">
                            </li> --}}
                            {{-- <input style="margin-top:10px;" type="file" class="form-control text-muted" name="cert_id" accept="image/png, image/jpg, image/jpeg"><br> --}}
                        </ul>
            
            <form action="/webpanel/customer-detail/update/{{$customer_view->id}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <ul class="text-muted" style="padding-top: 10px;">
                            <li class="mt-4">
                                <span>เลขใบอนุญาตขายยา/สถานพยาพยาล</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="cert_number" value="{{$customer_view->cert_number}}"><br>
                            </li>
                            <span>วันหมดอายุ</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                            <input class="form-control" style="margin-top:10px;  color: rgb(171, 171, 171);"  type="text" id="datepicker" name="cert_expire" value="{{$customer_view->cert_expire}}">
                            {{-- <input id="date" style="margin-top:10px;  color: rgb(171, 171, 171);" type="date"  class="form-control" name="cert_expire" value="{{$customer_view->cert_expire}}"><br> --}}
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

                        <ul class="text-title mt-5" style="text-align: start; margin-top: 20px;">
                            <span style="font-size: 16px; font-weight: 500; color:#545454;">ข้อมูลลูกค้า</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุให้ครบทุกช่อง</span>
                            <hr class="my-3 mb-2" style="color: #8E8E8E; width: 100%;">
                        </ul>
                        <div class="row text-muted">
                            <div class="col-sm-12">
                                <ul class="mt-3" style="width: 100%;">
                                    <span>ชื่อร้านค้า/สถานพยาบาล</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="customer_name" value="{{$customer_view->customer_name}}">
                                </ul>

                                @error('customer_name')

                                <div class="alert alert-danger my-2" role="alert">
                                    {{$message}}
                                </div>
                               
                                @enderror

                            </div>
                            <div class="col-sm-6">
                                <ul class="mt-4" style="width: 100%;">
                                    <span>CODE</span><span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" id="codeId" name="customer_code" value="{{$customer_view->customer_code}}" >

                                </ul>

                                @error('customer_code')

                                <div class="alert alert-danger my-2" role="alert">
                                    {{$message}}
                                </div>
                               
                                @enderror

                            </div>
                            
                            <div class="col-sm-6">
                                <ul class="mt-4" style="width: 100%;">
                                    <span>ระดับราคา</span><span style="font-size: 12px; color:red;">*ลูกค้า 6 เท่ากับ 1</span>
                                    <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="price_level">
                                    
                                        <option name="price_level" {{$customer_view->price_level == 1 ? 'selected' : '' }} value="1">1</option>
                                        <option name="price_level" {{$customer_view->price_level == 2 ? 'selected' : '' }} value="2">2</option>
                                        <option name="price_level" {{$customer_view->price_level == 3 ? 'selected' : '' }} value="3">3</option>
                                        <option name="price_level" {{$customer_view->price_level == 4 ? 'selected' : '' }} value="4">4</option>
                                        <option name="price_level" {{$customer_view->price_level == 5 ? 'selected' : '' }} value="5">5</option>

                                    </select>
                                </ul>
                            </div>
                            <div class="col-sm-12">
                                <ul style="width: 100%;">

                                <li class="mt-4">
                                    <span>สะสมคะแนน</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" id="points" name="points" value="{{$customer_view->points}}" >

                                </li>
                                
                                <li class="mt-4">
                                    <span>แบบอนุญาตขายยา</span>
                                    <select class="form-select" style="margin-top:10px;  color: rgb(171, 171, 171);" aria-label="Default select example" name="type">

                                        <option {{$customer_view->type == '' ? 'selected': ''}} value="">ไม่ระบุ</option>
                                        <option {{$customer_view->type == 'ข.ย.1' ? 'selected': ''}} value="ข.ย.1">ข.ย.1</option>
                                        <option {{$customer_view->type == 'ข.ย.2' ? 'selected': ''}} value="ข.ย.2">ข.ย.2</option>
                                        <option {{$customer_view->type == 'ย.บ.1' ? 'selected': ''}} value="ย.บ.1">ย.บ.1</option>
                                        <option {{$customer_view->type == 'คลินิกยา/สถานพยาบาล' ? 'selected': ''}} value="คลินิกยา/สถานพยาบาล">คลินิกยา/สถานพยาบาล</option>
                                    
                                    </select>
                                </li>
                                <li class="mt-4">
                                    <span>อีเมล</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" name="email" type="email" class="form-control" name="email" value="{{$customer_view->email}}">
                                </li>
                                <li class="mt-4">
                                    <span>เบอร์ร้านค้า</span> <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 027534702)</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="phone" value="{{$customer_view->phone}}">
                                </li>
                                <li class="mt-4">
                                    <span>เบอร์มือถือ</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span> <span style="font-size: 12px; color:gery;">(ตัวอย่าง: 0812345678)</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="telephone" value="{{$customer_view->telephone}}">
                                </li>
                                {{-- {{dd($customer_view->delivery_by);}} --}}
                                <li class="mt-4">
                                    <span>การจัดส่งสินค้า</span><span style="font-size: 12px; color:red;"> *ไม่ระบุ คือ จัดส่งตามรอบขนส่งทางร้าน</span>
                                    <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="delivery_by">
                                    <option {{$customer_view->delivery_by == 'standard' ? 'selected': ''}} value="standard">ไม่ระบุ</option>
                                    <option {{$customer_view->delivery_by == 'owner' ? 'selected': ''}} value="owner">ขนส่งเอกชน (พัสดุ)</option>
                                    </select>
                                </li>
                                <li class="mt-4">
                                    <span>ที่อยู่จัดส่ง</span>
                                    <input style="margin-top:10px; color: rgb(171, 171, 171);" type="text" class="form-control" name="address" value="{{$customer_view->address}}">                              
                                </li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="mt-4" style="width: 100%;">
                                    <span>จังหวัด</span>
                                    {{-- <input style="margin-top:10px; color: grey;" type="text" class="form-control" name="province"> --}}
            
                                    <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="province" id="province">
                                        @if(isset($province))
                                        @foreach($province as $row)
                        
                                            <option value="{{$row->id}}" {{$row->name_th == $customer_view->province ? 'selected' : ''}}>{{$row->name_th}}</option>
                                        
                                        @endforeach
                                    @endif
                                    </select>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="mt-4" style="width: 100%;">
                                    <span>อำเภอ/แขวง</span>
                                    <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="amphur" id="amphures">
                                        
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
                            <div class="col-sm-6">
                                <ul class="mt-3" style="width: 100%;">
                                    <span>ตำบล/เขต</span>
                                    <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="district" id="districts">
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
                            <div class="col-sm-6">
                                <ul class="mt-3" style="width: 100%;">
                                    <span>รหัสไปรษณีย์</span> <span style="font-size: 12px; color:red;">*กรุณาตรวจสอบ</span>
                                    <input style="margin-top:10px; color:rgb(171, 171, 171);" type="text" class="form-control" id="zipcode" name="zip_code" value="{{$customer_view->zip_code}}">
                                </ul>
                            </div>

                            <div class="col-sm-12">
                                <ul  class="mt-3 mb-8" style="width: 100%;">
                                    <span>ภูมิศาสตร์</span>
                                    <input style="margin-top:10px; color:rgb(171, 171, 171);" type="text" class="form-control" id="geography" name="geography" value="{{$customer_view->geography}}">
                                </ul>
                            </div>
                              
                        </div>
                    </div>
                    <!--form login-->
                        <div class="col-sm-6">
                            <div class="form-control">
                                <ul class="text-title ms-6 mr-6" style="text-align: start; margin-top: 10px;">
                                    <span style="font-size: 16px; font-weight: 500; color:#545454;">ข้อมูลผู้รับผิดชอบ</span>
                                    <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                                </ul>
                                <ul class="text-muted ms-6 mr-6" style="padding-top: 10px;">

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
                                    <ul class="text-title ms-6" style="text-align: start; margin-top: 10px;">
                                        <span style="font-size: 16px; font-weight: 500; color:#545454;">ตั้งค่ารหัสผ่านและสถานะบัญชี</span>
                                        <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                                    </ul>
                                    <ul class="text-muted ms-6 mr-6" style="padding-top: 10px;">

                                        <span>สถานะบัญชี</span> <span style="font-size: 12px; color:red;">*จำเป็นต้องระบุ</span>
                                        <select class="form-select" style="margin-top:10px; color: rgb(171, 171, 171);" aria-label="Default select example" name="status">
    
                                                <option {{$customer_view->status == 'ลงทะเบียนใหม่' ? 'selected': ''}} value="ลงทะเบียนใหม่">ลงทะเบียนใหม่</option>
                                                <option {{$customer_view->status == 'รอดำเนินการ' ? 'selected': ''}} value="รอดำเนินการ">รอดำเนินการ</option>
                                                <option {{$customer_view->status== 'ต้องดำเนินการ' ? 'selected': ''}} value="ต้องดำเนินการ">ต้องดำเนินการ</option>
                                                <option {{$customer_view->status == 'ดำเนินการแล้ว' ? 'selected': ''}} value="ดำเนินการแล้ว">ดำเนินการแล้ว</option>
                                        
    
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
                                    <ul class="text-title ms-6 mr-6" style="text-align: start; margin-top: 10px;">
                                        <span style="font-size: 16px; font-weight: 500; color:#545454;">สถานะบัญชีลูกค้า</span>
                                        <hr class="my-3" style="color: #8E8E8E; width: 100%;">
                                    </ul>
                                    <ul class="text-muted ms-6 mr-6" style="padding-top: 10px;">
                                    <label></label>
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
                        
                                </div>

                                     
                                <div class="mb-3 my-4 ms-2 mr-2">
                                    <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 16px; font-weight: 500; color:#545454;">เพิ่มเติม</label></label>
                                    <textarea class="form-control" style="color: rgb(171, 171, 171);" id="exampleFormControlTextarea1" rows="3" name="text_add">{{$customer_view->text_area}}</textarea>

                                </div>

                                <div class="mb-3 my-4 ms-2 mr-2">
                                    <label for="exampleFormControlTextarea1" class="form-label" style="font-size: 16px; font-weight: 500; color:#545454;">ข้อความส่งถึงแอดมินผู้ดูแล</label></label>
                                    <textarea class="form-control" style="color: rgb(171, 171, 171);" id="exampleFormControlTextarea1" rows="3" name="text_admin">{{$customer_view->text_admin}}</textarea>
                                </div>

                                <div class="mb-3 my-4 ms-2 mr-2">
                                    <span style="font-size: 16px; font-weight: 500; color:#545454;">ลงทะเบียนโดย</span>
                                    <input style="margin-top:10px; color:rgb(171, 171, 171);" type="text" class="form-control" id="" name="" value="{{$customer_view->register_by}}" disabled>
                                </div>
                                <div class="mb-3 my-4 ms-2 mr-2">
                                    <span style="font-size: 16px; font-weight: 500; color:#ff5252;">อัปเดตข้อมูล</span>
                                    @if($customer_view->updated_at != '')
                                    <span style="margin-top:10px; color:rgb(242, 72, 72); border: solid 1px rgb(255, 89, 89);" type="text" class="form-control" id="" name="">{{$customer_view->updated_at}}</span>
                                    @endif
                                </div>
                                <hr class="mr-6 ms-6 mt-4" style="color:#8E8E8E;">
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
                                <!--- update user information-->
                                  {{--   <script>
                                            $('#updateForm').click(function() {
                                                
                                                $('#bg').css('display', 'none');
                                                let user = $('#form').serialize();
                                           /*      let customer_id = $('#codeId').val();
                                                console.log(customer_id); */

                                                $.ajax({
                                                    // url: '/webpanel/customer-detail/update/{{$customer_view->customer_code}}',
                                                    url: '/webpanel/customer-detail/update/{{$customer_view->id}}',
                                                    type: 'post',
                                                    data: user,
                                                    success: function(data) {

                                                        if (data == 'success') {
                                                            Swal.fire({
                                                            title: 'สำเร็จ',
                                                            text: 'อัปเดตข้อมูลเรียบร้อย',
                                                            icon:'success',
                                                            confirmButtonText: 'ตกลง'

                                                            }).then((data)=>{
                                                                $('#bg').css('display', '');
                                                                // window.location.href = "/webpanel/customer";

                                                            });

                                                        } else {
                                                            Swal.fire({
                                                            title: 'เกิดข้อผิดพลาด',
                                                            text: 'ไม่สามารถอัปเดตข้อมูลได้',
                                                            icon: 'error',
                                                            confirmButtonText: 'ตกลง'

                                                            }).then ((data)=>{  
                                                                if(data.isConfirmed) {
                                                                    window.location.reload();
                                                                }
                                                            })
                                                        }

                                                        console.log(data);
                                                    }
                                                });
                                            });
                                    </script> --}}

                </div>
       
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
{{-- 
{{$customer_view->cert_store;}} --}}
        <!--- php upload ใบอนุญาตขายยา/สถานพยาบาล--->
      {{--   <script>

                $(document).ready(function(){
                    $('#certStore').click(function(){
                        // e.preventDefault(); ปิดใช้งาน submit ปกติ
                        const now = new Date().getTime();

                        Swal.fire ({
                            html:
                            '<p style="text-align: start;">แก้ไขใบอนุญาตขายยา/สถานพยาบาล/Code : {{$customer_view->customer_code; }}</p>'
                            +'<hr>'
                            +'<form action="/webpanel/customer-detail/upload-store/{{$customer_view->customer_code}}" method="post" enctype="multipart/form-data">'
                            +'@csrf'
                            +'@if ((($customer_view->cert_store)) != '')'
                            // +'<img src="/storage/certs/{{$customer_view->cert_store ; }}" id="fileImage" style="width: 100%";/>'
                            // +'<img src="{{asset("storage/".$customer_view->cert_store)}}" id="fileImage" style="width: 100%";/>'
                            //update = "storage/".$customer_view->cert_strore; //test;
                            +`<img src="{{asset("storage/".$customer_view->cert_store)}}?v=${now}" id="fileImage" style="width: 100%";/>`
                            +'@else'
                            +'<img src="/profile/image.jpg" width="100%" id="fileImage">'
                            +'@endif'
                            +'<hr>'
                            +'<input type="file" id="image" class="form-control" name="cert_store" style="margin-top: 10px;"; accept="image/png, image/jpg, image/jpeg"/>'
                            +'<hr>'
                            +'<div style="margin-top: 10px; text-align: end;">'
                            +'<button onclick="closeWin()" type="button" onclick="closeOpenedWindow()" class="btn" id="cancelUpload" data-dismiss="modal">ปิด</button>'
                            +'<button type="submit" name="submit_store" class="btn" id="submitUpload" style="margin: 5px;">บันทึก</button>'
                            +'</div>'
                            +'</form>',
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
                                                text: 'ขนาดภาพไม่เกิน 1 MB (ใบอนุญาตขายยา)',
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

      {{--   <script>

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
                                                text: 'ขนาดภาพไม่เกิน 1 MB (ใบอนุญาตขายยา)',
                                                showConfirmButton: true,
                                                confirmButtonText: 'ตกลง'

                                            }).then(function() {
                                                $("#image").val('');
                                                window.location.reload();
                                            });

                                        }
                                    });
                             
        </script> --}}

        <!-- preview image -->
        <script>
            document.getElementById('imageStore').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.getElementById('previewStore');
                        img.src = e.target.result;
                        img.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
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

     

        <script>
                document.getElementById('imageMedical').addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.getElementById('previewMedical');
                            img.src = e.target.result;
                            img.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
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

        <script>
                document.getElementById('imageCommerce').addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.getElementById('previewCommerce');
                            img.src = e.target.result;
                            img.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
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

        <script>
                document.getElementById('imageVat').addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.getElementById('previewVat');
                            img.src = e.target.result;
                            img.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
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

        <script>
                document.getElementById('imageId').addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.getElementById('previewId');
                            img.src = e.target.result;
                            img.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
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

</body>
</html>
