<?php
/**
 * Block pattern categories and patterns.
 *
 * Pattern library layout:
 * - Core patterns: this file (`agency_starter_register_patterns`).
 * - Extended patterns: `patterns-more.php` via `agency_starter_get_extended_patterns()`.
 * - Synced global patterns: `synced-patterns.php` (wp_block posts).
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Markup for an empty Query Loop state.
 *
 * @param string $message Empty-state message (demo Lorem is intentional).
 * @return string
 */
function agency_starter_query_empty_pattern_content( $message ) {
	return sprintf(
		'<!-- wp:group {"className":"agency-query-empty","layout":{"type":"default"}} -->
<div class="wp-block-group agency-query-empty"><!-- wp:paragraph -->
<p>%s</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->',
		esc_html( $message )
	);
}

/**
 * Register pattern categories.
 */
function agency_starter_register_pattern_categories() {
	$categories = apply_filters(
		'agency_starter_pattern_categories',
		array(
			'corporate-hero'     => array(
				'label' => __( 'Corporate Hero', 'agency-starter' ),
			),
			'corporate-cta'      => array(
				'label' => __( 'Corporate CTA', 'agency-starter' ),
			),
			'corporate-trust'    => array(
				'label' => __( 'Corporate Trust', 'agency-starter' ),
			),
			'corporate-services' => array(
				'label' => __( 'Corporate Services', 'agency-starter' ),
			),
			'corporate-content'  => array(
				'label' => __( 'Corporate Content', 'agency-starter' ),
			),
			'corporate-archive'  => array(
				'label' => __( 'Corporate Archive', 'agency-starter' ),
			),
			'corporate-team'     => array(
				'label' => __( 'Corporate Team', 'agency-starter' ),
			),
			'corporate-nav'      => array(
				'label' => __( 'Corporate Navigation', 'agency-starter' ),
			),
		)
	);

	foreach ( $categories as $slug => $properties ) {
		register_block_pattern_category( $slug, $properties );
	}
}
add_action( 'init', 'agency_starter_register_pattern_categories' );

require_once get_template_directory() . '/inc/patterns-more.php';

/**
 * Register block patterns.
 */
