<?php
/**
 * Paksa IT Solutions — Homepage: Trust / Capability Strip
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

$all = array_merge( $items, $items );
?>
<div class="pk-trust-strip" aria-label="<?php esc_attr_e( 'Core capabilities', 'paksa-it-solutions' ); ?>">
    <div class="pk-trust-marquee-wrap" aria-hidden="true">
        <ul class="pk-trust-marquee" role="list">
            <?php foreach ( $all as $item ) : ?>
                <li class="pk-trust-item">
                    <svg class="pk-trust-dot" width="6" height="6" viewBox="0 0 6 6" aria-hidden="true"><circle cx="3" cy="3" r="3" fill="currentColor"/></svg>
                    <?php echo esc_html( $item ); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
