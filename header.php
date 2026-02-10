<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package soodacode
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>

	<?php
    wp_head(); // Asegúrate de que wp_head() esté en la posición correcta

    // Obtener el código de Google Analytics
    $google_analytics_code = get_theme_mod('google_analytics_code');

    // Imprimir el código de Google Analytics si está disponible
    if ( ! empty( $google_analytics_code ) ) {
        echo $google_analytics_code; // Imprimir el código HTML tal cual
    }
    ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'soodacode' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="header_nav">

			<div class="site-branding">
				 <a href="<?php echo esc_url(home_url('/')); ?>"><span>Sooda</span>code</a>
			</div><!-- .site-branding -->
				
			<nav id="site-navigation" class="main-navigation">

					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
						$cta_button_url = get_permalink(get_theme_mod('cta_button_url'));
						$cta_button_text = get_theme_mod('cta_button_text');
						if (!empty($cta_button_url) && !empty($cta_button_text)) : ?>
							<a href="<?php echo esc_url ($cta_button_url); ?>" class="menu-button">
            					<?php echo esc_html($cta_button_text); ?>
							</a>
						<?php endif; ?>
			</nav><!-- #site-navigation -->

			<div class="toggle-menu">
					<i class="ri-menu-fill open-menu" aria-controls="primary-menu" aria-expanded="false"></i>
					<i class="ri-close-large-fill close-menu" aria-controls="primary-menu" aria-expanded="true" style="display: none;"></i>
			</div><!-- .toggle-menu -->

		</div>
	</header><!-- #masthead -->
