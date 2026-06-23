<?php
/**
 * Demo content seeding and upgrades.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AGENCY_STARTER_DEMO_VERSION', 15 );

/**
 * Homepage pattern composition (editorial flow).
 *
 * @return string
 */
function agency_starter_homepage_content() {
	$parts = array(
		'<!-- wp:agency-starter/hero-interactive {"align":"full","fullViewport":true} /-->',
		agency_starter_synced_block_markup( 'statistics-row' ),
		'<!-- wp:agency-starter/logo-cloud {"align":"full"} /-->',
		'<!-- wp:agency-starter/media-slider {"align":"full"} /-->',
		'<!-- wp:agency-starter/usp-tabs {"align":"full"} /-->',
		'<!-- wp:pattern {"slug":"agency-starter/audience-split"} /-->',
		agency_starter_synced_block_markup( 'trust-statement' ),
		agency_starter_synced_block_markup( 'testimonial-excerpt' ),
		'<!-- wp:pattern {"slug":"agency-starter/blog-preview"} /-->',
		'<!-- wp:pattern {"slug":"agency-starter/news-preview"} /-->',
		agency_starter_synced_block_markup( 'newsletter-signup' ),
		agency_starter_synced_block_markup( 'contact-cta-band' ),
	);

	return implode( '', $parts );
}

/**
 * Contact page pattern composition.
 *
 * @return string
 */
function agency_starter_contact_page_content() {
	return implode(
		'',
		array(
			'<!-- wp:pattern {"slug":"agency-starter/hero-minimal"} /-->',
			'<!-- wp:pattern {"slug":"agency-starter/contact-details"} /-->',
			'<!-- wp:pattern {"slug":"agency-starter/location-card"} /-->',
			agency_starter_synced_block_markup( 'team-contact-cards' ),
			'<!-- wp:pattern {"slug":"agency-starter/contact-form-section"} /-->',
		)
	);
}

/**
 * Employers / Candidates landing page composition.
 *
 * @return string
 */
function agency_starter_landing_page_content() {
	return implode(
		'',
		array(
			'<!-- wp:pattern {"slug":"agency-starter/hero-section"} /-->',
			'<!-- wp:pattern {"slug":"agency-starter/section-sub-nav"} /-->',
			'<!-- wp:pattern {"slug":"agency-starter/service-grid"} /-->',
			agency_starter_synced_block_markup( 'testimonial-excerpt' ),
			agency_starter_synced_block_markup( 'contact-cta-band' ),
		)
	);
}

/**
 * Knowledge hub page composition.
 *
 * @return string
 */
function agency_starter_knowledge_hub_content() {
	return implode(
		'',
		array(
			'<!-- wp:pattern {"slug":"agency-starter/hero-minimal"} /-->',
			'<!-- wp:pattern {"slug":"agency-starter/section-sub-nav"} /-->',
			'<!-- wp:pattern {"slug":"agency-starter/resource-grid"} /-->',
			agency_starter_synced_block_markup( 'contact-cta-band' ),
		)
	);
}

/**
 * About page composition.
 *
 * @return string
 */
function agency_starter_about_page_content() {
	return implode(
		'',
		array(
			'<!-- wp:pattern {"slug":"agency-starter/hero-section"} /-->',
			agency_starter_synced_block_markup( 'trust-statement' ),
			'<!-- wp:pattern {"slug":"agency-starter/timeline"} /-->',
			'<!-- wp:agency-starter/logo-cloud {"align":"full"} /-->',
			agency_starter_synced_block_markup( 'team-contact-cards' ),
		)
	);
}

/**
 * Testimonials page composition.
 *
 * @return string
 */
function agency_starter_testimonials_page_content() {
	return implode(
		'',
		array(
			'<!-- wp:pattern {"slug":"agency-starter/hero-minimal"} /-->',
			'<!-- wp:pattern {"slug":"agency-starter/testimonials-grid"} /-->',
			agency_starter_synced_block_markup( 'contact-cta-band' ),
		)
	);
}

/**
 * References page composition.
 *
 * @return string
 */
function agency_starter_references_page_content() {
	return implode(
		'',
		array(
			'<!-- wp:pattern {"slug":"agency-starter/hero-minimal"} /-->',
			'<!-- wp:pattern {"slug":"agency-starter/case-list"} /-->',
			agency_starter_synced_block_markup( 'contact-cta-band' ),
		)
	);
}

