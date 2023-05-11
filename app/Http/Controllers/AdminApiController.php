<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\AdminUserType;
use App\Models\AdminUserTypePermission;
use App\Models\PermissionType;
use App\Models\TagToSubTag;
use App\Models\SubTag;
use App\Models\Tag;
use App\Models\User;
use App\Rules\CheckIfAdminUserTypeExists;
use App\Rules\CheckIfPermissionTypeExists;
use App\Rules\Exist_Already_Email_AdminUser;
use App\Rules\OnlyLetterRule;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Session;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class AdminApiController extends Controller
{
    public function admin_login(Request $request){
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'email' => [
                    "required",
                    "email",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'password' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {
                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
            }


            try {
                $check_db =  DB::table('admin_users')->where(['email'=>$data['email']])->get();

                if(count($check_db) == 1){

                    $password = fiki_decrypt($check_db[0]->password);

                    if($password == $data['password']){

                        $username = $check_db[0]->first_name.' '.$check_db[0]->last_name;

                        Session::put('admin.is_login',true);
                        Session::put('admin.username',$username);;
                        Session::put('admin.lang','tr');

                        return response(['result' => 1, 'msg' => 'Lütfen bekleyiniz.'], 200);
                    }else{


                        return response(['result' => -1, 'msg' => 'Yanlış email ya da şifre girdiniz, lütfen tekrar deneyiniz.'], 200);
                    }

                }else{
                    return response(['result' => -2, 'msg' => 'Yanlış email ya da şifre girdiniz, lütfen tekrar deneyiniz.'], 200);
                }

            } catch (QueryException $e) {

                return response(['result' => -3, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }




        } catch (\Exception $e) { // 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__
            return response(['result' => -997, 'msg' => 'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.']);

        }
    }

    public function get_permissions (Request $request){

        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'admin_user_type_id' => [
                    "required",
                    "numeric",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                    new CheckIfAdminUserTypeExists(),
                ],
            ]);
            if ($validator->fails()) {
                $resp = response(['result'=>-1,"msg"=>$validator->errors()->first(),'error' => $validator->errors() ,"function"=>__FUNCTION__,"data"=>$data],400);
                return $resp;
            }


            $permission_types = AdminUserTypePermission::where('admin_user_type_id',$data['admin_user_type_id'])->get();
            foreach ($permission_types as $permission_type){
                $perm = PermissionType::where('permission_id',$permission_type->permission_id)->first();
                $permission_type->permission_name = $perm->permission_name;
            }


            return response(['result'=>1,"msg"=>"Success","html"=>view('admin.partials.permissions')->with('permissions',$permission_types)->render()],200);
        } catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }

    }

    public function get_admin_user_types(Request $request){



        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'permission_id' => [
                    "required",
                    "numeric",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                    new CheckIfPermissionTypeExists()
                ],
            ]);
            if ($validator->fails()) {
                $resp = response(['result'=>-1,"msg"=>$validator->errors()->first(),'error' => $validator->errors() ,"function"=>__FUNCTION__,"data"=>$data],400);
                return $resp;
            }

            $admin_user_types = AdminUserType::all();
            foreach ($admin_user_types as $admin_user_type){

                $admin_user_type->is_checked = false;
                $check_if_ts_checked = AdminUserTypePermission::where('admin_user_type_id',$admin_user_type->admin_user_type_id)
                    ->where('permission_id',$data['permission_id'])->first();
                if(!empty($check_if_ts_checked)){
                    $admin_user_type->is_checked = true;
                }

            }



            return response(['result'=>1,"msg"=>"Success","html"=>view('admin.partials.admin_user_types')->with('admin_user_types',$admin_user_types)->render()],200);
        } catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }


    }

    public function insert_admin_user(Request $request){
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'first_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'last_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'email' => [
                    "required",
                    "email",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                    new Exist_Already_Email_AdminUser()
                ],
                'phone' => [
                    "required",
                    'digits_between:10,11',
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'password' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'admin_user_type_id' => [
                    "required",
                    "numeric",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                    new CheckIfAdminUserTypeExists(),
                ],
                'is_active' => [
                    "required",
                    "boolean",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'title' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ]
            ]);

            if ($validator->fails()) {
                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
            }



            try {

                AdminUser::create($data);

            } catch (QueryException $e) {

                return response(['result' => -1, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }


            return response(['result' => 1, 'msg' => 'Kayıt başarıyla eklendi.']);

        } catch (\Exception $e) { // 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__
            return response(['result' => -997, 'msg' => 'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.']);

        }
    }

    public function update_admin_user(Request $request){
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'first_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'last_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'email' => [
                    "required",
                    "email",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),

                ],
                'phone' => [
                    "required",
                    'digits_between:10,11',
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'password' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'admin_user_type_id' => [
                    "required",
                    "numeric",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                    new CheckIfAdminUserTypeExists(),
                ],
                'is_active' => [
                    "required",
                    "boolean",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'title' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ]
            ]);

            if ($validator->fails()) {
                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
            }


            try {

                $admin_id = $data['admin_id'];
                unset($data['admin_id']);
                AdminUser::find($admin_id)->update($data);


            } catch (QueryException $e) {

                return response(['result' => -1, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }


            return response(['result' => 1, 'msg' => 'Kayıt başarıyla güncellendi.']);

        } catch (\Exception $e) { // 'msg' => 'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.'
            return response(['result' => -997, 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__]);

        }
    }

    public function delete_admin_user(Request $request)
    {

        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'admin_id' => [
                    "required",
                    "numeric",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);
            if ($validator->fails()) {
                $resp = response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 400);
                return $resp;
            }

            try{
                AdminUser::where('admin_id',$data['admin_id'])->delete();

            }catch (QueryException $e) {

                $function_name = getcwd();
                $resp = response(['result' => -1, 'msg' => $function_name . ' - Query Error=>' . $e->getMessage()], 400);
                return $resp;
            }

            return response(['result' => 1, "msg" => "Kayıt başarıyla silindi"], 200);
        } catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }


    }

    public function insert_permission_type(Request $request)
    {

        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'permission_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'permission_code' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'admin_user_type_id_array' => [
                    "required",
                    "json",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],

            ]);
            if ($validator->fails()) {
                $resp = response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 400);
                return $resp;
            }

            $admin_user_type_id_array = json_decode($data['admin_user_type_id_array'],true);
            if(!empty($admin_user_type_id_array)){
                foreach ($admin_user_type_id_array as $admin_user_type_id) {
                    // check admin user type exists
                    $count = AdminUserType::where('admin_user_type_id', $admin_user_type_id)->count();
                    if($count == 0){
                        return response(['result' => -1, "msg" => "Admin User Type Not Found"], 400);
                    }
                }
            }




            try {
                $create_data = [
                    'permission_name' => $data['permission_name'],
                    'permission_code' => $data['permission_code']
                ];


                $created_permission_id = PermissionType::create($create_data)->permission_id;

            } catch (QueryException $e) {

                $function_name = getcwd();
                $resp = response(['result' => -1, 'msg' => $function_name . ' - Query Error=>' . $e->getMessage()], 400);
                return $resp;
            }


            $created_admin_user_type_permissions = [];

            if(!empty($admin_user_type_id_array)){
                foreach ($admin_user_type_id_array as $admin_user_type_id){


                    try{
                        $create_data = [
                            'admin_user_type_id' => $admin_user_type_id,
                            'permission_id' => $created_permission_id
                        ];

                        $created_record_id = AdminUserTypePermission::create($create_data)->record_id;
                        array_push($created_admin_user_type_permissions,$created_record_id);
                    } catch (QueryException $e) {
                        PermissionType::where('permission_id',$created_permission_id)->delete();

                        foreach ($created_admin_user_type_permissions as $created_admin_user_type_permission){
                            AdminUserTypePermission::where('record_id',$created_admin_user_type_permission)->delete();
                        }


                        $function_name = getcwd();
                        $resp = response(['result' => -1, 'msg' => $function_name . ' - Query Error=>' . $e->getMessage()], 400);
                        return $resp;
                    }
                }


            }


            return response(['result' => 1, "msg" => "Success"], 200);
        } catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }

    }

    public function delete_permission_type(Request $request)
    {

        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'permission_id' => [
                    "required",
                    "numeric",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                    new CheckIfPermissionTypeExists()
                ],
            ]);
            if ($validator->fails()) {
                $resp = response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 400);
                return $resp;
            }

            $check_if_already_assigned = AdminUserTypePermission::where('permission_id',$data['permission_id'])->count();
            if($check_if_already_assigned > 0){
                return response(['result' => -1, "msg" => "Please unassign this permission from all users before delete"], 400);
            }

            try {
                PermissionType::where('permission_id',$data['permission_id'])->delete();
                AdminUserTypePermission::where('permission_id',$data['permission_id'])->delete();
            } catch (QueryException $e) {

                $function_name = getcwd();
                $resp = response(['result' => -1, 'msg' => $function_name . ' - Query Error=>' . $e->getMessage()], 400);
                return $resp;
            }

            return response(['result' => 1, "msg" => "Success"], 200);
        } catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }


    }

    public function assign_permission_type(Request $request){

        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'permission_id' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                    new CheckIfPermissionTypeExists()
                ],
                'admin_user_type_id_array' => [
                    "required",
                    "json",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],

            ]);
            if ($validator->fails()) {
                $resp = response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 400);
                return $resp;
            }


            AdminUserTypePermission::where('permission_id',$data['permission_id'])->delete();

            $created_admin_user_type_permissions = [];
            $admin_user_type_id_array = json_decode($data['admin_user_type_id_array'],true);
            foreach ($admin_user_type_id_array as $admin_user_type_id){




                try{
                    $create_data = [
                        'admin_user_type_id' => $admin_user_type_id,
                        'permission_id' => $data['permission_id']
                    ];

                    $created_record_id = AdminUserTypePermission::create($create_data)->record_id;
                    array_push($created_admin_user_type_permissions,$created_record_id);
                } catch (QueryException $e) {
                    PermissionType::where('permission_id',$data['permission_id'])->delete();

                    foreach ($created_admin_user_type_permissions as $created_admin_user_type_permission){
                        AdminUserTypePermission::where('record_id',$created_admin_user_type_permission)->delete();
                    }


                    $function_name = getcwd();
                    $resp = response(['result' => -1, 'msg' => $function_name . ' - Query Error=>' . $e->getMessage()], 400);
                    return $resp;
                }
            }




            return response(['result' => 1, "msg" => "Success"], 200);
        } catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }

    }

    public function insert_admin_user_type(Request $request)
    {

        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'admin_user_type_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);
            if ($validator->fails()) {
                $resp = response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 400);
                return $resp;
            }

            try{

                $created_record_id = AdminUserType::create($data)->admin_user_type_id;

            }catch (QueryException $e) {

                $function_name = getcwd();
                $resp = response(['result' => -1, 'msg' => $function_name . ' - Query Error=>' . $e->getMessage()], 400);
                return $resp;
            }

            return response(['result' => 1, "msg" => "Kayıt başarıyla eklendi"], 200);
        } catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }



    }

    public function delete_admin_user_type(Request $request)
    {
        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'admin_user_type_id' => [
                    "required",
                    "numeric",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);
            if ($validator->fails()) {
                $resp = response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 400);
                return $resp;
            }

            try{
                AdminUserType::where('admin_user_type_id',$data['admin_user_type_id'])->delete();
                AdminUserTypePermission::where('admin_user_type_id',$data['admin_user_type_id'])->delete();

            }catch (QueryException $e) {

                $function_name = getcwd();
                $resp = response(['result' => -1, 'msg' => $function_name . ' - Query Error=>' . $e->getMessage()], 400);
                return $resp;
            }

            return response(['result' => 1, "msg" => "Kayıt başarıyla silindi"], 200);
        } catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }


    }

    public function insert_tag(Request $request)
    {

        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'tag_name' => [
                    "required",
                    new OnlyLetterRule(),
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'is_active' => [
                    "required",
                    "boolean",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'display_name' => [
                    "required",
                    new OnlyLetterRule(),
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'tag_image' => 'required|image|mimes:png,jpg,jpeg|max:2048|dimensions:ratio=1',
            ]);
            if ($validator->fails()) {
                $resp = response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 400);
                return $resp;
            }



            if ($request->hasFile('tag_image')) {

                $original_file = $request->file('tag_image');

                $content_name_clean = preg_replace('/[^A-Za-z0-9\-]/', '', $original_file->getClientOriginalName());

                if (strlen($content_name_clean) > 30) {
                    $content_name_clean = substr($content_name_clean, 0, 10);
                }

                $date = date("Y-m-d");
                $time = date("h-i-s");

                $extension = $original_file->getClientOriginalExtension();

                $content_filename_small = $content_name_clean . $date."-".$time."." . $extension;

                $file_small = Image::make($original_file)->encode($extension);

                Storage::disk('tag_images')->put($content_filename_small, (string)$file_small);


            }

            try {
                $data["tag_image"] = URL::asset('uploads/tag_images/' . $content_filename_small);

                Tag::create($data);

            } catch (QueryException $e) {

                return response(['result' => -2, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }


            return response(['result' => 1, 'msg' => 'Kayıt başarıyla eklendi.'],200);

        } catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }



    }

    public function update_tag(Request $request){
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'tag_id' => [
                    "required",
                    "integer",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'tag_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'is_active' => [
                    "required",
                    "boolean",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'display_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {
                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
            }


            try {

                $tag_id = $data['tag_id'];
                unset($data['tag_id']);
                Tag::find($tag_id)->update(["tag_name"=>$data['tag_name'],
                                            "is_active"=>$data['is_active'],
                                            "display_name"=>$data['display_name']
                                         ]);

            } catch (QueryException $e) {

                return response(['result' => -2, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }




            return response(['result' => 1, 'msg' => 'Kayıt başarıyla güncellendi.']);

        } catch (\Exception $e) { // 'msg' =>'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.']
            return response(['result' => -997, 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__], 403);

        }
    }

    public function update_tag_image(Request $request){
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'tag_id' => [
                    "required",
                    "integer",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'tag_image' => 'required|image|mimes:png,jpg,jpeg|max:2048|dimensions:ratio=1',
            ]);

            if ($validator->fails()) {
                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
            }


            if ($request->hasFile('tag_image')) {

                $original_file = $request->file('tag_image');

                $content_name_clean = preg_replace('/[^A-Za-z0-9\-]/', '', $original_file->getClientOriginalName());

                if (strlen($content_name_clean) > 30) {
                    $content_name_clean = substr($content_name_clean, 0, 10);
                }

                $date = date("Y-m-d");
                $time = date("h-i-s");

                $extension = $original_file->getClientOriginalExtension();

                $content_filename_small = $content_name_clean . $date."-".$time."." . $extension;

                $file_small = Image::make($original_file)->encode($extension);

                Storage::disk('tag_images')->put($content_filename_small, (string)$file_small);


            }

            try {
                $data["tag_image"] = URL::asset('uploads/tag_images/' . $content_filename_small);



                $tag_id = $data['tag_id'];
                unset($data['tag_id']);
                Tag::find($tag_id)->update(["tag_image"=>$data['tag_image']]);

            } catch (QueryException $e) {

                return response(['result' => -2, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }




            return response(['result' => 1, 'msg' => 'Kayıt başarıyla güncellendi.']);

        } catch (\Exception $e) { // 'msg' =>'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.']
            return response(['result' => -997, 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__], 403);

        }
    }

    public function delete_tag(Request $request)
    {

        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'tag_id' => [
                    "required",
                    "integer",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);
            if ($validator->fails()) {
                $resp = response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 400);
                return $resp;
            }

            // Deleting tag
            try{
                // Getting tag imge in first place
                $img = Tag::where('tag_id',$data['tag_id'])->first('tag_image');

                Tag::where('tag_id',$data['tag_id'])->delete();

            }catch (QueryException $e) {

                $function_name = getcwd();
                $resp = response(['result' => -1, 'msg' => $function_name . ' - Query Error=>' . $e->getMessage()], 400);
                return $resp;
            }
            // Deleting tag image
            try{

                $img_url = $img['tag_image'];

                $img = explode('uploads',$img_url);

                if (File::exists(public_path('uploads/'.$img[1].''))) {
                    File::delete(public_path('uploads/'.$img[1].''));
                }

            }catch (QueryException $e) {

                $function_name = getcwd();
                $resp = response(['result' => -2, 'msg' => $function_name . ' - Query Error=>' . $e->getMessage()], 400);
                return $resp;
            }

            // Deleting tag from tag to subtags
            try{
                TagToSubTag::where('tag_id',$data['tag_id'])->delete();

            }catch (QueryException $e) {

                $function_name = getcwd();
                $resp = response(['result' => -3, 'msg' => $function_name . ' - Query Error=>' . $e->getMessage()], 400);
                return $resp;
            }

            return response(['result' => 1, "msg" => "Kayıt başarıyla silindi"], 200);
        } catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }


    }

    public function insert_subtag(Request $request)
    {

        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'sub_tag_name' => [
                    "required",
                    new OnlyLetterRule(),
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'tags' => [
                    "required",
                    "json",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'is_active' => [
                    "required",
                    "boolean",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'display_name' => [
                    "required",
                    new OnlyLetterRule(),
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);
            if ($validator->fails()) {
                $resp = response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 400);
                return $resp;
            }

            $tags = json_decode($data['tags']);

            // If there is no selected tag
            if($tags== null || empty($tags) || count($tags) <= 0){
                return response(['result' => -1, 'msg' => 'Her alt kategori en az bir kategoriye ait olmalı. Lütfen kategori ekleyiniz.'], 400);
            }

            // Insert subtag to table
            try {

                $created_subtag_id = SubTag::create($data)->sub_tag_id;

            } catch (QueryException $e) {

                    return response(['result' => -2, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
                }

            // Insert tags of the subtags
            try {
                foreach($tags as $tag) {
                    TagToSubTag::create(["sub_tag_id" => $created_subtag_id,
                        "tag_id" => $tag]);
                }

            } catch (QueryException $e) {

                SubTag::where('sub_tag_id',$created_subtag_id)->delete();
                return response(['result' => -3, 'msg' => 'Query Error=>' . $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__], 400);
            }

            return response(['result' => 1, 'msg' => 'Kayıt başarıyla eklendi.'],200);

        } catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }



    }

    public function update_subtag(Request $request)
    {

        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'sub_tag_id' => [
                    "required",
                   'integer',
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'sub_tag_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'tags' => [
                    "required",
                    "json",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'is_active' => [
                    "required",
                    "boolean",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'display_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);
            if ($validator->fails()) {
                $resp = response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 400);
                return $resp;
            }

            $tags = json_decode($data['tags']);
            unset($data['tags']);

            // If there is no selected tag
            if($tags== null || empty($tags) || count($tags) <= 0){
                return response(['result' => -1, 'msg' => 'Her alt kategori en az bir kategoriye ait olmalı. Lütfen kategori ekleyiniz.'], 400);
            }

            $subtag_id = $data['sub_tag_id'];
            unset($data['sub_tag_id']);

            // Update subtag
            try {
                SubTag::find($subtag_id)->update($data);

            } catch (QueryException $e) {

                    return response(['result' => -2, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
                }

            // Delete all tags of the subtags
            try {

                TagToSubTag::where('sub_tag_id',$subtag_id)->delete();

            } catch (QueryException $e) {

                return response(['result' => -3, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }

            // Update tags of the subtags
            try {

                foreach($tags as $tag) {
                    TagToSubTag::create(["sub_tag_id" => $subtag_id,
                        "tag_id" => $tag]);
                }

            } catch (QueryException $e) {

                SubTag::where('sub_tag_id',$subtag_id)->delete();
                return response(['result' => -4, 'msg' => 'Query Error=>' . $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__], 400);
            }

            return response(['result' => 1, 'msg' => 'Kayıt başarıyla eklendi.'],200);

        } catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }



    }

    public function delete_subtag(Request $request)
    {

        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'sub_tag_id' => [
                    "required",
                    "integer",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);
            if ($validator->fails()) {
                $resp = response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 400);
                return $resp;
            }

            try{
                SubTag::where('sub_tag_id',$data['sub_tag_id'])->delete();

            }catch (QueryException $e) {

                $function_name = getcwd();
                $resp = response(['result' => -1, 'msg' => $function_name . ' - Query Error=>' . $e->getMessage()], 400);
                return $resp;
            }

            try{
                TagToSubTag::where('sub_tag_id',$data['sub_tag_id'])->delete();

            }catch (QueryException $e) {

                $function_name = getcwd();
                $resp = response(['result' => -1, 'msg' => $function_name . ' - Query Error=>' . $e->getMessage()], 400);
                return $resp;
            }

            return response(['result' => 1, "msg" => "Kayıt başarıyla silindi"], 200);
        } catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }


    }

    public function insert_user(Request $request){
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'first_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'last_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'email' => [
                    "required",
                    "email",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                    new Exist_Already_Email_AdminUser()
                ],
                'phone' => [
                    "required",
                    'digits_between:10,11',
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'password' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'is_confirmed' => [
                    "required",
                    "boolean",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {
                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
            }



            try {

                User::create($data);

            } catch (QueryException $e) {

                return response(['result' => -1, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }


            return response(['result' => 1, 'msg' => 'Kayıt başarıyla eklendi.']);

        } catch (\Exception $e) { // 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__
            return response(['result' => -997, 'msg' => 'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.']);

        }
    }

    public function update_user(Request $request){
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'user_id' => [
                    "required",
                    "integer",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'company_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'first_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'last_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'email' => [
                    "required",
                    "email",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),

                ],
                'phone' => [
                    "required",
                    'digits_between:10,11',
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'password' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'is_confirmed' => [
                    "required",
                    "boolean",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {
                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
            }


            try {

                $user_id = $data['user_id'];
                unset($data['user_id']);
                User::find($user_id)->update($data);


            } catch (QueryException $e) {

                return response(['result' => -1, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }


            return response(['result' => 1, 'msg' => 'Kayıt başarıyla güncellendi.']);

        } catch (\Exception $e) { // 'msg' => 'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.'
            return response(['result' => -997, 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__]);

        }
    }

    public function delete_user(Request $request)
    {

        try{
            $data = $request->all();
            $validator = Validator::make($data, [
                'user_id' => [
                    "required",
                    "numeric",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);
            if ($validator->fails()) {
                $resp = response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 400);
                return $resp;
            }

            try{
                User::where('user_id',$data['user_id'])->delete();

            }catch (QueryException $e) {

                $function_name = getcwd();
                $resp = response(['result' => -1, 'msg' => $function_name . ' - Query Error=>' . $e->getMessage()], 400);
                return $resp;
            }

            return response(['result' => 1, "msg" => "Kayıt başarıyla silindi"], 200);
        } catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }


    }

    public function fill_datatable(Request $request){
        try {


            $data = $request->all();

            $validator = Validator::make($data,[

                'table' => [
                    "required",
                    "string",
                    'regex:/(^[A-Za-z0-9\ _."]+$)+/', //only number letter and space and dot

                ],
                'primary_key' => [
                    "required",
                    "string",
                    'regex:/(^[A-Za-z0-9\_]+$)+/', //only number letter and space and dot

                ],
                'where' => [
                    "nullable",
                ],
                'post_or_get' => [
                    "required",
                    "string"
                ]

            ]);



            if($validator->fails()){
                $resp = response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 400);
                return $resp;
            }


            $table = $data['table'];
            $primary_key = $data['primary_key'];
            $where = $data['where'];
            $post_get_data = json_decode($data['post_or_get'],true);

            $columns = [];
            foreach ($data['columns'] as $column){
                if(!is_null($column['data'])){
                    array_push($columns,['db' => $column['data'],'dt' => $column['data']]);
                }

            }

            $sql_details = array(
                'user' => env('DB_USERNAME'),
                'db'   => env('DB_DATABASE'),
                'pass' => env('DB_PASSWORD'),
                'host' => env('DB_HOST'),
            );

            if(env('DB_TYPE') == 'mysql'){
                $ssp = new \SSP_MYSQL();
                return
                    $ssp::simple( $request, $sql_details, $table, $primary_key, $columns,$where)
                ;
            }
            if(env('DB_TYPE') == 'pgsql'){
                $ssp = new \SSP_PGSQL();
                return json_encode(
                    $ssp::simple( $request, $sql_details, $table, $primary_key, $columns,$where)
                );
            }



        }
        catch (\Throwable $t) {

            return response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__,"data"=>$data],500);


        }

    }

}
