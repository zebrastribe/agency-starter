<?php
/**
 * Demo mode helpers — gate seeding and admin upgrades.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether demo seeding is enabled for this install.
 *
 * @return bool
 */
function agency_starter_demo_enabled() {
	return (bool) AGENCY_STARTER_DEMO;
}

/**
 * Whether privileged demo maintenance may run on admin_init.
 *
 * @return bool
 */
function agency_starter_can_run_admin_seeder() {
	return agency_starter_demo_enabled() && current_user_can( 'manage_options' );
}
