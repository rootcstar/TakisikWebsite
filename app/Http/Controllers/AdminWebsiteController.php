<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function get_home(){
        return view('admin.index');
    }

    public function get_general(Request $request){

        $tables_data_array = array();
        $path =  explode('/',$request->path());
        $url_end = $path[count($path)-1];

        if($url_end === 'tag_details'){

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
            $tags_table_data['new_link'] = "/admin/tags/yeni";
            $tags_table_data['url_end'] = 'tags';


            array_push($tags_table_data_array,$tags_table_data);


            return view('admin.tag_details')->with('tags_table_data',$tags_table_data_array[0]);
        }

      /*
        if($url_end === 'personal'){

            // First table is
            $personal_table_data_array = array();
            $personal_table_data['table_id'] =  'v_personal_accounts';
            $my_database = env('DB_DATABASE');
            $personal_table_columns = DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA =  '$my_database' AND TABLE_NAME = 'v_personal_accounts' ORDER BY ORDINAL_POSITION;");

            $personal_columns_array = array();
            foreach($personal_table_columns as $columns){
                array_push($personal_columns_array,$columns->COLUMN_NAME); // for mysql
            }

            if(count($personal_table_columns) == 0){
                return abort(404);
            }

            // return $table_columns;
            $personal_table_data['table_fields'] = $personal_columns_array;
            $personal_table_data['table_name'] = 'v_personal_accounts';
            $personal_table_data['new_link'] = "/admin/personal/yeni";
            $personal_table_data['url_end'] = 'personal';


            array_push($personal_table_data_array,$personal_table_data);


            return view('admin.personal')->with('admin_table_data',$personal_table_data_array[0]);
        }
        if($url_end === 'company'){

            // First table is ADMIN
            $personal_table_data_array = array();
            $personal_table_data['table_id'] =  'v_company_accounts';
            $my_database = env('DB_DATABASE');
            $personal_table_columns = DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA =  '$my_database' AND TABLE_NAME = 'v_company_accounts' ORDER BY ORDINAL_POSITION;");

            $personal_columns_array = array();
            foreach($personal_table_columns as $columns){
                array_push($personal_columns_array,$columns->COLUMN_NAME); // for mysql
            }

            if(count($personal_table_columns) == 0){
                return abort(404);
            }

            // return $table_columns;
            $personal_table_data['table_fields'] = $personal_columns_array;
            $personal_table_data['table_name'] = 'company';
            $personal_table_data['new_link'] = "/admin/company/yeni";
            $personal_table_data['url_end'] = 'company';


            array_push($personal_table_data_array,$personal_table_data);


            return view('admin.company')->with('admin_table_data',$personal_table_data_array[0]);
        }
      */


        $table_data['table_id'] =  $url_end;
        $my_database = env('DB_DATABASE');
        $table_columns = DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA =  '$my_database' AND TABLE_NAME = '$url_end' ORDER BY ORDINAL_POSITION;");

        $columns_array = array();
        foreach($table_columns as $columns){
            array_push($columns_array,$columns->COLUMN_NAME); // for mysql
        }

        if(count($table_columns) == 0){
            return abort(404);
        }

        // return $table_columns;
        $table_data['table_fields'] = $columns_array;
        $table_data['table_name'] = $url_end;
        $table_data['new_link'] = "/admin/". $url_end."/yeni";
        $table_data['url_end'] = $url_end;


        array_push($tables_data_array,$table_data);


        return view('admin.general')->with('table_data',$tables_data_array);

    }

    public function get_add_page(Request $request){


        $path =  explode('/',$request->path());
        $table_name  = $path[count($path)-2]; // urunler/ we use table name in url


        return view('admin.adds.'.$table_name.'-add');

    }

    public function get_detail_page($table_name,$id,Request $request){ // UPDATE PAGE

        $my_database = env('DB_DATABASE');

   //     $path =  explode('/',$request->path());
   //     $table_name  = $path[count($path)-3]; // urunler/1 we use table name in url
   //     $pk_id = $path[count($path)-1];
      //  return $ids;
        //get the name of the primary key
        $table_columns = DB::select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA =  '$my_database' AND TABLE_NAME = '$table_name' ORDER BY ORDINAL_POSITION;");
        $primary_key_name = $table_columns[0]->COLUMN_NAME;

        $data = DB::table($table_name)->where($primary_key_name,$id)->get();

        $data = json_encode($data[0]);


        return view('admin.updates.'.$table_name.'-update')->with('data',json_decode($data,true));

    }

}
