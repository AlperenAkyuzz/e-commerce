$(document).ready(function() {

    var sizes = "";
    var size_qty = "";
    var size_price = "";
    var size_key = "";
    var colors = "";
    var total = "";
    var stock = jQuery("#stock").val();
    var keys = "";
    var values = "";
    var prices = "";

    /*-----------------------------
        Cart Page Quantity
    -----------------------------*/
    jQuery(document).on('click', '.qtminus', function () {
        var el = jQuery(this);
        var tselector = el.parent().find('#qty');
        total = jQuery(tselector).val();
        if (total > 1) {
            total--;
        }
        jQuery(tselector).val(total);
    });

    jQuery(document).on('click', '.qtplus', function () {
        var el = jQuery(this);

        var tselector = el.parent().find('#qty');

        total = jQuery(tselector).val();
        if (stock != "") {
            var stk = parseInt(stock);
            if (total < stk) {
                total++;
                jQuery(tselector).val(total);
            }
        } else {
            total++;
        }

        jQuery(tselector).val(total);
    });



    jQuery(document).on('change', '.product-attr', function () {

        var total = 0;
        total = getAmount() + getSizePrice();
        total = total.toFixed(2);
        var pos = jQuery('#curr_pos').val();
        var sign = jQuery('#curr_sign').val();
        if (pos == '0') {
            jQuery('#product-price-48').html(sign + total);
        } else {
            jQuery('#product-price-48').html(total + sign);
        }
    });

    function getSizePrice() {

        var total = 0;
        if (jQuery('.product-size .siz-list li').length > 0) {
            total = parseFloat(jQuery('.product-size .siz-list li.active').find('.size_price').val());
        }

        return total;
    }

    function getAmount() {
        var total = 0;
        var value = parseFloat(jQuery('#product_price').val());
        var datas = jQuery(".product-attr:checked").map(function () {
            return jQuery(this).data('price');
        }).get();

        var data;
        for (data in datas) {
            total += parseFloat(datas[data]);
        }
        total += value;
        return total;
    }

    jQuery(document).on("click", "#addcrt", function () {
        var qty = jQuery('#qty').val();
        var pid = jQuery('.product-container').data('pid');

        if (jQuery('.product-attr').length > 0) {
            values = jQuery(".product-attr:checked").map(function () {
                return jQuery(this).val();
            }).get();

            keys = jQuery(".product-attr:checked").map(function () {
                return jQuery(this).data('key');
            }).get();

            prices = jQuery(".product-attr:checked").map(function () {
                return jQuery(this).data('price');
            }).get();


        }


        jQuery.ajax({
            type: "POST",
            url: mainurl + "/addnumcart",
            data: {
                id: pid,
                qty: qty,
                size: sizes,
                color: colors,
                size_qty: size_qty,
                size_price: size_price,
                size_key: size_key,
                keys: keys,
                values: values,
                prices: prices
            },
            success: function (data) {

                if (data == 'digital') {
                    toastr.error(trans('front.already_cart'));
                    //console.log('already_cart')
                } else if (data == 0) {
                    toastr.error(trans('front.out_of_stock'));
                } else {
                    jQuery(".cart-count").html(data[0]);
                    jQuery(".cart-load").load(mainurl + '/carts/view');
                    toastr.success(trans('front.success_add_cart'));
                }
            },
            error: function() {
                toastr.success(trans('front.error_message'));
            }

        });

    });

    jQuery(document).on('click', '.add-to-wish', function () {
        jQuery.get(jQuery(this).data('href'), function (data) {

            if (data[0] == 1) {
                toastr.success('add_wish');
                c//onsole.log('add_wish')
                jQuery('#wishlist-count').html(data[1]);

            } else {
                //console.log('already_wish')
                toastr.error('already_wish');
            }

        });

        return false;
    });
    
});