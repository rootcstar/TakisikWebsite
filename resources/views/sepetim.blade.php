@extends('layout.app')

@section('content')

    <div id="tt-pageContent">
        <div class="container-indent">
            <div class="container">
                <div class="row" id="shopping-cart-page">
                    @if(Session::get('shopping_cart.products') == null || count(Session::get('shopping_cart.products')) == 0 )
                        <div class="col-md-12 text-center">
                            <img width="25%" src="{{ asset('assets/img/shop-bag.png') }}">
                        </div>
                        <div class="col-md-12">
                            <h2 class="font-semibold text-center pt-3">Sepetinizde ürün bulunmamaktadır!</h2>
                        </div>
                        <div class="col-md-12">
                            <h3 class="font-medium text-center pb-3"><a href="/alisveris">Hemen şimdi alışverişe başlayın!</a></h3>
                        </div>
                    @else
                    <div class="col-sm-12 col-xl-8">

                        <div class="tt-shopcart-table" id="shopping-cart-table">

                            <table>
                                <tbody>
                                    @foreach(Session::get('shopping_cart.products') as $product)

                                        <tr>
                                            <td>
                                                <a class="tt-btn-close"  data-toggle="modal" data-target="#DeleteItemsModal" onclick="DeleteItemsModal('{{ encrypt($product->model_record_id) }}')"></a>
                                            </td>
                                            <td>
                                                <a href="/urun-detay/{{ Str::slug($product->product_name) }}/{{ Str::slug($product->product_code) }}">
                                                <div class="tt-product-img" >
                                                    <img src="{{ $product->product_image }}" data-src="{{ $product->product_image }}" alt="">
                                                </div>
                                                </a>
                                            </td>

                                            <td>
                                                <a href="/urun-detay/{{ Str::slug($product->product_name) }}/{{ Str::slug($product->product_code) }}">
                                                    <h2 class="tt-title">
                                                        {{ $product->product_name }}
                                                    </h2>
                                                    <h2 class="tt-title">
                                                       {{ $product->product_code }}-{{ $product->model_number }}
                                                    </h2>
                                                    <ul class="tt-list-parameters">
                                                        <li>
                                                            <div class="tt-price">
                                                                {{ $product->new_price }} TL
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="detach-quantity-mobile">



                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="tt-price subtotal">
                                                                {{ number_format(($product->new_price *  $product->quantity), 2, '.', '') }} TL
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </a>
                                            </td>

                                            <td>
                                                <div class="tt-price">
                                                    {{ $product->new_price }} TL
                                                </div>
                                            </td>
                                            <td>
                                                <div class="detach-quantity-desctope">

                                                        <div class="tt-input-counter style-01">
                                                            @if( $product->quantity == 1)
                                                                <span class="minus-btn"  type=button"  data-toggle="modal" data-target="#DeleteItemsModal" onclick="DeleteItemsModal('{{ encrypt($product->model_record_id) }}')"></span>
                                                            @else
                                                                <span class="minus-btn"  type=button"  onclick="DeleteItem('{{ encrypt($product->model_record_id) }}')"></span>
                                                            @endif
                                                            <input class="cart-counter" value="{{ $product->quantity }}" size="1000" id="counter-input" disabled>
                                                            <span class="plus-btn" type=button"  onclick="AddToCart('{{ encrypt($product->model_record_id) }}',1)"></span>
                                                        </div>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="tt-price subtotal">
                                                    {{ number_format(($product->new_price *  $product->quantity), 2, '.', '') }} TL
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="tt-shopcart-btn">
                                <div class="col-left">
                                    <a class="btn-link" href="/alisveris"><i class="icon-e-19"></i>ALIŞVERİŞE DEVAM ET</a>
                                </div>
                                <div class="col-right">
                                    <a class="btn-link" href="#"><i class="icon-h-02"></i>SEPETİ TEMİZLE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="tt-shopcart-wrapper">
                            <div class="tt-shopcart-box">
                                <h4 class="tt-title">
                                    ESTIMATE SHIPPING AND TAX
                                </h4>
                                <p>Enter your destination to get a shipping estimate.</p>
                                <form class="form-default">
                                    <div class="form-group">
                                        <label for="address_country">COUNTRY <sup>*</sup></label>
                                        <select id="address_country" class="form-control">
                                            <option>Austria</option>
                                            <option>Belgium</option>
                                            <option>Cyprus</option>
                                            <option>Croatia</option>
                                            <option>Czech Republic</option>
                                            <option>Denmark</option>
                                            <option>Finland</option>
                                            <option>France</option>
                                            <option>Germany</option>
                                            <option>Greece</option>
                                            <option>Hungary</option>
                                            <option>Ireland</option>
                                            <option>France</option>
                                            <option>Italy</option>
                                            <option>Luxembourg</option>
                                            <option>Netherlands</option>
                                            <option>Poland</option>
                                            <option>Portugal</option>
                                            <option>Slovakia</option>
                                            <option>Slovenia</option>
                                            <option>Spain</option>
                                            <option>United Kingdom</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_province">STATE/PROVINCE <sup>*</sup></label>
                                        <select id="address_province" class="form-control">
                                            <option>State/Province</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_zip">ZIP/POSTAL CODE <sup>*</sup></label>
                                        <input type="text" name="name" class="form-control" id="address_zip" placeholder="Zip/Postal Code">
                                    </div>
                                    <a href="#" class="btn btn-border">CALCULATE SHIPPING</a>
                                    <p>
                                        There is one shipping rate available for Alabama, Tanzania, United Republic Of.
                                    </p>
                                    <ul class="tt-list-dot list-dot-large">
                                        <li><a href="#">International Shipping at $20.00</a></li>
                                    </ul>
                                </form>
                            </div>
                            <div class="tt-shopcart-box">
                                <h4 class="tt-title">
                                    NOTE
                                </h4>
                                <p>Add special instructions for your order...</p>
                                <form class="form-default">
                                    <textarea class="form-control" rows="7"></textarea>
                                </form>
                            </div>
                            <div class="tt-shopcart-box tt-boredr-large">
                                <table class="tt-shopcart-table01" id="shopping-cart-totals">
                                    <tbody>
                                        <tr>
                                            <th>ARA TOPLAM</th>
                                            <td>{{ Session::get('shopping_cart.total_price') }} TL</td>
                                        </tr>
                                        <tr>
                                            <th>KARGO</th>
                                            <td>19.99 TL</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>TOPLAM</th>
                                            <td>{{ Session::get('shopping_cart.total_price') }} + KARGO TL</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <a href="#" class="btn btn-lg"><span class="icon icon-check_circle"></span>PROCEED TO CHECKOUT</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
