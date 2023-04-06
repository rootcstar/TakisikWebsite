<?php
date_default_timezone_set('US/Eastern');

function FixName($var){

    $var = str_replace("_", " ", $var); //Remove single quote _
    return ucwords($var);
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

function CalculateProductPrice($price,$kdv,$discount_percentage){

    $discounted_price = $price - (($price * $discount_percentage)/100);
    $price =$discounted_price + (($discounted_price*$kdv)/100);

    return $price;
}



/** ***************************************************************************************************************************************************************************** */








?>
