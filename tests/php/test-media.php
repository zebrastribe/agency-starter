<?php
/**
 * Responsive image and media helper tests.
 */

use PHPUnit\Framework\TestCase;

/**
 * Media markup contracts.
 */
class Agency_Starter_Media_Test extends TestCase {

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
	 * Media helper must expose responsive render API.
	 */
	public function test_media_helper_exposes_responsive_render_api() {
		$source = (string) file_get_contents( $this->theme_dir . '/inc/media.php' );
		$this->assertStringContainsString( 'function agency_starter_render_image', $source );
		$this->assertStringContainsString( 'wp_get_attachment_image', $source );
		$this->assertStringContainsString( 'function agency_starter_image_sizes_attr', $source );
		$this->assertStringContainsString( 'function agency_starter_placeholder_img', $source );
	}

	/**
	 * Block renders must use the shared responsive image helper.
	 */
	public function test_block_renders_use_responsive_image_helper() {
		$renders = array(
			'blocks/usp-tabs/render.php',
			'blocks/hero-interactive/render.php',
			'blocks/content-block/render.php',
			'blocks/logo-cloud/render.php',
			'blocks/media-slider/render.php',
		);

		foreach ( $renders as $file ) {
			$source = (string) file_get_contents( $this->theme_dir . '/' . $file );
			$this->assertStringContainsString( 'agency_starter_render_image', $source, $file );
		}
	}
}
