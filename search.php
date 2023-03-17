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
                $s=get_search_query();
                $args = array('s' =>$s, 'post_type' => 'product');
                // The Query
                $the_query = new WP_Query( $args );
                if ( $the_query->have_posts() ) {
                    _e("<div class='col-12'><h2 class='title-nandaresende text-center mb-3'>Buscar resultados para: ".get_query_var('nanda-resende')."</h2></div>"); ?>

                    <div class="col-12 container-main container-main-nandaresende">
			            <div class="content-all-products">
				            <div class="row align-items-center">
				              	<?php while ( $the_query->have_posts() ) {
	                        		$the_query->the_post(); ?>
		                            <div class="product col-lg-2 col-md-3 col-sm-4 col-6 mb-5 px-2">
                                        <div class="content-img-product">
                                            <?php $woo_prices = woocommerce_prices($product);
                                            if ($woo_prices['on_sale']) { ?>
                                                <span class="badge-sale">Promoção</span>
                                            <?php } ?>
                                            <img class="img-product img-responsive" src="<?php echo get_the_post_thumbnail_url() ?>" alt="Imagem do Produto">
                                            <a class="btn-add-to-cart" href="<?php echo '?add-to-cart='.$product->get_id() ?>" data-quantity="1" data-toggle="tooltip" data-placement="top" title="Add carrinho">Add carrinho</a>
                                        </div>
                                        <div class="category-name py-2"><?php echo $product->get_categories(); ?></div>
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="product-name pt-2"><?php the_title() ?></div>
                                            <div class="content-prices d-flex pb-2 pt-3">
                                                <?php if ($woo_prices['type'] == 'variable') {
                                                    if ($woo_prices['on_sale']) { ?>
                                                        <div class="last-price">R$<?php echo $woo_prices['regular_price'] ?></div>
                                                        <div class="price">R$<?php echo $woo_prices['sale_price'] ?></div>
                                                    <?php } else { ?>
                                                        <div class="price">R$<?php echo $woo_prices['regular_price'] ?></div>
                                                    <?php } ?>
                                                    <?php
                                                } else { ?>
                                                    <?php if ($woo_prices['on_sale']) { ?>
                                                        <div class="last-price"><s>R$ <?php echo $woo_prices['regular_price'] ?></s></div>
                                                        <div class="price">R$<?php echo $woo_prices['sale_price'] ?></div>
                                                    <?php } else { ?>
                                                        <div class="price">R$<?php echo $woo_prices['regular_price'] ?></div>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </a>
                                        <a href="<?php the_permalink(); ?>" class="btn btn-lg btn-nandaresende-first">Comprar</a>
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
