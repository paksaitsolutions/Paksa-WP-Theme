<?php
/**
 * Paksa IT Solutions — Block Pattern: Paragraph Callout
 *
 * Callout paragraph with accent left border.
 * For highlighting key information, quotes, or important notes.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/paragraph-callout',
    array(
        'title'      => __( 'Paragraph — Callout', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-paragraphs' ),
        'keywords'   => array( 'paragraph', 'callout', 'highlight', 'quote', 'note' ),
        'viewport'   => array(
            'width'  => 720,
            'height' => 120,
        ),
        'content'    => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"var(--pk-space-4)","right":"var(--pk-space-6)","bottom":"var(--pk-space-4)","left":"var(--pk-space-6)"}},"border":{"radius":"var(--pk-radius-md)"},"backgroundColor":"accent-light"}} -->
<div class="pk-contact-form" style="padding:1rem 1.5rem;border-radius:var(--pk-radius-md);background-color:var(--pk-accent-light);border-left:4px solid var(--pk-accent);"><!-- wp:paragraph {"style":{"color":{"text":"var(--pk-text)"},"fontSize":"1.0625rem","lineHeight":"1.7","fontWeight":{"normal"}},"metadata":{"dxActionId":""}} -->
<p style="color:var(--pk-text);font-size:1.0625rem;line-height:1.7;font-weight:400;">' . esc_html__( 'We turn these challenges into connected digital systems. Our approach combines enterprise-grade technology with deep domain expertise to deliver solutions that scale with your business.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
    )
);
