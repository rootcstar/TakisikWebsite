@extends('layout.app')

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
                                        <h3 class="tt-title">KULLANICI BİLGİLERİ</h3>
                                        {{  request()->route()->getName() }}
                                        <div class="tt-table-responsive">
                                            <table class="tt-table-shop-02">
                                                <tbody>
                                                    <tr>
                                                        <td>AD:</td>
                                                        <td>{{ Session::get('user.0')->first_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>SOYAD:</td>
                                                        <td>{{ Session::get('user.0')->last_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>E-MAIL:</td>
                                                        <td>{{ Session::get('user.0')->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>TELEFON:</td>
                                                        <td>+{{ Session::get('user.0')->country_code }} {{ Session::get('user.0')->phone }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ÜYELİK TÜRÜ:</td>
                                                        <td>@if(Session::get('user.0')->account_type == 2) Kurumsal @else Bireysel @endif</td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
