<?php
/**
* Template Name: State Location
*/
get_header();
global $post;
$state_name = get_post_meta($post->ID, '_nexagen_state_name', true);
$state_abbr = get_post_meta($post->ID, '_nexagen_state_abbr', true);
$state_slug = get_post_field('post_name', $post->ID);
// Fallback: derive from title
if (!$state_name) {
$title      = get_the_title($post->ID);
$state_name = str_replace('WordPress Web Design in ', '', $title);
$state_abbr = '';
}
// Short label: use abbreviation if available, else full name
$state_label = $state_abbr ? $state_abbr : $state_name;
// Dynamic intro paragraph — unique per state reference
$intro_paragraph = sprintf(
'Businesses across %s need websites that do more than look good — they need to convert visitors into customers. Our US-based team combines deep WordPress expertise with an understanding of what local %s audiences expect. Whether you\'re a startup in a growing %s city or an established business ready for a digital upgrade, we build websites that perform.',
esc_html($state_name),
esc_html($state_label),
esc_html($state_name)
);
// Dynamic FAQ items
$faqs = [
[
'q' => sprintf('Do you work with businesses across all of %s?', $state_name),
'a' => sprintf(
'Yes. We serve clients throughout %s — from the major metro areas to smaller communities. Our team works remotely and collaborates closely with %s businesses regardless of location within the state.',
esc_html($state_name),
esc_html($state_label)
),
],
[
'q' => sprintf('How long does a WordPress project take for a %s business?', $state_label),
'a' => 'Most small-to-mid-size websites are completed within 4–8 weeks, depending on scope. We provide a clear timeline upfront after understanding your project requirements — no vague estimates.',
],
[
'q' => sprintf('Will my %s website rank well in local search?', $state_label),
'a' => sprintf(
'We build every site with on-page SEO foundations in place — proper heading structure, fast load times, schema markup, and local relevance signals for %s. We also offer dedicated SEO services if you need ongoing search visibility.',
esc_html($state_name)
),
],
[
'q' => 'What does WordPress maintenance include?',
'a' => 'Our maintenance plans cover core and plugin updates, daily backups, uptime monitoring, security scanning, and priority support. Your site stays secure and stable without you having to manage it.',
],
[
'q' => sprintf('Can you migrate my existing website to WordPress for my %s business?', $state_label),
'a' => sprintf(
'Absolutely. We handle migrations from Wix, Squarespace, Shopify, legacy CMS platforms, and custom-built sites. We preserve your content, redirect your URLs to protect SEO value, and get your new %s site live without downtime.',
esc_html($state_name)
),
],
];
// Dynamic benefits
$benefits = [
[
'icon'  => '🏗️',
'title' => 'Built for ' . esc_html($state_name) . ' Businesses',
'desc'  => sprintf(
'We understand the business climate in %s. Our websites are designed to resonate with your local audience while meeting national performance standards.',
esc_html($state_name)
),
],
[
'icon'  => '⚡',
'title' => 'Fast, Reliable Performance',
'desc'  => 'Every site we build is optimized for speed — fast hosting, lean code, and image optimization. A faster site means lower bounce rates and better rankings.',
],
[
'icon'  => '🔒',
'title' => 'Security & Ongoing Support',
'desc'  => 'We don\'t disappear after launch. Our team monitors your site, applies updates, and is available when you need help — no support tickets going cold.',
],
[
'icon'  => '📈',
'title' => 'SEO-Ready From Day One',
'desc'  => sprintf(
'Every %s site we build includes on-page SEO foundations — structured data, proper heading hierarchy, fast load times, and mobile optimization.',
esc_html($state_label)
),
],
[
'icon'  => '🇺',
'title' => 'US-Based Team',
'desc'  => 'No outsourcing. Your project is handled entirely by our in-house US team — real communication, accountability, and quality control at every step.',
],
[
'icon'  => '💳',
'title' => 'Transparent Pricing',
'desc'  => 'We quote clearly and stick to it. No hidden fees, no scope creep surprises. You know exactly what you\'re getting before we start.',
],
];
?>
<main>
<div class="page-hero">
<div class="container">
<?php nexagen_render_breadcrumb(); ?>
<div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">
<?php echo esc_html($state_name); ?> WordPress Agency
</div>
<h1>WordPress Web Design in <?php echo esc_html($state_name); ?></h1>
<p>US-based WordPress firm serving <?php echo esc_html($state_name); ?> businesses — web design &amp; development, WP hosting, maintenance, &amp; SEO.</p>
<div style="display:flex;gap:1rem;justify-content:center;margin-top:2rem;flex-wrap:wrap;">
<a href="<?php echo home_url('/contact/'); ?>" class="btn btn-accent btn-lg">Get a Free Quote</a>
<a href="<?php echo home_url('/team/'); ?>" class="btn btn-white">Meet Our Team</a>
</div>
</div>
</div>

