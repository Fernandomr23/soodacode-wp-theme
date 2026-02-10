<?php
/**
 * The template for displaying author archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#author
 *
 * @package soodacode
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="author-header">
        <?php
        // Retrieve the author's ID and display their name
        $author_id = get_queried_object_id();
        $author_name = get_the_author_meta('display_name', $author_id);
        $author_description = get_the_author_meta('description', $author_id);
        $author_avatar = custom_profile_picture_display($author_id);
        ?>

        <div class="author-profile">
            <div class="author-avatar">
                <?php echo $author_avatar; ?>
            </div>
            <div class="author-details">
                <h1 class="author-title"><?php echo esc_html($author_name); ?></h1>
                <?php if ($author_description) : ?>
                    <div class="author-bio">
                        <?php echo wp_kses_post($author_description); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="container author-posts category-page">
                <h2>Projects of <?php echo esc_html($author_name); ?></h2>
                <?php get_template_part( 'template-parts/content', 'blog' ); ?>
            </div>
    </div>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();
