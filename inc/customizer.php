<?php
/**
 * soodacode Theme Customizer
 *
 * @package soodacode
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */


function soodacode_customize_register( $wp_customize ) {
    // Soporte para título y descripción del sitio
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'soodacode_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'soodacode_customize_partial_blogdescription',
            )
        );
    }

    // Añadir sección para redes sociales
    $wp_customize->add_section('social_media_section', array(
        'title'    => __('Socials', 'soodacode'),
        'priority' => 150,
    ));

    // Ajustes y controles para URLs de redes sociales
    $wp_customize->add_setting('linkedin_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('linkedin_url', array(
        'label'    => __('Linkedin URL', 'soodacode'),
        'section'  => 'social_media_section',
        'type'     => 'url',
    ));

    $wp_customize->add_setting('youtube_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('youtube_url', array(
        'label'    => __('YouTube URL', 'soodacode'),
        'section'  => 'social_media_section',
        'type'     => 'url',
    ));

    $wp_customize->add_setting('github_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('github_url', array(
        'label'    => __('Github URL', 'soodacode'),
        'section'  => 'social_media_section',
        'type'     => 'url',
    ));
    
    // Añadir un nuevo control de texto para el enlace CTA dentro de la sección "Identidad del sitio"
    $wp_customize->add_setting('cta_button_url', array(
        'default'   => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'cta_button_url', array(
        'label'    => __('CTA Button URL', 'soodacode'),
        'section'  => 'title_tagline',
        'settings' => 'cta_button_url',
        'type'     => 'dropdown-pages',
    )));
    
    // Añadir un nuevo control de texto para el texto del botón CTA dentro de la sección "Identidad del sitio"
    $wp_customize->add_setting('cta_button_text', array(
        'default'   => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'cta_button_text', array(
        'label'    => __('CTA Button Text', 'mytheme'),
        'section'  => 'title_tagline', // Sección "Identidad del sitio"
        'settings' => 'cta_button_text',
        'type'     => 'text',
    )));
    
    // Añadir una nueva sección para scripts en el <head>
    $wp_customize->add_section('head_scripts_section', array(
        'title'    => __('Analytics Code', 'soodacode'),
        'priority' => 160,
    ));

    // Ajuste para el código de Google Analytics
    $wp_customize->add_setting('google_analytics_code', array(
        'default'           => '',
    ));

    // Control para el ajuste del código de Google Analytics
    $wp_customize->add_control('google_analytics_code', array(
        'label'       => __('Google Analytics Code', 'soodacode'),
        'section'     => 'head_scripts_section',
        'type'        => 'textarea', // Tipo de campo de texto para ingresar código
        'description' => __('Insert your Google Analytics tracking code here.', 'soodacode'),
    ));
}
add_action( 'customize_register', 'soodacode_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function soodacode_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function soodacode_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function soodacode_customize_preview_js() {
    wp_enqueue_script( 'soodacode-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'soodacode_customize_preview_js' );
