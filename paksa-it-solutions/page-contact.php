<?php
/**
 * Paksa IT Solutions — Contact Page Template
 *
 * Template Name: Contact Us
 *
 * Content is edited via the block editor (Pages → Contact → Edit).
 * The contact form is rendered via do_action('paksa_contact_form') —
 * add a shortcode block [paksa_contact_form] or use the hook directly.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<main id="main-content" class="pk-contact-page">
    <?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>
    <div class="pk-page-content">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
    <?php
    // Contact form rendered below page content.
    // Hooked in inc/contact-form.php via add_action('paksa_contact_form', ...).
    do_action( 'paksa_contact_form' );
    ?>
</main>
<?php
get_footer();
