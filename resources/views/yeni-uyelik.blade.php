@extends('layout.app')

@section('content')
    <div id="tt-pageContent">
        <div class="container-indent">
            <div class="container">
                <div class="tt-login-form">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6">
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-6 text-center">
                                        <a class="tt-promo-02 register-btn-01" type="button" onclick="GetFrom('{{ fiki_encrypt(0) }}')">
                                            <div class="tt-description tt-point-h-l">
                                                <div class="tt-description-wrapper">
                                                    <div class="tt-title-large">BIREYSEL</div>
                                                </div>
                                            </div>
                                        </a>
                                </div>
                                <div class="col-md-6 col-lg-6 col-6 text-center" onclick="GetFrom('{{ fiki_encrypt(1) }}')">
                                    <a class="tt-promo-02 register-btn-02" >
                                        <div class="tt-description tt-point-h-l">
                                            <div class="tt-description-wrapper">
                                                <div class="tt-title-large">KURUMSAL</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center" id="register-form-content">
                        <div class="col-md-8 col-lg-6">
                            <div class="tt-item">
                                <h2 class="tt-title">YENİ HESAP OLUŞTURUN</h2>
                                <h3 class="tt-title">Lütfen açmak istediğiniz hesap türünü seçiniz.</h3>
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

        function GetFrom(id){

            $('#loader').removeClass('hidden');

            let data = '{"id":"' + id + '"}';

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {

                    let resp = JSON.parse(this.responseText);

                    $('#loader').addClass('hidden');

                    if (resp['result'] == 1) {

                        $('#register-form-content').html('');
                        $('#register-form-content').append(resp['form']);

                    }else{

                        Swal.fire({
                            icon: 'warning',
                            text: resp['msg'],
                            confirmButtonText:'Tamam',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })

                    }

                }else if (this.status >= 400 && this.status < 500) {
                    let resp = JSON.parse(this.responseText);
                    $('#loader').addClass("hidden");
                    Swal.fire(resp['msg']);
                } else if (this.status >= 500) {
                    let resp = JSON.parse(this.responseText);
                    $('#loader').addClass('hidden');
                    Swal.fire(resp['msg']);

                }
            };
            xhttp.onerror = function onError(e) {

                alert('con error');
            };
            xhttp.open("POST", "/api/api-get-register-form", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.send(data);

        }

        function RegisterSubmit(){

            $('#loader').removeClass('hidden');

            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var country_code = $('#country_code').val();
            var phone = $('#phone').val();
            var email = $('#email').val();
            var password = $('#password').val();

            let data = '{"first_name":"' + first_name + '","last_name":"' + last_name + '","email":"' + email + '","country_code":"' + country_code + '","phone":"' + phone + '","password":"' + password + '"}';

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                let resp = JSON.parse(this.responseText);
                if (this.readyState == 4 && this.status == 200) {


                    if (resp['result'] == 1) {
                        $('#loader').addClass('hidden');
                        Swal.fire({
                            icon: 'success',
                            title: resp['title'],
                            text: resp['msg'],
                            allowOutsideClick: false,
                            confirmButtonText:'Tamam',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = '/';
                            }
                        })
                    }else{

                        $('#loader').addClass('hidden');

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
            xhttp.open("POST", "/api/api-register", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.send(data);

        }
    </script>
@endsection
