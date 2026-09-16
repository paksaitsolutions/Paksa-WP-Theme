<?php
/**
 * Paksa IT Solutions — Block Pattern: Services Process
 *
 * Step-by-step process display with icons, numbers, and descriptions.
 * Reusable for any service-based business showing their methodology.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/services-process',
    array(
        'title'      => __( 'Services — Process', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-services' ),
        'keywords'   => array( 'process', 'steps', 'methodology', 'workflow', 'how we work' ),
        'viewport'   => array(
            'width'  => 1280,
            'height' => 600,
        ),
        'content'    => '<!-- wp:group {"metadata":{"dxActionId":""}} -->
<div class="pk-animate-on-scroll" data-anim="fade-up"><!-- wp:heading {"level":2,"className":"pk-animate-on-scroll","style":{"typography":{"fontSize":"clamp(1.5rem, 3vw, 2.25rem)","lineHeight":"1.15"},"spacing":{"marginBottom":"1rem"}},"metadata":{"dxActionId":""}} -->
<h2 class="pk-animate-on-scroll" style="font-size:clamp(1.5rem, 3vw, 2.25rem);line-height:1.15;margin-bottom:1rem;" data-anim="fade-up" data-delay="0">' . esc_html__( 'How We Work', 'paksa-it-solutions' ) . '</h2><!-- /wp:heading -->

<!-- wp:paragraph {"className":"body-large pk-animate-on-scroll","style":{"color":{"text":"var(--pk-text-secondary)"},"typography":{"fontSize":"1.125rem","lineHeight":"1.7"}},"metadata":{"dxActionId":""}} -->
<p class="body-large pk-animate-on-scroll" style="color:var(--pk-text-secondary);font-size:1.125rem;line-height:1.7;" data-anim="fade-up" data-delay="100">' . esc_html__( 'A structured approach that delivers results at every stage.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-process-steps pk-animate-on-scroll"} -->
<div class="pk-svc-process-steps pk-animate-on-scroll" data-anim="fade-up" data-delay="200"><!-- wp:div {"className":"pk-svc-step pk-animate-on-scroll"} -->
<div class="pk-svc-step pk-animate-on-scroll" data-anim="fade-up" data-delay="0"><!-- wp:group {"className":"pk-svc-step-icon"} -->
<div class="pk-svc-step-icon"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-step-title"} -->
<h3 class="pk-svc-step-title">' . esc_html__( 'Discover', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-step-desc"} -->
<p class="pk-svc-step-desc">' . esc_html__( 'Understand the business, workflows, data requirements and operational context.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-step pk-animate-on-scroll"} -->
<div class="pk-svc-step pk-animate-on-scroll" data-anim="fade-up" data-delay="100"><!-- wp:group {"className":"pk-svc-step-icon"} -->
<div class="pk-svc-step-icon"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 19l7-7 3 3-7 7-3-3z"></path><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path><path d="M2 2l7.586 7.586"></path><circle cx="11" cy="11" r="2"></circle></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-step-title"} -->
<h3 class="pk-svc-step-title">' . esc_html__( 'Design', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-step-desc"} -->
<p class="pk-svc-step-desc">' . esc_html__( 'Define the solution architecture, system design and implementation strategy.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-step pk-animate-on-scroll"} -->
<div class="pk-svc-step pk-animate-on-scroll" data-anim="fade-up" data-delay="200"><!-- wp:group {"className":"pk-svc-step-icon"} -->
<div class="pk-svc-step-icon"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-step-title"} -->
<h3 class="pk-svc-step-title">' . esc_html__( 'Build', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-step-desc"} -->
<p class="pk-svc-step-desc">' . esc_html__( 'Develop the software, integrations and data layers with quality as a core requirement.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-step pk-animate-on-scroll"} -->
<div class="pk-svc-step pk-animate-on-scroll" data-anim="fade-up" data-delay="300"><!-- wp:group {"className":"pk-svc-step-icon"} -->
<div class="pk-svc-step-icon"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-step-title"} -->
<h3 class="pk-svc-step-title">' . esc_html__( 'Deploy', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-step-desc"} -->
<p class="pk-svc-step-desc">' . esc_html__( 'Test, integrate and deploy with structured handover, training and go-live support.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-step pk-animate-on-scroll"} -->
<div class="pk-svc-step pk-animate-on-scroll" data-anim="fade-up" data-delay="400"><!-- wp:group {"className":"pk-svc-step-icon"} -->
<div class="pk-svc-step-icon"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-step-title"} -->
<h3 class="pk-svc-step-title">' . esc_html__( 'Evolve', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-step-desc"} -->
<p class="pk-svc-step-desc">' . esc_html__( 'Continuously improve the platform as business needs change and new opportunities emerge.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group -->',
    )
);
