@extends('admin.layouts.app')



@section('content')


    <div class="card-header p-0">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="detail-tab" data-toggle="pill"
                   href="#detail" role="tab" aria-controls="detail"
                   aria-selected="true">Müşteri Bilgisi Güncelleme</a>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="billing-address-tab" data-toggle="pill"
                   href="#billingaddresstab" role="tab" aria-controls="tags"
                   aria-selected="true">Müşteri Fatura Adresi Bilgisi</a>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="shipping-address-tab" data-toggle="pill"
                   href="#shippingaddresstab" role="tab" aria-controls="tags"
                   aria-selected="true">Müşteri Kargo Adresi Bilgisi</a>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="card-tab" data-toggle="pill"
                   href="#cardtab" role="tab" aria-controls="tags"
                   aria-selected="true">Müşteri Ödeme(Kart) Bilgisi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="discount-tab" data-toggle="pill"
                   href="#discounttab" role="tab" aria-controls="tags"
                   aria-selected="true">Müşteri İndirim Bilgisi</a>
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
                                        <label>Müşteri ID</label>
                                        <input id="user_id" type="text" class="form-control" name="sub_tag_id" value="{{ $data['user_id'] }}" disabled>
                                        <input id="user_id" type="text" class="form-control" name="sub_tag_id" value="{{ $data['user_id'] }}" hidden>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Üyelik Türü</label>
                                        <input id="account_type" type="text" class="form-control" name="account_type" value="{{ $data['account_type'] }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Adı</label>
                                        <input id="first_name" type="text" class="form-control" name="first_name" value="{{ $data['first_name'] }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Adı</label>
                                        <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $data['last_name'] }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input id="email" type="text" class="form-control" name="email" value="{{ $data['email'] }}">
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Telefon</label>
                                        <input id="phone" type="text" class="form-control" name="phone" value="{{ $data['phone'] }}">
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-2 p-0">
                                <div  class="btn btn-block btn-info btn-lg atlantis-button" name=""
                                      onclick="UpdateUser();">Güncelle
                                </div>
                            </div>
                        </form>
                    </div>


                    <div class="tab-pane fade show " id="billingaddresstab" role="tabpanel"
                         aria-labelledby="tags-tab">

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <div class="col-sm-6">


                                </div>

                                <div class="col-md-2 p-0">
                                    <div  class="btn btn-block btn-info btn-lg atlantis-button" name=""
                                          onclick="UpdateTagsOfSubtag();">Ekle
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade show " id="shippingaddresstab" role="tabpanel"
                         aria-labelledby="tags-tab">

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">


                                <div class="col-md-2 p-0">
                                    <div  class="btn btn-block btn-info btn-lg atlantis-button" name=""
                                          onclick="UpdateTagsOfSubtag();">Ekle
                                    </div>
                                </div>
                        </form>
                    </div>
                    <div class="tab-pane fade show " id="cardtab" role="tabpanel"
                         aria-labelledby="tags-tab">

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">



                                <div class="col-md-2 p-0">
                                    <div  class="btn btn-block btn-info btn-lg atlantis-button" name=""
                                          onclick="UpdateTagsOfSubtag();">Ekle
                                    </div>
                                </div>
                        </form>
                    </div>
                    <div class="tab-pane fade show " id="discounttab" role="tabpanel"
                         aria-labelledby="tags-tab">

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">


                                <div class="col-md-2 p-0">
                                    <div  class="btn btn-block btn-info btn-lg atlantis-button" name=""
                                          onclick="UpdateTagsOfSubtag();">Ekle
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
        function UpdateSubtag(){
            let sub_tag_name = document.getElementById("sub_tag_name").value;
            if (sub_tag_name == "" || sub_tag_name == " " || sub_tag_name == undefined) {
                Swal.fire({
                    icon: 'info',
                    title: 'Ups...',
                    text: 'Alt Kategori adı giriniz.',
                })
                return;
            }
            let is_active = document.getElementById("is_active").value;

            let display_name = document.getElementById("display_name").value;
            if (display_name == "" || display_name == " " || display_name == undefined) {
                Swal.fire({
                    icon: 'info',
                    title: 'Ups...',
                    text: 'Sayfada görünen adı giriniz.',
                })
                return;
            }
            let display_order = document.getElementById("display_order").value;

            let sub_tag_id = document.getElementById("sub_tag_id").value;


            let formData2 = new FormData();

            formData2.append("sub_tag_id", parseInt(sub_tag_id));
            formData2.append("sub_tag_name", sub_tag_name);
            formData2.append("is_active", is_active);
            formData2.append("display_name", display_name);
            formData2.append("display_order", display_order);


            Swal.showLoading();
            fetch('/api/update-sub-tag', {method: "POST", body: formData2})
                .then(response => response.json())
                .then(data => {
                    if (data.result == '1') {
                        setTimeout(() => {
                            Swal.fire({
                                icon: 'success',
                                title: data.msg,
                                showConfirmButton: true,
                                outsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.replace('/admin/sub_tags');
                                }
                            });
                        }, 500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ups!',
                            text: data.msg,
                            outsideClick: false
                        })
                        Swal.showLoading.hide();
                    }
                })
                .catch(error => {
                    console.log('Error', error);
                });

        }

        function UpdateTagsOfSubtag(){

            let tags = $("#tags").val();
            if (tags == "") {
                Swal.fire({
                    icon: 'info',
                    title: 'Ups...',
                    text: 'Lütfen en az bir kategori seçin.',
                })
                return;
            }

            console.log(JSON.stringify(tags));
            let sub_tag_id = document.getElementById("sub_tag_id").value;
            let formData2 = new FormData();

            formData2.append("tags", JSON.stringify(tags));
            formData2.append("sub_tag_id", parseInt(sub_tag_id));


            Swal.showLoading();
            fetch('/api/update-tags-of-sub-tag', {method: "POST", body: formData2})
                .then(response => response.json())
                .then(data => {
                    if (data.result == '1') {
                        setTimeout(() => {
                            Swal.fire({
                                icon: 'success',
                                title: data.msg,
                                showConfirmButton: true,
                                outsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.replace('/admin/sub_tags');
                                }
                            });
                        }, 500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ups!',
                            text: data.msg,
                            outsideClick: false
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
