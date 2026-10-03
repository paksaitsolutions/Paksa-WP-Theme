<?php
/**
 * Paksa IT Solutions — About Page Template
 *
 * Template Name: About Us
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<main id="main-content" tabindex="-1" class="pk-about-page">
    <?php
    while ( have_posts() ) :
        the_post();
        get_template_part( 'template-parts/about/hero' );
        get_template_part( 'template-parts/about/story' );
        get_template_part( 'template-parts/about/expertise' );
        get_template_part( 'template-parts/about/approach' );
        get_template_part( 'template-parts/about/mission' );
        get_template_part( 'template-parts/about/values' );
        get_template_part( 'template-parts/about/why-choose' );
        get_template_part( 'template-parts/about/cta' );
    endwhile;
    ?>
</main>
<?php
get_footer();
