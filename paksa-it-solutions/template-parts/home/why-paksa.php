<?php
/**
 * Paksa IT Solutions — Homepage: Why Paksa
 * Content: Customizer headings + filter-extensible principles
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = paksa_get_option( 'paksa_why_eyebrow', __( 'Why Paksa', 'paksa-it-solutions' ) );
$heading     = paksa_get_option( 'paksa_why_heading', __( 'Technology With Business Thinking Behind It.', 'paksa-it-solutions' ) );
$description = paksa_get_option( 'paksa_why_description', __( 'We combine deep technical capability with genuine understanding of how businesses operate.', 'paksa-it-solutions' ) );

$principles = apply_filters( 'paksa_why_principles', array(
    array(
        'title' => __( 'Business-First Engineering', 'paksa-it-solutions' ),
        'desc'  => __( 'Technology decisions begin with understanding the business — its operations, constraints and objectives.', 'paksa-it-solutions' ),
        'icon'  => 'business',
    ),
    array(
        'title' => __( 'Intelligent by Design', 'paksa-it-solutions' ),
        'desc'  => __( 'AI is applied where it creates meaningful, measurable value — not as a marketing feature.', 'paksa-it-solutions' ),
        'icon'  => 'intelligent',
    ),
    array(
        'title' => __( 'Scalable Architecture', 'paksa-it-solutions' ),
        'desc'  => __( 'Solutions are designed to evolve as the business grows, without requiring complete rebuilds.', 'paksa-it-solutions' ),
        'icon'  => 'scalable',
    ),
    array(
        'title' => __( 'Connected Systems', 'paksa-it-solutions' ),
        'desc'  => __( 'Data and workflows are designed to work together rather than remaining isolated in separate systems.', 'paksa-it-solutions' ),
        'icon'  => 'connected',
    ),
    array(
        'title' => __( 'Security & Governance', 'paksa-it-solutions' ),
        'desc'  => __( 'Security, permissions and accountability are considered from the architecture level — not added later.', 'paksa-it-solutions' ),
        'icon'  => 'security',
    ),
    array(
        'title' => __( 'Long-Term Partnership', 'paksa-it-solutions' ),
        'desc'  => __( 'We build for sustainable use and ongoing evolution — not just initial deployment and handover.', 'paksa-it-solutions' ),
        'icon'  => 'partnership',
    ),
) );
?>
<section class="section section-alt pk-why" aria-labelledby="pk-why-heading">
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow'     => $eyebrow,
            'heading'     => $heading,
            'description' => $description,
        ) );
        ?>

        <div class="pk-why-grid">
            <?php foreach ( $principles as $index => $principle ) : ?>
                <div class="pk-why-item pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $index % 3 ) * 80 ); ?>">
                    <div class="pk-why-icon" aria-hidden="true">
                        <?php echo paksa_get_why_icon( $principle['icon'] ); ?>
                    </div>
                    <h3 class="pk-why-title"><?php echo esc_html( $principle['title'] ); ?></h3>
                    <p class="pk-why-desc"><?php echo esc_html( $principle['desc'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
