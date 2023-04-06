@extends('layout.app')

@section('content')
    <div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="index.html">Home</a></li>
            <li>Listing</li>
        </ul>
    </div>
</div>
    <div id="tt-pageContent">
        <div class="container-indent">
            <div class="container">
                <div class="tt-layout-promo-box">
                    <div class="row">

                        @foreach($categories as $category)
                            <div class="col-sm-6 col-md-4">
                                <div type="button"  onclick="GetCategory('{{encrypt($category->tag_id)}}')" class="tt-promo-box tt-one-child category-select">
                                    <img src="{{$category->tag_image}}" data-src="{{$category->tag_image}}" onerror="this.onerror=null; this.src='{{ asset('assets/img/placeholder500x500.jpg') }}'">
                                    <div class="tt-description">
                                        <div class="tt-description-wrapper">
                                            <div class="tt-background"></div>
                                            <div class="tt-title-small text-uppercase">{{$category->display_name}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('external_js')
    <script>
        function GetCategory(id){

          //  $('#loader').removeClass("hidden");
            var data = '{"id":"' + id + '"}';


            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.responseText);
                    if (response['result'] == 1) {

                        window.location.href = '/alisveris';

                    }else{
                    //    $('#loader').addClass("hidden");
                        Swal.fire(response['msg']);
                    }

                } else if (this.status >= 400 && this.status < 500) {
                    let response = JSON.parse(this.responseText);
                  //  $('#loader').addClass("hidden");
                    Swal.fire(response['msg']);
                } else if (this.status >= 500) {
                    let response = JSON.parse(this.responseText);
                  //  $('#loader').addClass('hidden');
                    Swal.fire(response['msg']);

                }
            };
            xhttp.onerror = function onError(e) {

                alert('con error:'+e);
            }

            xhttp.open("POST", "/api/api-get-category", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.send(data);

        }
    </script>
@endsection
