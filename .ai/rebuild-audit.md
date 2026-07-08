# Bright Autonomy Rebuild Audit

Date: 2026-07-08

## Current Published URLs

Keep these slugs unchanged unless a 301 redirect is explicitly added.

| ID | Type | Title | Slug |
| --- | --- | --- | --- |
| 15 | page | Home | `/` |
| 17 | page | Features | `/features/` |
| 19 | page | Knowledge Center | `/knowledge-center/` |
| 21 | page | About | `/about/` |
| 23 | page | Reserve My Place in Line | `/reserve-my-place-in-line/` |

Permalink structure: `/%postname%/`

Front page: page ID `15` (`Home`)

## Reservation Functionality

Reservation logic has been moved out of the theme into:

`wp-content/plugins/bright-reservations/bright-reservations.php`

Active reservation tables:

| Table | Purpose | Current Count |
| --- | --- | --- |
| `wp_reserve` | Main reservation/contact records | 82 |
| `wp_machines` | Fleet machine records linked to reservation IDs | 180 |

The plugin preserves the existing AJAX action names:

| Action | Access |
| --- | --- |
| `form_reserve_submition` | Public and logged-in users |
| `save_user_submition` | Super admin only |

The current page template still renders the form:

`wp-content/themes/bright/template-page-reserve.php`

During the ACF rebuild, the new theme can either keep that template name or render a new ACF-backed reservation template that posts to the same AJAX action.

## SEO Notes

Active SEO plugin: All in One SEO Pack.

Current AIOSEO page-level rows exist for the public pages, but title and description fields are blank. SEO preservation should focus on:

- Keeping the public URL slugs unchanged.
- Preserving page titles/headings and meaningful body copy.
- Keeping AIOSEO active through launch.
- Verifying sitemap output before go-live.
- Setting `blog_public` to `1` on production. Local value is currently `0`.
- Adding 301 redirects only if any public URL changes.

## Elementor Dependencies

Active Elementor-related plugins:

- `elementor`
- `elementor-pro`
- `theme-bright-toolkit`

The five public pages contain Elementor meta. Public page content must be rebuilt before Elementor is removed.

Elementor library records currently present:

| ID | Title | Status |
| --- | --- | --- |
| 6 | Default Kit | publish |
| 237 | Feedback | publish |
| 382 | Single Post Footer Template | publish |
| 862 | Elementor Header #862 | draft |
| 1289 | Terms and Conditions | publish |
| 1348 | Elementor Footer #1348 | publish |
| 1705 | template | publish |

The `theme-bright-toolkit` plugin is only custom Elementor widgets. It can be removed after the ACF theme replaces the Elementor layouts.

## Plugin Cleanup Plan

Keep during rebuild:

- `bright-reservations`
- `advanced-custom-fields-pro`
- `all-in-one-seo-pack`
- `wp-mail-smtp`
- `updraftplus`
- `wp-migrate-db-pro`

Likely remove after ACF replacement and verification:

- `elementor`
- `elementor-pro`
- `theme-bright-toolkit`
- `advanced-custom-fields-font-awesome`, unless the new ACF fields need icon pickers
- `wpforms-lite`, unless the new contact form uses it
- `classic-editor`, unless the client prefers it
- `svg-support`, unless SVG uploads are still required
- inactive default plugins/themes after launch backup

## Cleanup Sequence

1. Build ACF field groups and templates for the XD pages.
2. Rebuild Home, Features, Knowledge Center, About, and Reserve using the same page IDs/slugs.
3. Replace the Elementor contact form on About with either a custom ACF/theme form or WPForms.
4. Verify reservation submission, existing email lookup links, admin save flow, and notification email.
5. Crawl old vs. new staging URLs and compare status codes, titles, canonicals, and sitemap.
6. Back up files and database.
7. Deactivate Elementor, Elementor Pro, and Bright Toolkit.
8. Remove Elementor post meta/library records only after the front end is confirmed clean.
9. Clear cache and retest public pages.

## Cleanup Completed On 2026-07-08

A database backup and inventories were created before cleanup:

- `backups/cleanup-2026-07-08/before-elementor-cleanup.sql`
- `backups/cleanup-2026-07-08/plugins-before.csv`
- `backups/cleanup-2026-07-08/posts-before.csv`

Removed plugins:

- `elementor`
- `elementor-pro`
- `theme-bright-toolkit`
- `wpforms-lite`
- `classic-editor`
- `advanced-custom-fields-font-awesome`
- `akismet`
- `hello`

Removed Elementor data:

- Elementor library posts
- Elementor post meta
- Elementor options/log/version rows
- Generated `wp-content/uploads/elementor` assets

Post-cleanup verification:

