<?php
/**
 * Template Name: Custom Page Template
 * Description: A custom page template that follows the theme's design patterns.
 *
 * @package soodacode
 */

get_header(); ?>

<main id="primary" class="site-main custom-page">

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
        
            <section class="header-page">
                    <h1 class="page-title"><?php the_title(); ?></h1>
            </section>

            <!-- Page Content -->
            <div class="container">
                <div class="page-content">
                    <?php the_content(); ?>
                </div>
            </div>

        <?php endwhile; ?>
    <?php else : ?>
        <div class="container">
            <p><?php _e('Sorry, no content found.', 'soodacode'); ?></p>
        </div>
    <?php endif; ?>

</main><!-- #main -->

<?php
get_footer();