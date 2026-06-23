<?php
/**
 * Content Block helpers — two-column editorial section with image options.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default image URL for the content block.
 *
 * @return string
 */
function agency_starter_content_block_default_image_url() {
	return agency_starter_placeholder_url( 'wide' );
}

/**
 * Normalize block image attributes.
 *
 * @param array<string, mixed> $attributes Block attributes.
 * @return array{id: int, url: string, alt: string}
 */
function agency_starter_content_block_normalize_image( $attributes ) {
	$id  = (int) ( $attributes['imageId'] ?? 0 );
	$url = '';

	if ( $id > 0 ) {
		$url = (string) wp_get_attachment_image_url( $id, 'wide' );
	}

	if ( ! $url && ! empty( $attributes['imageUrl'] ) ) {
		$url = esc_url_raw( (string) $attributes['imageUrl'] );
	}

	if ( ! $url ) {
		$url = agency_starter_content_block_default_image_url();
	}

	$alt = sanitize_text_field( $attributes['imageAlt'] ?? '' );

	return array(
		'id'  => $id,
		'url' => $url,
		'alt' => $alt,
	);
}

/**
 * Allowed theme background colors for the content block.
 *
 * @return array<string, string> slug => CSS modifier class.
 */
function agency_starter_content_block_section_colors() {
	return array(
		'background'       => '',
		'surface-alt'      => 'agency-section--alt',
		'surface-dark'     => 'agency-section--dark',
		'primary-subtle'   => 'agency-content-block--primary-subtle',
		'secondary-subtle' => 'agency-content-block--secondary-subtle',
	);
}

/**
 * Resolve a section color slug to a modifier class.
 *
 * @param string $slug Color slug from block attributes.
 * @return string
 */
function agency_starter_content_block_section_color_class( $slug ) {
	$colors = agency_starter_content_block_section_colors();
	$slug   = sanitize_key( $slug );

	return $colors[ $slug ] ?? '';
}

/**
 * Whether the selected section color uses inverse (light) text.
 *
 * @param string $slug Color slug from block attributes.
 * @return bool
 */
function agency_starter_content_block_uses_inverse_text( $slug ) {
	return 'surface-dark' === sanitize_key( $slug );
}
