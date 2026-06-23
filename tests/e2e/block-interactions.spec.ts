import { test, expect } from '@playwright/test';

test.describe('Block interactions', () => {
	test('USP tabs switch panel when a tab is clicked', async ({ page }) => {
		await page.goto('/');

		const section = page.locator('[data-agency-usp-tabs]').first();
		await expect(section).toBeVisible();

		const tabs = section.locator('[data-usp-tab]');
		await expect(tabs).toHaveCount(4);

		const secondItem = section.locator('[data-usp-item]').nth(1);
		const secondTab = secondItem.locator('[data-usp-tab]');
		const secondPanel = secondItem.locator('[data-usp-panel]');

		await expect(secondItem).not.toHaveClass(/is-active/);
		await expect(secondPanel).toHaveAttribute('aria-hidden', 'true');

		await secondTab.click();

		await expect(secondItem).toHaveClass(/is-active/);
		await expect(secondTab).toHaveAttribute('aria-expanded', 'true');
		await expect(secondPanel).toHaveAttribute('aria-hidden', 'false');
		await expect(section.locator('[data-usp-item]').first()).not.toHaveClass(/is-active/);
	});

	test('USP tabs view script is loaded on homepage', async ({ page }) => {
		const responses: string[] = [];
		page.on('response', (response) => {
			if (response.url().includes('usp-tabs.min.js')) {
				responses.push(response.url());
			}
		});

		await page.goto('/');
		await page.locator('[data-agency-usp-tabs]').first().waitFor();

		expect(responses.length).toBeGreaterThan(0);
	});

	test('FAQ accordion opens on summary click', async ({ page }) => {
		await page.goto('/');

		const faqSection = page.locator('.agency-faq-section').first();
		if ((await faqSection.count()) === 0) {
			test.skip(true, 'No FAQ block on homepage — add faq-section to test page');
		}

		const secondItem = faqSection.locator('.agency-faq__item').nth(1);
		await secondItem.locator('.agency-faq__summary').click();
		await expect(secondItem).toHaveAttribute('open', '');
	});
});
