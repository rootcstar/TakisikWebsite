<?php

namespace App\Http\Controllers;


use App\Models\ProductModel;
use App\Models\ProductModelAndImage;
use Illuminate\Support\Facades\DB;
use Session;

class WebsiteController extends Controller
{

    public function get_product($product_code, $mri = ''){
        if(empty($mri)){

            $product_data = DB::select("SELECT * FROM v_shop_products_with_tags WHERE product_code = '".$product_code."' ORDER BY model_number  asc");

            //Finding how many models
            $product_models = ProductModel::where('product_id',$product_data[0]->product_id)->get();

            $products = array();
            foreach ($product_models as $product_model) {

                $product = DB::select("SELECT * FROM v_shop_products_with_tags WHERE product_code = '".$product_code."' AND  model_number = '".$product_model->model_number."' ");

                ProductModelAndImage::where(['product_code'=>$product_code,'model_number'=>($product_model->model_number)])->get();
                array_push($products,$product[0]);
            }


            $models = ProductModelAndImage::where('product_code',$product_code)->get();

            // Finding product models
            foreach ($products as $product) {
                $product->product_image =array();
            }

            foreach ($models as $model) {
                foreach ($products as $product) {
                    if($product->model_number == $model->model_number){
                        array_push($product->product_image, $model->product_image);

                    }
                }
            }
            return $products;
        }


        $product_data = DB::select("SELECT * FROM v_shop_products_with_tags WHERE product_code = '".$product_code."' ORDER BY model_number  asc");

        //Finding how many models
        $product_models = ProductModel::where('product_id',$product_data[0]->product_id)->get();

        $products = array();
        foreach ($product_models as $product_model) {

            $product = DB::select("SELECT * FROM v_shop_products_with_tags WHERE product_code = '".$product_code."' AND  model_number = '".$mri."' ");
            ProductModelAndImage::where(['product_code'=>$product_code,'model_number'=>($product_model->model_number)])->get();
            array_push($products,$product[0]);
        }


        $models = ProductModelAndImage::where('product_code',$product_code)->get();

        // Finding product models
        foreach ($products as $product) {
            $product->product_image =array();
        }

        foreach ($models as $model) {
            foreach ($products as $product) {
                if($product->model_number == $model->model_number){
                    array_push($product->product_image, $model->product_image);

                }
            }
        }


        return $products;
    }
    public function get_test(){



        return  Session::get('website.user.user_info')->first_name;

        return view('test');
    }

    public function get_confirm_account_page(){
        $user_id = fiki_decrypt($_GET['user_id']);
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

        $products = $this->get_product($product_code);

        $cart_search_result = array_search($products[0]->model_record_id, array_column(Session::get('website.shopping_cart.products'), 'model_record_id')); // Gives false or index of the product in the arra
        $fav_search_result = array_search($products[0]->model_record_id, array_column(Session::get('website.user.favorites'), 'model_record_id'));



        return view('urun-detay')->with('product',$products[0])
                                ->with('product_models',$products)
                                ->with('product_images',$products[0]->product_image)
                                        ->with('qty',($cart_search_result !== false) ? Session::get('website.shopping_cart.products')[$cart_search_result]->quantity : 0 )
                                        ->with('tag_name',( isset($products[0]->tag_name)) ? $products[0]->tag_name : "ERROR" )
                                        ->with('sub_tag_name',(isset($products[0]->sub_tag_name)) ? $products[0]->sub_tag_name : "ERROR" )
                                        ->with('fav',($fav_search_result !== false) ? "fav" :"" )
                                        ->with('fav_text',($fav_search_result !== false) ? "FAVORİLERDEN ÇIKAR" :"FAVORİLERE EKLE" );
    }

    public function get_contact(){
        return view('iletisim');
    }

    public function get_shopping_cart_page(){


        $total_price = Session::get('website.shopping_cart.total_price');

        $cart_final_price = number_format($total_price + config('constants.cargo_price'),2,'.','');

        Session::put('website.shopping_cart.final_price',$cart_final_price);

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
    public function get_my_account_page(){

        return view('kullanici-bilgilerim');
    }
    public function get_account_info_page(){

        return view('kullanici-bilgilerim');
    }
    public function get_address_info_page(){

        return view('adres-bilgilerim');
    }
}
