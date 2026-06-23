<?php
/**
 * Newsletter signup shortcode for patterns.
 *
 * @package Agency_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Demo newsletter signup form — replace with Mailchimp/CF7 in production.
 *
 * Uses the same field markup as Contact Form 7 demo forms (agency-cf7-*).
 *
 * @return string
 */
function agency_starter_newsletter_shortcode() {
	$field_id = wp_unique_id( 'agency-newsletter-email-' );

	ob_start();
	?>
	<form
		class="agency-form agency-newsletter__form"
		action="#"
		method="post"
		novalidate
		data-agency-newsletter-demo
		aria-label="<?php echo esc_attr( agency_starter_t( 'Newsletter signup' ) ); ?>"
	>
		<p class="agency-cf7-field">
			<label class="agency-form__label--sr-only" for="<?php echo esc_attr( $field_id ); ?>">
				<?php echo esc_html( agency_starter_t( 'Email address' ) ); ?>
			</label>
			<input
				type="email"
				class="agency-cf7-input"
				id="<?php echo esc_attr( $field_id ); ?>"
				name="email"
				autocomplete="email"
				placeholder="<?php echo esc_attr( agency_starter_t( 'Email address' ) ); ?>"
				required
			/>
		</p>
		<p class="agency-cf7-actions">
			<button type="submit" class="agency-form__submit">
				<?php echo esc_html( agency_starter_t( 'Subscribe' ) ); ?>
			</button>
		</p>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode( 'agency_starter_newsletter', 'agency_starter_newsletter_shortcode' );

/**
 * Prevent demo newsletter form from navigating away.
 */
function agency_starter_newsletter_demo_script() {
	if ( is_admin() ) {
		return;
	}

	$script = <<<'JS'
document.querySelectorAll('[data-agency-newsletter-demo]').forEach((form) => {
	form.addEventListener('submit', (event) => {
		event.preventDefault();
	});
});
JS;

	wp_register_script( 'agency-starter-newsletter-demo', '', array(), AGENCY_STARTER_VERSION, true );
	wp_enqueue_script( 'agency-starter-newsletter-demo' );
	wp_add_inline_script( 'agency-starter-newsletter-demo', $script );
}

add_filter( 'do_shortcode_tag', 'agency_starter_newsletter_enqueue_demo_script_on_tag', 10, 2 );

/**
 * @param string $output Shortcode output.
 * @param string $tag    Shortcode tag.
 * @return string
 */
function agency_starter_newsletter_enqueue_demo_script_on_tag( $output, $tag ) {
	if ( 'agency_starter_newsletter' !== $tag ) {
		return $output;
	}

	agency_starter_newsletter_demo_script();
	return $output;
}
