@extends('admin.layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Kullanıcı Güncelle</h4>
                <h6 class="card-subtitle">Kullanıcı bilgilerini buradan güncelleyebilirsiniz</h6>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#account-info" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Kullanıcı Bilgileri</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#shipping-info" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Kargo Adresleri</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#billing-info" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Fatura Adresleri</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#card-info" role="tab"><span class="hidden-sm-up"></span> <span class="hidden-xs-down">Kart Bilgileri</span></a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tab-content-border">
                    <div class="tab-pane active" id="account-info" role="tabpanel">
                        <div class="p-20">

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
                                        <input type="password" class="form-control input-fields" id="password" value="{{fiki_decrypt($data['password'])}}" required>
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
                            <div class="col-sm-12" style="text-align: -webkit-right; align-self: end;">
                                <div class="btn btn-primary" id="form_submit">Güncelle</div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane  p-20" id="shipping-info" role="tabpanel">
                        <table id="{{$shipping_address_table_name}}" class="table table-striped table-bordered w-100" >
                            <thead>
                            <tr>
                                <th>Güncelle</th>
                                @foreach($shipping_address_keys as $shipping_address_key)
                                    <th>{{ LanguageChange(ucwords(str_replace("_"," ",$shipping_address_key))) }}</th>
                                @endforeach
                                <th>Sil</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                            <tfoot>
                            <tr>
                                <th>Güncelle</th>
                                @foreach($shipping_address_keys as $shipping_address_key)
                                    <th>{{ LanguageChange(ucwords(str_replace("_"," ",$shipping_address_key))) }}</th>
                                @endforeach
                                <th>Sil</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="tab-pane p-20" id="billing-info" role="tabpanel">
                        <table id="{{$billing_address_table_name}}" class="table table-striped table-bordered w-100" >
                            <thead>
                            <tr>
                                <th>Güncelle</th>
                                @foreach($billing_address_keys as $billing_address_key)
                                    <th>{{ LanguageChange(ucwords(str_replace("_"," ",$shipping_address_key))) }}</th>
                                @endforeach
                                <th>Sil</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                            <tfoot>
                            <tr>
                                <th>Güncelle</th>
                                @foreach($billing_address_keys as $billing_address_key)
                                    <th>{{ LanguageChange(ucwords(str_replace("_"," ",$billing_address_key))) }}</th>
                                @endforeach
                                <th>Sil</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="tab-pane p-20" id="card-info" role="tabpanel">
                        <table id="{{$user_cards_table_name}}" class="table table-striped table-bordered w-100" >
                            <thead>
                            <tr>
                                <th>Güncelle</th>
                                @foreach($user_cards_keys as $user_cards_key)
                                    <th>{{ LanguageChange(ucwords(str_replace("_"," ",$user_cards_key))) }}</th>
                                @endforeach
                                <th>Sil</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                            <tfoot>
                            <tr>
                                <th>Güncelle</th>
                                @foreach($user_cards_keys as $user_cards_keys)
                                    <th>{{ LanguageChange(ucwords(str_replace("_"," ",$user_cards_key))) }}</th>
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
                            window.location = '{{route('admin_panel_customers')}}';
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

        $(document).ready(function () {

            var table_name = "user_shipping_addresses"
            var where = "user_id = {{$data['user_id']}}"
            var post_or_get = "GET"
            var primary_key = 'user_id'

            var query_string = "table="+table_name+"&&"+
                "where="+where+"&&"+
                "post_or_get="+post_or_get+"&&"+
                "primary_key="+primary_key;

            $('#{{$shipping_address_table_name}}').DataTable({
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

                    $(nRow).attr('id', '{{$shipping_address_key}}_' + aData.user_id); // or whatever you choose to set as the id
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
                            return '<a  target="_blank" href="/admin/customers/update/'+row.user_id+'">' +
                                '<button type="button" class="btn btn-warning" >Güncelle</button>'
                            '</a>'
                        }
                    },
                    {"data": "record_id"},
                    {"data": "user_id"},
                    {"data": "address_line_1"},
                    {"data": "address_line_2"},
                    {"data": "country"},
                    {"data": "city"},
                    {"data": "zip"},
                    {
                        "data":null,
                        "className": 'text-center ',
                        mRender: function (data, type, row) {
                            return '<button type="button" class="btn btn-danger" onclick=""><i class="fas fa-trash"></i></button>'
                        }
                    },


                ]
            });
        });

        $(document).ready(function () {

            var table_name = "user_billing_addresses"
            var where = "user_id = {{$data['user_id']}}"
            var post_or_get = "GET"
            var primary_key = 'user_id'

            var query_string = "table="+table_name+"&&"+
                "where="+where+"&&"+
                "post_or_get="+post_or_get+"&&"+
                "primary_key="+primary_key;

            $('#{{$billing_address_table_name}}').DataTable({
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

                    $(nRow).attr('id', '{{$billing_address_table_name}}_' + aData.user_id); // or whatever you choose to set as the id
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
                            return '<a  target="_blank" href="/admin/customers/update/'+row.user_id+'">' +
                                '<button type="button" class="btn btn-warning" >Güncelle</button>'
                            '</a>'
                        }
                    },
                    {"data": "record_id"},
                    {"data": "user_id"},
                    {"data": "billing_address_line_1"},
                    {"data": "billing_address_line_2"},
                    {"data": "country"},
                    {"data": "city"},
                    {"data": "zip"},
                    {
                        "data":null,
                        "className": 'text-center ',
                        mRender: function (data, type, row) {
                            return '<button type="button" class="btn btn-danger" onclick=""><i class="fas fa-trash"></i></button>'
                        }
                    },


                ]
            });
        });

        $(document).ready(function () {

            var table_name = "user_cards"
            var where = "user_id = {{$data['user_id']}}"
            var post_or_get = "GET"
            var primary_key = 'user_id'

            var query_string = "table="+table_name+"&&"+
                "where="+where+"&&"+
                "post_or_get="+post_or_get+"&&"+
                "primary_key="+primary_key;

            $('#{{$user_cards_table_name}}').DataTable({
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

                    $(nRow).attr('id', '{{$user_cards_table_name}}_' + aData.user_id); // or whatever you choose to set as the id
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
                            return '<a  target="_blank" href="/admin/customers/update/'+row.user_id+'">' +
                                '<button type="button" class="btn btn-warning" >Güncelle</button>'
                            '</a>'
                        }
                    },
                    {"data": "record_id"},
                    {"data": "name_on_card"},
                    {"data": "card_type"},
                    {"data": "last_four_digit"},
                    {"data": "is_active"},
                    {
                        "data":null,
                        "className": 'text-center ',
                        mRender: function (data, type, row) {
                            return '<button type="button" class="btn btn-danger" onclick=""><i class="fas fa-trash"></i></button>'
                        }
                    },


                ]
            });
        });
    </script>
@endsection

