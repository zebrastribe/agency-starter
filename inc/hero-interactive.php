<?php
/**
 * Interactive Hero block helpers (split hero + media slider).
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default slider slides.
 *
 * @return array<int, array<string, string>>
 */
function agency_starter_hero_interactive_default_slides() {
	$wide = agency_starter_placeholder_url( 'wide' );

	return array(
		array(
			'imageUrl'    => $wide,
			'label'       => __( 'Lorem Company', 'agency-starter' ),
			'quote'       => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'agency-starter' ),
			'attribution' => __( '— Lorem Name, Lorem Title', 'agency-starter' ),
		),
		array(
			'imageUrl'    => $wide,
			'label'       => __( 'Lorem Partner', 'agency-starter' ),
			'quote'       => __( 'Lorem ipsum sed do eiusmod tempor incididunt ut labore.', 'agency-starter' ),
			'attribution' => __( '— Lorem Person, Lorem Role', 'agency-starter' ),
		),
		array(
			'imageUrl'    => $wide,
			'label'       => __( 'Lorem Client', 'agency-starter' ),
			'quote'       => __( 'Lorem ipsum ut enim ad minim veniam quis nostrud.', 'agency-starter' ),
			'attribution' => __( '— Lorem Leader, Lorem Department', 'agency-starter' ),
		),
	);
}

/**
 * Normalize a single slide entry.
 *
 * @param array<string, mixed>  $slide     Raw slide.
 * @param array<string, string> $fallback Fallback slide.
 * @return array<string, string>
 */
function agency_starter_hero_interactive_normalize_slide( $slide, $fallback ) {
	if ( ! is_array( $slide ) ) {
		return $fallback;
	}

	$image_id = (int) ( $slide['imageId'] ?? 0 );
	$image    = '';

	if ( $image_id > 0 ) {
		$image = (string) wp_get_attachment_image_url( $image_id, 'hero' );
	}

	if ( ! $image && ! empty( $slide['imageUrl'] ) ) {
		$image = esc_url_raw( (string) $slide['imageUrl'] );
	} elseif ( ! $image && ! empty( $slide['url'] ) ) {
		$image = esc_url_raw( (string) $slide['url'] );
	}

	if ( ! $image ) {
		$image = $fallback['imageUrl'];
	}

	return array(
		'imageId'     => $image_id,
		'imageUrl'    => $image,
		'label'       => sanitize_text_field( ! empty( $slide['label'] ) ? $slide['label'] : $fallback['label'] ),
		'quote'       => sanitize_textarea_field( ! empty( $slide['quote'] ) ? $slide['quote'] : $fallback['quote'] ),
		'attribution' => sanitize_text_field( ! empty( $slide['attribution'] ) ? $slide['attribution'] : $fallback['attribution'] ),
	);
}

/**
 * Flatten legacy accordion items into slides.
 *
 * @param mixed $items Legacy items attribute.
 * @return array<int, array<string, string>>
 */
function agency_starter_hero_interactive_slides_from_items( $items ) {
	if ( ! is_array( $items ) || empty( $items ) ) {
		return array();
	}

	$slides   = array();
	$defaults = agency_starter_hero_interactive_default_slides();
	$fallback = $defaults[0];

	foreach ( $items as $index => $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}

		$item_fallback = $defaults[ $index ] ?? $fallback;
		$images        = array();

		if ( ! empty( $item['images'] ) && is_array( $item['images'] ) ) {
			foreach ( $item['images'] as $entry ) {
				if ( is_array( $entry ) && ! empty( $entry['url'] ) ) {
					$url = esc_url_raw( $entry['url'] );
				} elseif ( is_string( $entry ) && '' !== trim( $entry ) ) {
					$url = esc_url_raw( $entry );
				} else {
					continue;
				}
				if ( $url ) {
					$images[] = $url;
				}
			}
		}

		if ( empty( $images ) && ! empty( $item['imageUrl'] ) ) {
			$images[] = esc_url_raw( (string) $item['imageUrl'] );
		}

		if ( empty( $images ) ) {
			$images[] = $item_fallback['imageUrl'];
		}

		foreach ( $images as $image_url ) {
			$slides[] = array(
				'imageId'     => (int) ( $item['imageId'] ?? 0 ),
				'imageUrl'    => $image_url,
				'label'       => sanitize_text_field( $item['title'] ?? $item_fallback['label'] ),
				'quote'       => sanitize_textarea_field( $item['description'] ?? $item_fallback['quote'] ),
				'attribution' => $item_fallback['attribution'],
			);
		}
	}

	return $slides;
}

