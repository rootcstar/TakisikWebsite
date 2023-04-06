
$(document).ready(function () {
    $('#active_drivers').DataTable({
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
            $(nRow).attr('id', 'driver-' + aData.driver_id); // or whatever you choose to set as the id
        },
//                "ajax": "../api/admin/api-fill-datatable.php?datatable_name=active_drivers",
        "ajax": "/api/fill-datatable?datatable_name=active_drivers",
        "columns": [

            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    return '<span class="right badge badge-warning action-button action-details"><a href="{{'/drivers/'}}' + row.driver_id + '" class="white" target="_blank">Update</span></a> '
                }
            },

            {"data": "driver_id"},
            {
                mRender: function (data, type, row) {
                    return row.first_name + ' ' + row.last_name
                }
            },
            {"data": "email"},
            {"data": "phone"},
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    if (row.is_active == 't') {
                        status = '<span class="right badge badge-success action-button white width-100">Active</span>';
                    } else {

                        status = '<span class="right badge badge-danger action-button white width-100">Not Active</span>';
                    }
                    return status;
                }
            },
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    delete_function = "addToDeleteModal('" + row.driver_id + "','deleteRecord','driver')";
                    return '<i class="fas fa-trash action-delete" type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" onclick=' + delete_function + '></i></th>'
                }
            },


        ]
    });
});

$(document).ready(function () {
    $('#active_app_users').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], "serverSide": true,
        "processing": true,
        "responsive": true,
        "paging": true,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
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

        ],
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
            $(nRow).attr('id', 'user-' + aData.user_id); // or whatever you choose to set as the id
        },

        "ajax": "/api/fill-datatable?datatable_name=active_app_users",

        "columns": [

            {
                "className": 'text-center',
                mRender: function (data, type, row) {

                    if (row.email != '') {
                        //we deleted email login
                        //var password_button = '<span class="right badge badge-danger action-button action-password"><a href="reset-password.php?user_id='+row.user_id+'&&type=user" class="white" target="_blank">Password</a></span>';
                        var password_button = '';
                    } else {
                        var password_button = '';
                    }


                    return '<span class="right badge badge-warning action-button action-details"><a href="{{'/users/app-user/'}}' + row.user_id + '" class="white" target="_blank">Update</span></a> ' + password_button + ''
                }
            },

            {"data": "user_id"},
            {
                mRender: function (data, type, row) {
                    return row.first_name + ' ' + row.last_name
                }
            },
            {"data": "email"},
            {"data": "phone"},

            {"data": "formatted_address"},
            {"data": "type_name"},

        ]
    });
});

$(document).ready(function() {
    $('#active_admin_users').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],"serverSide": true,
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

        ],"searching": true,
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'admin-' + aData.admin_id); // or whatever you choose to set as the id
        },
        // "ajax": "../api/admin/api-fill-datatable.php?datatable_name=active_admin_users",
        "ajax":"/api/fill-datatable?datatable_name=active_admin_users",
        "columns": [

            {
                "className": 'text-center',
                mRender: function (data, type, row) {

                    if(row.email != ''){

                        var password_button = '<span class="right badge badge-danger action-button action-password"><a href="reset-password.php?admin_id='+row.admin_id+'&&type=user" class="white" target="_blank">Password</a></span>';

                    } else {
                        var password_button='';
                    }


                    return '<span class="right badge badge-warning action-button action-details"><a href="{{'/users/admin/'}}'+row.admin_id+'" class="white" target="_blank">Update</span></a> '
                }
            },

            { "data": "admin_id" },
            {
                mRender: function (data, type, row) {
                    return row.first_name +' '+ row.last_name
                }
            },
            { "data": "email" },
            { "data": "phone" },
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    if(row.is_active == 't'){
                        status = '<span class="right badge badge-success action-button white width-100">Active</span>';
                    } else {

                        status ='<span class="right badge badge-danger action-button white width-100">Inactive</span>';
                    }
                    return status;
                }
            },




        ]
    });
});

