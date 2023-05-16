@extends('admin.layouts.app')



@section('content')



    <div class="container-fluid">
        <div class="card-header p-0">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active text-dark" id="tag-tab" data-toggle="pill"
                       href="#tagtab" role="tab" aria-controls="tag"
                       aria-selected="true">Alt Kategori Güncelle</a>
                </li>
            </ul>
        </div>

        <div class="card card-default">

            <div class="card-body">
                <div class="tab-content" id="custom-tabs-above-tabContent">
                    <div class="tab-pane fade show active" id="tagtab" role="tabpanel" aria-labelledby="tag-tab">

                        <h3 class="card-title">Alt Kategori Güncelle</h3>
                        <h6 class="card-subtitle">Buradan alt kategori güncelleme işlemi yapabilirsiniz</h6>

                        <form class="row g-3 needs-validation" id="form" novalidate>
                            <input class="hide input-fields" value="{{$data['sub_tag_id']}}" id="sub_tag_id" readonly>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label >Alt Kategori Adı</label>
                                    <input id="sub_tag_name" type="text" class="form-control input-fields" pattern="[a-zA-ZğüşöçĞÜŞÖÇİ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ ]{1,30}"
                                           value="{{$data['sub_tag_name']}}" required>
                                    <div class="invalid-feedback"> Zorunlu alan. Min 3 harf</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    @php
                                        $tags_data = DB::table('tags')->get();
                                        $tags_belong_to_subtag = DB::table('tag_to_sub_tags')->where('sub_tag_id',$data['sub_tag_id'])->get();

                                    @endphp
                                    @for($i=0;$i<count($tags_belong_to_subtag);$i++)

                                            <?php $tags_belong_to_subtag_ids[] = $tags_belong_to_subtag[$i]->tag_id; ?>

                                    @endfor
                                    <label>Ürün hangi kategoriye ait?</label>
                                    <select class="select2 form-control" multiple="multiple" id="tags-multiple" data-placeholder="En az 1 tag seçiniz" style="height: 36px;width: 100%;">
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
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label >Sayfada Görünen Adı</label>
                                    <input id="display_name" type="text" class="form-control input-fields" pattern="[a-zA-ZğüşöçĞÜŞÖÇİ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ ]{1,30}"
                                           value="{{$data['display_name']}}" required>
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
                            <div class="col-sm-12" style="text-align: -webkit-right; align-self: end;">
                                <div class="btn btn-primary" id="form_submit">{{$update_button_name}}</div>
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

            formData.append('is_active', $('#is_active').find(':selected').val());
            let tags = $("#tags-multiple").val();
            console.log(tags);
            formData.append("tags", JSON.stringify(tags));


            fetch('{{ route('update_subtag_api') }}', {

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
