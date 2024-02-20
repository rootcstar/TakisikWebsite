@extends('layout.app')

@section('content')

<div id="tt-pageContent">
    <div class="container-indent">
        <div class="tt-mobile-product-layout visible-xs" id="image-part-mobile">
            @include('partials.product-image-mobile')
        </div>

        <div class="container container-fluid-mobile" id="product-detail">
            <div class="row">
                <div class="col-6 hidden-xs" id="image-part">
                    @include('partials.product-image')
                </div>
                <div class="col-6">
                    <div class="tt-product-single-info">
                        <div class="tt-wrapper">
                            <div class="tt-label">
                                <div class="tt-label-new">YENİ</div>
                            </div><h1 class="tt-title" id="prd-nm">{{ $product->product_name }}</h1>
                            <h4 class="m-0" id="prd-cm">{{ $product->product_code }}-{{ $product->model_number }}</h4>
                            <div class="tt-price">
                                <span class="new-price" id="prd-pr">{{ number_format(CalculateProductPrice($product->wholesale_price,$product->kdv),2,'.','') }} TL</span>
                                <span class="old-price"></span>
                            </div>
                            <div class="tt-review">
                                <div class="tt-rating">
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                    <i class="icon-star"></i>
                                    <i class="icon-star-half"></i>
                                    <i class="icon-star-empty"></i>
                                </div>
                            </div>
                            <div class="tt-wrapper">
                                Fiyatlarımıza KDV dahildir.
                            </div>
                            <div class="tt-wrapper">
                                <h4 class="p-0">MODELLER</h4>
                                <div class="row">
                                    @foreach($product_models as $key=>$model)
                                        <div class="col-3 col-md-2 pt-3" >
                                            <a onclick="GetModel('{{ fiki_encrypt($model->model_record_id) }}',{{$key}})">
                                                <img src="{{ $model->product_image[0] }}" alt="" class="loading" data-was-processed="true">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                           </div>
                            <div class="tt-wrapper">
                                <div class="tt-row-custom-01">
                                    <div class="col-item">
                                        <div class="tt-input-counter style-01">
                                            <input  value="{{ $qty }}" size="10000"  id="counter-input">
                                        </div>
                                    </div>
                                    <div class="col-item">
                                        <button onclick="AddToCartInput('{{ fiki_encrypt($product->model_record_id) }}')" id="pd-add-btn"  class="btn btn-lg"><i class="icon-f-39"></i>SEPETE EKLE</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tt-wrapper">
                                <ul class="tt-list-btn">
                                    <li>
                                        <a class="btn-link wishlist-btn {{ $fav }} " id="fav-btn-0" type="button" onclick="AddToFav('{{ fiki_encrypt($product->model_record_id) }}',0)" >
                                            <i class="icon-n-072"></i>
                                            <span id="add-wish-text">{{ $fav_text }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tt-collapse-block">
                                <div class="tt-item ">
                                    <div class="tt-collapse-title ">AÇIKLAMA</div>
                                    <div class="tt-collapse-content" style="display: block;">
                                        Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.

                                    </div>
                                </div>
                                <div class="tt-item ">
                                    <div class="tt-collapse-title">ÜRÜN BİLGİSİ</div>
                                    <div class="tt-collapse-content" style="display: block;">
                                        <table class="tt-table-03">
                                            <tbody>
                                            <tr>
                                                <td>Color:</td>
                                                <td>Blue, Purple, White</td>
                                            </tr>
                                            <tr>
                                                <td>Size:</td>
                                                <td>20, 24</td>
                                            </tr>
                                            <tr>
                                                <td>Material:</td>
                                                <td>100% Polyester</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