$(document).ready(function() {
    $('#active_tm_users').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],"serverSide": true,
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

        ],"searching": true,
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'admin-' + aData.admin_id); // or whatever you choose to set as the id
        },

        "ajax":"/api/fill-datatable?datatable_name=active_tm_users",

        "columns": [

            {
                "className": 'text-center',
                mRender: function (data, type, row) {

                    if(row.email != ''){

                        var password_button = '<span class="right badge badge-danger action-button action-password"><a href="reset-password.php?admin_id='+row.admin_id+'&&type=admin" class="white" target="_blank">Password</a></span>';

                    } else {
                        var password_button='';
                    }
                    return '<span class="right badge badge-warning action-button action-details"><a href="{{'/users/admin/'}}'+row.admin_id+'" class="white" target="_blank">Update</span></a> '
                }
            },

            { "data": "admin_id" },
            {
                mRender: function (data, type, row) {
                    return row.first_name +' '+ row.last_name
                }
            },
            { "data": "email" },
            { "data": "phone" },

            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    if(row.is_active == 't'){
                        status = '<span class="right badge badge-success action-button white width-100">Active</span>';
                    } else {

                        status ='<span class="right badge badge-danger action-button white width-100">Inactive</span>';
                    }
                    return status;
                }
            },





        ]
    });
});

$(document).ready(function() {
    $('#active_statistics_users').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],"serverSide": true,
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

        ],"searching": true,
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'admin-' + aData.admin_id); // or whatever you choose to set as the id
        },
        // "ajax": "../api/admin/api-fill-datatable.php?datatable_name=active_statistics_users",
        "ajax":"/api/fill-datatable?datatable_name=active_statistics_users",

        "columns": [

            {
                "className": 'text-center',
                mRender: function (data, type, row) {

                    if(row.email != ''){

                        var password_button = '<span class="right badge badge-danger action-button action-password"><a href="reset-password.php?admin_id='+row.admin_id+'&&type=admin" class="white" target="_blank">Password</a></span>';

                    } else {
                        var password_button='';
                    }
                    return '<span class="right badge badge-warning action-button action-details"><a href="{{'/users/admin/'}}'+row.admin_id+'" class="white" target="_blank">Update</span></a> '
                }
            },

            { "data": "admin_id" },
            {
                mRender: function (data, type, row) {
                    return row.first_name +' '+ row.last_name
                }
            },
            { "data": "email" },
            { "data": "phone" },
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    if(row.is_active == 't'){
                        status = '<span class="right badge badge-success action-button white width-100">Active</span>';
                    } else {

                        status ='<span class="right badge badge-danger action-button white width-100">Inactive</span>';
                    }
                    return status;
                }
            },


            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    delete_function = "addToDeleteModal('"+row.admin_id+"','deleteRecord','statistics_user')";
                    return '<i class="fas fa-trash action-delete" type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" onclick='+delete_function+'></i></th>'
                }
            },


        ]
    });
});

/*
$(document).ready(function () {
    $('#unconfirmed_orders').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], "serverSide": true,
        "processing": true,
        "responsive": true,
        "paging": true,
        "order": [[2, "desc"]],
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
            $(nRow).attr('id', 'unconfirmed_order-' + aData.order_id); // or whatever you choose to set as the id
        },


        "ajax": "/api/fill-datatable?datatable_name=unconfirmed_orders",


        "columns": [
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    cancel_function = "addToCancelAndRefundModal('" + row.order_id + "')";
                    return ' <span class="right badge badge-warning action-button action-details"><a href="{{'orders/'}}' + row.order_id + '" class="white" target="_blank">Details</span></a> <span class="right badge badge-danger action-button action-cancel"  data-toggle="modal" data-target="#modal-danger" onclick="' + cancel_function + '">Cancel & Refund</span>'
                }
            },
            {"data": "order_id"},
            {
                mRender: function (data, type, row) {
                    return row.first_name + ' ' + row.last_name
                }
            },
            {
                mRender: function (data, type, row) {
                    //return sqlToJsDate(row.order_date);

                }
            },
            {"data": "user_formatted_address"},

        ]
    });
});
*/
$(document).ready(function () {

    $('#confirmed_orders').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], "serverSide": true,
        "processing": true,
        "responsive": true,
        "paging": true,
        "order": [[2, "desc"]],
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
            $(nRow).attr('id', 'confirmed_order-' + aData.order_id); // or whatever you choose to set as the id
        },

        //"ajax": "../api/admin/api-fill-datatable.php?datatable_name=confirmed_orders",
        "ajax": "/api/fill-datatable?datatable_name=confirmed_orders",


        "columns": [
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    cancel_function = "addToCancelAndRefundModal('" + row.order_id + "')";
                    return ' <span class="right badge badge-warning action-button action-details"><a href="{{'/orders/'}}' + row.order_id + '" class="white" target="_blank">Details</span></a> <span class="right badge badge-danger action-button action-cancel"  data-toggle="modal" data-target="#modal-danger" onclick="' + cancel_function + '">Cancel & Refund</span>'
                }
            },

            {"data": "order_id"},
            {
                mRender: function (data, type, row) {
                    return row.first_name + ' ' + row.last_name
                }
            },
            {
                mRender: function (data, type, row) {
                    // return sqlToJsDate(row.order_date);
                }
            },
            {"data": "user_formatted_address"},


        ]
    });
});

