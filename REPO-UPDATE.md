# Repo Update (GitHub theme updates)

This theme works with [Repo Update](https://github.com/zebrastribe/repo-update) via the **`deploy`** branch.

## Why two branches?

| Branch | Contents |
|--------|----------|
| `main` | Full _tw source (Tailwind, esbuild, tests) |
| `deploy` | Built theme only (`style.css`, `functions.php`, … at repo root) |

WordPress installs the theme at `wp-content/themes/agency-starter/theme/` (slug **`agency-starter/theme`**). The `deploy` branch zip matches that folder so native updates replace the right files.

## Plugin setup

1. Install and activate **Repo Update**
2. **Repo Update → Repositories → Add**
3. Owner: `zebrastribe`
4. Repository: `agency-starter`
5. Branch: **`deploy`**
6. Type: **Theme**
7. Target: **Agency Starter** (`agency-starter/theme`)
8. Test connection → Save

## Release a new version

1. Bump `Version` in `theme/style.css` (and rebuild if needed)
2. Push to `main` — CI refreshes `deploy`
3. In wp-admin: **Repo Update → Check now**, then update under **Appearance → Themes**
