<?php
/**
 * Paksa IT Solutions — About: Mission & Vision
 *
 * Content: _paksa_page_mission and _paksa_page_vision post meta.
 * Section hidden if both are empty.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID();
$mission = paksa_page_meta_textarea( 'mission', '', $page_id );
$vision  = paksa_page_meta_textarea( 'vision', '', $page_id );

if ( ! $mission && ! $vision ) {
    return;
}
?>
<section class="section section-alt pk-about-mission" aria-labelledby="pk-about-mission-heading">
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'heading' => __( 'Mission & Vision', 'paksa-it-solutions' ),
        ) );
        ?>
        <div class="grid grid-2" style="max-width: var(--pk-container-narrow); margin: 0 auto;">
            <?php if ( $mission ) : ?>
                <div class="pk-about-value-item pk-animate-on-scroll" data-anim="fade-up">
                    <p class="pk-about-value-title"><?php esc_html_e( 'Our Mission', 'paksa-it-solutions' ); ?></p>
                    <p class="pk-about-value-desc"><?php echo esc_html( $mission ); ?></p>
                </div>
            <?php endif; ?>
            <?php if ( $vision ) : ?>
                <div class="pk-about-value-item pk-animate-on-scroll" data-anim="fade-up" data-delay="80">
                    <p class="pk-about-value-title"><?php esc_html_e( 'Our Vision', 'paksa-it-solutions' ); ?></p>
                    <p class="pk-about-value-desc"><?php echo esc_html( $vision ); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
