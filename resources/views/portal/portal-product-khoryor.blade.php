@extends ('layouts.portal')
@section('content')

        <div class="py-2"></div>
        <h5 class="ms-6 !text-gray-600">ประเภทร้านยา : ข.ย.2</h5>
        <hr class="my-3">

    <div class="mx-8">

            <div>
                <form class="w-full mt-2" method="get" action="/portal/product-type/khor-yor-2">
                    <span class="ms-2">ค้นหาสินค้า : </span>
                    {{-- <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label> --}}
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <!---icon -->
                        </div>
                        <input type="search" id="default-search" name="keyword" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="รหัสสินค้า | ชื่อสินค้า" />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium !rounded-md text-sm px-4 py-2 my-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ค้นหา</button>
                    
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

            <div class="" id="protected">
                <hr class="my-3 mt-4" style="color: #8E8E8E; width: 100%;">
            
                <button data-dropdown-toggle="dropdownCsv" class="bg-green-600 hover:bg-green-700 text-white py-2 w-[30%] !rounded-md">
                    เลือกร้านค้า
                </button>
        
                <div id="dropdownCsv" class="z-10 hidden divide-y divide-gray-100 absolute md:w-[20%] w-[25%] text-center">
                    <a href="/portal/product-type/khor-yor-2" class="block px-4 py-2 text-base text-white !no-underline bg-gray-800 hover:bg-green-700" id="listCsv">ข.ย.2</a>
                    <a href="/portal/product-type/somphor-2" class="block px-4 py-2 text-base text-white !no-underline bg-gray-800 hover:bg-green-700" id="listCsv">สมุนไพร</a>
                </div>

                <div class="relative flex w-full mr-4">
                    <div class="min-h-screen bg-gray-200 flex flex-col w-full">

                    <div class="flex items-center justify-between bg-white border-b p-4 shadow-sm">
                        <h3 class="font-bold text-gray-700">ประเภทร้านค้า (ข.ย.2)  <span class="text-red-500 text-base">*ขายยาบรรจุเสร็จฯ / คลินิกการพยาบาลและผดุงครรภ์ / โรงพยาบาลคลินิกสัตว์และขายยาสัตว์</span></h3>
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
                                value="{{ url('/portal/product-type/khor-yor-2') }}"
                                {{ empty($currentCateId) ? 'selected' : '' }}
                            >
                                สินค้าทั้งหมด
                            </option>
                    
                            @if(isset($category) && count($category) > 0)
                                @foreach($category as $row_cat)
                                    <option
                                        value="{{ url('/portal/product-type/khor-yor-2/' . $row_cat->categories_id) }}"
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

                    <div class="flex h-screen overflow-y-auto">
                
                        {{-- <aside class="w-64 bg-gray-100 p-2 border-r sticky top-0 h-screen-fix overflow-y-auto"> --}}
                        <aside
                                class="hidden md:block
                                        md:w-52
                                        lg:w-64
                                        bg-gray-100 border-r sticky top-0 h-screen overflow-y-auto">

                            <h4 class="text-2xl font-bold py-4 ms-6">หมวดหมู่สินค้า</h4>
                        
                            <nav class="space-y-2">
                                <a href="{{ url('/portal/product-type/khor-yor-2') }}" 
                                   class="block px-4 py-2 rounded-lg font-medium !no-underline !text-gray-600 hover:bg-green-500 hover:!text-white">
                                    สินค้าทั้งหมด
                                </a>
                                <hr style="color:#838383;">
                                @if(isset($category) && count($category) > 0)
                                    @foreach($category as $row_cat)
                                        <a href="{{ url('/portal/product-type/khor-yor-2/' . $row_cat->categories_id) }}" 
                                            class="block px-4 py-2 rounded-lg font-medium !no-underline !text-gray-600 hover:bg-green-500 hover:!text-white">
                                            {{ $row_cat->categories_name }}
                                        </a>
                                        <hr style="color:#838383;">
                                    @endforeach
                                @else
                                    <p class="text-gray-400 italic">ยังไม่มีหมวดหมู่สินค้า</p>
                                @endif
                            </nav>
                        </aside>
                        
                        
                
                        <main class="flex-1 p-2 bg-white w-full overflow-y-auto">
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
                                        @if(isset($khor_yor_2) && count($khor_yor_2) > 0) 
                                        @php 
                                            // $start = 1;
                                        @endphp
                                        
                                        @foreach($khor_yor_2 as $row)
                                            <tr class="tr-hover">

                                                <td style="text-align: center; color:#6b6b6b;">{{ $start++ }}</td>
                                                <td style="text-align: center; color:#6b6b6b;">{{ $row->product_id }}</td>
                                                <td style="text-align: left; color:#05b46e;">{{ $row->product_name }}</td>
                                                <td style="text-align: left; color:#6b6b6b;">{{ $row->generic_name }}</td>
                                                <td style="text-align: center; color:#6b6b6b;">{{ $row->khor_yor_2 == 1 ? 'ข.ย.2':'' }}</td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <td colspan="5" style="text-align: center; color:#6b6b6b;">ไม่พบสินค้าประเภท ร้านค้า: ข.ย.2</td>
                                        @endif
                                    </tbody>
                                        
                            </table>
                
                            </div>
                        </main>
                
                    </div>
                </div>
                
          
            </div>
            
        </div>

    <hr>
    <div class="ms-12 mb-6">
            @if($total_page > 1)
                <nav aria-label="Page navigation example">
                <ul class="pagination py-4">
                <li class="page-item">

                @if ($page == 1)
                    <a class="page-link" href="/portal/product-type/khor-yor-2?page=<?=1 ; ?>" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @else
                    <a class="page-link" href="/portal/product-type/khor-yor-2?page=<?= $page-1 ; ?>" aria-label="Previous">
                    <span aria-hidden="true">Previous</span>
                    </a>
                @endif
                </li>

                @if($total_page > 14)

                    @for ($i= 1; $i <= 3 ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/portal/product-type/khor-yor-2?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link">...</a></li>
                    @for ($i= $total_page-1; $i <= $total_page ; $i++)
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/portal/product-type/khor-yor-2?page={{ $i }}">{{ $i }}</a></li>
                    @endfor

                @else
                    @for ($i= 1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/portal/product-type/khor-yor-2?page={{ $i }}">{{ $i }}</a></li>
                    @endfor
                
                @endif

                <li class="page-item">
                
                @if ($page == $total_page)
                    <a class="page-link" href="/portal/product-type/khor-yor-2?page={{ $page }}" aria-label="Next">
                    <span aria-hidden="true">next</span>
                    </a>
                @else
                    <a class="page-link" href="/portal/product-type/khor-yor-2?page={{ $page + 1 }}" aria-label="Next">
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
</div>
@endsection
@push('styles')
<style>
    #dropdownDivider {
        background-color: rgb(67, 68, 68);
        color: white;
        border-radius: 5px;
        
    }
    #dropdownlist:hover {
        background-color: rgba(8, 123, 110, 0.544);
        color: white;
        border-radius: 5px;
        
    }
    #protected {
    position: relative;
    }

    #protected::after {
                content: "© cms.vmdrug";
                position: fixed; /* เปลี่ยนจาก absolute → fixed */
                top: 50%;
                left: 50%;
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
    #khoryor {
        background-color: #3399ff;
        color: rgb(102, 102, 102);
        
    }
    #khoryor:hover {
        background-color:#3399ff;
        color: white;
    }
    #listCsv {
        background-color: rgb(67, 68, 68);
        color: white;
        border-radius: 5px;
        
    }
    #listCsv:hover {
        background-color: rgb(8, 123, 110);
        color: white;
        border-radius: 5px;
        
    }
    :root {
        --vh: 100vh;
        }
        @supports (-webkit-touch-callout: none) {
        :root {
            --vh: 100dvh;
        }
        }
        .h-screen-fix {
        height: var(--vh);
        min-height: 100vh;
    }

</style>
@endpush
