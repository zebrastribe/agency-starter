<?php
/**
 * Accessible Contact Form 7 demo form markup.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build one CF7 field row with explicit label association.
 *
 * @param array<string, mixed> $field Field config.
 * @return string
 */
function agency_starter_cf7_field_markup( $field ) {
	$name         = sanitize_key( $field['name'] ?? '' );
	$label        = sanitize_text_field( $field['label'] ?? '' );
	$type         = sanitize_key( $field['type'] ?? 'text' );
	$required     = ! empty( $field['required'] );
	$autocomplete = sanitize_key( $field['autocomplete'] ?? '' );

	if ( ! $name || ! $label ) {
		return '';
	}

	$required_mark = $required ? ' <span class="agency-required" aria-hidden="true">*</span>' : '';
	$required_attr = $required ? '*' : '';
	$autocomplete  = $autocomplete ? ' autocomplete:' . $autocomplete : '';

	if ( 'textarea' === $type ) {
		$control = sprintf( '[textarea%s %s id:%s class:agency-cf7-input%s]', $required_attr, $name, $name, $autocomplete );
	} else {
		$control = sprintf( '[%s%s %s id:%s class:agency-cf7-input%s]', $type, $required_attr, $name, $name, $autocomplete );
	}

	return sprintf(
		'<p class="agency-cf7-field"><label for="%1$s">%2$s%3$s</label>' . "\n" . '%4$s</p>',
		esc_attr( $name ),
		esc_html( $label ),
		$required_mark,
		$control
	);
}

/**
 * Compose a demo CF7 form from field definitions.
 *
 * @param array<int, array<string, mixed>> $fields Field rows.
 * @param string                           $submit Submit button label.
 * @return string
 */
function agency_starter_cf7_form_markup( $fields, $submit ) {
	$rows = array();

	foreach ( $fields as $field ) {
		$row = agency_starter_cf7_field_markup( $field );
		if ( $row ) {
			$rows[] = $row;
		}
	}

	$rows[] = sprintf( '<p class="agency-cf7-actions">[submit "%s"]</p>', esc_attr( $submit ) );

	return implode( "\n\n", $rows );
}

/**
 * Demo employer form markup.
 *
 * @return string
 */
function agency_starter_cf7_employer_form() {
	return agency_starter_cf7_form_markup(
		array(
			array(
				'label'        => __( 'Lorem name', 'agency-starter' ),
				'name'         => 'your-name',
				'type'         => 'text',
				'required'     => true,
				'autocomplete' => 'name',
			),
			array(
				'label'        => __( 'Lorem company', 'agency-starter' ),
				'name'         => 'your-company',
				'type'         => 'text',
				'required'     => true,
				'autocomplete' => 'organization',
			),
			array(
				'label'        => __( 'Lorem email', 'agency-starter' ),
				'name'         => 'your-email',
				'type'         => 'email',
				'required'     => true,
				'autocomplete' => 'email',
			),
			array(
				'label'    => __( 'Lorem message', 'agency-starter' ),
				'name'     => 'your-message',
				'type'     => 'textarea',
				'required' => false,
			),
		),
		__( 'Lorem send', 'agency-starter' )
	);
}

/**
 * Demo candidate form markup.
 *
 * @return string
 */
function agency_starter_cf7_candidate_form() {
	return agency_starter_cf7_form_markup(
		array(
			array(
				'label'        => __( 'Lorem name', 'agency-starter' ),
				'name'         => 'your-name',
				'type'         => 'text',
				'required'     => true,
				'autocomplete' => 'name',
			),
			array(
				'label'        => __( 'Lorem email', 'agency-starter' ),
				'name'         => 'your-email',
				'type'         => 'email',
				'required'     => true,
				'autocomplete' => 'email',
			),
			array(
				'label'        => __( 'Lorem phone', 'agency-starter' ),
				'name'         => 'your-phone',
				'type'         => 'tel',
				'required'     => false,
				'autocomplete' => 'tel',
			),
			array(
				'label'    => __( 'Lorem message', 'agency-starter' ),
				'name'     => 'your-message',
				'type'     => 'textarea',
				'required' => false,
			),
		),
		__( 'Lorem apply', 'agency-starter' )
	);
}

/**
 * Demo contact form markup.
 *
 * @return string
 */
function agency_starter_cf7_contact_form() {
	return agency_starter_cf7_form_markup(
		array(
			array(
				'label'        => __( 'Lorem name', 'agency-starter' ),
				'name'         => 'your-name',
				'type'         => 'text',
				'required'     => true,
				'autocomplete' => 'name',
			),
			array(
				'label'        => __( 'Lorem email', 'agency-starter' ),
				'name'         => 'your-email',
				'type'         => 'email',
				'required'     => true,
				'autocomplete' => 'email',
			),
			array(
				'label'    => __( 'Lorem subject', 'agency-starter' ),
				'name'     => 'your-subject',
				'type'     => 'text',
				'required' => false,
			),
			array(
				'label'    => __( 'Lorem message', 'agency-starter' ),
				'name'     => 'your-message',
				'type'     => 'textarea',
				'required' => true,
			),
		),
		__( 'Lorem send message', 'agency-starter' )
	);
}
