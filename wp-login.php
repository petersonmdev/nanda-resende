<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Nanda_Resende
 */

  get_header(); ?>
  
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
    <section class="section section-nandaresende section-register">
      <div class="container">
        <div class="row">
          <div class="col-12 col-sm-12 col-md-6 offset-md-3 content-login-nandaresende">
            <div class="section-title text-center mb-4">
              <h3>já sou cadastrado</h3>
            </div>
            <form action="" class="woocommerce-form woocommerce-form-login login" method="post">
                <div class="input-group">
                <label for="username">
                    <span>Nome de usuário ou e-mail</span>
                </label>
                <input type="email" class="form-control inpt-nandaresende woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="">
                <label for="password">
                    <span>Senha</span>
                </label>
                <span class="password-input"><input class="form-control inpt-nandaresende woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password"><span class="show-password-input"></span></span>
                <p class="text-right mb-3">
                    <a href="#" title="">Esqueci minha senha</a>
                </p>
                <a title="submit" class="btn btn-lg btn-nandaresende btn-nandaresende-first woocommerce-button button woocommerce-form-login__submit">Entrar</a>
                </div>
            </form>
          </div>
        </div>
      </div>
    </section>

<?php get_footer(); ?>


