@extends('admin.layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Yeni Kullanıcı Türü Oluştur</h4>
                        <h5 class="card-subtitle"> Yeni kullanıcı türü oluşturun</h5>
                        <form class="row g-3 needs-validation" id="form" novalidate>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label for="admin_user_type_name">{{LanguageChange('Admin User Type Name')}}</label>
                                    <input type="text" class="form-control input-fields" id="admin_user_type_name" pattern="[a-zA-Z]{2}[a-zA-Z ]{1,30}"
                                           placeholder="Lütfen doldurunuz" required>

                                    <div class="invalid-feedback"> Zorunlu alan. Min 3 harf.</div>
                                </div>
                            </div>

                        </form>
                        <div class="btn btn-primary" id="form_submit">Ekle</div>
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

            Swal.showLoading();
            let formData = new FormData();



            $('.input-fields').each(function(){

                formData.append(''+$(this).attr('id')+'', $(this).val());


            });


            fetch('{{ route('new_admin_user_type_api') }}', {
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

                    Swal.fire({
                        icon: 'success',
                        title: data.msg,
                        confirmButtonColor: '#367ab2',
                    }).then((result) => {
                        if (result.isDismissed || result.isConfirmed) {
                            window.location = '{{route('admin_panel_admin_user_types')}}';
                        }

                    })

                })
                .catch((error) => {

                    Swal.fire({
                        icon: 'error',
                        title: error,
                    })
                    Swal.close();
                });


        });




    </script>
@endsection
