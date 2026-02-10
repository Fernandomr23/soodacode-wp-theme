<?php
/**
 * The blog template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package soodacode
 */

get_header();
?>
	<main id="primary" class="home">
		
		<?php get_template_part( 'template-parts/banner' ); ?>

		<?php get_template_part( 'template-parts/content', 'blog' ); ?>
		
		<?php get_template_part( 'template-parts/content', 'category' ); ?>

		<?php get_template_part( 'template-parts/content', 'yt' ); ?>

	</main><!-- #main -->

<?php
get_footer();