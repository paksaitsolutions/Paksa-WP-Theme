<?php
/**
 * Paksa IT Solutions — Block Pattern: Services Tabs
 *
 * Tabbed interface for service categories.
 * Each tab shows service details with a list of items.
 * Fully reusable — change tab names, items, and icons.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/services-tabs',
    array(
        'title'      => __( 'Services — Tabs', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-services' ),
        'keywords'   => array( 'services', 'tabs', 'categories', 'toggle' ),
        'viewport'   => array(
            'width'  => 1280,
            'height' => 500,
        ),
        'content'    => '<!-- wp:group {"metadata":{"dxActionId":""}} -->
<div class="pk-animate-on-scroll" data-anim="fade-up"><!-- wp:heading {"level":2,"className":"pk-animate-on-scroll","style":{"typography":{"fontSize":"clamp(1.5rem, 3vw, 2.25rem)","lineHeight":"1.15"},"spacing":{"marginBottom":"1rem"}},"metadata":{"dxActionId":""}} -->
<h2 class="pk-animate-on-scroll" style="font-size:clamp(1.5rem, 3vw, 2.25rem);line-height:1.15;margin-bottom:1rem;" data-anim="fade-up" data-delay="0">' . esc_html__( 'Services', 'paksa-it-solutions' ) . '</h2><!-- /wp:heading -->

<!-- wp:paragraph {"className":"body-large pk-animate-on-scroll","style":{"color":{"text":"var(--pk-text-secondary)"},"typography":{"fontSize":"1.125rem","lineHeight":"1.7"}},"metadata":{"dxActionId":""}} -->
<p class="body-large pk-animate-on-scroll" style="color:var(--pk-text-secondary);font-size:1.125rem;line-height:1.7;" data-anim="fade-up" data-delay="100">' . esc_html__( 'Explore our technology expertise across key areas.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-tabs pk-animate-on-scroll"} -->
<div class="pk-svc-tabs pk-animate-on-scroll" data-anim="fade-up" data-delay="200"><div class="pk-svc-tabs-nav" role="tablist" aria-label="' . esc_attr__( 'Service categories', 'paksa-it-solutions' ) . '"><!-- wp:button {"className":"pk-svc-tab-btn is-active","metadata":{"dxActionId":""}} -->
<button class="pk-svc-tab-btn is-active" role="tab" aria-selected="true" aria-controls="pk-tab-1" id="pk-tab-btn-1" data-anim="fade-up" data-delay="0"><!-- wp:group {"className":"pk-svc-tab-btn-icon"} -->
<div class="pk-svc-tab-btn-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg></div><!-- /wp:group -->

<!-- wp:html -->
' . esc_html__( 'Software Development', 'paksa-it-solutions' ) . '<!-- /wp:html --></button><!-- /wp:button -->

<!-- wp:button {"className":"pk-svc-tab-btn","metadata":{"dxActionId":""}} -->
<button class="pk-svc-tab-btn" role="tab" aria-selected="false" aria-controls="pk-tab-2" id="pk-tab-btn-2" data-anim="fade-up" data-delay="100"><!-- wp:group {"className":"pk-svc-tab-btn-icon"} -->
<div class="pk-svc-tab-btn-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="3"></circle><path d="M12 1v6m0 6v6m11-7h-6m-6 0H1m17.5-7.5L15 12m-6 0L4.5 7.5m13 9L15 12m-6 0l-2.5-4.5"></path></svg></div><!-- /wp:group -->

<!-- wp:html -->
' . esc_html__( 'AI &amp; Data', 'paksa-it-solutions' ) . '<!-- /wp:html --></button><!-- /wp:button -->

<!-- wp:button {"className":"pk-svc-tab-btn","metadata":{"dxActionId":""}} -->
<button class="pk-svc-tab-btn" role="tab" aria-selected="false" aria-controls="pk-tab-3" id="pk-tab-btn-3" data-anim="fade-up" data-delay="200"><!-- wp:group {"className":"pk-svc-tab-btn-icon"} -->
<div class="pk-svc-tab-btn-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg></div><!-- /wp:group -->

<!-- wp:html -->
' . esc_html__( 'Cloud &amp; Infrastructure', 'paksa-it-solutions' ) . '<!-- /wp:html --></button><!-- /wp:button --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-tab-panel is-active","id":"pk-tab-1","role":"tabpanel","metadata":{"dxActionId":""}} -->
<div class="pk-svc-tab-panel is-active" id="pk-tab-1" role="tabpanel" aria-labelledby="pk-tab-btn-1" data-anim="fade-up" data-delay="300"><!-- wp:heading {"level":3} -->
<h3>' . esc_html__( 'Enterprise Software Development', 'paksa-it-solutions' ) . '</h3><!-- /wp:heading -->

<!-- wp:paragraph -->
<p>' . esc_html__( 'Custom software solutions built from the ground up, tailored to your specific business processes and goals.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:list {"className":"pk-animate-on-scroll"} -->
<ul class="pk-animate-on-scroll" data-anim="fade-up" data-delay="400"><!-- wp:html -->
<li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg> Web Applications</li><!-- /wp:html -->
<!-- wp:html -->
<li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg> Mobile Applications</li><!-- /wp:html -->
<!-- wp:html -->
<li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg> Desktop Applications</li><!-- /wp:html -->
<!-- wp:html -->
<li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg> Legacy System Modernization</li><!-- /wp:html --></ul><!-- /wp:list --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-tab-panel","id":"pk-tab-2","role":"tabpanel","metadata":{"dxActionId":""}} -->
<div class="pk-svc-tab-panel" id="pk-tab-2" role="tabpanel" aria-labelledby="pk-tab-btn-2" data-anim="fade-up"><h3>' . esc_html__( 'AI, ML &amp; Data', 'paksa-it-solutions' ) . '</h3><p>' . esc_html__( 'Harness the power of artificial intelligence and data analytics for competitive advantage.', 'paksa-it-solutions' ) . '</p><ul><li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg> Machine Learning Models</li><li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg> Predictive Analytics</li><li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg> Natural Language Processing</li><li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg> Data Visualization Dashboards</li></ul></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-svc-tab-panel","id":"pk-tab-3","role":"tabpanel","metadata":{"dxActionId":""}} -->
<div class="pk-svc-tab-panel" id="pk-tab-3" role="tabpanel" aria-labelledby="pk-tab-btn-3" data-anim="fade-up"><h3>' . esc_html__( 'Cloud &amp; Infrastructure', 'paksa-it-solutions' ) . '</h3><p>' . esc_html__( 'Scalable cloud solutions engineered for reliability, performance, and cost efficiency.', 'paksa-it-solutions' ) . '</p><ul><li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg> Cloud Migration</li><li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg> Infrastructure as Code</li><li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg> CI/CD Pipeline Setup</li><li><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg> 24/7 Monitoring &amp; Support</li></ul></div><!-- /wp:group --></div><!-- /wp:group -->',
    )
);
