@extends ('layouts.webpanel')
@section('content')
@csrf

    <div class="py-2"></div>
    <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/sale" class="!no-underline">ย้อนกลับ</a> | กรอกข้อมูล</h5>
    <hr class="my-3 !text-gray-400 !border">

    <div class="grid grid-cols-1 mx-4 px-2 text-gray-500">

            <span class="text-red-500 text-sm">*นำเข้าไฟล์เขตการขาย (Sale_area) tb: saleareas</span>
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
            <div>

        
                <form method="post" id="import" action="/webpanel/sale/importcsv" enctype="multipart/form-data" style="margin-top: 10px;">
                    @csrf
                    <input type="file"  id="import_csv" name="import_csv" class="form-control text-muted"><br/>
                    <input class="mb-4 bg-blue-500 hover:bg-blue-600 !rounded-sm text-white px-3 py-2" type="submit" name="submit_csv" value="นำเข้าไฟล์">
                
                </form>
     
                @if(Session::get('success_import'))
                <div>
                    <ul class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success_import') }}</ul>
                </div>
                @elseif(Session::get('error_import'))
                <div>
                    <ul class="alert alert-danger"><i class="fa-solid fa-circle-xmark" style="color:red;"></i> {{ Session::get('error_import') }}</ul>
                </div>
                @endif
            </div>

    </div>

@endsection
