<?php
/**
 * Placeholder images, responsive markup, and featured-image fallbacks.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Supported placeholder asset keys.
 *
 * @return array<string, string> slug => filename
 */
function agency_starter_placeholder_files() {
	return array(
		'hero'   => 'hero-abstract.svg',
		'blog'   => 'blog-featured.svg',
		'square' => 'image-1x1.svg',
		'wide'   => 'image-16x9.svg',
		'logo'   => 'logo-slot.svg',
		'avatar' => 'avatar-initials.svg',
	);
}

/**
 * URL for a theme placeholder image.
 *
 * @param string $slug hero|blog|square|wide|logo|avatar
 * @return string
 */
function agency_starter_placeholder_url( $slug ) {
	$files = agency_starter_placeholder_files();
	$file  = $files[ $slug ] ?? $files['wide'];

	return get_template_directory_uri() . '/assets/images/placeholders/' . $file;
}

/**
 * Intrinsic dimensions for placeholder SVGs (layout stability).
 *
 * @param string $slug Placeholder slug or registered image size name.
 * @return array{0: int, 1: int}
 */
function agency_starter_placeholder_dimensions( $slug ) {
	$map = array(
		'hero'   => array( 1920, 1080 ),
		'blog'   => array( 1200, 675 ),
		'wide'   => array( 1600, 900 ),
		'square' => array( 800, 800 ),
		'card'   => array( 800, 450 ),
		'logo'   => array( 300, 100 ),
		'avatar' => array( 80, 80 ),
	);

	return $map[ $slug ] ?? $map['wide'];
}

/**
 * Default sizes attribute for theme image contexts.
 *
 * @param string $size Registered size or placeholder slug.
 * @return string
 */
function agency_starter_image_sizes_attr( $size ) {
	$map = array(
		'hero'   => '(min-width: 64em) 50vw, 100vw',
		'wide'   => '(min-width: 64em) 50vw, 100vw',
		'card'   => '(min-width: 64em) 33vw, 100vw',
		'blog'   => '(min-width: 64em) 66vw, 100vw',
		'logo'   => '140px',
		'square' => '(min-width: 36em) 50vw, 100vw',
		'avatar'       => '80px',
		'media-slider' => '(min-width: 64em) min(34rem, 42vw), 84vw',
	);

	return $map[ $size ] ?? '100vw';
}

/**
 * Render a responsive image tag (attachment srcset when ID is available).
 *
 * @param array<string, mixed> $args {
 *     @type int    $id            Attachment ID.
 *     @type string $url           Fallback URL when no attachment.
 *     @type string $alt           Alt text.
 *     @type string $size          WP image size or placeholder slug.
 *     @type string $class         CSS class.
 *     @type string $loading       lazy|eager.
 *     @type string $decoding      async|auto|sync.
 *     @type string $fetchpriority high|low|auto.
 *     @type string $sizes         sizes attribute override.
 *     @type int    $width         Explicit width for URL-only images.
 *     @type int    $height        Explicit height for URL-only images.
 * }
 * @return string HTML img element.
 */
