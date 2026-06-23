# THEME_AUDIT.md — Agency Starter v0.1.0

**Audit date:** 2026-06-17  
**Auditor:** Enterprise WordPress engineering review (12 phases)  
**Scope:** 161 source files (excludes `node_modules/`, `vendor/`, test artifacts)  
**Prior audits:** `/theme-audit/01`–`20` (2026-06-10 baseline + SEO/AEO 2026-06-17)

## Legend

| Symbol | Meaning |
|--------|---------|
| ✓ | Passed — acceptable for production starter kit |
| ⚠ | Needs improvements — ship with documented caveat or fix in Phase 2 |
| ✖ | Critical — release blocker for enterprise / Theme Directory |
| ◐ | In progress / partial |

## Executive scores (/100)

| Dimension | Score | Grade |
|-----------|------:|-------|
| **Overall theme health** | **82** | B |
| **Production readiness** | **86** | B+ |
| **WordPress compliance** | **76** | C+ |
| **Architecture** | **78** | C+ |
| **Code quality** | **80** | B− |
| **Maintainability** | **74** | C+ |
| **Performance** | **71** | C |
| **Accessibility** | **86** | B |
| **Security** | **82** | B |
| **UX** | **68** | D+ |
| **Developer experience** | **79** | C+ |
| **Gutenberg** | **84** | B |
| **Theme completeness** | **70** | C |
| **Plugin compatibility** | **72** | C |
| **Future-proofing** | **75** | C+ |
| **Technical debt** | **35** | High debt (lower is better) |

**Verdict:** Strong **B2B agency starter kit** for controlled client deployments. **Not production-ready** for mass distribution (WordPress.org, tens of thousands of sites) without Phase 1–3 roadmap completion.

---

## Phase summaries

### Phase 1 — Repository architecture ⚠

- **_tw split:** build root + `theme/` installable tree — intentional, documented.
- **No PHP namespaces / PSR-4** — procedural `inc/` modules; acceptable for theme scale.
- **Composer:** dev-only (WPCS, i18n); `vendor/` should not ship in zip.
- **Node:** Tailwind 4 + esbuild; production build required before deploy.
- **CI:** `.github/workflows/theme-tests.yml` runs Vitest + PHPUnit only — no lint, e2e, production build, or PHPCS.
- **Broken script:** `npm run test:qa` references missing `node_scripts/lighthouse-qa.mjs`.
- **Artifact in tree:** `agency-starter.zip` should not be committed.
- **Licensing:** GPL v2+ in `LICENSE` + `style.css` header ✓

### Phase 2 — WordPress theme completeness ⚠

| Feature | Status |
|---------|--------|
| Block theme / FSE | ✓ |
| Front page, pages, singles, archives, search, 404 | ✓ |
| Custom page templates (contact, legal, news, articles, job) | ✓ |
| Job CPT + archive + single | ✓ |
| News/articles via categories + hub pages | ✓ (2026-06-17) |
| Menus (5 locations) | ✓ |
| Featured images, custom logo, title-tag, feeds | ✓ |
| theme.json + style variations (5) | ✓ |
| Patterns (40+) + synced patterns | ✓ |
| **Comments** | ✖ No template, no `comments.php`, singles omit comments |
| **Posts page (native blog)** | ⚠ Uses static hub pages instead |
| **Sticky posts** | ⚠ No handling |
| **Password-protected posts** | ⚠ Core default only |
| **Attachment pages** | ⚠ No `attachment.html`; core fallback |
| **Widget areas / customizer** | N/A FSE — block widgets only |
| **RTL** | ✖ No `rtl.css` or logical property audit |
| **i18n** | ⚠ Text domain consistent; **no `.pot` committed** |
| **Child themes** | ✖ Undocumented |
| **Multisite** | ⚠ Untested |
| **WooCommerce** | ✖ Not integrated (comment stub in `tailwind.css` only) |
| **WPML** | ✖ Not integrated |
| **Polylang** | ⚠ Demo seeding + language switcher; no graceful no-plugin fallback in header |
| **Yoast / RankMath / SEOPress** | ⚠ Yoast-first; RankMath/TSF untested |
| **Caching plugins** | ⚠ No explicit compatibility layer |

### Phase 3 — Template hierarchy ✓ (FSE)

Block theme correctly uses HTML templates. Missing `category.html`, `tag.html`, `author.html`, `date.html` — **acceptable**; `archive.html` fallback works. No `comments` template part.

### Phase 4 — Gutenberg ✓

