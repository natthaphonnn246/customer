@extends ('layouts.webpanel')
@section('content')
@csrf
        
        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6"><a href="/webpanel/admin" class="!no-underline">ย้อนกลับ</a> | รายละเอียด</h5>
        <hr class="my-3 !text-gray-400 !border">

        <div class="grid grid-cols-1 gap-4 mx-4 px-2 text-gray-500">

        <div class="mt-3">
            <a href="/webpanel/sale-create" class="bg-blue-500 hover:bg-blue-600 !rounded-md py-2 px-3 text-white !no-underline" type="submit"  name="">เพิ่มเขตการขาย</a>
            <a href="/webpanel/sale/importsale" class="bg-gray-200 hover:bg-gray-300 !rounded-md py-2 px-3 !text-gray-600 !no-underline text-center" type="submit"  name="">import Sale CSV</a>
            {{-- <a href="/webpanel/admin-role"  id="adminRole" class="btn" type="submit"  name="" style="width: 180px; padding: 8px;">จัดการสิทธิ์</a> --}}
    
        </div>

        <hr class="my-2 !text-gray-400">

        <table class="table table-striped">
            <thead>
              <tr>
                <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">#</td>
                <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">Sale area</td>
                <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">ชื่อพนักงานขาย</td>
                <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">วันที่สร้าง</td>
                <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">จัดการ</td>
              </tr>
            </thead>
            <tbody>
                @if(!empty($salearea))

                <?php 
                    @$start = 1;
                ?>
                @foreach ($salearea as $row)
              <tr>
                    <?php
                        
                        $id = $row->id;
                        $sale_area = $row->sale_area;
                        $sale_name = $row->sale_name;
                        $created_at = $row->created_at
            
                    ?>
                
                <td scope="row" class="!text-gray-500 text-left p-3">{{$start++}}</td>
                <td scope="row" class="!text-gray-500 text-left p-3">{{$sale_area}}</td>
                <td scope="row" class="!text-gray-500 text-left p-3">{{$sale_name}}</td>
                <td scope="row" class="!text-gray-500 text-left p-3">{{$created_at}}</td>
                <td class="text-gray-500 text-left p-3">
                    <div class="flex flex-col sm:flex-row gap-2 sm:items-center">
                        <a href="/webpanel/sale/{{$id}}"
                           class="bg-blue-500 py-2 px-3 hover:bg-blue-600 rounded-sm text-white text-center">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                
                        <button
                            class="bg-red-500 py-2 px-3 hover:bg-red-600 !rounded-sm text-white"
                            type="submit"
                            id="trash{{$id}}">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                </td>
               
              </tr>
               <!-- delete saleareas table -->
                <script>
                        $(document).ready(function() {

                                $('#trash{{$id}}').click(function(e) {
                                    e.preventDefault();
                                    // console.log('delete{{$sale_area}}');
                                    let code_del = '{{$id}}';
                                    // console.log('{{$sale_area}}');

                                        swal.fire({
                                            icon: "warning",
                                            title: "คุณต้องการลบข้อมูลหรือไม่",
                                            // text: '<?= $sale_area .' '.'('. $sale_name.')' ; ?>',
                                            text: '{{$sale_area.' '.'('. $sale_name.')'}}',
                                            showCancelButton: true,
                                            confirmButtonText: "ลบข้อมูล",
                                            cancelButtonText: "ยกเลิก"
                                        }).then(function(result) {
                            
                                        if(result.isConfirmed) {
                                            $.ajax({
                                            url: '/webpanel/sale/delete/{{$id}}',
                                            type: 'GET',
                                            success: function(data) {

                                                let check_id = JSON.parse(data);
                                                console.log(check_id.checkcode);

                                                if(check_id.checkcode == code_del) 
                                                {
                                                    swal.fire({
                                                        icon: "success",
                                                        title: "ลบข้อมูลสำเร็จ",
                                                        showConfirmButton: true,
                                                    
                                                    }).then (function(result) {
                                                        window.location.reload();
                                                    });
                                                    
                                                } else {
                                                    Swal.fire({
                                                        icon: "error",
                                                        title: "เกิดข้อผิดพลาด",
                                                        text: 'ไม่พบข้อมูล {{$sale_area.' '.'('. $sale_name.')'}}',
                                                        showConfirmButton: true,
                                                    });
                                                }

                                            },

                                        });

                                    } //iscomfirmed;
                        
                                });   

                            });
                        
                        });

                </script>

              @endforeach
              @endif
            </tbody>
          </table>
        
    </div>

@endsection