- Public pages remain: Home, Features, Knowledge Center, About, Reserve My Place in Line.
- Front page remains page ID `15`.
- Reserve page still uses `template-page-reserve.php`.
- `wp_reserve` remains at 82 rows.
- `wp_machines` remains at 180 rows.
- Active SEO plugin remains All in One SEO Pack.
- Active reservation plugin remains Bright Reservations.

## Page Data Cleanup Completed On 2026-07-08

A database backup was created before clearing page data:

- `backups/cleanup-2026-07-08/before-page-data-cleanup.sql`

Cleared for page IDs `15`, `17`, `19`, `21`, and `23`:

- `post_content`
- `post_excerpt`
- non-AIOSEO page meta, except `_wp_page_template`
- page revisions

Preserved:

- page records, titles, slugs, and publish status
- front page setting: page ID `15`
- `_wp_page_template`, including Reserve page template `template-page-reserve.php`
- AIOSEO post meta
- `wp_aioseo_posts` rows

## ACF Field Cleanup Completed On 2026-07-08

A database backup was created before removing old ACF fields:

- `backups/cleanup-2026-07-08/before-acf-field-cleanup.sql`

Removed old ACF field groups and fields:

- Site Header
- Site Footer
- Post Layout

Preserved:

- Advanced Custom Fields PRO plugin
- theme ACF JSON sync folder: `wp-content/themes/bright/acf-json`

## Plugin Maintenance Completed On 2026-07-08

Requested cleanup/update actions:

- Deactivated `wp-super-cache`.
- Removed `updraftplus`.
- Removed `wp-content/updraft`.
- Removed UpdraftPlus options from `wp_options`.
- Removed `classic-editor` after it was found active again.
- Updated available wordpress.org plugins:
  - All in One SEO Pack: `4.9.9`
  - SVG Support: `2.5.16`
  - WP Mail SMTP: `4.9.0`
  - WP Super Cache: `3.1.1` and inactive

Update blockers:

- Advanced Custom Fields PRO stayed at `6.2.1.1` because the update package was not available.
- WP Migrate DB Pro stayed at `2.7.4` because the license subscription is expired.

Post-maintenance verification:

- `wp-super-cache` is inactive.
- No `advanced-cache.php`, `WP_CACHE`, or `wp-content/cache` cache drop-in was found.
- No UpdraftPlus files or options remain.
- Bright Reservations and All in One SEO Pack remain active.
- Reservation data remains intact.

## Header/Footer Data Cleanup Completed On 2026-07-08

A database backup was created before removing header/footer data:

- `backups/cleanup-2026-07-08/before-header-footer-data-cleanup.sql`

Removed:

- old `Main Menu`
- nav menu items
- nav menu terms/options
- theme mod options
- widget/sidebar options
- block navigation posts
- global style posts
- leftover draft page: `Breakthrough Technology`

Post-cleanup verification:

- menu terms: `0`
- nav menu items: `0`
- block navigation posts: `0`
- global style posts: `0`
- theme mod options: `0`
- preserved published pages remain at `5`
- AIOSEO rows for preserved pages remain at `5`
- reservation data remains intact

## Upload Files Cleanup Completed On 2026-07-08

Removed files/folders inside:

- `wp-content/uploads`

Recreated:

- `wp-content/uploads/index.php`

Preserved intentionally:

- AIOSEO rows
- published page records/slugs
- reservation tables/data

Post-cleanup verification:

- uploads directory size: `4.0K`
- upload files remaining: `wp-content/uploads/index.php`
- AIOSEO rows for preserved pages: `5`
- `wp_reserve`: `82`
- `wp_machines`: `180`

## Media Library Cleanup Completed On 2026-07-08

A database backup was created before removing Media Library records:

- `backups/cleanup-2026-07-08/before-media-library-cleanup.sql`

Removed:

- attachment posts
- attachment post meta
- attachment term relationships
- attachment comments/comment meta
- AIOSEO rows for deleted attachment posts only

Preserved:

- AIOSEO rows for the five preserved public pages
- published page records/slugs
- reservation tables/data

Post-cleanup verification:

- attachment posts: `0`
- orphan attachment/meta rows: `0`
- orphan AIOSEO rows: `0`
- AIOSEO rows for preserved pages: `5`
- upload files remaining: `wp-content/uploads/index.php`
- `wp_reserve`: `82`
- `wp_machines`: `180`

## Theme Reset Completed On 2026-07-08

Theme changes:

- Activated default WordPress theme: `twentytwentyfive`.
- Reset Reserve page `_wp_page_template` from `template-page-reserve.php` to `default`.
- Deleted old active theme: `bright`.

Preserved:

- five published page records and slugs
- All in One SEO page rows
- Bright Reservations plugin and reservation database tables

Current theme state:

- active: `twentytwentyfive`
- inactive: `mosharaf-core`
