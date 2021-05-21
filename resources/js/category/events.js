$(document).ready(function () {

    // when dynamic attribute changes
    $(".attribute-input, #sortby, .vendor-input").on('change', function () {
        $("#CssLoader").show();
        filter();
    });

    // when price changed & clicked in search button
    $(".filter-btn").on('click', function (e) {
        e.preventDefault();
        $("#CssLoader").show();
        filter();
    });
});

function filter() {
    let filterlink = '';

    $(".attribute-input").each(function () {
        if ($(this).is(':checked')) {
            if (filterlink == '') {
                filterlink += routeURI + '?' + $(this).attr('name') + '=' + $(this).val();
            } else {
                filterlink += '&' + $(this).attr('name') + '=' + $(this).val();
            }
        }
    });

    $(".vendor-input").each(function () {
        if ($(this).is(':checked')) {
            if (filterlink == '') {
                filterlink += routeURI + '?' + $(this).attr('name') + '=' + $(this).val();
            } else {
                filterlink += '&' + $(this).attr('name') + '=' + $(this).val();
            }
        }
    });

    if ($("#sortby").val() != '') {
        if (filterlink == '') {
            filterlink += routeURI + '?' + $("#sortby").attr('name') + '=' + $("#sortby").val();
        } else {
            filterlink += '&' + $("#sortby").attr('name') + '=' + $("#sortby").val();
        }
    }

    if ($("#min_price").val() != '') {
        if (filterlink == '') {
            filterlink += routeURI + '?' + $("#min_price").attr('name') + '=' + $("#min_price").val();
        } else {
            filterlink += '&' + $("#min_price").attr('name') + '=' + $("#min_price").val();
        }
    }

    if ($("#max_price").val() != '') {
        if (filterlink == '') {
            filterlink += routeURI + '?' + $("#max_price").attr('name') + '=' + $("#max_price").val();
        } else {
            filterlink += '&' + $("#max_price").attr('name') + '=' + $("#max_price").val();
        }
    }


    //console.log(encodeURI(filterlink));
    $("#ajaxContent").load(encodeURI(filterlink), function (data) {

        $("#CssLoader").fadeOut(1000);
    });
}