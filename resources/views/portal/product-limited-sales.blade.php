@extends ('layouts.portal')
@section('content')

        <div class="py-2"></div>
        <h5 class="ms-6 !text-gray-600">สินค้าจำกัดขายต่อเดือน | ข.ย.13</h5>
        <hr class="my-3">

    <div class="contentArea w-full max-w-full break-words py-4  overflow-x-auto">

        <div class="ms-6 mr-6 mb-6" style="text-align: left;" id=protected>

            <div class="flex">
                <span class="ms-6" style="color: #363636; font-size:20px;">สูตร 
                    <span style="text-decoration:underline;">Dextromethorphan</span>
                    ตำรับยาเม็ด สูตรเดี่ยวและผสม ขายรวมกัน 
                    <span style="text-decoration:underline;">ทุกยี่ห้อ</span>
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
        
        </div>

        <!-- viagra -->
        <div class="flex">
            <span class="ms-6" style="color: #363636; font-size:20px;">สูตร 
                <span style="text-decoration:underline;">Sildenafil, Tadalafil</span>
                ตำรับยาเม็ด สูตรเดี่ยวและผสม ขายรวมกัน 
  
                    <span style="text-decoration:underline;">ทุกยี่ห้อ</span>
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
       
@endsection
@push('styles')
<style>
    #protected {
    position: relative;
    }

    #protected::after {
                content: "© cms.vmdrug";
                position: fixed; /* เปลี่ยนจาก absolute → fixed */
                top: 55%;
                left: 60%;
                font-size: 120px;
                color: rgba(170, 170, 170, 0.111);
                pointer-events: none;
                padding-top: 30px;
                /* transform: translate(-50%, -50%) rotate(-45deg); */
                transform: translate(-50%, -50%);
                white-space: nowrap;
                z-index: 9999; /* กันโดนซ่อนโดย content อื่น */
    }
    .disabled-link {
        pointer-events: none;   /* กดไม่ได้ */
        opacity: 0.4;           /* ทำให้ปุ่มจางลง */
        cursor: not-allowed;    /* เมาส์เป็นรูปห้าม */
        text-decoration: none;  /* เอาเส้นใต้ลิงก์ออก (ถ้าอยากให้ดูเหมือนปุ่ม) */
    }
    .modal-body {
    max-height: 60vh;
    overflow-y: auto;
    }
</style>
@endpush
