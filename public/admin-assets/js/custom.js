$(function() {
    $('#carousel1').owlCarousel({
        loop: true,
        autoplay: true,
        margin: 10,
        responsiveClass: true,
        dots: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            }
        }
    });
    $('#testi').owlCarousel({
        loop: true,
        margin: 30,
        nav: false,
        dots: true,
        autoplay: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            }
        }
    });
    $('a.nav-link, .dm-btn').on('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top - 10
        }, 1000);
        event.preventDefault();
    });
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
                    $(id).attr("disabled", false).focus();

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
