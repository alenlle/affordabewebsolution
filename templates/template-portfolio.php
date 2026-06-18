<?php
/**
 * Template Name: Portfolio
 */
get_header();
$projects = [
    ['title' => 'Dickson Data',        'cat' => 'Enterprise Website',   'desc' => 'Complete WordPress rebuild with compliance-focused digital modernization and enhanced UX.',       'color' => 'linear-gradient(135deg,#1a3a5c,#2d6a9f)', 'result' => '+180% organic traffic',   'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=600&fit=crop&auto=format&q=75'],
    ['title' => 'Pure Health Peptides', 'cat' => 'WooCommerce',         'desc' => 'Premium membership experience & rewards program launch for a fast-growing health brand.',        'color' => 'linear-gradient(135deg,#2d5016,#4a8025)', 'result' => '+240% online sales',      'img' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=800&h=500&fit=crop&auto=format&q=75'],
    ['title' => 'INDEVCO North America', 'cat' => 'Dual Brand Rebuild', 'desc' => 'Two sister WordPress websites with a unified premium design system for industrial brands.',     'color' => 'linear-gradient(135deg,#3d1a5c,#6d2d9f)', 'result' => 'Delivered on time',       'img' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&h=500&fit=crop&auto=format&q=75'],
    ['title' => 'HRchitect',            'cat' => 'B2B SaaS',           'desc' => 'Technical optimization and performance overhaul delivering 90+ PageSpeed scores.',               'color' => 'linear-gradient(135deg,#1a3d5c,#2d7a9f)', 'result' => '90+ PageSpeed score',     'img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=500&fit=crop&auto=format&q=75'],
    ['title' => 'United Way',           'cat' => 'Non-Profit',         'desc' => 'High-impact fundraising website with seamless donation integration and compelling storytelling.',  'color' => 'linear-gradient(135deg,#5c1a1a,#9f2d2d)', 'result' => '+65% donations',          'img' => 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?w=800&h=500&fit=crop&auto=format&q=75'],
    ['title' => 'Seeding Action',       'cat' => 'Campaign Page',      'desc' => '"Air We Share" initiative landing page — compelling environmental storytelling and action.',      'color' => 'linear-gradient(135deg,#1d5c1a,#2d9f35)', 'result' => 'Award-winning design',    'img' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800&h=500&fit=crop&auto=format&q=75'],
    ['title' => 'American Guild',       'cat' => 'Association',        'desc' => 'Professional association website with member portal, events calendar, and resources section.',    'color' => 'linear-gradient(135deg,#5c4a1a,#9f7d2d)', 'result' => '+120% member engagement', 'img' => 'https://images.unsplash.com/photo-1528605248644-14dd04022da1?w=800&h=500&fit=crop&auto=format&q=75'],
    ['title' => 'Apex Construction',    'cat' => 'Construction',       'desc' => 'Portfolio-driven construction company website with project galleries and lead generation.',       'color' => 'linear-gradient(135deg,#1a2a5c,#2d4a9f)', 'result' => '3× lead generation',      'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&h=500&fit=crop&auto=format&q=75'],
];
?>

<main>
    <div class="page-hero">
        <div class="container">
            <?php nexagen_render_breadcrumb(); ?>
            <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">Case Studies</div>
            <h1>Real Projects, Real Results</h1>
            <p>Explore our work across industries and see how we've helped 2,500+ businesses transform their online presence.</p>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="portfolio-grid">
                <?php foreach ($projects as $i => $proj): ?>
                <article class="portfolio-card <?php echo $i === 0 ? 'portfolio-card--tall' : ''; ?>" style="cursor:default;">
                    <div class="portfolio-bg" style="background:<?php echo $proj['color']; ?>;"></div>
                    <img src="<?php echo esc_url($proj['img']); ?>" alt="<?php echo esc_attr($proj['title']); ?> website screenshot" loading="lazy" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.35;mix-blend-mode:luminosity;">
                    <div class="portfolio-overlay">
                        <div>
                            <span class="portfolio-tag"><?php echo esc_html($proj['cat']); ?></span>
                            <h2 class="portfolio-title"><?php echo esc_html($proj['title']); ?></h2>
                            <p class="portfolio-desc"><?php echo esc_html($proj['desc']); ?></p>
                            <div style="margin-top:0.75rem;">
                                <span style="background:var(--color-accent);color:var(--color-heading);font-size:0.8125rem;font-weight:700;font-family:var(--font-heading);padding:0.3rem 0.875rem;border-radius:9999px;">
                                    📈 <?php echo esc_html($proj['result']); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php nexagen_render_testimonials(3); ?>
    <?php nexagen_render_cta('Ready to Add Your Story?', 'Join 2,500+ businesses who\'ve transformed their online presence with Affordable Web Solution.'); ?>
</main>

<?php get_footer(); ?>
