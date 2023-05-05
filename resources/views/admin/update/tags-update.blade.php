@extends('admin.layouts.app')



@section('content')


    <div class="card-header p-0">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="detail-tab" data-toggle="pill"
                   href="#detail" role="tab" aria-controls="detail"
                   aria-selected="true">Tag Detay Güncelleme</a>
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
                                        <label>Kategori ID</label>
                                        <input id="tag_id" type="text" class="form-control" name="tag_id" value="{{ $data['tag_id'] }}" hidden>
                                        <input id="tag_id" type="text" class="form-control" name="tag_id" value="{{ $data['tag_id'] }}" disabled="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Kategori Adı</label>
                                        <input id="tag_name" type="text" class="form-control" name="tag_name" value="{{ $data['tag_name'] }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Sayfada Gösterilsin Mi?</label>
                                        <select id="is_active" class="form-control " name="is_active" style="width: 100%;">
                                            <option value="0" @if(!$data['is_active']) {{'selected="selected"'}} @endif>Hayir</option>
                                            <option value="1"  @if($data['is_active']) {{'selected="selected"'}}  @endif>Evet</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Sayfada Görünen Adı</label>
                                        <div class="input-group ">
                                            <div class="custom-file">
                                                <input id="display_name" type="text" class="form-control" name="display_name" value="{{ $data['display_name'] }}">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="input-group ">
                                    <img src="{{ $data['tag_image'] }}" width="30%" height="auto" class="img-fluid mb-2" id ="new_img">
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group ">
                                        <label>Resim (Kare)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="tag_image"
                                                   id="tag_image" onchange="loadFile(event)" required>
                                            <label class="custom-file-label" for="exampleInputFile" id="image_label">Choose File</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-0">
                                <div  class="btn btn-block btn-info btn-lg atlantis-button" name=""
                                      onclick="updateTags();">Ekle
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
        function updateTags(){

            Swal.fire({
                title: 'Lütfen bekleyiniz...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
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

            let tag_image = document.getElementById("tag_image").files[0];
            if (tag_image == null) {
                Swal.fire({
                    icon: 'info',
                    title: 'ZORUNLU ALAN',
                    text: 'Lütfen bir resim yükleyiniz.',
                    confirmButtonText: 'Tamam'
                })
                return;
            }
            let tag_id = document.getElementById("tag_id").value;
            let formData2 = new FormData();

            formData2.append("tag_name", tag_name);
            formData2.append("is_active", is_active);
            formData2.append("display_name", display_name);
            formData2.append("tag_image", tag_image);
            formData2.append("tag_id", parseInt(tag_id));


            Swal.showLoading();
            fetch('/api/update-tag', {method: "POST", body: formData2})
                .then(response => response.json())
                .then(data => {
                    if (data.result == '1') {
                        setTimeout(() => {
                            Swal.fire({
                                icon: 'success',
                                title: data.msg,
                                showConfirmButton: true,
                                allowOutsideClick:false,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.replace('/admin/tag_details');
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
