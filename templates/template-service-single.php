<?php
/**
 * Template Name: Service Single
 */
get_header();
global $post;
$icon = get_post_meta($post->ID, '_nexagen_service_icon', true) ?: '🔧';
$all_services = nexagen_get_services();
?>

<main>
    <div class="page-hero">
        <div class="container">
            <?php nexagen_render_breadcrumb(); ?>
            <div style="font-size:3rem;margin-bottom:1rem;" aria-hidden="true"><?php echo $icon; ?></div>
            <h1><?php the_title(); ?></h1>
            <?php if (has_excerpt()): ?>
            <p><?php the_excerpt(); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Benefit Bar -->
    <section style="background:var(--color-card);border-bottom:1px solid var(--color-border);padding:1.5rem 0;">
        <div class="container">
            <div style="display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:2rem;">
                <?php
                $perks = ['✓ US-Based In-House Team', '✓ 100% Satisfaction Guarantee', '✓ 15+ Years Experience', '✓ 370+ Five-Star Reviews'];
                foreach ($perks as $p): ?>
                <span style="font-family:var(--font-heading);font-weight:600;font-size:0.9rem;color:var(--color-primary);"><?php echo esc_html($p); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section style="padding:5rem 0;">
        <div class="container">
            <div class="aws-sidebar-layout">
                <div>
                    <div class="entry-content">
                        <?php while (have_posts()): the_post(); the_content(); endwhile; ?>
                    </div>
                </div>

                <!-- Sticky Sidebar -->
                <aside class="aws-sidebar">
                    <div class="card" style="padding:2rem;margin-bottom:1.5rem;border-top:4px solid var(--color-primary);">
                        <h3 style="font-size:1.0625rem;margin-bottom:0.5rem;">Ready to Get Started?</h3>
                        <p style="font-size:0.875rem;margin-bottom:1.5rem;">Get a free quote for this service. We respond within 24 hours.</p>
                        <a href="<?php echo home_url('/contact/'); ?>" class="btn btn-primary" style="width:100%;justify-content:center;">Get a Free Quote</a>
                        <div style="margin-top:1rem;text-align:center;">
                            <a href="tel:<?php echo esc_attr(preg_replace('/\D/', '', nexagen_opt('agency_phone', '8001234567'))); ?>"
                               style="font-size:0.875rem;color:var(--color-primary);font-weight:600;">
                                📞 <?php echo esc_html(nexagen_opt('agency_phone', '(800) 123-4567')); ?>
                            </a>
                        </div>
                    </div>

                    <!-- Other Services -->
                    <div class="card" style="padding:1.5rem;">
                        <h4 style="font-size:0.9375rem;margin-bottom:1rem;">Other Services</h4>
                        <ul style="list-style:none;display:flex;flex-direction:column;gap:0.5rem;">
                            <?php foreach (array_slice($all_services, 0, 6) as $svc): ?>
                            <?php if ($svc['slug'] !== get_post_field('post_name', $post->ID)): ?>
                            <li>
                                <a href="<?php echo home_url('/' . $svc['slug'] . '/'); ?>"
                                   style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;color:var(--color-body);padding:0.5rem 0.75rem;border-radius:var(--radius-md);transition:all 0.2s;"
                                   onmouseover="this.style.background='var(--color-card)';this.style.color='var(--color-primary)'"
                                   onmouseout="this.style.background='transparent';this.style.color='var(--color-body)'">
                                    <span><?php echo $svc['icon']; ?></span>
                                    <span><?php echo esc_html($svc['title']); ?></span>
                                </a>
                            </li>
                            <?php endif; endforeach; ?>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <?php nexagen_render_process(); ?>
    <?php nexagen_render_testimonials(3); ?>
    <?php nexagen_render_cta(); ?>
</main>

<?php get_footer(); ?>
