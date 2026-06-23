/**
 * Interactive Hero block editor.
 */
const { registerBlockType } = wp.blocks;
const { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } = wp.blockEditor;
const { PanelBody, TextControl, TextareaControl, Button, ToggleControl, SelectControl } = wp.components;
const { Fragment } = wp.element;

const PANEL_COLORS = [
	{ label: 'Background (white)', value: 'background' },
	{ label: 'Surface alt', value: 'surface-alt' },
	{ label: 'Surface dark', value: 'surface-dark' },
	{ label: 'Primary', value: 'primary' },
	{ label: 'Primary subtle', value: 'primary-subtle' },
	{ label: 'Secondary', value: 'secondary' },
	{ label: 'Secondary subtle', value: 'secondary-subtle' },
	{ label: 'Accent', value: 'accent' },
];

const ACCENT_COLORS = [
	{ label: 'Accent', value: 'accent' },
	{ label: 'Primary', value: 'primary' },
	{ label: 'Secondary', value: 'secondary' },
	{ label: 'Foreground', value: 'foreground' },
	{ label: 'Background (white)', value: 'background' },
];

const LIGHT_PANELS = new Set(['background', 'surface', 'surface-alt', 'primary-subtle', 'secondary-subtle']);

const usesInverseText = (slug) => !LIGHT_PANELS.has(slug || '');

const panelColorStyle = (contentColor, mediaColor, accentColor) => ({
	'--agency-hero-interactive-content-bg': `var(--wp--preset--color--${contentColor || 'primary'})`,
	'--agency-hero-interactive-media-bg': `var(--wp--preset--color--${mediaColor || 'surface-dark'})`,
	'--agency-hero-interactive-accent': `var(--wp--preset--color--${accentColor || 'secondary'})`,
});

const DEFAULT_SLIDES = [
	{
		imageUrl: '',
		label: 'Lorem Company',
		quote: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
		attribution: '— Lorem Name, Lorem Title',
	},
	{
		imageUrl: '',
		label: 'Lorem Partner',
		quote: 'Lorem ipsum sed do eiusmod tempor incididunt ut labore.',
		attribution: '— Lorem Person, Lorem Role',
	},
	{
		imageUrl: '',
		label: 'Lorem Client',
		quote: 'Lorem ipsum ut enim ad minim veniam quis nostrud.',
		attribution: '— Lorem Leader, Lorem Department',
	},
];

const normalizeSlides = (slides) => (slides?.length ? slides : DEFAULT_SLIDES);