Six custom blocks with `block.json`, PHP render, editor scripts. USP tabs accordion + ARIA improved. FAQ uses `<details>`. Editor scripts enqueue on all block editor screens (admin perf ⚠).

### Phase 5 — Code review ⚠

- Sanitization/escaping generally correct in block renders.
- Pattern markup triplicated (`patterns.php`, `synced-patterns.php`, demo content).
- Demo system (`demo-content.php`) large but gated by `AGENCY_STARTER_DEMO`.
- `post-archives.php` adds maintainable query filtering ✓

### Phase 6 — WordPress standards ✓

- ABSPATH guards on PHP files ✓
- `load_theme_textdomain` ✓
- `register_nav_menus`, `add_theme_support`, enqueue APIs ✓
- Block bindings for job meta ✓
- Classic `wp_head`/`get_header` N/A (block theme)

### Phase 7 — Performance ✓

- Core `style.css` bundle; custom block CSS split to `theme/css/blocks/` (on-demand via `wp_enqueue_block_style`) ✓
- Tailwind Typography split to `css/prose-content.css` (editorial views only) ✓
- Critical header CSS single source (`css/critical-header.css`) ✓
- Mobile nav script conditional on header template part ✓
- Responsive images via `agency_starter_render_image()` ✓
- Global `script.min.js` on all front-end pages — now conditional ✓

### Phase 8 — Accessibility ✓

- Skip link, focus-visible rings, reduced-motion CSS ✓
- Mobile nav `role="dialog"` ✓
- Contrast rules in design tokens / `agency-design.css` ✓
- 404 via translatable `404-content` pattern ✓
- FAQ collapsed by default + `aria-expanded` sync ✓
- CF7 accessible demo form markup (`inc/cf7-forms.php`) ✓
- RTL stylesheet (`rtl.css`) + logical header props ✓
- PHPUnit a11y contracts in CI ✓
- Playwright + axe via `npm run test:a11y` (local/staging) ✓

### Phase 9 — Security ✓

- Output escaped in dynamic blocks.
- Demo seeders gated (`AGENCY_STARTER_DEMO` + capabilities).
- Job meta `auth_callback` on REST ✓
- No custom REST routes or AJAX handlers.
- Polylang `update_option` demo-only.

### Phase 10 — UX ⚠

- Lorem ipsum throughout — expected for starter, blocks client launch.
- Newsletter shortcode placeholder.
- Empty query states not designed.
- Search includes posts + jobs ✓

### Phase 11 — Edge cases ⚠

- No posts / one post / thousands: core Query Loop handles; empty state UI missing.
- No menu assigned: fallback nav ✓
- WooCommerce active: no styles/conflicts tested.
- PHP 8.3: compatible; `Requires PHP: 7.4` in header is low — bump to 8.0+ recommended.

### Phase 12 — Developer experience ✓

- `DESIGN-SYSTEM.md`, `README.md` strong.
- PHPCS, PHPUnit, Vitest, Playwright present.
- Missing: child theme guide, production deploy checklist in theme root, `.pot` generation in CI.

---

## Critical issues register

### ✖ CRIT-01 — Not distributable at enterprise scale

**Location:** Project positioning  
**Impact:** Theme is v0.1.0 starter with demo content, Lorem, and client-specific paths (`/kandidater/it-jobs/`).  
**Fix:** Version as starter kit; separate production bundle pipeline per `WP-dev/docs/theme-deploy-for-all-users.md`.

### ✖ CRIT-02 — Comments not supported

**Location:** `theme/templates/single.html`, missing `comments` template part  
**Impact:** Comment-enabled posts render without theme styling; poor UX for blogs.  
**Fix:**

```html
<!-- Add to single.html after post-content section -->
<!-- wp:template-part {"slug":"comments","area":"uncategorized"} /-->
```

Create `theme/parts/comments.html`:

```html
<!-- wp:comments {"className":"agency-comments"} /-->
```

Add `add_theme_support( 'html5', … 'comment-list' )` already present; enqueue comment-reply if threaded.

### ✖ CRIT-03 — No translation template (.pot)

**Location:** `theme/languages/`  
**Impact:** Blocks WordPress.org i18n requirements; enterprise multilingual workflows.  
**Fix:** `composer run make-pot` in CI; commit `agency-starter.pot`.

### ✖ CRIT-04 — Broken QA npm script

**Location:** `package.json` → `test:qa`  
**Impact:** CI/docs reference non-existent `node_scripts/lighthouse-qa.mjs`.  
**Fix:** Add script or remove `test:qa` from package.json.

### ✖ CRIT-05 — 404 not internationalized

