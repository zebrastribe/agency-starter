<?php
/**
 * News and article archive query filters.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Category slug for news posts. */
define( 'AGENCY_STARTER_CAT_NEWS', 'nyhed' );

/** Category slug for long-form articles. */
define( 'AGENCY_STARTER_CAT_ARTICLES', 'artikel' );

/**
 * Query block namespace → category slug.
 *
 * @return array<string, string>
 */
function agency_starter_post_archive_namespace_map() {
	return array(
		'agency-starter/news'     => AGENCY_STARTER_CAT_NEWS,
		'agency-starter/articles' => AGENCY_STARTER_CAT_ARTICLES,
	);
}

/**
 * Page template → category slug for archive hub pages.
 *
 * @return array<string, string>
 */
function agency_starter_post_archive_page_templates() {
	return array(
		'page-archive-news'     => AGENCY_STARTER_CAT_NEWS,
		'page-archive-articles' => AGENCY_STARTER_CAT_ARTICLES,
	);
}

/**
 * Ensure news and article categories exist (idempotent).
 *
 * @return void
 */
function agency_starter_ensure_post_archive_terms() {
	if ( function_exists( 'agency_starter_ensure_term' ) ) {
		agency_starter_ensure_term( AGENCY_STARTER_CAT_ARTICLES, 'category' );
		agency_starter_ensure_term( AGENCY_STARTER_CAT_NEWS, 'category' );
		return;
	}

	foreach ( array( AGENCY_STARTER_CAT_ARTICLES, AGENCY_STARTER_CAT_NEWS ) as $slug ) {
		if ( ! term_exists( $slug, 'category' ) ) {
			wp_insert_term(
				ucfirst( $slug ),
				'category',
				array(
					'slug' => $slug,
				)
			);
		}
	}
}
add_action( 'after_switch_theme', 'agency_starter_ensure_post_archive_terms', 5 );

/**
 * Append a category tax_query clause to a Query Loop vars array.
 *
 * @param array  $query         Query vars.
 * @param string $category_slug Category slug.
 * @return array
 */
function agency_starter_apply_post_category_filter( $query, $category_slug ) {
	$term = get_term_by( 'slug', $category_slug, 'category' );
	if ( ! $term || is_wp_error( $term ) ) {
		return $query;
	}

	$tax_query   = isset( $query['tax_query'] ) && is_array( $query['tax_query'] ) ? $query['tax_query'] : array();
	$tax_query[] = array(
		'taxonomy' => 'category',
		'field'    => 'term_id',
		'terms'    => array( (int) $term->term_id ),
	);

	$query['tax_query'] = $tax_query;

	return $query;
}

/**
 * Filter Query Loop blocks to news/article categories.
 *
 * @param array    $query Query vars.
 * @param WP_Block $block Block instance.
 * @param int      $page  Current page.
 * @return array
 */
function agency_starter_filter_query_loop_block_query_vars( $query, $block, $page ) {
	unset( $page );

	$post_type = $query['postType'] ?? 'post';
	if ( 'post' !== $post_type ) {
		return $query;
	}

	$namespace = $query['namespace'] ?? '';
	$map       = agency_starter_post_archive_namespace_map();

	if ( $namespace && isset( $map[ $namespace ] ) ) {
		return agency_starter_apply_post_category_filter( $query, $map[ $namespace ] );
	}

	if ( is_singular( 'page' ) ) {
		$template  = get_page_template_slug( (int) get_queried_object_id() );
		$templates = agency_starter_post_archive_page_templates();

		if ( $template && isset( $templates[ $template ] ) ) {
			return agency_starter_apply_post_category_filter( $query, $templates[ $template ] );
		}
	}

	return $query;
}
add_filter( 'query_loop_block_query_vars', 'agency_starter_filter_query_loop_block_query_vars', 10, 3 );
