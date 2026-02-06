@extends ('layouts.webpanel')
@section('content')

    <div class="contentArea w-full max-w-full break-words">
          
        <div class="py-2"></div>
        <h5 class="!text-gray-600 font-semibold ms-6">สถานะเข้าใช้งานแบบอนุญาตขายยา</h5>
        <hr class="my-3 !text-gray-400 !border">

        <div class="mx-8 mb-2 overflow-x-auto">

            <table class="table table-striped" id="type-table">
                <thead>
                    <tr>
                        <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">#</td>
                        <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">CODE</td>
                        <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">อีเมล</td>
                        <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">ชื่อ</td>
                        <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">เข้าระบบล่าสุด</td>
                        <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">IP Address</td>
                        <td scope="col" class="!text-gray-500 text-left p-3 font-semibold">สถานะ</td>
                    </tr>
                </thead>
                <tbody>
                    <!-- JSON Data will be inserted here -->
                </tbody>
            </table>
        </div>

        <div class="py-2"></div>
    </div>

    {{-- {{$date}} --}}
@endsection

    <script>

     async function fetchStatus() {
        const response = await fetch('/webpanel/type-active/updated');
        const data =  await response.json();
        // console.log(data.user);

        const data_row = data.user;

        const tableBody = document.querySelector("#type-table tbody");
        // console.log(data.date);

        const check_timer = data.check_type_time;
        console.log(check_timer);

        let start = 1;
        //เคลียร์ตาราง;
        tableBody.innerHTML = "";
        data_row.forEach(rowd => {

            const lastActivity = Date.parse(rowd.last_activity) / 1000;
            const count_time = (data.date.date - lastActivity)/60;

            console.log(count_time);


            const row = document.createElement("tr");
        
                if(data.date.date - lastActivity < check_timer) {

                    // console.log('pass');

                 
                        row.innerHTML = `<td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${start++}</td>
                                     <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.user_id}</td>
                                     <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.email}</td>
                                     <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.user_name}</td>
                                     <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.login_date}</td>
                                     <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.ip_address}</td>
                                     <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500"><i class="fa-solid fa-circle" style="color: #03ae3f; font-size:18px;"></i> ออนไลน์</td>`;
                    
                   
                
                } else if (count_time < 59) {

                    row.innerHTML = `<td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${start++}</td>
                                        <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.user_id}</td>
                                        <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.email}</td>
                                        <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.user_name}</td>
                                        <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.login_date}</td>
                                        <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.ip_address}</td>
                                        <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500"><i class="fa-solid fa-circle" style="color: #ee2c2c; font-size:18px;"></i> ออฟไลน์เมื่อ ${Math.round(count_time)} นาทีที่แล้ว</td>`;
                } else {
                    row.innerHTML = `<td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${start++}</td>
                                     <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.user_id}</td>
                                     <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.email}</td>
                                     <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.user_name}</td>
                                     <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.login_date}</td>
                                     <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500">${rowd.ip_address}</td>
                                     <td scope="row" class="text-gray-400 text-left px-3 py-4 !text-gray-500"><i class="fa-solid fa-circle" style="color: rgb(193, 193, 193); font-size:18px;"></i> ออฟไลน์</td>`;

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