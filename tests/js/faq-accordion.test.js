import { describe, it, expect, beforeEach } from 'vitest';
import { initFaqSections } from '../../javascript/faq-section.js';

function buildFaqMarkup() {
	return `
		<section class="agency-faq-section">
			<div class="agency-faq-section__list">
				<details class="agency-faq__item">
					<summary class="agency-faq__summary" aria-expanded="false">
						<span class="agency-faq__question">Question one</span>
					</summary>
					<div class="agency-faq__answer">Answer one</div>
				</details>
				<details class="agency-faq__item">
					<summary class="agency-faq__summary" aria-expanded="false">
						<span class="agency-faq__question">Question two</span>
					</summary>
					<div class="agency-faq__answer">Answer two</div>
				</details>
			</div>
		</section>
	`;
}

describe('FAQ accordion', () => {
	beforeEach(() => {
		document.body.innerHTML = buildFaqMarkup();
		initFaqSections();
	});

	it('starts with all panels collapsed', () => {
		const items = document.querySelectorAll('.agency-faq__item');
		for (const item of items) {
			expect(item.open).toBe(false);
		}
	});

	it('toggles open state when summary is clicked', () => {
		const items = document.querySelectorAll('.agency-faq__item');
		const secondSummary = items[1].querySelector('.agency-faq__summary');

		secondSummary?.dispatchEvent(new MouseEvent('click', { bubbles: true }));
		expect(items[1].open).toBe(true);
	});

	it('syncs aria-expanded on summaries', async () => {
		const summary = document.querySelectorAll('.agency-faq__summary')[1];
		expect(summary.getAttribute('aria-expanded')).toBe('false');

		summary.click();
		await Promise.resolve();
		expect(summary.getAttribute('aria-expanded')).toBe('true');
	});
});