/**
 * Conversion form page composition.
 *
 * @return string
 */
function agency_starter_conversion_page_content() {
	return implode(
		'',
		array(
			'<!-- wp:pattern {"slug":"agency-starter/conversion-form-layout"} /-->',
			agency_starter_synced_block_markup( 'trust-statement' ),
		)
	);
}

/**
 * Privacy policy page composition.
 *
 * @return string
 */
function agency_starter_privacy_page_content() {
	return implode(
		'',
		array(
			'<!-- wp:pattern {"slug":"agency-starter/hero-minimal"} /-->',
			'<!-- wp:group {"align":"full","className":"agency-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:paragraph -->
<p>' . esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'agency-starter' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
		)
	);
}

/**
 * Update an existing demo page's block content.
 *
 * @param string $slug    Page slug.
 * @param string $content Block content.
 * @return void
 */
function agency_starter_update_demo_page( $slug, $content ) {
	$page = get_page_by_path( $slug );
	if ( ! $page ) {
		return;
	}

	wp_update_post(
		array(
			'ID'           => $page->ID,
			'post_content' => $content,
			'post_status'  => 'publish',
		)
	);
}

/**
 * Demo page → template map.
 *
 * @return array<string, string>
 */
function agency_starter_demo_page_templates() {
	return array(
		'contact'        => 'page-contact',
		'employers'      => 'page-section-landing',
		'candidates'     => 'page-section-landing',
		'about'          => 'page-section-landing',
		'testimonials'   => 'page-section-landing',
		'references'     => 'page-section-landing',
		'knowledge-hub'  => 'page-knowledge-hub',
		'employer-form'  => 'page-conversion',
		'candidate-form' => 'page-conversion',
		'articles'       => 'page-archive-articles',
		'news'           => 'page-archive-news',
		'privacy-policy' => 'page-legal',
	);
}

/**
 * Assign block templates to demo pages.
 *
 * @return void
 */
function agency_starter_assign_demo_page_templates() {
	foreach ( agency_starter_demo_page_templates() as $slug => $template ) {
		$page = get_page_by_path( $slug );
		if ( ! $page ) {
			continue;
		}

		update_post_meta( $page->ID, '_wp_page_template', $template );
	}
}

/**
 * Seed demo pages, jobs, posts, menus on first activation.
 */
