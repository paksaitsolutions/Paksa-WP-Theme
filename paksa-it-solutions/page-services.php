<?php
/**
 * Paksa IT Solutions — Services Page Template
 *
 * Template Name: Services / IT Solutions
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>
<main id="main-content" class="pk-services-page">
    <?php get_template_part( 'template-parts/services/hero' ); ?>
    <?php get_template_part( 'template-parts/services/stats' ); ?>
    <?php get_template_part( 'template-parts/services/portfolio' ); ?>
    <?php get_template_part( 'template-parts/services/capabilities' ); ?>
    <?php get_template_part( 'template-parts/services/process' ); ?>
    <?php get_template_part( 'template-parts/services/technology' ); ?>
    <?php get_template_part( 'template-parts/services/industries' ); ?>
    <?php get_template_part( 'template-parts/services/cta' ); ?>
</main>
<?php
get_footer();
