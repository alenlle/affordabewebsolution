<?php
/**
 * Affordable Web Solution Theme Functions
 * 
 * Complete WordPress theme setup including:
 * - Theme support declarations
 * - Asset enqueuing
 * - Navigation menus
 * - Custom post types
 * - Theme customizer
 * - Auto page generation on activation
 * - SEO/Schema helpers
 * - Widget areas
 */

defined('ABSPATH') || exit;

/* ============================================================
   THEME CONSTANTS
   ============================================================ */
define('AWS_VERSION',    '1.0.0');
define('AWS_DIR',        get_template_directory());
define('AWS_URI',        get_template_directory_uri());
define('AWS_ASSETS',     AWS_URI . '/assets');

/* ============================================================
   THEME SETUP
   ============================================================ */
function nexagen_setup() {
    load_theme_textdomain('affordable-web-solution', AWS_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ]);
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ]);
    add_theme_support('customize-selective-refresh-widgets');

    // Image sizes
    add_image_size('aws-hero',     1400, 700,  true);
    add_image_size('aws-card',     600,  400,  true);
    add_image_size('aws-thumb',    400,  300,  true);
    add_image_size('aws-portrait', 400,  500,  true);

    // Menus
    register_nav_menus([
        'primary'  => __('Primary Menu', 'affordable-web-solution'),
        'footer-1' => __('Footer Services', 'affordable-web-solution'),
        'footer-2' => __('Footer Company', 'affordable-web-solution'),
        'footer-3' => __('Footer Clients', 'affordable-web-solution'),
    ]);
}
add_action('after_setup_theme', 'nexagen_setup');

/* ============================================================
   ENQUEUE SCRIPTS & STYLES
   ============================================================ */
function nexagen_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'aws-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap',
        [],
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'aws-style',
        get_stylesheet_uri(),
        ['aws-fonts'],
        AWS_VERSION
    );

    // Main JS
    wp_enqueue_script(
        'aws-main',
        AWS_ASSETS . '/js/main.js',
        [],
        AWS_VERSION,
        true
    );

    // Localize script
    wp_localize_script('aws-main', 'awsData', [
        'ajaxUrl'   => admin_url('admin-ajax.php'),
        'nonce'     => wp_create_nonce('nexagen_nonce'),
        'siteUrl'   => home_url(),
        'themeUrl'  => AWS_URI,
    ]);

    // Comments
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'nexagen_scripts');

/* ============================================================
   WIDGET AREAS
   ============================================================ */
