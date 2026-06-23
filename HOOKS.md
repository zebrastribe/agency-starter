# Hooks & Filters — Agency Starter

Extension points for child themes and plugins. All hooks use the `agency_starter_` prefix.

## Filters

| Hook | Location | Default | Purpose |
|------|----------|---------|---------|
| `agency_starter_menus` | `inc/setup.php` | Primary + 4 footer locations | Add/rename nav menu locations |
| `agency_starter_job_archive_slug` | `inc/post-types.php` | `kandidater/it-jobs` | Job CPT archive URL slug |
| `agency_starter_pattern_categories` | `inc/patterns.php` | Corporate pattern cats | Register pattern categories |
| `agency_starter_organization_same_as` | `inc/schema.php` | `[]` | Yoast Organization `sameAs` URLs |
| `agency_starter_needs_prose_styles` | `inc/performance.php` | Editorial templates | Load Tailwind Typography CSS |
| `agency_starter_theme_uses_mobile_nav` | `inc/performance.php` | Header has toggle | Load mobile nav script |

## Actions

The theme does not expose custom actions yet. Prefer the filters above or standard WordPress hooks (`after_setup_theme`, `init`, `wp_enqueue_scripts`).

## Block query namespaces

Query Loop blocks can filter post archives by category:

| Namespace | Category slug |
|-----------|---------------|
| `agency-starter/news` | `nyhed` |
| `agency-starter/articles` | `artikel` |

Set in the block’s query settings or use the archive page templates.

## Demo mode

| Constant | Default | Effect |
|----------|---------|--------|
| `AGENCY_STARTER_DEMO` | `false` | When `true`, seeds demo pages, menus, CF7 forms, and Polylang languages |

Define in `wp-config.php` for local/staging only.

## Child theme

See [CHILD-THEME.md](./CHILD-THEME.md).
