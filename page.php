<?php get_header(); ?>

<main>
    <div class="page-hero">
        <div class="container">
            <?php nexagen_render_breadcrumb(); ?>
            <h1><?php the_title(); ?></h1>
        </div>
    </div>

    <article style="padding:4rem 0;">
        <div class="container" style="max-width:860px;">
            <?php
            while (have_posts()) {
                the_post();
                the_content();
            }
            ?>
        </div>
    </article>

    <?php nexagen_render_cta(); ?>
</main>

<?php get_footer(); ?>
