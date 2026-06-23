<?php
/**
 * Breadcrumb output — Yoast when available, theme fallback otherwise.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render breadcrumb trail HTML.
 *
 * @return string
 */
function agency_starter_get_breadcrumbs_html() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		ob_start();
		yoast_breadcrumb(
			'<nav class="agency-breadcrumbs__nav" aria-label="' . esc_attr__( 'Breadcrumbs', 'agency-starter' ) . '">',
			'</nav>'
		);
		$html = ob_get_clean();
		if ( is_string( $html ) && '' !== trim( $html ) ) {
			return $html;
		}
	}

	$items   = array();
	$items[] = array(
		'url'   => home_url( '/' ),
		'label' => __( 'Home', 'agency-starter' ),
	);

	if ( is_front_page() ) {
		return agency_starter_format_breadcrumb_nav( $items );
	}

	if ( is_singular() ) {
		$items[] = array(
			'url'   => '',
			'label' => get_the_title(),
		);
	} elseif ( is_search() ) {
		$items[] = array(
			'url'   => '',
			'label' => sprintf(
				/* translators: %s: search query */
				__( 'Search results for "%s"', 'agency-starter' ),
				get_search_query()
			),
		);
	} elseif ( is_archive() ) {
		$items[] = array(
			'url'   => '',
			'label' => wp_strip_all_tags( get_the_archive_title() ),
		);
	} elseif ( is_404() ) {
		$items[] = array(
			'url'   => '',
			'label' => __( 'Page not found', 'agency-starter' ),
		);
	}

	return agency_starter_format_breadcrumb_nav( $items );
}

/**
 * Format breadcrumb items as accessible nav markup.
 *
 * @param array<int, array{url: string, label: string}> $items Trail items.
 * @return string
 */
function agency_starter_format_breadcrumb_nav( $items ) {
	if ( empty( $items ) ) {
		return '';
	}

	$last_index = count( $items ) - 1;
	$parts      = array();

	foreach ( $items as $index => $item ) {
		$label = $item['label'];
		if ( $index === $last_index || '' === $item['url'] ) {
			$parts[] = '<span aria-current="page">' . esc_html( $label ) . '</span>';
			continue;
		}

		$parts[] = '<a href="' . esc_url( $item['url'] ) . '">' . esc_html( $label ) . '</a>';
	}

	return sprintf(
		'<nav class="agency-breadcrumbs__nav" aria-label="%1$s"><p class="has-muted-color has-text-color has-sm-font-size">%2$s</p></nav>',
		esc_attr__( 'Breadcrumbs', 'agency-starter' ),
		implode( ' / ', $parts )
	);
}

/**
 * Shortcode for block template parts.
 *
 * @return string
 */
function agency_starter_breadcrumbs_shortcode() {
	return agency_starter_get_breadcrumbs_html();
}
add_shortcode( 'agency_starter_breadcrumbs', 'agency_starter_breadcrumbs_shortcode' );
