<?php
/**
 * Block bindings for job post meta.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get a job meta value for block bindings.
 *
 * @param array    $source_args    Source arguments.
 * @param WP_Block $block_instance   Block instance.
 * @param string   $meta_key         Meta key to retrieve.
 * @return string|null
 */
function agency_starter_get_job_meta_binding_value( array $source_args, $block_instance, $meta_key ) {
	if ( empty( $block_instance->context['postId'] ) ) {
		return null;
	}

	$post_id = (int) $block_instance->context['postId'];
	$post    = get_post( $post_id );

	if ( ! $post || 'job' !== $post->post_type ) {
		return null;
	}

	if ( ( ! is_post_publicly_viewable( $post ) && ! current_user_can( 'read_post', $post_id ) ) || post_password_required( $post ) ) {
		return null;
	}

	$value = get_post_meta( $post_id, $meta_key, true );

	if ( 'job_status' === $meta_key ) {
		return agency_starter_format_job_status_label( is_string( $value ) ? $value : '' );
	}

	return is_string( $value ) ? $value : '';
}

/**
 * Human-readable job status label.
 *
 * @param string $status Raw status slug.
 * @return string
 */
function agency_starter_format_job_status_label( $status ) {
	$labels = array(
		'open'   => __( 'Open position', 'agency-starter' ),
		'closed' => __( 'Position closed', 'agency-starter' ),
	);

	$status = sanitize_key( $status );

	return $labels[ $status ] ?? $status;
}

/**
 * Register block binding sources for job meta fields.
 */
function agency_starter_register_block_bindings() {
	$sources = array(
		'agency-starter/job-company'  => array(
			'label'    => __( 'Job Company', 'agency-starter' ),
			'meta_key' => 'job_company',
		),
		'agency-starter/job-location' => array(
			'label'    => __( 'Job Location', 'agency-starter' ),
			'meta_key' => 'job_location',
		),
		'agency-starter/job-status'   => array(
			'label'    => __( 'Job Status', 'agency-starter' ),
			'meta_key' => 'job_status',
		),
	);

	foreach ( $sources as $source_name => $config ) {
		register_block_bindings_source(
			$source_name,
			array(
				'label'              => $config['label'],
				'get_value_callback' => function ( $source_args, $block_instance ) use ( $config ) {
					return agency_starter_get_job_meta_binding_value( $source_args, $block_instance, $config['meta_key'] );
				},
				'uses_context'       => array( 'postId', 'postType' ),
			)
		);
	}
}
add_action( 'init', 'agency_starter_register_block_bindings' );
