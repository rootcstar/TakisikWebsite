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
                                                <a class="tt-btn-close"  data-toggle="modal" data-target="#DeleteItemsModal" onclick="DeleteItemsModal('{{ fiki_encrypt($product->model_record_id) }}')"></a>
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
                                                                <span class="minus-btn"  type=button"  data-toggle="modal" data-target="#DeleteItemsModal" onclick="DeleteItemsModal('{{ fiki_encrypt($product->model_record_id) }}')"></span>
                                                            @else
                                                                <span class="minus-btn"  type=button"  onclick="DeleteItem('{{ fiki_encrypt($product->model_record_id) }}')"></span>
                                                            @endif
                                                            <input class="cart-counter" value="{{ $product->quantity }}" size="1000" id="counter-input" disabled>
                                                            <span class="plus-btn" type=button"  onclick="AddToCart('{{ fiki_encrypt($product->model_record_id) }}',1)"></span>
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
                                    <a class="btn-link" data-toggle="modal" data-target="#EmptyCartModal" onclick="EmptyShoppingCartModal()"><i class="icon-h-02"></i>SEPETİ TEMİZLE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="tt-shopcart-wrapper">
                            <div class="tt-shopcart-box">
                                <h4 class="tt-title">
                                    NOT
                                </h4>
                                <p>Siparişiniz ile ilgili eklemek istediklerinizi aşağıya ekleyibilirsiniz.</p>
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
                                <a href="#" class="btn btn-lg"><span class="icon icon-check_circle"></span>SİPARİŞİ TAMAMLA</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('external_js')
    <script>
        function EmptyShoppingCartModal(){

            $("#empty-cart").attr("onclick","EmptyShoppingCart()");
            $('#empty-cart-modal-text').text("Sepeti boşaltmak istediğinize emin misiniz?");
        }


        function EmptyShoppingCart(){

            $('#loader').removeClass('hidden');

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {

                    let response = JSON.parse(this.responseText);

                    if(response['result'] == 1){


                        $('#shopping-cart-desktop').html('');
                        $('#shopping-cart-desktop').append(response['shopping_cart']);

                        $( "#product-detail" ).load(window.location.href + " #product-detail" );

                        if(response['empty_cart'] == true){
                            $( "#shopping-cart-page" ).load(window.location.href + " #shopping-cart-page" );
                        }else{

                            $( "#shopping-cart-table" ).load(window.location.href + " #shopping-cart-table" );
                            $( "#shopping-cart-totals" ).load(window.location.href + " #shopping-cart-totals" );
                        }

                        $("#close-empty-cart-modal").click();
                        $('#loader').addClass("hidden");

                    }else{

                        $("#close-empty-cart-modal").click();
                        $('#loader').addClass("hidden");
                        Swal.fire(response['msg']);
                    }
                } else if (this.status >= 400 && this.status < 500) {
                    let response = JSON.parse(this.responseText);
                    $("#close-empty-cart-modal").click();
                    $('#loader').addClass("hidden");
                    Swal.fire(response['msg']);
                } else if (this.status >= 500) {
                    let response = JSON.parse(this.responseText);
                    $("#close-empty-cart-modal").click();
                    $('#loader').addClass('hidden');
                    Swal.fire(response['msg']);

                }
                xhttp.onerror = function onError(e) {

                    alert('con error:'+e);
                }
            };

            xhttp.open("POST", "/api/api-empty-cart", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.send();

        }
    </script>
@endsection
