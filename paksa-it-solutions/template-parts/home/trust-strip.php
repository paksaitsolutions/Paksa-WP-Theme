<?php
/**
 * Paksa IT Solutions — Homepage: Trust / Capability Strip
 * Content: WordPress Customizer
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$items = array();
for ( $i = 1; $i <= 6; $i++ ) {
    $val = paksa_get_option( 'paksa_trust_item_' . $i, paksa_trust_default( $i ) );
    if ( $val ) {
        $items[] = $val;
    }
}

if ( empty( $items ) ) {
    return;
}
?>
<div class="pk-trust-strip" aria-label="<?php esc_attr_e( 'Core capabilities', 'paksa-it-solutions' ); ?>">
    <div class="container">
        <ul class="pk-trust-list" role="list">
            <?php foreach ( $items as $item ) : ?>
                <li class="pk-trust-item">
                    <span class="pk-trust-dot" aria-hidden="true"></span>
                    <?php echo esc_html( $item ); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