function agency_starter_seed_demo_content() {
	if ( ! agency_starter_demo_enabled() ) {
		return;
	}

	if ( get_option( 'agency_starter_demo_seeded' ) ) {
		agency_starter_maybe_upgrade_demo();
		return;
	}

	agency_starter_seed_synced_patterns();

	$home_id = agency_starter_create_demo_page(
		'Home',
		'home',
		agency_starter_homepage_content()
	);

	agency_starter_create_demo_page(
		'Employers',
		'employers',
		agency_starter_landing_page_content(),
		'page-section-landing'
	);

	agency_starter_create_demo_page(
		'Candidates',
		'candidates',
		agency_starter_landing_page_content(),
		'page-section-landing'
	);

	agency_starter_create_demo_page(
		'Contact',
		'contact',
		agency_starter_contact_page_content(),
		'page-contact'
	);

	agency_starter_create_demo_page(
		'Employer Form',
		'employer-form',
		agency_starter_conversion_page_content(),
		'page-conversion'
	);

	agency_starter_create_demo_page(
		'Candidate Form',
		'candidate-form',
		agency_starter_conversion_page_content(),
		'page-conversion'
	);

	agency_starter_create_demo_page(
		'Knowledge Hub',
		'knowledge-hub',
		agency_starter_knowledge_hub_content(),
		'page-knowledge-hub'
	);

	agency_starter_create_demo_page(
		'Articles',
		'articles',
		'',
		'page-archive-articles'
	);

	agency_starter_create_demo_page(
		'News',
		'news',
		'',
		'page-archive-news'
	);

	agency_starter_create_demo_page(
		'Testimonials',
		'testimonials',
		agency_starter_testimonials_page_content(),
		'page-section-landing'
	);

	agency_starter_create_demo_page(
		'References',
		'references',
		agency_starter_references_page_content(),
		'page-section-landing'
	);

	agency_starter_create_demo_page(
		'About',
		'about',
		agency_starter_about_page_content(),
		'page-section-landing'
	);

	agency_starter_create_demo_page(
		'Privacy Policy',
		'privacy-policy',
		agency_starter_privacy_page_content(),
		'page-legal'
	);

	$artikel_id = agency_starter_ensure_term( 'artikel', 'category' );
	$nyhed_id   = agency_starter_ensure_term( 'nyhed', 'category' );

	$job_titles = array(
		'Lorem job title one',
		'Lorem job title two',
		'Lorem job title three',
		'Lorem job title four',
		'Lorem job title five',
		'Lorem job title six',
		'Lorem job title seven',
	);

	$companies = array(
		'Lorem company one',
		'Lorem company two',
		'Lorem company three',
		'Lorem company four',
		'Lorem company five',
		'Lorem company six',
		'Lorem company seven',
	);
	$locations = array(
		'Lorem city one',
		'Lorem city two',
		'Lorem city three',
		'Lorem remote',
		'Lorem hybrid',
		'Lorem city four',
		'Lorem city five',
	);
	$statuses  = array(
		'Lorem open',
		'Lorem open',
		'Lorem open',
		'Lorem closed',
		'Lorem open',
		'Lorem open',
		'Lorem open',
	);

	foreach ( $job_titles as $index => $title ) {
		$job_id = wp_insert_post(
			array(
				'post_title'   => $title,
				'post_name'    => sanitize_title( $title ),
				'post_status'  => 'publish',
				'post_type'    => 'job',
				'post_content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
				'post_excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			)
		);

		if ( $job_id && ! is_wp_error( $job_id ) ) {
			update_post_meta( $job_id, 'job_company', $companies[ $index ] );
			update_post_meta( $job_id, 'job_location', $locations[ $index ] );
			update_post_meta( $job_id, 'job_status', $statuses[ $index ] );
		}
	}

	$article_titles = array(
		'Lorem ipsum article one',
		'Lorem ipsum article two',
		'Lorem ipsum article three',
		'Lorem ipsum article four',
		'Lorem ipsum article five',
	);

	$news_titles = array(
		'Lorem ipsum news item one',
		'Lorem ipsum news item two',
		'Lorem ipsum news item three',
	);

	foreach ( $article_titles as $title ) {
		wp_insert_post(
			array(
				'post_title'    => $title,
				'post_name'     => sanitize_title( $title ),
				'post_status'   => 'publish',
				'post_type'     => 'post',
				'post_content'  => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent commodo cursus magna.</p>',
				'post_category' => array( $artikel_id ),
			)
		);
	}

	foreach ( $news_titles as $title ) {
		wp_insert_post(
			array(
				'post_title'    => $title,
				'post_name'     => sanitize_title( $title ),
				'post_status'   => 'publish',
				'post_type'     => 'post',
				'post_content'  => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed odio dui.</p>',
				'post_category' => array( $nyhed_id ),
			)
		);
	}

	if ( $home_id && ! is_wp_error( $home_id ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
	}

	agency_starter_seed_demo_menus();
	agency_starter_apply_site_branding_defaults();
	update_option( 'agency_starter_demo_seeded', 1 );
	update_option( 'agency_starter_demo_version', AGENCY_STARTER_DEMO_VERSION );
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'agency_starter_seed_demo_content' );

/**
 * Upgrade existing demo installs.
 */
function agency_starter_maybe_upgrade_demo() {
	if ( ! agency_starter_demo_enabled() ) {
		return;
	}

	$version = (int) get_option( 'agency_starter_demo_version', 1 );

	if ( $version >= AGENCY_STARTER_DEMO_VERSION ) {
		return;
	}

	agency_starter_seed_synced_patterns();
	agency_starter_refresh_synced_patterns();

	$missing_pages = array(
		array( 'Articles', 'articles', '', 'page-archive-articles' ),
		array( 'News', 'news', '', 'page-archive-news' ),
	);

	foreach ( $missing_pages as $page ) {
		if ( ! get_page_by_path( $page[1] ) ) {
			agency_starter_create_demo_page( $page[0], $page[1], $page[2], $page[3] );
		}
	}

	agency_starter_assign_demo_page_templates();

	agency_starter_upgrade_homepage_news_preview();
	agency_starter_upgrade_demo_copy();
	agency_starter_ensure_jobs_submenu();
	update_option( 'agency_starter_demo_version', AGENCY_STARTER_DEMO_VERSION );
}

/**
 * Refresh homepage and synced patterns (Lorem demo content).
 *
 * @return void
 */
function agency_starter_upgrade_demo_copy() {
	agency_starter_refresh_synced_patterns();
	agency_starter_update_demo_page( 'home', agency_starter_homepage_content() );
	agency_starter_apply_site_branding_defaults();

	if ( ! get_page_by_path( 'terms-of-use' ) ) {
		agency_starter_create_demo_page(
			__( 'Terms of Use', 'agency-starter' ),
			'terms-of-use',
			agency_starter_terms_page_content(),
			'page-legal'
		);
	}
}

/**
 * Default public site name and tagline for TimeWork demos.
 *
 * @return void
 */
function agency_starter_apply_site_branding_defaults() {
	agency_starter_maybe_install_default_site_icon();

	$name = (string) get_option( 'blogname', '' );
	if ( in_array( $name, array( '', 'Agency Starter Demo', 'WordPress' ), true ) ) {
		update_option( 'blogname', 'Time Work' );
	}

	$description = (string) get_option( 'blogdescription', '' );
	$placeholders = array(
		'',
		'Just another WordPress site',
		'Just another WordPress site.',
		'Lorem ipsum B2B agency theme',
		'IT industry career partner',
	);

	if ( in_array( $description, $placeholders, true ) ) {
		update_option( 'blogdescription', 'IT-branchens karrierepartner' );
	}
}

/**
 * Terms of use page composition.
 *
 * @return string
 */
function agency_starter_terms_page_content() {
	return '<!-- wp:pattern {"slug":"agency-starter/hero-minimal"} /-->' .
		'<!-- wp:group {"align":"full","className":"agency-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section"><!-- wp:group {"className":"agency-container agency-container--narrow","layout":{"type":"default"}} -->
<div class="wp-block-group agency-container agency-container--narrow"><!-- wp:paragraph -->
<p>' . esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 'agency-starter' ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->';
}

/**
 * Insert news-preview on the front page for demo upgrades.
 *
 * @return void
 */
function agency_starter_upgrade_homepage_news_preview() {
	$page_id = (int) get_option( 'page_on_front' );
	if ( ! $page_id ) {
		return;
	}

	$content = (string) get_post_field( 'post_content', $page_id );
	if ( str_contains( $content, 'agency-starter/news-preview' ) ) {
		return;
	}

	$needle = '<!-- wp:pattern {"slug":"agency-starter/blog-preview"} /-->';
	if ( ! str_contains( $content, $needle ) ) {
		return;
	}

	wp_update_post(
		array(
			'ID'           => $page_id,
			'post_content' => str_replace(
				$needle,
				$needle . '<!-- wp:pattern {"slug":"agency-starter/news-preview"} /-->',
				$content
			),
		)
	);
}

/**
 * Create a demo page if it does not exist.
 *
 * @param string $title    Page title.
 * @param string $slug     Page slug.
 * @param string $content  Block content.
 * @param string $template Optional page template.
 * @return int Post ID.
 */
function agency_starter_create_demo_page( $title, $slug, $content, $template = '' ) {
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		return (int) $existing->ID;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => $content,
		)
	);

	if ( $page_id && ! is_wp_error( $page_id ) && $template ) {
		update_post_meta( $page_id, '_wp_page_template', $template );
	}

	return $page_id;
}

