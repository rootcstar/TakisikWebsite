@extends('layout.app')

<?php
    $user = Session::get('website.user');
    ?>
@section('content')
    <div id="tt-pageContent">
        <div class="container-indent">
            <div class="container">
                <div class="row">
                    @include('partials.my-account-sidebar')
                    <div class="col-md-12 col-lg-9 col-xl-9">
                        <div class="content-indent">
                            <div class="container container-fluid-custom-mobile-padding">
                                <div class="tt-shopping-layout">
                                    <div class="tt-wrapper mt-0">
                                        <div class="tt-shopping-layout">
                                            <div class="tt-title-wrapper d-flex">
                                                <span class="tt-title-cst">ADRES BİLGİLERİM</span>
                                                <div class="">
                                                    <button data-target="#NewAddressModal" data-toggle="modal" class="btn">YENİ ADRES EKLE</button><br>
                                                </div>

                                            </div>
                                            @if(count($user['billing_addresses']) != 0)
                                                <h3 class="tt-title-cst tt-title-child">FATURA ADRES BİLGİLERİ</h3>
                                                <div class="address-grid">
                                                @foreach($user['billing_addresses'] as $billing_address)
                                                    <div class="card  mb-3" style="max-width: 18rem;">
                                                        <h5 class="card-header card-title mb-0">{{$billing_address->address_title}}</h5>
                                                        <div class="card-body">
                                                            <span class="card-text mt-0">{{$billing_address->neighbourhood}}</span>
                                                            <span class="card-text-address mt-0">{{$billing_address->address}}</span>
                                                            <span class="card-text mt-0">{{$billing_address->district}}/{{$billing_address->city}}</span>
                                                            <div class="tt-shop-btn">
                                                               <btn class="btn-link" data-toggle="modal" data-target="#DeleteAddressModal" onclick="DeleteAddressModal('2','{{fiki_encrypt($billing_address->record_id)}}')" ><i class="fa fa-trash"></i>SİL</btn>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                </div>
                                            @endif

                                            @if(count($user['shipping_addresses']) != 0)
                                                <h3 class="tt-title-cst tt-title-child">KARGO ADRES BİLGİLERİ</h3>
                                                <div class="address-grid">
                                                @foreach($user['shipping_addresses'] as $shipping_address)
                                                    <div class="card  mb-3" style="max-width: 18rem;">
                                                        <h5 class="card-header card-title mb-0">{{$shipping_address->address_title}}</h5>
                                                        <div class="card-body">
                                                            <span class="card-text mt-0">{{$shipping_address->neighbourhood}}</span>
                                                            <span class="card-text-address mt-0">{{$shipping_address->address}}</span>
                                                            <span class="card-text mt-0">{{$shipping_address->district}}/{{$shipping_address->city}}</span>
                                                            <div class="tt-shop-btn">
                                                                <btn class="btn-link" data-toggle="modal" data-target="#DeleteAddressModal" onclick="DeleteAddressModal('1','{{fiki_encrypt($shipping_address->record_id)}}')" ><i class="fa fa-trash"></i>SİL</btn>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                </div>
                                            @endif
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
    </div>
@endsection
