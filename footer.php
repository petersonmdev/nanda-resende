<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nanda_Resende
 */

?>

<?php if (is_page('finalizar-compra')) { ?>

  <!--footer-main-->
  <footer class="footer-main footer-nandaresende footer-checkout mt-5">
    <div class="footer-bottom">
      <div class="container clearfix">
        <div class="copyright-text">
          <p class="text-center"><strong>NANDA RESENDE - CNPJ: 46.937.481/0001-67</strong> &copy; Todos direitos reservados, <?php echo date("Y"); ?></p>
        </div>
      </div>
    </div>
  </footer>
  <!--End footer-main-->

  </div>
  <!--End pagewrapper-->

  <?php wp_footer(); ?>

  </body>

  </html>

<?php } else { ?>

  <!--footer-main-->
    <footer class="footer-main footer-nandaresende">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                        <h6 class="title-footer-top">Navegação</h6>
                        <?php
                        wp_nav_menu(array(
                            'theme_location'  => 'footer-col1',
                            'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
                            'container'       => '',
                            'container_class' => '',
                            'container_id'    => '',
                            'menu_class'      => 'menu-link'
                        ));
                        ?>
                    </div>
                    <div class="col-lg-1 d-lg-block d-md-none mb-4"></div>
                    <div class="col-lg-3 col-md-3 col-sm-12 mb-4">
                        <div class="content-middle-footer">
                            <h6 class="title-footer-top">Formas de pagamento</h6>
                            <img src="<?php echo img; ?>/icons/payment-method.png" alt="cartões aceitos">
                        </div>
                        <div class="content-middle-footer content-middle-footer mt-5 pt-4">
                            <h6 class="title-footer-top">Funcionamento</h6>
                            <p>De segunda a Quinta, das 7h as 17h. Sexta-feira, das 7h as 16h</p>
                        </div>
                    </div>
                    <div class="col-lg-1 d-lg-block d-md-none mb-4"></div>
                    <div class="col-lg-4 col-md-5 col-sm-12 mb-4">
                        <h3 class="title-footer-top">Contato</h3>
                        <div class="content-newsletter">
                            <div class="group">
                                <input class="w-100" type="email" required>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Cadastre seu e-mail e receba novidades</label>
                            </div>
                        </div>

                        <div class="col-12 mb-4 p-0 content-newsletter-nandaresende-bottom">
                            <h5 class="p-0 m-0 link-email-footer"><a href="mailto:contato@nandaresendejoias.com.br">contato@nandaresendejoias.com.br</a></h5>
                            <div class="localization-footer pt-3">
                                <p>
                                    <b><span class="material-symbols-outlined">location_on</span>Galeria Cristal</b>
                                    <span class="d-block">Alameda Ricardo Paranhos, 345 - Sala 05, Setor Marista, Goiânia - GO. 74180-050</span>
                                </p>
                            </div>
                            <ul class="d-flex social-icons p-0">
                                <li><a href="https://api.whatsapp.com/send?phone=+5562996169196"><img src="<?php echo img; ?>/icons/whatsapp.png" alt="Whatsapp"></a></li>
                                <li><a href="https://www.instagram.com/nandaresendejoias/"><img src="<?php echo img; ?>/icons/instagram.png" alt="Instagram"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container clearfix">
                <div class="copyright-text">
                    <p><strong>NANDA RESENDE JOIAS - CNPJ: 46.937.481/0001-67</strong> &copy; Todos direitos reservados, <?php echo Date('Y'); ?></p>
                </div>

                <div class="footer-bottom-link">
                    <h6 class="mb-2 mr-2 d-md-block d-lg-inline text-uppercase">
                        Desenvolvido por:
                    </h6>
                    <a href="http://petersonmacedo.com.br" target="_blank" class="mb-0 mx-3 d-inline logo-peterson">
                        <img src="<?php echo img; ?>/logo-peterson.png" alt="" class="img-responsive">
                    </a>
                </div>
            </div>
    </footer>
  <!--End footer-main-->

  </div>
  <!--End pagewrapper-->

  <?php wp_footer(); ?>

  </body>

  </html>

<?php }; ?>