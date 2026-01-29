@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/customer" class="!no-underline">ย้อนกลับ</a> | นำเข้าไฟล์ร้านค้า รูปแบบ CSV</h5>
        <hr class="my-3 !text-gray-400 !border">

            <div class="ms-6" style="text-align: left; margin-top: 10px;">
                <span style="color: #e84545;">**นำเข้าไฟล์ข้อมูลลูกค้า (Customer_all) tb: customers</span>
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

            <div class="ms-6 mr-6" style="text-align: left;">

        
                <form method="post" id="import" action="/webpanel/customer/importcsv" enctype="multipart/form-data" style="margin-top: 10px;">
                    @csrf
                    <input type="file"  id="import_csv" name="import_csv" class="form-control text-muted"><br/>
                    <input type="submit" id="importCustomer" name="submit_csv" class="btn btn-primary mb-4" value="นำเข้าไฟล์">
                
                </form>
                {{-- <hr style="color: #8E8E8E;"> --}}

                @if(Session::get('success_import'))
                <div class="py-4">
                    <ul class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success_import') }}</ul>
                </div>
                @endif
            
            </div>
          

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
