<?php
/**
 * Paksa IT Solutions — Block Pattern: Heading Compact
 *
 * Compact heading with subheading for smaller sections,
 * sidebars, cards, and modular content areas.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/heading-compact',
    array(
        'title'      => __( 'Heading — Compact', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-headings' ),
        'keywords'   => array( 'heading', 'compact', 'small', 'card' ),
        'viewport'   => array(
            'width'  => 600,
            'height' => 200,
        ),
        'content'    => '<!-- wp:paragraph {"style":{"color":{"text":"var(--pk-accent)"},"typography":{"fontSize":"0.75rem","fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.08em"}},"metadata":{"dxActionId":""}} -->
<p style="color:var(--pk-accent);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:1rem;">' . esc_html__( 'Feature', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"clamp(1.25rem, 2vw, 1.5rem)","lineHeight":"1.2"},"spacing":{"marginBottom":"1rem"}},"metadata":{"dxActionId":""}} -->
<h3 style="font-size:clamp(1.25rem, 2vw, 1.5rem);line-height:1.2;margin-bottom:1rem;">' . esc_html__( 'Smart Analytics Dashboard', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"var(--pk-text-secondary)"},"fontSize":"0.9375rem","lineHeight":"1.6"}},"metadata":{"dxActionId":""}} -->
<p style="color:var(--pk-text-secondary);font-size:0.9375rem;line-height:1.6;">' . esc_html__( 'Real-time insights and metrics to drive better business decisions.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->',
    )
);
