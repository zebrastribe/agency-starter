<?php
/**
 * Media Slider block helpers (full-width testimonial / showcase carousel).
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default section header copy (lorem placeholder).
 *
 * @return array{eyebrow: string, heading: string, intro: string}
 */
function agency_starter_media_slider_default_header() {
	return array(
		'eyebrow' => __( 'Lorem ipsum', 'agency-starter' ),
		'heading' => __( 'Dolor sit amet consectetur', 'agency-starter' ),
		'intro'   => __( 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.', 'agency-starter' ),
	);
}

/**
 * Default slides for editor and empty front-end state.
 *
 * @return array<int, array<string, string>>
 */
function agency_starter_media_slider_default_slides() {
	$wide = agency_starter_placeholder_url( 'wide' );

	return array(
		array(
			'imageUrl'  => $wide,
			'videoUrl'  => '',
			'title'     => __( 'Lorem Company', 'agency-starter' ),
			'body'      => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.', 'agency-starter' ),
			'ctaLabel'  => __( 'Learn more', 'agency-starter' ),
			'ctaUrl'    => '#',
		),
		array(
			'imageUrl'  => $wide,
			'videoUrl'  => '',
			'title'     => __( 'Lorem Partner', 'agency-starter' ),
			'body'      => __( 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.', 'agency-starter' ),
			'ctaLabel'  => __( 'Learn more', 'agency-starter' ),
			'ctaUrl'    => '#',
		),
		array(
			'imageUrl'  => $wide,
			'videoUrl'  => '',
			'title'     => __( 'Lorem Client', 'agency-starter' ),
			'body'      => __( 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 'agency-starter' ),
			'ctaLabel'  => __( 'Learn more', 'agency-starter' ),
			'ctaUrl'    => '#',
		),
	);
}

/**
 * Normalize one slide.
 *
 * @param array<string, mixed>  $slide     Raw slide.
 * @param array<string, string> $fallback Fallback slide.
 * @return array<string, string|int>
 */
function agency_starter_media_slider_normalize_slide( $slide, $fallback ) {
	if ( ! is_array( $slide ) ) {
		return $fallback;
	}

	$image_id = (int) ( $slide['imageId'] ?? 0 );
	$image    = '';

	if ( $image_id > 0 ) {
		$image = (string) wp_get_attachment_image_url( $image_id, 'card' );
	}

	if ( ! $image && ! empty( $slide['imageUrl'] ) ) {
		$image = esc_url_raw( (string) $slide['imageUrl'] );
	}

	if ( ! $image ) {
		$image = $fallback['imageUrl'];
	}

	$video = '';
	if ( ! empty( $slide['videoUrl'] ) ) {
		$video = esc_url_raw( (string) $slide['videoUrl'] );
	}

	$cta_url = ! empty( $slide['ctaUrl'] ) ? esc_url_raw( (string) $slide['ctaUrl'] ) : $fallback['ctaUrl'];
	if ( ! $cta_url ) {
		$cta_url = '#';
	}

	return array(
		'imageId'  => $image_id,
		'imageUrl' => $image,
		'videoUrl' => $video,
		'title'    => sanitize_text_field( ! empty( $slide['title'] ) ? $slide['title'] : $fallback['title'] ),
		'body'     => sanitize_textarea_field( ! empty( $slide['body'] ) ? $slide['body'] : $fallback['body'] ),
		'ctaLabel' => sanitize_text_field( ! empty( $slide['ctaLabel'] ) ? $slide['ctaLabel'] : $fallback['ctaLabel'] ),
		'ctaUrl'   => $cta_url,
	);
}

/**
 * Normalize slides from block attributes.
 *
 * @param mixed $slides Raw slides attribute.
 * @return array<int, array<string, string|int>>
 */
function agency_starter_media_slider_normalize_slides( $slides ) {
	$defaults = agency_starter_media_slider_default_slides();

	if ( ! is_array( $slides ) || empty( $slides ) ) {
		return $defaults;
	}

	$normalized = array();
	foreach ( $slides as $index => $slide ) {
		$fallback     = $defaults[ $index ] ?? $defaults[0];
		$normalized[] = agency_starter_media_slider_normalize_slide( $slide, $fallback );
	}

	return $normalized;
}
