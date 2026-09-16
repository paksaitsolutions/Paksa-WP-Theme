<?php
/**
 * Paksa IT Solutions — Services Guide
 *
 * Comprehensive documentation for all services section patterns,
 * CSS classes, icons, animations, and customization options.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = paksa_get_option( 'paksa_services_eyebrow', __( 'Our Services', 'paksa-it-solutions' ) );
$heading     = paksa_get_option( 'paksa_services_heading', __( 'What We Do', 'paksa-it-solutions' ) );
$description = paksa_get_option( 'paksa_services_description', __( 'Enterprise technology solutions for modern businesses.', 'paksa-it-solutions' ) );
$columns     = paksa_get_option( 'paksa_services_columns', '3' );
$layout      = paksa_get_option( 'paksa_services_layout', 'grid' ); // grid, tabs, process, list

/**
 * Filter: paksa_services_items
 * Allows dynamic population of service items.
 *
 * Each item: array(
 *     'title'       => string,
 *     'description' => string,
 *     'icon'        => string (SVG markup or icon class),
 *     'url'         => string (optional link),
 *     'highlight'   => bool (featured card),
 * )
 */
$items = apply_filters( 'paksa_services_items', array(
    array(
        'title'       => __( 'Enterprise Software', 'paksa-it-solutions' ),
        'description' => __( 'Custom software built for your business.', 'paksa-it-solutions' ),
        'icon'        => '<svg>...</svg>',
    ),
    array(
        'title'       => __( 'AI &amp; ML', 'paksa-it-solutions' ),
        'description' => __( 'Intelligent automation and analytics.', 'paksa-it-solutions' ),
        'icon'        => '<svg>...</svg>',
    ),
) );

if ( empty( $items ) ) {
    return;
}
?>
<section class="section section-alt pk-services" aria-labelledby="pk-services-heading">
    <div class="container">
        <?php if ( 'process' === $layout ) : ?>
            <?php get_template_part( 'template-parts/services/process' ); ?>
        <?php else : ?>
            <div class="pk-services-header pk-animate-on-scroll" data-anim="fade-up">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $heading ) : ?>
                    <h2 id="pk-services-heading"><?php echo esc_html( $heading ); ?></h2>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="body-large"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>
            </div>

            <?php if ( 'tabs' === $layout ) : ?>
                <?php get_template_part( 'template-parts/services/tabs' ); ?>
            <?php else : ?>
                <div class="pk-svc-grid pk-svc-grid-<?php echo esc_attr( $columns ); ?>">
                    <?php foreach ( $items as $index => $item ) : ?>
                        <?php
                        $icon = isset( $item['icon'] ) ? $item['icon'] : '';
                        $url  = isset( $item['url'] ) ? $item['url'] : '#';
                        $cls  = isset( $item['highlight'] ) && $item['highlight'] ? ' pk-svc-card-highlight' : '';
                        ?>
                        <article class="pk-svc-card<?php echo esc_attr( $cls ); ?> pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( $index * 80 ); ?>">
                            <?php if ( $icon ) : ?>
                                <div class="pk-svc-card-icon" aria-hidden="true">
                                    <?php echo $icon; ?>
                                </div>
                            <?php endif; ?>

                            <h3 class="pk-svc-card-title"><?php echo esc_html( $item['title'] ); ?></h3>
                            <p class="pk-svc-card-desc"><?php echo esc_html( $item['description'] ); ?></p>

                            <a href="<?php echo esc_url( $url ); ?>" class="pk-svc-card-link">
                                <?php esc_html_e( 'Learn More', 'paksa-it-solutions' ); ?>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
