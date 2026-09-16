<?php
/**
 * Paksa IT Solutions — Product Taxonomy Archive
 *
 * Template: taxonomy-paksa_product_cat.php
 * URL: /solutions/category/{term-slug}/
 *
 * Displays products belonging to a single paksa_product_cat term.
 * Uses native WP_Query loop — no custom query needed.
 * Reuses product card markup and design system from archive-paksa_product.php.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$term        = get_queried_object();
$term_name   = $term ? $term->name : '';
$term_desc   = $term ? $term->description : '';
$archive_url = get_post_type_archive_link( 'paksa_product' );

// Sibling terms for category navigation
$sibling_cats = get_terms( array(
    'taxonomy'   => 'paksa_product_cat',
    'hide_empty' => true,
) );
?>
<main id="main-content" class="pk-product-taxonomy">

    <?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>

    <!-- Taxonomy Hero -->
    <section class="pk-prod-listing-hero" aria-labelledby="pk-tax-heading">
        <div class="container pk-prod-listing-hero-inner">
            <div class="pk-prod-listing-hero-content">
                <span class="eyebrow pk-animate-on-scroll" data-anim="fade-up">
                    <?php esc_html_e( 'Software Solutions', 'paksa-it-solutions' ); ?>
                </span>
                <h1 id="pk-tax-heading" class="pk-prod-listing-hero-heading pk-animate-on-scroll" data-anim="fade-up" data-delay="80">
                    <?php echo esc_html( $term_name ); ?>
                </h1>
                <?php if ( $term_desc ) : ?>
                    <p class="body-large pk-animate-on-scroll" data-anim="fade-up" data-delay="120">
                        <?php echo esc_html( $term_desc ); ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Category navigation — all categories + current highlighted -->
            <?php if ( ! is_wp_error( $sibling_cats ) && ! empty( $sibling_cats ) ) : ?>
                <nav class="pk-prod-cat-filter pk-animate-on-scroll" data-anim="fade-up" data-delay="160"
                     aria-label="<?php esc_attr_e( 'Browse products by category', 'paksa-it-solutions' ); ?>">
                    <a href="<?php echo esc_url( $archive_url ); ?>"
                       class="pk-prod-cat-pill"
                       aria-current="false">
                        <?php esc_html_e( 'All Products', 'paksa-it-solutions' ); ?>
                    </a>
                    <?php foreach ( $sibling_cats as $cat ) :
                        $is_current = $term && $cat->term_id === $term->term_id;
                    ?>
                        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
                           class="pk-prod-cat-pill<?php echo $is_current ? ' is-active' : ''; ?>"
                           aria-current="<?php echo $is_current ? 'page' : 'false'; ?>">
                            <?php echo esc_html( $cat->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>
        </div>
    </section>

    <!-- Product Grid — native WP loop filtered by taxonomy -->
    <section class="section pk-prod-grid-section" id="pk-products-grid" aria-labelledby="pk-tax-grid-label">
        <div class="container">
            <h2 id="pk-tax-grid-label" class="screen-reader-text">
                <?php
                /* translators: %s: category name */
                printf( esc_html__( 'Products in %s', 'paksa-it-solutions' ), esc_html( $term_name ) );
                ?>
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

                <div class="pk-prod-empty" style="text-align:center; padding: var(--pk-space-16) 0;">
                    <p class="body-large" style="color: var(--pk-text-muted);">
                        <?php
                        /* translators: %s: category name */
                        printf( esc_html__( 'No products are currently listed under %s.', 'paksa-it-solutions' ), '<strong>' . esc_html( $term_name ) . '</strong>' );
                        ?>
                    </p>
                    <a href="<?php echo esc_url( $archive_url ); ?>" class="btn btn-outline" style="margin-top: var(--pk-space-6);">
                        <?php esc_html_e( 'View All Products', 'paksa-it-solutions' ); ?>
                    </a>
                </div>

            <?php endif; ?>

        </div>
    </section>

    <!-- CTA -->
    <?php get_template_part( 'template-parts/products/cta' ); ?>

</main>
<?php
get_footer();