/**
 * Demo Jobs mega-menu columns (Lorem placeholder links).
 *
 * @return array<int, array<string, mixed>>
 */
function agency_starter_jobs_submenu_definition() {
	return array(
		array(
			'title'          => 'Lorem open roles',
			'url'            => '#',
			'column_heading' => 'Lorem open roles',
			'children'       => array(
				array(
					'title' => 'Lorem Senior Developer',
					'url'   => '/lorem-senior-developer/',
				),
				array(
					'title' => 'Lorem Project Manager',
					'url'   => '/lorem-project-manager/',
				),
				array(
					'title' => 'Lorem UX Designer',
					'url'   => '/lorem-ux-designer/',
				),
			),
		),
		array(
			'title'          => 'Lorem more jobs',
			'url'            => '#',
			'column_heading' => 'Lorem more jobs',
			'children'       => array(
				array(
					'title' => 'Lorem DevOps Engineer',
					'url'   => '/lorem-devops-engineer/',
				),
				array(
					'title' => 'Lorem Business Analyst',
					'url'   => '/lorem-business-analyst/',
				),
				array(
					'title' => 'Lorem all IT jobs',
					'url'   => '/kandidater/it-jobs/',
				),
			),
		),
	);
}

/**
 * Primary navigation tree for demo seeding.
 *
 * @return array<int, array<string, mixed>>
 */
