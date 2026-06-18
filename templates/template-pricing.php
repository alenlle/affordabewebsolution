<?php
/**
 * Template Name: Pricing
 */
get_header();
?>

<main>
    <div class="page-hero">
        <div class="container">
            <?php nexagen_render_breadcrumb(); ?>
            <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">Investment</div>
            <h1>Transparent, Honest WordPress Pricing</h1>
            <p>No hidden fees, no surprises, no upsells. Just clear, fair pricing for exceptional WordPress work.</p>
        </div>
    </div>

    <?php nexagen_render_pricing(); ?>
    <?php nexagen_render_faq(); ?>

    <!-- Visual Trust Banner -->
    <section style="padding:0;overflow:hidden;max-height:320px;position:relative;">
        <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1400&h=320&fit=crop&auto=format&q=75" alt="Our team delivering exceptional web projects" loading="lazy" style="width:100%;height:320px;object-fit:cover;display:block;filter:brightness(0.55);">
        <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;color:#fff;padding:2rem;">
            <div style="font-family:var(--font-heading);font-weight:900;font-size:2rem;margin-bottom:0.75rem;line-height:1.2;">Every Plan Backed by a 100% Satisfaction Guarantee</div>
            <p style="opacity:0.85;font-size:1.0625rem;max-width:560px;">We're not done until you're completely happy. That's our promise to every client.</p>
        </div>
    </section>

    <!-- Maintenance Plans -->
    <section class="section bg-card">
        <div class="container">
            <div class="section-header">
                <div class="section-label">Ongoing Care</div>
                <h2>WordPress Maintenance Plans</h2>
                <p>Keep your website secure, fast, and up to date with our managed maintenance plans.</p>
            </div>
            <div class="pricing-grid">
                <?php
                $plans = [
                    ['name' => 'Basic Care', 'price' => '199', 'features' => ['Monthly WordPress updates', 'Security scanning', 'Automated backups', 'Uptime monitoring', 'Email support']],
                    ['name' => 'Pro Care',   'price' => '349', 'featured' => true, 'features' => ['Everything in Basic', 'Weekly updates', 'Daily backups', 'Speed optimization', 'Priority support', '1hr content edits/mo', 'Monthly performance report']],
                    ['name' => 'Elite Care', 'price' => '599', 'features' => ['Everything in Pro', 'Daily security scans', 'A/B testing', 'Dedicated manager', '4hr content edits/mo', 'SEO monitoring', 'Quarterly strategy call']],
                ];
                foreach ($plans as $plan): ?>
                <div class="pricing-card <?php echo isset($plan['featured']) ? 'pricing-card--featured' : ''; ?>">
                    <div class="pricing-label"><?php echo esc_html($plan['name']); ?></div>
                    <div class="pricing-price-wrap">
                        <div class="pricing-price">$<?php echo esc_html($plan['price']); ?></div>
                        <div class="pricing-period">/month</div>
                    </div>
                    <ul class="pricing-features">
                        <?php foreach ($plan['features'] as $feat): ?>
                        <li class="pricing-feature">
                            <span class="pricing-feature-icon">✓</span>
                            <?php echo esc_html($feat); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?php echo home_url('/contact/'); ?>" class="btn <?php echo isset($plan['featured']) ? 'btn-accent' : 'btn-primary'; ?>" style="width:100%;justify-content:center;">
                        Get Started
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php nexagen_render_cta(); ?>
</main>

<?php get_footer(); ?>
