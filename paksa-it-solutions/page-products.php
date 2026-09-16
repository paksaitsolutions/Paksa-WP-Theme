<?php
/**
 * Paksa IT Solutions — Products / Solutions Listing Page Template
 *
 * Template Name: Products / Solutions
 *
 * Orchestrator only. All section markup lives in template-parts/products/.
 * Queries the paksa_product CPT for the product grid.
 *
 * Content architecture:
 *   - Page-level hero/CTA text → post meta (_paksa_prod_listing_*)
 *   - Product grid             → WP_Query on paksa_product CPT
 *   - Structured arrays        → apply_filters( 'paksa_prod_*', $defaults )
 *   - Global settings          → paksa_get_option()
 *
 * Section visibility:
 *   Each section is shown by default.
 *   Set post meta _paksa_prod_listing_show_{section} = '0' to hide.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$page_id = get_the_ID();

$show = array(
    'hero'       => get_post_meta( $page_id, '_paksa_prod_listing_show_hero',       true ) !== '0',
    'grid'       => get_post_meta( $page_id, '_paksa_prod_listing_show_grid',       true ) !== '0',
    'industries' => get_post_meta( $page_id, '_paksa_prod_listing_show_industries', true ) !== '0',
    'faq'        => get_post_meta( $page_id, '_paksa_prod_listing_show_faq',        true ) !== '0',
    'cta'        => get_post_meta( $page_id, '_paksa_prod_listing_show_cta',        true ) !== '0',
);

/**
 * Filter: paksa_products_listing_section_visibility
 *
 * @param array $show    Section visibility map.
 * @param int   $page_id Current page ID.
 */
$show = apply_filters( 'paksa_products_listing_section_visibility', $show, $page_id );
?>
<main id="main-content" class="pk-products-page">

    <?php if ( $show['hero'] )       get_template_part( 'template-parts/products/hero' ); ?>
    <?php if ( $show['grid'] )       get_template_part( 'template-parts/products/grid' ); ?>
    <?php if ( $show['industries'] ) get_template_part( 'template-parts/products/industries' ); ?>
    <?php if ( $show['faq'] )        get_template_part( 'template-parts/products/faq' ); ?>
    <?php if ( $show['cta'] )        get_template_part( 'template-parts/products/cta' ); ?>

</main>
<?php
get_footer();
