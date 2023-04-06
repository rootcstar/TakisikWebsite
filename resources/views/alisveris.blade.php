@extends('layout.app')
<?php

 //   echo json_encode(Session::all());
    ?>
@section('content')
    <div id="tt-pageContent">
        <div class="container-indent">
            <div class="container">
                <div class="row flex-sm-row-reverse">
                    <div class="col-md-12 col-lg-9 col-xl-9">
                        <div class="content-indent container-fluid-custom-mobile-padding-02">
                            <div class="tt-filters-options">
                                <div class="tt-btn-toggle">
                                    <a href="#">FILTER</a>
                                </div>
                                <div class="tt-quantity">
                                    <a href="#" class="tt-col-two" data-value="tt-col-two"></a>
                                    <a href="#" class="tt-col-three" data-value="tt-col-three"></a>
                                    <a href="#" class="tt-col-four" data-value="tt-col-four"></a>
                                </div>
                            </div>

                            <div class="tt-product-listing row" id="products">

                                @foreach(Session::get('website.default_products') as $key=>$product)
                                        <div class="col-6 col-md-4 tt-col-item">
                                            <div class="tt-product thumbprod-center">
                                                <div class="tt-image-box">
                                                    <a  class="tt-btn-quickview" data-toggle="modal" data-target="#ModalquickView" type="button"  onclick="QuickView('{{ encrypt($product->product_code) }}')"></a>
                                                    <a  class="tt-btn-wishlist2 <?php if(array_search($product->model_record_id, array_column(Session::get('user.favorites'), 'model_record_id')) !== false){ echo 'fav'; } ?>" onclick="AddToFav('{{ encrypt($product->model_record_id) }}',{{$key}})"  id="fav-btn-{{$key}}-hm"></a>

                                                    <a href="/urun-detay/{{ Str::slug($product->product_name) }}/{{ Str::slug($product->product_code) }}">
                                                        <span class="tt-img"><img src="{{ $product->product_image }}" data-src="{{ $product->product_image }}" alt=""></span>
                                                        <span class="tt-img-roll-over"><img src="{{ $product->product_image }}" data-src="{{ $product->product_image }}" alt=""></span>
                                                    </a>
                                                </div>
                                                <div class="tt-description">
                                                    <div class="tt-row">
                                                    </div>
                                                    <h2 class="tt-title"><a href="">{{ $product->product_code }}</a></h2>
                                                    <h2 class="tt-title"><a href="">{{ $product->product_name }}</a></h2>
                                                    <div class="tt-price">
                                                        {{ number_format(CalculateProductPrice($product->wholesale_price,$product->kdv,Session::get('website.user.user_discount')),2,'.','') }} TL
                                                    </div>
                                                    <div class="tt-product-inside-hover">
                                                        <div class="tt-row-btn">
                                                            <a href="#" class="tt-btn-addtocart thumbprod-button-bg" data-toggle="modal" data-target="#modalAddToCartProduct" onclick="AddToCart('{{ encrypt($product->model_record_id) }}',1)">SEPETE EKLE</a>
                                                        </div>
                                                        <div class="tt-row-btn">
                                                            <a  class="tt-btn-quickview" data-toggle="modal" data-target="#ModalquickView" type="button"  onclick="QuickView('{{ encrypt($product->product_code) }}')"></a>
                                                            <a  class="tt-btn-wishlist2 <?php if(array_search($product->model_record_id, array_column(Session::get('user.favorites'), 'model_record_id')) !== false){ echo 'fav';} ?>"   onclick="AddToFav('{{ encrypt($product->model_record_id) }}',{{$key}})"  id="fav-btn-{{$key}}-hm"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                            </div>

                            <div class="text-center tt_product_showmore" id="load-more">
                                <a href="#" class="btn btn-border" onclick="LoadMore('{{ encrypt(Session::get('website.selected_tag')) }}','{{ encrypt(Session::get('website.selected_sub_tag')) }}','{{ encrypt(9) }}')">LOAD MORE</a>
                                <div class="tt_item_all_js">
                                    <a href="#" class="btn btn-border01">NO MORE ITEM TO SHOW</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4 col-lg-3 col-xl-3 leftColumn rightColumn aside">
                        @include('partials.shop-filter-bar')
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
