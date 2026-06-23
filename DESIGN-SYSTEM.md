# Agency Starter Design System

**Agent contract:** Read this file before editing theme CSS, patterns, templates, or `theme.json`.  
**Brand values:** `design-preproduction/master-design.md`  
**Mantine UI catalog (page sections):** https://ui.mantine.dev/ — pick a section type before building  
**Mantine primitives (spacing/tokens):** https://mantine.dev/llms.txt — never add `@mantine/core` or React

---

## Two Mantine sources (do not confuse)

| Source | What it is | How we use it |
|--------|------------|---------------|
| **[Mantine UI](https://ui.mantine.dev/)** | 123 pre-built **page sections** (Hero headers, Stats grid, Contact us, Footers…) | **Pick the section type first**, then implement with an Agency pattern below |
| **[Mantine core](https://mantine.dev/llms.txt)** | React primitives (`Container`, `Stack`, `Button`, `Paper`) | Translate to `.agency-container`, `.agency-card`, `.agency-btn--*` in CSS |

**Workflow for any new section:**  
1. Browse [ui.mantine.dev](https://ui.mantine.dev/) → find closest section (e.g. “Stats grid”, “Get in touch form”)  
2. Map to an existing pattern slug (table below) or extend the pattern library  
3. Implement with `.agency-section` → `.agency-container` skeleton — **never invent layout from scratch**

---

## Authority order (conflicts)

1. `design-preproduction/master-design.md` — hex, fonts, section rhythm  
2. `theme/theme.json` — WordPress tokens (must mirror master-design)  
3. **This file** — components, composition, do/don’t  
4. `theme/inc/patterns*.php` — page building blocks  
5. `theme/templates/*.html` — shell only; no one-off styles  

If a value is not in 1–3, **do not invent it**.

---

## Mantine → WordPress mapping

| Mantine | Use in theme | Never use |
|---------|--------------|-----------|
| `MantineProvider` / theme | `theme.json` + CSS variables | React provider |
| `Container` | `.agency-container` (75rem) | `layout: constrained` on containers |
| `Container size="sm"` | `.agency-container--narrow` (45rem) | `max-width` inline styles |
| `Stack` | `.agency-section .agency-container` (flex column + gap) | Random `margin-top` on blocks |
| `SimpleGrid` | `.agency-audience-grid`, `.agency-service-grid`, `agency-grid.css` | `flex-basis: 55%`, raw columns |
| `Paper` | `.agency-card` | `box-shadow`, glassmorphism |
| `Button` | `.agency-btn--employer` / `--candidate` / `--ghost` / `--on-dark` | Tailwind `bg-primary` in patterns |
| `AppShell` | `.site-header-shell` → `.agency-main` → `.site-footer` | Nested `<header>` tags |
| `TextInput` | `.wpcf7` styles in `agency-design.css` | Unstyled form HTML |

When unsure how Mantine handles spacing or layout, check [Mantine docs](https://mantine.dev/llms.txt) and **translate** to the WordPress class above — do not import the React package.

---

## Mantine UI → Agency Starter pattern map

Reference: [Mantine UI categories](https://ui.mantine.dev/). Use these slugs in `<!-- wp:pattern {"slug":"…"} /-->`.

### Application UI

| [Mantine UI category](https://ui.mantine.dev/) | Mantine UI examples | Agency pattern | Status |
|------------------------------------------------|---------------------|----------------|--------|
| [Headers](https://ui.mantine.dev/category/headers/) | Simple header, Header with menus | `site-header` + `header-utility` parts | ✅ |
| [Navbars](https://ui.mantine.dev/category/navbars/) | Simple navbar | `.primary-nav` + mobile panel | ✅ |
| [Footers](https://ui.mantine.dev/category/footers/) | Footer with links | `footer` + `footer-legal` parts | ✅ |
| [Stats](https://ui.mantine.dev/category/stats/) | Stats grid, Grouped stats | `statistics-row` (synced) | ✅ |
| [Grids](https://ui.mantine.dev/category/grids/) | Grid with leading item | `service-grid`, `feature-grid` | ✅ |
| [Application cards](https://ui.mantine.dev/category/cards/) | — | `agency-card` + service/audience patterns | ✅ |
| [Buttons](https://ui.mantine.dev/category/buttons/) | — | `.agency-btn--*` | ✅ |
| [Inputs](https://ui.mantine.dev/category/inputs/) | — | `.wpcf7` form styles | ✅ |
| [Tables](https://ui.mantine.dev/category/tables/) | — | — | ⬜ defer |
| [Carousels](https://ui.mantine.dev/category/carousels/) | — | **Do not use** (design brief) | 🚫 |

### Page sections

| [Mantine UI category](https://ui.mantine.dev/) | Mantine UI examples | Agency pattern | Status |
|------------------------------------------------|---------------------|----------------|--------|
| [Hero headers](https://ui.mantine.dev/category/hero/) | Hero with content on left, Hero with bullets | `hero-homepage`, `hero-section`, `hero-minimal`, `hero-service`, block `hero-interactive` | ✅ |
| [Features section](https://ui.mantine.dev/category/features/) | Features with cards, Features with icons | `service-grid`, `feature-grid`, `audience-split`, block `content-block` | ✅ |
| [Contact us](https://ui.mantine.dev/category/contact/) | Get in touch form, Contact us form | `contact-details`, `contact-form-section`, `team-contact-cards`, `location-card` | ✅ |
| [FAQ](https://ui.mantine.dev/category/faq/) | FAQ simple, Faq with image | `faq-section`, block `faq-section` | ✅ |
| [Banners](https://ui.mantine.dev/category/banners/) | Email banner | `newsletter-signup` (synced), block `cta-glow` | ✅ |
| [Authentication](https://ui.mantine.dev/category/authentication/) | — | — | ⬜ N/A |
| [Error pages](https://ui.mantine.dev/category/error/) | — | `404.html` template | ✅ basic |

### Blog UI

| [Mantine UI category](https://ui.mantine.dev/) | Mantine UI examples | Agency pattern | Status |
|------------------------------------------------|---------------------|----------------|--------|
| [Article cards](https://ui.mantine.dev/category/article-cards/) | Articles cards grid, Article card with image | `post-card`, `blog-preview` | ✅ |
| [Table of contents](https://ui.mantine.dev/category/toc/) | — | `anchor-nav`, `knowledge-article-layout` | ✅ |
| [Comments](https://ui.mantine.dev/category/comments/) | — | — | ⬜ defer |

### Agency-specific (custom blocks — no Mantine UI equivalent)

| Business need | Agency pattern |
|---------------|----------------|
| Logo trust band | `logo-cloud` |
| Interactive split hero | block `hero-interactive` (optional `100vh`, accordion + image slider) |
| Dark conversion CTA | `contact-cta-band` (synced) |
| Trust quote | `trust-statement`, `testimonial-excerpt` (synced) |
| Dual audience routing | `audience-split` |
| Job listing card | `job-card` in Query Loop |
| Process / timeline | `process-steps`, `timeline` |

### Homepage composition (Mantine UI order)

Maps to [Mantine UI page sections](https://ui.mantine.dev/) stacked vertically:

```
hero-homepage          → Hero with content on left
statistics-row         → Stats grid
logo-cloud             → (trust logos)
audience-split         → Features with cards (2-col)
trust-statement        → (editorial quote)
testimonial-excerpt    → (social proof)
blog-preview           → Articles cards grid
newsletter-signup      → Email banner
contact-cta-band       → Banner with action (dark)
```

### Contact page composition

```
hero-minimal           → Hero section with text
contact-details        → Contact information (2-col cards)
location-card          → Office card
team-contact-cards     → Team cards grid (synced)
contact-form-section   → Get in touch form
```

---

## Page shells

### Marketing / landing (`front-page`, `page-section-landing`, `page-contact`)

```html
<main class="agency-main">
  <!-- wp:post-content layout default -->
  <!-- Only alignfull .agency-section blocks inside -->
</main>
```

Each section = one pattern:

```
alignfull .agency-section [modifiers]
  └── .agency-container [.agency-container--narrow]
        └── content (Stack gap applied automatically)
```

### Prose (`page`, `single`, `page-legal`)

```html
<main class="agency-main">
  <div class="agency-container agency-container--narrow agency-main__inner">
    breadcrumbs → title → post-content
  </div>
</main>
```

### Archive with hero (`archive-job`, `page-archive-*`)

```html
<main class="agency-main">
  <!-- wp:pattern hero-minimal (alignfull — NOT inside container) -->
  <div class="alignfull agency-section agency-section--alt">
    <div class="agency-container">
      query / grid
    </div>
  </div>
</main>
```

**Never** put `alignfull` hero patterns inside `.agency-container`.

---

## Section modifiers

| Class | When |
|-------|------|
| `.agency-section` | Default white section, `padding-block: 4xl` |
| `.agency-section--alt` | `#F9F9F9` background |
| `.agency-section--dark` | `#111827` CTA bands |
| `.agency-section--compact` | Reduced vertical padding |
| `.agency-hero` | Homepage / landing hero (white, large type) |

Section rhythm: white → alt → white → dark CTA → alt footer.

---

## Closed component set

### `.agency-card` (Mantine Paper)

```html
<div class="agency-card">
  <h3 class="agency-card__title">…</h3>
  <p class="agency-card__text">…</p>
  <p class="agency-card__actions"><a href="#">…</a></p>
</div>
```

- Flat `1px` border, `8px` radius, **no shadow**  
- Padding: `var(--wp--preset--spacing--xl)`  
- Job/post archive cards **must** use `.agency-card`, not `bg-surface-alt p-lg`

### `.agency-btn--*` (Mantine Button)

| Class | Use |
|-------|-----|
| `agency-btn--employer` | Employer CTAs (`#3296D2`) |
| `agency-btn--candidate` | Candidate CTAs (`#35CDBB`) |
| `agency-btn--ghost` | Secondary / outline |
| `agency-btn--on-dark` | White button on dark bands |

### Grids

| Class | Columns |
|-------|---------|
| `.agency-audience-grid` | 2 |
| `.agency-service-grid` | 3 |
| `.agency-stat-grid` | 3 |
| `.agency-logo-cloud` | 5 → 3 → 1 |
| `.agency-cta-band` | 1fr + auto |

---

## Pattern authoring rules

1. **Outer wrapper:** `alignfull` + `.agency-section` (+ modifier)  
2. **Inner wrapper:** `.agency-container` with `"layout":{"type":"default"}` — **never `constrained`**  
3. **Semantic classes only** — no Tailwind utilities in pattern PHP (`py-2xl`, `bg-surface-alt`, `gap-xl`)  
4. **No inline** `style="flex-basis:…"` on columns  
5. **Buttons** use `.agency-btn--*` classes  
6. **New component?** Add to this file + `agency-design.css` first, then pattern  

### Valid pattern skeleton

```html
<!-- wp:group {"align":"full","className":"agency-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull agency-section">
  <!-- wp:group {"className":"agency-container","layout":{"type":"default"}} -->
  <div class="wp-block-group agency-container">
    <!-- content -->
  </div>
  <!-- /wp:group -->
</div>
<!-- /wp:group -->
```

---

## Motion (Step 1 — CSS-only)

**Spec:** `theme-investigation/21-motion-implementation.md` · `animation-investigation/`  
**Tokens:** `theme.json` → `settings.custom.motion` → `--wp--custom--motion--*`

| Class | Use | LCP safe? |
|-------|-----|-----------|
| `agency-motion-enter-subtle` | Hero H1 — transform only | Yes |
| `agency-motion-fade-in` | Lead text, CTAs | No on H1 |
| `agency-motion-slide-up` | Section intros (Step 1.5) | Context-dependent |
| `agency-motion-delay-sm` | Secondary hero elements | 100ms |
| `agency-motion-delay-md` | CTA row | 200ms |

**Step 1 rules:** No scroll listeners. No counter animations. Hero motion applied via `theme/inc/motion.php` at render (or classes in pattern markup).

**Step 1.5 (gated):** Block editor Animation panel + Interactivity API on-view — only after Lighthouse Performance ≥ 95. See `theme-investigation/20-theme-implementation-roadmap.md`.

---

## Anti-patterns (reject in PR)

- Purple gradients, Inter/Roboto as brand font  
- Tailwind utility classes in `patterns*.php`  
- `layout: constrained` on `.agency-container`  
- Hero inside `.agency-main__inner` container  
- Custom colors as inline hex — use `theme.json` presets  
- Shadows on cards  
- Carousels, parallax, statistic counter JS  
- Scroll-triggered animation at Step 1 (CSS immediate only)  
- `opacity: 0` on hero H1 (breaks LCP)  
- `@mantine/core`, Emotion, or front-end React  

---

## Files to edit

| Task | File |
|------|------|
| Color / font hex | `design-preproduction/master-design.md` → sync `theme.json` |
| Spacing / layout tokens | `theme.json` + `agency-layout.css` |
| Component look | `tailwind/custom/components/agency-design.css` |
| Motion / animation | `tailwind/custom/components/animation.css` + `theme/inc/motion.php` |
| Grid behaviour | `tailwind/custom/components/agency-grid.css` |
| New section pattern | `theme/inc/patterns.php` or `patterns-more.php` |
| Global CTA/stats | `theme/inc/synced-patterns.php` |
| Page template shell | `theme/templates/*.html` |
| Demo page content | `theme/inc/demo-content.php` |

After CSS changes: `npm run dev` in theme directory.

---

## AI framework guidance

**Best stack for AI-followable UI on this project:**

| Layer | Tool | Why |
|-------|------|-----|
| **Section catalog** | [ui.mantine.dev](https://ui.mantine.dev/) | Names and structures for real page sections (Hero, Stats grid, Contact form…) |
| **Primitives** | [mantine.dev/llms.txt](https://mantine.dev/llms.txt) | Spacing, Container, Stack, Button token rules |
| **Contract** | This file | Mantine UI → Agency pattern map + do/don’t |
| **Tokens** | `theme.json` | Executable color/spacing values |
| **Enforcement** | `.cursor/rules/agency-design-system.mdc` | Cursor reads before edits |

**Do not** import Mantine React — translate [Mantine UI](https://ui.mantine.dev/) section **layouts** into Gutenberg patterns using `.agency-*` classes.

**If a Mantine UI section has no pattern yet:** add a row to the map above, implement the pattern, then use it — do not freestyle HTML/CSS.
