<?php
/**
 * Template Name: Home Page
 */
get_header();
?>
<main id="homepage-main">
    <?php nexagen_render_hero(); ?>
    <?php nexagen_render_trust_bar(); ?>
    <?php nexagen_render_services_grid(6); ?>
    <?php nexagen_render_stats_row(); ?>
    <?php nexagen_render_why_us(); ?>
    <?php nexagen_render_process(); ?>
    <?php nexagen_render_testimonials(3); ?>
    <?php nexagen_render_portfolio(4); ?>
    <?php nexagen_render_pricing(); ?>
    <?php nexagen_render_faq(); ?>
    <?php nexagen_render_blog_preview(3); ?>
    <?php nexagen_render_cta(); ?>
</main>
<?php get_footer(); ?>
