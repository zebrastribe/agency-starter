<?php
/**
 * Register theme blocks.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register a dedicated inserter category for theme blocks.
 *
 * @param array<int, array<string, mixed>> $categories Registered block categories.
 * @return array<int, array<string, mixed>>
 */
function agency_starter_register_block_category( $categories ) {
	return array_merge(
		array(
			array(
				'slug'  => 'agency-starter',
				'title' => __( 'Agency Starter', 'agency-starter' ),
				'icon'  => 'layout',
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'agency_starter_register_block_category' );

/**
 * Register view scripts for dynamic blocks (enqueued on render via block.json viewScript).
 */
function agency_starter_register_block_view_scripts() {
	$blocks = array(
		'agency-starter-usp-tabs'         => 'js/usp-tabs.min.js',
		'agency-starter-logo-cloud'       => 'js/logo-cloud.min.js',
		'agency-starter-hero-interactive' => 'js/hero-interactive.min.js',
		'agency-starter-media-slider'     => 'js/media-slider.min.js',
		'agency-starter-faq-section'      => 'js/faq-section.min.js',
	);

	foreach ( $blocks as $handle => $relative_path ) {
		wp_register_script(
			$handle,
			get_template_directory_uri() . '/' . $relative_path,
			array(),
			agency_starter_asset_version( $relative_path ),
			true
		);
	}
}
add_action( 'init', 'agency_starter_register_block_view_scripts', 9 );

/**
 * Register per-block stylesheets (loaded only when the block is present).
 *
 * @return void
 */
function agency_starter_register_block_styles() {
	$blocks = array(
		'agency-starter/usp-tabs'         => 'css/blocks/usp-tabs.css',
		'agency-starter/logo-cloud'       => 'css/blocks/logo-cloud.css',
		'agency-starter/hero-interactive' => 'css/blocks/hero-interactive.css',
		'agency-starter/media-slider'     => 'css/blocks/media-slider.css',
		'agency-starter/content-block'    => 'css/blocks/content-block.css',
		'agency-starter/faq-section'      => 'css/blocks/faq-section.css',
		'agency-starter/cta-glow'         => 'css/blocks/cta-glow.css',
	);

	foreach ( $blocks as $block_name => $relative_path ) {
		$handle = 'agency-starter-block-' . str_replace( '/', '-', $block_name );

		wp_register_style(
			$handle,
			get_template_directory_uri() . '/' . $relative_path,
			array(),
			agency_starter_asset_version( $relative_path )
		);

		wp_enqueue_block_style(
			$block_name,
			array(
				'handle' => $handle,
			)
		);
	}
}
add_action( 'init', 'agency_starter_register_block_styles', 10 );

/**
 * Register custom blocks from block.json metadata.
 */
function agency_starter_register_blocks() {
	register_block_type( get_template_directory() . '/blocks/usp-tabs' );
	register_block_type( get_template_directory() . '/blocks/logo-cloud' );
	register_block_type( get_template_directory() . '/blocks/hero-interactive' );
	register_block_type( get_template_directory() . '/blocks/media-slider' );
	register_block_type( get_template_directory() . '/blocks/content-block' );
	register_block_type( get_template_directory() . '/blocks/faq-section' );
	register_block_type( get_template_directory() . '/blocks/cta-glow' );
}
add_action( 'init', 'agency_starter_register_blocks' );

/**
 * Enqueue USP Tabs editor assets.
 */
function agency_starter_enqueue_usp_tabs_editor_assets() {
	if ( ! is_admin() ) {
		return;
	}

	wp_enqueue_script(
		'agency-starter-usp-tabs-editor',
		get_template_directory_uri() . '/js/usp-tabs-editor.min.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
		agency_starter_asset_version( 'js/usp-tabs-editor.min.js' ),
		true
	);
}
add_action( 'enqueue_block_assets', 'agency_starter_enqueue_usp_tabs_editor_assets' );

/**
 * Enqueue Logo Cloud editor assets.
 */
function agency_starter_enqueue_logo_cloud_editor_assets() {
	if ( ! is_admin() ) {
		return;
	}

	wp_enqueue_script(
		'agency-starter-logo-cloud-editor',
		get_template_directory_uri() . '/js/logo-cloud-editor.min.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
		agency_starter_asset_version( 'js/logo-cloud-editor.min.js' ),
		true
	);
}
add_action( 'enqueue_block_assets', 'agency_starter_enqueue_logo_cloud_editor_assets' );

/**
 * Enqueue Interactive Hero editor assets.
 */
function agency_starter_enqueue_hero_interactive_editor_assets() {
	if ( ! is_admin() ) {
		return;
	}

	wp_enqueue_script(
		'agency-starter-hero-interactive-editor',
		get_template_directory_uri() . '/js/hero-interactive-editor.min.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
		agency_starter_asset_version( 'js/hero-interactive-editor.min.js' ),
		true
	);
}
add_action( 'enqueue_block_assets', 'agency_starter_enqueue_hero_interactive_editor_assets' );

/**
 * Enqueue Media Slider editor assets.
 */
function agency_starter_enqueue_media_slider_editor_assets() {
	if ( ! is_admin() ) {
		return;
	}

	wp_enqueue_script(
		'agency-starter-media-slider-editor',
		get_template_directory_uri() . '/js/media-slider-editor.min.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
		agency_starter_asset_version( 'js/media-slider-editor.min.js' ),
		true
	);

	wp_localize_script(
		'agency-starter-media-slider-editor',
		'agencyStarterMediaSlider',
		array(
			'placeholderWide' => agency_starter_placeholder_url( 'wide' ),
		)
	);
}
add_action( 'enqueue_block_assets', 'agency_starter_enqueue_media_slider_editor_assets' );

/**
 * Enqueue Content Block editor assets.
 */
function agency_starter_enqueue_content_block_assets() {
	if ( ! is_admin() ) {
		return;
	}

	wp_enqueue_script(
		'agency-starter-content-block-editor',
		get_template_directory_uri() . '/js/content-block-editor.min.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
		agency_starter_asset_version( 'js/content-block-editor.min.js' ),
		true
	);
}
add_action( 'enqueue_block_assets', 'agency_starter_enqueue_content_block_assets' );

/**
 * Enqueue FAQ Section editor assets.
 */
function agency_starter_enqueue_faq_section_assets() {
	if ( ! is_admin() ) {
		return;
	}

	wp_enqueue_script(
		'agency-starter-faq-section-editor',
		get_template_directory_uri() . '/js/faq-section-editor.min.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
		agency_starter_asset_version( 'js/faq-section-editor.min.js' ),
		true
	);
}
add_action( 'enqueue_block_assets', 'agency_starter_enqueue_faq_section_assets' );

/**
 * Enqueue CTA Glow Card editor assets.
 */
function agency_starter_enqueue_cta_glow_assets() {
	if ( ! is_admin() ) {
		return;
	}

	wp_enqueue_script(
		'agency-starter-cta-glow-editor',
		get_template_directory_uri() . '/js/cta-glow-editor.min.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
		agency_starter_asset_version( 'js/cta-glow-editor.min.js' ),
		true
	);
}
add_action( 'enqueue_block_assets', 'agency_starter_enqueue_cta_glow_assets' );
