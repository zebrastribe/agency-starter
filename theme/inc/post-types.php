<?php
/**
 * Custom post types and meta fields.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the job custom post type.
 */
function agency_starter_register_job_cpt() {
	$archive_slug = apply_filters( 'agency_starter_job_archive_slug', 'kandidater/it-jobs' );

	$labels = array(
		'name'               => __( 'Jobs', 'agency-starter' ),
		'singular_name'      => __( 'Job', 'agency-starter' ),
		'add_new'            => __( 'Add New', 'agency-starter' ),
		'add_new_item'       => __( 'Add New Job', 'agency-starter' ),
		'edit_item'          => __( 'Edit Job', 'agency-starter' ),
		'new_item'           => __( 'New Job', 'agency-starter' ),
		'view_item'          => __( 'View Job', 'agency-starter' ),
		'search_items'       => __( 'Search Jobs', 'agency-starter' ),
		'not_found'          => __( 'No jobs found', 'agency-starter' ),
		'not_found_in_trash' => __( 'No jobs found in Trash', 'agency-starter' ),
		'all_items'          => __( 'All Jobs', 'agency-starter' ),
		'menu_name'          => __( 'Jobs', 'agency-starter' ),
	);

	register_post_type(
		'job',
		array(
			'labels'       => $labels,
			'public'       => true,
			'has_archive'  => $archive_slug,
			'rewrite'      => array(
				'slug'       => $archive_slug,
				'with_front' => false,
			),
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'menu_icon'    => 'dashicons-id-alt',
			'show_in_rest' => true,
		)
	);
}
add_action( 'init', 'agency_starter_register_job_cpt' );

/**
 * Register job post meta fields.
 */
function agency_starter_register_job_meta() {
	$meta_fields = array(
		'job_company'  => __( 'Company', 'agency-starter' ),
		'job_location' => __( 'Location', 'agency-starter' ),
		'job_status'   => __( 'Status', 'agency-starter' ),
	);

	foreach ( $meta_fields as $key => $label ) {
		register_post_meta(
			'job',
			$key,
			array(
				'show_in_rest'      => true,
				'single'            => true,
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
				'auth_callback'     => function () {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}
}
add_action( 'init', 'agency_starter_register_job_meta' );
