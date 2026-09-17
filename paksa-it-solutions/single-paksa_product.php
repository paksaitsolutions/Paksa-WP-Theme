<?php
/**
 * Paksa IT Solutions — Single Product Template
 *
 * Template: single-paksa_product.php
 *
 * Renders the block editor content for individual product pages.
 * Build each product page using the block editor — all sections are editable.
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
?>
<main id="main-content" class="pk-single-product">
    <?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php the_content(); ?>
    </article>
</main>
<?php
get_footer();
