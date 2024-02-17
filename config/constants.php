<?php
if(env('APP_ENV') == 'local'){
    $url = 'http://localhost:8000';
    $requester_type = 'takisik-admin-panel-test';
    $admin_token = 'a847156c6d12d5fcafed0bf3a9479171307ded97c45af0aaf56d6105119072fa';
    $app_title = 'Takışık Admin Panel';
} else {
    $url = '';
    $requester_type = '';
    $admin_token = '';
    $app_title = 'Takışık Admin Panel';
}

return [

    'app_title'=>$app_title,
    'api_url'=>$url,
    'requester_type'=>$requester_type,
    'admin_token'=> $admin_token,
    'cargo_price'=>39.99,
    'min_cart_total_price'=>350,
    'total_price_for_free_shipping'=>1000





];
