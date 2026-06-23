<?php
/**
 * Brand logo: SVG uploads + bundled default for Site Identity.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Allow SVG brand assets for administrators only.
 *
 * @param array<string, string> $mimes Mime types.
 * @return array<string, string>
 */
function agency_starter_allow_svg_logo_uploads( $mimes ) {
	if ( current_user_can( 'manage_options' ) || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
		$mimes['svg'] = 'image/svg+xml';
	}

	return $mimes;
}
add_filter( 'upload_mimes', 'agency_starter_allow_svg_logo_uploads' );

/**
 * WordPress filetype sniffing can reject SVG without an explicit extension map.
 *
 * @param array<string, mixed> $data      File data.
 * @param string               $file      Path.
 * @param string               $filename  Filename.
 * @param string[]|null        $mimes     Optional mime list.
 * @return array<string, mixed>
 */
function agency_starter_fix_svg_filetype( $data, $file, $filename, $mimes = null ) {
	if ( is_string( $filename ) && str_ends_with( strtolower( $filename ), '.svg' ) ) {
		return array(
			'ext'             => 'svg',
			'type'            => 'image/svg+xml',
			'proper_filename' => $filename,
		);
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'agency_starter_fix_svg_filetype', 10, 4 );

/**
 * Path to the bundled Time Work logo (vector, no embedded raster).
 *
 * @return string
 */
function agency_starter_default_logo_path() {
	return get_template_directory() . '/assets/images/brand/timework-logo.svg';
}

/**
 * Path to the bundled hourglass favicon (SVG).
 *
 * @return string
 */
function agency_starter_default_favicon_svg_path() {
	return get_template_directory() . '/assets/images/brand/timework-favicon.svg';
}

/**
 * Path to the bundled site icon source (512px PNG).
 *
 * @return string
 */
function agency_starter_default_site_icon_path() {
	return get_template_directory() . '/assets/images/brand/timework-site-icon-512.png';
}

/**
 * Public URL for the theme favicon SVG.
 *
 * @return string
 */
function agency_starter_favicon_svg_url() {
	return get_template_directory_uri() . '/assets/images/brand/timework-favicon.svg';
}

/**
 * Import a bundled brand image into the media library.
 *
 * @param string $path     Absolute file path.
 * @param string $filename Destination filename.
 * @param string $title    Attachment title.
 * @param string $mime     Mime type.
 * @return int Attachment ID or 0.
 */
function agency_starter_import_brand_asset( $path, $filename, $title, $mime ) {
	if ( ! is_readable( $path ) ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$upload = wp_upload_bits( $filename, null, (string) file_get_contents( $path ) );
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}

	$attachment_id = wp_insert_attachment(
		array(
			'post_mime_type' => $mime,
			'post_title'     => $title,
			'post_content'   => '',
			'post_status'    => 'inherit',
		),
		$upload['file']
	);

	if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
		return 0;
	}

	wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $upload['file'] ) );

	return (int) $attachment_id;
}

/**
 * Output bundled favicon only when Site Icon is not set in wp-admin.
 *
 * When a Site Icon is configured (Appearance → Site Identity), WordPress outputs
 * favicon tags via wp_site_icon() and the admin's choice must not be overridden.
 */
function agency_starter_print_favicon_tags() {
	if ( is_admin() || has_site_icon() ) {
		return;
	}

	printf(
		'<link rel="icon" href="%s" type="image/svg+xml" sizes="any" />' . "\n",
		esc_url( agency_starter_favicon_svg_url() )
	);

	$png_32  = get_template_directory_uri() . '/assets/images/brand/timework-favicon-32.png';
	$png_180 = get_template_directory_uri() . '/assets/images/brand/timework-site-icon-180.png';

	printf(
		'<link rel="icon" href="%s" type="image/png" sizes="32x32" />' . "\n",
		esc_url( $png_32 )
	);
	printf(
		'<link rel="apple-touch-icon" href="%s" />' . "\n",
		esc_url( $png_180 )
	);
}
add_action( 'wp_head', 'agency_starter_print_favicon_tags', 2 );

/**
 * Import bundled logo into the media library when no custom logo is set.
 */
function agency_starter_maybe_install_default_logo() {
	if ( get_theme_mod( 'custom_logo' ) ) {
		return;
	}

	$attachment_id = agency_starter_import_brand_asset(
		agency_starter_default_logo_path(),
		'timework-logo.svg',
		'Time Work logo',
		'image/svg+xml'
	);

	if ( $attachment_id > 0 ) {
		set_theme_mod( 'custom_logo', $attachment_id );
	}
}
add_action( 'after_setup_theme', 'agency_starter_maybe_install_default_logo', 20 );

/**
 * Import bundled site icon when Appearance → Site Icon is not configured.
 */
function agency_starter_maybe_install_default_site_icon() {
	if ( get_option( 'site_icon' ) ) {
		return;
	}

	$attachment_id = agency_starter_import_brand_asset(
		agency_starter_default_site_icon_path(),
		'timework-site-icon-512.png',
		'Time Work site icon',
		'image/png'
	);

	if ( $attachment_id > 0 ) {
		update_option( 'site_icon', $attachment_id );
	}
}
add_action( 'after_setup_theme', 'agency_starter_maybe_install_default_site_icon', 21 );

/**
 * Default site tagline shown beside header/footer logos (editable in Site Identity).
 */
function agency_starter_maybe_set_default_tagline() {
	$description = (string) get_option( 'blogdescription', '' );
	$placeholders = array(
		'',
		'Just another WordPress site',
		'Just another WordPress site.',
	);

	if ( ! in_array( $description, $placeholders, true ) ) {
		return;
	}

	update_option( 'blogdescription', 'IT-branchens karrierepartner' );
}
add_action( 'after_setup_theme', 'agency_starter_maybe_set_default_tagline', 15 );
