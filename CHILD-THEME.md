# Child Theme Guide — Agency Starter

Agency Starter is a **block theme** (Full Site Editing). Child themes work the standard WordPress way.

## Quick start

1. Create `wp-content/themes/agency-starter-child/style.css`:

```css
/*
Theme Name: Agency Starter Child
Template: agency-starter
Text Domain: agency-starter-child
*/
```

2. Create `functions.php`:

```php
<?php
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'agency-starter-child',
		get_stylesheet_uri(),
		array( 'agency-starter-style' ),
		wp_get_theme()->get( 'Version' )
	);
}, 20 );
```

3. Activate **Agency Starter Child** in Appearance → Themes.

## What to override

| Goal | Approach |
|------|----------|
| Extra CSS | Child `style.css` or enqueue a custom stylesheet |
| Template changes | Copy templates from parent `theme/templates/` into child `templates/` |
| Template parts | Copy from parent `theme/parts/` into child `parts/` |
| Patterns | Register new patterns in child `functions.php` with `register_block_pattern()` |
| Hooks | Use filters in [HOOKS.md](./HOOKS.md) — no need to copy parent PHP |
| `theme.json` | Add child `theme.json` to extend/override design tokens |

## Do not copy

- The entire parent theme into the child (use `Template:` header instead)
- Built assets from parent (`style.css`, `theme/js/*.min.js`) — rebuild in parent project root if modifying source

## Block styles

Custom block CSS loads per-block from `theme/css/blocks/` via `wp_enqueue_block_style`. Override in child by dequeuing the parent handle and enqueuing your own, or add CSS in the child theme stylesheet with higher specificity.

## Parent build pipeline

CSS/JS changes to Agency Starter require running `npm run production` in the **parent** theme directory (`agency-starter/`), then deploying with `wp-dev push theme production --build`.
