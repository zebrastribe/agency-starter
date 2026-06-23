import { describe, it, expect, beforeEach } from 'vitest';
import { initAgencyUspTabs } from '../../javascript/usp-tabs.js';

function buildUspTabsMarkup() {
	return `
		<section data-agency-usp-tabs>
			<div class="agency-usp-tabs__item is-active" data-usp-item data-usp-index="0">
				<button type="button" data-usp-tab data-usp-index="0" aria-expanded="true">
					Tab A<span data-usp-chevron></span>
				</button>
				<div data-usp-panel data-usp-index="0" aria-hidden="false">Panel A</div>
			</div>
			<div class="agency-usp-tabs__item" data-usp-item data-usp-index="1">
				<button type="button" data-usp-tab data-usp-index="1" aria-expanded="false">
					Tab B<span data-usp-chevron></span>
				</button>
				<div data-usp-panel data-usp-index="1" aria-hidden="true">Panel B</div>
			</div>
			<figure data-usp-figure data-usp-index="0" class="is-active" aria-hidden="false">Fig A</figure>
			<figure data-usp-figure data-usp-index="1" aria-hidden="true">Fig B</figure>
		</section>
	`;
}

describe('initAgencyUspTabs', () => {
	let root;

	beforeEach(() => {
		document.body.innerHTML = buildUspTabsMarkup();
		root = document.querySelector('[data-agency-usp-tabs]');
		initAgencyUspTabs(root);
	});

	it('expands clicked item inline and collapses others', () => {
		const items = root.querySelectorAll('[data-usp-item]');
		const tabs = root.querySelectorAll('[data-usp-tab]');
		const panels = root.querySelectorAll('[data-usp-panel]');

		tabs[1].click();

		expect(items[0].classList.contains('is-active')).toBe(false);
		expect(items[1].classList.contains('is-active')).toBe(true);
		expect(tabs[0].getAttribute('aria-expanded')).toBe('false');
		expect(tabs[1].getAttribute('aria-expanded')).toBe('true');
		expect(panels[0].getAttribute('aria-hidden')).toBe('true');
		expect(panels[1].getAttribute('aria-hidden')).toBe('false');
	});

	it('does nothing when accordion items are missing', () => {
		document.body.innerHTML = '<section data-agency-usp-tabs></section>';
		const empty = document.querySelector('[data-agency-usp-tabs]');
		expect(() => initAgencyUspTabs(empty)).not.toThrow();
	});
});
