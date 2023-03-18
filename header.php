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

// um número no formato internacional (ativo no WhatsApp)
$number = '+5562996169196';
$numberprint = '(62) 99616-9196';
// o texto ou algo vindo de um <textarea> ou <input> por exemplo
$msg = 'Olá, vim do Site Oficial Nanda Resende, poderia me ajudar?';

// montar o link (número e texto) (web)
$targetWeb = 'https://api.whatsapp.com/send?phone=' . urldecode($number) . '&text=' . urldecode($msg) . '';

// montar o link (número e texto) (app)
$targetApp = '//web.whatsapp.com/send?phone=' . urldecode($number) . '&text=' . urldecode($msg) . '';

$isMobile = (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($_SERVER['HTTP_USER_AGENT'], 0, 4)))

?>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">

  <?php wp_head(); ?>

</head>

<?php if (is_page('finalizar-compra')) { ?>

  <body <?php body_class(); ?>>
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

          <?php
          if ($isMobile) {
            echo '<a href="' . $targetApp . '" class="btn-wpp-mobile d-md-flex d-lg-none animated infinite pulse delay-2s"><i class="fab fa-whatsapp"></i></a>';
          } else {
            echo '<a href="' . $targetWeb . '" class="btn-wpp-mobile d-md-flex d-lg-none animated infinite pulse delay-2s"><i class="fab fa-whatsapp"></i></a>';
          }
          ?>

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
                                                  <input type="text" class="search__input" name="s" placeholder="Faça sua busca..." value="<?php echo get_search_query() ?>" />
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