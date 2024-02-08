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
                                                <h3 class="tt-title-cst">FATURA ADRES BİLGİLERİ</h3>
                                            <div class="address-grid">

                                                    @foreach($user['billing_addresses'] as $billing_address)
                                                        <div class="card  mb-3" style="max-width: 18rem;">
                                                            <h5 class="card-header card-title mb-0">{{$billing_address->address_title}}</h5>
                                                            <div class="card-body">
                                                                <span class="card-text mt-0">{{$billing_address->neighbourhood}}</span>
                                                                <span class="card-text-address mt-0">{{$billing_address->address}}</span>
                                                                <span class="card-text mt-0">{{$billing_address->district}}/{{$billing_address->city}}</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>


                                            @if(count($user['shipping_addresses']) != 0)
                                            <h3 class="tt-title">KARGO ADRES BİLGİLERİ</h3>
                                            @endif
                                            <div class="card border-secondary  mb-3" style="max-width: 18rem;">
                                                <h5 class="card-header card-title mb-0">ADRES BASLIK</h5>
                                                <div class="card-body text-secondary">
                                                    <p class="card-text mt-0">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                                </div>
                                            </div>
                                            <div class="tt-wrapper">
                                                <h3 class="tt-title">TITLE</h3>
                                                <div class="tt-table-responsive">
                                                    <table class="tt-table-shop-02">
                                                        <tbody>
                                                        <tr>
                                                            <td>NAME:</td>
                                                            <td>Lorem ipsum dolor sit AMET conse ctetur </td>
                                                        </tr>
                                                        <tr>
                                                            <td>E-MAIL:</td>
                                                            <td>Ut enim ad minim veniam, quis nostrud </td>
                                                        </tr>
                                                        <tr>
                                                            <td>ADDRESS:</td>
                                                            <td>Eexercitation ullamco laboris nisi ut aliquip ex ea</td>
                                                        </tr>
                                                        <tr>
                                                            <td>ADDRESS 2:</td>
                                                            <td>Commodo consequat. Duis aute irure dol</td>
                                                        </tr>
                                                        <tr>
                                                            <td>COUNTRY:</td>
                                                            <td>Lorem ipsum dolor sit amet conse ctetur</td>
                                                        </tr>
                                                        <tr>
                                                            <td>ZIP:</td>
                                                            <td>555</td>
                                                        </tr>
                                                        <tr>
                                                            <td>PHONE:</td>
                                                            <td>888888888</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tt-shop-btn">
                                                    <a class="btn-link" href="#">
                                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             viewBox="0 0 22 22" style="enable-background:new 0 0 22 22;" xml:space="preserve">
							<g>
                                <path d="M2.3,20.4C2.3,20.4,2.3,20.4,2.3,20.4C2.2,20.4,2.2,20.4,2.3,20.4c-0.2,0-0.2,0-0.3,0c-0.1,0-0.1-0.1-0.2-0.1
									c-0.1-0.1-0.1-0.2-0.1-0.3c0-0.1,0-0.2,0-0.3l0.6-5c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0-0.1,0-0.1
									c0,0,0-0.1,0.1-0.1L14.6,2.1C15,1.7,15.4,1.6,16,1.6c0.5,0,1,0.2,1.3,0.5l2.6,2.6c0.4,0.4,0.5,0.8,0.5,1.3c0,0.5-0.2,1-0.5,1.3
									L7.7,19.6c0,0-0.1,0-0.1,0.1c0,0-0.1,0-0.1,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0L2.3,20.4z M2.9,19.1l2.9-0.4
									l-2.6-2.6L2.9,19.1z M3.7,14.8L5,16.1l9.7-9.7L13.5,5L3.7,14.8z M7.2,18.3L17,8.5l-1.3-1.3L5.9,17L7.2,18.3z M15.5,3l-1.2,1.2
									l3.5,3.5L19,6.5c0.1-0.1,0.2-0.3,0.2-0.4c0-0.2-0.1-0.3-0.2-0.4L16.4,3c-0.1-0.1-0.3-0.2-0.4-0.2C15.8,2.8,15.6,2.8,15.5,3z"/>
                            </g>
							</svg>
                                                        EDIT
                                                    </a>
                                                    <a class="btn-link" href="#"><i class="icon-h-02"></i>DELETE</a>
                                                </div>
                                            </div>
                                            <div class="tt-wrapper">
                                                <h3 class="tt-title">TITLE</h3>
                                                <div class="tt-table-responsive">
                                                    <table class="tt-table-shop-02">
                                                        <tbody>
                                                        <tr>
                                                            <td>NAME:</td>
                                                            <td>Lorem ipsum dolor sit AMET conse ctetur </td>
                                                        </tr>
                                                        <tr>
                                                            <td>E-MAIL:</td>
                                                            <td>Ut enim ad minim veniam, quis nostrud </td>
                                                        </tr>
                                                        <tr>
                                                            <td>ADDRESS:</td>
                                                            <td>Eexercitation ullamco laboris nisi ut aliquip ex ea</td>
                                                        </tr>
                                                        <tr>
                                                            <td>ADDRESS 2:</td>
                                                            <td>Commodo consequat. Duis aute irure dol</td>
                                                        </tr>
                                                        <tr>
                                                            <td>COUNTRY:</td>
                                                            <td>Lorem ipsum dolor sit amet conse ctetur</td>
                                                        </tr>
                                                        <tr>
                                                            <td>ZIP:</td>
                                                            <td>555</td>
                                                        </tr>
                                                        <tr>
                                                            <td>PHONE:</td>
                                                            <td>888888888</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tt-shop-btn">
                                                    <a class="btn-link" href="#"><i class="icon-g-25"></i>EDIT</a>
                                                    <a class="btn-link" href="#"><i class="icon-h-02"></i>DELETE</a>
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
        </div>
    </div>
@endsection
