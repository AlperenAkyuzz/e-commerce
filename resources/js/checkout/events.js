$(document).ready(function () {
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();

    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);

        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {
        /*
        var validationMessage = '';

        // Check inputs are filled.
        $.each($(this).closest('.tab-pane').find('input[type="text"]'), function () {
            if ($(this).val() == '')
                validationMessage = "Please fill all inputs";
        });
        if (validationMessage != '')
            alert(validationMessage);
        else {
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active);
        }*/

        //validate fields
        /*
        var fail = false;
        var fail_log = '';
        var name;

        $('.checkoutform').find('input').each(function(){
            if($(this).prop('required')){
                if ( ! $( this ).val() ) {
                    fail = true;
                    name = $( this ).attr( 'name' );
                    fail_log += name + " is required \n";
                }
            }
        });

        //submit if fail never got set to true
        if ( ! fail ) {
            //process form here.
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active);
            $("html, body").animate({scrollTop: 0}, 1000);

        } else {
            //alert( fail_log );
            $('.error-message').html(fail_log);
        }
*/
        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);
        $("html, body").animate({scrollTop: 0}, 1000);
        fillShippingFields()

    });

    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });

    // Password Checking

    $("#open-pass").on("change", function () {
        if (this.checked) {
            $('.set-account-pass').removeClass('d-none');
            $('.set-account-pass input').prop('required', true);
            $('#personal-email').prop('required', true);
            $('#personal-name').prop('required', true);
        } else {
            $('.set-account-pass').addClass('d-none');
            $('.set-account-pass input').prop('required', false);
            $('#personal-email').prop('required', false);
            $('#personal-name').prop('required', false);

        }
    });

    // Shipping Address Checking

    $("#ship-diff-address").on("change", function () {
        if (this.checked) {
            $('.ship-diff-addres-area').removeClass('d-none');
            $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required', true);
        } else {
            $('.ship-diff-addres-area').addClass('d-none');
            $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required', false);
        }

    });



});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}

function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

function fillShippingFields() {
    // Fill the payment shipping info fields
    var shipping_user = !$('input[name="shipping_name"]').val() ? $('input[name="name"]').val() : $('input[name="shipping_name"]').val();
    var shipping_location = !$('input[name="shipping_address"]').val() ? $('input[name="address"]').val() : $('input[name="shipping_address"]').val();
    var shipping_phone = !$('input[name="shipping_phone"]').val() ? $('input[name="phone"]').val() : $('input[name="shipping_phone"]').val();
    var shipping_email = !$('input[name="shipping_email"]').val() ? $('input[name="email"]').val() : $('input[name="shipping_email"]').val();

    $('#shipping_user').html('<i class="fas fa-user"></i>' + shipping_user);
    $('#shipping_location').html('<i class="fas fas fa-map-marker-alt"></i>' + shipping_location);
    $('#shipping_phone').html('<i class="fas fa-phone"></i>' + shipping_phone);
    $('#shipping_email').html('<i class="fas fa-envelope"></i>' + shipping_email);
}