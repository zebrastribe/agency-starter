<?php
/**
 * Polylang string registration and theme UI translations.
 *
 * Register strings on init so they appear under Languages → String translations.
 * Output uses pll__() with .mo fallback via agency_starter_t().
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Polylang string group name in mlang_strings. */
const AGENCY_STARTER_PLL_GROUP = 'Agency Starter';

/**
 * Translatable UI strings (admin label => source text).
 *
 * @return array<string, string>
 */
function agency_starter_pll_string_registry() {
	return array(
		'close'                    => 'Close',
		'close-menu'               => 'Close menu',
		'open-menu'                => 'Open menu',
		'mobile-navigation'        => 'Mobile navigation',
		'primary-nav'              => 'Primary',
		'skip-to-content'          => 'Skip to content',
		'submenu-suffix'           => '%s submenu',
		'open-submenu'             => 'Open %s submenu',
		'expand-item'              => 'Expand %s',
		'hero-slides'              => 'Hero slides',
		'home'                     => 'Home',
		'employers'                => 'Employers',
		'candidates'               => 'Candidates',
		'jobs'                     => 'Jobs',
		'articles'                 => 'Articles',
		'news'                     => 'News',
		'contact'                  => 'Contact',
		'company'                  => 'Company',
		'privacy-policy'           => 'Privacy Policy',
		'privacy-policy-lower'     => 'Privacy policy',
		'terms-of-use'             => 'Terms of Use',
		'terms-of-use-lower'       => 'Terms of use',
		'all-rights-reserved'      => 'All rights reserved.',
		'lorem-view-all-articles'  => 'Lorem view all articles',
		'lorem-view-all-news'      => 'Lorem view all news',
		'lorem-view-all-jobs'      => 'Lorem view all jobs',
		'book-a-demo'              => 'Book a demo',
		'learn-more'               => 'Learn more',
		'newsletter-signup'        => 'Newsletter signup',
		'email-address'            => 'Email address',
		'subscribe'                => 'Subscribe',
	);
}

/**
 * Default Danish translations seeded into Polylang (editable later in admin).
 *
 * @return array<string, string> English source => Danish.
 */
function agency_starter_pll_default_translations_da() {
	return array(
		'Close'                    => 'Luk',
		'Close menu'               => 'Luk menu',
		'Open menu'                => 'Åbn menu',
		'Mobile navigation'        => 'Mobil navigation',
		'Primary'                  => 'Primær',
		'Skip to content'          => 'Spring til indhold',
		'%s submenu'               => '%s undermenu',
		'Open %s submenu'          => 'Åbn %s undermenu',
		'Expand %s'                => 'Udvid %s',
		'Hero slides'              => 'Hero-billeder',
		'Home'                     => 'Forside',
		'Employers'                => 'Virksomheder',
		'Candidates'               => 'Kandidater',
		'Jobs'                     => 'Job',
		'Articles'                 => 'Artikler',
		'News'                     => 'Nyheder',
		'Contact'                  => 'Kontakt',
		'Company'                  => 'Virksomheden',
		'Privacy Policy'           => 'Privatlivspolitik',
		'Privacy policy'           => 'Privatlivspolitik',
		'Terms of Use'             => 'Vilkår for brug',
		'Terms of use'             => 'Vilkår for brug',
		'All rights reserved.'     => 'Alle rettigheder forbeholdes.',
		'Lorem view all articles'  => 'Se alle artikler',
		'Lorem view all news'      => 'Se alle nyheder',
		'Lorem view all jobs'      => 'Se alle job',
		'Book a demo'              => 'Book en demo',
		'Learn more'               => 'Læs mere',
		'Newsletter signup'        => 'Nyhedsbrev tilmelding',
		'Email address'            => 'E-mail',
		'Subscribe'                => 'Tilmeld',
	);
}

/**
 * Register theme strings with Polylang (visible in Languages → String translations).
 */
function agency_starter_register_pll_strings() {
	if ( ! class_exists( 'PLL_Admin_Strings' ) ) {
		return;
	}

	foreach ( agency_starter_pll_string_registry() as $name => $string ) {
		PLL_Admin_Strings::register_string( $name, $string, AGENCY_STARTER_PLL_GROUP, false );
	}
}
add_action( 'init', 'agency_starter_register_pll_strings', 20 );

/**
 * Translate a theme UI string (Polylang → theme .mo → source).
 *
 * @param string $text Source string (English).
 * @return string
 */
function agency_starter_t( $text ) {
	$text = (string) $text;
	if ( '' === $text ) {
		return $text;
	}

	if ( function_exists( 'pll__' ) ) {
		$translated = pll__( $text );
		if ( $translated !== $text ) {
			return $translated;
		}
	}

	$gettext = __( $text, 'agency-starter' );
	return $gettext !== $text ? $gettext : $text;
}

/**
 * @param string $text Source string.
 * @return string
 */
function agency_starter_esc_html__( $text ) {
	return esc_html( agency_starter_t( $text ) );
}

/**
 * @param string $text Source string.
 * @return string
 */
function agency_starter_esc_attr__( $text ) {
	return esc_attr( agency_starter_t( $text ) );
}

/**
 * Seed default Danish Polylang string translations (does not overwrite existing).
 */
function agency_starter_seed_pll_default_translations() {
	if ( ! function_exists( 'PLL' ) || ! isset( PLL()->model ) ) {
		return;
	}

	$lang = PLL()->model->get_language( 'da' );
	if ( ! $lang ) {
		return;
	}

	$mo = new PLL_MO();
	$mo->import_from_db( $lang );

	foreach ( agency_starter_pll_default_translations_da() as $original => $danish ) {
		if ( '' === $mo->translate_if_any( $original ) ) {
			$mo->add_entry(
				$mo->make_entry( $original, $danish )
			);
		}
	}

	$mo->export_to_db( $lang );
}

/**
 * Seed Polylang defaults once per theme strings version.
 */
function agency_starter_maybe_seed_pll_defaults() {
	$version = 1;
	if ( (int) get_option( 'agency_starter_pll_strings_version', 0 ) >= $version ) {
		return;
	}

	agency_starter_register_pll_strings();
	agency_starter_seed_pll_default_translations();
	update_option( 'agency_starter_pll_strings_version', $version );
}
add_action( 'admin_init', 'agency_starter_maybe_seed_pll_defaults', 5 );

/**
 * Replace known UI strings inside rendered block HTML.
 *
 * @param string $content Block HTML.
 * @return string
 */
function agency_starter_pll_translate_html( $content ) {
	if ( is_admin() || ! is_string( $content ) || '' === $content ) {
		return $content;
	}

	foreach ( agency_starter_pll_string_registry() as $source ) {
		$translated = agency_starter_t( $source );
		if ( $translated !== $source ) {
			$content = str_replace( $source, $translated, $content );
		}
	}

	return $content;
}

/**
 * Translate UI strings in rendered blocks (patterns, post content, template parts).
 *
 * @param string $block_content Block HTML.
 * @param array  $block         Block data.
 * @return string
 */
function agency_starter_pll_render_block( $block_content, $block ) {
	unset( $block );
	return agency_starter_pll_translate_html( $block_content );
}
add_filter( 'render_block', 'agency_starter_pll_render_block', 8, 2 );
