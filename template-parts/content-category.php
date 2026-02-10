<?php
/**
 * Template part for displaying category layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package soodacode
 */
?>
<div class="category-section">
    		<div class="container category-container">
        		<div class="category-grid">
					<?php
					$args = array(
						'number' => 6,
					);
					$categories = get_categories($args);

					foreach ($categories as $category) {
						$category_image_url = get_term_meta($category->term_id, 'category_image', true);
						$category_link = get_category_link($category->term_id);
						?>
						<div class="category-card">
							<a href="<?php echo esc_url($category_link); ?>">
							<?php if ($category_image_url): ?>
								<img src="<?php echo esc_url($category_image_url); ?>" alt="<?php echo esc_attr($category->name); ?>">
							<?php endif; ?>
								<span><?php echo esc_html($category->name); ?></span>
							</a>
            			</div>
            		<?php } ?>
				</div>
			</div>
        </div><!-- categoty-section -->