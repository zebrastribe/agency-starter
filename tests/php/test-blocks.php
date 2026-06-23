<?php
/**
 * Block contract tests — catch missing scripts, hooks, and render markup.
 */

use PHPUnit\Framework\TestCase;

/**
 * Block registration and markup contracts.
 */
class Agency_Starter_Blocks_Test extends TestCase {

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
	 * @param string $block Block folder name.
	 * @return array<string, mixed>
	 */
	private function read_block_json( $block ) {
		$path = $this->theme_dir . '/blocks/' . $block . '/block.json';
		$this->assertFileExists( $path, "Missing block.json for {$block}" );
		$data = json_decode( (string) file_get_contents( $path ), true );
		$this->assertIsArray( $data );
		return $data;
	}

	/**
	 * Interactive blocks must declare a viewScript handle.
	 */
	public function test_interactive_blocks_declare_view_script() {
		$expected = array(
			'usp-tabs'         => 'agency-starter-usp-tabs',
			'logo-cloud'       => 'agency-starter-logo-cloud',
			'hero-interactive' => 'agency-starter-hero-interactive',
			'media-slider'     => 'agency-starter-media-slider',
		);

		foreach ( $expected as $block => $handle ) {
			$json = $this->read_block_json( $block );
			$this->assertSame( $handle, $json['viewScript'] ?? null, "{$block} viewScript handle" );
		}
	}

	/**
	 * View script bundles must exist on disk.
	 */
	public function test_view_script_files_exist() {
		$files = array(
			'js/usp-tabs.min.js',
			'js/logo-cloud.min.js',
			'js/hero-interactive.min.js',
			'js/media-slider.min.js',
		);

		foreach ( $files as $file ) {
			$this->assertFileExists( $this->theme_dir . '/' . $file, "Missing built script: {$file}" );
		}
	}

	/**
	 * USP tabs render template must expose JS hooks and enqueue script.
	 */
	public function test_usp_tabs_render_contract() {
		$render = (string) file_get_contents( $this->theme_dir . '/blocks/usp-tabs/render.php' );
		$this->assertStringContainsString( "wp_enqueue_script( 'agency-starter-usp-tabs' )", $render );
		$this->assertStringContainsString( 'data-agency-usp-tabs', $render );
		$this->assertStringContainsString( 'data-usp-item', $render );
		$this->assertStringContainsString( 'data-usp-tab', $render );
		$this->assertStringContainsString( 'data-usp-panel', $render );
		$this->assertStringContainsString( 'data-usp-figure', $render );
		$this->assertStringContainsString( 'aria-expanded', $render );
		$this->assertStringContainsString( 'agency-usp-tabs__accordion', $render );
	}

	/**
	 * FAQ render must use native details/summary accordion markup.
	 */
	public function test_faq_section_render_contract() {
		$render = (string) file_get_contents( $this->theme_dir . '/blocks/faq-section/render.php' );
		$this->assertStringContainsString( '<details', $render );
		$this->assertStringContainsString( '<summary', $render );
		$this->assertStringContainsString( 'agency-faq__item', $render );
		$this->assertStringNotContainsString( ' open', $render );
	}

	/**
	 * Media slider render must expose carousel hooks and enqueue script.
	 */
	public function test_media_slider_render_contract() {
		$render = (string) file_get_contents( $this->theme_dir . '/blocks/media-slider/render.php' );
		$this->assertStringContainsString( "wp_enqueue_script( 'agency-starter-media-slider' )", $render );
		$this->assertStringContainsString( 'data-agency-media-slider', $render );
		$this->assertStringContainsString( 'data-media-slider-track', $render );
		$this->assertStringContainsString( 'data-media-slide', $render );
		$this->assertStringContainsString( 'data-media-dot', $render );
		$this->assertStringContainsString( 'agency-media-slider__slide', $render );
	}

	/**
	 * Interactive hero must expose configurable panel color hooks.
	 */
	public function test_hero_interactive_render_exposes_color_controls() {
		$render = (string) file_get_contents( $this->theme_dir . '/blocks/hero-interactive/render.php' );
		$helper = (string) file_get_contents( $this->theme_dir . '/inc/hero-interactive.php' );

		$this->assertStringContainsString( 'agency_starter_hero_interactive_color_style', $render );
		$this->assertStringContainsString( 'agency-hero-interactive__content--on-dark', $render );
		$this->assertStringContainsString( 'agency-hero-interactive__media--on-light', $render );
		$this->assertStringContainsString( 'function agency_starter_hero_interactive_panel_colors', $helper );
		$this->assertStringContainsString( 'function agency_starter_hero_interactive_accent_colors', $helper );
	}

	/**
	 * blocks.php must register view scripts before block registration.
	 */
	public function test_blocks_php_registers_view_scripts() {
		$source = (string) file_get_contents( $this->theme_dir . '/inc/blocks.php' );
		$this->assertStringContainsString( 'agency_starter_register_block_view_scripts', $source );
		$this->assertStringContainsString( 'agency-starter-usp-tabs', $source );
		$this->assertStringContainsString( "add_action( 'init', 'agency_starter_register_block_view_scripts', 9 )", $source );
	}

