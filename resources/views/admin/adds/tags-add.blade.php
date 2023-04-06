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
                                        <label>Kategori Adı</label>
                                        <input id="tag_name" type="text" class="form-control" name="tag_name" value="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Sayfada Gösterilsin Mi?</label>
                                        <select id="is_active" class="form-control " name="is_active" style="width: 100%;">
                                            <option value="1"  >Evet</option>
                                            <option value="0">Hayir</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Sayfada Görünen Adı</label>
                                        <div class="input-group ">
                                            <div class="custom-file">
                                                <input id="display_name" type="text" class="form-control" name="display_name" value="">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Görünüm Sırası</label>
                                        <input id="display_order" type="number" class="form-control" name="display_order" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-0">
                                <div  class="btn btn-block btn-info btn-lg atlantis-button" name=""
                                      onclick="AddTag();">Ekle
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
        function AddTag(){
            let tag_name = document.getElementById("tag_name").value;
            if (tag_name == "" || tag_name == " " || tag_name == undefined) {
                Swal.fire({
                    icon: 'info',
                    title: 'Ups...',
                    text: 'Kategori adı giriniz.',
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


            let formData2 = new FormData();

            formData2.append("tag_name", tag_name);
            formData2.append("is_active", is_active);
            formData2.append("display_name", display_name);
            formData2.append("display_order", display_order);


            Swal.showLoading();
            fetch('/api/add-tag', {method: "POST", body: formData2})
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
                                    window.location.replace('/admin/tags');
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
