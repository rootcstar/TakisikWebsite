
@extends('admin.layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">

                    <div class="card-body">
                        <h3 class="card-title" >
                            {{$title}}
                        </h3>
                        <h6 class="card-subtitle">Buradan ürün silme ve ekleme işlemi yapabilirsiniz</h6>

                        <table id="{{$table_id}}" class="table table-striped table-bordered" >
                            <thead>
                            <tr>
                                <th>Güncelle</th>
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
                                <th>Güncelle</th>
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
            </div>


        </div>

    </div>



@endsection
@section('scripts')


    <script>

        $(document).ready(function () {

            var table_name = "products"
            var where = ""
            var post_or_get = "GET"
            var primary_key = 'product_id'

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

                    $(nRow).attr('id', '{{$table_id}}_' + aData.product_id); // or whatever you choose to set as the id
                },
                "ajax": "{{route('fill_datatable_api')}}?" +query_string+ "",
                "columnDefs": [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
                "columns": [

                    {
                        "data":null,
                        "className": 'text-center ',
                        mRender: function (data, type, row) {
                            return '<a  target="_blank" href="/admin/products/update/'+row.product_id+'">' +
                                '<button type="button" class="btn btn-warning" >Güncelle</button>'
                            '</a>'
                        }
                    },
                    {"data": "product_id"},
                    {"data": "barcode"},
                    {"data": "product_code"},
                    {"data": "product_name"},
                    {"data": "is_active"},
                    {"data": "is_new"},
                    {
                        "data":null,
                        "className": 'text-center ',
                        mRender: function (data, type, row) {
                            return '<button type="button" class="btn btn-danger" onclick="delete_user('+row.product_id+')"><i class="fas fa-trash"></i></button>'
                        }
                    },


                ]
            });
        });


        function delete_user(id) {

            Swal.fire({
                title: 'Silmek istediğinizden emin misiniz?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                confirmButtonColor: '#367ab2',
            }).then((result) => {
                if (result.isConfirmed) {
                    show_loader();

                    let formData = new FormData();
                    formData.append('user_id', id);

                    fetch('{{ route('delete_user_api') }}', {
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
