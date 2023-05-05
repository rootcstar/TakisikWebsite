<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\AdminUserType;
use App\Models\PermissionType;
use App\Models\SubTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;
use Session;

class AdminWebsiteController extends Controller
{
    public function get_login(){
        return view('admin.partials.login');
    }

    public function admin_logout(){

        Session::flush('admin');
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
            ->with('title', 'Permission Types')
            ->with('keys', $keys )
            ->with('data', $data)
            ->with('new_button_route', 'admin_panel_new_permission_type')
            ->with('new_button_name', 'New Permission Type')
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

        return view('admin.update.update-tag')
            ->with('data',$data)
            ->with('title','Kategori Güncelle')
            ->with('update_button_name','Güncelle');
    }

    public function get_new_tag()
    {
        return view('admin.new.new-tag');
    }



}