<!-- Enhanced Stats Bar -->
<section style="background:linear-gradient(135deg, #fafaf9 0%, #ffffff 50%, #fafaf9 100%);border-bottom:1px solid var(--color-border);padding:2.5rem 0;position:relative;overflow:hidden;">
<!-- Subtle accent line at top -->
<div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg, transparent, var(--color-primary), transparent);"></div>
<div class="container">
<div style="display:flex;justify-content:center;align-items:center;gap:0;flex-wrap:wrap;max-width:900px;margin:0 auto;">
<?php
$stats = [
['icon' => '⭐', 'num' => nexagen_opt('stats_1_num', '370+'), 'label' => nexagen_opt('stats_1_label', '5-Star Reviews'), 'sub' => 'Trusted by Clients'],
['icon' => '🛡️', 'num' => '100%', 'label' => 'Satisfaction Guaranteed', 'sub' => 'No Questions Asked'],
['icon' => '👥', 'num' => nexagen_opt('stats_3_num', '50+'), 'label' => 'Expert Team Members', 'sub' => 'US-Based Professionals'],
];
foreach ($stats as $idx => $s): ?>
<div style="flex:1;min-width:200px;text-align:center;padding:1.5rem 1rem;position:relative;">
<!-- Divider between items -->
<?php if ($idx > 0): ?>
<div style="position:absolute;left:0;top:20%;bottom:20%;width:1px;background:linear-gradient(180deg, transparent, var(--color-border), transparent);"></div>
<?php endif; ?>
<!-- Icon Badge -->
<div style="display:inline-flex;align-items:center;justify-content:center;width:48px;height:48px;background:linear-gradient(135deg, rgba(34,85,51,0.08), rgba(34,85,51,0.04));border-radius:12px;margin-bottom:0.75rem;font-size:1.5rem;box-shadow:0 2px 8px rgba(34,85,51,0.08);">
<?php echo $s['icon']; ?>
</div>
<!-- Number -->
<div style="font-family:var(--font-heading);font-weight:900;font-size:2.25rem;color:var(--color-primary);letter-spacing:-0.03em;line-height:1;margin-bottom:0.5rem;">
<?php echo esc_html($s['num']); ?>
</div>
<!-- Label -->
<div style="font-family:var(--font-heading);font-weight:700;font-size:0.9375rem;color:var(--color-heading);margin-bottom:0.25rem;letter-spacing:-0.01em;">
<?php echo esc_html($s['label']); ?>
</div>
<!-- Sub-label -->
<div style="font-size:0.75rem;color:var(--color-body);opacity:0.7;text-transform:uppercase;letter-spacing:0.05em;">
<?php echo esc_html($s['sub']); ?>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</section>
<!-- Dynamic Intro Section -->
<section class="section">
<div class="container" style="max-width:900px;">
<div class="section-header" style="text-align:left;">
<div class="section-label">Why <?php echo esc_html($state_name); ?> Businesses Choose Us</div>
<h2>WordPress Experts Who Understand <?php echo esc_html($state_name); ?></h2>
<p style="font-size:1.0625rem;line-height:1.75;color:var(--color-body);">
<?php echo $intro_paragraph; ?>
</p>
</div>
</div>
</section>
<!-- Services Grid -->
<?php nexagen_render_services_grid(6); ?>
<!-- Dynamic Benefits Grid -->
<section class="section bg-card">
<div class="container">
<div class="section-header">
<div class="section-label">What Sets Us Apart</div>
<h2>The Right WordPress Partner for <?php echo esc_html($state_name); ?> Businesses</h2>
<p>Here's what working with us actually means — not marketing language, but specifics.</p>
</div>
<div class="aws-auto-grid">
<?php foreach ($benefits as $benefit): ?>
<div style="background:var(--color-white);border:1px solid var(--color-border);border-radius:var(--radius-lg);padding:1.75rem;">
<div style="font-size:2rem;margin-bottom:0.75rem;"><?php echo $benefit['icon']; ?></div>
<h3 style="font-size:1.0625rem;margin-bottom:0.5rem;"><?php echo $benefit['title']; ?></h3>
<p style="font-size:0.9375rem;color:var(--color-body);margin:0;"><?php echo $benefit['desc']; ?></p>
</div>
<?php endforeach; ?>
</div>
</div>
</section>
<!-- State visual banner -->
<div style="position:relative;overflow:hidden;max-height:260px;">
<img src="https://images.unsplash.com/photo-1495562569060-2eec283d3391?w=1400&h=260&fit=crop&auto=format&q=70" alt="Serving businesses across <?php echo esc_attr($state_name); ?>" loading="lazy" style="width:100%;height:260px;object-fit:cover;display:block;filter:brightness(0.45);">
<div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;color:#fff;padding:2rem;">
<div style="font-family:var(--font-heading);font-weight:900;font-size:1.875rem;margin-bottom:0.5rem;">Proudly Serving <?php echo esc_html($state_name); ?> Businesses</div>
<p style="opacity:0.85;font-size:1rem;max-width:520px;">Local knowledge, national expertise. We build websites that work for your <?php echo esc_html($state_name); ?> audience.</p>
</div>
</div>
<!-- Process -->
<?php nexagen_render_process(); ?>
<!-- Testimonials -->
<?php nexagen_render_testimonials(3); ?>
<!-- Page Content (Long-form SEO text from editor) -->
<?php
$post_content = get_the_content(null, false, $post->ID);
if (!empty(trim(strip_tags($post_content)))): ?>
<section class="section">
<div class="container" style="max-width:900px;">
<div class="entry-content">
<?php while (have_posts()): the_post(); the_content(); endwhile; ?>
</div>
</div>
</section>
<?php endif; ?>
<!-- Dynamic FAQ Section -->
<section class="section bg-card">
<div class="container" style="max-width:800px;">
<div class="section-header">
<div class="section-label">FAQ</div>
<h2>Common Questions from <?php echo esc_html($state_name); ?> Businesses</h2>
</div>
<div style="margin-top:2rem;display:flex;flex-direction:column;gap:1rem;">
<?php foreach ($faqs as $i => $faq): ?>
<details style="background:var(--color-white);border:1px solid var(--color-border);border-radius:var(--radius-lg);padding:1.25rem 1.5rem;" <?php echo $i === 0 ? 'open' : ''; ?>>
<summary style="font-family:var(--font-heading);font-weight:700;font-size:1rem;cursor:pointer;list-style:none;display:flex;justify-content:space-between;align-items:center;">
<?php echo esc_html($faq['q']); ?>
<span style="font-size:1.25rem;color:var(--color-primary);margin-left:1rem;">+</span>
</summary>
<p style="margin:0.75rem 0 0;font-size:0.9375rem;color:var(--color-body);line-height:1.7;">
<?php echo $faq['a']; ?>
</p>
</details>
<?php endforeach; ?>
</div>
</div>
</section>
<!-- City Links Grid -->
<section class="section">
<div class="container">
<div class="section-header">
<div class="section-label">Cities We Serve</div>
<h2>WordPress Web Design in Every Corner of <?php echo esc_html($state_name); ?></h2>
<p>We serve businesses in cities and communities throughout <?php echo esc_html($state_name); ?>. Click your city to learn more about our local services.</p>
</div>
<?php nexagen_render_cities_grid($state_slug); ?>
</div>
</section>
<!-- Blog Preview -->
<?php nexagen_render_blog_preview(3); ?>
<?php nexagen_render_cta(
'Ready to Start Your ' . $state_name . ' WordPress Project?',
'Join businesses across ' . $state_name . ' who trust us for premium WordPress web design and development. Let\'s talk about what your site needs to succeed.'
); ?>
</main>
<?php get_footer(); ?>