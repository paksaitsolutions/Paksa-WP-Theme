<?php
/**
 * Paksa IT Solutions — Products / Solutions Page Template
 *
 * Template Name: Products / Solutions
 *
 * Content is edited via the block editor (Pages → Products → Edit).
 * Use Paksa block patterns to build sections.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<main id="main-content" class="pk-products-page">
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
