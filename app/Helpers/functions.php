<?php
date_default_timezone_set('US/Eastern');

function FixName($var){

    $var = str_replace("_", " ", $var); //Remove single quote _
    return ucwords($var);
}

/******************* FIKITECH ***************************/

function CleanVariable($var){

    $var = str_replace("'", "", $var); //Remove single quote '
    $var = str_replace('"', '', $var); //Remove double quote "
    $var = strip_tags(addslashes($var));
    return $var;

}

function CreateGuid(){
    $date_combine = date("YmdHis");
    $value=$date_combine;
    $guid = fiki_encrypt($value);
    return $guid;
}

function searchForId($search_value, $array) {

    $id_path = array();

    // Iterating over main array
    foreach ($array as $key1 => $val1) {

        $temp_path = $id_path;

        // Adding current key to search path
        array_push($temp_path, $key1);

        // Check if this value is an array
        // with atleast one element
        if(is_array($val1) and count($val1)) {

            // Iterating over the nested array
            foreach ($val1 as $key2 => $val2) {

                if($val2 == $search_value) {

                    // Adding current key to search path
                    array_push($temp_path, $key2);

                    return  $temp_path;
                }
            }
        }

        elseif($val1 == $search_value) {
            return  $temp_path;
        }
    }

    return null;
}

function LanguageChange($value){


    $lang[] = array('Tags' => 'Kategoriler',
                    "Tag Id" => "Kategori ID",
                    "Tag Name" =>  "Kategori Adı",
                    "Tag Image" =>  "Kategori Fotoğrafı",
                    "Image" =>  "Fotoğraf",
                    "Display Name"=>"Sayfada Görünen Adı",
                    'Sub Tags' => 'Alt Kategoriler',
                    "Sub Tag Id" => "Alt Kategori ID",
                    "Sub Tag Name" => "Alt Kategori Adı",
                    "Is Active" => "Sayfada Gösterilsin Mi?",
                    'Users' => 'Müşteriler',
                    'Admin Users' => 'Admin Kullanıcıları',
                    "User Id" => "Kullanıcı ID",
                    'First Name' => 'Adı',
                    "Last Name" => "Soyadı",
                    "Phone" => "Telefon",
                    "Password" => "Şifre",
                    "Company Name" =>  "Şirket Adı",
                    "Country Code" =>  "Ülke Kodu",
                    "Billing Address Line 1" =>  "Fatura Adresi",
                    "Billing Address Line 2" =>  "Fatura Adresi Devam",
                    "Shipping Address Line 1" =>  "Teslimat Adresi",
                    "Shipping Address Line 2" =>  "Teslimat Adresi Devam",
                    "City" =>  "Şehir",
                    "Zip" =>  "Posta kodu",
                    "Country" =>  "Ülke",
                    "Logout" =>  "Çıkış",
                    "Update" =>  "Düzenle",
                    );

    if(Session::get('admin.lang') == 'tr'){

        return array_key_exists($value, $lang[0]) ? $lang[0][$value] : $value;


    }else if(Session::get('admin.lang') == 'en'){

        $lang_en = array_flip($lang[0]);

        return array_key_exists($value, $lang_en[0]) ? $lang_en[0][$value] : $value;
    }
}

