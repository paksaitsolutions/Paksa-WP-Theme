<?php
/**
 * Paksa IT Solutions — About: Values
 * Product benefit-style coloured cards with icons.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$page_id = get_the_ID();
$raw     = paksa_page_meta_textarea( 'values_list', '', $page_id );
$values  = paksa_parse_pipe_list( $raw );

if ( empty( $values ) ) { return; }

// Same 6-colour palette as product benefits
$palettes = [
    [ 'bg' => '#eef3fe', 'icon_bg' => '#6192f8', 'accent' => '#6192f8' ],
    [ 'bg' => '#edfaf3', 'icon_bg' => '#12b76a', 'accent' => '#12b76a' ],
    [ 'bg' => '#fff8ec', 'icon_bg' => '#f79009', 'accent' => '#f79009' ],
    [ 'bg' => '#fef0f0', 'icon_bg' => '#f04438', 'accent' => '#f04438' ],
    [ 'bg' => '#f3f0ff', 'icon_bg' => '#7c3aed', 'accent' => '#7c3aed' ],
    [ 'bg' => '#e8f9fb', 'icon_bg' => '#0891b2', 'accent' => '#0891b2' ],
];

$icons = [
    '<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>',
    '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/>',
    '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
    '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
    '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
];
?>
<section class="section pk-about-values" aria-labelledby="pk-about-values-heading">
    <div class="container">
        <div class="section-header">
            <span class="pk-about-eyebrow">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                What We Stand For
            </span>
            <h2 id="pk-about-values-heading">Our Values</h2>
        </div>
        <div class="pk-about-values-grid">
            <?php foreach ( $values as $i => $value ) :
                $pal  = $palettes[ $i % count( $palettes ) ];
                $icon = $icons[ $i % count( $icons ) ];
            ?>
                <div class="pk-about-value-card pk-animate-on-scroll" data-anim="fade-up"
                     data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>"
                     style="--val-bg:<?php echo esc_attr( $pal['bg'] ); ?>;--val-icon:<?php echo esc_attr( $pal['icon_bg'] ); ?>;--val-accent:<?php echo esc_attr( $pal['accent'] ); ?>">
                    <div class="pk-about-value-icon" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><?php echo $icon; // phpcs:ignore ?></svg>
                    </div>
                    <h3 class="pk-about-value-title"><?php echo esc_html( $value['title'] ); ?></h3>
                    <?php if ( $value['desc'] ) : ?>
                        <p class="pk-about-value-desc"><?php echo esc_html( $value['desc'] ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
