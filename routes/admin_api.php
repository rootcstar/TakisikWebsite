<?php

use App\Http\Controllers\ADMIN\AdminPanelApiController;
use App\Http\Middleware\AdminLoginControlMiddleware;
use Illuminate\Support\Facades\Route;



    /**** LOGS ****/
    Route::post('/admin-login', [AdminPanelApiController::class, 'admin_login'])->name('admin_login_api');

    Route::middleware([AdminLoginControlMiddleware::class])->group(function () {
    // ADMIN PANEL APIS'S
    Route::get('/fill-datatable', [AdminPanelApiController::class, 'fill_datatable'])->name('fill_datatable_api');;

    Route::post('/admin-user/create', [AdminPanelApiController::class, 'insert_admin_user'])->name('new_admin_user_api');
    Route::post('/admin-user/update', [AdminPanelApiController::class, 'update_admin_user'])->name('update_admin_user_api');
    Route::post('/admin-user/delete', [AdminPanelApiController::class, 'delete_admin_user'])->name('delete_admin_user_api');
    Route::post('/permissions/get', [AdminPanelApiController::class, 'get_permissions'])->name('get_permissions_api');

    Route::post('/permission-type/create', [AdminPanelApiController::class, 'insert_permission_type'])->name('new_permission_type_api');
    Route::post('/permission-type/delete', [AdminPanelApiController::class, 'delete_permission_type'])->name('delete_permission_type_api');
    Route::post('/permission-type/assign', [AdminPanelApiController::class, 'assign_permission_type'])->name('assign_permission_type_api');
    Route::post('/admin-user-types/get', [AdminPanelApiController::class, 'get_admin_user_types'])->name('get_admin_user_types_api');

    Route::post('/admin-user-type/create', [AdminPanelApiController::class, 'insert_admin_user_type'])->name('new_admin_user_type_api');
    Route::post('/admin-user-type/delete', [AdminPanelApiController::class, 'delete_admin_user_type'])->name('delete_admin_user_type_api');

    Route::post('/tag/create', [AdminPanelApiController::class, 'insert_tag'])->name('new_tag_api');
    Route::post('/tag/update', [AdminPanelApiController::class, 'update_tag'])->name('update_tag_api');
    Route::post('/tag/update-image', [AdminPanelApiController::class, 'update_tag_image'])->name('update_tag_image_api');
    Route::post('/tag/delete', [AdminPanelApiController::class, 'delete_tag'])->name('delete_tag_api');

    Route::post('/subtag/create', [AdminPanelApiController::class, 'insert_subtag'])->name('new_subtag_api');
    Route::post('/subtag/update', [AdminPanelApiController::class, 'update_subtag'])->name('update_subtag_api');
    Route::post('/subtag/delete', [AdminPanelApiController::class, 'delete_subtag'])->name('delete_subtag_api');

    Route::post('/user/create', [AdminPanelApiController::class, 'insert_user'])->name('new_user_api');
    Route::post('/user/update', [AdminPanelApiController::class, 'update_user'])->name('update_user_api');
    Route::post('/user/delete', [AdminPanelApiController::class, 'delete_user'])->name('delete_user_api');

    Route::post('/user/discount/create', [AdminPanelApiController::class, 'insert_user_discount'])->name('new_user_discount_api');
    Route::post('/user/discount/delete', [AdminPanelApiController::class, 'delete_user_discount'])->name('delete_user_discount_api');

    Route::post('/user/shipping-address/update', [AdminPanelApiController::class, 'update_user_shipping_address'])->name('update_user_shipping_address_api');
    Route::post('/user/billing-address/update', [AdminPanelApiController::class, 'update_user_billing_address'])->name('update_user_billing_address_api');

    Route::post('/product/create', [AdminPanelApiController::class, 'insert_product'])->name('new_product_api');
    Route::post('/product/update', [AdminPanelApiController::class, 'update_product'])->name('update_product_api');
    Route::post('/product/update/model', [AdminPanelApiController::class, 'insert_product_model_and_image'])->name('new_product_model_and_image_api');
    Route::post('/product/delete/model', [AdminPanelApiController::class, 'delete_product_model'])->name('delete_product_model_api');


    Route::post('/import-excel', [AdminPanelApiController::class, 'upload_product_excel'])->name('importExcel');



});
