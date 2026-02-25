<?php
    
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\LineController;

    Route::get('/', function () {
        return redirect()->route('login');
    });    
    
    Route::middleware('statusOnline', 'block.ai')->group(function (){

        //recaptcah v-2;
        // Route::post('/', [RecaptchaV2::class, 'reCaptcha']);

        Route::get('login', function () {
            return view('auth.login-tailwind');
        });

        //messaging API LineOA
        Route::post('/line/connect', [LineController::class, 'connectLine'])->name('portal.line.connect');

        //logout line revoktoken
        Route::post('/webpanel/line/revoke-token/user',[LineController::class, 'revokeLineToken'])->name('line.revoktoken.admin');

        //logout line revoktoken ออกจากระบบทั้งหมด
        Route::post('/webpanel/line/revoke-token/all',[LineController::class, 'revokeAllLineTokens'])->name('line.revoktoken.all');
    });

    require __DIR__.'/auth.php';
