# DEBUGGING_PLAYBOOK.md — Production Issue Playbook

Practical fixes only. Each issue: Cause → How to debug → Fix steps. Theme-specific file/function names included throughout.

---

## 1. 404 after rewrite changes

**Cause:** A CPT or taxonomy rewrite slug changed (`service`, `portfolio`, `location`, `industry`), but `flush_rewrite_rules()` only runs when `nexagen_flush_rewrite` option is `'yes'` — if that flag wasn't set, stale rules stay cached. Also: auto-generated city pages depend on their parent state page's `post_parent` — if a slug/parent link breaks, the URL 404s even though the page exists.

**How to debug:**
- Settings → Permalinks — does simply opening this page and saving fix it? If yes, it was a stale rewrite cache.
- Check the flag: `wp option get nexagen_flush_rewrite` (WP-CLI) or query `wp_options` directly.
- Check the actual page: Pages list → search slug → confirm it exists and check its `post_parent` and template (`_wp_page_template` meta).
- Check `.htaccess` (site root, not theme folder) for an old redirect rule conflicting with the new structure — see `DEPLOYMENT-INSTRUCTIONS.md` for the documented service-slug migration case.

**Fix steps:**
1. Settings → Permalinks → Save Changes (forces a rewrite flush).
2. If the CPT/taxonomy `rewrite` arg was just changed in code, confirm `update_option('nexagen_flush_rewrite', 'yes')` was set and that `init` ran once afterward (any page load triggers the gated flush).
3. For city/state 404s specifically: check the city page's `post_parent` ID actually matches the existing state page ID — `nexagen_create_state_pages()` sets this at insert time, it's not auto-repaired later.
4. Purge any page cache / CDN cache after the permalink save — flushed rewrite rules don't matter if a cached 404 response is still being served.

---

## 2. AJAX not working (nonce / admin-ajax.php issues)

**Cause:** Nonce action string mismatch between `wp_create_nonce()` and `check_ajax_referer()`, missing `wp_ajax_nopriv_*` hook for logged-out users, the localized `awsData` object not present on the page (script not enqueued there), or a security plugin blocking `admin-ajax.php`.

**How to debug:**
- Browser DevTools → Network tab → submit the form → find the `admin-ajax.php` POST request.
  - Response `-1` → no matching `wp_ajax_{action}`/`wp_ajax_nopriv_{action}` hook fired for the current login state.
  - Response `0` or empty body → `check_ajax_referer()` failed (nonce mismatch) or a PHP fatal error broke the JSON output.
  - Response is valid JSON with `success: false` → that's the handler working correctly, read `data.message`.
- View page source, search for `awsData` — confirm it exists and `awsData.nonce` is a non-empty string.
- Check PHP error log for a fatal error during the request (breaks JSON, causes the `0`/empty response).

**Fix steps:**
1. Confirm both `add_action('wp_ajax_nexagen_{action}', ...)` and, if guests need it, `add_action('wp_ajax_nopriv_nexagen_{action}', ...)` are registered.
2. Confirm the nonce action string is identical in both places: `wp_create_nonce('{action}_nonce')` in `nexagen_scripts()` and `check_ajax_referer('{action}_nonce', 'nonce')` in the handler.
3. Confirm the script that needs `awsData` is actually enqueued on that page (check any `is_page()`/conditional logic in the enqueue function).
4. Disable security/firewall plugins temporarily to rule out them blocking `admin-ajax.php` (common with some host-level security plugins).
5. Check the PHP error log for fatals; fix them — a fatal mid-handler produces an empty/invalid AJAX response that looks like "AJAX isn't working" but is actually a PHP error.

---

## 3. Customizer changes not reflecting

**Cause:** Either the value never saved correctly, output is being served from a cache, or the template is reading a hardcoded default instead of calling `get_theme_mod()`/`nexagen_opt()` for that field.

