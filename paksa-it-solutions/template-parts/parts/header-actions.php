<?php
/**
 * Reusable header actions.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$variant         = isset( $args['variant'] ) ? $args['variant'] : paksa_get_header_variant();
$primary_text    = paksa_get_option( 'paksa_cta_primary_text', __( 'Get in Touch', 'paksa-it-solutions' ) );
$primary_url     = paksa_get_option( 'paksa_cta_primary_url', '/contact/' );
$secondary_text  = paksa_get_option( 'paksa_header_secondary_text', __( 'View services', 'paksa-it-solutions' ) );
$secondary_url   = paksa_get_option( 'paksa_header_secondary_url', '/services/' );
?>
<div class="nav-cta pk-header-actions">
    <?php if ( $variant === 'two-actions' && $secondary_text && $secondary_url ) : ?>
        <a href="<?php echo esc_url( $secondary_url ); ?>" class="btn btn-outline btn-sm">
            <?php echo esc_html( $secondary_text ); ?>
        </a>
    <?php endif; ?>
    <?php if ( $primary_text && $primary_url ) : ?>
        <a href="<?php echo esc_url( $primary_url ); ?>" class="btn btn-primary btn-sm">
            <?php echo esc_html( $primary_text ); ?>
        </a>
    <?php endif; ?>
</div>
