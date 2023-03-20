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

    <main class="pt-5 pb-5 main-nandaresende">
        <div class="container">
            <div class="content-post-nandaresende mb-3 pb-3">
                <?php if(have_posts()){
                    while (have_posts()){ ?>
                        <h2 class="title-nandaresende text-center mb-3"><?= the_title(); ?></h2>
                        <?php the_post(); ?>
                        <?php the_content(); ?>
                <?php   }
                } ?>
            </div>
        </div>
    </main>

<?php get_footer(); ?>

