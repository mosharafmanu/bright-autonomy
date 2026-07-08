# Bright Autonomy Rebuild — AI Handoff

Last updated: 2026-07-08

This theme is the working base for the Bright Autonomy rebuild. The rest of the WordPress install was cleaned so the rebuild can start from a controlled ACF theme foundation while preserving URLs, SEO records, and the reservation system.

## Project Goal

Rebuild `bright-autonomy.com` from the client Adobe XD design using this custom ACF-based theme.

Primary requirements:

- Keep existing public URLs so Google rankings are not lost.
- Keep All in One SEO data.
- Keep the "Reserve Your Place in Line" functionality and existing reservation data.
- Do not use Elementor.
- Build pages with ACF Flexible Content layouts and PHP section templates.

## Preserved URLs

These pages/slugs were intentionally kept:

| Page ID | Title | URL |
| --- | --- | --- |
| 15 | Home | `/` |
| 17 | Features | `/features/` |
| 19 | Knowledge Center | `/knowledge-center/` |
| 21 | About | `/about/` |
| 23 | Reserve My Place in Line | `/reserve-my-place-in-line/` |

The page content was cleared, but the page records, slugs, and SEO rows were preserved.

## Current Theme

Active rebuild theme:

`wp-content/themes/bright-autonomy`

Theme architecture:

- ACF Flexible Content field: `cms`
- Section templates: `template-parts/sections/{layout_name}.php`
- ACF JSON: `acf-json/`
- Main docs: `.ai/ACF-PATTERNS.md`, `.ai/THEME-ARCHITECTURE.md`

Before building sections, sync the ACF JSON in WP Admin:

`Custom Fields > Sync`

## What Was Removed

Old build cleanup completed:

- Deleted old `bright` theme.
- Removed Elementor and Elementor Pro.
- Removed Elementor page/library/meta/options/uploads.
- Removed old ACF field groups.
- Removed old header/footer/menu/theme-mod/widget data.
- Cleared old page body content and revisions.
- Removed UpdraftPlus and old backups.
- Deactivated WP Super Cache.

Detailed cleanup history is in:

`.ai/rebuild-audit.md`

## SEO Preservation

All in One SEO was preserved.

Preserved SEO storage:

- `_aioseo_*` post meta
- `wp_aioseo_posts` rows for the five public pages

Important launch notes:

- Keep the same page slugs.
- Add 301 redirects if any URL must change.
- Verify canonicals, titles, descriptions, sitemap, robots, and `blog_public` before production launch.

## Reservation System

The reservation backend was moved out of the old theme into a site-specific plugin:

`wp-content/plugins/bright-reservations/bright-reservations.php`

If the WordPress install is deleted and only this theme is kept, do **not** lose that plugin logic. Recreate it from `.ai/RESERVATION-SYSTEM.md` or move the plugin into the next WordPress install.

Current reservation DB tables:

- `wp_reserve`
- `wp_machines`

Known local counts at cleanup time:

- `wp_reserve`: 82 rows
- `wp_machines`: 180 rows

The new theme must rebuild the reservation form UI and submit to the preserved AJAX actions documented in `.ai/RESERVATION-SYSTEM.md`.

## Next Build Steps

1. Add the XD design assets/screens to the workspace.
2. Sync ACF JSON in WP Admin.
3. Update design tokens in `style.css`.
4. Update fonts in `functions.php`.
5. Define project image sizes in `inc/image-sizes.php`.
6. Build ACF layouts for each XD section.
7. Create matching templates in `template-parts/sections/`.
8. Rebuild the five preserved pages using ACF layouts.
9. Rebuild header/footer fields and menus.
10. Rebuild reservation form UI using the Bright Reservations backend.
11. Test desktop/mobile, form submissions, email notifications, SEO output, sitemap, and URL status codes.

## Critical Warning

If an AI agent starts from only this theme folder, they must understand that:

- The database cleanup was already done in the previous WordPress install.
- The reservation backend plugin is not part of the theme unless it is copied separately.
- SEO data lives in the WordPress database, not in this theme.
- This theme contains the rebuild framework and documentation, not the preserved production data.

