function validate_form(my_form_id) {

    is_valid = true;
    $('#'+my_form_id).find('input,select,textarea,radio,checkbox').each(function() {

        if(!this.checkValidity()){
            $(this).addClass('is-invalid');
            is_valid = false;
        } else {
            $(this).addClass('is-valid');
        }
    });
    return is_valid;

}
function show_loader(){
    Swal.fire({
        title: 'Please wait...',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,

    })
}
function hide_loader(){
    Swal.close();
}
