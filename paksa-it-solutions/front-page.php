<?php
/**
 * Paksa IT Solutions — Front Page
 *
 * Renders the static front page set in Settings → Reading.
 * Content is edited via the block editor (Pages → Home → Edit).
 * Global settings (contact, social, WhatsApp) remain in Appearance → Customize.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<main id="main-content" class="pk-front-page">
    <?php if ( paksa_get_option( 'paksa_home_show_hero', '1' ) !== '0' ) get_template_part( 'template-parts/home/hero' ); ?>
    <?php if ( paksa_get_option( 'paksa_home_show_trust_strip', '1' ) !== '0' ) get_template_part( 'template-parts/home/trust-strip' ); ?>
    <?php if ( paksa_get_option( 'paksa_home_show_challenge', '1' ) !== '0' ) get_template_part( 'template-parts/home/challenge' ); ?>
    <?php if ( paksa_get_option( 'paksa_home_show_capabilities', '1' ) !== '0' ) get_template_part( 'template-parts/home/capabilities' ); ?>
    <?php if ( paksa_get_option( 'paksa_home_show_technology', '1' ) !== '0' ) get_template_part( 'template-parts/home/technology' ); ?>
    <?php if ( paksa_get_option( 'paksa_home_show_products', '1' ) !== '0' ) get_template_part( 'template-parts/home/products' ); ?>
    <?php if ( paksa_get_option( 'paksa_home_show_intelligence', '1' ) !== '0' ) get_template_part( 'template-parts/home/intelligence' ); ?>
    <?php if ( paksa_get_option( 'paksa_home_show_process', '1' ) !== '0' ) get_template_part( 'template-parts/home/process' ); ?>
    <?php if ( paksa_get_option( 'paksa_home_show_why_paksa', '1' ) !== '0' ) get_template_part( 'template-parts/home/why-paksa' ); ?>
    <?php if ( paksa_get_option( 'paksa_home_show_differentiation', '1' ) !== '0' ) get_template_part( 'template-parts/home/differentiation' ); ?>
    <?php if ( paksa_get_option( 'paksa_home_show_industries', '1' ) !== '0' ) get_template_part( 'template-parts/home/industries' ); ?>
    <?php if ( paksa_get_option( 'paksa_home_show_case_studies', '1' ) !== '0' ) get_template_part( 'template-parts/home/case-studies' ); ?>
    <?php if ( paksa_get_option( 'paksa_home_show_outcomes', '1' ) !== '0' ) get_template_part( 'template-parts/home/outcomes' ); ?>
    <?php if ( paksa_get_option( 'paksa_home_show_faq', '1' ) !== '0' ) get_template_part( 'template-parts/home/faq' ); ?>
    <?php if ( paksa_get_option( 'paksa_home_show_final_cta', '1' ) !== '0' ) get_template_part( 'template-parts/home/final-cta' ); ?>
</main>
<?php
get_footer();
