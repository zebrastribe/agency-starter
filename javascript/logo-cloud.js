/**
 * Logo Cloud marquee — animate full width when logos overflow or count threshold met.
 */
document.querySelectorAll('[data-agency-logo-marquee]').forEach((root) => {
	const track = root.querySelector('[data-marquee-track]');
	const list = root.querySelector('[data-marquee-list]');
	const viewport = root.querySelector('[data-marquee-viewport]');

	if (!track || !list || !viewport) {
		return;
	}

	const minLogos = Number(root.dataset.minLogos) || 6;
	const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

	const reset = () => {
		track.querySelectorAll('[data-marquee-clone]').forEach((node) => node.remove());
		root.classList.remove('is-animated', 'is-static');
	};

	const setup = () => {
		reset();

		const items = list.querySelectorAll('.agency-logo-cloud__item');
		if (!items.length) {
			return;
		}

		const listWidth = list.scrollWidth;
		const viewportWidth = viewport.clientWidth;
		const shouldAnimate =
			!reducedMotion.matches &&
			(items.length >= minLogos || listWidth > viewportWidth);

		if (shouldAnimate) {
			const clone = list.cloneNode(true);
			clone.setAttribute('data-marquee-clone', '');
			clone.setAttribute('aria-hidden', 'true');
			track.appendChild(clone);
			root.classList.add('is-animated');
			return;
		}

		root.classList.add('is-static');
	};

	setup();

	let resizeTimer;
	window.addEventListener('resize', () => {
		window.clearTimeout(resizeTimer);
		resizeTimer = window.setTimeout(setup, 150);
	});

	reducedMotion.addEventListener('change', setup);
});
