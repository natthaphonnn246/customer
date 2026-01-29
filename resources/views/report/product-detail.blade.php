@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">
        <div class="py-2"></div>
      
        <div class="flex flex-col md:flex-row items-center justify-between mx-4">

            {{-- ฝั่งซ้าย --}}
            <div>
                <h5
                    id="backTo"
                    onclick="goBack()"
                    class="cursor-pointer text-gray-600 hover:text-blue-600 text-center"
                >
                    ย้อนกลับ
                </h5>
            </div>
        
            {{-- ฝั่งขวา --}}
            <div class="flex gap-2 justify-end">
                <a
                    href="/webpanel/report/seller/exportcsv/check/item/{{ request('id') }}?from={{ request('from') ?? '' }}&to={{ request('to') ?? '' }}&category={{ request('category') }}&region={{ request('region') }}"
                    class="w-[150px] rounded-md bg-green-600 px-4 py-2 !no-underline text-center text-sm font-medium text-white
                           hover:bg-green-700"
                >
                    Export CSV
                </a>
        
                <a
                    href="/webpanel/report/seller/exportexcel/check/item/{{ request('id') }}?from={{ request('from') ?? '' }}&to={{ request('to') ?? '' }}&category={{ request('category') }}&region={{ request('region') }}"
                    class="w-[150px] rounded-md bg-blue-600 px-4 py-2 !no-underline text-center text-sm font-medium text-white
                           hover:bg-blue-700"
                >
                    Export Excel
                </a>
            </div>
        
        </div>
        <hr class="my-3 !text-gray-400 !border">

        <script>
        function goBack() {
            window.history.back();
        }
        </script>


        <div class="flex flex-col sm:flex-row gap-2 sm:items-center mt-4">
            <span class="ms-6" style="color: #747474; font-weight:400;"> รหัสสินค้า : {{$product_id ?? 'ไม่ระบุ'}} | {{$product_name->product_name ?? 'ไม่พบข้อมูล'}}
                | หมวดหมู่ : {{$category_name->categories_name ?? 'ไม่มี'}} {{ '('.request('category').')' ?? '' }} | ภูมิศาสตร์ : {{request('region') ?? 'ไม่มี'}}
            </span>
        </div>
       
        <div class="mt-4 mx-4">

                <hr class="my-2" style="color: #8E8E8E; width: 100%;">

                @if(empty($purchase_order))

                    <table class="table table-striped">
                      <thead>
                            <tr>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:5%;">#</td>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: left; padding: 20px 8px 20px; width:80%;">ร้านค้า</td>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:20px;">จำนวน</td>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:20px;">หน่วย</td>
                              </tr>
                        </thead>
                        <tbody>
                            
                        <div class="my-4">
                        <span style="font-weight:500; color:#0fc57f; border:solid; padding: 5px 15px 5px; border-radius:5px;">ร้านค้า : {{$count_customer ?? 'ไม่ระบุ'}}</span>
                        <span style="color:#666666;">สั่งซื้อวันที่ : {{ request('from') ?? 'ไม่ระบุ'}} ถึง {{ request('to') ?? 'ไม่ระบุ'}}</span>
                        </div>
                         
                        <hr class="my-2" style="color: #8E8E8E; width: 100%;">
       
                        @php $total_product = 0; @endphp
                        @foreach($product_list as $row_order)
                        
                        @php
                            $name = $customer_name->where('customer_id', $row_order->customer_id)->first();

                        @endphp
                        
                        @php $qty = $row_order->quantity_by; @endphp
                          <tr>
                            <td scope="col" style="color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:10px;">{{ $start++ }}</td>
                            <td scope="col" style="color:#7d7d7d; text-align: left; padding: 20px 8px 20px; width:65%;">{{$row_order->customer_id}} {{ $name['customer_name'] ?? 'ไม่ระบุชื่อ' }}</td>
                            <td scope="col" style="color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:10px;">{{  $qty }}</td>
                            <td scope="col" style="color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:10px;">{{$row_order->unit}}</td>
                          </tr>
                          
                        @php
                        $total_product +=  $qty;
                        @endphp
       
                        @endforeach

                      <tr>
                        <td colspan="2" style="background-color:rgb(204, 204, 204); color:#161616; text-align: right; font-weight:400; padding: 20px 8px 20px; width:200px;">ทั้งหมด</td>
                        <td colspan="1" style="background-color:rgb(204, 204, 204); color:#161616; text-align: center; font-weight:400; padding: 20px 8px 20px; width:200px;">{{ $total_product }}</td>
                        <td colspan="1" style="background-color:rgb(204, 204, 204); color:#161616; text-align: center; font-weight:400; padding: 20px 8px 20px; width:200px;">{{ $row_order->unit }}</td>

                      </tr>
                        </tbody>
                      </table>
            
                      <div class="py-2"></div>
                @endif
           

    </div>
</div>
@endsection
@push('styles')
    <style>
        #backTo {
            background-color: #4355ff;
            color:white;
            padding:10px;
            width: 100px;
            border-radius: 8px;
        }
        #backTo:hover {
            padding:10px;
            width: 100px;
            background-color: #2a3de4;
            border-radius: 8px;
        }
    </style>
@endpush
