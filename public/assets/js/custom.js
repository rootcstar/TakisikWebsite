
$('#register-btn-ind').click( function() {
    $('#account_type').val(1);
    $(this).addClass('selected');
    $('#register-btn-comp').removeClass('selected');
    $('.company-fields').each(function() {

        $(this).hide();
        $('#company_name').val('');
        $('#company_name').prop('disabled','disabled');
        $('#company_name').prop('required','');

    })
});

$('#register-btn-comp').click( function() {
    $('#account_type').val(2);
    $(this).addClass('selected');
    $('#register-btn-ind').removeClass('selected');
    $('.company-fields').each(function() {

        $(this).show();
        $('#company_name').prop('disabled','');
        $('#company_name').prop('required','required');
    })
});

$(document).ready(function() {
    // Get the modal
    var modal = document.getElementById("NewAddressModal");

    // Get the <span> element that closes the modal
    var span = document.getElementById("close-new-address-modal");

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
        // Clear form inputs
        $('#NewAddressModal input[type="text"],#NewAddressModal select').val('');
        $('#district').attr("disabled", true).html("<option value=''>Seçiniz</option>");
        $('#neighbourhood').attr("disabled", true).html("<option value=''>Seçiniz</option>");
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            // Clear form inputs
            $('#NewAddressModal input[type="text"], #NewAddressModal select').val('');
            $('#district').attr("disabled", true).html("<option value=''>Seçiniz</option>");
            $('#neighbourhood').attr("disabled", true).html("<option value=''>Seçiniz</option>");
        }
    }
});

$(document).ready(function() {

    get_list_data("city", true, "#city");


    $("#city").on("change", function () {

        $("#district").attr("disabled", true).html("<option value=''>Seçiniz</option>");
        $("#neighbourhood").attr("disabled", true).html("<option value=''>Seçiniz</option>");

        get_list_data("district", $(this).val(), "#district");


    });

    $("#district").on("change", function () {

        $("#neighbourhood").attr("disabled", true).html("<option value=''>Seçiniz</option>");

        get_list_data("neighbourhood", $(this).val(), "#neighbourhood");

    });

    function get_list_data(action, val, id) {
        $('#loader').removeClass('hidden');
        if(action == 'city'){
            var data = '{ "city":"' + val + '"}';
        }

        if(action == 'district'){
            var data = '{ "city_id":"' + val + '"}';
        }

        if(action == 'neighbourhood'){
            var data = '{ "district_id":"' + val + '"}';
        }


        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.responseText);

                if(response['result'] == 1){
                    $(id).attr("disabled", false).html("<option value=''>Seçiniz</option>");
                    $(id).focus();
                    $.each(response['data'], function (index, value) {
                        var row="";
                        row +='<option value="'+value[action+'_id']+'">'+value[action+'_name_uppercase']+'</option>';
                        $(id).append(row);
                    })
                    $('#loader').addClass('hidden');

                }else{
                    $('#loader').addClass('hidden');
                    Swal.fire(response['msg']);
                }
            } else if (this.status >= 400 && this.status < 500) {
                let response = JSON.parse(this.responseText);
                $('#loader').addClass('hidden');
                Swal.fire(response['msg']);
            } else if (this.status >= 500) {
                let response = JSON.parse(this.responseText);
                $('#loader').addClass('hidden');
                Swal.fire(response['msg']);

            }
            xhttp.onerror = function onError(e) {

                alert('con error:'+e);
            }
        };

        xhttp.open("POST", "/api/get-"+action, true);
        xhttp.setRequestHeader("Content-Type", "application/json");
        xhttp.send(data);
    }
});
