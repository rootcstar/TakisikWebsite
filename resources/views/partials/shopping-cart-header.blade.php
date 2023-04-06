





@if(Session::get('shopping_cart.products') == null || count(Session::get('shopping_cart.products')) == 0)

        <button class="tt-dropdown-toggle">
            <i class="icon-f-39"></i>
            <span class="tt-badge-cart">0</span>
        </button>
        <div class="tt-dropdown-menu">
            <div class="tt-mobile-add">
                <button class="tt-close">Kapat</button>
            </div>
            <div class="tt-dropdown-inner">
                <div class="tt-cart-layout">
                    <!-- layout emty cart -->
                    <a  class="tt-cart-empty" style="padding-bottom:0px;">
                        <i class="icon-f-39"></i>
                        <p>No Products in the Cart</p>
                    </a>
                </div>
            </div>
        </div>
@else

        <button class="tt-dropdown-toggle">
            <i class="icon-f-39"></i>
            <span class="tt-badge-cart">{{ Session::get('shopping_cart.total_qty')  }}</span>
        </button>
        <div class="tt-dropdown-menu">
            <div class="tt-mobile-add">
                <button class="tt-close">Kapat</button>
            </div>
            <div class="tt-dropdown-inner">
                <div class="tt-cart-layout">
                    <div class="tt-cart-content">
                        <div class="tt-cart-list">


                            @foreach(Session::get('shopping_cart.products') as $product)

                                <div class="tt-item">
                                    <a href="/urun-detay/{{ Str::slug($product->product_name) }}/{{ Str::slug($product->product_code) }}">
                                        <div class="tt-item-img">
                                            <img src="{{$product->product_image }}" data-src="{{$product->product_image }}" alt="">
                                        </div>
                                        <div class="tt-item-descriptions">
                                            <h2 class="tt-title">{{$product->product_name }}</h2>
                                            <ul class="tt-add-info">
                                                <li>{{$product->product_code }}-{{$product->model_number }}</li>

                                            </ul>
                                            <div class="tt-quantity">{{$product->quantity }} X</div> <div class="tt-price">{{$product->new_price }} TL</div>
                                        </div>
                                    </a>
                                    <div class="tt-item-close">
                                        <a href="#" class="tt-btn-close"  data-toggle="modal" data-target="#DeleteItemsModal" onclick="DeleteItemsModal('{{ encrypt($product->model_record_id) }}')"></a>
                                    </div>
                                </div>


                            @endforeach
                        </div>
                        <div class="tt-cart-total-row">
                            <div class="tt-cart-total-title">ARA TOPLAM:</div>
                            <div class="tt-cart-total-price">{{  Session::get('shopping_cart.total_price')  }} TL</div>
                        </div>
                        <div class="tt-cart-btn">
                            <div class="tt-item">
                                <a href="/sepetim" class="btn">SEPETE GİT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endif
