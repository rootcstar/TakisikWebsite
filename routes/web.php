<?php

use App\Http\Controllers\ADMIN\AdminWebsiteController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\WebsiteController;
use App\Http\Middleware\AdminLoginControlMiddleware;
use App\Http\Middleware\LoginControlMiddleware;
use Illuminate\Support\Facades\Route;

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
    Route::get('/hesabim', [WebsiteController::class, 'get_my_account_page']);
    Route::get('/hesabim/kullanici-bilgileri', [WebsiteController::class, 'get_account_info_page']);
    Route::get('/hesabim/adres-bilgileri', [WebsiteController::class, 'get_address_info_page']);
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

    Route::get('/admin', [AdminWebsiteController::class, 'get_admin_dashboard'])->name('admin_panel_dashboard');

    Route::get('/admin/admin-users', [AdminWebsiteController::class, 'get_admin_users'])->name('admin_panel_admin_users');
    Route::get('/admin/admin-users/update/{pri_id}', [AdminWebsiteController::class, 'get_update_admin_user']);
    Route::get('/admin/admin-users/new', [AdminWebsiteController::class, 'get_new_admin_user'])->name('admin_panel_new_admin_user');

    Route::get('/admin/permission-types', [AdminWebsiteController::class, 'get_permission_types'])->name('admin_panel_permission_types');
    Route::get('/admin/permission-types/new', [AdminWebsiteController::class, 'get_new_permission_type'])->name('admin_panel_new_permission_type');

    Route::get('/admin/admin-user-types', [AdminWebsiteController::class, 'get_admin_user_types'])->name('admin_panel_admin_user_types');
    Route::get('/admin/admin-user-types/new', [AdminWebsiteController::class, 'get_new_admin_user_type'])->name('admin_panel_new_admin_user_type');

    Route::get('/admin/tags', [AdminWebsiteController::class, 'get_tags'])->name('admin_panel_tags');
    Route::get('/admin/tags/update/{pri_id}', [AdminWebsiteController::class, 'get_update_tag']);

    Route::get('/admin/subtags/update/{pri_id}', [AdminWebsiteController::class, 'get_update_subtag']);

    Route::get('/admin/customers', [AdminWebsiteController::class, 'get_customers'])->name('admin_panel_customers');
    Route::get('/admin/customers/new', [AdminWebsiteController::class, 'get_new_user'])->name('admin_panel_new_user');
    Route::get('/admin/customers/update/{pri_id}', [AdminWebsiteController::class, 'get_update_customer']);

    Route::get('/admin/customers/shipping-address/update/{pri_id}', [AdminWebsiteController::class, 'get_update_customer_shipping_address']);
    Route::get('/admin/customers/billing-address/update/{pri_id}', [AdminWebsiteController::class, 'get_update_customer_billing_address']);

    Route::get('/admin/products', [AdminWebsiteController::class, 'get_products'])->name('admin_panel_products');
    Route::get('/admin/products/new', [AdminWebsiteController::class, 'get_new_product'])->name('admin_panel_new_product');
    Route::get('/admin/products/update/{pri_id}', [AdminWebsiteController::class, 'get_update_product']);

    Route::get('/admin/product-upload-with-excel', [AdminWebsiteController::class, 'get_insert_products_with_excel'])->name('admin_panel_excel_upload');


});
