<?php
/**
 * Affordable Web Solution Template Helpers
 * Reusable rendering functions for sections, components, and blocks.
 */

defined('ABSPATH') || exit;

/* ============================================================
   RENDER: SITE HEADER
   ============================================================ */
function nexagen_render_header(): void {
    $agency_name = nexagen_opt('agency_name', 'Affordable Web Solution');
    $cta_text    = nexagen_opt('agency_cta_text', 'Get a Free Quote');
    $cta_url     = nexagen_opt('agency_cta_url', '/contact/');

    // --- v1.1: Read new customizer settings (with safe defaults) ---
    $logo_position = get_theme_mod( 'aws_header_logo_position', 'left' );
    $show_phone    = get_theme_mod( 'aws_header_show_phone', '1' );
    $is_sticky     = get_theme_mod( 'aws_header_sticky', '1' );

    // Build header class list
    $header_classes = [ 'site-header' ];
    if ( 'center' === $logo_position ) {
        $header_classes[] = 'header-logo-center';
    }
    if ( '0' === $is_sticky ) {
        $header_classes[] = 'header-not-sticky';
    }

    $services = nexagen_get_services();
    ?>
    <a class="skip-link" href="#main"><?php _e('Skip to content', 'affordable-web-solution'); ?></a>

    <header class="<?php echo esc_attr( implode( ' ', $header_classes ) ); ?>" id="site-header" role="banner">
        <div class="container">
            <div class="header-inner">
                <!-- Logo -->
                <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr($agency_name); ?> - Home">
                    <?php if (has_custom_logo()): ?>
                        <?php the_custom_logo(); ?>
                    <?php else: ?>
                        <div class="logo-mark" aria-hidden="true">N</div>
                        <span class="logo-text"><?php echo esc_html($agency_name); ?></span>
                    <?php endif; ?>
                </a>

                <!-- Main Navigation -->
                <nav class="main-nav" role="navigation" aria-label="Primary navigation">
                    <?php
                    // Use WordPress menu if one is assigned to 'primary', else fall back to hardcoded links.
                    if ( has_nav_menu( 'primary' ) ) :
                        wp_nav_menu( [
                            'theme_location'  => 'primary',
                            'menu_class'      => 'primary-menu',
                            'container'       => false,
                            'items_wrap'      => '<ul id="%1$s" class="%2$s" role="list">%3$s</ul>',
                            'fallback_cb'     => false,
                            'walker'          => class_exists( 'AWS_Nav_Walker' ) ? new AWS_Nav_Walker() : '',
                        ] );
                    else :
                    ?>
                    <ul role="list" style="display:flex;align-items:center;gap:0.25rem;list-style:none;">
                        <li class="nav-item">
                            <a href="<?php echo home_url('/services/'); ?>" class="nav-link">
                                Services
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                            </a>
                            <div class="dropdown" role="menu">
                                <?php foreach (array_slice($services, 0, 6) as $svc): ?>
                                <a href="<?php echo home_url('/' . $svc['slug'] . '/'); ?>" class="dropdown-link" role="menuitem">
                                    <span class="dropdown-link-icon" aria-hidden="true"><?php echo $svc['icon']; ?></span>
                                    <span><?php echo esc_html($svc['title']); ?></span>
                                </a>
                                <?php endforeach; ?>
                                <a href="<?php echo home_url('/services/'); ?>" class="dropdown-link" role="menuitem" style="border-top:1px solid var(--color-border);margin-top:0.5rem;padding-top:1rem;">
                                    <span class="dropdown-link-icon" aria-hidden="true">→</span>
                                    <span>View All Services</span>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo home_url('/industries/'); ?>" class="nav-link">Industries</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo home_url('/locations/'); ?>" class="nav-link">Locations</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo home_url('/portfolio/'); ?>" class="nav-link">Portfolio</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo home_url('/about/'); ?>" class="nav-link">About</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo home_url('/blog/'); ?>" class="nav-link">Blog</a>
                        </li>
                    </ul>
                    <?php endif; ?>
                </nav>

                <!-- Header CTA -->
                <div class="header-cta">
                    <?php if ( '1' === $show_phone ) : ?>
                    <a href="tel:<?php echo esc_attr(nexagen_opt('agency_phone', '+18001234567')); ?>"
                       class="btn btn-header-phone btn-sm"
                       aria-label="Call us">
                        <?php echo esc_html(nexagen_opt('agency_phone', '(800) 123-4567')); ?>
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url($cta_url); ?>" class="btn btn-accent btn-sm">
                        <?php echo esc_html($cta_text); ?>
                    </a>
                </div>

                <!-- Mobile Hamburger -->
                <button class="hamburger" id="hamburger" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="mobile-nav">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Nav -->
    <nav class="mobile-nav" id="mobile-nav" role="navigation" aria-label="Mobile navigation" aria-hidden="true">
        <a href="<?php echo home_url('/'); ?>" class="mobile-nav-link">Home</a>
        <a href="<?php echo home_url('/services/'); ?>" class="mobile-nav-link">Services</a>
        <a href="<?php echo home_url('/industries/'); ?>" class="mobile-nav-link">Industries</a>
        <a href="<?php echo home_url('/locations/'); ?>" class="mobile-nav-link">Locations</a>
        <a href="<?php echo home_url('/portfolio/'); ?>" class="mobile-nav-link">Portfolio</a>
        <a href="<?php echo home_url('/about/'); ?>" class="mobile-nav-link">About</a>
        <a href="<?php echo home_url('/blog/'); ?>" class="mobile-nav-link">Blog</a>
        <a href="<?php echo home_url('/contact/'); ?>" class="mobile-nav-link">Contact</a>
        <div style="margin-top:2rem;">
            <a href="<?php echo esc_url($cta_url); ?>" class="btn btn-accent btn-lg" style="width:100%;justify-content:center;color:var(--color-heading);">
                <?php echo esc_html($cta_text); ?>
            </a>
        </div>
    </nav>
    <?php
}

/* ============================================================
   RENDER: SITE FOOTER
   ============================================================ */
