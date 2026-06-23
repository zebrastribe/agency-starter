/**
 * Media Slider — full-width carousel (testimonials / showcases).
 */
document.querySelectorAll('[data-agency-media-slider]').forEach((root) => {
	const track = root.querySelector('[data-media-slider-track]');
	const viewport = root.querySelector('.agency-media-slider__viewport');
	const slides = Array.from(root.querySelectorAll('[data-media-slide]'));
	const dots = Array.from(root.querySelectorAll('[data-media-dot]'));

	if (!track || !viewport || !slides.length) {
		return;
	}

	const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	const autoplayMs = 6000;
	const swipeThreshold = 48;

	let activeIndex = 0;
	let currentOffset = 0;
	let isDragging = false;
	let isPaused = false;
	let dragStartX = 0;
	let dragStartOffset = 0;
	let autoplayId = null;

	const getSlideOffset = (index) => {
		const slide = slides[index];
		if (!slide) {
			return 0;
		}

		const viewportWidth = viewport.getBoundingClientRect().width;
		const slideCenter = slide.offsetLeft + slide.offsetWidth / 2;
		return slideCenter - viewportWidth / 2;
	};

	const setTrackOffset = (offset, animate = true) => {
		currentOffset = offset;
		const shouldAnimate = animate && !reducedMotion && !isDragging;
		track.classList.toggle('is-animating', shouldAnimate);
		track.style.transform = `translateX(${-offset}px)`;
	};

	const stopAutoplay = () => {
		if (autoplayId !== null) {
			window.clearInterval(autoplayId);
			autoplayId = null;
		}
	};

	const startAutoplay = () => {
		stopAutoplay();

		if (reducedMotion || slides.length <= 1 || isPaused || isDragging) {
			return;
		}

		autoplayId = window.setInterval(() => {
			activateSlide(activeIndex + 1);
		}, autoplayMs);
	};

	const activateSlide = (slideIndex, { animate = true } = {}) => {
		const next = ((slideIndex % slides.length) + slides.length) % slides.length;
		activeIndex = next;

		slides.forEach((slide, i) => {
			const active = i === next;
			slide.classList.toggle('is-active', active);
			slide.setAttribute('aria-hidden', active ? 'false' : 'true');
		});

		dots.forEach((dot, i) => {
			const active = i === next;
			dot.classList.toggle('is-active', active);
			if (active) {
				dot.setAttribute('aria-current', 'true');
				dot.tabIndex = 0;
			} else {
				dot.removeAttribute('aria-current');
				dot.tabIndex = -1;
			}
		});

		root.dataset.activeSlide = String(next);
		setTrackOffset(getSlideOffset(next), animate);
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
				startAutoplay();
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
			startAutoplay();
		});
	});

	const recenter = () => {
		setTrackOffset(getSlideOffset(activeIndex), false);
	};

	window.addEventListener('resize', recenter);

	if (typeof ResizeObserver !== 'undefined') {
		const observer = new ResizeObserver(recenter);
		observer.observe(viewport);
		slides.forEach((slide) => observer.observe(slide));
	}

	const pause = () => {
		isPaused = true;
		stopAutoplay();
	};

	const resume = () => {
		isPaused = false;
		startAutoplay();
	};

	root.addEventListener('mouseenter', pause);
	root.addEventListener('mouseleave', resume);
	root.addEventListener('focusin', pause);
	root.addEventListener('focusout', (event) => {
		if (!root.contains(event.relatedTarget)) {
			resume();
		}
	});

	document.addEventListener('visibilitychange', () => {
		if (document.hidden) {
			stopAutoplay();
			return;
		}

		if (!isPaused) {
			startAutoplay();
		}
	});

	const endDrag = (event) => {
		if (!isDragging) {
			return;
		}

		isDragging = false;
		track.classList.remove('is-dragging');
		viewport.classList.remove('is-dragging');

		if (viewport.hasPointerCapture(event.pointerId)) {
			viewport.releasePointerCapture(event.pointerId);
		}

		const delta = dragStartX - event.clientX;

		if (Math.abs(delta) > swipeThreshold) {
			activateSlide(activeIndex + (delta > 0 ? 1 : -1));
		} else {
			activateSlide(activeIndex);
		}

		if (!isPaused) {
			startAutoplay();
		}
	};

	viewport.addEventListener('pointerdown', (event) => {
		if (event.pointerType === 'mouse' && event.button !== 0) {
			return;
		}

		if (event.target.closest('a, button')) {
			return;
		}

		event.preventDefault();

		isDragging = true;
		dragStartX = event.clientX;
		dragStartOffset = currentOffset;
		track.classList.add('is-dragging');
		viewport.classList.add('is-dragging');
		viewport.setPointerCapture(event.pointerId);
		stopAutoplay();
	});

	viewport.addEventListener('pointermove', (event) => {
		if (!isDragging) {
			return;
		}

		event.preventDefault();
		setTrackOffset(dragStartOffset + (dragStartX - event.clientX), false);
	});

	viewport.addEventListener('pointerup', endDrag);
	viewport.addEventListener('pointercancel', endDrag);

	viewport.addEventListener('dragstart', (event) => {
		event.preventDefault();
	});

	activateSlide(0, { animate: false });
	startAutoplay();
});
