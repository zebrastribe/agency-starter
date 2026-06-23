/**
 * Vertical USP accordion — expand content inline under each tab.
 */

const CHEVRON_UP =
	'<svg class="agency-usp-tabs__chevron-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>';
const CHEVRON_DOWN =
	'<svg class="agency-usp-tabs__chevron-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>';

/**
 * Wire one USP accordion root element.
 *
 * @param {HTMLElement} root
 */
export function initAgencyUspTabs(root) {
	const items = Array.from(root.querySelectorAll('[data-usp-item]'));
	const figures = Array.from(root.querySelectorAll('[data-usp-figure]'));

	if (!items.length) {
		return;
	}

	const activate = (index) => {
		items.forEach((item, i) => {
			const active = i === index;
			const tab = item.querySelector('[data-usp-tab]');
			const panel = item.querySelector('[data-usp-panel]');
			const chevron = item.querySelector('[data-usp-chevron]');

			item.classList.toggle('is-active', active);

			if (tab instanceof HTMLButtonElement) {
				tab.setAttribute('aria-expanded', active ? 'true' : 'false');
				tab.tabIndex = active ? 0 : -1;
			}

			if (panel instanceof HTMLElement) {
				panel.setAttribute('aria-hidden', active ? 'false' : 'true');
			}

			if (chevron) {
				chevron.innerHTML = active ? CHEVRON_UP : CHEVRON_DOWN;
			}
		});

		figures.forEach((figure, i) => {
			const show = i === index;
			figure.classList.toggle('is-active', show);
			figure.setAttribute('aria-hidden', show ? 'false' : 'true');
		});
	};

	items.forEach((item) => {
		const tab = item.querySelector('[data-usp-tab]');
		if (!(tab instanceof HTMLButtonElement)) {
			return;
		}

		tab.addEventListener('click', () => {
			const index = Number(item.dataset.uspIndex);
			if (!Number.isNaN(index)) {
				activate(index);
			}
		});

		tab.addEventListener('keydown', (event) => {
			const current = Number(item.dataset.uspIndex);
			if (Number.isNaN(current)) {
				return;
			}

			let next = current;
			if (event.key === 'ArrowDown' || event.key === 'ArrowRight') {
				event.preventDefault();
				next = (current + 1) % items.length;
			} else if (event.key === 'ArrowUp' || event.key === 'ArrowLeft') {
				event.preventDefault();
				next = (current - 1 + items.length) % items.length;
			} else if (event.key === 'Home') {
				event.preventDefault();
				next = 0;
			} else if (event.key === 'End') {
				event.preventDefault();
				next = items.length - 1;
			} else {
				return;
			}

			activate(next);
			const nextTab = items[next]?.querySelector('[data-usp-tab]');
			if (nextTab instanceof HTMLButtonElement) {
				nextTab.focus();
			}
		});
	});
}

/**
 * Initialize all USP accordion blocks on the page.
 *
 * @param {ParentNode} [scope=document]
 */
export function initAllAgencyUspTabs(scope = document) {
	scope.querySelectorAll('[data-agency-usp-tabs]').forEach((root) => {
		if (root instanceof HTMLElement && !root.dataset.uspTabsInit) {
			root.dataset.uspTabsInit = 'true';
			initAgencyUspTabs(root);
		}
	});
}

function boot() {
	initAllAgencyUspTabs();
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', boot);
} else {
	boot();
}