	/**
	 * Custom blocks must live in the dedicated Agency Starter inserter category.
	 */
	public function test_custom_blocks_use_agency_starter_category() {
		$blocks_dir = $this->theme_dir . '/blocks';
		$block_json = glob( $blocks_dir . '/*/block.json' ) ?: array();

		$this->assertNotEmpty( $block_json );

		foreach ( $block_json as $file ) {
			$data = json_decode( (string) file_get_contents( $file ), true );
			$name = basename( dirname( $file ) );
			$this->assertSame( 'agency-starter', $data['category'] ?? '', $name );
		}

		$source = (string) file_get_contents( $this->theme_dir . '/inc/blocks.php' );
		$this->assertStringContainsString( 'block_categories_all', $source );
		$this->assertStringContainsString( 'agency_starter_register_block_category', $source );
	}

	/**
	 * Post archive templates must declare query namespaces for category filtering.
	 */
	public function test_post_archive_templates_declare_query_namespace() {
		$news = (string) file_get_contents( $this->theme_dir . '/templates/page-archive-news.html' );
		$this->assertStringContainsString( '"namespace":"agency-starter/news"', $news );
		$this->assertStringContainsString( 'agency-starter/post-card', $news );

		$articles = (string) file_get_contents( $this->theme_dir . '/templates/page-archive-articles.html' );
		$this->assertStringContainsString( '"namespace":"agency-starter/articles"', $articles );
		$this->assertStringNotContainsString( 'taxQuery', $articles );
	}

	/**
	 * Post archive filter module must map namespaces and page templates.
	 */
	public function test_post_archives_php_contract() {
		$source = (string) file_get_contents( $this->theme_dir . '/inc/post-archives.php' );
		$this->assertStringContainsString( 'agency_starter_filter_query_loop_block_query_vars', $source );
		$this->assertStringContainsString( 'agency-starter/news', $source );
		$this->assertStringContainsString( 'agency-starter/articles', $source );
		$this->assertStringContainsString( 'page-archive-news', $source );
		$this->assertStringContainsString( 'page-archive-articles', $source );
		$this->assertStringContainsString( "add_filter( 'query_loop_block_query_vars'", $source );
	}

	/**
	 * Single template and comments part must wire the comments block.
	 */
	public function test_single_template_includes_comments_part() {
		$single = (string) file_get_contents( $this->theme_dir . '/templates/single.html' );
		$this->assertStringContainsString( '"slug":"comments"', $single );

		$comments = (string) file_get_contents( $this->theme_dir . '/parts/comments.html' );
		$this->assertStringContainsString( 'wp:comments', $comments );
		$this->assertStringContainsString( 'agency-comments', $comments );
	}

	/**
	 * 404 template must use the translatable pattern slug.
	 */
	public function test_404_template_uses_i18n_pattern() {
		$template = (string) file_get_contents( $this->theme_dir . '/templates/404.html' );
		$this->assertStringContainsString( 'agency-starter/404-content', $template );

		$patterns = (string) file_get_contents( $this->theme_dir . '/inc/patterns.php' );
		$this->assertStringContainsString( 'agency-starter/404-content', $patterns );
		$this->assertStringContainsString( "esc_html__( 'Page not found', 'agency-starter' )", $patterns );
	}

	/**
	 * Archive templates must declare empty query states.
	 */
	public function test_archive_templates_include_query_no_results() {
		$news = (string) file_get_contents( $this->theme_dir . '/templates/page-archive-news.html' );
		$this->assertStringContainsString( 'query-no-results', $news );
		$this->assertStringContainsString( 'query-empty-news', $news );

		$jobs = (string) file_get_contents( $this->theme_dir . '/templates/archive-job.html' );
		$this->assertStringContainsString( 'query-empty-jobs', $jobs );
	}

	/**
	 * Language switcher must hide utility bar separator when unavailable.
	 */
	public function test_language_switcher_utility_bar_contract() {
		$source = (string) file_get_contents( $this->theme_dir . '/inc/language-switcher.php' );
		$this->assertStringContainsString( 'agency_starter_language_switcher_available', $source );
		$this->assertStringContainsString( 'agency_starter_filter_header_utility_language_switcher', $source );
	}

	/**
	 * Block styles must register per-block CSS handles.
	 */
	public function test_blocks_register_per_block_styles() {
		$source = (string) file_get_contents( $this->theme_dir . '/inc/blocks.php' );
		$this->assertStringContainsString( 'agency_starter_register_block_styles', $source );
		$this->assertStringContainsString( 'wp_enqueue_block_style', $source );
		$this->assertStringContainsString( 'css/blocks/usp-tabs.css', $source );

		$this->assertFileExists( $this->theme_dir . '/css/blocks/usp-tabs.css' );
	}

	/**
	 * a11y contrast bridge file should be removed (rules live in agency-design.css).
	 */
	public function test_a11y_contrast_bridge_removed() {
		$this->assertFileDoesNotExist( $this->theme_dir . '/css/a11y-contrast.css' );
		$enqueue = (string) file_get_contents( $this->theme_dir . '/inc/enqueue.php' );
		$this->assertStringNotContainsString( 'a11y-contrast', $enqueue );
	}
}
