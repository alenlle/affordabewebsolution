<?php
/**
 * Template Name: Services Overview
 */
get_header();
$services = nexagen_get_services();
?>

<main>
    <div class="page-hero">
        <div class="container">
            <?php nexagen_render_breadcrumb(); ?>
            <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">What We Offer</div>
            <h1>Premium WordPress Services</h1>
            <p>Every service you need to build, grow, and maintain a world-class WordPress website — all under one roof.</p>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <?php while (have_posts()): the_post(); ?>
            <?php if (get_the_content()): ?>
            <div class="entry-content" style="max-width:800px;margin:0 auto 4rem;"><?php the_content(); ?></div>
            <?php endif; endwhile; ?>

            <div class="services-grid">
                <?php foreach ($services as $svc): ?>
                <a href="<?php echo home_url('/' . $svc['slug'] . '/'); ?>" class="service-card" style="text-decoration:none;display:block;padding:0;overflow:hidden;">
                    <?php if (!empty($svc['img'])): ?>
                    <div style="width:100%;height:160px;overflow:hidden;">
                        <img src="<?php echo esc_url($svc['img']); ?>" alt="<?php echo esc_attr($svc['title']); ?>" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;">
                    </div>
                    <?php endif; ?>
                    <div style="padding:1.5rem 1.75rem 1.75rem;">
                        <div class="service-icon"><?php echo $svc['icon']; ?></div>
                        <h3><?php echo esc_html($svc['title']); ?></h3>
                        <p><?php echo esc_html($svc['desc']); ?></p>
                        <span class="service-link">
                            Learn more
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php nexagen_render_why_us(); ?>
    <?php nexagen_render_process(); ?>
    <?php nexagen_render_testimonials(3); ?>
    <?php nexagen_render_cta(); ?>
</main>

<?php get_footer(); ?>
