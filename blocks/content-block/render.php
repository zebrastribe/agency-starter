<?php
/**
 * Content Block — breaker or in-page two-column section.
 *
 * @package Agency_Starter
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Block content.
 * @var WP_Block $block      Block instance.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow         = sanitize_text_field( $attributes['eyebrow'] ?? '' );
$heading         = sanitize_text_field( $attributes['heading'] ?? '' );
$body            = sanitize_textarea_field( $attributes['body'] ?? '' );
$cta_label       = sanitize_text_field( $attributes['ctaLabel'] ?? '' );
$cta_url         = esc_url_raw( $attributes['ctaUrl'] ?? '' );
$media_position  = sanitize_key( $attributes['mediaPosition'] ?? 'right' );
$image_display   = sanitize_key( $attributes['imageDisplay'] ?? 'inline' );
$placement       = sanitize_key( $attributes['placement'] ?? 'default' );
$section_color   = sanitize_key( $attributes['sectionColor'] ?? 'background' );
$use_section_bg  = 'section-background' === $image_display;
$is_breaker      = 'breaker' === $placement;
$media_on_left   = 'left' === $media_position;
$uses_inverse    = agency_starter_content_block_uses_inverse_text( $section_color ) || $use_section_bg;
$image           = agency_starter_content_block_normalize_image( $attributes );
$color_class     = agency_starter_content_block_section_color_class( $section_color );

$section_classes = array(
	'agency-section',
	'agency-content-block',
);
if ( $color_class ) {
	$section_classes[] = $color_class;
}
if ( $is_breaker ) {
	$section_classes[] = 'agency-content-block--breaker';
}
if ( $media_on_left ) {
	$section_classes[] = 'agency-content-block--media-left';
} else {
	$section_classes[] = 'agency-content-block--media-right';
}
if ( $use_section_bg ) {
	$section_classes[] = 'agency-content-block--section-bg';
}

$wrapper_args = array(
	'class' => implode( ' ', $section_classes ),
);
if ( $use_section_bg && $image['url'] ) {
	$wrapper_args['style'] = sprintf( 'background-image: url(%s);', esc_url( $image['url'] ) );
}

$wrapper_attrs = get_block_wrapper_attributes( $wrapper_args );

$cta_class = $uses_inverse ? 'agency-btn--on-dark' : 'agency-btn--employer';

/**
 * Resolve internal paths to full URLs.
 *
 * @param string $href Raw href.
 * @return string
 */
$resolve_href = static function ( $href ) {
	if ( $href && str_starts_with( $href, '/' ) ) {
		return home_url( $href );
	}
	return $href;
};
?>
<section <?php echo $wrapper_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $use_section_bg ) : ?>
		<div class="agency-content-block__scrim" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="agency-container">
		<div class="agency-content-block__split">
			<div class="agency-content-block__content">
				<?php if ( $eyebrow ) : ?>
					<p class="agency-content-block__eyebrow agency-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>

				<?php if ( $heading ) : ?>
					<h2 class="agency-content-block__title agency-section__title"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>

				<?php if ( $body ) : ?>
					<div class="agency-content-block__body agency-lead">
						<?php echo wp_kses_post( wpautop( $body ) ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $cta_label && $cta_url ) : ?>
					<div class="agency-content-block__actions">
						<a class="agency-btn <?php echo esc_attr( $cta_class ); ?> agency-content-block__cta" href="<?php echo esc_url( $resolve_href( $cta_url ) ); ?>">
							<?php echo esc_html( $cta_label ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( ! $use_section_bg ) : ?>
				<div class="agency-content-block__media">
					<figure class="agency-content-block__figure">
						<?php
						echo agency_starter_render_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper.
							array(
								'id'      => $image['id'],
								'url'     => $image['url'],
								'alt'     => $image['alt'],
								'size'    => 'wide',
								'loading' => $is_breaker ? 'eager' : 'lazy',
							)
						);
						?>
					</figure>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
