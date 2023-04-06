@extends('layout.app')

@section('content')
    <div id="tt-pageContent">
        <div class="container-indent">
            <div class="container">
                <div class="tt-login-form">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="tt-item">
                                <h2 class="tt-title">YENI KULLANICI</h2>
                                <p>

                                    Firmamızdan bir kullanıcıa hesabı oluşturarak alışveriş sayfasına gidebilir ve siparişlerinizi oluşturabilirsiniz.
                                </p>
                                <div class="form-group">
                                    <a href="/uyelik/yeni" class="btn btn-top btn-border">HESAP OLUŞTUR</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <div class="tt-item">
                                <h2 class="tt-title">GİRİŞ</h2>

                                <div class="form-default form-top">
                                    @csrf


                                        <div class="form-group">
                                            <label for="loginAcoountType">ÜYELİK *</label>
                                            <div class="tt-required">* zorunlu alanlar</div>
                                            <select class="form-control" id="account_type">
                                                <option value="{{encrypt(1)}}">Bireysel</option>
                                                <option value="{{encrypt(2)}}">Kurumsal</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="loginInputName">E-MAIL ADRESİNİZ *</label>
                                            <input type="text" id="email" class="form-control" name="email" placeholder="Email adresiniz" required="" >
                                        </div>
                                        <div class="form-group">
                                            <label for="loginInputEmail">ŞİFRENİZ *</label>
                                            <input type="password" id="password" class="form-control" name="password" placeholder="Şifreniz" required="">
                                        </div>
                                        <div class="row">
                                            <div class="col-auto mr-auto">
                                                <div class="form-group">
                                                    <button class="btn btn-border"  onclick="SigninSubmit()" name="signin-submit">GİRİŞ</button>
                                                </div>
                                            </div>
                                            <div class="col-auto align-self-end">
                                                <div class="form-group">
                                                    <ul class="additional-links">
                                                        <li><a onclick="ForgetPassword()">Şifremi Unuttum!</a></li>
                                                    </ul>
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
        function SigninSubmit(){

            $('#loader').removeClass('hidden');

            var account_type = $('#account_type').val();
            var email = $('#email').val();
            var password = $('#password').val();

            let data = '{"email":"' + email + '","password":"' + password + '","account_type":"' + account_type + '"}';

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                let resp = JSON.parse(this.responseText);
                if (this.readyState == 4 && this.status == 200) {


                    if (resp['result'] == 1) {
                        $('#loader').addClass('hidden');
                        window.location = '/alisveris';
                    }

                    $('#loader').addClass('hidden');
                    Swal.fire({
                        icon: 'warning',
                        text: resp['msg'],
                        showConfirmButton: false,
                    })




                }else if (this.status >= 400 && this.status < 500) {
                    $('#loader').addClass("hidden");
                    Swal.fire({
                        icon: 'warning',
                        text: resp['msg'],
                        confirmButtonText: 'Tamam',
                        outsideClick: false,
                    })
                } else if (this.status >= 500) {

                    $('#loader').addClass('hidden');
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata',
                        text: resp['msg']
                    })

                }
            };
            xhttp.onerror = function onError(e) {

                alert('con error');
            };
            xhttp.open("POST", "api/api-signin", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.send(data);

        }

        function ForgetPassword(){

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Mail adresinizi giriniz',
                input: 'text',
                inputID: 'forget_passw_mail',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                showCancelButton: true,
                confirmButtonText: 'Gönder',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
                cancelButtonText: 'İptal',
            }).then((result) => {

                    if (result.isConfirmed) {
                        $('#loader').removeClass('hidden');

                        var email = result.value;

                        let data = '{"email":"' + email + '"}';

                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function () {
                            let resp = JSON.parse(this.responseText);
                            if (this.readyState == 4 && this.status == 200) {


                                if (resp['result'] == 1) {
                                    $('#loader').addClass('hidden');

                                    swalWithBootstrapButtons.fire({

                                        text: resp['msg'],
                                        icon: 'success',
                                        confirmButtonText: 'Tamam',
                                        showLoaderOnConfirm: true,
                                        allowOutsideClick: false,
                                    })

                                }else{

                                    $('#loader').addClass('hidden');
                                    swalWithBootstrapButtons.fire({
                                        text: resp['msg'],
                                        icon: 'error',
                                        confirmButtonText: 'Tamam',
                                        showLoaderOnConfirm: true,
                                        allowOutsideClick: false,
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
                        xhttp.open("POST", "api/api-forget-password", true);
                        xhttp.setRequestHeader("Content-Type", "application/json");
                        xhttp.send(data);
                    }
            })
        }

    </script>
@endsection
