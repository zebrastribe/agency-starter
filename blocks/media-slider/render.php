<?php
/**
 * Media Slider — full-width testimonial / showcase carousel.
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

$header_defaults = agency_starter_media_slider_default_header();
$eyebrow         = sanitize_text_field( $attributes['eyebrow'] ?? '' ) ?: $header_defaults['eyebrow'];
$heading         = sanitize_text_field( $attributes['heading'] ?? '' ) ?: $header_defaults['heading'];
$intro           = sanitize_textarea_field( $attributes['intro'] ?? '' ) ?: $header_defaults['intro'];
$slides      = agency_starter_media_slider_normalize_slides( $attributes['slides'] ?? array() );
$slide_count = count( $slides );

wp_enqueue_script( 'agency-starter-media-slider' );

$wrapper_attrs = get_block_wrapper_attributes(
	array(
		'class'                     => 'agency-section agency-media-slider alignfull',
		'data-agency-media-slider'  => '',
	)
);

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
	<div class="agency-container agency-media-slider__header-wrap">
		<header class="agency-media-slider__header">
			<div class="agency-media-slider__heading-group">
				<?php if ( $eyebrow ) : ?>
					<p class="agency-eyebrow agency-media-slider__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>
				<?php if ( $heading ) : ?>
					<h2 class="agency-media-slider__title"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
			</div>
			<?php if ( $intro ) : ?>
				<p class="agency-lead agency-media-slider__intro"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
		</header>
	</div>

	<div class="agency-media-slider__stage" aria-live="polite">
		<div class="agency-media-slider__viewport">
			<div class="agency-media-slider__track" data-media-slider-track>
				<?php foreach ( $slides as $slide_index => $slide ) : ?>
					<?php
					$is_active   = 0 === $slide_index;
					$slide_class = 'agency-media-slider__slide';
					if ( $is_active ) {
						$slide_class .= ' is-active';
					}
					$has_video = ! empty( $slide['videoUrl'] );
					$has_cta   = ! empty( $slide['ctaLabel'] ) && ! empty( $slide['ctaUrl'] );
					?>
					<article
						class="<?php echo esc_attr( $slide_class ); ?>"
						data-media-slide
						data-slide-index="<?php echo esc_attr( (string) $slide_index ); ?>"
						aria-hidden="<?php echo $is_active ? 'false' : 'true'; ?>"
					>
						<div class="agency-media-slider__card">
							<div class="agency-media-slider__media">
								<?php
								echo agency_starter_render_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									array(
										'id'         => (int) ( $slide['imageId'] ?? 0 ),
										'url'        => $slide['imageUrl'],
										'alt'        => $slide['title'],
										'size'       => 'card',
										'sizes'      => agency_starter_image_sizes_attr( 'media-slider' ),
										'loading'    => 0 === $slide_index ? 'eager' : 'lazy',
										'class'      => 'agency-media-slider__image',
										'draggable'  => false,
									)
								);
								?>
								<?php if ( $has_video ) : ?>
									<a
										class="agency-media-slider__play"
										href="<?php echo esc_url( $resolve_href( $slide['videoUrl'] ) ); ?>"
										target="_blank"
										rel="noopener noreferrer"
										aria-label="<?php echo esc_attr( sprintf( /* translators: %s: slide title */ __( 'Play video: %s', 'agency-starter' ), $slide['title'] ) ); ?>"
									>
										<span class="agency-media-slider__play-icon" aria-hidden="true"></span>
									</a>
								<?php endif; ?>
							</div>
							<div class="agency-media-slider__body">
								<?php if ( ! empty( $slide['title'] ) ) : ?>
									<h3 class="agency-media-slider__slide-title"><?php echo esc_html( $slide['title'] ); ?></h3>
								<?php endif; ?>
								<?php if ( ! empty( $slide['body'] ) ) : ?>
									<p class="agency-media-slider__slide-text"><?php echo esc_html( $slide['body'] ); ?></p>
								<?php endif; ?>
								<?php if ( $has_cta ) : ?>
									<a class="agency-media-slider__cta agency-btn agency-btn--ghost" href="<?php echo esc_url( $resolve_href( $slide['ctaUrl'] ) ); ?>">
										<?php echo esc_html( $slide['ctaLabel'] ); ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>

		<?php if ( $slide_count > 1 ) : ?>
			<div class="agency-media-slider__nav" role="group" aria-label="<?php esc_attr_e( 'Slide navigation', 'agency-starter' ); ?>">
				<div class="agency-media-slider__dots">
					<?php for ( $dot = 0; $dot < $slide_count; $dot++ ) : ?>
						<button
							type="button"
							class="agency-media-slider__dot<?php echo 0 === $dot ? ' is-active' : ''; ?>"
							data-media-dot
							data-slide-index="<?php echo esc_attr( (string) $dot ); ?>"
							aria-label="<?php echo esc_attr( sprintf( /* translators: %d: slide number */ __( 'Show slide %d', 'agency-starter' ), $dot + 1 ) ); ?>"
							<?php echo 0 === $dot ? 'aria-current="true"' : ''; ?>
						></button>
					<?php endfor; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
