/**
 * Front-end navigation and accessibility helpers.
 */

const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
const mobileNavPanel = document.querySelector('#mobile-nav-panel');
const mobileNavDrawer = document.querySelector('.mobile-nav-panel__drawer');
const mobileNavClose = document.querySelector('.mobile-nav-close');
const mobileNavBackdrop = document.querySelector('.mobile-nav-panel__backdrop');
const desktopNav = document.querySelector('.site-header .primary-nav');
const siteHeader = document.querySelector('.site-header');
const navI18n = window.agencyStarterI18n || {};

const FOCUSABLE = 'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])';
const DESKTOP_NAV_QUERY = window.matchMedia('(min-width: 64em)');

const HOVER_CLOSE_DELAY = 280;

let scrollLockY = 0;
let openNavItem = null;
let openPanel = null;
let closeTimer = null;

function getFocusableElements(container) {
	return Array.from(container.querySelectorAll(FOCUSABLE)).filter(
		(el) => !el.hasAttribute('hidden') && el.offsetParent !== null,
	);
}

function trapFocus(event) {
	if (!mobileNavPanel || mobileNavPanel.hidden) {
		return;
	}
	const focusable = getFocusableElements(mobileNavPanel);
	if (!focusable.length) {
		return;
	}
	const first = focusable[0];
	const last = focusable[focusable.length - 1];

	if (event.key === 'Tab') {
		if (event.shiftKey && document.activeElement === first) {
			event.preventDefault();
			last.focus();
		} else if (!event.shiftKey && document.activeElement === last) {
			event.preventDefault();
			first.focus();
		}
	}
}

function lockScroll() {
	scrollLockY = window.scrollY;
	document.body.classList.add('mobile-nav-open');
	document.body.style.top = `-${scrollLockY}px`;
}

function unlockScroll() {
	document.body.classList.remove('mobile-nav-open');
	document.body.style.top = '';
	window.scrollTo(0, scrollLockY);
}

function openMobileNav() {
	if (!mobileNavPanel || !mobileNavToggle) {
		return;
	}
	mobileNavPanel.hidden = false;
	requestAnimationFrame(() => {
		mobileNavPanel.classList.add('is-open');
	});
	mobileNavToggle.setAttribute('aria-expanded', 'true');
	if (navI18n.closeMenu) {
		mobileNavToggle.setAttribute('aria-label', navI18n.closeMenu);
	}
	lockScroll();
	document.addEventListener('keydown', trapFocus);
	const firstLink = getFocusableElements(mobileNavPanel)[0];
	if (firstLink) {
		firstLink.focus();
	}
}

function closeMobileNav(immediate = false) {
	if (!mobileNavPanel || !mobileNavToggle) {
		return;
	}
	mobileNavPanel.classList.remove('is-open');
	mobileNavToggle.setAttribute('aria-expanded', 'false');
	if (navI18n.openMenu) {
		mobileNavToggle.setAttribute('aria-label', navI18n.openMenu);
	}
	unlockScroll();
	document.removeEventListener('keydown', trapFocus);
	resetMobileNavBranches();

	if (immediate || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
		mobileNavPanel.hidden = true;
		return;
	}

	const drawer = mobileNavDrawer || mobileNavPanel;
	const onTransitionEnd = (event) => {
		if (event.target !== drawer || event.propertyName !== 'transform') {
			return;
		}
		drawer.removeEventListener('transitionend', onTransitionEnd);
		mobileNavPanel.hidden = true;
		mobileNavToggle.focus();
	};

	drawer.addEventListener('transitionend', onTransitionEnd);
}

function resetMobileNavBranches() {
	document.querySelectorAll('.mobile-nav-item--branch.is-open').forEach((branch) => {
		branch.classList.remove('is-open');
		branch.querySelector('[data-mobile-branch]')?.setAttribute('aria-expanded', 'false');
		const list = branch.querySelector('.mobile-nav-branch__list');
		if (list) {
			list.hidden = true;
		}
	});
}

function isMobileNavVisible() {
	return Boolean(
		mobileNavPanel &&
			!mobileNavPanel.hidden &&
			(mobileNavPanel.classList.contains('is-open') ||
				document.body.classList.contains('mobile-nav-open')),
	);
}

function handleViewportChange() {
	if (DESKTOP_NAV_QUERY.matches) {
		if (isMobileNavVisible()) {
			closeMobileNav(true);
		} else {
			resetMobileNavBranches();
		}

		closeOpenNav();
		return;
	}

	closeOpenNav();
}

function toggleMobileNav() {
	if (mobileNavPanel.classList.contains('is-open')) {
		closeMobileNav();
	} else {
		openMobileNav();
	}
}

