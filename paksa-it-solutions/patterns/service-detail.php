<?php
/**
 * Paksa IT Solutions — Block Pattern: Service Detail
 *
 * Single service showcase with icon, features list, and CTA.
 * Reusable for any individual service page.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/service-detail',
    array(
        'title'      => __( 'Service — Detail', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-services' ),
        'keywords'   => array( 'service', 'detail', 'showcase', 'single' ),
        'viewport'   => array(
            'width'  => 1280,
            'height'  => 700,
        ),
        'content'    => '<!-- wp:group {"metadata":{"dxActionId":""}} -->
<div class="pk-animate-on-scroll" data-anim="fade-up"><!-- wp:group {"className":"pk-svc-card-icon"} -->
<div class="pk-svc-card-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":1,"className":"display pk-animate-on-scroll","style":{"typography":{"fontSize":"clamp(2rem, 4vw, 3rem)","lineHeight":"1.1"},"spacing":{"marginBottom":"1rem"}},"metadata":{"dxActionId":""}} -->
<h1 class="display pk-animate-on-scroll" style="font-size:clamp(2rem, 4vw, 3rem);line-height:1.1;margin-bottom:1rem;" data-anim="fade-up" data-delay="100">' . esc_html__( 'Enterprise Software Development', 'paksa-it-solutions' ) . '</h1><!-- /wp:heading -->

<!-- wp:paragraph {"className":"body-large pk-animate-on-scroll","style":{"color":{"text":"var(--pk-text-secondary)"},"typography":{"fontSize":"1.125rem","lineHeight":"1.7"}},"metadata":{"dxActionId":""}} -->
<p class="body-large pk-animate-on-scroll" style="color:var(--pk-text-secondary);font-size:1.125rem;line-height:1.7;" data-anim="fade-up" data-delay="200">' . esc_html__( 'Custom-built software solutions that streamline operations, automate workflows, and scale with your business. From initial concept to deployment and beyond.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"left"},"className":"pk-hero-actions pk-animate-on-scroll"} -->
<div class="pk-hero-actions pk-animate-on-scroll" data-anim="fade-up" data-delay="300"><!-- wp:button {"className":"btn btn-primary"} -->
<div class="wp-block-button"><a href="#contact" class="wp-element-button btn btn-primary">' . esc_html__( 'Start a Project', 'paksa-it-solutions' ) . '</a></div><!-- /wp:button -->

<!-- wp:button {"className":"btn btn-outline"} -->
<div class="wp-block-button"><a href="#solutions" class="wp-element-button btn btn-outline">' . esc_html__( 'View Case Studies', 'paksa-it-solutions' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->

<!-- wp:heading {"level":2,"style":{"typography":{"fontSize":"clamp(1.5rem, 3vw, 2.25rem)","lineHeight":"1.15"},"spacing":{"marginTop":"4rem","marginBottom":"1rem"}},"metadata":{"dxActionId":""}} -->
<h2 style="font-size:clamp(1.5rem, 3vw, 2.25rem);line-height:1.15;margin-top:4rem;margin-bottom:1rem;" data-anim="fade-up" data-delay="400">' . esc_html__( 'What We Deliver', 'paksa-it-solutions' ) . '</h2><!-- /wp:heading -->

<!-- wp:group {"className":"pk-svc-features pk-animate-on-scroll"} -->
<div class="pk-svc-features pk-animate-on-scroll" data-anim="fade-up" data-delay="500"><!-- wp:div {"className":"pk-svc-feature pk-animate-on-scroll"} -->
<div class="pk-svc-feature pk-animate-on-scroll" data-anim="fade-up" data-delay="0"><!-- wp:group {"className":"pk-svc-feature-icon"} -->
<div class="pk-svc-feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg></div><!-- /wp:group -->

<!-- wp:group -->
<div><h3 class="pk-svc-feature-title">' . esc_html__( 'Full-Stack Development', 'paksa-it-solutions' ) . '</h3><p class="pk-svc-feature-desc">' . esc_html__( 'Frontend, backend, database, and API integration — all in one team.', 'paksa-it-solutions' ) . '</p></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-feature pk-animate-on-scroll"} -->
<div class="pk-svc-feature pk-animate-on-scroll" data-anim="fade-up" data-delay="100"><!-- wp:group {"className":"pk-svc-feature-icon"} -->
<div class="pk-svc-feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg></div><!-- /wp:group -->

<!-- wp:group -->
<div><h3 class="pk-svc-feature-title">' . esc_html__( 'UI/UX Design', 'paksa-it-solutions' ) . '</h3><p class="pk-svc-feature-desc">' . esc_html__( 'User-centered interfaces designed for engagement and conversion.', 'paksa-it-solutions' ) . '</p></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-feature pk-animate-on-scroll"} -->
<div class="pk-svc-feature pk-animate-on-scroll" data-anim="fade-up" data-delay="200"><!-- wp:group {"className":"pk-svc-feature-icon"} -->
<div class="pk-svc-feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg></div><!-- /wp:group -->

<!-- wp:group -->
<div><h3 class="pk-svc-feature-title">' . esc_html__( 'QA &amp; Testing', 'paksa-it-solutions' ) . '</h3><p class="pk-svc-feature-desc">' . esc_html__( 'Automated and manual testing to ensure rock-solid quality.', 'paksa-it-solutions' ) . '</p></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-feature pk-animate-on-scroll"} -->
<div class="pk-svc-feature pk-animate-on-scroll" data-anim="fade-up" data-delay="300"><!-- wp:group {"className":"pk-svc-feature-icon"} -->
<div class="pk-svc-feature-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg></div><!-- /wp:group -->

<!-- wp:group -->
<div><h3 class="pk-svc-feature-title">' . esc_html__( 'Maintenance &amp; Support', 'paksa-it-solutions' ) . '</h3><p class="pk-svc-feature-desc">' . esc_html__( 'Ongoing updates, monitoring, and feature enhancements post-launch.', 'paksa-it-solutions' ) . '</p></div><!-- /wp:group --></div><!-- /wp:group --></div><!-- /wp:group -->',
    )
);
