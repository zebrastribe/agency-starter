/**
 * FAQ Section — sync aria-expanded on native details/summary accordions.
 */
function initFaqSections(root = document) {
	root.querySelectorAll('.agency-faq-section').forEach((section) => {
		section.querySelectorAll('.agency-faq__item').forEach((item) => {
			const summary = item.querySelector('.agency-faq__summary');
			if (!(summary instanceof HTMLElement)) {
				return;
			}

			const sync = () => {
				summary.setAttribute('aria-expanded', item.open ? 'true' : 'false');
			};

			sync();
			item.addEventListener('toggle', sync);
			summary.addEventListener('click', () => {
				queueMicrotask(sync);
			});
		});
	});
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', () => initFaqSections());
} else {
	initFaqSections();
}

export { initFaqSections };
