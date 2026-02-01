<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LineController;
use App\Http\Controllers\Portal\PortalCustomerController;

Route::middleware('auth:sanctum')->post('/logout/line', [LineController::class, 'logoutLine']);
Route::post('/logout/line/nottoken', [LineController::class, 'logoutLineNoToken']);
Route::post('/logout/line/fail', [LineController::class, 'logoutLineFail']);

//revoke tokens
$router->post('/webpanel/line/revoke-tokens', [LineController::class, 'revokeAllLineTokens']);

Route::post('/status/register', [PortalCustomerController::class, 'signin']);

//line
// $router->post('/line/connect', [PromoController::class, 'connectLine']);
