<?php
/**
 * Polylang language switcher (globe + flag badge + code).
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inline flag SVG for supported languages.
 *
 * @param string $slug Language slug (da|en).
 * @return string
 */
function agency_starter_language_flag_svg( $slug ) {
	$slug = sanitize_key( $slug );

	if ( 'da' === $slug ) {
		return '<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><circle cx="10" cy="10" r="10" fill="#C8102E"/><rect x="8" y="0" width="4" height="20" fill="#fff"/><rect x="0" y="8" width="20" height="4" fill="#fff"/></svg>';
	}

	if ( 'en' === $slug ) {
		return '<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><defs><clipPath id="agency-lang-flag-uk"><circle cx="10" cy="10" r="10"/></clipPath></defs><g clip-path="url(#agency-lang-flag-uk)"><rect width="20" height="20" fill="#012169"/><path d="M0 0l20 20M20 0L0 20" stroke="#fff" stroke-width="3.2"/><path d="M0 0l20 20M20 0L0 20" stroke="#C8102E" stroke-width="1.6"/><rect x="8" y="0" width="4" height="20" fill="#fff"/><rect x="0" y="8" width="20" height="4" fill="#fff"/><rect x="9" y="0" width="2" height="20" fill="#C8102E"/><rect x="0" y="9" width="20" height="2" fill="#C8102E"/></g></svg>';
	}

	return '';
}

/**
 * Whether the custom language switcher should render.
 *
 * @return bool
 */
function agency_starter_language_switcher_available() {
	if ( ! function_exists( 'pll_the_languages' ) ) {
		return false;
	}

	$languages = pll_the_languages(
		array(
			'raw'                    => 1,
			'hide_if_empty'          => 0,
			'hide_if_no_translation' => 0,
		)
	);

	return is_array( $languages ) && count( $languages ) >= 2;
}

/**
 * Build the language switcher markup.
 *
 * Shows the current language; click navigates to the alternate language.
 *
 * @return string
 */
function agency_starter_language_switcher_markup() {
	if ( ! agency_starter_language_switcher_available() ) {
		return '';
	}

	$languages = pll_the_languages(
		array(
			'raw'                    => 1,
			'hide_if_empty'          => 0,
			'hide_if_no_translation' => 0,
			'display_names_as'       => 'slug',
		)
	);

	if ( empty( $languages ) || count( $languages ) < 2 ) {
		return '';
	}

	$current   = null;
	$alternate = null;

	foreach ( $languages as $language ) {
		if ( ! empty( $language['current_lang'] ) ) {
			$current = $language;
			continue;
		}

		if ( null === $alternate ) {
			$alternate = $language;
		}
	}

	if ( ! $current ) {
		$current = reset( $languages );
	}

	if ( ! $alternate ) {
		foreach ( $languages as $language ) {
			if ( empty( $language['current_lang'] ) ) {
				$alternate = $language;
				break;
			}
		}
	}

	if ( ! $current || ! $alternate || empty( $alternate['url'] ) ) {
		return '';
	}

	$current_slug   = sanitize_key( $current['slug'] );
	$alternate_slug = sanitize_key( $alternate['slug'] );
	$code           = strtoupper( $current_slug );
	$flag_svg       = agency_starter_language_flag_svg( $current_slug );
	$globe_svg      = agency_starter_heroicon( 'globe-alt', 'agency-lang-switch__globe' );

	$alternate_label = 'da' === $alternate_slug
		? __( 'Danish', 'agency-starter' )
		: ( 'en' === $alternate_slug ? __( 'English', 'agency-starter' ) : strtoupper( $alternate_slug ) );

	$aria_label = sprintf(
		/* translators: %s: target language name */
		__( 'Switch language to %s', 'agency-starter' ),
		$alternate_label
	);

	return sprintf(
		'<a class="agency-lang-switch" href="%1$s" lang="%2$s" hreflang="%2$s" aria-label="%3$s"><span class="agency-lang-switch__icon" aria-hidden="true">%4$s<span class="agency-lang-switch__flag">%5$s</span></span><span class="agency-lang-switch__code">%6$s</span></a>',
		esc_url( $alternate['url'] ),
		esc_attr( $alternate_slug ),
		esc_attr( $aria_label ),
		$globe_svg,
		$flag_svg,
		esc_html( $code )
	);
}

/**
 * Shortcode wrapper.
 *
 * @return string
 */
function agency_starter_language_switcher_shortcode() {
	return agency_starter_language_switcher_markup();
}
add_shortcode( 'agency_language_switcher', 'agency_starter_language_switcher_shortcode' );

/**
 * Replace Polylang block output with the custom switcher.
 *
 * @param string $block_content Rendered block HTML.
 * @param array  $block         Block data.
 * @return string
 */
function agency_starter_render_language_switcher_block( $block_content, $block ) {
	if ( 'polylang/language-switcher' !== ( $block['blockName'] ?? '' ) ) {
		return $block_content;
	}

	$markup = agency_starter_language_switcher_markup();

	return $markup ? $markup : $block_content;
}
add_filter( 'render_block', 'agency_starter_render_language_switcher_block', 10, 2 );

/**
 * Hide the utility-bar separator and Polylang block when no switcher is available.
 *
 * @param string $block_content Part HTML.
 * @param array  $block         Block data.
 * @return string
 */
function agency_starter_filter_header_utility_language_switcher( $block_content, $block ) {
	if ( ( $block['attrs']['slug'] ?? '' ) !== 'header-utility' ) {
		return $block_content;
	}

	if ( agency_starter_language_switcher_available() ) {
		return $block_content;
	}

	$block_content = preg_replace(
		'/<!-- wp:paragraph[^>]*-->\s*<p[^>]*>\|<\/p>\s*<!-- \/wp:paragraph -->\s*/',
		'',
		$block_content
	);
	$block_content = preg_replace(
		'/<!-- wp:polylang\/language-switcher[^\/]*\/-->\s*/',
		'',
		$block_content
	);
	$block_content = preg_replace(
		'/<!-- wp:paragraph[^>]*-->\s*<p class="[^"]*">\|<\/p>\s*<!-- \/wp:paragraph -->\s*/',
		'',
		$block_content
	);
	$block_content = preg_replace(
		'/<!-- wp:paragraph {"fontSize":"sm"} -->\s*<p class="[^"]*">\|<\/p>\s*<!-- \/wp:paragraph -->\s*/',
		'',
		$block_content
	);

	return $block_content;
}
add_filter( 'render_block_core/template-part', 'agency_starter_filter_header_utility_language_switcher', 8, 2 );
