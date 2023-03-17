<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Nanda_Resende
 */

get_header();
?>

	<?php get_header(); ?>
    <section class="section-404 section section-nandaresende">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                  <div class="section-title text-center pb-4">
                    <h1 style="font-size: 5em;">404</h1>
                    <h4>Oops, página não encontrada!</h4>
                    <p style="color: #bfbfbf;">A página pode ter sido removida</p>
                  </div>
                  <div class="section-title text-center pb-4">
                    <a href="<?php echo get_home_url(); ?>" title="" class="btn btn-lg btn-nandaresende-second">Voltar para Home</a>
                  </div>
                </div>                    
            </div>
        </div>
    </section>
    <!--End 404 -->

<?php get_footer(); ?>
