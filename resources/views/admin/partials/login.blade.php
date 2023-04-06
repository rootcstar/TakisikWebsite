<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Takışık Admin Panel</title>
    <link rel="shortcut icon" href="{{asset("assets/img/logos/favicon.png")}}"/>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin-assets/dist/css/adminlte.css')}}">

    <link rel="stylesheet" href="{{asset('admin-assets/plugins/ekko-lightbox/ekko-lightbox.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('admin-assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/preview/searchPane/dataTables.searchPane.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}"> {{-- not found in assets --}}
    <link rel="stylesheet" href="{{asset('admin-assets/plugins/summernote/summernote-bs4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin-assets/dist/css/admin-custom.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <img src="{{asset("assets/img/logos/logo-b.png")}}" width="80%">
    </div>
    <div class="card">
        <div class="card-body login-card-body">

            <form action="" method="post" enctype="multipart/form-data">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password"  id="password" name="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

            <!--    <div class=" mb-3 col g-recaptcha" id="g-recaptcha-response" name = "g-recaptcha-response" data-sitekey="6Lcw69giAAAAAAyU9kfmljq3tS--u7LhTTUZLu4f"></div> -->

                <div class="col-6 offset-3 text-right">
                        <div  class="btn btn-block btn-info" name=""
                              onclick="AdminLogin();">Giriş Yap
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('admin-assets/dist/js/adminlte.min.js')}}"></script>
<script src="{{ asset('admin-assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src='https://www.google.com/recaptcha/api.js' async defer></script>

<script>
    function AdminLogin(){

     /*   var response = grecaptcha.getResponse();
        if(response == undefined){
            alert('Robot olmadiginizi dogrulayin.');
            grecaptcha.reset();
            return;
        }

      */

        let email = document.getElementById("email").value;
        if (email == "" || email == " " || email == undefined) {
            Swal.fire({
                icon: 'info',
                title: 'Ups...',
                text: 'Lütfen bir email giriniz.',
            })
            return;
        }

        let password = document.getElementById("password").value;
        if (password == "" || password == " " || password == undefined) {
            Swal.fire({
                icon: 'info',
                title: 'Ups...',
                text: 'Lütfen bir şifre giriniz.',
            })
            return;
        }

        let formData2 = new FormData();

        formData2.append("email", email);
        formData2.append("password", password);
     /*   formData2.append("g-recaptcha-response", response);    */


        Swal.showLoading();
        fetch('/api/admin-login', {method: "POST", body: formData2})
            .then(response => response.json())
            .then(data => {
                if (data.result == '1') {

                    Swal.fire({
                        title: data.msg,
                        showConfirmButton: false,
                        outsideClick: false,
                    })

                    window.location = '/admin';
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ups!',
                        text: data.msg
                    }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                })

                }
            })
            .catch(error => {
                console.log('Error', error);
            });

    }

</script>
</body>
</html>
