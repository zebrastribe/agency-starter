<?php
/**
 * USP Tabs block helpers (Mantine Tabs vertical mapping).
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default tab items.
 *
 * @return array<int, array<string, string>>
 */
function agency_starter_usp_tabs_default_items() {
	$wide = agency_starter_placeholder_url( 'wide' );

	return array(
		array(
			'title'       => 'Lorem service one',
			'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.',
			'ctaLabel'    => 'Lorem learn more',
			'ctaUrl'      => '/employers/',
			'imageUrl'    => $wide,
			'icon'        => 'briefcase',
		),
		array(
			'title'       => 'Lorem service two',
			'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget risus varius blandit.',
			'ctaLabel'    => 'Lorem learn more',
			'ctaUrl'      => '/employers/',
			'imageUrl'    => $wide,
			'icon'        => 'user-group',
		),
		array(
			'title'       => 'Lorem service three',
			'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras mattis consectetur purus sit amet fermentum.',
			'ctaLabel'    => 'Lorem learn more',
			'ctaUrl'      => '/employers/',
			'imageUrl'    => $wide,
			'icon'        => 'currency-dollar',
		),
		array(
			'title'       => 'Lorem service four',
			'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed odio dui.',
			'ctaLabel'    => 'Lorem learn more',
			'ctaUrl'      => '/candidates/',
			'imageUrl'    => $wide,
			'icon'        => 'users',
		),
	);
}

/**
 * Normalize tab items from block attributes.
 *
 * @param mixed $items Raw items.
 * @return array<int, array<string, string>>
 */
function agency_starter_usp_tabs_normalize_items( $items ) {
	if ( ! is_array( $items ) || empty( $items ) ) {
		return agency_starter_usp_tabs_default_items();
	}

	$choices    = array_keys( agency_starter_heroicon_choices() );
	$normalized = array();
	$defaults   = agency_starter_usp_tabs_default_items();

	foreach ( $items as $index => $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}

		$fallback = $defaults[ $index ] ?? $defaults[0];
		$icon     = $item['icon'] ?? $fallback['icon'];
		if ( 'banknotes' === $icon ) {
			$icon = 'currency-dollar';
		}
		if ( ! in_array( $icon, $choices, true ) ) {
			$icon = $fallback['icon'];
		}

		$normalized[] = array(
			'title'       => sanitize_text_field( $item['title'] ?? $fallback['title'] ),
			'description' => sanitize_textarea_field( $item['description'] ?? $fallback['description'] ),
			'ctaLabel'    => sanitize_text_field( $item['ctaLabel'] ?? $fallback['ctaLabel'] ),
			'ctaUrl'      => esc_url_raw( $item['ctaUrl'] ?? $fallback['ctaUrl'] ),
			'imageId'     => (int) ( $item['imageId'] ?? 0 ),
			'imageUrl'    => esc_url_raw( ( $item['imageUrl'] ?? '' ) ? $item['imageUrl'] : $fallback['imageUrl'] ),
			'icon'        => $icon,
		);
	}

	return ! empty( $normalized ) ? $normalized : agency_starter_usp_tabs_default_items();
}
