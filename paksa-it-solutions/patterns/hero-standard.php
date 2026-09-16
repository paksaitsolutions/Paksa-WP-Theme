<?php
/**
 * Paksa IT Solutions — Block Pattern: Hero Standard
 *
 * Text left, dashboard visual right.
 * Default hero for the homepage.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/hero-standard',
    array(
        'title'      => __( 'Hero Standard', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-hero' ),
        'keywords'   => array( 'hero', 'header', 'cta', 'standard' ),
        'viewport'   => array(
            'width'  => 1280,
            'height' => 600,
        ),
        'content'    => '<!-- wp:group {"className":"pk-hero","align":"wide"} -->
<div class="pk-hero pk-hero-inner"><!-- wp:group {"className":"pk-hero-content"} -->
<div class="pk-hero-content"><!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.08em","fontSize":"0.75rem","fontWeight":"600"}},"textColor":"accent","className":"eyebrow pk-animate-on-scroll","metadata":{"dxActionId":""}} -->
<p class="eyebrow pk-animate-on-scroll" style="color:var(--pk-accent);font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;" data-anim="fade-up">' . esc_html__( 'Enterprise Technology Solutions', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"pk-hero-heading pk-animate-on-scroll","style":{"typography":{"fontSize":"clamp(2rem, 4vw, 3.25rem)","lineHeight":"1.1"},"spacing":{"marginBottom":"1rem"}}} -->
<h1 class="pk-hero-heading pk-animate-on-scroll" style="font-size:clamp(2rem, 4vw, 3.25rem);line-height:1.1;margin-bottom:1rem;" data-anim="fade-up" data-delay="100">' . esc_html__( 'Technology That Moves Business Forward', 'paksa-it-solutions' ) . '</h1><!-- /wp:heading -->

<!-- wp:paragraph {"className":"pk-hero-description body-large pk-animate-on-scroll","style":{"typography":{"fontSize":"1.125rem","lineHeight":"1.7"}},"textColor":"secondary","metadata":{"dxActionId":""}} -->
<p class="pk-hero-description body-large pk-animate-on-scroll" style="color:var(--pk-text-secondary);font-size:1.125rem;line-height:1.7;" data-anim="fade-up" data-delay="200">' . esc_html__( 'Paksa IT Solutions builds enterprise software, AI-powered solutions and intelligent digital systems designed around real business challenges.', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:buttons {"className":"pk-hero-actions pk-animate-on-scroll","layout":{"type":"flex","justifyContent":"left"}} -->
<div class="pk-hero-actions pk-animate-on-scroll" data-anim="fade-up" data-delay="250"><!-- wp:button {"className":"btn btn-primary"} -->
<div class="wp-block-button"><a href="#contact" class="wp-element-button btn btn-primary">' . esc_html__( 'Get a Free Consultation', 'paksa-it-solutions' ) . '</a></div><!-- /wp:button -->

<!-- wp:button {"className":"btn btn-outline"} -->
<div class="wp-block-button"><a href="#solutions" class="wp-element-button btn btn-outline">' . esc_html__( 'Explore Our Solutions', 'paksa-it-solutions' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-hero-visual pk-animate-on-scroll","metadata":{"dxActionId":""}} -->
<div class="pk-hero-visual pk-animate-on-scroll" data-anim="fade-in" data-delay="300" aria-hidden="true"><!-- wp:group {"className":"pk-hero-dashboard"} -->
<div class="pk-hero-dashboard"><!-- wp:group {"className":"pk-dash-header"} -->
<div class="pk-dash-header"><!-- wp:group {"className":"pk-dash-dots"} -->
<div class="pk-dash-dots"><!-- wp:paragraph {"style":{"color":{"text":"#e53e3e"}}} -->
<p style="color:#e53e3e">.</p><!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"color":{"text":"#d69e2e"}}} -->
<p style="color:#d69e2e">.</p><!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"color":{"text":"#38a169"}}} -->
<p style="color:#38a169">.</p><!-- /wp:paragraph --></div><!-- /wp:group -->

<!-- wp:paragraph {"style":{"color":{"text":"#718096"}}} -->
<p style="color:#718096">' . esc_html__( 'Enterprise Platform', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-dash-body"} -->
<div class="pk-dash-body"><!-- wp:group {"className":"pk-dash-sidebar"} -->
<div class="pk-dash-sidebar"><!-- wp:paragraph {"className":"pk-dash-nav-item is-active"} -->
<p class="pk-dash-nav-item"></p><!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pk-dash-nav-item"} -->
<p class="pk-dash-nav-item"></p><!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pk-dash-nav-item"} -->
<p class="pk-dash-nav-item"></p><!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pk-dash-nav-item"} -->
<p class="pk-dash-nav-item"></p><!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pk-dash-nav-item"} -->
<p class="pk-dash-nav-item"></p><!-- /wp:paragraph --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-dash-main"} -->
<div class="pk-dash-main"><!-- wp:group {"className":"pk-dash-metrics"} -->
<div class="pk-dash-metrics"><!-- wp:group {"className":"pk-dash-metric"} -->
<div class="pk-dash-metric"><!-- wp:paragraph {"className":"pk-dash-metric-label"} -->
<p class="pk-dash-metric-label"></p><!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pk-dash-metric-value pk-accent-bar"} -->
<p class="pk-dash-metric-value pk-accent-bar"></p><!-- /wp:paragraph --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-dash-metric"} -->
<div class="pk-dash-metric"><!-- wp:paragraph {"className":"pk-dash-metric-label"} -->
<p class="pk-dash-metric-label"></p><!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pk-dash-metric-value"} -->
<p class="pk-dash-metric-value"></p><!-- /wp:paragraph --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-dash-metric"} -->
<div class="pk-dash-metric"><!-- wp:paragraph {"className":"pk-dash-metric-label"} -->
<p class="pk-dash-metric-label"></p><!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pk-dash-metric-value pk-accent-bar"} -->
<p class="pk-dash-metric-value pk-accent-bar"></p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-dash-chart"} -->
<div class="pk-dash-chart"><!-- wp:group {"className":"pk-dash-chart-bars"} -->
<div class="pk-dash-chart-bars"><!-- wp:paragraph {"style":{"--h":"45%"}} -->
<p class="pk-dash-bar" style="--h:45%"></p><!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"--h":"70%"}} -->
<p class="pk-dash-bar" style="--h:70%"></p><!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"--h":"55%"}} -->
<p class="pk-dash-bar" style="--h:55%"></p><!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"--h":"85%"}} -->
<p class="pk-dash-bar pk-bar-accent" style="--h:85%"></p><!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"--h":"65%"}} -->
<p class="pk-dash-bar" style="--h:65%"></p><!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"--h":"90%"}} -->
<p class="pk-dash-bar pk-bar-accent" style="--h:90%"></p><!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"--h":"75%"}} -->
<p class="pk-dash-bar" style="--h:75%"></p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-dash-modules"} -->
<div class="pk-dash-modules"><!-- wp:group {"className":"pk-dash-module"} -->
<div class="pk-dash-module"><!-- wp:paragraph {"className":"pk-dash-module-icon"} -->
<p class="pk-dash-module-icon"></p><!-- /wp:paragraph -->

<!-- wp:group {"className":"pk-dash-module-lines"} -->
<div class="pk-dash-module-lines"><!-- wp:paragraph {"style":{"color":{"text":"#e2e8f0"}}} -->
<p></p><!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"color":{"text":"#e2e8f0"}}} -->
<p></p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-dash-module"} -->
<div class="pk-dash-module"><!-- wp:paragraph {"className":"pk-dash-module-icon pk-icon-accent"} -->
<p class="pk-dash-module-icon pk-icon-accent"></p><!-- /wp:paragraph -->

<!-- wp:group {"className":"pk-dash-module-lines"} -->
<div class="pk-dash-module-lines"><!-- wp:paragraph -->
<p></p><!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p></p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-dash-module"} -->
<div class="pk-dash-module"><!-- wp:paragraph {"className":"pk-dash-module-icon"} -->
<p class="pk-dash-module-icon"></p><!-- /wp:paragraph -->

<!-- wp:group {"className":"pk-dash-module-lines"} -->
<div class="pk-dash-module-lines"><!-- wp:paragraph -->
<p></p><!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p></p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group --></div><!-- /wp:group --></div><!-- /wp:group --></div><!-- /wp:group -->

<!-- wp:group {"className":"pk-hero-nodes","metadata":{"dxActionId":""}} -->
<div class="pk-hero-nodes" aria-hidden="true"><!-- wp:paragraph {"className":"pk-node pk-node-ai"} -->
<p class="pk-node pk-node-ai">' . esc_html__( 'AI', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pk-node pk-node-bi"} -->
<p class="pk-node pk-node-bi">' . esc_html__( 'BI', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pk-node pk-node-erp"} -->
<p class="pk-node pk-node-erp">' . esc_html__( 'ERP', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pk-node pk-node-data"} -->
<p class="pk-node pk-node-data">' . esc_html__( 'Data', 'paksa-it-solutions' ) . '</p><!-- /wp:paragraph --></div><!-- /wp:group --></div><!-- /wp:group --></div><!-- /wp:group -->',
    )
);
