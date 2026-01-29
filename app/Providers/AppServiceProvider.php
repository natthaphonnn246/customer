<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $check_type_pass = 0;
            $code_pass = 0;
    
            if (Auth::check()) {
                $setting_check = Setting::where('setting_id', 'WS01')->value('check_type');
                $user = Auth::user();
                $code_type = User::where('user_id', $user->user_id)->value('allowed_check_type');
    
                if ((int)$setting_check === 1) {
                    if ((int)$code_type === 1) {
                        $check_type_pass = 1;
                        $code_pass = 1;
                    }
                } else {
    
                    $check_type_pass = 1;
                    $code_pass = 1;
                }
            }
    
            $view->with(compact('check_type_pass', 'code_pass'));
        });

        if (request()->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
        }
    }
}
