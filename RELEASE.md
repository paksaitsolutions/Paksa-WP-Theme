# Nexus Business Theme — Release Procedure

> **Read this before every release.**
> This document is the authoritative release checklist.

---

## Release Model

```
Developer
    ↓
Modify theme code
    ↓
Bump version in style.css + functions.php
    ↓
Git commit + push to main
    ↓
Git tag  (e.g. v1.2.0)
    ↓
Push tag to GitHub
    ↓
GitHub Actions: validate → build ZIP → create Release
    ↓
WordPress sites detect update via Dashboard → Updates
    ↓
Administrator clicks Update
    ↓
Theme code replaced — database untouched
```

---

## Version Authority

The **single authoritative version source** is `style.css`:

```css
 * Version: 1.1.0
```

`functions.php` defines `PAKSA_THEME_VERSION` which must match:

```php
define('PAKSA_THEME_VERSION', '1.1.0');
```

The Git tag must also match (with a `v` prefix):

```
v1.1.0
```

The GitHub Actions workflow validates all three agree before building the release.
If they disagree, the workflow fails and no release is created.

---

## Pre-Release Checklist

Before creating a tag, verify every item:

```
[ ] All code changes committed and pushed to main
[ ] style.css Version: updated to new version number
[ ] functions.php PAKSA_THEME_VERSION constant updated to match
[ ] No SMTP credentials, API keys, or secrets in any file
[ ] No wp-config.php, database dumps, or .env files committed
[ ] No client-specific content committed (products JSON, Customizer exports, etc.)
[ ] PHP syntax valid (run: find paksa-it-solutions -name '*.php' -exec php -l {} \;)
[ ] Git working tree is clean (git status shows nothing to commit)
[ ] SNAPSHOT.md updated if architecture changed
[ ] Changelog prepared (will appear in GitHub Release body)
```

---

## Step-by-Step Release

### 1. Update version numbers

Edit `paksa-it-solutions/style.css`:
```css
 * Version: 1.2.0
```

Edit `paksa-it-solutions/functions.php`:
```php
define('PAKSA_THEME_VERSION', '1.2.0');
```

### 2. Commit

```bash
git add paksa-it-solutions/style.css paksa-it-solutions/functions.php
git commit -m "Bump version to 1.2.0"
git push origin main
```

### 3. Tag

```bash
git tag v1.2.0
git push origin v1.2.0
```

That's it. GitHub Actions takes over from here.

### 4. Monitor the workflow

Go to: `https://github.com/paksaitsolutions/Paksa-WP-Theme/actions`

The workflow will:
1. Validate version consistency (tag = style.css = functions.php)
2. Validate required files exist
3. Run PHP syntax check on all `.php` files
4. Run secret scan
5. Build `paksa-it-solutions-theme.zip`
6. Validate ZIP structure
7. Create GitHub Release with ZIP attached

If any step fails, the release is not created. Fix the issue, delete the tag, and re-tag.

### 5. Verify the release

Go to: `https://github.com/paksaitsolutions/Paksa-WP-Theme/releases`

Confirm:
- Release named `Nexus Business Theme 1.2.0` exists
- `paksa-it-solutions-theme.zip` is attached as a release asset
- Release is not marked as draft or pre-release

---

## If the Workflow Fails

### Version mismatch
```
Error: Version mismatch — tag is 1.2.0 but style.css says 1.1.0
```
Fix: Update `style.css` and `functions.php`, commit, delete the tag, re-tag.

```bash
git tag -d v1.2.0
git push origin :refs/tags/v1.2.0
# fix files, commit
git tag v1.2.0
git push origin v1.2.0
```

### PHP syntax error
```
Error: PHP syntax error in paksa-it-solutions/inc/some-file.php
```
Fix: Correct the syntax error, commit, delete tag, re-tag.

### Secret scan warning
```
Error: Secret scan found potential credentials.
```
Fix: Remove the credential from the file. If it was committed to history, rotate the credential immediately. Use GitHub Actions Secrets for any CI credentials.