function nexagen_widgets_init() {
    register_sidebar([
        'name'          => __('Blog Sidebar', 'affordable-web-solution'),
        'id'            => 'blog-sidebar',
        'description'   => __('Widgets for blog sidebar', 'affordable-web-solution'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'nexagen_widgets_init');

/* ============================================================
   CUSTOM POST TYPES
   ============================================================ */
function nexagen_register_post_types() {
    // Portfolio / Case Studies
    register_post_type('portfolio', [
        'labels' => [
            'name'               => __('Portfolio', 'affordable-web-solution'),
            'singular_name'      => __('Case Study', 'affordable-web-solution'),
            'add_new'            => __('Add Case Study', 'affordable-web-solution'),
            'add_new_item'       => __('Add New Case Study', 'affordable-web-solution'),
            'edit_item'          => __('Edit Case Study', 'affordable-web-solution'),
            'menu_name'          => __('Portfolio', 'affordable-web-solution'),
        ],
        'public'            => true,
        'has_archive'       => true,
        'supports'          => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon'         => 'dashicons-portfolio',
        'rewrite'           => ['slug' => 'portfolio'],
        'show_in_rest'      => true,
    ]);

    // Testimonials
    register_post_type('testimonial', [
        'labels' => [
            'name'          => __('Testimonials', 'affordable-web-solution'),
            'singular_name' => __('Testimonial', 'affordable-web-solution'),
            'add_new'       => __('Add Testimonial', 'affordable-web-solution'),
            'menu_name'     => __('Testimonials', 'affordable-web-solution'),
        ],
        'public'       => false,
        'show_ui'      => true,
        'supports'     => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'menu_icon'    => 'dashicons-format-quote',
        'show_in_rest' => true,
    ]);

    // Team Members
    register_post_type('team_member', [
        'labels' => [
            'name'          => __('Team Members', 'affordable-web-solution'),
            'singular_name' => __('Team Member', 'affordable-web-solution'),
            'add_new'       => __('Add Team Member', 'affordable-web-solution'),
            'menu_name'     => __('Team', 'affordable-web-solution'),
        ],
        'public'       => false,
        'show_ui'      => true,
        'supports'     => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'menu_icon'    => 'dashicons-groups',
        'show_in_rest' => true,
    ]);

    // Services
    register_post_type('service', [
        'labels' => [
            'name'          => __('Services', 'affordable-web-solution'),
            'singular_name' => __('Service', 'affordable-web-solution'),
            'add_new'       => __('Add Service', 'affordable-web-solution'),
            'menu_name'     => __('Services', 'affordable-web-solution'),
        ],
        'public'       => true,
        'has_archive'  => true,
        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon'    => 'dashicons-admin-tools',
        'rewrite'      => ['slug' => '', 'with_front' => false],
        'show_in_rest' => true,
    ]);

    // Flush on registration (only if needed)
    if (get_option('nexagen_flush_rewrite') === 'yes') {
        flush_rewrite_rules();
        delete_option('nexagen_flush_rewrite');
    }
}
add_action('init', 'nexagen_register_post_types');

/* ============================================================
   CUSTOM TAXONOMIES
   ============================================================ */
function nexagen_register_taxonomies() {
    // Portfolio categories
    register_taxonomy('portfolio_cat', 'portfolio', [
        'labels'       => ['name' => __('Portfolio Categories', 'affordable-web-solution'), 'singular_name' => __('Category', 'affordable-web-solution')],
        'hierarchical' => true,
        'rewrite'      => ['slug' => 'portfolio-category'],
        'show_in_rest' => true,
    ]);

    // Location taxonomy
    register_taxonomy('location', ['page'], [
        'labels'       => ['name' => __('Locations', 'affordable-web-solution'), 'singular_name' => __('Location', 'affordable-web-solution')],
        'hierarchical' => true,
        'rewrite'      => ['slug' => 'location'],
        'public'       => true,
        'show_in_rest' => true,
    ]);

    // Industry taxonomy
    register_taxonomy('industry', ['page', 'service'], [
        'labels'       => ['name' => __('Industries', 'affordable-web-solution'), 'singular_name' => __('Industry', 'affordable-web-solution')],
        'hierarchical' => true,
        'rewrite'      => ['slug' => 'industry'],
        'public'       => true,
        'show_in_rest' => true,
    ]);
}
add_action('init', 'nexagen_register_taxonomies');

/* ============================================================
   THEME CUSTOMIZER
   ============================================================ */
function nexagen_customizer($wp_customize) {
    // ── Agency Info Panel ──
    $wp_customize->add_panel('nexagen_agency', [
        'title'    => __('Agency Settings', 'affordable-web-solution'),
        'priority' => 30,
    ]);

    // Agency Name
    $wp_customize->add_section('nexagen_identity', [
        'title' => __('Agency Identity', 'affordable-web-solution'),
        'panel' => 'nexagen_agency',
    ]);

    $fields = [
        'agency_name'    => ['label' => 'Agency Name',        'default' => 'Affordable Web Solution'],
        'agency_tagline' => ['label' => 'Agency Tagline',     'default' => 'Premium WordPress Design & Development'],
        'agency_phone'   => ['label' => 'Phone Number',       'default' => '+1 (800) 123-4567'],
        'agency_email'   => ['label' => 'Email Address',      'default' => 'hello@affordablewebsolution.com'],
        'agency_address' => ['label' => 'Office Address',     'default' => '123 Digital Ave, San Francisco, CA 94105'],
        'agency_cta_text'=> ['label' => 'CTA Button Text',   'default' => 'Get a Free Quote'],
        'agency_cta_url' => ['label' => 'CTA Button URL',    'default' => '/contact'],
        'facebook_url'   => ['label' => 'Facebook URL',       'default' => ''],
        'twitter_url'    => ['label' => 'Twitter/X URL',      'default' => ''],
        'linkedin_url'   => ['label' => 'LinkedIn URL',       'default' => ''],
        'instagram_url'  => ['label' => 'Instagram URL',      'default' => ''],
        'youtube_url'    => ['label' => 'YouTube URL',        'default' => ''],
    ];

    foreach ($fields as $key => $args) {
        $wp_customize->add_setting("nexagen_{$key}", [
            'default'           => $args['default'],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("nexagen_{$key}", [
            'label'   => __($args['label'], 'affordable-web-solution'),
            'section' => 'nexagen_identity',
            'type'    => 'text',
        ]);
    }

    // Hero Section
    $wp_customize->add_section('nexagen_hero', [
        'title' => __('Homepage Hero', 'affordable-web-solution'),
        'panel' => 'nexagen_agency',
    ]);

    $hero_fields = [
        'hero_title'    => ['label' => 'Hero Title',       'default' => 'The WordPress Agency You\'ve Been Looking For'],
        'hero_subtitle' => ['label' => 'Hero Subtitle',    'default' => 'US-based WordPress design & development agency with 15+ years of experience, 2,500+ projects completed, and 370+ five-star reviews.'],
        'hero_cta1'     => ['label' => 'CTA Button 1',     'default' => 'Get a Free Quote'],
        'hero_cta2'     => ['label' => 'CTA Button 2',     'default' => 'View Our Work'],
        'stats_1_num'   => ['label' => 'Stat 1 Number',    'default' => '370+'],
        'stats_1_label' => ['label' => 'Stat 1 Label',     'default' => '5-Star Reviews'],
        'stats_2_num'   => ['label' => 'Stat 2 Number',    'default' => '2,500+'],
        'stats_2_label' => ['label' => 'Stat 2 Label',     'default' => 'Projects Delivered'],
        'stats_3_num'   => ['label' => 'Stat 3 Number',    'default' => '50+'],
        'stats_3_label' => ['label' => 'Stat 3 Label',     'default' => 'Expert Team Members'],
    ];

    foreach ($hero_fields as $key => $args) {
        $wp_customize->add_setting("nexagen_{$key}", [
            'default'           => $args['default'],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("nexagen_{$key}", [
            'label'   => __($args['label'], 'affordable-web-solution'),
            'section' => 'nexagen_hero',
            'type'    => 'text',
        ]);
    }
}
add_action('customize_register', 'nexagen_customizer');

/* ============================================================
   CUSTOMIZER: Header, Footer & Logo (v1.1 — Astra/OceanWP style)
   These files ONLY add settings; they never remove existing ones.
   ============================================================ */
require_once AWS_DIR . '/inc/customizer/customizer-helpers.php';
require_once AWS_DIR . '/inc/customizer/header-customizer.php';
require_once AWS_DIR . '/inc/customizer/footer-customizer.php';

/* ============================================================
   BODY CLASS: header layout flags
   Adds classes used by CSS / JS for logo position, sticky, etc.
   ============================================================ */
function aws_body_classes( array $classes ): array {
    // Logo position
    $logo_pos = get_theme_mod( 'aws_header_logo_position', 'left' );
    if ( 'center' === $logo_pos ) {
        $classes[] = 'header-logo-center';
    }

    // Sticky header
    if ( '1' === get_theme_mod( 'aws_header_sticky', '1' ) ) {
        $classes[] = 'header-sticky';
    } else {
        $classes[] = 'header-not-sticky';
    }

    // Transparent header on front page
    if ( is_front_page() && '1' === get_theme_mod( 'aws_header_transparent_home', '0' ) ) {
        $classes[] = 'header-transparent';
    }

    return $classes;
}
add_filter( 'body_class', 'aws_body_classes' );

/* ============================================================
   HELPER: Get Customizer Option
   ============================================================ */
function nexagen_opt(string $key, string $default = ''): string {
    return (string) get_theme_mod("nexagen_{$key}", $default);
}

/* ============================================================
   SEO: CUSTOM TITLE TAG
   ============================================================ */
function nexagen_document_title_separator($sep) {
    return '|';
}
add_filter('document_title_separator', 'nexagen_document_title_separator');

/* ============================================================
   SEO: OPEN GRAPH & SCHEMA META
   ============================================================ */
function nexagen_head_meta() {
    global $post;
    $site_name   = get_bloginfo('name');
    $site_url    = home_url();
    $description = get_bloginfo('description');
    $image       = AWS_ASSETS . '/images/og-default.jpg';

    if (is_singular() && $post) {
        $description = wp_strip_all_tags(get_the_excerpt($post));
        if (has_post_thumbnail($post)) {
            $img_data = wp_get_attachment_image_src(get_post_thumbnail_id($post), 'large');
            if ($img_data) $image = $img_data[0];
        }
        $url = get_permalink($post);
        $title = get_the_title($post) . ' | ' . $site_name;
    } else {
        $url   = get_home_url();
        $title = get_bloginfo('name') . ' - ' . get_bloginfo('description');
    }

    echo "\n<!-- Affordable Web Solution SEO Meta -->\n";
    echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";
    echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";

    // Local Business Schema (homepage)
    if (is_front_page()) {
        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'ProfessionalService',
            'name'        => $site_name,
            'url'         => $site_url,
            'telephone'   => nexagen_opt('agency_phone', '+1 (800) 123-4567'),
            'email'       => nexagen_opt('agency_email', 'hello@affordablewebsolution.com'),
            'address'     => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => nexagen_opt('agency_address', '123 Digital Ave'),
                'addressLocality' => 'San Francisco',
                'addressRegion'   => 'CA',
                'addressCountry'  => 'US',
            ],
            'areaServed'       => 'US',
            'serviceType'      => 'WordPress Design & Development',
            'priceRange'       => '$$',
            'aggregateRating'  => [
                '@type'       => 'AggregateRating',
                'ratingValue' => '5',
                'reviewCount' => '370',
            ],
        ];
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
}
add_action('wp_head', 'nexagen_head_meta', 5);

/* ============================================================
   BREADCRUMB SCHEMA
   ============================================================ */
function nexagen_breadcrumb_schema(): array {
    global $post;
    $crumbs = [['name' => 'Home', 'url' => home_url()]];

    if (is_singular()) {
        $post_type = get_post_type($post);
        if ($post_type !== 'post') {
            $obj = get_post_type_object($post_type);
            if ($obj && $obj->has_archive) {
                $crumbs[] = ['name' => $obj->labels->name, 'url' => get_post_type_archive_link($post_type)];
            }
        } else {
            $crumbs[] = ['name' => 'Blog', 'url' => get_permalink(get_option('page_for_posts'))];
        }
        $crumbs[] = ['name' => get_the_title($post), 'url' => get_permalink($post)];
    } elseif (is_page()) {
        $ancestors = get_post_ancestors($post);
        foreach (array_reverse($ancestors) as $anc_id) {
            $crumbs[] = ['name' => get_the_title($anc_id), 'url' => get_permalink($anc_id)];
        }
        $crumbs[] = ['name' => get_the_title($post), 'url' => get_permalink($post)];
    }

    return $crumbs;
}

function nexagen_render_breadcrumb(): void {
    $crumbs = nexagen_breadcrumb_schema();
    if (count($crumbs) < 2) return;

    echo '<nav class="breadcrumb" aria-label="Breadcrumb">';
    $total = count($crumbs);
    foreach ($crumbs as $i => $crumb) {
        if ($i < $total - 1) {
            echo '<a href="' . esc_url($crumb['url']) . '">' . esc_html($crumb['name']) . '</a>';
            echo '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>';
        } else {
            echo '<span>' . esc_html($crumb['name']) . '</span>';
        }
    }
    echo '</nav>';

    // Breadcrumb schema
    $list_items = array_map(function($crumb, $i) {
        return [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $crumb['name'],
            'item'     => $crumb['url'],
        ];
    }, $crumbs, array_keys($crumbs));

    $schema = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $list_items,
    ];
    echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
}

/* ============================================================
   FAQ SCHEMA OUTPUT
   ============================================================ */
function nexagen_faq_schema(array $faqs): void {
    if (empty($faqs)) return;
    $items = array_map(fn($faq) => [
        '@type'          => 'Question',
        'name'           => $faq['q'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
    ], $faqs);

    echo '<script type="application/ld+json">' . wp_json_encode([
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => $items,
    ]) . '</script>';
}

/* ============================================================
   ADMIN COLUMNS: Portfolio
   ============================================================ */
function nexagen_portfolio_columns($cols) {
    return array_merge(
        array_slice($cols, 0, 2, true),
        ['thumbnail' => 'Preview'],
        array_slice($cols, 2, null, true)
    );
}
add_filter('manage_portfolio_posts_columns', 'nexagen_portfolio_columns');

function nexagen_portfolio_columns_content($col, $post_id) {
    if ($col === 'thumbnail' && has_post_thumbnail($post_id)) {
        echo get_the_post_thumbnail($post_id, [60, 60]);
    }
}
add_action('manage_portfolio_posts_custom_column', 'nexagen_portfolio_columns_content', 10, 2);

/* ============================================================
   EXCERPT LENGTH
   ============================================================ */
add_filter('excerpt_length', fn() => 25);
add_filter('excerpt_more',   fn() => '&hellip;');

/* ============================================================
   REMOVE EMOJI SCRIPTS (Performance)
   ============================================================ */
remove_action('wp_head',             'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles',     'print_emoji_styles');
remove_action('admin_print_styles',  'print_emoji_styles');
remove_filter('the_content_feed',    'wp_staticize_emoji');
remove_filter('comment_text_rss',    'wp_staticize_emoji');
remove_filter('wp_mail',             'wp_staticize_emoji_for_email');

/* ============================================================
   DISABLE GUTENBERG ON SPECIFIC TEMPLATES
   ============================================================ */
function nexagen_disable_gutenberg($use, $post_type) {
    return $use;
}
add_filter('use_block_editor_for_post_type', 'nexagen_disable_gutenberg', 10, 2);

/* ============================================================
   CONTACT FORM AJAX HANDLER
   ============================================================ */
function nexagen_handle_contact() {
    check_ajax_referer('nexagen_nonce', 'nonce');

    $name    = sanitize_text_field($_POST['name']    ?? '');
    $email   = sanitize_email($_POST['email']         ?? '');
    $phone   = sanitize_text_field($_POST['phone']   ?? '');
    $service = sanitize_text_field($_POST['service'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    if (!$name || !$email || !$message) {
        wp_send_json_error(['message' => 'Please fill in all required fields.']);
    }

    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Please enter a valid email address.']);
    }

    $to      = nexagen_opt('agency_email', get_option('admin_email'));
    $subject = "New Contact Form Submission from {$name}";
    $body    = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\nService: {$service}\n\nMessage:\n{$message}";
    $headers = ["Content-Type: text/plain; charset=UTF-8", "From: {$name} <{$email}>"];

    if (wp_mail($to, $subject, $body, $headers)) {
        wp_send_json_success(['message' => 'Your message has been sent! We\'ll be in touch within 24 hours.']);
    } else {
        wp_send_json_error(['message' => 'Sorry, there was an error. Please try again or call us directly.']);
    }
}
add_action('wp_ajax_nexagen_contact',        'nexagen_handle_contact');
add_action('wp_ajax_nopriv_nexagen_contact', 'nexagen_handle_contact');

/* ============================================================
   DATA: US STATES & CITIES
   ============================================================ */
function nexagen_get_states(): array {
    return [
        'alabama'        => ['name' => 'Alabama',        'abbr' => 'AL', 'cities' => ['Birmingham', 'Montgomery', 'Huntsville', 'Mobile', 'Tuscaloosa', 'Hoover', 'Auburn', 'Decatur', 'Madison', 'Florence', 'Anniston', 'Dothan']],
        'alaska'         => ['name' => 'Alaska',         'abbr' => 'AK', 'cities' => ['Anchorage', 'Fairbanks', 'Juneau', 'Sitka', 'Ketchikan', 'Wasilla', 'Kenai', 'Kodiak', 'Palmer', 'Nome']],
        'arizona'        => ['name' => 'Arizona',        'abbr' => 'AZ', 'cities' => ['Phoenix', 'Tucson', 'Mesa', 'Chandler', 'Scottsdale', 'Gilbert', 'Glendale', 'Tempe', 'Peoria', 'Surprise', 'Goodyear', 'Buckeye', 'Avondale', 'Maricopa', 'Marana', 'Oro Valley', 'Casa Grande', 'Lake Havasu City', 'Flagstaff', 'Prescott Valley', 'Queen Creek', 'San Tan Valley', 'Casas Adobes', 'Catalina Foothills', 'Cathedral City', 'Yuma']],
        'arkansas'       => ['name' => 'Arkansas',       'abbr' => 'AR', 'cities' => ['Little Rock', 'Fort Smith', 'Fayetteville', 'Springdale', 'Jonesboro', 'North Little Rock', 'Conway', 'Rogers', 'Bentonville', 'Hot Springs', 'Pine Bluff', 'Texarkana']],
        'california'     => ['name' => 'California',     'abbr' => 'CA', 'cities' => ['Los Angeles', 'San Diego', 'San Jose', 'San Francisco', 'Fresno', 'Sacramento', 'Long Beach', 'Oakland', 'Bakersfield', 'Anaheim', 'Santa Ana', 'Riverside', 'Stockton', 'Irvine', 'Chula Vista', 'Fremont', 'San Bernardino', 'Modesto', 'Fontana', 'Moreno Valley', 'Glendale', 'Santa Clarita', 'Garden Grove', 'Oceanside', 'Rancho Cucamonga', 'Ontario', 'Lancaster', 'Elk Grove', 'Palmdale', 'Corona', 'Salinas', 'Pomona', 'Hayward', 'Escondido', 'Sunnyvale', 'Pasadena', 'Torrance', 'Roseville', 'Fullerton', 'Visalia', 'Compton', 'Santa Rosa', 'Thousand Oaks', 'Simi Valley', 'Concord', 'Victorville', 'El Monte', 'Costa Mesa', 'Inglewood', 'Downey', 'Berkeley', 'Murrieta', 'Santa Clara', 'West Covina', 'Richmond', 'Temecula', 'Norwalk', 'Antioch', 'Burbank', 'Daly City', 'El Cajon', 'Santa Maria', 'Jurupa Valley', 'Clovis', 'San Mateo', 'Rialto', 'Chino', 'Vista', 'South Gate', 'Mission Viejo', 'Vacaville', 'Vallejo', 'Carson', 'Fairfield', 'Hesperia', 'Ventura', 'Orange', 'Manteca', 'Rosemead', 'Citrus Heights', 'Lakewood', 'Pomona', 'Hemet', 'Norwalk', 'Hawthorne', 'Whittier', 'Alhambra', 'Tracy', 'Livermore', 'Highland', 'Davie', 'Petaluma', 'Clearwater', 'Napa', 'San Leandro', 'Yuba City', 'Redding', 'Davie', 'Folsom', 'Tuscaloosa', 'Merced', 'Upland', 'Santa Barbara', 'Santa Cruz', 'San Ramon', 'Colton', 'Apple Valley', 'Perris', 'Ceres', 'Tulare', 'Turlock', 'Yucaipa', 'Palo Alto', 'Woodland', 'San Luis Obispo', 'Eastvale', 'Lake Elsinore', 'Lake Forest', 'Lynwood', 'Lodi', 'Gardena', 'El Dorado Hills', 'Madera', 'Pittsburg', 'Huntington Park', 'Mountain View', 'Menifee', 'Gilroy', 'Davis', 'Pico Rivera', 'Indio', 'Redlands', 'Tustin', 'Baldwin Park', 'Delano', 'Watsonville', 'San Jacinto', 'Fountain Valley', 'Paramount', 'Seaside', 'Cupertino', 'Diamond Bar', 'Milpitas', 'Walnut Creek', 'Porterville', 'Novato', 'Poway', 'Santa Monica', 'Pleasanton', 'San Rafael', 'San Clemente', 'Castro Valley', 'Laguna Niguel', 'San Marcos', 'Redondo Beach', 'Rancho Cordova', 'Redwood City', 'Newport Beach', 'Hayward', 'Antelope', 'Arden-Arcade', 'Azusa', 'Brea', 'Buena Park', 'Carmichael', 'Cerritos', 'Covin', 'Cypress', 'El Paso de Robles', 'Florence-Graham', 'Florin', 'Hanford', 'La Habra', 'La Mesa', 'Lincoln', 'Livermore', 'Lodi', 'National City', 'Placentia', 'North Highlands', 'Rancho Santa Margarita', 'Rocklin', 'Santee', 'Union City', 'Westminster', 'Yorba Linda', 'Aliso Viejo']],
        'colorado'       => ['name' => 'Colorado',       'abbr' => 'CO', 'cities' => ['Denver', 'Colorado Springs', 'Aurora', 'Fort Collins', 'Lakewood', 'Thornton', 'Arvada', 'Westminster', 'Pueblo', 'Centennial', 'Boulder', 'Highlands Ranch', 'Greeley', 'Longmont', 'Loveland', 'Broomfield', 'Castle Rock', 'Commerce City', 'Parker', 'Northglenn', 'Brighton', 'Grand Junction', 'Lafayette']],
        'connecticut'    => ['name' => 'Connecticut',    'abbr' => 'CT', 'cities' => ['Bridgeport', 'New Haven', 'Stamford', 'Hartford', 'Waterbury', 'Norwalk', 'Danbury', 'New Britain', 'West Hartford', 'Greenwich', 'Meriden', 'Bristol', 'Milford', 'Middletown', 'Norwich', 'Shelton', 'Torrington', 'New Milford', 'Naugatuck']],
        'delaware'       => ['name' => 'Delaware',       'abbr' => 'DE', 'cities' => ['Wilmington', 'Dover', 'Newark', 'Middletown', 'Smyrna', 'Milford', 'Seaford', 'Georgetown', 'Elsmere', 'New Castle']],
        'florida'        => ['name' => 'Florida',        'abbr' => 'FL', 'cities' => ['Jacksonville', 'Miami', 'Tampa', 'Orlando', 'St. Petersburg', 'Hialeah', 'Tallahassee', 'Fort Lauderdale', 'Cape Coral', 'Pembroke Pines', 'Hollywood', 'Miramar', 'Gainesville', 'Coral Springs', 'Clearwater', 'Miami Gardens', 'Palm Bay', 'Pompano Beach', 'West Palm Beach', 'Lakeland', 'Davie', 'Sunrise', 'Boca Raton', 'Deltona', 'Port St. Lucie', 'Plantation', 'Fort Myers', 'Palmdale', 'Kissimmee', 'Sarasota', 'Doral', 'Brandon', 'Palm Coast', 'Boynton Beach', 'Lauderhill', 'Weston', 'Homestead', 'Delray Beach', 'Melbourne', 'Tamarac', 'Largo', 'Margate', 'Riverview', 'Pine Hills', 'Palm Harbor', 'Ocala', 'Ocoee', 'Spring Hill', 'Lehigh Acres', 'Pensacola', 'Kendall', 'Bradenton', 'Sanford', 'Wellington', 'St. Cloud', 'Port Charlotte', 'Apopka', 'Bonita Springs', 'North Port', 'Kendale Lakes', 'Daytona Beach', 'Jupiter', 'Sunrise Manor', 'Pinellas Park', 'Country Club', 'Panama City', 'Poinciana', 'Leesburg', 'Coconut Creek', 'Tamiami', 'Town N Country', 'University', 'Wesley Chapel', 'Westchester', 'Weston', 'Fountainebleau', 'Horizon West', 'Fort Pierce', 'Palm Desert', 'Port Orange', 'Winter Haven', 'Titusville', 'St. Augustine', 'The Hammocks', 'The Villages', 'Palm Bay', 'St. Pete Beach', 'Sebring', 'Fort Myers Beach', 'New Smyrna Beach']],
        'georgia'        => ['name' => 'Georgia',        'abbr' => 'GA', 'cities' => ['Atlanta', 'Augusta', 'Columbus', 'Macon', 'Savannah', 'Athens', 'Sandy Springs', 'Roswell', 'Johns Creek', 'Albany', 'Warner Robins', 'Alpharetta', 'Marietta', 'Smyrna', 'Gainesville', 'Valdosta', 'South Fulton', 'Stonecrest', 'Brookhaven', 'Dunwoody', 'Dalton']],
        'hawaii'         => ['name' => 'Hawaii',         'abbr' => 'HI', 'cities' => ['Honolulu', 'East Honolulu', 'Pearl City', 'Hilo', 'Kailua', 'Waipahu', 'Kaneohe', 'Mililani', 'Kahului', 'Kihei', 'Ewa Beach', 'Makakilo']],
        'idaho'          => ['name' => 'Idaho',          'abbr' => 'ID', 'cities' => ['Boise', 'Meridian', 'Nampa', 'Idaho Falls', 'Caldwell', 'Pocatello', 'Coeur d\'Alene', 'Twin Falls', 'Lewiston', 'Post Falls']],
        'illinois'       => ['name' => 'Illinois',       'abbr' => 'IL', 'cities' => ['Chicago', 'Aurora', 'Joliet', 'Naperville', 'Rockford', 'Springfield', 'Elgin', 'Peoria', 'Champaign', 'Waukegan', 'Cicero', 'Bloomington', 'Arlington Heights', 'Evanston', 'Decatur', 'Schaumburg', 'Bolingbrook', 'Palatine', 'Skokie', 'Des Plaines', 'Orland Park', 'Tinley Park', 'Oak Park', 'Berwyn', 'Mount Prospect', 'Normal', 'Wheaton', 'Downers Grove', 'Hoffman Estates', 'Oak Lawn', 'Alton', 'Glenview', 'Round Lake Beach']],
        'indiana'        => ['name' => 'Indiana',        'abbr' => 'IN', 'cities' => ['Indianapolis', 'Fort Wayne', 'Evansville', 'South Bend', 'Carmel', 'Fishers', 'Bloomington', 'Hammond', 'Gary', 'Lafayette', 'Noblesville', 'Muncie', 'Columbus', 'Anderson', 'Terre Haute', 'Lawrence', 'Jeffersonville', 'Westfield', 'Kokomo', 'Michigan City', 'Mishawaka', 'Elkhart']],
        'iowa'           => ['name' => 'Iowa',           'abbr' => 'IA', 'cities' => ['Des Moines', 'Cedar Rapids', 'Davenport', 'Sioux City', 'Iowa City', 'Waterloo', 'Council Bluffs', 'Ames', 'West Des Moines', 'Dubuque', 'Ankeny', 'Urbandale', 'Cedar Falls', 'Marion', 'Bettendorf']],
        'kansas'         => ['name' => 'Kansas',         'abbr' => 'KS', 'cities' => ['Wichita', 'Overland Park', 'Kansas City', 'Olathe', 'Topeka', 'Lawrence', 'Shawnee', 'Lenexa', 'Manhattan', 'Salina', 'Hutchinson', 'Manhattan', 'Leavenworth']],
        'kentucky'       => ['name' => 'Kentucky',       'abbr' => 'KY', 'cities' => ['Louisville', 'Lexington', 'Bowling Green', 'Owensboro', 'Covington', 'Hopkinsville', 'Richmond', 'Florence', 'Georgetown', 'Elizabethtown', 'Henderson', 'Nicholasville', 'Jeffersontown']],
        'louisiana'      => ['name' => 'Louisiana',      'abbr' => 'LA', 'cities' => ['New Orleans', 'Baton Rouge', 'Shreveport', 'Metairie', 'Lafayette', 'Lake Charles', 'Kenner', 'Bossier City', 'Monroe', 'Alexandria', 'Houma', 'Mandeville', 'Slidell', 'Hammond', 'Laplace']],
        'maine'          => ['name' => 'Maine',          'abbr' => 'ME', 'cities' => ['Portland', 'Lewiston', 'Bangor', 'South Portland', 'Auburn', 'Biddeford', 'Sanford', 'Augusta', 'Saco', 'Westbrook']],
        'maryland'       => ['name' => 'Maryland',       'abbr' => 'MD', 'cities' => ['Baltimore', 'Frederick', 'Rockville', 'Gaithersburg', 'Bowie', 'Hagerstown', 'Annapolis', 'College Park', 'Salisbury', 'Waldorf', 'Columbia', 'Silver Spring', 'Germantown', 'Bethesda', 'Towson', 'Glen Burnie', 'Ellicott City', 'Dundalk', 'Wheaton', 'Aspen Hill', 'Severn', 'Bel Air South']],
        'massachusetts'  => ['name' => 'Massachusetts',  'abbr' => 'MA', 'cities' => ['Boston', 'Worcester', 'Springfield', 'Cambridge', 'Lowell', 'Brockton', 'Quincy', 'Lynn', 'New Bedford', 'Fall River', 'Newton', 'Lawrence', 'Somerville', 'Framingham', 'Haverhill', 'Waltham', 'Malden', 'Revere', 'Medford', 'Taunton', 'Chicopee', 'Everett', 'Peabody', 'Methuen Town', 'Leominster']],
        'michigan'       => ['name' => 'Michigan',       'abbr' => 'MI', 'cities' => ['Detroit', 'Grand Rapids', 'Warren', 'Sterling Heights', 'Ann Arbor', 'Lansing', 'Flint', 'Dearborn', 'Livonia', 'Westland', 'Troy', 'Farmington Hills', 'Kalamazoo', 'Wyoming', 'Southfield', 'Rochester Hills', 'Taylor', 'Pontiac', 'St. Clair Shores', 'Royal Oak', 'Novi', 'Dearborn Heights', 'Battle Creek', 'Saginaw', 'Kentwood', 'East Lansing', 'Roseville', 'Portage', 'Muskegon', 'Bay City', 'Jackson', 'Michigan City', 'Holland', 'South Lyon']],
        'minnesota'      => ['name' => 'Minnesota',      'abbr' => 'MN', 'cities' => ['Minneapolis', 'Saint Paul', 'Rochester', 'Duluth', 'Bloomington', 'Brooklyn Park', 'Plymouth', 'Maple Grove', 'Woodbury', 'St. Cloud', 'Eagan', 'Eden Prairie', 'Coon Rapids', 'Burnsville', 'Apple Valley', 'Blaine', 'Lakeville', 'Minnetonka', 'Brooklyn Center', 'Edina', 'St. Louis Park', 'Moorhead', 'Maplewood', 'Mankato']],
        'mississippi'    => ['name' => 'Mississippi',    'abbr' => 'MS', 'cities' => ['Jackson', 'Gulfport', 'Southaven', 'Hattiesburg', 'Biloxi', 'Meridian', 'Tupelo', 'Greenville', 'Olive Branch', 'Horn Lake', 'Clinton', 'Pearl']],
        'missouri'       => ['name' => 'Missouri',       'abbr' => 'MO', 'cities' => ['Kansas City', 'St. Louis', 'Springfield', 'Columbia', 'Independence', 'Lee\'s Summit', 'O\'Fallon', 'St. Joseph', 'St. Charles', 'Blue Springs', 'Joplin', 'Florissant', 'Chesterfield', 'Jefferson City', 'St. Peters', 'Missouri City']],
        'montana'        => ['name' => 'Montana',        'abbr' => 'MT', 'cities' => ['Billings', 'Missoula', 'Great Falls', 'Bozeman', 'Butte', 'Helena', 'Kalispell', 'Havre', 'Anaconda', 'Miles City']],
        'nebraska'       => ['name' => 'Nebraska',       'abbr' => 'NE', 'cities' => ['Omaha', 'Lincoln', 'Bellevue', 'Grand Island', 'Kearney', 'Fremont', 'Hastings', 'Norfolk', 'North Platte', 'Columbus']],
        'nevada'         => ['name' => 'Nevada',         'abbr' => 'NV', 'cities' => ['Las Vegas', 'Henderson', 'Reno', 'North Las Vegas', 'Sparks', 'Carson City', 'Enterprise', 'Spring Valley', 'Sunrise Manor', 'Paradise']],
        'new-hampshire'  => ['name' => 'New Hampshire',  'abbr' => 'NH', 'cities' => ['Manchester', 'Nashua', 'Concord', 'Derry', 'Dover', 'Rochester', 'Portsmouth', 'Salem', 'Merrimack', 'Hudson', 'Londonderry', 'Keene']],
        'new-jersey'     => ['name' => 'New Jersey',     'abbr' => 'NJ', 'cities' => ['Newark', 'Jersey City', 'Paterson', 'Elizabeth', 'Lakewood', 'Trenton', 'Camden', 'Clifton', 'Passaic', 'East Orange', 'Union City', 'Plainfield', 'Bayonne', 'New Brunswick', 'Hoboken', 'Perth Amboy', 'Vineland', 'West New York']],
        'new-mexico'     => ['name' => 'New Mexico',     'abbr' => 'NM', 'cities' => ['Albuquerque', 'Las Cruces', 'Rio Rancho', 'Santa Fe', 'Roswell', 'Farmington', 'Clovis', 'Hobbs', 'Alamogordo', 'Carlsbad', 'Gallup']],
        'new-york'       => ['name' => 'New York',       'abbr' => 'NY', 'cities' => ['New York City', 'Buffalo', 'Rochester', 'Yonkers', 'Syracuse', 'Albany', 'New Rochelle', 'Mount Vernon', 'Schenectady', 'Utica', 'White Plains', 'Hempstead', 'Troy', 'Niagara Falls', 'Binghamton', 'Freeport', 'Valley Stream', 'Queens', 'Brooklyn', 'Bronx', 'Manhattan', 'Staten Island', 'Levittown', 'Saratoga Springs', 'Glens Falls', 'Poughkeepsie', 'Ithaca', 'Corning', 'Horseheads']],
        'north-carolina' => ['name' => 'North Carolina', 'abbr' => 'NC', 'cities' => ['Charlotte', 'Raleigh', 'Greensboro', 'Durham', 'Winston-Salem', 'Fayetteville', 'Cary', 'Wilmington', 'High Point', 'Concord', 'Asheville', 'Gastonia', 'Chapel Hill', 'Jacksonville', 'Rocky Mount', 'Kannapolis', 'Burlington', 'Wilson', 'Apex', 'Huntersville', 'Mooresville', 'Greenville', 'Hickory']],
        'north-dakota'   => ['name' => 'North Dakota',   'abbr' => 'ND', 'cities' => ['Fargo', 'Bismarck', 'Grand Forks', 'Minot', 'West Fargo', 'Williston', 'Mandan', 'Dickinson', 'Jamestown', 'Devils Lake']],
        'ohio'           => ['name' => 'Ohio',            'abbr' => 'OH', 'cities' => ['Columbus', 'Cleveland', 'Cincinnati', 'Toledo', 'Akron', 'Dayton', 'Parma', 'Canton', 'Youngstown', 'Lorain', 'Hamilton', 'Springfield', 'Kettering', 'Elyria', 'Lakewood', 'Cuyahoga Falls', 'Euclid', 'Middletown', 'Dublin', 'Newark', 'Westerville', 'Fairfield', 'Mansfield', 'Lima']],
        'oklahoma'       => ['name' => 'Oklahoma',       'abbr' => 'OK', 'cities' => ['Oklahoma City', 'Tulsa', 'Norman', 'Broken Arrow', 'Edmond', 'Lawton', 'Moore', 'Midwest City', 'Enid', 'Stillwater', 'Muskogee', 'Owasso']],
        'oregon'         => ['name' => 'Oregon',         'abbr' => 'OR', 'cities' => ['Portland', 'Eugene', 'Salem', 'Gresham', 'Hillsboro', 'Beaverton', 'Bend', 'Medford', 'Springfield', 'Corvallis', 'Albany', 'Tigard', 'Aloha', 'Lake Oswego', 'Longview']],
        'pennsylvania'   => ['name' => 'Pennsylvania',   'abbr' => 'PA', 'cities' => ['Philadelphia', 'Pittsburgh', 'Allentown', 'Erie', 'Reading', 'Scranton', 'Bethlehem', 'Lancaster', 'Harrisburg', 'Altoona', 'York', 'State College', 'Wilkes-Barre', 'Chester', 'Lebanon', 'Levittown']],
        'rhode-island'   => ['name' => 'Rhode Island',   'abbr' => 'RI', 'cities' => ['Providence', 'Cranston', 'Warwick', 'Pawtucket', 'East Providence', 'Woonsocket', 'Newport', 'Central Falls', 'North Providence', 'Westerly']],
        'south-carolina' => ['name' => 'South Carolina', 'abbr' => 'SC', 'cities' => ['Columbia', 'Charleston', 'North Charleston', 'Mount Pleasant', 'Rock Hill', 'Greenville', 'Summerville', 'Sumter', 'Goose Creek', 'Hilton Head Island', 'Florence', 'Spartanburg', 'Myrtle Beach', 'Mauldin']],
        'south-dakota'   => ['name' => 'South Dakota',   'abbr' => 'SD', 'cities' => ['Sioux Falls', 'Rapid City', 'Aberdeen', 'Brookings', 'Watertown', 'Mitchell', 'Yankton', 'Pierre', 'Huron', 'Spearfish']],
        'tennessee'      => ['name' => 'Tennessee',      'abbr' => 'TN', 'cities' => ['Nashville', 'Memphis', 'Knoxville', 'Chattanooga', 'Clarksville', 'Murfreesboro', 'Franklin', 'Jackson', 'Johnson City', 'Bartlett', 'Hendersonville', 'Kingsport', 'Collierville', 'Cleveland', 'Smyrna', 'Morristown', 'Spring Hill', 'Bristol']],
        'texas'          => ['name' => 'Texas',          'abbr' => 'TX', 'cities' => ['Houston', 'San Antonio', 'Dallas', 'Austin', 'Fort Worth', 'El Paso', 'Arlington', 'Corpus Christi', 'Plano', 'Laredo', 'Lubbock', 'Garland', 'Irving', 'Amarillo', 'Grand Prairie', 'McKinney', 'Frisco', 'Brownsville', 'Pasadena', 'Killeen', 'McAllen', 'Denton', 'Midland', 'Waco', 'Carrollton', 'Odessa', 'Abilene', 'Beaumont', 'Round Rock', 'Pearland', 'Richardson', 'Lewisville', 'College Station', 'Tyler', 'League City', 'Wichita Falls', 'Allen', 'Sugar Land', 'Edinburg', 'The Woodlands', 'Mesquite', 'Pharr', 'San Angelo', 'Conroe', 'Longview', 'New Braunfels', 'Temple', 'Baytown', 'Missouri City', 'North Richland Hills', 'Harlingen', 'Grapevine', 'Flower Mound', 'Mansfield', 'Rowlett', 'Burleson', 'Galveston', 'Texarkana', 'Bryan', 'Pflugerville', 'Leander', 'Georgetown', 'Cedar Park', 'Kyle', 'Cedar Hill', 'Victoria', 'DeSoto', 'Bedford', 'Euless', 'Port Arthur', 'Spring', 'Atascocita', 'Sherman', 'Texas City', 'Wylie', 'San Marcos', 'Rockwall', 'Mission', 'Little Elm']],
        'utah'           => ['name' => 'Utah',           'abbr' => 'UT', 'cities' => ['Salt Lake City', 'West Valley City', 'Provo', 'West Jordan', 'Orem', 'Sandy', 'Ogden', 'St. George', 'Layton', 'South Jordan', 'Taylorsville', 'Millcreek', 'Murray', 'Lehi', 'Herriman', 'Logan', 'Draper', 'Eagle Mountain', 'Cedar City', 'Roy']],
        'vermont'        => ['name' => 'Vermont',        'abbr' => 'VT', 'cities' => ['Burlington', 'South Burlington', 'Rutland', 'Barre', 'Montpelier', 'Winooski', 'St. Albans', 'Newport', 'Vergennes']],
        'virginia'       => ['name' => 'Virginia',       'abbr' => 'VA', 'cities' => ['Virginia Beach', 'Norfolk', 'Chesapeake', 'Richmond', 'Newport News', 'Alexandria', 'Hampton', 'Roanoke', 'Portsmouth', 'Suffolk', 'Lynchburg', 'Harrisonburg', 'Leesburg', 'Charlottesville', 'Blacksburg', 'Dale City', 'Centreville', 'Reston', 'McLean', 'Tuckahoe', 'Fredericksburg', 'Manassas', 'Arlington', 'Winchester', 'Chantilly', 'Fairfax', 'Williamsburg']],
        'washington'     => ['name' => 'Washington',     'abbr' => 'WA', 'cities' => ['Seattle', 'Spokane', 'Tacoma', 'Vancouver', 'Bellevue', 'Kent', 'Everett', 'Renton', 'Kirkland', 'Bellingham', 'Kennewick', 'Yakima', 'Redmond', 'Marysville', 'South Hill', 'Richland', 'Shoreline', 'Lakewood', 'Burien', 'Sammamish', 'Lacey', 'Pasco', 'Longview', 'Olympia', 'Federal Way', 'Auburn', 'Wenatchee', 'Mount Vernon', 'Bothell']],
        'west-virginia'  => ['name' => 'West Virginia',  'abbr' => 'WV', 'cities' => ['Charleston', 'Huntington', 'Morgantown', 'Parkersburg', 'Wheeling', 'Weirton', 'Fairmont', 'Martinsburg', 'Beckley', 'Lewisburg']],
        'wisconsin'      => ['name' => 'Wisconsin',      'abbr' => 'WI', 'cities' => ['Milwaukee', 'Madison', 'Green Bay', 'Kenosha', 'Racine', 'Appleton', 'Waukesha', 'Oshkosh', 'Eau Claire', 'Janesville', 'West Allis', 'La Crosse', 'Sheboygan', 'Wauwatosa', 'Wausau', 'Waukegan']],
        'wyoming'        => ['name' => 'Wyoming',        'abbr' => 'WY', 'cities' => ['Cheyenne', 'Casper', 'Laramie', 'Gillette', 'Rock Springs', 'Sheridan', 'Green River', 'Evanston', 'Riverton', 'Cody']],
    ];
}

/* ============================================================
   DATA: SERVICES
   ============================================================ */
function nexagen_get_services(): array {
    return [
        ['slug' => 'wordpress-design',        'title' => 'WordPress Website Design',       'icon' => '🎨', 'img' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=600&h=340&fit=crop&auto=format&q=75', 'desc' => 'Beautiful, handcrafted WordPress websites built by award-winning designers.'],
        ['slug' => 'wordpress-development',   'title' => 'WordPress Development',          'icon' => '💻', 'img' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600&h=340&fit=crop&auto=format&q=75', 'desc' => 'Custom WordPress development with deep technical expertise and clean code.'],
        ['slug' => 'wordpress-maintenance',   'title' => 'WordPress Maintenance',          'icon' => '🔧', 'img' => 'https://images.unsplash.com/photo-1518432031352-d6fc5c10da5a?w=600&h=340&fit=crop&auto=format&q=75', 'desc' => 'Proactive, expert maintenance keeping your site secure, fast, and up to date.'],
        ['slug' => 'wordpress-hosting',       'title' => 'Managed WordPress Hosting',      'icon' => '🚀', 'img' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600&h=340&fit=crop&auto=format&q=75', 'desc' => 'Ultra-fast, secure, fully managed WordPress hosting on world-class infrastructure.'],
        ['slug' => 'wordpress-support',       'title' => 'WordPress Support',              'icon' => '🛡️',  'img' => 'https://images.unsplash.com/photo-1553877522-43269d4ea984?w=600&h=340&fit=crop&auto=format&q=75', 'desc' => 'Expert on-demand WordPress support available when you need it most.'],
        ['slug' => 'seo-services',            'title' => 'Search Engine Optimization',     'icon' => '📈', 'img' => 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=600&h=340&fit=crop&auto=format&q=75', 'desc' => 'Data-driven SEO strategies that drive qualified traffic and grow your business.'],
        ['slug' => 'wordpress-security',      'title' => 'WordPress Security',             'icon' => '🔒', 'img' => 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=600&h=340&fit=crop&auto=format&q=75', 'desc' => 'Comprehensive security hardening, monitoring, and malware removal.'],
        ['slug' => 'wordpress-speed',         'title' => 'WordPress Speed Optimization',   'icon' => '⚡', 'img' => 'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=600&h=340&fit=crop&auto=format&q=75', 'desc' => 'Core Web Vitals optimization for 90+ PageSpeed scores and sub-second loads.'],
        ['slug' => 'woocommerce',             'title' => 'WooCommerce Development',        'icon' => '🛒', 'img' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=340&fit=crop&auto=format&q=75', 'desc' => 'Custom WooCommerce stores that convert visitors into loyal customers.'],
        ['slug' => 'wordpress-migration',     'title' => 'WordPress Migration',            'icon' => '🔄', 'img' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=600&h=340&fit=crop&auto=format&q=75', 'desc' => 'Seamless, risk-free WordPress migrations with zero data loss.'],
        ['slug' => 'wordpress-ada',           'title' => 'ADA Compliance',                 'icon' => '♿', 'img' => 'https://images.unsplash.com/photo-1573164713988-8665fc963095?w=600&h=340&fit=crop&auto=format&q=75', 'desc' => 'WCAG 2.1 compliance to make your website accessible to all users.'],
        ['slug' => 'white-label-wordpress',   'title' => 'White Label WordPress',          'icon' => '🏷️',  'img' => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=600&h=340&fit=crop&auto=format&q=75', 'desc' => 'White label WordPress services for agencies and resellers.'],
    ];
}

/* ============================================================
   DATA: INDUSTRIES
   ============================================================ */
function nexagen_get_industries(): array {
    return [
        ['slug' => 'healthcare',     'title' => 'Healthcare',          'icon' => '🏥', 'img' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'legal',          'title' => 'Legal / Law Firms',   'icon' => '⚖️', 'img' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'dental',         'title' => 'Dental Practices',    'icon' => '🦷', 'img' => 'https://images.unsplash.com/photo-1588776814546-daab30f310ce?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'restaurant',     'title' => 'Restaurants & Cafes', 'icon' => '🍽️', 'img' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'real-estate',    'title' => 'Real Estate',         'icon' => '🏠', 'img' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'non-profit',     'title' => 'Non-Profits',         'icon' => '🤝', 'img' => 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'construction',   'title' => 'Construction',        'icon' => '🏗️', 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'education',      'title' => 'Education',           'icon' => '🎓', 'img' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'saas',           'title' => 'SaaS & Tech',         'icon' => '☁️', 'img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'ecommerce',      'title' => 'eCommerce',           'icon' => '🛍️', 'img' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'finance',        'title' => 'Finance',             'icon' => '💰', 'img' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'hospitality',    'title' => 'Hospitality',         'icon' => '🏨', 'img' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'gym-fitness',    'title' => 'Gym & Fitness',       'icon' => '💪', 'img' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'startup',        'title' => 'Startups',            'icon' => '🚀', 'img' => 'https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'corporate',      'title' => 'Corporate',           'icon' => '🏢', 'img' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400&h=260&fit=crop&auto=format&q=70'],
        ['slug' => 'small-business', 'title' => 'Small Business',      'icon' => '🏪', 'img' => 'https://images.unsplash.com/photo-1556742044-3c52d6e88c62?w=400&h=260&fit=crop&auto=format&q=70'],
    ];
}

/* ============================================================
   AUTO PAGE GENERATION ON THEME ACTIVATION
   ============================================================ */
function nexagen_activate(): void {
    nexagen_create_core_pages();
    nexagen_create_service_pages();
    nexagen_create_industry_pages();
    nexagen_create_state_pages();
    nexagen_setup_menus();
    update_option('nexagen_flush_rewrite', 'yes');
    update_option('nexagen_activated', '1');
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'nexagen_activate');

/* ── Core Pages ── */
function nexagen_create_core_pages(): void {
    $pages = [
        [
            'title'    => 'Home',
            'slug'     => 'home',
            'template' => 'templates/template-home.php',
            'content'  => '',
            'set_front'=> true,
        ],
        [
            'title'    => 'About Us',
            'slug'     => 'about',
            'template' => 'templates/template-about.php',
            'content'  => nexagen_get_about_content(),
        ],
        [
            'title'    => 'Portfolio',
            'slug'     => 'portfolio',
            'template' => 'templates/template-portfolio.php',
            'content'  => '',
        ],
        [
            'title'    => 'Blog',
            'slug'     => 'blog',
            'template' => '',
            'content'  => '',
            'set_blog' => true,
        ],
        [
            'title'    => 'Contact Us',
            'slug'     => 'contact',
            'template' => 'templates/template-contact.php',
            'content'  => nexagen_get_contact_content(),
        ],
        [
            'title'    => 'FAQ',
            'slug'     => 'faq',
            'template' => 'templates/template-faq.php',
            'content'  => nexagen_get_faq_content(),
        ],
        [
            'title'    => 'Pricing',
            'slug'     => 'pricing',
            'template' => 'templates/template-pricing.php',
            'content'  => '',
        ],
        [
            'title'    => 'Privacy Policy',
            'slug'     => 'privacy-policy',
            'template' => '',
            'content'  => '<p>Your privacy is important to us. This privacy policy explains how we collect, use, and protect your personal information when you visit our website.</p>',
        ],
        [
            'title'    => 'Terms of Service',
            'slug'     => 'terms',
            'template' => '',
            'content'  => '<p>By using our services, you agree to these terms of service. Please read them carefully.</p>',
        ],
        [
            'title'    => 'Services',
            'slug'     => 'services',
            'template' => 'templates/template-services.php',
            'content'  => '',
        ],
        [
            'title'    => 'Industries We Serve',
            'slug'     => 'industries',
            'template' => 'templates/template-industries.php',
            'content'  => '',
        ],
        [
            'title'    => 'Locations',
            'slug'     => 'locations',
            'template' => 'templates/template-locations.php',
            'content'  => '',
        ],
        [
            'title'    => 'Team',
            'slug'     => 'team',
            'template' => 'templates/template-team.php',
            'content'  => nexagen_get_team_content(),
        ],
        [
            'title'    => 'Testimonials',
            'slug'     => 'testimonials',
            'template' => 'templates/template-testimonials.php',
            'content'  => '',
        ],
        [
            'title'    => 'Careers',
            'slug'     => 'careers',
            'template' => '',
            'content'  => nexagen_get_careers_content(),
        ],
    ];

    foreach ($pages as $page_data) {
        $existing = get_page_by_path($page_data['slug']);
        if ($existing) continue;

        $page_id = wp_insert_post([
            'post_title'   => $page_data['title'],
            'post_name'    => $page_data['slug'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => $page_data['content'] ?? '',
        ]);

        if (is_wp_error($page_id)) continue;

        if (!empty($page_data['template'])) {
            update_post_meta($page_id, '_wp_page_template', $page_data['template']);
        }

        if (!empty($page_data['set_front'])) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $page_id);
        }

        if (!empty($page_data['set_blog'])) {
            update_option('page_for_posts', $page_id);
        }
    }
}

/* ── Service Pages ── */
function nexagen_create_service_pages(): void {
    $services = nexagen_get_services();

    foreach ($services as $svc) {
        if (get_page_by_path($svc['slug'])) continue;

        $content = nexagen_generate_service_content($svc['title'], $svc['desc']);

        $page_id = wp_insert_post([
            'post_title'   => $svc['title'],
            'post_name'    => $svc['slug'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_parent'  => 0,
            'post_content' => $content,
        ]);

        if (!is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'templates/template-service-single.php');
            update_post_meta($page_id, '_nexagen_service_icon', $svc['icon']);
        }
    }
}

/* ── Industry Pages ── */
function nexagen_create_industry_pages(): void {
    $industries = nexagen_get_industries();
    $parent     = get_page_by_path('industries');
    $parent_id  = $parent ? $parent->ID : 0;

    foreach ($industries as $ind) {
        if (get_page_by_path($ind['slug'])) continue;

        $content = nexagen_generate_industry_content($ind['title']);

        $page_id = wp_insert_post([
            'post_title'   => $ind['title'] . ' Web Design & Development',
            'post_name'    => $ind['slug'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_parent'  => $parent_id,
            'post_content' => $content,
        ]);

        if (!is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'templates/template-industry.php');
            update_post_meta($page_id, '_nexagen_industry_icon', $ind['icon']);
        }
    }
}

/* ── State + City Pages ── */
function nexagen_create_state_pages(): void {
    $states    = nexagen_get_states();
    $loc_parent = get_page_by_path('locations');
    $parent_id  = $loc_parent ? $loc_parent->ID : 0;

    foreach ($states as $slug => $state) {
        $state_page = get_page_by_path($slug);

        if (!$state_page) {
            $content = nexagen_generate_state_content($state['name'], $state['abbr'], $state['cities']);

            $state_id = wp_insert_post([
                'post_title'   => 'WordPress Web Design in ' . $state['name'],
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_parent'  => $parent_id,
                'post_content' => $content,
            ]);

            if (!is_wp_error($state_id)) {
                update_post_meta($state_id, '_wp_page_template', 'templates/template-state.php');
                update_post_meta($state_id, '_nexagen_state_name', $state['name']);
                update_post_meta($state_id, '_nexagen_state_abbr', $state['abbr']);
            }
        } else {
            $state_id = $state_page->ID;
        }

        // City pages
        foreach ($state['cities'] as $city) {
            $city_slug = sanitize_title($city . '-' . strtolower($state['abbr']));
            if (get_page_by_path($city_slug)) continue;

            $city_content = nexagen_generate_city_content($city, $state['name'], $state['abbr']);

            $city_id = wp_insert_post([
                'post_title'   => 'WordPress Web Design in ' . $city . ', ' . $state['abbr'],
                'post_name'    => $city_slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_parent'  => $state_id,
                'post_content' => $city_content,
            ]);

            if (!is_wp_error($city_id)) {
                update_post_meta($city_id, '_wp_page_template', 'templates/template-city.php');
                update_post_meta($city_id, '_nexagen_city_name',  $city);
                update_post_meta($city_id, '_nexagen_state_name', $state['name']);
                update_post_meta($city_id, '_nexagen_state_abbr', $state['abbr']);
            }
        }
    }
}

/* ── Setup Menus ── */
function nexagen_setup_menus(): void {
    $menu_name = 'Primary Menu';
    $menu_id   = wp_get_nav_menu_object($menu_name);

    if (!$menu_id) {
        $menu_id = wp_create_nav_menu($menu_name);
    }

    $items = [
        ['title' => 'Services',   'url' => '/services/'],
        ['title' => 'Industries', 'url' => '/industries/'],
        ['title' => 'Locations',  'url' => '/locations/'],
        ['title' => 'Portfolio',  'url' => '/portfolio/'],
        ['title' => 'Blog',       'url' => '/blog/'],
        ['title' => 'About',      'url' => '/about/'],
        ['title' => 'Contact',    'url' => '/contact/'],
    ];

    foreach ($items as $order => $item) {
        wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'  => $item['title'],
            'menu-item-url'    => $item['url'],
            'menu-item-status' => 'publish',
            'menu-item-position' => $order + 1,
        ]);
    }

    $locations = get_theme_mod('nav_menu_locations', []);
    $locations['primary'] = is_object($menu_id) ? $menu_id->term_id : $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}

/* ============================================================
   CONTENT GENERATORS
   ============================================================ */
function nexagen_generate_service_content(string $title, string $desc): string {
    return "<!-- wp:paragraph -->
<p>{$desc} Our expert team brings years of experience and a proven track record to every project. Whether you're a small business owner or a large enterprise, we deliver solutions tailored to your unique needs and goals.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Why Choose Our {$title} Services?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>When you partner with Affordable Web Solution for {$title}, you get more than just a service — you get a dedicated team committed to your success. We combine technical excellence with creative thinking to deliver results that matter.</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li><strong>Expert Team:</strong> Certified specialists with deep WordPress expertise</li>
<li><strong>Proven Process:</strong> A refined workflow that delivers on time, every time</li>
<li><strong>Transparent Communication:</strong> Regular updates and clear reporting</li>
<li><strong>Results-Driven:</strong> Every decision is made with your business goals in mind</li>
<li><strong>Ongoing Support:</strong> We're with you long after launch</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2>Our Approach to {$title}</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We begin every engagement with a thorough discovery process to understand your business, your audience, and your goals. This foundation allows us to create solutions that are not just technically excellent, but strategically aligned with what you're trying to achieve.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>Discovery & Strategy</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We start by learning everything about your business — your goals, your audience, your competitors, and your current challenges. This deep understanding guides every decision we make throughout the project.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>Design & Development</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Our team of designers and developers work in close collaboration to bring your vision to life. Every element is crafted with purpose — aesthetics, functionality, and performance all work together seamlessly.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>Testing & Launch</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Before launch, we conduct comprehensive testing across all devices and browsers. We don't launch until everything is perfect. After launch, we monitor performance and make any necessary adjustments.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>Ongoing Optimization</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Our relationship doesn't end at launch. We provide ongoing support, monitoring, and optimization to ensure your solution continues to perform and improve over time.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Frequently Asked Questions</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Here are answers to the most common questions about our {$title} services:</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>How long does the process take?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Timelines vary based on project scope and complexity. Typically, projects range from 2-8 weeks. During your initial consultation, we'll provide a detailed timeline tailored to your specific requirements.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>What is your pricing?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Our pricing is transparent and based on your project's scope. We offer packages for businesses of all sizes, from startups to large enterprises. Contact us for a custom quote tailored to your needs.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>Do you offer ongoing support?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Absolutely. We offer comprehensive ongoing support and maintenance plans to keep your website running at peak performance. Our team is always available to assist with updates, issues, or new features.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Ready to get started? Contact our team today for a free consultation and discover how our {$title} services can transform your online presence.</p>
<!-- /wp:paragraph -->";
}

function nexagen_generate_industry_content(string $industry): string {
    return "<!-- wp:paragraph -->
<p>Affordable Web Solution specializes in delivering premium WordPress web design and development solutions for the {$industry} industry. We understand the unique challenges, compliance requirements, and audience expectations that {$industry} businesses face — and we build websites that address all of them while driving real business results.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>WordPress Web Design for {$industry} Organizations</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Your website is often the first point of contact between your {$industry} organization and potential clients or customers. In today's competitive digital landscape, a generic template simply won't cut it. You need a website that reflects your expertise, builds trust, and converts visitors into clients.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>That's where Affordable Web Solution comes in. With over 15 years of experience building websites for {$industry} organizations across the United States, we know what works. We've helped hundreds of {$industry} businesses grow their online presence, generate more leads, and build stronger brands.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>What Makes a Great {$industry} Website?</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Trust Signals:</strong> Professional design, credentials, and social proof that establish credibility instantly</li>
<li><strong>Clear Value Proposition:</strong> Visitors should immediately understand what you do and why you're the best choice</li>
<li><strong>Conversion-Optimized Layout:</strong> Strategic placement of CTAs that guide visitors toward taking action</li>
<li><strong>Mobile-First Design:</strong> Over 60% of web traffic comes from mobile devices — your site must perform flawlessly on all screens</li>
<li><strong>Fast Load Times:</strong> Every second of delay costs you conversions — we build for speed</li>
<li><strong>SEO Foundation:</strong> Built-in SEO best practices ensure search engines can find and rank your site</li>
<li><strong>Compliance Ready:</strong> We ensure your site meets all relevant compliance requirements for your industry</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2>Our {$industry} Web Design Process</h2>
<!-- /wp:heading -->

<!-- wp:heading {\"level\":3} -->
<h3>1. Discovery & Research</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We begin by immersing ourselves in your business, your market, and your competition. This research phase ensures every design and development decision is grounded in strategy, not just aesthetics.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>2. Custom Design</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Our designers create a completely custom design tailored to your {$industry} brand. No templates, no shortcuts — just a unique, professional website that stands out in your market.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>3. WordPress Development</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We build your site on WordPress — the world's most powerful CMS — ensuring it's fast, secure, easy to update, and built to scale as your business grows.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>4. SEO & Launch</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We build in SEO from the ground up and launch your site only after thorough testing. Post-launch, we monitor performance and are available to support your ongoing success.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Ready to Elevate Your {$industry} Online Presence?</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Join hundreds of {$industry} organizations across the United States who trust Affordable Web Solution to power their online presence. Contact us today for a free consultation and discover what's possible for your business.</p>
<!-- /wp:paragraph -->";
}

function nexagen_generate_state_content(string $state, string $abbr, array $cities): string {
    $city_list = implode(', ', array_slice($cities, 0, 8));
    $city_count = count($cities);

    return "<!-- wp:paragraph -->
<p>Affordable Web Solution is proud to serve businesses across {$state}, delivering premium WordPress web design and development services to organizations of all sizes. From bustling cities like {$city_list}, and dozens more communities across {$abbr}, our expert team is ready to help your {$state} business thrive online.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>WordPress Web Design in {$state}</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>As a US-based WordPress agency with over 15 years of experience, we understand the unique needs of {$state} businesses. Whether you're a small local business looking to establish your online presence, or an established enterprise ready for a complete digital transformation, our team has the expertise and experience to deliver results.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>We've worked with businesses across industries in {$state} — from healthcare and legal to restaurants, real estate, and everything in between. Our deep understanding of the US market, combined with our technical WordPress expertise, makes us the ideal partner for your next web project.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Why {$state} Businesses Choose Affordable Web Solution</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>US-Based Team:</strong> Our entire team is based in the United States, ensuring clear communication and alignment on your goals</li>
<li><strong>15+ Years of Experience:</strong> We've completed over 2,500 WordPress projects for clients across the country</li>
<li><strong>370+ Five-Star Reviews:</strong> Our track record speaks for itself — we consistently deliver exceptional results</li>
<li><strong>Full-Service Agency:</strong> From design and development to hosting, maintenance, and SEO, we handle everything</li>
<li><strong>Transparent Pricing:</strong> No hidden fees, no surprises — just honest, straightforward pricing</li>
<li><strong>100% Satisfaction Guarantee:</strong> We're not done until you're completely happy with the result</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2>Our WordPress Services in {$state}</h2>
<!-- /wp:heading -->

<!-- wp:heading {\"level\":3} -->
<h3>WordPress Website Design</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Our {$state} web design team creates stunning, conversion-optimized WordPress websites that reflect your brand and engage your target audience. Every design is completely custom — no templates, no compromises.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>WordPress Development</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Our developers build fast, secure, and scalable WordPress websites that grow with your business. From custom themes and plugins to complex integrations, we handle it all.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>WordPress Maintenance & Support</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Keep your {$state} website running at peak performance with our comprehensive WordPress maintenance and support plans. We handle updates, security, backups, and performance optimization so you can focus on your business.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>SEO for {$state} Businesses</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Get found by more {$state} customers with our proven SEO strategies. We build SEO into the foundation of every website and offer ongoing SEO programs to help you dominate search results in your market.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Cities We Serve in {$state}</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We proudly serve businesses in {$city_count}+ cities and communities throughout {$state}, including: {$city_list}, and many more. No matter where your business is located in {$state}, our team is ready to help.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Frequently Asked Questions About Our {$state} Web Design Services</h2>
<!-- /wp:heading -->

<!-- wp:heading {\"level\":3} -->
<h3>Do you work with businesses anywhere in {$state}?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Absolutely. As a fully remote-capable agency, we work with businesses throughout {$state} and across the entire United States. Distance is never a barrier to great work.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>How long does a typical {$state} website project take?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Most website projects are completed within 4-12 weeks, depending on scope and complexity. During your initial consultation, we'll provide a detailed timeline specific to your project requirements.</p>
<!-- /wp:paragraph -->

<!-- wp:heading {\"level\":3} -->
<h3>What makes you different from other {$state} web design agencies?</h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Unlike many agencies that outsource work or use page builders, Affordable Web Solution is a true in-house team of WordPress specialists. We don't take shortcuts — we build custom, high-performance websites with clean code and long-term scalability in mind.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Ready to start your {$state} web design project? Contact our team today for a free consultation and discover how Affordable Web Solution can transform your online presence.</p>
<!-- /wp:paragraph -->";
}

function nexagen_generate_city_content(string $city, string $state, string $abbr): string {
    return "<!-- wp:paragraph -->
<p>Are you a business owner in {$city}, {$abbr} looking for a professional WordPress website that drives real results? Affordable Web Solution is your trusted partner for WordPress web design and development in {$city}. Our expert team delivers premium, custom WordPress websites that help {$city} businesses grow their online presence, attract more customers, and generate more revenue.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>WordPress Web Design Services in {$city}, {$state}</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>In today's digital landscape, your website is often the first impression potential customers have of your {$city} business. A poorly designed or outdated website can cost you clients and revenue. Affordable Web Solution creates beautiful, high-performing WordPress websites that make {$city} businesses stand out and succeed online.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>We've helped businesses across {$city} and throughout {$state} build powerful online presences. Our {$city} web design services include:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li><strong>Custom WordPress Web Design:</strong> Fully custom designs built specifically for your {$city} business and brand</li>
<li><strong>WordPress Development:</strong> Clean, fast, scalable code built by experienced WordPress developers</li>
<li><strong>Mobile-Responsive Design:</strong> Your site will look and perform perfectly on every device</li>
<li><strong>Local SEO for {$city}:</strong> Optimized to rank in local {$city} and {$abbr} search results</li>
<li><strong>WordPress Maintenance:</strong> Ongoing support to keep your {$city} website secure and up to date</li>
<li><strong>Managed Hosting:</strong> Fast, reliable, fully managed WordPress hosting</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2>Why {$city} Businesses Trust Affordable Web Solution</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Affordable Web Solution is not just another web design agency — we're WordPress specialists with over 15 years of experience building high-performance websites for businesses across the United States, including hundreds of clients in {$state}.</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li>✅ 2,500+ successful WordPress projects completed</li>
<li>✅ 370+ five-star Google reviews from satisfied clients</li>
<li>✅ 50+ in-house WordPress experts on our team</li>
<li>✅ US-based team with excellent communication</li>
<li>✅ 100% satisfaction guarantee on all projects</li>
<li>✅ Transparent, fixed-price project quotes</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2>The Importance of a Quality Website for {$city} Businesses</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The {$city} business market is competitive. Your potential customers are actively searching online for the products and services you offer. If your website doesn't show up in search results, or if it fails to impress when visitors arrive, you're losing business to competitors who have invested in their online presence.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>A professionally designed WordPress website from Affordable Web Solution will:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul>
<li>Rank higher in Google search results for {$city} and {$abbr} searches</li>
<li>Convert more visitors into leads and customers</li>
<li>Build trust and credibility with your target audience</li>
<li>Provide a seamless experience on mobile devices</li>
<li>Load fast — keeping visitors engaged and reducing bounce rates</li>
<li>Be easy for your team to update and manage</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2>Local SEO for {$city} Businesses</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Getting found by {$city} customers searching online is crucial for your business growth. Our WordPress websites are built with local SEO best practices from the ground up. We optimize your site for {$city}-specific keywords, set up your Google Business Profile, build local citations, and implement structured data markup — all to help you rank at the top of local search results.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Get Started with Your {$city} Website Today</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Don't let an outdated or underperforming website hold your {$city} business back. Contact Affordable Web Solution today for a free consultation. We'll discuss your goals, review your current online presence, and show you exactly how we can help your {$city} business succeed online.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Call us at (800) 123-4567, email us at hello@affordablewebsolution.com, or fill out our contact form to get started. We look forward to hearing about your {$city}, {$state} business!</p>
<!-- /wp:paragraph -->";
}

function nexagen_get_about_content(): string {
    return "<!-- wp:paragraph -->
<p>Affordable Web Solution is a premium WordPress web design and development agency built by passionate experts who believe every business deserves a world-class website. Founded over 15 years ago, we've grown from a small team of WordPress enthusiasts into one of the most respected WordPress agencies in the United States — with over 2,500 projects completed, 370+ five-star reviews, and 50+ in-house experts.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Our Story</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We started Affordable Web Solution because we saw a gap in the market: businesses needed a WordPress partner they could truly trust — one that combined technical excellence with beautiful design, transparent communication, and genuine care for client success. That's still our mission today.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Over the years, we've worked with clients ranging from local small businesses to Fortune 500 companies, nonprofits, universities, healthcare organizations, law firms, and everything in between. Every project, regardless of size or budget, receives the same level of dedication and expertise.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Our Values</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul>
<li><strong>Excellence:</strong> We don't settle for good enough. Every website we build is crafted to the highest standards of design, development, and performance.</li>
<li><strong>Transparency:</strong> No hidden fees, no vague timelines, no surprises. We communicate clearly and honestly at every stage of every project.</li>
<li><strong>Partnership:</strong> We see ourselves as an extension of your team, not just a vendor. Your success is our success.</li>
<li><strong>Innovation:</strong> We stay at the cutting edge of WordPress development, always learning and adopting best practices to deliver better results.</li>
<li><strong>Reliability:</strong> When we make a commitment, we keep it. Our clients can count on us to deliver on time and on budget.</li>
</ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2>Why Affordable Web Solution?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We're not a general web agency that occasionally does WordPress. We're WordPress specialists — it's all we do, and we do it better than anyone. Our entire team is dedicated to mastering the WordPress ecosystem, from core development to Gutenberg blocks, WooCommerce, performance optimization, and security hardening.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>This specialization means you get deeper expertise, faster turnaround, and better results than you'd get from a generalist agency. When you hire Affordable Web Solution, you're hiring a team that lives and breathes WordPress every day.</p>
<!-- /wp:paragraph -->";
}

function nexagen_get_contact_content(): string {
    return "<!-- wp:paragraph -->
<p>Ready to start your next WordPress project? We'd love to hear from you. Fill out the form below and one of our WordPress experts will get back to you within 24 hours.</p>
<!-- /wp:paragraph -->";
}

function nexagen_get_faq_content(): string {
    return "<!-- wp:paragraph -->
<p>Have questions about our WordPress web design and development services? Here are answers to the most common questions we receive from clients across the United States.</p>
<!-- /wp:paragraph -->";
}

function nexagen_get_team_content(): string {
    return "<!-- wp:paragraph -->
<p>Meet the talented team of WordPress specialists, designers, developers, and strategists who make Affordable Web Solution one of the most trusted WordPress agencies in the United States. Our team brings together decades of combined experience and a shared passion for creating exceptional WordPress websites.</p>
<!-- /wp:paragraph -->";
}

function nexagen_get_careers_content(): string {
    return "<!-- wp:heading -->
<h2>Join the Affordable Web Solution Team</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We're always looking for talented, passionate WordPress specialists to join our growing team. At Affordable Web Solution, you'll work on exciting projects for clients across the United States, collaborate with a world-class team, and help shape the future of WordPress web design and development.</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2>Why Work at Affordable Web Solution?</h2>
<!-- /wp:heading -->
<!-- wp:list -->
<ul>
<li>Remote-first culture with flexible working hours</li>
<li>Competitive salaries and comprehensive benefits</li>
<li>Ongoing learning and professional development opportunities</li>
<li>Work on meaningful projects for clients who care</li>
<li>Collaborative, supportive, and talented team</li>
<li>Clear growth path and career advancement opportunities</li>
</ul>
<!-- /wp:list -->
<!-- wp:paragraph -->
<p>Interested in joining us? Send your resume and portfolio to careers@affordablewebsolution.com. We look forward to hearing from you!</p>
<!-- /wp:paragraph -->";
}

/* ============================================================
   301 REDIRECTS: /services/{slug}/ → /{slug}/
   Handles legacy URLs so no 404s or broken external links.
   ============================================================ */
function nexagen_redirect_service_urls(): void {
    // Only fire on front-end, not in admin or REST
    if ( is_admin() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
        return;
    }

    $service_slugs = [
        'wordpress-design',
        'wordpress-development',
        'wordpress-maintenance',
        'wordpress-hosting',
        'wordpress-support',
        'seo-services',
        'wordpress-security',
        'wordpress-speed',
        'woocommerce',
        'wordpress-migration',
        'wordpress-ada',
        'white-label-wordpress',
    ];

    // Parse the current request path
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $path        = parse_url( $request_uri, PHP_URL_PATH );

    foreach ( $service_slugs as $slug ) {
        // Match /services/{slug}/ with or without trailing slash
        if ( preg_match( '#^/services/' . preg_quote( $slug, '#' ) . '(/?)$#', $path ) ) {
            wp_redirect( home_url( '/' . $slug . '/' ), 301 );
            exit;
        }
    }
}
add_action( 'template_redirect', 'nexagen_redirect_service_urls', 1 );

/* ============================================================
   FIX EXISTING SERVICE PAGES: Remove parent association
   so URLs resolve at root level instead of under /services/
   Run once via WP-CLI or admin — triggered by option flag.
   ============================================================ */
function nexagen_fix_service_page_parents(): void {
    if ( get_option( 'nexagen_fix_service_parents' ) !== 'yes' ) {
        return;
    }

    $service_slugs = [
        'wordpress-design', 'wordpress-development', 'wordpress-maintenance',
        'wordpress-hosting', 'wordpress-support', 'seo-services',
        'wordpress-security', 'wordpress-speed', 'woocommerce',
        'wordpress-migration', 'wordpress-ada', 'white-label-wordpress',
    ];

    foreach ( $service_slugs as $slug ) {
        $page = get_page_by_path( $slug );
        if ( $page && $page->post_parent != 0 ) {
            wp_update_post([
                'ID'          => $page->ID,
                'post_parent' => 0,
            ]);
        }
    }

    delete_option( 'nexagen_fix_service_parents' );
    flush_rewrite_rules();
}
add_action( 'init', 'nexagen_fix_service_page_parents', 20 );

/* ============================================================
   INCLUDE ADDITIONAL THEME HELPERS
   ============================================================ */
require_once AWS_DIR . '/inc/template-helpers.php';



/* FORCE /services/ TO USE SERVICE OVERVIEW TEMPLATE */
add_filter('template_include', function($template){

    if (is_page('services')) {

        $custom_template = locate_template(
            'templates/template-services.php'
        );

        if (!empty($custom_template)) {
            return $custom_template;
        }
    }

    return $template;

},999);