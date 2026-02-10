<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package soodacode
 */

?>

	<footer class="site-footer">
		<div class="footer-container container">
			<!-- <div class="footer-menu">
				<?php
				wp_nav_menu(array(
					'theme_location' => 'footer',
					'menu_id'        => 'footer-menu',
					'menu_class'     => 'footer-nav',
					'container'      => 'nav',
					'container_class' => 'footer-nav-container',
					'depth'          => 1,
				));
				?>
			</div> -->

			<div class="footer-info">
				<div class="footer-branding site-branding">
					<a href="<?php echo esc_url(home_url('/')); ?>"><span>Sooda</span>code</a>
					<p><?php bloginfo('description'); ?></p>
				</div>

			<?php
			$linkedin_url = get_theme_mod('linkedin_url', '');
			$youtube_url = get_theme_mod('youtube_url', '');
			$github_url = get_theme_mod('github_url', '');

			$show_footer_social = !empty($linkedin_url) || !empty($youtube_url) || !empty($github_url);

			if ($show_footer_social) : ?>
				<div class="footer-social">
					<?php if (!empty($linkedin_url)) : ?>
						<a href="<?php echo esc_url($linkedin_url); ?>" target="_blank"><i class="ri-linkedin-line"></i></a>
					<?php endif; ?>

					<?php if (!empty($youtube_url)) : ?>
						<a href="<?php echo esc_url($youtube_url); ?>" target="_blank"><i class="ri-youtube-line"></i></a>
					<?php endif; ?>

					<?php if (!empty($github_url)) : ?>
						<a href="<?php echo esc_url($github_url); ?>" target="_blank"><i class="ri-github-line"></i></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="footer-credits">
        		<p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> - <a href="<?php echo esc_url(home_url('/privacy')); ?>">Legal</a></p>
    		</div>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
