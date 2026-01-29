@extends ('layouts.webpanel')
@section('content')
   
    <div class="contentArea w-full max-w-full break-words">
        <div class="py-2"></div>
        <h5 class="ms-6 cursor-pointer" id="backTo" onclick="goBack()">ย้อนกลับ</h5>
        <hr class="my-3 !text-gray-400 !border">

        <script>
        function goBack() {
            window.history.back();
        }
        </script>

        <div class="flex flex-col sm:flex-row gap-2 sm:items-center mx-4">
            <p style="color: #747474; font-weight:400;"> รหัสลูกค้า : {{$customer_id ?? 'ไม่ระบุ'}} | {{$customer_name->customer_name ?? 'ไม่พบข้อมูล'}}
                | ขายโดย : {{$customer_name->sale_area ?? 'ไม่มี'}} | แอดมิน : {{$customer_name->admin_area ?? 'ไม่มี'}} | ภูมิศาสตร์ : {{$customer_name->geography ?? 'ไม่มี'}}</p>
        </div>

        <div class="mx-4">


                <hr class="my-2" style="color: #8E8E8E; width: 100%;">

                @if(!empty($purchase_order))

                @foreach($purchase_order as $row_po)

                <?php 
                $sum_order = 0;
                ?>
                    <table class="table table-striped ms-2">
                      <thead>
                            <tr>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: left; padding: 20px 8px 20px; width:65%;">รายการ</td>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">หน่วย</td>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">จำนวน</td>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">ราคา</td>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">ต้นทุน</td>
                                <td scope="col" style="font-weight:500; font-size:16px; color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">รวมเป็นเงิน</td>
                              </tr>
                        </thead>
                        <tbody>
                            
                            <div class="mt-4 mb-4">
                                <span style="font-weight:500; color:#f33e3e; border:solid; padding:5px; border-radius:5px;">{{$row_po->purchase_order ?? 'ไม่ระบุ'}}</span>
                                <span style="color:#666666;">สั่งซื้อวันที่ : {{$row_po->date_purchase ?? 'ไม่ระบุ'}}</span>
                            </div>
                
                         
                            <hr class="my-2" style="color: #8E8E8E; width: 100%;">
       
                            @foreach($order_selling as $row_order)
                            @if($row_po->purchase_order == $row_order->purchase_order)
                            <?php 
                                // $sum_price = $row_order->quantity * number_format($row_order->price,2);
                                $sum_price = $row_order->quantity * $row_order->price;

                                // echo gettype((int)number_format($row_order->price,2));
                            ?>
                    
                          <tr>
                            <td scope="col" style="color:#7d7d7d; text-align: left; padding: 20px 8px 20px; width:65%;">{{$row_order->product_id}} {{$row_order->product_name}}</td>
                            <td scope="col" style="color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">{{$row_order->unit}}</td>
                            <td scope="col" style="color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">{{$row_order->quantity}}</td>
                            <td scope="col" style="color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">{{$row_order->price}}</td>
                            <td scope="col" style="color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">{{$row_order->cost}}</td>
                            <td scope="col" style="color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:100px;">{{ number_format($sum_price,2) }}</td>
                          </tr>
                     
                            <?php 
                            // $sum_order = 0;
                            $sum_order += $sum_price;
                            
                            ?>
                            @endif
                            @endforeach
                          <tr>
                           
                            <td colspan="5" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: right; font-weight:500; padding: 20px 8px 20px; width:200px;">ยอดรวม (บาท)</td>
                            <td colspan="1" style="background-color:rgb(227, 227, 227); color:#7d7d7d; text-align: center; font-weight:500; padding: 20px 8px 20px; width:200px;">{{ number_format($sum_order,2) }}</td>
                            {{-- <td colspan="1" style="color:#7d7d7d; text-align: center; padding: 20px 8px 20px; width:200px;">บาท</td> --}}
    
                          </tr>
                      {{-- @endforeach --}}
             
                      @if ($row_order->unit == 'โค้ด')
                      <tr>
                           
                        <td colspan="6" style="background-color:rgb(253, 253, 253); color:#ff4444; text-align: left; font-weight:400; padding: 20px 8px 20px; width:200px;">*ถ้ามีโค้ดส่วนลด ต้องนำส่วนลดมาลบยอดรวมทุกครั้ง ({{$row_order->product_name}})</td>

                      </tr>
                      @endif
                      @endforeach
                        </tbody>
                      </table>
               
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
