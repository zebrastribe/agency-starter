<?php
/**
 * Pattern registry smoke tests.
 */

use PHPUnit\Framework\TestCase;

/**
 * Pattern count test.
 */
class Agency_Starter_Patterns_Test extends TestCase {

	/**
	 * Ensure extended patterns file returns expected count.
	 */
	public function test_extended_patterns_count() {
		require dirname( __DIR__, 2 ) . '/theme/inc/patterns-more.php';
		$patterns = agency_starter_get_extended_patterns();
		$this->assertCount( 20, $patterns );
	}

	/**
	 * Ensure synced pattern slugs are defined.
	 */
	public function test_synced_pattern_slugs() {
		require dirname( __DIR__, 2 ) . '/theme/inc/synced-patterns.php';
		$slugs = agency_starter_get_synced_pattern_slugs();
		$this->assertCount( 6, $slugs );
		$this->assertArrayHasKey( 'contact-cta-band', $slugs );
	}
}