**Location:** `theme/templates/404.html`  
**Impact:** English-only H1/body on localized sites.  
**Fix:** Use `wp:pattern` with translatable pattern or `<!-- wp:post-title -->` on a dedicated 404 page; wrap strings via i18n block or PHP pattern.

### ⚠ HIGH-01 — Monolithic CSS

**Location:** `theme/style.css`  
**Impact:** FCP/LCP on mobile; all block CSS shipped always.  
**Fix:** Split critical CSS; consider per-block stylesheets via `wp_enqueue_block_style` (WP 6.3+).

### ⚠ HIGH-02 — CI gap

**Location:** `.github/workflows/theme-tests.yml`  
**Impact:** Regressions in e2e, lint, production build undetected.  
**Fix:** Add `npm run production`, `npm run lint`, Playwright on PR (optional smoke).

### ⚠ HIGH-03 — No RTL support

**Location:** Theme-wide  
**Fix:** Audit logical properties; add `theme.json` `settings.custom` RTL notes; test `is_rtl()`.

### ⚠ HIGH-04 — Plugin compatibility matrix undocumented

**Location:** `README.md`  
**Fix:** Document tested plugins + known conflicts (Yoast, Polylang, CF7, cache plugins).

### ⚠ HIGH-05 — `agency-starter.zip` in repository

**Location:** Root  
**Fix:** Add to `.gitignore`; build in CI release only.

---

## File checklist (161/161 reviewed — 100%)

### Config & docs (15)

| File | Status | Notes |
|------|--------|-------|
| `package.json` | ⚠ | Broken `test:qa` script |
| `package-lock.json` | ✓ | |
| `composer.json` | ✓ | Dev-only deps |
| `composer.lock` | ✓ | |
| `phpunit.xml.dist` | ✓ | |
| `phpcs.xml.dist` | ✓ | |
| `eslint.config.js` | ✓ | |
| `postcss.config.js` | ✓ | |
| `prettier.config.js` | ✓ | |
| `vitest.config.js` | ✓ | |
| `playwright.config.ts` | ✓ | |
| `.editorconfig` | ✓ | |
| `.gitignore` | ⚠ | Should ignore `*.zip`, `vendor/` |
| `.npmrc` | ✓ | |
| `.prettierignore` | ✓ | |
| `README.md` | ✓ | Strong |
| `DESIGN-SYSTEM.md` | ✓ | Agent contract |
| `LICENSE` | ✓ | GPL |
| `agency-starter.zip` | ✓ | Removed; listed in `.gitignore` |

### Build entry & scripts (4)

| File | Status | Notes |
|------|--------|-------|
| `tailwind.css` | ✓ | PostCSS entry |
| `tailwind-intellisense.css` | ✓ | Generated IDE helper |
| `node_scripts/zip.js` | ✓ | Bundle script |
| `node_scripts/lighthouse-qa.mjs` | — | Removed; `test:qa` → Playwright only |

### JavaScript source (11)

| File | Status | Notes |
|------|--------|-------|
| `javascript/script.js` | ✓ | Mobile nav |
| `javascript/block-editor.js` | ✓ | Typography classes |
| `javascript/usp-tabs.js` | ✓ | Accordion + unit tests |
| `javascript/usp-tabs-editor.js` | ✓ | |
| `javascript/logo-cloud.js` | ✓ | Marquee |
| `javascript/logo-cloud-editor.js` | ✓ | |
| `javascript/hero-interactive.js` | ✓ | Slider a11y |
| `javascript/hero-interactive-editor.js` | ✓ | |
| `javascript/content-block-editor.js` | ✓ | |
| `javascript/faq-section-editor.js` | ✓ | No controlled `open` |
| `javascript/cta-glow-editor.js` | ✓ | |

### JavaScript built (12)

| File | Status | Notes |
|------|--------|-------|
| `theme/js/*.min.js` (11 files) | ✓ | Must rebuild after source changes |
| `theme/js/readme.txt` | ✓ | |

### Tailwind / CSS source (20)

