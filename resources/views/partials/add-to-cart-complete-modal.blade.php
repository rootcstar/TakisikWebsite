<div class="tt-modal-addtocart desctope">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="tt-modal-messages">
                <i class="icon-f-68"></i> Ürün sepete eklendi!
            </div>
            <div class="tt-modal-product">
                <div class="tt-img">
                    <img src="{{ $product->product_image }}" data-src="{{ $product->product_image }}" alt="">
                </div>
                <h2 class="tt-title">{{ $product->product_code }}-{{ $product->model_number }}</h2>
                <h2 class="tt-title">{{ $product->product_name }}</h2>
                <div class="tt-qty">
                    SEPETTEKİ ADET: <span>{{ $product->quantity }}</span>
                </div>
            </div>
            <div class="tt-product-total">
                <div class="tt-total">
                    FİYAT: <span class="tt-price">{{ $product->new_price }} TL</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <a href="#" class="tt-cart-total">
                Sepetinizde toplam {{ Session::get('shopping_cart.total_qty') }} ürün var.
                <div class="tt-total">
                   SEPET TOPLAM: <span class="tt-price">{{ Session::get('shopping_cart.total_price') }} TL</span>
                </div>
            </a>
            <a href="#" class="btn btn-border btn-close-popup">ALIŞVERIŞE DEVAM ET</a>
            <a href="/sepetim" class="btn">SEPETE GİT</a>
        </div>
    </div>
</div>
