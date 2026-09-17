<?php
/**
 * Paksa IT Solutions — Block Pattern: Services Category Grid
 *
 * 4-column card grid showing service categories with icons and counts.
 * Reusable for any service-based business.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/services-categories-grid',
    array(
        'title'      => __( 'Services — Category Grid', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-services' ),
        'keywords'   => array( 'categories', 'grid', '4 column' ),
        'viewport'   => array(
            'width'  => 1280,
            'height' => 500,
        ),
        'content'    => '<!-- wp:group {"metadata":{"dxActionId":""}} -->
<div class="pk-animate-on-scroll" data-anim="fade-up"><!-- wp:heading {"level":2,"className":"pk-animate-on-scroll","style":{"typography":{"fontSize":"clamp(1.5rem, 3vw, 2.25rem)","lineHeight":"1.15"},"spacing":{"marginBottom":"1rem"}},"metadata":{"dxActionId":""}} -->
<h2 class="pk-animate-on-scroll" style="font-size:clamp(1.5rem, 3vw, 2.25rem);line-height:1.15;margin-bottom:1rem;" data-anim="fade-up" data-delay="0">' . esc_html__( 'Our Expertise', 'paksa-it-solutions' ) . '</h2><!-- /wp:heading -->

<!-- wp:paragraph {"className":"body-large pk-animate-on-scroll","style":{"color":{"text":"var(--pk-text-secondary)"},"typography":{"fontSize":"1.125rem","lineHeight":"1.7"}},"metadata":{"dxActionId":""}} -->
<p class="body-large pk-animate-on-scroll" style="color:var(--pk-text-secondary);font-size:1.125rem;line-height:1.7;" data-anim="fade-up" data-delay="100">' . esc_html__( 'Technology expertise across key business domains.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-grid pk-svc-grid-4 pk-animate-on-scroll"} -->
<div class="pk-svc-grid pk-svc-grid-4 pk-animate-on-scroll" data-anim="fade-up" data-delay="200"><!-- wp:group {"className":"pk-svc-category pk-animate-on-scroll"} -->
<div class="pk-svc-category pk-animate-on-scroll" data-anim="fade-up" data-delay="0"><!-- wp:group {"className":"pk-svc-category-icon"} -->
<div class="pk-svc-category-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-category-title"} -->
<h3 class="pk-svc-category-title">' . esc_html__( 'Enterprise Software', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-category-desc"} -->
<p class="pk-svc-category-desc">' . esc_html__( 'Custom software for your business processes.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:html -->
<span class="pk-svc-category-count">24</span><!-- /wp:html --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-category pk-animate-on-scroll"} -->
<div class="pk-svc-category pk-animate-on-scroll" data-anim="fade-up" data-delay="100"><!-- wp:group {"className":"pk-svc-category-icon"} -->
<div class="pk-svc-category-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="3"></circle><path d="M12 1v6m0 6v6m11-7h-6m-6 0H1m17.5-7.5L15 12m-6 0L4.5 7.5m13 9L15 12m-6 0l-2.5-4.5"></path></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-category-title"} -->
<h3 class="pk-svc-category-title">' . esc_html__( 'AI &amp; ML', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-category-desc"} -->
<p class="pk-svc-category-desc">' . esc_html__( 'Intelligent automation and predictive analytics.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:html -->
<span class="pk-svc-category-count">18</span><!-- /wp:html --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-category pk-animate-on-scroll"} -->
<div class="pk-svc-category pk-animate-on-scroll" data-anim="fade-up" data-delay="200"><!-- wp:group {"className":"pk-svc-category-icon"} -->
<div class="pk-svc-category-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-category-title"} -->
<h3 class="pk-svc-category-title">' . esc_html__( 'Cloud', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-category-desc"} -->
<p class="pk-svc-category-desc">' . esc_html__( 'Scalable cloud infrastructure and DevOps.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:html -->
<span class="pk-svc-category-count">12</span><!-- /wp:html --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-category pk-animate-on-scroll"} -->
<div class="pk-svc-category pk-animate-on-scroll" data-anim="fade-up" data-delay="300"><!-- wp:group {"className":"pk-svc-category-icon"} -->
<div class="pk-svc-category-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-category-title"} -->
<h3 class="pk-svc-category-title">' . esc_html__( 'Integration', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-category-desc"} -->
<p class="pk-svc-category-desc">' . esc_html__( 'Connect your systems and data seamlessly.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:html -->
<span class="pk-svc-category-count">16</span><!-- /wp:html --></div><!-- /wp:group --></div><!-- /wp:group -->',
    )
);
