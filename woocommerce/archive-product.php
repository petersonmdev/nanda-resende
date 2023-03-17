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
        $price_filter = [
            'relation' => 'OR',
            [
                'key' => '_regular_price',
                'value' => $filter['price'],
                'type' => 'NUMERIC',
                'compare' => '<='
            ],
            [
                'key' => '_sale_price',
                'value' => $filter['price'],
                'type' => 'NUMERIC',
                'compare' => '<='
            ],
        ];
    }else{
        $price_filter = null;
    }
}

$meta_query  = WC()->query->get_meta_query();
$tax_query   = WC()->query->get_tax_query();
$tax_query[] = array(
    'taxonomy' => 'product_visibility',
    'field'    => 'name',
    'terms'    => 'featured',
    'operator' => 'IN',
);

if (!$price_filter && !$product_cat) {
    $params = array(
        'post_type'           => 'product',
        'post_status'         => 'publish',
        'ignore_sticky_posts' => 1,
        'orderby'             => 'rand',
        'meta_query'          => $meta_query,
        'tax_query'           => $tax_query,
    );
} else {
    $params = array(
        'post_type'   => 'product',
        'product_cat' => $product_cat,
        'meta_query'  => $price_filter
    );
}

?>

<!--Main container -->
<section class="section section-nandaresende section-main-container section-products">
    <main role="main" class="container">
        <div class="row">
            <?php get_sidebar( 'filter' ); ?>

            <div class="col-lg-8 col-md-12 container-main container-main-nandaresende">
                <div class="content-all-products">
                    <div class="row align-items-center">

                        <?php $wc_query = new WP_Query($params); ?>

                        <?php if ( $wc_query->have_posts() ) : ?>
                            <?php while ( $wc_query->have_posts() ) :
                                $wc_query->the_post();
                                $product = wc_get_product( get_the_ID() ); ?>
                                <div class="product col col-lg-4 col-6 col-sm-4 col-md-4 mb-4">
                                    <div class="content-img-product">
                                        <?php $woo_prices = woocommerce_prices($product);
                                        if ($woo_prices['on_sale']) { ?>
                                            <span class="badge-sale">Promoção</span>
                                        <?php } ?>
                                        <img class="img-product img-responsive" src="<?php echo get_the_post_thumbnail_url() ?>" alt="Imagem do Produto">
                                        <a class="btn-add-to-cart add_to_cart_button ajax_add_to_cart <?= $product->get_type() == 'simple' ? 'product_type_simple' : 'product_type_variable' ?>" href="<?= $product->get_type() == 'simple' ? '?add-to-cart='.$product->get_id() : $product->get_permalink() ?>" data-quantity="1" data-toggle="tooltip" data-placement="top" title="Add carrinho">Add carrinho</a>
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
                            <?php endwhile; ?>
                        <?php else: ?>
                            <h3 class="col-12 text-center">Nenhum produto encontrado!</h3>
                            <?php wp_reset_postdata(); ?>
                        <?php endif; ?>
                    </div>
                    <nav class="nav-pagination-nandaresende container">
                        <ul class="list-unstyled p-0 row">
                            <li class="col-6 text-left pl-0"><?php previous_posts_link( '&laquo; Anterior', $wc_query->max_num_pages) ?></li>
                            <li class="col-6 text-right pr-0"><?php next_posts_link( 'Próximo &raquo;', $wc_query->max_num_pages) ?></li>
                        </ul>
                    </nav>
                </div>

            </div>
            <!-- /.blog-main -->
        </div>
        <!-- /.row -->
    </main>
    <!--End Main container -->
</section>

<script type="text/javascript">
    var slider = document.getElementById("filterPrice");
    var output = document.getElementById("valuePriceFilter");
    output.innerHTML = slider.value;

    slider.oninput = function() {
        output.innerHTML = this.value;
    };

    jQuery(document).ready(function(){
        $(".cat-filter").click(function(e){
            e.preventDefault();
            $("#cat-filter li > a").removeClass("active");
            $(this).addClass("active");
            var category = $(this).attr('data-selected');
            $("input[name=cat-filter]").val(category);

            $("#form-filter").submit();
        });
        $(".color-filter").click(function(e){
            e.preventDefault();
            $("#color-filter li > a").removeClass("active");
            $(this).addClass("active");
            var color = $(this).attr('data-selected');
            $("input[name=color-filter]").val(color);

            $("#form-filter").submit();
        });
        $("#filterPrice").change(function(event) {
            $("#form-filter").submit();
        });
    });
</script>

<?php get_footer(); ?>


