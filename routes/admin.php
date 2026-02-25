<?php
    use App\Exports\CustomerExcelExport;
    use App\Exports\CustomerAreaExport;
    use App\Exports\CustomerCsvExport;
    use App\Http\Controllers\ProvinceController;
    use App\Http\Controllers\Portal\PortalCustomerController;
    use App\Http\Controllers\Webpanel\WebpanelAdminController;
    use Illuminate\Support\Facades\Route;


Route::middleware('statusOnline', 'block.ai')->group(function (){

    //admin for reports;
    Route::middleware('auth', 'status','maintenance', 'adminRole', 'verified')->group(function () {
        Route::get('/admin/register', [PortalCustomerController::class, 'registerByAdmin'])->middleware('auth', 'status','maintenance')->name('admin.register');

        Route::get('/admin', [WebpanelAdminController::class, 'newDashboard'])->name('admin.report');
        Route::get('/admin/customer', [WebpanelAdminController::class, 'indexCustomer'])->name('admim.customer');
        Route::get('/admin/customer/{slug}', [WebpanelAdminController::class, 'edit']);
        Route::get('/admin/customer/status/{status_check}', [WebpanelAdminController::class, 'indexStatus']);
        Route::get('/admin/customer/export/getcsv/{status}', [CustomerCsvExport::class, 'exportCustomerCsv']);
        Route::get('/admin/customer/export/getexcel/{status}', [CustomerExcelExport::class, 'exportCustomerExcel']);
        Route::get('/admin/customer/status/{status_check}', [WebpanelAdminController::class, 'indexStatus']);
        Route::get('/admin/customer/adminarea/{admin_id}', [WebpanelAdminController::class, 'indexAdminArea']);
        Route::get('/admin/customer/adminarea/{admin_id}/{status}', [WebpanelAdminController::class, 'indexAdminArea']);
        Route::get('/admin/customer/export/getexcel/{status}/{admin_id}', [CustomerAreaExport::class, 'exportCustomerAreaExcel']);
        Route::get('/admin/customer/export/getcsv/{status}/{admin_id}', [CustomerAreaExport::class, 'exportCustomerAreaCsv']);
        Route::get('/admin/customer/adminarea/{admin_id}/{status}', [WebpanelAdminController::class, 'indexAdminArea']);
        Route::get('/admin/customer-create/update-amphure', [ProvinceController::class, 'amphure']);
        Route::get('/admin/customer-create/update-district', [ProvinceController::class, 'district']);
        Route::get('/admin/customer-create/update-zipcode', [ProvinceController::class, 'zipcode']);
        Route::get('/admin/customer-create/update-geography', [ProvinceController::class, 'geographies']);

        //update
        Route::put('/admin/customer-detail/update/{customer:slug}', [WebpanelAdminController::class, 'updateEdit'])->name('admin.customer.update');
    });

});


