<?php
/**
 * Paksa IT Solutions — Services Page Template
 *
 * Template Name: Services / IT Solutions
 *
 * Orchestrator only. All section markup lives in template-parts/services/.
 * Content is driven by page post meta (editable per-page) and apply_filters() hooks.
 * No hardcoded business copy. No plugin dependencies.
 *
 * Content architecture:
 *   - Page-level text  → post meta (get_post_meta( get_the_ID(), '_paksa_svc_*', true ))
 *   - Structured arrays → apply_filters( 'paksa_svc_*', $defaults )
 *   - Global settings  → get_theme_mod() via paksa_get_option()
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<main id="main-content" class="pk-services-page">

    <?php
    // Visibility flags — stored as post meta, default true.
    // Admin can set _paksa_svc_show_* to '0' to hide any section.
    $page_id = get_the_ID();

    $show = array(
        'hero'         => get_post_meta( $page_id, '_paksa_svc_show_hero',         true ) !== '0',
        'overview'     => get_post_meta( $page_id, '_paksa_svc_show_overview',     true ) !== '0',
        'portfolio'    => get_post_meta( $page_id, '_paksa_svc_show_portfolio',    true ) !== '0',
        'capabilities' => get_post_meta( $page_id, '_paksa_svc_show_capabilities', true ) !== '0',
        'process'      => get_post_meta( $page_id, '_paksa_svc_show_process',      true ) !== '0',
        'industries'   => get_post_meta( $page_id, '_paksa_svc_show_industries',   true ) !== '0',
        'technology'   => get_post_meta( $page_id, '_paksa_svc_show_technology',   true ) !== '0',
        'faq'          => get_post_meta( $page_id, '_paksa_svc_show_faq',          true ) !== '0',
        'cta'          => get_post_meta( $page_id, '_paksa_svc_show_cta',          true ) !== '0',
    );

    /**
     * Filter: paksa_services_section_visibility
     * Allows programmatic control of section visibility.
     *
     * @param array $show    Associative array of section => bool.
     * @param int   $page_id Current page ID.
     */
    $show = apply_filters( 'paksa_services_section_visibility', $show, $page_id );

    if ( $show['hero'] )         get_template_part( 'template-parts/services/hero' );
    if ( $show['overview'] )     get_template_part( 'template-parts/services/overview' );
    if ( $show['portfolio'] )    get_template_part( 'template-parts/services/portfolio' );
    if ( $show['capabilities'] ) get_template_part( 'template-parts/services/capabilities' );
    if ( $show['process'] )      get_template_part( 'template-parts/services/process' );
    if ( $show['industries'] )   get_template_part( 'template-parts/services/industries' );
    if ( $show['technology'] )   get_template_part( 'template-parts/services/technology' );
    if ( $show['faq'] )          get_template_part( 'template-parts/services/faq' );
    if ( $show['cta'] )          get_template_part( 'template-parts/services/cta' );
    ?>

</main>
<?php
get_footer();
