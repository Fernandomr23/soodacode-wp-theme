<?php
/**
 * The template for displaying category pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package soodacode
 */

get_header();
?>
    <main id="primary" class="site-main">
        <div class="category-section">
            <div class="header-page">
                <?php
                $category = get_queried_object();
                $category_image_url = get_term_meta($category->term_id, 'category_image', true);
				if ($category_image_url): ?>
					<img src="<?php echo esc_url($category_image_url); ?>" alt="<?php echo esc_attr($category->name); ?>">
				<?php endif; ?>
                <h1><?php single_cat_title(); ?></h1>
                <div class="category-description container">
                    <?php echo category_description(); ?>
                </div>
            </div>
            <div class="container category-page">
                <h2>Recent projects with <?php single_cat_title(); ?></h2>
                <?php get_template_part( 'template-parts/content', 'blog' ); ?>
            </div>
        </div><!-- category-section -->

        <?php get_template_part( 'template-parts/content', 'yt' ); ?>

    </main><!-- #main -->
<?php
get_footer();
?>

