<?php
/**
 * Nanda Resende functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package nanda_resende
 */

if ( ! isset( $content_width ) ) {
	$content_width = 600;
}

if ( ! function_exists( 'nanda_resende_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function nanda_resende_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Nanda Resende, use a find and replace
		 * to change 'nanda-resende' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'nanda-resende', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'nanda-resende' ),
        ) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'nanda_resende_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 68,
			'width'       => 130,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'nanda_resende_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function nanda_resende_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Filter Sidebar', 'nanda-resende' ),
		'id'            => 'filter',
		'description'   => esc_html__( 'Add widgets here.', 'nanda-resende' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'nanda_resende_widgets_init' );

/**
 * Enqueue scripts and styles.
 */

function nanda_resende_scripts() {
    wp_enqueue_style( 'nanda-resende-slick', get_template_directory_uri() . '/plugins/slick/slick.css', array(), '1.0', 'all' );
    wp_enqueue_style( 'nanda-resende-slick-theme', get_template_directory_uri() . '/plugins/slick/slick-theme.css', array(), '1.0', 'all' );
    wp_enqueue_style( 'nanda-resende-fancybox', get_template_directory_uri() . '/plugins/fancybox/jquery.fancybox.min.css', array(), '1.0', 'all' );
    wp_enqueue_style( 'nanda-resende-bootstrap', get_template_directory_uri() . '/plugins/bootstrap.min.css', array(), '4.4.1', 'all' );
    wp_enqueue_style( 'nanda-resende-animate', get_template_directory_uri() . '/plugins/animate.min.css', array(), '3.5.0', 'all' );
    wp_enqueue_style( 'nanda-resende-owl', get_template_directory_uri() . '/plugins/owlcarousel/owl.carousel.min.css', array(), '2.3.4', 'all' );
    wp_enqueue_style( 'nanda-resende-owl-theme', get_template_directory_uri() . '/plugins/owlcarousel/owl.theme.default.min.css', array(), '2.3.4', 'all' );
    wp_enqueue_style( 'nanda-resende-style-theme', get_template_directory_uri() . '/css/style.css', array(), '1.0', 'all' );
    wp_enqueue_style( 'nanda-resende-main', get_template_directory_uri() . '/css/nandaresendejoias.css', array(), '1.0', 'all' );
    wp_enqueue_style( 'nanda-resende-fontawesome', get_template_directory_uri() . '/css/fontawesome.min.all.css', array(), '5.11.1', 'all' );
    wp_enqueue_style( 'nanda-resende-checkout', get_template_directory_uri() . '/css/checkout-v3.css', array(), '2.0', 'all' );
    
    wp_enqueue_style( 'nanda-resende-style', get_stylesheet_uri() );

    if(!is_checkout()) {
        wp_enqueue_script( 'nanda-resende-jquery', get_template_directory_uri() . '/plugins/jquery.js', array(), '3.4.1', true );
        wp_enqueue_script( 'nanda-resende-lettering', get_template_directory_uri() . '/plugins/jquery.lettering.js', array(), '0.6.1', true );
        wp_enqueue_script( 'nanda-resende-loadie', get_template_directory_uri() . '/plugins/jquery.loadie.min.js', array(), '1.0', true );
        wp_enqueue_script( 'nanda-resende-popper', get_template_directory_uri() . '/plugins/popper.min.js', array(), '1.0', true );
        wp_enqueue_script( 'nanda-resende-bootstrap', get_template_directory_uri() . '/plugins/bootstrap.min.js', array(), '4.3.1', true );
        wp_enqueue_script( 'nanda-resende-bootstrap-select', get_template_directory_uri() . '/plugins/bootstrap-select.min.js', array(), '1.11.0', true );
        wp_enqueue_script( 'nanda-resende-foundation', get_template_directory_uri() . '/plugins/foundation.js', array(), '1.0', true );
        wp_enqueue_script( 'nanda-resende-owl', get_template_directory_uri() . '/plugins/owlcarousel/owl.carousel.min.js', array(), '2.3.4', true );
        wp_enqueue_script( 'nanda-resende-slick', get_template_directory_uri() . '/plugins/slick/slick.min.js', array(), '1.0', true );
        wp_enqueue_script( 'nanda-resende-fancybox', get_template_directory_uri() . '/plugins/fancybox/jquery.fancybox.min.js', array(), '3.2.10', true );
        wp_enqueue_script( 'nanda-resende-zoom', get_template_directory_uri() . '/plugins/jquery.zoom.min.js', array(), '1.7.21', true );
        wp_enqueue_script( 'nanda-resende-wow', get_template_directory_uri() . '/plugins/wow.js', array(), '1.0.1', true );
        wp_enqueue_script( 'nanda-resende-jquery-ui', get_template_directory_uri() . '/plugins/jquery-ui.js', array(), '1.11.4', true );
        wp_enqueue_script( 'nanda-resende-timePicker', get_template_directory_uri() . '/plugins/timePicker.js', array(), '0.8', true );
        wp_enqueue_script( 'nanda-resende-script', get_template_directory_uri() . '/js/script.js', array(), '1.0', true );
    }

    wp_enqueue_script( 'nanda-resende-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );
    wp_enqueue_script( 'nanda-resende-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '1.0', true );
    wp_enqueue_script( 'nanda-resende-autocomplete-address', get_template_directory_uri() . '/js/autocomplete-address.js', array('jquery'), '1.0', true );
    
    // wp_enqueue_script('woocommerce-ajax-add-to-cart', get_template_directory_uri() . '/js/ajax-add-to-cart.js', array('jquery'),'1.0' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'nanda_resende_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Assets
 */
define('fonts', get_template_directory_uri() . '/webfonts');
define('plugins', get_template_directory_uri() . '/plugins');
define('img', get_template_directory_uri() . '/images');
define('css', get_template_directory_uri() . '/css');
define('js', get_template_directory_uri() . '/js');

/**
 * Adding bootstrap classes to woocommerce checkout form
 *
 * @param $fields
 * @return mixed
 */
function wti_add_bootstrap_to_checkout_fields($fields) {
    foreach ($fields as $fieldset) {
        foreach ($fieldset as $field) {
            // Add form-group class around the label and the input
            $field['class'][] = 'form-group';

            // Add form-control to the actual input
            $field['input_class'][] = 'form-control';
        }
    }

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'wti_add_bootstrap_to_checkout_fields');

/*/////////////////////////////////////////////////////////////////////
//////////// WOOCOMMERCE
/////////////////////////////////////*/

/*-- GET PRODUCT PRICES --*/
function woocommerce_prices($product){
    if ( $product->is_type('simple') ) {
        if($product->is_on_sale()){
            $r = ['type' => 'simple', 'on_sale' => true, 'regular_price' => $product->get_regular_price(), 'sale_price' => $product->get_sale_price()];
        }else{
            $r = ['type' => 'simple', 'on_sale' => false, 'regular_price' => $product->get_regular_price()];
        }
    }else{
        $variations = $product->get_available_variations();
        foreach ($variations as $variation) {
            $display_regular_price[] = $variation['display_regular_price'];
            $display_price[] = $variation['display_price'];
        }
        if($product->is_on_sale()){
            $regular_price = min($display_regular_price);
            $sale_price = min($display_price);
            $r = ['type' => 'variable', 'on_sale' => true, 'regular_price' => $regular_price, 'sale_price' => $sale_price];
        }else{
            $regular_price = min($display_regular_price);
            $r = ['type' => 'variable', 'on_sale' => false, 'regular_price' => $regular_price];
        }
    }
    return $r;
}


/*///////////////////////////////////////////////
////////// REGISTRA OS MENUS DO SITE
////////////////////////////*/
register_nav_menus(array(
    'primary' => __('Principal', 'nanda-resende'),
    'footer-col1' => __('Footer', 'nanda-resende')
));

function add_additional_class_on_li($classes, $item, $args) {
    if($args->add_li_class) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

function add_additional_class_on_link($classes, $item, $args) {
    if($args->add_link_class) {
        $classes[] = $args->add_link_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_link', 10, 4);




if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Home Banner´s',
        'menu_title'    => 'Banner´s',
        'menu_slug'     => 'banners',
        'capability'    => 'edit_posts',
        'icon_url'      => 'dashicons-images-alt2',
        'redirect'      => false
    ));
}

// Retorna avaliaçãoes dos produtos (estrelinhas);
function get_star_rating() {

    global $woocommerce, $product;

    $average      = $product->get_average_rating();
    $review_count = $product->get_review_count();

    return '<div class="star-rating">
                <span style="width:'.( ( $average / 5 ) * 100 ) . '%" title="'.
                $average.'">
                    <strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'nanda-resende' ).
                '</span>                    
            </div>';

}


function getMinMaxPrice(){
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'product',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'meta_query' => array(
            array(
                'key' => '_price',
            )
        )       
    );

    $loop = new WP_Query($args);
    $i = count($loop->posts) - 1;
    $max = get_post_meta($loop->posts[0]->ID, '_price', true);
    $min = get_post_meta($loop->posts[$i]->ID, '_price', true);
    return ['min' => $min, 'max' => $max];
}  

// Vinculando Classe de entrega 'frete-gratuito' com os produtos
/*function my_wc_free_shipping_by_shipping_class( $rates, $package ) {
    $shipping_class = 'entrega-gratuita'; // Slug da sua classe de entrega.
    $allow_free_shipping = true;
    //$states = array("GO", "TO", "MT", "MG", "SP", "RJ", "ES");
    // Verifica se todos os produtos precisam ser entregues e se possuem a class de entrega selecionada.
    foreach ( $package['contents'] as $value ) {
        $product = $value['data'];
        if ( $product->needs_shipping() && $shipping_class !== $product->get_shipping_class() ) {
            $allow_free_shipping = false;
            break;
        }
    }
    // Remove a entrega gratuita se algum produto não possuir a classe de entrega selecionada.
    if ( ! $allow_free_shipping ) {
        foreach ( $rates as $rate_id => $rate ) {
            if ( 'free_shipping' === $rate->method_id ) {
                unset( $rates[ $rate_id ] );
                break;
            }
        }
    }
    return $rates;
}
add_filter( 'woocommerce_package_rates', 'my_wc_free_shipping_by_shipping_class', 100, 2 );*/

// Ajustando o layout do checkout
add_filter( 'woocommerce_checkout_fields' , 'amit_checkout_fields_styling', 10 );
function amit_checkout_fields_styling( $fields ) {
    $fields['billing']['billing_first_name']['class'][0] = 'form-row-wide';
    $fields['billing']['billing_last_name']['class'][0] = 'form-row-wide';
    $fields['billing']['billing_postcode']['class'][0] = 'form-row-wide';
    $fields['billing']['billing_address_1']['class'][0] = 'form-row-wide';
    $fields['billing']['billing_number']['class'][0] = 'form-row-wide';
    $fields['billing']['billing_neighborhood']['class'][0] = 'form-row-wide';
    $fields['billing']['billing_city']['class'][0] = 'form-row-wide';
    $fields['billing']['billing_phone']['class'][0] = 'form-row-wide';
    return $fields;
}

/**
 * Alterar o separador do breadcrumb
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_delimiter' );
function wcc_change_breadcrumb_delimiter( $defaults ) {
    // Change the breadcrumb delimeter from '/' to '>'
    $defaults['delimiter'] = ' <span class="arrow-breadcrumb material-symbols-outlined">chevron_right</span> ';
    return $defaults;
}

/**
 * Adicionar classe no botão da paginação de produtos
 */
add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
  return 'class="btn btn-nandaresende btn-nandaresende-third"';
}

