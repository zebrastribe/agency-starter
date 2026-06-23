# Performance — Agency Starter

Structural performance choices for the theme shell. Demo Lorem content and placeholder SVGs remain intentional until real content import (Step 2).

## Asset loading

| Asset | When it loads |
|-------|----------------|
| `style.css` | Every front-end view |
| `css/prose-content.css` | Editorial views only (`single`, `single-job`, `page-legal`) — see `agency_starter_needs_prose_styles()` |
| `css/blocks/*.css` | When matching custom block is on the page (`wp_enqueue_block_style`) |
| `js/script.min.js` | When header template part includes `.mobile-nav-toggle` |
| `css/critical-header.css` | Inlined in `wp_head` (single source; decorative header rules stay in `agency-design.css`) |

## Responsive images

Custom blocks and patterns use `agency_starter_render_image()` in `inc/media.php`:

- **Media library attachments** → `wp_get_attachment_image()` with `srcset`, `sizes`, `loading`, `decoding`
- **Placeholder / external URLs** → explicit `width` / `height` / `sizes` for layout stability

Registered image sizes: `hero` (1920), `card` (800), `logo` (300).

## Tailwind Typography

`.prose` is **not** in the main `style.css` bundle. It builds to `css/prose-content.css` and loads only where templates add prose classes to `post-content`.

Marketing pages (homepage, section landings) built from patterns skip prose entirely.

## CI budgets

```bash
npm run production   # builds style.css + prose-content.css + block CSS
npm run test:budget  # static file size checks (runs in GitHub Actions)
```

Optional Lighthouse (requires running site):

```bash
WP_BASE_URL=http://localhost:8894 npm run test:lighthouse
```

Adjust thresholds with `LH_MIN_SCORE` and `LH_MAX_LCP_MS`.

## Hooks

| Filter | Purpose |
|--------|---------|
| `agency_starter_needs_prose_styles` | Force prose CSS on/off |
| `agency_starter_theme_uses_mobile_nav` | Force mobile nav script on/off |

See [HOOKS.md](./HOOKS.md).

## After CSS changes

```bash
npm run production
```

Hard refresh the browser. Demo placeholder images are SVG — they will not generate WordPress `srcset` until replaced with media library uploads.
