<?php get_header(); ?>

<main>
    <div class="page-hero">
        <div class="container">
            <h1>404 — Page Not Found</h1>
            <p>Oops! The page you're looking for doesn't exist or has been moved.</p>
        </div>
    </div>

    <div style="padding:5rem 0;text-align:center;">
        <div class="container" style="max-width:600px;">
            <div style="margin-bottom:2rem;border-radius:var(--radius-2xl);overflow:hidden;height:220px;">
                <img src="https://images.unsplash.com/photo-1578328819058-b69f3a3b0f6b?w=800&h=440&fit=crop&auto=format&q=75" alt="Page not found" loading="eager" style="width:100%;height:100%;object-fit:cover;display:block;filter:hue-rotate(80deg) saturate(0.6) brightness(0.9);">
            </div>
            <h2 style="margin-bottom:1rem;">Lost in the Digital Wilderness?</h2>
            <p style="margin-bottom:2rem;">Don't worry — even the best WordPress developers occasionally take a wrong turn. Let's get you back on track.</p>
            <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                <a href="<?php echo home_url('/'); ?>" class="btn btn-primary">Go to Homepage</a>
                <a href="<?php echo home_url('/contact/'); ?>" class="btn btn-outline">Contact Us</a>
            </div>

            <div style="margin-top:3rem;">
                <p style="font-weight:600;margin-bottom:1rem;color:var(--color-heading);">Or try searching:</p>
                <?php get_search_form(); ?>
            </div>

            <div style="margin-top:3rem;display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;">
                <?php
                $quick = [
                    ['Services', '/services/'],
                    ['Portfolio', '/portfolio/'],
                    ['Blog', '/blog/'],
                    ['About', '/about/'],
                    ['Pricing', '/pricing/'],
                    ['Contact', '/contact/'],
                ];
                foreach ($quick as $l): ?>
                <a href="<?php echo home_url($l[1]); ?>" class="card" style="padding:1rem;text-align:center;text-decoration:none;font-weight:600;font-family:var(--font-heading);font-size:0.9rem;color:var(--color-heading);">
                    <?php echo esc_html($l[0]); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
