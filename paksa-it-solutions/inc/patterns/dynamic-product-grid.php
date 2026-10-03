<?php
/**
 * Paksa — Block Pattern: Dynamic Product Grid
 *
 * A fully dynamic product grid using paksa/dynamic-grid.
 * Queries published paksa_product CPT items with visual controls.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/dynamic-product-grid',
    array(
        'title'      => __( 'Dynamic — Product Grid', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-dynamic-grids' ),
        'keywords'   => array( 'products', 'dynamic', 'grid', 'query' ),
        'viewport'   => array( 'width' => 1280, 'height' => 500 ),
        'content'    => '<!-- wp:paksa/dynamic-grid {"source":"paksa_product","mode":"dynamic","perPage":9,"orderBy":"menu_order","order":"asc","featured":"featured","layout":"grid","columns":3,"heading":"Our Products","eyebrow":"Featured Solutions","description":"Industry-specific platforms designed around operational realities.","showReadMore":true,"readMoreLabel":"View all products","readMoreUrl":"/solutions/"} /-->',
    )
);
