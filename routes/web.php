<?php

    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\ProvinceController;
    use App\Http\Controllers\CustomerController;
    use App\Http\Controllers\AdminController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Middleware\EnsureUserHasRole;
    use Illuminate\Support\Facades\DB;
 
    /* Route::get('/portals', function (string $id) {
        // ...
    })->middleware(['check:A02']);
 */
    Route::get('/', function () {
        return view('auth.login');
    });

    Route::get('login', function () {
        return view('welcome');
    });

   Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'role','status','rights_area', 'verified'])->name('dashboard'); 

    Route::get('/webpanel', function () {
        return view('webpanel/dashboard');
    })->middleware('auth', 'role','status', 'verified');

    Route::get('/webpanel/admin', function () {
        return view('webpanel/admin');
    })->middleware('auth', 'role', 'status', 'verified');

    Route::get('/webpanel/customer', function () {
        return view('webpanel/customer');
    })->middleware('auth', 'role', 'status', 'verified');

    Route::get('/webpanel/admin-create', function () {
        return view('webpanel/admin-create');
    })->middleware('auth', 'role','status', 'verified');

    Route::get('/webpanel/customer-create', function () {
        return view('webpanel/customer-create');
    })->middleware('auth', 'role','status', 'verified');

    Route::get('webpanel', [UserController::class, 'admin'])->middleware('auth', 'role','status', 'rights_area', 'verified')->name('webpanel');
    Route::get('/portal', function () {
        return view('portal/dashboard');
    })->middleware('auth', 'role','status','rightsArea', 'verified');
    Route::get('/portal/signin', function () {
        return view('portal/signin');
    })->middleware('auth', 'status', 'verified');


    Route::put('/post/{id}', function (string $id) {
        // ...
    })->middleware(EnsureUserHasRole::class.':editor');

    
    /* $admin = 'A02';
    Route::get('portal', [UserController::class, 'portalSignin'])->middleware('auth','userRole', 'status', 'verified' , 'admin_01:'.$admin)->name('portal'); */
    Route::get('portal', [UserController::class, 'portalSignin'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea')->name('portal');
    // Route::get('portal/test', [UserController::class, 'portalTest'])->middleware('auth','userRole', 'status', 'verified')->name('test');
    //status check admin;
    Route::post('/webpanel/admin/status-check', [UserController::class,'statusAct'])->middleware('auth', 'role','status', 'verified');

    Route::post('/webpanel/admin/status-inactive', [UserController::class,'statusiAct'])->middleware('auth', 'role','status', 'verified');

    // Route::get('/webpanel/admin', [UserController::class,'adminCheck'])->middleware('auth', 'role','status', 'verified')->name('wbpanel-status');
    Route::get('/webpanel/admin', [UserController::class,'userData'])->middleware('auth', 'role','status', 'verified')->name('wbpanel-status');

    //webpanel for admin;
    Route::get('/webpanel/admin-create/', [ProvinceController::class, 'index']);
    Route::get('/webpanel/admin-create/update-amphure', [ProvinceController::class, 'amphure']);
    Route::get('/webpanel/admin-create/update-district', [ProvinceController::class, 'district']);
    Route::get('/webpanel/admin-create/update-zipcode', [ProvinceController::class, 'zipcode']);

    //webpanel for customer-create;
    Route::get('/webpanel/customer-create', [ProvinceController::class, 'customerCreate']);
    Route::get('/webpanel/customer-create/update-amphure', [ProvinceController::class, 'amphure']);
    Route::get('/webpanel/customer-create/update-district', [ProvinceController::class, 'district']);
    Route::get('/webpanel/customer-create/update-zipcode', [ProvinceController::class, 'zipcode']);

    //webpanel for admin-detail;
    Route::get('/webpanel/admin/{id}', [UserController::class, 'edit'])->middleware('auth', 'role','status', 'verified');

    //portal;
    Route::get('/portal/signin', [ProvinceController::class, 'indexPortal'])->middleware('auth','userRole', 'status');
    Route::get('/portal/signin/update-amphure', [ProvinceController::class, 'amphure']);
    Route::get('/portal/signin/update-district', [ProvinceController::class, 'district']);
    Route::get('/portal/signin/update-zipcode', [ProvinceController::class, 'zipcode']);

    //portal customer;
    Route::get('/portal/customer', [UserController::class, 'portalSignin'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea', 'rights_area');
    //admin create;
    // Route::post('/webpanel/admin-create/insert', [AdminController::class, 'create']);

    //user create;
     Route::post('/webpanel/admin-create/insert', [UserController::class, 'create']);

     //user update;
     Route::post('/webpanel/admin-detail/update/{id}', [UserController::class, 'update']);
     //reset password;
     Route::post('/webpanel/admin-detail/reset/{id_reset}', [UserController::class, 'reset']);

     //admin-role;
   /*   Route::get('/webpanel/admin-role', function() {
         return view('webpanel/admin-role');
     })->middleware('auth'); */

     //customer;
     Route::get('/webpanel/customer', function() {
         return view('webpanel/customer');
     });

     //customer view table;
     Route::get('/webpanel/customer', [CustomerController::class, 'index'])->middleware('auth', 'role','status', 'verified');
     Route::get('/webpanel/customer-sign', function() {
        return view('webpanel/customer-create');
    });

    //webpanel customer create;
    Route::post('/webpanel/customer-create/insert', [CustomerController::class, 'create'])->middleware('auth', 'role','status', 'verified');
    //webpanel customer edit view;
    Route::get('/webpanel/customer/{id}', [CustomerController::class, 'edit'])->middleware('auth', 'role','status', 'verified');
    //webpanel customer update;
    Route::post('/webpanel/customer-detail/update/{id}', [CustomerController::class, 'update']);
    //webpanel uploade image;
    Route::post('/webpanel/customer-detail/upload-store/{id}', [CustomerController::class, 'certStore']);
    Route::post('/webpanel/customer-detail/upload-medical/{id}', [CustomerController::class, 'certMedical']);
    Route::post('/webpanel/customer-detail/upload-commerce/{id}', [CustomerController::class, 'certCommerce']);
    Route::post('/webpanel/customer-detail/upload-vat/{id}', [CustomerController::class, 'certVat']);
    Route::post('/webpanel/customer-detail/upload-id/{id}', [CustomerController::class, 'certId']);

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';
