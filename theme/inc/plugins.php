<?php
/**
 * Plugin integration hooks (CF7, Yoast, Polylang).
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Polylang demo languages (DA + EN).
 */
function agency_starter_setup_polylang() {
	if ( ! agency_starter_demo_enabled() ) {
		return;
	}

	if ( ! function_exists( 'pll_languages_list' ) || get_option( 'agency_starter_polylang_seeded' ) ) {
		return;
	}

	if ( pll_languages_list() ) {
		update_option( 'agency_starter_polylang_seeded', 1 );
		return;
	}

	if ( function_exists( 'PLL' ) && isset( PLL()->model ) ) {
		PLL()->model->add_language(
			array(
				'name'           => 'Dansk',
				'slug'           => 'da',
				'locale'         => 'da_DK',
				'rtl'            => 0,
				'term_group'     => 0,
				'no_default_cat' => 0,
				'flag'           => 'dk',
			)
		);
		PLL()->model->add_language(
			array(
				'name'           => 'English',
				'slug'           => 'en',
				'locale'         => 'en_US',
				'rtl'            => 0,
				'term_group'     => 0,
				'no_default_cat' => 0,
				'flag'           => 'gb',
			)
		);
		update_option( 'agency_starter_polylang_seeded', 1 );
	}
}
add_action( 'init', 'agency_starter_setup_polylang', 20 );

/**
 * Register demo menus with Polylang for all languages.
 *
 * @param int    $menu_id  Menu term ID.
 * @param string $location Theme menu location slug.
 */
function agency_starter_sync_polylang_menu( $menu_id, $location ) {
	if ( ! function_exists( 'pll_languages_list' ) || ! $menu_id ) {
		return;
	}

	$options = get_option( 'polylang', array() );
	$theme   = get_stylesheet();

	if ( empty( $options['nav_menus'] ) ) {
		$options['nav_menus'] = array();
	}
	if ( empty( $options['nav_menus'][ $theme ] ) ) {
		$options['nav_menus'][ $theme ] = array();
	}
	if ( empty( $options['nav_menus'][ $theme ][ $location ] ) ) {
		$options['nav_menus'][ $theme ][ $location ] = array();
	}

	foreach ( pll_languages_list( array( 'fields' => 'slug' ) ) as $lang ) {
		$options['nav_menus'][ $theme ][ $location ][ $lang ] = (int) $menu_id;
	}

	update_option( 'polylang', $options );
}


/**
 * Create demo CF7 forms if plugin is active.
 */
function agency_starter_seed_cf7_forms() {
	if ( ! agency_starter_can_run_admin_seeder() ) {
		return;
	}

	if ( ! class_exists( 'WPCF7_ContactForm' ) || get_option( 'agency_starter_cf7_seeded' ) ) {
		return;
	}

	$employer = WPCF7_ContactForm::get_template(
		array(
			'title' => 'Lorem Employer Form',
		)
	);

	$employer->set_properties(
		array(
			'form' => agency_starter_cf7_employer_form(),
		)
	);

	$employer_id = $employer->save();

	$candidate = WPCF7_ContactForm::get_template(
		array(
			'title' => 'Lorem Candidate Form',
		)
	);

	$candidate->set_properties(
		array(
			'form' => agency_starter_cf7_candidate_form(),
		)
	);

	$candidate_id = $candidate->save();

	$contact = WPCF7_ContactForm::get_template(
		array(
			'title' => 'Lorem Contact Form',
		)
	);

	$contact->set_properties(
		array(
			'form' => agency_starter_cf7_contact_form(),
		)
	);

	$contact_id = $contact->save();

	update_option(
		'agency_starter_cf7_ids',
		array(
			'employer'  => $employer_id,
			'candidate' => $candidate_id,
			'contact'   => $contact_id,
		)
	);
	update_option( 'agency_starter_cf7_seeded', 1 );
	agency_starter_wire_cf7_conversion_pages();
}
add_action( 'admin_init', 'agency_starter_seed_cf7_forms' );

/**
 * Ensure general contact CF7 exists on upgraded installs.
 */
function agency_starter_ensure_contact_cf7() {
	if ( ! agency_starter_can_run_admin_seeder() ) {
		return;
	}

	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return;
	}

	$ids = get_option( 'agency_starter_cf7_ids', array() );
	if ( ! empty( $ids['contact'] ) && get_post( (int) $ids['contact'] ) ) {
		return;
	}

	$contact = WPCF7_ContactForm::get_template(
		array(
			'title' => 'Lorem Contact Form',
		)
	);

	$contact->set_properties(
		array(
			'form' => agency_starter_cf7_contact_form(),
		)
	);

	$ids['contact'] = $contact->save();
	update_option( 'agency_starter_cf7_ids', $ids );
}
add_action( 'admin_init', 'agency_starter_ensure_contact_cf7' );

/**
 * Render contact page CF7 form.
 *
 * @return string
 */
function agency_starter_contact_form_shortcode() {
	$shortcode = agency_starter_cf7_shortcode_for( 'contact' );

	if ( false !== strpos( $shortcode, 'placeholder' ) ) {
		return '<div class="agency-form-placeholder">' . esc_html( $shortcode ) . '</div>';
	}

	return do_shortcode( $shortcode );
}
add_shortcode( 'agency_starter_contact_form', 'agency_starter_contact_form_shortcode' );

/**
 * Insert CF7 shortcodes into conversion demo pages.
 */
function agency_starter_wire_cf7_conversion_pages() {
	if ( ! agency_starter_can_run_admin_seeder() ) {
		return;
	}

	$ids = get_option( 'agency_starter_cf7_ids', array() );

	$map = array(
		'employer-form'  => 'employer',
		'candidate-form' => 'candidate',
	);

	foreach ( $map as $slug => $type ) {
		if ( empty( $ids[ $type ] ) ) {
			continue;
		}

		$page = get_page_by_path( $slug );
		if ( ! $page ) {
			continue;
		}

		$shortcode = '[contact-form-7 id="' . (int) $ids[ $type ] . '"]';
		if ( false !== strpos( $page->post_content, $shortcode ) ) {
			continue;
		}

		wp_update_post(
			array(
				'ID'           => $page->ID,
				'post_content' => str_replace( '[Lorem form shortcode placeholder]', $shortcode, $page->post_content ),
			)
		);
	}
}

/**
 * Replace form placeholder in conversion pages with CF7 shortcode.
 *
 * @param string $type Form key in agency_starter_cf7_ids (e.g. contact, employer).
 * @return string CF7 shortcode or placeholder when the form is not provisioned.
 */
function agency_starter_cf7_shortcode_for( $type ) {
	$ids = get_option( 'agency_starter_cf7_ids', array() );

	if ( empty( $ids[ $type ] ) ) {
		return '[Lorem form shortcode placeholder]';
	}

	return '[contact-form-7 id="' . (int) $ids[ $type ] . '"]';
}
