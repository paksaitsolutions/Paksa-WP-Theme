<?php
/**
 * Paksa IT Solutions — About: Company Story (split layout with image)
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$page_id = get_the_ID();
$heading = paksa_page_meta( 'story_heading', '', $page_id );
$content = paksa_page_meta_textarea( 'story_content', '', $page_id );

if ( ! $heading && ! $content ) { return; }

$image_id  = (int) get_post_meta( $page_id, '_paksa_page_about_image_id', true );
$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : '';
?>
<section class="section pk-about-story" aria-labelledby="pk-about-story-heading">
    <div class="container">
        <div class="pk-about-split">
            <div class="pk-about-split__text pk-animate-on-scroll" data-anim="fade-up">
                <span class="pk-about-eyebrow">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    About Paksa
                </span>
                <?php if ( $heading ) : ?>
                    <h2 id="pk-about-story-heading"><?php echo esc_html( $heading ); ?></h2>
                <?php endif; ?>
                <?php foreach ( array_filter( array_map( 'trim', explode( "\n", $content ) ) ) as $para ) : ?>
                    <p><?php echo esc_html( $para ); ?></p>
                <?php endforeach; ?>
                <div class="pk-about-trust-row">
                    <div class="pk-about-trust-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        Data Science & AI/ML
                    </div>
                    <div class="pk-about-trust-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        AI Automation
                    </div>
                    <div class="pk-about-trust-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        Software Development
                    </div>
                    <div class="pk-about-trust-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        IT Consultancy
                    </div>
                </div>
            </div>
            <?php if ( $image_url ) : ?>
                <div class="pk-about-split__visual pk-animate-on-scroll" data-anim="fade-up" data-delay="100">
                    <img src="<?php echo esc_url( $image_url ); ?>"
                         alt="<?php esc_attr_e( 'Paksa IT Solutions Team', 'paksa-it-solutions' ); ?>"
                         loading="lazy" decoding="async">
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
