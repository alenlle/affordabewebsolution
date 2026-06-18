<?php
/**
 * Template Name: Testimonials
 */
get_header();
$all_testimonials = [
    ['name' => 'Sarah Johnson',   'company' => 'TechVentures Inc.',     'industry' => 'SaaS',        'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'Affordable Web Solution delivered a stunning WordPress website that exceeded all our expectations. Their team is responsive, professional, and truly expert at what they do. Our site traffic increased 180% within 3 months of launch.',    'rating' => 5],
    ['name' => 'Michael Torres',  'company' => 'Coastal Law Group',     'industry' => 'Legal',       'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'We\'ve worked with several web agencies over the years, but Affordable Web Solution is by far the best. They understood our law firm\'s needs perfectly and delivered a site that projects exactly the right level of trust and professionalism.',   'rating' => 5],
    ['name' => 'Dr. Emily Chen',  'company' => 'Northside Medical Ctr', 'industry' => 'Healthcare',  'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'As a healthcare provider, our website needs to be both compliant and patient-friendly. Affordable Web Solution nailed both. The new site has significantly improved our patient acquisition.',  'rating' => 5],
    ['name' => 'David Kim',       'company' => 'Apex Construction',     'industry' => 'Construction', 'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'The project was delivered on time, on budget, and the quality was exceptional. Affordable Web Solution\'s team communicated clearly throughout the entire process.', 'rating' => 5],
    ['name' => 'Rachel Foster',   'company' => 'Bloom Boutique',        'industry' => 'eCommerce',   'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'Our WooCommerce store has never performed better. Sales are up 240% since the redesign, and our customers constantly compliment how easy the shopping experience is.',    'rating' => 5],
    ['name' => 'James Mitchell',  'company' => 'GreenPath Non-Profit',  'industry' => 'Non-Profit',  'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'Working with Affordable Web Solution was a fantastic experience. They took the time to truly understand our mission and built a website that inspires donors and volunteers alike.',   'rating' => 5],
    ['name' => 'Samantha Colby',  'company' => 'HRchitect',             'industry' => 'HR Tech',     'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'Their team is highly responsive, thorough, and consultative in guiding us through a website technical optimization. Results were impressive and immediate.',           'rating' => 5],
    ['name' => 'Eric Vazquez',    'company' => 'Premise',               'industry' => 'Corporate',   'avatar' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'None compare to the level of expertise and professionalism that the Affordable Web Solution team brings to the table. They\'ve become our permanent WordPress partner.',              'rating' => 5],
    ['name' => 'Wendy Maddalone', 'company' => 'Azelis AES',            'industry' => 'Industrial',  'avatar' => 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'Everyone was quick to respond to emails and explained everything clearly. Communication was easy and the final product was exactly what we envisioned.',              'rating' => 5],
    ['name' => 'Carl Garcia',     'company' => 'Akumen Inc.',           'industry' => 'Consulting',  'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'Everything that I asked for was delivered by the Affordable Web Solution team of WordPress experts. I\'m very pleased and recommend Affordable Web Solution based on my own experience.',            'rating' => 5],
    ['name' => 'Andrea Money',    'company' => 'Leadership PW',         'industry' => 'Non-Profit',  'avatar' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'The Affordable Web Solution team is always really responsive. They set me up for success. I love that our website was designed so that it\'s easy for me to update.',               'rating' => 5],
    ['name' => 'Annie Yager',     'company' => 'Annie Yager Marketing', 'industry' => 'Marketing',   'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=80&h=80&fit=crop&auto=format&q=80', 'text' => 'Affordable Web Solution was referred to me by a friend. Since day one their service has been absolutely impeccable. I couldn\'t be happier with both the process and the result.',    'rating' => 5],
];
?>

<main>
    <div class="page-hero">
        <div class="container">
            <?php nexagen_render_breadcrumb(); ?>
            <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">Client Reviews</div>
            <h1>370+ Five-Star Reviews</h1>
            <p>Real words from real clients across the United States. We let our work — and our clients — speak for us.</p>
        </div>
    </div>

    <?php nexagen_render_stats_row(); ?>

    <!-- Visual trust image -->
    <div style="width:100%;overflow:hidden;max-height:280px;position:relative;">
        <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1400&h=280&fit=crop&auto=format&q=75" alt="Happy clients and team celebrating project success" loading="lazy" style="width:100%;height:280px;object-fit:cover;display:block;filter:brightness(0.5);">
        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;flex-direction:column;text-align:center;color:#fff;padding:2rem;">
            <div style="font-family:var(--font-heading);font-weight:900;font-size:1.875rem;margin-bottom:0.5rem;">Don't Take Our Word for It</div>
            <p style="opacity:0.85;font-size:1rem;max-width:500px;">370+ verified five-star reviews from real businesses across the United States.</p>
        </div>
    </div>

    <section class="section">
        <div class="container">
            <div class="testimonials-grid">
                <?php foreach ($all_testimonials as $t): ?>
                <article class="testimonial-card">
                    <div class="testimonial-stars" aria-label="5 star rating">
                        <?php for ($i = 0; $i < 5; $i++): ?><span class="star">★</span><?php endfor; ?>
                    </div>
                    <span class="badge badge-primary" style="margin-bottom:1rem;font-size:0.75rem;"><?php echo esc_html($t['industry']); ?></span>
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
        </div>
    </section>

    <?php nexagen_render_cta('Ready to Become Our Next Success Story?', 'Join 2,500+ businesses that trust Affordable Web Solution for their WordPress websites.'); ?>
</main>

<?php get_footer(); ?>
