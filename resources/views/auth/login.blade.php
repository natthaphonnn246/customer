<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            
            <img src="/profile/logo.jpeg" class="img-fluid">
            <hr style="color:rgb(95, 95, 95);">
            @if (Session::has('error_login'))
            <div class="alert alert-danger my-2"><i class="fa-solid fa-circle-xmark" style="color: rgb(172, 27, 27);"></i> {{ Session::get('error_login') }}</div>
            @endif
            <x-input-label for="email" :value="__('Email')" style="font-family: 'Prompt', sans-serif;" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"  style="font-family: 'Prompt', sans-serif; font-size:15px;" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" style="font-family: 'Prompt', sans-serif;" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
       {{--  <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div> --}}

        <div class="flex items-center justify-center mt-4">

        <!-- reset password -->
         {{--    @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif --}}

            <x-primary-button class="ms-3" style="background-color: rgb(26, 60, 229); font-family: 'Prompt', sans-serif;">
                {{ __('Log in') }}
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>

