<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;

use App\Models\AdminUser;
use App\Models\AdminUserType;
use App\Models\City;
use App\Models\District;
use App\Models\Neighbourhood;
use App\Models\PermissionType;
use App\Models\Product;
use App\Models\ProductModelAndImage;
use App\Models\SubTag;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserBillingAddress;
use App\Models\UserShippingAddress;
use Session;

class AdminWebsiteController extends Controller
{
    public function get_login(){
        return view('admin.partials.login');
    }

    public function admin_logout(){

        Session::forget('admin');
        return redirect('admin/login');
    }

    public function get_admin_dashboard(){
        return view('admin.dashboard');
    }

    public function get_admin_users(){

        $keys = [
            'admin_id',
            'first_name',
            'last_name',
            'title',
            'email',
            'phone',
        ];
        $data = AdminUser::select($keys)->get();



        return view('admin.admin-users')
            ->with('table_id', 'admin_users')
            ->with('title', 'Yöneticiler')
            ->with('keys', $keys)
            ->with('data', $data)
            ->with('new_button_route', 'admin_panel_new_admin_user')
            ->with('new_button_name', 'Yeni Ekle');


    }

    public function get_new_admin_user(){
        return view('admin.new.new-admin-user');
    }

    public function get_update_admin_user($pri_id){

        $data = AdminUser::where('admin_id',$pri_id)->first();

        if($data == null || empty($data)){
            return view('admin.errors.404');
        }

        return view('admin.update.update-admin-user')->with('data',$data);
    }

    public function get_permission_types(){


        $keys = [
            'permission_id',
            'permission_name',
            'permission_code',
        ];
        $data = PermissionType::select($keys)->get();

        $admin_user_types = AdminUserType::all();

        return view('admin.permission-types')
            ->with('table_id', 'permission_types')
            ->with('title', 'İzinler')
            ->with('keys', $keys )
            ->with('data', $data)
            ->with('new_button_route', 'admin_panel_new_permission_type')
            ->with('new_button_name', 'Yeni EKle')
            ->with('admin_user_types',$admin_user_types);;

    }

    public function get_new_permission_type(){


        $admin_user_types = AdminUserType::select(
            'admin_user_type_id',
            'admin_user_type_name'
        )->get();


        return view('admin.new.new-permission-type')->with('admin_user_types',$admin_user_types);
    }

    public function get_admin_user_types()
    {

        $keys = [
            'admin_user_type_id',
            'admin_user_type_name',
        ];
        $data = AdminUserType::select($keys)->get();

        return view('admin.admin-user-types')
            ->with('table_id', 'admin_user_types')
            ->with('title', 'Admin User Types')
            ->with('keys', $keys)
            ->with('data', $data)
            ->with('new_button_route', 'admin_panel_new_admin_user_type')
            ->with('new_button_name', 'Ekle');;

    }

    public function get_new_admin_user_type()
    {
        return view('admin.new.new-admin-user-type');
    }

    public function get_tags(){

        $keys = [
            'tag_id',
            'tag_name',
            'tag_image',
            'is_active',
        ];
        $data = Tag::select($keys)->get();

        $second_keys = [
            'sub_tag_id',
            'sub_tag_name',
            'is_active',
        ];
        $second_data = SubTag::select($second_keys)->get();

        return view('admin.tags')
            ->with('table_id', 'tags')
            ->with('title', 'Kategoriler')
            ->with('keys', $keys)
            ->with('data', $data)
            ->with('second_table_id', 'sub_tags')
            ->with('second_title', 'Alt Kategoriler')
            ->with('second_keys', $second_keys)
            ->with('second_data', $second_data)
            ->with('new_button_name', 'Yeni Ekle');


    }

    public function get_update_tag($pri_id){

        $data = Tag::where('tag_id',$pri_id)->first();

        if($data == null || empty($data)){
            return view('admin.errors.404');
        }
        return view('admin.update.update-tag')
            ->with('data',$data)
            ->with('title','Kategori Güncelle')
            ->with('update_button_name','Güncelle');
    }

    public function get_update_subtag($pri_id){

        $data = SubTag::where('sub_tag_id',$pri_id)->first();

        if($data == null || empty($data)){
            return view('admin.errors.404');
        }
        return view('admin.update.update-subtag')
            ->with('data',$data)
            ->with('title','Alt Kategori Güncelle')
            ->with('update_button_name','Güncelle');
    }

