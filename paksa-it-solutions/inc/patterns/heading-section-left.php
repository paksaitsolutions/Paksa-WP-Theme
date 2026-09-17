<?php
/**
 * Paksa IT Solutions — Block Pattern: Section Heading Left
 *
 * Left-aligned section header with eyebrow, heading, and description.
 * For content sections where left alignment fits the layout.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/heading-section-left',
    array(
        'title'      => __( 'Heading — Section Left', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-headings' ),
        'keywords'   => array( 'heading', 'section', 'left', 'align' ),
        'viewport'   => array(
            'width'  => 1280,
            'height' => 250,
        ),
        'content'    => '<!-- wp:group {"className":"section-header align-left pk-animate-on-scroll","metadata":{"dxActionId":""}} -->
<div class="section-header align-left pk-animate-on-scroll" data-anim="fade-up"><!-- wp:paragraph {"style":{"color":{"text":"var(--pk-accent)"},"typography":{"fontSize":"0.75rem","fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.08em"}},"metadata":{"dxActionId":""}} -->
<p style="color:var(--pk-accent);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;">' . esc_html__( 'The Challenge', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"style":{"typography":{"fontSize":"clamp(1.5rem, 3vw, 2.25rem)","lineHeight":"1.15"},"spacing":{"marginBottom":"1rem"}},"metadata":{"dxActionId":""}} -->
<h2 style="font-size:clamp(1.5rem, 3vw, 2.25rem);line-height:1.15;margin-bottom:1rem;">' . esc_html__( 'Technology Should Solve Real Business Problems', 'paksa-it-solutions' ) . '</h2><!-- /wp:heading -->

<!-- wp:paragraph {"className":"body-large","style":{"color":{"text":"var(--pk-text-secondary)"},"typography":{"fontSize":"1.125rem","lineHeight":"1.7"}},"metadata":{"dxActionId":""}} -->
<p class="body-large" style="color:var(--pk-text-secondary);font-size:1.125rem;line-height:1.7;">' . esc_html__( 'Most businesses operate with disconnected systems, manual processes and fragmented data. The result is slow decisions, limited visibility and missed opportunities.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
    )
);
