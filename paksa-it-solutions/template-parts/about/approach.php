<?php
/**
 * Paksa IT Solutions — About: Our Approach
 * Numbered step cards with colour palette, matching product module style.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$page_id = get_the_ID();
$intro   = paksa_page_meta_textarea( 'approach_content', '', $page_id );
$raw     = paksa_page_meta_textarea( 'approach_steps', '', $page_id );
$steps   = paksa_parse_pipe_list( $raw );

if ( ! $intro && empty( $steps ) ) { return; }

// 8-colour number palette (same as product module numbers)
$num_colors = [ '#6192f8', '#12b76a', '#f79009', '#f04438', '#7c3aed', '#0891b2', '#e11d8f', '#0ea5e9' ];

$step_icons = [
    '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>',
    '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
    '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>',
    '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
];
?>
<section class="section pk-about-approach" aria-labelledby="pk-about-approach-heading">
    <div class="container">
        <div class="section-header">
            <span class="pk-about-eyebrow">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="6" y1="3" x2="6" y2="15"/><circle cx="18" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><path d="M18 9a9 9 0 0 1-9 9"/></svg>
                How We Work
            </span>
            <h2 id="pk-about-approach-heading">Our Approach</h2>
            <?php if ( $intro ) : ?>
                <p><?php echo esc_html( $intro ); ?></p>
            <?php endif; ?>
        </div>
        <?php if ( ! empty( $steps ) ) : ?>
            <div class="pk-about-approach-grid">
                <?php foreach ( $steps as $i => $step ) :
                    $num_color = $num_colors[ $i % count( $num_colors ) ];
                    $icon      = $step_icons[ $i % count( $step_icons ) ];
                    $num       = str_pad( $i + 1, 2, '0', STR_PAD_LEFT );
                ?>
                    <div class="pk-about-approach-card pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $i % 4 ) * 80 ); ?>">
                        <div class="pk-about-approach-top">
                            <span class="pk-about-approach-num" style="color:<?php echo esc_attr( $num_color ); ?>"><?php echo esc_html( $num ); ?></span>
                            <div class="pk-about-approach-icon" style="background:<?php echo esc_attr( $num_color ); ?>1a;color:<?php echo esc_attr( $num_color ); ?>" aria-hidden="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?php echo $icon; // phpcs:ignore ?></svg>
                            </div>
                        </div>
                        <h3 class="pk-about-approach-title"><?php echo esc_html( $step['title'] ); ?></h3>
                        <?php if ( $step['desc'] ) : ?>
                            <p class="pk-about-approach-desc"><?php echo esc_html( $step['desc'] ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
