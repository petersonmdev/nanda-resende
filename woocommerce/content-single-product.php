<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
$attributes = $product->get_attributes();
$variationId = $product->get_variation_id();
$variableProduct = new WC_Product_Variable($variationId);
$allVariations = $variableProduct->get_available_variations();

$variations_json = wp_json_encode( $allVariations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );


?>
<!--Main container -->
<section class="section section-nandaresende section-product">
    <div class="container">
        <div class="row">
            <div class="col d-lg-block d-none carousel-vertical">
                <ul class="list-unstyled nav nav-tabs" id="myTab" role="tablist">
                    <li class="d-block nav-item" data-target="#productSimple" data-slide-to="0">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#img0" role="tab" aria-controls="img0" aria-selected="true">
                            <img src="<?= (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : 'https://via.placeholder.com/300x300&text=@nandaresendejoias' ?>" alt="images" class="img-responsive img-product">
                        </a>
                    </li>
                    <?php
                        $gallery_ids = $product->get_gallery_image_ids();
                        $i = 1;
                        foreach( $gallery_ids as $gallery_id ) {
                            $image_link = wp_get_attachment_url( $gallery_id ); ?>
                            <li class="d-block nav-item" data-target="#productSimple" data-slide-to="<?php echo$i ?>">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#img<?php echo $i ?>" role="tab" aria-controls="img<?php echo$i?>" aria-selected="true">
                                    <img src="<?php echo$image_link?>" alt="images" class="img-responsive img-product">
                                </a>
                            </li>
                    <?php $i++; } ?>
                </ul>
            </div>
            <div class="col-xs-5 col-lg-5 col-md-6 col-sm-12 image-product d-flex mb-5">
                <div id="productSimple" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#productSimple" data-slide-to="0" class="active"></li>
                        <?php $i=1; foreach( $gallery_ids as $gallery_id ) : ?>
                            <li data-target="#productSimple" data-slide-to="<?php echo$i?>" class=""></li>
                        <?php $i++; endforeach; ?>
                    </ol>
                    <div class="carousel-inner tab-content">
                        <div class="carousel-item tab-pane active" id="img0">
                            <figure class="zoom d-block w-100" style="background-image: url(<?php echo get_the_post_thumbnail_url() ?>)">
                                <img src="<?= (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : 'https://via.placeholder.com/600x600&text=@nandaresendejoias' ?>" alt="img0">
                            </figure>
                        </div>
                        <?php $i=1; foreach( $gallery_ids as $gallery_id ) :
                            $image_link = wp_get_attachment_url( $gallery_id );
                        ?>
                            <div class="carousel-item tab-pane" id="img<?php echo$i?>">
                                <figure class="zoom d-block w-100" style="background-image: url(<?php echo $image_link; ?>)">
                                    <img src="<?php echo $image_link; ?>" alt="img<?php echo$i?>">
                                </figure>
                            </div>
                        <?php $i++; endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#productSimple" role="button" data-slide="prev">
                        <span class="icons-arrow-point-to-right" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#productSimple" role="button" data-slide="next">
                        <span class="icons-arrow-point-to-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-xs-5 col-lg-5 col-md-6 col-sm-12 content-information-product">
                <?php if (!$product->is_type( 'variable' )) : ?>
                <form class="cart" action="<?php home_url( 'carrinho/' ); ?>" method="post" enctype="multipart/form-data">
                    <?php endif; ?>
                    <div class="content-title-product mb-2">
                        <h3 class="title-product"><?php echo $product->get_name(); ?></h3>
                        <h6 class="reference-product"><?php echo $product->get_sku() ? $product->get_sku() : ''; ?></h6>
                    </div>
                    <div class="content-price-product mb-4">
                        <div class="text-price-product mb-4 pb-3">
                            <?php $the_product = woocommerce_prices($product);
                            if ($the_product['type'] == 'simple' ) {
                                if($the_product['on_sale']){ ?>
                                    <?= ($the_product['on_sale']) ? '<span class="seal-variation-sale">Produto em promoção</span>' : '' ?>
                                    <h3 class="last-price"><s>R$<?php echo number_format($the_product['regular_price'], 2, ',', ''); ?></s></h3>
                                    <h1 class="price">R$<?php echo number_format($the_product['sale_price'], 2, ',', ''); ?></h1>
                                <?php }else{ ?>
                                    <h1 class="price">R$<?php echo number_format($the_product['regular_price'], 2, ',', ''); ?></h1>
                                <?php } ?>
                                <?php
                            } else { ?>
                                <h1 class="price price-variation"><?php echo do_shortcode('[product_price]'); ?></h1>
                            <?php } ?>
                            <span class="d-block pt-3"><?php the_excerpt(); ?></span>
                        </div>
                    </div>
                    <?php do_action('woocommerce_before_add_to_cart_button'); ?>
                    <?php if ($product->is_type( 'variable' )) : ?>
                        <?php woocommerce_template_single_add_to_cart(); ?>
                    <?php else : ?>
                    <div class="quantity">
                        <label class="screen-reader-text" for="quantity"><?php echo $product->get_name(); ?> quantidade</label>
                        <input type="hidden" id="quantity" class="input-text qty text" name="quantity" value="1" title="Qtd">
                    </div>

                    <?php
                    if($product->get_stock_quantity()==0) {
                        echo '<p class="pt-2 col-12 panel text-center no-stock-msg">Infelizmente estamos sem estoque :(</p>';
                    }
                    ?>
                    <div class="cta-product">
                        <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="btn btn-lg btn-nandaresende-first" <?php echo ($product->get_stock_quantity()==0) ? 'disabled="disabled"' : '' ?>>Comprar</button>
                    </div>
                </form>
            <?php endif; ?>
                <?php do_action('woocommerce_after_add_to_cart_button'); ?>

            </div>
        </div>

        <div class="row">
            <div class="col-12 description-product mt-4">
                <div class="product-post">
                    <h2 class="product-post-title py-3 mb-3">Descrição do produto</h2>
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-products-featured section section-nandaresende">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-12">
        <div class="section-title my-4">
          <h3>Talvez você goste</h3>
        </div>
      </div>
      <div class="d-lg-block col-md-12 carousel-mobile-nandaresende">
        <div id="interesse" class="owl-carousel owl-theme owl-loaded owl-drag">
          <?php
          $params = array(
              'posts_per_page' => 15,
              'post_type' => 'product',
              'meta_key' => 'total_sales',
              'orderby'   	=> 'meta_value_num',
              'order' 		=> 'desc'
          );
          $wc_query = new WP_Query($params);
          while( $wc_query->have_posts() ) : 
            $wc_query->the_post();
            $product = wc_get_product(get_the_ID());?>
            <div class="item">
                <div class="product mb-5">
                    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
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
                    <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
                </div>
            </div>
          <?php endwhile;
          wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
    jQuery(document).ready(function(){
        $('.btn-pa_tamanho').prop("required", true);
        $(".btn-pa_tamanho").click(function(){
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $(this).removeAttr('style');
                return;
            }
            $(this).addClass('active');
            $('.btn-pa_tamanho').removeAttr('style');
            var tamanho = $(this).attr("id");
            $("#pa_tamanho").val(tamanho);
            $(this).css({'background':'#64b161', 'color':'#fff'});
        });
    });
</script>