<?php get_header(); ?>

<main id="blog-main" class="blog-main">
    <div class="container">
        <?php if (is_home() && !is_front_page()): ?>
        <div class="page-hero blog-page-hero">
            <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">Our Blog</div>
            <h1>Latest WordPress Insights</h1>
            <p>Tips, tutorials, and strategies from the Affordable Web Solution team.</p>
        </div>
        <?php endif; ?>

        <div class="blog-layout">
            <!-- Posts -->
            <div>
                <?php if (have_posts()): ?>
                <div class="blog-grid blog-index-grid">
                    <?php while (have_posts()): the_post(); ?>
                    <article <?php post_class('blog-card'); ?>>
                        <?php if (has_post_thumbnail()): ?>
                        <a href="<?php the_permalink(); ?>" class="blog-card-img" aria-hidden="true">
                            <?php the_post_thumbnail('aws-card'); ?>
                        </a>
                        <?php else:
                            $fallback_imgs = [
                                'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=400&fit=crop&auto=format',
                                'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=600&h=400&fit=crop&auto=format',
                                'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=600&h=400&fit=crop&auto=format',
                                'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&h=400&fit=crop&auto=format',
                            ];
                            $img_url = $fallback_imgs[get_the_ID() % count($fallback_imgs)];
                        ?>
                        <a href="<?php the_permalink(); ?>" class="blog-card-img" aria-hidden="true">
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
                        </a>
                        <?php endif; ?>

                        <div class="blog-card-body blog-card-body-flex">
                            <?php $cats = get_the_category(); if ($cats): ?>
                            <div class="blog-cat"><?php echo esc_html($cats[0]->name); ?></div>
                            <?php endif; ?>

                            <h2 class="blog-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <p class="blog-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '…'); ?></p>

                            <div class="blog-card-footer">
                                <div class="blog-meta"><?php echo get_the_date(); ?></div>
                                <a href="<?php the_permalink(); ?>" class="service-link blog-read-more">
                                    Read more
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="blog-pagination">
                    <?php the_posts_pagination([
                        'mid_size'  => 2,
                        'prev_text' => '← Previous',
                        'next_text' => 'Next →',
                    ]); ?>
                </div>

                <?php else: ?>
                <div class="blog-empty">
                    <div style="font-size:3rem;margin-bottom:1rem;">📝</div>
                    <h2>No posts yet</h2>
                    <p>Check back soon — we publish new WordPress insights regularly.</p>
                    <a href="<?php echo home_url('/'); ?>" class="btn btn-primary" style="margin-top:1rem;">Back to Home</a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <aside class="blog-sidebar-wrap">
                <div class="card blog-sidebar-card">
                    <h3 class="blog-sidebar-title">Ready to Start?</h3>
                    <p class="blog-sidebar-text">Let's build your perfect WordPress website.</p>
                    <a href="<?php echo home_url('/contact/'); ?>" class="btn btn-primary btn-sm" style="width:100%;justify-content:center;">Get a Free Quote</a>
                </div>
                <?php if (is_active_sidebar('blog-sidebar')): dynamic_sidebar('blog-sidebar'); endif; ?>
            </aside>
        </div>
    </div>
</main>

<?php get_footer(); ?>
