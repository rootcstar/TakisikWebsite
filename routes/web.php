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
    Route::get('/admin/logout', [AdminWebsiteController::class, 'admin_logout'])->name('admin_panel_logout');

//ADMIN URLS
Route::middleware([AdminLoginControlMiddleware::class])->group(function() {

    Route::get('/admin', [WebsiteController::class, 'get_admin_dashboard'])->name('admin_panel_dashboard');
    Route::get('/admin/admin-users', [WebsiteController::class, 'get_admin_users'])->name('admin_panel_admin_users');
    Route::get('/admin/admin-users/new', [WebsiteController::class, 'get_new_admin_user'])->name('admin_panel_new_admin_user');

    Route::get('/admin/permission-types', [WebsiteController::class, 'get_permission_types'])->name('admin_panel_permission_types');
    Route::get('/admin/permission-types/new', [WebsiteController::class, 'get_new_permission_type'])->name('admin_panel_new_permission_type');

    Route::get('/admin/admin-user-types', [WebsiteController::class, 'get_admin_user_types'])->name('admin_panel_admin_user_types');
    Route::get('/admin/admin-user-types/new', [WebsiteController::class, 'get_new_admin_user_type'])->name('admin_panel_new_admin_user_type');



});
