<?php
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\UserController;
    use App\Exports;
    use Illuminate\Http\Request;
    use App\Models\User;
    use App\Exports\CustomerExcelExport;
    use App\Exports\CustomerAreaExport;
    use App\Exports\CustomerCsvExport;
    use App\Exports\SellerCsvExport;
    use App\Exports\ProductCsvExport;
    use App\Exports\ProductExcelExport;
    use App\Exports\SellerExcelExport;
    use App\Exports\RegionSalesCsvExport;
    use App\Exports\RegionSalesExcelExport;
    use App\Exports\RegionProductCsvExport;
    use App\Exports\RegionProductExcelExport;
    use App\Http\Controllers\ProvinceController;
    use App\Http\Controllers\Webpanel\WebpanelCustomerController;
    use App\Http\Controllers\Portal\PortalCustomerController;
    use App\Http\Controllers\Webpanel\WebpanelAdminController;
    use App\Http\Controllers\SettingController;
    use App\Http\Controllers\SaleareaController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\LogStatusController;
    use App\Http\Controllers\ReportSellerController;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\SubcategoryController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Middleware\EnsureUserHasRole;
    use App\Imports\SellersImport;
    use App\Models\Customer;
    use App\Models\Salearea;
    use App\Http\Controllers\ImportController;
    use App\Http\Controllers\ImportCsvController;
    use App\Http\Controllers\RecaptchaV2;
    use App\Models\ReportSeller;
    use Illuminate\Support\Facades\DB;
    use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
    use App\Http\Controllers\ChooseBoxController;
    use App\Http\Controllers\FdaReporterController;
    use App\Http\Controllers\StatusUpdateController;
    use App\Http\Controllers\ProductTypeController;


    // Route::get('/', function() { return view('auth.login-tailwind');})->name('login');


    Route::get('/', function () {
        return view('auth.login-tailwind');
    });

    //recaptcah v-2;
    // Route::post('/', [RecaptchaV2::class, 'reCaptcha']);

    //middleware statusOnline;