$(document).ready(function() {
    $('#completed_orders').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],"serverSide": true,
        "processing": true,
        "responsive": true,
        "paging": true,
        "order": [[ 2, "desc" ]],
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

        ],"searching": true,
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'completed_order-' + aData.order_id); // or whatever you choose to set as the id
        },

        //"ajax": "../api/admin/api-fill-datatable.php?datatable_name=completed_orders",
        "ajax": "/api/fill-datatable?datatable_name=completed_orders",


        "columns": [
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    return ' <span class="right badge badge-warning action-button action-details"><a href="{{'/orders/'}}='+row.order_id+'" class="white" target="_blank">Details</a></span>'
                }
            },
            { "data": "order_id" },
            {
                mRender: function (data, type, row) {
                    return row.first_name +' '+ row.last_name
                }
            },
            {
                mRender: function (data, type, row) {
                    //return sqlToJsDate(row.order_date);
                }
            },
            { "data": "user_formatted_address" },
            { "data": "store_name" },
            { "data": "subtotal" },

        ]
    });
});

$(document).ready(function() {
    $('#cancelled_orders').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],"serverSide": true,
        "processing": true,
        "responsive": true,
        "paging": true,
        "order": [[ 2, "desc" ]],

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

        ],"searching": true,
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'cancelled_order-' + aData.order_id); // or whatever you choose to set as the id
        },

        // "ajax": "../api/admin/api-fill-datatable.php?datatable_name=cancelled_orders",
        "ajax": "/api/fill-datatable?datatable_name=cancelled_orders",


        "columns": [
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    return ' <span class="right badge badge-warning action-button action-details"><a href="{{'/orders/'}}'+row.order_id+'" class="white" target="_blank">Details</span></a> '
                }
            },
            { "data": "order_id" },
            {
                mRender: function (data, type, row) {
                    return row.first_name +' '+ row.last_name
                }
            },
            {
                mRender: function (data, type, row) {
                    //    return sqlToJsDate(row.order_date);
                }
            },
            { "data": "user_formatted_address" },




        ]
    });
});

$(document).ready(function() {
    $('#active_stores').DataTable({
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
            $(nRow).attr('id', 'store-' + aData.store_id); // or whatever you choose to set as the id
        },
        // "ajax": "../api/admin/api-fill-datatable.php?datatable_name=active_stores",
        "ajax":"/api/fill-datatable?datatable_name=active_stores",
        "columns": [

            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    if(row.store_id==568){

                        return '<span class="right badge badge-warning action-button action-details" onclick="my_func()"><a  class="white" target="_blank">Update</span></a> <span class="right badge badge-danger action-button action-password"></span>'

                    } else {
                        return '<span class="right badge badge-warning action-button action-details"><a href="{{'/stores/'}}'+row.store_id+'" class="white" target="_blank">Update</span></a> <span class="right badge badge-danger action-button action-password"></span>'

                    }

                }
            },

            { "data": "store_id" },
            { "data": "store_name" },
            { "data": "store_address_1" },
            {
                mRender: function (data, type, row) {
                    return row.city +', '+ row.state
                }
            },
            { "data": "zip" },
            { "data": "country" },
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    if(row.is_open == 't'){
                        status = '<span class="right badge badge-success action-button white width-100">Open</span>';
                    } else {

                        status ='<span class="right badge badge-danger action-button white width-100">Not Open</span>';
                    }
                    return status;
                }
            },


        ]
    });

});