function positionNavPanels() {
	if (!siteHeader) {
		return;
	}

	const top = `${siteHeader.getBoundingClientRect().bottom}px`;
	document.documentElement.style.setProperty('--agency-nav-panel-top', top);
}

function clearCloseTimer() {
	if (closeTimer !== null) {
		window.clearTimeout(closeTimer);
		closeTimer = null;
	}
}

function scheduleCloseNav() {
	clearCloseTimer();
	closeTimer = window.setTimeout(() => {
		closeOpenNav();
	}, HOVER_CLOSE_DELAY);
}

function getPanelForItem(item) {
	const itemId = item.dataset.navItem;
	if (!itemId) {
		return null;
	}

	return (
		document.querySelector(`[data-mega-for="${itemId}"]`) ||
		document.querySelector(`[data-nav-for="${itemId}"]`)
	);
}

function closeOpenNav() {
	if (openNavItem) {
		openNavItem.classList.remove('is-open');
		openNavItem.querySelector('[data-nav-trigger]')?.setAttribute('aria-expanded', 'false');
	}

	if (openPanel) {
		openPanel.classList.remove('is-open');
	}

	openNavItem = null;
	openPanel = null;
	document.body.classList.remove('agency-nav-open');
}

function openNavItemPanel(item) {
	if (!DESKTOP_NAV_QUERY.matches) {
		return;
	}

	const panel = getPanelForItem(item);
	const trigger = item.querySelector('[data-nav-trigger]');

	if (!panel || !trigger) {
		return;
	}

	if (openNavItem && openNavItem !== item) {
		closeOpenNav();
	}

	clearCloseTimer();
	item.classList.add('is-open');
	panel.classList.add('is-open');
	trigger.setAttribute('aria-expanded', 'true');
	openNavItem = item;
	openPanel = panel;
	document.body.classList.add('agency-nav-open');
	positionNavPanels();
}

function initDesktopNavigation() {
	if (!desktopNav) {
		return;
	}

	desktopNav.querySelectorAll('.menu-item-has-children').forEach((item) => {
		const trigger = item.querySelector('[data-nav-trigger]');
		const panel = getPanelForItem(item);

		if (!trigger || !panel) {
			return;
		}

		const open = () => openNavItemPanel(item);
		const scheduleClose = () => scheduleCloseNav();

		item.addEventListener('mouseenter', open);
		item.addEventListener('mouseleave', scheduleClose);
		panel.addEventListener('mouseenter', clearCloseTimer);
		panel.addEventListener('mouseleave', scheduleClose);

		trigger.addEventListener('click', (event) => {
			event.preventDefault();
			event.stopPropagation();

			if (item.classList.contains('is-open')) {
				closeOpenNav();
				return;
			}

			openNavItemPanel(item);
		});
	});

	desktopNav.querySelectorAll('[data-mega-close]').forEach((button) => {
		button.addEventListener('click', (event) => {
			event.preventDefault();
			closeOpenNav();
		});
	});

	document.addEventListener('click', (event) => {
		if (!openNavItem) {
			return;
		}

		if (openNavItem.contains(event.target) || openPanel?.contains(event.target)) {
			return;
		}

		closeOpenNav();
	});

	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && openNavItem) {
			closeOpenNav();
		}
	});

	window.addEventListener('resize', positionNavPanels);
	window.addEventListener('scroll', positionNavPanels, { passive: true });
	positionNavPanels();
}

function initMobileNavigation() {
	document.querySelectorAll('[data-mobile-branch]').forEach((button) => {
		button.addEventListener('click', (event) => {
			event.preventDefault();
			event.stopPropagation();

			const branch = button.closest('.mobile-nav-item--branch');
			const list = branch?.querySelector('.mobile-nav-branch__list');
			if (!branch || !list) {
				return;
			}

			const isOpen = branch.classList.toggle('is-open');
			button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
			list.hidden = !isOpen;
		});
	});
}

if (mobileNavToggle && mobileNavPanel) {
	mobileNavToggle.addEventListener('click', toggleMobileNav);
	mobileNavClose?.addEventListener('click', closeMobileNav);
	mobileNavBackdrop?.addEventListener('click', closeMobileNav);
	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && mobileNavPanel.classList.contains('is-open')) {
			closeMobileNav();
		}
	});

	if (typeof DESKTOP_NAV_QUERY.addEventListener === 'function') {
		DESKTOP_NAV_QUERY.addEventListener('change', handleViewportChange);
	} else {
		DESKTOP_NAV_QUERY.addListener(handleViewportChange);
	}

	window.addEventListener('resize', handleViewportChange);
	handleViewportChange();
}

initDesktopNavigation();
initMobileNavigation();
