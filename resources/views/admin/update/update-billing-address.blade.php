@extends('admin.layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Fatura Adresi Güncelle</h4>
                <h6 class="card-subtitle">Adres bilgilerini buradan güncelleyebilirsiniz</h6>
                <!-- Tab panes -->
                <div class="tab-content tab-content-border">
                    <div class="tab-pane active" id="account-info" role="tabpanel">
                        <div class="p-20">

                            <form class="row g-3 needs-validation" id="form" novalidate>
                                <input class="form-control input-fields hide" id="user_id" value="{{$data['user_id']}}" readonly>
                                <input class="form-control input-fields hide" id="record_id" value="{{$data['record_id']}}" readonly>
                                <div class="col-md-6 form-group">
                                    <div class="form-floating">
                                        <label for="company_name">ADRES BAŞLIĞI</label>
                                        <input type="address_title" class="form-control input-fields" id="address_title" value="{{$data['address_title']}}"  pattern="[a-zA-Z0-9ğüşöçĞÜŞÖÇİ .,-]{1,30}" required>
                                        <div class="invalid-feedback"> Zorunlu alan. Sadece yazı, rakam ve bazı özel karakterler (.,)</div>
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="form-group">

                                        <label for="city" class="control-label">İL*</label>
                                        <select class="form-control input-fields" id="city" name="city" required>
                                            <option value="{{$data['city_id']}}" selected>{{$data['city']}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label for="district" class="control-label">İLÇE*</label>
                                        <select class="form-control input-fields" id="district"  name="district" disabled="disabled" required>
                                            <option value="{{$data['district_id']}}" >{{$data['district']}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label for="neighbourhood" class="control-label">MAHALLE*</label>
                                        <select class="form-control input-fields" id="neighbourhood" name="neighbourhood" disabled="disabled" required>
                                            <option value="{{$data['neighbourhood_id']}}" >{{$data['neighbourhood']}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="form-floating">
                                        <label for="zip" class="control-label">ZIP*</label>
                                        <input type="text" class="form-control input-fields" id="zip" name="zip" value="{{$data['zip']}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="form-floating">
                                        <label for="address" class="control-label">ADRES*</label>
                                        <input type="text" class="form-control input-fields" id="address" name="address" value="{{$data['address']}}" required>
                                    </div>
                                </div>

                            </form>
                            <div class="col-sm-12" style="text-align: -webkit-right; align-self: end;">
                                <div class="btn btn-primary" id="form_submit">Güncelle</div>
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
            formData.append('city', $('#city').find(':selected').val());
            formData.append('district', $('#district').find(':selected').val());
            formData.append('neighbourhood', $('#neighbourhood').find(':selected').val());

            fetch('{{ route('update_user_billing_address_api') }}', {

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

