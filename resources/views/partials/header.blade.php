<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Takışık</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Wokiee - Responsive HTML5 Template">
    <meta name="author" content="wokiee">
    <link rel="shortcut icon" href="{{ asset('assets/img/logos/favicon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.css') }}"> {{-- not found in assets --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}"> {{-- not found in assets --}}
    @yield('external_css')
</head>
<body>
<div class="loader hidden" id="loader">
    <div class="loadingio-spinner-ripple-be5ycp1ovec"><div class="ldio-diw91tq3ek">
            <div></div>
            <div></div>
        </div>
    </div>
</div>
<header>
    <!-- tt-mobile menu -->
    <nav class="panel-menu mobile-main-menu">
        <ul>
            <li>
                <a href="/">ANASAYFA</a>
            </li>
            <li>
                <a href="/hakkimizda">HAKKIMIZDA</a>
            </li>
            @if(Session::get('website.is_login') == true)
                <li class="dropdown tt-megamenu-col-01">
                    <a href="/kategoriler">ALIŞVERİŞ</a>
                </li>
            @endif
            <li class="dropdown tt-megamenu-col-01">
                <a href="/iletisim">BİZE ULAŞIN</a>
            </li>
            @if(Session::get('website.is_login') != true)
                <li class="dropdown tt-megamenu-col-01">
                    <a href="/uyelik">GİRİŞ YAP / KAYIT OL</a>
                </li>
            @endif
        </ul>
        <div class="mm-navbtn-names">
            <div class="mm-closebtn">Close</div>
            <div class="mm-backbtn">Back</div>
        </div>
    </nav>
    <!-- tt-mobile-header -->
    <div class="tt-mobile-header">
        <div class="container-fluid">
            <div class="tt-header-row">
                <div class="tt-mobile-parent-menu">
                    <div class="tt-menu-toggle">
                        <i class="icon-03"></i>
                    </div>
                </div>
                <!-- search -->
                <div class="tt-mobile-parent-search tt-parent-box"></div>
                <!-- /search -->
                <!-- cart -->
                <div class="tt-mobile-parent-cart tt-parent-box" >
                    <div class="tt-cart tt-dropdown-obj " data-tooltip="Cart" data-tposition="bottom" >
                    </div>
                </div>
                <!-- /cart -->
                <!-- account -->
                <div class="tt-mobile-parent-account tt-parent-box"></div>
                <!-- /account -->
                <!-- currency -->
                <div class="tt-mobile-parent-multi tt-parent-box"></div>
                <!-- /currency -->
            </div>
        </div>
        <div class="container-fluid tt-top-line">
            <div class="row">
                <div class="tt-logo-container">
                    <!-- mobile logo -->
                    <a class="tt-logo tt-logo-alignment" href="index.html"><img src="{{ asset('assets/img/logos/logo-all-white.png') }}" alt=""></a>
                    <!-- /mobile logo -->
                </div>
            </div>
        </div>
    </div>
    <!-- tt-desktop-header -->
    <div class="tt-desktop-header">
        <div class="container">
            <div class="tt-header-holder">
                <div class="tt-col-obj tt-obj-logo">
                    <!-- logo -->
                    <a class="tt-logo tt-logo-alignment" href="/"><img src="{{ asset('assets/img/logos/logo-all-white.png') }}" alt=""></a>
                    <!-- /logo -->
                </div>
                <div class="tt-col-obj tt-obj-menu obj-aligment-right">
                    <!-- tt-menu -->
                    <div class="tt-desctop-parent-menu tt-parent-box">
                        <div class="tt-desctop-menu">
                            <nav>
                                <ul>
                                    <li class="dropdown tt-megamenu-col-02">
                                        <a href="/">ANASAYFA</a>
                                    </li>
                                    <li class="dropdown megamenu">
                                        <a href="/hakkimizda">HAKKIMIZDA</a>
                                    </li>
                                    @if(Session::get('website.is_login') == true)
                                        <li class="dropdown tt-megamenu-col-01">
                                            <a href="/kategoriler">ALIŞVERİŞ</a>
                                        </li>
                                    @endif
                                    <li class="dropdown tt-megamenu-col-01">
                                        <a href="/iletisim">BİZE ULAŞIN</a>
                                    </li>
                                    @if(Session::get('website.is_login') != true)
                                        <li class="dropdown tt-megamenu-col-01">
                                            <a href="/uyelik">GİRİŞ YAP / KAYIT OL</a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- /tt-menu -->
                </div>
                <div class="tt-col-obj tt-obj-options">
                    @if(Session::get('website.is_login') == true)
                        <!-- tt-cart -->
                        <div class="tt-desctop-parent-cart tt-parent-box" >
                            <div class="tt-cart tt-dropdown-obj " data-tooltip="Cart" data-tposition="bottom" id="shopping-cart-desktop">
                            @include('partials.shopping-cart-header')
                            </div>
                        </div>
                        <!-- /tt-cart -->

                        <!-- tt-account -->
                        <div class="tt-desctop-parent-account tt-parent-box">
                            <div class="tt-account tt-dropdown-obj">
                                <button class="tt-dropdown-toggle"  data-tooltip="My Account" data-tposition="bottom"><i class="icon-f-94"></i></button>
                                <div class="tt-dropdown-menu">
                                    <div class="tt-mobile-add">
                                        <button class="tt-close">Close</button>
                                    </div>
                                    <div class="tt-dropdown-inner">
                                        <ul>
                                            <li><a href="/hesabim"><i class="icon-f-94"></i>Hesabım</a></li>
                                            <li><a href="/favorilerim"><i class="icon-n-072"></i>Favorilerim</a></li>
                                            <li><a href="/logout"><i class="icon-f-76"></i>Çıkış Yap</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /tt-account -->
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- stuck nav -->
    <div class="tt-stuck-nav">
        <div class="container">
            <div class="tt-header-row ">
                <div class="tt-stuck-parent-menu"></div>
                <div class="tt-stuck-parent-cart tt-parent-box">
                    <div class="tt-cart tt-dropdown-obj " data-tooltip="Cart" data-tposition="bottom">
                    </div>
                </div>
                <div class="tt-stuck-parent-account tt-parent-box"></div>
            </div>
        </div>
    </div>
    @if(Session::has('website.is_login') && (Session::get('website.is_login') == true))
    <div id="header-info-box">
    @if(Session::has('website.shopping_cart.total_qty') && (Session::get('website.shopping_cart.total_qty') > 0))
        @php $price = (config('constants.total_price_for_free_shipping')-Session::get('website.shopping_cart.total_price')) @endphp
        @if($price > 0)
            <div class="tt-color-scheme-05">
                <div class="container">
                    <div class="tt-header text-center">
                        <div class="tt-box-info ">
                            <p>{{$price}} TL'lik daha ürün ekle ücretsiz kargo fırsatından yararlan!</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else

        <div class="tt-color-scheme-05">
            <div class="container">
                <div class="tt-header text-center">
                    <div class="tt-box-info ">
                        <p>{{config('constants.total_price_for_free_shipping')}} TL ve üzeri siparişlerinizde ücretsiz kargo fırsatı!</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
    @endif
</header>

@yield('content')
