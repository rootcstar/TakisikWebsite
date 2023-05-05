@extends('admin.layouts.app')



@section('content')



    <div class="container-fluid">
        <div class="card-header p-0">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active text-dark" id="tag-tab" data-toggle="pill"
                       href="#tagtab" role="tab" aria-controls="tag"
                       aria-selected="true">Kategori Güncelle</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" id="tag-image-tab" data-toggle="pill"
                       href="#tagimagetab" role="tab" aria-controls="tagimage"
                       aria-selected="true">Kategori Resim Güncelle</a>
                </li>
            </ul>
        </div>

        <div class="card card-default">

            <div class="card-body">
                <div class="tab-content" id="custom-tabs-above-tabContent">
                    <div class="tab-pane fade show active" id="tagtab" role="tabpanel" aria-labelledby="tag-tab">

                        <h3 class="card-title">Kategori Güncelle</h3>
                        <h6 class="card-subtitle">Buradan kategori güncelleme işlemi yapabilirsiniz</h6>

                        <form class="row g-3 needs-validation" id="form" novalidate>
                            <input class="hide input-fields" value="{{$data['tag_id']}}" id="tag_id" readonly>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label >Kategori Adı</label>
                                    <input id="tag_name" type="text" class="form-control input-fields" pattern="[a-zA-ZğüşöçĞÜŞÖÇİ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ ]{1,30}"
                                           value="{{$data['tag_name']}}" required>
                                    <div class="invalid-feedback"> Zorunlu alan. Min 3 harf</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Sayfada Gösterilsin Mi?</label>
                                    <select id="is_active" class="form-control" name="is_active" style="width: 100%;">
                                        <option  value="{{$data['is_active']}}" selected="">@php echo ($data['is_active'] == 1) ?  'Evet' :  'Hayır' @endphp</option>
                                        <option  value="@php echo ($data['is_active'] == 1) ? 0 : 1 @endphp">@php echo ($data['is_active'] == 1) ? 'Hayır' : 'Evet' @endphp</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label >Sayfada Görünen Adı</label>
                                    <input id="display_name" type="text" class="form-control input-fields" pattern="[a-zA-ZğüşöçĞÜŞÖÇİ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ ]{1,30}"
                                           value="{{$data['display_name']}}" required>
                                    <div class="invalid-feedback"> Zorunlu alan. Min 3 harf</div>
                                </div>
                            </div>
                            <div class="col-sm-6" style="text-align: -webkit-right;">
                                <div class="btn btn-primary" id="form_submit">{{$update_button_name}}</div>
                            </div>
                        </form>

                    </div>

                    <div class="tab-pane fade show " id="tagimagetab" role="tabpanel" aria-labelledby="tag-image-tab">

                        <h3 class="card-title">Kategori Resim Güncelle</h3>
                        <h6 class="card-subtitle">Buradan kategori resimi güncelleme işlemi yapabilirsiniz</h6>

                        <form class="row g-3 needs-validation" id="image-form" novalidate>
                            <input class="hide image-fields" value="{{$data['tag_id']}}" id="tag_id" readonly>
                           <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Resim (Kare)</label>
                                    <div class="custom-file">
                                        <input type="file" class="form-control custom-file-input image-fields"  id="tag_image" onchange="loadFile(event)" >

                                        <label class="custom-file-label" for="exampleInputFile" id="image_label">Dosya Seç</label>
                                    </div>
                                    <div class="invalid-feedback"> Zorunlu alan. Lütfen bir dosya seçiniz</div>
                                </div>
                            </div>
                            <div class="col-sm-6 text-left" style="padding-top: 1.7rem; padding-bottom: 1.7rem;">
                                <div class="btn btn-primary" id="image_form_submit">{{$update_button_name}}</div>
                            </div>
                            <div class="col-sm-6 ">
                                <img src="{{$data['tag_image']}}" width="50%" height="auto" class="img-fluid mb-2" id ="new_img">
                            </div>
                        </form>

                    </div>
                </div>
            </div>


        </div>
    </div>




@endsection


@section('scripts')

    <script>
        $('#form_submit').on('click', function () {
            is_valid = validate_form('form');
            if (!is_valid) {
                return;
            }


            show_loader();
            let formData = new FormData();

            $('.input-fields').each(function(){

                formData.append(''+$(this).attr('id')+'', $(this).val());


            });
            formData.append('tag_image', document.getElementById("tag_image").files[0]);
            formData.append('is_active', $('#is_active').find(':selected').val());

            fetch('{{ route('update_tag_api') }}', {

                method: "POST",
                body: formData

            })
                .then(response => {
                    if (response.status == 301) {
                        window.location = '{{route('admin_panel_logout')}}';
                        throw new Error('Logging out...');
                    }
                    return response.json();

                })
                .then(data => {

                    if (data.result != '1') {
                        Swal.fire({
                            icon: 'error',
                            title: data.msg,
                            confirmButtonColor: '#367ab2',
                        })
                        return;
                    }


                    Swal.fire({
                        icon: 'success',
                        title: data.msg,
                        confirmButtonColor: '#367ab2',
                    }).then((result) => {
                        if (result.isDismissed || result.isConfirmed) {
                            window.location.reload();
                        }

                    })

                })
                .catch((error) => {

                    Swal.fire({
                        icon: 'error',
                        title: error,
                    })

                });


        });

        $('#image_form_submit').on('click', function () {
            is_valid = validate_form('image-form');
            if (!is_valid) {
                return;
            }


            show_loader();
            let formData = new FormData();

            $('.image-fields').each(function(){

                formData.append(''+$(this).attr('id')+'', $(this).val());


            });
            formData.append('tag_image', document.getElementById("tag_image").files[0]);

            fetch('{{ route('update_tag_image_api') }}', {

                method: "POST",
                body: formData

            })
                .then(response => {
                    if (response.status == 301) {
                        window.location = '{{route('admin_panel_logout')}}';
                        throw new Error('Logging out...');
                    }
                    return response.json();

                })
                .then(data => {

                    if (data.result != '1') {
                        Swal.fire({
                            icon: 'error',
                            title: data.msg,
                            confirmButtonColor: '#367ab2',
                        })
                        return;
                    }


                    Swal.fire({
                        icon: 'success',
                        title: data.msg,
                        confirmButtonColor: '#367ab2',
                    }).then((result) => {
                        if (result.isDismissed || result.isConfirmed) {
                            window.location.reload();
                        }

                    })

                })
                .catch((error) => {

                    Swal.fire({
                        icon: 'error',
                        title: error,
                    })

                });


        });
    </script>

@endsection
