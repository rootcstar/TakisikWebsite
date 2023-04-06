@extends('admin.layouts.app')

@section('content')

    <div class="card-header p-0">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="info-tab" data-toggle="pill"
                   href="#infotab" role="tab" aria-controls="info"
                   aria-selected="true">Müşteriler</a>
            </li>
        </ul>
    </div>

    <div class="card card-default">
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-above-tabContent">
                <div class="tab-pane fade show active" id="infotab" role="tabpanel" aria-labelledby="info-tab">

                    <div class="card-body" id="table-content">


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
                                    "ajax": "/api/fill-datatable?datatable_name=<?php echo $admin_table_data['table_id']; ?>&&primary_key=<?php echo $admin_table_data['table_fields'][0]; ?>&&cols=<?php echo encrypt(json_encode($admin_table_data['table_fields']));?>",
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


            </div>
        </div>
    </div>
@endsection


