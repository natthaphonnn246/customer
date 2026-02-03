@extends('layouts.webpanel')
@section('content')

<div class="py-2"></div>
<h5 class="!text-gray-600 font-semibold ms-6">จัดกลุ่มไลน์ (Line)</h5>
<hr class="my-3 !text-gray-400 !border">

    <div class="mx-4 py-2">
        <h6 class="!text-gray-700">จัดกลุ่มไลน์ตาม user_id กับ Admin Area</h6>
        <hr class="!text-gray-600 my-4">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            @foreach ($userId as $row)
                <form class="line-form border rounded-md p-4"
                      data-area="{{ $row->admin_area }}">
            
                    <p class="mb-2 font-semibold text-gray-600">
                        Admin Area : {{ $row->admin_area }} ({{ $row->name }})
                    </p>
            
                    <select
                        class="form-select w-full !text-gray-500 mb-3"
                        name="user_id"
                        required
                    >
                        <option value="">-- เลือก user_id --</option>
                        @foreach ($userId as $item)
                            <option value="{{ $item->user_id }}"
                                @selected(($customerMap[$row->admin_area] ?? null) === $item->user_id)
                            >
                                {{ $item->user_id }} ({{ $item->name }})
                            </option>
                        @endforeach
                    </select>
            
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 px-4 py-2 text-white !rounded-md"
                    >
                        บันทึก
                    </button>
                </form>
            @endforeach
        </div>
                            
        </form>
    </div>
    <script>
        document.querySelectorAll('.line-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
        
                const adminArea = this.dataset.area;
                const formData = new FormData(this);
                formData.append('admin_area', adminArea);
        
                console.log(Object.fromEntries(formData));
        
                fetch("{{ route('admin.groupline.update') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(result => {
                    Swal.fire({
                        icon: result.status === 'success' ? 'success' : 'warning',
                        title: result.status === 'success' ? 'สำเร็จ' : 'แจ้งเตือน',
                        text: result.message,
                    });
                });
            });
        });
    </script>
        
@endsection