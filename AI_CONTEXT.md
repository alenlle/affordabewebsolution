# AI_CONTEXT.md — Affordable Web Solution WordPress Theme

Read this before touching any code. It tells you where things live, what naming pattern to follow, and what NOT to do.

## What this is

Custom WordPress theme for a web design agency. No build tools, no page builder, no framework. Plain PHP template tags, vanilla CSS (custom properties), vanilla JS. On activation it auto-generates ~850+ pages (core pages + services + industries + all 50 US states + 800+ cities) for local-SEO purposes.

- Theme name: Affordable Web Solution
- Version: 1.1.1, Text domain: `affordable-web-solution`
- Requires PHP 8.0, WP 6.0+

## Naming conventions — READ THIS FIRST

Two prefixes coexist. Match the one already used in the area you're editing:

- **`nexagen_*`** — original/legacy code. Functions, CPTs, theme_mod keys, data generators (`nexagen_get_services()`, `nexagen_get_states()`), all render functions (`nexagen_render_*`).
- **`aws_*`** — v1.1 additions, specifically the Header/Footer Customizer system (`inc/customizer/`) and `AWS_*` constants (`AWS_DIR`, `AWS_URI`, `AWS_VERSION`, `AWS_ASSETS`).

Don't mix them. New agency text content (name, phone, social URLs) → `nexagen_*` pattern. New layout/style toggle → `aws_*` pattern, matching header/footer customizer structure.

## File responsibility map

| If you need to... | Edit this file |
|---|---|
| Add/change front-end markup or sections (hero, FAQ, pricing, etc.) | `inc/template-helpers.php` — add a `nexagen_render_*()` function |
| Add a new page template | `templates/template-{name}.php` with `Template Name:` header comment, then call render functions from `inc/template-helpers.php` |
| Add a CPT or taxonomy | `functions.php`, inside `nexagen_register_post_types()` / `nexagen_register_taxonomies()` (hooked on `init`) |
| Add a legacy agency-text option (text field) | `functions.php`, `nexagen_customizer()` — add to `$fields` or `$hero_fields` array |
| Add a header/footer layout or color option | `inc/customizer/header-customizer.php` or `footer-customizer.php`, then wire the value into `aws_customizer_dynamic_css()` in `customizer-helpers.php`, then mirror it in `assets/js/customizer-preview.js` for live preview |
| Add/modify the AJAX contact form | `functions.php` (`nexagen_handle_contact`) + `assets/js/main.js` (submit handler) |
| Change colors/spacing/typography globally | `style.css` `:root` custom properties — don't hardcode hex values elsewhere |
| Edit the data behind Services / Industries / States+Cities | `functions.php` — `nexagen_get_services()`, `nexagen_get_industries()`, `nexagen_get_states()` (large static arrays, single source of truth, used by both auto-page-generation AND nav/footer rendering) |

## Architecture pattern to follow

1. Data lives in static array functions in `functions.php` (`nexagen_get_services()`, etc.)
2. Rendering lives in `inc/template-helpers.php` as `nexagen_render_*()` functions that read that data
3. Page templates in `templates/` are thin — they just call `get_header()`, a sequence of `nexagen_render_*()` calls, `get_footer()`
4. `header.php` calls `nexagen_render_header()`; `footer.php` calls `nexagen_render_footer()` — don't put markup directly in header.php/footer.php

Follow this same split for new features: data function → render function → thin template call.

## Known gaps / things to flag before relying on them

