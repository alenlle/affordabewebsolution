# MASTER_RULES.md — AI Development Firewall

Binding for any AI assistant working on this theme. If a task conflicts with a rule below, stop and ask — do not improvise around it.

## 1. Files / actions that must NEVER be modified directly

- `style.css` theme header block (Theme Name, Text Domain, Version) — WP identifies the theme by this. Don't touch without explicit instruction.
- `header.php` / `footer.php` — must stay thin wrappers (`nexagen_render_header()` / `nexagen_render_footer()` only). Never add markup directly into these files.
- Root `.htaccess` — outside the theme folder, server-level. Edit only for a named, documented deployment task, never as a side effect of an unrelated change.
- Live database content created by `nexagen_create_*_pages()` — never bulk-edit, delete, or re-run against production without an explicit human-approved backup step.
- Any SQL shown in `DEPLOYMENT-INSTRUCTIONS.md` — manual, one-time, human-run only. Never wire it into automated code.
- WordPress core files and other themes/plugins — out of scope entirely.

## 2. `nexagen_*` vs `aws_*` — no mixing

- `nexagen_*` = legacy: agency text content, CPTs, taxonomies, data arrays (`nexagen_get_services()`, `nexagen_get_states()`, etc.), all render functions.
- `aws_*` = v1.1: Header/Footer Customizer (layout, color, toggle settings), constants (`AWS_DIR`, `AWS_URI`, `AWS_VERSION`, `AWS_ASSETS`).
- New text/content option → `nexagen_*`. New layout/style/color option → `aws_*`. Never invent a third prefix.
- Always use the `AWS_*` path constants — never hardcode `get_template_directory()` / `get_template_directory_uri()` again.
- A new `aws_*` customizer setting requires all four: setting, control, sanitize callback, dynamic-CSS line. If `transport => postMessage`, also add the JS handler in `customizer-preview.js`. Missing any one = silent breakage.

## 3. 850+ auto-generated pages — safety rules

- `nexagen_create_*_pages()` functions run once, on `register_activation_hook` only. Never call them directly elsewhere.
- Every page-insert path must keep its existing idempotency check (`get_page_by_path()`) before `wp_insert_post()`. Never remove this check.
- `nexagen_get_states()`, `nexagen_get_services()`, `nexagen_get_industries()` are single sources of truth consumed by nav, footer, AND page generation. Never change their array key structure without auditing every consumer.
- Removing an entry from these arrays does NOT delete the already-published page — flag this to a human; don't silently leave orphaned pages.
- `flush_rewrite_rules()` stays gated behind the `nexagen_flush_rewrite` option flag. Never call it unconditionally on a normal request — it's expensive.
- Never trigger a full re-generation (all states/cities) on a production site without testing on staging first.

## 4. SEO / schema duplication prevention

- Existing schema sources: `nexagen_head_meta()` (OG/Twitter + LocalBusiness), `nexagen_breadcrumb_schema()`, `nexagen_faq_schema()`. One schema block per type, no exceptions.
- Before adding ANY new meta tag or JSON-LD output, check for Yoast/RankMath (`defined('WPSEO_VERSION')` or `is_plugin_active()`) and bail if active. This guard does not exist yet — add it on first touch of this code, don't compound the duplication risk.
- Never add a second `title-tag` support call or manual `<title>` output — `add_theme_support('title-tag')` is already declared once.
- All JSON-LD must go through `wp_json_encode()`. Never string-concatenate JSON manually.

## 5. AJAX security rules

- Every handler starts with `check_ajax_referer()`. No exceptions, no "internal use" excuse.
- Sanitize every `$_POST`/`$_GET` field with the type-correct function (`sanitize_text_field`, `sanitize_email`, `sanitize_textarea_field`, `absint`, etc.) before use.
- Register `wp_ajax_nopriv_{action}` only if logged-out users genuinely need it. Don't add it by default.
- Always respond via `wp_send_json_success()` / `wp_send_json_error()` — never raw `echo` + `die()`.
- Never echo unescaped user input back into the response.
- Reuse the `nexagen_nonce` only for the same contact-form purpose. A new AJAX action needs its own uniquely named nonce, created and localized the same way `nexagen_contact` is.

## 6. Customizer rules

- Settings are additive only — never delete an existing `nexagen_*` or `aws_*` setting/control. Production sites may already have stored `theme_mod` values for it.
- Every setting needs an explicit `sanitize_callback`: hex colors → `sanitize_hex_color`/`aws_sanitize_color_rgba`, checkboxes → `aws_sanitize_checkbox`, radio/select → `aws_sanitize_choices`. No setting without one.
- `transport => 'postMessage'` requires a matching handler in `customizer-preview.js`. If you can't add the JS in the same change, use `transport => 'refresh'` instead.
- Always read with a default: `get_theme_mod('key', $default)`. Never assume a value exists.
- Panel priorities are intentional (Header=25, Footer=26, Agency=30). Don't reorder existing panels.

## 7. Performance rules

- Do not re-enable emoji scripts (intentionally removed).
- Do not add new external font or script requests if an existing enqueued asset can be reused.
- Never run `WP_Query` against 850+ generated pages for listings (locations, services, etc.) — use the static PHP arrays (`nexagen_get_states()`, etc.), which is the existing pattern.
- New `wp_head`/`wp_footer` hooks must declare an explicit priority; cache repeated `get_theme_mod()` calls in local variables instead of re-calling.
- New dynamic CSS hooks at priority 99 or later, consistent with `aws_customizer_dynamic_css`. Don't create a second freestanding `<style>` block for the same concern.
- No jQuery dependency in front-end JS (`main.js` is vanilla). jQuery is acceptable only inside the Customizer preview context, matching `customizer-preview.js`.

## 8. WordPress best practices — enforced, no exceptions

- Every PHP file starts with `defined('ABSPATH') || exit;`.
- Escape all output (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`) — never raw-echo dynamic data.
- Sanitize all input before use or storage.
- `snake_case`, prefixed (`nexagen_`/`aws_`) function and hook names only.
- Use core WP APIs over custom code (`wp_mail`, `wp_nav_menu`, `register_sidebar`, etc.) — don't reinvent.
- Wrap all user-facing strings in `__()`/`_e()` with text domain `affordable-web-solution`.
- No direct `$wpdb` queries unless `WP_Query`/`get_posts` genuinely cannot do the job — none exist today, keep it that way.
- Any rewrite-slug change to a CPT/taxonomy must pair with a gated `flush_rewrite_rules()` call, following the existing `nexagen_flush_rewrite` option-flag pattern.

## Escalation rule

If a requested change requires breaking any rule above, do not proceed silently. State which rule is in conflict and ask for explicit confirmation before writing code.
