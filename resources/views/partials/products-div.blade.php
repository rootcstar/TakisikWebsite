
@if(empty($products))
    <h1>{{ $empty_message }}</h1>
@else

    @foreach($products as $key=>$product)
        <div class="col-6 col-md-4 tt-col-item">
            <div class="tt-product thumbprod-center">
                <div class="tt-image-box">
                    <a href="#" class="tt-btn-quickview" data-toggle="modal" data-target="#ModalquickView"	onclick="QuickView('{{ fiki_encrypt($product->product_code) }}')"></a>
                    <a  class="tt-btn-wishlist2 <?php if(array_search($product->model_record_id, array_column(Session::get('website.user.favorites'), 'model_record_id')) !== false){ echo 'fav'; } ?>" onclick="AddToFav('{{ fiki_encrypt($product->model_record_id) }}',{{$key}})" id="fav-btn-{{$key}}"></a>

                    <a href="/urun-detay/{{ Str::slug($product->product_name) }}/{{ Str::slug($product->product_code) }}">
                        <span class="tt-img"><img src="{{ $product->product_image }}" data-src="{{ $product->product_image }}" alt=""></span>
                        <span class="tt-img-roll-over"><img src="{{ $product->product_image }}" data-src="{{ $product->product_image }}" alt=""></span>
                    </a>
                </div>
                <div class="tt-description">
                    <div class="tt-row">
                    </div>
                    <h2 class="tt-title">{{ $product->product_code }}</a></h2>
                    <h2 class="tt-title"><a href="">{{ $product->product_name }}</a></h2>
                    <div class="tt-price">
                        {{ $product->final_price }} TL
                    </div>

                    <div class="tt-product-inside-hover">
                        <div class="tt-row-btn">
                            <a href="#" class="tt-btn-addtocart thumbprod-button-bg" data-toggle="modal" data-target="#modalAddToCartProduct" onclick="AddToCart('{{ fiki_encrypt($product->model_record_id) }}')">SEPETE EKLE</a>
                        </div>
                        <div class="tt-row-btn">
                            <a href="#" class="tt-btn-quickview" data-toggle="modal" data-target="#ModalquickView" onclick="QuickView('{{ fiki_encrypt($product->product_code) }}')"></a>
                            <a  class="tt-btn-wishlist2 <?php if(array_search($product->model_record_id, array_column(Session::get('website.user.favorites'), 'model_record_id')) !== false){ echo 'fav'; } ?> "  onclick="AddToFav('{{ fiki_encrypt($product->model_record_id) }}',{{$key}})" id="fav-btn-{{$key}}"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endif
