@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6">แบบอนุญาตขายยา</h5>
        <hr class="my-3 !text-gray-400 !border">

        <div class="flex justify-center gap-4 mt-6 mb-6">
            <span class="text-2xl font-bold">เลือกประเภทร้านค้า :</span>
        </div>

        <div class="flex justify-center">
            <a href="/webpanel/report/product-type/khor-yor-2"
            class="mb-8 !no-underline py-4 text-white font-semibold text-xl rounded-lg bg-blue-500 hover:bg-blue-600 w-[40%] transition duration-300 text-center">
            ข.ย.2
            </a>
        </div>

        <div class="flex justify-center">
            <a href="/webpanel/report/product-type/somphor-2"
               class="mb-8 !no-underline py-4 text-white font-semibold text-xl rounded-lg bg-blue-500 hover:bg-blue-600 w-[40%] transition duration-300 text-center">
                สมุนไพร
            </a>
        </div>
        

    </div>
@endsection