<?php
/**
 * Learning Curve.
 *
 * This file adds functions to the Learning Curve theme - A Genesis Child Theme
 *
 * @package Learning Curve
 * @author  Jeff Cleverley
 * @license GPL-2.0+
 * @link    http://github.com/JeffCleverley/LearningCurve
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
function genesis_sample_localization_setup(){
	load_child_theme_textdomain(
		'learning-curve',
		get_stylesheet_directory() . '/languages'
	);
}

// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the required WooCommerce styles and Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Add the Genesis Connect WooCommerce notice.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Learning Curve' );
define( 'CHILD_THEME_URL', 'http://github.com/JeffCleverley/LearningCurve' );
define( 'CHILD_THEME_VERSION', '0.1' );

// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
function genesis_sample_enqueue_scripts_styles() {

	wp_enqueue_style(
		'learning-curve-fonts',
		'//fonts.googleapis.com/css?family=Lobster+Two:700|Quicksand:400|Raleway:800',
		array(),
		CHILD_THEME_VERSION );

	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG )
		? ''
		: '.min';

	wp_enqueue_script(
		'learning-curve-responsive-menu',
		get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js",
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true );

	wp_localize_script(
		'learning-curve-responsive-menu',
		'genesis_responsive_menu',
		learning_curve_responsive_menu_settings()
	);

	$asset_file = '/js/fontawesome.js';
	wp_enqueue_script(
		'fontawesome',
		get_stylesheet_directory_uri() . $asset_file,
		array( ),
		CHILD_THEME_VERSION,
		true
	);

	$asset_file = '/js/packs/solid.js';
	wp_enqueue_script(
		'fontawesome-solid',
		get_stylesheet_directory_uri() . $asset_file,
		array( ),
		CHILD_THEME_VERSION,
		true
	);
}

// Define our responsive menu settings.
function learning_curve_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( '', 'learning-curve' ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( '', 'learning-curve' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array(
	'caption',
	'comment-form',
	'comment-list',
	'gallery',
	'search-form'
	)
);

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array(
	'404-page',
	'drop-down-menu',
	'headings',
	'rems',
	'search-form',
	'skip-links'
	)
);

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add Image Sizes.
add_image_size( 'featured-image', 720, 400, TRUE );
add_image_size( 'featured-width-soft-crop', 720 );
add_image_size( 'medium-large-soft-crop', 600 );

// Register the three useful image sizes for use in Add Media modal
add_filter( 'image_size_names_choose', 'learning_curve_custom_sizes' );
function learning_curve_custom_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'featured-width-soft-crop' => __( 'Featured Soft Crop' ),
		'medium-large-soft-crop' => __( 'Medium Large Soft Crop' ),
	) );
}

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array(
	'primary' => __( 'After Header Menu', 'learning-curve' ),
	'secondary' => __( 'Footer Menu', 'learning-curve' )
	)
);

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
function genesis_sample_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}

// Remove WP Emoji
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );