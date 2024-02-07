<?php
date_default_timezone_set('US/Eastern');

function FixName($var){

    $var = str_replace("_", " ", $var); //Remove single quote _
    return ucwords($var);
}
function fiki_encrypt($data) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';
    $secret_iv =  'e0d2679eb5c7b266fed6a402e37fed66';
    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    $output = openssl_encrypt($data, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);

    return $output;
}

function fiki_decrypt($data) {

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=';
    $secret_iv =  'e0d2679eb5c7b266fed6a402e37fed66';
    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);


    $output = openssl_decrypt(base64_decode($data), $encrypt_method, $key, 0, $iv);

    return $output;
}

/******************* FIKITECH ***************************/

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
                    "Is Active" => "Sayfada Gösterilsin",
                    'Customers' => 'Müşteriler',
                    'Admin Users' => 'Yöneticiler',
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
                    "Account Type" =>  "Üyelik",
                    "Title" => 'Başlık',
                    "Admin Id" => "Yönetici ID",
                    "Admin User Type Id" => "ID",
                    "Admin User Type Name" => "Yönetici Türü Adı",
                    "Admin Type" =>  "Yönetici Türü",
                    "Admin User Types" =>  "Yönetici Türleri",
                    "Permission Types" =>  "İzinler",
        "New Permission Type" =>  "Yeni İzin",
                    "Is New" =>  "Yeni",
                    "Permission Id" =>  "İzin ID",
                    "Permission Name" =>  "İzin",
                    "Permission Code" =>  "İzin Kod Adı",
                    "Barcode" =>  "Barkod Numarası",
                    "Product Id" =>  "Ürün ID",
                    "Product Code" =>  "Stok Kodu",
                    "Product Name" =>  "Stok Adı",
        "Unit Quantity"=> "Birim Miktarı",
        "Unit"=> "Birim",
        "Main Unit Quantity"=> "Temel Birim Miktarı",
        "Main Unit"=> "Temel Birim",
        "Single Price"=> "Birim Fiyatı",
        "Wholesale Price"=> "Toptan Fiyatı",
        "Retail Price"=> "Parakende Fiyatı",
        "Record Id"=> "Kayıt ID",
        "Products"=> "Ürünler",
                    );

    if(Session::get('admin.lang') == 'tr'){

        return array_key_exists($value, $lang[0]) ? $lang[0][$value] : $value;


    }else if(Session::get('admin.lang') == 'en'){

        $lang_en = array_flip($lang[0]);

        return array_key_exists($value, $lang_en[0]) ? $lang_en[0][$value] : $value;
    }
}

function CalculateProductPrice($price,$kdv,$discount_percentage){

    $discounted_price = $price - (($price * $discount_percentage)/100);
    $price =$discounted_price + (($discounted_price*$kdv)/100);

    return $price;
}



/** ***************************************************************************************************************************************************************************** */








?>
