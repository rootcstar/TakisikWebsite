<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
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

</head>

<body class="hold-transition sidebar-mini text-sm layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand  navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-4">

        <img src="{{asset('assets/img/logos/logo-b.png')}}" class="brand-image ml-0 mr-0 elevation-3 w-100">
        <div class="user-panel pt-3 pb-3 pb-0 d-flex">
            <div class="info">
                    <span  class="d-block user-name">{{ Session::get('admin.username') }}
                         <a class="right badge badge-danger logout-button" href="{{ url('admin/logout') }}"><span class="">{{ LanguageChange('Logout') }}</span></a>

</span>

            </div>
        </div>
        <!-- Sidebar -->
        <div class="sidebar pr-0 pl-0">
            <!-- Sidebar user panel (optional) -->


            <!-- Sidebar Menu -->
            <nav class="mt-0">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item has-treeview menu-open">
                        <ul class="nav nav-treeview">
                            @include('admin.layouts.sidebar')
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>



    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">

            @yield('content')

            <div class="modal fade" id="modal-warning">
                <div class="modal-dialog">
                    <div class="modal-content bg-warning">
                        <div class="modal-header">
                            <h4 class="modal-title">Warning Modal</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <p>One fine body&hellip;</p>
                        </div>
                        <div class="modal-footer ">
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-outline-dark">Save changes</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <div class="modal fade" id="modal-danger">
                <div class="modal-dialog">
                    <div class="modal-content bg-danger">
                        <div class="modal-header">
                            <h4 class="modal-title" id="danger-title">Are you sure?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p id="danger-text">This action may not be reversable from admin panel.</p>
                        </div>
                        <div class="modal-footer ">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-outline-light" id="danger-yes-button" onclick="">Yes
                            </button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
            </div>
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline"></div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2022 <a href="http://fikitech.com/" class="fikitech-blue">Fiki Tech Solutions</a>.</strong> All rights reserved.
    </footer>


    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Bu kaydı silmek istediğinize emin misiniz?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-outline-light" id="delete-record-btn">Sil</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

</div>

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->


<script src="{{asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin-assets/dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('admin-assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('admin-assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin-assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin-assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin-assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<script src="{{asset('admin-assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin-assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin-assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin-assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('admin-assets/plugins/moment/moment.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('admin-assets/plugins/daterangepicker/daterangepicker.css')}}">
<script src="{{asset('admin-assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('admin-assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('admin-assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script src="{{asset('admin-assets/plugins/ekko-lightbox/ekko-lightbox.min.js')}}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{asset('admin-assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>

<script src="{{asset('admin-assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="{{ asset('admin-assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('admin-assets/plugins/select2/js/select2.full.min.js') }}"></script>

@yield('external_js')
<script>
    //Initialize Select2 Elements
    $('.select2').select2()
</script>
<script>
    function DeleteRecordModal(table_name,primary_key_id){

        $('#delete-record-btn').attr("onclick", "DeleteRecord('" + table_name + "','" +primary_key_id+ "')");
    }

    function DeleteRecord(table_name,primary_key_id){

        var data = '{"table_name":"' +table_name+ '","primary_key_id":"' + primary_key_id + '"}';
console.log(data);

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                let resp = JSON.parse(this.responseText);
                if (resp['result'] == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: (resp['msg']),
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        timer: 1000
                    })

                    location.reload();



                }else{

                    Swal.fire({
                        icon: 'error',
                        title: (resp['msg']),
                        showConfirmButton: true,
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }

            } else if (this.status >= 400) {
                let resp = JSON.parse(this.responseText);
                Swal.fire({
                    icon: 'warning',
                    title: (resp['msg']),
                    showConfirmButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            } else if (this.status >= 500) {
                //Başarısız
                alert('error');
            }
        };
        xhttp.onerror = function onError(e) {

            let resp = JSON.parse(this.responseText);
            // $('#loader').addClass("hidden");

            Swal.fire(resp['msg']);
            // location.reload();
        };

        xhttp.open("POST", "/api/delete-record", true);
        xhttp.setRequestHeader("Content-Type", "application/json");
        xhttp.send(data);
    }
</script>
<script>
    var loadFile = function (event) {

        var output = document.getElementById('new_img');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function () {
            URL.revokeObjectURL(output.src)
        }

    };
</script>

<script>
    $(function () {
        bsCustomFileInput.init();
    });
</script>

<script>
    $(function () {
        // Summernote
        $('.custom-text-editor').summernote()

    })

</script>

</body>
</html>
