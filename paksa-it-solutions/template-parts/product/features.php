<?php
/**
 * Paksa IT Solutions — Single Product: Key Features
 * Includes real product screenshot above the features grid.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$prod_id  = get_the_ID();
$eyebrow  = paksa_prod_meta( 'features_eyebrow', __( 'Features', 'paksa-it-solutions' ), $prod_id );
$heading  = paksa_prod_meta( 'features_heading', __( 'Key Features', 'paksa-it-solutions' ), $prod_id );
$desc     = paksa_prod_meta_textarea( 'features_desc', '', $prod_id );
$features = paksa_parse_pipe_list( paksa_prod_meta_textarea( 'features_list', '', $prod_id ) );
$features = apply_filters( 'paksa_product_features', $features, $prod_id );

if ( empty( $features ) ) {
    return;
}

// Palette: bg, icon colour — cycles per card
$feat_palettes = [
    [ 'bg' => '#eef3fe', 'color' => '#6192f8' ],  // blue
    [ 'bg' => '#edfaf3', 'color' => '#12b76a' ],  // green
    [ 'bg' => '#fff8ec', 'color' => '#f79009' ],  // amber
    [ 'bg' => '#fef0f0', 'color' => '#f04438' ],  // red
    [ 'bg' => '#f3f0ff', 'color' => '#7c3aed' ],  // purple
    [ 'bg' => '#e8f9fb', 'color' => '#0891b2' ],  // cyan
    [ 'bg' => '#fdf2f8', 'color' => '#e11d8f' ],  // pink
    [ 'bg' => '#f0f9ff', 'color' => '#0ea5e9' ],  // sky
];

// Contextual icons per feature index (ERP feature set)
$feat_icons = [
    // 0 Finance
    '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
    // 1 Inventory / Box
    '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
    // 2 Procurement / Shopping cart
    '<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>',
    // 3 HR / Users
    '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
    // 4 Sales / TrendingUp
    '<polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>',
    // 5 AI / CPU
    '<rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/>',
    // 6 Reports / BarChart
    '<line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>',
    // 7 Workflow / GitBranch
    '<line x1="6" y1="3" x2="6" y2="15"/><circle cx="18" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><path d="M18 9a9 9 0 0 1-9 9"/>',
    // 8 Warehouse / Archive
    '<polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/><line x1="10" y1="12" x2="14" y2="12"/>',
    // 9 Payroll / CreditCard
    '<rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/>',
    // 10 Vendor / Briefcase
    '<rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
    // 11 Attendance / Clock
    '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
    // 12 Dashboard / Monitor
    '<rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>',
    // 13 Security / Shield
    '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
    // 14 Export / Upload
    '<polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>',
    // 15 Notifications / Bell
    '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
    // 16 Multi-branch / Globe
    '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
];

// Real screenshot — main ERP dashboard
$img_id  = (int) get_post_meta( $prod_id, '_paksa_prod_img_hero', true );
$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'paksa-large' ) : get_post_meta( $prod_id, '_paksa_prod_img_hero_url', true );
?>
<section class="section pk-prod-features" aria-labelledby="pk-prod-features-heading">
    <div class="container">

        <?php get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow'     => $eyebrow,
            'heading'     => $heading,
            'description' => $desc,
        ) ); ?>

        <?php if ( $img_url ) : ?>
            <div class="pk-prod-section-screenshot pk-animate-on-scroll" data-anim="fade-up">
                <img src="<?php echo esc_url( $img_url ); ?>"
                     alt="<?php echo esc_attr( __( 'Paksa ERP Dashboard', 'paksa-it-solutions' ) ); ?>"
                     loading="lazy"
                     decoding="async"
                     class="pk-prod-screenshot-img">
            </div>
        <?php endif; ?>

        <div class="pk-prod-features-grid">
            <?php foreach ( $features as $i => $feature ) :
                $pal  = $feat_palettes[ $i % count( $feat_palettes ) ];
                $icon = isset( $feat_icons[ $i ] ) ? $feat_icons[ $i ] : $feat_icons[ $i % count( $feat_icons ) ];
            ?>
                <div class="pk-prod-feature-item pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>">
                    <div class="pk-prod-feature-icon" aria-hidden="true"
                         style="background:<?php echo esc_attr( $pal['bg'] ); ?>;color:<?php echo esc_attr( $pal['color'] ); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><?php echo $icon; ?></svg>
                    </div>
                    <div class="pk-prod-feature-body">
                        <h3 class="pk-prod-feature-title"><?php echo esc_html( $feature['title'] ); ?></h3>
                        <?php if ( $feature['desc'] ) : ?>
                            <p class="pk-prod-feature-desc"><?php echo esc_html( $feature['desc'] ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