- **`AWS_Nav_Walker` does not exist.** `inc/template-helpers.php` checks `class_exists('AWS_Nav_Walker')` before using it as the `wp_nav_menu` walker, but it's never defined anywhere in the theme. It silently falls back to the default `Walker_Nav_Menu`. If a task references custom nav-menu markup/walker behavior, this is dead code — don't assume it does anything.
- **No plugin-conflict handling.** The theme outputs its own meta tags + JSON-LD (LocalBusiness, Breadcrumb, FAQPage schema) via `nexagen_head_meta()`, `nexagen_breadcrumb_schema()`, `nexagen_faq_schema()`. If Yoast SEO or RankMath is active, expect duplicate `<meta>`/schema output. There is no `is_plugin_active()` check anywhere in the codebase.
- **No real plugin integrations.** WooCommerce/Yoast/RankMath only appear as marketing copy strings on service pages (e.g. "WooCommerce Development" service listing) — not functional hooks. Don't assume WooCommerce-aware code exists.
- **Google Tag Manager is hardcoded** in `header.php` (container ID `GTM-P847K98Z`). Don't duplicate GTM if a plugin is later used for tag management.
- **Two separate customizer registration systems** run in parallel (`nexagen_customizer()` in functions.php, plus `aws_header_customizer()` / `aws_footer_customizer()` required from `inc/customizer/`). They don't conflict today but a future refactor should NOT collapse them without checking both for overlapping option names.
- **`use_block_editor_for_post_type` filter is a no-op stub** (`nexagen_disable_gutenberg`) — currently returns `$use` unchanged. It's a placeholder hook point, not active logic.
- **Auto-generated pages are idempotent on activation** — `nexagen_create_*_pages()` functions check `get_page_by_path()` before inserting, so re-activating the theme won't duplicate pages. Rewrite flush is gated by a one-time option flag (`nexagen_flush_rewrite`).

## Conventions to follow when writing new code

- WordPress Coding Standards: `snake_case` functions, `defined('ABSPATH') || exit;` at top of every PHP file, escape on output (`esc_html`, `esc_attr`, `esc_url`), sanitize on input.
- Prefer hooks/filters over editing core template files directly — there's already a hook for most things (see hook table below).
- All theme_mod reads go through `get_theme_mod()` with an explicit default — never assume a setting exists.
- New customizer settings need a `sanitize_callback`. Reuse `aws_sanitize_choices`, `aws_sanitize_checkbox`, `aws_sanitize_color_rgba` from `customizer-helpers.php` instead of writing new ones.
- AJAX handlers: always `check_ajax_referer()` first, sanitize every `$_POST` field, respond with `wp_send_json_success`/`wp_send_json_error`.

## Hook quick reference

| Hook | Function | What it does |
|---|---|---|
| `after_setup_theme` | `nexagen_setup` | theme supports, image sizes, nav menu locations |
| `wp_enqueue_scripts` | `nexagen_scripts` | fonts, style.css, main.js, localizes `awsData` (ajaxUrl, nonce) |
| `init` | `nexagen_register_post_types`, `nexagen_register_taxonomies` | CPTs/taxonomies |
| `customize_register` | `nexagen_customizer`, `aws_header_customizer`, `aws_footer_customizer` | all customizer options |
| `wp_head` (priority 5) | `nexagen_head_meta` | OG/Twitter meta, LocalBusiness schema (front page only) |
| `wp_head` (priority 99) | `aws_customizer_dynamic_css` | inline CSS built from theme_mods, overrides defaults |
| `body_class` | `aws_body_classes` | adds layout flags (sticky, transparent, logo position) |
| `wp_ajax_nexagen_contact` / `wp_ajax_nopriv_nexagen_contact` | `nexagen_handle_contact` | contact form submit |
| `register_activation_hook` | `nexagen_activate` | one-time: creates ~850 pages + nav menu |

## CPTs & taxonomies (summary — see functions.php for full args)

- CPTs: `portfolio` (public, has archive), `service` (public, flattened slug — see DEPLOYMENT-INSTRUCTIONS.md for why), `testimonial` (admin-only), `team_member` (admin-only)
- Taxonomies: `portfolio_cat` → `portfolio`; `location` → `page`; `industry` → `page`, `service`

## Before making changes, search for these terms in functions.php first

`nexagen_opt`, `get_theme_mod`, `nexagen_get_services`, `nexagen_get_states`, `add_action`, `add_filter` — most existing behavior is discoverable by grepping these in `functions.php` and `inc/template-helpers.php` rather than reading the whole file top to bottom.
