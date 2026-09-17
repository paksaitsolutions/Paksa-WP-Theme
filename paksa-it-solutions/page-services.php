<?php
/**
 * Paksa IT Solutions — Services Page Template
 *
 * Template Name: Services / IT Solutions
 *
 * Content is edited via the block editor (Pages → Services → Edit).
 * Use Paksa Services block patterns to build sections.
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
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
    endif;
    ?>
</main>
<?php
get_footer();