function CurlRequest($url,$method,$post_data = array()){
    $AWS_TOKEN = config("constants.token");

    if($method == 'POST'){

        //$post_data['token'] = $AWS_TOKEN;

        if($_FILES){
            // for files
            $keys = array_keys($_FILES);
            $post_data[$keys[0]] = new CURLFile($_FILES[$keys[0]]['tmp_name'],$_FILES[$keys[0]]['type'],$_FILES[$keys[0]]['name']);

            $options = array(
                CURLOPT_RETURNTRANSFER => true,     // return web page
                CURLOPT_HEADER         => false,    // don't return headers
                CURLOPT_FOLLOWLOCATION => true,     // follow redirects
                CURLOPT_ENCODING       => "",       // handle all encodings
                CURLOPT_AUTOREFERER    => true,     // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
                CURLOPT_TIMEOUT        => 120,      // timeout on response
                CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
                CURLOPT_SSL_VERIFYPEER => false,     // Disabled SSL Cert checks
                CURLOPT_POST=>true,
                CURLOPT_POSTFIELDS => $post_data,
                CURLOPT_SSL_VERIFYHOST => false     // Disabled SSL Cert checks


            );

        }else {
            $options = array(
                CURLOPT_RETURNTRANSFER => true,     // return web page
                CURLOPT_HEADER         => false,    // don't return headers
                CURLOPT_FOLLOWLOCATION => true,     // follow redirects
                CURLOPT_ENCODING       => "",       // handle all encodings
                CURLOPT_AUTOREFERER    => true,     // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
                CURLOPT_TIMEOUT        => 120,      // timeout on response
                CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
                CURLOPT_SSL_VERIFYPEER => false,     // Disabled SSL Cert checks
                CURLOPT_POST=>true,
                CURLOPT_POSTFIELDS => $post_data,
                CURLOPT_SSL_VERIFYHOST => false     // Disabled SSL Cert checks
            );
        }

        //  echo json_encode($_FILES);
    }
    if($method == 'PUT'){
        //$post_data['token'] = $AWS_TOKEN;

        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false,     // Disabled SSL Cert checks
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_SSL_VERIFYHOST => false     // Disabled SSL Cert checks
        );

    }
    if($method == 'GET'){
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false,     // Disabled SSL Cert checks
            CURLOPT_SSL_VERIFYHOST => false     // Disabled SSL Cert checks
        );

        if(!empty($post_data)){
            $url = $url.'?';
            foreach($post_data as $key=>$value){
                $add = $key.'='.$value.'&&';
                $url .= $add;
            }
            $url = substr($url,0,-2);
        }


    }


    $ch= curl_init( $url );
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: '.$AWS_TOKEN.'',
    ));


    curl_setopt_array( $ch, $options );
    $response = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


    curl_close( $ch );

    $response = json_decode($response,true);
    $response['http_status'] = $httpcode;

    return $response;
    // return $response;
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function CalculateProductPrice($price,$kdv,$discount_percentage){

    $discounted_price = $price - (($price * $discount_percentage)/100);
    $price =$discounted_price + (($discounted_price*$kdv)/100);

    return $price;
}

function SendToMaintenance($post_array,$user_id,$type='website'){

    $maintenance_post_array =array("data"=>json_encode($post_array),"type" => $type,"requester_id"=>$user_id,"requester_type"=>"user_website","requester_ip"=> get_client_ip());
    CurlRequest('http://api.atlantissocket.com/api/send-data-to-maintenance','POST',$maintenance_post_array);

}

function ImageFix($url){

    $resp = CurlRequest($url,'GET');

    if($resp['http_status'] == 200){
        $image_url = $url;
    }else{
        $image_array = array('Missing-Image-Placeholders-v1.jpg','Missing-Image-Placeholders-v10.jpg','Missing-Image-Placeholders-v11.jpg','Missing-Image-Placeholders-v13.jpg'
        ,'Missing-Image-Placeholders-v14.jpg','Missing-Image-Placeholders-v2.jpg','Missing-Image-Placeholders-v3.jpg','Missing-Image-Placeholders-v4.jpg','Missing-Image-Placeholders-v5.jpg'
        ,'Missing-Image-Placeholders-v6.jpg','Missing-Image-Placeholders-v7.jpg','Missing-Image-Placeholders-v8.jpg','Missing-Image-Placeholders-v9.jpg');

        $image = array_rand($image_array,1);
        $image_url = 'https://d38yhdy393q827.cloudfront.net/default_empty_product_photos/'.$image_array[$image].'';
    }

    return $image_url;
}
/** ***************************************************************************************************************************************************************************** */








?>
