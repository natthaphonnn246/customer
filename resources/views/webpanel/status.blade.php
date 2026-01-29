@extends ('layouts.webpanel')
@section('content')
@csrf

        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6">สถานะการใช้งาน (Admin Status)</h5>
        <hr class="my-3 !text-gray-400 !border">

        <div class="grid grid-cols-1 gap-4 mx-4 px-2 text-gray-500">

            <table class="table table-striped" id="user-table">
                <thead>
                    <tr>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">#</td>
                        <td scope="col" style="color:#838383; text-align: left; font-weight: 500;">CODE</td>
                        <td scope="col" style="color:#838383; text-align: left;  font-weight: 500;">อีเมล</td>
                        <td scope="col" style="color:#838383; text-align: left;  font-weight: 500;">ชื่อ</td>
                        <td scope="col" style="color:#838383; text-align: left;  font-weight: 500;">เข้าระบบล่าสุด</td>
                        <td scope="col" style="color:#838383; text-align: left;  font-weight: 500;">สถานะ</td>
                    </tr>
                </thead>
                <tbody>
                    <!-- JSON Data will be inserted here -->
                </tbody>
            </table>

    </div>

    {{-- {{$date}} --}}
@endsection

    <script>

     async function fetchStatus() {
        const response = await fetch('/webpanel/active-user/updated');
        const data =  await response.json();
        // console.log(data[1]);

        const data_row = data.user;

        const tableBody = document.querySelector("#user-table tbody");
        // console.log(data[1]);

        let start = 1;
        //เคลียร์ตาราง;
        tableBody.innerHTML = "";
        data_row.forEach(rowd => {

            console.log(data.setting);
         /*    console.log(rowd.last_activity);
            console.log(data[1]); */

            const count_time = (data.date.date - rowd.last_activity)/60;
            console.log(count_time);

            const row = document.createElement("tr");
        
                if(data.date.date - rowd.last_activity < 300) {

                    if(data.setting == 1) {
                        row.innerHTML = `<td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${start++}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.user_id}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.email}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.name}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.login_date}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;"><i class="fa-solid fa-circle" style="color: #fbc02d; font-size:18px;"></i> ปิดปรับปรุง (Login)</td>`;
                    } else {
                        row.innerHTML = `<td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${start++}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.user_id}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.email}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.name}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.login_date}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;"><i class="fa-solid fa-circle" style="color: #03ae3f; font-size:18px;"></i> ออนไลน์</td>`;
                    }
                   
                
                } else if (count_time < 59) {

                    if(data.setting == 1) {
                        row.innerHTML = `<td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${start++}</td>
                                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.user_id}</td>
                                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.email}</td>
                                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.name}</td>
                                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.login_date}</td>
                                        <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;"><i class="fa-solid fa-circle" style="color: #ee2c2c; font-size:18px;"></i> ออฟไลน์เมื่อ ${Math.round(count_time)} นาทีที่แล้ว (ปิดปรับปรุง)</td>`;
                    
                    } else {
                        row.innerHTML = `<td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${start++}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.user_id}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.email}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.name}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.login_date}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;"><i class="fa-solid fa-circle" style="color: #ee2c2c; font-size:18px;"></i> ออฟไลน์เมื่อ ${Math.round(count_time)} นาทีที่แล้ว</td>`;
                    }
                } else {
                    row.innerHTML = `<td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${start++}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.user_id}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.email}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.name}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;">${rowd.login_date}</td>
                                     <td scope="row" style="color:#9C9C9C; text-align: left; padding: 20px 8px 20px;"><i class="fa-solid fa-circle" style="color: rgb(193, 193, 193); font-size:18px;"></i> ออฟไลน์</td>`;

                }
                tableBody.appendChild(row);
            
  
                // console.log(rowd.user_id.length);
           
        });

    }
    

    // fetchStatus();
    const timer = setInterval(fetchStatus, 2000);

    /* setTimeout(() => {
        clearInterval(timer);
        console.log("หยุดการทำงานของ Interval");
    }, 6000);   */



    </script>

{{--     <script>

setInterval(() => {
  


    let userData = {
        userId: 1,
        username: "john_doe",
        status: "offline"
        };

        // อัปเดตค่าเดิม
        userData.status = "online";
        console.log(userData);

    }, 3000);
    </script>
 --}}
</body>
</html>