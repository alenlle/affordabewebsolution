<?php get_header(); ?>

<main style="padding-top:5rem;">
    <div class="page-hero">
        <div class="container">
            <h1>Search Results</h1>
            <p>
                <?php if (have_posts()): ?>
                Found <?php echo $wp_query->found_posts; ?> result<?php echo $wp_query->found_posts !== 1 ? 's' : ''; ?> for
                <?php else: ?>
                No results found for
                <?php endif; ?>
                "<strong><?php echo esc_html(get_search_query()); ?></strong>"
            </p>
        </div>
    </div>

    <div style="padding:4rem 0;">
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
                        ];
                        $img_url = $fallback_imgs[get_the_ID() % count($fallback_imgs)];
                    ?>
                    <a href="<?php the_permalink(); ?>" class="blog-card-img" style="display:block;">
                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
                    </a>
                    <?php endif; ?>
                    <div class="blog-card-body">
                        <div class="blog-cat"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></div>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p style="font-size:0.9rem;"><?php echo wp_trim_words(get_the_excerpt(), 18, '…'); ?></p>
                        <div class="blog-meta"><?php echo get_the_date(); ?></div>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>
            <?php the_posts_pagination(['prev_text' => '← Previous', 'next_text' => 'Next →']); ?>

            <?php else: ?>
            <div style="text-align:center;padding:4rem 2rem;">
                <div style="font-size:3rem;margin-bottom:1rem;">🔍</div>
                <h2>No results found</h2>
                <p style="margin-bottom:2rem;">Try a different search term, or browse our services and blog.</p>
                <?php get_search_form(); ?>
                <div style="margin-top:2rem;">
                    <a href="<?php echo home_url('/services/'); ?>" class="btn btn-primary" style="margin:0.5rem;">View Services</a>
                    <a href="<?php echo home_url('/blog/'); ?>" class="btn btn-outline" style="margin:0.5rem;">Read Our Blog</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
