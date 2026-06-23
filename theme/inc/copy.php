<?php
/**
 * Demo pattern markup (Lorem placeholder content).
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Homepage hero pattern markup.
 *
 * @return string
 */
function agency_starter_pattern_content_hero_homepage() {
	return '<!-- wp:group {"align":"full","className":"agency-section agency-hero","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-hero"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:paragraph {"className":"agency-eyebrow"} -->
<p class="agency-eyebrow">Lorem recruitment partner</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"agency-hero__title"} -->
<h1 class="wp-block-heading agency-hero__title">Lorem ipsum dolor sit amet consectetur</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-lead"} -->
<p class="agency-lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"agency-hero__actions"} -->
<div class="wp-block-buttons agency-hero__actions"><!-- wp:button {"className":"agency-btn--employer"} -->
<div class="wp-block-button agency-btn--employer"><a class="wp-block-button__link wp-element-button">Lorem employer CTA</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"agency-btn--candidate"} -->
<div class="wp-block-button agency-btn--candidate"><a class="wp-block-button__link wp-element-button">Lorem candidate CTA</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->';
}

/**
 * Audience split pattern markup.
 *
 * @return string
 */
function agency_starter_pattern_content_audience_split() {
	return '<!-- wp:group {"align":"full","className":"agency-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:heading {"textAlign":"center","className":"agency-section__title"} -->
<h2 class="wp-block-heading has-text-align-center agency-section__title">Lorem ipsum audience pathways</h2>
<!-- /wp:heading -->

<!-- wp:columns {"className":"agency-audience-grid"} -->
<div class="wp-block-columns agency-audience-grid"><!-- wp:column {"className":"agency-card agency-card--employer-tint"} -->
<div class="wp-block-column agency-card agency-card--employer-tint"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem employers</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget risus varius blandit.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"agency-card__actions"} -->
<div class="wp-block-buttons agency-card__actions"><!-- wp:button {"className":"agency-btn--employer"} -->
<div class="wp-block-button agency-btn--employer"><a class="wp-block-button__link wp-element-button">Lorem employer path</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-card agency-card--candidate-tint"} -->
<div class="wp-block-column agency-card agency-card--candidate-tint"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem candidates</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras mattis consectetur purus sit amet fermentum.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"agency-card__actions"} -->
<div class="wp-block-buttons agency-card__actions"><!-- wp:button {"className":"agency-btn--candidate"} -->
<div class="wp-block-button agency-btn--candidate"><a class="wp-block-button__link wp-element-button">Lorem candidate path</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->';
}

/**
 * Trust statement pattern markup.
 *
 * @return string
 */
function agency_starter_pattern_content_trust_statement() {
	return '<!-- wp:group {"align":"full","className":"agency-section agency-section--compact agency-trust-statement","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--compact agency-trust-statement"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:paragraph {"align":"center","className":"agency-trust-statement__quote"} -->
<p class="has-text-align-center agency-trust-statement__quote">Lorem ipsum trusted by leading organisations across Denmark for more than 20 years.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->';
}

/**
 * Testimonial excerpt pattern markup.
 *
 * @return string
 */
function agency_starter_pattern_content_testimonial_excerpt() {
	return '<!-- wp:group {"align":"full","className":"agency-section agency-section--alt agency-section--compact","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--alt agency-section--compact"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:quote {"className":"agency-testimonial-excerpt"} -->
<blockquote class="wp-block-quote agency-testimonial-excerpt"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget risus varius blandit.</p><cite>Lorem Client Name</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->';
}

/**
 * Newsletter signup pattern markup.
 *
 * @return string
 */
function agency_starter_pattern_content_newsletter_signup() {
	return '<!-- wp:group {"align":"full","className":"agency-section agency-section--compact agency-newsletter","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--compact agency-newsletter"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:heading {"textAlign":"center","className":"agency-section__title"} -->
<h2 class="wp-block-heading has-text-align-center agency-section__title">Lorem ipsum stay informed</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"agency-lead"} -->
<p class="has-text-align-center agency-lead">Lorem ipsum dolor sit amet — monthly insights for employers and candidates.</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[agency_starter_newsletter]
<!-- /wp:shortcode -->

<!-- wp:paragraph {"align":"center","fontSize":"sm"} -->
<p class="has-text-align-center has-sm-font-size">Lorem ipsum privacy notice. <a href="/privacy-policy/">Lorem privacy policy</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->';
}

/**
 * Blog preview pattern markup.
 *
 * @return string
 */
function agency_starter_pattern_content_blog_preview() {
	return '<!-- wp:group {"align":"full","className":"agency-section agency-section--alt","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--alt"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum latest insights</h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":2,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","namespace":"agency-starter/articles"},"layout":{"type":"default"}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:pattern {"slug":"agency-starter/post-card"} /-->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:pattern {"slug":"agency-starter/query-empty-articles"} /-->
<!-- /wp:query-no-results -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|xl"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--xl)"><!-- wp:button {"url":"/articles/","className":"agency-btn--ghost"} -->
<div class="wp-block-button agency-btn--ghost"><a class="wp-block-button__link wp-element-button" href="/articles/">Lorem view all articles</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->';
}

/**
 * News preview pattern markup.
 *
 * @return string
 */
function agency_starter_pattern_content_news_preview() {
	return '<!-- wp:group {"align":"full","className":"agency-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum latest news</h2>
<!-- /wp:heading -->

<!-- wp:query {"queryId":5,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","namespace":"agency-starter/news"},"layout":{"type":"default"}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:pattern {"slug":"agency-starter/post-card"} /-->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:pattern {"slug":"agency-starter/query-empty-news"} /-->
<!-- /wp:query-no-results -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|xl"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--xl)"><!-- wp:button {"url":"/news/","className":"agency-btn--ghost"} -->
<div class="wp-block-button agency-btn--ghost"><a class="wp-block-button__link wp-element-button" href="/news/">Lorem view all news</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->';
}

/**
 * Contact CTA band pattern markup.
 *
 * @return string
 */
function agency_starter_pattern_content_contact_cta_band() {
	return '<!-- wp:group {"align":"full","className":"agency-section agency-section--dark agency-section--compact agency-cta-band","layout":{"type":"default"}} -->
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
<div class="wp-block-buttons"><!-- wp:button {"url":"/contact/","className":"agency-btn--on-dark"} -->
<div class="wp-block-button agency-btn--on-dark"><a class="wp-block-button__link wp-element-button" href="/contact/">Lorem contact CTA</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->';
}

/**
 * Statistics row pattern markup.
 *
 * @return string
 */
function agency_starter_pattern_content_statistics_row() {
	return '<!-- wp:group {"align":"full","className":"agency-section agency-section--alt agency-section--compact agency-stat-grid","layout":{"type":"default"}} -->
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
<!-- /wp:group -->';
}

/**
 * Default logo cloud band label.
 *
 * @return string
 */
function agency_starter_logo_cloud_default_label() {
	return 'Lorem ipsum companies grow with us';
}
