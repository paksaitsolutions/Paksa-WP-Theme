<?php
/**
 * Paksa IT Solutions — Block Pattern: Paragraph CTA
 *
 * Paragraph text with primary and secondary CTA buttons.
 * For conversion-focused sections and landing page content.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/paragraph-cta',
    array(
        'title'      => __( 'Paragraph — CTA', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-paragraphs' ),
        'keywords'   => array( 'paragraph', 'cta', 'buttons', 'action' ),
        'viewport'   => array(
            'width'  => 720,
            'height' => 200,
        ),
        'content'    => '<!-- wp:paragraph {"style":{"color":{"text":"var(--pk-text)"},"fontSize":"1.125rem","lineHeight":"1.7"},"metadata":{"dxActionId":""}} -->
<p style="color:var(--pk-text);font-size:1.125rem;line-height:1.7;margin-bottom:1.5rem;">' . esc_html__( 'Ready to transform your business operations? Let\'s discuss how technology can help you improve efficiency, reduce costs, and scale with confidence.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"}} -->
<div style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;font-family:var(--pk-font-sans);font-size:0.9375rem;font-weight:600;text-decoration:none;border:2px solid transparent;border-radius:var(--pk-radius-md);padding:0.75rem 1.5rem;cursor:pointer;background-color:var(--pk-primary);color:var(--pk-text-inverse);border-color:var(--pk-primary);margin-right:0.5rem;"><a href="#contact" style="color:inherit;text-decoration:none;">' . esc_html__( 'Get a Free Consultation', 'paksa-it-solutions' ) . '</a></div><div style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;font-family:var(--pk-font-sans);font-size:0.9375rem;font-weight:600;text-decoration:none;border:2px solid var(--pk-primary);border-radius:var(--pk-radius-md);padding:0.75rem 1.5rem;cursor:pointer;background-color:transparent;color:var(--pk-primary);"><a href="#solutions" style="color:inherit;text-decoration:none;">' . esc_html__( 'Discuss Your Project', 'paksa-it-solutions' ) . '</a></div><!-- /wp:buttons -->',
    )
);
