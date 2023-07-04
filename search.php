<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Nanda_Resende
 */

get_header();
?>

	<!-- Breadcrumb -->
    <div class="breadcrumb-nandaresende">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <?php woocommerce_breadcrumb(); ?>
          </div>
        </div>
      </div>      
    </div>
    <!-- End breadcrumb -->

    <!--Main container -->
    <section class="section section-nandaresende section-main-container section-products">
      	<main role="main" class="container">
        	<div class="row">

                <?php

                if ( have_posts() ) {
                    _e("<div class='col-12'><h2 class='title-nandaresende text-center mb-3'>Buscar resultados para: ".get_search_query('nanda-resende')."</h2></div>"); ?>

                    <div class="col-12">
                        <div class="search-result-count default-max-width pb-4">
                            <?php
                            printf(
                                esc_html(
                                /* translators: %d: The number of search results. */
                                    _n(
                                        'We found %d result for your search.',
                                        'We found %d results for your search.',
                                        (int) $wp_query->found_posts,
                                        'twentytwentyone'
                                    )
                                ),
                                (int) $wp_query->found_posts
                            );
                            ?>
                        </div>                    </div>
                    <div class="col-12 container-main container-main-nandaresende">
			            <div class="content-all-products">
				            <div class="row align-items-center">
				              	<?php while ( have_posts() ) {
	                        		the_post();
                                    $product = wc_get_product(get_the_ID()); ?>

		                            <div class="product col-lg-2 col-md-3 col-sm-4 col-6 mb-5 px-2">
                                        <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
                                        <div class="content-img-product">
                                            <?php $woo_prices = woocommerce_prices($product);
                                            if ($woo_prices['on_sale']) {
                                                $off = 100-($woo_prices['sale_price']*100)/$woo_prices['regular_price'];?>
                                                <span class="badge-sale"><?= "$off% OFF" ?></span>
                                            <?php } ?>
                                            <img class="img-product img-responsive" src="<?= (get_the_post_thumbnail_url()) ? get_the_post_thumbnail_url() : 'https://via.placeholder.com/300x300&text=@nandaresendejoias' ?>" alt="Imagem do Produto">
                                            <a class="btn-add-to-cart add_to_cart_button ajax_add_to_cart <?= $product->get_type() == 'simple' ? 'product_type_simple' : 'product_type_variable' ?>" href="<?= $product->get_type() == 'simple' ? '?add-to-cart='.$product->get_id() : $product->get_permalink() ?>" data-quantity="1" data-toggle="tooltip" data-placement="top" title="Add carrinho">Add carrinho</a>
                                        </div>
                                        <div class="category-name py-2"><?php echo $product->get_categories(); ?></div>
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="product-name pt-2"><?php the_title() ?></div>
                                            <div class="content-prices d-flex pb-2 pt-3">
                                                <?php if ($woo_prices['type'] == 'variable') { ?>
                                                    <div class="price price-variation">
                                                        <?php echo do_shortcode('[product_price]'); ?>
                                                        <?php if ($woo_prices['on_sale']) { ?>
                                                            <small class="installment w-100">ou 3x de R$<?php echo number_format((float)$woo_prices['sale_price']/3, 2, ',', ''); ?></small>
                                                        <?php } else { ?>
                                                            <small class="installment w-100">ou 3x de R$<?php echo number_format((float)$woo_prices['regular_price']/3, 2, ',', ''); ?></small>
                                                        <?php } ?>
                                                    </div>
                                                <?php } else { ?>
                                                    <?php if ($woo_prices['on_sale']) { ?>
                                                        <div class="last-price"><s>R$ <?php echo number_format((float)$woo_prices['regular_price'], 2, ',', ''); ?></s></div>
                                                        <div class="price">R$<?php echo number_format((float)$woo_prices['sale_price'], 2, ',', ''); ?></div>
                                                        <div class="installment w-100">ou 3x de R$<?php echo number_format((float)$woo_prices['sale_price']/3, 2, ',', ''); ?></div>
                                                    <?php } else { ?>
                                                        <div class="price">R$<?php echo number_format((float)$woo_prices['regular_price'], 2, ',', ''); ?></div>
                                                        <div class="installment">ou 3x de R$<?php echo number_format((float)$woo_prices['regular_price']/3, 2, ',', ''); ?></div>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </a>
                                        <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
                                        <!--<a href="<?php /*the_permalink(); */?>" class="btn btn-lg btn-nandaresende-first">Comprar</a>-->
				                    </div>
				                <?php } ?>
			                </div>
		                </div>
		            </div>
		        <?php } else { ?>
	            	<div class="col-12">
	            		<h2 class="title-nandaresende text-center mb-3">Nada encontrado!</h2>
	                    <div class="alert alert-info">
	                      <p>Desculpe, mas nada corresponde aos seus critérios de busca. Por favor, tente novamente com algumas palavras-chave diferentes.</p>
	                    </div>
	            	</div>
                <?php } ?>
            </div>
        </main>
    </section>

<?php get_footer();