$(document).ready(function() {
    $('#inactive_stores').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],"serverSide": true,
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

        ],"searching": true,
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'store-' + aData.store_id); // or whatever you choose to set as the id
        },
        // "ajax": "../api/admin/api-fill-datatable.php?datatable_name=inactive_stores",
        "ajax":"/api/fill-datatable?datatable_name=inactive_stores",
        "columns": [

            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    return '<span class="right badge badge-warning action-button action-details"><a href="{{'/stores/'}}'+row.store_id+'" class="white" target="_blank">Update</span></a> <span class="right badge badge-danger action-button action-password"></span>'
                }
            },

            { "data": "store_id" },
            { "data": "store_name" },
            { "data": "store_address_1" },
            {
                mRender: function (data, type, row) {
                    return row.city +', '+ row.state
                }
            },
            { "data": "zip" },
            { "data": "country" },
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    if(row.is_open == 1){
                        status = '<span class="right badge badge-success action-button white width-100">Open</span>';
                    } else {
                        status ='<span class="right badge badge-danger action-button white width-100">Not Open</span>';

                    }
                    return '<th class="text-center">'+status+'</th>'
                }
            },


        ]
    });

});

$(document).ready(function () {
    $('#active_store_tablets').DataTable({
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
            $(nRow).attr('id', 'store-' + aData.store_id); // or whatever you choose to set as the id
        },
        // "ajax": "../api/admin/api-fill-datatable.php?datatable_name=active_store_tablets",
        "ajax":"/api/fill-datatable?datatable_name=active_store_tablets",
        "columns": [


            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    if (row.store_id == '568') {
                        status = row.store_id + ' (Test Store) ';
                    } else {
                        status = row.store_id

                    }
                    return status;
                }
            },

            {
                "className": 'text-center',
                mRender: function (data, type, row) {

                    if (row.battery_percentage <= 15) {
                        status = '<span class="right badge badge-danger action-button white width-100">' + row.battery_percentage + '</span>';

                    } else if (row.battery_percentage <= 30) {
                        status = '<span class="right badge badge-warning action-button white width-100">' + row.battery_percentage + '</span>';

                    } else if (row.battery_percentage >= 31) {
                        status = '<span class="right badge badge-success action-button white width-100">' + row.battery_percentage + '</span>';

                    } else {
                        status = '<span class="right badge badge-info action-button white width-100">not open</span>';

                    }

                    return status;
                }
            },

            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    if (row.is_charging == 1) {
                        status = '<span class="right badge badge-success action-button white width-100">Charging</span>';
                    } else {
                        status = '<span class="right badge badge-danger action-button white width-100">Not Charging</span>';

                    }
                    return status;
                }
            },

        ]
    });
});

$(document).ready(function() {
    $('#store_responsibles_table').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],"serverSide": true,
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

        ],"searching": true,
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'store_managers-' + aData.store_responsible_id); // or whatever you choose to set as the id
        },
        //"ajax": "../api/admin/api-fill-datatable.php?datatable_name=store_responsibles_table",
        "ajax":"/api/fill-datatable?datatable_name=store_responsibles_table",
        "columns": [
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    return ' <span class="right badge badge-warning action-button action-details"><a href="{{'/store-manager/'}}'+row.store_responsible_id+'" class="white" target="_blank">Details</a></span>  '
                }
            },
            { "data": "name" },
            { "data": "email" },
            { "data": "phone" },
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    delete_function = "addToDeleteModal('"+row.store_responsible_id+"','deleteRecord','store_managers')";
                    return '<i class="fas fa-trash action-delete" type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" onclick='+delete_function+'></i></th>'
                }
            },


        ]

    });
});

