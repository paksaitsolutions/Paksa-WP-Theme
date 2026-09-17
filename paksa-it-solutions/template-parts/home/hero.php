<?php
/**
 * Paksa IT Solutions — Homepage: Hero Section
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$eyebrow     = paksa_get_option( 'paksa_hero_eyebrow',              __( 'Enterprise Technology Solutions', 'paksa-it-solutions' ) );
$heading     = paksa_get_option( 'paksa_hero_heading',              __( 'Technology That Moves Business Forward', 'paksa-it-solutions' ) );
$subheading  = paksa_get_option( 'paksa_hero_subheading',           "Build Smarter.\nOperate Better.\nGrow With Confidence." );
$description = paksa_get_option( 'paksa_hero_description',          __( 'Paksa IT Solutions builds enterprise software, AI-powered solutions and intelligent digital systems designed around real business challenges.', 'paksa-it-solutions' ) );
$cta1_text   = paksa_get_option( 'paksa_hero_cta_primary_text',     __( 'Get a Free Consultation', 'paksa-it-solutions' ) );
$cta1_url    = paksa_get_option( 'paksa_hero_cta_primary_url',      '#contact' );
$cta2_text   = paksa_get_option( 'paksa_hero_cta_secondary_text',   __( 'Explore Our Solutions', 'paksa-it-solutions' ) );
$cta2_url    = paksa_get_option( 'paksa_hero_cta_secondary_url',    '#solutions' );

$subheading_lines = array_filter( array_map( 'trim', explode( "\n", $subheading ) ) );
$typewriter_words = implode( '|', $subheading_lines );
?>
<section class="pk-hero" aria-labelledby="pk-hero-heading">

    <!-- Gradient mesh background -->
    <div class="pk-hero-mesh" aria-hidden="true">
        <div class="pk-mesh-blob pk-mesh-blob--1"></div>
        <div class="pk-mesh-blob pk-mesh-blob--2"></div>
        <div class="pk-mesh-blob pk-mesh-blob--3"></div>
    </div>

    <div class="container pk-hero-inner">

        <!-- Content -->
        <div class="pk-hero-content">

            <?php if ( $eyebrow ) : ?>
                <div class="pk-hero-eyebrow-wrap pk-animate-on-scroll" data-anim="fade-up">
                    <span class="pk-hero-eyebrow-dot" aria-hidden="true"></span>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                </div>
            <?php endif; ?>

            <h1 id="pk-hero-heading" class="pk-hero-heading pk-animate-on-scroll" data-anim="fade-up" data-delay="80">
                <?php echo esc_html( $heading ); ?>
            </h1>

            <?php if ( ! empty( $subheading_lines ) ) : ?>
                <p class="pk-hero-subheading pk-animate-on-scroll" data-anim="fade-up" data-delay="160"
                   data-typewriter="<?php echo esc_attr( $typewriter_words ); ?>">
                    <span class="pk-typewriter-text"><?php echo esc_html( reset( $subheading_lines ) ); ?></span><span class="pk-cursor" aria-hidden="true">|</span>
                </p>
            <?php endif; ?>

            <?php if ( $description ) : ?>
                <p class="pk-hero-description body-large pk-animate-on-scroll" data-anim="fade-up" data-delay="220">
                    <?php echo esc_html( $description ); ?>
                </p>
            <?php endif; ?>

            <div class="pk-hero-actions pk-animate-on-scroll" data-anim="fade-up" data-delay="300">
                <?php if ( $cta1_text && $cta1_url ) : ?>
                    <a href="<?php echo esc_url( $cta1_url ); ?>" class="btn btn-primary pk-btn-glow">
                        <?php echo esc_html( $cta1_text ); ?>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="8" x2="13" y2="8"/><polyline points="9,4 13,8 9,12"/></svg>
                    </a>
                <?php endif; ?>
                <?php if ( $cta2_text && $cta2_url ) : ?>
                    <a href="<?php echo esc_url( $cta2_url ); ?>" class="btn btn-outline">
                        <?php echo esc_html( $cta2_text ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Social proof strip -->
            <div class="pk-hero-proof pk-animate-on-scroll" data-anim="fade-up" data-delay="380">
                <div class="pk-proof-stat">
                    <span class="pk-proof-number" data-count="50" data-suffix="+">50+</span>
                    <span class="pk-proof-label"><?php esc_html_e( 'Projects Delivered', 'paksa-it-solutions' ); ?></span>
                </div>
                <div class="pk-proof-divider" aria-hidden="true"></div>
                <div class="pk-proof-stat">
                    <span class="pk-proof-number" data-count="8" data-suffix="+">8+</span>
                    <span class="pk-proof-label"><?php esc_html_e( 'Years Experience', 'paksa-it-solutions' ); ?></span>
                </div>
                <div class="pk-proof-divider" aria-hidden="true"></div>
                <div class="pk-proof-stat">
                    <span class="pk-proof-number" data-count="100" data-suffix="%">100%</span>
                    <span class="pk-proof-label"><?php esc_html_e( 'Custom Built', 'paksa-it-solutions' ); ?></span>
                </div>
            </div>

        </div>

        <!-- Visual -->
        <div class="pk-hero-visual pk-animate-on-scroll" data-anim="fade-in" data-delay="200" aria-hidden="true">

            <div class="pk-hero-dashboard">
                <div class="pk-dash-header">
                    <div class="pk-dash-dots">
                        <span></span><span></span><span></span>
                    </div>
                    <span class="pk-dash-title"><?php esc_html_e( 'Enterprise Platform', 'paksa-it-solutions' ); ?></span>
                    <span class="pk-dash-status">
                        <span class="pk-dash-status-dot"></span>
                        <?php esc_html_e( 'Live', 'paksa-it-solutions' ); ?>
                    </span>
                </div>

                <div class="pk-dash-body">
                    <div class="pk-dash-sidebar">
                        <div class="pk-dash-nav-item is-active"></div>
                        <div class="pk-dash-nav-item"></div>
                        <div class="pk-dash-nav-item"></div>
                        <div class="pk-dash-nav-item"></div>
                        <div class="pk-dash-nav-item"></div>
                        <div class="pk-dash-nav-item"></div>
                    </div>

                    <div class="pk-dash-main">
                        <!-- KPI row -->
                        <div class="pk-dash-kpis">
                            <div class="pk-dash-kpi">
                                <span class="pk-dash-kpi-label">Revenue</span>
                                <span class="pk-dash-kpi-value pk-dash-kpi-value--up">↑ 24%</span>
                            </div>
                            <div class="pk-dash-kpi">
                                <span class="pk-dash-kpi-label">Orders</span>
                                <span class="pk-dash-kpi-value">1,284</span>
                            </div>
                            <div class="pk-dash-kpi pk-dash-kpi--accent">
                                <span class="pk-dash-kpi-label">AI Score</span>
                                <span class="pk-dash-kpi-value">98.2</span>
                            </div>
                        </div>

                        <!-- Chart -->
                        <div class="pk-dash-chart">
                            <div class="pk-dash-chart-bars">
                                <div class="pk-dash-bar" style="--h:40%"></div>
                                <div class="pk-dash-bar" style="--h:62%"></div>
                                <div class="pk-dash-bar" style="--h:48%"></div>
                                <div class="pk-dash-bar pk-bar-accent" style="--h:82%"></div>
                                <div class="pk-dash-bar" style="--h:58%"></div>
                                <div class="pk-dash-bar pk-bar-accent" style="--h:91%"></div>
                                <div class="pk-dash-bar" style="--h:70%"></div>
                            </div>
                        </div>

                        <!-- Module row -->
                        <div class="pk-dash-modules">
                            <div class="pk-dash-module">
                                <div class="pk-dash-module-icon pk-icon-accent"></div>
                                <div class="pk-dash-module-lines"><div></div><div></div></div>
                            </div>
                            <div class="pk-dash-module">
                                <div class="pk-dash-module-icon"></div>
                                <div class="pk-dash-module-lines"><div></div><div></div></div>
                            </div>
                            <div class="pk-dash-module">
                                <div class="pk-dash-module-icon"></div>
                                <div class="pk-dash-module-lines"><div></div><div></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Floating nodes -->
            <div class="pk-hero-nodes">
                <div class="pk-node pk-node-ai pk-float" style="animation-delay:0s">
                    <span class="pk-node-pulse-ring"></span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
                    AI
                </div>
                <div class="pk-node pk-node-bi pk-float" style="animation-delay:1s">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    BI
                </div>
                <div class="pk-node pk-node-erp pk-float" style="animation-delay:2s">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    ERP
                </div>
                <div class="pk-node pk-node-data pk-float" style="animation-delay:1.5s">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                    Data
                </div>
            </div>

        </div>
    </div>
</section>
