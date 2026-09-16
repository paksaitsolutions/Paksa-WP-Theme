<?php
/**
 * Paksa IT Solutions — Product Archive Template
 *
 * Template: archive-paksa_product.php
 * URL: /solutions/
 *
 * Native WordPress CPT archive. Uses the main WP_Query loop — no custom query.
 * Ordered by menu_order ASC, title ASC (set in CPT registration).
 *
 * Reuses:
 *   template-parts/products/cta.php     — final CTA
 *   template-parts/components/section-header.php
 *   .pk-product-card CSS from home.css
 *   .pk-products-grid CSS from home.css
 *   .pk-prod-badge, .pk-product-thumb from products.css
 *
 * Does NOT load products.js — no JS category filter on archive.
 * Native taxonomy navigation used instead.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Taxonomy terms for category navigation
$archive_cats = get_terms( array(
    'taxonomy'   => 'paksa_product_cat',
    'hide_empty' => true,
) );
?>
<main id="main-content" class="pk-product-archive">

    <?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>

    <!-- Archive Hero -->
    <section class="pk-prod-listing-hero" aria-labelledby="pk-archive-heading">
        <div class="container pk-prod-listing-hero-inner">
            <div class="pk-prod-listing-hero-content">
                <span class="eyebrow pk-animate-on-scroll" data-anim="fade-up">
                    <?php esc_html_e( 'Software Solutions', 'paksa-it-solutions' ); ?>
                </span>
                <h1 id="pk-archive-heading" class="pk-prod-listing-hero-heading pk-animate-on-scroll" data-anim="fade-up" data-delay="80">
                    <?php post_type_archive_title(); ?>
                </h1>
                <?php
                $archive_desc = get_the_archive_description();
                if ( $archive_desc ) :
                ?>
                    <div class="body-large pk-animate-on-scroll" data-anim="fade-up" data-delay="120">
                        <?php echo wp_kses_post( $archive_desc ); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ( ! is_wp_error( $archive_cats ) && ! empty( $archive_cats ) ) : ?>
                <nav class="pk-prod-cat-filter pk-animate-on-scroll" data-anim="fade-up" data-delay="160"
                     aria-label="<?php esc_attr_e( 'Browse products by category', 'paksa-it-solutions' ); ?>">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'paksa_product' ) ); ?>"
                       class="pk-prod-cat-pill<?php echo ! is_tax() ? ' is-active' : ''; ?>"
                       aria-current="<?php echo ! is_tax() ? 'page' : 'false'; ?>">
                        <?php esc_html_e( 'All Products', 'paksa-it-solutions' ); ?>
                    </a>
                    <?php foreach ( $archive_cats as $cat ) : ?>
                        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
                           class="pk-prod-cat-pill"
                           aria-current="false">
                            <?php echo esc_html( $cat->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>
        </div>
    </section>

    <!-- Product Grid — native WP loop -->
    <section class="section pk-prod-grid-section" id="pk-products-grid" aria-labelledby="pk-archive-grid-label">
        <div class="container">
            <h2 id="pk-archive-grid-label" class="screen-reader-text">
                <?php esc_html_e( 'All Products', 'paksa-it-solutions' ); ?>
            </h2>

            <?php if ( have_posts() ) : ?>

                <div class="pk-products-grid pk-prod-cpt-grid" role="list">
                    <?php
                    $index = 0;
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/components/product-card', null, array(
                            'post_id' => get_the_ID(),
                            'index'   => $index,
                        ) );
                        $index++;
                    endwhile;
                    ?>
                </div>

                <!-- Pagination -->
                <?php
                the_posts_pagination( array(
                    'mid_size'           => 2,
                    'prev_text'          => __( '&larr; Previous', 'paksa-it-solutions' ),
                    'next_text'          => __( 'Next &rarr;', 'paksa-it-solutions' ),
                    'screen_reader_text' => __( 'Products navigation', 'paksa-it-solutions' ),
                    'class'              => 'pk-archive-pagination',
                ) );
                ?>

            <?php else : ?>

                <p class="pk-prod-empty body-large" style="text-align:center; color: var(--pk-text-muted); padding: var(--pk-space-16) 0;">
                    <?php esc_html_e( 'No products have been published yet.', 'paksa-it-solutions' ); ?>
                </p>

            <?php endif; ?>

        </div>
    </section>

    <!-- CTA — reuses products listing CTA component -->
    <?php get_template_part( 'template-parts/products/cta' ); ?>

</main>
<?php
get_footer();
