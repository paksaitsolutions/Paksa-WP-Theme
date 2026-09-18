<?php
/**
 * Reusable announcement part for the announcement header variation.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) || paksa_get_header_variant() !== 'announcement' ) {
    return;
}

$text = paksa_get_option( 'paksa_announcement_text', '' );
$url  = paksa_get_option( 'paksa_announcement_url', '' );

if ( ! $text ) {
    return;
}
?>
<div class="pk-announcement" role="region" aria-label="<?php esc_attr_e( 'Site announcement', 'paksa-it-solutions' ); ?>">
    <div class="container pk-announcement__inner">
        <?php if ( $url ) : ?>
            <a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $text ); ?> <?php echo paksa_icon( 'arrow', 16 ); ?></a>
        <?php else : ?>
            <p><?php echo esc_html( $text ); ?></p>
        <?php endif; ?>
    </div>
</div>
