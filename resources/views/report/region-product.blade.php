@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2"></div>
        <h5 class="mx-4" style="color: #8E8E8E;"><a href="/webpanel/report/product/sales/region/view?category={{ request('category') }}&region={{ request('region') }}&from={{ request('from') }}&to={{ request('to') }}" class="!no-underline">ย้อนกลับ</a> | ขายตามภูมิศาสตร์</h5>
        <hr class="my-3 !text-gray-400 !border">

        <div class="mr-6" style="text-align: right;">

            <a href="/webpanel/report/product/sales/region/exportcsv?product={{ request('product') }}&from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}&category={{ request('category') ?? ''}}&region={{ request('region') ?? ''}}"  id="exportcsv" 
            class="w-[150px] rounded-md bg-green-600 px-4 py-2 !no-underline text-center text-sm font-medium text-white hover:bg-green-700"
            type="submit">Export CSV</a>

            <a href="/webpanel/report/product/sales/region/exportexcel?product={{ request('product') }}&from={{ request('from') ?? ''}}&to={{ request('to') ?? ''}}&category={{ request('category') ?? ''}}&region={{ request('region') ?? ''}}"  id="exportexcel" 
            class="w-[150px] rounded-md bg-blue-600 px-4 py-2 !no-underline text-center text-sm font-medium text-white hover:bg-blue-700"
            type="submit">Export Excel</a>
    
        </div>
        <hr class="my-3" style="color: #8E8E8E; width: 100%;">
  
        <div class="container"  style="width: 95%;">

            <div class="row ms-2">

            </div>

        </div>

            <div class="mx-4 mt-2">

                <div class="flex flex-col sm:flex-row gap-2 sm:items-center mt-2">
                    <span class="mx-2" style="font-size:16px; border-radius:8px; color:#8a8a8a;"><span style="color:rgb(30, 146, 255);">({{ request('product') }}) {{ $product?->product_name ?? '' }} </span>| {{ $category_name?->categories_name ?? '' }} ({{ request('category') }}) | <span style="color:rgb(255, 30, 30);">{{ request('region') }} </span>| {{ request('from') }} ถึง {{ request('to') }}</span>
                </div>

                <hr class="my-4" style="color: #8E8E8E; width: 100%;">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td scope="col" style="color:#838383; text-align: center; font-weight: 500; width:5px;">#</td>
                            <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">CODE</td>
                            <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">ร้านค้า</td>
                            <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">รหัสสินค้า</td>
                            <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">ชื่อสินค้า</td>
                            <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">หน่วย</td>
                            <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">จำนวน</td>
                            <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">ราคา</td>
                            <td scope="col" style="color:#838383; text-align: right; font-weight: 500;">รวมเป็นเงิน</td>
                        </tr>
                        </tr>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @if(!@empty($sales))
                        @php 
                        
                            $start = 1; 
                            $total = 0;
                            $total_qty = 0;
                        
                        @endphp

                        @foreach ($sales as $row_product)
                        <tr>
                            <td scope="row" style="color:#9C9C9C; text-align: center; padding: 20px 8px; width:5%;">{{ $start++ }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px; width:6%;">{{ $row_product->customer_id }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px; width:15%;">{{ $row_product->customer_name }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px; width:7%;">{{ $row_product->product_id }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px; width:26%;">{{ $row_product->product_name }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px; width:9%;">{{ $row_product->unit }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px; width:9%;">{{ $row_product->quantity_by }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px; width:9%;">{{ number_format($row_product->average_price,2) }}</td>
                            <td scope="row" style="color:#9C9C9C; text-align: right; padding: 20px 8px; width:14%;">{{ number_format($row_product->total_sales,2) }}</td>
                        </tr>
                        

                        @php 
                            $total += $row_product->total_sales;
                            $total_qty += $row_product->quantity_by;
                        @endphp
                        @endforeach

                        <tr>
                           
                            <td colspan="6" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">รวมทั้งหมด</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ $total_qty }} ({{ $row_product->unit }})</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;"></td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($total,2) }}</td>
    
                        </tr>
                        @endif
                    </tbody>

                </table>
            </div>
       
            <div class="py-2"></div>

    </div>
@endsection
