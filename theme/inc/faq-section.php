<?php
/**
 * FAQ Section block helpers.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default FAQ items.
 *
 * @return array<int, array{question: string, answer: string}>
 */
function agency_starter_faq_section_default_items() {
	return array(
		array(
			'question' => __( 'Does this replace legal counsel?', 'agency-starter' ),
			'answer'   => __( 'No. The platform reduces risk and manual work by embedding compliance into day-to-day operations, but it does not replace legal advice.', 'agency-starter' ),
		),
		array(
			'question' => __( 'Can compliance really be centralized globally?', 'agency-starter' ),
			'answer'   => __( 'Yes. Policies, worker data, and required actions are tracked in one platform so teams see the same source of truth across countries.', 'agency-starter' ),
		),
		array(
			'question' => __( 'Where do compliance insights live?', 'agency-starter' ),
			'answer'   => __( 'Insights appear in dashboards and worker profiles, with alerts when regulations or employment status changes require action.', 'agency-starter' ),
		),
		array(
			'question' => __( 'How are complex or edge cases handled?', 'agency-starter' ),
			'answer'   => __( 'Edge cases are flagged for review with context and documentation so legal and HR teams can resolve them without losing track.', 'agency-starter' ),
		),
		array(
			'question' => __( 'How does the platform help prevent worker misclassification?', 'agency-starter' ),
			'answer'   => __( 'Classification checks, contract templates, and audit trails help teams hire with the right worker type from the start.', 'agency-starter' ),
		),
	);
}

/**
 * Normalize a single FAQ item.
 *
 * @param array<string, mixed>  $item     Raw item.
 * @param array<string, string> $fallback Fallback item.
 * @return array{question: string, answer: string}
 */
function agency_starter_faq_section_normalize_item( $item, $fallback ) {
	if ( ! is_array( $item ) ) {
		return $fallback;
	}

	return array(
		'question' => sanitize_text_field( ! empty( $item['question'] ) ? $item['question'] : $fallback['question'] ),
		'answer'   => sanitize_textarea_field( ! empty( $item['answer'] ) ? $item['answer'] : $fallback['answer'] ),
	);
}

/**
 * Normalize FAQ items from block attributes.
 *
 * @param mixed $items Raw items attribute.
 * @return array<int, array{question: string, answer: string}>
 */
function agency_starter_faq_section_normalize_items( $items ) {
	$defaults = agency_starter_faq_section_default_items();

	if ( ! is_array( $items ) || empty( $items ) ) {
		return $defaults;
	}

	$normalized = array();
	foreach ( $items as $index => $item ) {
		$fallback     = $defaults[ $index ] ?? $defaults[0];
		$normalized[] = agency_starter_faq_section_normalize_item( $item, $fallback );
	}

	return $normalized;
}

/**
 * Print FAQPage JSON-LD for normalized FAQ items.
 *
 * @param array<int, array{question: string, answer: string}> $items FAQ items.
 * @return void
 */
function agency_starter_print_faq_schema_json_ld( array $items ) {
	if ( defined( 'WPSEO_VERSION' ) || empty( $items ) ) {
		return;
	}

	static $printed = false;
	if ( $printed ) {
		return;
	}

	$entities = array();
	foreach ( $items as $item ) {
		if ( empty( $item['question'] ) || empty( $item['answer'] ) ) {
			continue;
		}
		$entities[] = array(
			'@type'          => 'Question',
			'name'           => $item['question'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $item['answer'],
			),
		);
	}

	if ( empty( $entities ) ) {
		return;
	}

	$printed = true;

	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $entities,
	);

	printf(
		'<script type="application/ld+json">%s</script>' . "\n",
		wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
	);
}
