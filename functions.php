<?php
/**
 * Agency Starter functions and definitions
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'AGENCY_STARTER_VERSION' ) ) {
	define( 'AGENCY_STARTER_VERSION', '0.1.0' );
}

if ( ! defined( 'AGENCY_STARTER_TYPOGRAPHY_CLASSES' ) ) {
	define(
		'AGENCY_STARTER_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

/**
 * Enable demo seeding (pages, menus, CF7, synced patterns) on theme activation.
 * Set to true in wp-config.php for local/staging demos only.
 */
if ( ! defined( 'AGENCY_STARTER_DEMO' ) ) {
	define( 'AGENCY_STARTER_DEMO', false );
}

/**
 * Tailwind Typography in TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function agency_starter_tinymce_add_class( $settings ) {
	$settings['body_class'] = AGENCY_STARTER_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'agency_starter_tinymce_add_class' );

/**
 * Limit heading levels in editor.
 *
 * @param array  $args Block type args.
 * @param string $block_type Block name.
 * @return array
 */
function agency_starter_modify_heading_levels( $args, $block_type ) {
	if ( 'core/heading' !== $block_type ) {
		return $args;
	}
	if ( isset( $args['attributes']['level'] ) ) {
		$args['attributes']['level']['default'] = 2;
	}
	return $args;
}
add_filter( 'register_block_type_args', 'agency_starter_modify_heading_levels', 10, 2 );

require get_template_directory() . '/inc/demo.php';
require get_template_directory() . '/inc/media.php';
require get_template_directory() . '/inc/performance.php';
require get_template_directory() . '/inc/heroicons.php';
require get_template_directory() . '/inc/usp-tabs.php';
require get_template_directory() . '/inc/hero-interactive.php';
require get_template_directory() . '/inc/media-slider.php';
require get_template_directory() . '/inc/logo-cloud.php';
require get_template_directory() . '/inc/content-block.php';
require get_template_directory() . '/inc/faq-section.php';
require get_template_directory() . '/inc/cta-glow.php';
require get_template_directory() . '/inc/blocks.php';
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/branding.php';
require get_template_directory() . '/inc/copy.php';
require get_template_directory() . '/inc/breadcrumbs.php';
require get_template_directory() . '/inc/schema.php';
require get_template_directory() . '/inc/polylang-i18n.php';
require get_template_directory() . '/inc/i18n-parts.php';
require get_template_directory() . '/inc/i18n-nav.php';
require get_template_directory() . '/inc/newsletter.php';
require get_template_directory() . '/inc/post-types.php';
require get_template_directory() . '/inc/post-archives.php';
require get_template_directory() . '/inc/block-bindings.php';
require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/synced-patterns.php';
require get_template_directory() . '/inc/patterns.php';
require get_template_directory() . '/inc/demo-content.php';
require get_template_directory() . '/inc/language-switcher.php';
require get_template_directory() . '/inc/cf7-forms.php';
require get_template_directory() . '/inc/plugins.php';
require get_template_directory() . '/inc/navigation.php';