registerBlockType('agency-starter/hero-interactive', {
	edit({ attributes, setAttributes }) {
		const {
			eyebrow,
			heading,
			headingAccent,
			lead,
			primaryCtaLabel,
			primaryCtaUrl,
			secondaryCtaLabel,
			secondaryCtaUrl,
			fullViewport,
			mediaImageDisplay,
			contentColor,
			mediaColor,
			headingAccentColor,
			slides,
		} = attributes;
		const slideItems = normalizeSlides(slides);
		const activeSlide = slideItems[0] || DEFAULT_SLIDES[0];
		const resolvedContentColor = contentColor || 'primary';
		const resolvedMediaColor = mediaColor || 'surface-dark';
		const resolvedAccentColor = headingAccentColor || 'secondary';
		const contentInverse = usesInverseText(resolvedContentColor);
		const mediaInverse = usesInverseText(resolvedMediaColor);
		const primaryCtaClass = contentInverse ? 'agency-btn--on-dark' : 'agency-btn--employer';
		const blockProps = useBlockProps({
			className: 'agency-hero-interactive-editor alignfull agency-section agency-hero agency-hero-interactive' + (mediaImageDisplay === 'cover' ? ' agency-hero-interactive--media-cover' : ''),
			style: panelColorStyle(resolvedContentColor, resolvedMediaColor, resolvedAccentColor),
		});

		const updateSlide = (index, field, value) => {
			setAttributes({
				slides: slideItems.map((slide, i) => (i === index ? { ...slide, [field]: value } : slide)),
			});
		};

		const addSlide = () => {
			if (slideItems.length >= 6) return;
			setAttributes({
				slides: [...slideItems, { imageUrl: '', label: '', quote: '', attribution: '' }],
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
					{ title: 'Appearance', initialOpen: true },
					wp.element.createElement(SelectControl, {
						label: 'Left panel background',
						value: resolvedContentColor,
						options: PANEL_COLORS,
						onChange: (v) => setAttributes({ contentColor: v }),
					}),
					wp.element.createElement(SelectControl, {
						label: 'Right panel background',
						value: resolvedMediaColor,
						options: PANEL_COLORS,
						onChange: (v) => setAttributes({ mediaColor: v }),
					}),
					wp.element.createElement(SelectControl, {
						label: 'Heading accent color',
						value: resolvedAccentColor,
						options: ACCENT_COLORS,
						onChange: (v) => setAttributes({ headingAccentColor: v }),
					}),
				),
				wp.element.createElement(
					PanelBody,
					{ title: 'Layout', initialOpen: true },
					wp.element.createElement(ToggleControl, {
						label: 'Fill viewport height (100vh)',
						help: 'Turn off when placing this block mid-page.',
						checked: fullViewport !== false,
						onChange: (v) => setAttributes({ fullViewport: v }),
					}),
					wp.element.createElement(SelectControl, {
						label: 'Right panel image display',
						help: 'Cover fills the right card as a background image.',
						value: mediaImageDisplay || 'inline',
						options: [
							{ label: 'Inline image', value: 'inline' },
							{ label: 'Cover background', value: 'cover' },
						],
						onChange: (v) => setAttributes({ mediaImageDisplay: v }),
					}),
				),
				wp.element.createElement(
					PanelBody,
					{ title: 'Calls to action', initialOpen: false },
					wp.element.createElement(TextControl, { label: 'Primary CTA label', value: primaryCtaLabel, onChange: (v) => setAttributes({ primaryCtaLabel: v }) }),
					wp.element.createElement(TextControl, { label: 'Primary CTA URL', value: primaryCtaUrl, onChange: (v) => setAttributes({ primaryCtaUrl: v }) }),
					wp.element.createElement(TextControl, { label: 'Secondary CTA label', value: secondaryCtaLabel, onChange: (v) => setAttributes({ secondaryCtaLabel: v }) }),
					wp.element.createElement(TextControl, { label: 'Secondary CTA URL', value: secondaryCtaUrl, onChange: (v) => setAttributes({ secondaryCtaUrl: v }) }),
				),
				wp.element.createElement(
					PanelBody,
					{ title: 'Slider slides', initialOpen: true },
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
											slides: slideItems.map((slide, i) =>
												i === index ? { ...slide, imageUrl: media.url, imageId: media.id } : slide,
											),
										});
									},
									allowedTypes: ['image'],
									render: ({ open }) =>
										wp.element.createElement(
											'div',
											{ style: { display: 'flex', gap: '0.5rem', alignItems: 'center', marginBottom: '0.5rem' } },
											slide.imageUrl
												? wp.element.createElement('img', { src: slide.imageUrl, alt: '', style: { width: '64px', height: '40px', objectFit: 'cover', borderRadius: '4px' } })
												: null,
											wp.element.createElement(Button, { variant: 'secondary', onClick: open }, slide.imageUrl ? 'Replace image' : 'Add image'),
											slide.imageUrl
												? wp.element.createElement(Button, { isDestructive: true, onClick: () => updateSlide(index, 'imageUrl', '') }, 'Remove')
												: null,
										),
								}),
							),
							wp.element.createElement(TextControl, { label: 'Label tag (optional)', value: slide.label || '', onChange: (v) => updateSlide(index, 'label', v) }),
							wp.element.createElement(TextareaControl, { label: 'Quote', value: slide.quote || '', onChange: (v) => updateSlide(index, 'quote', v) }),
							wp.element.createElement(TextControl, { label: 'Attribution', value: slide.attribution || '', onChange: (v) => updateSlide(index, 'attribution', v) }),
							wp.element.createElement(Button, { isDestructive: true, onClick: () => removeSlide(index), style: { marginTop: '0.5rem' } }, 'Remove slide'),
						),
					),
					wp.element.createElement(Button, { variant: 'secondary', onClick: addSlide }, 'Add slide'),
				),
			),
			wp.element.createElement(
				'div',
				blockProps,
				wp.element.createElement(
					'div',
					{ className: 'agency-hero-interactive__split' },
					wp.element.createElement(
						'div',
						{
							className:
								'agency-hero-interactive__content agency-hero-interactive__content--' +
								(contentInverse ? 'on-dark' : 'on-light'),
						},
						wp.element.createElement(
							'div',
							{ className: 'agency-hero-interactive__content-inner' },
							wp.element.createElement(RichText, { tagName: 'p', className: 'agency-hero-interactive__eyebrow', value: eyebrow, onChange: (v) => setAttributes({ eyebrow: v }), placeholder: 'Optional eyebrow' }),
							wp.element.createElement(
								'h1',
								{ className: 'agency-hero__title agency-hero-interactive__title' },
								wp.element.createElement(RichText, { tagName: 'span', value: heading, onChange: (v) => setAttributes({ heading: v }), placeholder: 'Hero headline', withoutInteractiveFormatting: true, allowedFormats: [] }),
								' ',
								wp.element.createElement(RichText, { tagName: 'span', className: 'agency-hero-interactive__accent', value: headingAccent, onChange: (v) => setAttributes({ headingAccent: v }), placeholder: 'Accent phrase', withoutInteractiveFormatting: true, allowedFormats: [] }),
							),
							wp.element.createElement(RichText, { tagName: 'p', className: 'agency-hero__lead agency-hero-interactive__lead', value: lead, onChange: (v) => setAttributes({ lead: v }), placeholder: 'Supporting line' }),
							primaryCtaLabel
								? wp.element.createElement(
										'p',
										{ style: { marginTop: '1rem' } },
										wp.element.createElement('span', { className: `agency-btn ${primaryCtaClass} agency-hero-interactive__cta` }, primaryCtaLabel),
									)
								: null,
						),
					),
					wp.element.createElement(
						'div',
						{
							className:
								'agency-hero-interactive__media agency-hero-interactive__media--' +
								(mediaInverse ? 'on-dark' : 'on-light'),
						},
						mediaImageDisplay === 'cover'
							? wp.element.createElement(
								'div',
								{
									className: 'agency-hero-interactive__slide agency-hero-interactive__slide--cover is-active',
									style: activeSlide.imageUrl
										? { backgroundImage: `url(${activeSlide.imageUrl})`, minHeight: '280px' }
										: { minHeight: '280px' },
								},
								wp.element.createElement('div', { className: 'agency-hero-interactive__slide-scrim', 'aria-hidden': 'true' }),
								wp.element.createElement(
									'div',
									{ className: 'agency-hero-interactive__slide-content' },
									wp.element.createElement(
										'div',
										{ className: 'agency-hero-interactive__caption' },
										activeSlide.label
											? wp.element.createElement('p', { className: 'agency-hero-interactive__slide-label' }, activeSlide.label)
											: null,
										activeSlide.quote
											? wp.element.createElement('p', { className: 'agency-hero-interactive__quote' }, activeSlide.quote)
											: null,
										activeSlide.attribution
											? wp.element.createElement('p', { className: 'agency-hero-interactive__attribution' }, activeSlide.attribution)
											: null,
									),
								),
							)
							: wp.element.createElement(
								Fragment,
								null,
								wp.element.createElement('p', { style: { margin: '0 0 0.5rem', fontSize: '0.75rem', opacity: 0.7 } }, `${slideItems.length} slide${slideItems.length === 1 ? '' : 's'}`),
								activeSlide.label
									? wp.element.createElement('p', { className: 'agency-hero-interactive__slide-label', style: { margin: '0 0 0.5rem' } }, activeSlide.label)
									: null,
								activeSlide.quote
									? wp.element.createElement('p', { className: 'agency-hero-interactive__quote' }, activeSlide.quote)
									: null,
								activeSlide.attribution
									? wp.element.createElement('p', { className: 'agency-hero-interactive__attribution' }, activeSlide.attribution)
									: null,
								wp.element.createElement('p', { style: { margin: '0.75rem 0 0', fontSize: '0.8rem', opacity: 0.65 } }, 'Edit right-panel text per slide in the sidebar.'),
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
