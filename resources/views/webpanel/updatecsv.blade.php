@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/customer" class="!no-underline">ย้อนกลับ</a> | อัปเดตข้อมูลร้านค้า</h5>
        <hr class="my-3 !text-gray-400 !border">

            <div class="ms-6" style="text-align: left; margin-top: 10px;">
                <span style="color: #e84545;">**อัปเดตข้อมูลลูกค้า (update customers) tb: customers</span>
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

        
                <form method="post" action="/webpanel/customer/updatecsv/updated" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="import_csv_1" name="import_csv" class="form-control text-muted mt-2">
                    <br/>
                    <input type="submit" id="importCustomer_1"
                           class="btn btn-primary mb-4"
                           value="นำเข้าไฟล์"
                           disabled>
                </form>
                {{-- <hr style="color: #8E8E8E;"> --}}

                @if(Session::get('success_updated'))
                <div class="py-4">
                    <ul class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success_updated') }}</ul>
                </div>
                @endif
                <div class="" style="text-align: left; margin-top: 10px;">
                    <span style="color: #e84545;">**อัปเดตเหตุผลลูกค้าที่ปิดใช้งาน *สถานะบัญชี : ไม่อนุมัติ, ถูกระงับสมาชิก tb: customers</span>
                </div>
                <!--update เหตุผล -->
                <form method="post" action="/webpanel/customer/updatecsv/customer-cause" enctype="multipart/form-data">
                    @csrf
                    <input type="file" id="import_csv_2" name="import_csv" class="form-control text-muted mt-2">
                    <br/>
                    <input type="submit" id="importCustomer_2"
                           class="btn btn-primary mb-4"
                           value="นำเข้าไฟล์"
                           disabled>
                </form>
                <hr style="color: #8E8E8E;">

                @if(Session::get('success_cause'))
                <div class="py-4">
                    <ul class="alert alert-success"><i class="fa-solid fa-circle-check" style="color:green;"></i> {{ Session::get('success_cause') }}</ul>
                </div>
                @endif
            
            </div>
          

    </div>

@push('scripts')
    <script>
        $(function () {
        
            function toggleButton(fileInput, button) {
                if (fileInput.val()) {
                    button.prop('disabled', false);
                } else {
                    button.prop('disabled', true);
                }
            }
        
            $('#import_csv_1').on('change', function () {
                toggleButton($(this), $('#importCustomer_1'));
            });
        
            $('#import_csv_2').on('change', function () {
                toggleButton($(this), $('#importCustomer_2'));
            });
        
        });
    </script>
@endpush

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
