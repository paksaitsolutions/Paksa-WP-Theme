<?php
/**
 * Services Page — Hero Section
 * Dark split layout: left content + right animated service grid
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$eyebrow = paksa_svc_meta( 'hero_eyebrow',     __( 'Enterprise IT Services', 'paksa-it-solutions' ) );
$heading = paksa_svc_meta( 'hero_heading',      __( 'Technology That Works the Way Your Business Does', 'paksa-it-solutions' ) );
$desc    = paksa_svc_meta_textarea( 'hero_description', __( 'Purpose-built software, applied AI, and intelligent data systems — designed around your operations, not adapted from a template.', 'paksa-it-solutions' ) );
$cta1_t  = paksa_svc_meta( 'hero_cta1_text',   __( 'Get a Free Consultation', 'paksa-it-solutions' ) );
$cta1_u  = paksa_svc_meta_url( 'hero_cta1_url', '/contact/' );
$cta2_t  = paksa_svc_meta( 'hero_cta2_text',   __( 'Explore Services', 'paksa-it-solutions' ) );
$cta2_u  = paksa_svc_meta_url( 'hero_cta2_url', '#pk-services-portfolio' );

if ( ! $heading ) { return; }

$services = array(
    array( 'label' => 'Enterprise Software',      'icon' => 'enterprise', 'accent' => false ),
    array( 'label' => 'AI & Machine Learning',    'icon' => 'ai',         'accent' => true  ),
    array( 'label' => 'Data Science',             'icon' => 'bi',         'accent' => false ),
    array( 'label' => 'AI Automation',            'icon' => 'ai',         'accent' => true  ),
    array( 'label' => 'System Integration',       'icon' => 'integration','accent' => false ),
    array( 'label' => 'Custom Development',       'icon' => 'custom',     'accent' => false ),
    array( 'label' => 'Ecommerce Solutions',      'icon' => 'ecommerce',  'accent' => false ),
    array( 'label' => 'Business Intelligence',    'icon' => 'bi',         'accent' => true  ),
);
?>
<section class="pk-svc-hero" aria-labelledby="pk-svc-hero-heading">
    <div class="pk-svc-hero-bg" aria-hidden="true">
        <div class="pk-svc-hero-grid-lines"></div>
    </div>
    <div class="container pk-svc-hero-inner">

        <div class="pk-svc-hero-content">
            <?php if ( $eyebrow ) : ?>
                <span class="pk-svc-hero-eyebrow pk-animate-on-scroll" data-anim="fade-up"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>

            <h1 id="pk-svc-hero-heading" class="pk-svc-hero-heading pk-animate-on-scroll" data-anim="fade-up" data-delay="100">
                <?php echo esc_html( $heading ); ?>
            </h1>

            <?php if ( $desc ) : ?>
                <p class="pk-svc-hero-desc pk-animate-on-scroll" data-anim="fade-up" data-delay="150">
                    <?php echo esc_html( $desc ); ?>
                </p>
            <?php endif; ?>

            <div class="pk-svc-hero-actions pk-animate-on-scroll" data-anim="fade-up" data-delay="200">
                <?php if ( $cta1_t && $cta1_u ) : ?>
                    <a href="<?php echo esc_url( $cta1_u ); ?>" class="btn btn-primary">
                        <?php echo esc_html( $cta1_t ); ?>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="8" x2="13" y2="8"/><polyline points="9,4 13,8 9,12"/></svg>
                    </a>
                <?php endif; ?>
                <?php if ( $cta2_t && $cta2_u ) : ?>
                    <a href="<?php echo esc_url( $cta2_u ); ?>" class="btn btn-outline-inv">
                        <?php echo esc_html( $cta2_t ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="pk-svc-hero-meta pk-animate-on-scroll" data-anim="fade-up" data-delay="250">
                <div class="pk-svc-hero-meta-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                    <span><?php esc_html_e( 'No obligation consultation', 'paksa-it-solutions' ); ?></span>
                </div>
                <div class="pk-svc-hero-meta-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                    <span><?php esc_html_e( 'Lahore-based team', 'paksa-it-solutions' ); ?></span>
                </div>
                <div class="pk-svc-hero-meta-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                    <span><?php esc_html_e( 'End-to-end delivery', 'paksa-it-solutions' ); ?></span>
                </div>
            </div>
        </div>

        <div class="pk-svc-hero-visual pk-animate-on-scroll" data-anim="fade-in" data-delay="200" aria-hidden="true">
            <div class="pk-svc-tiles-wrap">
                <?php foreach ( $services as $i => $svc ) :
                    $cls = $svc['accent'] ? ' pk-svc-tile--accent' : '';
                    $delay = $i * 60;
                ?>
                    <div class="pk-svc-tile<?php echo esc_attr( $cls ); ?> pk-animate-on-scroll" data-anim="scale-in" data-delay="<?php echo esc_attr( $delay ); ?>">
                        <div class="pk-svc-tile-icon">
                            <?php echo paksa_icon( $svc['icon'], 20 ); ?>
                        </div>
                        <span class="pk-svc-tile-label"><?php echo esc_html( $svc['label'] ); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>
