@extends ('layouts.portal')
@section('content')

        <div class="py-2"></div>
        <h5 class="ms-6 !text-gray-600">ประเภทร้านยา : ข.ย.2/สมุนไพร</h5>
        <hr class="my-3">

<div class="mx-4">

        <div class="ms-6 mr-6 mb-6 overflow-x-auto" id=protected>

            <span class="mt-2 text-base text-red-500 font-medium">
                ประเภทร้านค้า (ข.ย.2)
            </span>

            <table class="table table-striped table-bordered table-hover mt-4" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:2%;">#</th>
                        <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">รหัสร้านค้า</th>
                        <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:15%;">ชื่อร้านค้า</th>
                        <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">แบบอนุญาต</th>
                        <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">แอดมิน</th>
                        <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">เขตการขาย</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($customer_type) && count($customer_type) > 0) 
                    @php 
                        $start = 1;
                    @endphp
                    
                    @foreach($customer_type as $row)
                        <tr class="tr-hover">

                            <td style="text-align: center; color:#6b6b6b;">{{ $start++ }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row->customer_id }}</td>
                            <td style="text-align: left; color:#4aa1ff;">{{ $row->customer_name }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row->type }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row->admin_area }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row->sale_area }}</td>
                        </tr>
                    @endforeach
                    @else
                        <td colspan="5" style="text-align: center; color:#6b6b6b;">ไม่พบประเภทร้านค้า: สมุนไพร</td>
                    @endif
                </tbody>
                    
            </table>
        
        </div>

        <!-- somphor -->
        <div class="ms-6 mr-6 mb-6" style="text-align: left;" id=protected>
        <div style="text-align: left;">
            <span class="mt-2 text-base text-red-500 font-medium">
                ประเภทร้านค้า (สมุนไพร)
            </span>
        </div>

        <table class="table table-striped table-bordered table-hover mt-4" style="width: 100%;">
            <thead>
                <tr>
                    <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:2%;">#</th>
                    <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">รหัสร้านค้า</th>
                    <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:15%;">ชื่อร้านค้า</th>
                    <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">แบบอนุญาต</th>
                    <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">แอดมิน</th>
                    <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">เขตการขาย</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($customer_type_somphor) && count($customer_type_somphor) > 0) 
                @php 
                    $start = 1;
                @endphp
                
                @foreach($customer_type_somphor as $row_somphor)
                    <tr class="tr-hover">

                        <td style="text-align: center; color:#6b6b6b;">{{ $start++ }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row_somphor->customer_id }}</td>
                            <td style="text-align: left; color:#01b24e;">{{ $row_somphor->customer_name }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row_somphor->type }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row_somphor->admin_area }}</td>
                            <td style="text-align: center; color:#6b6b6b;">{{ $row_somphor->sale_area }}</td>
                    </tr>
                @endforeach
                @else
                    <td colspan="5" style="text-align: center; color:#6b6b6b;">ไม่พบประเภทร้านค้า: สมุนไพร</td>
                @endif
            </tbody>
                
        </table>
        <div class="py-2"></div>
    </div>
</div>
       
@endsection
</body>
</html>