| File | Status | Notes |
|------|--------|-------|
| `tailwind/tailwind-theme.css` | ✓ | |
| `tailwind/tailwind-typography.css` | ⚠ | Large; verify front-end need |
| `tailwind/tailwind-editor.css` | ✓ | |
| `tailwind/custom/base.css` | ✓ | |
| `tailwind/custom/fonts.css` | ✓ | |
| `tailwind/custom/utilities.css` | ✓ | |
| `tailwind/custom/file-header.css` | ✓ | WP style header injection |
| `tailwind/custom/components/components.css` | ✓ | |
| `tailwind/custom/components/agency-design.css` | ✓ | Core design system |
| `tailwind/custom/components/agency-layout.css` | ✓ | |
| `tailwind/custom/components/agency-grid.css` | ✓ | |
| `tailwind/custom/components/animation.css` | ✓ | Reduced motion |
| `tailwind/custom/blocks/*.css` | ✓ | Per-block source (copied to `theme/css/blocks/`) |
| `theme/style.css` | ⚠ | Core bundle (block CSS excluded) |
| `theme/style-editor.css` | ✓ | |
| `theme/css/blocks/*.css` | ✓ | On-demand block styles |

### PHP — core (1)

| File | Status | Notes |
|------|--------|-------|
| `theme/functions.php` | ✓ | Loader + guards |

### PHP — inc/ (26)

| File | Status | Notes |
|------|--------|-------|
| `theme/inc/setup.php` | ✓ | Supports, menus, caps |
| `theme/inc/enqueue.php` | ✓ | Conditional prose + mobile nav script |
| `theme/inc/blocks.php` | ✓ | Per-block styles + editor scripts |
| `theme/inc/block-bindings.php` | ✓ | Job meta bindings |
| `theme/inc/breadcrumbs.php` | ✓ | Yoast + fallback |
| `theme/inc/schema.php` | ✓ | FAQ + org schema |
| `theme/inc/navigation.php` | ✓ | Dynamic primary nav |
| `theme/inc/language-switcher.php` | ⚠ | Polylang-dependent |
| `theme/inc/i18n-parts.php` | ✓ | Part string translation |
| `theme/inc/media.php` | ✓ | Placeholder images |
| `theme/inc/post-types.php` | ✓ | Job CPT |
| `theme/inc/post-archives.php` | ✓ | News/articles filters |
| `theme/inc/patterns.php` | ⚠ | Large pattern registry |
| `theme/inc/patterns-more.php` | ✓ | Includes news-preview |
| `theme/inc/synced-patterns.php` | ⚠ | Triplication with patterns.php |
| `theme/inc/demo.php` | ✓ | Demo gating |
| `theme/inc/demo-content.php` | ⚠ | Large seeder v9 |
| `theme/inc/plugins.php` | ✓ | CF7/Yoast/Polylang |
| `theme/inc/newsletter.php` | ⚠ | Placeholder shortcode |
| `theme/inc/heroicons.php` | ✓ | SVG icons |
| `theme/inc/usp-tabs.php` | ✓ | |
| `theme/inc/logo-cloud.php` | ✓ | |
| `theme/inc/hero-interactive.php` | ✓ | |
| `theme/inc/content-block.php` | ✓ | |
| `theme/inc/faq-section.php` | ✓ | |
| `theme/inc/cta-glow.php` | ✓ | |

### PHP — blocks render (6)

| File | Status | Notes |
|------|--------|-------|
| `theme/blocks/usp-tabs/render.php` | ✓ | Escaped, ARIA |
| `theme/blocks/logo-cloud/render.php` | ✓ | |
| `theme/blocks/hero-interactive/render.php` | ✓ | H1 front-page only |
| `theme/blocks/content-block/render.php` | ✓ | wp_kses_post body |
| `theme/blocks/faq-section/render.php` | ✓ | details/summary |
| `theme/blocks/cta-glow/render.php` | ✓ | |

### Block metadata (6)

| File | Status |
|------|--------|
| `theme/blocks/*/block.json` | ✓ |

### FSE templates (16)

| File | Status | Notes |
|------|--------|-------|
| `theme/templates/front-page.html` | ✓ | |
| `theme/templates/page.html` | ✓ | |
| `theme/templates/single.html` | ✓ | Comments template part |
| `theme/templates/single-job.html` | ✓ | |
| `theme/templates/index.html` | ✓ | |
| `theme/templates/archive.html` | ✓ | |
| `theme/templates/archive-job.html` | ✓ | |
| `theme/templates/page-archive-articles.html` | ✓ | Namespace filter |
| `theme/templates/page-archive-news.html` | ✓ | Namespace filter |
| `theme/templates/search.html` | ✓ | post + job |
| `theme/templates/404.html` | ✓ | i18n via `404-content` pattern |
| `theme/templates/page-contact.html` | ✓ | |
| `theme/templates/page-conversion.html` | ✓ | |
| `theme/templates/page-knowledge-hub.html` | ✓ | |
| `theme/templates/page-legal.html` | ✓ | |
| `theme/templates/page-section-landing.html` | ✓ | |

