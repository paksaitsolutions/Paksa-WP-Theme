<?php
/**
 * Paksa IT Solutions — Block Pattern: Paragraph Highlight
 *
 * Paragraph with accent background tint highlight.
 * For emphasis blocks, feature descriptions, and key takeaways.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/paragraph-highlight',
    array(
        'title'      => __( 'Paragraph — Highlight', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-paragraphs' ),
        'keywords'   => array( 'paragraph', 'highlight', 'accent', 'background' ),
        'viewport'   => array(
            'width'  => 720,
            'height' => 120,
        ),
        'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var(--pk-space-6)","right":"var(--pk-space-6)","bottom":"var(--pk-space-6)","left":"var(--pk-space-6)"}},"border":{"radius":"var(--pk-radius-lg)"},"backgroundColor":"bg-alt"}} -->
<div style="padding:1.5rem;border-radius:var(--pk-radius-lg);background-color:var(--pk-bg-alt);border:1px solid var(--pk-border);"><!-- wp:paragraph {"style":{"color":{"text":"var(--pk-text)"},"fontSize":"1rem","lineHeight":"1.7"},"metadata":{"dxActionId":""}} -->
<p style="color:var(--pk-text);font-size:1rem;line-height:1.7;">' . esc_html__( 'Our enterprise platform unifies your data, processes, and teams in one intelligent ecosystem — giving you real-time visibility and the confidence to make faster, better decisions.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="btn" style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;font-family:var(--pk-font-sans);font-size:0.9375rem;font-weight:600;text-decoration:none;border:2px solid transparent;border-radius:var(--pk-radius-md);padding:0.75rem 1.5rem;cursor:pointer;margin-top:1rem;background-color:var(--pk-primary);color:var(--pk-text-inverse);border-color:var(--pk-primary);"><a href="#contact" style="color:inherit;text-decoration:none;">' . esc_html__( 'Learn More', 'paksa-it-solutions' ) . '</a></div><!-- /wp:buttons --></div><!-- /wp:group -->',
    )
);
