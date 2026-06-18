# Affordable Web Solution — Developer Guide

Theme: **Affordable Web Solution** | Version: 1.1.1 | Text domain: `affordable-web-solution`
Function prefix: `nexagen_` (legacy/original) and `aws_` (v1.1 additions — header/footer customizer). No build step: vanilla CSS custom properties + vanilla JS, no page builder dependency.

## 1. Theme Structure

```
/
├── style.css                      → theme header + all CSS (custom properties, components, responsive)
├── functions.php                  → core bootstrap: setup, CPTs, taxonomies, customizer, AJAX, SEO, auto page-gen
├── header.php / footer.php        → likely wrappers calling nexagen_render_header()/footer() (not yet inspected)
├── front-page.php                 → "Homepage" template (static front page)
├── archive.php                    → blog/category/tag/date/author archive
├── inc/
│   ├── template-helpers.php       → all nexagen_render_*() section/component output functions
│   └── customizer/
│       ├── customizer-helpers.php → sanitize callbacks + dynamic CSS output (wp_head) + preview JS enqueue
│       ├── header-customizer.php  → aws_header_panel settings/controls
│       └── footer-customizer.php  → aws_footer_panel settings/controls
├── templates/                     → page templates (Template Name: header), selected via "Page Attributes"
│   ├── template-home.php, template-services.php, template-service-single.php
│   ├── template-industry.php, template-locations.php, template-state.php, template-city.php
│   ├── template-team.php, template-about.php, template-contact.php, template-testimonials.php
├── assets/
│   ├── js/main.js                 → sticky header, mobile nav, FAQ accordion, scroll reveal, contact AJAX
│   └── js/customizer-preview.js   → postMessage live-preview for customizer
└── DEPLOYMENT-INSTRUCTIONS.md     → ops notes (service URL slug migration, .htaccess, DB fix)
```

## 2. Important Files

| File | Purpose |
|---|---|
| `functions.php` | Theme setup, CPTs, taxonomies, legacy customizer (`nexagen_customizer`), AJAX contact handler, SEO/schema, auto-page generator on activation (`nexagen_activate`), 50-state/city content generators |
| `inc/template-helpers.php` | All front-end markup: header/footer, hero, services grid, FAQ, breadcrumbs, pricing, etc. |
| `inc/customizer/*.php` | v1.1 Header/Footer Customizer panels — additive, never remove legacy settings |
| `style.css` | Single stylesheet; CSS variables drive all theming (colors, spacing, radius, shadows) |
| `assets/js/main.js` | All front-end interactivity, no framework |

## 3. Theme Options (Customizer)

Two parallel systems coexist — be careful which one you extend:

**Legacy panel** — `nexagen_agency` (registered in `functions.php`, `nexagen_customizer()`):
- Section `nexagen_identity`: agency name, tagline, phone, email, address, CTA text/URL, social URLs
- Section `nexagen_hero`: hero title/subtitle, 2 CTA labels, 3 stat number/label pairs
- All stored as `theme_mod` under key `nexagen_{field}`, read via helper `nexagen_opt($key, $default)`

**v1.1 panels** — `aws_header_panel` (priority 25) and `aws_footer_panel` (priority 26):
- Header: logo position/width, sticky toggle, transparent-on-home, nav font size/weight, dropdown bg, CTA colors, logo sizing (desktop/tablet/mobile)
- Footer: columns (1–4), width, description, show logo/socials/stats, colors (bg/heading/text/link/hover), bottom bar (copyright, bg, legal links toggle), pre-footer CTA strip
- Stored as `theme_mod` under raw key (e.g. `aws_header_sticky`), read via `get_theme_mod()` directly
- Sanitized via shared helpers in `customizer-helpers.php`: `aws_sanitize_choices()`, `aws_sanitize_checkbox()`, `aws_sanitize_color_rgba()`
- Rendered as dynamic inline CSS (`aws_customizer_dynamic_css()` on `wp_head` priority 99) + live-previewed via `postMessage` in `customizer-preview.js`

**Convention:** new agency/content fields → extend legacy `nexagen_*` pattern; new layout/style toggles → extend `aws_*` pattern and add matching dynamic-CSS + preview-JS entries.

## 4. Custom Classes

- **`AWS_Nav_Walker`** — referenced in `inc/template-helpers.php` via `class_exists('AWS_Nav_Walker') ? new AWS_Nav_Walker() : ''` but **not defined anywhere in the codebase**. Currently falls back to default `Walker_Nav_Menu`. Flag this for whoever assumes a custom walker exists.
- No `WP_Widget` subclasses found — only a registered sidebar (`blog-sidebar`), no custom widget classes.
- No other PHP classes; theme is function-based throughout.

## 5. Custom Post Types

Registered in `functions.php` → `nexagen_register_post_types()` (hooked `init`):

| CPT | Slug | Public | Archive | Notes |
|---|---|---|---|---|
| `portfolio` | `portfolio` | Yes | Yes | "Case Study" labels, custom admin thumbnail column |
| `testimonial` | — | No (`show_ui` only) | No | Internal content type, no front-end single |
| `team_member` | — | No (`show_ui` only) | No | Internal content type |
| `service` | empty slug (top-level), `with_front=false` | Yes | Yes | Slug intentionally flattened (see §10 deployment notes) |

