<?php
/**
 * Paksa IT Solutions — Block Pattern: Section Intro
 *
 * Centered section header + lead paragraph + CTA.
 * Standard section introduction pattern.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/heading-paragraph-section',
    array(
        'title'      => __( 'Intro — Section', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-hero' ),
        'keywords'   => array( 'section', 'intro', 'cta', 'centered' ),
        'viewport'   => array(
            'width'  => 1280,
            'height' => 350,
        ),
        'content'    => '<!-- wp:group {"align":"wide","metadata":{"dxActionId":""}} -->
<div class="cta-global pk-animate-on-scroll" data-anim="fade-up"><!-- wp:h2 {"textAlign":"center","className":"pk-animate-on-scroll","metadata":{"dxActionId":""}} -->
<h2 class="pk-animate-on-scroll" style="text-align:center;color:var(--pk-text-inverse);margin-bottom:1rem;" data-anim="fade-up" data-delay="100">' . esc_html__( 'Ready to Transform Your Business?', 'paksa-it-solutions' ) . '</h2><!-- /wp:h2 -->

<!-- wp:paragraph {"textAlign":"center","className":"pk-animate-on-scroll","metadata":{"dxActionId":""}} -->
<p class="pk-animate-on-scroll" style="text-align:center;color:rgba(255,255,255,0.85);margin-bottom:2rem;max-width:600px;margin-left:auto;margin-right:auto;" data-anim="fade-up" data-delay="150">' . esc_html__( 'Let\'s discuss how technology can help you improve operations, reduce costs, and scale with confidence.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"className":"pk-animate-on-scroll"} -->
<div class="pk-animate-on-scroll" data-anim="fade-up" data-delay="200" style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;flex-wrap:wrap;"><!-- wp:button {"className":"btn btn-primary"} -->
<div class="wp-block-button"><a href="#contact" class="wp-element-button btn btn-primary">' . esc_html__( 'Get a Free Consultation', 'paksa-it-solutions' ) . '</a></div><!-- /wp:button -->

<!-- wp:button {"className":"btn btn-outline"} -->
<div class="wp-block-button"><a href="#solutions" class="wp-element-button btn btn-outline">' . esc_html__( 'Discuss Your Project', 'paksa-it-solutions' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->',
    )
);
