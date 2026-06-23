<?php
/**
 * CTA Glow Card block helpers.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Section background color slugs → modifier classes.
 *
 * @return array<string, string>
 */
function agency_starter_cta_glow_section_colors() {
	return array(
		'background'       => '',
		'surface-alt'      => 'agency-section--alt',
		'surface-dark'     => 'agency-section--dark',
		'primary-subtle'   => 'agency-cta-glow--primary-subtle',
		'secondary-subtle' => 'agency-cta-glow--secondary-subtle',
	);
}

/**
 * Accent glow color slugs → CSS custom property names.
 *
 * @return array<string, string>
 */
function agency_starter_cta_glow_accent_colors() {
	return array(
		'accent'    => 'accent',
		'primary'   => 'primary',
		'secondary' => 'secondary',
	);
}

/**
 * Resolve section color slug to a modifier class.
 *
 * @param string $slug Color slug.
 * @return string
 */
function agency_starter_cta_glow_section_color_class( $slug ) {
	$colors = agency_starter_cta_glow_section_colors();
	$slug   = sanitize_key( $slug );

	return $colors[ $slug ] ?? '';
}

/**
 * Resolve accent color slug to a theme preset slug.
 *
 * @param string $slug Accent slug.
 * @return string
 */
function agency_starter_cta_glow_accent_preset( $slug ) {
	$colors = agency_starter_cta_glow_accent_colors();
	$slug   = sanitize_key( $slug );

	return $colors[ $slug ] ?? 'accent';
}

/**
 * Resolve glow position slug to a modifier class.
 *
 * @param string $slug Position slug.
 * @return string
 */
function agency_starter_cta_glow_position_class( $slug ) {
	$map = array(
		'bottom-left'  => 'agency-cta-glow--glow-bl',
		'bottom-right' => 'agency-cta-glow--glow-br',
		'top-left'     => 'agency-cta-glow--glow-tl',
		'top-right'    => 'agency-cta-glow--glow-tr',
	);

	$slug = sanitize_key( $slug );

	return $map[ $slug ] ?? 'agency-cta-glow--glow-bl';
}
