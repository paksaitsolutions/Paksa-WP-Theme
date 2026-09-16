<?php
/**
 * Paksa IT Solutions — Single Product Detail Template
 *
 * Template: single-paksa_product.php
 * Handles individual product pages at /solutions/{product-slug}/
 *
 * Orchestrator only. All section markup lives in template-parts/product/.
 * Section visibility controlled by _paksa_prod_show_* post meta.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Ensure we are on a valid published product.
if ( ! have_posts() ) {
    get_footer();
    return;
}

the_post();

$prod_id = get_the_ID();

$show = array(
    'hero'       => true,  // Hero always shown on single product
    'overview'   => get_post_meta( $prod_id, '_paksa_prod_show_overview',   true ) !== '0',
    'features'   => get_post_meta( $prod_id, '_paksa_prod_show_features',   true ) !== '0',
    'modules'    => get_post_meta( $prod_id, '_paksa_prod_show_modules',    true ) !== '0',
    'benefits'   => get_post_meta( $prod_id, '_paksa_prod_show_benefits',   true ) !== '0',
    'industries' => get_post_meta( $prod_id, '_paksa_prod_show_industries', true ) !== '0',
    'faq'        => get_post_meta( $prod_id, '_paksa_prod_show_faq',        true ) !== '0',
    'cta'        => get_post_meta( $prod_id, '_paksa_prod_show_cta',        true ) !== '0',
);

/**
 * Filter: paksa_product_section_visibility
 *
 * @param array $show    Section visibility map.
 * @param int   $prod_id Product post ID.
 */
$show = apply_filters( 'paksa_product_section_visibility', $show, $prod_id );
?>
<main id="main-content" class="pk-single-product">

    <?php if ( $show['hero'] )       get_template_part( 'template-parts/product/hero' ); ?>
    <?php if ( $show['overview'] )   get_template_part( 'template-parts/product/overview' ); ?>
    <?php if ( $show['features'] )   get_template_part( 'template-parts/product/features' ); ?>
    <?php if ( $show['modules'] )    get_template_part( 'template-parts/product/modules' ); ?>
    <?php if ( $show['benefits'] )   get_template_part( 'template-parts/product/benefits' ); ?>
    <?php if ( $show['industries'] ) get_template_part( 'template-parts/product/industries' ); ?>
    <?php if ( $show['faq'] )        get_template_part( 'template-parts/product/faq' ); ?>
    <?php if ( $show['cta'] )        get_template_part( 'template-parts/product/cta' ); ?>

</main>
<?php
get_footer();
