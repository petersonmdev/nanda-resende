<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

if( !empty($_GET['categoria']) ){
    $search_filter = true;
    $has_filter = true;
    $filter['category'] = $_GET['categoria'];
    $product_cat = $filter['category'];
}

if( $_POST['has-filter'] == 'true' ){
    $has_filter = true;

    if(!empty($_POST['busca']))
        $filter['s'] = $_POST['busca'];

    if(!empty($_POST['cat-filter'])){
        $filter['category'] = $_POST['cat-filter'];
        $product_cat = $filter['category'];
    }else{
        $product_cat = null;
    }

    if(!empty($_POST['price-filter'])){
        $filter['price'] = $_POST['price-filter'];
        $price_filter = $filter['price'];
    }else{
        $price_filter = null;
    }

}

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 9,
    'paged' => $paged,
    'meta_key'  	=> 'total_sales',
    'orderby'   	=> 'meta_value_num',
    'order' 		=> 'desc',
);

if (!empty($product_cat)) {
    $args['tax_query'] = array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => $product_cat
        )
    );
}

if (is_product_category() || is_product_tag()) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => get_query_var( 'taxonomy' ),
            'field' => 'slug',
            'terms' => get_query_var( 'term' ),
        )
    );
}

if (!empty($price_filter)) {
    $args['meta_query'] = array(
        'relation' => 'OR',
        [
            'key' => '_regular_price',
            'value' => $price_filter,
            'type' => 'NUMERIC',
            'compare' => '<='
        ],
        [
            'key' => '_price',
            'value' => $price_filter,
            'type' => 'NUMERIC',
            'compare' => '<='
        ],
        [
            'key' => '_min_variation_price',
            'value' => $price_filter,
            'type' => 'NUMERIC',
            'compare' => '<='
        ],
        [
            'key' => '_sale_price',
            'value' => $price_filter,
            'type' => 'NUMERIC',
            'compare' => '<='
        ],
    );
}

?>

<?php if ( is_product_category() ) { ?>
    <section class="section section-nandaresende pb-2 pt-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="section-title text-center">
                        <h3><?php woocommerce_page_title(); ?></h3>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<!--Main container -->
<section class="section section-nandaresende section-main-container section-products">
    <main role="main" class="container">
        <div class="row">
            <?php get_sidebar( 'filter' ); ?>

            <div class="col-lg-9 col-md-12 container-main container-main-nandaresende">
                <div class="content-all-products">
                    <div class="row align-items-center">
                        <?php $wc_query = new WP_Query($args);

                        if ( $wc_query->have_posts() ) : ?>
                            <?php while ( $wc_query->have_posts() ) :
                                $wc_query->the_post();
                                $product = wc_get_product( get_the_ID() ); ?>
                                <div class="product col col-lg-4 col-6 col-sm-4 col-md-4 mb-4">
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
                            <?php if($wc_query->max_num_pages > 1) { ?>
                                <div class="col-12">
                                    <?php the_posts_pagination(); ?>
                                </div>
                            <?php } ?>

                        <?php else: ?>
                            <h3 class="col-12 text-center">Nenhum produto encontrado!</h3>
                            <?php wp_reset_postdata(); ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
            <!-- /.blog-main -->
        </div>
        <!-- /.row -->
    </main>
    <!--End Main container -->
</section>

<?php get_footer(); ?>


