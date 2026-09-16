<?php
/**
 * Paksa IT Solutions — Single Service: Overview
 *
 * Content: _paksa_svc_overview_* post meta.
 * Falls back to block editor content (the_content).
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$svc_id  = get_the_ID();
$eyebrow = paksa_svc_meta( 'overview_eyebrow', '', $svc_id );
$heading = paksa_svc_meta( 'overview_heading', '', $svc_id );
$content = paksa_svc_meta_textarea( 'overview_content', '', $svc_id );

$has_meta_content = $heading || $content;
$has_post_content = trim( get_the_content() ) !== '';

if ( ! $has_meta_content && ! $has_post_content ) {
    return;
}
?>
<section class="section pk-prod-overview" id="pk-service-overview" aria-labelledby="pk-svc-overview-heading">
    <div class="container">
        <div class="pk-prod-overview-inner">

            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>

            <?php if ( $heading ) : ?>
                <h2 id="pk-svc-overview-heading"><?php echo esc_html( $heading ); ?></h2>
            <?php endif; ?>

            <div class="pk-prod-overview-text">
                <?php if ( $content ) :
                    $paragraphs = array_filter( array_map( 'trim', explode( "\n", $content ) ) );
                    foreach ( $paragraphs as $para ) :
                ?>
                    <p><?php echo esc_html( $para ); ?></p>
                <?php
                    endforeach;
                elseif ( $has_post_content ) : ?>
                    <div class="pk-prod-post-content">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
