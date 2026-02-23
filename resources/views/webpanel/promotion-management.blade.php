@extends('layouts.webpanel')
@section('content')

<div class="py-2"></div>
<h5 class="!text-gray-600 font-semibold ms-6">จัดการโปรโมชั่น (Management)</h5>
<hr class="my-3 !text-gray-400 !border">
        
<div class="grid grid-cols-1 mx-4 px-2 text-gray-500">

    <div class="mt-2">
        <a href="/webpanel/report/product/importproduct" class="bg-green-500 !no-underline text-white px-3 py-2 rounded-md">สินค้าทั้งหมด</a>
    </div>

    <hr class="!text-gray-500 mt-4">

    <p class="font-bold text-base">ตั้งค่าแสดงโปรโมชั่นให้ผู้มีสิทธิ์ <span class="text-red-500 text-xs">* ปิด คือไม่แสดง</span></p>

    <div class="relative mb-2">
        <select
            id=""
            class="block w-full appearance-none bg-white border border-green-400
                   px-4 py-2 pr-10 rounded-lg
                   focus:outline-none focus:ring-1 focus:ring-green-500"
            name="rights"
            >
    
            <option value="0">ปิด</option>
            <option value="1">เปิด</option>
    
        </select>
    
        <!-- icon -->
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    <hr class="!text-gray-500 mb-4">

    <h5 class="font-bold mb-3 !text-gray-500">สถานะเมนูหน้าจัดซื้อ</h5>

    <p class="font-medium text-base mt-2">สินค้าไม่เคลื่อนไหว <span class="text-red-500 text-xs">* ปิด คือไม่แสดง</span></p>

    <div class="relative mb-4">
        <select
            id=""
            class="block w-full appearance-none bg-white border border-green-400
                   px-4 py-2 pr-10 rounded-lg
                   focus:outline-none focus:ring-1 focus:ring-green-500"
            name="slow_move"
            >
    
            <option value="0">ปิด</option>
            <option value="1">เปิด</option>
    
        </select>
    
        <!-- icon -->
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    <p class="font-medium text-base">สินค้าขายดี <span class="text-red-500 text-xs">* ปิด คือไม่แสดง</span></p>

    <div class="relative mb-4">
        <select
            id=""
            class="block w-full appearance-none bg-white border border-green-400
                   px-4 py-2 pr-10 rounded-lg
                   focus:outline-none focus:ring-1 focus:ring-green-500"
            name="best_seller"
            >
    
            <option value="0">ปิด</option>
            <option value="1">เปิด</option>
    
        </select>
    
        <!-- icon -->
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    <p class="font-medium text-base">สินค้ากำไรดี <span class="text-red-500 text-xs">* ปิด คือไม่แสดง</span></p>

    <div class="relative mb-4">
        <select
            id=""
            class="block w-full appearance-none bg-white border border-green-400
                   px-4 py-2 pr-10 rounded-lg
                   focus:outline-none focus:ring-1 focus:ring-green-500"
            name="best_profit"
            >
    
            <option value="0">ปิด</option>
            <option value="1">เปิด</option>
    
        </select>
    
        <!-- icon -->
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>
</div>
@endsection