Route::middleware('statusOnline')->group(function (){
    
    Route::get('/signin', function () {
        return view('portal/portal-sign');
    })->middleware('auth', 'status','maintenance');

    Route::get('/signin', [PortalCustomerController::class, 'portalSign'])->middleware('auth', 'status','maintenance')->name('portal.sign');

      //dashboard portal charts;
    Route::get('/portal/dashboard', function () {
        return view('/portal/dashboard');
    })->middleware('auth', 'status','maintenance', 'checkMenu');

    Route::get('/portal/dashboard',[PortalCustomerController::class , 'dashboardCharts'])->middleware('auth', 'status','maintenance');

    Route::get('/portal/portal-sign/update-amphure', [ProvinceController::class, 'amphure']);
    Route::get('/portal/portal-sign/update-district', [ProvinceController::class, 'district']);
    Route::get('/portal/portal-sign/update-zipcode', [ProvinceController::class, 'zipcode']);


    Route::get('login', function () {
        return view('auth.login-tailwind');
    });

    //admin for reports;
    Route::middleware('auth', 'status','maintenance', 'adminRole', 'verified')->group(function () {
        Route::get('/admin', [WebpanelAdminController::class, 'dashboard'])->name('admin.report');
        Route::get('/admin/customer', [WebpanelAdminController::class, 'indexCustomer']);
        Route::get('/admin/customer/{id}', [WebpanelAdminController::class, 'edit']);
        Route::get('/admin/customer/status/{status_check}', [WebpanelAdminController::class, 'indexStatus']);
        Route::get('/admin/customer/export/getcsv/{status}', [CustomerCsvExport::class, 'exportCustomerCsv']);
        Route::get('/admin/customer/export/getexcel/{status}', [CustomerExcelExport::class, 'exportCustomerExcel']);
        Route::get('/admin/customer/status/{status_check}', [WebpanelAdminController::class, 'indexStatus']);
        Route::get('/admin/customer/adminarea/{admin_id}', [WebpanelAdminController::class, 'indexAdminArea']);
        Route::get('/admin/customer/adminarea/{admin_id}/{status}', [WebpanelAdminController::class, 'indexAdminArea']);
        Route::get('/admin/customer/export/getexcel/{status}/{admin_id}', [CustomerAreaExport::class, 'exportCustomerAreaExcel']);
        Route::get('/admin/customer/export/getcsv/{status}/{admin_id}', [CustomerAreaExport::class, 'exportCustomerAreaCsv']);
        Route::get('/admin/customer/adminarea/{admin_id}/{status}', [WebpanelAdminController::class, 'indexAdminArea']);
    });

    //test;
  
    // Route::get('/webpanel/customer-status' , [LogStatusController::class, 'statusOnline']);
   
    // Route::get('/webpanel/customer-status' , [LogStatusController::class, 'statusOnline']);

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

        Route::get('/webpanel/customer/importcustomer', [WebpanelCustomerController::class, 'import']);

        Route::get('/webpanel/customer/updatecsv', [WebpanelCustomerController::class, 'updateView']);
        Route::post('/webpanel/customer/updatecsv/updated', [WebpanelCustomerController::class, 'updateCsv']);

        //update cause;
        Route::post('/webpanel/customer/updatecsv/customer-cause', [WebpanelCustomerController::class, 'updateCause']);
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

        Route::get('/webpanel/sale/importsale', [SaleareaController::class, 'importsale']);

        Route::post('/webpanel/customer/importcsv',[WebpanelCustomerController::class, 'importFile']);
        Route::post('/webpanel/sale/importcsv',[SaleareaController::class, 'importFile']);

        Route::post('/webpanel/admin/status-check', [UserController::class,'statusAct']);
        Route::post('/webpanel/admin/status-inactive', [UserController::class,'statusiAct']);
        Route::get('/webpanel/admin', [UserController::class,'userData'])->name('wbpanel-status');

        //is_blocked;
        Route::post('/webpanel/admin/status-unblocked', [UserController::class,'unBlocked']);
        Route::post('/webpanel/admin/status-isblocked', [UserController::class,'isBlocked']);
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

        Route::get('/webpanel/sale-create', [SaleareaController::class, 'viewCreate']);

        Route::post('/webpanel/sale-create/insert', [SaleareaController::class, 'create']);

        Route::get('/webpanel/sale', [SaleareaController::class, 'index']);

        Route::get('/webpanel/sale/{id}', [SaleareaController::class, 'viewSale']);

        Route::post('/webpanel/sale-detail/update/{id}', [SaleareaController::class, 'edit']);

        //status customer actinve or inactinve;
        Route::post('/webpanel/customer/status-active', [WebpanelCustomerController::class, 'statusAct']);
        Route::post('/webpanel/customer/status-inactive', [WebpanelCustomerController::class, 'statusiAct']);

        //export customer -> getexcel;
        Route::get('/webpanel/customer/export/getexcel/{status}', [CustomerExcelExport::class, 'exportCustomerExcel']);

        //export customer check-purchase csv;
        Route::get('/webpanel/customer/export/purchase/getexcel/{status_pur}', [CustomerExcelExport::class, 'PurchaseCustomerExcel']);

        //export customer -> getexcel;
        // Route::get('/webpanel/customer/export/getexcel/{status}/{admin_id}', [WebpanelCustomerController::class, 'exportCustomerAreaExcel']);
        Route::get('/webpanel/customer/export/getexcel/{status}/{admin_id}', [CustomerAreaExport::class, 'exportCustomerAreaExcel']);

        //export customer -> getcsv;
        Route::get('/webpanel/customer/export/getcsv/{status}', [CustomerCsvExport::class, 'exportCustomerCsv']);

        //export customer check-purchase excel;
        Route::get('/webpanel/customer/export/purchase/getcsv/{status_pur}', [CustomerCsvExport::class, 'PurchaseExoportCsv']);

        //export adminarea-detail->getcsv;
        // Route::get('/webpanel/customer/export/getcsv/{status}/{admin_id}', [WebpanelCustomerController::class, 'exportCustomerAreaCsv']);
        Route::get('/webpanel/customer/export/getcsv/{status}/{admin_id}', [CustomerAreaExport::class, 'exportCustomerAreaCsv']);

        //export customer_detail -> getcsv;
        Route::get('/webpanel/customer/getcsv/{customer_id}', [WebpanelCustomerController::class, 'getCustomerCsv']);

        //adminarea-detail;
        Route::get('/webpanel/customer/adminarea/{admin_id}', [WebpanelCustomerController::class, 'indexAdminArea']);

        //search customer;
        // Route::get('/webpanel/customer/adminarea/{admin_id}', [WebpanelCustomerController::class, 'indexAdminArea']);

        Route::get('/webpanel/customer/adminarea/{admin_id}/{status}', [WebpanelCustomerController::class, 'indexAdminArea']);

        
        //admin-status;
        // Route::get('/webpanel/customer-status' , [LogStatusController::class, 'statusOnline']);

        //test update;
        // Route::get('/webpanel/customer-status' , [LogStatusController::class, 'statusOnline']);

        Route::get('/webpanel/active-user', [LogStatusController::class, 'create']);

        Route::get('/webpanel/active-user/updated', [LogStatusController::class, 'updated']);

        /* Route::get('/webpanel/active-user/updated', function () {
            $status = time();
            return response()->json(["status" => $status]);
        }); */

        //update status-wating;
        Route::post('/webpanel/customer/update-status/wating', [WebpanelCustomerController::class, 'updateStatusWating']);

        //cache_clear;
        Route::get('/webpanel/customer/check/{cache_clear}', [WebpanelCustomerController::class, 'index']);


    });

    // Route::get('/webpanel/customer-status', [LogStatusController::class, 'create']);

