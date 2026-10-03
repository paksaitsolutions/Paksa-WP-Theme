<?php
/**
 * Paksa — Block Pattern: Service Query with Filter
 *
 * A dynamic service grid with category filtering and search.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/service-query-filter',
    array(
        'title'      => __( 'Dynamic — Service Grid with Filter', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-services' ),
        'keywords'   => array( 'services', 'filter', 'search', 'dynamic' ),
        'viewport'   => array( 'width' => 1280, 'height' => 500 ),
        'content'    => '<!-- wp:paksa/dynamic-grid {"source":"paksa_service","mode":"dynamic","perPage":12,"orderBy":"menu_order","order":"asc","showFilter":true,"enableSearch":true,"layout":"grid","columns":3,"heading":"All Services","eyebrow":"Browse by expertise","description":"Use the filter to find services by category.","showReadMore":true,"readMoreLabel":"View all services","readMoreUrl":"/services/"} /-->',
    )
);
