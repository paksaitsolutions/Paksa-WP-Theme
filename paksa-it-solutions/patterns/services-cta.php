<?php
/**
 * Paksa IT Solutions — Block Pattern: Services CTA
 *
 * Call-to-action section for services.
 * Gradient background with heading, description, and buttons.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/services-cta',
    array(
        'title'      => __( 'Services — CTA', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-services' ),
        'keywords'   => array( 'cta', 'call to action', 'contact', 'start' ),
        'viewport'   => array(
            'width'  => 1280,
            'height' => 300,
        ),
        'content'    => '<!-- wp:group {"className":"pk-svc-cta pk-animate-on-scroll","metadata":{"dxActionId":""}} -->
<div class="pk-svc-cta pk-animate-on-scroll" data-anim="fade-up"><h2>' . esc_html__( 'Ready to Transform Your Business?', 'paksa-it-solutions' ) . '</h2><p>' . esc_html__( 'Let\'s discuss how our technology solutions can help you achieve your business goals.', 'paksa-it-solutions' ) . '</p><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div style="display:inline-flex;align-items:center;justify-content:center;gap:0.5rem;flex-wrap:wrap;"><!-- wp:button {"className":"btn btn-primary"} -->
<div class="wp-block-button"><a href="#contact" class="wp-element-button btn btn-primary">' . esc_html__( 'Get a Free Consultation', 'paksa-it-solutions' ) . '</a></div><!-- /wp:button -->

<!-- wp:button {"className":"btn btn-outline"} -->
<div class="wp-block-button"><a href="#solutions" class="wp-element-button btn btn-outline">' . esc_html__( 'View All Services', 'paksa-it-solutions' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->',
    )
);
