@extends('admin.layouts.app')

@section('content')

    <div class="card-header p-0">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="info-tab" data-toggle="pill"
                   href="#infotab" role="tab" aria-controls="info" onclick="ShowTable('{{fiki_encrypt('v_personal_accounts')}}')"
                   aria-selected="true">Müşteri Kimlik Bilgisi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="billing-tab" data-toggle="pill"
                   href="#billingtab" role="tab" aria-controls="billing" onclick="ShowTable('{{fiki_encrypt('users_personel')}}')"
                   aria-selected="true">Müşteri Fatura Adres Bilgisi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="shipping-tab" data-toggle="pill"
                   href="#shippingtab" role="tab" aria-controls="shipping" onclick="ShowTable('{{fiki_encrypt('v_personal_shipping_addresses')}}')"
                   aria-selected="true">Müşteri Teslimat Adres Bilgisi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="cards-tab" data-toggle="pill"
                   href="#cardstab" role="tab" aria-controls="cards" onclick="ShowTable('{{fiki_encrypt('v_personal_cards')}}')"
                   aria-selected="true">Müşteri Kart Bilgisi</a>
            </li>
        </ul>
    </div>

    <div class="card card-default">
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-above-tabContent">
                <div class="tab-pane fade show active" id="infotab" role="tabpanel" aria-labelledby="info-tab">

                    <div class="card-body" id="table-content-v_personal_accounts">


                        <table id="{{ $admin_table_data['table_id'] }}" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                @php
                                    $not_to_show = array(   'admin_users'=>array('created_date','last_updated','password')                                   );

                                @endphp
                                @foreach($admin_table_data['table_fields'] as $field)
                                    @if(isset($not_to_show[$admin_table_data['table_name']]) && in_array($field,$not_to_show[$admin_table_data['table_name']]))
                                        @continue;

                                    @endif
                                    <th>{{ LanguageChange(FixName($field)) }}</th>
                                @endforeach
                                <th>Sil</th>
                            </tr>
                            </thead>


                            <tfoot>

                            </tfoot>
                        </table>


                        <script>

                            $(document).ready(function () {
                                $('#<?php echo $admin_table_data['table_id']; ?>').DataTable({
                                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], "serverSide": true,
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
                                        $(nRow).attr('id', '<?php echo $admin_table_data['table_id']; ?>-' + aData.<?php echo $admin_table_data['table_fields'][0]; ?>); // or whatever you choose to set as the id
                                    },
                                    "ajax": "/api/fill-datatable?datatable_name=<?php echo $admin_table_data['table_id']; ?>&&primary_key=<?php echo $admin_table_data['table_fields'][0]; ?>&&cols=<?php echo fiki_encrypt(json_encode($admin_table_data['table_fields']));?>",
                                    "columnDefs": [{
                                        "defaultContent": "-",
                                        "targets": "_all"
                                    }],

                                    "columns": [
                                        {
                                            "className": 'text-center',
                                            mRender: function (data, type, row) {
                                                return '<span class="right badge badge-warning update-button action-button action-details"><a href="/admin/<?php echo $admin_table_data['table_id']; ?>/detay/' + row.<?php echo $admin_table_data['table_fields'][0]; ?> + '" class="white" target="_blank"><?php echo LanguageChange('Düzenle'); ?></span></a> '
                                            }
                                        },

                                            <?php

                                            foreach($admin_table_data['table_fields'] as $field){
                                                if(isset($not_to_show[$admin_table_data['table_name']]) && in_array($field,$not_to_show[$admin_table_data['table_name']])){
                                                    continue;
                                                }


                                                if(str_contains($field,'foto') || str_contains($field,'resim') || str_contains($field,'resmi') | str_contains($field,'image') ){
                                                    echo '{
                                    mRender: function (data, type, row) {
                                        return "<img src="+row.'.$field.'+" style=\"width:10%; height:auto\">";
                                    }
                                },';
                                                } else if(str_contains($field,'active')){
                                                    echo '{
                                    mRender: function (data, type, row) {
                                        if(row.'.$field.'){
                                         return "Evet";

                                        } else {

                                         return "Hayir";
                                        }
                                    }
                                },';
                                                } else {
                                                    echo '{"data": "'.$field.'"},';
                                                }


                                            }
                                            ?>
                                        {
                                            "className": ' text-center badge-danger',
                                            mRender: function (data, type, row) {
                                                return '<i class="fas fa-trash action-delete" onclick="DeleteRecordModal(\'<?php echo $admin_table_data['table_name']; ?>\',\''+row.<?php echo $admin_table_data['table_fields'][0]; ?>+'\')" data-toggle="modal" data-target="#modal-delete" type="button"></i> ';
                                            }
                                        },

                                    ]
                                });
                            });
                        </script>

                    </div>
                </div>

                <div class="tab-pane fade show " id="billingtab" role="tabpanel" aria-labelledby="billing-tab">


                    <div class="card-body" id="table-content-v_personal_billing_addresses">

                    </div>
                </div>

                <div class="tab-pane fade show " id="shippingtab" role="tabpanel" aria-labelledby="shipping-tab">


                    <div class="card-body" id="table-content-v_personal_shipping_addresses">

                    </div>
                </div>

                <div class="tab-pane fade show " id="cardstab" role="tabpanel" aria-labelledby="cards-tab">


                    <div class="card-body" id="table-content-v_personal_cards">

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('external_js')
    <script>
        function ShowTable(enc_id){
            var data = '{"table_id":"' +enc_id+'"}';

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    let resp = JSON.parse(this.responseText);

                    if (resp['result'] == 1) {

                        $('#table-content-'+resp['table_name']).html('');
                        $('#table-content-'+resp['table_name']).append(resp['table_content']);

                    }else{

                        Swal.fire({
                            icon: 'error',
                            title: (resp['msg']),
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }

                    //     $('#loader').addClass("hidden");


                } else if (this.status >= 400) {
                    let resp = JSON.parse(this.responseText);
                    Swal.fire({
                        icon: 'warning',
                        title: (resp['msg']),
                        showConfirmButton: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else if (this.status >= 500) {
                    //Başarısız
                    alert('error');
                }
            };
            xhttp.onerror = function onError(e) {
                let resp = JSON.parse(this.responseText);
                // $('#loader').addClass("hidden");

                Swal.fire(resp['msg']);
                // location.reload();
            };

            xhttp.open("POST", "/api/show-table", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.send(data);

        }

    </script>
@endsection
