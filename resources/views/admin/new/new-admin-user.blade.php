@extends('admin.layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Yeni Admin Oluştur</h4>
                        <h5 class="card-subtitle"> Yeni admin kullanıcısı oluşturabilirsiniz</h5>
                        <form class="row g-3 needs-validation" id="form" novalidate>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label for="floatingName">{{LanguageChange('First Name')}}</label>
                                    <input type="text" class="form-control input-fields" id="first_name"  pattern="[a-zA-ZğüşöçĞÜŞÖÇİ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ ]{1,30}"
                                           placeholder="Lütfen doldurunuz" required>
                                    <div class="invalid-feedback"> Zorunlu alan. Min 3 harf</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label for="floatingName">{{LanguageChange('Last Name')}}</label>
                                    <input type="text" class="form-control input-fields" id="last_name" pattern="[a-zA-ZğüşöçĞÜŞÖÇİ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ ]{1,30}"
                                           placeholder="Lütfen doldurunuz" required>
                                    <div class="invalid-feedback"> Zorunlu alan.. Min 3 harf</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label for="floatingEmail">{{LanguageChange('Email')}}</label>
                                    <input type="email" class="form-control input-fields" id="email" placeholder="Lütfen doldurunuz" required>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label for="floatingPassword">{{LanguageChange('Password')}}</label>
                                    <input type="password" class="form-control input-fields" id="password" placeholder="Lütfen doldurunuz" required>
                                    <div class="invalid-feedback"> Zorunlu alan
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label for="phone">{{LanguageChange('Phone')}}</label>
                                    <input type="tel" class="form-control input-fields" id="phone" placeholder="Lütfen doldurunuz" pattern="[0-9]{10,11}" required>
                                    <div class="invalid-feedback"> Zorunlu alan. Numaranızı boşluk ve karakter olmadan sadece rakam formatında yazınız</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label for="title">{{LanguageChange('Title')}}</label>
                                    <input type="title" class="form-control input-fields" id="title" placeholder="Lütfen doldurunuz"  pattern="[a-zA-Z0-9ğüşöçĞÜŞÖÇİ]{1,30}" required>
                                    <div class="invalid-feedback"> Zorunlu alan. Sadece yazı, rakam ve bazı özel karakterler (.,)</div>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <div class="form-floating mb-3">
                                    <label for="floatingSelect">{{LanguageChange('Admin Type')}}</label>
                                    <select class="custom-select" id="admin_user_type_id" aria-label="User Type"
                                            onchange="display_permissions()" required>

                                        <option value="" selected>Lütfen seçiniz</option>
                                        @foreach (\App\Models\AdminUserType::all() as $user_type)
                                            <option value="{{ $user_type->admin_user_type_id }}">{{ $user_type->admin_user_type_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"> Zorunlu alan</div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Kullanıcı Aktif mi?</label>
                                    <select id="is_active" class="form-control" name="is_active" style="width: 100%;">
                                        <option value="0" selected>Hayir</option>
                                        <option value="1" >Evet</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 form-group" id="permissions">


                            </div>

                        </form>
                        <div class="col-sm-12" style="text-align: -webkit-right; align-self: end;">
                            <div class="btn btn-primary" id="form_submit">Ekle</div>
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
            formData.append('admin_user_type_id', $('#admin_user_type_id').find(':selected').val());
            formData.append('is_active', $('#is_active').find(':selected').val());

            fetch('{{ route('new_admin_user_api') }}', {

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
                            window.location = '{{route('admin_panel_admin_users')}}';
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

        function display_permissions() {

            var admin_user_type_id = $('#admin_user_type_id').find(':selected').val();
            if (admin_user_type_id == '') {
                $('#permissions').html("");

                return;
            }

            show_loader();
            let formData = new FormData();
            formData.append('admin_user_type_id', admin_user_type_id);

            fetch('{{ route('get_permissions_api') }}', {

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
                    Swal.close();
                    if (data.result != '1') {
                        Swal.fire({
                            icon: 'error',
                            title: data.msg,
                            confirmButtonColor: '#367ab2',
                        })
                        return;
                    }

                    $('#permissions').html(data.html);
                    Swal.close();
                })
                .catch((error) => {

                    Swal.fire({
                        icon: 'error',
                        title: error,
                    })

                });
        }


    </script>
@endsection
