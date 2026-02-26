@extends ('layouts.webpanel')
@section('content')

    <div class="py-2"></div>
    <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/product" class="!no-underline">ย้อนกลับ</a> | ดีลพิเศษ</h5>
    <hr class="my-3 !text-gray-400 !border">

    <div class="mx-8">
        <span class="block text-base font-bold text-gray-500">รหัสสินค้า : {{ $item?->product_id}}</span>
        <span class="block text-base font-bold text-gray-500 mt-2">ชื่อสินค้า : {{ $item?->product_name}}</span>
    </div>

    <div class="mx-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <form action="{{ route('webpanel.product.create.deal', ['id'=>$item?->id]) }}" method="POST">
            @csrf
                <div class="border p-4 rounded-lg mt-2">
                    
                    <div class="flex justify-between items-center">
                        <span class="text-blue-500 font-bold text-xl">
                            เพิ่มดีลพิเศษ</span>
                        </span>
                    </div>

                    <!-- จำนวน -->
                    <span class="block text-gray-500 mt-2">
                        จำนวน{{ $item?->unit }} / แพ็ก <span class="text-red-500 text-xs">*ขั้นต่ำ 1</span>
                    </span>
                    <input type="number"
                        name="qty_pack"
                        class="border px-2 py-2 w-full rounded-md mt-1 text-gray-400">

                    <!-- ราคา -->
                    <span class="block text-gray-500 mt-1">
                        ราคาดีลพิเศษ <span class="text-red-500 text-xs">*ขั้นต่ำ 1</span>
                    </span>
                    <input type="number"
                        name="price"
                        class="border px-2 py-2 w-full rounded-md mt-1 text-gray-400">

                    <!-- สต๊อก -->
                    <span class="block text-gray-500 mt-1">สต๊อก</span>
                    <input type="number"
                        name="stock_pack"
                        class="border px-2 py-2 w-full rounded-md mt-1 text-gray-400">

                    <!-- สถานะ -->
                    <span class="block text-gray-500 mt-1">สถานะ</span>
                    <select 
                        name="is_active"
                        class="form-select mt-1 !text-gray-400 w-full"
                    >
                        <option value="0">ปิด</option>
                        <option value="1">เปิด</option>
                    </select>

                    <div class="text-end">
                        <button
                        type="submit"
                        class="text-white text-sm bg-blue-500 hover:bg-blue-600 px-4 py-2 !rounded-md mt-3"
                        >
                            บันทึก
                        </button>
                    </div>

                </div>
        </form>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

            @if($itemDeal)
                @php $index = 1; @endphp
        
                @foreach ($itemDeal as $row)

                <form 
                    action="{{ route('webpanel.product.update.deal', ['id' => $row->id]) }}" 
                    method="POST"
                    class="border p-4 rounded-lg"
                >
                    @csrf
        
                    <!-- ส่ง id ไป -->
                    <input type="hidden" name="id" value="{{ $row->id }}">
        
                    <div class="flex justify-between items-center">
                        <span class="text-red-400 font-bold text-xl">
                            ดีลพิเศษ #{{ $index++ }}
                        </span>
                    </div>
        
                    <!-- จำนวน -->
                    <span class="block text-gray-500 mt-1">
                        จำนวน {{ $row?->unit }} / แพ็ก
                    </span>
                    <input type="number"
                        name="qty_pack"
                        value="{{ $row?->qty_pack }}"
                        class="border px-2 py-2 w-full rounded-md mt-1 text-gray-400">
        
                    <!-- ราคา -->
                    <span class="block text-gray-500 mt-1">
                        ราคาดีลพิเศษ
                    </span>
                    <input type="number"
                        name="price"
                        value="{{ $row?->price }}"
                        class="border px-2 py-2 w-full rounded-md mt-1 text-gray-400">
        
                    <!-- สต๊อก -->
                    <span class="block text-gray-500 mt-2">สต๊อก</span>
                    <input type="number"
                        name="stock_pack"
                        value="{{ $row->stock_pack }}"
                        class="border px-2 py-2 w-full rounded-md mt-1 text-gray-400">
        
                    <!-- สถานะ -->
                    <span class="block text-gray-500 mt-1">สถานะ</span>
                    <select 
                        name="is_active"
                        class="mt-1 w-full border rounded-md px-2 py-2 text-gray-400"
                    >
                        <option value="0" {{ !$row->is_active ? 'selected' : '' }}>ปิด</option>
                        <option value="1" {{ $row->is_active ? 'selected' : '' }}>เปิด</option>
                    </select>
        
                    <div class="text-end mt-3 space-x-2">
                        <!-- บันทึก -->
                        <button
                            type="submit"
                            class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 !rounded-md"
                        >
                            บันทึก
                        </button>
        
                        <!-- ลบ -->
                        <button
                            type="button"
                            class="btn-delete text-white bg-red-400 hover:bg-red-500 px-4 py-2 !rounded-md"
                            data-id="{{ $row->id }}"
                        >
                            ลบ
                        </button>
                    </div>
                </form>
                @endforeach
            @endif
        
        </div>
    </div>
 
    <div class="py-4"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
        
                    if (!confirm('ยืนยันการลบ?')) return;
        
                    fetch(`/webpanel/product/destroy/deal/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
                });
            });
        });
    </script>

    @if(session('success'))
    <script>
        Swal.fire({
            title: 'สำเร็จ',
            text: '{{ session('success') }}',
            icon: 'success'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            title: 'ล้มเหลว',
            text: '{{ session('error') }}',
            icon: 'error'
        });
    </script>
    @endif
@endsection