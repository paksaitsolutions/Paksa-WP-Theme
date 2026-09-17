<?php
/**
 * Paksa IT Solutions — Block Pattern: Hero Minimal
 *
 * Text-only hero with no visual element. Reduced padding and smaller heading.
 * Best for inner pages, content-focused layouts, or when a clean minimal
 * introduction is preferred.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/hero-minimal',
    array(
        'title'      => __( 'Hero Minimal', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-hero' ),
        'keywords'   => array( 'hero', 'minimal', 'text-only', 'simple' ),
        'viewport'   => array(
            'width'  => 1280,
            'height' => 400,
        ),
        'content'    => '<!-- wp:group {"className":"pk-hero pk-hero-minimal","align":"wide"} -->
<div class="pk-hero pk-hero-minimal"><div class="container"><div class="pk-hero-inner" style="display:grid;grid-template-columns:1fr"><div class="pk-hero-content" style="max-width:720px"><!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em","fontSize":"0.75rem","fontWeight":"600"}},"textColor":"accent","className":"eyebrow pk-animate-on-scroll","metadata":{"dxActionId":""}} -->
<p class="eyebrow pk-animate-on-scroll" style="color:var(--pk-accent);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;" data-anim="fade-up">' . esc_html__( 'Enterprise Technology Solutions', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"pk-hero-heading pk-animate-on-scroll","style":{"typography":{"fontSize":"clamp(1.75rem, 3vw, 2.5rem)","lineHeight":"1.1"},"spacing":{"marginBottom":"1rem"}}} -->
<h1 class="pk-hero-heading pk-animate-on-scroll" style="font-size:clamp(1.75rem, 3vw, 2.5rem);line-height:1.1;margin-bottom:1rem;" data-anim="fade-up" data-delay="100">' . esc_html__( 'Technology That Moves Business Forward', 'paksa-it-solutions' ) . '</h1><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-hero-description body-large pk-animate-on-scroll","style":{"typography":{"fontSize":"1.125rem","lineHeight":"1.7"},"fontWeight":{"normal"}},"textColor":"secondary","metadata":{"dxActionId":""}} -->
<p class="pk-hero-description body-large pk-animate-on-scroll" style="color:var(--pk-text-secondary);font-size:1.125rem;line-height:1.7;font-weight:400;" data-anim="fade-up" data-delay="200">' . esc_html__( 'Paksa IT Solutions builds enterprise software, AI-powered solutions and intelligent digital systems designed around real business challenges.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:buttons {"className":"pk-hero-actions pk-animate-on-scroll","layout":{"type":"flex","justifyContent":"left"}} -->
<div class="pk-hero-actions pk-animate-on-scroll" data-anim="fade-up" data-delay="250"><!-- wp:button {"className":"btn btn-primary"} -->
<div class="wp-block-button"><a href="#contact" class="wp-element-button btn btn-primary">' . esc_html__( 'Get a Free Consultation', 'paksa-it-solutions' ) . '</a></div><!-- /wp:button -->

<!-- wp:button {"className":"btn btn-outline"} -->
<div class="wp-block-button"><a href="#solutions" class="wp-element-button btn btn-outline">' . esc_html__( 'Explore Our Solutions', 'paksa-it-solutions' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div></div><!-- /wp:group -->',
    )
);
