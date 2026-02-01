@extends ('layouts.portal')
@section('content')

    <div class="py-2"></div>
    <h5 class="ms-6 !text-gray-600">ร้านค้า : <span class="inline-block border-2 border-orange-500 text-orange-500 px-3 py-2 rounded-lg text-base cursor-pointer">ต้องดำเนินการ</span></h5>
    <hr class="my-3">
    
            <div class="modal fade" id="checkModal" tabindex="-1" aria-labelledby="checkModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header text-center">
                      <h5 class="modal-title w-100 text-center" style="font-size: 24px; font-weight:400; color: rgb(249, 48, 48);">ปิดแก้ไขข้อมูลลูกค้าชั่วคราว</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                    </div>
                    <div class="modal-body text-center">
                   {{--  <p style="color: red; font-size:72px;">
                        <i class="fa-regular fa-triangle-exclamation alert-icon"></i>
                    </p> --}}

                    <p style="color: red;">
                        <img src="/icons/alarm.gif" alt="" style="width:100%; height:auto; max-width:500px;">
                    </p>
                        
                      <p style="color: rgb(0, 68, 255); font-size:24px;">กรุณากลับมาอีกครั้งในภายหลัง</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" id="acknowledgeBtn" class="btn btn-primary">รับทราบ</button>
                    </div>
                  </div>
                </div>
            </div>

            <script>
                let checkEdit = @json($check_edit); // จะได้ boolean จริง ๆ
                if(checkEdit) {
                    var myModal = new bootstrap.Modal(document.getElementById('checkModal'));
                    myModal.show();

                    document.getElementById('acknowledgeBtn').addEventListener('click', function () {
                        var modal = bootstrap.Modal.getInstance(document.getElementById('checkModal'));
                        modal.hide();
                    });

                }
            </script>
            
            <div class="ms-6 mr-6" id="protected">
            <div class="row">
                <!--- search --->
                <div style="display: flex; justify-content: center;">
                    <form class="py-3" style="width:80%;" method="get" action="/portal/customer/status/action">
                        {{-- <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-black">Search</label> --}}
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <!---icon -->
                            </div>
                            <input type="search" id="default-search" name="keyword" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="CODE" />
                            <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium !rounded-md text-sm px-4 py-2 my-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">ค้นหา</button>
                        
                        </div>
                        <p class="py-2" id="keyword_search"></p>
                        @csrf   
                    </form>
                </div>

            </div>

        <hr style="color: #8E8E8E; width: 100%;">
        
        <div class="overflow-x-auto">
        <table class="table table-striped">
            <thead>
              <tr>
                <td scope="col" class="!text-gray-500 text-left p-3 font-medium">#</td>
                <td scope="col" class="!text-gray-500 text-center p-3 font-medium">CODE</td>
                <td scope="col" class="!text-gray-500 text-left p-3 font-medium">อีเมล</td>
                <td scope="col" class="!text-gray-500 text-center p-3 font-medium">เขตการขาย</td>
                <td scope="col" class="!text-gray-500 text-left p-3 font-medium">ชื่อร้านค้า</td>
                <td scope="col" class="!text-gray-500 text-center p-3 font-medium">สถานะ</td>
                @if(!empty($pur_report) && $pur_report->purchase_status === 1)
                    <td scope="col" class="!text-gray-500 text-center p-3 font-medium">การสั่งซื้อ</td>
                @endif
                {{-- <td scope="col" class="!text-gray-500 text-left p-3 font-medium">วันที่ลงทะเบียน</td> --}}
                <td scope="col" class="!text-gray-500 text-left p-3 font-medium">จัดการ</td>
              </tr>
            </thead>
            <tbody>
                @if(!empty($customer_list))
                <?php 
                    $start += 1;
                ?>
                @foreach ($customer_list as $row_list)
              <tr>
                    <?php
                        
                        $id = $row_list->id;
                        $customer_name = $row_list->customer_name;
                        $customer_code = $row_list->customer_code;
                        $sale_area = $row_list->sale_area;
                        $status_admin = $row_list->sale_area;
                        $email = $row_list->email;
                        $status = $row_list->status;
                        $created_at = $row_list->created_at;
                        $customer_status = $row_list->customer_status;
                        $slug = $row_list?->slug;
                    ?>
                
                @if($customer_status == 'active')
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$start++}}</td>
                    <td scope="row" class="text-gray-400 text-center px-3 py-4 !text-gray-500">{{$customer_code}}</td>
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$email}}</td>
                    <td scope="row" class="text-gray-400 text-center px-3 py-4 !text-gray-500">{{$sale_area}}</td>
                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$customer_name}}</td>
                    <td class="text-center px-3 py-4 w-full md:w-1/5">
                        @if ($status == 'รอดำเนินการ')
                        <span class="inline-block border-2 border-red-400 text-red-400 px-3 py-2 rounded-lg text-sm">
                            รอดำเนินการ
                        </span>
                
                        @elseif ($status == 'ต้องดำเนินการ')
                            <span class="inline-block border-2 border-amber-400 text-amber-400 px-3 py-2 rounded-lg text-sm">
                                ต้องดำเนินการ
                            </span>
                    
                        @else ($status == 'ดำเนินการแล้ว')
                            <span class="inline-block border-2 border-green-500 text-green-500 px-3 py-2 rounded-lg text-sm">
                                ดำเนินการแล้ว
                            </span>
                        @endif
                    </td>

                    {{-- <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">{{$created_at}}</td> --}}

                    @php
                        $dis_check =  $check_edit;
                        $dis_check = $dis_check > 0;
                    @endphp

                    <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">
                        <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                            <a href="{{ $dis_check ? 'javascript:void(0)' : '/portal/customer/'.$slug }}"
                            id="edit"
                            class="{{ $dis_check ? 'disabled-link' : '' }}">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                        </div>

                    </td>

                    {{-- <td scope="row" style="color:#9C9C9C; text-align: center; padding:15px;"><a href="/portal/customer/{{$id}}" id="edit"><i class="fa-regular fa-eye"></i></a> --}}
                    {{-- <button id="trash"><i class="fa-regular fa-trash-can"></i></button> --}}
                   
                @endif
              </tr>
    
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
{{-- {{dd($total_page);}} --}}
          @if($total_page > 1)
          <nav aria-label="Page navigation example">
            <ul class="pagination py-4">
            <li class="page-item">

            @if ($page == 1)
                <a class="page-link" href="/portal/customer/status/action?page={{ 1 }}" aria-label="Previous">
                <span aria-hidden="true">Previous</span>
                </a>
            @else
                <a class="page-link" href="/portal/customer/status/action?page={{ $page - 1 }}" aria-label="Previous">
                <span aria-hidden="true">Previous</span>
                </a>
            @endif
            </li>

            @if($total_page > 14)

                @for ($i= 1; $i <= 10 ; $i++)
                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/portal/customer/status/action?page={{ $i }}">{{ $i }}</a></li>
                @endfor
                <li class="page-item"><a class="page-link">...</a></li>
                @for ($i= $total_page-1; $i <= $total_page ; $i++)
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>"><a class="page-link" href="/portal/customer/status/action?page={{ $i }}">{{ $i }}</a></li>
                @endfor

            @else
                @for ($i= 1; $i <= $total_page ; $i++)
                <li class="page-item <?= ($i == $page) ? 'active' : '' ; ?>" ><a class="page-link" href="/portal/customer/status/action?page={{ $i }}">{{ $i }}</a></li>
                @endfor
            
            @endif

            <li class="page-item">
            
            @if ($page == $total_page)
                <a class="page-link" href="/portal/customer/status/action?page={{ $page }}" aria-label="Next">
                <span aria-hidden="true">next</span>
                </a>
            @else
                <a class="page-link" href="/portal/customer/status/action?page={{ $page + 1 }}" aria-label="Next">
                <span aria-hidden="true">next</span>
                </a>
            @endif
            </li>
            </ul>
        </nav>
        @else
        {{-- <hr> --}}
        @endif

    </div>

<script>
        $(document).ready(function () {

            $("#reports").click(function () {
                console.log("Report");
                $(this).next('.sub-menus').slideToggle();
                $(this).find('.dropdown').toggleClass('rotate');
                $(this).toggleClass("submenu"); // toggle เปิดปิดแถบสีเมนู;
                // $('.sub-menus').css("background-color", "black", "text-align", "left");
            

            });
        
        });

</script>
@endsection
@push('styles')
<style>
    #edit {
        background-color: #007bff;
        color: #FFFFFF;
        border: none;
        cursor: pointer;
        padding: 8px 16px;
        font-size: 16px;
        border-radius: 4px;
        text-align: center;
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
                /* color: rgba(234, 43, 43, 0.111); */
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

</style>
@endpush
