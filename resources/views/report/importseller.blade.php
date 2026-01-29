@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">

            <div class="py-2"></div>
            <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/report/seller" class="!no-underline">ย้อนกลับ</a> | รายงานขาย</h5>
            <hr class="my-3 !text-gray-400 !border">

            <div class="ms-6" style="text-align: left; margin-top: 10px;">
                <span style="color: #e84545;">**นำเข้าไฟล์ขายสินค้า (Seller from db:vmdrug) tb: Sellers</span>
            </div>

            @error('import_csv')

            <div class="alert alert-danger my-2" role="alert">
                {{ $message ?? '' }}
            </div>
        
            @enderror

            @if (isset($check_import))

                <div class="alert alert-success my-2" role="alert">
                    {{$check_import}}
                </div>

            @endif

            {{-- {{$check_provinces}} --}}
            <div class="ms-6 mr-6" style="text-align: left;">

        
                <form method="post" id="import" action="/webpanel/report/seller/importcsv" enctype="multipart/form-data" style="margin-top: 10px;">
                    @csrf
                    <input type="file"  id="import_csv" name="import_csv" class="form-control text-muted"><br/>
                    <input type="submit" id="importCustomer" name="submit_csv" class="btn btn-primary mb-4" value="นำเข้าไฟล์">
                
                </form>
                <hr style="color: #8E8E8E;">

                <div class="py-2">
                    <h2 style="color:rgb(61, 210, 108); font-weight: 400; padding:10px; font-size:18px;"><span style="color:#f21e1e;">** สั่งซื้อล่าสุดที่นำเข้าแล้ว :</span> <span style="border: solid 2px; padding: 5px 10px; border-radius:5px; color:red;">{{ $check_po_updated?->last_purchase_date }}</span>
                        <i class="fa-solid fa-arrow-right"></i> วันที่นำเข้าไฟล์ : <span style="color:rgb(61, 210, 108);">{{ $check_po_updated?->created_date }}</span>
                    </h2>

                </div>

                <hr style="color: #8E8E8E;">


 {{--                @if(Session::get('success_import'))
                <div class="py-4">
                    <ul class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success_import') }}</ul>
                </div>
                @endif

                @if(Session::get('import'))
                <div class="py-4">
                    <ul class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('import') }}</ul>
                </div>
                @endif --}}

            
            </div>

            <div class="ms-6 mt-2">
                <h2 style="color: rgb(26, 26, 26); font-weight: 400; padding:10px; font-size:18px;">สถานะการนำเข้าข้อมูล</h2>
            </div>
          
        <div class="ms-4" style="width:95%;">
            
           {{--      @if(session('import'))
                    <div class="alert alert-success">{{ session('import') }}</div>
                @endif
 --}}
   
                @if($importStatus?->id)
                <div id="import-status">
                    <div class="alert alert-secondary" id="import-status">
                        {{ 'กำลังประมวลผล' }}
                    </div> 
                </div>  
                @endif

            
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td scope="row" style="color:#9C9C9C; text-align: left;  padding:20px; width: 20%;">วันที่</td>
                            <td scope="row" style="color:#9C9C9C; text-align: center;  padding:20px; width: 20%;">สถานะ</td>
                            <td scope="row" style="color:#9C9C9C; text-align: center;  padding:20px; width: 20%;">จำนวนแถวที่นำเข้า</td>

                        </tr>
                    </thead>
                    <tbody id="import-table-body">
                        @foreach($imports as $import)
                            <tr style="">
                                <td scope="row" style="color:#9C9C9C; text-align: left;  padding:20px; width: 20%;">{{ $import->created_at->format('Y-m-d H:i') }}</td>
                                <td scope="row" style="color:#9C9C9C; text-align: center;  padding:20px; width: 20%;">
                                    @if($import->status === 'completed')
                                        <span class="inline-block border-2 border-green-600 text-green-600 px-3 py-2 rounded-lg text-base">ดำเนินการแล้ว</span>
                                    @elseif($import->status === 'processing')
                                    <span class="inline-block border-2 border-yellow-500 text-yellow-500 px-3 py-2 rounded-lg text-base">กำลังดำเนินการ</span>
                                    @else
                                    <span class="inline-block border-2 border-red-500 text-red-500 px-3 py-2 rounded-lg text-base">รอดำเนินการ</span>
                                    @endif
                                </td>
                                <td scope="row" style="color:#9C9C9C; text-align: center;  padding:20px; width: 20%;">{{ $import->success_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
            
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', () => {
            const importId = "{{ $importStatus?->id }}";
            setInterval(() => {
                fetch(`/import-status/${importId}`)
                    .then(res => res.text())
                    .then(html => {
                        const tbody = document.getElementById('import-status');
                        if (tbody) {
                            tbody.innerHTML = html;
                            console.log('import');
                        } else {
                            console.error('ไม่เจอ element #import-status');
                        }
                    });
            }, 5000);
        });
    </script>
    
    <script>

        document.addEventListener('DOMContentLoaded', () => {
            setInterval(() => {
                fetch('{{ route("imports.partial") }}')
                    .then(res => res.text())
                    .then(html => {
                        const tbody = document.getElementById('import-table-body');
                        if (tbody) {
                            tbody.innerHTML = html;
                            console.log('pass');
                        } else {
                            console.error('ไม่เจอ element #import-table-body');
                        }
                    });
            }, 5000);
        });
    </script>
@endsection