**How to debug:**
- View page source on the live front-end (not the Customizer preview) and search for `<style id="aws-customizer-css">` — confirm the new value is actually present in that inline block.
- If it's missing or shows the old value: that's a caching issue, not a code issue.
- If the *Customizer preview* shows the change but the *published, real front-end* doesn't: that's expected if `transport => 'postMessage'` JS exists but you're checking before clicking Publish — preview-only updates never persist until saved.

**Fix steps:**
1. Reload the live URL in a private/incognito window (rules out browser cache).
2. Purge any full-page cache plugin (WP Rocket, W3 Total Cache, etc.) and CDN cache — the dynamic CSS is printed via `wp_head`, page caches absolutely will cache it.
3. If the value is still missing from `view-source` after a cache purge: check that the `get_theme_mod('aws_{key}', $default)` call inside `aws_customizer_dynamic_css()` uses the exact same key string as `add_setting('aws_{key}', ...)` — a typo here fails silently with no error, it just falls back to default.
4. If it's a `nexagen_*` field, confirm the template/render function calls `nexagen_opt('{key}', $default)` rather than a hardcoded string.

---

## 4. CSS not updating (cache / wp_head priority)

**Cause:** `style.css` is loaded with a version query string from the `AWS_VERSION` constant — if that constant isn't bumped after an edit, browsers and CDNs keep serving the old cached file indefinitely. Separately, the customizer's dynamic inline CSS is hooked at `wp_head` priority **99**; anything hooked later (100+) by another plugin can override it.

**How to debug:**
- DevTools → Network tab → check the `style.css` request URL — look at the `?ver=` query string and compare to the current `AWS_VERSION` value in `functions.php`.
- Check response headers (`cache-control`, `age`) to see if a CDN/cache layer served a stale copy.
- View source, find `<style id="aws-customizer-css">` and check its position relative to any other inline `<style>` blocks — later in the `<head>` wins on equal specificity.

**Fix steps:**
1. Bump `AWS_VERSION` in `functions.php` after every `style.css` edit. This is the only cache-busting mechanism — forgetting it means stale CSS can persist for as long as the browser/CDN cache TTL.
2. Hard refresh (Ctrl/Cmd+Shift+R) or test in incognito to rule out local browser cache.
3. Purge server-side cache plugin and CDN cache.
4. If only the *customizer-driven* styles aren't updating (static CSS is fine): check for another `wp_head` hook running at priority ≥100 that outputs a conflicting rule — `aws_customizer_dynamic_css` runs at 99 specifically so it can override theme defaults, but it can itself be overridden by anything later.
5. As a last resort, restart PHP-FPM / clear OPcache if a direct file edit doesn't seem to take effect at all (rare, but happens on some hosts after manual file uploads).

---

## 5. Page generation issues (850+ pages system)

**Cause:** `nexagen_activate()` runs exactly once, on `register_activation_hook`. Common failure modes: theme installed without a proper "Activate" click (e.g. bulk migration), a `max_execution_time`/memory limit hit partway through ~850+ `wp_insert_post()` calls on shared hosting, or a trashed page already occupying a slug that `get_page_by_path()` checks against (silently skips insertion).

**How to debug:**
- `wp option get nexagen_activated` and `wp option get nexagen_flush_rewrite` (WP-CLI) — confirms whether activation logic actually ran.
- `wp post list --post_type=page --format=count` — compare to expected count (~50 states + ~800+ cities + services + industries + core pages).
- Check PHP error log around the activation timestamp for `Maximum execution time exceeded` or memory errors.
- Check Trash for a page with the same slug as a missing one — `get_page_by_path()` matches by slug regardless of status and will skip insertion if any match exists.

