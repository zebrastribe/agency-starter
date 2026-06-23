# Readiness Scorecard — Agency Starter v0.1.0

**Updated:** 2026-06-17 (after Phases 1–5)  
**Context:** Theme **shell and architecture** are production-oriented; **demo Lorem content** is intentional until Step 2 content import.

## How to read scores

| Score | Meaning |
|------:|---------|
| **90–100** | Ship-ready for enterprise client deploy |
| **75–89** | Solid starter — minor gaps documented |
| **60–74** | Usable with caveats |
| **&lt; 60** | Blocker or major gap for that area |

**Demo content** (Lorem, placeholder SVGs, demo CF7 titles) does **not** reduce structural scores — it is flagged separately under *Content readiness*.

---

## Executive summary

| Dimension | Score | Grade | Notes |
|-----------|------:|-------|-------|
| **Overall theme health** | **82** | B | Phases 1–5 complete; strong FSE starter |
| **Production shell readiness** | **86** | B+ | Architecture, CI, a11y contracts in place |
| **Content / client launch readiness** | **42** | F | Demo Lorem — Step 2 import required |
| **WordPress compliance** | **84** | B | Block theme, patterns, CPT, i18n baseline |
| **Gutenberg / custom blocks** | **88** | B+ | 6 blocks, bindings, per-block assets |
| **Performance structure** | **85** | B | Split CSS/JS, budgets, responsive images |
| **Accessibility structure** | **86** | B | Skip link, ARIA, axe contracts, CF7 labels |
| **Security** | **82** | B | Escaping, gated demo seeders |
| **Developer experience** | **88** | B+ | HOOKS, PERFORMANCE, CI, tests |
| **Plugin compatibility** | **78** | C+ | CF7/Yoast/Polylang documented; not exhaustive |

**Verdict:** Ready to deploy as a **controlled agency starter** with demo content. **Not** ready for public Theme Directory or “flip switch” client launch without content import and client-specific QA.

---

## Element scorecard (most important areas)

| Element | Score | Status | What’s in place | Remaining gap (demo-aware) |
|---------|------:|--------|-----------------|---------------------------|
| **FSE template hierarchy** | 92 | ✓ | Front page, singles, archives, jobs, 404, legal/contact templates | Native category/tag/author templates optional |
| **Header + navigation** | 88 | ✓ | Sticky shell, critical CSS, Polylang fallback, primary nav | Client menu/content still demo |
| **Mobile navigation** | 90 | ✓ | Dialog semantics, focus trap, Escape, conditional JS | Manual RTL QA on real RTL locale |
| **Custom blocks (6)** | 88 | ✓ | block.json, render.php, editor JS, on-demand CSS | Demo copy in defaults |
| **USP Tabs** | 90 | ✓ | ARIA tabs, animation, media position, responsive images | Placeholder images until media import |
| **Interactive Hero** | 86 | ✓ | Split layout, slider, responsive images | Demo quotes / Lorem |
| **FAQ section** | 91 | ✓ | Collapsed by default, `aria-expanded` sync, FAQ schema | Demo Q&A text |
| **News / articles** | 85 | ✓ | Category filters, archive templates, empty states | Demo posts only |
| **Job CPT + archive** | 84 | ✓ | Single/archive templates, meta bindings | Demo jobs |
| **Forms (CF7)** | 87 | ✓ | Accessible demo markup (`label`/`for`, autocomplete, ids) | Lorem labels; re-seed or update forms on existing installs |
| **Newsletter** | 55 | ⚠ | Placeholder pattern + shortcode hook | Provider integration (Step 2+) |
| **i18n** | 80 | ✓ | Text domain, `.pot`, 404 pattern, Polylang demo | Full translation files client-specific |
| **RTL** | 72 | ◐ | `rtl.css` + logical props in critical header | Full mirror QA not automated |
| **Images / media** | 86 | ✓ | `agency_starter_render_image()`, sizes, lazy loading | SVG placeholders lack `srcset` until uploads |
| **Performance budgets** | 88 | ✓ | CI asset budgets, split bundles, optional Lighthouse | Live Lighthouse needs running WP |
| **Accessibility CI** | 85 | ✓ | PHPUnit a11y contracts; Playwright + axe locally/optional | axe e2e not in default CI (no WP service) |
| **Comments** | 78 | ✓ | Template part + single integration | Low priority for marketing sites |
| **SEO / schema** | 82 | ✓ | FAQ schema, org schema filter, breadcrumbs | Yoast-first; RankMath smoke optional |
| **Security** | 82 | ✓ | ABSPATH, escaping, demo gates | Standard WP hardening still ops responsibility |
| **CI / build** | 90 | ✓ | production build, PHPUnit, PHPCS, Vitest, budgets, a11y contracts | Playwright e2e in CI needs WP container |
| **Documentation** | 90 | ✓ | README, HOOKS, CHILD-THEME, PERFORMANCE, DESIGN-SYSTEM, this scorecard | Deploy runbook lives in WP-dev docs |
| **Demo vs production content** | 40 | ✖ | `AGENCY_STARTER_DEMO` gated | **All copy/images/forms are Lorem** — Step 2 |

---

## Phase completion tracker

| Phase | Focus | Status |
|-------|--------|--------|
| 1 | Blockers (comments, i18n, CI) | ✓ Complete |
| 2 | WordPress functionality | ✓ Complete |
| 3 | Architecture (CSS split, hooks docs) | ✓ Complete |
| 4 | Performance structure | ✓ Complete |
| 5 | Accessibility structure | ✓ Complete |
| 6 | DX (zip hygiene, e2e CI) | ◐ Partial |
| 7 | Nice-to-have (WooCommerce, WP.org) | ◐ Backlog |

---

## Pre-client-launch checklist (Step 2+)

1. Replace demo content (pages, menus, patterns, media library).
2. Re-seed or hand-edit CF7 forms with client copy (structure already accessible).
3. Connect newsletter provider (replace placeholder shortcode).
4. Run `WP_BASE_URL=… npm run test:a11y` on staging.
5. Run `npm run test:lighthouse` on staging.
6. Client plugin stack smoke test (Yoast/RankMath, cache, Polylang if used).
7. `wp-dev push theme production --build` per [theme deploy doc](../../docs/theme-deploy-for-all-users.md).

---

## Quick test commands

```bash
npm run production
npm run test              # Vitest + PHPUnit + asset budgets
phpunit --filter A11y     # Accessibility contracts only
WP_BASE_URL=http://localhost:8894 npm run test:a11y   # axe + Playwright (local WP)
```
