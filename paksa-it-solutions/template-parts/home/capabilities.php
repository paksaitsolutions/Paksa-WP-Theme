<?php
/**
 * Paksa IT Solutions — Homepage: What We Build (Capabilities)
 * Content: Static array — editable via filter for extensibility
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = paksa_get_option( 'paksa_capabilities_eyebrow', __( 'What We Build', 'paksa-it-solutions' ) );
$heading     = paksa_get_option( 'paksa_capabilities_heading', __( 'Technology Built Around Your Business', 'paksa-it-solutions' ) );
$description = paksa_get_option( 'paksa_capabilities_description', __( 'From enterprise platforms to intelligent automation — we build the systems that power serious business operations.', 'paksa-it-solutions' ) );

/**
 * Filter: paksa_capabilities_items
 * Allows child themes or plugins to modify capability cards.
 */
$capabilities = apply_filters( 'paksa_capabilities_items', array(
    array(
        'icon'        => 'enterprise',
        'title'       => __( 'Enterprise Software', 'paksa-it-solutions' ),
        'description' => __( 'Business platforms designed around operational requirements — finance, inventory, HR, procurement and more.', 'paksa-it-solutions' ),
        'featured'    => true,
    ),
    array(
        'icon'        => 'custom',
        'title'       => __( 'Custom Software', 'paksa-it-solutions' ),
        'description' => __( 'Purpose-built applications for unique workflows and processes that off-the-shelf software cannot address.', 'paksa-it-solutions' ),
        'featured'    => false,
    ),
    array(
        'icon'        => 'ai',
        'title'       => __( 'AI & Machine Learning', 'paksa-it-solutions' ),
        'description' => __( 'Predictive intelligence, automation and intelligent decision support built into your business systems.', 'paksa-it-solutions' ),
        'featured'    => true,
    ),
    array(
        'icon'        => 'bi',
        'title'       => __( 'Business Intelligence', 'paksa-it-solutions' ),
        'description' => __( 'Dashboards, analytics and decision intelligence that turn operational data into clear business insight.', 'paksa-it-solutions' ),
        'featured'    => false,
    ),
    array(
        'icon'        => 'ecommerce',
        'title'       => __( 'Ecommerce Solutions', 'paksa-it-solutions' ),
        'description' => __( 'Connected commerce platforms and operational systems that integrate with your wider business infrastructure.', 'paksa-it-solutions' ),
        'featured'    => false,
    ),
    array(
        'icon'        => 'integration',
        'title'       => __( 'System Integration', 'paksa-it-solutions' ),
        'description' => __( 'Connect ERP, ecommerce, APIs and business applications so data and workflows move without friction.', 'paksa-it-solutions' ),
        'featured'    => false,
    ),
) );
?>
<section class="section section-alt pk-capabilities" id="solutions" aria-labelledby="pk-capabilities-heading">
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow'     => $eyebrow,
            'heading'     => $heading,
            'description' => $description,
        ) );
        ?>

        <div class="pk-capabilities-grid">
            <?php foreach ( $capabilities as $index => $cap ) : ?>
                <article class="pk-cap-card<?php echo ! empty( $cap['featured'] ) ? ' pk-cap-card--featured' : ''; ?> pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $index % 3 ) * 80 ); ?>">
                    <div class="pk-cap-icon" aria-hidden="true">
                        <?php echo paksa_get_capability_icon( $cap['icon'] ); ?>
                    </div>
                    <h3 class="pk-cap-title"><?php echo esc_html( $cap['title'] ); ?></h3>
                    <p class="pk-cap-description"><?php echo esc_html( $cap['description'] ); ?></p>
                    <span class="pk-cap-arrow" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="8" x2="13" y2="8"></line>
                            <polyline points="9,4 13,8 9,12"></polyline>
                        </svg>
                    </span>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
