<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nanda_Resende
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<?php

// Número no formato internacional (ativo no WhatsApp)
$number = '5562996169196';

// Mensagem de texto padrão para identificar que veio do site
$msg = 'Olá, vim da loja Nanda Resende joias, poderia me ajudar?';

// link WhatsApp
$target = 'https://wa.me/'.urldecode($number).'?text='.urlencode($msg);

?>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NBLWVS2');</script>
    <!-- End Google Tag Manager -->

  <?php wp_head(); ?>

</head>

<?php if (is_page('finalizar-compra')) { ?>

  <body <?php body_class(); ?>>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NBLWVS2"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php wp_body_open(); ?>
    <div id="page" class="site">

      <!-- Breadcrumb -->
      <section class="section-nandaresende section section-header-checkout">
        <div class="container">
          <div class="row">
            <div class="col-6 d-none d-md-block col-lg-6 text-left">
              <div class="section-title-header-checkout mb-0">
                <h3>
                  <span class="material-symbols-outlined">lock</span>
                  pagamento
                  <small>100% seguro</small>
                </h3>
              </div>
            </div>

            <div class="col-md-6 col-sm-12 col-lg-6 text-right content-logo-checkout">
              <figure>
                <a href="<?php echo esc_url(home_url()); ?>">
                  <img src="<?php echo img; ?>/logo.png" alt="" width="130">
                </a>
              </figure>
            </div>
          </div>
        </div>
      </section>
      <!-- End header checkout -->

    <?php } else { ?>

      <body <?php body_class() ?>>
        <div class="page-wrapper">
            <?= '<a href="' . $target . '" class="btn-wpp-mobile d-md-flex d-lg-none animated infinite pulse delay-2s"><i class="fab fa-whatsapp"></i></a>'; ?>
          <section class="header-uper d-none d-lg-block">
      <div class="container clearfix">
        <div class="row content-header-nandaresende">
          <div class="logo col-2">
            <figure>
              <a href="<?php echo esc_url(home_url()) ?>">
                <img src="<?php echo img; ?>/logo.png" alt="" width="110">
              </a>
            </figure>
          </div>

          <div class="right-side col-10 d-sm-none d-md-block">
              <ul class="d-flex content-menu action-header">
                  <?php
                  echo strip_tags(wp_nav_menu(array(
                      'theme_location'  => 'primary',
                      'container'       => false,
                      'echo'            => false,
                      'items_wrap'      => '%3$s',
                      'menu_class'      => 'item-menu',
                      'depth'           => 0,
                  )), '<li>, <a>');
                  ?>
                  <li class="item item-menu item-menu-last-icons">
                      <ul class="d-flex">
                          <li class="item item-icons-search">
                              <div class="search-overlay"></div>
                              <div class="scroll-cont">
                                  <div class="content">
                                      <div class="search_desk">
                                          <div class="search__bg"></div>
                                          <div class="search__box">
                                              <form id="searchForm" action="<?php echo get_site_url(); ?>" method="get" role="search" class="woocommerce-product-search">
                                                  <input type="text" class="search__input" name="s" placeholder="Faça sua busca..." />
                                              </form>
                                              <div class="search__line"></div>
                                              <div class="search__close"></div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </li>
                          <li class="item item-icons-cart">
                              <a href="<?php echo wc_get_cart_url(); ?>">
                                  <span class="material-symbols-outlined">
                                      shopping_cart
                                  </span>
                                  <span id="mini-cart-count" class="contador-cart"></span>
                              </a>
                          </li>
                          <li class="item item-icons-account">
                              <a href="<?php echo get_permalink(wc_get_page_id('myaccount')); ?>">
                                  <span class="material-symbols-outlined">
                                      person
                                  </span>
                              </a>
                          </li>
                      </ul>
                  </li>
              </ul>
          </div>
        </div>
      </div>
    </section>
    <!--Header Upper-->
    <!--Main Header-->
    <nav class="navbar navbar-default navbar-light navbar-nandaresende d-md-block d-lg-none">
        <div class="container">
            <!-- Collect the nav links, forms, and other content for toggling -->
            <nav class="navbar navbar-expand-lg w-100">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="logo logo-mobile d-md-block d-lg-none">
                    <figure>
                        <a href="<?php echo esc_url(home_url()) ?>">
                            <img src="<?php echo img; ?>/logo.png" alt="" width="130">
                        </a>
                    </figure>
                </div>
                <div class="d-md-block d-lg-none">
                    <ul class="content-cart-mobile p-0 m-0">
                        <li class="item d-inline item-icons-cart">
                            <a href="<?php echo wc_get_cart_url(); ?>">
                                <span class="material-symbols-outlined">
                                  shopping_cart
                                </span>
                                <span id="mini-cart-count-mobile" class="contador-cart"></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav nav-fill w-100">
                        <?php
                        wp_nav_menu(array(
                            'theme_location'  => 'primary',
                            'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
                            'container'       => '',
                            'container_class' => '',
                            'container_id'    => '',
                            'menu_class'      => 'navbar-nav nav-fill w-100 ul-menu-mobile',
                            'add_li_class'    => 'nav-item'
                        ));
                        ?>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- /.container-fluid -->
        </nav>
        <nav class="nav-content-search d-md-block d-lg-none">
            <div class="container">
                <div class=row>
                    <div class="col-12">
                        <form action="<?php echo get_site_url(); ?>" method="get" role="search" class="search woocommerce-product-search">
                            <div class="input-group content-search">
                                <input class="form-control inpt-nandaresende" type="text" name="s" placeholder="Faça sua busca..." aria-describedby="button-addon-mobile" value="<?php echo get_search_query() ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary btn-nandaresende" type="submit" id="button-addon-mobile"><span class="material-symbols-outlined">search</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <!--End Main Header -->
        <div class="modal-loading"></div>

      <?php }; ?>