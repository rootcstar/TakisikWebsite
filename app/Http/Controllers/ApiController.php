<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Neighbourhood;
use App\Models\User;
use App\Models\UserBillingAddress;
use App\Models\UserShippingAddress;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Rules\PasswordRule;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmAccountMail;
use App\Mail\ForgetPasswordMail;
use Session;

class ApiController extends Controller
{
    public function set_sessions_for_login($user_id)
    {

        // Logged In
        Session::put('website.is_login', true);

    }

    public function set_sessions_for_shopping($user_id)
    {


        $tags = DB::select('SELECT * FROM tags WHERE is_active=true');
        Session::put('website.shopping.tags', $tags);

        $subtags = DB::select('SELECT * FROM sub_tags WHERE is_active=true');
        Session::put('website.shopping.sub_tags', $subtags);


        if (!Session::has('website.selected_tag')) {

            $default_products = DB::select("SELECT * FROM v_shop_products_with_tags WHERE tag_id='" . $tags[0]->tag_id . "' AND model_number ='1'  GROUP BY product_code ORDER BY product_id ASC LIMIT 9");
            Session::put('website.selected_tag', $tags[0]->tag_id);

            $data_sub_tags = DB::select("SELECT * FROM v_tag_to_sub_tags WHERE tag_id = '" . $tags[0]->tag_id . "'");
            Session::put('website.sub_tag_filter_bar', $data_sub_tags);

        } else {

            $default_products = DB::select("SELECT * FROM v_shop_products_with_tags WHERE tag_id='" . Session::get('website.selected_tag') . "'  AND model_number ='1' GROUP BY product_code ORDER BY product_id ASC LIMIT 9");

            $data_sub_tags = DB::select("SELECT * FROM v_tag_to_sub_tags WHERE tag_id = '" . Session::get('website.selected_tag') . "'");
            Session::put('website.sub_tag_filter_bar', $data_sub_tags);
        }


        Session::put('website.default_products', $default_products);


        $user_fav_products_data = DB::select("SELECT * FROM v_user_favs_with_details WHERE user_id = '" . $user_id . "'");
        $user_billing_address_data = UserBillingAddress::where(['user_id'=>$user_id,'is_deleted'=>false])->get();
        $user_shipping_address_data = UserShippingAddress::where(['user_id'=>$user_id,'is_deleted'=>false])->get();

        Session::put('website.user.billing_addresses', $user_billing_address_data);
        Session::put('website.user.shipping_addresses', $user_shipping_address_data);
        Session::put('website.user.favorites', $user_fav_products_data);

        $data_user_discount = DB::select("SELECT * FROM user_discounts WHERE user_id= '" . $user_id . "'");
        $user_discount = 0;
        if (!empty($data_user_discount)) {
            $user_discount = $data_user_discount[0]->discount_percentage;
        }
        Session::put('website.user.user_discount', $user_discount);


    }
    public function signin(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'email' => [
                    "email",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'password' => [
                    new PasswordRule(),
                    "string",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'account_type' => [
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }

            $account_type = $data['account_type'];


            $user_data = DB::select("SELECT * FROM users WHERE email = '" . $data['email'] . "' AND account_type = '".$account_type."'");

            if (empty($user_data) || $user_data == null) {
                return response(['result' => -1, "msg" => 'Bu email adresine ait bir hesap bulunamamaktadır.'], 200);
            }

            if (fiki_decrypt($user_data[0]->password) != $data['password']) {
                return response(['result' => -2, "msg" => 'Lütfen şifrenizi doğru girdiğinizden emin olun.'], 200);
            }


            if($user_data[0]->is_confirmed != 1){
                return response(['result' => -2, "msg" => "Mailinizi kontrol ederek hesabınızın onaylandığından emin olunuz."], 200);
            }



            Session::put('website.is_login', true);
            Session::put('website.user.user_info', $user_data[0]);
            Session::put('website.shopping_cart.products', array());
            $this->set_sessions_for_shopping($user_data[0]->user_id);


            return response(['result' => 1, "msg" => "Lütfen bekleyiniz."], 200);





        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }


    }
    public function forget_password(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'email' => [
                    "email",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }

            $user_data = DB::select("SELECT * FROM users WHERE email = '" . $data['email'] . "'");

            if (empty($user_data) || $user_data == null) {
                return response(['result' => -2, "msg" => 'Bu email adresine ait bir hesap bulunmamaktadır.'], 200);
            }

            try {

                $user = DB::select("SELECT * FROM `users` WHERE email='" . $data['email'] . "' ORDER BY user_id DESC LIMIT 1");
                $data['user_id'] = $user[0]->user_id;

            } catch (QueryException $e) {

                return response(['result' => -3, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }


            Mail::to($data['email'])->send(new ForgetPasswordMail($data));
            return response(['result' => 1, "msg" => 'Emailinizi kontrol edin!'], 200);


        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }
    }
    public function new_password(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'control' => [                      // USER ID
                    "string",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'password' => [
                    new PasswordRule(),
                    "string",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'password_ctrl' => [
                    new PasswordRule(),
                    "string",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);
            $data['control'] = fiki_decrypt($data['control']);
            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }

            $user_data = DB::select("SELECT * FROM users WHERE user_id = '" . $data['control'] . "'");

            if (empty($user_data) || $user_data == null) {
                return response(['result' => -2, "msg" => 'Böyle bir hesap bulunmamaktadır.'], 200);
            }

            if ($data['password'] !== $data['password_ctrl']) {
                return response(['result' => -3, "msg" => 'Şifreler birbiriyle uyumlu değil. Lütfen tekrar giriniz.'], 200);
            }


            DB::update("UPDATE users SET password = ? WHERE user_id= ? ", [fiki_encrypt($data['password']), $data['control']]);


            return response(['result' => 1, "msg" => 'Şifreniz yenilendi. Alışverişe başlayabilisiniz!'], 200);


        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }
    }
    public function register(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'account_type' => [
                    "required",
                    "numeric",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'company_name' => [
                    Rule::requiredIf(fn () => ($request->account_type == 2)),
                    "nullable",
                    "string",
                    "regex:/(^[A-Za-z .-]+$)+/",
                ],
                'first_name' => [
                    "required",
                    "string",
                    "regex:/(^[A-Za-z .-]+$)+/",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'last_name' => [
                    "required",
                    "string",
                    "regex:/(^[A-Za-z .-]+$)+/",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'email' => [
                    "required",
                    "email",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'country_code' => [
                    "required",
                    "integer",
                    "digits_between:1,5",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'phone' => [
                    "required",
                    "string",
                    'regex:/(^[0-9\ +]+$)+/',
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'password' => [
                    "required",
                    new PasswordRule(),
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ]
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" =>  $validator->errors()->first(), 'error' => $validator->errors()->keys()], 403);

            }



            $check_email_exist = DB::select("SELECT * FROM users WHERE email='" . $data['email'] . "'");

            if ($check_email_exist != null || !empty($check_email_exist)) {

                return response(['result' => -2, "msg" => 'Bu email adresine ait bir hesap bulunmakta.'], 200);
            }

            try {

                $data['password'] = fiki_encrypt($data['password']);
                DB::table('users')->insert($data);
                $user = DB::select("SELECT * FROM `users` WHERE email='" . $data['email'] . "' ORDER BY user_id DESC LIMIT 1");
                $data['user_id'] = $user[0]->user_id;

            } catch (QueryException $e) {

                return response(['result' => -3, 'msg' => 'Query Error=>' . $e->getMessage()], 400);
            }

            Mail::to($data['email'])->send(new ConfirmAccountMail($data));
            return response(['result' => 1, "title" => 'Son bir adım kaldı!',
                              "msg" => 'Size hesabınızı onaylayabilmeniz için bir mail yolladık. Mailinizi kontrol edin ve hemen alişverişe başlayın!'], 200);

        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }

        return response(['result' => -1, "msg" => 'Lütfen bekleyiniz.'], 200);
    }
    public function get_register_form(Request $request)
    {
        try {
            $data = $request->all();
            $data['id'] = fiki_decrypt($data['id']);
            $validator = Validator::make($data, [
                'id' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }

            if($data['id'] == 0){

                $form = view('partials.register-individual-form-content')->render();
                return response(['result' => 1, "form" => $form], 200);
            }

            if($data['id'] == 1){

                $form = view('partials.register-company-form-content')->render();
                return response(['result' => 1, "form" => $form], 200);
            }

            return response(['result' => -1, "msg" => 'Bir sorun oluştu. Lütfen yapmak istediğiniz işlemi tekrar deneyiniz.'], 200);

        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }

    }
    public function logout(){
        Session::forget('website');
        return redirect('/');
    }

    public function get_tag_products(Request $request)
    {
        try {
            $data = $request->all();

            $data['tag_id'] = fiki_decrypt($data['tag_id']);
            $data['sub_tag_id'] = fiki_decrypt($data['sub_tag_id']);
            $validator = Validator::make($data, [
                'tag_id' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'sub_tag_id' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }


            $data_products = DB::select("SELECT * FROM v_shop_products_with_tags WHERE tag_id = '" . $data['tag_id'] . "' AND model_number = 1 GROUP BY product_code ORDER BY product_id ASC LIMIT 9");

            $data_sub_tags = DB::select("SELECT * FROM v_tag_to_sub_tags WHERE tag_id = '" . $data['tag_id'] . "'");
            //return response(['result'=>-56,"msg"=>$data_sub_tag_ids[0]->sub_tag_display_name],200);
            //return response(['result'=>-91,"mas"=>json_encode($data_sub_tag_ids)],403);


            Session::put("website.selected_tag", $data['tag_id']);
            Session::put("website.selected_sub_tag", $data['sub_tag_id']);
            foreach ($data_products as $product) {
                $product->final_price = number_format(CalculateProductPrice($product->wholesale_price, $product->kdv, Session::get('website.user.user_discount')), 2, '.', '');
            }

            $products_div = view('partials.products-div', ["products" => $data_products, "empty_message" => "THERE ARE NO PRODUCT IN THIS CATEGORY"])->render();

            $sub_tag_filter = view('partials.sub-tag-filter', ["sub_tags" => $data_sub_tags])->render();

            if (count($data_products) < 9) {

                $load_more = '
            <div class="tt_item_all_js" style="display:block;">
                <a href="" class="btn btn-border01">NO MORE ITEM TO SHOW</a>
            </div>';
            } else {

                $load_more = '<a href="#" class="btn btn-border" onclick="LoadMore(\'' . fiki_encrypt($data['tag_id']) . '\',\'' . fiki_encrypt($data['sub_tag_id']) . '\',\'' . fiki_encrypt(9) . '\')">LOAD MORE</a>
            <div class="tt_item_all_js">
                <a href="" class="btn btn-border01">NO MORE ITEM TO SHOW</a>
            </div>';

            }

            $this->set_sessions_for_shopping(Session::get('website.user.user_id'));

            return response(['result' => 1, "products" => $products_div, "sub_tag_filter" => $sub_tag_filter, "load-more" => $load_more], 200);

        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }

    }
    public function get_sub_tag_products(Request $request)
    {
        try {
            $data = $request->all();

            $data['tag_id'] = fiki_decrypt($data['tag_id']);
            $data['sub_tag_id'] = fiki_decrypt($data['sub_tag_id']);
            $validator = Validator::make($data, [
                'tag_id' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'sub_tag_id' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }

            if ($data['sub_tag_id'] == 0) {
                $data_products = DB::select("SELECT * FROM v_shop_products_with_tags WHERE tag_id = '" . $data['tag_id'] . "'   AND model_number = 1  GROUP BY product_code  ORDER BY product_id ASC LIMIT 9");

            } else {
                $data_products = DB::select("SELECT * FROM v_shop_products_with_tags WHERE tag_id = '" . $data['tag_id'] . "' AND sub_tag_id = '" . $data['sub_tag_id'] . "'  AND model_number = 1  GROUP BY product_code  ORDER BY product_id ASC LIMIT 9");

            }


            //   return response(['result'=>-1,"msg"=>json_encode($data['tag_id'])],403);

            $data_sub_tags = DB::select("SELECT * FROM v_tag_to_sub_tags WHERE tag_id = '" . $data['tag_id'] . "'");

            Session::put("website.selected_tag", $data['tag_id']);
            Session::put("website.selected_sub_tag", $data['sub_tag_id']);
            foreach ($data_products as $product) {
                $product->final_price = number_format(CalculateProductPrice($product->wholesale_price, $product->kdv, Session::get('website.user.user_discount')), 2, '.', '');
            }

            $products_div = view('partials.products-div', ["products" => $data_products, "empty_message" => "THERE ARE NO PRODUCT IN THIS CATEGORY"])->render();
            $sub_tag_filter = view('partials.sub-tag-filter', ["sub_tags" => $data_sub_tags])->render();

            $load_more = '<a href="#" class="btn btn-border" onclick="LoadMore(\'' . fiki_encrypt($data['tag_id']) . '\',\'' . fiki_encrypt($data['sub_tag_id']) . '\',\'' . fiki_encrypt(9) . '\')">LOAD MORE</a>
            <div class="tt_item_all_js">
                <a href="" class="btn btn-border01">NO MORE ITEM TO SHOW</a>
            </div>';


            $this->set_sessions_for_shopping(Session::get('website.user.user_id'));

            return response(['result' => 1, "products" => $products_div, "sub_tag_filter" => $sub_tag_filter, "load-more" => $load_more], 200);

        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }

    }
    public function load_more(Request $request)
    {
        try {
            $data = $request->all();

            $data['tag_id'] = fiki_decrypt($data['tag_id']);
            $data['sub_tag_id'] = fiki_decrypt($data['sub_tag_id']);
            $data['start'] = fiki_decrypt($data['start']);
            $validator = Validator::make($data, [
                'tag_id' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'sub_tag_id' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'start' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }


            if ($data['sub_tag_id'] != 0) {
                $data_products = DB::select("SELECT * FROM v_shop_products_with_tags WHERE sub_tag_id = '" . $data['sub_tag_id'] . "' AND sub_tag_is_active ='1' and product_is_active = '1' GROUP BY product_code ORDER BY product_id ASC LIMIT 9 OFFSET ".$data['start']."");
                $count = count(DB::select("SELECT * FROM v_shop_products_with_tags WHERE sub_tag_id = '" . $data['sub_tag_id'] . "' AND sub_tag_is_active ='1' and product_is_active = '1' GROUP BY product_code"));

            } else {
                $data_products = DB::select("SELECT * FROM v_shop_products_with_tags WHERE tag_id = '" . $data['tag_id'] . "' AND tag_is_active  ='1' AND sub_tag_is_active ='1' and product_is_active = '1'  GROUP BY product_code ORDER BY product_id ASC LIMIT 9 OFFSET ".$data['start']."");
                $count = count(DB::select("SELECT * FROM v_shop_products_with_tags WHERE tag_id = '" . $data['tag_id'] . "' AND tag_is_active  ='1' AND sub_tag_is_active ='1' and product_is_active = '1' GROUP BY product_code"));

            }

            foreach ($data_products as $product) {
                $product->final_price = number_format(CalculateProductPrice($product->wholesale_price, $product->kdv, Session::get('website.user.user_discount')), 2, '.', '');
            }


            $products_div = view('partials.products-div', ["products" => $data_products, "empty_message" => ""])->render();

            if ($count <= $data['start']) {

                $load_more = '
        <div class="tt_item_all_js" style="display:block;">
            <a href="" class="btn btn-border01">NO MORE ITEM TO SHOW</a>
        </div>';


            } else {

                $new_start = $data['start'] + 9;

                if ($count <= $new_start) {

                    $load_more = '
            <div class="tt_item_all_js" style="display:block;">
                <a href="" class="btn btn-border01">NO MORE ITEM TO SHOW</a>
            </div>';


                } else {

                    $load_more = '<a href="#" class="btn btn-border" onclick="LoadMore(\'' . fiki_encrypt($data['tag_id']) . '\',\'' . fiki_encrypt($data['sub_tag_id']) . '\',\'' . fiki_encrypt($new_start) . '\')">LOAD MORE</a>
            <div class="tt_item_all_js">
                <a href="" class="btn btn-border01">NO MORE ITEM TO SHOW</a>
            </div>';

                }


            }

            //  return response(['result'=>-91,"msg"=>json_encode($data_products)],403);


            return response(['result' => 1, "products" => $products_div, "load-more" => $load_more], 200);

        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }
    }

    public function add_to_cart(Request $request)
    {
        try {
            $data = $request->all();
            $data['mri'] = fiki_decrypt($data['mri']);
            $validator = Validator::make($data, [
                'mri' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'qty' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }

            if (!is_numeric($data['qty'])) {

                $data['qty'] = 1;

            }


            $shopping_cart_products = Session::get('website.shopping_cart.products');

            $result = array_search($data['mri'], array_column($shopping_cart_products, 'model_record_id')); // Gives false or index of the product in the array

            if ($result === false) {
                $data_product = DB::select("SELECT * FROM v_shop_products_with_tags WHERE model_record_id = '" . $data['mri'] . "' AND
                                                                                                                sub_tag_is_active ='1' and product_is_active = '1' ");

                $data_product = $data_product[0];
                $data_product->new_price = number_format(CalculateProductPrice($data_product->wholesale_price, $data_product->kdv, Session::get('website.user.user_discount')), 2, '.', '');

                $data_product->quantity = $data['qty'];
                Session::push('website.shopping_cart.products', $data_product);

            } else {

                    $shopping_cart_products[$result]->quantity += $data['qty'];

                    if($shopping_cart_products[$result]->quantity > 1000){
                        return response(['result' => -1, "msg" => "Bu üründen en fazla 1000 adet ekleyebilirsiniz."], 200);
                    }

                    $data_product = $shopping_cart_products[$result];

            }
            $shopping_cart_products = Session::get('website.shopping_cart.products');

            $cart_total_qty = 0;
            $total_price = 0;
            //  return response(['result'=>-58,"msg"=>json_encode($shopping_cart_products)],200);
            for ($i = 0; $i < count($shopping_cart_products); $i++) {
                $cart_total_qty += $shopping_cart_products[$i]->quantity;

                $total_price += ($shopping_cart_products[$i]->new_price) * ($shopping_cart_products[$i]->quantity);
                $total_price = number_format($total_price, 2, '.', '');

            }


            Session::put('website.shopping_cart.total_qty', $cart_total_qty);
            Session::put('website.shopping_cart.total_price', $total_price);

            $add_to_cart_modal_div = view('partials.add-to-cart-complete-modal', ["product" => $data_product])->render();

            $shopping_cart_header_div = view('partials.shopping-cart-header')->render();

            $fav_search_result = array_search($data['mri'], array_column(Session::get('website.user.favorites'), 'model_record_id'));



            $product_models_data = DB::select("SELECT * FROM v_shop_products_with_tags WHERE product_code = '".$data_product->product_code."' ORDER BY model_number  asc");
            $quick_view_modal_div = view('partials.quick-view-modal', ["product" => $data_product,
                'product_models'=>$product_models_data,
                "qty" => $data_product->quantity,
                'fav'=>($fav_search_result !== false) ? "fav" :"" ,
                'fav_text'=>($fav_search_result !== false) ? "FAVORİLERDEN ÇIKAR" :"FAVORİLERE EKLE"])->render();


            return response(['result' => 1, "add_complete_modal" => $add_to_cart_modal_div, "shopping_cart" => $shopping_cart_header_div,
                                            "quick_view_modal"=>$quick_view_modal_div,"qty"=>$data_product->quantity], 200);

        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }
    }
    public function add_to_cart_input(Request $request) // FOR PRODUCT DETAIL PAGE ADD BUTTON
    {
        try {
            $data = $request->all();
            $data['mri'] = fiki_decrypt($data['mri']);
            $validator = Validator::make($data, [
                'mri' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'qty' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }

            if (!is_numeric($data['qty'])) {

                $data['qty'] = 10;

            }


            $shopping_cart_products = Session::get('website.shopping_cart.products');

            $result = array_search($data['mri'], array_column($shopping_cart_products, 'model_record_id')); // Gives false or index of the product in the array

            if ($result === false) {
                $data_product = DB::select("SELECT * FROM v_shop_products_with_tags WHERE model_record_id = '" . $data['mri'] . "' AND
                                                                                                                sub_tag_is_active ='1' and product_is_active = '1' ");

                $data_product = $data_product[0];
                $data_product->new_price = number_format(CalculateProductPrice($data_product->wholesale_price, $data_product->kdv, Session::get('website.user.user_discount')), 2, '.', '');

                $data_product->quantity = $data['qty'];
                Session::push('website.shopping_cart.products', $data_product);

            } else {

                $shopping_cart_products[$result]->quantity = $data['qty'];
                $data_product = $shopping_cart_products[$result];

            }
            $shopping_cart_products = Session::get('website.shopping_cart.products');

            $cart_total_qty = 0;
            $total_price = 0;
            //  return response(['result'=>-58,"msg"=>json_encode($shopping_cart_products)],200);
            for ($i = 0; $i < count($shopping_cart_products); $i++) {
                $cart_total_qty += $shopping_cart_products[$i]->quantity;

                $total_price += ($shopping_cart_products[$i]->new_price) * ($shopping_cart_products[$i]->quantity);
                $total_price = number_format($total_price, 2, '.', '');

            }


            Session::put('website.shopping_cart.total_qty', $cart_total_qty);
            Session::put('website.shopping_cart.total_price', $total_price);

            $add_to_cart_modal_div = view('partials.add-to-cart-complete-modal', ["product" => $data_product])->render();

            $shopping_cart_header_div = view('partials.shopping-cart-header')->render();

            $fav_search_result = array_search($data['mri'], array_column(Session::get('website.user.favorites'), 'model_record_id'));


            $product_models_data = DB::select("SELECT * FROM v_shop_products_with_tags WHERE product_code = '".$data_product->product_code."' ORDER BY model_number  asc");

            $quick_view_modal_div = view('partials.quick-view-modal', ["product" => $data_product,
                "qty" => $data_product->quantity,
                'product_models'=>$product_models_data,
                'fav'=>($fav_search_result !== false) ? "fav" :"" ,
                'fav_text'=>($fav_search_result !== false) ? "FAVORİLERDEN ÇIKAR" :"FAVORİLERE EKLE"])->render();



            return response(['result'=> 1, "add_complete_modal" => $add_to_cart_modal_div, "shopping_cart" => $shopping_cart_header_div,
                "quick_view_modal"=>$quick_view_modal_div,"qty"=>$data_product->quantity], 200);

        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }
    }
    public function delete_item(Request $request){  // DELETE 1 ITEM --> qty=1
        try {
            $data = $request->all();
            $data['model_record_id'] = fiki_decrypt($data['model_record_id']);
            $validator = Validator::make($data, [
                'model_record_id' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ]
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }

            $qty = 1;


            $shopping_cart_products = Session::get('website.shopping_cart.products');

            $result = array_search($data['model_record_id'], array_column($shopping_cart_products, 'model_record_id')); // Gives false or index of the product in the array


            if ($result === false) { // There is no item

                return response(['result' => -1, "msg" => "Sepetinizde bu üründen bulunmamaktadır."], 200);

            } else {

                $product_data = $shopping_cart_products[$result]; // FOR QUICK VIEW
                if ($shopping_cart_products[$result]->quantity == 1) {

                    array_splice($shopping_cart_products, $result, 1);
                    Session::put('website.shopping_cart.products', $shopping_cart_products);
                    $quantity = 0;
                } else {

                    $shopping_cart_products[$result]->quantity -= $qty;
                    $quantity = $shopping_cart_products[$result]->quantity;
                }

            }
            $shopping_cart_products = Session::get('website.shopping_cart.products');

            $cart_total_qty = 0;
            $total_price = 0;
            //  return response(['result'=>-58,"msg"=>json_encode($shopping_cart_products)],200);
            for ($i = 0; $i < count($shopping_cart_products); $i++) {
                $cart_total_qty += $shopping_cart_products[$i]->quantity;

                $total_price += ($shopping_cart_products[$i]->new_price) * ($shopping_cart_products[$i]->quantity);
                $total_price = number_format($total_price, 2, '.', '');

            }


            Session::put('website.shopping_cart.total_qty', $cart_total_qty);
            Session::put('website.shopping_cart.total_price', $total_price);

            $shopping_cart_header_div = view('partials.shopping-cart-header')->render();

            $fav_search_result = array_search($data['model_record_id'], array_column(Session::get('website.user.favorites'), 'model_record_id'));


            $product_models_data = DB::select("SELECT * FROM v_shop_products_with_tags WHERE product_code = '".$product_data->product_code."' ORDER BY model_number  asc");

            $quick_view_modal_div = view('partials.quick-view-modal', ["product" => $product_data,
                "qty" => $quantity,
                'product_models'=>$product_models_data,
                'fav'=>($fav_search_result !== false) ? "fav" :"" ,
                'fav_text'=>($fav_search_result !== false) ? "FAVORİLERDEN ÇIKAR" :"FAVORİLERE EKLE"])->render();



            $empty_cart = false;
            if($cart_total_qty == 0){
                $empty_cart = true;
            }


            return response(['result' => 1, "shopping_cart" => $shopping_cart_header_div, "quick_view_modal"=>$quick_view_modal_div,
                                            "empty_cart"=>$empty_cart,"qty"=>$quantity], 200);

        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }
    }
    public function delete_items_from_cart(Request $request)
    {   // DELETE 1 ITEM --> qty = ALL
        try {
            $data = $request->all();
            $data['model_record_id'] = fiki_decrypt($data['model_record_id']);
            $validator = Validator::make($data, [
                'model_record_id' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ]
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }

            $qty = 1;


            $shopping_cart_products = Session::get('website.shopping_cart.products');

            $result = array_search($data['model_record_id'], array_column($shopping_cart_products, 'model_record_id')); // Gives false or index of the product in the array


            if ($result === false) { // There is no item

                return response(['result' => -2, "msg" => "Sepetinizde bu üründen bulunmamaktadır."], 200);

            } else {


                array_splice($shopping_cart_products, $result, 1);
                Session::put('website.shopping_cart.products', $shopping_cart_products);

            }
            $shopping_cart_products = Session::get('website.shopping_cart.products');
            $cart_total_qty = 0;
            if ($shopping_cart_products != null || count($shopping_cart_products) != 0) {

                $total_price = 0;
                //  return response(['result'=>-58,"msg"=>json_encode($shopping_cart_products)],200);
                for ($i = 0; $i < count($shopping_cart_products); $i++) {
                    $cart_total_qty += $shopping_cart_products[$i]->quantity;

                    $total_price += ($shopping_cart_products[$i]->new_price) * ($shopping_cart_products[$i]->quantity);
                    $total_price = number_format($total_price, 2, '.', '');

                }


                Session::put('website.shopping_cart.total_qty', $cart_total_qty);
                Session::put('website.shopping_cart.total_price', $total_price);

                $message = "Ürün başarıyla silindi.";


            } else {

                $message = "Sepetinizde ürün kalmamıştır.";

            }

            $shopping_cart_header_div = view('partials.shopping-cart-header')->render();

            $empty_cart = false;
            if($cart_total_qty == 0){
                $empty_cart = true;
            }


            return response(['result' => 1, "msg" => $message, "shopping_cart" => $shopping_cart_header_div,"empty_cart"=>$empty_cart], 200);

        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }
    }
    public function quick_view($product_code){
        try{
            $product_code = fiki_decrypt($product_code);
            $product_models_data = DB::select("SELECT * FROM v_shop_products_with_tags WHERE product_code = '".$product_code."' ORDER BY model_number  asc");

            $product_data = $product_models_data;

            $cart_search_result = array_search($product_data[0]->model_record_id, array_column(Session::get('website.shopping_cart.products'), 'model_record_id')); // Gives false or index of the product in the arra
            $fav_search_result = array_search($product_data[0]->model_record_id, array_column(Session::get('website.user.favorites'), 'model_record_id'));





            $quick_view_modal_div = view('partials.quick-view-modal', ["product" => $product_data[0],
                                                                            "qty" => ($cart_search_result !== false) ? Session::get('website.shopping_cart.products')[$cart_search_result]->quantity : 0,
                                                                            'product_models'=>$product_models_data,
                                                                            "fav"=>($fav_search_result !== false) ? "fav" :"" ,
                                                                            "fav_text"=>($fav_search_result !== false) ? "FAVORİLERDEN ÇIKAR" :"FAVORİLERE EKLE" ])->render();


            return response(['result' => 1, "modal" => $quick_view_modal_div], 200);


        }catch (\Exception $e) {

            return response(['result'=>-500,"msg"=>$e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function"=>__FUNCTION__],500);

        }
    }
    public function add_to_fav(Request $request)
    {
        try {
            $data = $request->all();
            $enc_model_record_id = $data['model_record_id'];
            $data['model_record_id'] = fiki_decrypt($data['model_record_id']);
            $validator = Validator::make($data, [
                'model_record_id' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }



            $user_fav_products = Session::get('website.user.favorites');

            $result = array_search($data['model_record_id'], array_column($user_fav_products, 'model_record_id')); // Gives false or index of the product in the array

            $user = Session::get('website.user');

            if ($result === false) { // This product not in the user fav list
                $data_product = DB::select("SELECT * FROM v_shop_products_with_tags WHERE model_record_id = '" . $data['model_record_id'] . "' AND
                                                                                                                product_is_active = '1' ");


                $data_product = $data_product[0];

                Session::push('website.user.favorites',$data_product);


                $insert_data['user_id'] = $user[0]->user_id;
                $insert_data['product_model_record_id'] = $data['model_record_id'];
                DB::table('user_fav_items')->insert($insert_data);

                $fav_list_div = view('partials.favorites-list-div')->render();
                return response(['result' => 1, "msg" => 'Ürün favorilerinizde!', "enc-mri"=>$enc_model_record_id, "fav_txt"=>"FAVORİLERDEN ÇIKAR", "fav_div"=>$fav_list_div], 200);

            } else {


                array_splice($user_fav_products, $result, 1);
                Session::put('website.user.favorites', $user_fav_products);

                DB::table('user_fav_items')->where('user_id',$user[0]->user_id)->where('product_model_record_id',$data['model_record_id'])->delete();
                $fav_list_div = view('partials.favorites-list-div')->render();
                return response(['result' => 2, "msg" => 'Ürün favorilerinizden çıkarıldı!', "enc-mri"=>$enc_model_record_id, "fav_txt"=>"FAVORİLERE EKLE", "fav_div"=>$fav_list_div ], 200);

            }


        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }
    }

    public function get_product_model(Request $request){
        try {
            $data = $request->all();
            $data['mri'] = fiki_decrypt($data['mri']);
            $validator = Validator::make($data, [
                'mri' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }

            $model_record_id = $data['mri'];

            $data_product = DB::select("SELECT * FROM v_shop_products_with_tags WHERE model_record_id = '" . $model_record_id . "' AND
                                                                                                                product_is_active = '1' ");


            $shopping_cart_products = Session::get('website.shopping_cart.products');

            $check_cart_result = array_search($model_record_id, array_column($shopping_cart_products, 'model_record_id')); // Gives false or index of the product in the array



            $user_fav_products = Session::get('website.user.favorites');

            $check_favs_result = array_search($model_record_id, array_column($user_fav_products, 'model_record_id')); // Gives false or index of the product in the array

            if(count($data_product)>1){
                $product_images = array();
                foreach ($data_product as $product) {
                        array_push($product_images, $product->product_image);
                }
                $data_product[0]->product_image = $product_images;
            }

            $data_product = $data_product[0];
            $product_code_model_number =  $data_product->product_code.'-'. $data_product->model_number ;
            $product_price = number_format(CalculateProductPrice($data_product->wholesale_price,$data_product->kdv,Session::get('website.user.user_discount')),2,'.','').' TL';
            $enc_model_record_id = fiki_encrypt($data_product->model_record_id);

            $product_div = view('partials.product-image',['product_images' => $data_product->product_image])->render();
            $product_div_mobile = view('partials.product-image-mobile')->with('product_images',$data_product->product_image)->render();

            return response(['result' => 1, "qty"=>($check_cart_result !== false) ? $shopping_cart_products[$check_cart_result]->quantity: 0,
                                            "prd-nm"=>$data_product->product_name,
                                            "product_image_div"=>$product_div,
                                            "product_image_mobile_div"=>$product_div_mobile,
                                            "prd-pr"=>$product_price,
                "prd-cm"=>$product_code_model_number,
                                            "enc-mri"=>$enc_model_record_id,
                "fav"=>($check_favs_result !== false) ? "fav" : "",
                "fav_txt"=>($check_favs_result !== false) ? "FAVORİLERDEN ÇIKAR":"FAVORİLERE EKLE"],200);



        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }
    }
    public function get_category(Request $request){
        try {
            $data = $request->all();
            $data['id'] = fiki_decrypt($data['id']);
            $validator = Validator::make($data, [
                'id' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }


            Session::put('website.selected_tag', $data['id']);
            $data_sub_tags = DB::select("SELECT * FROM v_tag_to_sub_tags WHERE tag_id = '" . $data['id'] . "'");
            Session::put('website.sub_tag_filter_bar', $data_sub_tags);

            return response(['result' => 1], 200);

        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }
    }
    public function get_empty_cart(Request $request){  // DELETE 1 ITEM --> qty=1
        try {
            $shopping_cart_products = Session::get('website.shopping_cart.products');

            if(count($shopping_cart_products) == 0){
                return response(['result' => -1, "msg" => "Sepetinizde boşaltılacak ürün bulunmamaktadır."],200);
            }

            Session::forget('website.shopping_cart');
            Session::put('website.shopping_cart.products', array());


            $shopping_cart_products = Session::get('website.shopping_cart.products');

            $cart_total_qty = 0;
            $total_price = 0;
            //  return response(['result'=>-58,"msg"=>json_encode($shopping_cart_products)],200);
            for ($i = 0; $i < count($shopping_cart_products); $i++) {
                $cart_total_qty += $shopping_cart_products[$i]->quantity;

                $total_price += ($shopping_cart_products[$i]->new_price) * ($shopping_cart_products[$i]->quantity);
                $total_price = number_format($total_price, 2, '.', '');

            }


            Session::put('website.shopping_cart.total_qty', $cart_total_qty);
            Session::put('website.shopping_cart.total_price', $total_price);

            $shopping_cart_header_div = view('partials.shopping-cart-header')->render();


            $empty_cart = true;


            return response(['result' => 1, "shopping_cart" => $shopping_cart_header_div,   "empty_cart"=>$empty_cart], 200);

        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }
    }


    public function update_user(Request $request){
        try {
            $data = $request->only(['user_id','company_name','first_name','last_name','phone']);
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
                'phone' => [
                    "required",
                    'digits_between:10,11',
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {
                $response =  response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 403);
                $request = new Request();
                $request['log_type'] = 'Takisik_Website_validation_error';
                $request['data'] = $response->getContent();
                $maintenance_controller = new GeneralController();
                $maintenance_controller->send_data_to_maintenance($request);
                if(env('APP_ENV') == 'local'){
                    return $response;
                }
                return response(['result' => -1, 'msg' => 'Hatalı giriş. Lütfen tekrar deneyin'], 403);
            }


            try {

                $user_id = $data['user_id'];
                unset($data['user_id']);
                User::where('user_id',$user_id)->update(['company_name'=>$data['company_name'],
                                            'first_name'=>$data['first_name'],
                                            'last_name'=>$data['last_name'],
                                            'phone'=>$data['phone']
                ]);


            } catch (QueryException $e) {
                $response = response(['result' => -500, 'msg' => "Hata oluştu. Lütfen daha sonra tekrar deneyin","error"=>$e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function" => __FUNCTION__], 400);
                $request = new Request();
                $request['log_type'] = 'Takisik_Website_query_error';
                $request['data'] = $response->getContent();
                $maintenance_controller = new GeneralController();
                $maintenance_controller->send_data_to_maintenance($request);
                return $response;
            }

            $user_data =  User::where('user_id',$user_id)->get();
            Session::put('website.user.user_info',$user_data[0]);


            return response(['result' => 1, 'msg' => 'Başarıyla güncellendi'],200);

        } catch (\Throwable $t) {
            $resp = response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__],500);
            $request = new Request();
            $request['log_type'] = 'Takisik_Website_500_error';
            $request['data'] = $resp->getContent();
            $maintenance_controller = new GeneralController;
            $maintenance_controller->send_data_to_maintenance($request);
            if(env('APP_ENV') == 'local'){
                return $resp;
            }
            return response(['result' => -500, 'msg' => "Sistem hatası. Lütfen daha sonra tekrar deneyin veya destek ekibimize başvurun."], 500);
        }
    }
    public function insert_address(Request $request){
        try {
            $data = $request->only(['user_id','address_type','address_title','address','city','district','neighbourhood','zip']);
            $validator = Validator::make($data, [
                'user_id' => [
                    "required",
                    "integer",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'address_type' => [
                    "required",
                    "integer",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'address_title' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'address' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'city' => [
                    "required",
                    "integer",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'district' => [
                    "required",
                    "integer",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'neighbourhood' => [
                    "required",
                    "integer",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'zip' => [
                    "required",
                    'integer',
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {
                $response =  response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 403);
                $request = new Request();
                $request['log_type'] = 'Takisik_Website_validation_error';
                $request['data'] = $response->getContent();
                $maintenance_controller = new GeneralController();
                $maintenance_controller->send_data_to_maintenance($request);
                if(env('APP_ENV') == 'local'){
                    return $response;
                }
                return response(['result' => -1, 'msg' => 'Hatalı giriş. Lütfen tekrar deneyin'], 403);
            }

            $city_name = City::where('city_id',$data['city'])->value('city_name_uppercase');
            $district_name = District::where('district_id',$data['district'])->value('district_name_uppercase');
            $neighbourhood_name = Neighbourhood::where('neighbourhood_id',$data['neighbourhood'])->value('neighbourhood_name');



            if($data['address_type'] == 1){ //SHIPPING ADDRESS
                try {
                    $updated_data = $data;
                    $updated_data['city'] = $city_name;
                    $updated_data['district'] = $district_name;
                    $updated_data['neighbourhood'] = $neighbourhood_name;

                    UserShippingAddress::create($updated_data);

                    $user_shipping_address_data = UserShippingAddress::where(['user_id'=>$data['user_id'],'is_deleted'=>false])->get();
                    Session::put('website.user.shipping_addresses', $user_shipping_address_data);

                } catch (QueryException $e) {
                    $response = response(['result' => -500, 'msg' => "Hata oluştu. Lütfen daha sonra tekrar deneyin","error"=>$e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function" => __FUNCTION__], 400);
                    $request = new Request();
                    $request['log_type'] = 'Takisik_Website_query_error';
                    $request['data'] = $response->getContent();
                    $maintenance_controller = new GeneralController();
                    $maintenance_controller->send_data_to_maintenance($request);
                    return $response;
                }
            }

            if($data['address_type'] == 2){ //BILLING ADDRESS
                try {
                    $updated_data = $data;
                    $updated_data['city'] = $city_name;
                    $updated_data['district'] = $district_name;
                    $updated_data['neighbourhood'] = $neighbourhood_name;

                    UserBillingAddress::create($updated_data);

                    $user_billing_address_data = UserBillingAddress::where(['user_id'=>$data['user_id'],'is_deleted'=>false])->get();
                    Session::put('website.user.billing_addresses', $user_billing_address_data);
                } catch (QueryException $e) {
                    $response = response(['result' => -500, 'msg' => "Hata oluştu. Lütfen daha sonra tekrar deneyin","error"=>$e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function" => __FUNCTION__], 400);
                    $request = new Request();
                    $request['log_type'] = 'Takisik_Website_query_error';
                    $request['data'] = $response->getContent();
                    $maintenance_controller = new GeneralController();
                    $maintenance_controller->send_data_to_maintenance($request);
                    return $response;
                }
            }



            return response(['result' => 1, 'msg' => 'Adres Eklendi'],200);

        } catch (\Throwable $t) {
            $resp = response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__],500);
            $request = new Request();
            $request['log_type'] = 'Takisik_Website_500_error';
            $request['data'] = $resp->getContent();
            $maintenance_controller = new GeneralController;
            $maintenance_controller->send_data_to_maintenance($request);
            if(env('APP_ENV') == 'local'){
                return $resp;
            }
            return response(['result' => -500, 'msg' => "Sistem hatası. Lütfen daha sonra tekrar deneyin veya destek ekibimize başvurun."], 500);
        }
    }
    public function delete_address(Request $request){
        try {
            $data = $request->only(['address_type','record_id']);
            $validator = Validator::make($data, [
                'address_type' => [
                    "required",
                    "integer",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
                'record_id' => [
                    "required",
                    "string",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {
                $response =  response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors(), "function" => __FUNCTION__, "data" => $data], 403);
                $request = new Request();
                $request['log_type'] = 'Takisik_Website_validation_error';
                $request['data'] = $response->getContent();
                $maintenance_controller = new GeneralController();
                $maintenance_controller->send_data_to_maintenance($request);
                if(env('APP_ENV') == 'local'){
                    return $response;
                }
                return response(['result' => -1, 'msg' => 'Hatalı giriş. Lütfen tekrar deneyin'], 403);
            }

            $record_id = fiki_decrypt($data['record_id']);
            $user_id = Session::get('website.user.user_info')->user_id;


            if($data['address_type'] == 1){ //SHIPPING ADDRESS
                try {
                    UserShippingAddress::where('record_id',$record_id)->update(['is_deleted'=>true]);

                    $user_shipping_address_data = UserShippingAddress::where(['user_id'=>$user_id,'is_deleted'=>false])->get();
                    Session::put('website.user.shipping_addresses', $user_shipping_address_data);

                } catch (QueryException $e) {
                    $response = response(['result' => -500, 'msg' => "Hata oluştu. Lütfen daha sonra tekrar deneyin","error"=>$e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function" => __FUNCTION__], 400);
                    $request = new Request();
                    $request['log_type'] = 'Takisik_Website_query_error';
                    $request['data'] = $response->getContent();
                    $maintenance_controller = new GeneralController();
                    $maintenance_controller->send_data_to_maintenance($request);
                    return $response;
                }
            }

            if($data['address_type'] == 2){ //BILLING ADDRESS
                try {
                    UserBillingAddress::where('record_id',$record_id)->update(['is_deleted'=>true]);

                    $user_billing_address_data = UserBillingAddress::where(['user_id'=>$user_id,'is_deleted'=>false])->get();
                    Session::put('website.user.billing_addresses', $user_billing_address_data);
                } catch (QueryException $e) {
                    $response = response(['result' => -500, 'msg' => "Hata oluştu. Lütfen daha sonra tekrar deneyin","error"=>$e->getMessage(). " at ". $e->getFile(). ":". $e->getLine(),"function" => __FUNCTION__], 400);
                    $request = new Request();
                    $request['log_type'] = 'Takisik_Website_query_error';
                    $request['data'] = $response->getContent();
                    $maintenance_controller = new GeneralController();
                    $maintenance_controller->send_data_to_maintenance($request);
                    return $response;
                }
            }



            return response(['result' => 1, 'msg' => 'Adres Silindi'],200);

        } catch (\Throwable $t) {
            $resp = response(['result'=>-500,"msg"=>$t->getMessage(). " at ". $t->getFile(). ":". $t->getLine(),"function"=>__FUNCTION__],500);
            $request = new Request();
            $request['log_type'] = 'Takisik_Website_500_error';
            $request['data'] = $resp->getContent();
            $maintenance_controller = new GeneralController;
            $maintenance_controller->send_data_to_maintenance($request);
            if(env('APP_ENV') == 'local'){
                return $resp;
            }
            return response(['result' => -500, 'msg' => "Sistem hatası. Lütfen daha sonra tekrar deneyin veya destek ekibimize başvurun."], 500);
        }
    }


    public function get_city(Request $request)
    {
        try {

            $cities_data = City::all();


            return response(['result' => 1, "data" => $cities_data], 200);

        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }

    }
    public function get_neighbourhood(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'district_id' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }

            $hood_data = Neighbourhood::where('district_id',$data['district_id'])->orderBy('neighbourhood_name_uppercase','ASC')->get();


            return response(['result' => 1, "data" => $hood_data], 200);

        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }

    }
    public function get_district(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'city_id' => [
                    "integer",
                    "required",
                    Rule::notIn(['null', 'undefined', 'NULL', ' ']),
                ],
            ]);

            if ($validator->fails()) {

                return response(['result' => -1, "msg" => $validator->errors()->first(), 'error' => $validator->errors()], 403);

            }

            $district_data = District::where('city_id',$data['city_id'])->orderBy('district_name_uppercase','ASC')->get();



            return response(['result' => 1, "data" => $district_data ], 200);

        } catch (\Exception $e) {

            return response(['result' => -500, "msg" => $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(), "function" => __FUNCTION__], 500);

        }

    }

}
