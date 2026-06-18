<?php
/**
 * Template Name: Contact
 */
get_header();
?>

<main>
    <div class="page-hero">
        <div class="container">
            <?php nexagen_render_breadcrumb(); ?>
            <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.6);">Let's Talk</div>
            <h1>Start Your WordPress Project Today</h1>
            <p>Fill out the form and a WordPress expert will be in touch within 24 hours. No pressure — just a conversation.</p>
        </div>
    </div>

    <?php nexagen_render_contact_form(); ?>
    <?php nexagen_render_faq(); ?>
</main>

<?php get_footer(); ?>
