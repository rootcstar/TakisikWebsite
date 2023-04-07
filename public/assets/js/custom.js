
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
