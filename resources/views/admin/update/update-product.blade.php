@extends('admin.layouts.app')


@section('content')


    <div class="container-fluid">
        <div class="card-header p-0">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active text-dark" id="product-tab" data-toggle="pill"
                       href="#producttab" role="tab" aria-controls="product"
                       aria-selected="true">Ürün Oluştur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" id="model-tab" data-toggle="pill"
                       href="#modeltab" role="tab" aria-controls="model"
                       aria-selected="true">Model</a>
                </li>
            </ul>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="tab-content" id="custom-tabs-above-tabContent">
                    <div class="tab-pane fade show active" id="producttab" role="tabpanel" aria-labelledby="product-tab">
                        <h3 class="card-title">Ürün Güncelle</h3>
                        <h6 class="card-subtitle"> Buradan ürün güncelleme işlemi yapabilirsiniz</h6>
                        <form class="row g-3 needs-validation" id="product-form" novalidate>
                            <input class="hide input-fields" value="{{$prod_data['product_id']}}" id="product_id" readonly>
                            <div class="col-sm-12">
                                <div class="form-group">

                                    @php
                                        $subtags_data = \App\Models\SubTag::all();
                                        $product_subtags= \App\Models\ProductSubTag::where('product_id',$prod_data['product_id'])->get();

                                    @endphp

                                    @for($i=0;$i<count($product_subtags);$i++)

                                            <?php $product_subtags_ids[] = $product_subtags[$i]->sub_tag_id; ?>

                                    @endfor

                                    <label>Ürün hangi alt kategoriye ait?</label>
                                    <select class="select2 form-control" multiple="multiple" id="subtags-multiple" data-placeholder="En az 1 alt kategori seçiniz" style="height: 36px;width: 100%;">
                                        @if(!empty($product_subtags_ids))
                                            @foreach ($subtags_data as $subtag)
                                                @if( in_array($subtag->sub_tag_id,$product_subtags_ids))
                                                    <option value="{{$subtag->sub_tag_id}}" {{ "selected='selected'"}}>{{$subtag->sub_tag_name}}</option>
                                                @else
                                                    <option value="{{$subtag->sub_tag_id}}" >{{$subtag->sub_tag_name}}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach ($subtags_data as $subtag)
                                                    <option value="{{$subtag->sub_tag_id}}" >{{$subtag->sub_tag_name}}</option>

                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <div class="form-floating">
                                    <label for="barcode">{{LanguageChange('Barkod Numarası')}}</label>
                                    <input type="text" class="form-control input-fields" id="barcode" value="{{$prod_data['barcode']}}" placeholder="Lütfen doldurunuz"  pattern="[0-9]{1,30}" required>
                                    <div class="invalid-feedback"> Zorunlu alan. Sadece rakam</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label for="floatingName">{{LanguageChange('Product Code')}}</label>
                                    <input type="text" class="form-control input-fields" id="product_code" value="{{$prod_data['product_code']}}" pattern="[a-zA-ZğüşöçĞÜŞÖÇİ0-9 ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ0-9 ]{1,30}"
                                           placeholder="Lütfen doldurunuz" required>
                                    <div class="invalid-feedback"> Zorunlu alan. Min 3 harf</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label for="floatingName">{{LanguageChange('Product Name')}}</label>
                                    <input type="text" class="form-control input-fields" id="product_name" value="{{$prod_data['product_name']}}" pattern="[a-zA-ZğüşöçĞÜŞÖÇİ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ ]{1,30}"
                                           placeholder="Lütfen doldurunuz" required>
                                    <div class="invalid-feedback"> Zorunlu alan.. Min 3 harf</div>
                                </div>
                            </div>


                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label >{{LanguageChange('Unit')}}</label>
                                    <select id="unit" class="form-control" style="width: 100%;" >

                                        @php $units = \App\Models\Unit::all(); @endphp
                                        <option value="" selected disabled>Lütfen seçiniz</option>
                                        @foreach($units as $unit)
                                            @if($prod_data['unit_id'] == $unit->unit_id)
                                                <option value="{{$unit->unit_id}}" selected>{{$unit->unit_name}}</option>
                                            @else
                                                <option value="{{$unit->unit_id}}" >{{$unit->unit_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label>{{LanguageChange('Unit Quantity')}}</label>
                                    <input type="text" class="form-control input-fields" id="unit_qty" value="{{$prod_data['unit_qty']}}" pattern="[0-9]{1,30}" placeholder="Lütfen doldurunuz" required>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>


                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label>{{LanguageChange('Main Unit')}}</label>

                                    <select id="main_unit" class="form-control " style="width: 100%;">

                                        @php $main_units = \App\Models\MainUnit::all(); @endphp
                                        <option value="" selected disabled>Lütfen seçiniz</option>
                                        @foreach($main_units as $main_unit)
                                            @if($prod_data['main_unit_id'] == $main_unit->main_unit_id)
                                                <option value="{{$main_unit->main_unit_id}}" selected>{{$main_unit->main_unit_name}}</option>
                                            @else
                                                <option value="{{$main_unit->main_unit_id}}" >{{$main_unit->main_unit_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label>{{LanguageChange('Main Unit Quantity')}}</label>
                                    <input type="text" class="form-control input-fields" id="main_unit_qty" value="{{$prod_data['main_unit_qty']}}" pattern="[0-9]{1,30}" placeholder="Lütfen doldurunuz" required>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label>{{LanguageChange('Single Price')}}</label>
                                    <input type="text" class="form-control input-fields" id="single_price" value="{{$prod_data['single_price']}}" placeholder="Lütfen doldurunuz" pattern="[0-9 .,]{1,30}"required>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label>{{LanguageChange('Wholesale Price')}}</label>
                                    <input type="text" class="form-control input-fields" id="wholesale_price" value="{{$prod_data['wholesale_price']}}" placeholder="Lütfen doldurunuz" pattern="[0-9 .,]{1,30}" required>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label>{{LanguageChange('Retail Price')}}</label>
                                    <input type="text" class="form-control input-fields" id="retail_price" value="{{$prod_data['retail_price']}}" placeholder="Lütfen doldurunuz" pattern="[0-9 .,]{1,30}"  required>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label>{{LanguageChange('KDV')}}</label>
                                    <input type="text" class="form-control input-fields" id="kdv" value="{{$prod_data['kdv']}}" placeholder="Lütfen doldurunuz" pattern="[0-9 .,]{1,30}"  required>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{LanguageChange('Is Active')}}</label>
                                    <select id="is_active" class="form-control" style="width: 100%;">
                                        <option  value="{{$prod_data['is_active']}}" selected="">@php echo ($prod_data['is_active'] == 1) ?  'Evet' :  'Hayır' @endphp</option>
                                        <option  value="@php echo ($prod_data['is_active'] == 1) ? 0 : 1 @endphp">@php echo ($prod_data['is_active'] == 1) ? 'Hayır' : 'Evet' @endphp</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{LanguageChange('Is New')}}</label>
                                    <select id="is_new" class="form-control" style="width: 100%;">
                                        <option  value="{{$prod_data['is_new']}}" selected="">@php echo ($prod_data['is_new'] == 1) ?  'Evet' :  'Hayır' @endphp</option>
                                        <option  value="@php echo ($prod_data['is_new'] == 1) ? 0 : 1 @endphp">@php echo ($prod_data['is_new'] == 1) ? 'Hayır' : 'Evet' @endphp</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="col-sm-12" style="text-align: -webkit-right;align-self: end;">
                            <div class="btn btn-primary" id="product_form_submit">Güncelle</div>
                        </div>

                    </div>

                    <div class="tab-pane fade show " id="modeltab" role="tabpanel" aria-labelledby="model-tab">
                        <h4 class="card-title">Model Ekle</h4>
                        <h5 class="card-subtitle"> Buradan yeni oluşturduğunuz ürüne model ve fotoğraf ekleyebilirsiniz</h5>
                        <form class="row g-3 needs-validation" id="model-form" novalidate>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label>{{LanguageChange('Model Number')}}</label>
                                    <input type="text" class="form-control" id="model_number"  pattern="[0-9]{1,30}"
                                           placeholder="Lütfen doldurunuz" required>
                                    <div class="invalid-feedback"> Zorunlu alan. Min 3 harf</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Resim </label>
                                    <div class="custom-file">
                                        <input type="file" class="form-control custom-file-input image-fields"  id="product_image" onchange="loadFile(event)" >

                                        <label class="custom-file-label" for="exampleInputFile" id="image_label">Dosya Seç</label>
                                    </div>
                                    <div class="invalid-feedback"> Zorunlu alan. Lütfen bir dosya seçiniz</div>
                                </div>
                            </div>
                            <div class="col-sm-12 text-right">
                                <img  width="20%" height="auto" class="img-fluid mb-2" id ="new_img">
                            </div>
                            <div class="col-sm-12" style="text-align: -webkit-right; align-self: end;">
                                <div class="btn btn-primary" id="model_form_submit">Ekle</div>
                            </div>
                        </form>
                        <table id="{{$table_id}}" class="table table-striped table-bordered w-100">
                            <thead>
                            <tr>

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

                                @foreach($keys as $key)
                                    <th>{{ LanguageChange(ucwords(str_replace("_"," ",$key))) }}</th>
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


@endsection

@section('scripts')
    <script>

        $(document).ready(function () {

            var table_name = "v_products_models_and_images"
            var where = "product_id = {{$prod_data['product_id']}}"
            var post_or_get = "GET"
            var primary_key = 'model_number'

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

                    $(nRow).attr('id', '{{$table_id}}_' + aData.model_record_id); // or whatever you choose to set as the id
                },
                "ajax": "{{route('fill_datatable_api')}}?" +query_string+ "",
                "columnDefs": [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                "columns": [

                    {"data": "model_record_id"},
                    {"data": "image_record_id"},
                    {"data": "product_id"},
                    {"data": "model_number"},
                    {"data": "product_image",
                        "className": 'text-center',
                        mRender: function (data, type, row) {
                            return '<img src="'+row.product_image+'" style="width:50%; height:auto">'
                        }},
                    {
                        "data":null,
                        "className": 'text-center ',
                        mRender: function (data, type, row) {
                            return '<button type="button" class="btn btn-danger" onclick="delete_model('+row.model_record_id+','+row.image_record_id+')"><i class="fas fa-trash"></i></button>'
                        }
                    },


                ]
            });
        });

        $('#product_form_submit').on('click', function () {
            is_valid = validate_form('product-form');
            if (!is_valid) {
                return;
            }


            show_loader();
            let formData = new FormData();

            $('.input-fields').each(function(){

                formData.append(''+$(this).attr('id')+'', $(this).val());


            });
            formData.append('is_active', $('#is_active').find(':selected').val());
            formData.append('is_new', $('#is_new').find(':selected').val());
            formData.append('unit_id', $('#unit').find(':selected').val());
            formData.append('main_unit_id', $('#main_unit').find(':selected').val());
            let tags = $("#subtags-multiple").val();
            console.log(tags);
            formData.append("subtags", JSON.stringify(tags));

            fetch('{{ route('update_product_api') }}', {

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

        $('#model_form_submit').on('click', function () {
            is_valid = validate_form('model-form');
            if (!is_valid) {
                return;
            }


            show_loader();
            let formData = new FormData();

            formData.append('product_id', $('#product_id').val());
            formData.append('model_number', $('#model_number').val());
            formData.append('product_image', document.getElementById("product_image").files[0]);


            fetch('{{ route('new_product_model_and_image_api') }}', {

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

        function delete_model(model_id,image_id) {

            Swal.fire({
                title: 'Silmek istediğinizden emin misiniz?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                confirmButtonColor: '#367ab2',
            }).then((result) => {
                if (result.isConfirmed) {
                    show_loader();

                    let formData = new FormData();
                    formData.append('model_id', model_id);
                    formData.append('image_id', image_id);

                    fetch('{{ route('delete_product_model_api') }}', {
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
                            })
                            window.location.reload();

                        })
                        .catch((error) => {

                            Swal.fire({
                                icon: 'error',
                                title: error,
                            })
                        });

                }
            })
        }

    </script>
@endsection

