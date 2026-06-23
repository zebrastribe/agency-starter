/**
 * Content Block editor.
 */
const { registerBlockType } = wp.blocks;
const { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } = wp.blockEditor;
const { PanelBody, TextControl, Button, SelectControl } = wp.components;
const { Fragment } = wp.element;

const SECTION_COLORS = [
	{ label: 'Background (white)', value: 'background' },
	{ label: 'Surface alt (light gray)', value: 'surface-alt' },
	{ label: 'Surface dark', value: 'surface-dark' },
	{ label: 'Primary subtle', value: 'primary-subtle' },
	{ label: 'Secondary subtle', value: 'secondary-subtle' },
];

const sectionColorClass = (slug) => {
	const map = {
		background: '',
		'surface-alt': 'agency-section--alt',
		'surface-dark': 'agency-section--dark',
		'primary-subtle': 'agency-content-block--primary-subtle',
		'secondary-subtle': 'agency-content-block--secondary-subtle',
	};
	return map[slug] || '';
};

registerBlockType('agency-starter/content-block', {
	edit({ attributes, setAttributes }) {
		const {
			eyebrow,
			heading,
			body,
			ctaLabel,
			ctaUrl,
			imageUrl,
			imageAlt,
			mediaPosition,
			imageDisplay,
			placement,
			sectionColor,
		} = attributes;

		const useSectionBg = imageDisplay === 'section-background';
		const mediaOnLeft = mediaPosition === 'left';
		const isBreaker = placement === 'breaker';
		const isDark = sectionColor === 'surface-dark' || useSectionBg;
		const colorClass = sectionColorClass(sectionColor || 'background');

		const blockClassName = [
			'agency-content-block-editor',
			'alignfull',
			'agency-section',
			'agency-content-block',
			colorClass,
			isBreaker ? 'agency-content-block--breaker' : '',
			mediaOnLeft ? 'agency-content-block--media-left' : 'agency-content-block--media-right',
			useSectionBg ? 'agency-content-block--section-bg' : '',
		]
			.filter(Boolean)
			.join(' ');

		const blockProps = useBlockProps({
			className: blockClassName,
			style:
				useSectionBg && imageUrl
					? { backgroundImage: `url(${imageUrl})` }
					: undefined,
		});

		const ctaClass = isDark ? 'agency-btn--on-dark' : 'agency-btn--employer';

		return wp.element.createElement(
			Fragment,
			null,
			wp.element.createElement(
				InspectorControls,
				null,
				wp.element.createElement(
					PanelBody,
					{ title: 'Placement', initialOpen: true },
					wp.element.createElement(SelectControl, {
						label: 'Section role',
						help: 'Breaker works below the navigation or as a bold band mid-page.',
						value: placement || 'default',
						options: [
							{ label: 'In-page section', value: 'default' },
							{ label: 'Breaker band', value: 'breaker' },
						],
						onChange: (v) => setAttributes({ placement: v }),
					}),
					wp.element.createElement(SelectControl, {
						label: 'Background color',
						value: sectionColor || 'background',
						options: SECTION_COLORS,
						onChange: (v) => setAttributes({ sectionColor: v }),
					}),
				),
				wp.element.createElement(
					PanelBody,
					{ title: 'Layout', initialOpen: true },
					wp.element.createElement(SelectControl, {
						label: 'Media position',
						help: 'Choose whether the image column sits on the left or right.',
						value: mediaPosition || 'right',
						options: [
							{ label: 'Text left, image right', value: 'right' },
							{ label: 'Image left, text right', value: 'left' },
						],
						onChange: (v) => setAttributes({ mediaPosition: v }),
					}),
					wp.element.createElement(SelectControl, {
						label: 'Image display',
						help: 'Section background fills the whole block; inline keeps the image in its column.',
						value: imageDisplay || 'inline',
						options: [
							{ label: 'Inline in column', value: 'inline' },
							{ label: 'Section background', value: 'section-background' },
						],
						onChange: (v) => setAttributes({ imageDisplay: v }),
					}),
				),
				wp.element.createElement(
					PanelBody,
					{ title: 'Image', initialOpen: true },
					wp.element.createElement(
						MediaUploadCheck,
						null,
						wp.element.createElement(MediaUpload, {
							onSelect: (media) =>
								setAttributes({
									imageUrl: media.url,
									imageId: media.id,
									imageAlt: media.alt || '',
								}),
							allowedTypes: ['image'],
							render: ({ open }) =>
								wp.element.createElement(
									'div',
									{ style: { display: 'flex', gap: '0.5rem', alignItems: 'center', marginBottom: '0.75rem' } },
									imageUrl
										? wp.element.createElement('img', {
												src: imageUrl,
												alt: '',
												style: { width: '96px', height: '64px', objectFit: 'cover', borderRadius: '8px' },
											})
										: null,
									wp.element.createElement(
										Button,
										{ variant: 'secondary', onClick: open },
										imageUrl ? 'Replace image' : 'Add image',
									),
									imageUrl
										? wp.element.createElement(
												Button,
												{ isDestructive: true, onClick: () => setAttributes({ imageUrl: '', imageId: undefined, imageAlt: '' }) },
												'Remove',
											)
										: null,
								),
						}),
					),
					wp.element.createElement(TextControl, {
						label: 'Image alt text',
						value: imageAlt || '',
						onChange: (v) => setAttributes({ imageAlt: v }),
					}),
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
				useSectionBg
					? wp.element.createElement('div', { className: 'agency-content-block__scrim', 'aria-hidden': 'true' })
					: null,
				wp.element.createElement(
					'div',
					{ className: 'agency-container' },
					wp.element.createElement(
						'div',
						{ className: 'agency-content-block__split' },
						wp.element.createElement(
							'div',
							{ className: 'agency-content-block__content' },
							wp.element.createElement(RichText, {
								tagName: 'p',
								className: 'agency-content-block__eyebrow agency-eyebrow',
								value: eyebrow,
								onChange: (v) => setAttributes({ eyebrow: v }),
								placeholder: 'Eyebrow label',
							}),
							wp.element.createElement(RichText, {
								tagName: 'h2',
								className: 'agency-content-block__title agency-section__title',
								value: heading,
								onChange: (v) => setAttributes({ heading: v }),
								placeholder: 'Section heading',
								allowedFormats: [],
							}),
							wp.element.createElement(RichText, {
								tagName: 'p',
								className: 'agency-content-block__body agency-lead',
								value: body,
								onChange: (v) => setAttributes({ body: v }),
								placeholder: 'Supporting copy',
							}),
							ctaLabel
								? wp.element.createElement(
										'div',
										{ className: 'agency-content-block__actions' },
										wp.element.createElement('span', { className: `agency-btn ${ctaClass} agency-content-block__cta` }, ctaLabel),
									)
								: null,
						),
						!useSectionBg
							? wp.element.createElement(
									'div',
									{ className: 'agency-content-block__media' },
									imageUrl
										? wp.element.createElement(
												'figure',
												{ className: 'agency-content-block__figure' },
												wp.element.createElement('img', { src: imageUrl, alt: imageAlt || '' }),
											)
										: wp.element.createElement(
												'div',
												{
													className: 'agency-content-block__figure agency-content-block__figure--empty',
													style: { minHeight: '280px' },
												},
												'Add an image in the sidebar',
											),
								)
							: null,
					),
				),
			),
		);
	},
	save() {
		return null;
	},
});
