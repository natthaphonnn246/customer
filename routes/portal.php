<?php
    use App\Http\Controllers\ProvinceController;
    use App\Http\Controllers\Portal\PortalCustomerController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProductTypeController;
    use App\Http\Controllers\LineController;

//middleware statusOnline;
Route::middleware('statusOnline', 'block.ai')->group(function (){

    Route::get('/signin', [PortalCustomerController::class, 'portalSign'])->middleware('auth', 'status','maintenance')->name('portal.sign');

    Route::get('/portal/portal-sign/update-amphure', [ProvinceController::class, 'amphure']);
    Route::get('/portal/portal-sign/update-district', [ProvinceController::class, 'district']);
    Route::get('/portal/portal-sign/update-zipcode', [ProvinceController::class, 'zipcode']);
    
    Route::get('/portal/signin/update-amphure', [ProvinceController::class, 'amphure']);
    Route::get('/portal/signin/update-district', [ProvinceController::class, 'district']);
    Route::get('/portal/signin/update-zipcode', [ProvinceController::class, 'zipcode']);

    //create customer;
    Route::post('/portal/portal-sign/create', [PortalCustomerController::class, 'signin']);

    //create customer;
    Route::post('/portal/signin/create', [PortalCustomerController::class, 'signin']);

    //portal-sign;
    Route::middleware('auth', 'userRole', 'status', 'verified', 'maintenance', 'rights_area', 'checkMenu')->group(function () {

        Route::get('/portal/signin', [PortalCustomerController::class, 'indexPortal'])->name('portal'); //portalSign
        Route::get('/portal/dashboard',[PortalCustomerController::class , 'dashboardCharts']);

    });

    Route::name('portal.')->prefix('portal')->middleware('auth', 'userRole', 'status', 'verified', 'maintenance', 'rights_area')->group(function () {
        Route::name('customer-detail.')->prefix('customer-detail')->group(function () {
                    Route::post('/upload-store/{id}', [PortalCustomerController::class, 'certStore']);
                    Route::post('/upload-medical/{id}', [PortalCustomerController::class, 'certMedical']);
                    Route::post('/upload-commerce/{id}', [PortalCustomerController::class, 'certCommerce']);
                    Route::post('/upload-vat/{id}', [PortalCustomerController::class, 'certVat']);
                    Route::post('/upload-id/{id}', [PortalCustomerController::class, 'certId']);
                    Route::post('/update/{id}', [PortalCustomerController::class, 'updateEdit']);
                });
    });

    Route::get('/portal/customer', [PortalCustomerController::class, 'customerView'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'purReport', 'checkMenu')->name('portal.customer');
    Route::get('/portal/customer/status/{status_customer}', [PortalCustomerController::class, 'customerViewEdit'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'checkMenu');

    //fetch; 'purReport'
    Route::post('/portal/customer/purchase', [PortalCustomerController::class, 'purchaseOrder'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'CheckPurReport', 'checkMenu');

    //purchase;
    Route::get('/portal/customer/purchase/{fixed_id}', [PortalCustomerController::class, 'fixedDate'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'CheckPurReport', 'checkMenu');
    
    // resource
    Route::get('/portal/customer/{id}', [PortalCustomerController::class, 'customerEdit'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea', 'maintenance', 'rights_area', 'CustomerDetailCheck', 'checkMenu');

    ///search customer;
    Route::get('/portal/customer/search/code', [PortalCustomerController::class, 'customerSearch'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'checkMenu');

    //type แบบอนุญาตขายยา ข.ย.2;
    Route::get('/portal/product-type', [PortalCustomerController::class, 'protalIndexType'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'checkMenu')
        ->name('portal.product-type');

    Route::get('/portal/product-type/khor-yor-2/{cate_id?}', [PortalCustomerController::class, 'protalTypeKhoryor'])
        ->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'confirmType', 'allowedType', 'checkMenu');

    Route::get('/portal/product-type/somphor-2/{cate_id?}', [PortalCustomerController::class, 'protalTypeSomphor'])
        ->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'confirmType', 'allowedType', 'checkMenu');

    //check pass ;
    Route::post('/portal/product-type/check-password',[ProductTypecontroller::class, 'checkLiceseType'])
        ->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'checkMenu');

    //limited-sales;
    Route::get('/portal/limited-sales',[ProductTypecontroller::class, 'limitedSale'])
        ->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'checkMenu');

    //customer-type;
    Route::get('/portal/customer-type',[ProductTypecontroller::class, 'customerType'])
        ->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'checkMenu');
});

// require __DIR__.'/auth.php';

// โค้ดนี้จะเหมือนกับโค้ดข้างบนเลยครับ ตั้งแต่บรรทัดที่ 462-483
//  - name('portal.') คือ ชื่อตอนเราใช้ {{ route('portal.')}}
//  - prefix('portal') คือ path เราจะขึ้นต้นด้วย /portal/
//  - middleware('auth', 'userRole', 'status', 'verified', 'maintenance', 'rights_area') ก็สามารถต่อรวมกันได้เลย

// Route::name('portal.')->prefix('portal')->middleware('auth', 'userRole', 'status', 'verified', 'maintenance', 'rights_area')->group(function () {
//     Route::get('/signin', [PortalCustomerController::class, 'indexPortal'])->name('portal'); ตรงนี้เวลาเรียกใช้ เอา prefix('') กับ ->name('') มาต่อกัน {{ route('portal.portal')}}

//     Route::name('customer-detail.')->prefix('customer-detail')->group(function () {
//         Route::post('/upload-store/{id}', [PortalCustomerController::class, 'certStore']);
//         Route::post('/upload-medical/{id}', [PortalCustomerController::class, 'certMedical']);
//         Route::post('/upload-commerce/{id}', [PortalCustomerController::class, 'certCommerce']);
//         Route::post('/upload-vat/{id}', [PortalCustomerController::class, 'certVat']);
//         Route::post('/upload-id/{id}', [PortalCustomerController::class, 'certId']);
//         Route::post('/update/{id}', [PortalCustomerController::class, 'updateEdit']);
//     });
// });