function agency_starter_render_image( $args ) {
	$args = wp_parse_args(
		(array) $args,
		array(
			'id'            => 0,
			'url'           => '',
			'alt'           => '',
			'size'          => 'wide',
			'class'         => '',
			'loading'       => 'lazy',
			'decoding'      => 'async',
			'fetchpriority' => '',
			'sizes'         => '',
			'width'         => 0,
			'height'        => 0,
			'draggable'     => null,
		)
	);

	$id = (int) $args['id'];
	if ( $id > 0 && wp_attachment_is_image( $id ) ) {
		$attrs = array(
			'class'    => $args['class'],
			'loading'  => $args['loading'],
			'decoding' => $args['decoding'],
		);

		if ( '' !== $args['alt'] ) {
			$attrs['alt'] = $args['alt'];
		}

		if ( $args['fetchpriority'] ) {
			$attrs['fetchpriority'] = $args['fetchpriority'];
		}

		if ( false === $args['draggable'] ) {
			$attrs['draggable'] = 'false';
		}

		$sizes = $args['sizes'] ?: agency_starter_image_sizes_attr( (string) $args['size'] );
		if ( $sizes ) {
			$attrs['sizes'] = $sizes;
		}

		return wp_get_attachment_image( $id, $args['size'], false, $attrs );
	}

	$url = $args['url'];
	if ( ! $url ) {
		$url = agency_starter_placeholder_url( (string) $args['size'] );
	}

	$dims   = agency_starter_placeholder_dimensions( (string) $args['size'] );
	$width  = (int) $args['width'] ?: $dims[0];
	$height = (int) $args['height'] ?: $dims[1];

	$attributes = array(
		'src'      => esc_url( $url ),
		'alt'      => esc_attr( $args['alt'] ),
		'loading'  => esc_attr( $args['loading'] ),
		'decoding' => esc_attr( $args['decoding'] ),
	);

	if ( $args['class'] ) {
		$attributes['class'] = esc_attr( $args['class'] );
	}
	if ( $width > 0 ) {
		$attributes['width'] = (string) $width;
	}
	if ( $height > 0 ) {
		$attributes['height'] = (string) $height;
	}
	if ( $args['fetchpriority'] ) {
		$attributes['fetchpriority'] = esc_attr( $args['fetchpriority'] );
	}

	if ( false === $args['draggable'] ) {
		$attributes['draggable'] = 'false';
	}

	$sizes = $args['sizes'] ?: agency_starter_image_sizes_attr( (string) $args['size'] );
	if ( $sizes ) {
		$attributes['sizes'] = esc_attr( $sizes );
	}

	$html = '<img';
	foreach ( $attributes as $name => $value ) {
		$html .= sprintf( ' %s="%s"', $name, $value );
	}
	$html .= ' />';

	return $html;
}

/**
 * Placeholder img for patterns and synced content.
 *
 * @param string               $slug Placeholder slug.
 * @param array<string, mixed> $args Passed to agency_starter_render_image().
 * @return string
 */
function agency_starter_placeholder_img( $slug, $args = array() ) {
	return agency_starter_render_image(
		array_merge(
			array(
				'url'  => agency_starter_placeholder_url( $slug ),
				'size' => $slug,
			),
			$args
		)
	);
}

/**
 * Output placeholder featured image when a post has no thumbnail.
 *
 * @param string $block_content Block HTML.
 * @param array  $block         Block data.
 * @return string
 */
function agency_starter_post_featured_image_placeholder( $block_content, $block ) {
	if ( is_admin() || has_post_thumbnail() ) {
		return $block_content;
	}

	$class = $block['attrs']['className'] ?? '';
	$ratio = $block['attrs']['aspectRatio'] ?? '16/9';
	$link  = ! empty( $block['attrs']['isLink'] );
	$alt   = get_the_title() ? get_the_title() : __( 'Article image placeholder', 'agency-starter' );

	$img = agency_starter_render_image(
		array(
			'url'     => agency_starter_placeholder_url( 'blog' ),
			'alt'     => $alt,
			'size'    => 'card',
			'class'   => 'agency-post-card__image--placeholder',
			'loading' => 'lazy',
		)
	);

	if ( $link ) {
		$img = sprintf( '<a href="%s">%s</a>', esc_url( get_permalink() ), $img );
	}

	$classes = trim( 'wp-block-post-featured-image agency-post-card__image agency-post-card__image--empty ' . $class );

	return sprintf(
		'<figure class="%s" style="aspect-ratio:%s">%s</figure>',
		esc_attr( $classes ),
		esc_attr( str_replace( '/', ' / ', $ratio ) ),
		$img
	);
}
add_filter( 'render_block_core/post-featured-image', 'agency_starter_post_featured_image_placeholder', 10, 2 );
