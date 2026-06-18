<?php get_header(); ?>

<main>
<?php while (have_posts()): the_post(); ?>

    <div class="page-hero">
        <div class="container">
            <?php nexagen_render_breadcrumb(); ?>
            <?php
            $cats = get_the_category();
            if ($cats): ?>
            <div class="badge" style="justify-content:center;margin-bottom:1rem;background:rgba(255,255,255,0.15);color:#ffffff;border:1px solid rgba(255,255,255,0.35);backdrop-filter:blur(4px);"><?php echo esc_html($cats[0]->name); ?></div>
            <?php endif; ?>
            <h1 style="max-width:800px;margin:0 auto 1rem;"><?php the_title(); ?></h1>
            <p style="opacity:0.75;">
                By <?php the_author(); ?> &bull; <?php echo get_the_date(); ?> &bull;
                <?php
                $wc = str_word_count(strip_tags(get_the_content()));
                echo ceil($wc / 200) . ' min read';
                ?>
            </p>
        </div>
    </div>

    <div style="padding:4rem 0;">
        <div class="container">
            <div class="single-post-layout">
                <!-- Post Content -->
                <article>
                    <?php if (has_post_thumbnail()): ?>
                    <div style="margin-bottom:2.5rem;border-radius:var(--radius-xl);overflow:hidden;">
                        <?php the_post_thumbnail('aws-hero'); ?>
                    </div>
                    <?php else:
                        $fallback_hero_imgs = [
                            'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=1400&h=600&fit=crop&auto=format&q=75',
                            'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1400&h=600&fit=crop&auto=format&q=75',
                            'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=1400&h=600&fit=crop&auto=format&q=75',
                            'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1400&h=600&fit=crop&auto=format&q=75',
                        ];
                        $hero_img = $fallback_hero_imgs[get_the_ID() % count($fallback_hero_imgs)];
                    ?>
                    <div style="margin-bottom:2.5rem;border-radius:var(--radius-xl);overflow:hidden;height:420px;">
                        <img src="<?php echo esc_url($hero_img); ?>" alt="<?php the_title_attribute(); ?>" loading="eager" style="width:100%;height:100%;object-fit:cover;display:block;">
                    </div>
                    <?php endif; ?>

                    <div class="entry-content" style="max-width:none;">
                        <?php the_content(); ?>
                    </div>

                    <!-- Tags -->
                    <?php $tags = get_the_tags(); if ($tags): ?>
                    <div style="margin-top:3rem;padding-top:2rem;border-top:1px solid var(--color-border);">
                        <span style="font-size:0.875rem;font-weight:600;color:var(--color-heading);margin-right:0.75rem;">Tags:</span>
                        <?php foreach ($tags as $tag): ?>
                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                           class="badge badge-primary"
                           style="margin-right:0.375rem;margin-bottom:0.375rem;text-decoration:none;">
                            <?php echo esc_html($tag->name); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Author Bio -->
                    <div class="author-bio">
                        <div style="width:64px;height:64px;border-radius:50%;background:var(--color-primary);display:flex;align-items:center;justify-content:center;color:var(--color-accent);font-weight:800;font-size:1.5rem;flex-shrink:0;">
                            <?php echo esc_html(substr(get_the_author(), 0, 1)); ?>
                        </div>
                        <div>
                            <div style="font-family:var(--font-heading);font-weight:700;margin-bottom:0.375rem;"><?php the_author(); ?></div>
                            <p style="font-size:0.9rem;margin:0;"><?php echo esc_html(get_the_author_meta('description')); ?></p>
                        </div>
                    </div>

                    <!-- Post Navigation -->
                    <div class="post-nav">
                        <?php
                        $prev = get_previous_post();
                        $next = get_next_post();
                        if ($prev): ?>
                        <a href="<?php echo esc_url(get_permalink($prev)); ?>" class="btn btn-outline btn-sm" style="flex:1;justify-content:center;">
                            ← <?php echo esc_html(wp_trim_words(get_the_title($prev), 5)); ?>
                        </a>
                        <?php endif;
                        if ($next): ?>
                        <a href="<?php echo esc_url(get_permalink($next)); ?>" class="btn btn-outline btn-sm" style="flex:1;justify-content:center;">
                            <?php echo esc_html(wp_trim_words(get_the_title($next), 5)); ?> →
                        </a>
                        <?php endif; ?>
                    </div>
                </article>

                <!-- Sidebar -->
                <aside class="single-post-sidebar">
                    <div class="card" style="padding:1.5rem;margin-bottom:1.5rem;">
                        <h3 style="font-size:1rem;margin-bottom:1rem;">Ready to Start Your WordPress Project?</h3>
                        <p style="font-size:0.875rem;margin-bottom:1rem;">Join 2,500+ businesses that trust Affordable Web Solution.</p>
                        <a href="<?php echo home_url('/contact/'); ?>" class="btn btn-primary btn-sm" style="width:100%;justify-content:center;">Get a Free Quote</a>
                    </div>

                    <?php if (is_active_sidebar('blog-sidebar')): dynamic_sidebar('blog-sidebar'); endif; ?>
                </aside>
            </div>
        </div>
    </div>

<?php endwhile; ?>
</main>

<?php nexagen_render_cta(); ?>
<?php get_footer(); ?>
