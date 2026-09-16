<?php
/**
 * Paksa IT Solutions — Single Service Detail Template
 *
 * Template: single-paksa_service.php
 * URL: /services/{service-slug}/
 *
 * Orchestrator only. All section markup lives in template-parts/service/.
 * Section visibility controlled by _paksa_svc_show_* post meta.
 *
 * Relationship to page-services.php:
 *   page-services.php = master overview of all services (marketing landing page)
 *   single-paksa_service.php = individual service detail page
 *   Both coexist. No conflict.
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

$svc_id = get_the_ID();

$show = array(
    'hero'             => true,
    'overview'         => get_post_meta( $svc_id, '_paksa_svc_show_overview',         true ) !== '0',
    'features'         => get_post_meta( $svc_id, '_paksa_svc_show_features',         true ) !== '0',
    'faq'              => get_post_meta( $svc_id, '_paksa_svc_show_faq',              true ) !== '0',
    'related_products' => get_post_meta( $svc_id, '_paksa_svc_show_related_products', true ) !== '0',
    'cta'              => get_post_meta( $svc_id, '_paksa_svc_show_cta',              true ) !== '0',
);

/**
 * Filter: paksa_service_section_visibility
 *
 * @param array $show   Section visibility map.
 * @param int   $svc_id Service post ID.
 */
$show = apply_filters( 'paksa_service_section_visibility', $show, $svc_id );
?>
<main id="main-content" class="pk-single-service">

    <?php if ( $show['hero'] )             get_template_part( 'template-parts/service/hero' ); ?>
    <?php if ( $show['overview'] )         get_template_part( 'template-parts/service/overview' ); ?>
    <?php if ( $show['features'] )         get_template_part( 'template-parts/service/features' ); ?>
    <?php if ( $show['faq'] )              get_template_part( 'template-parts/service/faq' ); ?>
    <?php if ( $show['related_products'] ) get_template_part( 'template-parts/service/related-products' ); ?>
    <?php if ( $show['cta'] )              get_template_part( 'template-parts/service/cta' ); ?>

</main>
<?php
get_footer();