function nexagen_render_footer(): void {
    $agency_name = nexagen_opt('agency_name', 'Affordable Web Solution');
    $phone       = nexagen_opt('agency_phone', '(800) 123-4567');
    $email       = nexagen_opt('agency_email', 'hello@affordablewebsolution.com');
    $services    = nexagen_get_services();
    $industries  = nexagen_get_industries();

    // --- v1.1: New customizer settings ---
    $footer_desc       = get_theme_mod( 'aws_footer_description', 'Premium WordPress web design & development agency. We build beautiful, high-performing websites that grow businesses across the United States.' );
    $show_logo         = get_theme_mod( 'aws_footer_show_logo', '1' );
    $show_socials      = get_theme_mod( 'aws_footer_show_socials', '1' );
    $show_stats        = get_theme_mod( 'aws_footer_show_stats', '1' );
    $show_legal        = get_theme_mod( 'aws_footer_show_legal', '1' );
    $copyright_custom  = get_theme_mod( 'aws_footer_copyright', '' );
    $cta_enable        = get_theme_mod( 'aws_footer_cta_enable', '0' );
    $cta_heading       = get_theme_mod( 'aws_footer_cta_heading', 'Ready to Grow Your Business?' );
    $cta_subtext       = get_theme_mod( 'aws_footer_cta_subtext', 'Get a free consultation and custom quote for your project.' );
    $cta_btn_text      = get_theme_mod( 'aws_footer_cta_btn_text', 'Get a Free Quote' );
    $cta_btn_url       = get_theme_mod( 'aws_footer_cta_btn_url', '/contact/' );
    $cta_bg            = sanitize_hex_color( get_theme_mod( 'aws_footer_cta_bg_color', '#C6FF4D' ) );

    // Copyright text: use custom or auto-generate
    $copyright = $copyright_custom
        ? wp_kses_post( $copyright_custom )
        : '&copy; ' . esc_html( date( 'Y' ) ) . ' ' . esc_html( $agency_name ) . '. All rights reserved.';

    $socials = [
        'facebook'  => ['url' => nexagen_opt('facebook_url'),  'icon' => 'f',  'label' => 'Facebook'],
        'twitter'   => ['url' => nexagen_opt('twitter_url'),   'icon' => 'x',  'label' => 'Twitter / X'],
        'linkedin'  => ['url' => nexagen_opt('linkedin_url'),  'icon' => 'in', 'label' => 'LinkedIn'],
        'instagram' => ['url' => nexagen_opt('instagram_url'), 'icon' => 'ig', 'label' => 'Instagram'],
        'youtube'   => ['url' => nexagen_opt('youtube_url'),   'icon' => 'yt', 'label' => 'YouTube'],
    ];
    ?>

    <?php if ( '1' === $cta_enable ) : ?>
    <!-- Pre-Footer CTA Strip -->
    <section class="aws-footer-cta-strip" style="background:<?php echo esc_attr( $cta_bg ); ?>;padding:3rem 0;">
        <div class="container" style="text-align:center;">
            <h2 class="aws-footer-cta-heading" style="color:#102117;font-size:clamp(1.5rem,3vw,2.25rem);margin-bottom:0.75rem;">
                <?php echo esc_html( $cta_heading ); ?>
            </h2>
            <p class="aws-footer-cta-subtext" style="color:rgba(16,33,23,0.75);margin-bottom:1.5rem;">
                <?php echo esc_html( $cta_subtext ); ?>
            </p>
            <a href="<?php echo esc_url( $cta_btn_url ); ?>" class="btn btn-sm aws-footer-cta-btn" style="background:#102117;color:#fff;padding:0.75rem 2rem;border-radius:0.5rem;font-weight:700;">
                <?php echo esc_html( $cta_btn_text ); ?>
            </a>
        </div>
    </section>
    <?php endif; ?>

    <footer class="site-footer" role="contentinfo">
        <div class="container">
            <div class="footer-top">
                <!-- Brand -->
                <div class="footer-brand">
                    <?php if ( '1' === $show_logo ) : ?>
                    <div class="footer-logo">
                        <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>">
                            <?php if ( has_custom_logo() ) : ?>
                                <?php the_custom_logo(); ?>
                            <?php else : ?>
                                <div class="logo-mark">N</div>
                                <span class="logo-text"><?php echo esc_html($agency_name); ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                    <?php endif; ?>
                    <p class="footer-desc">
                        <?php echo wp_kses_post( $footer_desc ); ?>
                    </p>
                    <?php if ( '1' === $show_stats ) : ?>
                    <!-- Stats -->
                    <div class="aws-footer-stats-grid">
                        <?php
                        $stats = [
                            [nexagen_opt('stats_1_num','370+'), nexagen_opt('stats_1_label','5-Star Reviews')],
                            [nexagen_opt('stats_2_num','2,500+'), nexagen_opt('stats_2_label','Projects Done')],
                            [nexagen_opt('stats_3_num','50+'), nexagen_opt('stats_3_label','Experts')],
                        ];
                        foreach ($stats as $stat): ?>
                        <div style="text-align:center;padding:0.75rem;background:rgba(255,255,255,0.05);border-radius:0.5rem;">
                            <span style="font-family:var(--font-heading);font-weight:800;font-size:1.25rem;color:var(--color-accent);display:block;"><?php echo esc_html($stat[0]); ?></span>
                            <span style="font-size:0.75rem;opacity:0.6;"><?php echo esc_html($stat[1]); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ( '1' === $show_socials ) : ?>
                    <!-- Socials -->
                    <div class="footer-socials">
                        <?php foreach ($socials as $key => $social): if (!$social['url']) continue; ?>
                        <a href="<?php echo esc_url($social['url']); ?>" class="footer-social"
                           target="_blank" rel="noopener noreferrer"
                           aria-label="<?php echo esc_attr($social['label']); ?>">
                            <?php echo strtoupper($social['icon']); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Services Column -->
                <div class="footer-col">
                    <h4>Our Services</h4>
                    <ul class="footer-links" role="list">
                        <?php foreach (array_slice($services, 0, 8) as $svc): ?>
                        <li>
                            <a href="<?php echo home_url('/' . $svc['slug'] . '/'); ?>" class="footer-link">
                                <?php echo esc_html($svc['title']); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Company Column -->
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul class="footer-links" role="list">
                        <li><a href="<?php echo home_url('/about/'); ?>" class="footer-link">About Us</a></li>
                        <li><a href="<?php echo home_url('/team/'); ?>" class="footer-link">Our Team</a></li>
                        <li><a href="<?php echo home_url('/portfolio/'); ?>" class="footer-link">Portfolio</a></li>
                        <li><a href="<?php echo home_url('/testimonials/'); ?>" class="footer-link">Testimonials</a></li>
                        <li><a href="<?php echo home_url('/blog/'); ?>" class="footer-link">Blog</a></li>
                        <li><a href="<?php echo home_url('/careers/'); ?>" class="footer-link">Careers</a></li>
                        <li><a href="<?php echo home_url('/faq/'); ?>" class="footer-link">FAQ</a></li>
                        <li><a href="<?php echo home_url('/contact/'); ?>" class="footer-link">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Contact Column -->
                <div class="footer-col">
                    <h4>Contact Us</h4>
                    <ul class="footer-links" role="list">
                        <li style="margin-bottom:1rem;">
                            <span style="display:block;font-size:0.75rem;opacity:0.5;margin-bottom:0.25rem;text-transform:uppercase;letter-spacing:0.06em;">Phone</span>
                            <a href="tel:<?php echo esc_attr(preg_replace('/\D/','',$phone)); ?>" class="footer-link" style="font-weight:600;font-size:0.9375rem;color:rgba(255,255,255,0.8);">
                                <?php echo esc_html($phone); ?>
                            </a>
                        </li>
                        <li style="margin-bottom:1rem;">
                            <span style="display:block;font-size:0.75rem;opacity:0.5;margin-bottom:0.25rem;text-transform:uppercase;letter-spacing:0.06em;">Email</span>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="footer-link" style="font-weight:600;font-size:0.9375rem;color:rgba(255,255,255,0.8);">
                                <?php echo esc_html($email); ?>
                            </a>
                        </li>
                        <li>
                            <span style="display:block;font-size:0.75rem;opacity:0.5;margin-bottom:0.25rem;text-transform:uppercase;letter-spacing:0.06em;">Address</span>
                            <span style="font-size:0.9rem;opacity:0.7;line-height:1.6;">
                                <?php echo esc_html(nexagen_opt('agency_address', '123 Digital Ave, San Francisco, CA 94105')); ?>
                            </span>
                        </li>
                    </ul>
                    <div style="margin-top:1.5rem;">
                        <a href="<?php echo home_url('/contact/'); ?>" class="btn btn-accent btn-sm" style="width:100%;justify-content:center;">
                            Get a Free Quote
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p class="footer-copy">
                    <?php echo $copyright; // Already sanitized above ?>
                </p>
                <?php if ( '1' === $show_legal ) : ?>
                <nav class="footer-legal" aria-label="Legal links">
                    <a href="<?php echo home_url('/privacy-policy/'); ?>">Privacy Policy</a>
                    <a href="<?php echo home_url('/terms/'); ?>">Terms of Service</a>
                    <a href="<?php echo home_url('/sitemap.xml'); ?>">Sitemap</a>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </footer>
    <?php
}

