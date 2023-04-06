@extends('layout.app')
<?php

    $user_id = $_GET['user_id'];

?>

@section('content')
    <div id="tt-pageContent">
        <div class="container-indent">
            <div class="container">
                <h1 class="tt-title-subpages noborder">ŞİFRENİZİ YENİLEYİN</h1>
                <div class="tt-login-form">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6">
                            <div class="tt-item">
                                <div class="form-default">
                                    @csrf
                                        <div class="form-group">
                                            <input value="{{ $user_id }}" id="control" disabled hidden>
                                            <label for="loginInputName">Yeni Şifre</label>
                                            <input type="password" name="password" class="form-control" id="password" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="loginLastName">Yeni şifre tekrar</label>
                                            <input type="password" name="password_ctrl" class="form-control" id="password_ctrl" placeholder="">
                                        </div>
                                        <div class="tt-required">* Şifrelerin eşleştiğinden emin olunuz.</div>
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <button class="btn btn-border" onclick="NewPasswordSubmit()">Gönder</button>
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

@section('external_js')
    <script>
        function NewPasswordSubmit(){
            $('#loader').removeClass('hidden');

            var password = $('#password').val();
            var password_ctrl = $('#password_ctrl').val();
            var control = $('#control').val();

            let data = '{"password":"' + password + '","password_ctrl":"' + password_ctrl + '","control":"' + control + '"}';

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
                            confirmButtonText:'Tamam',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = '/uyelik';
                            }
                        })
                    }else if(resp['result'] == -3){

                        Swal.fire({
                            icon: 'warning',
                            text: resp['msg'],
                            confirmButtonText:'Tamam',
                            allowOutsideClick: false
                        }).then((result) => {
                            $('#loader').removeClass('hidden');
                            if (result.isConfirmed) {
                               location.reload();
                            }
                        })

                    }else{

                        Swal.fire({
                            icon: 'warning',
                            text: resp['msg'],
                            confirmButtonText:'Tamam',
                            allowOutsideClick: false
                        })
                    }



                }else if (this.status >= 400 && this.status < 500) {
                    $('#loader').addClass("hidden");
                    Swal.fire(resp['msg']);
                } else if (this.status >= 500) {

                    $('#loader').addClass('hidden');
                    Swal.fire(resp['msg']);

                }
            };
            xhttp.onerror = function onError(e) {

                alert('con error');
            };
            xhttp.open("POST", "/api/api-new-password", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.send(data);
        }
    </script>
@endsection
