@extends('layouts.admin')
@section('content')
    <div class="py-2"></div>
    <h5 class="!text-gray-600 font-semibold ms-6">หน้าแรก</h5>
    <hr class="my-3 !text-gray-400 !border">

    <div class="grid grid-cols-1 md:grid-cols-2 max-w-6xl mx-auto py-8 px-4 gap-8 bg-white rounded-2xl">
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
        <div>
            <div
            {{-- <a href="/admin/customer/status/completed" --}}
                class="w-full h-[90px]
                        bg-yellow-500 rounded-lg
                        flex flex-col justify-between
                        px-4 py-3
                        text-white !no-underline
                        {{-- hover:bg-yellow-600 hover:shadow-lg --}}
                        transition"
            >
                <h6 class="text-sm">
                    กำลังดำเนินการ
                </h6>
    
                <span class="text-2xl font-bold text-right leading-none">
                    {{ $total_status_action ?? '0' }}
                </span>
            </div>
            {{-- </a> --}}
        </div>
    
        <!-- ดำเนินการแล้ว -->
        <div
            {{-- <a href="/admin/customer/status/completed" --}}
                class="w-full h-[90px]
                        bg-green-500 rounded-lg
                        flex flex-col justify-between
                        px-4 py-3
                        text-white !no-underline
                        {{-- hover:bg-green-600 hover:shadow-lg --}}
                        transition"
            >
                <h6 class="text-sm">
                    ดำเนินการแล้ว
                </h6>
    
                <span class="text-2xl font-bold text-right leading-none">
                    {{ $total_status_completed ?? '0' }}
                </span>
            {{-- </a> --}}
        </div>
    </div>

@endsection