/* ============================================================
   RENDER: HERO SECTION (Homepage)
   ============================================================ */
function nexagen_render_hero(): void {
    $title    = nexagen_opt('hero_title',    'The WordPress Agency You\'ve Been Looking For');
    $subtitle = nexagen_opt('hero_subtitle', 'US-based WordPress design & development agency with 15+ years of experience, 2,500+ projects completed, and 370+ five-star reviews.');
    $cta1     = nexagen_opt('hero_cta1',     'Get a Free Quote');
    $cta2     = nexagen_opt('hero_cta2',     'View Our Work');
    $s1n      = nexagen_opt('stats_1_num',   '370+');
    $s1l      = nexagen_opt('stats_1_label', '5-Star Reviews');
    $s2n      = nexagen_opt('stats_2_num',   '2,500+');
    $s2l      = nexagen_opt('stats_2_label', 'Projects Delivered');
    $s3n      = nexagen_opt('stats_3_num',   '50+');
    $s3l      = nexagen_opt('stats_3_label', 'Expert Team Members');
    ?>
    <section class="hero" aria-label="Hero section">
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-bg-gradient"></div>
            <div class="hero-bg-dots"></div>
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=1400&h=800&fit=crop&auto=format&q=60" alt="" loading="eager" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.08;mix-blend-mode:luminosity;">
        </div>

        <div class="container">
            <div class="hero-content">
                <!-- Left: Text -->
                <div class="hero-text animate-fadeup">
                    <div class="hero-eyebrow">
                        <span class="hero-eyebrow-dot">★</span>
                        <span>#1 US-Based WordPress Agency</span>
                    </div>

                    <h1 class="hero-title">
                        <?php
                        // Highlight the first 2 words
                        $words = explode(' ', $title);
                        $highlighted = array_splice($words, 0, 2);
                        $rest = implode(' ', $words);
                        echo '<span class="highlight">' . esc_html(implode(' ', $highlighted)) . '</span> ' . esc_html($rest);
                        ?>
                    </h1>

                    <p class="hero-subtitle"><?php echo esc_html($subtitle); ?></p>

                    <div class="hero-actions">
                        <a href="<?php echo home_url('/contact/'); ?>" class="btn btn-primary btn-lg">
                            <?php echo esc_html($cta1); ?>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                        <a href="<?php echo home_url('/portfolio/'); ?>" class="btn btn-outline btn-lg">
                            <?php echo esc_html($cta2); ?>
                        </a>
                    </div>

                    <div class="hero-trust" role="list" aria-label="Trust indicators">
                        <?php
                        $trust = [
                            ['icon' => '✓', 'text' => '15+ Years Experience'],
                            ['icon' => '★', 'text' => '370+ Five-Star Reviews'],
                            ['icon' => '🇺🇸', 'text' => 'US-Based Team'],
                        ];
                        foreach ($trust as $item): ?>
                        <div class="hero-trust-item" role="listitem">
                            <span aria-hidden="true"><?php echo $item['icon']; ?></span>
                            <span><?php echo esc_html($item['text']); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Right: Visual -->
                <div class="hero-visual animate-fadeup delay-3" aria-hidden="true">
                    <div class="hero-card-stack">
                        <!-- Main Stats Card -->
                        <div class="hero-main-visual animate-float">
                            <div style="color:rgba(255,255,255,0.7);font-size:0.875rem;font-family:var(--font-heading);margin-bottom:1.5rem;font-weight:500;">
                                ⚡ Real-time performance dashboard
                            </div>
                            <div class="hero-stats-grid">
                                <div class="hero-stats-item">
                                    <span class="hero-stats-value"><?php echo esc_html($s1n); ?></span>
                                    <span class="hero-stats-label"><?php echo esc_html($s1l); ?></span>
                                </div>
                                <div class="hero-stats-item">
                                    <span class="hero-stats-value"><?php echo esc_html($s2n); ?></span>
                                    <span class="hero-stats-label"><?php echo esc_html($s2l); ?></span>
                                </div>
                                <div class="hero-stats-item">
                                    <span class="hero-stats-value"><?php echo esc_html($s3n); ?></span>
                                    <span class="hero-stats-label"><?php echo esc_html($s3l); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Card -->
                        <div class="hero-floating-card">
                            <div style="width:36px;height:36px;background:linear-gradient(135deg,var(--color-primary),var(--color-accent));border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1rem;">🚀</div>
                            <div>
                                <div style="font-family:var(--font-heading);font-weight:700;font-size:0.875rem;color:var(--color-heading);">Project Launched!</div>
                                <div style="font-size:0.75rem;color:var(--color-body);">Client satisfaction: 100%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}

