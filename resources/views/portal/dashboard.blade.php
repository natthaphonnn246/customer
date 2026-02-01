@extends ('layouts.portal')
@section('content')

    <div class="contentArea" id="protected">
       
        <!-- charts --->
        <div class="py-2"></div>
        <h5 class="ms-6 !text-gray-600">หน้าหลัก</h5>
        <hr class="my-3">
    
            <div class="text-start">
                {{-- <h5 class="ms-8 !text-gray-600 !font-[400]">สถานะร้านค้า</h5> --}}
                <div class="py-2" id="column-chart"></div>
            </div>
    </div>

        @if(isset($count_modal_waiting) && $count_modal_waiting > 0 && $check_edit === 0)
            <div class="modal fade" id="checkModalWaiting" tabindex="-1" aria-labelledby="checkModalWaitingLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-center">
                    <h5 class="modal-title w-100 text-center !text-orange-400">
                        {{-- กรุณาอัปเดตข้อมูลให้ครบ :  --}}
                        <span class="inline-block border-2 border-amber-400 text-amber-400 px-3 py-2 rounded-lg text-base">ต้องดำเนินการ</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                    </div>
                    <div class="modal-body text-left">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-warning">
                                <tr>
                                    <td class="!text-center font-medium !text-gray-600">รหัสร้านค้า</td>
                                    <td class="!text-center font-medium !text-gray-600">
                                        ชื่อร้านค้า
                                    </td>
                            
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($check_modal_waiting as $row_modal)
                                    <tr>
                                        <td class="!text-center !text-gray-500">{{ $row_modal->customer_id }}</td>
                                        <td>
                                            <a href="{{ asset('/portal/customer/'.$row_modal->slug) }}" class="!no-underline !text-gray-500">
                                                {{ $row_modal->customer_name }}
                                                {{-- <sup style="background-color:#e04b30; color:white; border-radius:5px; padding:3px;">Edit</sup> --}}
                                            </a>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="modal-footer">
                    <button type="button" id="acknowledgeBtnWaiting" class="btn btn-warning">รับทราบ</button>
                    </div>
                </div>
                </div>
            </div>
        @endif

        <script>
             document.addEventListener("DOMContentLoaded", function () {
                var modal2 = new bootstrap.Modal(document.getElementById('checkModalWaiting'));
                        modal2.show();

                        // ปุ่มปิด modal2
                        document.getElementById('acknowledgeBtnWaiting').addEventListener('click', function () {
                            var m2 = bootstrap.Modal.getInstance(document.getElementById('checkModalWaiting'));
                            m2.hide();
                        });
             });
        </script>

        <script type="text/javascript">
                
                const options = {
                colors: ["#2B8BFF"],
                series: [
                    {
                    name: "Customers",
                    color: "#2B8BFF",
                    data: [
                        { x: "ร้านค้า", y: {{$status_all}} },
                        { x: "รอดำเนินการ", y: {{$status_waiting}} },
                        { x: "ต้องดำเนินการ", y: {{$status_action}} },
                        { x: "ดำเนินการแล้ว", y: {{$status_completed}} },
                    ],
                    },
                ],
                chart: {
                    type: "bar",
                    height: "500px",
                    fontFamily: "Prompt, sans-serif",
                    toolbar: {
                    show: false,
                    },
                },
                plotOptions: {
                    bar: {
                    horizontal: false,
                    columnWidth: "50%",
                    borderRadiusApplication: "end",
                    borderRadius: 0,
                    },
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    style: {
                    fontFamily: "Prompt, sans-serif",
                    },
                },
                states: {
                    hover: {
                    filter: {
                        type: "darken",
                        value: 1,
                    },
                    },
                },
                stroke: {
                    show: true,
                    width: 0,
                    colors: ["transparent"],
                },
                grid: {
                    show: true,
                    strokeDashArray: 0,
                    padding: {
                    left: 2,
                    right: 2,
                    top: -14
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                legend: {
                    show: false,
                },
                xaxis: {
                    floating: false,
                    labels: {
                    show: true,
                    style: {
                        fontFamily: "Prompt, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400 transform:rotate(45deg)',
                    }
                    },
                    axisBorder: {
                    show: false,
                    },
                    axisTicks: {
                    show: false,
                    },
                },
                yaxis: {
                    show: true,
                },
                fill: {
                    opacity: 1,
                },
                }

                if(document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("column-chart"), options);
                chart.render();
                }

        </script>


@endsection
@push('styles')
<style>

    #column-chart {
        max-width: 80%;
        height: 100%;
        margin: 5px auto;
        /* overflow: auto; */
        }

    #protected {
            position: relative;
            }

            #protected::after {
            content: "© cms.vmdrug";
            position: absolute;
            top: 50%;
            left: 50%;
            font-size: 145px;
            /* color: rgba(234, 43, 43, 0.111); */
            color: rgba(170, 170, 170, 0.111);
            pointer-events: none;
            transform: translate(-50%, -50%); /* เอียงซ้าย 45 องศา */
            white-space: nowrap; /* ป้องกันตัดบรรทัด */
    }
    .modal-body {
        max-height: 60vh;
        overflow-y: auto;
    }

</style>
@endpush