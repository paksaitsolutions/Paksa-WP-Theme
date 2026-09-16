<?php
/**
 * Paksa IT Solutions — Block Pattern: Services Stats
 *
 * Statistics display with icons, values, and labels.
 * For showcasing achievements, metrics, and social proof.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/services-stats',
    array(
        'title'      => __( 'Services — Stats', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-services' ),
        'keywords'   => array( 'stats', 'numbers', 'metrics', 'statistics', 'counters' ),
        'viewport'   => array(
            'width'  => 1280,
            'height' => 300,
        ),
        'content'    => '<!-- wp:group {"className":"section-dark pk-svc-stats","metadata":{"dxActionId":""}} -->
<div class="section-dark pk-svc-stats pk-animate-on-scroll" data-anim="fade-up"><!-- wp:div {"className":"pk-svc-stat pk-animate-on-scroll"} -->
<div class="pk-svc-stat pk-animate-on-scroll" data-anim="fade-up" data-delay="0"><!-- wp:group {"className":"pk-svc-stat-icon"} -->
<div class="pk-svc-stat-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div><!-- /wp:group -->

<!-- wp:group -->
<div><span class="pk-svc-stat-value">' . esc_html__( '100+', 'paksa-it-solutions' ) . '</span><span class="pk-svc-stat-label">' . esc_html__( 'Projects Delivered', 'paksa-it-solutions' ) . '</span></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-stat pk-animate-on-scroll"} -->
<div class="pk-svc-stat pk-animate-on-scroll" data-anim="fade-up" data-delay="100"><!-- wp:group {"className":"pk-svc-stat-icon"} -->
<div class="pk-svc-stat-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div><!-- /wp:group -->

<!-- wp:group -->
<div><span class="pk-svc-stat-value">' . esc_html__( '50+', 'paksa-it-solutions' ) . '</span><span class="pk-svc-stat-label">' . esc_html__( 'Happy Clients', 'paksa-it-solutions' ) . '</span></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-stat pk-animate-on-scroll"} -->
<div class="pk-svc-stat pk-animate-on-scroll" data-anim="fade-up" data-delay="200"><!-- wp:group {"className":"pk-svc-stat-icon"} -->
<div class="pk-svc-stat-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div><!-- /wp:group -->

<!-- wp:group -->
<div><span class="pk-svc-stat-value">' . esc_html__( '15+', 'paksa-it-solutions' ) . '</span><span class="pk-svc-stat-label">' . esc_html__( 'Years Experience', 'paksa-it-solutions' ) . '</span></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:div {"className":"pk-svc-stat pk-animate-on-scroll"} -->
<div class="pk-svc-stat pk-animate-on-scroll" data-anim="fade-up" data-delay="300"><!-- wp:group {"className":"pk-svc-stat-icon"} -->
<div class="pk-svc-stat-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg></div><!-- /wp:group -->

<!-- wp:group -->
<div><span class="pk-svc-stat-value">' . esc_html__( '24/7', 'paksa-it-solutions' ) . '</span><span class="pk-svc-stat-label">' . esc_html__( 'Support Available', 'paksa-it-solutions' ) . '</span></div><!-- /wp:group --></div><!-- /wp:group --></div><!-- /wp:group -->',
    )
);
