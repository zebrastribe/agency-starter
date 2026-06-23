<?php
/**
 * Logo Cloud — full-width marquee when enough logos overflow.
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

$label    = sanitize_text_field( $attributes['label'] ?? agency_starter_logo_cloud_default_label() );
$logos    = agency_starter_logo_cloud_normalize_logos( $attributes['logos'] ?? array() );
$min_anim = max( 2, (int) ( $attributes['minLogosForAnimation'] ?? 6 ) );

wp_enqueue_script( 'agency-starter-logo-cloud' );

$wrapper_attrs = get_block_wrapper_attributes(
	array(
		'class'                    => 'agency-section agency-section--compact agency-logo-cloud',
		'data-agency-logo-marquee' => '',
		'data-min-logos'           => (string) $min_anim,
	)
);
?>
<section <?php echo $wrapper_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="agency-logo-cloud__frame">
		<?php if ( $label ) : ?>
			<div class="agency-container">
				<p class="agency-logo-cloud__label"><?php echo esc_html( $label ); ?></p>
			</div>
		<?php endif; ?>

		<div class="agency-logo-cloud__viewport" data-marquee-viewport>
			<div class="agency-logo-cloud__track" data-marquee-track>
				<ul class="agency-logo-cloud__list" data-marquee-list role="list">
					<?php foreach ( $logos as $logo ) : ?>
						<li class="agency-logo-cloud__item">
							<?php
							echo agency_starter_render_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper.
								array(
									'id'     => (int) ( $logo['id'] ?? 0 ),
									'url'    => $logo['url'],
									'alt'    => $logo['alt'],
									'size'   => 'logo',
									'width'  => 140,
									'height' => 48,
									'loading'=> 'lazy',
								)
							);
							?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
