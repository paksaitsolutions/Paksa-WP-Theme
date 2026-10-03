<?php
/**
 * Paksa — Block Pattern: Dynamic Timeline Composition
 *
 * A process timeline using paksa/timeline with editable InnerBlocks items.
 * Uses existing animation infrastructure and paksa_visual_* helpers.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/timeline-process',
    array(
        'title'      => __( 'Timeline — Process Journey', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-process-v2' ),
        'keywords'   => array( 'timeline', 'process', 'journey', 'steps' ),
        'viewport'   => array( 'width' => 1280, 'height' => 500 ),
        'content'    => '<!-- wp:paksa/timeline {"orientation":"vertical","markerType":"number","connectorStyle":"solid","animation":"fade-up"} -->'
        . '<div class="wp-block-paksa-timeline">'
        . '<!-- wp:group {"className":"pk-timeline__item"} -->'
        . '<div class="wp-block-group pk-timeline__item">'
        . paksa_visual_heading( 'Strategy & Discovery', 3 )
        . paksa_visual_paragraph( 'Align on goals, users, and opportunity. Conduct stakeholder interviews and competitive analysis.' )
        . '</div><!-- /wp:group -->'
        . '<!-- wp:group {"className":"pk-timeline__item"} -->'
        . '<div class="wp-block-group pk-timeline__item">'
        . paksa_visual_heading( 'Design & Prototyping', 3 )
        . paksa_visual_paragraph( 'Create wireframes, user flows, and interactive prototypes. Validate direction with real users.' )
        . '</div><!-- /wp:group -->'
        . '<!-- wp:group {"className":"pk-timeline__item"} -->'
        . '<div class="wp-block-group pk-timeline__item">'
        . paksa_visual_heading( 'Development', 3 )
        . paksa_visual_paragraph( 'Build with scalable, maintainable code. Follow modern practices and automated testing.' )
        . '</div><!-- /wp:group -->'
        . '<!-- wp:group {"className":"pk-timeline__item"} -->'
        . '<div class="wp-block-group pk-timeline__item">'
        . paksa_visual_heading( 'Launch & Iteration', 3 )
        . paksa_visual_paragraph( 'Deploy with confidence. Monitor performance and iterate based on real usage data.' )
        . '</div><!-- /wp:group -->'
        . '</div><!-- /wp:paksa/timeline -->',
    )
);
