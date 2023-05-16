@extends('admin.layouts.app')


@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Yeni Ürün Oluştur</h4>
                        <h5 class="card-subtitle"> Yeni ürün oluşturabilirsiniz</h5>
                        <form class="row g-3 needs-validation" id="product-form" novalidate>
                            <div class="col-sm-12">
                                <div class="form-group">

                                    @php $subtags_data = \App\Models\SubTag::all(); @endphp

                                    <label>Ürün hangi alt kategoriye ait?</label>
                                    <select class="select2 form-control" multiple="multiple" id="subtags-multiple" data-placeholder="En az 1 alt kategori seçiniz" style="height: 36px;width: 100%;">

                                        @foreach ($subtags_data as $subtag)
                                            <option value="{{$subtag->sub_tag_id}}" >{{$subtag->sub_tag_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <div class="form-floating">
                                    <label for="barcode">{{LanguageChange('Barkod Numarası')}}</label>
                                    <input type="text" class="form-control input-fields" id="barcode" placeholder="Lütfen doldurunuz"  pattern="[0-9]{1,30}" required>
                                    <div class="invalid-feedback"> Zorunlu alan. Sadece rakam</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label for="floatingName">{{LanguageChange('Product Code')}}</label>
                                    <input type="text" class="form-control input-fields" id="product_code"  pattern="[a-zA-ZğüşöçĞÜŞÖÇİ0-9 ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ0-9 ]{1,30}"
                                           placeholder="Lütfen doldurunuz" required>
                                    <div class="invalid-feedback"> Zorunlu alan. Min 3 harf</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label for="floatingName">{{LanguageChange('Product Name')}}</label>
                                    <input type="text" class="form-control input-fields" id="product_name" pattern="[a-zA-ZğüşöçĞÜŞÖÇİ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ ]{1,30}"
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
                                            <option value="{{$unit->unit_id}}" >{{$unit->unit_name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label>{{LanguageChange('Unit Quantity')}}</label>
                                    <input type="text" class="form-control input-fields" id="unit_qty" pattern="[0-9]{1,30}" placeholder="Lütfen doldurunuz" required>
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
                                            <option value="{{$main_unit->main_unit_id}}" >{{$main_unit->main_unit_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label>{{LanguageChange('Main Unit Quantity')}}</label>
                                    <input type="text" class="form-control input-fields" id="main_unit_qty" pattern="[0-9]{1,30}" placeholder="Lütfen doldurunuz" required>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label>{{LanguageChange('Single Price')}}</label>
                                    <input type="text" class="form-control input-fields" id="single_price" placeholder="Lütfen doldurunuz" pattern="[0-9 .,]{1,30}"required>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label>{{LanguageChange('Wholesale Price')}}</label>
                                    <input type="text" class="form-control input-fields" id="wholesale_price" placeholder="Lütfen doldurunuz" pattern="[0-9 .,]{1,30}" required>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label>{{LanguageChange('Retail Price')}}</label>
                                    <input type="text" class="form-control input-fields" id="retail_price" placeholder="Lütfen doldurunuz" pattern="[0-9 .,]{1,30}"  required>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label>{{LanguageChange('KDV')}}</label>
                                    <input type="text" class="form-control input-fields" id="kdv" placeholder="Lütfen doldurunuz" pattern="[0-9 .,]{1,30}"  required>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{LanguageChange('Is Active')}}?</label>
                                    <select id="is_active" class="form-control" style="width: 100%;">
                                        <option value="0" selected>Hayir</option>
                                        <option value="1" >Evet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{LanguageChange('Is New')}}?</label>
                                    <select id="is_new" class="form-control" style="width: 100%;">
                                        <option value="0" selected>Hayir</option>
                                        <option value="1" >Evet</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="btn btn-primary" id="product_form_submit">Ekle</div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script>


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

            fetch('{{ route('new_product_api') }}', {

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
                            window.location = '{{route('admin_panel_products')}}';
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
