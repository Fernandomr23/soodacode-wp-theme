<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package soodacode
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="banner-section">
    		<div class="banner container">

        		<div class="banner-title">
					<h1 class="page-title">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results for: %s', 'soodacode' ), get_search_query());
						?>
					</h1>
        		</div>
        
        		<div class="banner-search">
					<p>If you're not happy with the results, please do another search.
					</p>
            		<?php get_search_form(); ?>
        		</div>
    		</div><!-- banner -->
		</div><!-- banner-section -->

		<?php get_template_part( 'template-parts/content', 'blog' ); ?>
	</main><!-- #main -->

<?php
get_footer();
