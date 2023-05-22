(function($) {

    jQuery(document).ready(function ($) {

        $('label[for="billing_address_2"]').removeClass('screen-reader-text');

        $('#billing_email').on('blur', function(event) {
            event.preventDefault();
            var data = {
                action: 'update_billing_email',
                email: $(this).val()
            }

            $.ajax({
                type: 'POST',
                url: wc_checkout_params.ajax_url,
                data: data,
                success: function(response) {
                    $('body').trigger('update_checkout');
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

    });

})(window.jQuery);