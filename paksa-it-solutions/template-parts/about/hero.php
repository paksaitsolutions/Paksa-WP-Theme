<?php
/**
 * Paksa IT Solutions — About: Hero (dark, matches product hero)
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$page_id = get_the_ID();
$eyebrow = paksa_page_meta( 'hero_eyebrow', 'About Us', $page_id );
$heading = paksa_page_meta( 'hero_heading', get_the_title(), $page_id );
$desc    = paksa_page_meta_textarea( 'hero_description', '', $page_id );
?>
<section class="pk-about-hero" aria-labelledby="pk-about-heading">
    <div class="pk-about-hero__dots" aria-hidden="true"></div>
    <div class="pk-about-hero__glow" aria-hidden="true"></div>
    <div class="container">
        <div class="pk-about-hero__inner">
            <div class="pk-about-hero__content">
                <?php if ( $eyebrow ) : ?>
                    <span class="pk-about-hero__eyebrow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <?php echo esc_html( $eyebrow ); ?>
                    </span>
                <?php endif; ?>
                <h1 id="pk-about-heading" class="pk-about-hero__heading pk-animate-on-scroll" data-anim="fade-up">
                    <?php echo esc_html( $heading ); ?>
                </h1>
                <?php if ( $desc ) : ?>
                    <p class="pk-about-hero__desc pk-animate-on-scroll" data-anim="fade-up" data-delay="80">
                        <?php echo esc_html( $desc ); ?>
                    </p>
                <?php endif; ?>
                <div class="pk-about-hero__actions pk-animate-on-scroll" data-anim="fade-up" data-delay="120">
                    <a href="/contact-us/" class="pk-btn-primary">
                        Get in Touch
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                    <a href="/services/" class="pk-btn-ghost-inv">View Our Services</a>
                </div>
            </div>
            <div class="pk-about-hero__stats pk-animate-on-scroll" data-anim="fade-up" data-delay="160">
                <div class="pk-about-hero__stat">
                    <div class="pk-about-hero__stat-val">2019</div>
                    <div class="pk-about-hero__stat-label">Established</div>
                </div>
                <div class="pk-about-hero__stat">
                    <div class="pk-about-hero__stat-val">3+</div>
                    <div class="pk-about-hero__stat-label">Countries Served</div>
                </div>
                <div class="pk-about-hero__stat pk-about-hero__stat--featured">
                    <div class="pk-about-hero__stat-val">AI-Powered</div>
                    <div class="pk-about-hero__stat-label">Data Science · AI/ML · Automation</div>
                </div>
                <div class="pk-about-hero__stat">
                    <div class="pk-about-hero__stat-val">5+</div>
                    <div class="pk-about-hero__stat-label">Software Products</div>
                </div>
                <div class="pk-about-hero__stat">
                    <div class="pk-about-hero__stat-val">100%</div>
                    <div class="pk-about-hero__stat-label">Business-Focused</div>
                </div>
            </div>
        </div>
    </div>
</section>
