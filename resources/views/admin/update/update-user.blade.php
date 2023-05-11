@extends('admin.layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Kullanıcı Güncelle</h4>
                    <h5 class="card-subtitle"> Kullanıcı bilgilerini buradan güncelleyebilirsiniz</h5>
                    <form class="row g-3 needs-validation" id="form" novalidate>
                        <input class="form-control input-fields hide" id="user_id" value="{{$data['user_id']}}" readonly>
                        <div class="col-md-6 form-group">
                            <div class="form-floating">
                                <label for="company_name">{{LanguageChange('Company Name')}}</label>
                                <input type="company_name" class="form-control input-fields" id="company_name" value="{{$data['company_name']}}"  pattern="[a-zA-Z0-9ğüşöçĞÜŞÖÇİ .,-]{1,30}" required>
                                <div class="invalid-feedback"> Zorunlu alan. Sadece yazı, rakam ve bazı özel karakterler (.,)</div>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <div class="form-floating">
                                <label for="floatingName">{{LanguageChange('First Name')}}</label>
                                <input type="text" class="form-control input-fields" id="first_name"  pattern="[a-zA-ZğüşöçĞÜŞÖÇİ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ ]{1,30}"
                                       value="{{$data['first_name']}}" required>
                                <div class="invalid-feedback"> Zorunlu alan. Min 3 harf</div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="form-floating">
                                <label for="floatingName">{{LanguageChange('Last Name')}}</label>
                                <input type="text" class="form-control input-fields" id="last_name" pattern="[a-zA-ZğüşöçĞÜŞÖÇİ]{2}[a-zA-ZğüşöçĞÜŞÖÇİ ]{1,30}"
                                       value="{{$data['first_name']}}" required>
                                <div class="invalid-feedback"> Zorunlu alan.. Min 3 harf</div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="form-floating">
                                <label for="floatingEmail">{{LanguageChange('Email')}}</label>
                                <input type="email" class="form-control input-fields" id="email" value="{{$data['email']}}" required>
                                <div class="invalid-feedback"> Zorunlu alan</div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="form-floating">
                                <label for="phone">{{LanguageChange('Phone')}}</label>
                                <input type="tel" class="form-control input-fields" id="phone" value="{{$data['phone']}}" pattern="[0-9]{10,11}" required>
                                <div class="invalid-feedback"> Zorunlu alan. Numaranızı boşluk ve karakter olmadan sadece rakam formatında yazınız</div>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="form-floating">
                                <label for="floatingPassword">{{LanguageChange('Password')}}</label>
                                <input type="password" class="form-control input-fields" id="password" value="{{$data['password']}}" required>
                                <div class="invalid-feedback"> Zorunlu alan</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kullanıcı Onayla</label>
                                <select id="is_confirmed" class="form-control" style="width: 100%;">
                                    <option  value="{{$data['is_confirmed']}}" selected="">@php echo ($data['is_confirmed'] == 1) ?  'Evet' :  'Hayır' @endphp</option>
                                    <option  value="@php echo ($data['is_confirmed'] == 1) ? 0 : 1 @endphp">@php echo ($data['is_confirmed'] == 1) ? 'Hayır' : 'Evet' @endphp</option>
                                </select>
                            </div>
                        </div>


                    </form>
                    <div class="btn btn-primary" id="form_submit">Güncelle</div>
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

            $('.input-fields').each(function() {

                formData.append('' + $(this).attr('id') + '', $(this).val());
            })

            formData.append('is_confirmed', $('#is_confirmed').find(':selected').val());


            fetch('{{ route('update_user_api') }}', {

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
                            window.location = '{{route('admin_panel_users')}}';
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

