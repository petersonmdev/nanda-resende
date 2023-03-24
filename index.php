<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Nanda_Resende
 */

get_header();
?>

<!--=================================
    =            Page Slider            =
    ==================================-->
<div class="container">
    <div class="hero-slider slider-nandaresende d-none d-lg-block">
      <?php if (get_field('slides_desktop', 'option')) : ?>
        <?php while (the_repeater_field('slides_desktop', 'option')) : ?>
          <div class="slider-item slide1" style="background-image:url('<?php echo get_sub_field('imagem'); ?>')">
            <div class="container">
              <div class="row">
                <div class="col-12">
                  <!-- Slide Content Start-->
                  <div class="content style text-left content-text-slider">
                    <?php if (get_sub_field('texto1')) : ?> <h2 class="text-destaque"><?php echo get_sub_field('texto1'); ?></h2> <?php endif; ?>
                    <?php if (get_sub_field('texto2')) : ?> <p class="tag-text"><?php echo get_sub_field('texto2'); ?></p> <?php endif; ?>
                    <?php if (get_sub_field('texto3')) : ?> <span class="text-bg"><?php echo get_sub_field('texto3'); ?></span> <?php endif; ?>
                  </div>
                  <!-- Slide Content End-->
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
</div>

<!--## BANNER MOBILE ##-->
<div class="container">
    <div class="hero-slider slider-nandaresende d-lg-none">
      <?php if (get_field('slides_desktop', 'option')) : ?>
        <?php while (the_repeater_field('slides_mobile', 'option')) : ?>
          <div class="slider-item slide1" style="background-image:url(<?php echo get_sub_field('imagem'); ?>)">
            <div class="container">
              <div class="row">
                <div class="col-12">
                  <!-- Slide Content Start-->
                  <div class="content style text-left content-text-slider">
                    <?php if (get_sub_field('texto1')) : ?> <h2 class="text-destaque"><?php echo get_sub_field('texto1'); ?></h2> <?php endif; ?>
                    <?php if (get_sub_field('texto2')) : ?> <p class="tag-text"><?php echo get_sub_field('texto2'); ?></p> <?php endif; ?>
                    <?php if (get_sub_field('texto3')) : ?> <span class="text-bg"><?php echo get_sub_field('texto3'); ?></span> <?php endif; ?>
                  </div>
                  <!-- Slide Content End-->
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>
</div>

<!--====  End of Page Slider  ====-->

