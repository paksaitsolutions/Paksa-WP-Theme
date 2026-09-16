<?php
/**
 * Paksa IT Solutions — Block Pattern: Display Heading
 *
 * Large, dramatic display heading with eyebrow label.
 * For major page introductions and hero-style headings.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/heading-display',
    array(
        'title'      => __( 'Heading — Display', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-headings' ),
        'keywords'   => array( 'heading', 'display', 'large', 'hero', 'title' ),
        'viewport'   => array(
            'width'  => 1280,
            'height' => 300,
        ),
        'content'    => '<!-- wp:paragraph {"style":{"color":{"text":"var(--pk-accent)"}},"className":"eyebrow pk-animate-on-scroll","metadata":{"dxActionId":""}} -->
<p class="eyebrow pk-animate-on-scroll" style="color:var(--pk-accent);" data-anim="fade-up">' . esc_html__( 'Enterprise Technology Solutions', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"display pk-animate-on-scroll","style":{"typography":{"fontSize":"clamp(2.5rem, 5vw, 4rem)","lineHeight":"1.1"},"spacing":{"marginBottom":"1.5rem"}},"metadata":{"dxActionId":""}} -->
<h1 class="display pk-animate-on-scroll" style="font-size:clamp(2.5rem, 5vw, 4rem);line-height:1.1;margin-bottom:1.5rem;" data-anim="fade-up" data-delay="100">' . esc_html__( 'Technology That Moves Business Forward', 'paksa-it-solutions' ) . '</h1><!-- /wp:heading -->

<!-- wp:paragraph {"className":"body-large","style":{"color":{"text":"var(--pk-text-secondary)"}},"metadata":{"dxActionId":""}} -->
<p class="body-large" style="color:var(--pk-text-secondary);">' . esc_html__( 'Build smarter, operate better, grow with confidence.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->',
    )
);
