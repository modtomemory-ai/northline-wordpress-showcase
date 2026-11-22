# Architecture notes — how the sample is constructed

## Why a PHP-driven classic theme?

The job description explicitly asks for a theme built *from scratch* and offers to review the implementation. A classic theme with native PHP template hierarchy provides a clear demonstration of WordPress hooks, `WP_Query`, escaping, template files, customizer controls, and conditional rendering without hiding implementation details behind a visual page builder. It still uses `theme.json` and a dynamic Gutenberg block.

## Why a companion plugin?

The theme owns presentation, while **Northline Core** owns data: custom post type `nl_project`, taxonomy `nl_sector`, editable meta fields and the Gutenberg block. Switching the theme does not unregister the site's content type (assuming the plugin remains active).

## Request → render flow

1. WordPress loads plugins and theme, then fires `init`.
2. The plugin registers `nl_project`, `nl_sector`, permitted post meta and the project grid block.
3. `front-page.php` uses `WP_Query` for the four most recent published projects and explicitly calls `wp_reset_postdata()`.
4. `northline_project_card()` escapes URLs, text fields and fallback illustration paths; featured images are produced through WordPress' native thumbnail functions.
5. If there are no portfolio items, `northline_concept_card()` renders **clearly labeled placeholders**, which cannot be mistaken for CMS-stored real commissions.
6. Archive and taxonomy templates are server-rendered, paginated and allow native sector navigation.

## Gutenberg block

The plugin registers `northline/project-grid` as a dynamic block with a configurable count (1–12). JavaScript uses official `wp.*` packages for a build-free editor interface. PHP runs a constrained `WP_Query`, creates the HTML and resets post data; published changes are reflected without rebuilding assets. Styling ships with the block's registered stylesheet.

## Security and accessibility

- Server-rendered text and URLs are escaped using `esc_html`, `esc_attr` or `esc_url` as appropriate.
- The meta-box write path verifies capability, nonce, post type and autosave/revision state; submitted fields are sanitized.
- Post metadata is explicitly registered for REST with field-level authorization, making it available to the block editor.
- Project listings expose only `publish` status; no hidden drafts are selected.
- The site includes a skip link, semantic headings, keyboard-focus states, an Escape-to-close mobile menu, correct `aria-expanded`, and reduced-motion support.
- No contact form or authenticated custom REST endpoint exists, deliberately minimizing unnecessary attack surface.

## Performance choices

- Illustrations are local, author-created SVG assets; no remote stock image dependencies.
- The CSS and JS are small and use no build-chain or runtime frontend framework.
- Script is footer-loaded; noncritical project illustrations are lazy-loaded.
- Query uses `no_found_rows` where pagination is not needed, limiting unnecessary count work.
- `filemtime()` versions assets during development to avoid stale browser caches.

## Future extensions (not claimed as implemented)

Production implementation should add cache policies, accessibility audit, structured data/SEO requirements, integration testing on supported WordPress/PHP versions, translatable language catalogs, real content ownership reviews, and image optimization for client-supplied photography.