/**
 * Adicionar produto no carrinho com Ajax
 */

function woocommerce_ajax_add_to_cart_js() {
    wp_enqueue_script('woocommerce-ajax-add-to-cart', get_template_directory_uri() . '/js/ajax-add-to-cart.js', array('jquery'), '', true);
}
add_action('wp_enqueue_scripts', 'woocommerce_ajax_add_to_cart_js', 99);

add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');

function woocommerce_ajax_add_to_cart() {

    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    $variation_id = absint($_POST['variation_id']);
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

        do_action('woocommerce_ajax_added_to_cart', $product_id);

        if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }

        WC_AJAX :: get_refreshed_fragments();
    } else {

        $data = array(
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

        echo wp_send_json($data);
    }

    wp_die();
}

add_action('wp_ajax_ql_woocommerce_ajax_add_to_cart', 'ql_woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_ql_woocommerce_ajax_add_to_cart', 'ql_woocommerce_ajax_add_to_cart');
function ql_woocommerce_ajax_add_to_cart() {
    $product_id = apply_filters('ql_woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    $variation_id = absint($_POST['variation_id']);
    $passed_validation = apply_filters('ql_woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);
    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {
        do_action('ql_woocommerce_ajax_added_to_cart', $product_id);
        if ('yes' === get_option('ql_woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }
        WC_AJAX :: get_refreshed_fragments();
    } else {
        $data = array(
            'error' => true,
            'product_url' => apply_filters('ql_woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));
        echo wp_send_json($data);
    }
    wp_die();
}

add_filter( 'woocommerce_update_order_review_fragments', 'my_custom_shipping_table_update');

function my_custom_shipping_table_update( $fragments ) {
    
    ob_start();
    ?>
    <table class="my-custom-shipping-table">
        <tbody>
        <?php wc_cart_totals_shipping_html(); ?>
        </tbody>
    </table>
    <?php
    $woocommerce_shipping_methods = ob_get_clean();
    $fragments['.my-custom-shipping-table'] = $woocommerce_shipping_methods;   

    return $fragments;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'wc_refresh_mini_cart_count');
add_filter( 'woocommerce_add_to_cart_fragments', 'wc_refresh_mini_cart_count_mobile');
add_filter( 'woocommerce_add_to_cart_fragments', 'wc_refresh_cart_item');
add_filter( 'woocommerce_add_to_cart_fragments', 'wc_refresh_cart_count');
function wc_refresh_mini_cart_count($fragments){
    ob_start(); ?>
    <i id="mini-cart-count" class="contador-cart"><?php echo WC()->cart->get_cart_contents_count(); ?></i>
    <?php 
    $fragments['#mini-cart-count'] = ob_get_clean();
    return $fragments;
}
function wc_refresh_mini_cart_count_mobile($fragments){
    ob_start(); ?>
    <i id="mini-cart-count-mobile" class="contador-cart"><?php echo WC()->cart->get_cart_contents_count(); ?></i>
    <?php 
    $fragments['#mini-cart-count-mobile'] = ob_get_clean();
    return $fragments;
}
function wc_refresh_cart_count($fragments){
    ob_start(); ?>
    <strong id="count-itens"><?php echo WC()->cart->get_cart_contents_count(); ?> Itens</strong>
    <?php 
    $fragments['#count-itens'] = ob_get_clean();
    return $fragments;
}
function wc_refresh_cart_item($fragments){
    ob_start(); ?>
    <span id="subtotal-itens">R$ <?php echo WC()->cart->get_subtotal(); ?></span>
    <?php 
    $fragments['#subtotal-itens'] = ob_get_clean();
    return $fragments;
}

// Utility function that outputs the mini cart content
function my_wc_mini_cart_content(){
    $cart = WC()->cart->get_cart();

    foreach ( $cart as $cart_item_key => $cart_item  ):
        $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
            $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
            $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
            $product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
            if(isset($cart_item['variation']['attribute_pa_size'])) {
                $variation_val = $cart_item['variation']['attribute_pa_size'];
                $term_obj  = get_term_by('slug', $variation_val, 'pa_size');
                $size_name = $term_obj->name;
            }
            ?>

            <div class="media mini-cart__item woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
                <li  class="item-cart-box w-100">
                    <div id="cart-items">
                        <img src="<?php echo get_the_post_thumbnail_url($cart_item['product_id'], 'thumbnail') ?>" alt="">
                        <div class="product-cart">
                            <p class="name-product m-0"><?php echo $cart_item['data']->name; ?></p>
                            <p class="price-product m-0"><?php echo $cart_item['quantity'] ?>x R$ <?php echo $cart_item['data']->sale_price ? number_format($cart_item['data']->sale_price, 2, ',', '.') : number_format($cart_item['data']->regular_price, 2, ',', '.') ?></p>
                        </div>
                        <div class="remove-product-cart"><?php $key = $cart_item['key'] ?>
                            <?php
                            echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                __( 'Remove this item', 'nanda-resende' ),
                                esc_attr( $product_id ),
                                esc_attr( $cart_item_key ),
                                esc_attr( $_product->get_sku() )
                            ), $cart_item_key );
                            ?>
                        </div>
                    </div>
                </li>
            </div>
            <?php
        }
    endforeach;
    if ($cart) { ?>
        <li class="cart-items subtotal">
            <div>
                <h5 class="text-center subtotal-text">
                Subtotal: <span id="cart-subtotal"><?php echo WC()->cart->get_total() ?></span>
                </h5>
            </div>
        </li>
        <li class="cart-items mb-2 content-btn-cart">
            <a href="<?php echo esc_url(home_url('/carrinho')); ?>" class="btn btn-nandaresende btn-block btn-view-cart">Ver Carrinho</a>
        </li>
        <li class="cart-items content-btn-checkout">
            <a href="<?php echo esc_url(home_url('/finalizar-compra')); ?>" class="btn btn-nandaresende btn-block text-center btn-view-cart">Finalizar Compra <i class="icons-right-arrow"></i></a>
        </li>
    <?php } else { ?>
        <li class="empty-cart empty-cart-ajax">O carrinho está vazio</li>
    <?php }
}

// Hooked: The mini cart count and the cart content
add_action( 'frosted_header_top', 'my_wc_mini_cart' );
function my_wc_mini_cart() {
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        $count = WC()->cart->get_cart_contents_count();
        ?>
        <a href="#"><?php _e('Cart', 'nanda-resende'); ?> <span id="cart_count" class="cart__amount"><?php echo esc_html( $count ); ?></span></a>
        <div id="mini-cart-content" class="sub-menu sub-menu--right sub-menu--cart">
        <?php my_wc_mini_cart_content(); ?>
        </div>
        <?php
    }
}

// Ajax refreshing mini cart count and content
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );
function my_header_add_to_cart_fragment( $fragments ) {
    $count = WC()->cart->get_cart_contents_count();

    $fragments['#cart_count'] = '<span id="cart_count" class="cart__amount">' . esc_attr( $count ) . '</span>';

    ob_start();
    ?>
    <div id="mini-cart-content" class="sub-menu sub-menu--right sub-menu--cart">
    <?php my_wc_mini_cart_content(); ?>
    <div>
    <?php

    $fragments['#mini-cart-content'] = ob_get_clean();

    return $fragments;
}

/**
 * Fim Adicionar produto no carrinho com Ajax
 */

/**
 * Produtos variáveis
 */

function get_product_regular_price($variation_id) {

    global $woocommerce; 
    $product = new WC_Product_Variation($variation_id);
    return $product->get_regular_price(); 
}

function get_product_min_price($variation_id) {

    global $woocommerce; 
    $product = new WC_Product_Variation($variation_id);
    return $product->get_price(); 
}

function get_product_descricao($variation_id) {

    global $woocommerce; 
    $product = new WC_Product_Variation($variation_id);
    return $product->get_variation_attributes(); 
}

function get_product_ref($variation_id) {

    global $woocommerce; 
    $product = new WC_Product_Variation($variation_id);
    return $product->get_description(); 
}


function cw_woo_attribute(){
    global $product;
    $attributes = $product->get_attributes();
    if ( ! $attributes ) {
        return;
    }
    $display_result = '';
    foreach ( $attributes as $attribute ) {
        if ( $attribute->get_variation() ) {
            continue;
        }
        $name = $attribute->get_name();
        if ( $attribute->is_taxonomy() ) {
            $terms = wp_get_post_terms( $product->get_id(), $name, 'all' );
            $cwtax = $terms[0]->taxonomy;
            $cw_object_taxonomy = get_taxonomy($cwtax);
            if ( isset ($cw_object_taxonomy->labels->singular_name) ) {
                $tax_label = $cw_object_taxonomy->labels->singular_name;
            } elseif ( isset( $cw_object_taxonomy->label ) ) {
                $tax_label = $cw_object_taxonomy->label;
                if ( 0 === strpos( $tax_label, 'Product ' ) ) {
                    $tax_label = substr( $tax_label, 8 );
                }
            }
            $display_result .= $tax_label . ': ';
            $tax_terms = array();
            foreach ( $terms as $term ) {
                $single_term = esc_html( $term->name );
                array_push( $tax_terms, $single_term );
            }
            $display_result .= implode(', ', $tax_terms) .  '<br />';
        } else {
            $display_result .= $name . ': ';
            $display_result .= esc_html( implode( ', ', $attribute->get_options() ) ) . '<br />';
        }
    }
    echo $display_result;
}
add_action('woocommerce_single_product_summary', 'cw_woo_attribute', 25);

function custom_wc_ajax_variation_threshold( $qty, $product ) { return 300; } add_filter( 'woocommerce_ajax_variation_threshold', 'custom_wc_ajax_variation_threshold', 100, 3 );

/**
 * Fim Produtos variáveis
 */

// Cropped Products images
add_theme_support( 'woocommerce', array(
    'thumbnail_image_width' => 250,
    'gallery_thumbnail_image_width' => 150,
    'single_image_width' => 500,
) );

// Preço de Produto variável

add_shortcode( 'product_price', 'display_formatted_product_price' );
function display_formatted_product_price( $atts ) {
    extract(shortcode_atts( array(
        'id' => null
    ), $atts, 'product_price' ) );

    global $product;

    if( ! empty($id) || ! is_a($product, 'WC_Product') ) {
        $product = wc_get_product( empty($id) ? get_the_id() : $id );
    }

    $price_html = $product->get_price_html();

    // Others product types than variable
    if ( ! $product->is_type('variable') ) {
        return '<span class="product-price">' . $price_html . '</span>';
    }
    // For variable products
    else {
        ob_start();

        ?>
        <script type="text/javascript">
        jQuery( function($){
            var p = '<?php echo $price_html; ?>', s = 'span.product-price';

            $( 'form.variations_form.cart' ).on('show_variation', function(event, data) {
                $(s).html(data.price_html); // Display the selected variation price
            });

            $( 'form.variations_form.cart' ).on('hide_variation', function() {
                $(s).html(p); // Display the variable product price range
            });
        });
        </script>
        <?php

        return ob_get_clean() . '<span class="product-price">' . $price_html . '</span>';
    }
}

/**
 * @description   Funções responsaveis por remover os respectivos campos, cidade e estado, para o calculo de frete
 * @author        Peterson Macedo
 */
add_filter( 'woocommerce_shipping_calculator_enable_city', '__return_false' );
add_filter( 'woocommerce_shipping_calculator_enable_state', '__return_false' );