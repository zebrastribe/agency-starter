<?php
/**
 * USP Tabs — vertical accordion + preview panel.
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

$eyebrow         = sanitize_text_field( $attributes['eyebrow'] ?? 'Lorem ipsum partner' );
$heading         = sanitize_text_field( $attributes['heading'] ?? 'Lorem ipsum dolor sit amet' );
$lead            = sanitize_textarea_field( $attributes['lead'] ?? '' );
$show_lead       = ! isset( $attributes['showLead'] ) || ! empty( $attributes['showLead'] );
$media_position  = sanitize_key( $attributes['mediaPosition'] ?? 'right' );
$media_on_left   = 'left' === $media_position;
$items           = agency_starter_usp_tabs_normalize_items( $attributes['items'] ?? array() );
$uid             = wp_unique_id( 'agency-usp-' );

wp_enqueue_script( 'agency-starter-usp-tabs' );

$wrapper_attrs = get_block_wrapper_attributes(
	array(
		'class'                => 'agency-section agency-section--alt agency-usp-tabs',
		'data-agency-usp-tabs' => '',
		'data-orientation'     => 'vertical',
	)
);

$root_classes = array(
	'agency-usp-tabs__root',
	$media_on_left ? 'agency-usp-tabs--media-left' : 'agency-usp-tabs--media-right',
);

ob_start();
?>
<div class="agency-usp-tabs__column">
	<?php if ( $eyebrow || $heading || ( $show_lead && $lead ) ) : ?>
		<div class="agency-usp-tabs__intro">
			<?php if ( $eyebrow ) : ?>
				<p class="agency-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<h2 class="agency-section__title agency-usp-tabs__heading"><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>

			<?php if ( $show_lead && $lead ) : ?>
				<p class="agency-lead agency-usp-tabs__lead"><?php echo esc_html( $lead ); ?></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="agency-usp-tabs__accordion">
		<?php foreach ( $items as $index => $item ) : ?>
			<?php
			$is_active = 0 === $index;
			$tab_id    = $uid . '-tab-' . $index;
			$panel_id  = $uid . '-panel-' . $index;
			$cta_href  = $item['ctaUrl'];
			if ( $cta_href && str_starts_with( $cta_href, '/' ) ) {
				$cta_href = home_url( $cta_href );
			}
			?>
			<div
				class="agency-usp-tabs__item<?php echo $is_active ? ' is-active' : ''; ?>"
				data-usp-item
				data-usp-index="<?php echo esc_attr( (string) $index ); ?>"
			>
				<button
					type="button"
					class="agency-usp-tabs__tab"
					id="<?php echo esc_attr( $tab_id ); ?>"
					aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
					aria-controls="<?php echo esc_attr( $panel_id ); ?>"
					data-usp-tab
					data-usp-index="<?php echo esc_attr( (string) $index ); ?>"
				>
					<span class="agency-usp-tabs__section">
						<?php
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper.
						echo agency_starter_heroicon( $item['icon'], 'agency-usp-tabs__icon' );
						?>
					</span>
					<span class="agency-usp-tabs__label"><?php echo esc_html( $item['title'] ); ?></span>
					<span class="agency-usp-tabs__chevron" data-usp-chevron aria-hidden="true">
						<?php
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper.
						echo agency_starter_heroicon( $is_active ? 'chevron-up' : 'chevron-down', 'agency-usp-tabs__chevron-icon' );
						?>
					</span>
				</button>
				<div
					class="agency-usp-tabs__panel"
					id="<?php echo esc_attr( $panel_id ); ?>"
					role="region"
					aria-labelledby="<?php echo esc_attr( $tab_id ); ?>"
					aria-hidden="<?php echo $is_active ? 'false' : 'true'; ?>"
					data-usp-panel
					data-usp-index="<?php echo esc_attr( (string) $index ); ?>"
				>
					<div class="agency-usp-tabs__panel-inner">
						<p class="agency-usp-tabs__description"><?php echo esc_html( $item['description'] ); ?></p>
						<?php if ( ! empty( $item['ctaLabel'] ) && ! empty( $cta_href ) ) : ?>
							<a class="agency-usp-tabs__cta" href="<?php echo esc_url( $cta_href ); ?>">
								<span><?php echo esc_html( $item['ctaLabel'] ); ?></span>
								<span class="agency-usp-tabs__cta-icon" aria-hidden="true">
									<?php
									// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper.
									echo agency_starter_heroicon( 'arrow-right', 'agency-usp-tabs__cta-arrow' );
									?>
								</span>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
<?php
$column_markup = ob_get_clean();

ob_start();
?>
<div class="agency-usp-tabs__preview">
	<?php foreach ( $items as $index => $item ) : ?>
		<figure
			class="agency-usp-tabs__figure<?php echo 0 === $index ? ' is-active' : ''; ?>"
			data-usp-figure
			data-usp-index="<?php echo esc_attr( (string) $index ); ?>"
			aria-hidden="<?php echo 0 === $index ? 'false' : 'true'; ?>"
		>
			<?php
			echo agency_starter_render_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper.
				array(
					'id'            => (int) ( $item['imageId'] ?? 0 ),
					'url'           => $item['imageUrl'],
					'alt'           => '',
					'size'          => 'wide',
					'loading'       => 0 === $index ? 'eager' : 'lazy',
					'fetchpriority' => 0 === $index ? 'high' : '',
				)
			);
			?>
		</figure>
	<?php endforeach; ?>
</div>
<?php
$preview_markup = ob_get_clean();
?>
<section <?php echo $wrapper_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="agency-container">
		<div class="<?php echo esc_attr( implode( ' ', $root_classes ) ); ?>">
			<?php
			if ( $media_on_left ) {
				echo $preview_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $column_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				echo $column_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $preview_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</div>
	</div>
</section>