function agency_starter_primary_menu_definitions() {
	return array(
		array(
			'title' => __( 'Home', 'agency-starter' ),
			'url'   => '/',
		),
		array(
			'title' => __( 'Employers', 'agency-starter' ),
			'url'   => '/employers/',
		),
		array(
			'title' => __( 'Candidates', 'agency-starter' ),
			'url'   => '/candidates/',
		),
		array(
			'title'    => __( 'Jobs', 'agency-starter' ),
			'url'      => '/kandidater/it-jobs/',
			'classes'  => 'mega-menu',
			'children' => agency_starter_jobs_submenu_definition(),
		),
		array(
			'title' => __( 'Articles', 'agency-starter' ),
			'url'   => '/articles/',
		),
		array(
			'title' => __( 'News', 'agency-starter' ),
			'url'   => '/news/',
		),
		array(
			'title' => __( 'Contact', 'agency-starter' ),
			'url'   => '/contact/',
		),
	);
}

/**
 * Insert one nav menu item (and optional descendants).
 *
 * @param int                  $menu_id   Menu term ID.
 * @param array<string, mixed> $item      Item definition.
 * @param int                  $parent_id Parent menu item ID.
 * @param int                  $position  Sort position.
 * @return int New menu item post ID.
 */
function agency_starter_insert_nav_menu_item( $menu_id, array $item, $parent_id = 0, $position = 0 ) {
	$url  = (string) ( $item['url'] ?? '/' );
	$href = '/' === $url ? home_url( '/' ) : home_url( $url );

	$args = array(
		'menu-item-title'     => (string) ( $item['title'] ?? '' ),
		'menu-item-url'       => $href,
		'menu-item-status'    => 'publish',
		'menu-item-type'      => 'custom',
		'menu-item-parent-id' => (int) $parent_id,
		'menu-item-position'  => (int) $position,
	);

	if ( ! empty( $item['classes'] ) ) {
		$args['menu-item-classes'] = (string) $item['classes'];
	}

	$item_id = wp_update_nav_menu_item( $menu_id, 0, $args );
	if ( is_wp_error( $item_id ) || ! $item_id ) {
		return 0;
	}

	if ( ! empty( $item['column_heading'] ) && defined( 'AGENCY_NAV_COLUMN_HEADING' ) ) {
		update_post_meta( $item_id, AGENCY_NAV_COLUMN_HEADING, sanitize_text_field( (string) $item['column_heading'] ) );
	}

	if ( ! empty( $item['children'] ) && is_array( $item['children'] ) ) {
		$child_position = 1;
		foreach ( $item['children'] as $child ) {
			if ( is_array( $child ) ) {
				agency_starter_insert_nav_menu_item( $menu_id, $child, (int) $item_id, $child_position++ );
			}
		}
	}

	return (int) $item_id;
}

/**
 * Restore Jobs submenu when a flat primary menu was rebuilt without children.
 *
 * @return void
 */
