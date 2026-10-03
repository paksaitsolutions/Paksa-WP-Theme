<?php
/**
 * Paksa — Block Pattern: Featured Products + Latest
 *
 * A two-section composition showing featured products as cards
 * and latest products as a grid list. Uses native core/query blocks.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/products-featured-latest',
    array(
        'title'      => __( 'Products — Featured then Latest', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-products' ),
        'keywords'   => array( 'products', 'featured', 'latest', 'grid' ),
        'viewport'   => array( 'width' => 1280, 'height' => 600 ),
        'content'    => '<!-- wp:paksa/section {"variant":"gradient","textAlign":"center"} -->'
        . '<div class="wp-block-paksa-section pk-section pk-section--gradient">'
        . paksa_visual_heading( 'Featured Solutions', 2 )
        . paksa_visual_paragraph( 'Our most impactful products, hand-selected.' )
        . '<!-- wp:columns {"className":"pk-pattern-card-grid"} -->'
        . '<div class="wp-block-columns pk-pattern-card-grid">'
        . '<!-- wp:column -->'
        . '<div class="wp-block-column">'
        . '<!-- wp:paksa/dynamic-grid {"source":"paksa_product","mode":"dynamic","perPage":3,"featured":"featured","layout":"grid","columns":3} /-->'
        . '</div><!-- /wp:column -->'
        . '<!-- wp:column -->'
        . '<div class="wp-block-column">'
        . '<!-- wp:paksa/dynamic-grid {"source":"paksa_product","mode":"dynamic","perPage":3,"featured":"not_featured","layout":"grid","columns":3} /-->'
        . '</div><!-- /wp:column -->'
        . '</div><!-- /wp:columns -->'
        . '</div><!-- /wp:paksa/section -->',
    )
);
