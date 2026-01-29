@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">

            <div class="py-2"></div>
            <h5 class="ms-6 !text-gray-600"><a href="/webpanel/report/product/importproduct" class="!no-underline">ย้อนกลับ</a> | อัปเดตแบบอนุญาตขายยา</h5>
            <hr class="my-3 !text-gray-400 !border">

            <div class="mx-8">
                <span style="color: #e84545;">**นำเข้าไฟล์อัปเดต (แบบอนุญาต from db:vmdrug) tb: Products</span>
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
            <div class="mx-8">

                <form method="post" id="import" action="/webpanel/report/product/update-type/importcsv" enctype="multipart/form-data" style="margin-top: 10px;">
                    @csrf
                    @method('put')
                    <input type="file"  id="import_csv" name="import_cost" class="form-control text-muted"><br/>
                    <input type="submit" id="importCustomer" name="submit_csv" class="btn btn-primary mb-4" value="นำเข้าไฟล์">
                
                </form>
                
                {{-- <hr class="my-3" style="color: #8E8E8E; width: 100%;"> --}}

                @if(Session::get('success_import'))
                <div class="py-4">
                    <ul class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success_import') }}</ul>
                </div>
                @endif
            
            </div>
               
            <hr class="my-3" style="color: #8E8E8E; width: 100%;">

    </div>

@endsection
@push('styles')
    <style>
        #importCustomer {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }
        #importCustomer:hover {
            background-color: #0b59f6;
            color: #ffffff;
        }
    </style>
@endpush
