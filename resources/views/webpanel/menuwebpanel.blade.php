<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!--jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

    <title>@yield('title') | Develop</title>
</head>

<style>
     body{
        font-family: 'Prompt', sans-serif;
    }
    li {
        font-size: 14px;
    }
    .rotate {
        transform: rotate(-90deg);
        margin-left: calc(30px + 60px);
    }
    .rotate_p {
        transform: rotate(-90deg);
        margin-left: calc(30px + 40px);
    }
    .profile {
        background-color: rgba(3, 12, 40, 0.463);
        height: 85px;
    }
    .submenu {
        background-color: rgba(3, 12, 40, 0.463);
    }
    .sub_product {
        background-color: rgba(3, 12, 40, 0.463);
    }
    html,body{
    /* height: 100%; */
    /* font-family: "Prompt", sans-serif; */
    font-weight: 400;
    font-style: normal;
    font-size: 15px;
    }
    .container-fluid{
        display: flex;
        flex-direction: row;
        background-color: rgb(255, 255, 255);
        position: fixed;
        /* flex-direction: column; */
    
    }
    .sidebar{
        background-color: rgb(58, 73, 96);
        max-width: 300px;
        width: 100%;
        overflow: auto;
        /* height: 100%; */
        /* text-align: left; */
        /* padding-top: 10px; */
    }
    .item a {
        color: rgb(255, 255, 255);
        text-align: center;
        text-decoration: none;
        margin-left: 25px;
        padding: 20px;
        width: 100%;
    }
    .dropdown {
        color: rgb(255, 255, 255);
        text-align: center;
        text-decoration: none;
        /* margin-left: 100px; */
        /* margin-left: 30%; */
        margin-left: calc(25px + 65px);
    }
    .dropdown_p {
        color: rgb(255, 255, 255);
        text-align: center;
        text-decoration: none;
        /* margin-left: 85px; */
        /* padding-top: 20px; */
        /* margin-left: 30%; */
        margin-left: calc(25px + 45px);
    }
    .item{
        padding: 0px;
        line-height: 55px;
        
    }
    /* .item :hover {
        background-color: rgba(21, 0, 207, 0.563);
        line-height: 60px;
    
    } */
    .content{
        background-color: #ebedef;
        width: 100%;
        overflow: auto;
        text-align: center;
        padding-left: 30px;
        padding-right: 30px;
    }
    .img-fluid{
        margin-top: 18px;
        border-radius: 100%;
        width: 48px;
        height: 48px;
        color: aliceblue;
        margin-left: 50px;
    }
    .mt-1{
        color: aliceblue;
        padding-top: 10px;
    }
    #logout :hover {
        background-color: rgb(211, 57, 57);
    }
    #product {
        background-color: none;
    }
    /* .item :hover {
        background-color: rgb(32, 45, 163);
        color: white;
    } */
    .itemList_menu:hover {
        background-color: rgba(13, 62, 206, 0.463);
        color: white;
        width: 100%;
    }
    .mainItem:hover {
        color: white;
        background-color: rgb(32, 45, 163);
        
    }
    .mainItem {
        line-height: 55px;
        padding: 0px;

    }
    .logout:hover {
        background-color: rgb(198, 54, 54);
        color: white;
        width: 100%;
    }
    .logout {
    background-color: rgb(225, 88, 88);
    padding: 0px;
    }
</style>

<title>Document</title>
</head>
<body>

