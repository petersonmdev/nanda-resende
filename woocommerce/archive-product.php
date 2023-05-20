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
                        <div class="container">
                            <?php $wc_query = new WP_Query($args);

                            if ( $wc_query->have_posts() ) :
                                /**
                                 * Hook: woocommerce_before_shop_loop.
                                 *
                                 * @hooked woocommerce_output_all_notices - 10
                                 * @hooked woocommerce_result_count - 20
                                 * @hooked woocommerce_catalog_ordering - 30
                                 */
                                do_action( 'woocommerce_before_shop_loop' );

                                woocommerce_product_loop_start();

                                if ( wc_get_loop_prop( 'total' ) ) {
                                    while ( have_posts() ) {
                                        the_post();

                                        /**
                                         * Hook: woocommerce_shop_loop.
                                         */
                                        do_action( 'woocommerce_shop_loop' );

                                        wc_get_template_part( 'content', 'product' );
                                    }
                                }

                                woocommerce_product_loop_end(); ?>

                                <?php
                                /**
                                 * Hook: woocommerce_after_shop_loop.
                                 *
                                 * @hooked woocommerce_pagination - 10
                                 */
                                do_action( 'woocommerce_after_shop_loop' ); ?>

                            <?php else: ?>
                                <h3 class="col-12 text-center">Nenhum produto encontrado!</h3>
                                <?php wp_reset_postdata(); ?>
                            <?php endif; ?>
                        </div>
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


