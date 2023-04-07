<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\ApiController;
use App\Http\Middleware\LoginControlMiddleware;
use App\Http\Middleware\AdminLoginControlMiddleware;
use App\Http\Controllers\AdminWebsiteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/logout', [ApiController::class, 'logout']);
Route::get('/hesap-onayi', [WebsiteController::class, 'get_confirm_account_page']);
Route::get('/yeni-sifre', [WebsiteController::class, 'get_new_password_page']);
Route::get('/uyari', [WebsiteController::class, 'get_warning_page']);


Route::get('/test', [WebsiteController::class, 'get_test']);

Route::middleware([LoginControlMiddleware::class])->group(function() {
    Route::get('/alisveris', [WebsiteController::class, 'get_shopping_page']);
    Route::get('/urun-detay/{product_name}/{product_code}', [WebsiteController::class, 'get_product_detail_page']);
    Route::get('/sepetim', [WebsiteController::class, 'get_shopping_cart_page']);
    Route::get('/favorilerim', [WebsiteController::class, 'get_favs_page']);
    Route::get('/kategoriler', [WebsiteController::class, 'get_categories_page']);
});

    Route::get('/', [WebsiteController::class, 'get_index']);
    Route::get('/uyelik', [WebsiteController::class, 'get_signin_page'])->name('uyelik');
    Route::get('/uyelik/yeni', [WebsiteController::class, 'get_register_page'])->name('yeni_uyelik');
    Route::get('/iletisim', [WebsiteController::class, 'get_contact']);


    // ADMIN LOGS
    Route::get('/admin/login', [AdminWebsiteController::class, 'get_login'])->name('admin-login');
    Route::get('/admin/logout', [AdminWebsiteController::class, 'admin_logout']);

//ADMIN URLS
Route::middleware([AdminLoginControlMiddleware::class])->group(function() {
    Route::get('/admin', [AdminWebsiteController::class, 'get_home']);
    Route::get('/admin/{table_name}', [AdminWebsiteController::class, 'get_general']);

    Route::get('/admin/{table_name}/yeni', [AdminWebsiteController::class, 'get_add_page']); // ADD
    Route::get('/admin/{table_name}/detay/{id}', [AdminWebsiteController::class, 'get_detail_page']); // UPDATE
});
