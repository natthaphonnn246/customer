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
    use App\Http\Controllers\OrderingController;
    use App\Http\Controllers\StatusUpdateController;
    use App\Http\Controllers\ProductTypeController;
    use App\Http\Controllers\PurchaseController;
    use App\Http\Controllers\LineController;
    use App\Http\Controllers\PromotionController;

Route::middleware('statusOnline', 'block.ai')->group(function (){

    //redirect LineOA
    Route::get('/account/profile', [LineController::class, 'loginLine'])->middleware('auth', 'status','maintenance')->name('portal.account.profile');

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

        //ordering
        Route::name('webpanel.')->prefix('webpanel')->group(function () {
            Route::name('ordering.')->prefix('ordering')->group(function () {

                Route::get('/', [OrderingController::class, 'index'])->name('index');
                Route::get('/count-order', [OrderingController::class, 'countOrder'])->name('count.order');
                Route::get('/product-search', [OrderingController::class, 'productSearch'])->name('product.search');
                Route::get('/customer-search', [OrderingController::class, 'searchCustomer'])->name('customer.search');
                Route::get('/latest-header', [OrderingController::class, 'getLatestDraftPO'])->name('lastest.header');
                Route::post('/create-header/new', [OrderingController::class, 'createHeaderPo'])->name('create.header.new');
                Route::post('/update/save-draft', [OrderingController::class, 'saveDraft'])->name('save.draft');
                Route::post('/confirmed/save-po', [OrderingController::class, 'confirmOrdering'])->name('confirmed.save');
                Route::post('/view/item', [OrderingController::class, 'viewItem'])->name('view.item');
                Route::post('/cancel/item', [OrderingController::class, 'cancelItem'])->name('cancel.item');
                Route::post('/cancel/item-all', [OrderingController::class, 'cancelItemAll'])->name('cancel.item.all');
                Route::get('/view/{order}', [OrderingController::class, 'viewDraft'])->name('view');
            });
        });
        
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
        Route::get('/webpanel/customer/{id}', [WebpanelCustomerController::class, 'edit'])->name('webpanel.customer.edit');
        //webpanel uploade image;
        Route::post('/webpanel/customer-detail/upload-store/{id}', [WebpanelCustomerController::class, 'certStore']);
        Route::post('/webpanel/customer-detail/upload-medical/{id}', [WebpanelCustomerController::class, 'certMedical']);
        Route::post('/webpanel/customer-detail/upload-commerce/{id}', [WebpanelCustomerController::class, 'certCommerce']);
        Route::post('/webpanel/customer-detail/upload-vat/{id}', [WebpanelCustomerController::class, 'certVat']);
        Route::post('/webpanel/customer-detail/upload-id/{id}', [WebpanelCustomerController::class, 'certId']);

         //user create;
        Route::post('/webpanel/admin-create/insert', [UserController::class, 'create']);

        //จัดกลุ่มแอดมินกับไลน์;
        Route::get('/webpanel/admin-group', [UserController::class, 'groupLine']);
        Route::post('webpanel/admin-group/update', [UserController::class, 'updateLine'])->name('admin.groupline.update');

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
        Route::get('/webpanel/customer/export/getexcel/{status}/{admin_id}', [CustomerAreaExport::class, 'exportCustomerAreaExcel']);

        //export customer -> getcsv;
        Route::get('/webpanel/customer/export/getcsv/{status}', [CustomerCsvExport::class, 'exportCustomerCsv']);

        //export customer check-purchase excel;
        Route::get('/webpanel/customer/export/purchase/getcsv/{status_pur}', [CustomerCsvExport::class, 'PurchaseExoportCsv']);

        //export adminarea-detail->getcsv;
        Route::get('/webpanel/customer/export/getcsv/{status}/{admin_id}', [CustomerAreaExport::class, 'exportCustomerAreaCsv']);

        //export customer_detail -> getcsv;
        Route::get('/webpanel/customer/getcsv/{customer_id}', [WebpanelCustomerController::class, 'getCustomerCsv']);

        //adminarea-detail;
        Route::get('/webpanel/customer/adminarea/{admin_id}', [WebpanelCustomerController::class, 'indexAdminArea']);

        //search customer;
        Route::get('/webpanel/customer/adminarea/{admin_id}/{status}', [WebpanelCustomerController::class, 'indexAdminArea']);

        Route::get('/webpanel/active-user', [LogStatusController::class, 'create']);
        Route::get('/webpanel/active-user/updated', [LogStatusController::class, 'updated']);

        //update status-wating;
        Route::post('/webpanel/customer/update-status/wating', [WebpanelCustomerController::class, 'updateStatusWating']);

        //cache_clear;
        Route::get('/webpanel/customer/check/{cache_clear}', [WebpanelCustomerController::class, 'index']);

    });

    //report seller;
    Route::middleware('auth', 'role','status', 'verified')->group(function () {

        //product
        Route::name('webpanel.product.')->prefix('webpanel/product')->group(function () {
            Route::get('/', [ProductController::class, 'productAll'])->name('index');
            Route::get('/{id}/special-deal', [PromotionController::class, 'specialDeal'])->name('special.deal');
            Route::get('/{id}/special-price', [PromotionController::class, 'specialPrice'])->name('special.price');
            Route::get('/{id}', [ProductController::class, 'productEdit'])->name('item.edit');
        });
        //report product-type (แบบ ข.ย.)
        Route::get('/webpanel/product-type', [ProductController::class, 'indexType']);
        Route::get('/webpanel/product-type/khor-yor-2/{cate_id?}', [ProductController::class, 'productTypeKhoryor']);

        //report product-type (สมุนไพร)
        Route::get('/webpanel/product-type/somphor-2/{cate_id?}', [ProductController::class, 'productTypeSomphor']);

        Route::get('/webpanel/report/seller', [ReportSellerController::class, 'index']);
        Route::get('webpanel/report/seller/importseller', [ReportSellerController::class, 'import']);

        //queue;
        //ใช้จริง no jobs;
        // Route::post('/webpanel/report/seller/importcsv', [ImportController::class, 'import']);

        //jobs;
        Route::post('/webpanel/report/seller/importcsv', [ImportCsvController::class, 'importCsv']);

        Route::get('/imports/partial', [ImportController::class, 'partial'])->name('imports.partial');

        // web.php
        Route::get('/import-status/{id}', [ImportController::class, 'checkStatus'])->name('import-status');

        Route::get('/webpanel/report/seller/{id}', [ReportSellerController::class, 'show']);
        Route::get('/webpanel/report/seller/exportcsv/check', [SellerCsvExport::class, 'exportSellerCsv']);
        Route::get('/webpanel/report/seller/exportexcel/check', [SellerExcelExport::class, 'exportSellerExcel']);
        Route::get('/webpanel/report/seller/search/keyword', [ReportSellerController::class, 'search']);
        Route::get('/webpanel/report/product', [ProductController::class, 'index']);
        // Route::get('/webpanel/report/product', [ProductController::class, 'preload']);
        Route::get('webpanel/report/product/importproduct', [ProductController::class, 'import']);
        Route::get('webpanel/report/product/importproduct/{id}', [ProductController::class, 'productInfo']);
        Route::put('webpanel/report/product/importproduct/updated/{id}', [ProductController::class, 'updateInfo']);
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
        Route::get('/webpanel/product/limited-sales',[ProductTypecontroller::class, 'limitedSaleWebpanel']);

        //status online type;
        Route::get('/webpanel/status-type', [LogStatusController::class, 'indexType']);
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

    //update groups customer;
    Route::post('/webpanel/customer/groups-customer/updatadmin/{sale_area}', [WebpanelCustomerController::class, 'updateAdminarea']);

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
    Route::put('/webpanel/customer-detail/update/{id}', [WebpanelCustomerController::class, 'update'])->middleware(['auth', 'role', 'status', 'verified'])->name('webpanel.customer.update');

    //delete customer;
    Route::get('/webpanel/customer/delete/{id}', [WebpanelCustomerController::class, 'deleteCustomer']);
    //delete admin;
    Route::get('/webpanel/admin/delete/{id}', [UserController::class, 'deleteAdmin']);
    //delete sale_area;
    Route::get('/webpanel/sale/delete/{id}', [SaleareaController::class, 'deleteSalearea']);

});
    //webpanel-promotion
    Route::name('webpanel.promotion.')->prefix('webpanel')->middleware('auth', 'role','status', 'verified')->group(function () {
        Route::name('product.')->prefix('promotion-view')->group(function () {

            Route::get('/', [PromotionController::class, 'view'])->name('view');
            Route::get('/draft', [PromotionController::class, 'viewDraft'])->name('view.draft');
            Route::get('/product-slow', [PromotionController::class, 'viewDeadStock'])->name('slow.view');
            Route::get('/edit/{id}', [PromotionController::class, 'addEdit'])->name('product.edit');
            Route::get('/product-slow/data', [PromotionController::class, 'deadStock'])->name('slow.data');
            Route::post('/product-slow/item', [PromotionController::class, 'viewItem'])->name('slow.item');
            Route::post('/edit/update/{productId}', [PromotionController::class, 'addEditUpdate'])->name('product.edit.update');
            Route::post('/confirm/order/{orderId}', [PromotionController::class, 'confirmPo'])->name('confirm.order');
            Route::delete('/item/destroy/{id}', [PromotionController::class, 'destroy']);

        });

        Route::get('/promotion-management', [PromotionController::class, 'index'])->name('management');
        Route::get('/order-id', [PromotionController::class, 'editCheck'])->name('order.id');
        Route::post('/product-slow/add', [PromotionController::class, 'addProduct'])->name('product.add');
        Route::post('/create-po/new', [PromotionController::class, 'createHeaderPo'])->name('create.po');

    });

    require __DIR__.'/auth.php';
