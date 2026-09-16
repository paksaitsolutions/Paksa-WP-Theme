<?php
/**
 * Paksa IT Solutions — Contact: Hero
 *
 * Content: _paksa_page_hero_* post meta, falls back to page title.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID();
$eyebrow = paksa_page_meta( 'hero_eyebrow', '', $page_id );
$heading = paksa_page_meta( 'hero_heading', get_the_title(), $page_id );
$desc    = paksa_page_meta_textarea( 'hero_description', '', $page_id );
?>
<section class="pk-contact-hero" aria-labelledby="pk-contact-heading">
    <div class="container">
        <?php if ( $eyebrow ) : ?>
            <span class="eyebrow pk-animate-on-scroll" data-anim="fade-up"><?php echo esc_html( $eyebrow ); ?></span>
        <?php endif; ?>
        <h1 id="pk-contact-heading" class="pk-contact-hero-heading pk-animate-on-scroll" data-anim="fade-up" data-delay="80">
            <?php echo esc_html( $heading ); ?>
        </h1>
        <?php if ( $desc ) : ?>
            <p class="body-large pk-animate-on-scroll" data-anim="fade-up" data-delay="120" style="max-width: 600px;">
                <?php echo esc_html( $desc ); ?>
            </p>
        <?php endif; ?>
    </div>
</section>
