@extends('layout.app')

@section('content')

    <div id="tt-pageContent">
        <div class="container-indent">
            <div class="container">
                <div class="row" id="shopping-cart-page">
                    @if(Session::get('website.shopping_cart.products') == null || count(Session::get('website.shopping_cart.products')) == 0 )
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
                                    @foreach(Session::get('website.shopping_cart.products') as $product)

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
                                    <a class="btn-link" href="/kategoriler"><i class="icon-e-19"></i>ALIŞVERİŞE DEVAM ET</a>
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
                                <div class="form-default">
                                    <div class="form-group" id="form-group-shipping-address">
                                        <h5 class="control-label pb-1">Teslimat Adresi</h5>
                                            <?php
                                                $user = Session::get('website.user');
                                            ?>
                                            @if(count($user['shipping_addresses']) != 0)
                                                <select class="form-control" id="shipping_address" name="shipping_address" required="">
                                                    <option value="" >Seçiniz</option>
                                                    @foreach($user['shipping_addresses'] as $shipping_address)
                                                        <option class="text-truncate" value="{{$shipping_address->record_id}}">{{$shipping_address->address_title}} ({{$shipping_address->address}})</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <button data-target="#NewAddressModal" data-toggle="modal" class="btn btn-border">YENİ ADRES EKLE</button>
                                            @endif

                                    </div>
                                    <div class="form-group  hide" id="form-group-billing-address">
                                        <h5 class="control-label pb-1">Fatura Adresi</h5>
                                            <?php
                                                $user = Session::get('website.user');
                                            ?>
                                            @if(count($user['billing_addresses']) != 0)
                                            <select class="form-control " id="billing_address" name="billing_address" disabled>
                                                <option value="" >Seçiniz</option>
                                                @foreach($user['billing_addresses'] as $billing_address)
                                                    <option class="text-truncate"  value="{{$billing_address->record_id}}">{{$billing_address->address_title}} ({{$billing_address->address}})</option>
                                                @endforeach
                                            </select>
                                            @else
                                                <button data-target="#NewAddressModal" data-toggle="modal" class="btn btn-border">YENİ ADRES EKLE</button>
                                            @endif


                                    </div>
                                    <input type="checkbox" id="check_billing_address" onclick="checkCheckbox()" checked> Faturamı aynı adrese gönder.</input>
                                    <hr>
                                    <h4 class="tt-title">
                                        NOT
                                    </h4>
                                    <p>Siparişiniz ile ilgili eklemek istediklerinizi aşağıya ekleyibilirsiniz.</p>
                                    <textarea class="form-control" rows="7" id="note"></textarea>
                                </div>
                            </div>
                            <div class="tt-shopcart-box tt-border-large">
                                <table class="tt-shopcart-table01" id="shopping-cart-totals">
                                    <tbody>
                                        <tr>
                                            <th>ARA TOPLAM</th>
                                            <td>{{ Session::get('website.shopping_cart.total_price') }} TL</td>
                                        </tr>
                                        <tr>
                                            <th>KARGO</th>
                                            <td>19.99 TL</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>TOPLAM</th>
                                            <td>{{ Session::get('website.shopping_cart.total_price') }} + KARGO TL</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <a  onclick="PlaceOrder()" class="btn btn-lg"><span class="icon icon-check_circle"></span>SİPARİŞİ TAMAMLA</a>
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

            xhttp.open("POST", "/api/empty-cart", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.send();

        }


        function PlaceOrder(){

            $('#loader').removeClass('hidden');
            let formData = new FormData();

            var shipping_address = document.getElementById('shipping_address');
            if(!shipping_address){
                $('#loader').addClass('hidden');
                Swal.fire({
                    icon: 'warning',
                    title: 'Lütfen bir teslimat adresi ekleyiniz',
                    showConfirmButton: false,
                })
                return;
            }
            if(!$('#shipping_address').find(':selected').val()){
                $('#loader').addClass('hidden');
                Swal.fire({
                    icon: 'warning',
                    title: 'Lütfen teslimat adresini seçiniz',
                    showConfirmButton: false,
                })
                return;
            }


            var checkbox = document.getElementById("check_billing_address");
            if (checkbox.checked) {
                 check_billing_address = 1;
            }else{
                var check_billing_address = 0;
                var billing_address = document.getElementById('billing_address');
                if(!billing_address){
                    $('#loader').addClass('hidden');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Lütfen bir fatura adresi ekleyiniz',
                        showConfirmButton: false,
                    })
                    return;
                }
                if(!$('#billing_address').find(':selected').val()){
                    $('#loader').addClass('hidden');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Lütfen fatura adresini seçiniz',
                        showConfirmButton: false,
                    })
                    return;
                }
                formData.append('billing_address', $('#billing_address').find(':selected').val());
            }

            if($('#note').val()){
                formData.append('note', $('#note').val());
            }


            formData.append('shipping_address', $('#shipping_address').find(':selected').val());
            formData.append('check_billing_address', check_billing_address);
            formData.append('note', $('#note').val());


            fetch('{{route('place_order')}}', {

                method: "POST",
                body: formData

            })
                .then(response => {
                    return response.json();
                })
                .then(data => {
                    if (data.result == '1') {

                        $('#loader').addClass('hidden');
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            outsideClick: false,
                        })

                    //    window.location.reload();
                    }else{

                        $('#loader').addClass('hidden');
                        Swal.fire({
                            icon: 'error',
                            title: 'Ups!',
                            text: data.msg
                        })
                    }



                })
                .catch((error) => {
                    Swal.fire({
                        icon: 'error',
                        title: error,
                    })
                });


        }
    </script>
@endsection
