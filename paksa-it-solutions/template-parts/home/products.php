<?php
/**
 * Paksa IT Solutions — Homepage: Featured Products / Solutions
 *
 * Content: WP_Query on paksa_product CPT (featured products only, or all if none featured).
 * Falls back to empty state if no products are published.
 * No hardcoded product data.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Query featured products first; fall back to all published products (max 4).
$featured_query = new WP_Query( array(
    'post_type'      => 'paksa_product',
    'post_status'    => 'publish',
    'posts_per_page' => 4,
    'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
    'meta_query'     => array(
        array(
            'key'   => '_paksa_prod_featured',
            'value' => '1',
        ),
    ),
) );

if ( ! $featured_query->have_posts() ) {
    // No featured products — show first 4 published products.
    $featured_query = new WP_Query( array(
        'post_type'      => 'paksa_product',
        'post_status'    => 'publish',
        'posts_per_page' => 4,
        'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
    ) );
}

if ( ! $featured_query->have_posts() ) {
    return; // No products published — section hidden entirely.
}

$archive_url = get_post_type_archive_link( 'paksa_product' );
?>
<section class="section pk-products" id="products" aria-labelledby="pk-products-heading">
    <div class="container">
        <header class="section-header">
            <span class="eyebrow"><?php esc_html_e( 'Featured Solutions', 'paksa-it-solutions' ); ?></span>
            <h2 id="pk-products-heading"><?php esc_html_e( 'Software Built for Specific Business Needs', 'paksa-it-solutions' ); ?></h2>
            <p><?php esc_html_e( 'Industry-specific platforms designed around the operational realities of each sector.', 'paksa-it-solutions' ); ?></p>
        </header>

        <div class="pk-products-grid" role="list">
            <?php
            $index = 0;
            while ( $featured_query->have_posts() ) :
                $featured_query->the_post();
                get_template_part( 'template-parts/components/product-card', null, array(
                    'post_id'     => get_the_ID(),
                    'index'       => $index,
                    'heading_tag' => 'h3',
                ) );
                $index++;
            endwhile;
            wp_reset_postdata();
            ?>
        </div>

        <?php if ( $archive_url ) : ?>
            <div style="text-align:center; margin-top: var(--pk-space-10);">
                <a href="<?php echo esc_url( $archive_url ); ?>" class="btn btn-outline">
                    <?php esc_html_e( 'View All Products', 'paksa-it-solutions' ); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
