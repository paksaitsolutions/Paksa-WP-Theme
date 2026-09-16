<?php
/**
 * Paksa IT Solutions — Front Page (Homepage)
 * Orchestrates all homepage sections via template parts.
 * Section visibility is controlled via Customizer (paksa_home_show_*).
 * No section markup lives here — only get_template_part() calls.
 *
 * @package paksa-it-solutions
 */

get_header();

/**
 * Section visibility — controlled via Customizer.
 * Default: all sections visible.
 * Admin can hide any section from Appearance → Customize → Homepage → Section Visibility.
 */
$show = array(
    'hero'            => paksa_get_option( 'paksa_home_show_hero',            '1' ) !== '0',
    'trust_strip'     => paksa_get_option( 'paksa_home_show_trust_strip',     '1' ) !== '0',
    'challenge'       => paksa_get_option( 'paksa_home_show_challenge',       '1' ) !== '0',
    'capabilities'    => paksa_get_option( 'paksa_home_show_capabilities',    '1' ) !== '0',
    'technology'      => paksa_get_option( 'paksa_home_show_technology',      '1' ) !== '0',
    'products'        => paksa_get_option( 'paksa_home_show_products',        '1' ) !== '0',
    'intelligence'    => paksa_get_option( 'paksa_home_show_intelligence',    '1' ) !== '0',
    'process'         => paksa_get_option( 'paksa_home_show_process',         '1' ) !== '0',
    'why_paksa'       => paksa_get_option( 'paksa_home_show_why_paksa',       '1' ) !== '0',
    'differentiation' => paksa_get_option( 'paksa_home_show_differentiation', '1' ) !== '0',
    'industries'      => paksa_get_option( 'paksa_home_show_industries',      '1' ) !== '0',
    'case_studies'    => paksa_get_option( 'paksa_home_show_case_studies',    '1' ) !== '0',
    'outcomes'        => paksa_get_option( 'paksa_home_show_outcomes',        '1' ) !== '0',
    'faq'             => paksa_get_option( 'paksa_home_show_faq',             '1' ) !== '0',
    'final_cta'       => paksa_get_option( 'paksa_home_show_final_cta',       '1' ) !== '0',
);

/**
 * Filter: paksa_homepage_section_visibility
 * Allows programmatic control of section visibility.
 *
 * @param array $show Associative array of section => bool.
 */
$show = apply_filters( 'paksa_homepage_section_visibility', $show );
?>
<main id="main-content" class="pk-front-page">
<?php
if ( $show['hero'] )            get_template_part( 'template-parts/home/hero' );
if ( $show['trust_strip'] )     get_template_part( 'template-parts/home/trust-strip' );
if ( $show['challenge'] )       get_template_part( 'template-parts/home/challenge' );
if ( $show['capabilities'] )    get_template_part( 'template-parts/home/capabilities' );
if ( $show['technology'] )      get_template_part( 'template-parts/home/technology' );
if ( $show['products'] )        get_template_part( 'template-parts/home/products' );
if ( $show['intelligence'] )    get_template_part( 'template-parts/home/intelligence' );
if ( $show['process'] )         get_template_part( 'template-parts/home/process' );
if ( $show['why_paksa'] )       get_template_part( 'template-parts/home/why-paksa' );
if ( $show['differentiation'] ) get_template_part( 'template-parts/home/differentiation' );
if ( $show['industries'] )      get_template_part( 'template-parts/home/industries' );
if ( $show['case_studies'] )    get_template_part( 'template-parts/home/case-studies' );
if ( $show['outcomes'] )        get_template_part( 'template-parts/home/outcomes' );
if ( $show['faq'] )             get_template_part( 'template-parts/home/faq' );
if ( $show['final_cta'] )       get_template_part( 'template-parts/home/final-cta' );
?>
</main>
<?php
get_footer();
