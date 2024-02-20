<div class="tt-wishlist-list" id="wishlist">
    @foreach(Session::get('website.user.favorites') as $key=>$product)
        <div class="tt-item">
            <div class="tt-col-description">
                <div class="tt-img" >
                    <a href="/urun-detay/{{ fiki_encrypt($product->model_record_id) }}">
                        <img src="{{ $product->product_image }}" alt="">
                    </a>
                </div>
                <div class="tt-description">
                    <h2 class="tt-title"><a href="/urun-detay/{{ fiki_encrypt($product->model_record_id) }}">{{ $product->product_name }}</a></h2>
                    <h2 class="tt-title"><a href="/urun-detay/{{ fiki_encrypt($product->model_record_id) }}">{{ $product->product_code }}-{{ $product->model_number }}</a></h2>
                    <div class="tt-price">
                        <span class="new-price">${{ number_format(CalculateProductPrice($product->wholesale_price,$product->kdv),2,'.','') }} </span>

                    </div>
                </div>
            </div>
            <div class="tt-col-btn">
                <a class="tt-btn-addtocart" data-toggle="modal" data-target="#modalAddToCartProduct" onclick="AddToCart('{{ fiki_encrypt($product->model_record_id) }}')"><i class="icon-f-39"></i>SEPETE EKLE</a>
                <a class="btn-link"  data-toggle="modal" data-target="#ModalquickView" onclick="QuickView('{{ fiki_encrypt($product->product_code) }}')"><i class="icon-f-73"></i>ÜRÜNE GÖZAT</a>
                <a class="btn-link js-removeitem" onclick="AddToFav('{{ fiki_encrypt($product->model_record_id) }}',{{$key}})"  id="fav-btn-{{$key}}" href="#"><i class="icon-h-02"></i>KALDIR</a>
            </div>
        </div>

    @endforeach
</div>

