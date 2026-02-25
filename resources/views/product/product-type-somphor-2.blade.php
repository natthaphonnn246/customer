@extends ('layouts.webpanel')
@section('content')
    
    <div class="contentArea w-full max-w-full break-words">

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6">แบบอนุญาตขายยา | สมุนไพร</h5>
        <hr class="my-3 !text-gray-400 !border">

        <div class="mr-6" style="text-align: right;">

            <a href="/webpanel/report/product-type/khor-yor-2/export/getcsv/somphor-2"  id="exportcsv" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export CSV</a>
            <a href="/webpanel/report/product-type/khor-yor-2/export/getexcel/somphor-2"  id="exportexcel" class="btn" type="submit"  name="" style="width: 150px; padding: 8px;">Export Excel</a>
    
        </div>
        <hr class="my-4" style="color: #8E8E8E; width: 100%;">
        <div class="mx-8">

            <div>
                <form class="w-full mt-2" method="get" action="/webpanel/product-type/somphor-2">
                    <div class="ms-2 my-2">
                        <span>ค้นหาสินค้า : </span>
                    </div>
                    {{-- <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label> --}}
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <!---icon -->
                        </div>
                        <input type="search" id="default-search" name="keyword" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="รหัสสินค้า | ชื่อสินค้า" />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium !rounded-md text-sm px-4 py-2 my-2">ค้นหา</button>
                    
                    </div>
                    <p class="py-2" id="keyword_search"></p>
                    @csrf   
                </form>
            </div>

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

            <div class="mx-2 mb-2" id="protected">
                <hr class="my-3 mt-4" style="color: #8E8E8E; width: 100%;">
            
                <button data-dropdown-toggle="dropdownCsv" class="bg-green-600 hover:bg-green-700 text-white py-2 w-[30%] !rounded-md">
                    เลือกร้านค้า
                </button>
        
                <div id="dropdownCsv" class="z-10 hidden divide-y divide-gray-100 absolute md:w-[20%] w-[25%] text-center">
                    <a href="/webpanel/product-type/khor-yor-2" class="block px-4 py-2 text-base text-white !no-underline bg-gray-800 hover:bg-green-700">ข.ย.2</a>
                    <a href="/webpanel/product-type/somphor-2" class="block px-4 py-2 text-base text-white !no-underline bg-gray-800 hover:bg-green-700">สมุนไพร</a>
                </div>
                
                <div class="relative flex w-full mr-4">
                    
                    <div class="min-h-screen bg-gray-200 flex flex-col w-full">

                        <div class="flex items-center justify-between bg-white border-b p-5 shadow-sm">
                            <h3 class="font-bold text-gray-700">ประเภทร้านค้า (สมุนไพร)</h3>
                        </div>
                
                        <div class="relative block md:hidden w-72 max-w-md mx-auto my-2">
                            <select
                                class="block w-full appearance-none bg-white border border-gray-300
                                       px-3 py-2 pr-10 rounded-md shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-green-500
                                       focus:border-green-500"
                                onchange="if (this.value) window.location.href = this.value"
                            >
                                <option value="">เลือกหมวดหมู่สินค้า</option>
                        
                                <option
                                    value="{{ url('/webpanel/report/product-type/somphor-2') }}"
                                    {{ empty($currentCateId) ? 'selected' : '' }}
                                >
                                    สินค้าทั้งหมด
                                </option>
                        
                                @if(isset($category) && count($category) > 0)
                                    @foreach($category as $row_cat)
                                        <option
                                            value="{{ url('/webpanel/report/product-type/somphor-2/' . $row_cat->categories_id) }}"
                                            {{ $row_cat->categories_id == $currentCateId ? 'selected' : '' }}
                                        >
                                            {{ $row_cat->categories_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        
                            <!-- ลูกศร ▼ -->
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                     <div class="flex flex-1">
                
                        <aside
                                class="hidden md:block
                                        md:w-52
                                        lg:w-64
                                        bg-gray-100 border-r sticky top-0 h-screen overflow-y-auto">
                                        
                            <h4 class="text-2xl font-bold py-4 ms-6">หมวดหมู่สินค้า</h4>
                        
                            <nav class="space-y-2">
                                <a href="{{ url('/webpanel/product-type/somphor-2') }}" 
                                   class="!no-underline block px-4 py-2 rounded-md font-medium hover:bg-green-600 !text-gray-600 hover:!text-white">
                                    สินค้าทั้งหมด
                                </a>
                                <hr style="color:#838383;">
                                @if(isset($category) && count($category) > 0)
                                    @foreach($category as $row_cat)
                                        <a href="{{ url('/webpanel/product-type/somphor-2/' . $row_cat->categories_id) }}" 
                                            class="!no-underline block px-4 py-2 rounded-md font-medium hover:bg-green-600 !text-gray-600 hover:!text-white">
                                            {{ $row_cat->categories_name }}
                                        </a>
                                        <hr style="color:#838383;">
                                    @endforeach
                                @else
                                    <p class="text-gray-400 italic">ยังไม่มีหมวดหมู่สินค้า</p>
                                @endif
                            </nav>
                        </aside>
                        
                        
                
                        <main class="flex-1 p-0 bg-white w-full">
                            <div class="overflow-x-auto w-full">
                                <table class="table table-striped table-bordered table-hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:2%;">#</th>
                                            <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:5%;">รหัสสินค้า</th>
                                            <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:20%;">ชื่อสินค้า</th>
                                            <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:10%;">ชื่อสามัญทางยา</th>
                                            <th style="color:#838383; text-align:center; vertical-align:middle; font-weight:500; width:10%;">ประเภทร้านค้า</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($som_phor_2) && count($som_phor_2) > 0) 
                                        @php 
                                            // $start = 1;
                                        @endphp
                                        
                                        @foreach($som_phor_2 as $row)
                                            <tr class="tr-hover">

                                                <td style="text-align: center; color:#6b6b6b;">{{ $start++ }}</td>
                                                <td style="text-align: center; color:#6b6b6b;">{{ $row->product_id }}</td>
                                                <td style="text-align: left; color:#05b46e;">{{ $row->product_name }}</td>
                                                <td style="text-align: left; color:#6b6b6b;">{{ $row->generic_name }}</td>
                                                <td style="text-align: center; color:#6b6b6b;">{{ $row->som_phor_2 == 1 ? 'สมุนไพร':'' }}</td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <td colspan="5" style="text-align: center; color:#6b6b6b;">ไม่พบสินค้าประเภท ร้านค้า: สมุนไพร</td>
                                        @endif
                                    </tbody>
                                        
                            </table>
                
                            </div>
                        </main>
                
                    </div>
                </div>
                
            
                
                
          
            </div>
            
        </div>

    </div>

    <div class="ms-12 mb-6">
        @if($total_page > 1)
            <nav aria-label="Page navigation example">
            <ul class="pagination py-4">
            <li class="page-item">

            @if ($page == 1)
                <a class="page-link" href="/webpanel/product-type/somphor-2?page=<?=1 ; ?>" aria-label="Previous">
                <span aria-hidden="true">Previous</span>
                </a>
            @else
                <a class="page-link" href="/webpanel/product-type/somphor-2?page=<?= $page-1 ; ?>" aria-label="Previous">
                <span aria-hidden="true">Previous</span>
                </a>
            @endif
            </li>

                @if($total_page > 14)

                    @for ($i= 1; $i <= 3 ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/product-type/somphor-2?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link">...</a></li>
                    @for ($i= $total_page-1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/webpanel/product-type/somphor-2?page={{ $i }}">{{ $i }}</a></li>
                    @endfor

                @else
                    @for ($i= 1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/webpanel/product-type/somphor-2?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                
                @endif

            <li class="page-item">
            
            @if ($page == $total_page)
                <a class="page-link" href="/webpanel/product-type/somphor-2?page={{ $page }}" aria-label="Next">
                <span aria-hidden="true">next</span>
                </a>
            @else
                <a class="page-link" href="/webpanel/product-type/somphor-2?page={{ $page + 1 }}" aria-label="Next">
                <span aria-hidden="true">next</span>
                </a>
            @endif
            </li>
            </ul>
            </nav>

            <hr>
            <div class="py-3">
                <p class="text-sm" style="color:#898989;"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
            </div>

        @else
        <hr>
        <div class="py-3">
            <p class="ms-8 text-sm" style="color:#898989;"> ทั้งหมด {{$total_page}} : จาก {{$page}} - {{$total_page}} </p>
        </div>
        @endif
    </div>
</div>
@endsection
@push('styles')
<style>
    #exportcsv {
        background-color: #dddddd;
        color: #3d3d3d;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
    }
    #exportcsv:hover {
        background-color: #cccccc;
        color: #3c3c3c;
    }
    #exportexcel {
        background-color: #dddddd;
        color: #3d3d3d;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
    }
    #exportexcel:hover {
        background-color: #cccccc;
        color: #3c3c3c;
    }
    .tr-hover:hover {
        background-color: rgb(8, 123, 110);
        color: white;
        border-radius: 5px;
    }
    .table tbody tr:hover {
        background-color: #f0f0f0; /* สีเมื่อ hover */
        cursor: pointer; /* เปลี่ยน cursor */
    }
</style>
@endpush
