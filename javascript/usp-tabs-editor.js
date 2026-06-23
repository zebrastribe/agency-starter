/**
 * USP Tabs block editor (vertical accordion preview).
 */
const { registerBlockType } = wp.blocks;
const { useBlockProps, RichText, InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl, TextareaControl, SelectControl, ToggleControl, Button } = wp.components;
const { Fragment } = wp.element;

const ICON_OPTIONS = [
	{ label: 'Briefcase', value: 'briefcase' },
	{ label: 'Currency dollar', value: 'currency-dollar' },
	{ label: 'Banknotes', value: 'banknotes' },
	{ label: 'User group', value: 'user-group' },
	{ label: 'Users', value: 'users' },
	{ label: 'Globe', value: 'globe-alt' },
	{ label: 'Building', value: 'building-office' },
];

const DEFAULT_ITEMS = [
	{ title: 'Employer services', description: 'Need to hire anyone, anywhere? We handle contracts, compliance, and onboarding — in days, not months.', ctaLabel: 'Learn more', ctaUrl: '/employers/', imageUrl: '', icon: 'briefcase' },
	{ title: 'Global payroll', description: 'Accurate, compliant payroll in every market you operate. Run by in-house specialists, not a partner network.', ctaLabel: 'Learn more', ctaUrl: '/employers/', imageUrl: '', icon: 'currency-dollar' },
	{ title: 'Contractor management', description: 'Engage international contractors compliantly. Contracts, payments, and risk — handled end to end.', ctaLabel: 'Learn more', ctaUrl: '/candidates/', imageUrl: '', icon: 'user-group' },
	{ title: 'Candidate matching', description: 'Source, screen, and place talent faster with a dedicated consultant and a curated shortlist.', ctaLabel: 'Learn more', ctaUrl: '/candidates/', imageUrl: '', icon: 'users' },
];

const normalizeItems = (items) => (items?.length ? items : DEFAULT_ITEMS);

registerBlockType('agency-starter/usp-tabs', {
	edit({ attributes, setAttributes }) {
		const { eyebrow, heading, lead, showLead, mediaPosition, items } = attributes;
		const tabItems = normalizeItems(items);
		const mediaOnLeft = mediaPosition === 'left';

		const blockProps = useBlockProps({
			className: `agency-usp-tabs-editor alignfull agency-section agency-section--alt agency-usp-tabs--media-${mediaOnLeft ? 'left' : 'right'}`,
		});

		const updateItem = (index, field, value) => {
			setAttributes({
				items: tabItems.map((item, i) => (i === index ? { ...item, [field]: value } : item)),
			});
		};

		const addItem = () => {
			if (tabItems.length >= 6) return;
			setAttributes({
				items: [...tabItems, { title: 'New service', description: 'Description.', ctaLabel: 'Learn more', ctaUrl: '/contact/', imageUrl: '', icon: 'briefcase' }],
			});
		};

		const removeItem = (index) => {
			if (tabItems.length <= 1) return;
			setAttributes({ items: tabItems.filter((_, i) => i !== index) });
		};

		const intro = wp.element.createElement(
			'div',
			{ className: 'agency-usp-tabs__intro' },
			wp.element.createElement(RichText, {
				tagName: 'p',
				className: 'agency-eyebrow',
				value: eyebrow,
				onChange: (v) => setAttributes({ eyebrow: v }),
				placeholder: 'Eyebrow',
			}),
			wp.element.createElement(RichText, {
				tagName: 'h2',
				className: 'agency-section__title agency-usp-tabs__heading',
				value: heading,
				onChange: (v) => setAttributes({ heading: v }),
				placeholder: 'Section heading',
			}),
			showLead
				? wp.element.createElement(RichText, {
						tagName: 'p',
						className: 'agency-lead agency-usp-tabs__lead',
						value: lead,
						onChange: (v) => setAttributes({ lead: v }),
						placeholder: 'Optional intro text above the tabs',
					})
				: null,
		);

		const accordion = wp.element.createElement(
			'div',
			{ className: 'agency-usp-tabs__accordion' },
			tabItems.map((item, index) =>
				wp.element.createElement(
					'div',
					{
						key: index,
						className: `agency-usp-tabs__item${index === 0 ? ' is-active' : ''}`,
					},
					wp.element.createElement('button', { type: 'button', className: 'agency-usp-tabs__tab', disabled: true }, item.title || `Tab ${index + 1}`),
					index === 0
						? wp.element.createElement('div', { className: 'agency-usp-tabs__panel' }, wp.element.createElement('p', null, item.description))
						: null,
				),
			),
		);

		const column = wp.element.createElement('div', { className: 'agency-usp-tabs__column' }, intro, accordion);

		const preview = wp.element.createElement(
			'div',
			{ className: 'agency-usp-tabs__preview' },
			wp.element.createElement('div', { style: { padding: '2rem', opacity: 0.6 } }, 'Preview image updates on the front end'),
		);

		return wp.element.createElement(
			Fragment,
			null,
			wp.element.createElement(
				InspectorControls,
				null,
				wp.element.createElement(
					PanelBody,
					{ title: 'Layout', initialOpen: true },
					wp.element.createElement(SelectControl, {
						label: 'Preview image position',
						value: mediaPosition || 'right',
						options: [
							{ label: 'Right (tabs left)', value: 'right' },
							{ label: 'Left (tabs right)', value: 'left' },
						],
						onChange: (v) => setAttributes({ mediaPosition: v }),
					}),
					wp.element.createElement(ToggleControl, {
						label: 'Show intro text',
						checked: showLead !== false,
						onChange: (v) => setAttributes({ showLead: v }),
					}),
				),
				wp.element.createElement(
					PanelBody,
					{ title: 'Tabs', initialOpen: false },
					tabItems.map((item, index) =>
						wp.element.createElement(
							'div',
							{ key: index, style: { marginBottom: '1rem', paddingBottom: '1rem', borderBottom: '1px solid #e5e7eb' } },
							wp.element.createElement(SelectControl, {
								label: `Tab ${index + 1} icon`,
								value: item.icon || 'briefcase',
								options: ICON_OPTIONS,
								onChange: (v) => updateItem(index, 'icon', v),
							}),
							wp.element.createElement(TextControl, { label: 'Title', value: item.title, onChange: (v) => updateItem(index, 'title', v) }),
							wp.element.createElement(TextareaControl, { label: 'Description', value: item.description, onChange: (v) => updateItem(index, 'description', v) }),
							wp.element.createElement(TextControl, { label: 'CTA label', value: item.ctaLabel, onChange: (v) => updateItem(index, 'ctaLabel', v) }),
							wp.element.createElement(TextControl, { label: 'CTA URL', value: item.ctaUrl, onChange: (v) => updateItem(index, 'ctaUrl', v) }),
							wp.element.createElement(TextControl, { label: 'Preview image URL', value: item.imageUrl, onChange: (v) => updateItem(index, 'imageUrl', v), help: 'Empty = theme placeholder.' }),
							wp.element.createElement(Button, { isDestructive: true, onClick: () => removeItem(index) }, 'Remove tab'),
						),
					),
					wp.element.createElement(Button, { variant: 'secondary', onClick: addItem }, 'Add tab'),
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
						{ className: `agency-usp-tabs__root agency-usp-tabs--media-${mediaOnLeft ? 'left' : 'right'}` },
						mediaOnLeft ? [preview, column] : [column, preview],
					),
				),
			),
		);
	},
	save() {
		return null;
	},
});