$(document).ready(function () {
    $('#saved_user_addresses').DataTable({
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
            $(nRow).attr('id', 'user_address-' + aData.record_id); // or whatever you choose to set as the id
        },
        //"ajax": "../api/admin/api-fill-datatable.php?datatable_name=saved_user_addresses",
        "ajax":"/api/fill-datatable?datatable_name=saved_user_addresses",
        "columns": [
            /*{
              "className": 'text-center',
                mRender: function (data, type, row) {
                    return '<span class="right badge badge-warning action-button action-details"><a href="user-address-detail.php?record_id='+row.record_id+'" class="white" target="_blank">Update</span></a> '
                }
            },*/
            {"data": "first_name"},
            {"data": "last_name"},
            {"data": "email"},
            {"data": "formatted_address"},
            {"data": "lattitude"},
            {"data": "longtitude"}
            /*  {
                "className": 'text-center',
                  mRender: function (data, type, row) {
                    delete_function = "addToDeleteModal('"+row.record_id+"','deleteRecord','user_address')";
                      return '<i class="fas fa-trash action-delete" type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" onclick="'+delete_function+'"></i></th>'
                  }
              },*/


        ]

    });
});

$(document).ready(function() {
    $('#all_categories').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],"serverSide": true,
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

        ],"searching": true,
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'category-' + aData.category_id); // or whatever you choose to set as the id
        },

        //"ajax": "../api/admin/api-fill-datatable.php?datatable_name=all_categories",
        "ajax":"/api/fill-datatable?datatable_name=all_categories",
        "columns": [
            { "className": 'text-center',
                mRender: function (data, type, row) {
                    return ' <span class="right badge badge-warning action-button action-details"><a href="{{'/categories/'}}'+row.category_id+'" class="white" target="_blank">Update</span> '
                }
            },
            { "data": "category_id" },
            { "data": "category_name_app" },
            { "data": "display_order" },
            { "data": "category_name" },
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    if(row.is_active == 't'){
                        status = '<span class="right badge badge-success action-button white width-100">Active</span>';
                    } else {
                        status ='<span class="right badge badge-danger action-button white width-100">Not Active</span>';

                    }
                    return status;
                }
            },


        ]
    });
});

$(document).ready(function () {
    $('#all_sub_categories').DataTable({
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
            $(nRow).attr('id', 'sub-category-' + aData.subcategory_id); // or whatever you choose to set as the id
        },

        // "ajax": "../api/admin/api-fill-datatable.php?datatable_name=all_sub_categories",

        "ajax":"/api/fill-datatable?datatable_name=all_sub_categories",

        "columns": [
            /* { "className": 'text-center',
               mRender: function (data, type, row) {
                   return ' <span class="right badge badge-warning action-button action-details"><a href="sub-category-detail.php?sub_category_id='+row.sub_category_id+'" class="white" target="_blank">Update</span> '
               }
             },*/

            {"data": "sub_category_id"},
            {"data": "sub_category_name"},
            {"data": "sub_category_name_app"},
            {"data": "category_name"}

        ]
    });
});

$(document).ready(function() {
    $('#tags_table').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],"serverSide": true,
        "processing": true,
        "responsive": true,
        "paging": true,
        "aLengthMenu": [
            [10, 50, 100, 200, -1],
            [10, 50, 100, 200, "All"]
        ],
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

        ],"searching": true,
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'tag-' + aData.tag_id); // or whatever you choose to set as the id
        },
        // "ajax":"../api/admin/api-fill-datatable.php?datatable_name=tags_table",
        "ajax":"/api/fill-datatable?datatable_name=tags_table",

        "columns": [
            { "className": 'text-center',
                mRender: function (data, type, row) {
                    return ' <span class="right badge badge-warning action-button action-details"><a href="{{'/tags/'}}'+row.tag_id+'" class="white" target="_blank">Update</span> '
                }
            },
            { "data": "tag_id" },
            { "data": "tag_name" },
            { "data": "display_name" }

        ]
    });
});

$(document).ready(function () {
    $('#tax_definitions_table').DataTable({
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
            $(nRow).attr('id', 'tax-' + aData.tax_id); // or whatever you choose to set as the id
        },
        // "ajax": "../api/admin/api-fill-datatable.php?datatable_name=tax_definitions_table",
        "ajax":"/api/fill-datatable?datatable_name=tax_definitions_table",
        "columns": [

            {"data": "tax_id"},
            {"data": "tax_name"},

            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    delete_function = "addToDeleteModal('" + row.tax_id + "','deleteRecord','tax')";
                    return '<i class="fas fa-trash action-delete" type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" onclick=' + delete_function + '></i></th>'
                }
            },


        ]

    });
});

