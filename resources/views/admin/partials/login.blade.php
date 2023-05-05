<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/img/logos/favicon.png')}}">
    <title>Golden Line Limo Admin Panel</title>
    <!-- Custom CSS -->
    <link href="{{asset('dist/css/style.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin-assets/css/custom.css')}}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body style="    background: #f0f5f9; !important">
<div class="main-wrapper">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url({{asset('assets/img/4050.jpg')}}) no-repeat center center;">
        <div class="auth-box">
            <div id="loginform">
                <div class="logo ">
                    <span class="db "><img src="{{asset('assets/img/logos/logo-all-black.png')}}" alt="logo" style="width:50%;" /></span>
                    <h5 class="font-medium m-t-20">Yönetici Giriş</h5>
                </div>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <form class="form-horizontal m-t-20 needs-validation" novalidate >
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                </div>
                                <input type="email" class="form-control" id="email" placeholder="Lütfen mail adresinizi giriniz">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                                </div>
                                <input type="password" class="form-control" id="password" placeholder="Lütfen şifrenizi giriniz">
                            </div>

                            <div class="form-group text-center">
                                <div class="col-xs-12 p-b-20">
                                    <div class="btn btn-block btn-lg btn-dark" onclick="login()">Log In</div>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper scss in scafholding.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper scss in scafholding.scss -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right Sidebar -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- All Required js -->
<!-- ============================================================== -->
<script src="{{asset('admin-assets/libs/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('admin-assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{asset('admin-assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- ============================================================== -->
<!-- This page plugin js -->
<!-- ============================================================== -->
<script>
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
</script>
</body>

</html>
<script>
    function login() {
        Swal.showLoading();

        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;

        let formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);

        fetch('{{ route('admin_login_api') }}',{

            method: "POST",
            body: formData

        })
            .then(response => {
                if(response.status == 301){
                    window.location = '{{route('admin_panel_logout')}}';
                    throw new Error('Logging out...');
                }
                return response.json();

            })
            .then(data => {
                if(data.result != '1'){
                    Swal.fire({
                        icon: 'error',
                        title: data.msg,
                    })
                    Swal.hideLoading();
                    return;
                }

                window.location = '{{route('admin_panel_dashboard')}}';


            })
            .catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: error,
                })
                Swal.hideLoading();
            });
    }


</script>


</body>

</html>
