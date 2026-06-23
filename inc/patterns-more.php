<?php
/**
 * Additional block patterns (trust, services, content, nav).
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return extended pattern definitions.
 *
 * @return array<int, array<string, mixed>>
 */
function agency_starter_get_extended_patterns() {
	$logo = esc_url( get_template_directory_uri() . '/assets/images/placeholders/logo-slot.svg' );

	return array(
		array(
			'title'      => __( 'USP Tabs', 'agency-starter' ),
			'slug'       => 'agency-starter/usp-tabs',
			'categories' => array( 'corporate-services' ),
			'content' => '<!-- wp:agency-starter/usp-tabs {"align":"full"} /-->',
		),
		array(
			'title'      => __( 'Trust Statement', 'agency-starter' ),
			'slug'       => 'agency-starter/trust-statement',
			'categories' => array( 'corporate-trust' ),
			'content'    => agency_starter_pattern_content_trust_statement(),
		),
		array(
			'title'      => __( 'Logo Cloud', 'agency-starter' ),
			'slug'       => 'agency-starter/logo-cloud',
			'categories' => array( 'corporate-trust' ),
			'content'    => '<!-- wp:agency-starter/logo-cloud {"align":"full"} /-->',
		),
		array(
			'title'      => __( 'Testimonial Entry', 'agency-starter' ),
			'slug'       => 'agency-starter/testimonial-entry',
			'categories' => array( 'corporate-trust' ),
			'content'    => '<!-- wp:group {"className":"agency-testimonial","layout":{"type":"default"}} -->
<div class="wp-block-group agency-testimonial"><!-- wp:quote {"className":"agency-testimonial__quote"} -->
<blockquote class="wp-block-quote agency-testimonial__quote"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</p><cite>Lorem Person, Lorem Company</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Testimonial Excerpt', 'agency-starter' ),
			'slug'       => 'agency-starter/testimonial-excerpt',
			'categories' => array( 'corporate-trust' ),
			'content'    => agency_starter_pattern_content_testimonial_excerpt(),
		),
		array(
			'title'      => __( 'Testimonials Grid', 'agency-starter' ),
			'slug'       => 'agency-starter/testimonials-grid',
			'categories' => array( 'corporate-trust' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:heading {"textAlign":"center","className":"agency-section__title"} -->
<h2 class="wp-block-heading has-text-align-center agency-section__title">Lorem ipsum client stories</h2>
<!-- /wp:heading -->

<!-- wp:columns {"className":"agency-testimonials-grid"} -->
<div class="wp-block-columns agency-testimonials-grid"><!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:quote {"className":"agency-testimonial__quote"} -->
<blockquote class="wp-block-quote agency-testimonial__quote"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p><cite>Lorem Person One, Lorem Corp</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:quote {"className":"agency-testimonial__quote"} -->
<blockquote class="wp-block-quote agency-testimonial__quote"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod.</p><cite>Lorem Person Two, Lorem Corp</cite></blockquote>
<!-- /wp:quote --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Case List', 'agency-starter' ),
			'slug'       => 'agency-starter/case-list',
			'categories' => array( 'corporate-trust' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum case references</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"agency-case-list","layout":{"type":"default"}} -->
<div class="wp-block-group agency-case-list"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem Senior Developer placement</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Placed within 3 weeks for a lorem technology client.</p>
<!-- /wp:paragraph -->

<!-- wp:separator {"className":"agency-case-list__divider"} -->
<hr class="wp-block-separator agency-case-list__divider"/>
<!-- /wp:separator -->

<!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem Project Manager search</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. End-to-end recruitment for a lorem enterprise.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Feature Grid', 'agency-starter' ),
			'slug'       => 'agency-starter/feature-grid',
			'categories' => array( 'corporate-services' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section"><!-- wp:group {"className":"agency-container agency-service-grid","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-service-grid"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum why choose us</h2>
<!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem expertise</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Deep sector knowledge.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem network</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Access to qualified candidates.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem partnership</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Long-term client relationships.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Industry Grid', 'agency-starter' ),
			'slug'       => 'agency-starter/industry-grid',
			'categories' => array( 'corporate-services' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--alt","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--alt"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum industries</h2>
<!-- /wp:heading -->

<!-- wp:columns {"className":"agency-audience-grid"} -->
<div class="wp-block-columns agency-audience-grid"><!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem IT</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum developers, architects, and IT leaders.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem Finance</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum controllers, analysts, and finance managers.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem Engineering</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum engineers and technical specialists.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Process Steps', 'agency-starter' ),
			'slug'       => 'agency-starter/process-steps',
			'categories' => array( 'corporate-services' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum our process</h2>
<!-- /wp:heading -->

<!-- wp:columns {"className":"agency-process-steps"} -->
<div class="wp-block-columns agency-process-steps"><!-- wp:column {"className":"agency-process-step"} -->
<div class="wp-block-column agency-process-step"><!-- wp:paragraph {"className":"agency-process-step__number"} -->
<p class="agency-process-step__number">01</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem brief</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-process-step"} -->
<div class="wp-block-column agency-process-step"><!-- wp:paragraph {"className":"agency-process-step__number"} -->
<p class="agency-process-step__number">02</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem search</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-process-step"} -->
<div class="wp-block-column agency-process-step"><!-- wp:paragraph {"className":"agency-process-step__number"} -->
<p class="agency-process-step__number">03</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem placement</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Timeline', 'agency-starter' ),
			'slug'       => 'agency-starter/timeline',
			'categories' => array( 'corporate-services' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--alt","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--alt"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum our history</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"agency-timeline","layout":{"type":"default"}} -->
<div class="wp-block-group agency-timeline"><!-- wp:paragraph {"className":"agency-timeline__date"} -->
<p class="agency-timeline__date">2004</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem company founded</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"agency-timeline__date"} -->
<p class="agency-timeline__date">2015</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem national expansion</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Pricing Guidance', 'agency-starter' ),
			'slug'       => 'agency-starter/pricing-guidance',
			'categories' => array( 'corporate-services' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum pricing</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-lead"} -->
<p class="agency-lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Every engagement is tailored — contact us for a no-obligation conversation.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"className":"agency-hero__actions"} -->
<div class="wp-block-buttons agency-hero__actions"><!-- wp:button {"url":"/employers/","className":"agency-btn--employer"} -->
<div class="wp-block-button agency-btn--employer"><a class="wp-block-button__link wp-element-button">Lorem request quote</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Knowledge Article Layout', 'agency-starter' ),
			'slug'       => 'agency-starter/knowledge-article-layout',
			'categories' => array( 'corporate-content' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:heading {"level":1,"className":"agency-hero__title"} -->
<h1 class="wp-block-heading agency-hero__title">Lorem ipsum resource article</h1>
<!-- /wp:heading -->

<!-- wp:pattern {"slug":"agency-starter/section-sub-nav"} /-->

<!-- wp:paragraph {"className":"agency-lead"} -->
<p class="agency-lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent commodo cursus magna.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Resource Grid', 'agency-starter' ),
			'slug'       => 'agency-starter/resource-grid',
			'categories' => array( 'corporate-content' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--alt","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--alt"><!-- wp:group {"className":"agency-container agency-service-grid","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-service-grid"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum resources</h2>
<!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem guide one</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="/knowledge-hub/">Lorem read more →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem guide two</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="/knowledge-hub/">Lorem read more →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"agency-card"} -->
<div class="wp-block-column agency-card"><!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem guide three</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="/knowledge-hub/">Lorem read more →</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Downloads List', 'agency-starter' ),
			'slug'       => 'agency-starter/downloads-list',
			'categories' => array( 'corporate-content' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum downloads</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"agency-card","layout":{"type":"default"}} -->
<div class="wp-block-group agency-card"><!-- wp:paragraph -->
<p><strong>Lorem resource PDF</strong> — Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href="/knowledge-hub/">Lorem download</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"agency-card","layout":{"type":"default"}} -->
<div class="wp-block-group agency-card"><!-- wp:paragraph -->
<p><strong>Lorem checklist PDF</strong> — Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href="/knowledge-hub/">Lorem download</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Related Content', 'agency-starter' ),
			'slug'       => 'agency-starter/related-content',
			'categories' => array( 'corporate-content' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--alt agency-section--compact","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--alt agency-section--compact"><!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container"><!-- wp:heading {"className":"agency-section__title"} -->
<h2 class="wp-block-heading agency-section__title">Lorem ipsum related</h2>
<!-- /wp:heading -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph -->
<p><a href="/articles/">Lorem related article one</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph -->
<p><a href="/articles/">Lorem related article two</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph -->
<p><a href="/knowledge-hub/">Lorem related resource</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Blog Preview', 'agency-starter' ),
			'slug'       => 'agency-starter/blog-preview',
			'categories' => array( 'corporate-archive' ),
			'content'    => agency_starter_pattern_content_blog_preview(),
		),
		array(
			'title'      => __( 'News Preview', 'agency-starter' ),
			'slug'       => 'agency-starter/news-preview',
			'categories' => array( 'corporate-archive' ),
			'content'    => agency_starter_pattern_content_news_preview(),
		),
		array(
			'title'      => __( 'CTA Inline', 'agency-starter' ),
			'slug'       => 'agency-starter/cta-inline',
			'categories' => array( 'corporate-cta' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--compact agency-cta-inline","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--compact agency-cta-inline"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:heading {"textAlign":"center","level":3} -->
<h3 class="wp-block-heading has-text-align-center">Lorem ipsum ready to discuss your needs?</h3>
<!-- /wp:heading -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"url":"/employers/","className":"agency-btn--employer"} -->
<div class="wp-block-button agency-btn--employer"><a class="wp-block-button__link wp-element-button" href="/contact/">Lorem contact us</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Newsletter Signup', 'agency-starter' ),
			'slug'       => 'agency-starter/newsletter-signup',
			'categories' => array( 'corporate-cta' ),
			'content'    => agency_starter_pattern_content_newsletter_signup(),
		),
		array(
			'title'      => __( 'Location Card', 'agency-starter' ),
			'slug'       => 'agency-starter/location-card',
			'categories' => array( 'corporate-team' ),
			'content'    => '<!-- wp:group {"align":"full","className":"agency-section agency-section--alt agency-section--compact","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section agency-section--alt agency-section--compact"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:group {"className":"agency-card","layout":{"type":"default"}} -->
<div class="wp-block-group agency-card"><!-- wp:image {"sizeSlug":"large","className":"agency-location-card__image rounded-lg"} -->
<figure class="wp-block-image size-large agency-location-card__image rounded-lg">' . agency_starter_placeholder_img( 'wide' ) . '</figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"className":"agency-card__title"} -->
<h3 class="wp-block-heading agency-card__title">Lorem Copenhagen office</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"agency-card__text"} -->
<p class="agency-card__text">Lorem ipsum street 1<br>1234 Lorem City<br><a href="/contact/">Lorem directions</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		),
		array(
			'title'      => __( 'Anchor Nav', 'agency-starter' ),
			'slug'       => 'agency-starter/anchor-nav',
			'categories' => array( 'corporate-nav' ),
			'content'    => '<!-- wp:group {"className":"agency-anchor-nav","layout":{"type":"default"}} -->
<div class="wp-block-group agency-anchor-nav"><!-- wp:navigation {"overlayMenu":"never","layout":{"type":"flex","justifyContent":"left"},"fontSize":"sm"} -->
<!-- wp:navigation-link {"label":"Lorem section one","url":"#lorem-one"} /-->
<!-- wp:navigation-link {"label":"Lorem section two","url":"#lorem-two"} /-->
<!-- wp:navigation-link {"label":"Lorem section three","url":"#lorem-three"} /-->
<!-- /wp:navigation --></div>
<!-- /wp:group -->',
		),
	);
}
