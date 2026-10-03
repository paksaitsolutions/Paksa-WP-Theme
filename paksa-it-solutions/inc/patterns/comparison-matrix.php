<?php
/**
 * Paksa — Block Pattern: Comparison Matrix
 *
 * A comparison table using native core/table block with Paksa styling.
 * Uses only existing block styles and CSS — no custom data model.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/comparison-matrix',
    array(
        'title'      => __( 'Comparison — Plan Matrix', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-matrix' ),
        'keywords'   => array( 'comparison', 'matrix', 'table', 'pricing', 'features' ),
        'viewport'   => array( 'width' => 1280, 'height' => 400 ),
        'content'    => '<!-- wp:paksa/section {"variant":"alt"} -->'
        . '<div class="wp-block-paksa-section pk-section pk-section--alt">'
        . paksa_visual_heading( 'Compare plans', 2 )
        . paksa_visual_paragraph( 'Side-by-side comparison of what each plan includes.' )
        . '<!-- wp:table {"className":"is-style-paksa-clean"} -->'
        . '<figure class="wp-block-table is-style-paksa-clean"><table><thead><tr><th>Feature</th><th>Starter</th><th>Professional</th><th>Enterprise</th></tr></thead><tbody>'
        . '<tr><td>Projects</td><td>1</td><td>5</td><td>Unlimited</td></tr>'
        . '<tr><td>User seats</td><td>1</td><td>5</td><td>Unlimited</td></tr>'
        . '<tr><td>Priority support</td><td>—</td><td>✓</td><td>✓</td></tr>'
        . '<tr><td>Dedicated account manager</td><td>—</td><td>—</td><td>✓</td></tr>'
        . '<tr><td>Custom integrations</td><td>—</td><td>—</td><td>✓</td></tr>'
        . '</tbody></table></figure><!-- /wp:table -->'
        . '<!-- /wp:paksa/section -->',
    )
);
