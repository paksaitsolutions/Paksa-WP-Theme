<?php
/**
 * Paksa IT Solutions — Contact Page Template
 *
 * Template Name: Contact Us
 *
 * Orchestrator only. All section markup lives in template-parts/contact/.
 *
 * Content model:
 *   Hero heading/description → post meta (_paksa_page_*)
 *   Contact intro, hours     → post meta (_paksa_page_*)
 *   Phone, email, address    → Customizer (Global Site Settings > Contact Information)
 *   WhatsApp URL             → Customizer (Global Site Settings > Contact Information)
 *   Form area                → do_action('paksa_contact_form') hook
 *                              If nothing hooked, shows email fallback.
 *   CTA                      → post meta override → Customizer fallback
 *
 * Form processing:
 *   No form backend is implemented in this phase.
 *   To add a form: hook into 'paksa_contact_form' action.
 *   Example: add_action( 'paksa_contact_form', function() { echo do_shortcode('[contact-form-7 id="1"]'); } );
 *
 * Section visibility:
 *   _paksa_page_show_faq = '0' to hide FAQ section
 *   _paksa_page_show_cta = '0' to hide CTA section
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

if ( ! have_posts() ) {
    get_footer();
    return;
}

the_post();

$page_id = get_the_ID();

$show = array(
    'faq' => get_post_meta( $page_id, '_paksa_page_show_faq', true ) !== '0',
    'cta' => get_post_meta( $page_id, '_paksa_page_show_cta', true ) !== '0',
);
?>
<main id="main-content" class="pk-contact-page">

    <?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>
    <?php get_template_part( 'template-parts/contact/hero' ); ?>
    <?php get_template_part( 'template-parts/contact/info' ); ?>
    <?php if ( $show['cta'] ) get_template_part( 'template-parts/contact/cta' ); ?>

</main>
<?php
get_footer();