function agency_starter_register_patterns() {
	$patterns = array_merge(
		array(
		array(
			'title'      => __( 'Hero Homepage', 'agency-starter' ),
			'slug'       => 'agency-starter/hero-homepage',
			'categories' => array( 'corporate-hero' ),
			'content'    => agency_starter_pattern_content_hero_homepage(),
		),
		array(
			'title'      => __( 'Hero Section', 'agency-starter' ),
			'slug'       => 'agency-starter/hero-section',
			'categories' => array( 'corporate-hero' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-hero","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-hero"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:paragraph {"className":"agency-eyebrow"} -->
<p class="agency-eyebrow">Lorem section</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"agency-hero__title"} -->
<h1 class="wp-block-heading agency-hero__title">Lorem ipsum section landing</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-lead"} -->
<p class="agency-lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"agency-hero__actions"} -->
<div class="wp-block-buttons agency-hero__actions"><!-- wp:button {"className":"agency-btn--employer"} -->
<div class="wp-block-button agency-btn--employer"><a class="wp-block-button__link wp-element-button">Lorem primary CTA</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Hero Minimal', 'agency-starter' ),
			'slug'       => 'agency-starter/hero-minimal',
			'categories' => array( 'corporate-hero' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--compact","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--compact"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:heading {"level":1,"className":"agency-hero__title"} -->
<h1 class="wp-block-heading agency-hero__title">Lorem ipsum minimal header</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-lead"} -->
<p class="agency-lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Hero Service', 'agency-starter' ),
			'slug'       => 'agency-starter/hero-service',
			'categories' => array( 'corporate-hero' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-hero","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-hero"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:columns {"className":"agency-hero-grid"} -->
<div class="wp-block-columns agency-hero-grid"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":1,"className":"agency-hero__title"} -->
<h1 class="wp-block-heading agency-hero__title">Lorem ipsum service detail</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-lead"} -->
<p class="agency-lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"sizeSlug":"large","className":"rounded-lg"} -->
<figure class="wp-block-image size-large rounded-lg">' . agency_starter_placeholder_img( 'hero' ) . '</figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Statistics Row', 'agency-starter' ),
			'slug'       => 'agency-starter/statistics-row',
			'categories' => array( 'corporate-trust' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--alt agency-section--compact agency-stat-grid","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--alt agency-section--compact agency-stat-grid"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"className":"agency-stat"} -->
<div class="wp-block-column agency-stat"><!-- wp:paragraph {"align":"center","className":"agency-stat__value"} -->
<p class="has-text-align-center agency-stat__value">20+</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","className":"agency-stat__label"} -->
<p class="has-text-align-center agency-stat__label">Lorem years experience</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-stat"} -->
<div class="wp-block-column agency-stat"><!-- wp:paragraph {"align":"center","className":"agency-stat__value"} -->
<p class="has-text-align-center agency-stat__value">500+</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","className":"agency-stat__label"} -->
<p class="has-text-align-center agency-stat__label">Lorem placements made</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-stat"} -->
<div class="wp-block-column agency-stat"><!-- wp:paragraph {"align":"center","className":"agency-stat__value"} -->
<p class="has-text-align-center agency-stat__value">98%</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","className":"agency-stat__label"} -->
<p class="has-text-align-center agency-stat__label">Lorem client satisfaction</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Contact CTA Band', 'agency-starter' ),
			'slug'       => 'agency-starter/contact-cta-band',
			'categories' => array( 'corporate-cta' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--dark agency-section--compact agency-cta-band","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--dark agency-section--compact agency-cta-band"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"agency-cta-band__text"} -->
<p class="agency-cta-band__text"><strong>Lorem ipsum dolor sit amet?</strong> Consectetur adipiscing elit sed do eiusmod tempor.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"agency-cta-band__meta"} -->
<p class="agency-cta-band__meta"><a href="tel:+4524864646">24 86 46 46</a> · <a href="mailto:lorem@example.com">lorem@example.com</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"right"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"agency-btn--on-dark"} -->
<div class="wp-block-button agency-btn--on-dark"><a class="wp-block-button__link wp-element-button">Lorem contact CTA</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Audience Split', 'agency-starter' ),
			'slug'       => 'agency-starter/audience-split',
			'categories' => array( 'corporate-cta' ),
			'content'    => agency_starter_pattern_content_audience_split(),
		),
		array(
			'title'      => __( 'Section Sub Navigation', 'agency-starter' ),
			'slug'       => 'agency-starter/section-sub-nav',
			'categories' => array( 'corporate-nav' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--compact","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--compact"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:group {"className":"agency-anchor-nav","layout":{"type":"default"}} -->
<div class="wp-block-group agency-anchor-nav"><!-- wp:navigation {"overlayMenu":"never","layout":{"type":"flex","justifyContent":"left"},"fontSize":"sm"} -->
<!-- wp:navigation-link {"label":"Lorem service A","url":"#"} /-->

<!-- wp:navigation-link {"label":"Lorem service B","url":"#"} /-->

<!-- wp:navigation-link {"label":"Lorem service C","url":"#"} /-->

<!-- wp:navigation-link {"label":"Lorem service D","url":"#"} /-->
<!-- /wp:navigation --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Service Grid', 'agency-starter' ),
			'slug'       => 'agency-starter/service-grid',
			'categories' => array( 'corporate-services' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--alt","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--alt"><!-- wp:group {"className":"agency-container agency-service-grid","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-service-grid"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum services</h2>
<!-- /wp:heading -->

<!-- wp:columns {"className":"agency-service-grid"} -->
<div class="wp-block-columns agency-service-grid"><!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem service one</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam id dolor id nibh ultricies vehicula.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"agency-card__actions"} -->
<p class="agency-card__actions"><a href="#">Lorem read more →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem service two</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean lacinia bibendum nulla sed consectetur.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"agency-card__actions"} -->
<p class="agency-card__actions"><a href="#">Lorem read more →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem service three</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ullamcorper nulla non metus auctor fringilla.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"agency-card__actions"} -->
<p class="agency-card__actions"><a href="#">Lorem read more →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'         => __( 'Job Card', 'agency-starter' ),
			'slug'          => 'agency-starter/job-card',
			'categories'    => array( 'corporate-archive' ),
			'blockTypes'    => array( 'core/template-part/post' ),
			'inserter'      => false,
			'content'       => '<!-- wp:group {"className":"agency-card agency-job-card","layout":{"type":"default"}} -->
<div class="wp-block-group agency-card agency-job-card"><!-- wp:post-title {"isLink":true,"level":3,"className":"agency-card__title"} /-->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"agency-starter/job-company"}}},"className":"agency-card__text"} -->
<p class="agency-card__text"></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"agency-starter/job-location"}}},"className":"agency-job-card__meta"} -->
<p class="agency-job-card__meta"></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"agency-starter/job-status"}}},"className":"agency-job-card__status"} -->
<p class="agency-job-card__status"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->',
		),
		array(
			'title'         => __( 'Post Card', 'agency-starter' ),
			'slug'          => 'agency-starter/post-card',
			'categories'    => array( 'corporate-archive' ),
			'blockTypes'    => array( 'core/template-part/post' ),
			'inserter'      => false,
			'content'       => '<!-- wp:group {"className":"agency-card agency-post-card","layout":{"type":"default"}} -->
<div class="wp-block-group agency-card agency-post-card"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","className":"agency-post-card__image"} /-->

<!-- wp:post-date {"className":"agency-post-card__date"} /-->

<!-- wp:post-title {"isLink":true,"level":3,"className":"agency-card__title"} /-->

<!-- wp:post-excerpt {"moreText":"Lorem read more","excerptLength":20,"className":"agency-card__text"} /--></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Job Apply CTA', 'agency-starter' ),
			'slug'       => 'agency-starter/job-apply-cta',
			'categories' => array( 'corporate-cta' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--alt agency-section--compact","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--alt agency-section--compact"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:group {"className":"agency-card agency-card--employer-tint","layout":{"type":"default"}} -->
<div class="wp-block-group agency-card agency-card--employer-tint"><!-- wp:heading {"level":2,"className":"agency-card__title"} -->
<h2 class="wp-block-heading agency-card__title">Lorem ipsum interested in this role?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Apply today and our consultants will be in touch.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"agency-card__actions"} -->
<div class="wp-block-buttons agency-card__actions"><!-- wp:button {"className":"agency-btn--employer"} -->
<div class="wp-block-button agency-btn--employer"><a class="wp-block-button__link wp-element-button">Lorem apply now</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"agency-btn--ghost"} -->
<div class="wp-block-button agency-btn--ghost"><a class="wp-block-button__link wp-element-button">Lorem view all jobs</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Contact Details', 'agency-starter' ),
			'slug'       => 'agency-starter/contact-details',
			'categories' => array( 'corporate-team' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum contact us</h2>
<!-- /wp:heading -->

<!-- wp:columns {"className":"agency-audience-grid"} -->
<div class="wp-block-columns agency-audience-grid"><!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:paragraph {"className":"agency-card__title"} -->
<p class="agency-card__title"><strong>Lorem Company Name</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum street 1<br>1234 Lorem City</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="tel:+4524864646">24 86 46 46</a><br><a href="mailto:lorem@example.com">lorem@example.com</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:paragraph {"className":"agency-card__title"} -->
<p class="agency-card__title"><strong>Lorem office hours</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Monday – Friday: 08:00 – 16:00<br>Saturday – Sunday: Closed</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Team Contact Cards', 'agency-starter' ),
			'slug'       => 'agency-starter/team-contact-cards',
			'categories' => array( 'corporate-team' ),
			'content'    => agency_starter_pattern_content_team_contact_cards(),
		),
		array(
			'title'      => __( 'Conversion Form Layout', 'agency-starter' ),
			'slug'       => 'agency-starter/conversion-form-layout',
			'categories' => array( 'corporate-cta' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--alt","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--alt"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:heading {"level":2,"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum get in touch</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-lead"} -->
<p class="agency-lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fill out the form below and we will respond within one business day.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"agency-form-placeholder"} -->
<p class="agency-form-placeholder">[Lorem form shortcode placeholder]</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"sm"} -->
<p class="has-sm-font-size">Lorem ipsum privacy notice. <a href="#">Lorem privacy policy</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Contact Form Section', 'agency-starter' ),
			'slug'       => 'agency-starter/contact-form-section',
			'categories' => array( 'corporate-cta' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--alt","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--alt"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:heading {"level":2,"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum get in touch</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-lead"} -->
<p class="agency-lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fill out the form below and we will respond within one business day.</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[agency_starter_contact_form]
<!-- /wp:shortcode -->

<!-- wp:paragraph {"fontSize":"sm"} -->
<p class="has-sm-font-size">Lorem ipsum privacy notice. <a href="#">Lorem privacy policy</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'CTA Banner', 'agency-starter' ),
			'slug'       => 'agency-starter/cta-banner',
			'categories' => array( 'corporate-cta' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--dark","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--dark"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Lorem ipsum ready to get started?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"agency-cta-band__text"} -->
<p class="has-text-align-center agency-cta-band__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Contact us today for a no-obligation conversation.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|xl"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--xl)"><!-- wp:button {"className":"agency-btn--on-dark"} -->
<div class="wp-block-button agency-btn--on-dark"><a class="wp-block-button__link wp-element-button">Lorem primary CTA</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'FAQ Section', 'agency-starter' ),
			'slug'       => 'agency-starter/faq-section',
			'categories' => array( 'corporate-content' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--alt","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--alt"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum frequently asked questions</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem ipsum question one?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem ipsum question two?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas faucibus mollis interdum. Cras mattis consectetur purus.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem ipsum question three?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel eu leo.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Knowledge Hub Layout', 'agency-starter' ),
			'slug'       => 'agency-starter/knowledge-hub-layout',
			'categories' => array( 'corporate-content' ),
			'content'    => '<!-- wp:pattern {"slug":"agency-starter/hero-minimal"} /--><!-- wp:pattern {"slug":"agency-starter/section-sub-nav"} /--><!-- wp:pattern {"slug":"agency-starter/resource-grid"} /-->',
		),
		array(
			'title'      => __( '404 Content', 'agency-starter' ),
			'slug'       => 'agency-starter/404-content',
			'categories' => array( 'corporate-content' ),
			'inserter'   => false,
			'content'    => sprintf(
				'<!-- wp:heading {"level":1,"className":"agency-hero__title"} -->
<h1 class="wp-block-heading agency-hero__title">%1$s</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-lead"} -->
<p class="agency-lead">%2$s</p>
<!-- /wp:paragraph -->

<!-- wp:search {"label":"%3$s","showLabel":false,"placeholder":"%4$s","buttonText":"%5$s"} /-->',
				esc_html__( 'Page not found', 'agency-starter' ),
				esc_html__( 'Lorem ipsum dolor sit amet. The page you requested could not be found.', 'agency-starter' ),
				esc_attr__( 'Search', 'agency-starter' ),
				esc_attr__( 'Search…', 'agency-starter' ),
				esc_html__( 'Search', 'agency-starter' )
			),
		),
		array(
			'title'      => __( 'Query Empty — News', 'agency-starter' ),
			'slug'       => 'agency-starter/query-empty-news',
			'categories' => array( 'corporate-archive' ),
			'inserter'   => false,
			'content'    => agency_starter_query_empty_pattern_content(
				__( 'Lorem ipsum no news items yet. Check back soon.', 'agency-starter' )
			),
		),
		array(
			'title'      => __( 'Query Empty — Articles', 'agency-starter' ),
			'slug'       => 'agency-starter/query-empty-articles',
			'categories' => array( 'corporate-archive' ),
			'inserter'   => false,
			'content'    => agency_starter_query_empty_pattern_content(
				__( 'Lorem ipsum no articles yet. Check back soon.', 'agency-starter' )
			),
		),
		array(
			'title'      => __( 'Query Empty — Posts', 'agency-starter' ),
			'slug'       => 'agency-starter/query-empty-posts',
			'categories' => array( 'corporate-archive' ),
			'inserter'   => false,
			'content'    => agency_starter_query_empty_pattern_content(
				__( 'Lorem ipsum no posts found yet.', 'agency-starter' )
			),
		),
		array(
			'title'      => __( 'Query Empty — Jobs', 'agency-starter' ),
			'slug'       => 'agency-starter/query-empty-jobs',
			'categories' => array( 'corporate-archive' ),
			'inserter'   => false,
			'content'    => agency_starter_query_empty_pattern_content(
				__( 'Lorem ipsum no jobs listed at the moment.', 'agency-starter' )
			),
		),
		array(
			'title'      => __( 'Query Empty — Search', 'agency-starter' ),
			'slug'       => 'agency-starter/query-empty-search',
			'categories' => array( 'corporate-archive' ),
			'inserter'   => false,
			'content'    => agency_starter_query_empty_pattern_content(
				__( 'Lorem ipsum no results matched your search.', 'agency-starter' )
			),
		),
		),
		agency_starter_get_extended_patterns()
	);

	foreach ( $patterns as $pattern ) {
		$args = array(
			'title'      => $pattern['title'],
			'categories' => $pattern['categories'],
			'content'    => $pattern['content'],
		);

		if ( isset( $pattern['blockTypes'] ) ) {
			$args['blockTypes'] = $pattern['blockTypes'];
		}

		if ( isset( $pattern['inserter'] ) ) {
			$args['inserter'] = $pattern['inserter'];
		}

		register_block_pattern( $pattern['slug'], $args );
	}
}
add_action( 'init', 'agency_starter_register_patterns' );