**Fix steps:**
1. If the count is far below expected and no error log entry exists: theme activation hook likely never fired. Re-trigger by deactivating/reactivating the theme (test on staging first — see `MASTER_RULES.md` §3).
2. If a timeout/memory error is in the log: temporarily raise `max_execution_time` and `memory_limit` (via host settings or `wp-config.php`), then reactivate.
3. If specific pages are missing: check Trash first, empty or rename the conflicting trashed page, then re-run only the relevant generator function (`nexagen_create_state_pages()`, etc.) via WP-CLI `eval`, not as a public-facing action.
4. If city pages exist but link to the wrong/blank parent: confirm the corresponding state page exists and re-check its ID against the city's `post_parent` before re-running.
5. After any manual fix, go to Settings → Permalinks → Save to flush rewrite rules, since the page set changed.

---

## 6. Menu / navigation issues

**Cause:** No menu is assigned to the `primary` theme location, so the theme silently falls back to a hardcoded nav (Services/Industries/Locations/etc.) defined directly in `nexagen_render_header()`. This isn't a bug — it's the documented fallback — but it means edits made in Appearance → Menus won't appear until a menu is actually assigned. Separately, `AWS_Nav_Walker` is referenced via `class_exists()` but never defined, so a real assigned menu renders with default `Walker_Nav_Menu` markup, not the custom `.dropdown` structure the CSS expects for submenus.

**How to debug:**
- Appearance → Menus → confirm a menu exists AND is assigned to "Primary Menu" location (`has_nav_menu('primary')` must be true).
- View source: hardcoded fallback outputs `<ul role="list">` with `.dropdown` divs; real `wp_nav_menu()` output is `<ul class="primary-menu">` with default `<ul class="sub-menu">` for children — visually distinguishable.
- If submenus look unstyled/broken after assigning a real menu: that's the missing walker, not a CSS bug per se.

**Fix steps:**
1. Confirm a menu is created and assigned to "Primary Menu". If not, that's expected behavior, not a defect — assign one if the client needs to edit nav items via wp-admin.
2. If submenu styling breaks once a real menu is assigned: either add CSS rules targeting `ul.primary-menu .sub-menu` to match `.dropdown` styling, or build the missing `AWS_Nav_Walker` class so its output matches the original markup. Don't assume the walker already does this — it doesn't exist.
3. Footer menu locations (`footer-1/2/3`) have no documented hardcoded fallback — confirm they're assigned in Appearance → Menus if footer links appear empty.
4. Clear any nav-menu-specific object cache after reassigning (some cache plugins cache `wp_nav_menu()` output separately from full-page cache).

---

## 7. Schema duplication issues

**Cause:** The theme outputs its own meta tags and JSON-LD (`nexagen_head_meta()`, `nexagen_breadcrumb_schema()`, `nexagen_faq_schema()`) with no guard against an SEO plugin (Yoast, RankMath, AIOSEO) doing the same thing. There is also no de-dupe protection if a render function that emits schema (`nexagen_render_breadcrumb()`, `nexagen_render_faq()`) is accidentally called more than once on the same page.

**How to debug:**
- View source, search `ld+json` — count blocks and check `@type` values for repeats (e.g. two `BreadcrumbList` or two `ProfessionalService`).
- Search for duplicate `<meta property="og:` tags.
- Check Plugins list for Yoast SEO / RankMath SEO / All in One SEO active alongside the theme.
- Run the live URL through Google's Rich Results Test — it flags duplicate/competing schema directly.

**Fix steps:**
1. If an SEO plugin is active: add a guard at the top of each theme schema function — `if (defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION')) return;` — rather than trying to disable the plugin's output (see `MASTER_RULES.md` §4).
2. If no SEO plugin is active but duplicates still appear: search `inc/template-helpers.php` and every file in `templates/` for repeated calls to `nexagen_render_breadcrumb()` or `nexagen_render_faq()` on the same template — each should be called exactly once per page.
3. Re-run the Rich Results Test after the fix to confirm one block per schema type remains.
4. If both the theme schema and an SEO plugin must coexist for any reason, turn off only the specific schema graph pieces inside the SEO plugin's settings (e.g. Yoast → Search Appearance → Local SEO toggle) instead of touching the theme — keeps a single point of maintenance.
