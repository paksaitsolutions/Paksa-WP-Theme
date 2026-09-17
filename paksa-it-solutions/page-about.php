<?php
/**
 * Paksa IT Solutions — About Page Template
 *
 * Template Name: About Us
 *
 * Content is edited via the block editor (Pages → About Us → Edit).
 * Use Paksa block patterns to build sections.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<main id="main-content" class="pk-about-page">
    <?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>
    <div class="pk-page-content">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
</main>
<?php
get_footer();
