<?php
/**
 * Paksa IT Solutions — Block Pattern: Services Grid
 *
 * Grid of service cards with icons, titles, descriptions, and links.
 * Fully reusable: swap icons, text, and links for any industry.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/services-grid',
    array(
        'title'      => __( 'Services — Grid', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-services' ),
        'keywords'   => array( 'services', 'grid', 'cards', 'icons', 'grid' ),
        'viewport'   => array(
            'width'  => 1280,
            'height' => 700,
        ),
        'content'    => '<!-- wp:group {"metadata":{"dxActionId":""}} -->
<div class="pk-animate-on-scroll" data-anim="fade-up"><!-- wp:heading {"level":2,"className":"pk-animate-on-scroll","style":{"typography":{"fontSize":"clamp(1.5rem, 3vw, 2.25rem)","lineHeight":"1.15"},"spacing":{"marginBottom":"1rem"}},"metadata":{"dxActionId":""}} -->
<h2 class="pk-animate-on-scroll" style="font-size:clamp(1.5rem, 3vw, 2.25rem);line-height:1.15;margin-bottom:1rem;" data-anim="fade-up" data-delay="0">' . esc_html__( 'Our Services', 'paksa-it-solutions' ) . '</h2><!-- /wp:heading -->

<!-- wp:paragraph {"className":"body-large pk-animate-on-scroll","style":{"color":{"text":"var(--pk-text-secondary)"},"typography":{"fontSize":"1.125rem","lineHeight":"1.7"}},"metadata":{"dxActionId":""}} -->
<p class="body-large pk-animate-on-scroll" style="color:var(--pk-text-secondary);font-size:1.125rem;line-height:1.7;" data-anim="fade-up" data-delay="100">' . esc_html__( 'Comprehensive technology solutions tailored to your business needs.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-grid pk-animate-on-scroll","metadata":{"dxActionId":""}} -->
<div class="pk-svc-grid pk-animate-on-scroll" data-anim="fade-up" data-delay="200"><!-- wp:group {"className":"pk-svc-card"} -->
<article class="pk-svc-card pk-animate-on-scroll" data-anim="fade-up" data-delay="0"><!-- wp:group {"className":"pk-svc-card-icon"} -->
<div class="pk-svc-card-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-card-title"} -->
<h3 class="pk-svc-card-title">' . esc_html__( 'Enterprise Software', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-card-desc"} -->
<p class="pk-svc-card-desc">' . esc_html__( 'Custom-built software solutions that streamline operations, automate workflows, and scale with your business.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:html -->
<a href="#contact" class="pk-svc-card-link">
    Learn More
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
</a><!-- /wp:html --></article><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-card"} -->
<article class="pk-svc-card pk-animate-on-scroll" data-anim="fade-up" data-delay="100"><!-- wp:group {"className":"pk-svc-card-icon"} -->
<div class="pk-svc-card-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="3"></circle><path d="M12 1v6m0 6v6m11-7h-6m-6 0H1m17.5-7.5L15 12m-6 0L4.5 7.5m13 9L15 12m-6 0l-2.5-4.5"></path></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-card-title"} -->
<h3 class="pk-svc-card-title">' . esc_html__( 'AI &amp; Machine Learning', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-card-desc"} -->
<p class="pk-svc-card-desc">' . esc_html__( 'Intelligent automation, predictive analytics, and AI-powered insights to drive smarter decisions.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:html -->
<a href="#contact" class="pk-svc-card-link">
    Learn More
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
</a><!-- /wp:html --></article><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-card"} -->
<article class="pk-svc-card pk-animate-on-scroll" data-anim="fade-up" data-delay="200"><!-- wp:group {"className":"pk-svc-card-icon"} -->
<div class="pk-svc-card-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-card-title"} -->
<h3 class="pk-svc-card-title">' . esc_html__( 'Business Intelligence', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-card-desc"} -->
<p class="pk-svc-card-desc">' . esc_html__( 'Data visualization, dashboards, and reporting tools that transform raw data into actionable insights.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:html -->
<a href="#contact" class="pk-svc-card-link">
    Learn More
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
</a><!-- /wp:html --></article><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-card"} -->
<article class="pk-svc-card pk-animate-on-scroll" data-anim="fade-up" data-delay="300"><!-- wp:group {"className":"pk-svc-card-icon"} -->
<div class="pk-svc-card-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-card-title"} -->
<h3 class="pk-svc-card-title">' . esc_html__( 'Cloud Solutions', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-card-desc"} -->
<p class="pk-svc-card-desc">' . esc_html__( 'Cloud infrastructure, migration, and optimization for scalable, reliable, and cost-effective operations.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:html -->
<a href="#contact" class="pk-svc-card-link">
    Learn More
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
</a><!-- /wp:html --></article><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-card"} -->
<article class="pk-svc-card pk-animate-on-scroll" data-anim="fade-up" data-delay="400"><!-- wp:group {"className":"pk-svc-card-icon"} -->
<div class="pk-svc-card-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-card-title"} -->
<h3 class="pk-svc-card-title">' . esc_html__( 'System Integration', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-card-desc"} -->
<p class="pk-svc-card-desc">' . esc_html__( 'Seamless integration of disparate systems, APIs, and data sources for a unified technology ecosystem.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:html -->
<a href="#contact" class="pk-svc-card-link">
    Learn More
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
</a><!-- /wp:html --></article><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-card"} -->
<article class="pk-svc-card pk-animate-on-scroll" data-anim="fade-up" data-delay="500"><!-- wp:group {"className":"pk-svc-card-icon"} -->
<div class="pk-svc-card-icon"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg></div><!-- /wp:group -->

<!-- wp:heading {"level":3,"className":"pk-svc-card-title"} -->
<h3 class="pk-svc-card-title">' . esc_html__( 'E-Commerce', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-svc-card-desc"} -->
<p class="pk-svc-card-desc">' . esc_html__( 'End-to-end e-commerce platforms with secure payments, inventory management, and customer experience optimization.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:html -->
<a href="#contact" class="pk-svc-card-link">
    Learn More
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
</a><!-- /wp:html --></article><!-- /wp:group --></div><!-- /wp:group -->',
    )
);
