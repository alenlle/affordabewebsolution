<?php
/**
 * Template Name: About Us
 */
get_header();

$team = [
    ['name' => 'Alex Morgan',    'role' => 'CEO & Founder',            'exp' => '18 yrs WP experience', 'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=200&h=200&fit=crop&auto=format', 'bio' => 'Alex founded Affordable Web Solution with a simple vision: build the WordPress agency he always wished existed. With 18 years in the industry, he leads strategy and client relationships.'],
    ['name' => 'Sarah Chen',     'role' => 'Lead Designer',            'exp' => '14 yrs WP experience', 'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&h=200&fit=crop&auto=format', 'bio' => 'Sarah heads our design team and has an extraordinary eye for beauty and usability. Her work has won multiple industry awards.'],
    ['name' => 'Marcus Johnson', 'role' => 'Head of Development',      'exp' => '16 yrs WP experience', 'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop&auto=format', 'bio' => 'Marcus leads our dev team with a relentless focus on performance, security, and code quality. Every site he touches is a masterpiece under the hood.'],
    ['name' => 'Priya Patel',    'role' => 'SEO & Marketing Director', 'exp' => '12 yrs WP experience', 'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200&h=200&fit=crop&auto=format', 'bio' => 'Priya drives measurable results for our clients through data-driven SEO strategies and performance marketing programs.'],
];
?>

<main>
    <div class="page-hero">
        <div class="container">
            <?php nexagen_render_breadcrumb(); ?>
            <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">Who We Are</div>
            <h1>The WordPress Agency You've Been Looking For</h1>
            <p>US-based, in-house, specialist. 15+ years, 2,500+ projects, 370+ five-star reviews.</p>
        </div>
    </div>

    <!-- Mission Section -->
    <section class="section">
        <div class="container">
            <!-- FIXED: replaced inline grid with responsive class -->
            <div class="aws-about-mission">
                <div class="aws-about-mission__text">
                    <div class="section-label">Our Mission</div>
                    <h2>Built by WordPress Experts, for Business Owners Who Deserve the Best</h2>
                    <p style="margin-bottom:1rem;">We started Affordable Web Solution because we saw a gap in the market: businesses needed a WordPress partner they could truly trust — one that combined technical excellence with beautiful design, transparent communication, and genuine care for client success.</p>
                    <p style="margin-bottom:1.5rem;">That mission drives everything we do. Every website we build. Every client conversation we have. Every line of code we write.</p>
                    <a href="<?php echo home_url('/contact/'); ?>" class="btn btn-primary">Start Your Project</a>
                </div>
                <div class="aws-about-mission__visual">
                    <div class="aws-about-mission__img">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=700&h=480&fit=crop&auto=format&q=80" alt="Affordable Web Solution team at work" loading="lazy">
                    </div>
                    <div class="aws-about-stats-box">
                        <?php
                        $nums = [
                            ['15+', 'Years in Business'],
                            ['2,500+', 'Projects Completed'],
                            ['370+', '5-Star Reviews'],
                            ['50+', 'In-House Experts'],
                            ['100%', 'US-Based Team'],
                            ['50', 'States Served'],
                        ];
                        ?>
                        <div class="aws-about-stats-grid">
                            <?php foreach ($nums as $n): ?>
                            <div class="aws-about-stat">
                                <div class="aws-about-stat__num"><?php echo esc_html($n[0]); ?></div>
                                <div class="aws-about-stat__label"><?php echo esc_html($n[1]); ?></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="section bg-card">
        <div class="container">
            <div class="section-header">
                <div class="section-label">What We Stand For</div>
                <h2>Our Core Values</h2>
                <p>These principles guide every decision we make and every project we take on.</p>
            </div>
            <?php
            $values = [
                ['icon' => '🎯', 'title' => 'Excellence',   'desc' => 'We don\'t settle for good enough. Every website is built to the highest standards of design, development, and performance.'],
                ['icon' => '🤝', 'title' => 'Partnership',  'desc' => 'We see ourselves as an extension of your team. Your success is our success — we\'re fully invested in your outcomes.'],
                ['icon' => '💬', 'title' => 'Transparency', 'desc' => 'No hidden fees, no vague timelines, no surprises. Clear, honest communication at every stage.'],
                ['icon' => '🔬', 'title' => 'Innovation',   'desc' => 'We stay at the cutting edge of WordPress, always adopting best practices and new technologies to deliver better results.'],
                ['icon' => '⏰', 'title' => 'Reliability',  'desc' => 'When we make a commitment, we keep it. Our on-time delivery rate exceeds 95%.'],
                ['icon' => '❤️', 'title' => 'Passion',      'desc' => 'We genuinely love what we do. That passion shows up in the quality and care we bring to every single project.'],
            ];
            ?>
            <div class="services-grid" style="margin-top:3rem;">
                <?php foreach ($values as $v): ?>
                <div class="card card--green" style="padding:2rem;">
                    <div class="service-icon"><?php echo $v['icon']; ?></div>
                    <h3><?php echo esc_html($v['title']); ?></h3>
                    <p style="margin:0;"><?php echo esc_html($v['desc']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Page Content (WP editor content) -->
    <?php while (have_posts()): the_post(); ?>
    <?php if (get_the_content()): ?>
    <section class="section">
        <div class="container" style="max-width:800px;">
            <div class="entry-content"><?php the_content(); ?></div>
        </div>
    </section>
    <?php endif; endwhile; ?>

    <!-- Team Preview -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <div class="section-label">Our Team</div>
                <h2>Meet the People Behind the Work</h2>
                <p>50+ WordPress specialists, designers, developers, and strategists — all in-house, all based in the US.</p>
            </div>
            <!-- FIXED: uses .services-grid which is already responsive -->
            <div class="services-grid" style="margin-top:3rem;">
                <?php foreach ($team as $member): ?>
                <div class="card" style="padding:2rem;text-align:center;">
                    <img src="<?php echo esc_url($member['photo']); ?>" alt="<?php echo esc_attr($member['name']); ?>" loading="lazy" style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin:0 auto 1.25rem;display:block;border:3px solid var(--color-accent);">
                    <h3 style="font-size:1.125rem;margin-bottom:0.25rem;"><?php echo esc_html($member['name']); ?></h3>
                    <div style="color:var(--color-primary);font-weight:600;font-size:0.875rem;margin-bottom:0.5rem;"><?php echo esc_html($member['role']); ?></div>
                    <div class="badge badge-accent" style="margin-bottom:1rem;"><?php echo esc_html($member['exp']); ?></div>
                    <p style="font-size:0.875rem;margin:0;"><?php echo esc_html($member['bio']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <div style="text-align:center;margin-top:2rem;">
                <a href="<?php echo home_url('/team/'); ?>" class="btn btn-outline">Meet the Full Team</a>
            </div>
        </div>
    </section>

    <?php nexagen_render_testimonials(3); ?>
    <?php nexagen_render_cta('Ready to Work With the Best?', 'Join 2,500+ businesses across the US that trust Affordable Web Solution for their WordPress websites.'); ?>
</main>

<?php get_footer(); ?>
