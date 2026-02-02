<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'CMS')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('cms-v1.ico') }}">
    {{-- Fonts --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    {{-- jQuery + UI (โหลดครั้งเดียว) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

    {{-- Sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        #bgs {
            position: fixed;
            inset: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(78, 78, 78, 0.6);
            display: none;
            z-index: 800;
            align-items: center;
            justify-content: center;
        }
        .swal2-container {
            z-index: 1050;
        }
        #ui-datepicker-div {
            z-index: 900 !important;
        }

    </style>
    @stack('styles')
</head>

<body class="bg-light" style="font-family: 'prompt';">
    <div id="bgs">
        {{-- <div class="loading">Loading...</div> --}}
    </div>
{{-- @include('components.admin-sidebar')

<main class="content-wrapper p-3 p-md-4 bg-gray-100">
    <div class="bg-white mt-14 md:mt-1">
        @yield('content')
    </div>
   
</main>
 --}}
<x-admin-sidebar
{{--     :status-alert="$status_alert ?? 0"
    :status-all="$status_all ?? 0"
    :status-waiting="$status_waiting ?? 0"
    :status-action="$status_action ?? 0"
    :status-completed="$status_completed ?? 0" --}}
    :user-name="$user_name->name ?? 'ไม่ระบุ'"
>
</x-admin-sidebar>

<main class="content-wrapper p-3 p-md-4 bg-gray-100">
    <div class="bg-white mt-14 md:mt-1">
        @yield('content')
    </div>
   
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- @if (session('swal'))
    <script>
    Swal.fire(@json(session('swal')));
    </script>
@endif --}}

@stack('scripts')
</body>
</html>
