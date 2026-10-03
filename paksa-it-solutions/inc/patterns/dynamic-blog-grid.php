<?php
/**
 * Paksa — Block Pattern: Dynamic Blog Grid
 *
 * A fully dynamic blog grid using paksa/dynamic-grid.
 * Queries published posts with visual controls.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/dynamic-blog-grid',
    array(
        'title'      => __( 'Dynamic — Blog Grid', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-dynamic-grids' ),
        'keywords'   => array( 'blog', 'dynamic', 'grid', 'posts' ),
        'viewport'   => array( 'width' => 1280, 'height' => 500 ),
        'content'    => '<!-- wp:paksa/dynamic-grid {"source":"post","mode":"dynamic","perPage":9,"orderBy":"date","order":"desc","layout":"grid","columns":3,"heading":"Latest Insights","eyebrow":"From the blog","description":"Ideas and updates worth reading.","showReadMore":true,"readMoreLabel":"View all posts","readMoreUrl":"/blog/"} /-->',
    )
);