/* ============================================================
   RENDER: TRUST BAR (Logo Strip)
   ============================================================ */
function nexagen_render_trust_bar(): void {
    $logos = ['Johns Hopkins', 'Forbes', 'United Way', 'Masonite', 'Penn State', 'Harvard Med', 'AGMA', 'MIT'];
    ?>
    <section class="trust-bar" aria-label="Trusted by leading organizations">
        <div class="container">
            <p class="trust-bar-label">Trusted by leading organizations across the US</p>
            <div class="trust-logos" role="list" aria-label="Client logos">
                <?php foreach ($logos as $logo): ?>
                <span class="trust-logo" role="listitem"><?php echo esc_html($logo); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

/* ============================================================
   RENDER: SERVICES GRID
   ============================================================ */
function nexagen_render_services_grid(int $limit = 6): void {
    $services = array_slice(nexagen_get_services(), 0, $limit);
    ?>
    <section class="section bg-card" aria-labelledby="services-heading">
        <div class="container">
            <div class="section-header">
                <div class="section-label">What We Do</div>
                <h2 id="services-heading">Expert WordPress Services That Drive Results</h2>
                <p>From beautiful custom design to robust development, managed hosting, and ongoing support — we handle every aspect of your WordPress website.</p>
            </div>

            <div class="services-grid" role="list">
                <?php foreach ($services as $svc): ?>
                <article class="service-card" role="listitem" style="padding:0;overflow:hidden;">
                    <?php if (!empty($svc['img'])): ?>
                    <div style="width:100%;height:160px;overflow:hidden;">
                        <img src="<?php echo esc_url($svc['img']); ?>" alt="<?php echo esc_attr($svc['title']); ?>" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.4s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    </div>
                    <?php endif; ?>
                    <div style="padding:1.5rem 1.75rem 1.75rem;">
                        <div class="service-icon" aria-hidden="true"><?php echo $svc['icon']; ?></div>
                        <h3><?php echo esc_html($svc['title']); ?></h3>
                        <p><?php echo esc_html($svc['desc']); ?></p>
                        <a href="<?php echo home_url('/' . $svc['slug'] . '/'); ?>" class="service-link" aria-label="Learn more about <?php echo esc_attr($svc['title']); ?>">
                            Learn more
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

            <div style="text-align:center;margin-top:2.5rem;">
                <a href="<?php echo home_url('/services/'); ?>" class="btn btn-outline">
                    View All Services
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </div>
    </section>
    <?php
}

/* ============================================================
   RENDER: STATS ROW
   ============================================================ */
function nexagen_render_stats_row(): void {
    $stats = [
        [nexagen_opt('stats_1_num','370+'), nexagen_opt('stats_1_label','5-Star Google Reviews'), '⭐'],
        [nexagen_opt('stats_2_num','2,500+'), nexagen_opt('stats_2_label','Happy Clients Served'), '😊'],
        [nexagen_opt('stats_3_num','50+'), nexagen_opt('stats_3_label','In-House WP Experts'), '👥'],
        ['15+', 'Years in Business', '🏆'],
    ];
    ?>
    <section class="section--sm bg-card aws-stats-section" aria-label="Agency statistics">
        <div class="container">
            <div class="stats-row stats-row--4col" role="list">
                <?php foreach ($stats as $stat): ?>
                <div class="stat-item" role="listitem">
                    <span class="stat-value"><?php echo esc_html($stat[0]); ?></span>
                    <span class="stat-label"><?php echo esc_html($stat[1]); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

/* ============================================================
   RENDER: WHY CHOOSE US
   ============================================================ */
function nexagen_render_why_us(): void {
    $reasons = [
        ['icon' => '🎯', 'title' => 'WordPress Specialists', 'desc' => 'We only do WordPress. This focus means you get deeper expertise and better results than a generalist agency.'],
        ['icon' => '🇺🇸', 'title' => 'US-Based In-House Team', 'desc' => 'No outsourcing, no surprises. Our entire team is based in the United States with excellent communication.'],
        ['icon' => '🚀', 'title' => 'Performance-First Builds', 'desc' => 'Every site we build is optimized for Core Web Vitals, 90+ PageSpeed scores, and sub-second load times.'],
        ['icon' => '🔒', 'title' => 'Security-Hardened', 'desc' => 'WordPress security is built into every project — from hardening and scanning to ongoing monitoring and updates.'],
        ['icon' => '📈', 'title' => 'SEO Built In', 'desc' => 'We build SEO into the DNA of every website — semantic HTML, schema markup, optimized content structure.'],
        ['icon' => '❤️', 'title' => '100% Satisfaction Guarantee', 'desc' => 'We\'re not done until you\'re completely happy. Our track record of 370+ five-star reviews speaks for itself.'],
    ];
    ?>
    <section class="section" aria-labelledby="why-heading">
        <div class="container">
            <div class="why-grid">
                <!-- Visual -->
                <div class="why-visual animate-fadeup" aria-hidden="true">
                    <div class="why-main-block" style="position:relative;overflow:hidden;">
                        <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=600&h=500&fit=crop&auto=format&q=60" alt="" loading="lazy" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.12;mix-blend-mode:luminosity;border-radius:var(--radius-2xl);">
                        <div style="position:relative;z-index:1;">
                        <div style="font-size:0.875rem;color:rgba(255,255,255,0.7);margin-bottom:1rem;font-family:var(--font-heading);font-weight:600;">WHY AFFORDABLE WEB SOLUTION</div>
                        <div style="font-family:var(--font-heading);font-weight:900;font-size:2rem;color:var(--color-white);line-height:1.2;margin-bottom:1.5rem;">
                            WordPress experts you can actually trust.
                        </div>
                        <div style="display:flex;gap:1rem;">
                            <?php
                            $mini = [['370+','5-Star Reviews'],['2500+','Clients Served']];
                            foreach ($mini as $m): ?>
                            <div style="background:rgba(255,255,255,0.1);border-radius:0.75rem;padding:1rem;flex:1;">
                                <div style="font-family:var(--font-heading);font-weight:800;font-size:1.5rem;color:var(--color-accent);"><?php echo esc_html($m[0]); ?></div>
                                <div style="font-size:0.8125rem;color:rgba(255,255,255,0.7);"><?php echo esc_html($m[1]); ?></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        </div>
                    </div>
                    <div class="why-badge-float">
                        <span class="why-badge-num">15+</span>
                        <span class="why-badge-text">Years Expert<br>Experience</span>
                    </div>
                </div>

                <!-- Content -->
                <div>
                    <div class="section-label">Why Us</div>
                    <h2 id="why-heading" style="margin-bottom:0.75rem;">Say Hello to Best-in-Industry Expertise</h2>
                    <p style="margin-bottom:2rem;">We're not just another web agency. We're WordPress specialists — and that specialization makes all the difference.</p>

                    <div class="why-list" role="list">
                        <?php foreach ($reasons as $reason): ?>
                        <div class="why-item" role="listitem">
                            <div class="why-item-icon" aria-hidden="true"><?php echo $reason['icon']; ?></div>
                            <div class="why-item-content">
                                <h4><?php echo esc_html($reason['title']); ?></h4>
                                <p><?php echo esc_html($reason['desc']); ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div style="margin-top:2rem;">
                        <a href="<?php echo home_url('/about/'); ?>" class="btn btn-primary">
                            Meet Our Team
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}

/* ============================================================
   RENDER: PROCESS
   ============================================================ */
function nexagen_render_process(): void {
    $steps = [
        ['title' => 'Discovery & Brief',     'desc' => 'We deep-dive into your business, brand, goals, and competition to build a strategic foundation.'],
        ['title' => 'Design & Mockups',      'desc' => 'Our designers create stunning custom mockups with your feedback shaping every detail.'],
        ['title' => 'Build & Develop',       'desc' => 'Expert WordPress developers bring the approved design to life with clean, performant code.'],
        ['title' => 'Launch & Grow',         'desc' => 'We launch your site and provide ongoing support, maintenance, and SEO to help it grow.'],
    ];
    ?>
    <section class="section bg-card" aria-labelledby="process-heading">
        <div class="container">
            <div class="section-header">
                <div class="section-label">How We Work</div>
                <h2 id="process-heading">Our Proven 4-Step Process</h2>
                <p>A refined workflow built over 15+ years that delivers exceptional results on time, every time.</p>
            </div>

            <div class="aws-process-layout">
                <div class="process-steps" role="list">
                    <?php foreach ($steps as $i => $step): ?>
                    <div class="process-step reveal" role="listitem">
                        <div class="process-num" aria-label="Step <?php echo $i+1; ?>"><?php echo str_pad($i+1, 2, '0', STR_PAD_LEFT); ?></div>
                        <h4><?php echo esc_html($step['title']); ?></h4>
                        <p><?php echo esc_html($step['desc']); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="aws-process-image">
                    <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=720&h=600&fit=crop&auto=format&q=80" alt="Our team collaborating on a web design project" loading="lazy">
                </div>
            </div>
        </div>
    </section>
    <?php
}

/* ============================================================
   RENDER: TESTIMONIALS
   ============================================================ */
function nexagen_render_testimonials(int $limit = 3): void {
    $testimonials = [
        ['name' => 'Sarah Johnson',   'company' => 'TechVentures Inc.',    'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'Affordable Web Solution delivered a stunning WordPress website that exceeded all our expectations. Their team is responsive, professional, and truly expert at what they do. Our site traffic increased 180% within 3 months of launch.',    'rating' => 5],
        ['name' => 'Michael Torres',  'company' => 'Coastal Law Group',    'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'We\'ve worked with several web agencies over the years, but Affordable Web Solution is by far the best. They understood our law firm\'s needs perfectly and delivered a site that projects exactly the right level of trust and professionalism.',   'rating' => 5],
        ['name' => 'Dr. Emily Chen',  'company' => 'Northside Medical Ctr','avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'As a healthcare provider, our website needs to be both compliant and patient-friendly. Affordable Web Solution nailed both. The new site has significantly improved our patient acquisition and the feedback from patients has been overwhelmingly positive.', 'rating' => 5],
        ['name' => 'David Kim',       'company' => 'Apex Construction',    'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'The project was delivered on time, on budget, and the quality was exceptional. Affordable Web Solution\'s team communicated clearly throughout the entire process and was always available to answer our questions.', 'rating' => 5],
        ['name' => 'Rachel Foster',   'company' => 'Bloom Boutique',       'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'Our WooCommerce store has never performed better. Sales are up 240% since the redesign, and our customers constantly compliment how easy the shopping experience is. Affordable Web Solution transformed our business.',    'rating' => 5],
        ['name' => 'James Mitchell',  'company' => 'GreenPath Non-Profit',  'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'Working with Affordable Web Solution was a fantastic experience from start to finish. They took the time to truly understand our mission and built a website that inspires donors and volunteers alike. Couldn\'t be happier.',   'rating' => 5],
    ];

    $display = array_slice($testimonials, 0, $limit);
    ?>
    <section class="section bg-white" aria-labelledby="testimonials-heading">
        <div class="container">
            <div class="section-header">
                <div class="section-label">What Clients Say</div>
                <h2 id="testimonials-heading">370+ Five-Star Reviews and Counting</h2>
                <p>Don't take our word for it. Here's what our clients across the United States have to say about working with Affordable Web Solution.</p>
            </div>

            <div class="testimonials-grid" role="list">
                <?php foreach ($display as $t): ?>
                <article class="testimonial-card reveal" role="listitem">
                    <div class="testimonial-stars" aria-label="<?php echo $t['rating']; ?> star rating" role="img">
                        <?php for ($i = 0; $i < $t['rating']; $i++): ?>
                        <span class="star" aria-hidden="true">★</span>
                        <?php endfor; ?>
                    </div>
                    <blockquote>
                        <p class="testimonial-text">"<?php echo esc_html($t['text']); ?>"</p>
                    </blockquote>
                    <div class="testimonial-author">
                        <img src="<?php echo esc_url($t['avatar']); ?>" alt="<?php echo esc_attr($t['name']); ?>" loading="lazy" style="width:48px;height:48px;border-radius:50%;object-fit:cover;flex-shrink:0;border:2px solid var(--color-accent);">
                        <div>
                            <div class="testimonial-name"><?php echo esc_html($t['name']); ?></div>
                            <div class="testimonial-company"><?php echo esc_html($t['company']); ?></div>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

            <div style="text-align:center;margin-top:2.5rem;">
                <a href="<?php echo home_url('/testimonials/'); ?>" class="btn btn-outline">Read All Reviews</a>
            </div>
        </div>
    </section>
    <?php
}

/* ============================================================
   RENDER: PORTFOLIO SHOWCASE
   ============================================================ */
function nexagen_render_portfolio(int $limit = 4): void {
    $projects = [
        ['title' => 'Dickson Data',       'cat' => 'Enterprise Website',     'desc' => 'WordPress rebuild & compliance-focused digital modernization',   'color' => 'linear-gradient(135deg,#1a3a5c,#2d6a9f)', 'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=600&fit=crop&auto=format&q=75'],
        ['title' => 'Pure Health',         'cat' => 'WooCommerce Store',       'desc' => 'Premium membership experience & rewards program launch',           'color' => 'linear-gradient(135deg,#2d5016,#4a8025)', 'img' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=800&h=500&fit=crop&auto=format&q=75'],
        ['title' => 'INDEVCO NA',          'cat' => 'Dual Brand Rebuild',      'desc' => 'Two sister brand websites with unified design system',             'color' => 'linear-gradient(135deg,#3d1a5c,#6d2d9f)', 'img' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&h=500&fit=crop&auto=format&q=75'],
        ['title' => 'United Way',          'cat' => 'Non-Profit Platform',     'desc' => 'High-impact fundraising website with donation integration',        'color' => 'linear-gradient(135deg,#5c1a1a,#9f2d2d)', 'img' => 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?w=800&h=500&fit=crop&auto=format&q=75'],
        ['title' => 'HRchitect',           'cat' => 'B2B SaaS Website',        'desc' => 'Technical optimization & performance overhaul',                    'color' => 'linear-gradient(135deg,#1a3d5c,#2d7a9f)', 'img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=500&fit=crop&auto=format&q=75'],
        ['title' => 'Seeding Action',      'cat' => 'Campaign Landing Page',   'desc' => '"Air We Share" initiative — compelling storytelling',              'color' => 'linear-gradient(135deg,#1d5c1a,#2d9f35)', 'img' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800&h=500&fit=crop&auto=format&q=75'],
    ];

    $display = array_slice($projects, 0, $limit);
    ?>
    <section class="section bg-card" aria-labelledby="portfolio-heading">
        <div class="container">
            <div class="section-header">
                <div class="section-label">Our Work</div>
                <h2 id="portfolio-heading">Real Projects, Real Results</h2>
                <p>A glimpse into the work we've done for clients across industries. Every project is a story of transformation.</p>
            </div>

            <div class="portfolio-grid" role="list" style="margin-top:3rem;">
                <?php foreach ($display as $i => $proj): ?>
                <article class="portfolio-card <?php echo $i === 0 ? 'portfolio-card--tall' : ''; ?>" role="listitem">
                    <div class="portfolio-bg" style="background:<?php echo $proj['color']; ?>;" aria-hidden="true"></div>
                    <img src="<?php echo esc_url($proj['img']); ?>" alt="<?php echo esc_attr($proj['title']); ?> project screenshot" loading="lazy" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.35;mix-blend-mode:luminosity;">
                    <div class="portfolio-overlay">
                        <div>
                            <span class="portfolio-tag"><?php echo esc_html($proj['cat']); ?></span>
                            <h3 class="portfolio-title"><?php echo esc_html($proj['title']); ?></h3>
                            <p class="portfolio-desc"><?php echo esc_html($proj['desc']); ?></p>
                        </div>
                    </div>
                    <a href="<?php echo home_url('/portfolio/'); ?>" aria-label="View <?php echo esc_attr($proj['title']); ?> case study" style="position:absolute;inset:0;z-index:10;"></a>
                </article>
                <?php endforeach; ?>
            </div>

            <div style="text-align:center;margin-top:2.5rem;">
                <a href="<?php echo home_url('/portfolio/'); ?>" class="btn btn-primary">
                    View All Case Studies
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </div>
    </section>
    <?php
}

/* ============================================================
   RENDER: PRICING
   ============================================================ */
function nexagen_render_pricing(): void {
    $plans = [
        [
            'label'    => 'Starter',
            'title'    => 'Launch',
            'price'    => '2,997',
            'period'   => 'one-time',
            'desc'     => 'Perfect for small businesses and startups ready to establish a professional online presence.',
            'featured' => false,
            'features' => ['Custom WordPress design','Up to 10 pages','Mobile-responsive','Basic SEO setup','Contact form','1 month support','Managed hosting setup'],
        ],
        [
            'label'    => 'Most Popular',
            'title'    => 'Grow',
            'price'    => '5,997',
            'period'   => 'one-time',
            'desc'     => 'For growing businesses that need a powerful, scalable website to drive serious results.',
            'featured' => true,
            'features' => ['Everything in Launch','Up to 25 pages','WooCommerce/eCommerce','Advanced SEO package','Blog system','3 months support','Speed optimization','Custom post types','Analytics integration'],
        ],
        [
            'label'    => 'Enterprise',
            'title'    => 'Scale',
            'price'    => 'Custom',
            'period'   => 'contact us',
            'desc'     => 'For large organizations requiring custom development, integrations, and enterprise-grade solutions.',
            'featured' => false,
            'features' => ['Everything in Grow','Unlimited pages','Custom functionality','API integrations','Multisite support','Priority support','Dedicated account manager','Monthly performance reports','White-glove service'],
        ],
    ];
    ?>
    <section class="section" aria-labelledby="pricing-heading">
        <div class="container">
            <div class="section-header">
                <div class="section-label">Investment</div>
                <h2 id="pricing-heading">Transparent, Honest Pricing</h2>
                <p>No hidden fees. No surprises. Choose the plan that fits your business needs and budget.</p>
            </div>

            <div class="pricing-grid" role="list" style="margin-top:3rem;">
                <?php foreach ($plans as $plan): ?>
                <div class="pricing-card <?php echo $plan['featured'] ? 'pricing-card--featured' : ''; ?>" role="listitem">
                    <div class="pricing-label"><?php echo esc_html($plan['label']); ?></div>
                    <h3><?php echo esc_html($plan['title']); ?></h3>
                    <div class="pricing-price-wrap">
                        <div class="pricing-price">
                            <?php echo $plan['price'] === 'Custom' ? 'Custom' : ('$' . esc_html($plan['price'])); ?>
                        </div>
                        <div class="pricing-period"><?php echo esc_html($plan['period']); ?></div>
                    </div>
                    <p class="pricing-desc"><?php echo esc_html($plan['desc']); ?></p>
                    <ul class="pricing-features" role="list">
                        <?php foreach ($plan['features'] as $feat): ?>
                        <li class="pricing-feature" role="listitem">
                            <span class="pricing-feature-icon" aria-hidden="true">✓</span>
                            <span><?php echo esc_html($feat); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?php echo home_url('/contact/'); ?>"
                       class="btn <?php echo $plan['featured'] ? 'btn-accent' : 'btn-primary'; ?>"
                       style="width:100%;justify-content:center;">
                        <?php echo $plan['price'] === 'Custom' ? 'Contact Us' : 'Get Started'; ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>

            <p style="text-align:center;margin-top:1.5rem;font-size:0.875rem;color:var(--color-body);opacity:0.7;">
                Maintenance plans starting at $199/month. All projects include a 100% satisfaction guarantee.
            </p>
        </div>
    </section>
    <?php
}

/* ============================================================
   RENDER: FAQ ACCORDION
   ============================================================ */
function nexagen_render_faq(array $faqs = []): void {
    if (empty($faqs)) {
        $faqs = [
            ['q' => 'How long does a WordPress website project take?',           'a' => 'Most projects are completed in 4-12 weeks, depending on scope and complexity. During our initial consultation, we\'ll provide a detailed timeline specific to your project. We pride ourselves on delivering on time — our on-time delivery rate is over 95%.'],
            ['q' => 'What is your pricing for WordPress web design?',             'a' => 'Our web design projects start at $2,997 for a custom starter website. Pricing varies based on scope, number of pages, custom functionality, and integrations required. We provide detailed, transparent quotes with no hidden fees before any project begins.'],
            ['q' => 'Do you offer ongoing maintenance and support?',              'a' => 'Yes! We offer comprehensive WordPress maintenance plans starting at $199/month. These plans include regular updates, security scanning, backups, uptime monitoring, and on-demand support. We recommend ongoing maintenance for every WordPress website.'],
            ['q' => 'Will my website be mobile-responsive?',                     'a' => 'Absolutely. Every website we build is designed and developed with a mobile-first approach. Your site will look and perform perfectly on all screen sizes — from smartphones and tablets to desktop computers and large monitors.'],
            ['q' => 'Do you work with clients outside your local area?',          'a' => 'We work with clients across the entire United States and internationally. As a fully remote-capable agency, we\'ve served clients in all 50 states. Distance is never a barrier to great work — we use video calls, project management tools, and clear communication to keep every project on track.'],
            ['q' => 'What happens after my website launches?',                   'a' => 'Launch is just the beginning. We provide thorough training so your team can manage the site confidently. We also offer ongoing maintenance, hosting, SEO, and support plans to ensure your site continues to perform and grow after launch.'],
            ['q' => 'Do you build SEO into your websites?',                      'a' => 'Yes — SEO is built into the DNA of every website we create. We implement proper heading structure, schema markup, optimized page speed, semantic HTML, clean URLs, and mobile-first design. We also offer dedicated SEO programs for clients who want to go further.'],
            ['q' => 'Can you redesign my existing WordPress website?',           'a' => 'Absolutely. Website redesigns are a significant part of our work. We can redesign your existing WordPress site while preserving your content, SEO rankings, and URLs. We\'ll create a fresh, modern design that better serves your business goals.'],
        ];
    }

    nexagen_faq_schema($faqs);
    ?>
    <section class="section bg-card" aria-labelledby="faq-heading">
        <div class="container">
            <div class="section-header">
                <div class="section-label">FAQ</div>
                <h2 id="faq-heading">Frequently Asked Questions</h2>
                <p>Everything you need to know about working with Affordable Web Solution.</p>
            </div>

            <div class="faq-list" role="list">
                <?php foreach ($faqs as $i => $faq): ?>
                <div class="faq-item" role="listitem" id="faq-<?php echo $i; ?>">
                    <button class="faq-question"
                            aria-expanded="false"
                            aria-controls="faq-answer-<?php echo $i; ?>"
                            onclick="awsToggleFaq(this)">
                        <?php echo esc_html($faq['q']); ?>
                        <span class="faq-icon" aria-hidden="true">+</span>
                    </button>
                    <div class="faq-answer" id="faq-answer-<?php echo $i; ?>" role="region" aria-labelledby="faq-<?php echo $i; ?>">
                        <p><?php echo esc_html($faq['a']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div style="text-align:center;margin-top:2.5rem;">
                <p style="margin-bottom:1rem;color:var(--color-body);">Still have questions? We'd love to help.</p>
                <a href="<?php echo home_url('/contact/'); ?>" class="btn btn-primary">Contact Our Team</a>
            </div>
        </div>
    </section>
    <?php
}

/* ============================================================
   RENDER: CTA BANNER
   ============================================================ */
function nexagen_render_cta(
    string $title   = 'Ready to Build Something Amazing?',
    string $desc    = 'Join 2,500+ businesses across the United States that trust Affordable Web Solution for their WordPress websites. Let\'s discuss your project.',
    string $btn1    = 'Get a Free Quote',
    string $btn1url = '',
    string $btn2    = 'View Our Work',
    string $btn2url = ''
): void {
    if (!$btn1url) $btn1url = home_url('/contact/');
    if (!$btn2url) $btn2url = home_url('/portfolio/');
    ?>
    <section class="section" aria-label="Call to action">
        <div class="cta-section">
            <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">Let's Work Together</div>
            <h2><?php echo esc_html($title); ?></h2>
            <p><?php echo esc_html($desc); ?></p>
            <div class="cta-actions">
                <a href="<?php echo esc_url($btn1url); ?>" class="btn btn-accent btn-lg">
                    <?php echo esc_html($btn1); ?>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="<?php echo esc_url($btn2url); ?>" class="btn btn-white">
                    <?php echo esc_html($btn2); ?>
                </a>
            </div>
        </div>
    </section>
    <?php
}

/* ============================================================
   RENDER: BLOG PREVIEW
   ============================================================ */
function nexagen_render_blog_preview(int $limit = 3): void {
    $args = [
        'post_type'      => 'post',
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    $posts = get_posts($args);
    if (empty($posts)) return;
    ?>
    <section class="section" aria-labelledby="blog-heading">
        <div class="container">
            <div class="section-header" style="display:flex;justify-content:space-between;align-items:flex-end;text-align:left;max-width:none;margin:0;">
                <div>
                    <div class="section-label">Latest Insights</div>
                    <h2 id="blog-heading">From Our WordPress Blog</h2>
                </div>
                <a href="<?php echo home_url('/blog/'); ?>" class="btn btn-outline" style="flex-shrink:0;">View All Posts</a>
            </div>

            <div class="blog-grid" style="margin-top:3rem;" role="list">
                <?php foreach ($posts as $post): setup_postdata($post); ?>
                <article class="blog-card" role="listitem">
                    <div class="blog-card-img">
                        <?php if (has_post_thumbnail($post->ID)): ?>
                            <?php echo get_the_post_thumbnail($post->ID, 'aws-card'); ?>
                        <?php else:
                            $fallback_imgs = [
                                'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=400&fit=crop&auto=format',
                                'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=600&h=400&fit=crop&auto=format',
                                'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=600&h=400&fit=crop&auto=format',
                                'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=400&fit=crop&auto=format',
                                'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&h=400&fit=crop&auto=format',
                            ];
                            $img_url = $fallback_imgs[$post->ID % count($fallback_imgs)];
                        ?>
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title($post)); ?>" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
                        <?php endif; ?>
                    </div>
                    <div class="blog-card-body">
                        <?php
                        $cats = get_the_category($post->ID);
                        if ($cats): ?>
                        <div class="blog-cat"><?php echo esc_html($cats[0]->name); ?></div>
                        <?php endif; ?>
                        <h3>
                            <a href="<?php echo esc_url(get_permalink($post)); ?>">
                                <?php echo esc_html(get_the_title($post)); ?>
                            </a>
                        </h3>
                        <div class="blog-meta">
                            <?php echo esc_html(get_the_date('M j, Y', $post)); ?>
                            &bull;
                            <?php
                            $content   = get_post_field('post_content', $post->ID);
                            $word_count = str_word_count(strip_tags($content));
                            echo ceil($word_count / 200) . ' min read';
                            ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
    <?php
}

/* ============================================================
   RENDER: CONTACT FORM
   ============================================================ */
function nexagen_render_contact_form(): void {
    $services = nexagen_get_services();
    ?>
    <section class="section" id="contact" aria-labelledby="contact-heading">
        <div class="container">
            <div class="contact-grid">
                <!-- Info -->
                <div class="contact-info">
                    <div class="section-label">Get in Touch</div>
                    <h2 id="contact-heading">Let's Discuss Your WordPress Project</h2>
                    <p>Fill out the form and one of our WordPress experts will get back to you within 24 hours. No pressure, no sales pitch — just a genuine conversation about your project.</p>

                    <?php
                    $details = [
                        ['icon' => '📞', 'label' => 'Phone', 'value' => nexagen_opt('agency_phone', '(800) 123-4567'), 'href' => 'tel:' . preg_replace('/\D/', '', nexagen_opt('agency_phone', '8001234567'))],
                        ['icon' => '✉️', 'label' => 'Email', 'value' => nexagen_opt('agency_email', 'hello@affordablewebsolution.com'), 'href' => 'mailto:' . nexagen_opt('agency_email', 'hello@affordablewebsolution.com')],
                        ['icon' => '📍', 'label' => 'Location', 'value' => nexagen_opt('agency_address', '123 Digital Ave, San Francisco, CA 94105'), 'href' => null],
                    ];
                    foreach ($details as $d): ?>
                    <div class="contact-detail">
                        <div class="contact-detail-icon" aria-hidden="true"><?php echo $d['icon']; ?></div>
                        <div>
                            <div class="contact-detail-label"><?php echo esc_html($d['label']); ?></div>
                            <?php if ($d['href']): ?>
                            <a href="<?php echo esc_attr($d['href']); ?>" class="contact-detail-value">
                                <?php echo esc_html($d['value']); ?>
                            </a>
                            <?php else: ?>
                            <div class="contact-detail-value"><?php echo esc_html($d['value']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <!-- Trust badges -->
                    <div style="margin-top:2rem;padding:1.5rem;background:var(--color-card);border-radius:var(--radius-lg);border:1px solid var(--color-border);">
                        <div style="font-family:var(--font-heading);font-weight:700;font-size:0.875rem;color:var(--color-heading);margin-bottom:1rem;">Why businesses choose us:</div>
                        <?php
                        $badges = ['✓ Free initial consultation', '✓ No-obligation quote', '✓ 100% satisfaction guarantee', '✓ Response within 24 hours'];
                        foreach ($badges as $badge): ?>
                        <div style="font-size:0.875rem;color:var(--color-body);padding:0.375rem 0;"><?php echo esc_html($badge); ?></div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Office / Team visual -->
                    <div style="margin-top:1.5rem;border-radius:var(--radius-xl);overflow:hidden;height:200px;">
                        <img src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=640&h=400&fit=crop&auto=format&q=80" alt="Affordable Web Solution headquarters" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block;">
                    </div>
                </div>

                <!-- Form -->
                <div class="contact-form">
                    <?php echo do_shortcode('[contact-form-7 id="77daf18" title="Contact"]'); ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}

/* ============================================================
   RENDER: LOCATION CITIES GRID
   ============================================================ */
function nexagen_render_cities_grid(string $state_slug): void {
    $states = nexagen_get_states();
    if (!isset($states[$state_slug])) return;

    $state  = $states[$state_slug];
    $cities = $state['cities'];
    $abbr   = $state['abbr'];
    ?>
    <div class="section-label" style="margin-top:2rem;">Cities We Serve in <?php echo esc_html($state['name']); ?></div>
    <div class="location-cities-grid" role="list">
        <?php foreach ($cities as $city): ?>
        <a href="<?php echo home_url('/' . sanitize_title($city . '-' . strtolower($abbr)) . '/'); ?>"
           class="city-link"
           role="listitem"
           aria-label="WordPress web design in <?php echo esc_attr($city); ?>, <?php echo esc_attr($abbr); ?>">
            <?php echo esc_html($city) . ', ' . esc_html($abbr); ?>
        </a>
        <?php endforeach; ?>
    </div>
    <?php
}
