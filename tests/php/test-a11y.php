<?php
/**
 * Accessibility contract tests (CI-safe, no running WordPress required).
 */

use PHPUnit\Framework\TestCase;

/**
 * Static a11y markup and integration contracts.
 */
class Agency_Starter_A11y_Test extends TestCase {

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
	 * Skip link must be output on the front end.
	 */
	public function test_skip_link_contract() {
		$source = (string) file_get_contents( $this->theme_dir . '/inc/enqueue.php' );
		$this->assertStringContainsString( 'agency_starter_skip_link', $source );
		$this->assertStringContainsString( 'Skip to content', $source );
	}

	/**
	 * FAQ accordion must start collapsed with aria-expanded on summaries.
	 */
	public function test_faq_starts_collapsed_with_aria_expanded() {
		$render = (string) file_get_contents( $this->theme_dir . '/blocks/faq-section/render.php' );
		$this->assertStringNotContainsString( ' open', $render );
		$this->assertStringContainsString( 'aria-expanded="false"', $render );
	}

	/**
	 * FAQ view script must sync aria-expanded.
	 */
	public function test_faq_view_script_registered() {
		$json = (string) file_get_contents( $this->theme_dir . '/blocks/faq-section/block.json' );
		$this->assertStringContainsString( 'agency-starter-faq-section', $json );
		$this->assertFileExists( dirname( __DIR__, 2 ) . '/javascript/faq-section.js' );
	}

	/**
	 * CF7 demo forms must use accessible field markup helpers.
	 */
	public function test_cf7_forms_use_accessible_markup() {
		$source = (string) file_get_contents( $this->theme_dir . '/inc/cf7-forms.php' );
		$this->assertStringContainsString( 'agency_starter_cf7_field_markup', $source );
		$this->assertStringContainsString( 'for="%1$s"', $source );
		$this->assertStringContainsString( 'autocomplete:', $source );

		$plugins = (string) file_get_contents( $this->theme_dir . '/inc/plugins.php' );
		$this->assertStringContainsString( 'agency_starter_cf7_contact_form', $plugins );
	}

	/**
	 * RTL stylesheet must exist and enqueue when is_rtl().
	 */
	public function test_rtl_stylesheet_contract() {
		$this->assertFileExists( $this->theme_dir . '/rtl.css' );
		$enqueue = (string) file_get_contents( $this->theme_dir . '/inc/enqueue.php' );
		$this->assertStringContainsString( 'is_rtl()', $enqueue );
		$this->assertStringContainsString( '/rtl.css', $enqueue );
	}

	/**
	 * Primary navigation must render nested menu trees and mega-menu helpers.
	 */
	public function test_primary_navigation_renders_nested_menus() {
		$nav = (string) file_get_contents( $this->theme_dir . '/inc/navigation.php' );
		$this->assertStringContainsString( 'agency_starter_nav_build_tree', $nav );
		$this->assertStringContainsString( 'agency-nav-panels', $nav );
		$this->assertStringContainsString( 'agency_starter_get_mobile_nav_markup', $nav );
		$this->assertStringContainsString( 'wp_nav_menu_item_custom_fields', $nav );
	}

	/**
	 * Mobile navigation dialog must expose modal semantics.
	 */
	public function test_mobile_nav_dialog_contract() {
		$nav = (string) file_get_contents( $this->theme_dir . '/inc/navigation.php' );
		$this->assertStringContainsString( 'role="dialog"', $nav );
		$this->assertStringContainsString( 'aria-modal="true"', $nav );
	}

	/**
	 * 404 must use translatable pattern, not hardcoded English in template.
	 */
	public function test_404_uses_i18n_pattern() {
		$template = (string) file_get_contents( $this->theme_dir . '/templates/404.html' );
		$this->assertStringContainsString( 'agency-starter/404-content', $template );
	}
}
