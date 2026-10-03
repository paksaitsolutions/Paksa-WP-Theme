<?php
/**
 * Paksa IT Solutions — Single Product: Business Benefits
 *
 * Qualitative business capabilities — no invented statistics.
 * Content: _paksa_prod_benefits_list meta (pipe-delimited: Title | Description)
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$prod_id  = get_the_ID();
$eyebrow  = paksa_prod_meta( 'benefits_eyebrow', __( 'Benefits', 'paksa-it-solutions' ), $prod_id );
$heading  = paksa_prod_meta( 'benefits_heading', __( 'Business Benefits', 'paksa-it-solutions' ), $prod_id );
$raw_list = paksa_prod_meta_textarea( 'benefits_list', '', $prod_id );
$benefits = paksa_parse_pipe_list( $raw_list );

/**
 * Filter: paksa_product_benefits
 *
 * @param array $benefits  Parsed benefit items.
 * @param int   $prod_id   Product post ID.
 */
$benefits = apply_filters( 'paksa_product_benefits', $benefits, $prod_id );

if ( empty( $benefits ) ) {
    return;
}
?>
<section class="section pk-prod-benefits" aria-labelledby="pk-prod-benefits-heading">
    <div class="container">

        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow' => $eyebrow,
            'heading' => $heading,
        ) );
        ?>

        <?php
        $benefit_palettes = [
            [ 'bg' => '#eef3fe', 'icon_bg' => '#6192f8', 'accent' => '#6192f8' ],  // blue
            [ 'bg' => '#edfaf3', 'icon_bg' => '#12b76a', 'accent' => '#12b76a' ],  // green
            [ 'bg' => '#fff8ec', 'icon_bg' => '#f79009', 'accent' => '#f79009' ],  // amber
            [ 'bg' => '#fef0f0', 'icon_bg' => '#f04438', 'accent' => '#f04438' ],  // red
            [ 'bg' => '#f3f0ff', 'icon_bg' => '#7c3aed', 'accent' => '#7c3aed' ],  // purple
            [ 'bg' => '#e8f9fb', 'icon_bg' => '#0891b2', 'accent' => '#0891b2' ],  // cyan
        ];
        $benefit_icons = [
            '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline>',
            '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>',
            '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>',
            '<rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line>',
            '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>',
            '<line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>',
            '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>',
            '<circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>',
        ];
        ?>
        <div class="pk-prod-benefits-grid">
            <?php foreach ( $benefits as $i => $benefit ) :
                $pal  = $benefit_palettes[ $i % count( $benefit_palettes ) ];
                $icon = $benefit_icons[ $i % count( $benefit_icons ) ];
            ?>
                <div class="pk-prod-benefit-item pk-animate-on-scroll" data-anim="fade-up"
                     data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>"
                     style="--ben-bg:<?php echo esc_attr( $pal['bg'] ); ?>;--ben-icon:<?php echo esc_attr( $pal['icon_bg'] ); ?>;--ben-accent:<?php echo esc_attr( $pal['accent'] ); ?>">
                    <div class="pk-prod-benefit-icon" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><?php echo $icon; ?></svg>
                    </div>
                    <h3 class="pk-prod-benefit-title"><?php echo esc_html( $benefit['title'] ); ?></h3>
                    <?php if ( $benefit['desc'] ) : ?>
                        <p class="pk-prod-benefit-desc"><?php echo esc_html( $benefit['desc'] ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
