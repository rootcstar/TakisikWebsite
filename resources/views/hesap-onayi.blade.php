@extends('layout.app')
<?php



?>
@section('content')
    <div class="container-indent nomargin">
        <div class="tt-empty-wishlist">
            <h1 class="tt-title">HESABINIZ ONAYLANDI</h1>
            <div class="icon-svg">
               <img src="{{ asset('assets/img/confirm-checkbox.png') }}" width="8%">
            </div>
            <p>Bizi tercih ettiğiniz için teşekkür ederiz.</p>
            <a href="/uyelik" class="btn">Alışverişe Başlayın!</a>
        </div>
    </div>
@endsection
