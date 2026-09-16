<?php
/**
 * Paksa IT Solutions — Homepage: Hero Section
 * Content: WordPress Customizer
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = paksa_get_option( 'paksa_hero_eyebrow', __( 'Enterprise Technology Solutions', 'paksa-it-solutions' ) );
$heading     = paksa_get_option( 'paksa_hero_heading', __( 'Technology That Moves Business Forward', 'paksa-it-solutions' ) );
$subheading  = paksa_get_option( 'paksa_hero_subheading', "Build Smarter.\nOperate Better.\nGrow With Confidence." );
$description = paksa_get_option( 'paksa_hero_description', __( 'Paksa IT Solutions builds enterprise software, AI-powered solutions and intelligent digital systems designed around real business challenges.', 'paksa-it-solutions' ) );
$cta1_text   = paksa_get_option( 'paksa_hero_cta_primary_text', __( 'Get a Free Consultation', 'paksa-it-solutions' ) );
$cta1_url    = paksa_get_option( 'paksa_hero_cta_primary_url', '#contact' );
$cta2_text   = paksa_get_option( 'paksa_hero_cta_secondary_text', __( 'Explore Our Solutions', 'paksa-it-solutions' ) );
$cta2_url    = paksa_get_option( 'paksa_hero_cta_secondary_url', '#solutions' );

$subheading_lines = array_filter( array_map( 'trim', explode( "\n", $subheading ) ) );
?>
<section class="pk-hero" aria-labelledby="pk-hero-heading">
    <div class="container pk-hero-inner">

        <div class="pk-hero-content">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow pk-animate-on-scroll" data-anim="fade-up"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>

            <h1 id="pk-hero-heading" class="pk-hero-heading pk-animate-on-scroll" data-anim="fade-up" data-delay="100">
                <?php echo esc_html( $heading ); ?>
            </h1>

            <?php if ( ! empty( $subheading_lines ) ) : ?>
                <p class="pk-hero-subheading pk-animate-on-scroll" data-anim="fade-up" data-delay="150">
                    <?php foreach ( $subheading_lines as $line ) : ?>
                        <span><?php echo esc_html( $line ); ?></span>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>

            <?php if ( $description ) : ?>
                <p class="pk-hero-description body-large pk-animate-on-scroll" data-anim="fade-up" data-delay="200">
                    <?php echo esc_html( $description ); ?>
                </p>
            <?php endif; ?>

            <div class="pk-hero-actions pk-animate-on-scroll" data-anim="fade-up" data-delay="250">
                <?php if ( $cta1_text && $cta1_url ) : ?>
                    <a href="<?php echo esc_url( $cta1_url ); ?>" class="btn btn-primary">
                        <?php echo esc_html( $cta1_text ); ?>
                    </a>
                <?php endif; ?>
                <?php if ( $cta2_text && $cta2_url ) : ?>
                    <a href="<?php echo esc_url( $cta2_url ); ?>" class="btn btn-outline">
                        <?php echo esc_html( $cta2_text ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="pk-hero-visual pk-animate-on-scroll" data-anim="fade-in" data-delay="300" aria-hidden="true">
            <div class="pk-hero-dashboard">
                <div class="pk-dash-header">
                    <div class="pk-dash-dots">
                        <span></span><span></span><span></span>
                    </div>
                    <span class="pk-dash-title"><?php esc_html_e( 'Enterprise Platform', 'paksa-it-solutions' ); ?></span>
                </div>
                <div class="pk-dash-body">
                    <div class="pk-dash-sidebar">
                        <div class="pk-dash-nav-item is-active"></div>
                        <div class="pk-dash-nav-item"></div>
                        <div class="pk-dash-nav-item"></div>
                        <div class="pk-dash-nav-item"></div>
                        <div class="pk-dash-nav-item"></div>
                    </div>
                    <div class="pk-dash-main">
                        <div class="pk-dash-metrics">
                            <div class="pk-dash-metric">
                                <div class="pk-dash-metric-label"></div>
                                <div class="pk-dash-metric-value pk-accent-bar"></div>
                            </div>
                            <div class="pk-dash-metric">
                                <div class="pk-dash-metric-label"></div>
                                <div class="pk-dash-metric-value"></div>
                            </div>
                            <div class="pk-dash-metric">
                                <div class="pk-dash-metric-label"></div>
                                <div class="pk-dash-metric-value pk-accent-bar"></div>
                            </div>
                        </div>
                        <div class="pk-dash-chart">
                            <div class="pk-dash-chart-bars">
                                <div class="pk-dash-bar" style="--h:45%"></div>
                                <div class="pk-dash-bar" style="--h:70%"></div>
                                <div class="pk-dash-bar" style="--h:55%"></div>
                                <div class="pk-dash-bar pk-bar-accent" style="--h:85%"></div>
                                <div class="pk-dash-bar" style="--h:65%"></div>
                                <div class="pk-dash-bar pk-bar-accent" style="--h:90%"></div>
                                <div class="pk-dash-bar" style="--h:75%"></div>
                            </div>
                        </div>
                        <div class="pk-dash-modules">
                            <div class="pk-dash-module">
                                <div class="pk-dash-module-icon"></div>
                                <div class="pk-dash-module-lines">
                                    <div></div><div></div>
                                </div>
                            </div>
                            <div class="pk-dash-module">
                                <div class="pk-dash-module-icon pk-icon-accent"></div>
                                <div class="pk-dash-module-lines">
                                    <div></div><div></div>
                                </div>
                            </div>
                            <div class="pk-dash-module">
                                <div class="pk-dash-module-icon"></div>
                                <div class="pk-dash-module-lines">
                                    <div></div><div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pk-hero-nodes" aria-hidden="true">
                <div class="pk-node pk-node-ai"><?php esc_html_e( 'AI', 'paksa-it-solutions' ); ?></div>
                <div class="pk-node pk-node-bi"><?php esc_html_e( 'BI', 'paksa-it-solutions' ); ?></div>
                <div class="pk-node pk-node-erp"><?php esc_html_e( 'ERP', 'paksa-it-solutions' ); ?></div>
                <div class="pk-node pk-node-data"><?php esc_html_e( 'Data', 'paksa-it-solutions' ); ?></div>
            </div>
        </div>

    </div>
</section>
