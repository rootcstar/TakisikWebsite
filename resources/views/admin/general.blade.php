@extends('admin.layouts.app')

@section('content')


    @php
        $not_to_show = array(     'users'=>array('created_date','last_updated','password'),
                                 'admin_users'=>array('created_date','last_updated','password'),
                                 'tags'=>array('created_date','last_updated','url_name','display_order'),
                                 'sub_tags'=>array('created_date','last_updated','url_name','display_order'),
        );

    @endphp
    @foreach($table_data as $table)

        <div class="row">
            <div class="col-12">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><strong>{{ LanguageChange(FixName(($table['table_name']))) }}</strong></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="{{$table['table_id']}}" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th></th>
                                    @foreach($table['table_fields'] as $field)
                                        @if(isset($not_to_show[$table['table_name']]) && in_array($field,$not_to_show[$table['table_name']]))
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
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="col-md-2">
                                @if($table['table_name'] != 'mesajlar')
                                    @if($table['new_link'] != '#')
                                        <a href="{{$table['new_link']}}">
                                            <button class="btn btn-block btn-info btn-lg " name="">Yeni Ekle
                                            </button>
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <script>

                $(document).ready(function () {
                    $('#<?php echo $table['table_id']; ?>').DataTable({
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
                            $(nRow).attr('id', '<?php echo $table['table_id']; ?>-' + aData.<?php echo $table['table_fields'][0]; ?>); // or whatever you choose to set as the id
                        },
                        "ajax": "/api/fill-datatable?datatable_name=<?php echo $table['table_id']; ?>&&primary_key=<?php echo $table['table_fields'][0]; ?>&&cols=<?php echo fiki_encrypt(json_encode($table['table_fields']));?>",
                        "columnDefs": [{
                            "defaultContent": "-",
                            "targets": "_all"
                        }],

                        "columns": [
                            {
                                "className": 'text-center',
                                mRender: function (data, type, row) {
                                    return '<span class="right badge badge-warning update-button action-button action-details"><a href="/admin/<?php echo $table['table_id']; ?>/detay/' + row.<?php echo $table['table_fields'][0]; ?> + '" class="white" target="_blank"><?php echo LanguageChange('Düzenle'); ?></span></a> '
                                }
                            },

                                    <?php

                                    foreach($table['table_fields'] as $field){
                                        if(isset($not_to_show[$table['table_name']]) && in_array($field,$not_to_show[$table['table_name']])){
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
                                        } else if(str_contains($field,'account_type')){
                                            echo '{
                                        mRender: function (data, type, row) {
                                            if(row.'.$field.' == 1){
                                             return "Bireysel";

                                            } else {

                                             return "Kurumsal";
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
                                    return '<i class="fas fa-trash action-delete" onclick="DeleteRecordModal(\'<?php echo $table['table_name']; ?>\',\''+row.<?php echo $table['table_fields'][0]; ?>+'\')" data-toggle="modal" data-target="#modal-delete" type="button"></i> ';
                                }
                            },

                        ]
                    });
                });
            </script>





            @endforeach

            @endsection



