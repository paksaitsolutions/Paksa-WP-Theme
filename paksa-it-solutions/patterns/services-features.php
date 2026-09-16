<?php
/**
 * Paksa IT Solutions — Block Pattern: Services Features
 *
 * Feature list with icons in a two-column layout.
 * Ideal for highlighting key capabilities or differentiators.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/services-features',
    array(
        'title'      => __( 'Services — Features', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-services' ),
        'keywords'   => array( 'features', 'capabilities', 'list', 'checklist' ),
        'viewport'   => array(
            'width'  => 1280,
            'height' => 400,
        ),
        'content'    => '<!-- wp:group {"metadata":{"dxActionId":""}} -->
<div class="pk-animate-on-scroll" data-anim="fade-up"><!-- wp:heading {"level":2,"className":"pk-animate-on-scroll","style":{"typography":{"fontSize":"clamp(1.5rem, 3vw, 2.25rem)","lineHeight":"1.15"},"spacing":{"marginBottom":"1rem"}},"metadata":{"dxActionId":""}} -->
<h2 class="pk-animate-on-scroll" style="font-size:clamp(1.5rem, 3vw, 2.25rem);line-height:1.15;margin-bottom:1rem;" data-anim="fade-up" data-delay="0">' . esc_html__( 'Why Choose Us', 'paksa-it-solutions' ) . '</h2><!-- /wp:heading -->

<!-- wp:paragraph {"className":"body-large pk-animate-on-scroll","style":{"color":{"text":"var(--pk-text-secondary)"},"typography":{"fontSize":"1.125rem","lineHeight":"1.7"}},"metadata":{"dxActionId":""}} -->
<p class="body-large pk-animate-on-scroll" style="color:var(--pk-text-secondary);font-size:1.125rem;line-height:1.7;" data-anim="fade-up" data-delay="100">' . esc_html__( 'Technology expertise combined with business understanding.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-features pk-animate-on-scroll"} -->
<div class="pk-svc-features pk-animate-on-scroll" data-anim="fade-up" data-delay="200"><!-- wp:div {"className":"pk-svc-feature pk-animate-on-scroll"} -->
<div class="pk-svc-feature pk-animate-on-scroll" data-anim="fade-up" data-delay="0"><!-- wp:group {"className":"pk-svc-feature-icon"} -->
<div class="pk-svc-feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg></div><!-- /wp:group -->

<!-- wp:group -->
<div><h3 class="pk-svc-feature-title">' . esc_html__( 'Expert Team', 'paksa-it-solutions' ) . '</h3><p class="pk-svc-feature-desc">' . esc_html__( 'Senior developers, architects, and consultants with decades of combined experience.', 'paksa-it-solutions' ) . '</p></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-feature pk-animate-on-scroll"} -->
<div class="pk-svc-feature pk-animate-on-scroll" data-anim="fade-up" data-delay="100"><!-- wp:group {"className":"pk-svc-feature-icon"} -->
<div class="pk-svc-feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg></div><!-- /wp:group -->

<!-- wp:group -->
<div><h3 class="pk-svc-feature-title">' . esc_html__( 'Agile Methodology', 'paksa-it-solutions' ) . '</h3><p class="pk-svc-feature-desc">' . esc_html__( 'Iterative development with regular feedback loops and transparent progress tracking.', 'paksa-it-solutions' ) . '</p></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-feature pk-animate-on-scroll"} -->
<div class="pk-svc-feature pk-animate-on-scroll" data-anim="fade-up" data-delay="200"><!-- wp:group {"className":"pk-svc-feature-icon"} -->
<div class="pk-svc-feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg></div><!-- /wp:group -->

<!-- wp:group -->
<div><h3 class="pk-svc-feature-title">' . esc_html__( 'Scalable Solutions', 'paksa-it-solutions' ) . '</h3><p class="pk-svc-feature-desc">' . esc_html__( 'Architecture designed to grow with your business from startup to enterprise.', 'paksa-it-solutions' ) . '</p></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-feature pk-animate-on-scroll"} -->
<div class="pk-svc-feature pk-animate-on-scroll" data-anim="fade-up" data-delay="300"><!-- wp:group {"className":"pk-svc-feature-icon"} -->
<div class="pk-svc-feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg></div><!-- /wp:group -->

<!-- wp:group -->
<div><h3 class="pk-svc-feature-title">' . esc_html__( '24/7 Support', 'paksa-it-solutions' ) . '</h3><p class="pk-svc-feature-desc">' . esc_html__( 'Round-the-clock monitoring and support to keep your systems running smoothly.', 'paksa-it-solutions' ) . '</p></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-feature pk-animate-on-scroll"} -->
<div class="pk-svc-feature pk-animate-on-scroll" data-anim="fade-up" data-delay="400"><!-- wp:group {"className":"pk-svc-feature-icon"} -->
<div class="pk-svc-feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg></div><!-- /wp:group -->

<!-- wp:group -->
<div><h3 class="pk-svc-feature-title">' . esc_html__( 'Competitive Pricing', 'paksa-it-solutions' ) . '</h3><p class="pk-svc-feature-desc">' . esc_html__( 'Transparent pricing models with no hidden costs and flexible engagement terms.', 'paksa-it-solutions' ) . '</p></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-feature pk-animate-on-scroll"} -->
<div class="pk-svc-feature pk-animate-on-scroll" data-anim="fade-up" data-delay="500"><!-- wp:group {"className":"pk-svc-feature-icon"} -->
<div class="pk-svc-feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg></div><!-- /wp:group -->

<!-- wp:group -->
<div><h3 class="pk-svc-feature-title">' . esc_html__( 'Proven Track Record', 'paksa-it-solutions' ) . '</h3><p class="pk-svc-feature-desc">' . esc_html__( 'Successfully delivered 100+ projects across multiple industries and use cases.', 'paksa-it-solutions' ) . '</p></div><!-- /wp:group --></div><!-- /wp:group --></div><!-- /wp:group -->',
    )
);
