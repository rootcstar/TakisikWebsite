<?php

use App\Http\Controllers\ADMIN\AdminApiController;
use App\Http\Controllers\ApiController;
use App\Http\Middleware\AdminLoginControlMiddleware;
use Illuminate\Support\Facades\Route;


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
    Route::post('/signin', [ApiController::class, 'signin']);
    Route::post('/forget-password', [ApiController::class, 'forget_password']);
    Route::post('/new-password', [ApiController::class, 'new_password']);
    Route::post('/register', [ApiController::class, 'register'])->name('register_api');
    Route::post('/get-register-form', [ApiController::class, 'get_register_form']);
    Route::post('/logout', [ApiController::class, 'logout']);

    /*** ***/
    Route::post('/get-tag-products', [ApiController::class, 'get_tag_products']);
    Route::post('/get-sub-tag-products', [ApiController::class, 'get_sub_tag_products']);
    Route::post('/load-more', [ApiController::class, 'load_more']);
    Route::post('/add-to-cart', [ApiController::class, 'add_to_cart']);
    Route::post('/add-to-cart-input', [ApiController::class, 'add_to_cart_input']);
    Route::post('/delete-item', [ApiController::class, 'delete_item']);
    Route::post('/delete-items', [ApiController::class, 'delete_items_from_cart']);
    Route::get('/quick-view/{product_code}', [ApiController::class, 'quick_view']);
    Route::post('/add-to-fav', [ApiController::class, 'add_to_fav']);
    Route::post('/get-product-model', [ApiController::class, 'get_product_model']);
    Route::post('/get-category', [ApiController::class, 'get_category']);
    Route::post('/empty-cart', [ApiController::class, 'get_empty_cart']);

    /** USER  */
    Route::post('/update-user', [ApiController::class, 'update_user']);
    Route::post('/add-new-address', [ApiController::class, 'insert_address'])->name('add_new_address');
    Route::post('/delete-address', [ApiController::class, 'delete_address'])->name('delete_address');

    Route::post('/get-city', [ApiController::class, 'get_city']);
    Route::post('/get-district', [ApiController::class, 'get_district']);
    Route::post('/get-neighbourhood', [ApiController::class, 'get_neighbourhood']);
