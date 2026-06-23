/**
 * Block editor modifications
 */
import '@_tw/typography/block-editor-classes';

wp.domReady(() => {
	wp.blocks.registerBlockStyle('core/paragraph', {
		name: 'lead',
		label: 'Lead',
	});

	wp.blocks.registerBlockStyle('core/paragraph', {
		name: 'agency-eyebrow',
		label: 'Eyebrow',
	});

	wp.blocks.registerBlockStyle('core/group', {
		name: 'agency-section-alt',
		label: 'Section Alt',
	});

	wp.blocks.registerBlockStyle('core/group', {
		name: 'agency-section-dark',
		label: 'Section Dark',
	});
});