/*     Route::get('/webpanel/update-status', function() {
        $date = time();
        return response()->json(['data' => $date]);
    }); */


    //report seller;
    Route::middleware('auth', 'role','status', 'verified')->group(function () {
        Route::get('/webpanel/report/seller', [ReportSellerController::class, 'index']);
        Route::get('webpanel/report/seller/importseller', [ReportSellerController::class, 'import']);
        // Route::post('/webpanel/report/seller/importcsv', [ReportSellerController::class, 'importFile']);

        //queue;
        //ใช้จริง no jobs;
        // Route::post('/webpanel/report/seller/importcsv', [ImportController::class, 'import']);

        //jobs;
        Route::post('/webpanel/report/seller/importcsv', [ImportCsvController::class, 'importCsv']);

        // Route::post('/webpanel/report/seller/importcsv', [ImportCsvController::class, 'import']);

 /*        Route::post('/webpanel/report/seller/importseller', [ImportController::class, 'import']);
        Route::get('import/status/{id}', [ImportController::class, 'importStatus'])->name('import.status'); */

        Route::get('/imports/partial', [ImportController::class, 'partial'])->name('imports.partial');

        // web.php
        Route::get('/import-status/{id}', [ImportController::class, 'checkStatus'])->name('import-status');


        // Route::get('/webpanel/report/seller/search_date', [ReportSellerController::class, 'index']);
        // Route::get('/webpanel/report/seller', [ReportSellerController::class, 'index']);
        // Route::get('/webpanel/report/seller/range', [ReportSellerController::class, 'index']);
        Route::get('/webpanel/report/seller/{id}', [ReportSellerController::class, 'show']);
        Route::get('/webpanel/report/seller/exportcsv/check', [SellerCsvExport::class, 'exportSellerCsv']);
        Route::get('/webpanel/report/seller/exportexcel/check', [SellerExcelExport::class, 'exportSellerExcel']);
        Route::get('/webpanel/report/seller/search/keyword', [ReportSellerController::class, 'search']);
        Route::get('/webpanel/report/product', [ProductController::class, 'index']);
        // Route::get('/webpanel/report/product', [ProductController::class, 'preload']);
        Route::get('webpanel/report/product/importproduct', [ProductController::class, 'import']);
        Route::get('webpanel/report/product/importproduct/{id}', [ProductController::class, 'productInfo']);
        Route::post('webpanel/report/product/importproduct/updated/{id}', [ProductController::class, 'updateInfo']);
        //importcsv_product master;
        Route::post('/webpanel/report/product/importcsv', [ProductController::class, 'importFile']);
        Route::get('/webpanel/report/product/new-product', [ProductController::class, 'newInfo']);
        Route::post('/webpanel/report/product/new-product/created', [ProductController::class, 'createInfo']);
        Route::get('/webpanel/report/product/update-cost', [ProductController::class, 'updateCost']);

        //update cost;
        // Route::post('/webpanel/report/product/update-cost/importcsv', [ProductController::class, 'importCostProduct']);
        Route::put('/webpanel/report/product/update-cost/importcsv', [ProductController::class, 'importCostProduct']);

        //update product_status;
        Route::put('/webpanel/report/product/update-status/importcsv', [ProductController::class, 'importStatusProduct']);
        Route::get('/webpanel/report/product/update-status', [ProductController::class, 'updateStatus']);

        //update type (แบบ ข.ย.)
        Route::get('/webpanel/report/product/update-type', [ProductController::class, 'updateKhoryor']);
        Route::put('/webpanel/report/product/update-type/importcsv', [ProductController::class, 'importKhoryor']);

        //report product-type (แบบ ข.ย.)
        Route::get('/webpanel/report/product-type', [ProductController::class, 'indexType']);
        Route::get('/webpanel/report/product-type/khor-yor-2/{cate_id?}', [ProductController::class, 'productTypeKhoryor']);

        //report product-type (สมุนไพร)
         Route::get('/webpanel/report/product-type/somphor-2/{cate_id?}', [ProductController::class, 'productTypeSomphor']);
        //report search type;
        // Route::get('/webpanel/report/product-type', [ProductController::class, 'productType']);

        //export excel and csv stock;
        Route::get('/webpanel/report/product/deadstock/exportexcel/check', [ProductExcelExport::class, 'deadStockExcel']);
        Route::get('/webpanel/report/product/deadstock/exportcsv/check', [ProductCsvExport::class, 'exportStockCsv']);
        
        Route::get('/webpanel/report/product/importproduct/deleted/{id}', [ProductController::class, 'deleteProduct']);
        Route::get('webpanel/report/product/importcategory', [CategoryController::class, 'import']);
        Route::post('/webpanel/report/product/importcsv/category', [CategoryController::class, 'importFile']);
        Route::get('webpanel/report/product/importsubcategory', [SubcategoryController::class, 'import']);
        Route::post('/webpanel/report/product/importcsv/subcategory', [SubcategoryController::class, 'importFile']);
        Route::get('/webpanel/product/product-detail/{id}', [ProductController::class, 'show']);
        Route::get('/webpanel/report/product/exportcsv/check', [ProductCsvExport::class, 'exportProductCsv']);
        Route::get('/webpanel/report/product/exportexcel/check', [ProductExcelExport::class, 'exportSellerExcel']);

        //update ajax category->sub_category;
        Route::get('/webpanel/report/product/new-product/subcategory', [ProductController::class, 'updateSubcategary']);

        //import_product_update;
        Route::post('/webpanel/report/product/importcsv-updated', [ProductController::class, 'importUpdateProduct']);

        //export item;
        Route::get('/webpanel/report/seller/exportcsv/check/item/{id}', [ProductCsvExport::class, 'exportItemCsv']);
        Route::get('/webpanel/report/seller/exportexcel/check/item/{id}', [ProductExcelExport::class, 'exportItemExcel']);


        Route::get('/webpanel/report/product/sales/category', [ProductController::class, 'salesCategory']);
        Route::get('/webpanel/report/product/sales/region', [ProductController::class, 'salesRegion']);
        Route::get('/webpanel/report/product/sales/region/view', [ProductController::class, 'viewRegion']);
        Route::get('/webpanel/report/product/sales/region/view/item', [ProductController::class, 'productRegion']);
        Route::get('/webpanel/report/product/sales/region/exportcsv/view', [RegionSalesCsvExport::class, 'exportViewRegionCsv']);
        Route::get('/webpanel/report/product/sales/region/exportexcel/view', [RegionSalesExcelExport::class, 'exportViewRegionExcel']);
        Route::get('/webpanel/report/product/sales/region/exportcsv', [RegionProductCsvExport::class, 'exportProductRegionCsv']);
        Route::get('/webpanel/report/product/sales/region/exportexcel', [RegionProductExcelExport::class, 'exportProductRegionExcel']);

        //deadstock;
        Route::get('/webpanel/report/product/deadstock', [ProductController::class, 'deadStock']);
        Route::get('/webpanel/report/product/deadstock/search', [ProductController::class, 'deadStock']);
        //delete-seller;
        Route::get('webpanel/report/delete-sale', [ReportSellerController::class, 'deleteSeller']);

        //count_pur;
        Route::get('/webpanel/report/count-purchase', [ReportSellerController::class, 'countPur']);
        Route::get('/webpanel/report/purchase-dates', [ReportSellerController::class, 'countPur']);
        Route::get('/webpanel/report/purchase-dates/{number_orders}', [ReportSellerController::class, 'countPur']);
        Route::get('/webpanel/report/count-purchase/{id}', [ReportSellerController::class, 'PurOrders']);
        Route::get('/webpanel/report/count-pur/exportexcel/check', [SellerExcelExport::class, 'exportNumPurExcel']);
        Route::get('/webpanel/report/count-pur/exportcsv/check', [SellerCsvExport::class, 'exportNumPurCsv']);

        //summary-purchase;
        Route::get('/webpanel/report/sum-purchase', [ReportSellerController::class, 'sumPur']);
        Route::get('/webpanel/report/sumpur-dates', [ReportSellerController::class, 'sumPur']);

        //fdareporter;
        Route::get('/webpanel/report/fdareporter', [FdaReporterController::class, 'FdaReporter']);
        Route::get('/webpanel/report/updated/fdareporter', [FdaReporterController::class, 'FdaReporter']);

        //check-updated;
        Route::get('/webpanel/check-updated', [WebpanelCustomerController::class, 'checkLicense']);
        Route::get('/webpanel/check-updated/{status}', [WebpanelCustomerController::class, 'checkLicense']);
        Route::get('/webpanel/check-updated/export/license/getcsv/{status_license}', [CustomerCsvExport::class, 'ExportLicenseCsv']);
        Route::get('/webpanel/check-updated/export/license/getexcel/{status_license}', [CustomerExcelExport::class, 'ExportLicenseExcel']);

        //limited sales;
        Route::get('/webpanel/report/product/limited-sales',[ProductTypecontroller::class, 'limitedSaleWebpanel']);

        //status online type;

        Route::get('/webpanel/report/status-type', [LogStatusController::class, 'indexType']);

        Route::get('/webpanel/type-active/updated', [LogStatusController::class, 'updatedType']);

        //export_csv type;
        Route::get('/webpanel/report/product-type/khor-yor-2/export/getcsv/{type_name}', [ProductCsvExport::class, 'exportTypeCsv']);
        Route::get('/webpanel/report/product-type/somphor-2/export/getcsv/{type_name}', [ProductCsvExport::class, 'exportTypeCsv']);

        //export_excel type;
        Route::get('/webpanel/report/product-type/khor-yor-2/export/getexcel/{type_name}', [ProductExcelExport::class, 'typeExcel']);
        Route::get('/webpanel/report/product-type/somphor-2/export/getexcel/{type_name}', [ProductExcelExport::class, 'typeExcel']);
    });
   
    Route::get('/webpanel/datepicker', function (){
        return view('webpanel/datepicker');
    });

    // Route::get('/webpanel/customer/search/code', [PortalCustomerController::class, 'customerSearch'])->middleware('auth', 'role','status', 'verified');

    // Route::get('/webpanel/customer/export/getcsv/{status}', [WebpanelCustomerController::class, 'exportCustomerCsv']);

    //update groups customer;
    Route::post('/webpanel/customer/groups-customer/updatadmin/{sale_area}', [WebpanelCustomerController::class, 'updateAdminarea']);

    // Route::get('/webpanel/customer/importcustomer',[CustomerController::class, 'importFile']);


    //customer view table;
    Route::get('/webpanel/customer', [WebpanelCustomerController::class, 'index'])->middleware('auth', 'role','status', 'verified');
    //webpanel/customer/status/{status_check};
    
    //fecth use id;
    Route::post('/webpanel/customer/purchase', [WebpanelCustomerController::class, 'purchase']);
    //review purchase_status;
    Route::get('/webpanel/customer/adminarea/{admin_id}/purchase/{fixed_id}', [WebpanelCustomerController::class, 'statusPurchase'])->middleware('auth', 'role','status', 'verified');

    Route::get('/webpanel/customer/status/{status_check}', [WebpanelCustomerController::class, 'indexStatus'])->middleware('auth', 'role','status', 'verified');

    //other-purchase (Line, telephone);
    Route::get('/webpanel/customer/order/other-purchase', [WebpanelCustomerController::class, 'otherPurchase'])->middleware('auth', 'role','status', 'verified');

    //check-customer-type;
    // Route::get('/webpanel/customer/status/{status_check}', [WebpanelCustomerController::class, 'indexStatus'])->middleware('auth', 'role','status', 'verified');

    //webpanel customer update;
    // Route::match(['POST', 'HEAD'],'/webpanel/customer-detail/update/{id}', [WebpanelCustomerController::class, 'update'])->middleware('auth', 'role','status', 'verified');
    // Route::post('/webpanel/customer-detail/update/{id}', [WebpanelCustomerController::class, 'update'])->middleware('auth', 'role','status', 'verified');

    // Route::match(['GET', 'POST'], '/webpanel/customer-detail/update/{id}', [WebpanelCustomerController::class, 'update'])->middleware(['auth', 'role', 'status', 'verified']);

    Route::put('/webpanel/customer-detail/update/{id}', [WebpanelCustomerController::class, 'update'])->middleware(['auth', 'role', 'status', 'verified']);

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
    Route::middleware('auth', 'userRole', 'status', 'verified', 'maintenance', 'rights_area', 'checkMenu')->group(function () {

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


    //delete customer;
    Route::get('/webpanel/customer/delete/{id}', [WebpanelCustomerController::class, 'deleteCustomer']);

    //delete admin;
    Route::get('/webpanel/admin/delete/{id}', [UserController::class, 'deleteAdmin']);

    //delete sale_area;
    Route::get('/webpanel/sale/delete/{id}', [SaleareaController::class, 'deleteSalearea']);

    //portal customer;
    Route::get('/portal/customer', [PortalCustomerController::class, 'customerView'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'purReport', 'checkMenu')->name('portal.customer');
    Route::get('/portal/customer/status/{status_customer}', [PortalCustomerController::class, 'customerViewEdit'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'checkMenu');

    //fetch; 'purReport'
    Route::post('/portal/customer/purchase', [PortalCustomerController::class, 'purchaseOrder'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'CheckPurReport', 'checkMenu');

    //purchase;
    Route::get('/portal/customer/purchase/{fixed_id}', [PortalCustomerController::class, 'fixedDate'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'CheckPurReport', 'checkMenu');
    // Route::get('/portal/customer/purchase/{fixed_id}', [PortalCustomerController::class, 'fixedDate'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'CheckPurReport');
    // resource
    Route::get('/portal/customer/{id}', [PortalCustomerController::class, 'customerEdit'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea', 'maintenance', 'rights_area', 'CustomerDetailCheck', 'checkMenu');
   //update smtp;
    // Route::put('/portal/customer/{id}', [StatusUpdateController::class, 'update'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea', 'maintenance', 'rights_area');

    ///search customer;
    Route::get('/portal/customer/search/code', [PortalCustomerController::class, 'customerSearch'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area', 'checkMenu');
    // Route::get('/portal/customer/search/code', [PortalCustomerController::class, 'customerKeyword'])->middleware('auth','userRole', 'status', 'verified' , 'adminArea','maintenance', 'rights_area');
  /*   Route::get('/webpanel/date', function() {
        return view('webpanel/date');
    }); */
   /*  Route::get('/logintail', function() {
        return view('auth/login-tailwind');
    }); */

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


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';
