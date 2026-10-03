<?php
/**
 * Paksa — Block Pattern: Dynamic Service Grid
 *
 * A fully dynamic service grid using paksa/dynamic-grid.
 * Queries published paksa_service CPT items with visual controls.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/dynamic-service-grid',
    array(
        'title'      => __( 'Dynamic — Service Grid', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-dynamic-grids' ),
        'keywords'   => array( 'services', 'dynamic', 'grid', 'query' ),
        'viewport'   => array( 'width' => 1280, 'height' => 500 ),
        'content'    => '<!-- wp:paksa/dynamic-grid {"source":"paksa_service","mode":"dynamic","perPage":9,"orderBy":"menu_order","order":"asc","layout":"grid","columns":3,"heading":"Our Services","eyebrow":"What We Do","description":"Comprehensive technology services tailored to your business needs.","showReadMore":true,"readMoreLabel":"View all services","readMoreUrl":"/services/"} /-->',
    )
);
