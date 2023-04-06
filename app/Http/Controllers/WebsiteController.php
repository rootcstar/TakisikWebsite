<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class WebsiteController extends Controller
{
    public function get_test(){
        return view('test');
    }

    public function get_confirm_account_page(){
        $user_id = decrypt($_GET['user_id']);
        if($user_id != null | !empty($user_id)){


            try {

                DB::update("UPDATE users SET is_confirmed = ? WHERE user_id= ? ",[true,$user_id]);
                return view('hesap-onayi');
            } catch (QueryException $e) {

                return view('uyari');
            }
        }

    }

    public function get_new_password_page(){
        return view('yeni-sifre');
    }

    public function get_signin_page(){
        return view('uyelik');
    }
    public function get_register_page(){
        return view('yeni-uyelik');
    }

    public function get_index(){
        return view('index');
    }

    public function get_shopping_page(){
        return view('alisveris');
    }

    public function get_product_detail_page($product_name,$product_code){ // ACCORDING TO PRODUCTS THAT HAS MODEL NUMBER 1

      //  $model_record_id = decrypt($enc_model_record_id);

        $product_models_data = DB::select("SELECT * FROM v_shop_products_with_tags WHERE product_code = '".$product_code."' ORDER BY model_number  asc");

        $product_data = $product_models_data;

        $cart_search_result = array_search($product_data[0]->model_record_id, array_column(Session::get('shopping_cart.products'), 'model_record_id')); // Gives false or index of the product in the arra
        $fav_search_result = array_search($product_data[0]->model_record_id, array_column(Session::get('user.favorites'), 'model_record_id'));


        return view('urun-detay')->with('product',$product_data[0])
                                ->with('product_models',$product_models_data)
                                        ->with('qty',($cart_search_result !== false) ? Session::get('shopping_cart.products')[$cart_search_result]->quantity : 0 )
                                        ->with('tag_name',( isset($product_data[0]->tag_name)) ? $product_data[0]->tag_name : "ERROR" )
                                        ->with('sub_tag_name',(isset($product_data[0]->sub_tag_name)) ? $product_data[0]->sub_tag_name : "ERROR" )
                                        ->with('fav',($fav_search_result !== false) ? "fav" :"" )
                                        ->with('fav_text',($fav_search_result !== false) ? "FAVORİLERDEN ÇIKAR" :"FAVORİLERE EKLE" );
    }


    public function get_contact(){
        return view('iletisim');
    }

    public function get_shopping_cart_page(){
        return view('sepetim');
    }

    public function get_favs_page(){
        return view('favorilerim');
    }

    public function get_categories_page(){

        $tags = DB::select('SELECT * FROM tags WHERE is_active=true');

      //  return $tags;
        return view('kategoriler')->with('categories',$tags);
    }
}
