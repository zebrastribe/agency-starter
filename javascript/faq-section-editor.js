/**
 * FAQ Section block editor.
 */
const { registerBlockType } = wp.blocks;
const { useBlockProps, RichText, InspectorControls } = wp.blockEditor;
const { PanelBody, TextareaControl, Button } = wp.components;
const { Fragment } = wp.element;

const DEFAULT_ITEMS = [
	{
		question: 'Does this replace legal counsel?',
		answer: 'No. The platform reduces risk and manual work by embedding compliance into day-to-day operations, but it does not replace legal advice.',
	},
	{
		question: 'Can compliance really be centralized globally?',
		answer: 'Yes. Policies, worker data, and required actions are tracked in one platform so teams see the same source of truth across countries.',
	},
	{
		question: 'Where do compliance insights live?',
		answer: 'Insights appear in dashboards and worker profiles, with alerts when regulations or employment status changes require action.',
	},
	{
		question: 'How are complex or edge cases handled?',
		answer: 'Edge cases are flagged for review with context and documentation so legal and HR teams can resolve them without losing track.',
	},
	{
		question: 'How does the platform help prevent worker misclassification?',
		answer: 'Classification checks, contract templates, and audit trails help teams hire with the right worker type from the start.',
	},
];

const normalizeItems = (items) => (items?.length ? items : DEFAULT_ITEMS);

registerBlockType('agency-starter/faq-section', {
	edit({ attributes, setAttributes }) {
		const { heading, items } = attributes;
		const faqItems = normalizeItems(items);

		const blockProps = useBlockProps({
			className: 'agency-faq-section-editor alignfull agency-section agency-faq-section',
		});

		const updateItem = (index, field, value) => {
			setAttributes({
				items: faqItems.map((item, i) => (i === index ? { ...item, [field]: value } : item)),
			});
		};

		const addItem = () => {
			if (faqItems.length >= 12) return;
			setAttributes({
				items: [...faqItems, { question: '', answer: '' }],
			});
		};

		const removeItem = (index) => {
			if (faqItems.length <= 1) return;
			setAttributes({ items: faqItems.filter((_, i) => i !== index) });
		};

		return wp.element.createElement(
			Fragment,
			null,
			wp.element.createElement(
				InspectorControls,
				null,
				wp.element.createElement(
					PanelBody,
					{ title: 'FAQ items', initialOpen: true },
					faqItems.map((item, index) =>
						wp.element.createElement(
							'div',
							{ key: index, style: { marginBottom: '1rem', paddingBottom: '1rem', borderBottom: '1px solid #e5e7eb' } },
							wp.element.createElement('p', { style: { margin: '0 0 0.5rem', fontWeight: 600 } }, `Question ${index + 1}`),
							wp.element.createElement(TextareaControl, {
								label: 'Question',
								value: item.question || '',
								onChange: (v) => updateItem(index, 'question', v),
							}),
							wp.element.createElement(TextareaControl, {
								label: 'Answer',
								value: item.answer || '',
								onChange: (v) => updateItem(index, 'answer', v),
							}),
							wp.element.createElement(Button, { isDestructive: true, onClick: () => removeItem(index), style: { marginTop: '0.5rem' } }, 'Remove question'),
						),
					),
					wp.element.createElement(Button, { variant: 'secondary', onClick: addItem }, 'Add question'),
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
						{ className: 'agency-faq-section__split' },
						wp.element.createElement(
							'div',
							{ className: 'agency-faq-section__intro' },
							wp.element.createElement(RichText, {
								tagName: 'h2',
								className: 'agency-faq-section__title agency-section__title',
								value: heading,
								onChange: (v) => setAttributes({ heading: v }),
								placeholder: 'FAQs',
								allowedFormats: [],
							}),
						),
						wp.element.createElement(
							'div',
							{ className: 'agency-faq-section__list' },
							faqItems.map((item, index) =>
								wp.element.createElement(
									'details',
									{
										key: index,
										className: 'agency-faq__item',
									},
									wp.element.createElement(
										'summary',
										{ className: 'agency-faq__summary' },
										wp.element.createElement('span', { className: 'agency-faq__question' }, item.question || `Question ${index + 1}`),
									),
									wp.element.createElement(
										'div',
										{ className: 'agency-faq__answer' },
										item.answer || 'Add an answer in the sidebar.',
									),
								),
							),
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
