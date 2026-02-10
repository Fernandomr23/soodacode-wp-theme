<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package soodacode
 */

get_header(); ?>

<main id="primary" class="site-main custom-404">

    <!-- 404 Banner Section -->
    <section class="page-banner>
        <div class="banner-content">
            <h1 class="page-title"><?php _e('Oops! Page Not Found', 'soodacode'); ?></h1>
        </div>
    </section>

    <div class="container">
        <div class="error-404-content">
            <h2><?php _e('We can’t seem to find the page you’re looking for.', 'soodacode'); ?></h2>
            <p><?php _e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'soodacode'); ?></p>


            <!-- Suggested Links -->
            <h3><?php _e('Here are some helpful links:', 'soodacode'); ?></h3>
            <ul class="error-links">
                <li><a href="<?php echo home_url(); ?>"><?php _e('Home', 'soodacode'); ?></a></li>
                <li><a href="<?php echo site_url('/blog/'); ?>"><?php _e('Blog', 'soodacode'); ?></a></li>
                <li><a href="<?php echo site_url('/contact/'); ?>"><?php _e('Contact Us', 'soodacode'); ?></a></li>
            </ul>
        </div>
    </div>

</main><!-- #main -->

<?php
get_footer();
