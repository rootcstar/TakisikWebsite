@extends('admin.layouts.app')



@section('content')


    <div class="card-header p-0">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="detail-tab" data-toggle="pill"
                   href="#detail" role="tab" aria-controls="detail"
                   aria-selected="true">Yeni Kayıt Ekleme</a>
            </li>

        </ul>
    </div>




    <div class="container-fluid">
        <div class="card card-default">

            <div class="card-body">

                <div class="tab-content" id="custom-tabs-above-tabContent">

                    <div class="tab-pane fade show active" id="detail" role="tabpanel"
                         aria-labelledby="detail-tab">

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Adı</label>
                                        <input id="first_name" type="text" class="form-control" name="first_name" value="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Soyadı</label>
                                        <input id="last_name" type="text" class="form-control" name="last_name" value="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Telefon</label>
                                        <div class="input-group ">
                                            <div class="custom-file">
                                                <input id="phone" type="text" class="form-control" name="phone" value="">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group ">
                                            <div class="custom-file">
                                                <input id="email" type="text" class="form-control" name="email" value="">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Şifre</label>
                                        <input id="password" type="text" class="form-control" name="password" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-0">
                                <div  class="btn btn-block btn-info btn-lg atlantis-button" name=""
                                      onclick="AddAdminUser();">Ekle
                                </div>
                            </div>
                        </form>
                    </div>



                </div>
            </div>
        </div>
    </div>




@endsection


@section('external_js')

    <script>
        function AddAdminUser(){
            let first_name = document.getElementById("first_name").value;
            if (first_name == "" || first_name == " " || first_name == undefined) {
                Swal.fire({
                    icon: 'info',
                    title: 'Ups...',
                    text: 'Kullanıcı adı giriniz.',
                })
                return;
            }
            let last_name = document.getElementById("last_name").value;
            if (last_name == "" || last_name == " " || last_name == undefined) {
                Swal.fire({
                    icon: 'info',
                    title: 'Ups...',
                    text: 'Kullanıcı soyadı giriniz.',
                })
                return;
            }
            let phone = document.getElementById("phone").value;
            if (phone == "" || phone == " " || phone == undefined) {
                Swal.fire({
                    icon: 'info',
                    title: 'Ups...',
                    text: 'Kullanıcı telefon numarasi giriniz.',
                })
                return;
            }
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

            formData2.append("first_name", first_name);
            formData2.append("last_name", last_name);
            formData2.append("phone", phone);
            formData2.append("email", email);
            formData2.append("password", password);


            Swal.showLoading();
            fetch('/api/add-admin-user', {method: "POST", body: formData2})
                .then(response => response.json())
                .then(data => {
                    if (data.result == '1') {
                        setTimeout(() => {
                            Swal.fire({
                                icon: 'success',
                                title: data.msg,
                                showConfirmButton: true,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.replace('/admin/admin_users');
                                }
                            });
                        }, 500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ups!',
                            text: data.msg
                        })
                        Swal.showLoading.hide();
                    }
                })
                .catch(error => {
                    console.log('Error', error);
                });

        }

    </script>

@endsection