Rewrite flush is gated by an option flag: `get_option('nexagen_flush_rewrite') === 'yes'`.

## 6. Taxonomies

Registered in `nexagen_register_taxonomies()` (hooked `init`):

| Taxonomy | Object types | Hierarchical | Slug |
|---|---|---|---|
| `portfolio_cat` | `portfolio` | Yes | `portfolio-category` |
| `location` | `page` | Yes | `location` |
| `industry` | `page`, `service` | Yes | `industry` |

All `show_in_rest => true` (Gutenberg/REST compatible).

## 7. AJAX Handlers

Only one handler exists:

```php
add_action('wp_ajax_nexagen_contact',        'nexagen_handle_contact');
add_action('wp_ajax_nopriv_nexagen_contact', 'nexagen_handle_contact');
```

- Verifies nonce via `check_ajax_referer('nexagen_nonce', 'nonce')`
- Nonce/ajaxUrl localized to JS as `awsData` via `wp_localize_script`
- Sanitizes all fields, sends mail via `wp_mail()` to `nexagen_opt('agency_email', ...)`
- Returns `wp_send_json_success` / `wp_send_json_error`
- Client side: `assets/js/main.js`, form `#aws-contact-form`, posts `action=nexagen_contact`

## 8. Widgets

- One sidebar registered: `blog-sidebar` ("Blog Sidebar") via `register_sidebar()` in `nexagen_widgets_init()`
- No custom `WP_Widget` classes — relies entirely on core/default widgets dropped into that sidebar
- `add_theme_support('customize-selective-refresh-widgets')` is enabled

## 9. Important Hooks & Filters

| Hook | Function | Purpose |
|---|---|---|
| `after_setup_theme` | `nexagen_setup` | Theme supports, image sizes, nav menus |
| `wp_enqueue_scripts` | `nexagen_scripts` | Fonts, main.css/js, localize `awsData` |
| `widgets_init` | `nexagen_widgets_init` | Register blog sidebar |
| `init` | `nexagen_register_post_types`, `nexagen_register_taxonomies` | CPTs/taxonomies |
| `customize_register` | `nexagen_customizer`, `aws_header_customizer`, `aws_footer_customizer` | All customizer settings |
| `customize_preview_init` | `aws_customizer_preview_js` | Enqueue live-preview JS (preview frame only) |
| `wp_head` (priority 5) | `nexagen_head_meta` | OG/Twitter meta + LocalBusiness schema on front page |
| `wp_head` (priority 99) | `aws_customizer_dynamic_css` | Inline `<style>` from customizer values, overrides theme defaults |
| `body_class` | `aws_body_classes` | Adds header layout/sticky/transparent classes |
| `manage_portfolio_posts_columns` / `..._custom_column` | `nexagen_portfolio_columns(_content)` | Admin thumbnail column |
| `excerpt_length` / `excerpt_more` | inline closures | 25 words, `&hellip;` |
| `document_title_separator` | `nexagen_document_title_separator` | `|` separator |
| `use_block_editor_for_post_type` | `nexagen_disable_gutenberg` | Currently a no-op passthrough (placeholder) |
| `wp_ajax_nexagen_contact` / `wp_ajax_nopriv_nexagen_contact` | `nexagen_handle_contact` | Contact form |
| `register_activation_hook` (theme `nexagen_activate`) | auto-creates core/service/industry/state/city pages + nav menu on activation | One-time setup |

Performance: emoji scripts removed (`remove_action`/`remove_filter` block).

## 10. Plugin Integration Notes

- **No formal plugin dependency code** (no `is_plugin_active()`, no Yoast/RankMath/WooCommerce hooks). WooCommerce, Yoast, RankMath only appear as marketing copy text on service pages — not functional integrations.
- Theme ships its own SEO (meta tags, OG/Twitter, LocalBusiness/Breadcrumb/FAQ JSON-LD via `nexagen_head_meta`, `nexagen_breadcrumb_schema`, `nexagen_faq_schema`). **If Yoast/RankMath is installed, expect duplicate meta/schema output** — should be filtered or conditionally disabled (not currently handled).
- Gutenberg: `show_in_rest => true` on all CPTs/taxonomies, but `use_block_editor_for_post_type` filter is a stub that changes nothing today — safe hook point to disable the block editor per post type if needed.
- `DEPLOYMENT-INSTRUCTIONS.md` documents a manual DB fix (`post_parent`) and `.htaccess` 301s for a service-URL slug migration — relevant if extending the `service` CPT rewrite further.

### Recommended extension pattern
- New theme option → follow `aws_*` customizer pattern (panel/section/setting/control + sanitize callback + dynamic CSS + optional postMessage preview), not the older flat `nexagen_*` text fields, unless it's simple agency text content.
- New front-end markup → add a `nexagen_render_*()` function to `inc/template-helpers.php`, call from the relevant `templates/template-*.php` file. Don't inline HTML in `functions.php`.
- New AJAX endpoint → mirror `nexagen_handle_contact`: nonce check, sanitize, `wp_send_json_*`.
