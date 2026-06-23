<?php
/**
 * Heroicons outline SVGs (MIT — https://heroicons.com).
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Allowed Heroicon slugs for USP tabs.
 *
 * @return array<string, string>
 */
function agency_starter_heroicon_paths() {
	return array(
		'briefcase'     => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z',
		'currency-dollar' => 'M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
		'banknotes'     => 'M2.25 18.75V15a2.25 2.25 0 012.25-2.25h15A2.25 2.25 0 0121.75 15v3.75M2.25 8.25V12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 12V8.25M3.75 6.75h16.5M9 12h6',
		'user-group'    => 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z',
		'users'         => 'M15 19.128a9.38 9.38 0 002.627.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
		'globe-alt'     => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418',
		'building-office' => 'M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21',
		'chevron-up'    => 'M4.5 15.75l7.5-7.5 7.5 7.5',
		'chevron-down'  => 'M19.5 8.25l-7.5 7.5-7.5-7.5',
		'arrow-right'   => 'M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3',
	);
}

/**
 * Render a Heroicon outline SVG.
 *
 * @param string $slug    Icon slug.
 * @param string $class   Optional CSS class on svg.
 * @return string Safe SVG markup.
 */
function agency_starter_heroicon( $slug, $class = 'agency-icon' ) {
	$paths = agency_starter_heroicon_paths();
	$path  = $paths[ $slug ] ?? $paths['briefcase'];

	return sprintf(
		'<svg class="%1$s" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="%2$s"/></svg>',
		esc_attr( $class ),
		esc_attr( $path )
	);
}

/**
 * Icon choices for block editor.
 *
 * @return array<string, string>
 */
function agency_starter_heroicon_choices() {
	return array(
		'briefcase'       => __( 'Briefcase', 'agency-starter' ),
		'currency-dollar' => __( 'Currency dollar', 'agency-starter' ),
		'banknotes'       => __( 'Banknotes', 'agency-starter' ),
		'user-group'      => __( 'User group', 'agency-starter' ),
		'users'           => __( 'Users', 'agency-starter' ),
		'globe-alt'       => __( 'Globe', 'agency-starter' ),
		'building-office' => __( 'Building', 'agency-starter' ),
	);
}
