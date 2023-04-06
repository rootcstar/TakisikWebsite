<?php

namespace App\Http\Controllers;

use App\Rules\OnlyLetterRule;
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
    public function adminLogin(Request $request){
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

                    $password = decrypt($check_db[0]->password);

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

    public function fillDataTable(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($data, [
            'column' => [
                'regex:/(^[A-Za-z0-9\_"]+$)+/', //only number letter and space and dot
            ],
            'datatable_name' => [
                'required',
            ],
            'primary_key' => [
                'required',
            ],
            'cols' => [
                'required',
            ]


        ]);

        if ($validator->fails()) {
            return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
        }

        $table = $data['datatable_name'];
        $where = "";
        $primary_key = $data['primary_key'];

        // return decrypt($data['cols']);
        $cols = decrypt($data['cols']);
        $cols = json_decode($cols, true);

        $columns = array();
        foreach ($cols as $col) {
            array_push($columns, array('db' => '' . $col . '', 'dt' => '' . $col . ''));
        }

        $method = 'get';
        $sql_details = array(
            'user' => env('DB_USERNAME'),
            'db' => env('DB_DATABASE'),
            'pass' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
        );

        //return 'here';

        $ssp = new \SSP();
        return json_encode(
            $ssp::simple($_GET, $sql_details, $table, $primary_key, $columns, $where)
        );

        return $response;


    }

    public function deleteRecord(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'table_name' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'primary_key_id' => [ // User ID
                    "required",
                    "numeric",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ]

            ]);

            if ($validator->fails()) {
                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
            }

            if($data['table_name'] == 'users'){ // Musteri silme

                // Musteri Bilgilerinin kontrol edilip silinmesi

                $billing_address_check = DB::select("SELECT * FROM user_billing_addresses WHERE user_id = '".$data['primary_key_id']."'");
                if($billing_address_check != null || !empty($billing_address_check)){

                    try{
                        DB::table('user_billing_addresses')->where('user_id',$data['primary_key_id'])->delete();
                    }catch(QueryException $e){
                        return response(['result' => -5, 'message' => 'Query Error=>' . $e->getMessage()], 400);
                    }
                }

                $shipping_address_check = DB::select("SELECT * FROM user_shipping_addresses WHERE user_id = '".$data['primary_key_id']."'");
                if($shipping_address_check != null || !empty($shipping_address_check)){

                    try{
                        DB::table('user_shipping_addresses')->where('user_id',$data['primary_key_id'])->delete();
                    }catch(QueryException $e){
                        return response(['result' => -5, 'message' => 'Query Error=>' . $e->getMessage()], 400);
                    }
                }

                $cards_check = DB::select("SELECT * FROM user_cards WHERE user_id = '".$data['primary_key_id']."'");
                if($cards_check != null || !empty($cards_check)){
                    try{
                        DB::table('user_cards')->where('user_id',$data['primary_key_id'])->delete();
                    }catch(QueryException $e){
                        return response(['result' => -5, 'message' => 'Query Error=>' . $e->getMessage()], 400);
                    }
                }

                $favs_check = DB::select("SELECT * FROM user_fav_items WHERE user_id = '".$data['primary_key_id']."'");
                if($favs_check != null || !empty($favs_check)) {

                    try{
                        DB::table('user_fav_items')->where('user_id', $data['primary_key_id'])->delete();
                    }catch(QueryException $e){
                        return response(['result' => -5, 'message' => 'Query Error=>' . $e->getMessage()], 400);
                    }
                }

                $discounts_check = DB::select("SELECT * FROM user_discounts WHERE user_id = '".$data['primary_key_id']."'");
                if($discounts_check != null || !empty($discounts_check)){

                    try{
                        DB::table('user_discounts')->where('user_id',$data['primary_key_id'])->delete();
                    }catch(QueryException $e){
                        return response(['result' => -5, 'message' => 'Query Error=>' . $e->getMessage()], 400);
                    }
                }


            }



            $table_name = $data['table_name'];


            $my_database = env('DB_DATABASE');// Finding primary key of table
            $table_primary_key = DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$my_database' AND TABLE_NAME = '$table_name' AND COLUMN_KEY = 'PRI';");

            $photo_control = DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$my_database' AND TABLE_NAME = '$table_name' AND ( COLUMN_NAME LIKE '%resmi%'
                                                                                                                                                                           OR COLUMN_NAME LIKE '%foto%'
                                                                                                                                                                           OR COLUMN_NAME LIKE '%resim%');");

            if($photo_control != null || !empty($photo_control))
            {
                for($i=0; $i<count($photo_control); $i++)
                {
                    $column_name = $photo_control[$i]->COLUMN_NAME; // photo, resim. etc.

                    // select all row of deleting record
                    $selected_record = DB::select("SELECT * FROM $table_name WHERE " . $table_primary_key[0]->COLUMN_NAME . "=" . $data['primary_key_id'] . ";");

                    $photo_path = explode('https://tuzenkimya.com/', $selected_record[0]->$column_name); // 0->tuzenkimya.com 1->photo path

                    if (!File::exists(public_path(''.$photo_path[1].''))) {

                        return response(['result' => -7, 'msg' => 'Üzgünüz resim dosyalarda bulunamadı.'], 200);

                    }
                    File::delete(public_path(''.$photo_path[1].''));
                    /*    Delete Multiple files this way
                          Storage::delete(['upload/test.png', 'upload/test2.png']);
                      */

                }

            }

            try{
                DB::table($table_name)->where($table_primary_key[0]->COLUMN_NAME, $data['primary_key_id'])->delete();

            }catch(QueryException $e){
                return response(['result' => -5, 'message' => 'Query Error=>' . $e->getMessage()], 400);
            }

            return response(['result' => 1, 'msg' => 'Kayıt başarıyla silindi.'],200);

        } catch (\Exception $e) { // 'msg' => 'Bir hata oluştu. Lütfen developer ile iletişime geçiniz'
            return response(['result' => -997, 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__]);

        }

    }

    public function addAdminUsers(Request $request){
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
                'phone' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
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

            $data['password'] = encrypt($data['password']);

            try {

                DB::table('admin_users')->insert($data);

            } catch (QueryException $e) {

                return response(['result' => -1, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }


            return response(['result' => 1, 'msg' => 'Kayıt başarıyla eklendi.']);

        } catch (\Exception $e) { // 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__
            return response(['result' => -997, 'msg' => 'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.']);

        }
    }

    public function updateAdminUser(Request $request)
    {

        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'admin_id' => [
                    "required",
                    "integer",
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
                'phone' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
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
            $data['password'] = encrypt($data['password']);

            try {
                DB::table('admin_users')->where("admin_id", $data['admin_id'])->update($data);

            } catch (QueryException $e) {

                return response(['result' => -1, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }


            return response(['result' => 1, 'msg' => 'Kayıt başarıyla güncellendi.']);

        } catch (\Exception $e) { // 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__
            return response(['result' => -997, 'msg' => 'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.']);

        }


    }

    public function addTag(Request $request){
        try {
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
                'tag_image' => 'required|image|mimes:png,jpg,jpeg|max:2048|dimensions:ratio=1',
            ]);

            if ($validator->fails()) {
                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
            }

            $data['url_name'] = Str::slug($data['tag_name']);

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
                $data["tag_image"] = URL::asset('tag_images/' . $content_filename_small);


                DB::table('tags')->insert($data);

            } catch (QueryException $e) {

                return response(['result' => -2, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }

            $tags_table_data_array = array();

            $tags_table_data['table_id'] =  'tags';
            $my_database = env('DB_DATABASE');
            $tags_table_columns = DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA =  '$my_database' AND TABLE_NAME = 'tags' ORDER BY ORDINAL_POSITION;");

            $tags_columns_array = array();
            foreach($tags_table_columns as $columns){
                array_push($tags_columns_array,$columns->COLUMN_NAME); // for mysql
            }

            if(count($tags_table_columns) == 0){
                return abort(404);
            }

            // return $table_columns;
            $tags_table_data['table_fields'] = $tags_columns_array;
            $tags_table_data['table_name'] = 'tags';
            $tags_table_data['url_end'] = 'tags';


            array_push($tags_table_data_array,$tags_table_data);

            $table_content = view('admin.partials.show_table_content', ["table_data" => $tags_table_data_array])->render();

            return response(['result' => 1, 'msg' => 'Kayıt başarıyla eklendi.', 'content' => $table_content]);

        } catch (\Exception $e) { // 'msg' =>'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.']
            return response(['result' => -997, 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__], 403);

        }
    }

    public function updateTag(Request $request){
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
                'tag_image' => 'required|image|mimes:png,jpg,jpeg|max:2048|dimensions:ratio=1',
            ]);

            if ($validator->fails()) {
                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
            }
            $data['url_name'] = Str::slug($data['tag_name']);

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
                $data["tag_image"] = URL::asset('tag_images/' . $content_filename_small);


                DB::table('tags')->where("tag_id", $data['tag_id'])->update($data);

            } catch (QueryException $e) {

                return response(['result' => -2, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }




            return response(['result' => 1, 'msg' => 'Kayıt başarıyla güncellendi.']);

        } catch (\Exception $e) { // 'msg' =>'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.']
            return response(['result' => -997, 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__], 403);

        }
    }

    public function addSubtag(Request $request){
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
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
                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
            }

            $data['url_name'] = Str::slug($data['display_name']);


            try {

                $tags = json_decode($data['tags']);

                // If there is no selected tag
                if($tags== null || empty($tags) || count($tags) <= 0){
                    return response(['result' => -1, 'msg' => 'Her alt kategori en az bir kategoriye ait olmalı. Lütfen kategori ekleyiniz.'], 400);
                }

                // Insert subtag to table
                try {
                    DB::table('sub_tags')->insert(["sub_tag_name"=>$data['sub_tag_name'],
                                                        "is_active"=>$data['is_active'],
                                                        "display_name"=>$data['display_name'],
                                                        "url_name"=>$data['url_name']]);

                } catch (QueryException $e) {

                    return response(['result' => -2, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
                }

                // Insert tags of the subtags
                foreach($tags as $tag){
                    try {
                        $data_st = DB::select('SELECT * FROM sub_tags WHERE last_updated = (SELECT max(last_updated) FROM sub_tags)');
                        DB::table('tag_to_sub_tags')->insert(["sub_tag_id"=>$data_st[0]->sub_tag_id,"tag_id"=>$tag]);

                    } catch (QueryException $e) {
                        return response(['result' => -3, 'msg' => 'Query Error=>' . $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__], 400);
                    }
                }

            } catch (QueryException $e) {

                return response(['result' => -4, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }

            $subtags_table_data_array = array();

            $subtags_table_data['table_id'] =  'sub_tags';
            $my_database = env('DB_DATABASE');
            $subtags_table_columns = DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA =  '$my_database' AND TABLE_NAME = 'sub_tags' ORDER BY ORDINAL_POSITION;");

            $subtags_columns_array = array();
            foreach($subtags_table_columns as $columns){
                array_push($subtags_columns_array,$columns->COLUMN_NAME); // for mysql
            }

            if(count($subtags_table_columns) == 0){
                return abort(404);
            }

            // return $table_columns;
            $subtags_table_data['table_fields'] = $subtags_columns_array;
            $subtags_table_data['table_name'] = 'tags';
            $subtags_table_data['new_link'] = "/admin/subtags/yeni";
            $subtags_table_data['url_end'] = 'tags';


            array_push($subtags_table_data_array,$subtags_table_data);

            $table_content = view('admin.partials.show_table_content', ["table_data" => $subtags_table_data_array])->render();

            return response(['result' => 1, 'msg' => 'Kayıt başarıyla eklendi.', 'content' => $table_content]);

        } catch (\Exception $e) { // 'msg' =>'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.']
            return response(['result' => -997, 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__], 403);

        }
    }

    public function updateSubtag(Request $request){
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'sub_tag_id' => [
                    "required",
                    "integer",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'sub_tag_name' => [
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
                'display_order' => [
                    "integer",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {
                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
            }

            $data['url_name'] = Str::slug($data['display_name']);

            // Insert subtag to table
            try {
                DB::table('sub_tags')->where('sub_tag_id',$data['sub_tag_id'])->update(["sub_tag_name"=>$data['sub_tag_name'],
                                                    "is_active"=>$data['is_active'],
                                                    "display_name"=>$data['display_name'],
                                                    "display_order"=>$data['display_order'],
                                                    "url_name"=>$data['url_name']]);

            } catch (QueryException $e) {

                return response(['result' => -2, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }

            return response(['result' => 1, 'msg' => 'Kayıt başarıyla güncellendi.']);

        } catch (\Exception $e) { // 'msg' =>'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.']
            return response(['result' => -997, 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__], 403);

        }
    }

    public function updateTagsOfSubtag(Request $request){
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'sub_tag_id' => [
                    "required",
                    "integer",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'tags' => [
                    "required",
                    "json",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {
                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
            }


            try {

                $tags = json_decode($data['tags']);

                // If there is no selected tag
                if($tags== null || empty($tags) || count($tags) <= 0){
                    return response(['result' => -1, 'msg' => 'Her alt kategori en az bir kategoriye ait olmalı. Lütfen kategori ekleyiniz.'], 400);
                }

                // Part 1 - Deleting all tags of this subtag
                try {
                    DB::table('tag_to_sub_tags')->where('sub_tag_id',$data['sub_tag_id'])->delete();

                } catch (QueryException $e) {

                    return response(['result' => -2, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
                }

                // Part 2 - Insert tags of the subtags
                foreach($tags as $tag){
                    try {

                        DB::table('tag_to_sub_tags')->insert(["sub_tag_id"=>$data['sub_tag_id'],"tag_id"=>$tag]);

                    } catch (QueryException $e) {
                        return response(['result' => -3, 'msg' => 'Query Error=>' . $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__], 400);
                    }
                }

            } catch (QueryException $e) {

                return response(['result' => -4, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }



            return response(['result' => 1, 'msg' => 'Kayıt başarıyla eklendi.']);

        } catch (\Exception $e) { // 'msg' =>'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.']
            return response(['result' => -997, 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__], 403);

        }
    }

    public function showTable(Request $request){
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'table_id' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {
                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);
            }

            $table_name = decrypt($data['table_id']);

            $tables_data_array = array();

            $my_database = env('DB_DATABASE');
            $table_columns = DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA =  '$my_database' AND TABLE_NAME = '$table_name' ORDER BY ORDINAL_POSITION;");

            $columns_array = array();
            foreach($table_columns as $columns){
                array_push($columns_array,$columns->COLUMN_NAME); // for mysql
            }

            if(count($table_columns) == 0){
                return abort(404);
            }

            // return $table_columns;
            $table_data['table_fields'] = $columns_array;
            $table_data['table_name'] = $table_name;
            $table_data['new_link'] = "/admin/". $table_name."/yeni";
            $table_data['url_end'] = $table_name;
            $table_data['table_id'] = $table_name;

            array_push($tables_data_array,$table_data);

            $table_content = view('admin.partials.show_table_content', ["table_data" => $tables_data_array])->render();


            return response(['result' => 1, 'table_content' => $table_content, 'table_name' => $table_name], 200);

        } catch (\Exception $e) { // 'msg' =>'Bir hata oluştu. Lütfen developer ile iletişime geçiniz.']
            return response(['result' => -997, 'msg' => $e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__], 403);

        }
    }

}
