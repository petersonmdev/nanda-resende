(function ($) {

    $('.woocommerce-variation-add-to-cart button.single_add_to_cart_button').removeClass('button');
    $('.woocommerce-variation-add-to-cart button.single_add_to_cart_button').addClass('btn btn-nandaresende-first btn-nandaresende-cta');

    if ( $('.woocommerce-variation-add-to-cart').hasClass('woocommerce-variation-add-to-cart-enabled') ) {
        $('.woocommerce-variation-add-to-cart button.single_add_to_cart_button').addClass('add_to_cart_button');
    } else {
        $('.woocommerce-variation-add-to-cart button.single_add_to_cart_button').removeClass('add_to_cart_button');
    }

    $(document).on('click', '.add-ajax-variation', function (e) {
        $(this).next('.modal-add-cart').modal().css('display', 'block');
        return false;
    });

    $(document).on('click', '.variable_add_to_cart_button', function (e) {
        e.preventDefault();

        $('input.inpt-pa-tamanho[name=variation_id]').click( function () {
            if ( $(this).is(':checked') ) {
                $('.variable_add_to_cart_button').addClass('product_type_simple add_to_cart_button ajax_add_to_cart');
            } else {
                $('.variable_add_to_cart_button').removeClass('product_type_simple add_to_cart_button ajax_add_to_cart');
            }
        });

        if ( ! $('input.inpt-pa-tamanho[name=variation_id]').is(':checked') ) {

            alertify.set({ delay: 1700 });
            alertify.error("Selecione uma opção");

        } else {

            var $thisbutton = $(this),
                $form = $thisbutton.closest('form.cart'),
                id = $thisbutton.val(),
                product_qty = $form.find('input[name=quantity]').val() || 1,
                product_id = $form.find('input[name=product_id]').val() || id,
                variation_id = $form.find('input.inpt-pa-tamanho[name=variation_id]:checked').val() || 0;

            var data = {
                action: 'woocommerce_ajax_add_to_cart',
                product_id: product_id,
                product_sku: '',
                quantity: product_qty,
                variation_id: variation_id,
            };

            $(document.body).trigger('adding_to_cart', [$thisbutton, data]);
            $(document.body).addClass("loading");
            $.ajax({
                type: 'post',
                url: wc_add_to_cart_params.ajax_url,
                data: data,
                beforeSend: function (response) {
                    $thisbutton.removeClass('added').addClass('loading');
                },
                complete: function (response) {
                    $thisbutton.addClass('added').removeClass('loading');
                },
                success: function (response) {

                    if (response.error & response.product_url) {
                        window.location = response.product_url;
                        return;
                    } else {
                        $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                        $(document.body).trigger('wc_fragment_refresh');
                        $(document.body).removeClass("loading");
                        alertify.set({ delay: 1700 });
                        alertify.success("Adicionado ao carrinho!");
                    }
                },
            });

            return false;

        }


    });
    
    $(document).on('click', '.product_type_simple.add_to_cart_button', function (e) {
        e.preventDefault();

        var $thisbutton = $(this),
            $form = $thisbutton.closest('form.cart'),
            id = $thisbutton.val(),
            product_qty = $form.find('input[name=quantity]').val() || 1,
            product_id = $form.find('input[name=product_id]').val() || id,
            variation_id = $form.find('input[name=variation_id]').val() || 0;

        var data = {
            action: 'woocommerce_ajax_add_to_cart',
            product_id: product_id,
            product_sku: '',
            quantity: product_qty,
            variation_id: variation_id,
        };

        $(document.body).trigger('adding_to_cart', [$thisbutton, data]);
        $(document.body).addClass("loading");
        $.ajax({
            type: 'post',
            url: wc_add_to_cart_params.ajax_url,
            data: data,
            beforeSend: function (response) {
                $thisbutton.removeClass('added').addClass('loading');
            },
            complete: function (response) {
                $thisbutton.addClass('added').removeClass('loading');
            },
            success: function (response) {
                console.log(response);
                if (response.error && response.product_url) {
                    //window.location = response.product_url;
                    alertify.notify("Erro ao adicionar produto ao carrinho!", "error", 2);
                    return;
                }

                $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                $(document.body).trigger('wc_fragment_refresh');
                $(document.body).removeClass("loading");
                alertify.notify("Adicionado ao carrinho!", "success", 2);

            },
        });

        return false;
    });

    $(document).on('click', '.remove', function (e) {
        e.preventDefault();

        var data = {
            action: 'woocommerce_ajax_add_to_cart',
        };

        $(document.body).addClass("loading");
        $.ajax({
            type: 'post',
            url: wc_add_to_cart_params.ajax_url,
            data: data,
            success: function (response) {
                if (response.error & response.product_url) {
                    window.location = response.product_url;
                    return;
                } else {
                    $(document.body).removeClass("loading");
                    alertify.notify("Removido do carrinho!", "error", 2);
                }
            },
        });

        return false;
    });
})(jQuery);