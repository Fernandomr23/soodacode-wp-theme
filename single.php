<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package soodacode
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<section class="header-page">

				<div class="entry-meta">
					<?php
					$categories = get_the_category();
					if ( ! empty( $categories ) ) {
						$category_links = array(); // Crear un array para almacenar los enlaces de categoría
						foreach ( $categories as $category ) {
							$category_id = $category->term_id;
							$category_links[] = '<a href="' . esc_url( get_category_link( $category_id ) ) . '" class="post-category">' . esc_html( $category->name ) . '</a>';
						}
						// Unir todos los enlaces con un espacio como separador
						echo implode( '  -  ', $category_links );
					}
					the_title( '<h1 class="entry-title container">', '</h1>' );
					?>
					<div class="entry-author">
						<p><?php soodacode_posted_by(); ?></p>
					</div>
					<?php
					$posted_date = get_the_date();
					$modified_date = get_the_modified_date();
					$content = get_post_field( 'post_content', get_the_ID() );
					$word_count = str_word_count( strip_tags( $content ) );
					$reading_time = ceil( $word_count / 200 ); 

					if ( $modified_date !== $posted_date ) {
						echo '<span class="posted-on">' . esc_html( $modified_date ) . '</span>';
					} else {
						echo '<span class="posted-on">' . esc_html( $posted_date ) . '</span>';
					}

					echo ' • <span class="reading-time">' . sprintf( esc_html__( '%d min read', 'soodacode' ), $reading_time ) . '</span>';
					?>
            	</div>
			</section><!-- .entry-header -->

			<?php get_template_part( 'template-parts/content', get_post_type() );

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