<div class="container-fluid p-0 d-flex h-100" style=" min-width: 1500px;">
    <div class="sidebar">
    
    <div class="row profile">
        <div class="col-3">
            {{-- <img src="{{asset('/images/profile_img copy.jpg')}}" class="img-fluid" width="50px" alt=""> --}}
            <img src="/profile/profile_img copy.jpg" class="img-fluid" width="50px" alt="">
        </div>

        <div class="col-2">
            <h6 class="mt-1" style="margin-left: 50px; padding-top: 26px;">Natthaphon</h6>
        </div>
    </div>
    
       <ul class="item" id="#">
       
           {{--  <ul class="mainItem">
                <li><a href="/portal/signin" style="cursor: pointer; margin-right: 15px;" id="sub_product"  class="sub-btn">สมัครสมาชิก (Dashboard) <i class="fas fa-angle-left dropdown_p" style="font-size: 12px;"></i></a></li>
            </ul> --}}
                <ul class="mainItem">
                    <li><a href="/webpanel" style="cursor: pointer; margin-right: 15px;" id="sub_product"  class="sub-btn">หน้าแรก (Dashboard)</a></li>
                </ul>


                <ul class="mainItem" id="report">
                    {{-- <li class="sub-menu"><a href="#" style="cursor: pointer; margin-right: 15px;" id="submenu"  class="sub-btn">รายงาน (Report) <i class="fas fa-angle-left dropdown" style="font-size: 12px;"></i></a></li> --}}
                    <li><a style="cursor: pointer; margin-right: 15px;" id="submenu"  class="sub-btn">ข้อมูลแอดมิน (Admin)</a></li>
                </ul>
                    <div class="sub-menu" style=" display: none; line-height: 55px;">
                        
                        <div class="itemList_menu"><a href="/webpanel/admin" style="line-height: 60px;" href="/webpanel/customer">แอดมินทั้งหมด</a></div>
                        <div class="itemList_menu"><a href="/webpanel/sale" style="line-height: 60px;" href="/webpanel/customer">เขตการขาย</a></div>
                        {{-- <div class="itemList_menu"><a style="line-height: 60px;" href="/webpanel/role">จัดการสิทธิ์</a></div> --}}
            
                    </div>

                <ul class="mainItem" id="campaign">
                    <li><a style="cursor: pointer; margin-right: 15px;" id="submenu"  class="sub-btn">ข้อมูลลูกค้า (Customer)</a></li>
                </ul>
    
                    <div class="sub-menu" style=" display: none; line-height: 55px;">
                    
                        <div class="itemList_menu"><a style="line-height: 60px;" href="/webpanel/customer">ลูกค้าทั้งหมด</a></div>
                        {{-- <div class="itemList_menu"><a style="line-height: 60px;" href="/campaign/random">สุ่มผู้โชคดี</a></div> --}}
            
                    </div>

                <ul class="mainItem" id="report">
                    {{-- <li class="sub-menu"><a href="#" style="cursor: pointer; margin-right: 15px;" id="submenu"  class="sub-btn">รายงาน (Report) <i class="fas fa-angle-left dropdown" style="font-size: 12px;"></i></a></li> --}}
                    <li><a href="/webpanel/setting" style="cursor: pointer; margin-right: 15px;" id="submenu"  class="sub-btn">ตั้งค่าระบบ (Settings)</a></li>
                </ul>

        <ul class="item">
                <li class="logout"><a href="/logout" ><i class="fa-solid fa-power-off"></i>
                    ออกจากระบบ (Logout)
                </a>
                </li>
        </ul>
    </ul>
</div>
<div class="content">
    <p>@yield('content')</p>
 
</div>
</div>

<!--Stock menu-->
<script>

        $(document).ready(function () {

            $("#report").click(function () {
                console.log("Report");
                $(this).next('.sub-menu').slideToggle();
                $(this).find('.dropdown').toggleClass('rotate');
                $(this).toggleClass("submenu"); // toggle เปิดปิดแถบสีเมนู;
                $('.sub-menu').css("background-color", "rgba(3, 12, 40, 0.463)");
            

            });
        
        });

</script>

<!-- Product menu-->
<script>

        $(document).ready(function () {

            $("#report_product").click(function () {
                console.log("Report_Product");
                $(this).next('.menu_product').slideToggle();
                $(this).find('.dropdown_p').toggleClass('rotate_p');
                $(this).toggleClass("sub_product"); // toggle เปิดปิดแถบสีเมนู;
                $('.menu_product').css("background-color", "rgba(3, 12, 40, 0.463)");
            

            });
        
        });

</script>

<script>

    $(document).ready(function () {

        $("#campaign").click(function () {
            console.log("Campaign");
            $(this).next('.sub-menu').slideToggle();
            $(this).find('.dropdown').toggleClass('rotate');
            $(this).toggleClass("submenu"); // toggle เปิดปิดแถบสีเมนู;
            $('.sub-menu').css("background-color", "rgba(3, 12, 40, 0.463)");
        

        });
    
    });

</script>

<script type="text/javascript">

    // console.log('hello');
 
        // $("#import_csv").prop("disabled", true);
   
    </script>

</body>
</html>