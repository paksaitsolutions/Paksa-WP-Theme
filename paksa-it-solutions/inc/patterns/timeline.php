<?php
/**
 * Paksa — Block Pattern: Timeline
 *
 * A vertical timeline using paksa/timeline.
 * Add, remove, or reorder timeline items inside the block.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH') ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/timeline',
    array(
        'title'      => __( 'Timeline — Process Steps', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-process-v2' ),
        'keywords'   => array( 'timeline', 'process', 'steps', 'history' ),
        'viewport'   => array( 'width' => 1280, 'height' => 500 ),
        'content'    => '<!-- wp:paksa/timeline {"orientation":"vertical","markerType":"number","connectorStyle":"solid"} -->'
        . '<div class="wp-block-paksa-timeline">'
        . '<!-- wp:group {"className":"pk-timeline__item"} -->'
        . '<div class="wp-block-group pk-timeline__item">'
        . paksa_visual_heading( 'Discovery', 3 )
        . paksa_visual_paragraph( 'Align on goals, users, and opportunity. Understand the problem before proposing a solution.' )
        . '</div><!-- /wp:group -->'
        . '<!-- wp:group {"className":"pk-timeline__item"} -->'
        . '<div class="wp-block-group pk-timeline__item">'
        . paksa_visual_heading( 'Design', 3 )
        . paksa_visual_paragraph( 'Create a clear plan and validate the approach before building. Sketch, prototype, and refine.' )
        . '</div><!-- /wp:group -->'
        . '<!-- wp:group {"className":"pk-timeline__item"} -->'
        . '<div class="wp-block-group pk-timeline__item">'
        . paksa_visual_heading( 'Delivery', 3 )
        . paksa_visual_paragraph( 'Build, test, and ship with quality and speed. Iterate based on real feedback.' )
        . '</div><!-- /wp:group -->'
        . '<!-- wp:group {"className":"pk-timeline__item"} -->'
        . '<div class="wp-block-group pk-timeline__item">'
        . paksa_visual_heading( 'Support', 3 )
        . paksa_visual_paragraph( 'Measure outcomes and keep improving after launch. Your success is our ongoing priority.' )
        . '</div><!-- /wp:group -->'
        . '</div><!-- /wp:paksa/timeline -->',
    )
);
