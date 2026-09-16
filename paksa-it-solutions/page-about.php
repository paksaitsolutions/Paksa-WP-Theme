<?php
/**
 * Paksa IT Solutions — About Page Template
 *
 * Template Name: About Us
 *
 * Orchestrator only. All section markup lives in template-parts/about/.
 *
 * Content model:
 *   Hero, story heading/content → post meta (_paksa_page_*)
 *   Long-form narrative         → block editor (the_content) — fallback for story
 *   Mission, vision, values     → post meta (_paksa_page_*)
 *   CTA                         → post meta override → Customizer fallback
 *   Global contact/social       → Customizer (Global Site Settings)
 *
 * Section visibility:
 *   _paksa_page_show_story  = '0' to hide story section
 *   _paksa_page_show_values = '0' to hide values section
 *   _paksa_page_show_cta    = '0' to hide CTA section
 *   Mission/vision hidden automatically if both fields are empty.
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
    'story'  => get_post_meta( $page_id, '_paksa_page_show_story',  true ) !== '0',
    'values' => get_post_meta( $page_id, '_paksa_page_show_values', true ) !== '0',
    'cta'    => get_post_meta( $page_id, '_paksa_page_show_cta',    true ) !== '0',
);
?>
<main id="main-content" class="pk-about-page">

    <?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>
    <?php get_template_part( 'template-parts/about/hero' ); ?>
    <?php if ( $show['story'] )  get_template_part( 'template-parts/about/story' ); ?>
    <?php                        get_template_part( 'template-parts/about/mission' ); ?>
    <?php if ( $show['values'] ) get_template_part( 'template-parts/about/values' ); ?>
    <?php if ( $show['cta'] )    get_template_part( 'template-parts/about/cta' ); ?>

</main>
<?php
get_footer();
