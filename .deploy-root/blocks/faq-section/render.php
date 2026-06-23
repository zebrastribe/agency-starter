<?php
/**
 * FAQ Section — two-column heading + accordion list.
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

$heading = sanitize_text_field( $attributes['heading'] ?? __( 'FAQs', 'agency-starter' ) );
$items   = agency_starter_faq_section_normalize_items( $attributes['items'] ?? array() );

$wrapper_attrs = get_block_wrapper_attributes(
	array(
		'class' => 'agency-section agency-faq-section',
	)
);
?>
<section <?php echo $wrapper_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="agency-container">
		<div class="agency-faq-section__split">
			<?php if ( $heading ) : ?>
				<div class="agency-faq-section__intro">
					<h2 class="agency-faq-section__title agency-section__title"><?php echo esc_html( $heading ); ?></h2>
				</div>
			<?php endif; ?>

			<div class="agency-faq-section__list">
				<?php foreach ( $items as $index => $item ) : ?>
					<details class="agency-faq__item">
						<summary class="agency-faq__summary" aria-expanded="false">
							<span class="agency-faq__question"><?php echo esc_html( $item['question'] ); ?></span>
						</summary>
						<div class="agency-faq__answer">
							<?php echo esc_html( $item['answer'] ); ?>
						</div>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
<?php agency_starter_print_faq_schema_json_ld( $items ); ?>
