/**
 * Media Slider block editor.
 */
const { registerBlockType } = wp.blocks;
const { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } = wp.blockEditor;
const { PanelBody, TextControl, TextareaControl, Button } = wp.components;
const { Fragment } = wp.element;

const PLACEHOLDER_WIDE = window.agencyStarterMediaSlider?.placeholderWide || '';

const DEFAULT_HEADER = {
	eyebrow: 'Lorem ipsum',
	heading: 'Dolor sit amet consectetur',
	intro: 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.',
};

const DEFAULT_SLIDES = [
	{
		imageUrl: '',
		videoUrl: '',
		title: 'Lorem Company',
		body: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.',
		ctaLabel: 'Learn more',
		ctaUrl: '#',
	},
	{
		imageUrl: '',
		videoUrl: '',
		title: 'Lorem Partner',
		body: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.',
		ctaLabel: 'Learn more',
		ctaUrl: '#',
	},
	{
		imageUrl: '',
		videoUrl: '',
		title: 'Lorem Client',
		body: 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
		ctaLabel: 'Learn more',
		ctaUrl: '#',
	},
];

const normalizeSlides = (slides) => (slides?.length ? slides : DEFAULT_SLIDES);

registerBlockType('agency-starter/media-slider', {
	edit({ attributes, setAttributes }) {
		const { eyebrow, heading, intro, slides } = attributes;
		const slideItems = normalizeSlides(slides);
		const previewSlide = slideItems[0] || DEFAULT_SLIDES[0];
		const previewImageUrl = previewSlide.imageUrl || PLACEHOLDER_WIDE;

		const blockProps = useBlockProps({
			className: 'agency-media-slider-editor alignfull agency-section agency-media-slider',
		});

		const updateSlide = (index, field, value) => {
			setAttributes({
				slides: slideItems.map((slide, i) => (i === index ? { ...slide, [field]: value } : slide)),
			});
		};

		const addSlide = () => {
			if (slideItems.length >= 8) return;
			setAttributes({
				slides: [
					...slideItems,
					{ imageUrl: '', videoUrl: '', title: '', body: '', ctaLabel: 'Learn more', ctaUrl: '#' },
				],
			});
		};

		const removeSlide = (index) => {
			if (slideItems.length <= 1) return;
			setAttributes({ slides: slideItems.filter((_, i) => i !== index) });
		};

		return wp.element.createElement(
			Fragment,
			null,
			wp.element.createElement(
				InspectorControls,
				null,
				wp.element.createElement(
					PanelBody,
					{ title: 'Slides', initialOpen: true },
					slideItems.map((slide, index) =>
						wp.element.createElement(
							'div',
							{ key: index, style: { marginBottom: '1rem', paddingBottom: '1rem', borderBottom: '1px solid #e5e7eb' } },
							wp.element.createElement('p', { style: { margin: '0 0 0.5rem', fontWeight: 600 } }, `Slide ${index + 1}`),
							wp.element.createElement(
								MediaUploadCheck,
								null,
								wp.element.createElement(MediaUpload, {
									onSelect: (media) => {
										setAttributes({
											slides: slideItems.map((item, i) =>
												i === index ? { ...item, imageUrl: media.url, imageId: media.id } : item,
											),
										});
									},
									allowedTypes: ['image'],
									value: slide.imageId,
									render: ({ open }) =>
										wp.element.createElement(
											Button,
											{ variant: 'secondary', onClick: open, style: { marginBottom: '0.5rem' } },
											slide.imageUrl ? 'Replace image' : 'Select image',
										),
								}),
							),
							wp.element.createElement(TextControl, {
								label: 'Video URL (optional)',
								help: 'Shows a play button overlay when set.',
								value: slide.videoUrl || '',
								onChange: (v) => updateSlide(index, 'videoUrl', v),
							}),
							wp.element.createElement(TextControl, {
								label: 'Title',
								value: slide.title || '',
								onChange: (v) => updateSlide(index, 'title', v),
							}),
							wp.element.createElement(TextareaControl, {
								label: 'Body',
								value: slide.body || '',
								onChange: (v) => updateSlide(index, 'body', v),
							}),
							wp.element.createElement(TextControl, {
								label: 'CTA label',
								value: slide.ctaLabel || '',
								onChange: (v) => updateSlide(index, 'ctaLabel', v),
							}),
							wp.element.createElement(TextControl, {
								label: 'CTA URL',
								value: slide.ctaUrl || '',
								onChange: (v) => updateSlide(index, 'ctaUrl', v),
							}),
							slideItems.length > 1
								? wp.element.createElement(
										Button,
										{ isDestructive: true, variant: 'link', onClick: () => removeSlide(index) },
										'Remove slide',
									)
								: null,
						),
					),
					slideItems.length < 8
						? wp.element.createElement(Button, { variant: 'primary', onClick: addSlide }, 'Add slide')
						: null,
				),
			),
			wp.element.createElement(
				'section',
				blockProps,
				wp.element.createElement(
					'div',
					{ className: 'agency-container agency-media-slider__header-wrap' },
					wp.element.createElement(
						'header',
						{ className: 'agency-media-slider__header' },
						wp.element.createElement(
							'div',
							{ className: 'agency-media-slider__heading-group' },
							wp.element.createElement(RichText, {
								tagName: 'p',
								className: 'agency-eyebrow agency-media-slider__eyebrow',
								value: eyebrow,
								onChange: (v) => setAttributes({ eyebrow: v }),
								placeholder: DEFAULT_HEADER.eyebrow,
							}),
							wp.element.createElement(RichText, {
								tagName: 'h2',
								className: 'agency-media-slider__title',
								value: heading,
								onChange: (v) => setAttributes({ heading: v }),
								placeholder: DEFAULT_HEADER.heading,
							}),
						),
						wp.element.createElement(RichText, {
							tagName: 'p',
							className: 'agency-lead agency-media-slider__intro',
							value: intro,
							onChange: (v) => setAttributes({ intro: v }),
							placeholder: DEFAULT_HEADER.intro,
						}),
					),
				),
				wp.element.createElement(
					'div',
					{ className: 'agency-media-slider__stage' },
					wp.element.createElement(
						'div',
						{ className: 'agency-media-slider__viewport' },
						wp.element.createElement(
							'article',
							{ className: 'agency-media-slider__slide is-active' },
							wp.element.createElement(
								'div',
								{ className: 'agency-media-slider__card' },
									wp.element.createElement(
										'div',
										{ className: 'agency-media-slider__media' },
										previewImageUrl
											? wp.element.createElement('img', {
													src: previewImageUrl,
													alt: '',
													className: 'agency-media-slider__image',
													loading: 'lazy',
													decoding: 'async',
													sizes: '(min-width: 64em) min(34rem, 42vw), 84vw',
												})
											: wp.element.createElement(
													'div',
													{ className: 'agency-media-slider__media-placeholder' },
													'Placeholder image',
												),
									),
								wp.element.createElement(
									'div',
									{ className: 'agency-media-slider__body' },
									wp.element.createElement('h3', { className: 'agency-media-slider__slide-title' }, previewSlide.title),
									wp.element.createElement('p', { className: 'agency-media-slider__slide-text' }, previewSlide.body),
									previewSlide.ctaLabel
										? wp.element.createElement(
												'span',
												{ className: 'agency-media-slider__cta agency-btn agency-btn--ghost' },
												previewSlide.ctaLabel,
											)
										: null,
								),
							),
						),
					),
					wp.element.createElement(
						'p',
						{ style: { textAlign: 'center', fontSize: '0.75rem', color: '#6b7280', marginTop: '1rem' } },
						`${slideItems.length} slide(s) — preview shows slide 1. Use sidebar to edit all slides.`,
					),
				),
			),
		);
	},
	save() {
		return null;
	},
});
