<?php
/**
 * CTA Glow Card — centered conversion band with accent gradient.
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

$heading          = sanitize_text_field( $attributes['heading'] ?? '' );
$subheading       = sanitize_text_field( $attributes['subheading'] ?? '' );
$cta_label        = sanitize_text_field( $attributes['ctaLabel'] ?? '' );
$cta_url          = esc_url_raw( $attributes['ctaUrl'] ?? '' );
$section_color    = sanitize_key( $attributes['sectionColor'] ?? 'surface-alt' );
$accent_color     = agency_starter_cta_glow_accent_preset( $attributes['accentColor'] ?? 'accent' );
$glow_position    = agency_starter_cta_glow_position_class( $attributes['glowPosition'] ?? 'bottom-left' );
$show_glow        = ! isset( $attributes['showGlow'] ) || ! empty( $attributes['showGlow'] );
$enable_animation = ! isset( $attributes['enableAnimation'] ) || ! empty( $attributes['enableAnimation'] );
$is_dark          = 'surface-dark' === $section_color;

$section_classes = array(
	'agency-section',
	'agency-cta-glow',
);
$color_class = agency_starter_cta_glow_section_color_class( $section_color );
if ( $color_class ) {
	$section_classes[] = $color_class;
}
if ( $show_glow ) {
	$section_classes[] = $glow_position;
}
if ( $enable_animation && $show_glow ) {
	$section_classes[] = 'agency-cta-glow--animate';
}

$card_style = sprintf(
	'--agency-cta-glow-accent: var(--wp--preset--color--%s, #1fcdbc);',
	esc_attr( $accent_color )
);

$wrapper_attrs = get_block_wrapper_attributes(
	array(
		'class' => implode( ' ', $section_classes ),
	)
);

$cta_class = $is_dark ? 'agency-btn--on-dark' : 'agency-btn--employer';

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
	<div class="agency-container">
		<div class="agency-cta-glow__card" style="<?php echo esc_attr( $card_style ); ?>">
			<?php if ( $show_glow ) : ?>
				<div class="agency-cta-glow__glow" aria-hidden="true"></div>
			<?php endif; ?>

			<div class="agency-cta-glow__inner">
				<?php if ( $heading ) : ?>
					<h2 class="agency-cta-glow__heading"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>

				<?php if ( $subheading ) : ?>
					<p class="agency-cta-glow__subheading"><?php echo esc_html( $subheading ); ?></p>
				<?php endif; ?>

				<?php if ( $cta_label && $cta_url ) : ?>
					<div class="agency-cta-glow__actions">
						<a class="agency-btn <?php echo esc_attr( $cta_class ); ?> agency-cta-glow__cta" href="<?php echo esc_url( $resolve_href( $cta_url ) ); ?>">
							<span class="agency-cta-glow__cta-label"><?php echo esc_html( $cta_label ); ?></span>
							<span class="agency-cta-glow__cta-icon" aria-hidden="true">&rarr;</span>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
