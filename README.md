# Agency Starter

Gutenberg block theme for B2B staffing agencies. First instance: **TimeWork**.

**Demo:** http://localhost:8889  
**Design authority:** `design-preproduction/master-design.md`  
**Agent contract:** [`DESIGN-SYSTEM.md`](DESIGN-SYSTEM.md) — read before editing patterns/CSS  
**Mantine UI sections:** https://ui.mantine.dev/ (pick section type → map to pattern)  
**Mantine primitives:** https://mantine.dev/llms.txt (spacing/tokens only, not React)  
**Roadmap:** `theme-investigation/20-theme-implementation-roadmap.md`

---

## Starter kit vs production

This theme ships as a **demo starter kit** (Step 1). Lorem ipsum copy, placeholder images, and demo pages are **intentional** until client content is imported in Step 2.

| Mode | When | What to do |
|------|------|------------|
| **Demo / local** | Evaluation, design review | Set `AGENCY_STARTER_DEMO` true in `wp-config.php` to seed pages, menus, and sample posts |
| **Production** | Client launch | Keep `AGENCY_STARTER_DEMO` **false** (default); deploy theme files only via `wp-dev push theme production --build`; replace Lorem with real content in the editor |

Never run `wp-dev push production` (full DB sync) after editing local demo content — that overwrites production. See [`WP-dev/docs/theme-deploy-for-all-users.md`](../../../../docs/theme-deploy-for-all-users.md).

**i18n:** Run `composer install && composer run make-pot` to regenerate `theme/languages/agency-starter.pot` after changing translatable strings.

---

## Design system

Component discipline: [Mantine UI](https://mantine.dev) principles (not the React package)

### Mantine → WordPress mapping

| Mantine | Agency Starter |
|---------|----------------|
| `MantineProvider` / theme object | `theme/theme.json` + `tailwind/tailwind-theme.css` |
| `Container` | `.agency-container` (75rem) / `.agency-container--narrow` (45rem) — px md→xl |
| `Stack` | `.agency-stack`, `.agency-section .agency-container` (flex column + gap) |
| `AppShell.Main` | `.agency-main` / `.agency-main__inner` |
| `Paper` withBorder | `.agency-card` — flat border, 8px radius, no shadow |
| `Button` variants | `.agency-btn--employer`, `--candidate`, `--ghost`, `--on-dark` |
| `Button` sizes sm/md/lg | `.agency-btn--sm`, `--md`, `--lg` |
| `Input` / `TextInput` | `.wpcf7` form field styles in `agency-design.css` |
| `focusRing: auto` | `:focus-visible` rings on links, buttons, inputs |
| `SimpleGrid` | `.agency-audience-grid`, `.agency-service-grid` |
| `AppShell` | `header-utility` → `site-header` → `main` → `site-footer` |

### Style variations

Five built-in appearances (inspired by [daisyUI](https://daisyui.com/docs/themes/) palettes) ship in `theme/styles/`:

| Variation | Character |
|-----------|-----------|
| **Light** | Clean white + purple primary (daisyUI `light`) |
| **Dark** | Dark surfaces + violet primary (daisyUI `dark`) |
| **Aqua** | Deep ocean blue + cyan primary (daisyUI `aqua`) |
| **Pearl** | Warm cream + olive accent (daisyUI `silk`, renamed) |
| **Ember** | Charcoal + orange primary (daisyUI `halloween`, renamed) |

**Site Editor:** Appearance → **Styles** → **Browse styles** to pick a variation. With `appearanceTools` enabled, admins can tweak colors/typography and **Save** — customizations are stored in the database as site Global Styles (revisions supported).

All variations keep the same token slugs (`primary`, `surface-alt`, …) so patterns and `.agency-*` CSS update automatically.

### Key CSS files

| File | Purpose |
|------|---------|
| `tailwind/custom/components/agency-design.css` | Semantic components (sections, cards, nav, forms) |
| `tailwind/custom/components/components.css` | Content width rules, utilities |
| `theme/theme.json` | Color, spacing, typography tokens |

---

## Development

```bash
cd WP-dev/wordpress/wp-content/themes/agency-starter
npm install
npm run dev          # build CSS + JS once
npm run watch        # watch mode
npm run bundle       # production zip
```

Rebuild after CSS changes:

```bash
docker run --rm -v "$PWD":/app -w /app node:20 npm run dev
```

### WP-CLI (local Docker)

```bash
cd WP-dev/docker
docker compose -p timework run --rm wpcli wp ... --path=/var/www/html
```

---

## Theme structure

```
agency-starter/           ← build tooling (npm, Tailwind, tests)
├── tailwind/custom/
│   ├── components/       ← core design system CSS (bundled in style.css)
│   └── blocks/           ← per-block CSS (copied to theme/css/blocks/)
├── HOOKS.md              ← filters & extension points
├── PERFORMANCE.md        ← asset loading & image strategy
├── READINESS-SCORECARD.md ← production vs demo readiness scores
├── CHILD-THEME.md        ← child theme guide
└── theme/                ← WordPress-installable theme
    ├── css/blocks/       ← block CSS (loaded on demand)
    ├── inc/
    │   ├── patterns.php  ← core patterns
    │   └── patterns-more.php ← extended patterns
    └── templates/
```

After CSS changes: `npm run production` (bundles `style.css` + copies block CSS).

---

## Plugins (Step 1 stack)

| Plugin | Role | Theme integration |
|--------|------|-------------------|
| **Contact Form 7** | Forms | `.wpcf7` styles; demo forms seeded when `AGENCY_STARTER_DEMO` |
| **Yoast SEO** | Meta + schema | Breadcrumbs, Organization schema, JobPosting gate |
| **Polylang** | DA + EN | Language switcher in utility bar; hidden when inactive or single language |
| **WP Fastest Cache** | Page cache | No theme hooks required; purge after theme deploy |
| **Limit Login Attempts Reloaded** | Security | No theme integration |

**Not integrated:** WooCommerce, WPML, Rank Math / SEOPress (Yoast-first; others untested).

---

## Step 1 / Step 2 gate

**Step 1:** Lorem ipsum + placeholder images only. Stakeholder sign-off required.  
**Step 2:** Import scraped content from `knowledge-base/` — do not start until Step 1 is approved.