---

## WordPress Update Discovery

Once a release exists on GitHub:

1. WordPress checks for updates periodically (every 12 hours by default)
2. The theme's `inc/updater.php` queries `api.github.com/repos/paksaitsolutions/Paksa-WP-Theme/releases/latest`
3. If the latest release version is newer than the installed version, WordPress shows an update notification
4. The administrator goes to **Dashboard → Updates** and clicks **Update**
5. WordPress downloads `paksa-it-solutions-theme.zip` from the GitHub Release
6. WordPress installs the ZIP into `wp-content/themes/paksa-it-solutions/`
7. Theme code is replaced — database is untouched

To force WordPress to check immediately: **Dashboard → Updates → Check Again**

---

## ZIP Structure

The release ZIP has this structure:

```
paksa-it-solutions-theme.zip
└── paksa-it-solutions/
    ├── style.css
    ├── functions.php
    ├── index.php
    ├── theme.json
    ├── front-page.php
    ├── header.php
    ├── footer.php
    ├── inc/
    │   ├── updater.php
    │   └── ...
    ├── assets/
    ├── template-parts/
    └── ...
```

The ZIP does NOT contain:
- `.git/` or `.github/`
- `.gitignore`
- `.kilo/` or `.kilocode/`
- `*.zip` files
- `node_modules/` or `vendor/`
- Any client data, database dumps, or credentials

---

## Database Safety Guarantee

A theme update replaces only files in `wp-content/themes/paksa-it-solutions/`.

The following are **never touched** by a theme update:

| Data | Location |
|---|---|
| Customizer settings | `wp_options` (theme mods) |
| Products | `wp_posts` (post_type = paksa_product) |
| Services | `wp_posts` (post_type = paksa_service) |
| Product/service meta | `wp_postmeta` |
| Categories | `wp_terms` + `wp_term_taxonomy` |
| Navigation menus | `wp_posts` (post_type = nav_menu_item) |
| Menu assignments | `wp_term_relationships` |
| Pages | `wp_posts` (post_type = page) |
| Media | `wp_posts` (post_type = attachment) + uploads/ |

The theme contains zero `update_option()`, `wp_insert_post()`, or `wp_delete_post()` calls
outside of user-triggered save handlers. The only activation hook calls `flush_rewrite_rules()`.

---

## Branch Strategy

```
main
 ├── All development
 └── Tags trigger releases
```

No separate `develop` or `release` branches are required at this project scale.
If the team grows, a `develop` → `main` PR model can be adopted without changing
the release mechanism (tags on `main` still trigger the workflow).

---

## Semantic Versioning

Use [Semantic Versioning](https://semver.org/):

| Change | Version bump | Example |
|---|---|---|
| Bug fixes, minor improvements | Patch | 1.1.0 → 1.1.1 |
| New features, backward-compatible | Minor | 1.1.0 → 1.2.0 |
| Breaking changes (rare) | Major | 1.1.0 → 2.0.0 |

Breaking changes in a WordPress theme context means changes that would require
administrator action after update (e.g. renamed Customizer keys, changed CPT slugs).
These should be avoided. If unavoidable, document the migration steps in the release notes.

---

## Required Live Test (Before First Production Release)

Perform this test on a staging WordPress installation before the first production release:

1. Install `Nexus Business Theme v1.1.0` (current version)
2. Create products, services, pages, menus, and Customizer settings
3. Publish `v1.2.0` release on GitHub (or use a test tag)
4. Go to **Dashboard → Updates → Check Again**
5. Verify WordPress shows "Nexus Business Theme 1.2.0 available"
6. Click **Update**
7. Verify theme version shows 1.2.0 in **Appearance → Themes**
8. Verify all products, services, pages, menus, and Customizer settings are intact
9. Verify frontend renders correctly on all page types

This test has not been performed yet (no WordPress runtime available in development).
It must be completed before relying on the update mechanism in production.
