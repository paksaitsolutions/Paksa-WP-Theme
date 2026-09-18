<?php
/**
 * Paksa IT Solutions — Homepage: What We Do (Capabilities)
 * Asymmetric bento grid — not 3 equal cards
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$heading     = paksa_get_option( 'paksa_capabilities_heading',     __( 'AI-Driven & Data-Focused IT Solutions', 'paksa-it-solutions' ) );
$description = paksa_get_option( 'paksa_capabilities_description', __( 'We deliver intelligent, scalable, and data-driven technology solutions that help businesses automate operations, gain actionable insights, and build future-ready digital systems.', 'paksa-it-solutions' ) );

$capabilities = apply_filters( 'paksa_capabilities_items', array(
    array(
        'icon'        => 'automation',
        'title'       => __( 'Automation AI', 'paksa-it-solutions' ),
        'description' => __( 'Transform your business operations with Automation AI, automating repetitive tasks and enabling intelligent workflows that improve productivity, accuracy, and performance.', 'paksa-it-solutions' ),
        'size'        => 'large',
    ),
    array(
        'icon'        => 'analytics',
        'title'       => __( 'Data & Analytics', 'paksa-it-solutions' ),
        'description' => __( 'Our Data & Analytics solutions empower organizations to transform data into actionable intelligence, enabling smarter decisions and long-term strategic growth.', 'paksa-it-solutions' ),
        'size'        => 'normal',
    ),
    array(
        'icon'        => 'ai',
        'title'       => __( 'AI & ML Solutions', 'paksa-it-solutions' ),
        'description' => __( 'Our AI & ML solutions help organizations enhance performance by leveraging intelligent models, predictive analytics, and data-driven automation.', 'paksa-it-solutions' ),
        'size'        => 'normal',
    ),
    array(
        'icon'        => 'digital',
        'title'       => __( 'Intelligent Digital Solutions', 'paksa-it-solutions' ),
        'description' => __( 'Transform your digital operations with intelligent, data-driven solutions designed to improve performance, scalability, and business efficiency.', 'paksa-it-solutions' ),
        'size'        => 'wide',
    ),
) );
?>
<section class="section pk-capabilities" id="solutions" aria-labelledby="pk-capabilities-heading">
    <div class="container">

        <header class="pk-capabilities-header pk-animate-on-scroll" data-anim="fade-up">
            <div class="pk-capabilities-header-text">
                <p class="pk-section-label"><?php esc_html_e( 'What We Do', 'paksa-it-solutions' ); ?></p>
                <h2 id="pk-capabilities-heading"><?php echo esc_html( $heading ); ?></h2>
            </div>
            <p class="pk-capabilities-header-desc"><?php echo esc_html( $description ); ?></p>
        </header>

        <div class="pk-cap-bento">
            <?php foreach ( $capabilities as $index => $cap ) : ?>
                <article class="pk-cap-cell pk-cap-cell--<?php echo esc_attr( $cap['size'] ); ?> pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( $index * 60 ); ?>">
                    <div class="pk-cap-cell-icon" aria-hidden="true">
                        <?php echo paksa_get_capability_icon( $cap['icon'] ); ?>
                    </div>
                    <h3 class="pk-cap-cell-title"><?php echo esc_html( $cap['title'] ); ?></h3>
                    <p class="pk-cap-cell-desc"><?php echo esc_html( $cap['description'] ); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
