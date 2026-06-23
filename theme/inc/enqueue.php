<?php
/**
 * Enqueue frontend and editor assets.
 *
 * @package Agency_Starter
 */

/**
 * Absolute URI to self-hosted Raleway font files.
 *
 * @return string
 */
function agency_starter_fonts_uri() {
	return trailingslashit( get_template_directory_uri() . '/assets/fonts' );
}

/**
 * Asset version from file modification time (cache bust when CSS/JS change).
 *
 * @param string $relative_path Path relative to theme root.
 * @return string
 */
function agency_starter_asset_version( $relative_path ) {
	$path = get_template_directory() . '/' . ltrim( $relative_path, '/' );

	return file_exists( $path ) ? (string) filemtime( $path ) : AGENCY_STARTER_VERSION;
}

/**
 * Print @font-face rules with absolute URLs (avoids broken relative paths in bundled CSS).
 */
function agency_starter_print_font_faces() {
	$base    = agency_starter_fonts_uri();
	$weights = array( 400, 500, 600, 700 );

	echo "<style id=\"agency-font-faces\">\n";
	foreach ( $weights as $weight ) {
		printf(
			"@font-face{font-family:'Raleway';font-style:normal;font-weight:%d;font-display:swap;src:url('%sraleway-%d.woff2') format('woff2')}\n",
			(int) $weight,
			esc_url( $base ),
			(int) $weight // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- integer font-weight in printf %d.
		);
	}
	echo "</style>\n";
}
add_action( 'wp_head', 'agency_starter_print_font_faces', 1 );

/**
 * Preload fonts used on first paint (body 400, nav 600).
 */
function agency_starter_preload_fonts() {
	$base = agency_starter_fonts_uri();
	foreach ( array( 400 ) as $weight ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( $base . 'raleway-' . $weight . '.woff2' )
		);
	}
}
add_action( 'wp_head', 'agency_starter_preload_fonts', 2 );

/**
 * Critical header layout — inlined from theme/css/critical-header.css (single source).
 */
function agency_starter_critical_header_css() {
	$path = get_template_directory() . '/css/critical-header.css';

	if ( ! is_readable( $path ) ) {
		return;
	}

	$css = (string) file_get_contents( $path );
	$css = preg_replace( '/\s+/', ' ', trim( $css ) );

	echo '<style id="agency-critical-header">' . $css . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static theme CSS file.
}
add_action( 'wp_head', 'agency_starter_critical_header_css', 100 );

/**
 * Main theme stylesheet, optional prose bundle, and mobile navigation script.
 */
function agency_starter_enqueue_frontend_assets() {
	wp_enqueue_style(
		'agency-starter-style',
		get_stylesheet_uri(),
		array( 'global-styles' ),
		agency_starter_asset_version( 'style.css' )
	);

	if ( agency_starter_needs_prose_styles() ) {
		wp_enqueue_style(
			'agency-starter-prose',
			get_template_directory_uri() . '/css/prose-content.css',
			array( 'agency-starter-style' ),
			agency_starter_asset_version( 'css/prose-content.css' )
		);
	}

	if ( agency_starter_theme_uses_mobile_nav() ) {
		wp_enqueue_script(
			'agency-starter-script',
			get_template_directory_uri() . '/js/script.min.js',
			array(),
			agency_starter_asset_version( 'js/script.min.js' ),
			true
		);
		wp_localize_script(
			'agency-starter-script',
			'agencyStarterI18n',
			agency_starter_frontend_i18n()
		);
	}

	if ( is_rtl() ) {
		wp_enqueue_style(
			'agency-starter-rtl',
			get_template_directory_uri() . '/rtl.css',
			array( 'agency-starter-style' ),
			agency_starter_asset_version( 'rtl.css' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'agency_starter_enqueue_frontend_assets' );

/**
 * Enqueue threaded comment reply script on singular views.
 */
function agency_starter_enqueue_comment_reply() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'agency_starter_enqueue_comment_reply' );

/**
 * Output skip link for keyboard and screen reader users.
 */
function agency_starter_skip_link() {
	echo '<a class="skip-link screen-reader-text bg-primary text-inverse focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:px-4 focus:py-2" href="#content">' . esc_html__( 'Skip to content', 'agency-starter' ) . '</a>';
}
add_action( 'wp_body_open', 'agency_starter_skip_link', 5 );

/**
 * Use theme skip link only — avoid duplicate core skip link.
 */
function agency_starter_remove_core_skip_link() {
	remove_action( 'wp_body_open', 'wp_print_skip_link' );
	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_block_template_skip_link' );
	remove_action( 'wp_footer', 'the_block_template_skip_link' );
}
add_action( 'init', 'agency_starter_remove_core_skip_link', 0 );

/**
 * Enqueue block editor script.
 */
function agency_starter_enqueue_block_editor_script() {
	$current_screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

	if (
		$current_screen &&
		$current_screen->is_block_editor() &&
		'widgets' !== $current_screen->id
	) {
		wp_enqueue_script(
			'agency-starter-editor',
			get_template_directory_uri() . '/js/block-editor.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			agency_starter_asset_version( 'js/block-editor.min.js' ),
			true
		);
		wp_add_inline_script( 'agency-starter-editor', "tailwindTypographyClasses = '" . esc_attr( AGENCY_STARTER_TYPOGRAPHY_CLASSES ) . "'.split(' ');", 'before' );
	}
}
add_action( 'enqueue_block_assets', 'agency_starter_enqueue_block_editor_script' );
