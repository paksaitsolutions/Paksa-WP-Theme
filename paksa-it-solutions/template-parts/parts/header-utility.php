<?php
/**
 * Reusable header utility bar for contact and social header variants.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$variant = paksa_get_header_variant();
if ( ! in_array( $variant, array( 'contact', 'social' ), true ) ) {
    return;
}

$phone = paksa_get_option( 'paksa_phone', '' );
$email = paksa_get_option( 'paksa_email', '' );
$links = array(
    'facebook' => paksa_get_option( 'paksa_social_facebook', '' ),
    'twitter'  => paksa_get_option( 'paksa_social_twitter', '' ),
    'linkedin' => paksa_get_option( 'paksa_social_linkedin', '' ),
    'github'   => paksa_get_option( 'paksa_social_github', '' ),
);

if ( $variant === 'contact' && ! $phone && ! $email ) {
    return;
}
if ( $variant === 'social' && ! array_filter( $links ) ) {
    return;
}
?>
<div class="pk-header-utility">
    <div class="container pk-header-utility__inner">
        <?php if ( $variant === 'contact' ) : ?>
            <div class="pk-header-utility__contact">
                <?php if ( $phone ) : ?>
                    <a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>"><?php echo paksa_icon( 'phone', 16 ); ?><span><?php echo esc_html( $phone ); ?></span></a>
                <?php endif; ?>
                <?php if ( $email ) : ?>
                    <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo paksa_icon( 'email', 16 ); ?><span><?php echo esc_html( $email ); ?></span></a>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="pk-header-utility__social" aria-label="<?php esc_attr_e( 'Social links', 'paksa-it-solutions' ); ?>">
                <?php foreach ( $links as $network => $url ) : ?>
                    <?php if ( $url ) : ?>
                        <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $network ) ); ?>"><?php echo paksa_icon( $network, 16 ); ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
