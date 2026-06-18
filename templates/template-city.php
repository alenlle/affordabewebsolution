<?php
/**
* Template Name: City Location
*/
get_header();
global $post;
$city       = get_post_meta($post->ID, '_nexagen_city_name',  true);
$state_name = get_post_meta($post->ID, '_nexagen_state_name', true);
$state_abbr = get_post_meta($post->ID, '_nexagen_state_abbr', true);
if (!$city) {
$title = get_the_title($post->ID);
$city  = str_replace('WordPress Web Design in ', '', $title);
}
// Get parent state slug for breadcrumb and back-link
$parent_id   = $post->post_parent;
$parent_slug = $parent_id ? get_post_field('post_name', $parent_id) : '';
// Location display helpers
$city_state  = $city . ($state_abbr ? ', ' . $state_abbr : ($state_name ? ', ' . $state_name : ''));
$state_label = $state_abbr ? $state_abbr : $state_name;
// Dynamic intro paragraph
$intro_paragraph = sprintf(
'Running a business in %s means competing for attention online as much as offline. A professionally built WordPress website gives %s businesses a credible, fast, and search-visible presence — one that works for you around the clock. Our US-based team handles everything from design to launch to ongoing maintenance, so you can focus on your business.',
esc_html($city),
esc_html($city)
);
// Dynamic "why us" paragraph specific to the city
$why_us = sprintf(
'We\'ve worked with businesses across %s and we know what %s customers expect when they land on your site: clear information, fast load times, and a design that reflects the professionalism of your business. We don\'t use cookie-cutter templates — every site is built to match your goals and your market.',
esc_html($state_name ?: 'the region'),
esc_html($city)
);
// Dynamic service highlights
$service_highlights = [
[
'icon'  => '🎨',
'title' => 'Custom WordPress Design',
'desc'  => sprintf(
'A website built for your %s business — not a generic template. We design around your brand, your audience, and your goals.',
esc_html($city)
),
],
[
'icon'  => '⚙️',
'title' => 'WordPress Development',
'desc'  => 'Custom functionality, WooCommerce, membership systems, booking tools — we build what your business actually needs, not what\'s easiest for us.',
],
[
'icon'  => '🔍',
'title' => 'Local SEO for ' . esc_html($city),
'desc'  => sprintf(
'We set up every %s site to rank for local search terms — structured data, on-page optimization, Google Business Profile alignment, and fast performance.',
esc_html($city)
),
],
[
'icon'  => '☁️',
'title' => 'Managed WordPress Hosting',
'desc'  => 'Fast, secure hosting with daily backups, SSL, and CDN — managed for you so your site stays online and performs well without the technical headache.',
],
[
'icon'  => '🔄',
'title' => 'Website Migrations',
'desc'  => sprintf(
'Already on another platform? We migrate %s businesses from Wix, Squarespace, or outdated custom sites to WordPress — without losing content or SEO value.',
esc_html($city)
),
],
[
'icon'  => '🛡️',
'title' => 'Maintenance & Support',
'desc'  => 'Monthly plans that keep your site updated, secure, and monitored. One call or email away — no ticketing systems or offshore delays.',
],
];
// Dynamic FAQ
$faqs = [
[
'q' => sprintf('Do you build websites for %s businesses specifically?', $city),
'a' => sprintf(
'Yes. While we work with clients nationwide, we\'re experienced in serving %s businesses and understand the local market context. Your website will be built with your %s audience in mind.',
esc_html($city),
esc_html($city)
),
],
[
'q' => sprintf('How much does a WordPress website cost for a %s business?', $city),
'a' => 'Pricing depends on scope — a brochure site differs from an e-commerce build. We provide a detailed quote after a free consultation. Most small business sites range from $2,500 to $8,000, with no hidden fees.',
],
[
'q' => 'How long does the website project take?',
'a' => sprintf(
'Most %s business websites are completed in 4–8 weeks. Larger or more complex projects may take 10–12 weeks. We give you a realistic timeline upfront and stick to it.',
esc_html($city)
),
],
[
'q' => sprintf('Will my %s website show up in Google search results?', $city),
'a' => sprintf(
'We build every site with solid SEO foundations — proper heading structure, fast load speed, schema markup, and local signals for %s. We also offer ongoing SEO services if you want to actively grow your search visibility.',
esc_html($city_state)
),
],
[
'q' => 'What happens after the website launches?',
'a' => 'We offer maintenance plans that cover updates, backups, security monitoring, and priority support. We\'re not a build-and-disappear agency — we\'re a long-term partner for your website.',
],
];
?>
<main>
<div class="page-hero">
<div class="container">
<?php nexagen_render_breadcrumb(); ?>
<div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">
<?php echo esc_html($city_state); ?> WordPress Agency
</div>
<h1>WordPress Web Design in <?php echo esc_html($city); ?><?php echo $state_abbr ? ', ' . esc_html($state_abbr) : ''; ?></h1>
<p>Premium WordPress design, development, hosting &amp; support for <?php echo esc_html($city); ?> businesses — built by a US-based team.</p>
<div style="display:flex;gap:1rem;justify-content:center;margin-top:2rem;flex-wrap:wrap;">
<a href="<?php echo home_url('/contact/'); ?>" class="btn btn-accent btn-lg">Get a Free Quote</a>
<a href="tel:<?php echo esc_attr(preg_replace('/\D/', '', nexagen_opt('agency_phone', '8001234567'))); ?>" class="btn btn-white">
📞 Call Us Now
</a>
</div>
</div>
</div>

