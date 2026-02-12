@extends ('layouts.webpanel')
@section('content')
@csrf
        
        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/sale" class="!no-underline">ย้อนกลับ</a> | รายละเอียด</h5>
        <hr class="my-3 !text-gray-400 !border">

        <div class="grid grid-cols-1 mx-4 px-2 text-gray-500">
        
        @if(isset($salearea))
            <form action="/webpanel/sale-detail/update/{{$salearea->id}}" method="post" enctype="multipart/form-data">
                @csrf

                        <div class="text-title mt-2">
                            <p class="text-gray-700 font-bold text-lg mb-1">ข้อมูลพนักงานขาย</p>
                        </div>
                        <hr class="my-3">
   
                            <div>
                                <p class="mt-4 mb-1">ชื่อพนักงานขาย</p>
                                <input type="text" class="form-control mt-2 !text-gray-600" name="sale_name" value="{{$salearea->sale_name}}">

                                <p class="mt-4 mb-1">เขตการขาย <span class="text-red-500 text-xs">*จำเป็นต้องระบุ ตัวอย่าง : S01</span></p>
                                <input type="text" class="form-control mt-2 !text-gray-600" name="sale_area" value="{{$salearea->sale_area}}">

            
                                <p class="mt-4 mb-1">Admin area</p>
                                <input type="text" class="form-control mt-2 !text-gray-600" name="admin_area" value="{{$salearea->admin_area}}" disabled>
                
                                <p class="mt-4 mb-1">สถานะบัญชี</p>
                                <select name="sale_status" class="form-select !text-gray-600" id="">
                                    <option @selected($salearea->sale_status) value="0">ปิด</option>
                                    <option @selected($salearea->sale_status) value="1">เปิด</option>
                                </select>

                                <label for="exampleFormControlTextarea1" class="form-label !text-gray-500 mt-4 font-bold">เพิ่มเติม</label></label>
                                <textarea class="form-control mt-1 !text-gray-600" id="exampleFormControlTextarea1" rows="3" name="text_add"> {{$salearea->text_add}}</textarea><br>

                                <button type="submit" name="submit_update" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 !rounded-lg mb-4">บันทึกข้อมูล</button>
                            

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
