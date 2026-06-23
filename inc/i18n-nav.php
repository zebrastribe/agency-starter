<?php
/**
 * Navigation label translations (Polylang / theme .mo).
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Translate primary/legal menu item titles.
 *
 * @param string $title Menu item title.
 * @return string
 */
function agency_starter_translate_nav_menu_title( $title ) {
	if ( is_admin() ) {
		return $title;
	}

	return agency_starter_t( (string) $title );
}
add_filter( 'nav_menu_item_title', 'agency_starter_translate_nav_menu_title', 10, 1 );

/**
 * Localized navigation label for theme renderers.
 *
 * @param string $title Menu item title.
 * @return string
 */
function agency_starter_nav_menu_label( $title ) {
	return agency_starter_t( (string) $title );
}

/**
 * Translate block navigation link labels (fallback for core/navigation blocks).
 *
 * @param string               $block_content Block HTML.
 * @param array<string, mixed> $block         Block data.
 * @return string
 */
function agency_starter_i18n_navigation_block( $block_content, $block ) {
	if ( 'core/navigation' !== ( $block['blockName'] ?? '' ) || is_admin() ) {
		return $block_content;
	}

	return agency_starter_pll_translate_html( $block_content );
}
add_filter( 'render_block', 'agency_starter_i18n_navigation_block', 9, 2 );
