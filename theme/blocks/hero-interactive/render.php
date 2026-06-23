<?php
/**
 * Interactive Hero — split layout with content left and media slider right.
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

$eyebrow             = sanitize_text_field( $attributes['eyebrow'] ?? '' );
$heading             = sanitize_text_field( $attributes['heading'] ?? '' );
$heading_accent      = sanitize_text_field( $attributes['headingAccent'] ?? '' );
$lead                = sanitize_textarea_field( $attributes['lead'] ?? '' );
$primary_cta_label   = sanitize_text_field( $attributes['primaryCtaLabel'] ?? '' );
$primary_cta_url     = esc_url_raw( $attributes['primaryCtaUrl'] ?? '' );
$secondary_cta_label = sanitize_text_field( $attributes['secondaryCtaLabel'] ?? '' );
$secondary_cta_url   = esc_url_raw( $attributes['secondaryCtaUrl'] ?? '' );
$full_viewport       = ! empty( $attributes['fullViewport'] );
$media_image_display = sanitize_key( $attributes['mediaImageDisplay'] ?? 'inline' );
$content_color       = agency_starter_hero_interactive_color_preset( $attributes['contentColor'] ?? 'primary', 'panel' );
$media_color         = agency_starter_hero_interactive_color_preset( $attributes['mediaColor'] ?? 'surface-dark', 'panel' );
$accent_color        = agency_starter_hero_interactive_color_preset( $attributes['headingAccentColor'] ?? 'secondary', 'accent' );
$content_inverse     = agency_starter_hero_interactive_uses_inverse_text( $content_color );
$media_inverse       = agency_starter_hero_interactive_uses_inverse_text( $media_color );
$use_cover_image     = 'cover' === $media_image_display;
$slides              = agency_starter_hero_interactive_normalize_slides(
	$attributes['slides'] ?? array(),
	$attributes['items'] ?? array()
);
$uid         = wp_unique_id( 'agency-hero-int-' );
$slide_count = count( $slides );
$heading_tag = is_front_page() ? 'h1' : 'h2';

wp_enqueue_script( 'agency-starter-hero-interactive' );

$section_classes = array(
	'agency-section',
	'agency-hero',
	'agency-hero-interactive',
);
if ( $full_viewport ) {
	$section_classes[] = 'agency-hero-interactive--viewport';
}
if ( $use_cover_image ) {
	$section_classes[] = 'agency-hero-interactive--media-cover';
}

$wrapper_attrs = get_block_wrapper_attributes(
	array(
		'class'                        => implode( ' ', $section_classes ),
		'style'                        => agency_starter_hero_interactive_color_style( $content_color, $media_color, $accent_color ),
		'data-agency-hero-interactive' => '',
	)
);

$content_panel_class = 'agency-hero-interactive__content agency-hero-interactive__content--' . ( $content_inverse ? 'on-dark' : 'on-light' );
$media_panel_class   = 'agency-hero-interactive__media agency-hero-interactive__media--' . ( $media_inverse ? 'on-dark' : 'on-light' );
$primary_cta_class   = $content_inverse ? 'agency-btn--on-dark' : 'agency-btn--employer';

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
	<div class="agency-hero-interactive__split">
		<div class="<?php echo esc_attr( $content_panel_class ); ?>">
			<div class="agency-hero-interactive__content-inner">
				<?php if ( $eyebrow ) : ?>
					<p class="agency-hero-interactive__eyebrow agency-motion-enter-subtle"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>

				<?php if ( $heading ) : ?>
					<<?php echo tag_escape( $heading_tag ); ?> class="agency-hero__title agency-hero-interactive__title<?php echo 'h1' === $heading_tag ? ' agency-motion-enter-subtle' : ''; ?>">
						<?php echo esc_html( $heading ); ?>
						<?php if ( $heading_accent ) : ?>
							<span class="agency-hero-interactive__accent"><?php echo esc_html( $heading_accent ); ?></span>
						<?php endif; ?>
					</<?php echo tag_escape( $heading_tag ); ?>>
				<?php endif; ?>

				<?php if ( $lead ) : ?>
					<p class="agency-hero__lead agency-hero-interactive__lead"><?php echo esc_html( $lead ); ?></p>
				<?php endif; ?>

				<?php if ( $primary_cta_label || $secondary_cta_label ) : ?>
					<div class="agency-hero__actions agency-hero-interactive__actions">
						<?php if ( $primary_cta_label && $primary_cta_url ) : ?>
							<a class="agency-btn <?php echo esc_attr( $primary_cta_class ); ?> agency-hero-interactive__cta" href="<?php echo esc_url( $resolve_href( $primary_cta_url ) ); ?>">
								<?php echo esc_html( $primary_cta_label ); ?>
							</a>
						<?php endif; ?>
						<?php if ( $secondary_cta_label && $secondary_cta_url ) : ?>
							<a class="agency-btn agency-btn--ghost agency-hero-interactive__ghost" href="<?php echo esc_url( $resolve_href( $secondary_cta_url ) ); ?>">
								<?php echo esc_html( $secondary_cta_label ); ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="<?php echo esc_attr( $media_panel_class ); ?>" aria-live="polite">
			<div class="agency-hero-interactive__slider" data-hero-slider>
				<?php foreach ( $slides as $slide_index => $slide ) : ?>
					<?php
					$is_active   = 0 === $slide_index;
					$quote_id    = $uid . '-quote-' . $slide_index;
					$has_caption = ! empty( $slide['label'] ) || ! empty( $slide['quote'] ) || ! empty( $slide['attribution'] );
					$slide_class = 'agency-hero-interactive__slide';
					if ( $is_active ) {
						$slide_class .= ' is-active';
					}
					if ( $use_cover_image ) {
						$slide_class .= ' agency-hero-interactive__slide--cover';
					}

					$slide_attrs = array(
						'class'             => $slide_class,
						'data-hero-slide'   => '',
						'data-slide-index'  => (string) $slide_index,
					);
					if ( $use_cover_image ) {
						$slide_attrs['data-hero-swipe'] = '';
					}
					if ( $use_cover_image && ! empty( $slide['imageUrl'] ) ) {
						$slide_attrs['style'] = sprintf(
							'background-image: url(%s);',
							esc_url( $slide['imageUrl'] )
						);
					}
					if ( ! $is_active ) {
						$slide_attrs['hidden'] = 'hidden';
					}

					$slide_attr_string = '';
					foreach ( $slide_attrs as $attr_key => $attr_value ) {
						if ( 'hidden' === $attr_key ) {
							$slide_attr_string .= ' hidden';
							continue;
						}
						$slide_attr_string .= sprintf( ' %s="%s"', esc_attr( $attr_key ), esc_attr( $attr_value ) );
					}
					?>
					<div<?php echo $slide_attr_string; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php if ( $use_cover_image ) : ?>
							<div class="agency-hero-interactive__slide-scrim" aria-hidden="true"></div>
							<div class="agency-hero-interactive__slide-content">
								<?php if ( $has_caption ) : ?>
									<div class="agency-hero-interactive__caption">
										<?php if ( ! empty( $slide['label'] ) ) : ?>
											<p class="agency-hero-interactive__slide-label"><?php echo esc_html( $slide['label'] ); ?></p>
										<?php endif; ?>
										<?php if ( ! empty( $slide['quote'] ) ) : ?>
											<blockquote class="agency-hero-interactive__quote" id="<?php echo esc_attr( $quote_id ); ?>">
												<p><?php echo esc_html( $slide['quote'] ); ?></p>
											</blockquote>
										<?php endif; ?>
										<?php if ( ! empty( $slide['attribution'] ) ) : ?>
											<p class="agency-hero-interactive__attribution"><?php echo esc_html( $slide['attribution'] ); ?></p>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						<?php else : ?>
							<figure class="agency-hero-interactive__figure" data-hero-swipe>
						<?php
						echo agency_starter_render_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper.
							array(
								'id'         => (int) ( $slide['imageId'] ?? 0 ),
								'url'        => $slide['imageUrl'],
								'alt'        => '',
								'size'       => 'hero',
								'loading'    => 0 === $slide_index ? 'eager' : 'lazy',
								'draggable'  => false,
							)
						);
						?>
							</figure>
							<?php if ( $has_caption ) : ?>
								<div class="agency-hero-interactive__caption">
									<?php if ( ! empty( $slide['label'] ) ) : ?>
										<p class="agency-hero-interactive__slide-label"><?php echo esc_html( $slide['label'] ); ?></p>
									<?php endif; ?>
									<?php if ( ! empty( $slide['quote'] ) ) : ?>
										<blockquote class="agency-hero-interactive__quote" id="<?php echo esc_attr( $quote_id ); ?>">
											<p><?php echo esc_html( $slide['quote'] ); ?></p>
										</blockquote>
									<?php endif; ?>
									<?php if ( ! empty( $slide['attribution'] ) ) : ?>
										<p class="agency-hero-interactive__attribution"><?php echo esc_html( $slide['attribution'] ); ?></p>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( $slide_count > 1 ) : ?>
				<div class="agency-hero-interactive__slider-nav">
					<div class="agency-hero-interactive__dots" role="group" aria-label="<?php echo agency_starter_esc_attr__( 'Hero slides' ); ?>">
						<?php for ( $dot = 0; $dot < $slide_count; $dot++ ) : ?>
							<button
								type="button"
								class="agency-hero-interactive__dot<?php echo 0 === $dot ? ' is-active' : ''; ?>"
								data-hero-dot
								data-slide-index="<?php echo esc_attr( (string) $dot ); ?>"
								aria-label="<?php echo esc_attr( sprintf( /* translators: %d: slide number */ __( 'Show slide %d', 'agency-starter' ), $dot + 1 ) ); ?>"
								<?php echo 0 === $dot ? 'aria-current="true"' : ''; ?>
							></button>
						<?php endfor; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