<!-- Enhanced Trust Bar -->
<section style="background:linear-gradient(135deg, #fafaf9 0%, #ffffff 50%, #fafaf9 100%);border-bottom:1px solid var(--color-border);padding:2rem 0;position:relative;overflow:hidden;">
<div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg, transparent, var(--color-primary), transparent);"></div>
<div class="container">
<div style="display:flex;justify-content:center;align-items:center;gap:0;flex-wrap:wrap;max-width:1000px;margin:0 auto;">
<?php
$trust = [
['icon' => '⭐', 'text' => '370+ Five-Star Reviews', 'sub' => 'Client Verified'],
['icon' => '📈', 'text' => '15+ Years Experience', 'sub' => 'Since 2010'],
['icon' => '📍', 'text' => 'US-Based Team', 'sub' => 'No Outsourcing'],
['icon' => '💯', 'text' => 'Satisfaction Guarantee', 'sub' => '100% Protected'],
];
foreach ($trust as $idx => $t): ?>
<div style="flex:1;min-width:180px;text-align:center;padding:1rem;position:relative;">
<?php if ($idx > 0): ?>
<div style="position:absolute;left:0;top:15%;bottom:15%;width:1px;background:linear-gradient(180deg, transparent, var(--color-border), transparent);"></div>
<?php endif; ?>
<div style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;background:linear-gradient(135deg, rgba(34,85,51,0.08), rgba(34,85,51,0.04));border-radius:10px;margin-bottom:0.5rem;font-size:1.25rem;">
<?php echo $t['icon']; ?>
</div>
<div style="font-family:var(--font-heading);font-weight:700;font-size:0.875rem;color:var(--color-primary);margin-bottom:0.125rem;">
<?php echo esc_html($t['text']); ?>
</div>
<div style="font-size:0.6875rem;color:var(--color-body);opacity:0.7;text-transform:uppercase;letter-spacing:0.05em;">
<?php echo esc_html($t['sub']); ?>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</section>
<!-- Dynamic City Intro -->
<section class="section">
<div class="container" style="max-width:900px;">
<div class="section-header" style="text-align:left;">
<div class="section-label">WordPress Design for <?php echo esc_html($city); ?> Businesses</div>
<h2>A WordPress Agency That Works for <?php echo esc_html($city); ?></h2>
<p style="font-size:1.0625rem;line-height:1.75;color:var(--color-body);">
<?php echo $intro_paragraph; ?>
</p>
<p style="font-size:1.0625rem;line-height:1.75;color:var(--color-body);margin-top:1rem;">
<?php echo $why_us; ?>
</p>
</div>
</div>
</section>
<!-- Dynamic Services Highlights -->
<section class="section bg-card">
<div class="container">
<div class="section-header">
<div class="section-label">What We Offer</div>
<h2>WordPress Services for <?php echo esc_html($city); ?> Businesses</h2>
<p>Everything you need to build, grow, and maintain your <?php echo esc_html($city); ?> website — handled by one team.</p>
</div>
<div class="aws-auto-grid">
<?php foreach ($service_highlights as $service): ?>
<div style="background:var(--color-white);border:1px solid var(--color-border);border-radius:var(--radius-lg);padding:1.75rem;">
<div style="font-size:2rem;margin-bottom:0.75rem;"><?php echo $service['icon']; ?></div>
<h3 style="font-size:1.0625rem;margin-bottom:0.5rem;"><?php echo $service['title']; ?></h3>
<p style="font-size:0.9375rem;color:var(--color-body);margin:0;"><?php echo $service['desc']; ?></p>
</div>
<?php endforeach; ?>
</div>
</div>
</section>
<!-- Core services from theme -->
<?php nexagen_render_services_grid(6); ?>
<!-- City visual -->
<div style="position:relative;overflow:hidden;max-height:240px;">
<img src="https://images.unsplash.com/photo-1486325212027-8081e485255e?w=1400&h=240&fit=crop&auto=format&q=70" alt="WordPress web design services in <?php echo esc_attr($city); ?>" loading="lazy" style="width:100%;height:240px;object-fit:cover;display:block;filter:brightness(0.45);">
<div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;color:#fff;padding:2rem;">
<div style="font-family:var(--font-heading);font-weight:900;font-size:1.75rem;margin-bottom:0.5rem;">Your Local <?php echo esc_html($city); ?> WordPress Partner</div>
<p style="opacity:0.85;font-size:0.9375rem;max-width:480px;">Expert web design and development for <?php echo esc_html($city); ?> businesses — delivered by a US-based team that gets results.</p>
</div>
</div>
<!-- Process -->
<?php nexagen_render_process(); ?>
<!-- Testimonials -->
<?php nexagen_render_testimonials(3); ?>
<!-- Long-form editor content (if present) -->
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
<h2>Questions from <?php echo esc_html($city); ?> Business Owners</h2>
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
<!-- Back to State -->
<?php if ($parent_slug && $state_name): ?>
<section class="section--sm">
<div class="container" style="text-align:center;">
<p style="margin-bottom:1rem;">
We serve all of <?php echo esc_html($state_name); ?> — not just <?php echo esc_html($city); ?>. See every <?php echo esc_html($state_name); ?> city we cover.
</p>
<a href="<?php echo home_url('/' . $parent_slug . '/'); ?>" class="btn btn-outline">
View All <?php echo esc_html($state_name); ?> Cities
</a>
</div>
</section>
<?php endif; ?>
<?php nexagen_render_cta(
'Ready to Build Your ' . $city . ' WordPress Website?',
'Let\'s talk about your project. Get a free consultation from our team of WordPress experts — no obligation, no sales pressure.'
); ?>
</main>
<?php get_footer(); ?>