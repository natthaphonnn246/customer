@extends ('layouts.webpanel')
@section('content')
@csrf

    <div class="py-2"></div>
    <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/sale" class="!no-underline">ย้อนกลับ</a> | กรอกข้อมูล</h5>
    <hr class="my-3 !text-gray-400 !border">

           
    <div class="grid grid-cols-1 mx-4 px-2 text-gray-500">
        <p class="text-lg font-bold mb-1">ระบุข้อมูลพนักงานขาย</p>

        <hr class="my-3">
        <form action="/webpanel/sale-create/insert" method="post" enctype="multipart/form-data">
            @csrf

                    <div class="text-gray-500">
                           
                        <p class="mt-3 mb-2">ชื่อพนักงานขาย</p>
                        <input type="text" class="form-control !text-gray-600" name="sale_name">

                        <p class="mt-3 mb-2">เขตการขาย <span class="text-red-500 text-xs">*จำเป็นต้องระบุ ตัวอย่าง : S01</span></p>
                        <input type="text" class="form-control !text-gray-600" name="sale_area" required>
                    
                        <label for="exampleFormControlTextarea1" class="form-label mt-3 mb-1" style="font-size: 18px; font-weight: 500;">เพิ่มเติม</label></label>
                        <textarea class="form-control my-1 !text-gray-600" id="exampleFormControlTextarea1" rows="3" name="text_add"></textarea>

                        <div class="mt-4 text-right">
                            <button type="submit" name="submit_form" class="bg-blue-600 hover:bg-blue-700 text-white !rounded-lg px-3 py-2 mb-4">บันทึกข้อมูล</button>
                        </div>
                            
                    </div>
                    <div>
                        @if(Session::get('success'))
                        <div class="alert alert-success ms-6 mr-6" role="alert">
                            <i class="fa-solid fa-circle-check" style="color:green;"></i>
                            {{Session::get('success')}}
                        </div>
                        @elseif(Session::get('error'))
                        <div class="alert alert-danger ms-6 mr-6" role="alert">
                            <i class="fa-solid fa-circle-xmark" style="color: rgb(172, 27, 27);"></i> 
                            {{Session::get('error')}}
                        </div>
                        @endif
                 
                    </div>
        </form>
    </div>

@endsection
</body>
</html>
