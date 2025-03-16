<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
 {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}

    @vite('resources/css/app.css')
    <title>cms.vmdrug</title>
</head>

<style>
    body{
        font-family: 'Prompt', sans-serif;
    }
    li {
        font-size: 15px;
    }
    #loginTail {
      background-color: rgb(0, 94, 255);
      color: white;
      font-size: 16px;
    }
    #loginTail:hover {
      background-color: rgb(10, 80, 202);
      color: white;
      font-size: 16px;
    }
</style>
<body>


    <section class="bg-gray-50" style="background-color:rgb(223, 223, 223);">
        <div class="flex flex-col items-center justify-center px-6 py-6 mx-auto md:h-screen lg:py-0" text>
            {{-- <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
                nntpn.com   
            </a> --}}
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:border-gray-700" style="background-color:rgb(255, 255, 255);">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl text-center dark:text-white" style="font-weight:500;">
                         <div style="margin-right:60px; margin-left:60px;">
                            <img style="width:100%;" src="/profile/cmsvmdrugpng copy.png">
                         </div>
                        
                        {{-- <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo"> --}}
                        {{-- <span style="color:black;">CMS</span>  --}}
                    </h1>
                    <form class="space-y-4 md:space-y-6" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div>
                            <label for="email"  class="block mb-2 text-sm text-gray-900 dark:text-black" style="font-weight:300; font-size: 16px;">อีเมล</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 font-regular rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" style="font-weight:300;" placeholder="" required="">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm text-gray-900 dark:text-black" style="font-weight:300; font-size: 16px;">รหัสผ่าน</label>
                            <input type="password" name="password" id="password" placeholder="" class="bg-gray-50 border border-gray-300 font-regular text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-white-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500" style="font-weight:300;" placeholder="" required="">
                        </div>
                        {{-- <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                  <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                                </div>
                                <div class="ml-3 text-sm">
                                  <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                                </div>
                            </div>
                            <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot password?</a>
                        </div> --}}
                        <ul class="text-center">
                            <button type="submit" class="w-full text-white bg-primary-400 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" id="loginTail" style="width:100px;">Login</button>
                        </ul>
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400 text-center">
                            &copy; 2025 cms.vmdrug.co.th All rights reserved
                        </p>
                    </form>
                </div>
            </div>
        </div>
      </section>
    
      <script>

      </script>
</body>
</html>
  