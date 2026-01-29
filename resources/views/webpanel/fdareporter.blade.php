@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6">รายงาน ข.ย.13 (FDAReport)</h5>
        <hr class="my-3 !text-gray-400 !border">

        <div class="ms-6 mr-6 mb-6" style="text-align: left;">

            <form method="get" action="/webpanel/report/updated/fdareporter">
                <div class="mx-4 mt-8 w-full">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                
                        {{-- วันที่เริ่ม --}}
                        <div>
                            <label for="fromcheck" class="block mb-1 text-base font-medium text-gray-600">
                                วันที่เริ่ม
                            </label>
                            <input
                                type="text"
                                id="fromcheck"
                                name="from"
                                value="{{ request('from') == '' ? date('Y-m-d') : request('from') }}"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-500
                                       focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>
                
                        {{-- ถึงวันที่ --}}
                        <div>
                            <label for="tocheck" class="block mb-1 text-base font-medium text-gray-600">
                                ถึงวันที่
                            </label>
                            <input
                                type="text"
                                id="tocheck"
                                name="to"
                                value="{{ request('to') == '' ? date('Y-m-d') : request('to') }}"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-500
                                       focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>
                        {{-- ค้นหาสามัญทางยา --}}
                        <div>
                            <label for="generic" class="block mb-1 text-base font-medium text-gray-600">
                                ค้นหาสามัญทางยา
                            </label>
                            <input
                                type="text"
                                id="generic"
                                name="generic"
                                placeholder="ระบุชื่อสามัญทางยา"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-500
                                       focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>
                
                        {{-- ค้นหาชื่อยา / รหัสสินค้า --}}
                        <div>
                            <label for="product" class="block mb-1 text-base font-medium text-gray-600">
                                ค้นหาชื่อยา / รหัสสินค้า
                            </label>
                            <input
                                type="text"
                                id="product"
                                name="product"
                                placeholder="ระบุชื่อสินค้า | รหัสสินค้า"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-base text-gray-500
                                       focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                         {{-- ปุ่มค้นหา --}}
                         <div class="flex">
                            <button
                                type="submit"
                                class="mt-2 w-full md:w-auto !rounded-md bg-blue-600 px-6 py-2 text-sm font-medium text-white
                                       hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                ค้นหา
                            </button>
                        </div>
                
                
                    </div>
                </div>
            </form>
            <script>
                $( function() {
                    var dateFormat = 'dd/mm/yy',
                        from = $( "#fromcheck" )
                        .datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            numberOfMonths: 1,
                            dateFormat: 'yy-mm-dd',
                        })
                        .on( "change", function() {
                            to.datepicker( "option", "minDate", getDate( this ) );
                        }),
                        to = $( "#tocheck" ).datepicker({
                        defaultDate: "+1w",
                        changeMonth: true,
                        dateFormat: 'yy-mm-dd',
                        numberOfMonths: 1 //จำนวนปฎิืิทิน;
                        })
                        .on( "change", function() {
                        from.datepicker( "option", "maxDate", getDate( this ) );
                        });
                
                    function getDate( element ) {
                        var date;
                        try {
                        date = $.datepicker.parseDate( dateFormat, element.value );
                        } catch( error ) {
                        date = null;
                        }
                
                        return date;
                    }
                });
            </script>

            <div class="ms-6 mr-6" id="protected">
                <hr class="my-3 mt-4" style="color: #8E8E8E; width: 100%;">
                <table class="table table-striped table-bordered mt-4" style="table-layout: auto; width:100%; vertical-align: middle;">
                    <thead>
                        <tr>
                            <th style="color:#838383; text-align: center; vertical-align: middle; font-weight: 500; width: 2%;">#</th>
                            <th style="color:#838383; text-align: center; vertical-align: middle; font-weight: 500; width: 5%;">รหัสร้านค้า</th>
                            <th style="color:#838383; text-align: center; vertical-align: middle; font-weight: 500; width: 15%;">ชื่อร้านค้า</th>
                            <th style="color:#838383; text-align: center; vertical-align: middle; font-weight: 500; width: 5%;">รหัสสินค้า</th>
                            <th style="color:#838383; text-align: center; vertical-align: middle; font-weight: 500; width: 20%;">ชื่อสินค้า</th>
                            <th style="color:#838383; text-align: center; vertical-align: middle; font-weight: 500; width: 10%;">ชื่อสามัญทางยา</th>
                            <th style="color:#838383; text-align: center; vertical-align: middle; font-weight: 500; width: 5%;">จำนวน</th>
                            <th style="color:#838383; text-align: center; vertical-align: middle; font-weight: 500; width: 5%;">หน่วย</th>
                            <th style="color:#838383; text-align: center; vertical-align: middle; font-weight: 500; width: 10%;">วันที่สั่ง</th>
                        </tr>
                    </thead>

                    <tbody class="text-sm">
                        @if($reporter->count() > 0)
                            @php 
                                $start = 1;
                                $prevCustomer = null;
                                $colorIndex = 0;
                                $colors = [
                                    'bg-gray-50',
                                    'bg-green-50',
                                    'bg-blue-50',
                                    'bg-orange-50'
                                ];
                            @endphp
                        
                            @foreach($reporter as $row)
                                @php
                                    $customer_id   = $row->customer_id;
                                    $customer_name = $row->customer_name;
                                    $product_id    = $row->product_id;
                                    $product_name  = $row->product_name;
                                    $generic_name  = $row->generic_name;
                                    $qty           = $row->qty;
                                    $unit          = $row->unit;
                                    $date_purchase = $row->date_purchase;
                        
                                    if ($prevCustomer !== $customer_id) {
                                        $colorIndex++;
                                        $bgColor = $colors[$colorIndex % count($colors)];
                                        $prevCustomer = $customer_id;
                                        $showHeader = true;
                                    } else {
                                        $showHeader = false;
                                    }
                                @endphp
                        
                                {{-- Sub-header ร้านค้า --}}
                                @if($showHeader)
                                    <tr class="{{ $bgColor }} border-t border-gray-400">
                                        <td colspan="9"
                                            class="px-4 py-2 font-medium !text-red-500">
                                            ร้านค้า: {{ $customer_name }} (รหัส: {{ $customer_id }})
                                        </td>
                                    </tr>
                                @endif
                        
                                {{-- แถวข้อมูล --}}
                                <tr class="{{ $bgColor }} hover:bg-opacity-70 transition">
                                    <td class="px-2 py-1 text-center">{{ $start++ }}</td>
                                    <td class="px-2 py-1 text-center">{{ $customer_id }}</td>
                                    <td class="px-2 py-1 text-left">{{ $customer_name }}</td>
                                    <td class="px-2 py-1 text-center">{{ $product_id }}</td>
                                    <td class="px-2 py-1 text-left font-medium">
                                        {{ $product_name }}
                                    </td>
                                    <td class="px-2 py-1 text-left">{{ $generic_name }}</td>
                                    <td class="px-2 py-1 text-center !text-red-500 font-semibold">
                                        {{ $qty }}
                                    </td>
                                    <td class="px-2 py-1 text-center">{{ $unit }}</td>
                                    <td class="px-2 py-1 text-left">{{ $date_purchase }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center py-6 !text-gray-600">
                                    ไม่พบข้อมูล
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="py-2"></div>
            </div>
            
        </div>

    </div>
@endsection
