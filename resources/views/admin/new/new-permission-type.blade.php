@extends('admin.layout.app-layout')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create new permission type</h4>
                        <h5 class="card-subtitle"> You can crate a new permission type</h5>
                        <form class="row g-3 needs-validation" id="form" novalidate>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label for="permission_name">Permission Name</label>
                                    <input type="text" class="form-control" id="permission_name" pattern="[a-zA-Z0-9\s]+"
                                           placeholder="Permission Name" required>
                                    <div class="invalid-feedback"> Required. Min 3 letters.</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <label for="permission_code">Permission Code</label>
                                    <input type="text" class="form-control" id="permission_code"
                                           placeholder="Permission Code" required>
                                    <div class="invalid-feedback"> Please fill this field</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="form-floating">
                                    <ul class="list-group">
                                        <h5 class="card-title">Assign to a user type automatically</h5>
                                        @php($i=1)
                                        @foreach( $admin_user_types as $admin_user_type)

                                            <li class="list-group-item">
                                                <div class="form-check form-check-inline">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="admin_user_type_id" id="customCheck{{$i}}" value="{{$admin_user_type->admin_user_type_id}}" >
                                                        <label class="custom-control-label" for="customCheck{{$i}}">{{$admin_user_type->admin_user_type_name}}</label>
                                                    </div>
                                                </div>
                                            </li>

                                            @php($i++)
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="text-left">
                                <div class="btn btn-primary" id="form_submit">Submit</div>
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

            Swal.showLoading();
            let formData = new FormData();

            var admin_user_type_id_array = [];
            $("input:checkbox[name=admin_user_type_id]:checked").each(function(){
                admin_user_type_id_array.push($(this).val());
            });


            formData.append('permission_name', $('#permission_name').val());
            formData.append('permission_code', $('#permission_code').val());
            formData.append('admin_user_type_id_array', JSON.stringify(admin_user_type_id_array));

            fetch('{{ route('new_permission_type_api') }}', {
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
                            window.location = '{{route('admin_panel_permission_types')}}';
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
