@extends('layout.app')

@section('content')
    <div id="tt-pageContent">
        <div class="container-indent">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-lg-3 col-xl-3 leftColumn aside">
                        <div class="tt-collapse tt-account-card open">
                            <h3 class="tt-account-card-title">HESABIM</h3>
                            <div class="tt-collapse-content">
                                <ul class="tt-list-row">
                                    <li class="active"><a href="#">Kullanıcı Bilgilerim</a></li>
                                    <li class=""><a href="#">Adres Bilgilerim</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tt-collapse open tt-account-card">
                            <h3 class="tt-account-card-title">SİPARİŞLERİM</h3>
                            <div class="tt-collapse-content">
                                <ul class="tt-list-row">
                                    <li class="active"><a href="#">Dresses</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-9 col-xl-9">
                        <div class="content-indent">
                            <div class="container container-fluid-custom-mobile-padding">
                                <div class="tt-shopping-layout">
                                    <div class="tt-wrapper mt-0">
                                        <h3 class="tt-title">ACCOUNT DETAILS</h3>
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
                                        <a href="#" class="btn btn-border">VIEW ADDRESS 2</a>
                                    </div>
                                    <div class="tt-wrapper">
                                        <h3 class="tt-title">ORDER HISTORY</h3>
                                        <div class="tt-table-responsive">
                                            <table class="tt-table-shop-01">
                                                <thead>
                                                <tr>
                                                    <th>ORDER</th>
                                                    <th>DATE</th>
                                                    <th>PAYMENT STATUS</th>
                                                    <th>FULFILLMENT STATUS</th>
                                                    <th>TOTAL</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><a href="shopping_order.html">#001</a></td>
                                                    <td>November 20. 2016</td>
                                                    <td>Processing</td>
                                                    <td>Processing</td>
                                                    <td>$40 fot 1 item</td>
                                                </tr>
                                                <tr>
                                                    <td><a href="shopping_order.html">#001</a></td>
                                                    <td>November 20. 2016</td>
                                                    <td>Processing</td>
                                                    <td>Processing</td>
                                                    <td>$40 fot 1 item</td>
                                                </tr>
                                                <tr>
                                                    <td><a href="shopping_order.html">#001</a></td>
                                                    <td>November 20. 2016</td>
                                                    <td>Processing</td>
                                                    <td>Processing</td>
                                                    <td>$40 fot 1 item</td>
                                                </tr>
                                                <tr>
                                                    <td><a href="shopping_order.html">#001</a></td>
                                                    <td>November 20. 2016</td>
                                                    <td>Processing</td>
                                                    <td>Processing</td>
                                                    <td>$40 fot 1 item</td>
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

@section('external_js')
    <script>

    </script>
@endsection