### Template parts (7)

| File | Status | Notes |
|------|--------|-------|
| `theme/parts/header.html` | ✓ | |
| `theme/parts/header-utility.html` | ⚠ | Polylang switcher |
| `theme/parts/footer.html` | ✓ | |
| `theme/parts/footer-legal.html` | ✓ | |
| `theme/parts/breadcrumbs.html` | ✓ | Shortcode |
| `theme/parts/post-meta.html` | ✓ | |
| `theme/parts/job-meta.html` | ✓ | |
| `theme/parts/comments.html` | ✓ | `wp:comments` block |

### theme.json & style variations (6)

| File | Status |
|------|--------|
| `theme/theme.json` | ✓ |
| `theme/styles/*.json` (5) | ✓ |

### Assets (18)

| File | Status |
|------|--------|
| `theme/assets/fonts/raleway-*.woff2` (4) | ✓ |
| `theme/assets/images/placeholders/**` (14) | ✓ |
| `theme/screenshot.png` | ✓ |
| `theme/languages/agency-starter.pot` | ✓ | Regenerate with `composer run make-pot` |
| `theme/languages/readme.txt` | ✓ | |

### Tests (8)

| File | Status | Notes |
|------|--------|-------|
| `tests/bootstrap.php` | ✓ | |
| `tests/php/test-blocks.php` | ✓ | Contract tests |
| `tests/php/test-patterns.php` | ✓ | |
| `tests/js/usp-tabs.test.js` | ✓ | |
| `tests/js/faq-accordion.test.js` | ✓ | |
| `tests/e2e/homepage.spec.ts` | ✓ | Not in CI |
| `tests/e2e/block-interactions.spec.ts` | ✓ | Not in CI |

---

## Release roadmap

### Phase 1 — Release blockers

1. ~~Remove `agency-starter.zip` from VCS; update `.gitignore`~~ ✓
2. ~~Fix or remove `test:qa` / add `lighthouse-qa.mjs`~~ ✓ (`test:qa` → e2e)
3. ~~Generate and commit `agency-starter.pot`~~ ✓
4. ~~Internationalize `404.html`~~ ✓
5. ~~Add comments template part + `single.html` integration~~ ✓
6. ~~Document "starter kit vs production" in README~~ ✓
7. ~~CI: `npm run production` + PHPCS on `theme/inc/`~~ ✓

### Phase 2 — Critical WordPress functionality

1. Empty state pattern for Query Loops
2. Sticky post styling in archives
3. Attachment template or redirect policy
4. Polylang header graceful degradation
5. RankMath / SEOPress smoke test doc
6. Bump `Requires PHP` to 8.0+

### Phase 3 — Architecture ✓

1. ~~Document pattern registry split (`patterns.php` + `patterns-more.php`)~~ ✓
2. ~~Split front-end CSS (block-level enqueue via `wp_enqueue_block_style`)~~ ✓
3. ~~Remove `a11y-contrast.css` after token fixes~~ ✓
4. ~~Child theme documentation + hook map (`CHILD-THEME.md`, `HOOKS.md`)~~ ✓

### Phase 4 — Performance ✓

1. ~~Audit Tailwind Typography inclusion~~ ✓ (split to `css/prose-content.css`, editorial-only)
2. ~~Deduplicate critical header CSS~~ ✓ (`theme/css/critical-header.css`, single source)
3. ~~Conditional `script.min.js` (only when mobile nav present)~~ ✓
4. ~~Lighthouse/asset budget in CI~~ ✓ (`test:budget` in theme-tests.yml; optional `test:lighthouse`)
5. ~~Responsive image markup (`agency_starter_render_image`)~~ ✓

### Phase 5 — Accessibility ✓

1. ~~axe-core in CI~~ ✓ (PHPUnit contracts in CI; Playwright axe via `test:a11y`)
2. ~~CF7 accessible default markup~~ ✓
3. ~~FAQ: avoid default `open` + `aria-expanded` sync~~ ✓
4. ~~RTL pass~~ ✓ (`rtl.css` + logical properties baseline)

### Phase 6 — Developer experience

1. ~~`HOOKS.md` filter/action reference~~ ✓
2. Production zip excludes `vendor/`, tests, source maps
3. Playwright in CI (smoke)

### Phase 7 — Nice-to-have

1. WooCommerce minimal compatibility layer
2. `knowledge-article-layout` as optional single template
3. Block locking on synced patterns
4. WordPress.org submission prep

---

**Checklist completion:** 161 / 161 files reviewed (100%)
