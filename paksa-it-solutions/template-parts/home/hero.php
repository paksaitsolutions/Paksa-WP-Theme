<?php
/**
 * Paksa IT Solutions — Homepage: Hero Section
 * Asymmetric split layout — content left, real image right
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$heading     = paksa_get_option( 'paksa_hero_heading',            __( 'AI-Powered IT Solutions for Data-Driven Businesses', 'paksa-it-solutions' ) );
$subheading  = paksa_get_option( 'paksa_hero_subheading',         "Build Smarter.\nOperate Better.\nGrow With Confidence." );
$description = paksa_get_option( 'paksa_hero_description',        __( 'Paksa IT Solutions delivers intelligent, scalable, and secure technology services with a strong focus on Data Science, Artificial Intelligence (AI/ML), and AI Automation.', 'paksa-it-solutions' ) );
$cta1_text   = paksa_get_option( 'paksa_hero_cta_primary_text',   __( 'Get Started', 'paksa-it-solutions' ) );
$cta1_url    = paksa_get_option( 'paksa_hero_cta_primary_url',    '/contact/' );
$cta2_text   = paksa_get_option( 'paksa_hero_cta_secondary_text', __( 'Explore Solutions', 'paksa-it-solutions' ) );
$cta2_url    = paksa_get_option( 'paksa_hero_cta_secondary_url',  '/our-products/' );

$subheading_lines = array_filter( array_map( 'trim', explode( "\n", $subheading ) ) );
$typewriter_words = implode( '|', $subheading_lines );
?>
<section class="pk-hero" aria-labelledby="pk-hero-heading">

    <!-- Subtle background grid -->
    <div class="pk-hero-grid-bg" aria-hidden="true"></div>

    <div class="container pk-hero-inner">

        <!-- Left: Content -->
        <div class="pk-hero-content">

            <div class="pk-hero-badge pk-animate-on-scroll" data-anim="fade-up">
                <span class="pk-hero-badge-dot" aria-hidden="true"></span>
                <span><?php esc_html_e( 'AI-Powered', 'paksa-it-solutions' ); ?></span>
            </div>

            <h1 id="pk-hero-heading" class="pk-hero-heading pk-animate-on-scroll" data-anim="fade-up" data-delay="60">
                <?php echo esc_html( $heading ); ?>
            </h1>

            <?php if ( ! empty( $subheading_lines ) ) : ?>
                <p class="pk-hero-subheading pk-animate-on-scroll" data-anim="fade-up" data-delay="120"
                   data-typewriter="<?php echo esc_attr( $typewriter_words ); ?>">
                    <span class="pk-typewriter-text"><?php echo esc_html( reset( $subheading_lines ) ); ?></span><span class="pk-cursor" aria-hidden="true">|</span>
                </p>
            <?php endif; ?>

            <?php if ( $description ) : ?>
                <p class="pk-hero-description pk-animate-on-scroll" data-anim="fade-up" data-delay="180">
                    <?php echo esc_html( $description ); ?>
                </p>
            <?php endif; ?>

            <div class="pk-hero-actions pk-animate-on-scroll" data-anim="fade-up" data-delay="240">
                <?php if ( $cta1_text && $cta1_url ) : ?>
                    <a href="<?php echo esc_url( $cta1_url ); ?>" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12,5 19,12 12,19"/></svg>
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

        <!-- Right: Real image from live site -->
        <div class="pk-hero-visual pk-animate-on-scroll" data-anim="fade-in" data-delay="100">
            <div class="pk-hero-img-wrap">
                <img
                    src="https://paksa.com.pk/wp-content/uploads/2023/12/banner-img.png"
                    alt="<?php esc_attr_e( 'Paksa IT Solutions — AI-powered enterprise technology', 'paksa-it-solutions' ); ?>"
                    width="738"
                    height="538"
                    loading="eager"
                    decoding="async"
                    class="pk-hero-img"
                >
                <!-- Floating stat cards -->
                <div class="pk-hero-stat pk-hero-stat--tl pk-animate-on-scroll" data-anim="scale-in" data-delay="400">
                    <span class="pk-hero-stat-num" data-count="22" data-suffix="k">22k</span>
                    <span class="pk-hero-stat-label"><?php esc_html_e( 'Downloads', 'paksa-it-solutions' ); ?></span>
                </div>
                <div class="pk-hero-stat pk-hero-stat--br pk-animate-on-scroll" data-anim="scale-in" data-delay="500">
                    <span class="pk-hero-stat-num" data-count="100" data-suffix="%">100%</span>
                    <span class="pk-hero-stat-label"><?php esc_html_e( 'Positive Feedback', 'paksa-it-solutions' ); ?></span>
                </div>
            </div>
        </div>

    </div>
</section>
