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
                                        <div class="tt-table-responsive">
                                            <table class="tt-table-shop-02">
                                                <tbody>
                                                @if(Session::get('website.user.0')->account_type == 2)
                                                    <tr>
                                                        <td>ŞİRKET ADI:</td>
                                                        <td><input class="user-info-input" id="company_name" value="{{ Session::get('website.user.0')->company_name }}"></td>
                                                    </tr>
                                                @endif

                                                    <tr>
                                                        <td>AD:</td>
                                                        <td><input class="user-info-input" id="first_name" value="{{ Session::get('website.user.0')->first_name }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>SOYAD:</td>
                                                        <td><input class="user-info-input" id="last_name" value="{{ Session::get('website.user.0')->last_name }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>E-MAIL:</td>
                                                        <td>{{ Session::get('website.user.0')->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>TELEFON:</td>
                                                        <td><input class="user-info-input" id="phone" value="{{ Session::get('website.user.0')->phone }}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>ÜYELİK TÜRÜ:</td>
                                                        <td>@if(Session::get('website.user.0')->account_type == 2) Kurumsal @else Bireysel @endif</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <input  id="user_id" value="{{ Session::get('website.user.0')->user_id }}" hidden disabled>
                                            <button class="btn " onclick="UpdateUserInformation()">GÜNCELLE</button><br>
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
        function UpdateUserInformation(){
            $('#loader').removeClass('hidden');

            var user_id = $('#user_id').val();
            var company_name = $('#company_name').val();
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var phone = $('#phone').val();

            let data = '{"user_id":"' + user_id + '","company_name":"' + company_name + '","first_name":"' + first_name + '","last_name":"' + last_name + '","phone":"' + phone + '"}';

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                let resp = JSON.parse(this.responseText);
                if (this.readyState == 4 && this.status == 200) {
                    $('#loader').addClass('hidden');

                    if (resp['result'] == 1) {

                        Swal.fire({
                            icon: 'success',
                            title: resp['title'],
                            text: resp['msg'],
                            allowOutsideClick: false,
                            confirmButton: false,
                        })
                        location.reload();
                    }


                }else {
                    $('#loader').addClass("hidden");

                    Swal.fire({
                        icon: 'warning',
                        text: resp['msg'],
                        confirmButtonText:'Tamam',
                        allowOutsideClick: false
                    })
                }
            };
            xhttp.onerror = function onError(e) {

                alert('con error');
            };
            xhttp.open("POST", "/api/update-user", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.send(data);
        }
    </script>
@endsection
