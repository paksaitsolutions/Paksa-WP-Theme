<?php
/**
 * Paksa IT Solutions — About: Why Choose Us
 * Product benefit-style coloured cards with icons.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$page_id = get_the_ID();
$intro   = paksa_page_meta_textarea( 'why_intro', '', $page_id );
$raw     = paksa_page_meta_textarea( 'why_list', '', $page_id );
$items   = paksa_parse_pipe_list( $raw );

if ( empty( $items ) ) { return; }

$palettes = [
    [ 'bg' => '#eef3fe', 'icon_bg' => '#6192f8', 'accent' => '#6192f8' ],
    [ 'bg' => '#edfaf3', 'icon_bg' => '#12b76a', 'accent' => '#12b76a' ],
    [ 'bg' => '#fff8ec', 'icon_bg' => '#f79009', 'accent' => '#f79009' ],
    [ 'bg' => '#fef0f0', 'icon_bg' => '#f04438', 'accent' => '#f04438' ],
    [ 'bg' => '#f3f0ff', 'icon_bg' => '#7c3aed', 'accent' => '#7c3aed' ],
    [ 'bg' => '#e8f9fb', 'icon_bg' => '#0891b2', 'accent' => '#0891b2' ],
];

$icons = [
    '<rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/>',
    '<rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
    '<polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/>',
    '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
    '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/>',
    '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>',
];
?>
<section class="section section-alt pk-about-why" aria-labelledby="pk-about-why-heading">
    <div class="container">
        <div class="section-header">
            <span class="pk-about-eyebrow">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                Why Choose Us
            </span>
            <h2 id="pk-about-why-heading">Why Choose Paksa IT Solutions</h2>
            <?php if ( $intro ) : ?>
                <p><?php echo esc_html( $intro ); ?></p>
            <?php endif; ?>
        </div>
        <div class="pk-about-why-grid">
            <?php foreach ( $items as $i => $item ) :
                $pal  = $palettes[ $i % count( $palettes ) ];
                $icon = $icons[ $i % count( $icons ) ];
            ?>
                <div class="pk-about-why-card pk-animate-on-scroll" data-anim="fade-up"
                     data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>"
                     style="--why-bg:<?php echo esc_attr( $pal['bg'] ); ?>;--why-icon:<?php echo esc_attr( $pal['icon_bg'] ); ?>;--why-accent:<?php echo esc_attr( $pal['accent'] ); ?>">
                    <div class="pk-about-why-icon" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><?php echo $icon; // phpcs:ignore ?></svg>
                    </div>
                    <h3 class="pk-about-why-title"><?php echo esc_html( $item['title'] ); ?></h3>
                    <?php if ( $item['desc'] ) : ?>
                        <p class="pk-about-why-desc"><?php echo esc_html( $item['desc'] ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
