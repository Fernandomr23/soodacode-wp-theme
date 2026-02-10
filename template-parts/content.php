<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package soodacode
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="article-layout container">

		<aside class="toc-sidebar">
			<nav id="table-of-contents">
				<?php echo do_shortcode('[sooda-toc]'); ?>
			</nav>
		</aside>

		<div class="article-content">
			<?php the_content(); ?>
		</div>

	</div>
</article>
