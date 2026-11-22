# QA report

## Completed automated checks

- [x] PHP CLI syntax validation across all theme and plugin PHP files on PHP 8.4.
- [x] JavaScript syntax parsing via `node --check` (both JS files).
- [x] Parse `theme.json` as JSON.
- [x] Check required files, static demo internal links and shipped SVG XML validity (`python3 scripts/validate.py`).
- [x] Repository contains a separate plugin and does not ship a prebuilt third-party theme or builder.
- [x] No external visual assets are required for the preview.

## Still requires live WordPress / browser verification

- [ ] Activate plugin and theme on WordPress 6.6+ with PHP 8.0+.
- [ ] Confirm projects and sectors appear in WordPress admin, front-end archive and REST API.
- [ ] Create/edit project metadata in both Gutenberg and classic admin contexts.
- [ ] Confirm dynamic Gutenberg block preview and front-end rendering.
- [ ] Confirm native permalinks, pagination, archive and taxonomy navigation.
- [ ] Review keyboard navigation, screen-reader labels and mobile layouts in an actual browser.
- [ ] Run WordPress Coding Standards (PHPCS), and check PHP 8.0–8.4 in a real installation.
- [ ] Run real-site performance and accessibility audits after hosting is set up.

**Status:** Source package prepared and statically validated; **not certified production-ready**. No live WordPress test or browser rendering was possible in the build environment. Checks listed as pending are not represented as completed.
