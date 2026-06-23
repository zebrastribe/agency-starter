<?php
/**
 * Synced pattern seeding (wp_block posts).
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slugs for patterns that must propagate globally.
 *
 * @return array<string, string> slug => title
 */
function agency_starter_get_synced_pattern_slugs() {
	return array(
		'contact-cta-band'    => __( 'Contact CTA Band', 'agency-starter' ),
		'statistics-row'      => __( 'Statistics Row', 'agency-starter' ),
		'trust-statement'     => __( 'Trust Statement', 'agency-starter' ),
		'team-contact-cards'  => __( 'Team Contact Cards', 'agency-starter' ),
		'newsletter-signup'   => __( 'Newsletter Signup', 'agency-starter' ),
		'testimonial-excerpt' => __( 'Testimonial Excerpt', 'agency-starter' ),
	);
}

/**
 * Get pattern markup by theme slug.
 *
 * @param string $slug Pattern slug without namespace.
 * @return string
 */
function agency_starter_get_pattern_markup_by_slug( $slug ) {
	$all = array_merge(
		array(
			array(
				'slug'    => 'agency-starter/contact-cta-band',
				'content' => agency_starter_pattern_content_contact_cta_band(),
			),
			array(
				'slug'    => 'agency-starter/statistics-row',
				'content' => agency_starter_pattern_content_statistics_row(),
			),
		),
		agency_starter_get_extended_patterns()
	);

	foreach ( $all as $pattern ) {
		$pattern_slug = str_replace( 'agency-starter/', '', $pattern['slug'] );
		if ( $pattern_slug === $slug ) {
			return $pattern['content'];
		}
	}

	// Team contact cards from main patterns file.
	if ( 'team-contact-cards' === $slug ) {
		return agency_starter_pattern_content_team_contact_cards();
	}

	return '';
}

/**
 * Team contact cards markup.
 *
 * @return string
 */
function agency_starter_pattern_content_team_contact_cards() {
	return '<!-- wp:group {"align":"full","className":"agency-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum meet the team</h2>
<!-- /wp:heading -->

<!-- wp:columns {"className":"agency-audience-grid"} -->
<div class="wp-block-columns agency-audience-grid"><!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:image {"width":"80px","sizeSlug":"thumbnail","className":"agency-team-card__avatar"} -->
<figure class="wp-block-image size-thumbnail is-resized agency-team-card__avatar">' . agency_starter_placeholder_img( 'avatar', array( 'width' => 80, 'height' => 80 ) ) . '</figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem Person One</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem role title</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="mailto:lorem1@example.com">lorem1@example.com</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:image {"width":"80px","sizeSlug":"thumbnail","className":"agency-team-card__avatar"} -->
<figure class="wp-block-image size-thumbnail is-resized agency-team-card__avatar">' . agency_starter_placeholder_img( 'avatar', array( 'width' => 80, 'height' => 80 ) ) . '</figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem Person Two</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem role title</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="mailto:lorem2@example.com">lorem2@example.com</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->';
}

/**
 * Seed synced wp_block posts for global patterns.
 */
function agency_starter_seed_synced_patterns() {
	if ( ! agency_starter_demo_enabled() ) {
		return;
	}

	$stored = get_option( 'agency_starter_synced_pattern_ids', array() );
	$slugs  = agency_starter_get_synced_pattern_slugs();

	foreach ( $slugs as $slug => $title ) {
		if ( isset( $stored[ $slug ] ) && get_post( (int) $stored[ $slug ] ) ) {
			continue;
		}

		$content = agency_starter_get_pattern_markup_by_slug( $slug );
		if ( '' === $content ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'    => 'wp_block',
				'post_title'   => $title,
				'post_name'    => 'agency-starter-' . $slug,
				'post_content' => $content,
				'post_status'  => 'publish',
			),
			true
		);

		if ( ! is_wp_error( $post_id ) && $post_id ) {
			update_post_meta( $post_id, 'wp_pattern_sync_status', 'synced' );
			$stored[ $slug ] = (int) $post_id;
		}
	}

	update_option( 'agency_starter_synced_pattern_ids', $stored );
}

/**
 * Refresh synced pattern post content from PHP definitions.
 */
function agency_starter_refresh_synced_patterns() {
	$stored = get_option( 'agency_starter_synced_pattern_ids', array() );
	$slugs  = agency_starter_get_synced_pattern_slugs();

	foreach ( $slugs as $slug => $title ) {
		if ( empty( $stored[ $slug ] ) ) {
			continue;
		}

		$content = agency_starter_get_pattern_markup_by_slug( $slug );
		if ( '' === $content ) {
			continue;
		}

		wp_update_post(
			array(
				'ID'           => (int) $stored[ $slug ],
				'post_content' => $content,
			)
		);
	}
}

/**
 * Return block ref markup for a synced pattern.
 *
 * @param string $slug Pattern slug.
 * @return string
 */
function agency_starter_synced_block_markup( $slug ) {
	$stored = get_option( 'agency_starter_synced_pattern_ids', array() );

	if ( empty( $stored[ $slug ] ) ) {
		return '<!-- wp:pattern {"slug":"agency-starter/' . $slug . '"} /-->';
	}

	return '<!-- wp:block {"ref":' . (int) $stored[ $slug ] . '} /-->';
}

add_action( 'after_switch_theme', 'agency_starter_seed_synced_patterns' );
