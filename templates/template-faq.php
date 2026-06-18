<?php
/**
 * Template Name: FAQ
 */
get_header();
?>

<main>
    <div class="page-hero">
        <div class="container">
            <?php nexagen_render_breadcrumb(); ?>
            <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">FAQs</div>
            <h1>Frequently Asked Questions</h1>
            <p>Everything you need to know about working with Affordable Web Solution. Can't find your answer? <a href="<?php echo home_url('/contact/'); ?>" style="color:var(--color-accent);">Ask us directly.</a></p>
        </div>
    </div>

    <?php while (have_posts()): the_post(); ?>
    <?php if (get_the_content()): ?>
    <section class="section--sm">
        <div class="container" style="max-width:800px;">
            <div class="entry-content"><?php the_content(); ?></div>
        </div>
    </section>
    <?php endif; endwhile; ?>

    <!-- FAQ visual banner -->
    <div style="position:relative;overflow:hidden;max-height:220px;margin-bottom:-1px;">
        <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=1400&h=220&fit=crop&auto=format&q=70" alt="Affordable Web Solution support team ready to help" loading="lazy" style="width:100%;height:220px;object-fit:cover;display:block;filter:brightness(0.45);">
        <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;color:#fff;padding:2rem;">
            <div style="font-family:var(--font-heading);font-weight:900;font-size:1.75rem;margin-bottom:0.375rem;">Got Questions? We've Got Answers.</div>
            <p style="opacity:0.85;font-size:0.9375rem;max-width:460px;">Our team is ready to help. Browse our FAQs or contact us directly.</p>
        </div>
    </div>

    <?php nexagen_render_faq(); ?>

    <?php nexagen_render_cta('Still Have Questions?', 'Our team is always happy to answer any question you have. Reach out and we\'ll get back to you within 24 hours.'); ?>
</main>

<?php get_footer(); ?>
