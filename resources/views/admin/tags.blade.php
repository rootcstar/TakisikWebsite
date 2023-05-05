
@extends('admin.layouts.app')


@section('content')

    <div class="container-fluid">

        <div class="card-header p-0">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link text-dark active" id="tags-tab" data-toggle="pill"
                       href="#tagstab" role="tab" aria-controls="tags"
                       aria-selected="true">Kategoriler</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" id="subtags-tab" data-toggle="pill"
                       href="#subtagstab" role="tab" aria-controls="subtags"
                       aria-selected="true">Alt Kategoriler</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-12">
                <!--DEAL 1 -->
                <div class="card card-default">

                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-above-tabContent">
                            <div class="tab-pane fade show active" id="tagstab" role="tabpanel" aria-labelledby="tags-tab">

                                <h3 class="card-title"> {{$title}}</h3>
                                <h6 class="card-subtitle">Buradan yönetici silme ve ekleme işlemi yapabilirsiniz</h6>

                                <form class="row g-3 needs-validation" id="form" novalidate>
                                    <div class="col-md-6 form-group">
                                        <div class="form-floating">
                                            <label >Kategori Adı</label>
                                            <input id="tag_name" type="text" class="form-control input-fields" pattern="[a-zA-ZğüşöçĞÜŞÖÇİ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ ]{1,30}"
                                                   placeholder="Lütfen doldurunuz" required>
                                            <div class="invalid-feedback"> Zorunlu alan. Min 3 harf</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Sayfada Gösterilsin Mi?</label>
                                            <select id="is_active" class="form-control" name="is_active" style="width: 100%;">
                                                <option value="0" selected>Hayir</option>
                                                <option value="1" >Evet</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <div class="form-floating">
                                            <label >Sayfada Görünen Adı</label>
                                            <input id="display_name" type="text" class="form-control input-fields" pattern="[a-zA-ZğüşöçĞÜŞÖÇİ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ ]{1,30}"
                                                   placeholder="Lütfen doldurunuz" required>
                                            <div class="invalid-feedback"> Zorunlu alan. Min 3 harf</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Resim (Kare)</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input input-fields" id="tag_image" onchange="loadFile(event)" required>

                                                <label class="custom-file-label" for="exampleInputFile" id="image_label">Dosya Seç</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">

                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <img  width="50%" height="auto" class="img-fluid mb-2" id ="new_img">
                                    </div>
                                    <div class="col-sm-6">

                                    </div>
                                    <div class="col-sm-6" style="text-align: -webkit-right;">
                                        <div class="btn btn-primary" id="new_tag_form_submit">{{$new_button_name}}</div>
                                    </div>
                                </form>
                                <table id="{{$table_id}}" class="table table-striped table-bordered w-100">
                                    <thead>
                                    <tr>
                                        <th>Güncelle</th>
                                        @foreach($keys as $key)
                                            <th>{{ LanguageChange(ucwords(str_replace("_"," ",$key))) }}</th>
                                        @endforeach
                                        <th>Sil</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th>Güncelle</th>
                                        @foreach($keys as $key)
                                            <th>{{ LanguageChange(ucwords(str_replace("_"," ",$key))) }}</th>
                                        @endforeach
                                        <th>Sil</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="tab-pane fade show " id="subtagstab" role="tabpanel" aria-labelledby="subtags-tab">
                                <form class="row g-3 needs-validation" id="subtag-form" novalidate>
                                    <div class="col-md-6 form-group">
                                        <div class="form-floating">
                                            <label >Alt Kategori Adı</label>
                                            <input id="sub_tag_name" type="text" class="form-control input-fields" pattern="[a-zA-ZğüşöçĞÜŞÖÇİ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ ]{1,30}"
                                                   placeholder="Lütfen doldurunuz" required>
                                            <div class="invalid-feedback"> Zorunlu alan. Min 3 harf</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            @php
                                                $tags_data = DB::table('tags')->get();
                                            @endphp
                                            <label>Ürün hangi kategoriye ait?</label>
                                            <select class="select2 form-control" multiple="multiple" id="tags-multiple" data-placeholder="En az 1 tag seçiniz" style="height: 36px;width: 100%;">
                                                @foreach ($tags_data as $tag)

                                                    <option value="{{$tag->tag_id}}" >{{$tag->tag_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">

                                    </div>
                                    <div class="col-sm-6" style="text-align: -webkit-right;">
                                        <div class="btn btn-primary" id="new_subtag_form_submit">{{$new_button_name}}</div>
                                    </div>
                                </form>

                                <table id="{{$second_table_id}}" class="table table-striped table-bordered w-100">
                                    <thead>
                                    <tr>
                                        <th>Güncelle</th>
                                        @foreach($second_keys as $second_key)
                                            <th>{{ LanguageChange(ucwords(str_replace("_"," ",$second_key))) }}</th>
                                        @endforeach
                                        <th>Sil</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th>Güncelle</th>
                                        @foreach($second_keys as $second_key)
                                            <th>{{ LanguageChange(ucwords(str_replace("_"," ",$second_key))) }}</th>
                                        @endforeach
                                        <th>Sil</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


        </div>

    </div>



@endsection
@section('scripts')


    <script>


        $('#new_tag_form_submit').on('click', function () {
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

            fetch('{{ route('new_tag_api') }}', {

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

        $(document).ready(function () {

            var table_name = "tags"
            var where = ""
            var post_or_get = "GET"
            var primary_key = 'tag_id'

            var query_string = "table="+table_name+"&&"+
                "where="+where+"&&"+
                "post_or_get="+post_or_get+"&&"+
                "primary_key="+primary_key;

            $('#{{$table_id}}').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "serverSide": true,
                "processing": true,
                "responsive": true,
                "paging": true,

                "dom": '<"top"B<"clear">>rt<"bottom"iflp<"clear">>',
                "buttons": [
                    //'csvHtml5'
                    {
                        "extend": 'csvHtml5',
                        "exportOptions": {

                            "modifer": {
                                "page": "all",
                                "search": "none"
                            }
                        }
                    },

                ], "searching": true,
                'fnCreatedRow': function (nRow, aData, iDataIndex) {

                    $(nRow).attr('id', '{{$table_id}}_' + aData.tag_id); // or whatever you choose to set as the id
                },
                "ajax": "{{route('fill_datatable_api')}}?" +query_string+ "",
                "columnDefs": [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                "columns": [

                    {
                        "data":null,
                        "className": 'text-center ',
                        mRender: function (data, type, row) {
                            return '<a  target="_blank" href="/admin/tags/update/'+row.tag_id+'">' +
                                '<button type="button" class="btn btn-warning" >Güncelle</button>'
                            '</a>'
                        }
                    },
                    {"data": "tag_id"},
                    {"data": "tag_name"},
                    {"data": "tag_image",
                     "className": 'text-center',
                        mRender: function (data, type, row) {
                            return '<img src="'+row.tag_image+'" style="width:50%; height:auto">'
                        }},
                    {"data": "is_active"},
                    {
                        "data":null,
                        "className": 'text-center ',
                        mRender: function (data, type, row) {
                            return '<button type="button" class="btn btn-danger" ><i class="fas fa-trash"></i></button>'
                        }
                    },


                ]
            });
        });

        $(document).ready( function () {

            var table_name = "sub_tags"
            var where = ""
            var post_or_get = "GET"
            var primary_key = 'sub_tag_id'

            var query_string = "table="+table_name+"&&"+
                "where="+where+"&&"+
                "post_or_get="+post_or_get+"&&"+
                "primary_key="+primary_key;

            $('#{{$second_table_id}}').DataTable({
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "serverSide": true,
                "processing": true,
                "responsive": true,
                "paging": true,

                "dom": '<"top"B<"clear">>rt<"bottom"iflp<"clear">>',
                "buttons": [
                    //'csvHtml5'
                    {
                        "extend": 'csvHtml5',
                        "exportOptions": {

                            "modifer": {
                                "page": "all",
                                "search": "none"
                            }
                        }
                    },

                ], "searching": true,
                'fnCreatedRow': function (nRow, aData, iDataIndex) {

                    $(nRow).attr('id', '{{$second_table_id}}_' + aData.sub_tag_id); // or whatever you choose to set as the id
                },
                "ajax": "{{route('fill_datatable_api')}}?" +query_string+ "",
                "columnDefs": [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                "columns": [

                    {
                        "data":null,
                        "className": 'text-center ',
                        mRender: function (data, type, row) {
                            return '<a  target="_blank" href="/admin/subtags/update/'+row.sub_tag_id+'">' +
                                '<button type="button" class="btn btn-warning" >Güncelle</button>'
                            '</a>'
                        }
                    },
                    {"data": "sub_tag_id"},
                    {"data": "sub_tag_name"},
                    {"data": "is_active"},
                    {
                        "data":null,
                        "className": 'text-center ',
                        mRender: function (data, type, row) {
                            return '<button type="button" class="btn btn-danger" ><i class="fas fa-trash"></i></button>'
                        }
                    },


                ]
            });
        });
    </script>


@endsection
