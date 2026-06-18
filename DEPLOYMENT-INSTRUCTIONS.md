# Service URL Fix — Deployment Guide

## What Was Changed

This update removes `/services/` from all individual service page URLs.

**Before:** `https://affordablewebsolution.com/services/wordpress-support/`
**After:** `https://affordablewebsolution.com/wordpress-support/`

The `/services/` listing page itself (`affordablewebsolution.com/services/`) is unchanged.

---

## Files Modified

| File | What Changed |
|------|-------------|
| `functions.php` | CPT rewrite slug cleared, service page parent set to 0, added 301 redirect function |
| `inc/template-helpers.php` | Nav dropdown, footer links, services grid links fixed |
| `templates/template-services.php` | Service card links fixed |
| `templates/template-service-single.php` | Related services sidebar links fixed |
| `.htaccess` | Apache-level 301 redirects added as server-side fallback |

---

## Deployment Steps (in order)

### Step 1 — Upload theme files
Upload the entire updated theme folder to:
```
/wp-content/themes/affordable-web-solution/
```

### Step 2 — Upload/replace .htaccess
Upload the new `.htaccess` to your **WordPress root** (same folder as `wp-config.php`).
- This is NOT inside the theme folder
- If you already have a `.htaccess`, replace only the service redirect lines (marked clearly in the file)

### Step 3 — Fix existing page parents in database
Existing service pages in your database still have `post_parent` pointing to the `/services/` page. Run this once to fix them.

**Option A — via WordPress admin (easiest):**
Go to your browser and visit:
```
https://affordablewebsolution.com/wp-admin/
```
Then in the browser address bar run this one-time trigger by visiting:
```
https://affordablewebsolution.com/wp-admin/admin.php?page=tools
```
OR use the WP-CLI command in Step 3B.

**Option B — via WP-CLI (recommended if you have SSH):**
```bash
wp option add nexagen_fix_service_parents yes
# Then load any page on the site — the init hook fires and cleans up automatically
wp cache flush
wp rewrite flush
```

**Option C — via phpMyAdmin (manual):**
Run this SQL query to set post_parent = 0 for all service pages:
```sql
UPDATE wp_posts p
JOIN wp_posts parent ON p.post_parent = parent.ID
SET p.post_parent = 0
WHERE parent.post_name = 'services'
  AND p.post_type = 'page'
  AND p.post_status = 'publish';
```
Replace `wp_` with your actual table prefix if different.

### Step 4 — Flush permalinks
Go to **WordPress Admin → Settings → Permalinks** and click **Save Changes**.
This regenerates rewrite rules without changing your permalink structure.

### Step 5 — Verify
Test these URLs — all should load correctly (200, not 404):
- `https://affordablewebsolution.com/wordpress-support/`
- `https://affordablewebsolution.com/seo-services/`
- `https://affordablewebsolution.com/woocommerce/`
- `https://affordablewebsolution.com/services/` (listing page — should still work)

Test these old URLs — all should 301 redirect to the new URL:
- `https://affordablewebsolution.com/services/wordpress-support/` → 301 to `/wordpress-support/`
- `https://affordablewebsolution.com/services/seo-services/` → 301 to `/seo-services/`

---

## SEO Notes

- 301 redirects preserve ~90–99% of link equity from any external links to old URLs
- Google will re-index new URLs within days to weeks once 301s are in place
- No canonical tag changes needed — WordPress will set them correctly after permalink flush
- If you use Yoast SEO or RankMath, check their XML sitemap after deployment to confirm new URLs appear correctly

---

## Rollback (if something breaks)

1. Restore old theme files from your backup
2. Re-upload the old `.htaccess`
3. Run: `wp rewrite flush` or visit Settings → Permalinks and save
