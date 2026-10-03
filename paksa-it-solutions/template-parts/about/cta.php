<?php
/**
 * Paksa IT Solutions — About: CTA (dark, matches product CTA)
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$page_id = get_the_ID();
$heading = paksa_page_meta( 'cta_heading', 'Ready to Work With Us?', $page_id );
$desc    = paksa_page_meta_textarea( 'cta_description', '', $page_id );
$btn1_t  = paksa_page_meta( 'cta_btn1_text', 'Get a Free Consultation', $page_id );
$btn1_u  = get_post_meta( $page_id, '_paksa_page_cta_btn1_url', true ) ?: '/contact-us/';
$btn2_t  = paksa_page_meta( 'cta_btn2_text', '', $page_id );
$btn2_u  = get_post_meta( $page_id, '_paksa_page_cta_btn2_url', true ) ?: '';
?>
<section class="pk-about-cta" aria-labelledby="pk-about-cta-heading">
    <div class="pk-prod-cta-dots" aria-hidden="true"></div>
    <div class="pk-about-cta-glow" aria-hidden="true"></div>
    <div class="container">
        <div class="pk-about-cta-inner pk-animate-on-scroll" data-anim="fade-up">
            <div class="pk-about-cta-left">
                <p class="pk-prod-cta-eyebrow">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    Get in Touch
                </p>
                <h2 id="pk-about-cta-heading" class="pk-prod-cta-heading"><?php echo esc_html( $heading ); ?></h2>
                <?php if ( $desc ) : ?>
                    <p class="pk-prod-cta-desc"><?php echo esc_html( $desc ); ?></p>
                <?php endif; ?>
            </div>
            <div class="pk-prod-cta-actions">
                <?php if ( $btn1_t && $btn1_u ) : ?>
                    <a href="<?php echo esc_url( $btn1_u ); ?>" class="pk-btn-primary">
                        <?php echo esc_html( $btn1_t ); ?>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                <?php endif; ?>
                <?php if ( $btn2_t && $btn2_u ) : ?>
                    <a href="<?php echo esc_url( $btn2_u ); ?>" class="pk-btn-ghost-inv"><?php echo esc_html( $btn2_t ); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
