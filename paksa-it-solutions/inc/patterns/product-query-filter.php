<?php
/**
 * Paksa — Block Pattern: Product Query with Filter
 *
 * A dynamic product grid with category filtering and search.
 * Uses paksa/dynamic-grid with showFilter and enableSearch enabled.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/product-query-filter',
    array(
        'title'      => __( 'Dynamic — Product Grid with Filter', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-products' ),
        'keywords'   => array( 'products', 'filter', 'search', 'dynamic' ),
        'viewport'   => array( 'width' => 1280, 'height' => 500 ),
        'content'    => '<!-- wp:paksa/dynamic-grid {"source":"paksa_product","mode":"dynamic","perPage":12,"orderBy":"menu_order","order":"asc","showFilter":true,"enableSearch":true,"layout":"grid","columns":3,"heading":"All Products","eyebrow":"Browse by category","description":"Use the filter to narrow down by product category.","showReadMore":true,"readMoreLabel":"View all products","readMoreUrl":"/solutions/"} /-->',
    )
);
