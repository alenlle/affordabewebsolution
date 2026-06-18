<?php
/**
 * Template Name: Industry Single
 */
get_header();
global $post;
$icon       = get_post_meta($post->ID, '_nexagen_industry_icon', true) ?: '🏢';
$industries = nexagen_get_industries();
?>

<main>
    <div class="page-hero">
        <div class="container">
            <?php nexagen_render_breadcrumb(); ?>
            <div style="font-size:3rem;margin-bottom:1rem;" aria-hidden="true"><?php echo $icon; ?></div>
            <h1><?php the_title(); ?></h1>
            <p>Premium WordPress web design & development solutions built specifically for your industry.</p>
        </div>
    </div>

    <!-- Benefits Quick Bar -->
    <section style="background:var(--color-card);padding:1.5rem 0;border-bottom:1px solid var(--color-border);">
        <div class="container">
            <div style="display:flex;flex-wrap:wrap;gap:2rem;justify-content:center;">
                <?php
                $perks = ['✓ Industry-Specific Design', '✓ Compliance-Ready', '✓ Mobile-First', '✓ SEO Optimized', '✓ US-Based Team'];
                foreach ($perks as $p): ?>
                <span style="font-family:var(--font-heading);font-weight:600;font-size:0.875rem;color:var(--color-primary);"><?php echo esc_html($p); ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section style="padding:5rem 0;">
        <div class="container">
            <div class="aws-sidebar-layout aws-sidebar-layout--narrow">
                <div class="entry-content">
                    <?php while (have_posts()): the_post(); the_content(); endwhile; ?>
                </div>

                <aside class="aws-sidebar">
                    <?php
                    // Find image for current industry
                    $current_slug = get_post_field('post_name', $post->ID);
                    $ind_img = '';
                    foreach ($industries as $ind_item) {
                        if ($ind_item['slug'] === $current_slug && !empty($ind_item['img'])) {
                            $ind_img = $ind_item['img'];
                            break;
                        }
                    }
                    if ($ind_img): ?>
                    <div style="border-radius:var(--radius-xl);overflow:hidden;margin-bottom:1.5rem;height:180px;">
                        <img src="<?php echo esc_url($ind_img); ?>" alt="<?php echo esc_attr(get_the_title()); ?> web design" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block;">
                    </div>
                    <?php endif; ?>
                    <div class="card" style="padding:2rem;margin-bottom:1.5rem;border-top:4px solid var(--color-primary);">
                        <h3 style="font-size:1rem;margin-bottom:0.5rem;">Build Your <?php echo esc_html(get_the_title()); ?> Website</h3>
                        <p style="font-size:0.875rem;margin-bottom:1.5rem;">Get a custom quote for your industry website today.</p>
                        <a href="<?php echo home_url('/contact/'); ?>" class="btn btn-primary" style="width:100%;justify-content:center;">Get a Free Quote</a>
                    </div>

                    <div class="card" style="padding:1.5rem;">
                        <h4 style="font-size:0.9375rem;margin-bottom:1rem;">Other Industries</h4>
                        <ul style="list-style:none;display:flex;flex-direction:column;gap:0.375rem;">
                            <?php foreach (array_slice($industries, 0, 8) as $ind): ?>
                            <?php if ($ind['slug'] !== get_post_field('post_name', $post->ID)): ?>
                            <li>
                                <a href="<?php echo home_url('/industries/' . $ind['slug'] . '/'); ?>"
                                   style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;color:var(--color-body);padding:0.4rem 0.75rem;border-radius:var(--radius-md);transition:all 0.2s;"
                                   onmouseover="this.style.background='var(--color-card)';this.style.color='var(--color-primary)'"
                                   onmouseout="this.style.background='transparent';this.style.color='var(--color-body)'">
                                    <span><?php echo $ind['icon']; ?></span> <?php echo esc_html($ind['title']); ?>
                                </a>
                            </li>
                            <?php endif; endforeach; ?>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <?php nexagen_render_services_grid(6); ?>
    <?php nexagen_render_testimonials(3); ?>
    <?php nexagen_render_cta(); ?>
</main>

<?php get_footer(); ?>
