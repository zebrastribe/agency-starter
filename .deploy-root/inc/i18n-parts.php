<?php
/**
 * Template-part UI translations (delegates to Polylang string translations).
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Translate static strings in block template parts at render time.
 *
 * @param string $block_content Part HTML.
 * @param array  $block         Block data.
 * @return string
 */
function agency_starter_i18n_template_part( $block_content, $block ) {
	$slug = $block['attrs']['slug'] ?? '';
	if ( ! $slug || is_admin() ) {
		return $block_content;
	}

	return agency_starter_pll_translate_html( $block_content );
}
add_filter( 'render_block_core/template-part', 'agency_starter_i18n_template_part', 9, 2 );

/**
 * Localized strings for front-end scripts.
 *
 * @return array<string, string>
 */
function agency_starter_frontend_i18n() {
	return array(
		'openMenu'  => agency_starter_t( 'Open menu' ),
		'closeMenu' => agency_starter_t( 'Close menu' ),
	);
}
