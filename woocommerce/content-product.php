<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>
<li <?php wc_product_class( 'product', $product ); ?>>
    <?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' ); ?>
    <div class="content-img-product">
        <?php $woo_prices = woocommerce_prices($product);
        if ($woo_prices['on_sale']) { ?>
            <span class="badge-sale">Promoção</span>
        <?php } ?>
        <img class="img-product img-responsive" src="<?= (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : 'https://via.placeholder.com/300x300&text=@nandaresendejoias' ?>" alt="Imagem do Produto">
        <a class="btn-add-to-cart add_to_cart_button ajax_add_to_cart <?= $product->get_type() == 'simple' ? 'product_type_simple' : 'product_type_variable' ?>" href="<?= $product->get_type() == 'simple' ? '?add-to-cart='.$product->get_id() : $product->get_permalink() ?>" data-quantity="1" data-toggle="tooltip" data-placement="top" title="Add carrinho">Add carrinho</a>
    </div>
    <div class="category-name py-2"><?php echo $product->get_categories(); ?></div>
    <a href="<?php the_permalink(); ?>">
        <div class="product-name pt-2"><?php the_title() ?></div>
        <div class="content-prices d-flex pb-2 pt-3">
            <?php if ($woo_prices['type'] == 'variable') { ?>
                <div class="price price-variation"><?php echo do_shortcode('[product_price]'); ?></div>
            <?php } else { ?>
                <?php if ($woo_prices['on_sale']) { ?>
                    <div class="last-price"><s>R$ <?php echo $woo_prices['regular_price'] ?></s></div>
                    <div class="price">R$<?php echo $woo_prices['sale_price'] ?></div>
                <?php } else { ?>
                    <div class="price">R$<?php echo $woo_prices['regular_price'] ?></div>
                <?php } ?>
            <?php } ?>
        </div>
    </a>


    <?php
    /**
     * Hook: woocommerce_after_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_close - 5
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */
    do_action( 'woocommerce_after_shop_loop_item' ); ?>
</li>