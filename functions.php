<?php
/**
 * soodacode functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package soodacode
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function soodacode_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on soodacode, use a find and replace
		* to change 'soodacode' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'soodacode', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'soodacode' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'soodacode_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'soodacode_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function soodacode_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'soodacode_content_width', 640 );
}
add_action( 'after_setup_theme', 'soodacode_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function soodacode_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'soodacode' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'soodacode' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'soodacode_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function soodacode_scripts() {
	wp_enqueue_style( 'soodacode-style', get_template_directory_uri() . '/css/main.css', array(), _S_VERSION );
	wp_enqueue_script( 'soodacode-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script('sooda-toc-scroll', get_template_directory_uri() . '/js/sooda-toc.js', array('jquery'), null, true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'soodacode_scripts' );

function soodacode_enqueue_media() {
    wp_enqueue_media();
    wp_enqueue_script('category-image-upload', get_template_directory_uri() . '/js/category-image-upload.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'soodacode_enqueue_media');
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Youtube features.
 */
require get_template_directory() . '/inc/youtube-settings.php';

/**
 * Custom profile images.
 */
require get_template_directory() . '/inc/custom-profile-picture.php';



/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Añadir campo de imagen a las categorías
function add_category_image_field() {
    ?>
    <div class="form-field">
        <label for="category_image"><?php _e('Category Image', 'soodacode'); ?></label>
        <input type="hidden" name="category_image" id="category_image" value="" />
        <div id="category-image-preview" style="max-width: 300px; max-height: 300px;"></div>
        <button type="button" class="upload-category-image button"><?php _e('Upload/Add image', 'soodacode'); ?></button>
    </div>
    <?php
}
add_action('category_add_form_fields', 'add_category_image_field', 10, 2);

function edit_category_image_field($term) {
    $category_image = get_term_meta($term->term_id, 'category_image', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="category_image"><?php _e('Category Image', 'soodacode'); ?></label>
        </th>
        <td>
            <input type="hidden" name="category_image" id="category_image" value="<?php echo esc_attr($category_image); ?>" />
            <div id="category-image-preview" style="max-width: 300px; max-height: 300px;">
                <?php if ($category_image): ?>
                    <img src="<?php echo esc_url($category_image); ?>" style="max-width: 100%; height: auto;" />
                <?php endif; ?>
            </div>
            <button type="button" class="upload-category-image button"><?php _e('Upload/Add image', 'soodacode'); ?></button>
            <button type="button" class="remove-category-image button"><?php _e('Remove image', 'soodacode'); ?></button>
        </td>
    </tr>
    <?php
}
add_action('category_edit_form_fields', 'edit_category_image_field', 10, 2);

function save_category_image($term_id) {
    if (isset($_POST['category_image']) && '' !== $_POST['category_image']) {
        $image = sanitize_text_field($_POST['category_image']);
        update_term_meta($term_id, 'category_image', $image);
    } else {
        delete_term_meta($term_id, 'category_image');
    }
}
add_action('edited_category', 'save_category_image', 10, 2);
add_action('create_category', 'save_category_image', 10, 2);

// Shortcode para la tabla de contenidos
function sooda_toc_shortcode() {
    global $post;
    $output = '<div class="sooda-toc"><span>' . __('Table of Contents', 'soodacode') . '</span><ul>';
    $content = $post->post_content;

    // Buscar y listar los H2 y H3
    if (preg_match_all('/<h([2-3])>(.*?)<\/h[2-3]>/', $content, $matches)) {
        foreach ($matches[0] as $key => $heading) {
            $level = $matches[1][$key];
            $title = strip_tags($matches[2][$key]);
            $anchor = sanitize_title($title);
            $output .= '<li class="toc-level-' . $level . '"><a href="#' . $anchor . '">' . $title . '</a></li>';
        }
    }

    $output .= '</ul></div>';
    return $output;
}
add_shortcode('sooda-toc', 'sooda_toc_shortcode');

// Agregar IDs a los H2 y H3 en el contenido
function sooda_add_id_to_headings($content) {
    $content = preg_replace_callback('/<h([2-3])>(.*?)<\/h[2-3]>/', function ($matches) {
        $level = $matches[1];
        $title = $matches[2];
        $anchor = sanitize_title($title);
        return '<h' . $level . ' id="' . $anchor . '">' . $title . '</h' . $level . '>';
    }, $content);

    return $content;
}
add_filter('the_content', 'sooda_add_id_to_headings');

// Insertar la imagen destacada antes del contenido del artículo
function sooda_insert_featured_image_before_content($content) {
    if (is_single() && has_post_thumbnail()) {
        $featured_image = get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'featured-image'));
        $content = $featured_image . $content;
    }

    return $content;
}
add_filter('the_content', 'sooda_insert_featured_image_before_content');

function allow_upload_svg($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    error_log('SVG MIME type added');
    return $mimes;
}
add_filter('upload_mimes', 'allow_upload_svg');

function github_button_shortcode() {
    $url = 'https://github.com/Fernandomr23/base-template';
    return '<a href="' . esc_url($url) . '" target="_blank" class="github-button"><button><i class="ri-code-s-slash-line"></i> Get the Base Template</button></a>';
}
add_shortcode('github_button', 'github_button_shortcode');

function codesooda_admin_color_scheme() {
  //Get the theme directory
  $theme_dir = get_stylesheet_directory_uri();

  //codesooda
  wp_admin_css_color( 'soodacode', __( 'Soodacode' ),
    $theme_dir . '/css/codesooda.css',
    array( '#282828', '#ffffff', '#c7ff24' , '#b586fc')
  );
}
add_action('admin_init', 'codesooda_admin_color_scheme');

