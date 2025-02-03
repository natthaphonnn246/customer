<?php

    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\UserController;
    use App\Exports;
    use App\Http\Controllers\ProvinceController;
    use App\Http\Controllers\Webpanel\WebpanelCustomerController;
    use App\Http\Controllers\Portal\PortalCustomerController;
    use App\Http\Controllers\SettingController;
    use App\Http\Controllers\SaleareaController;
    use App\Http\Controllers\DashboardController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Middleware\EnsureUserHasRole;
    use App\Models\Customer;
use App\Models\Salearea;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

    Route::get('/', function () {
        return view('auth.login-tailwind');
    });

    Route::get('/signin', function () {
        return view('portal/portal-sign');
    })->middleware('auth', 'status','maintenance');
    Route::get('/signin', [PortalCustomerController::class, 'portalSign'])->middleware('auth', 'status','maintenance')->name('portal.sign');

    Route::get('/portal/portal-sign/update-amphure', [ProvinceController::class, 'amphure']);
    Route::get('/portal/portal-sign/update-district', [ProvinceController::class, 'district']);
    Route::get('/portal/portal-sign/update-zipcode', [ProvinceController::class, 'zipcode']);


    Route::get('login', function () {
        return view('auth.login-tailwind');
    });

   Route::get('/dashboard', function () {
        return view('dashboard');
        })->middleware(['auth', 'role','status','rights_area', 'verified'])->name('dashboard'); 

    //webpanel routes;
    Route::middleware('auth', 'role','status', 'verified')->group(function () {

        // Route::get('webpanel', [UserController::class, 'admin'])->name('webpanel');

        Route::get('/webpanel', function () {
            return view('webpanel/dashboard');
        });

        Route::get('/webpanel', [DashboardController::class, 'index'])->name('webpanel');
    
        Route::get('/webpanel/admin', function () {
            return view('webpanel/admin');
        });
    
        Route::get('/webpanel/customer', function () {
            return view('webpanel/customer');
        });
    
        Route::get('/webpanel/admin-create', function () {
            return view('webpanel/admin-create');
        });
    
        Route::get('/webpanel/customer/customer-create', function () {
            return view('webpanel/customer-create');
        });

        Route::get('/webpanel/customer/groups-customer', function () {
            return view('webpanel/groups-customer');
        });

        Route::get('/webpanel/customer/importcustomer', function () {
            return view('webpanel/importcustomer');
        });
/* 
        Route::get('/webpanel/customer/customer-completed', function () {
            return view('webpanel/customer-completed');
        });

        Route::get('/webpanel/customer/customer-waiting', function () {
            return view('webpanel/customer-waiting');
        });

        Route::get('/webpanel/customer/customer-action', function () {
            return view('webpanel/customer-action');
        });

        Route::get('/webpanel/customer/update-latest', function () {
            return view('webpanel/update-latest');
        });

        Route::get('/webpanel/customer/customer-inactive', function () {
            return view('webpanel/customer-inactive');
        }); */

        Route::get('/webpanel/sale/importsale', function () {
            return view('webpanel/importsale');
        });

        Route::post('/webpanel/customer/importcsv',[WebpanelCustomerController::class, 'importFile']);
        Route::post('/webpanel/sale/importcsv',[SaleareaController::class, 'importFile']);

        Route::post('/webpanel/admin/status-check', [UserController::class,'statusAct']);
        Route::post('/webpanel/admin/status-inactive', [UserController::class,'statusiAct']);
        Route::get('/webpanel/admin', [UserController::class,'userData'])->name('wbpanel-status');

        //webpanel for admin-detail;
        Route::get('/webpanel/admin/{id}', [UserController::class, 'edit']);

        Route::post('/webpanel/customer-create/insert', [WebpanelCustomerController::class, 'create']);
        //webpanel customer edit view;
        Route::get('/webpanel/customer/{id}', [WebpanelCustomerController::class, 'edit']);
        //webpanel uploade image;
        Route::post('/webpanel/customer-detail/upload-store/{id}', [WebpanelCustomerController::class, 'certStore']);
        Route::post('/webpanel/customer-detail/upload-medical/{id}', [WebpanelCustomerController::class, 'certMedical']);
        Route::post('/webpanel/customer-detail/upload-commerce/{id}', [WebpanelCustomerController::class, 'certCommerce']);
        Route::post('/webpanel/customer-detail/upload-vat/{id}', [WebpanelCustomerController::class, 'certVat']);
        Route::post('/webpanel/customer-detail/upload-id/{id}', [WebpanelCustomerController::class, 'certId']);

         //user create;
        Route::post('/webpanel/admin-create/insert', [UserController::class, 'create']);

        //user update;
        Route::post('/webpanel/admin-detail/update/{id}', [UserController::class, 'update']);
        //reset password;
        Route::post('/webpanel/admin-detail/reset/{id_reset}', [UserController::class, 'reset']);

        //webpanel for admin;
        Route::get('/webpanel/admin-create/', [ProvinceController::class, 'index']);
        Route::get('/webpanel/admin-create/update-amphure', [ProvinceController::class, 'amphure']);
        Route::get('/webpanel/admin-create/update-district', [ProvinceController::class, 'district']);
        Route::get('/webpanel/admin-create/update-zipcode', [ProvinceController::class, 'zipcode']);

        //webpanel for customer-create;
        Route::get('/webpanel/customer/customer-create', [WebpanelCustomerController::class, 'customerCreate']);
        Route::get('/webpanel/customer-create/update-amphure', [ProvinceController::class, 'amphure']);
        Route::get('/webpanel/customer-create/update-district', [ProvinceController::class, 'district']);
        Route::get('/webpanel/customer-create/update-zipcode', [ProvinceController::class, 'zipcode']);
        Route::get('/webpanel/customer-create/update-geography', [ProvinceController::class, 'geographies']);

        Route::get('webpanel/customer/groups-customer', [WebpanelCustomerController::class, 'groupsCustomer']);

        Route::get('/webpanel/customer', function() {
            return view('webpanel/customer');
        });

        Route::get('/webpanel/customer-sign', function() {
            return view('webpanel/customer-create');
        });

        Route::get('/webpanel/setting', function() {
            return view('webpanel/setting');
        });

        // Route::get('webpanel', [UserController::class, 'admin'])->name('webpanel');

        //update settings;
        Route::post('/webpanel/setting/update-setting', [SettingController::class, 'maintenanceWeb']);
        //index settings;
        Route::get('/webpanel/setting', [SettingController::class, 'index']);

        //sale area;
        Route::get('/webpanel/sale', function() {
            return view('webpanel/sale');
        });

         //sale area created;
        Route::get('/webpanel/sale-create', function() {
            return view('webpanel/sale-create');
        });

        Route::post('/webpanel/sale-create/insert', [SaleareaController::class, 'create']);

        Route::get('/webpanel/sale', [SaleareaController::class, 'index']);

        Route::get('/webpanel/sale/{id}', [SaleareaController::class, 'viewSale']);

        Route::post('/webpanel/sale-detail/update/{id}', [SaleareaController::class, 'edit']);

        //status customer actinve or inactinve;
        Route::post('/webpanel/customer/status-active', [WebpanelCustomerController::class, 'statusAct']);
        Route::post('/webpanel/customer/status-inactive', [WebpanelCustomerController::class, 'statusiAct']);

        //export customer -> getexcel;
        Route::get('/webpanel/customer/export/getexcel/{status}', [WebpanelCustomerController::class, 'exportCustomerExcel']);
 
        //export customer -> getcsv;
        Route::get('/webpanel/customer/export/getcsv/{status}', [WebpanelCustomerController::class, 'exportCustomerCsv']);

        //export customer_detail -> getcsv;
        Route::get('/webpanel/customer/getcsv/{customer_id}', [WebpanelCustomerController::class, 'getCustomerCsv']);
 

    });

    Route::get('/webpanel/customer/export/getcsv/{status}', [WebpanelCustomerController::class, 'exportCustomerCsv']);

    //update groups customer;
    Route::post('/webpanel/customer/groups-customer/updatadmin/{sale_area}', [WebpanelCustomerController::class, 'updateAdminarea']);

    // Route::get('/webpanel/customer/importcustomer',[CustomerController::class, 'importFile']);
   

    //customer view table;
    Route::get('/webpanel/customer', [WebpanelCustomerController::class, 'index'])->middleware('auth', 'role','status', 'verified');
    //webpanel/customer/status/{status_check};
    Route::get('/webpanel/customer/status/{status_check}', [WebpanelCustomerController::class, 'indexStatus'])->middleware('auth', 'role','status', 'verified');


    //webpanel customer update;
    Route::post('/webpanel/customer-detail/update/{id}', [WebpanelCustomerController::class, 'update'])->middleware('auth', 'role','status', 'verified');

    Route::get('/portal/signin/update-amphure', [ProvinceController::class, 'amphure']);
    Route::get('/portal/signin/update-district', [ProvinceController::class, 'district']);
    Route::get('/portal/signin/update-zipcode', [ProvinceController::class, 'zipcode']);

    //portal;
    Route::middleware('auth','role', 'userRole', 'status', 'verified', 'maintenance', 'rights_area')->group(function () {

        // Route::get('/portal/signin', [CustomerController::class, 'indexPortal']);
       /*  Route::get('/portal/signin/update-amphure', [ProvinceController::class, 'amphure']);
        Route::get('/portal/signin/update-district', [ProvinceController::class, 'district']);
        Route::get('/portal/signin/update-zipcode', [ProvinceController::class, 'zipcode']); */
/* 
        Route::get('/portal', function () {
            return view('portal/portal-sign');
        }); */


        Route::get('/portal/signin', function () {
        return view('portal/signin');
        });
    
    });

  /*   Route::get('/portal/signin', function () {
        return view('portal/portal-sign');
        }); */

    //create customer;
    Route::post('/portal/portal-sign/create', [PortalCustomerController::class, 'signin']);

    //create customer;
    Route::post('/portal/signin/create', [PortalCustomerController::class, 'signin']);

    //portal-sign;
    Route::middleware('auth', 'userRole', 'status', 'verified', 'maintenance', 'rights_area')->group(function () {

        // Route::get('/portal/portal-sign', [CustomerController::class, 'indexPortal']); //portalSign;
        Route::get('/portal/signin', [PortalCustomerController::class, 'indexPortal'])->name('portal'); //portalSign
    /*     Route::get('/portal/portal-sign/update-amphure', [ProvinceController::class, 'amphure']);
        Route::get('/portal/portal-sign/update-district', [ProvinceController::class, 'district']);
        Route::get('/portal/portal-sign/update-zipcode', [ProvinceController::class, 'zipcode']);
 */

        //not right_area;
        // Route::get('/portal', [CustomerController::class, 'portalSign'])->name('portal.sign');

        //portal uploade image;
        Route::post('/portal/customer-detail/upload-store/{id}', [PortalCustomerController::class, 'certStore']);
        Route::post('/portal/customer-detail/upload-medical/{id}', [PortalCustomerController::class, 'certMedical']);
        Route::post('/portal/customer-detail/upload-commerce/{id}', [PortalCustomerController::class, 'certCommerce']);
        Route::post('/portal/customer-detail/upload-vat/{id}', [PortalCustomerController::class, 'certVat']);
        Route::post('/portal/customer-detail/upload-id/{id}', [PortalCustomerController::class, 'certId']);

        //customer update customer-detail;
        Route::post('/portal/customer-detail/update/{id}', [PortalCustomerController::class, 'updateEdit']);
    });
    
    //delete customer;
    Route::get('/webpanel/customer/delete/{customer_code}', [WebpanelCustomerController::class, 'deleteCustomer']);

    //delete admin;
    Route::get('/webpanel/admin/delete/{user_code}', [WebpanelCustomerController::class, 'deleteAdmin']);

    //delete sale_area;
    Route::get('/webpanel/sale/delete/{sale_area}', [WebpanelCustomerController::class, 'deleteSalearea']);

    //portal customer;
    Route::get('/portal/customer', [PortalCustomerController::class, 'customerView'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area')->name('portal.customer');
    Route::get('/portal/customer/status/{status_customer}', [PortalCustomerController::class, 'customerViewEdit'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area');

    Route::get('/portal/customer/{id}', [PortalCustomerController::class, 'customerEdit'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea', 'rights_area');
    
    ///search customer;
    Route::get('/portal/customer/search/code', [PortalCustomerController::class, 'customerSearch'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area');
    // Route::get('/portal/customer/search/code', [PortalCustomerController::class, 'customerKeyword'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area');
  /*   Route::get('/webpanel/date', function() {
        return view('webpanel/date');
    }); */
   /*  Route::get('/logintail', function() {
        return view('auth/login-tailwind');
    }); */

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';
