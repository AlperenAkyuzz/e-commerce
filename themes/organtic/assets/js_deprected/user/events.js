$(document).ready(function(){
    $('.tab a').on('click', function (e) {
        e.preventDefault();

        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');

        var href = $(this).attr('href');
        $('.forms > form').hide();
        $(href).fadeIn(500);
    });
});

// LOGIN FORM
$("#loginform").on('submit', function (e) {
    var $this = jQuery(this).parent();
    e.preventDefault();
    $this.find('button.submit-btn').prop('disabled', true);
    $this.find('.alert-info').show();
    $this.find('.alert-info p').html(jQuery('#authdata').val());
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
                $this.find('.alert-success p').html('Success !');
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