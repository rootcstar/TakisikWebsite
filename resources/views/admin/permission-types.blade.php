
@extends('admin.layouts.app')


@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!--DEAL 1 -->
                <div class="card card-default">

                    <!-- /.card-header -->
                    <div class="card-body">
                        <h3 class="card-title" >
                            {{$title}}
                        </h3>
                        <h6 class="card-subtitle">You can delete and add an permission type from here to assign permission later</h6>
                        <h6 class="card-subtitle">You can also assign a permission to user</h6>
                        <table id="{{$table_id}}" class="table table-striped table-bordered" >
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
                        <div class="col-md-12 mb-3">
                            <div class="col-md-2">
                                <a type="button" href="{{route($new_button_route)}}" class="btn btn-primary">{{$new_button_name}}</a>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Assign Permissions to User Type</h5>
                        <form class="row g-3 needs-validation" id="form" novalidate>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <label for="permission_id">Permission Type</label>
                                    <select class="custom-select" id="permission_id" aria-label="permission_id"  onchange="display_admin_user_types()"  required>
                                        <option value=""   selected>Select Permission Type</option>
                                        @foreach($data as $data3)
                                            <option value="{{ $data3 -> {$keys[0]} }}">{{ $data3-> permission_name }}</option>

                                        @endforeach

                                    </select>

                                    <div class="invalid-feedback"> Please fill this field</div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <label for="permission_id">Admin User Types</label>
                                <ul class="list-group" id="admin_user_types">

                                    <li class="list-group-item">Please select a permission to show user types</li>
                                </ul>

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

        $(document).ready(function () {

            var table_name = 'permission_types';
            var where = ""
            var post_or_get = "GET"
            var primary_key = 'permission_id';

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

                    $(nRow).attr('id', '{{$table_id}}_' + aData.permission_id); // or whatever you choose to set as the id
                },
                "ajax": "{{route('fill_datatable_api')}}?" +query_string+ "",
                "columnDefs": [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                "columns": [
                    {"data": "permission_id"},
                    {"data": "permission_name"},
                    {"data": "permission_name"},

                    {
                        "data":null,
                        "className": 'text-center ',
                        mRender: function (data, type, row) {
                            return '<button type="button" class="btn btn-primary" onclick="delete_permission_type('+row.permission_id+')"><i class="fas fa-trash"></i></button>'
                        }
                    },


                ]
            });
        });



        $('#form_submit').on('click', function () {


            is_valid = validate_form('form');
            if (!is_valid) {
                return;
            }


            Swal.fire({
                title: 'Do you want to assign?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                confirmButtonColor: '#367ab2',
            }).then((result) => {
                if (result.isConfirmed) {
                    show_loader();

                    let formData = new FormData();

                    var admin_user_type_id_array = [];
                    $("input:checkbox[name=admin_user_type_id]:checked").each(function(){
                        admin_user_type_id_array.push($(this).val());
                    });


                    formData.append('permission_id', $('#permission_id').find(':selected').val());
                    formData.append('admin_user_type_id_array', JSON.stringify(admin_user_type_id_array));


                    fetch('{{ route('assign_permission_type_api') }}', {
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



        });

        function display_admin_user_types() {


            var permission_id = $('#permission_id').find(':selected').val();
            if (permission_id == '') {
                $('#admin_user_types').html("");

                return;
            }

            show_loader();
            let formData = new FormData();
            formData.append('permission_id', permission_id);

            fetch('{{ route('get_admin_user_types_api') }}', {

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

                    $('#admin_user_types').html(data.html);
                    Swal.close();
                })
                .catch((error) => {

                    Swal.fire({
                        icon: 'error',
                        title: error,
                    })

                });
        }


        function delete_permission_type(id) {

            Swal.fire({
                title: 'Do you want to delete?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                confirmButtonColor: '#367ab2',
            }).then((result) => {
                if (result.isConfirmed) {
                    show_loader();

                    let formData = new FormData();
                    formData.append('permission_id', id);

                    fetch('{{ route('delete_permission_type_api') }}', {
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
