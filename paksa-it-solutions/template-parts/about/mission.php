<?php
/**
 * Paksa IT Solutions — About: Mission & Vision
 * Coloured icon cards matching product benefit style.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$page_id = get_the_ID();
$mission = paksa_page_meta_textarea( 'mission', '', $page_id );
$vision  = paksa_page_meta_textarea( 'vision', '', $page_id );

if ( ! $mission && ! $vision ) { return; }
?>
<section class="section section-alt pk-about-mission" aria-labelledby="pk-about-mission-heading">
    <div class="container">
        <div class="section-header">
            <span class="pk-about-eyebrow">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Purpose
            </span>
            <h2 id="pk-about-mission-heading">Mission &amp; Vision</h2>
        </div>
        <div class="pk-about-mv-grid">
            <?php if ( $mission ) : ?>
                <div class="pk-about-mv-card pk-animate-on-scroll" data-anim="fade-up"
                     style="--mv-bg:#eef3fe;--mv-icon:#6192f8;--mv-accent:#6192f8">
                    <div class="pk-about-mv-icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <h3 class="pk-about-mv-title"><?php esc_html_e( 'Our Mission', 'paksa-it-solutions' ); ?></h3>
                    <p class="pk-about-mv-desc"><?php echo esc_html( $mission ); ?></p>
                </div>
            <?php endif; ?>
            <?php if ( $vision ) : ?>
                <div class="pk-about-mv-card pk-animate-on-scroll" data-anim="fade-up" data-delay="100"
                     style="--mv-bg:#edfaf3;--mv-icon:#12b76a;--mv-accent:#12b76a">
                    <div class="pk-about-mv-icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </div>
                    <h3 class="pk-about-mv-title"><?php esc_html_e( 'Our Vision', 'paksa-it-solutions' ); ?></h3>
                    <p class="pk-about-mv-desc"><?php echo esc_html( $vision ); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
