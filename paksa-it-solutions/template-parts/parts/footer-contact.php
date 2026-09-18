<?php
/**
 * Reusable contact information for contact and company footer variants.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) || ! in_array( paksa_get_footer_variant(), array( 'contact', 'company' ), true ) ) {
    return;
}

$phone   = paksa_get_option( 'paksa_phone', '' );
$email   = paksa_get_option( 'paksa_email', '' );
$address = paksa_get_option( 'paksa_address', '' );

if ( ! $phone && ! $email && ! $address ) {
    return;
}
?>
<div class="pk-footer-contact">
    <?php if ( $phone ) : ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>"><?php echo paksa_icon( 'phone', 16 ); ?><span><?php echo esc_html( $phone ); ?></span></a><?php endif; ?>
    <?php if ( $email ) : ?><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo paksa_icon( 'email', 16 ); ?><span><?php echo esc_html( $email ); ?></span></a><?php endif; ?>
    <?php if ( $address ) : ?><p><?php echo paksa_icon( 'location', 16 ); ?><span><?php echo esc_html( $address ); ?></span></p><?php endif; ?>
</div>
