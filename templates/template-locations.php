<?php
/**
* Template Name: Locations Overview
*/
get_header();
$states = nexagen_get_states();
?>

<main>
<div class="page-hero">
<div class="container">
<?php nexagen_render_breadcrumb(); ?>
<div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">Nationwide Coverage</div>
<h1>WordPress Services Across All 50 States</h1>
<p>We proudly serve businesses in every state and 800+ cities across the United States.</p>
</div>
</div>

<!-- ✅ FIXED: Stats Row (Mobile 1, Tablet 2, Desktop 4) -->
<section class="stats-section">
    <div class="stats-container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">370+</div>
                <div class="stat-label">5-Star Google Reviews</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">2,500+</div>
                <div class="stat-label">Happy Clients Served</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">50+</div>
                <div class="stat-label">In-House WP Experts</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">15+</div>
                <div class="stat-label">Years in Business</div>
            </div>
        </div>
    </div>
</section>

<!-- Nationwide visual -->
<div style="position:relative;overflow:hidden;max-height:280px;">
<img src="https://images.unsplash.com/photo-1434626881859-194d67b2b86f?w=1400&h=280&fit=crop&auto=format&q=70" alt="Affordable Web Solution serving businesses nationwide across all 50 US states" loading="lazy" style="width:100%;height:280px;object-fit:cover;display:block;filter:brightness(0.4);">
<div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;color:#fff;padding:2rem;">
<div style="font-family:var(--font-heading);font-weight:900;font-size:2rem;margin-bottom:0.5rem;">Coast to Coast Coverage</div>
<p style="opacity:0.85;font-size:1.0625rem;max-width:540px;">From New York to California — our US-based team delivers world-class WordPress websites to businesses in every state.</p>
</div>
</div>

<section class="section">
<div class="container">
<div class="section-header">
<div class="section-label">Where We Work</div>
<h2>Serving All 50 US States</h2>
<p>Click your state to find local WordPress web design services and a list of cities we cover.</p>
</div>

<!-- ✅ FIXED: Responsive States Grid -->
<div class="states-grid">
<?php foreach ($states as $slug => $state): ?>
<a href="<?php echo home_url('/' . $slug . '/'); ?>"
class="card"
style="padding:1.25rem;text-align:center;text-decoration:none;display:block;">
<div style="font-family:var(--font-heading);font-weight:800;font-size:1.5rem;color:var(--color-primary);letter-spacing:-0.03em;display:block;margin-bottom:0.25rem;">
<?php echo esc_html($state['abbr']); ?>
</div>
<div style="font-size:0.8125rem;color:var(--color-body);"><?php echo esc_html($state['name']); ?></div>
<div style="font-size:0.75rem;color:var(--color-body);opacity:0.6;margin-top:0.25rem;"><?php echo count($state['cities']); ?> cities</div>
</a>
<?php endforeach; ?>
</div>

</div>
</section>

<?php nexagen_render_why_us(); ?>
<?php nexagen_render_testimonials(3); ?>
<?php nexagen_render_cta('Serving All 50 States', 'No matter where your business is located, Affordable Web Solution delivers exceptional WordPress websites. Let\'s discuss your project.'); ?>
</main>


<?php get_footer(); ?>