$(document).ready(function () {
    $('#active_homepage_banner').DataTable({
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
            $(nRow).attr('id', 'banner-' + aData.banner_id);
        },
        // "ajax": "../api/admin/api-fill-datatable.php?datatable_name=homepage_banners",
        "ajax":"/api/fill-datatable?datatable_name=homepage_banners",
        "columns": [
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    return ' <span class="right badge badge-warning action-button action-details"><a href="{{'/homepage-banner/'}}' + row.banner_id + '" class="white" target="_blank">Update</span> '
                }
            },

            {"data": "banner_id"},

            {"data": "description"},
            {"data": "created_date"},
            {"data": "last_updated"},

            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    if (row.is_active == 't') {
                        status = '<span class="right badge badge-success action-button white width-100">Active</span>';
                    } else {

                        status = '<span class="right badge badge-danger action-button white width-100">Not Active</span>';
                    }
                    return status;
                }
            }


        ]
    });
});

$(document).ready(function () {
    $('#none_promo_codes_table').DataTable({
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
            $(nRow).attr('id', 'promo-' + aData.promo_code_id); // or whatever you choose to set as the id
        },

        //"ajax": "../api/admin/api-fill-datatable.php?datatable_name=none_promo_codes_table",
        "ajax": "/api/fill-datatable?datatable_name=none_promo_codes_table",
        "columns": [
            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    return ' <span class="right badge badge-warning action-button action-details"><a href="{{'/promo-code/'}}' + row.promo_code_id + '" class="white" target="_blank">Update</span> '
                }
            },

            {"data": "promo_code_id"},
            {"data": "promo_code_text"},
            {
                mRender: function (data, type, row) {
                    // return sqlToJsDate(row.start_date);
                }
            },
            {
                mRender: function (data, type, row) {
                    //return sqlToJsDate(row.end_date);
                }
            },

            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    delete_function = "addToDeleteModal('" + row.promo_code_id + "','deleteRecord','promo')";
                    return '<i class="fas fa-trash action-delete" type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" onclick=' + delete_function + '></i></th>'
                }
            },
        ]
    });
});

$(document).ready(function() {
    $('#assigned_promo_code').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],"serverSide": true,
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

        ],"searching": true,
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'promo-' + aData.promo_code_id); // or whatever you choose to set as the id
        },

        // "ajax": "../api/admin/api-fill-datatable.php?datatable_name=assigned_promo_code",
        "ajax": "/api/fill-datatable?datatable_name=assigned_promo_code",

        "columns": [
            { "className": 'text-center',
                mRender: function (data, type, row) {
                    return ' <span class="right badge badge-warning action-button action-details"><a href="{{'/assigned-promo-code/'}}'+row.promo_code_id+'" class="white" target="_blank">Update</span> '
                }
            },

            { "data": "promo_code_id" },
            { "data": "promo_code_text" },
            {
                mRender: function (data, type, row) {
                    //return sqlToJsDate(row.start_date);
                }
            },
            {
                mRender: function (data, type, row) {
                    // return sqlToJsDate(row.end_date);
                }
            },


            {
                "className": 'text-center',
                mRender: function (data, type, row) {
                    delete_function = "addToDeleteModal('"+row.promo_code_id+"','deleteRecord','promo')";
                    return '<i class="fas fa-trash action-delete" type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger" onclick='+delete_function+'></i></th>'
                }
            },
        ]
    });
});

$(document).ready(function() {
    $('#referral_promo_codes_table').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],"serverSide": true,
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

        ],"searching": true,
        'fnCreatedRow': function (nRow, aData, iDataIndex) {
            $(nRow).attr('id', 'promo-' + aData.promo_code_id); // or whatever you choose to set as the id
        },

        //"ajax": "../api/admin/api-fill-datatable.php?datatable_name=referral_promo_codes_table",
        "ajax": "/api/fill-datatable?datatable_name=referral_promo_codes_table",

        "columns": [


            { "data": "promo_code_id" },
            { "data": "promo_code_text" },

            { "data": "assigned_user_id" },
            { "className": 'text-center',
                mRender: function (data, type, row) {
                    return row.first_name+' '+ row.last_name;
                }
            },
            { "className": 'text-left',
                mRender: function (data, type, row) {
                    return '$'+row.discount;
                }
            },


        ]
    });
});
