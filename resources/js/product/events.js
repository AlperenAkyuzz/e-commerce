$(document).ready(function() {

    var sizes = "";
    var size_qty = "";
    var size_price = "";
    var size_key = "";
    var colors = "";
    var total = "";
    var stock = $("#stock").val();
    var keys = "";
    var values = "";
    var prices = "";

    /*-----------------------------
        Cart Page Quantity
    -----------------------------*/
    $(document).on('click', '.qtminus', function () {
        var el = $(this);
        var tselector = el.parent().find('#qty');
        total = $(tselector).val();
        if (total > 1) {
            total--;
        }
        $(tselector).val(total);
    });

    $(document).on('click', '.qtplus', function () {
        var el = $(this);

        var tselector = el.parent().find('#qty');

        total = $(tselector).val();
        if (stock != "") {
            var stk = parseInt(stock);
            if (total < stk) {
                total++;
                $(tselector).val(total);
            }
        } else {
            total++;
        }

        $(tselector).val(total);
    });



    $(document).on('change', '.product-attr', function () {

        var total = 0;
        total = getAmount() + getSizePrice();
        total = total.toFixed(2);
        var pos = $('#curr_pos').val();
        var sign = $('#curr_sign').val();
        if (pos == '0') {
            $('#product-price-48').html(sign + total);
        } else {
            $('#product-price-48').html(total + sign);
        }
    });

    function getSizePrice() {

        var total = 0;
        if ($('.product-size .siz-list li').length > 0) {
            total = parseFloat($('.product-size .siz-list li.active').find('.size_price').val());
        }

        return total;
    }

    function getAmount() {
        var total = 0;
        var value = parseFloat($('#product_price').val());
        var datas = $(".product-attr:checked").map(function () {
            return $(this).data('price');
        }).get();

        var data;
        for (data in datas) {
            total += parseFloat(datas[data]);
        }
        total += value;
        return total;
    }

    // add to cart in product detail page
    $(document).on("click", "#addcrt", function () {
        var qty = $('#qty').val();
        var pid = $('.product-container').data('pid');

        if ($('.product-attr').length > 0) {
            values = $(".product-attr:checked").map(function () {
                return $(this).val();
            }).get();

            keys = $(".product-attr:checked").map(function () {
                return $(this).data('key');
            }).get();

            prices = $(".product-attr:checked").map(function () {
                return $(this).data('price');
            }).get();


        }


        $.ajax({
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
                    $(".cart-count").html(data[0]);
                    $(".cart-load").load(mainurl + '/carts/view');
                    toastr.success(trans('front.success_add_cart'));
                }
            },
            error: function() {
                toastr.success(trans('front.error_message'));
            }

        });

    });

    // Add to Wishlist

    $(document).on('click', '.add-to-wish', function () {
        $.get($(this).data('href'), function (data) {

            if (data[0] == 1) {
                toastr.success(trans('front.add_wish'));
                console.log('add_wish')
                $('#wishlist-count').html(data[1]);

            } else {
                //console.log('already_wish')
                toastr.error(trans('front.already_wish'));
            }

        });

        return false;
    });

    // Add cart product general function
    $(document).on('click', '.add-to-cart', function () {
        $.post($(this).data('href'), function (data) {

            if (data == 'digital') {
                toastr.error(trans('front.already_cart'));
            } else if (data == 0) {
                toastr.error(trans('front.out_of_stock'));
            } else {
                $(".cart-count").html(data[0]);
                $(".cart-load").load(mainurl + '/carts/view');

                toastr.success(trans('front.success_add_cart'));
            }
        });
        return false;
    });

    // Remove cart function

    $(document).on('click', '.cart-remove', function () {
        var $selector = $(this).data('class');
        $('.' + $selector).hide();
        $.get($(this).data('href'), function (data) {
            if (data == 0) {
                $(".cart-count").html(data);
                $('.cart-table').html('<h3 class="mt-1 pl-3 text-left">Cart is empty.</h3>');
                $('#cart-items').html('<p class="mt-1 pl-3 text-left">Cart is empty.</p>');
                $('.cart-load').html('');
                $('.cartpage .col-lg-4').html('');
            } else {
                $('.cart-quantity').html(data[1]);
                $("#cart-total").html(data[0]);
                $("#main-total").html(data[5]);
                $('.coupon-total').val(data[0]);
                if(data[6] == "0")  {
                    $("#cargo-price").html(trans('front.free_cargo'));
                } else {
                    $("#cargo-price").html('₺'+data[6]);
                }
            }

        });
    });

    // Cart Functions
    // Adding
    $(document).on("click", ".adding", function () {

        $("#CssLoader").show();

        var pid = $(this).parent().parent().parent().parent().find('.prodid').val();
        var itemid = $(this).parent().parent().parent().parent().find('.itemid').val();
        var size_qty = $(this).parent().parent().parent().parent().find('.size_qty').val();
        var size_price = $(this).parent().parent().parent().parent().find('.size_price').val();
        var stck = $("#stock" + itemid).val();
        var qty = $("#qty" + itemid).val();
        if (stck != "") {
            var stk = parseInt(stck);
            if (qty < stk) {
                qty++;
                $("#qty" + itemid).val(qty);
            }
        } else {
            qty++;
            $("#qty" + itemid).val(qty);
        }

        if(qty > 1) {
            $('.reducing').removeAttr('disabled');
        } else {
            $('.reducing').attr('disabled', true);
        }

        $.ajax({
            type: "POST",
            url: mainurl + "/addbyone",
            data: {id: pid, itemid: itemid, size_qty: size_qty, size_price: size_price},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                if (data == 0) {
                } else {
                    $(".discount").html($("#d-val").val());
                    $("#cart-total").html(data[0]);
                    $("#main-total").html(data[5]);
                    $(".coupon-total").val(data[3]);
                    $("#prc" + itemid).html(data[2]);
                    $("#prct" + itemid).html(data[4]);
                    $("#cqt" + itemid).html(data[1]);
                    $("#qty" + itemid).val(data[1]);
                    if(data[6] == "0")  {
                        $("#cargo-price").html(trans('front.free_cargo'));
                    } else {
                        $("#cargo-price").html('₺'+data[6]);
                    }
                }

                $("#CssLoader").hide();
            }
        });
    });

    // Reducing
    $(document).on("click", ".reducing", function () {

        var pid = $(this).parent().parent().parent().parent().find('.prodid').val();
        var itemid = $(this).parent().parent().parent().parent().find('.itemid').val();
        var size_qty = $(this).parent().parent().parent().parent().find('.size_qty').val();
        var size_price = $(this).parent().parent().parent().parent().find('.size_price').val();
        var stck = $("#stock" + itemid).val();
        var qty = $("#qty" + itemid).val();
        qty--;


        if (qty < 1) {
            $("#qty" + itemid).val("1");
        } else {
            $("#CssLoader").show();
            $("#qty" + itemid).val(qty);
            $.ajax({
                type: "POST",
                url: mainurl + "/reducebyone",
                data: {id: pid, itemid: itemid, size_qty: size_qty, size_price: size_price},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $(".discount").html($("#d-val").val());
                    $("#cart-total").html(data[0]);
                    $("#main-total").html(data[5]);
                    $(".coupon-total").val(data[3]);
                    $("#prc" + itemid).html(data[2]);
                    $("#prct" + itemid).html(data[4]);
                    $("#cqt" + itemid).html(data[1]);
                    $("#qty" + itemid).val(data[1]);
                    if(data[6] == "0")  {
                        $("#cargo-price").html(trans('front.free_cargo'));
                    } else {
                        $("#cargo-price").html('₺'+data[6]);
                    }


                    $("#CssLoader").hide();
                }
            });
        }
    });


    
});