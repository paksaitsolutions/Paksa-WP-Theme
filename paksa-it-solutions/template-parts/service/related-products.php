<?php
/**
 * Paksa IT Solutions — Single Service: Related Products
 *
 * Queries paksa_product posts whose IDs are stored in _paksa_svc_related_products.
 * Uses paksa_get_service_related_products() from service-meta.php.
 * Reuses .pk-product-card CSS from home.css.
 *
 * If no related products are set, section is silently hidden.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$svc_id      = get_the_ID();
$product_ids = paksa_get_service_related_products( $svc_id );

if ( empty( $product_ids ) ) {
    return;
}

$related_query = new WP_Query( array(
    'post_type'      => 'paksa_product',
    'post_status'    => 'publish',
    'post__in'       => $product_ids,
    'orderby'        => 'post__in',
    'posts_per_page' => count( $product_ids ),
) );

if ( ! $related_query->have_posts() ) {
    return;
}

$eyebrow = apply_filters( 'paksa_svc_related_products_eyebrow', __( 'Related Solutions', 'paksa-it-solutions' ), $svc_id );
$heading = apply_filters( 'paksa_svc_related_products_heading', __( 'Products That Support This Service', 'paksa-it-solutions' ), $svc_id );
?>
<section class="section section-alt pk-svc-related-products" aria-labelledby="pk-svc-related-heading">
    <div class="container">

        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow' => $eyebrow,
            'heading' => $heading,
        ) );
        ?>

        <div class="pk-products-grid" role="list">
            <?php
            $index = 0;
            while ( $related_query->have_posts() ) :
                $related_query->the_post();
                get_template_part( 'template-parts/components/product-card', null, array(
                    'post_id' => get_the_ID(),
                    'index'   => $index,
                ) );
                $index++;
            endwhile;
            wp_reset_postdata();
            ?>
        </div>

    </div>
</section>
