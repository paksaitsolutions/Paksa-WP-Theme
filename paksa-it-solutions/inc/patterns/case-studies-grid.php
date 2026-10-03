<?php
/**
 * Paksa — Block Pattern: Case Studies Grid
 *
 * A grid of case study cards using existing card styles.
 * Replace placeholders with real project outcomes.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/case-studies-grid',
    array(
        'title'      => __( 'Case Studies — Results Grid', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-case-studies' ),
        'keywords'   => array( 'case studies', 'results', 'outcomes', 'proof' ),
        'viewport'   => array( 'width' => 1280, 'height' => 500 ),
        'content'    => paksa_visual_section(
            '',
            'Measurable outcomes',
            'Real results from real projects. Use verified data, not estimates.',
            'Replace each card with a real case study, including the challenge, approach, and measurable outcome.',
            paksa_visual_columns( array(
                paksa_visual_group( 'is-style-paksa-card-image',
                    paksa_visual_media_placeholder()
                    . paksa_visual_group( 'pk-builder-card-content',
                        paksa_visual_paragraph( 'Enterprise', 'pk-component-meta' )
                        . paksa_visual_heading( '40% cost reduction', 3 )
                        . paksa_visual_paragraph( 'Migrated legacy infrastructure to cloud-native, cutting operational costs by 40% while improving reliability.' )
                        . paksa_visual_actions( 'Read the case study', '' )
                    )
                ),
                paksa_visual_group( 'is-style-paksa-card-image',
                    paksa_visual_media_placeholder()
                    . paksa_visual_group( 'pk-builder-card-content',
                        paksa_visual_paragraph( 'Technology', 'pk-component-meta' )
                        . paksa_visual_heading( '3x faster delivery', 3 )
                        . paksa_visual_paragraph( 'Redesigned the deployment pipeline, reducing release cycles from weekly to daily.' )
                        . paksa_visual_actions( 'Read the case study', '' )
                    )
                ),
                paksa_visual_group( 'is-style-paksa-card-image',
                    paksa_visual_media_placeholder()
                    . paksa_visual_group( 'pk-builder-card-content',
                        paksa_visual_paragraph( 'Healthcare', 'pk-component-meta' )
                        . paksa_visual_heading( '99.9% uptime', 3 )
                        . paksa_visual_paragraph( 'Built a HIPAA-compliant platform with multi-region redundancy and automated failover.' )
                        . paksa_visual_actions( 'Read the case study', '' )
                    )
                ),
            ), 'pk-builder-case-studies' )
        )
    )
);
