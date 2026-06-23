/**
 * Logo Cloud block editor.
 */
const { registerBlockType } = wp.blocks;
const { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } = wp.blockEditor;
const { PanelBody, TextControl, Button, RangeControl } = wp.components;
const { Fragment } = wp.element;

const DEFAULT_LOGOS = [
	{ url: '', alt: 'Nordvik' },
	{ url: '', alt: 'Helix' },
	{ url: '', alt: 'Meridian' },
	{ url: '', alt: 'Vertex' },
	{ url: '', alt: 'Axis' },
	{ url: '', alt: 'Pulse' },
	{ url: '', alt: 'Forge' },
	{ url: '', alt: 'Lumen' },
];

registerBlockType('agency-starter/logo-cloud', {
	edit({ attributes, setAttributes }) {
		const { label, logos, minLogosForAnimation } = attributes;
		const items = logos?.length ? logos : DEFAULT_LOGOS;
		const blockProps = useBlockProps({
			className: 'agency-logo-cloud-editor alignfull agency-section agency-section--compact agency-logo-cloud is-static',
		});

		const updateLogo = (index, field, value) => {
			setAttributes({
				logos: items.map((item, i) => (i === index ? { ...item, [field]: value } : item)),
			});
		};

		const addLogo = () => {
			if (items.length >= 16) return;
			setAttributes({ logos: [...items, { url: '', alt: 'Client logo' }] });
		};

		const removeLogo = (index) => {
			if (items.length <= 1) return;
			setAttributes({ logos: items.filter((_, i) => i !== index) });
		};

		return wp.element.createElement(
			Fragment,
			null,
			wp.element.createElement(
				InspectorControls,
				null,
				wp.element.createElement(
					PanelBody,
					{ title: 'Marquee', initialOpen: true },
					wp.element.createElement(RangeControl, {
						label: 'Min logos before animation',
						value: minLogosForAnimation ?? 6,
						onChange: (v) => setAttributes({ minLogosForAnimation: v }),
						min: 3,
						max: 12,
					}),
				),
				wp.element.createElement(
					PanelBody,
					{ title: 'Logos', initialOpen: true },
					items.map((item, index) =>
						wp.element.createElement(
							'div',
							{ key: index, style: { marginBottom: '1rem', paddingBottom: '1rem', borderBottom: '1px solid #e5e7eb' } },
							wp.element.createElement(TextControl, {
								label: `Logo ${index + 1} alt text`,
								value: item.alt,
								onChange: (v) => updateLogo(index, 'alt', v),
							}),
							wp.element.createElement(MediaUploadCheck, null,
								wp.element.createElement(MediaUpload, {
									onSelect: (media) => {
										setAttributes({
											logos: items.map((item, i) =>
												i === index ? { ...item, url: media.url, id: media.id } : item,
											),
										});
									},
									allowedTypes: ['image'],
									render: ({ open }) =>
										wp.element.createElement(Button, { variant: 'secondary', onClick: open }, item.url ? 'Replace image' : 'Upload logo'),
								}),
							),
							item.url
								? wp.element.createElement('img', { src: item.url, alt: item.alt, style: { maxHeight: '32px', marginTop: '0.5rem' } })
								: null,
							wp.element.createElement(Button, { isDestructive: true, onClick: () => removeLogo(index) }, 'Remove'),
						),
					),
					wp.element.createElement(Button, { variant: 'secondary', onClick: addLogo }, 'Add logo'),
				),
			),
			wp.element.createElement(
				'div',
				blockProps,
				wp.element.createElement(RichText, {
					tagName: 'p',
					className: 'agency-logo-cloud__label',
					value: label,
					onChange: (v) => setAttributes({ label: v }),
					placeholder: 'Global companies grow with us',
				}),
				wp.element.createElement(
					'ul',
					{ className: 'agency-logo-cloud__list', style: { display: 'flex', flexWrap: 'wrap', gap: '2rem', justifyContent: 'center', listStyle: 'none', padding: 0 } },
					items.map((item, index) =>
						wp.element.createElement(
							'li',
							{ key: index, className: 'agency-logo-cloud__item' },
							item.url
								? wp.element.createElement('img', { src: item.url, alt: item.alt, style: { maxHeight: '40px' } })
								: wp.element.createElement('span', { style: { opacity: 0.5 } }, item.alt || `Logo ${index + 1}`),
						),
					),
				),
				wp.element.createElement('p', { style: { textAlign: 'center', opacity: 0.6, fontSize: '0.875rem', marginTop: '1rem' } },
					`${items.length} logos — marquee on front end when ≥ ${minLogosForAnimation ?? 6} logos or overflow.`,
				),
			),
		);
	},
	save() {
		return null;
	},
});
