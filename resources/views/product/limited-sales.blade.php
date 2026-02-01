@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">

                <div class="py-2"></div>
                <h5 class="!text-gray-600 font-semibold ms-6">สินค้าจำกัดการขาย | ข.ย.13</h5>
                <hr class="my-3 !text-gray-400 !border">

                <div class="ms-6 mr-6 mb-6 overflow-x-auto" style="text-align: left;">
        
                    <div class="flex">
                        <span class="ms-6" style="color: #363636; font-size:20px;">สูตร 
                            <span style="text-decoration:underline;">Dextromethorphan</span>
                            ตำรับยาเม็ด สูตรเดี่ยวและผสม ขายรวมกัน 
                            <span style="color:red;">ไม่เกิน 2,000 เม็ด/ร้านค้า/เดือน</span>
                        </span>
                    </div>
        
                    <table class="table table-striped table-bordered table-hover mt-4" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:2%;">#</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">รหัสสินค้า</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:20%;">ชื่อสินค้า</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:10%;">ชื่อสามัญทางยา</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:10%;">หน่วยสินค้า</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($product_dextro) && count($product_dextro) > 0) 
                            @php 
                                $start = 1;
                            @endphp
                            
                            @foreach($product_dextro as $row)
                                <tr class="tr-hover">
        
                                    <td style="text-align: center; color:#6b6b6b;">{{ $start++ }}</td>
                                    <td style="text-align: center; color:#6b6b6b;">{{ $row->product_id }}</td>
                                    <td style="text-align: left; color:#fa5454;">{{ $row->product_name }}</td>
                                    <td style="text-align: left; color:#6b6b6b;">{{ $row->generic_name }}</td>
                                    <td style="text-align: center; color:#6b6b6b;">{{ $row->unit }}</td>
                                </tr>
                            @endforeach
                            @else
                                <td colspan="5" style="text-align: center; color:#6b6b6b;">ไม่พบสินค้าประเภท ร้านค้า: สมุนไพร</td>
                            @endif
                        </tbody>
                            
                    </table>
                
        
                    <!-- viagra -->
                    <div class="flex">
                        <span class="ms-6" style="color: #363636; font-size:20px;">สูตร 
                            <span style="text-decoration:underline;">Sildenafil, Tadalafil</span>
                            ตำรับยาเม็ด สูตรเดี่ยวและผสม ขายรวมกัน 
                            <span style="color:red;">ไม่เกิน 1,000 เม็ด/ร้านค้า/เดือน</span>
                        </span>
                    </div>
            
                    <table class="table table-striped table-bordered table-hover mt-4" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:2%;">#</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">รหัสสินค้า</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:20%;">ชื่อสินค้า</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:10%;">ชื่อสามัญทางยา</th>
                                <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:10%;">หน่วยสินค้า</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($product_viagra) && count($product_viagra) > 0) 
                            @php 
                                $start = 1;
                            @endphp
                            
                            @foreach($product_viagra as $row_viagra)
                                <tr class="tr-hover">
            
                                    <td style="text-align: center; color:#6b6b6b;">{{ $start++ }}</td>
                                    <td style="text-align: center; color:#6b6b6b;">{{ $row_viagra->product_id }}</td>
                                    <td style="text-align: left; color:#fa5454;">{{ $row_viagra->product_name }}</td>
                                    <td style="text-align: left; color:#6b6b6b;">{{ $row_viagra->generic_name }}</td>
                                    <td style="text-align: center; color:#6b6b6b;">{{ $row_viagra->unit }}</td>
                                </tr>
                            @endforeach
                            @else
                                <td colspan="5" style="text-align: center; color:#6b6b6b;">ไม่พบสินค้าประเภท ร้านค้า: สมุนไพร</td>
                            @endif
                        </tbody>
                    </table>
            </div>
            <div class="py-2"></div>
        </div>
@endsection
