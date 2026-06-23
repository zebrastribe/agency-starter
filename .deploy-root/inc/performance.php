<?php
/**
 * Performance helpers — conditional asset loading.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the active header template part includes mobile navigation.
 *
 * @return bool
 */
function agency_starter_theme_uses_mobile_nav() {
	static $uses = null;

	if ( null !== $uses ) {
		return $uses;
	}

	$content = '';
	$part    = get_block_template( get_stylesheet() . '//header', 'wp_template_part' );

	if ( $part && ! empty( $part->content ) ) {
		$content = $part->content;
	} else {
		$path = get_template_directory() . '/parts/header.html';
		if ( is_readable( $path ) ) {
			$content = (string) file_get_contents( $path );
		}
	}

	$uses = str_contains( $content, 'mobile-nav-toggle' );

	return (bool) apply_filters( 'agency_starter_theme_uses_mobile_nav', $uses );
}

/**
 * Whether Tailwind Typography (prose) styles should load on this view.
 *
 * Marketing pages built from patterns skip prose; editorial templates use it.
 *
 * @return bool
 */
function agency_starter_needs_prose_styles() {
	if ( is_admin() ) {
		return false;
	}

	$needs = is_singular( array( 'post', 'job' ) );

	if ( ! $needs && is_page() ) {
		$needs = is_page_template( 'page-legal' );
	}

	return (bool) apply_filters( 'agency_starter_needs_prose_styles', $needs );
}
