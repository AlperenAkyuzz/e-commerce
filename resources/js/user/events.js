$(document).ready(function(){
    $('.user-action-form .tab a').on('click', function (e) {
        e.preventDefault();

        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');

        var href = $(this).attr('href');
        $('.user-action-form > form').hide();
        $(href).fadeIn(500);
    });
});

// LOGIN FORM
$("#user-login").on('submit', function (e) {
    var $this = jQuery(this).parent();
    e.preventDefault();
    $this.find('button.submit-btn').prop('disabled', true);
    $this.find('.alert-info').show();
    $this.find('.alert-info p').html(trans('auth.please_wait')).val();
    jQuery.ajax({
        method: "POST",
        url: jQuery(this).prop('action'),
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if ((data.errors)) {
                $this.find('.alert-success').hide();
                $this.find('.alert-info').hide();
                $this.find('.alert-danger').show();
                $this.find('.alert-danger ul').html('');
                for (var error in data.errors) {
                    $this.find('.alert-danger p').html(data.errors[error]);
                }
            } else {
                $this.find('.alert-info').hide();
                $this.find('.alert-danger').hide();
                $this.find('.alert-success').show();
                $this.find('.alert-success p').html(trans('auth.success_login'));
                if (data == 1) {
                    location.reload();
                } else {
                    window.location = data;
                }

            }
            $this.find('button.submit-btn').prop('disabled', false);
        }

    });

});
// LOGIN FORM ENDS

// REGISTER FORM
$("#user-signup").on('submit', function (e) {
    var $this = $(this).parent();
    e.preventDefault();
    $this.find('button.submit-btn').prop('disabled', true);
    $this.find('.alert-info').show();
    $this.find('.alert-info p').html(trans('auth.please_wait')).val();
    $.ajax({
        method: "POST",
        url: $(this).prop('action'),
        data: new FormData(this),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {

            if (data == 1) {
                window.location = mainurl + '/user/dashboard';
            } else {

                if ((data.errors)) {
                    $this.find('.alert-success').hide();
                    $this.find('.alert-info').hide();
                    $this.find('.alert-danger').show();
                    $this.find('.alert-danger ul').html('');
                    for (var error in data.errors) {
                        $this.find('.alert-danger p').html(data.errors[error]);
                    }
                    $this.find('button.submit-btn').prop('disabled', false);
                } else {
                    $this.find('.alert-info').hide();
                    $this.find('.alert-danger').hide();
                    $this.find('.alert-success').show();
                    $this.find('.alert-success p').html(data);
                    $this.find('button.submit-btn').prop('disabled', false);
                }

            }

        }

    });

});
// REGISTER FORM ENDS