/**
 * Interactive Hero — viewport sizing + media slider.
 */
const syncHeroViewportHeight = () => {
	document.querySelectorAll('[data-agency-hero-interactive]').forEach((root) => {
		const shell = root.closest('.agency-main')?.querySelector('.site-header-shell') || document.querySelector('.site-header-shell');
		if (!shell) {
			return;
		}

		const height = Math.ceil(shell.getBoundingClientRect().height);
		document.documentElement.style.setProperty('--agency-shell-header-offset', `${height}px`);
	});
};

syncHeroViewportHeight();

if (typeof ResizeObserver !== 'undefined') {
	const shell = document.querySelector('.site-header-shell');
	if (shell) {
		const observer = new ResizeObserver(syncHeroViewportHeight);
		observer.observe(shell);
	}
} else {
	window.addEventListener('resize', syncHeroViewportHeight);
}

document.querySelectorAll('[data-agency-hero-interactive]').forEach((root) => {
	const slides = Array.from(root.querySelectorAll('[data-hero-slide]'));
	const dots = Array.from(root.querySelectorAll('[data-hero-dot]'));

	if (!slides.length) {
		return;
	}

	const activateSlide = (slideIndex) => {
		const next = ((slideIndex % slides.length) + slides.length) % slides.length;

		slides.forEach((slide, i) => {
			const active = i === next;
			slide.classList.toggle('is-active', active);
			slide.hidden = !active;
		});

		dots.forEach((dot, i) => {
			const active = i === next;
			dot.classList.toggle('is-active', active);
			if (active) {
				dot.setAttribute('aria-current', 'true');
			} else {
				dot.removeAttribute('aria-current');
			}
			dot.tabIndex = active ? 0 : -1;
		});

		root.dataset.activeSlide = String(next);
	};

	const focusDot = (index) => {
		dots[index]?.focus();
	};

	dots.forEach((dot, dotIndex) => {
		dot.tabIndex = dotIndex === 0 ? 0 : -1;

		dot.addEventListener('click', () => {
			const slideIndex = Number(dot.dataset.slideIndex);
			if (!Number.isNaN(slideIndex)) {
				activateSlide(slideIndex);
			}
		});

		dot.addEventListener('keydown', (event) => {
			let next = dotIndex;
			if (event.key === 'ArrowRight' || event.key === 'ArrowDown') {
				event.preventDefault();
				next = (dotIndex + 1) % dots.length;
			} else if (event.key === 'ArrowLeft' || event.key === 'ArrowUp') {
				event.preventDefault();
				next = (dotIndex - 1 + dots.length) % dots.length;
			} else if (event.key === 'Home') {
				event.preventDefault();
				next = 0;
			} else if (event.key === 'End') {
				event.preventDefault();
				next = dots.length - 1;
			} else {
				return;
			}

			activateSlide(next);
			focusDot(next);
		});
	});

	activateSlide(0);
});
