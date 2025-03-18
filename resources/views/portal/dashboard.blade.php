<!DOCTYPE html>
<html lang="en">
    @section ('title', 'customer')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" conten="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>cms.vmdrug</title>
</head>
<body>

    @extends ('portal/menuportal-tailwind')
    @section('content')
    @csrf


    <style>

        body{
            font-family: 'Prompt', sans-serif;
        }
        li {
            font-size: 15px;
        }
        .contentArea {
            /* padding: 10px; */
            /* padding: 20px 40px 40px; */
            background-color: #FFFFFF;
            border-radius: 2px;
            /* text-align: left; */
        }


            #column-chart {
            max-width: 80%;
            height: 100%;
            margin: 5px auto;
            }

        
    </style>


    <div class="contentArea">
       
        @section('col-2')

        @if(isset($user_name))
            <h6 class="mt-1" style="">{{$user_name->name}}</h6>
            @endif
        @endsection

        @section('status_alert')
        @if(!($user_name->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$status_alert}}</h6>
            @endif
        @endsection

        @section('status_all')
        @if(!($user_name->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$status_all}}</h6>
            @endif
        @endsection

        @section('status_waiting')
        @if(!($user_name->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$status_waiting}}</h6>
            @endif
        @endsection

        @section('status_action')
        @if(!($user_name->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$status_action}}</h6>
            @endif
        @endsection

        @section('status_completed')
        @if(!($user_name->rights_area) == '0')
            <h6 class="justifiy-content:center;" style="">{{$status_completed}}</h6>
            @endif
        @endsection
        
        <!-- charts --->
        <div class="py-2"></div>
        <p class="ms-6" style="color: #8E8E8E;">หน้าแรก (Dashboard)</p>
        <hr class="my-3" style="color: #8E8E8E; width: 100%; border:solid 2px;">
    
            <div class="bg-white rounded-sm dark:bg-gray-800 text-center">
                <span class="ms-8" style="color:#4a4a4a; font-weight:500; font-size:16px;">All customers</span>
                <div class="py-2" id="column-chart" style="color:#8E8E8E;"></div>
            </div>
        
    </div>
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
</body>
</html>
