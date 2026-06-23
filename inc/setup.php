<?php
/**
 * Theme setup: supports, menus, image sizes, capabilities.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme supports, navigation menus, and image sizes.
 */
function agency_starter_register_theme_support() {
	load_theme_textdomain( 'agency-starter', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 82,
			'width'       => 188,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	/* Relative path required: absolute URLs make WP fetch via HTTP (fails in Docker). */
	add_editor_style( 'style-editor.css' );

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


	// Block theme supports.
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'block-templates' );
	add_theme_support( 'block-template-parts' );

	$menus = apply_filters(
		'agency_starter_menus',
		array(
			'primary'        => __( 'Primary', 'agency-starter' ),
			'footer-a'       => __( 'Footer Column A', 'agency-starter' ),
			'footer-b'       => __( 'Footer Column B', 'agency-starter' ),
			'footer-company' => __( 'Footer Company', 'agency-starter' ),
			'legal'          => __( 'Legal', 'agency-starter' ),
		)
	);

	register_nav_menus( $menus );

	add_image_size( 'hero', 1920, 9999, false );
	add_image_size( 'card', 800, 9999, false );
	add_image_size( 'logo', 300, 9999, false );
}
add_action( 'after_setup_theme', 'agency_starter_register_theme_support' );

/**
 * Prevent non-administrators from editing theme options (Site Editor, Customizer).
 *
 * @param array  $caps    Required capabilities.
 * @param string $cap     Capability being checked.
 * @param int    $user_id User ID.
 * @param array  $args    Additional arguments.
 * @return array
 */
function agency_starter_restrict_edit_theme_options( $caps, $cap, $user_id, $args ) {
	if ( 'edit_theme_options' === $cap && ! user_can( $user_id, 'manage_options' ) ) {
		$caps[] = 'do_not_allow';
	}

	return $caps;
}
add_filter( 'map_meta_cap', 'agency_starter_restrict_edit_theme_options', 10, 4 );
