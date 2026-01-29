@extends ('layouts.webpanel')
@section('content')
{{-- @csrf --}}
        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6">ร้านค้า (Customer)</h5>
        <hr class="my-3 !text-gray-400 !border">
    
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mx-4 px-2">

            {{-- ร้านค้าทั้งหมด --}}
            <div class="bg-blue-600 text-white rounded-xl p-5 hover:shadow-lg transition">
                <div class="text-sm opacity-90">ร้านค้าทั้งหมด</div>
                <div class="text-3xl font-bold mt-2">
                    {{ $customer_all ?? 0 }}
                </div>
            </div>
        
            {{-- ลงทะเบียนใหม่ --}}
            <a href="/webpanel/customer/status/new_registration"
               class="block bg-cyan-600 text-white rounded-xl p-5 hover:bg-cyan-700 transition">
                <div class="text-sm opacity-90">ลงทะเบียนใหม่</div>
                <div class="text-3xl font-bold mt-2">
                    {{ $status_registration ?? 0 }}
                </div>
            </a>
        
            {{-- บัญชีปกติ --}}
            <div class="bg-emerald-600 text-white rounded-xl p-5 transition">
                <div class="text-sm opacity-90">บัญชีปกติ</div>
                <div class="text-3xl font-bold mt-2">
                    {{ $count_status_normal ?? 0 }}
                </div>
            </div>
        
            {{-- กำลังติดตาม --}}
            <a href="/webpanel/customer/status/following"
               class="block bg-amber-500 text-white rounded-xl p-5 hover:bg-amber-600 transition">
                <div class="text-sm opacity-90">กำลังติดตาม</div>
                <div class="text-3xl font-bold mt-2">
                    {{ $count_status_follow ?? 0 }}
                </div>
            </a>
        
            {{-- ระงับบัญชี --}}
            <div class="bg-rose-600 text-white rounded-xl p-5 transition">
                <div class="text-sm opacity-90">ระงับบัญชี (ไม่เคลื่อนไหว)</div>
                <div class="text-3xl font-bold mt-2">
                    {{ $count_status_suspend ?? 0 }}
                </div>
            </div>
        
            {{-- ปิดบัญชี --}}
            <div class="bg-slate-700 text-white rounded-xl p-5 transition">
                <div class="text-sm opacity-90">ปิดบัญชี</div>
                <div class="text-3xl font-bold mt-2">
                    {{ $count_status_closed ?? 0 }}
                </div>
            </div>
        
        </div>

        <hr class="my-3 !text-gray-400 !border">
    
        <div class="grid md:grid-cols-2 mx-4 px-4">
        
            <div>
                <div id="radial-chart" style="width:100%; color: #8E8E8E;">ร้านค้า</div>
                {{-- <canvas id="doughnutCustomer"></canvas> --}}
            </div>
            <div>
                {{-- <div style="color: #8E8E8E;">Normal customer</div> --}}
                <canvas id="barCustomer"></canvas>
            </div>

           
        </div>
            <!-- charts bar--->
        <hr class="my-3 !text-gray-400 !border">
        <p class="text-gray-900 dark:text-gray text-lm leading-none mt-4 ms-10" style="color: #8E8E8E;">กราฟแสดงข้อมูลร้านค้า</p>

        <div class="grid md:grid-cols-2 mx-4 px-4">

            <div>
                {{-- <div class="protected" style="position: relative;"> --}}
                <canvas id="myNorth" style="width:100%;"></canvas>
                {{-- </div> --}}
                <canvas id="myEastern" style="width:100%;"></canvas>
                <canvas id="myWestern" style="width:100%;"></canvas>
            </div>
            <div class="mb-4">
                <canvas id="myCentral" style="width:100%;"></canvas>
                <canvas id="myNortheast" style="width:100%;"></canvas>
                <canvas id="mySouth" style="width:100%;"></canvas>
            </div>

        </div> 
        
  
    <!--- script charts--->
        <script type="text/javascript">

                //north;
                Chart.defaults.global.defaultFontFamily = "'Sarabun', sans-serif";
                // Chart.defaults.global.defaultFontFamily = "'Helvetica Neue', 'Arial', sans-serif";

                    const xValue_n = ["ร้านค้า", "ปกติ", "ระงับบัญชี", "กำลังติดตาม", "ปิดบัญชี"];
                    const yValue_n = [{{$customer_north}}, {{$normal_customer_north}}, {{$suspend_customer_north}}, {{$follow_customer_north}}, {{$closed_customer_north}}];
                    const barColor_n = ["#AED6F1", "#D1F2EB","#FADBD8","#FAE5D3","#D6DBDF"];
                    const borderColor_n = ["#3498DB","#76D7C4","#D98880","#F8C471","#AEB6BF"];
                    
                new Chart("myNorth", {
                    type: "bar",
                    type: 'horizontalBar',
                    style: {
                        display: false,
                        position: 'bottom',
                        fullWidth: true,
                        labels: {
                        boxWidth: 10,
                        padding: 50
                        }
                    },
                    data: {
                        labels: xValue_n,
                        datasets: [{
                        backgroundColor: barColor_n,
                        borderColor: borderColor_n,
                        borderWidth: 1,
                        //   label: "Wine Production",
                        fill: true,
                        lineTension: 0.1,
                        //   backgroundColor: "#AED6F1",
                        data: yValue_n,
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: "ภาคเหนือ",
                        fontSize: 15,
                        padding: 20,
                        fontFamily: "'Sarabun', sans-serif",
                        // fontStyle: "",
                        fontColor: "#555759"
                        }
                    },
                    
                });

                //central;
                Chart.defaults.global.defaultFontFamily = "'Sarabun', sans-serif";
                
                    const xValues = ["ร้านค้า", "ปกติ", "ระงับบัญชี", "กำลังติดตาม", "ปิดบัญชี"];
                    const yValues = [{{$customer_central}}, {{$normal_customer_central}}, {{$suspend_customer_central}}, {{$follow_customer_central}}, {{$closed_customer_central}}];
                    const barColors = ["#AED6F1", "#D1F2EB","#FADBD8","#FAE5D3","#D6DBDF"];
                    const borderColor = ["#3498DB","#76D7C4","#D98880","#F8C471","#AEB6BF"];
                    
                new Chart("myCentral", {
                    type: "bar",
                    type: 'horizontalBar',
                    style: {
                        display: false,
                        position: 'bottom',
                        fullWidth: true,
                        labels: {
                        boxWidth: 10,
                        padding: 50
                        }
                    },
                    data: {
                        labels: xValues,
                        datasets: [{
                        backgroundColor: barColors,
                        borderColor: borderColor,
                        borderWidth: 1,
                        //   label: "Wine Production",
                        fill: true,
                        lineTension: 0.1,
                        //   backgroundColor: "#AED6F1",
                        data: yValues,
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: "ภาคกลาง",
                        fontSize: 15,
                        padding: 20,
                        fontFamily: "'Sarabun', sans-serif",
                        // fontStyle: "",
                        fontColor: "#555759"
                        }
                    },
                    
                });

                //eastern;
                Chart.defaults.global.defaultFontFamily = "'Helvetica Neue', 'Arial', sans-serif";
                    const xValue_e = ["ร้านค้า", "ปกติ", "ระงับบัญชี", "กำลังติดตาม", "ปิดบัญชี"];
                    const yValue_e = [{{$customer_eastern}}, {{$normal_customer_eastern}}, {{$suspend_customer_eastern}}, {{$follow_customer_eastern}}, {{$closed_customer_eastern}}];
                    const barColor_e = ["#AED6F1", "#D1F2EB","#FADBD8","#FAE5D3","#D6DBDF"];
                    const borderColor_e = ["#3498DB","#76D7C4","#D98880","#F8C471","#AEB6BF"];
                    
                new Chart("myEastern", {
                    type: "bar",
                    type: 'horizontalBar',
                    style: {
                        display: false,
                        position: 'bottom',
                        fullWidth: true,
                        labels: {
                        boxWidth: 10,
                        padding: 50
                        }
                    },
                    data: {
                        labels: xValue_e,
                        datasets: [{
                        backgroundColor: barColor_e,
                        borderColor: borderColor_e,
                        borderWidth: 1,
                        //   label: "Wine Production",
                        fill: true,
                        lineTension: 0.1,
                        //   backgroundColor: "#AED6F1",
                        data: yValue_e,
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: "ภาคตะวันออก",
                        fontSize: 15,
                        padding: 20,
                        fontFamily: "'Sarabun', sans-serif",
                        // fontStyle: "",
                        fontColor: "#555759"
                        }
                    },
                    
                });

                //north east;
                Chart.defaults.global.defaultFontFamily = "'Sarabun', sans-serif";
                    const xValue_ne = ["ร้านค้า", "ปกติ", "ระงับบัญชี", "กำลังติดตาม", "ปิดบัญชี"];
                    const yValue_ne = [{{$customer_northeast}}, {{$normal_customer_northeast}}, {{$suspend_customer_northeast}}, {{$follow_customer_northeast}}, {{$closed_customer_northeast}}];
                    const barColor_ne = ["#AED6F1", "#D1F2EB","#FADBD8","#FAE5D3","#D6DBDF"];
                    const borderColor_ne = ["#3498DB","#76D7C4","#D98880","#F8C471","#AEB6BF"];
                    
                new Chart("myNortheast", {
                    type: "bar",
                    type: 'horizontalBar',
                    style: {
                        display: false,
                        position: 'bottom',
                        fullWidth: true,
                        labels: {
                        boxWidth: 10,
                        padding: 50
                        }
                    },
                    data: {
                        labels: xValue_ne,
                        datasets: [{
                        backgroundColor: barColor_ne,
                        borderColor: borderColor_ne,
                        borderWidth: 1,
                        //   label: "Wine Production",
                        fill: true,
                        lineTension: 0.1,
                        //   backgroundColor: "#AED6F1",
                        data: yValue_ne,
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: "ภาคตะวันออกเฉียงเหนือ",
                        fontSize: 15,
                        padding: 20,
                        fontFamily: "'Sarabun', sans-serif",
                        // fontStyle: "",
                        fontColor: "#555759"
                        }
                    },
                    
                });

                //western;
                Chart.defaults.global.defaultFontFamily = "'Sarabun', sans-serif";
                    const xValue_w = ["ร้านค้า", "ปกติ", "ระงับบัญชี", "กำลังติดตาม", "ปิดบัญชี"];
                    const yValue_w = [{{$customer_western}}, {{$normal_customer_western}}, {{$suspend_customer_western}}, {{$follow_customer_western}}, {{$closed_customer_western}}];
                    const barColor_w = ["#AED6F1", "#D1F2EB","#FADBD8","#FAE5D3","#D6DBDF"];
                    const borderColor_w = ["#3498DB","#76D7C4","#D98880","#F8C471","#AEB6BF"];
                    
                new Chart("myWestern", {
                    type: "bar",
                    type: 'horizontalBar',
                    style: {
                        display: false,
                        position: 'bottom',
                        fullWidth: true,
                        labels: {
                        boxWidth: 10,
                        padding: 50
                        }
                    },
                    data: {
                        labels: xValue_w,
                        datasets: [{
                        backgroundColor: barColor_w,
                        borderColor: borderColor_w,
                        borderWidth: 1,
                        //   label: "Wine Production",
                        fill: true,
                        lineTension: 0.1,
                        //   backgroundColor: "#AED6F1",
                        data: yValue_w,
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: "ภาคตะวันตก",
                        fontSize: 15,
                        padding: 20,
                        fontFamily: "'Sarabun', sans-serif",
                        // fontStyle: "",
                        fontColor: "#555759"
                        }
                    },
                    
                });

                //south;
                Chart.defaults.global.defaultFontFamily = "'Sarabun', sans-serif";
                    const xValue_s = ["ร้านค้า", "ปกติ", "ระงับบัญชี", "กำลังติดตาม", "ปิดบัญชี"];
                    const yValue_s = [{{$customer_south}}, {{$normal_customer_south}}, {{$suspend_customer_south}}, {{$follow_customer_south}}, {{$closed_customer_south}}];
                    const barColor_s = ["#AED6F1", "#D1F2EB","#FADBD8","#FAE5D3","#D6DBDF"];
                    const borderColor_s = ["#3498DB","#76D7C4","#D98880","#F8C471","#AEB6BF"];
                    
                new Chart("mySouth", {
                    type: "bar",
                    type: 'horizontalBar',
                    style: {
                        display: false,
                        position: 'bottom',
                        fullWidth: true,
                        labels: {
                        boxWidth: 10,
                        padding: 50
                        }
                    },
                    data: {
                        labels: xValue_s,
                        datasets: [{
                        backgroundColor: barColor_s,
                        borderColor: borderColor_s,
                        borderWidth: 1,
                        //   label: "Wine Production",
                        fill: true,
                        lineTension: 0.1,
                        //   backgroundColor: "#AED6F1",
                        data: yValue_s,
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: "ภาคใต้",
                        fontSize: 15,
                        padding: 20,
                        fontFamily: "'Sarabun', sans-serif",
                        // fontStyle: "",
                        fontColor: "#555759"
                        }
                    },
                    
                });
     

                //chart dounghnut bar;
/* 
               const barColors_all = ["#F5B7B1","#C39BD3","#7FB3D5","#76D7C4","#F8C471"];

                const xValues_all = ["ภาคเหนือ", "ภาคกลาง", "ภาคตะวันออก", "ภาคตะวันออกเฉียงเหนือ", "ภาคตะวันตก", "ภาคใต้"];
                const yValues_all = [{{$customer_north}}, {{$customer_central}}, {{$customer_eastern}}, {{$customer_northeast}}, {{$customer_western}}, {{$customer_south}}];

                new Chart("doughnutCustomer", {
                    type: "doughnut",
                    data: {
                        labels: xValues_all,
                        datasets: [{
                        backgroundColor: barColors_all,
                        data: yValues_all
                        }]
                    },
                    options: {
                        title: {
                        display: true,
                        text: "All customers",
                        fontSize: 15,
                        padding: 20,
                        fontFamily: "Prompt",
                        fontColor: "#555759"
                        }
                    },
                    labels: ["ภาคเหนือ", "ภาคกลาง", "ภาคตะวันออก", "ภาคตะวันออกเฉียงเหนือ", "ภาคตะวันตก", "ภาคใต้"],
                        dataLabels: {
                        enabled: false,
                        },
                }); */

                //doughnut chart;
                const xValues_bar = ["ภาคเหนือ", "ภาคกลาง", "ภาคตะวันออก", "ภาคตะวันออกเฉียงเหนือ", "ภาคตะวันตก", "ภาคใต้"];
                const yValues_bar = [{{$normal_customer_north}}, {{$normal_customer_central}}, {{$normal_customer_eastern}}, {{$normal_customer_northeast}}, {{$normal_customer_western}}, {{$normal_customer_south}}];
                const barColors_bar = ["#D1F2EB", "#D1F2EB","#D1F2EB","#D1F2EB","#D1F2EB", "#D1F2EB"];
                const borderColors_bar = ["#76D7C4","#76D7C4","#76D7C4","#76D7C4","#76D7C4", "#76D7C4"];

                new Chart("barCustomer", {
                    
                        type: "bar",
                        data: {
                            labels: xValues_bar,
                            datasets: [{
                                backgroundColor: barColors_bar,
                                borderColor: borderColors_bar,
                                borderWidth: 1,
                                data: yValues_bar
                                }]
                        },
                        options: {
                            legend: {display: false},
                            title: {
                            display: true,
                            text: "สถานะบัญชีปกติ",
                            fontSize: 15,
                            padding: 20,
                            fontFamily: "'Sarabun', sans-serif",
                            fontColor: "#555759",
                            }
                        }
                    });
        </script>

        <script type="text/javascript">    

                    const getChartOptions = () => {
                    return {
                        series:  [{{$customer_north}}, {{$customer_central}}, {{$customer_eastern}}, {{$customer_northeast}}, {{$customer_western}}, {{$customer_south}}],
                        colors: ["#EF9A9A","#C39BD3","#7FB3D5","#80CBC4","#FFCC80", "#D7CCC8"],
                        chart: {
                        height: "100%",
                        width: "100%",
                        type: "donut",
                        fontFamily: "'Sarabun', sans-serif",
                        },
                        stroke: {
                        colors: ["transparent"],
                        lineCap: "",
                        },
                        plotOptions: {
                        pie: {
                            donut: {
                            labels: {
                                show: true,
                                name: {
                                show: true,
                                fontFamily: "'Sarabun', sans-serif",
                                offsetY: 20,
                                },
                                total: {
                                showAlways: true,
                                show: true,
                                label: "All customers",
                                fontFamily: "'Sarabun', sans-serif",
                                fontSize: 14,
                                formatter: function (w) {
                                    const sum = w.globals.seriesTotals.reduce((a, b) => {
                                    return a + b
                                    }, 0)
                                    return sum
                                },
                                },
                                value: {
                                show: true,
                                fontFamily: "'Sarabun', sans-serif",
                                offsetY: -20,
                                formatter: function (value) {
                                    return value + "k"
                                },
                                },
                            },
                            size: "70%",
                            },
                        },
                        },
                        grid: {
                        padding: {
                            top: -2,
                        },
                        },
                        labels: ["ภาคเหนือ", "ภาคกลาง", "ภาคตะวันออก", "ภาคตะวันออกเฉียงเหนือ", "ภาคตะวันตก", "ภาคใต้"],
                        dataLabels: {
                        enabled: false,
                        },
                        legend: {
                        position: "bottom",
                        fontFamily: "'Sarabun', sans-serif",
                        },
                        yaxis: {
                        labels: {
                            formatter: function (value) {
                            return value
                            },
                        },
                        },
                        xaxis: {
                        labels: {
                            formatter: function (value) {
                            return value
                            },
                        },
                        axisTicks: {
                            show: false,
                        },
                        axisBorder: {
                            show: false,
                        },
                        }
                    }
                    }

                    if (document.getElementById("radial-chart") && typeof ApexCharts !== 'undefined') {
                    const chart = new ApexCharts(document.getElementById("radial-chart"), getChartOptions());
                    chart.render();

                  /*   // Get all the checkboxes by their class name
                    const checkboxes = document.querySelectorAll('#devices input[type="checkbox"]');

                    // Function to handle the checkbox change event
                    function handleCheckboxChange(event, chart) {
                        const checkbox = event.target;
                        if (checkbox.checked) {
                            switch(checkbox.value) {
                                case 'desktop':
                                chart.updateSeries([15.1, 22.5, 4.4, 8.4]);
                                break;
                                case 'tablet':
                                chart.updateSeries([25.1, 26.5, 1.4, 3.4]);
                                break;
                                case 'mobile':
                                chart.updateSeries([45.1, 27.5, 8.4, 2.4]);
                                break;
                                default:
                                chart.updateSeries([55.1, 28.5, 1.4, 5.4]);
                            }

                        } else {
                            chart.updateSeries([35.1, 23.5, 2.4, 5.4]);
                        }
                    }

                    // Attach the event listener to each checkbox
                    checkboxes.forEach((checkbox) => {
                        checkbox.addEventListener('change', (event) => handleCheckboxChange(event, chart));
                    }); */
                    }


        </script>


@endsection

