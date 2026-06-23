<?php
/**
 * Logo Cloud block helpers.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default demo logos (wordmark SVGs).
 *
 * @return array<int, array<string, string>>
 */
function agency_starter_logo_cloud_default_logos() {
	$base = get_template_directory_uri() . '/assets/images/placeholders/logos/';

	return array(
		array( 'url' => $base . 'client-01.svg', 'alt' => 'Nordvik' ),
		array( 'url' => $base . 'client-02.svg', 'alt' => 'Helix' ),
		array( 'url' => $base . 'client-03.svg', 'alt' => 'Meridian' ),
		array( 'url' => $base . 'client-04.svg', 'alt' => 'Vertex' ),
		array( 'url' => $base . 'client-05.svg', 'alt' => 'Axis' ),
		array( 'url' => $base . 'client-06.svg', 'alt' => 'Pulse' ),
		array( 'url' => $base . 'client-07.svg', 'alt' => 'Forge' ),
		array( 'url' => $base . 'client-08.svg', 'alt' => 'Lumen' ),
	);
}

/**
 * Normalize logo items from block attributes.
 *
 * @param mixed $logos Raw logos.
 * @return array<int, array<string, string>>
 */
function agency_starter_logo_cloud_normalize_logos( $logos ) {
	if ( ! is_array( $logos ) || empty( $logos ) ) {
		return agency_starter_logo_cloud_default_logos();
	}

	$normalized = array();

	foreach ( $logos as $logo ) {
		if ( ! is_array( $logo ) ) {
			continue;
		}

		$url = esc_url_raw( $logo['url'] ?? '' );
		$alt = sanitize_text_field( $logo['alt'] ?? '' );
		$id  = (int) ( $logo['id'] ?? 0 );

		if ( ! $url && $id > 0 ) {
			$url = (string) wp_get_attachment_image_url( $id, 'logo' );
		}

		if ( ! $url ) {
			continue;
		}

		$normalized[] = array(
			'id'  => $id,
			'url' => $url,
			'alt' => $alt ?: __( 'Client logo', 'agency-starter' ),
		);
	}

	return $normalized ?: agency_starter_logo_cloud_default_logos();
}
