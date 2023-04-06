@extends('layout.app')

@section('content')
    <div id="tt-pageContent">
        <div class="container-indent">
            <div class="container">
                <h1 class="tt-title-subpages noborder">FAVORİLERİM</h1>
                <div class="tt-wishlist-box" id="wishlist-list">
                    @include('partials.favorites-list-div')
                </div>
            </div>
        </div>
    </div>

@endsection

@section('external_js')
    <script>

    </script>
@endsection
