@extends('admin.layouts.app')
@php
    $not_to_show = array(
                             'tags'=>array('created_date','last_updated','url_name','display_order','display_name'),
                             'sub_tags'=>array('created_date','last_updated','url_name','display_order','display_name'),
    );

@endphp
@section('content')

    <div class="card-header p-0">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tags-tab" data-toggle="pill"
                   href="#tagstab" role="tab" aria-controls="tags" onclick="ShowTable('{{encrypt('tags')}}')"
                   aria-selected="true">Kategoriler</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="subtags-tab" data-toggle="pill"
                   href="#subtags" role="tab" aria-controls="subtags" onclick="ShowTable('{{encrypt('sub_tags')}}')"
                   aria-selected="true">Alt Kategoriler</a>
            </li>
        </ul>
    </div>

    <div class="card card-default">
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-above-tabContent">
                <div class="tab-pane fade show active" id="tagstab" role="tabpanel" aria-labelledby="tags-tab">
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
                                    <label>Resim (Kare)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="tag_image"
                                                                          id="tag_image" onchange="loadFile(event)" required>

                                            <label class="custom-file-label" for="exampleInputFile" id="image_label">Choose File</label>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-sm-6">
                                <div class="input-group ">
                                    <img src="" width="30%" height="auto" class="img-fluid mb-2" id ="new_img">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 p-0">
                            <div  class="btn btn-block btn-info btn-lg atlantis-button" name="" onclick="AddTag();">
                                Yeni Tag Ekle
                            </div>
                        </div>
                    </form>

                    <div class="card-body" id="table-content-tags">


                        <table id="{{ $tags_table_data['table_id'] }}" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                @foreach($tags_table_data['table_fields'] as $field)
                                    @if(isset($not_to_show[$tags_table_data['table_name']]) && in_array($field,$not_to_show[$tags_table_data['table_name']]))
                                        @continue;

                                    @endif
                                    <th>{{ LanguageChange(FixName($field)) }}</th>
                                @endforeach
                                <th>Sil</th>
                            </tr>
                            </thead>


                            <tfoot>

                            </tfoot>
                        </table>


                        <script>

                            $(document).ready(function () {
                                $('#<?php echo $tags_table_data['table_id']; ?>').DataTable({
                                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], "serverSide": true,
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
                                        $(nRow).attr('id', '<?php echo $tags_table_data['table_id']; ?>-' + aData.<?php echo $tags_table_data['table_fields'][0]; ?>); // or whatever you choose to set as the id
                                    },
                                    "ajax": "/api/fill-datatable?datatable_name=<?php echo $tags_table_data['table_id']; ?>&&primary_key=<?php echo $tags_table_data['table_fields'][0]; ?>&&cols=<?php echo encrypt(json_encode($tags_table_data['table_fields']));?>",
                                    "columnDefs": [{
                                        "defaultContent": "-",
                                        "targets": "_all"
                                    }],

                                    "columns": [
                                        {
                                            "className": 'text-center',
                                            mRender: function (data, type, row) {
                                                return '<span class="right badge badge-warning update-button action-button action-details"><a href="/admin/<?php echo $tags_table_data['table_id']; ?>/detay/' + row.<?php echo $tags_table_data['table_fields'][0]; ?> + '" class="white" target="_blank"><?php echo LanguageChange('Düzenle'); ?></span></a> '
                                            }
                                        },

                                            <?php

                                            foreach($tags_table_data['table_fields'] as $field){
                                                if(isset($not_to_show[$tags_table_data['table_name']]) && in_array($field,$not_to_show[$tags_table_data['table_name']])){
                                                    continue;
                                                }


                                                if(str_contains($field,'foto') || str_contains($field,'resim') || str_contains($field,'resmi') | str_contains($field,'image') ){
                                                    echo '{
                                    mRender: function (data, type, row) {
                                        return "<img src="+row.'.$field.'+" style=\"width:10%; height:auto\">";
                                    }
                                },';
                                                } else if(str_contains($field,'active')){
                                                    echo '{
                                    mRender: function (data, type, row) {
                                        if(row.'.$field.'){
                                         return "Evet";

                                        } else {

                                         return "Hayir";
                                        }
                                    }
                                },';
                                                } else {
                                                    echo '{"data": "'.$field.'"},';
                                                }


                                            }
                                            ?>
                                        {
                                            "className": ' text-center badge-danger',
                                            mRender: function (data, type, row) {
                                                return '<i class="fas fa-trash action-delete" onclick="DeleteRecordModal(\'<?php echo $tags_table_data['table_name']; ?>\',\''+row.<?php echo $tags_table_data['table_fields'][0]; ?>+'\')" data-toggle="modal" data-target="#modal-delete" type="button"></i> ';
                                            }
                                        },

                                    ]
                                });
                            });
                        </script>

                    </div>
                </div>

                <div class="tab-pane fade show " id="subtags" role="tabpanel" aria-labelledby="subtags-tab">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Alt Kategori Adı</label>
                                    <input id="sub_tag_name" type="text" class="form-control" name="sub_tag_name" value="">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">

                                    <div class="" id="select-tags">
                                        <div class="form-group">

                                            @php
                                                $tags_data = DB::table('tags')->get();
                                            @endphp
                                            <label>Ürün hangi kategoriye ait?</label>
                                            <select class="select2" multiple="multiple" id="tags-multiple" data-placeholder="En az 1 tag seçiniz" style="width: 100%;">
                                                @foreach ($tags_data as $tag)

                                                    <option value="{{$tag->tag_id}}" >{{$tag->tag_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Sayfada Gösterilsin Mi?</label>
                                    <select id="is_active_sub" class="form-control " name="is_active_sub" style="width: 100%;">
                                        <option value="1">Evet</option>
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

                        </div>
                        <div class="col-md-2 p-0">
                            <div  class="btn btn-block btn-info btn-lg atlantis-button" name=""
                                  onclick="AddSubtag();">Yeni Alt Kategori Ekle
                            </div>
                        </div>
                    </form>

                    <div class="card-body" id="table-content-sub_tags">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('external_js')
    <script>
        function ShowTable(enc_id){
            var data = '{"table_id":"' +enc_id+'"}';

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    let resp = JSON.parse(this.responseText);

                    if (resp['result'] == 1) {

                        $('#table-content-'+resp['table_name']).html('');
                        $('#table-content-'+resp['table_name']).append(resp['table_content']);

                    }else{

                        Swal.fire({
                            icon: 'error',
                            title: (resp['msg']),
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }

                    //     $('#loader').addClass("hidden");


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

            xhttp.open("POST", "/api/show-table", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.send(data);

        }

        function AddSubtag(){
            let sub_tag_name = document.getElementById("sub_tag_name").value;
            if (sub_tag_name == "" || sub_tag_name == " " || sub_tag_name == undefined) {
                Swal.fire({
                    icon: 'info',
                    title: 'ZORUNLU ALAN',
                    text: 'Alt Kategori adı giriniz.',
                    confirmButtonText: 'Tamam'
                })
                return;
            }
            let tags = $("#tags-multiple").val();     console.log(tags);
            if (tags == "") {
                Swal.fire({
                    icon: 'info',
                    title: 'ZORUNLU ALAN',
                    text: 'Lütfen en az bir kategori seçin.',
                    confirmButtonText: 'Tamam'
                })
                return;
            }

            let is_active = document.getElementById("is_active_sub").value;

            let display_name = document.getElementById("display_name").value;
            if (display_name == "" || display_name == " " || display_name == undefined) {
                Swal.fire({
                    icon: 'info',
                    title: 'ZORUNLU ALAN',
                    text: 'Sayfada görünen adı giriniz.',
                    confirmButtonText: 'Tamam',
                })
                return;
            }


            let formData = new FormData();

            formData.append("sub_tag_name", sub_tag_name);
            formData.append("is_active", is_active);
            formData.append("display_name", display_name);
            formData.append("tags", JSON.stringify(tags));


            Swal.showLoading();
            fetch('/api/add-sub-tag', {method: "POST", body: formData})
                .then(response => response.json())
                .then(data => {
                    if (data.result == '1') {

                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            timer: 1000
                        })

                        $( "#table-content-sub_tags" ).html('');
                        $( "#table-content-sub_tags" ).append(data.content);
                        document.getElementById('sub_tag_name').value = '';
                        $("#tags-multiple").val('');
                        $(".select2-selection__rendered").empty();
                        document.getElementById('display_name').value = '';
                        document.getElementById('is_active_sub').value = '1';

                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'UYARI',
                            text: data.msg,
                            outsideClick: false
                        })
                    }
                })
                .catch(error => {
                    console.log('Error', error);
                });

        }

        function AddTag(){
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
                    title: 'ZORUNLU ALAN',
                    text: 'Lütfen kategori adını giriniz.',
                    confirmButtonText: 'Tamam'
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

            let formData2 = new FormData();

            formData2.append("tag_name", tag_name);
            formData2.append("is_active", is_active);
            formData2.append("tag_image", tag_image);
            formData2.append("display_name", display_name);

            Swal.showLoading();
            fetch('/api/add-tag', {method: "POST", body: formData2})
                .then(response => response.json())
                .then(data => {
                    if (data.result == '1') {

                            Swal.fire({
                                icon: 'success',
                                title: data.msg,
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                timer: 1000
                            })
                                    $( "#table-content-tags" ).html('');
                                    $( "#table-content-tags" ).append(data.content);
                                    document.getElementById('tag_name').value = '';
                                    document.getElementById('tag_image').value = '';
                                    $("#image_label").empty();
                                    document.getElementById('image_label').value = '';
                                    document.getElementById('is_active').value = '1';


                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'UYARI',
                            text: data.msg
                        })
                    }
                })
                .catch(error => {
                    console.log('Error', error);
                });

        }

    </script>
@endsection
