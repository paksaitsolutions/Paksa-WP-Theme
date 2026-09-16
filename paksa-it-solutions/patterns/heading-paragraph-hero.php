<?php
/**
 * Paksa IT Solutions — Block Pattern: Hero Intro
 *
 * Eyebrow + Display heading + Lead paragraph + CTA buttons.
 * Full hero introduction for landing pages.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/heading-paragraph-hero',
    array(
        'title'      => __( 'Intro — Hero', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-hero' ),
        'keywords'   => array( 'intro', 'hero', 'heading', 'paragraph', 'cta' ),
        'viewport'   => array(
            'width'  => 1280,
            'height' => 400,
        ),
        'content'    => '<!-- wp:paragraph {"style":{"color":{"text":"var(--pk-accent)"},"typography":{"fontSize":"0.75rem","fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.08em"}},"className":"eyebrow pk-animate-on-scroll","metadata":{"dxActionId":""}} -->
<p class="eyebrow pk-animate-on-scroll" style="color:var(--pk-accent);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;" data-anim="fade-up">' . esc_html__( 'Enterprise Technology Solutions', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"display pk-animate-on-scroll","style":{"typography":{"fontSize":"clamp(2.5rem, 5vw, 4rem)","lineHeight":"1.1"},"spacing":{"marginBottom":"1.5rem"}},"metadata":{"dxActionId":""}} -->
<h1 class="display pk-animate-on-scroll" style="font-size:clamp(2.5rem, 5vw, 4rem);line-height:1.1;margin-bottom:1.5rem;" data-anim="fade-up" data-delay="100">' . esc_html__( 'Technology That Moves Business Forward', 'paksa-it-solutions' ) . '</h1><!-- /wp:heading -->

<!-- wp:paragraph {"className":"body-large pk-animate-on-scroll","style":{"color":{"text":"var(--pk-text-secondary)"},"typography":{"fontSize":"1.125rem","lineHeight":"1.7"},"maxWidth":"600px"},"metadata":{"dxActionId":""}} -->
<p class="body-large pk-animate-on-scroll" style="color:var(--pk-text-secondary);font-size:1.125rem;line-height:1.7;max-width:600px;" data-anim="fade-up" data-delay="200">' . esc_html__( 'Build smarter, operate better, grow with confidence.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"},"className":"pk-hero-actions pk-animate-on-scroll"} -->
<div class="pk-hero-actions pk-animate-on-scroll" data-anim="fade-up" data-delay="250"><!-- wp:button {"className":"btn btn-primary"} -->
<div class="wp-block-button"><a href="#contact" class="wp-element-button btn btn-primary">' . esc_html__( 'Get a Free Consultation', 'paksa-it-solutions' ) . '</a></div><!-- /wp:button -->

<!-- wp:button {"className":"btn btn-outline"} -->
<div class="wp-block-button"><a href="#solutions" class="wp-element-button btn btn-outline">' . esc_html__( 'Explore Our Solutions', 'paksa-it-solutions' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons -->',
    )
);
