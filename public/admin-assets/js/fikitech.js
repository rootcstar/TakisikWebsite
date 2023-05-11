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

$(function () { // jQuery ready
    // On blur validation listener for form elements
    $('.needs-validation').find('input,select,textarea,input[type=radio],input[type=tel],input[type=checkbox],input[type=file]').on('input', function () {

        // check element validity and change class
        $(this).removeClass('is-valid is-invalid')
            .addClass(this.checkValidity() ? 'is-valid' : 'is-invalid');
    });
});

function show_loader(){
    Swal.fire({
        title: 'Lütfen bekleyiniz...',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,

    })
}
function hide_loader(){
    Swal.close();
}
var loadFile = function (event) {

    var output = document.getElementById('new_img');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function () {
        URL.revokeObjectURL(output.src)
    }

};
function RefreshTable($table_id) {
    $( "#"+$table_id+"" ).load( ""+route('admin_panel_tags')+" #mytable" );
}
