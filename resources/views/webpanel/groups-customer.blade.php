@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">
        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/customer" class="!no-underline">ย้อนกลับ</a> | อัปเดตความรับผิดชอบ</h5>
        <hr class="my-3 !text-gray-400 !border">

        <div class="py-3 my-4 ms-6 mr-6 p-4 mb-4 text-center text-red-800 rounded-lg bg-red-50 dark:bg-white-800 dark:text-red-400 border-1 border-red-600" role="alert">
            <span class="font-medium">คำเตือน !</span> กำหนดลูกค้าให้แอดมิน โดยอ้างอิงจากเขตการขาย
        </div>

        <hr class="my-3" style="color: #8E8E8E; width: 100%;">

            <div class="grid grid-cols-1 md:grid-cols-2">

                <?php
                foreach($row_salearea as $row_sale) {

                ?>
                <div class="mx-4 px-2 mt-3 mb-4">
                    <form action="/webpanel/customer/groups-customer/updatadmin/{{$row_sale->sale_area}}" method="post" enctype="multipart/form-data">
                        @csrf

                                    <div class="form-control mx-auto">
                                        <label for="sale_area" style="color:#838383; margin-top:10px; font-weight:500;">เขตการขาย : {{$row_sale->sale_area}}</label>
                                        <input class="form-control my-2" type="text" name="sale_area" style="color:#838383;" value="{{$row_sale->sale_area}}">
                                        <label for="sale_area" style="color:#838383; font-weight:500;">Admin area</label>
                                        <select class="form-select" style="margin-top:10px; color: grey;" aria-label="Default select example" name="admin_area">                  
                                            <option value="">ไม่ระบุ</option>
                                            @if(!empty($customer_area_list))
                                                 
                                                @foreach($admin_area_list as $row)
                                                
                                                    @if($row->rights_area != '0'  && $row->user_code != '0000') <!-- 0 == ไม่มีสิทธิ์ดูแลลูกค้า -->
                                                    {{-- <option {{($row->admin_area == $row_sale->admin_area) && ($row->admin_area == $customer_area_list->admin_area) ? 'selected' : '' ;}} value="{{$row->admin_area}}">{{$row->admin_area.' '. '('. $row->name. ')'}}</option> --}}
                                                    <option {{($row->admin_area == $row_sale->admin_area) ? 'selected' : '' ;}} value="{{$row->admin_area}}">{{$row->admin_area.' '. '('. $row->name. ')'}}</option>

                                                    @endif

                                                @endforeach
                                            @endif
                                        
                                        </select>

                                        <div style="text-align:right;">
                                            <button type="submit" id="updateForm" name="submit_update" class="btn my-2" style="border:none; width: 80px; color: white; padding: 8px;">บันทึก</button>
                                            <a href="" type="button" id="refreshForm" name="submit_update" class="btn my-3" style="border:none; width: 80px; color: rgb(111, 111, 111); padding: 8px;">ยกเลิก</a>
                                        </div>

                                        @if (!empty($row_sale->updated_at))
                                        <div class="my-3" style="text-align: right;">
                                            <span style="color:#a4a2a2;">อัปเดตข้อมูล : </span> <span style="color:#939393; border:solid 1px #404147; width: 50%; padding: 10px; border-radius: 5px;">{{$row_sale->updated_at}}</span></span></br>
                                        </div>
                                        @endif

                                    </div>

                            <script>
                                    $('#updateForm').click(function() {
                                        
                                        $('#bg').css('display', 'none');
                                        let user = $('#form').serialize();

                                        $.ajax({
                                            url: '/webpanel/customer/groups-customer/updatadmin',
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
                            </script>


                    </form>
                </div>

                <?php  } ?>
            </div>
   
            @if(Session::get('success') == 'อัปเดตข้อมูลเรียบร้อย')
                <script>
                        Swal.fire({
                            title: 'สำเร็จ',
                            text: 'อัปเดตข้อมูลเรียบร้อย',
                            icon:'success',
                            confirmButtonText: 'ตกลง'
                        }).then((data)=>{
                            if(data.isConfirmed) {
                                // window.location.reload();
                            }
                        });
                </script>
            @endif

    </div>

@endsection
@push('styles')
<style>
    #updateForm {
        background-color:  #925ff9;
        color: #ffffff;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
    }
    #updateForm:hover {
        background-color:#7a4dd3;
        color: #ffffff;
    }
    #refreshForm {
        background-color: #e9e9e9;
        color: #ffffff;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
    }
    #refreshForm:hover {
        background-color: #cbcbcb;
        color: #ffffff;
    }
</style>
@endpush
