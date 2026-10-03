<?php
/**
 * Paksa IT Solutions — Single Product: Modules
 * Alternating split layout with real module screenshots.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$prod_id = get_the_ID();
$eyebrow = paksa_prod_meta( 'modules_eyebrow', __( 'Modules', 'paksa-it-solutions' ), $prod_id );
$heading = paksa_prod_meta( 'modules_heading', __( 'Product Modules', 'paksa-it-solutions' ), $prod_id );
$desc    = paksa_prod_meta_textarea( 'modules_desc', '', $prod_id );
$modules = paksa_parse_pipe_list( paksa_prod_meta_textarea( 'modules_list', '', $prod_id ) );
$modules = apply_filters( 'paksa_product_modules', $modules, $prod_id );

if ( empty( $modules ) ) {
    return;
}

// Map module index → sideloaded image meta key
$module_images = array(
    0  => 'img_finance',      // Finance & Accounting
    1  => 'img_inventory',    // Inventory Management
    2  => 'img_procurement',  // Procurement
    3  => 'img_sales',        // Sales
    4  => 'img_hrms',         // HRMS
    5  => 'img_ai',           // AI Analytics
    6  => 'img_reports',      // Reporting
    7  => 'img_ai_cmd',       // Workflow / AI Command
    8  => 'img_inventory2',   // Warehouse
    9  => 'img_cashflow',     // Payroll / Cash Flow
    10 => 'img_procurement',  // Vendor
    11 => 'img_hrms_emp',     // Attendance
    12 => 'img_ai_suggest',   // Executive Dashboard
    13 => 'img_anomaly',      // Security
    14 => 'img_reports',      // Export
    15 => 'img_ai_cmd',       // Notifications
    16 => 'img_finance',      // Multi-Branch
);

// Featured modules to show in split layout (first 6 with screenshots)
$featured_count = 6;

$num_colors = [ '#6192f8', '#12b76a', '#f79009', '#f04438', '#7c3aed', '#0891b2', '#e11d8f', '#0ea5e9' ];
?>
<section class="section section-alt pk-prod-modules" aria-labelledby="pk-prod-modules-heading">
    <div class="container">

        <?php get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow'     => $eyebrow,
            'heading'     => $heading,
            'description' => $desc,
        ) ); ?>

        <?php // First 6 modules: alternating split with screenshot ?>
        <div class="pk-prod-modules-split">
            <?php foreach ( array_slice( $modules, 0, $featured_count ) as $i => $module ) :
                $img_key = isset( $module_images[ $i ] ) ? $module_images[ $i ] : '';
                $img_id  = $img_key ? (int) get_post_meta( $prod_id, '_paksa_prod_' . $img_key, true ) : 0;
                $img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'paksa-large' ) : ( $img_key ? get_post_meta( $prod_id, '_paksa_prod_' . $img_key . '_url', true ) : '' );
                $reverse = ( $i % 2 !== 0 ) ? ' pk-prod-modules-split__row--reverse' : '';
            ?>
                <div class="pk-prod-modules-split__row<?php echo esc_attr( $reverse ); ?> pk-animate-on-scroll" data-anim="fade-up">
                    <div class="pk-prod-modules-split__text">
                        <div class="pk-prod-module-number" aria-hidden="true" style="color:<?php echo esc_attr( $num_colors[ $i % count( $num_colors ) ] ); ?>"><?php echo esc_html( str_pad( $i + 1, 2, '0', STR_PAD_LEFT ) ); ?></div>
                        <h3 class="pk-prod-module-title"><?php echo esc_html( $module['title'] ); ?></h3>
                        <?php if ( $module['desc'] ) : ?>
                            <p class="pk-prod-module-desc"><?php echo esc_html( $module['desc'] ); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if ( $img_url ) : ?>
                        <div class="pk-prod-modules-split__visual">
                            <img src="<?php echo esc_url( $img_url ); ?>"
                                 alt="<?php echo esc_attr( $module['title'] ); ?>"
                                 loading="lazy"
                                 decoding="async"
                                 class="pk-prod-screenshot-img">
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php // Remaining modules: compact grid ?>
        <?php if ( count( $modules ) > $featured_count ) : ?>
            <div class="pk-prod-modules-grid" role="list">
                <?php foreach ( array_slice( $modules, $featured_count ) as $i => $module ) : ?>
                    <div class="pk-prod-module-item pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>" role="listitem">
                        <div class="pk-prod-module-number" aria-hidden="true" style="color:<?php echo esc_attr( $num_colors[ ( $i + $featured_count ) % count( $num_colors ) ] ); ?>"><?php echo esc_html( str_pad( $i + $featured_count + 1, 2, '0', STR_PAD_LEFT ) ); ?></div>
                        <div class="pk-prod-module-body">
                            <h3 class="pk-prod-module-title"><?php echo esc_html( $module['title'] ); ?></h3>
                            <?php if ( $module['desc'] ) : ?>
                                <p class="pk-prod-module-desc"><?php echo esc_html( $module['desc'] ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
