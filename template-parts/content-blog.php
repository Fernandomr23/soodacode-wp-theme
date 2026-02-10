<?php
/**
 * Template part for displaying blog layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package soodacode
 */

// Obtener el número de página actual
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Definir los argumentos para la consulta
$query_args = array(
    'post_type' => 'post',
    'paged' => $paged, // Asegura que se respete la paginación
);

// Condiciones adicionales según la página
if (is_home()) {
    // Página principal: sin límite de posts
} elseif (is_category()) {
    // Página de categorías
    $query_args['category_name'] = single_cat_title('', false);
} elseif (is_search()) {
    // Página de búsqueda
    $query_args['s'] = get_search_query();
} elseif (is_author()) {
    // Página de autor
    $author_id = get_queried_object_id();
    $query_args['author'] = $author_id;
}

// Query de posts
$the_query = new WP_Query($query_args);
?>
<div class="news-section">
    <div class="container">
        <div class="news-grid">
            <div class="blog-container">
                <?php
                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) : $the_query->the_post();
                        ?>
                        <div class="news-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="news-image">
                                    <?php the_post_thumbnail(); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!is_category()) : ?>
                                <span class="tag"><?php the_category(' '); ?></span>
                            <?php endif; ?>
                            <div class="news-content">
                                <a href="<?php the_permalink(); ?>">
                                    <h3 ><?php the_title(); ?></h3>
                                </a>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                <div class="news-meta">
                                    <span><?php
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
									</span>
                                </div>
                            </div>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>No posts found.</p>';
                endif;
                ?>
            </div>
            <?php if (get_the_posts_pagination(array('echo' => false)) && !is_search()) : ?>
			<div class="navigation">
				<?php
				the_posts_pagination(array(
					'mid_size' => 2,
					'prev_text' => __('« Previous', 'soodacode'),
					'next_text' => __('Next »', 'soodacode'),
				));
				?>
			</div>
			<?php endif; ?>
        </div>
    </div>
</div><!-- news-section -->
