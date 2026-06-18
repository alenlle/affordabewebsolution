<?php
/**
 * Template Name: Team
 */
get_header();
$team = [
    ['name' => 'Alex Morgan',     'role' => 'CEO & Founder',             'exp' => '18 yrs', 'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&h=500&fit=crop&auto=format', 'bio' => 'Alex founded Affordable Web Solution with a mission to build the WordPress agency he always wished existed. Visionary leader with 18 years in the industry.'],
    ['name' => 'Sarah Chen',      'role' => 'Creative Director',         'exp' => '14 yrs', 'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&h=500&fit=crop&auto=format', 'bio' => 'Award-winning designer with an extraordinary eye for beauty and usability. Sarah has shaped the visual identity of hundreds of brands.'],
    ['name' => 'Marcus Johnson',  'role' => 'Head of Development',       'exp' => '16 yrs', 'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=500&fit=crop&auto=format', 'bio' => 'Relentless focus on performance, security, and code quality. Marcus has architected complex WordPress solutions for Fortune 500 clients.'],
    ['name' => 'Priya Patel',     'role' => 'SEO & Marketing Director',  'exp' => '12 yrs', 'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&h=500&fit=crop&auto=format', 'bio' => 'Data-driven strategist who turns organic traffic into measurable revenue. Priya has helped clients achieve page-one rankings in hyper-competitive markets.'],
    ['name' => 'James Kim',       'role' => 'Senior WordPress Developer', 'exp' => '10 yrs', 'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=500&fit=crop&auto=format', 'bio' => 'Full-stack WordPress developer specializing in custom plugin development, WooCommerce, and complex API integrations.'],
    ['name' => 'Olivia Martinez', 'role' => 'UX Designer',               'exp' => '9 yrs',  'photo' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=500&fit=crop&auto=format', 'bio' => 'User experience expert who transforms complex user journeys into intuitive, conversion-optimized interfaces.'],
    ['name' => 'David Park',      'role' => 'WordPress Developer',        'exp' => '8 yrs',  'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=500&fit=crop&auto=format', 'bio' => 'Performance optimization specialist. David has a track record of turning slow, bloated WordPress sites into lightning-fast experiences.'],
    ['name' => 'Emma Thompson',   'role' => 'Project Manager',            'exp' => '7 yrs',  'photo' => 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=400&h=500&fit=crop&auto=format', 'bio' => 'The glue that keeps everything together. Emma ensures every project is delivered on time, on budget, and to the highest standard.'],
];
?>

<main>
    <div class="page-hero">
        <div class="container">
            <?php nexagen_render_breadcrumb(); ?>
            <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">The People</div>
            <h1>Meet the Affordable Web Solution Team</h1>
            <p>50+ WordPress specialists, designers, developers, and strategists — all in-house, all based in the US.</p>
        </div>
    </div>

    <?php while (have_posts()): the_post(); ?>
    <?php if (get_the_content()): ?>
    <section class="section--sm">
        <div class="container" style="max-width:800px;text-align:center;">
            <div class="entry-content"><?php the_content(); ?></div>
        </div>
    </section>
    <?php endif; endwhile; ?>

    <!-- Team Grid — FIXED: uses aws-team-grid (responsive 4→2→1 col) -->
    <section class="section">
        <div class="container">
            <div class="aws-team-grid">
                <?php foreach ($team as $member): ?>
                <div class="card aws-team-card">
                    <img src="<?php echo esc_url($member['photo']); ?>"
                         alt="<?php echo esc_attr($member['name']); ?>"
                         loading="lazy"
                         class="aws-team-avatar">
                    <h3 class="aws-team-name"><?php echo esc_html($member['name']); ?></h3>
                    <div class="aws-team-role"><?php echo esc_html($member['role']); ?></div>
                    <div class="badge badge-accent aws-team-badge"><?php echo esc_html($member['exp']); ?> WP experience</div>
                    <p class="aws-team-bio"><?php echo esc_html($member['bio']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Culture Section — FIXED: uses aws-culture-grid (responsive 2→1 col) -->
    <section class="section bg-card">
        <div class="container">
            <div class="aws-culture-grid">
                <!-- Text column -->
                <div class="aws-culture-text">
                    <div class="section-label">Life at Affordable Web Solution</div>
                    <h2>A Team That Loves What We Do</h2>
                    <p style="margin-bottom:1rem;">We're a remote-first company with a tight-knit culture. We work hard, support each other, and genuinely care about the work we produce and the clients we serve.</p>
                    <p style="margin-bottom:1.5rem;">If you're a WordPress specialist who shares our values, we'd love to hear from you.</p>
                    <a href="<?php echo home_url('/careers/'); ?>" class="btn btn-primary">View Open Positions</a>
                </div>
                <!-- Visual column -->
                <div class="aws-culture-visual">
                    <div class="aws-culture-img">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=360&fit=crop&auto=format"
                             alt="Affordable Web Solution team collaborating remotely"
                             loading="lazy">
                    </div>
                    <div class="aws-perks-grid">
                        <?php
                        $perks = [
                            ['🏠', 'Remote-First',    '100% remote, async-friendly culture'],
                            ['📚', 'Learning Budget', '$2,000/year for courses and conferences'],
                            ['💰', 'Competitive Pay', 'Top-of-market salaries + benefits'],
                            ['🌱', 'Career Growth',   'Clear advancement paths and mentorship'],
                        ];
                        foreach ($perks as $p): ?>
                        <div class="card aws-perk-card">
                            <div class="aws-perk-icon"><?php echo $p[0]; ?></div>
                            <div class="aws-perk-title"><?php echo esc_html($p[1]); ?></div>
                            <div class="aws-perk-desc"><?php echo esc_html($p[2]); ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php nexagen_render_cta('Work With Our Expert Team', 'Ready to start your project? Our team is here to help build something amazing for your business.'); ?>
</main>

<?php get_footer(); ?>
