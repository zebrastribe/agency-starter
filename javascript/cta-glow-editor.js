/**
 * CTA Glow Card block editor.
 */
const { registerBlockType } = wp.blocks;
const { useBlockProps, RichText, InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl, SelectControl, ToggleControl } = wp.components;
const { Fragment } = wp.element;

const SECTION_COLORS = [
	{ label: 'Background (white)', value: 'background' },
	{ label: 'Surface alt (light gray)', value: 'surface-alt' },
	{ label: 'Surface dark', value: 'surface-dark' },
	{ label: 'Primary subtle', value: 'primary-subtle' },
	{ label: 'Secondary subtle', value: 'secondary-subtle' },
];

const ACCENT_COLORS = [
	{ label: 'Accent (teal)', value: 'accent' },
	{ label: 'Primary (purple)', value: 'primary' },
	{ label: 'Secondary (pink)', value: 'secondary' },
];

const sectionColorClass = (slug) => {
	const map = {
		background: '',
		'surface-alt': 'agency-section--alt',
		'surface-dark': 'agency-section--dark',
		'primary-subtle': 'agency-cta-glow--primary-subtle',
		'secondary-subtle': 'agency-cta-glow--secondary-subtle',
	};
	return map[slug] || '';
};

const glowPositionClass = (slug) => {
	const map = {
		'bottom-left': 'agency-cta-glow--glow-bl',
		'bottom-right': 'agency-cta-glow--glow-br',
		'top-left': 'agency-cta-glow--glow-tl',
		'top-right': 'agency-cta-glow--glow-tr',
	};
	return map[slug] || 'agency-cta-glow--glow-bl';
};

const accentVar = (slug) => {
	const map = {
		accent: 'var(--wp--preset--color--accent, #1fcdbc)',
		primary: 'var(--wp--preset--color--primary, #570df8)',
		secondary: 'var(--wp--preset--color--secondary, #f000b8)',
	};
	return map[slug] || map.accent;
};

registerBlockType('agency-starter/cta-glow', {
	edit({ attributes, setAttributes }) {
		const {
			heading,
			subheading,
			ctaLabel,
			ctaUrl,
			sectionColor,
			accentColor,
			glowPosition,
			showGlow,
			enableAnimation,
		} = attributes;

		const isDark = sectionColor === 'surface-dark';
		const glowOn = showGlow !== false;
		const animate = enableAnimation !== false && glowOn;

		const blockClassName = [
			'agency-cta-glow-editor',
			'alignfull',
			'agency-section',
			'agency-cta-glow',
			sectionColorClass(sectionColor || 'surface-alt'),
			glowOn ? glowPositionClass(glowPosition || 'bottom-left') : '',
			animate ? 'agency-cta-glow--animate' : '',
		]
			.filter(Boolean)
			.join(' ');

		const blockProps = useBlockProps({ className: blockClassName });
		const ctaClass = isDark ? 'agency-btn--on-dark' : 'agency-btn--employer';

		return wp.element.createElement(
			Fragment,
			null,
			wp.element.createElement(
				InspectorControls,
				null,
				wp.element.createElement(
					PanelBody,
					{ title: 'Appearance', initialOpen: true },
					wp.element.createElement(SelectControl, {
						label: 'Section background',
						value: sectionColor || 'surface-alt',
						options: SECTION_COLORS,
						onChange: (v) => setAttributes({ sectionColor: v }),
					}),
					wp.element.createElement(ToggleControl, {
						label: 'Show gradient glow',
						checked: glowOn,
						onChange: (v) => setAttributes({ showGlow: v }),
					}),
					glowOn
						? wp.element.createElement(SelectControl, {
								label: 'Glow accent color',
								value: accentColor || 'accent',
								options: ACCENT_COLORS,
								onChange: (v) => setAttributes({ accentColor: v }),
							})
						: null,
					glowOn
						? wp.element.createElement(SelectControl, {
								label: 'Glow position',
								value: glowPosition || 'bottom-left',
								options: [
									{ label: 'Bottom left', value: 'bottom-left' },
									{ label: 'Bottom right', value: 'bottom-right' },
									{ label: 'Top left', value: 'top-left' },
									{ label: 'Top right', value: 'top-right' },
								],
								onChange: (v) => setAttributes({ glowPosition: v }),
							})
						: null,
					glowOn
						? wp.element.createElement(ToggleControl, {
								label: 'Subtle glow animation',
								help: 'Slow pulse on the gradient. Respects reduced-motion preferences.',
								checked: animate,
								onChange: (v) => setAttributes({ enableAnimation: v }),
							})
						: null,
				),
				wp.element.createElement(
					PanelBody,
					{ title: 'Call to action', initialOpen: false },
					wp.element.createElement(TextControl, {
						label: 'Button label',
						value: ctaLabel,
						onChange: (v) => setAttributes({ ctaLabel: v }),
					}),
					wp.element.createElement(TextControl, {
						label: 'Button URL',
						value: ctaUrl,
						onChange: (v) => setAttributes({ ctaUrl: v }),
					}),
				),
			),
			wp.element.createElement(
				'div',
				blockProps,
				wp.element.createElement(
					'div',
					{ className: 'agency-container' },
					wp.element.createElement(
						'div',
						{
							className: 'agency-cta-glow__card',
							style: { '--agency-cta-glow-accent': accentVar(accentColor || 'accent') },
						},
						glowOn
							? wp.element.createElement('div', { className: 'agency-cta-glow__glow', 'aria-hidden': 'true' })
							: null,
						wp.element.createElement(
							'div',
							{ className: 'agency-cta-glow__inner' },
							wp.element.createElement(RichText, {
								tagName: 'h2',
								className: 'agency-cta-glow__heading',
								value: heading,
								onChange: (v) => setAttributes({ heading: v }),
								placeholder: 'Conversion headline',
								allowedFormats: [],
							}),
							wp.element.createElement(RichText, {
								tagName: 'p',
								className: 'agency-cta-glow__subheading',
								value: subheading,
								onChange: (v) => setAttributes({ subheading: v }),
								placeholder: 'Supporting line',
								allowedFormats: [],
							}),
							ctaLabel
								? wp.element.createElement(
										'div',
										{ className: 'agency-cta-glow__actions' },
										wp.element.createElement(
											'span',
											{ className: `agency-btn ${ctaClass} agency-cta-glow__cta` },
											wp.element.createElement('span', { className: 'agency-cta-glow__cta-label' }, ctaLabel),
											wp.element.createElement('span', { className: 'agency-cta-glow__cta-icon', 'aria-hidden': 'true' }, '→'),
										),
									)
								: null,
						),
					),
				),
			),
		);
	},
	save() {
		return null;
	},
});
