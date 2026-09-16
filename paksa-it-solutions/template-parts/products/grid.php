<?php
/**
 * Paksa IT Solutions — Products Listing: Product Grid
 *
 * Queries the paksa_product CPT ordered by menu_order then title.
 * Each card links to the individual product's single-paksa_product.php page.
 * Reuses .pk-product-card CSS from home.css (already loaded on this template).
 *
 * Filter: paksa_products_query_args — override the WP_Query args.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow = apply_filters( 'paksa_prod_grid_eyebrow', __( 'Our Portfolio', 'paksa-it-solutions' ) );
$heading = apply_filters( 'paksa_prod_grid_heading', __( 'Software Products & Solutions', 'paksa-it-solutions' ) );
$desc    = apply_filters( 'paksa_prod_grid_desc',    __( 'Purpose-built platforms for specific industries and business operations.', 'paksa-it-solutions' ) );

$query_args = apply_filters( 'paksa_products_query_args', array(
    'post_type'      => 'paksa_product',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
) );

$products_query = new WP_Query( $query_args );
?>
<section class="section pk-prod-grid-section" id="pk-products-grid" aria-labelledby="pk-prod-grid-heading">
    <div class="container">

        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow'     => $eyebrow,
            'heading'     => $heading,
            'description' => $desc,
        ) );
        ?>

        <?php if ( $products_query->have_posts() ) : ?>

            <div class="pk-products-grid pk-prod-cpt-grid" role="list">
                <?php
                $index = 0;
                while ( $products_query->have_posts() ) :
                    $products_query->the_post();
                    get_template_part( 'template-parts/components/product-card', null, array(
                        'post_id'     => get_the_ID(),
                        'index'       => $index,
                        'show_filter' => true,
                    ) );
                    $index++;
                endwhile;
                wp_reset_postdata();
                ?>
            </div>

        <?php else : ?>

            <p class="pk-prod-empty body-large" style="text-align:center; color: var(--pk-text-muted);">
                <?php esc_html_e( 'No products have been published yet. Add products from the Products admin menu.', 'paksa-it-solutions' ); ?>
            </p>

        <?php endif; ?>

    </div>
</section>
