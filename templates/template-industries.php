<?php
/**
 * Template Name: Industries Overview
 */
get_header();
$industries = nexagen_get_industries();
?>

<main>
    <div class="page-hero">
        <div class="container">
            <?php nexagen_render_breadcrumb(); ?>
            <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">Industries We Serve</div>
            <h1>WordPress Solutions for Every Industry</h1>
            <p>We've built websites for businesses across dozens of industries. Whatever your field, we know what works.</p>
        </div>
    </div>

    <!-- Industries Grid — FIXED: uses aws-industries-grid (responsive 4→3→2→1) -->
    <section class="section">
        <div class="container">
            <div class="aws-industries-grid">
                <?php foreach ($industries as $ind): ?>
                <a href="<?php echo home_url('/industries/' . $ind['slug'] . '/'); ?>"
                   class="card aws-industry-card"
                   aria-label="<?php echo esc_attr($ind['title']); ?> web design">
                    <?php if (!empty($ind['img'])): ?>
                    <div class="aws-industry-img">
                        <img src="<?php echo esc_url($ind['img']); ?>"
                             alt="<?php echo esc_attr($ind['title']); ?> web design"
                             loading="lazy">
                    </div>
                    <?php endif; ?>
                    <div class="aws-industry-body">
                        <div class="aws-industry-icon" aria-hidden="true"><?php echo $ind['icon']; ?></div>
                        <h3 class="aws-industry-title"><?php echo esc_html($ind['title']); ?></h3>
                        <span class="service-link aws-industry-link">
                            Learn more
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php nexagen_render_why_us(); ?>
    <?php nexagen_render_testimonials(3); ?>
    <?php nexagen_render_cta(); ?>
</main>

<?php get_footer(); ?>
