<?php
/**
 * Paksa IT Solutions — Block Pattern: Section Heading
 *
 * Centered section header with eyebrow, heading, and description.
 * Standard pattern for content sections.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/heading-section',
    array(
        'title'      => __( 'Heading — Section', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-headings' ),
        'keywords'   => array( 'heading', 'section', 'centered', 'header' ),
        'viewport'   => array(
            'width'  => 1280,
            'height' => 250,
        ),
        'content'    => '<!-- wp:paragraph {"style":{"color":{"text":"var(--pk-accent)"},"typography":{"fontSize":"0.75rem","fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.08em"}},"className":"eyebrow pk-animate-on-scroll","metadata":{"dxActionId":""}} -->
<p class="eyebrow pk-animate-on-scroll" style="color:var(--pk-accent);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;" data-anim="fade-up">' . esc_html__( 'Our Expertise', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"className":"pk-animate-on-scroll","style":{"typography":{"fontSize":"clamp(1.5rem, 3vw, 2.25rem)","lineHeight":"1.15"},"spacing":{"marginBottom":"1rem"}},"metadata":{"dxActionId":""}} -->
<h2 class="pk-animate-on-scroll" style="font-size:clamp(1.5rem, 3vw, 2.25rem);line-height:1.15;margin-bottom:1rem;" data-anim="fade-up" data-delay="100">' . esc_html__( 'Enterprise Solutions Built for Your Business', 'paksa-it-solutions' ) . '</h2><!-- /wp:heading -->

<!-- wp:paragraph {"className":"body-large pk-animate-on-scroll","style":{"color":{"text":"var(--pk-text-secondary)"},"typography":{"fontSize":"1.125rem","lineHeight":"1.7"}},"metadata":{"dxActionId":""}} -->
<p class="body-large pk-animate-on-scroll" style="color:var(--pk-text-secondary);font-size:1.125rem;line-height:1.7;" data-anim="fade-up" data-delay="150">' . esc_html__( 'Purpose-built software, AI-powered systems and intelligent digital infrastructure designed around the way your business actually works.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->',
    )
);
