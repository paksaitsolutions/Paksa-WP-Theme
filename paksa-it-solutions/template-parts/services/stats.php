<?php
/**
 * Services Page — Stats / Social Proof Bar
 * Key numbers that build credibility above the fold
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$stats = apply_filters( 'paksa_svc_stats_items', array(
    array( 'value' => '50+',  'label' => __( 'Projects Delivered',    'paksa-it-solutions' ), 'icon' => 'check' ),
    array( 'value' => '8+',   'label' => __( 'Industries Served',     'paksa-it-solutions' ), 'icon' => 'enterprise' ),
    array( 'value' => '12+',  'label' => __( 'Service Capabilities',  'paksa-it-solutions' ), 'icon' => 'gear' ),
    array( 'value' => '100%', 'label' => __( 'In-house Team',         'paksa-it-solutions' ), 'icon' => 'users' ),
    array( 'value' => '5★',   'label' => __( 'Client Satisfaction',   'paksa-it-solutions' ), 'icon' => 'star' ),
) );

if ( empty( $stats ) ) { return; }
?>
<div class="pk-svc-stats-bar" aria-label="<?php esc_attr_e( 'Key statistics', 'paksa-it-solutions' ); ?>">
    <div class="container">
        <ul class="pk-svc-stats-list" role="list">
            <?php foreach ( $stats as $index => $stat ) : ?>
                <li class="pk-svc-stats-item pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( $index * 80 ); ?>">
                    <div class="pk-svc-stats-icon" aria-hidden="true">
                        <?php echo paksa_icon( $stat['icon'], 20 ); ?>
                    </div>
                    <span class="pk-svc-stats-value"><?php echo esc_html( $stat['value'] ); ?></span>
                    <span class="pk-svc-stats-label"><?php echo esc_html( $stat['label'] ); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
