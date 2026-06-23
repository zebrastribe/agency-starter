<?php
/**
 * Performance asset loading contracts.
 */

use PHPUnit\Framework\TestCase;

/**
 * Conditional enqueue tests.
 */
class Agency_Starter_Performance_Test extends TestCase {

	/**
	 * Theme root directory.
	 *
	 * @var string
	 */
	private $theme_dir;

	/**
	 * Set up paths.
	 */
	protected function setUp(): void {
		$this->theme_dir = dirname( __DIR__, 2 ) . '/theme';
	}

	/**
	 * Mobile nav script must be conditional on header template part.
	 */
	public function test_mobile_nav_script_is_conditional() {
		$source = (string) file_get_contents( $this->theme_dir . '/inc/enqueue.php' );
		$this->assertStringContainsString( 'agency_starter_theme_uses_mobile_nav', $source );
	}

	/**
	 * Prose bundle must load only on editorial views.
	 */
	public function test_prose_styles_are_conditional() {
		$source = (string) file_get_contents( $this->theme_dir . '/inc/enqueue.php' );
		$this->assertStringContainsString( 'agency_starter_needs_prose_styles', $source );
		$this->assertStringContainsString( 'css/prose-content.css', $source );
		$this->assertFileExists( $this->theme_dir . '/css/critical-header.css' );
	}

	/**
	 * Editorial templates apply prose classes to post content.
	 */
	public function test_editorial_templates_include_prose_class() {
		$single = (string) file_get_contents( $this->theme_dir . '/templates/single.html' );
		$this->assertStringContainsString( 'prose prose-neutral', $single );
	}
}