<section class="section-products-featured section section-nandaresende">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-12">
        <div class="section-title my-5">
          <h3>Destaques</h3>
        </div>
      </div>
      <div class="d-none d-lg-flex">
            <?php
            $meta_query  = WC()->query->get_meta_query();
            $tax_query   = WC()->query->get_tax_query();
            $tax_query[] = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
                'operator' => 'IN',
            );

            $params = array(
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'showposts'           => 4,
                'ignore_sticky_posts' => 1,
                'posts_per_page'      => $atts['per_page'],
                'orderby'             => 'rand',
                'order'               => $atts['order'],
                'meta_query'          => $meta_query,
                'tax_query'           => $tax_query,
            );
            $wc_query = new WP_Query($params); ?>
            <?php if ($wc_query->have_posts()) : ?>
              <?php while ($wc_query->have_posts()) :
                $wc_query->the_post();
                $product = wc_get_product(get_the_ID()); ?>

                <div class="col-3 product mb-5">
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
                    <a href="<?php the_permalink(); ?>" class="btn btn-lg btn-nandaresende-first">Comprar</a>
                </div>
              <?php endwhile; ?>
              <?php wp_reset_postdata(); ?>
            <?php endif; ?>
          </div>
      </div>
      <div class="d-md-block col-md-12 d-lg-none carousel-mobile-nandaresende">
        <div id="destaques" class="owl-carousel owl-theme owl-loaded owl-drag">
          <?php
          $meta_query  = WC()->query->get_meta_query();
          $tax_query   = WC()->query->get_tax_query();
          $tax_query[] = array(
              'taxonomy' => 'product_visibility',
              'field'    => 'name',
              'terms'    => 'featured',
              'operator' => 'IN',
          );

          $params = array(
              'post_type'           => 'product',
              'post_status'         => 'publish',
              'showposts'           => 15,
              'ignore_sticky_posts' => 1,
              'posts_per_page'      => $atts['per_page'],
              'orderby'             => 'rand',
              'order'               => $atts['order'],
              'meta_query'          => $meta_query,
              'tax_query'           => $tax_query,
          );
          $wc_query = new WP_Query($params);
          while ($wc_query->have_posts()) :
            $wc_query->the_post();
            $product = wc_get_product(get_the_ID()); ?>
            <div class="item">
                <div class="product mb-5">
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
                    <a href="<?php the_permalink(); ?>" class="btn btn-lg btn-nandaresende-first">Comprar</a>
                </div>
            </div>
          <?php endwhile;
          wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-products-featured section section-nandaresende">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-12">
        <div class="section-title my-5">
          <h3>Lançamentos</h3>
        </div>
      </div>
      <div class="d-none d-lg-flex">
        <?php
        $params = array('posts_per_page' => 4, 'post_type' => 'product', 'orderby' => 'DESC', 'meta_value' => '0', 'meta_compare' => '>=');
        $wc_query = new WP_Query($params); ?>
        <?php if ($wc_query->have_posts()) : ?>
          <?php while ($wc_query->have_posts()) :
            $wc_query->the_post();
            $product = wc_get_product(get_the_ID()); ?>
            <div class="col-3 product mb-5">
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
                <a href="<?php the_permalink(); ?>" class="btn btn-lg btn-nandaresende-first">Comprar</a>
            </div>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php endif; ?>
      </div>
      <div class="d-md-block col-md-12 d-lg-none carousel-mobile-nandaresende">
        <div id="lancamentos" class="owl-carousel owl-theme owl-loaded owl-drag">
          <?php
          $params = array('posts_per_page' => 15, 'post_type' => 'product', 'orderby' => 'DESC');
          $wc_query = new WP_Query($params);
          while ($wc_query->have_posts()) :
            $wc_query->the_post();
            $product = wc_get_product(get_the_ID()); ?>
            <div class="item">
                <div class="product mb-5">
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
                    <a href="<?php the_permalink(); ?>" class="btn btn-lg btn-nandaresende-first">Comprar</a>
                </div>
            </div>
          <?php endwhile;
          wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-products-featured section section-nandaresende">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-12">
        <div class="section-title my-5">
          <h3>Os queridinhos</h3>
        </div>
      </div>
      <div class="d-none d-lg-flex">
        <?php
        $params = array(
          'posts_per_page' => 4,
          'post_type' => 'product',
          'orderby' => 'rand',
          'meta_query' => array(
            array(
                'key' => '_stock_status',
                'value' => 'instock'
            )
          )
        );
        $wc_query = new WP_Query($params); ?>
        <?php if ($wc_query->have_posts()) : ?>
          <?php while ($wc_query->have_posts()) :
            $wc_query->the_post();
            $product = wc_get_product(get_the_ID()); ?>
            <div class="col-3 product mb-5">
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
                <a href="<?php the_permalink(); ?>" class="btn btn-lg btn-nandaresende-first">Comprar</a>
            </div>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php endif; ?>
      </div>
      <div class="d-md-block col-md-12 d-lg-none carousel-mobile-nandaresende">
        <div id="maisvistos" class="owl-carousel owl-theme owl-loaded owl-drag">
          <?php
          $params = array('posts_per_page' => 15, 'post_type' => 'product', 'orderby' => 'asc');
          $wc_query = new WP_Query($params);
          while ($wc_query->have_posts()) :
            $wc_query->the_post();
            $product = wc_get_product(get_the_ID()); ?>
            <div class="item">
                <div class="product mb-5">
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
                    <a href="<?php the_permalink(); ?>" class="btn btn-lg btn-nandaresende-first">Comprar</a>
                </div>
            </div>
          <?php endwhile;
          wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  jQuery(document).ready(function() {
    $(".btn-filter").click(function() {
      var filter = $(this).attr('data-filter');
      $("#input-price-filter").val(filter);
      $("#form-price-filter").submit();
    });
  });
</script>

<?php get_footer(); ?>