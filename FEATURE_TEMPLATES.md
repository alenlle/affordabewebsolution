# FEATURE_TEMPLATES.md — Reusable Code Patterns

Copy-paste starting points matching this theme's existing conventions (`nexagen_*` legacy, `aws_*` v1.1). Replace `{placeholder}` values. See `MASTER_RULES.md` before using any of these.

---

## 1. Custom Post Type (nexagen style)

Add inside the existing `nexagen_register_post_types()` function in `functions.php` (hooked on `init`) — don't create a second registration function.

```php
// Inside nexagen_register_post_types(), alongside the other register_post_type() calls:
register_post_type('{post_type_slug}', [
    'labels' => [
        'name'          => __('{Plural Name}', 'affordable-web-solution'),
        'singular_name' => __('{Singular Name}', 'affordable-web-solution'),
        'add_new'       => __('Add {Singular Name}', 'affordable-web-solution'),
        'add_new_item'  => __('Add New {Singular Name}', 'affordable-web-solution'),
        'edit_item'     => __('Edit {Singular Name}', 'affordable-web-solution'),
        'menu_name'     => __('{Plural Name}', 'affordable-web-solution'),
    ],
    'public'       => true,                 // false for admin-only types (see testimonial/team_member)
    'has_archive'  => true,                 // false if no front-end archive needed
    'supports'     => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
    'menu_icon'    => 'dashicons-{icon-name}',
    'rewrite'      => ['slug' => '{post_type_slug}'],
    'show_in_rest' => true,                 // keep true for Gutenberg/REST compatibility
]);
```

