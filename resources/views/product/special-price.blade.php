@extends ('layouts.webpanel')
@section('content')

    <div class="py-2"></div>
    <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/product" class="!no-underline">ย้อนกลับ</a> | ราคาพิเศษ</h5>
    <hr class="my-3 !text-gray-400 !border">

    <p class="mx-8 text-gray-500 font-bold text-xl">โปรโมชั่นลดราคา</p>
    
    <div class="mx-8">
        <hr class="!text-gray-500">
        <span class="block text-base font-bold text-gray-500">รหัสสินค้า : {{ $item?->product_id}}</span>
        <span class="block text-base font-bold text-gray-500 mt-2">ชื่อสินค้า : {{ $item?->product_name}}</span>
        <span class="block text-base font-bold text-gray-500 mt-2">ต้นทุน : {{ $item?->cost}} / {{ $item?->unit }}</span>
        <hr class="!text-gray-500">
    </div>
    <div class="mx-8 border p-4 rounded-lg w-[600px] mt-4">

        <span class="block text-gray-500">ราคา <span class="text-red-500 text-xs">*ห้ามขาดทุน</span></span>
        <input type="text" class="border px-2 py-2 w-full rounded-md mt-1 placeholder:text-gray-300" placeholder="ต้นทุน {{ $item?->cost }} / {{$item?->unit}}">

        @php
            $toDay = date('d/m/Y'); 
        @endphp
        <label class="text-gray-500 mt-3 mb-1">
            วันที่เริ่ม
            <span class="text-xs text-red-500">
                *กรุณาระบุวันที่ให้ถูกต้อง
            </span>
        </label>
    
        <div class="relative">
            <input
                type="text"
                id="datepickerStart"
                name=""
                value="{{ $toDay }}"
                class="w-full rounded-md border !border-gray-300
                    px-3 py-2 pr-10 text-gray-400
                    focus:outline-none focus:ring-2 focus:ring-blue-500
                    focus:border-blue-500 bg-white"
            >
    
            <!-- calendar icon (right) -->
            <button
                type="button"
                id="openDatepickerStart"
                class="absolute inset-y-0 right-0 flex items-center px-3
                    border-l !border-gray-300
                    text-gray-600 hover:text-gray-600
                    bg-gray-50 border !rounded-r-md">
                <i class="fa-regular fa-calendar"></i>
            </button>
        </div>

        @php
            $toDay = date('d/m/Y'); 
        @endphp
        <label class="text-gray-500 mt-3 mb-1">
            วันที่สิ้นสุด
            <span class="text-xs text-red-500">
                *กรุณาระบุวันที่ให้ถูกต้อง
            </span>
        </label>
    
        <div class="relative">
            <input
                type="text"
                id="datepickerEnd"
                name=""
                value="{{ $toDay }}"
                class="w-full rounded-md border !border-gray-300
                    px-3 py-2 pr-10 text-gray-400
                    focus:outline-none focus:ring-2 focus:ring-blue-500
                    focus:border-blue-500 bg-white"
            >
    
            <!-- calendar icon (right) -->
            <button
                type="button"
                id="openDatepickerEnd"
                class="absolute inset-y-0 right-0 flex items-center px-3
                    border-l !border-gray-300
                    text-gray-600 hover:text-gray-600
                    bg-gray-50 border !rounded-r-md">
                <i class="fa-regular fa-calendar"></i>
            </button>
        </div>

        <span class="block text-gray-500 mt-3">สถานะ</span>

        <select name="" class="mt-1 form-select !text-gray-400">
            <option value="0">ปิด</option>
            <option value="1">เปิด</option>
        </select>
        <div class="mt-3 text-end">
            <button class="bg-blue-500 hover:bg-blue-600 px-4 py-2 !rounded-md text-white">บันทึก</button>
        </div>
    </div>
    <div class="py-4"></div>

    <script>
        $(function () {
            $("#datepickerStart").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "2569:2574"
            });
        
            $("#openDatepickerStart").on("click", function () {
                $("#datepickerStart").focus();
            });
        });

        $(function () {
            $("#datepickerEnd").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "2569:2574"
            });
        
            $("#openDatepickerEnd").on("click", function () {
                $("#datepickerEnd").focus();
            });
        });
    </script>
@endsection