    public function get_customers(){

        $keys = [
            'user_id',
            'company_name',
            'email',
            'phone',
        ];
        $data = User::select($keys)->get();


        return view('admin.customers')
            ->with('table_id', 'users')
            ->with('title', 'Müşteriler')
            ->with('keys', $keys)
            ->with('data', $data)
            ->with('new_button_route', 'admin_panel_new_user')
            ->with('new_button_name', 'Yeni Ekle');


    }

    public function get_new_customer(){
        return view('admin.new.new-customer');
    }

    public function get_update_customer($pri_id){

        $data = User::where('user_id',$pri_id)->first();
        $shipping_address_keys = [
            'record_id',
            'user_id',
            'address_title',
            'city',
        ];
        $shipping_address_table_name = 'user_shipping_addresses';

        $billing_address_keys = [
            'record_id',
            'user_id',
            'address_title',
            'city',
        ];
        $billing_address_table_name = 'user_billing_addresses';


        $user_discount_keys = [
            'record_id',
            'discount_percentage',
        ];
        $user_discount_table_name = 'user_discounts';

        if($data == null || empty($data)){
            return view('admin.errors.404');
        }
        return view('admin.update.update-customer')
            ->with('shipping_address_table_name',$shipping_address_table_name)
            ->with('shipping_address_keys',$shipping_address_keys)
            ->with('billing_address_table_name',$billing_address_table_name)
            ->with('billing_address_keys',$billing_address_keys)
            ->with('user_discount_table_name',$user_discount_table_name)
            ->with('user_discount_keys',$user_discount_keys)
            ->with('data',$data);
    }
    public function get_update_customer_shipping_address($pri_id){

        $data = UserShippingAddress::where('record_id',$pri_id)->first();

        if($data == null || empty($data)){
            return view('admin.errors.404');
        }

        $data['city_id'] = City::where('city_name_uppercase',$data['city'])->value('city_id');
        $data['district_id'] = District::where('district_name_uppercase',$data['district'])->value('district_id');
        $data['neighbourhood_id'] = Neighbourhood::where('neighbourhood_name',$data['neighbourhood'])->value('neighbourhood_id');

        return view('admin.update.update-shipping-address')
            ->with('data',$data);
    }
    public function get_update_customer_billing_address($pri_id){

        $data = UserBillingAddress::where('record_id',$pri_id)->first();

        if($data == null || empty($data)){
            return view('admin.errors.404');
        }

        $data['city_id'] = City::where('city_name_uppercase',$data['city'])->value('city_id');
        $data['district_id'] = District::where('district_name_uppercase',$data['district'])->value('district_id');
        $data['neighbourhood_id'] = Neighbourhood::where('neighbourhood_name',$data['neighbourhood'])->value('neighbourhood_id');

        return view('admin.update.update-billing-address')
            ->with('data',$data);
    }

    public function get_products(){

        $keys = [
            'product_id',
            'barcode',
            'product_code',
            'product_name',
        ];
        $data = Product::select($keys)->get();


        return view('admin.products')
            ->with('table_id', 'products')
            ->with('title', 'Ürünler')
            ->with('keys', $keys)
            ->with('data', $data)
            ->with('new_button_route', 'admin_panel_new_product')
            ->with('new_button_name', 'Yeni Ekle');


    }

    public function get_new_product(){
        return view('admin.new.new-product');
    }

    public function get_update_product($pri_id){

        $prod_data = Product::where('product_id',$pri_id)->first();

        if($prod_data == null || empty($prod_data)){
            return view('admin.errors.404');
        }


        $keys = [
            'model_record_id',
            'image_record_id',
            'product_id',
            'model_number',
            'product_image',
        ];


        $data =  ProductModelAndImage::select($keys)->get();


        return view('admin.update.update-product')
                        ->with('prod_data',$prod_data)
                        ->with('title','Ürün Güncelle')
                        ->with('update_button_name','Güncelle')
                        ->with('table_id', 'product_images')
                        ->with('keys', $keys)
                        ->with('data', $data);



    }

    public function get_insert_products_with_excel(){
        return view('admin.new.new-product-excel');
    }

}