After adding a new CPT, set the rewrite-flush flag once (mirrors existing pattern, don't call `flush_rewrite_rules()` unconditionally):

```php
update_option('nexagen_flush_rewrite', 'yes');
```

---

## 2. Customizer field — both patterns

### 2a. `nexagen_*` pattern — agency/content text field

Add inside `nexagen_customizer()` in `functions.php`, to the existing `$fields` (Agency Identity) or `$hero_fields` (Hero) array — don't create a parallel loop.

```php
// Add a new key to the existing $fields array in nexagen_customizer():
'{field_key}' => ['label' => '{Field Label}', 'default' => '{default value}'],
```

Read it anywhere with:

```php
$value = nexagen_opt('{field_key}', '{fallback default}');
```

For a field that needs its own new section (not a simple text field):

```php
$wp_customize->add_section('nexagen_{section_key}', [
    'title' => __('{Section Title}', 'affordable-web-solution'),
    'panel' => 'nexagen_agency',
]);

$wp_customize->add_setting('nexagen_{field_key}', [
    'default'           => '{default}',
    'sanitize_callback' => 'sanitize_text_field',
]);
$wp_customize->add_control('nexagen_{field_key}', [
    'label'   => __('{Field Label}', 'affordable-web-solution'),
    'section' => 'nexagen_{section_key}',
    'type'    => 'text',
]);
```

### 2b. `aws_*` pattern — layout/style/color option

Add inside `aws_header_customizer()` or `aws_footer_customizer()` in `inc/customizer/{header|footer}-customizer.php`. All four pieces are required:

```php
// 1. Setting
$wp_customize->add_setting( 'aws_{field_key}', [
    'default'           => '{default}',
    'transport'         => 'postMessage', // or 'refresh' if no live-preview JS will be added
    'sanitize_callback' => 'sanitize_hex_color', // or aws_sanitize_checkbox / aws_sanitize_choices
] );

// 2. Control
$wp_customize->add_control(
    new WP_Customize_Color_Control( $wp_customize, 'aws_{field_key}', [
        'label'   => __( '{Field Label}', 'affordable-web-solution' ),
        'section' => 'aws_{existing_section_id}',
    ] )
);
```

```php
// 3. Dynamic CSS — add inside aws_customizer_dynamic_css() in customizer-helpers.php
$value = sanitize_hex_color( get_theme_mod( 'aws_{field_key}', '{default}' ) );
// ...inside the ob_start() CSS block:
// .selector { property: <?php echo esc_attr( $value ); ?> !important; }
```

```javascript
// 4. Live preview — add inside customizer-preview.js, only if transport is 'postMessage'
api( 'aws_{field_key}', function ( value ) {
    value.bind( function ( newval ) {
        setCss( '{unique-style-id}', '.selector { property: ' + newval + ' !important; }' );
    } );
} );
```

---

## 3. AJAX handler (secure, nonce-based)

```php
/**
 * Handle {action_name} AJAX request.
 */
function nexagen_handle_{action_name}() {
    check_ajax_referer( '{action_name}_nonce', 'nonce' );

    $field_one = sanitize_text_field( $_POST['field_one'] ?? '' );
    $field_two = sanitize_email( $_POST['field_two']     ?? '' );

    if ( ! $field_one || ! $field_two ) {
        wp_send_json_error( [ 'message' => 'Please fill in all required fields.' ] );
    }

    if ( ! is_email( $field_two ) ) {
        wp_send_json_error( [ 'message' => 'Please enter a valid email address.' ] );
    }

    // ...do the work...

    wp_send_json_success( [ 'message' => 'Done.' ] );
}
add_action( 'wp_ajax_nexagen_{action_name}', 'nexagen_handle_{action_name}' );
// Only add nopriv if logged-out users genuinely need this:
add_action( 'wp_ajax_nopriv_nexagen_{action_name}', 'nexagen_handle_{action_name}' );
```

Create + localize the matching nonce inside `nexagen_scripts()`:

```php
wp_localize_script( 'aws-main', 'awsData', [
    'ajaxUrl' => admin_url( 'admin-ajax.php' ),
    'nonce'   => wp_create_nonce( '{action_name}_nonce' ), // unique per action
] );
```

```javascript
// Client call — fetch pattern matching main.js
const formData = new FormData();
formData.append('action', 'nexagen_{action_name}');
formData.append('nonce', awsData.nonce);
formData.append('field_one', value1);

fetch(awsData.ajaxUrl, { method: 'POST', body: formData })
  .then(res => res.json())
  .then(data => { if (data.success) { /* ... */ } else { /* show data.data.message */ } });
```

---

## 4. Render function (`nexagen_render_*` pattern)

Add to `inc/template-helpers.php`. Call it from a template in `templates/`, never inline the markup in the template itself.

```php
/**
 * Render: {Section Name}.
 */
function nexagen_render_{section_name}(): void {
    $heading = nexagen_opt( '{field_key}', '{Default Heading}' );
    $enabled = get_theme_mod( 'aws_{toggle_key}', '1' );

    if ( '0' === $enabled ) {
        return;
    }
    ?>
    <section class="section" aria-labelledby="{section_name}-heading">
        <div class="container">
            <div class="section-header">
                <div class="section-label">{Label}</div>
                <h2 id="{section_name}-heading"><?php echo esc_html( $heading ); ?></h2>
            </div>

            <!-- section content -->

        </div>
    </section>
    <?php
}
```

---

## 5. Enqueue script + localize

Add inside (or alongside) `nexagen_scripts()` in `functions.php`, hooked on `wp_enqueue_scripts`.

```php
function nexagen_enqueue_{feature_name}() {
    // Optional: only load where actually needed
    if ( ! is_page( '{page-slug}' ) ) {
        return;
    }

    wp_enqueue_style(
        'aws-{feature-name}',
        AWS_ASSETS . '/css/{feature-name}.css',
        [],
        AWS_VERSION
    );

    wp_enqueue_script(
        'aws-{feature-name}',
        AWS_ASSETS . '/js/{feature-name}.js',
        [],
        AWS_VERSION,
        true
    );

    wp_localize_script( 'aws-{feature-name}', '{featureName}Data', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( '{action_name}_nonce' ),
    ] );
}
add_action( 'wp_enqueue_scripts', 'nexagen_enqueue_{feature_name}' );
```

---

## 6. Basic shortcode

No shortcode currently exists in this theme — this is a new pattern, not an existing one. Follow it exactly if a shortcode is genuinely the right tool (most content should go through a render function + template instead, per `MASTER_RULES.md`).

```php
/**
 * Shortcode: [{shortcode_tag}]
 * Usage: [{shortcode_tag} title="Custom Title" count="3"]
 */
function nexagen_{shortcode_tag}_shortcode( $atts ): string {
    $atts = shortcode_atts( [
        'title' => '{Default Title}',
        'count' => 3,
    ], $atts, '{shortcode_tag}' );

    $count = absint( $atts['count'] );
    $title = sanitize_text_field( $atts['title'] );

    ob_start();
    ?>
    <div class="aws-{shortcode_tag}">
        <h3><?php echo esc_html( $title ); ?></h3>
        <!-- shortcode output, using $count etc. -->
    </div>
    <?php
    return ob_get_clean(); // shortcodes must RETURN output, never echo
}
add_shortcode( '{shortcode_tag}', 'nexagen_{shortcode_tag}_shortcode' );
```
