<?php
/**
 * Paksa IT Solutions — Homepage: Trust / Capability Strip (Marquee)
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$items = array();
for ( $i = 1; $i <= 6; $i++ ) {
    $val = paksa_get_option( 'paksa_trust_item_' . $i, paksa_trust_default( $i ) );
    if ( $val ) $items[] = $val;
}

if ( empty( $items ) ) return;

// Duplicate for seamless loop
$all = array_merge( $items, $items );
?>
<div class="pk-trust-strip" aria-label="<?php esc_attr_e( 'Core capabilities', 'paksa-it-solutions' ); ?>">
    <div class="pk-trust-marquee-wrap">
        <ul class="pk-trust-marquee" role="list" aria-hidden="false">
            <?php foreach ( $all as $item ) : ?>
                <li class="pk-trust-item">
                    <svg class="pk-trust-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                    <?php echo esc_html( $item ); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
