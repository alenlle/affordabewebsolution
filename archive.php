<?php get_header(); ?>

<main style="padding-top:5rem;">
    <div class="page-hero">
        <div class="container">
            <?php nexagen_render_breadcrumb(); ?>
            <h1>
                <?php
                if (is_category()) {
                    single_cat_title();
                } elseif (is_tag()) {
                    echo 'Posts tagged: '; single_tag_title();
                } elseif (is_date()) {
                    echo get_the_date('F Y');
                } elseif (is_author()) {
                    echo 'Posts by ' . get_the_author();
                } else {
                    post_type_archive_title();
                }
                ?>
            </h1>
        </div>
    </div>

    <section style="padding:4rem 0;">
        <div class="container">
            <?php if (have_posts()): ?>
            <div class="blog-grid">
                <?php while (have_posts()): the_post(); ?>
                <article <?php post_class('blog-card'); ?>>
                    <?php if (has_post_thumbnail()): ?>
                    <a href="<?php the_permalink(); ?>" class="blog-card-img" style="display:block;">
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
                    <a href="<?php the_permalink(); ?>" class="blog-card-img" style="display:block;">
                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
                    </a>
                    <?php endif; ?>
                    <div class="blog-card-body">
                        <?php $cats = get_the_category(); if ($cats): ?>
                        <div class="blog-cat"><?php echo esc_html($cats[0]->name); ?></div>
                        <?php endif; ?>
                        <h2 style="font-size:1.0625rem;margin-bottom:0.75rem;">
                            <a href="<?php the_permalink(); ?>" style="color:var(--color-heading);"><?php the_title(); ?></a>
                        </h2>
                        <p style="font-size:0.875rem;margin-bottom:1rem;"><?php echo wp_trim_words(get_the_excerpt(), 18, '…'); ?></p>
                        <div class="blog-meta"><?php echo get_the_date(); ?></div>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>
            <?php the_posts_pagination(['prev_text' => '← Previous', 'next_text' => 'Next →']); ?>
            <?php else: ?>
            <p style="text-align:center;padding:3rem 0;">No posts found in this archive.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