function agency_starter_ensure_jobs_submenu() {
	if ( ! agency_starter_demo_enabled() ) {
		return;
	}

	$locations = get_nav_menu_locations();
	$menu_id   = isset( $locations['primary'] ) ? (int) $locations['primary'] : 0;
	if ( ! $menu_id ) {
		return;
	}

	$items = wp_get_nav_menu_items( $menu_id );
	if ( ! is_array( $items ) ) {
		return;
	}

	$jobs_item = null;
	foreach ( $items as $item ) {
		if ( 0 !== (int) $item->menu_item_parent ) {
			continue;
		}

		if ( in_array( (string) $item->title, array( 'Jobs', __( 'Jobs', 'agency-starter' ) ), true ) ) {
			$jobs_item = $item;
			break;
		}
	}

	if ( ! $jobs_item ) {
		return;
	}

	foreach ( $items as $item ) {
		if ( (int) $item->menu_item_parent === (int) $jobs_item->ID ) {
			return;
		}
	}

	$classes = array_filter( (array) $jobs_item->classes );
	if ( ! in_array( 'mega-menu', $classes, true ) ) {
		$classes[] = 'mega-menu';
		wp_update_nav_menu_item(
			$menu_id,
			(int) $jobs_item->ID,
			array(
				'menu-item-title'     => (string) $jobs_item->title,
				'menu-item-url'       => (string) $jobs_item->url,
				'menu-item-status'    => 'publish',
				'menu-item-type'      => 'custom',
				'menu-item-classes'   => implode( ' ', $classes ),
				'menu-item-parent-id' => 0,
			)
		);
	}

	$position = 1;
	foreach ( agency_starter_jobs_submenu_definition() as $child ) {
		agency_starter_insert_nav_menu_item( $menu_id, $child, (int) $jobs_item->ID, $position++ );
	}
}

/**
 * Seed navigation menus for demo.
 *
 * @param bool $force_rebuild Replace existing primary menu items.
 */
function agency_starter_seed_demo_menus( $force_rebuild = false ) {
	$locations = array(
		'primary' => agency_starter_primary_menu_definitions(),
		'legal'   => array(
			array(
				'title' => __( 'Privacy Policy', 'agency-starter' ),
				'url'   => '/privacy-policy/',
			),
			array(
				'title' => __( 'Terms of Use', 'agency-starter' ),
				'url'   => '/terms-of-use/',
			),
		),
	);

	$assigned = get_theme_mod( 'nav_menu_locations', array() );

	foreach ( $locations as $location => $items ) {
		$menu_name = 'Agency Starter ' . ucfirst( $location );
		$menu      = wp_get_nav_menu_object( $menu_name );

		if ( ! $menu ) {
			$menu_id = wp_create_nav_menu( $menu_name );
		} else {
			$menu_id = (int) $menu->term_id;
		}

		if ( is_wp_error( $menu_id ) || ! $menu_id ) {
			continue;
		}

		$existing = wp_get_nav_menu_items( $menu_id );
		if ( $force_rebuild && 'primary' === $location && $existing ) {
			foreach ( $existing as $item ) {
				wp_delete_post( $item->ID, true );
			}
			$existing = array();
		}

		if ( empty( $existing ) ) {
			$order = 1;
			foreach ( $items as $item ) {
				if ( is_array( $item ) ) {
					agency_starter_insert_nav_menu_item( $menu_id, $item, 0, $order++ );
				}
			}
		} elseif ( 'primary' === $location ) {
			agency_starter_ensure_jobs_submenu();
		}

		$assigned[ $location ] = $menu_id;

		if ( 'primary' === $location || 'legal' === $location ) {
			agency_starter_sync_polylang_menu( $menu_id, $location );
		}
	}

	set_theme_mod( 'nav_menu_locations', $assigned );
}

/**
 * Ensure a taxonomy term exists and return its ID.
 *
 * @param string $slug     Term slug.
 * @param string $taxonomy Taxonomy name.
 * @return int Term ID.
 */
function agency_starter_ensure_term( $slug, $taxonomy ) {
	$term = get_term_by( 'slug', $slug, $taxonomy );

	if ( $term ) {
		return (int) $term->term_id;
	}

	$result = wp_insert_term(
		ucfirst( $slug ),
		$taxonomy,
		array(
			'slug' => $slug,
		)
	);

	if ( is_wp_error( $result ) ) {
		return 0;
	}

	return (int) $result['term_id'];
}

/**
 * Run demo upgrade on admin init (for existing installs).
 */
function agency_starter_admin_demo_upgrade() {
	if ( ! agency_starter_can_run_admin_seeder() ) {
		return;
	}

	if ( get_option( 'agency_starter_demo_seeded' ) ) {
		agency_starter_maybe_upgrade_demo();
	}
}
add_action( 'admin_init', 'agency_starter_admin_demo_upgrade' );
