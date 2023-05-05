<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LoginControlMiddleware;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AdminApiController;
use App\Http\Controllers\AdminWebsiteController;
use App\Http\Middleware\AdminLoginControlMiddleware;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

    // WEBSITE API'S

    /*** LOGS ***/
    Route::post('/api-signin', [ApiController::class, 'signin']);
    Route::post('/api-forget-password', [ApiController::class, 'forget_password']);
    Route::post('/api-new-password', [ApiController::class, 'new_password']);
    Route::post('/api-register', [ApiController::class, 'register'])->name('register_api');
    Route::post('/api-get-register-form', [ApiController::class, 'get_register_form']);
    Route::post('/api-logout', [ApiController::class, 'logout']);

    /*** ***/
    Route::post('/api-get-tag-products', [ApiController::class, 'get_tag_products']);
    Route::post('/api-get-sub-tag-products', [ApiController::class, 'get_sub_tag_products']);
    Route::post('/api-load-more', [ApiController::class, 'load_more']);
    Route::post('/api-add-to-cart', [ApiController::class, 'add_to_cart']);
    Route::post('/api-add-to-cart-input', [ApiController::class, 'add_to_cart_input']);
    Route::post('/api-delete-item', [ApiController::class, 'delete_item']);
    Route::post('/api-delete-items', [ApiController::class, 'delete_items_from_cart']);
    Route::get('/api-quick-view/{product_code}', [ApiController::class, 'quick_view']);
    Route::post('/api-add-to-fav', [ApiController::class, 'add_to_fav']);
    Route::post('/api-get-product-model', [ApiController::class, 'get_product_model']);
    Route::post('/api-get-category', [ApiController::class, 'get_category']);

/**** LOGS ****/
Route::post('/admin-login', [AdminApiController::class, 'admin_login'])->name('admin_login_api');

Route::middleware([AdminLoginControlMiddleware::class])->group(function () {
    // ADMIN PANEL APIS'S
    Route::get('admin/fill-datatable', [AdminApiController::class, 'fill_datatable'])->name('fill_datatable_api');;

    Route::post('/admin/admin-user/create', [AdminApiController::class, 'insert_admin_user'])->name('new_admin_user_api');
    Route::post('/admin/admin-user/update', [AdminApiController::class, 'update_admin_user'])->name('update_admin_user_api');
    Route::post('/admin/admin-user/delete', [AdminApiController::class, 'delete_admin_user'])->name('delete_admin_user_api');

    Route::post('/admin/permissions/get', [AdminApiController::class, 'get_permissions'])->name('get_permissions_api');


    Route::post('/admin/admin-user-type/create', [AdminApiController::class, 'insert_admin_user_type'])->name('new_admin_user_type_api');
    Route::post('/admin/admin-user-type/delete', [AdminApiController::class, 'delete_admin_user_type'])->name('delete_admin_user_type_api');

    /**** ADD ****/

    Route::post('/add-tag', [AdminApiController::class, 'addTag']);
    Route::post('/add-sub-tag', [AdminApiController::class, 'addSubtag']);

    /**** UPDATE ****/
    Route::post('/update-tag', [AdminApiController::class, 'updateTag']);
    Route::post('/update-sub-tag', [AdminApiController::class, 'updateSubtag']);
    Route::post('/update-tags-of-sub-tag', [AdminApiController::class, 'updateTagsOfSubtag']);


    /****** DELETE ******/
    Route::post('/delete-record', [AdminApiController::class, 'deleteRecord']);

});