/**
 * Normalize slider slides from block attributes.
 *
 * @param mixed $slides Raw slides.
 * @param mixed $items  Legacy items attribute.
 * @return array<int, array<string, string>>
 */
function agency_starter_hero_interactive_normalize_slides( $slides, $items = array() ) {
	$defaults = agency_starter_hero_interactive_default_slides();

	if ( is_array( $slides ) && ! empty( $slides ) ) {
		$normalized = array();
		foreach ( $slides as $index => $slide ) {
			$fallback     = $defaults[ $index ] ?? $defaults[0];
			$normalized[] = agency_starter_hero_interactive_normalize_slide( $slide, $fallback );
		}
		return $normalized;
	}

	$legacy = agency_starter_hero_interactive_slides_from_items( $items );
	return ! empty( $legacy ) ? $legacy : $defaults;
}

/**
 * Allowed panel background colors (theme palette + white).
 *
 * @return array<string, string> slug => admin label.
 */
function agency_starter_hero_interactive_panel_colors() {
	return array(
		'background'       => __( 'Background (white)', 'agency-starter' ),
		'surface-alt'      => __( 'Surface alt', 'agency-starter' ),
		'surface-dark'     => __( 'Surface dark', 'agency-starter' ),
		'primary'          => __( 'Primary', 'agency-starter' ),
		'primary-subtle'   => __( 'Primary subtle', 'agency-starter' ),
		'secondary'        => __( 'Secondary', 'agency-starter' ),
		'secondary-subtle' => __( 'Secondary subtle', 'agency-starter' ),
		'accent'           => __( 'Accent', 'agency-starter' ),
	);
}

/**
 * Allowed heading accent colors.
 *
 * @return array<string, string> slug => admin label.
 */
function agency_starter_hero_interactive_accent_colors() {
	return array(
		'accent'     => __( 'Accent', 'agency-starter' ),
		'primary'    => __( 'Primary', 'agency-starter' ),
		'secondary'  => __( 'Secondary', 'agency-starter' ),
		'foreground' => __( 'Foreground', 'agency-starter' ),
		'background' => __( 'Background (white)', 'agency-starter' ),
	);
}

/**
 * Resolve a color slug to an allowed preset.
 *
 * @param string $slug Raw slug.
 * @param string $type panel|accent.
 * @return string
 */
function agency_starter_hero_interactive_color_preset( $slug, $type = 'panel' ) {
	$allowed = 'accent' === $type
		? array_keys( agency_starter_hero_interactive_accent_colors() )
		: array_keys( agency_starter_hero_interactive_panel_colors() );

	$slug   = sanitize_key( $slug );
	$fallback = 'accent' === $type ? 'secondary' : 'primary';

	return in_array( $slug, $allowed, true ) ? $slug : $fallback;
}

/**
 * Whether a panel color uses light (inverse) text.
 *
 * @param string $slug Color slug.
 * @return bool
 */
function agency_starter_hero_interactive_uses_inverse_text( $slug ) {
	$light_slugs = array(
		'background',
		'surface',
		'surface-alt',
		'primary-subtle',
		'secondary-subtle',
	);

	return ! in_array( sanitize_key( $slug ), $light_slugs, true );
}

/**
 * Build CSS custom properties for hero panel colors.
 *
 * @param string $content_color Content panel slug.
 * @param string $media_color   Media panel slug.
 * @param string $accent_color  Heading accent slug.
 * @return string
 */
function agency_starter_hero_interactive_color_style( $content_color, $media_color, $accent_color ) {
	return sprintf(
		'--agency-hero-interactive-content-bg:var(--wp--preset--color--%1$s);--agency-hero-interactive-media-bg:var(--wp--preset--color--%2$s);--agency-hero-interactive-accent:var(--wp--preset--color--%3$s);',
		esc_attr( $content_color ),
		esc_attr( $media_color ),
		esc_attr( $accent_color )
	);
}
