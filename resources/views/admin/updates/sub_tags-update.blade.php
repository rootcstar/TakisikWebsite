@extends('admin.layouts.app')



@section('content')


    <div class="card-header p-0">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="detail-tab" data-toggle="pill"
                   href="#detail" role="tab" aria-controls="detail"
                   aria-selected="true">Yeni Kayıt Ekleme</a>
            </li>

            <li class="nav-item">
                <a class="nav-link " id="tags-tab" data-toggle="pill"
                   href="#tagstab" role="tab" aria-controls="tags"
                   aria-selected="true">Kategori Ekleme</a>
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
                                        <label>Alt Kategori ID</label>
                                        <input id="sub_tag_id" type="text" class="form-control" name="sub_tag_id" value="{{ $data['sub_tag_id'] }}" disabled>
                                        <input id="sub_tag_id" type="text" class="form-control" name="sub_tag_id" value="{{ $data['sub_tag_id'] }}" hidden>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Alt Kategori Adı</label>
                                        <input id="sub_tag_name" type="text" class="form-control" name="sub_tag_name" value="{{ $data['sub_tag_name'] }}">
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Sayfada Gösterilsin Mi?</label>
                                        <select id="is_active" class="form-control " name="is_active" style="width: 100%;">
                                            <option value="1"  @if(!$data['is_active']) {{'selected="selected"'}} @endif>Evet</option>
                                            <option value="0"  @if(!$data['is_active']) {{'selected="selected"'}} @endif>Hayir</option>
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

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Görünüm Sırası</label>
                                        <input id="display_order" type="number" class="form-control" name="display_order" value="{{ $data['display_order'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-0">
                                <div  class="btn btn-block btn-info btn-lg atlantis-button" name=""
                                      onclick="UpdateSubtag();">Ekle
                                </div>
                            </div>
                        </form>
                    </div>


                    <div class="tab-pane fade show " id="tagstab" role="tabpanel"
                         aria-labelledby="tags-tab">

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        @php
                                            $tags_data = DB::table('tags')->get();
                                            $tags_belong_to_subtag = DB::table('tag_to_sub_tags')->where('sub_tag_id',$data['sub_tag_id'])->get();

                                        @endphp
                                        @for($i=0;$i<count($tags_belong_to_subtag);$i++)

                                                <?php $tags_belong_to_subtag_ids[] = $tags_belong_to_subtag[$i]->tag_id; ?>

                                        @endfor

                                        <div class="">
                                            <div class="form-group">
                                                <label>Ürün hangi kategoriye ait?</label>
                                                <select class="select2" multiple="multiple" id="tags" data-placeholder="Kategori seçiniz" style="width: 100%;">
                                                    @foreach ($tags_data as $tag)
                                                        @if( in_array($tag->tag_id,$tags_belong_to_subtag_ids))
                                                            <option value="{{$tag->tag_id}}"{{ "selected='selected'"}}>{{$tag->tag_name}}</option>
                                                        @else
                                                            <option value="{{$tag->tag_id}}" >{{$tag->tag_name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


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
