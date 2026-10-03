<?php
/**
 * Paksa IT Solutions — Single Product: Hero
 *
 * Dark hero matching the service single page pattern:
 * dot-grid background, glow, eyebrow pill, trust items, stat cards.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$prod_id = get_the_ID();
$eyebrow = paksa_prod_meta( 'hero_eyebrow', paksa_prod_meta( 'category_label', __( 'Software Solution', 'paksa-it-solutions' ), $prod_id ), $prod_id );
$heading = paksa_prod_meta( 'hero_heading', get_the_title(), $prod_id );
$desc    = paksa_prod_meta_textarea( 'hero_description', get_the_excerpt(), $prod_id );
$cta1_t  = paksa_prod_meta( 'hero_cta1_text', __( 'Request a Free Demo', 'paksa-it-solutions' ), $prod_id );
$cta1_u  = paksa_prod_meta_url( 'hero_cta1_url', '/contact/', $prod_id );
$cta2_t  = paksa_prod_meta( 'hero_cta2_text', __( 'Explore Features', 'paksa-it-solutions' ), $prod_id );
$cta2_u  = paksa_prod_meta_url( 'hero_cta2_url', '#pk-product-overview', $prod_id );
$badge   = paksa_prod_meta( 'badge', '', $prod_id );

// Trust items — one per line
$trust_raw = paksa_prod_meta_textarea( 'hero_trust_items', '', $prod_id );
$trust     = $trust_raw ? array_filter( array_map( 'trim', explode( "\n", $trust_raw ) ) ) : array();

// Stats — fall back to sensible defaults for ERP
$stat1_val   = paksa_prod_meta( 'stat1_val',   '10+',                    $prod_id );
$stat1_label = paksa_prod_meta( 'stat1_label', 'ERP Modules',            $prod_id );
$stat2_val   = paksa_prod_meta( 'stat2_val',   '10+',                    $prod_id );
$stat2_label = paksa_prod_meta( 'stat2_label', 'Industries Served',      $prod_id );
$stat3_val   = paksa_prod_meta( 'stat3_val',   '100%',                   $prod_id );
$stat3_label = paksa_prod_meta( 'stat3_label', 'In-house Development',   $prod_id );
$stat4_val   = paksa_prod_meta( 'stat4_val',   '5★',                     $prod_id );
$stat4_label = paksa_prod_meta( 'stat4_label', 'Client Satisfaction',    $prod_id );

// Eyebrow fallback from taxonomy
if ( ! $eyebrow ) {
    $terms = get_the_terms( $prod_id, 'paksa_product_cat' );
    if ( $terms && ! is_wp_error( $terms ) ) {
        $eyebrow = $terms[0]->name;
    }
}
?>
<section class="pk-prod-hero-dark" aria-labelledby="pk-prod-hero-heading">
    <div class="pk-prod-hero-dark__dots" aria-hidden="true"></div>
    <div class="pk-prod-hero-dark__glow" aria-hidden="true"></div>

    <div class="container">
        <div class="pk-prod-hero-dark__inner">

            <div class="pk-prod-hero-dark__content pk-animate-on-scroll" data-anim="fade-up">

                <?php
                // Breadcrumb inside the dark hero
                if ( function_exists( 'paksa_breadcrumbs' ) && ! is_front_page() ) {
                    echo '<div class="pk-prod-hero-dark__breadcrumb">';
                    paksa_breadcrumbs();
                    echo '</div>';
                }
                ?>

                <div class="pk-prod-hero-dark__eyebrow">
                    <?php echo paksa_icon( 'ai', 14 ); ?>
                    <?php echo esc_html( $eyebrow ); ?>
                    <?php if ( $badge ) : ?>
                        <span class="pk-prod-hero-dark__badge"><?php echo esc_html( $badge ); ?></span>
                    <?php endif; ?>
                </div>

                <h1 id="pk-prod-hero-heading" class="pk-prod-hero-dark__heading">
                    <?php echo esc_html( $heading ); ?>
                </h1>

                <?php if ( $desc ) : ?>
                    <p class="pk-prod-hero-dark__desc"><?php echo esc_html( $desc ); ?></p>
                <?php endif; ?>

                <div class="pk-prod-hero-dark__actions">
                    <?php if ( $cta1_t && $cta1_u ) : ?>
                        <a href="<?php echo esc_url( $cta1_u ); ?>" class="pk-btn-primary">
                            <?php echo esc_html( $cta1_t ); ?>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if ( $cta2_t && $cta2_u ) : ?>
                        <a href="<?php echo esc_url( $cta2_u ); ?>" class="pk-btn-ghost-inv">
                            <?php echo esc_html( $cta2_t ); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <?php if ( ! empty( $trust ) ) : ?>
                    <div class="pk-prod-hero-dark__trust">
                        <?php foreach ( $trust as $item ) : ?>
                            <span class="pk-prod-hero-dark__trust-item">
                                <?php echo paksa_icon( 'check', 14 ); ?>
                                <?php echo esc_html( $item ); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="pk-prod-hero-dark__stats pk-animate-on-scroll" data-anim="fade-up" data-delay="150" aria-hidden="true">
                <div class="pk-prod-hero-dark__stat pk-prod-hero-dark__stat--featured">
                    <div class="pk-prod-hero-dark__stat-val"><?php echo esc_html( $stat1_val ); ?></div>
                    <div class="pk-prod-hero-dark__stat-label"><?php echo esc_html( $stat1_label ); ?></div>
                </div>
                <div class="pk-prod-hero-dark__stat">
                    <div class="pk-prod-hero-dark__stat-val"><?php echo esc_html( $stat2_val ); ?></div>
                    <div class="pk-prod-hero-dark__stat-label"><?php echo esc_html( $stat2_label ); ?></div>
                </div>
                <div class="pk-prod-hero-dark__stat">
                    <div class="pk-prod-hero-dark__stat-val"><?php echo esc_html( $stat3_val ); ?></div>
                    <div class="pk-prod-hero-dark__stat-label"><?php echo esc_html( $stat3_label ); ?></div>
                </div>
                <div class="pk-prod-hero-dark__stat">
                    <div class="pk-prod-hero-dark__stat-val"><?php echo esc_html( $stat4_val ); ?></div>
                    <div class="pk-prod-hero-dark__stat-label"><?php echo esc_html( $stat4_label ); ?></div>
                </div>
            </div>

        </div>
    </div>
</section>
