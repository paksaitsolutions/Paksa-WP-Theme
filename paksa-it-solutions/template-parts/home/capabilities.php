<?php
/**
 * Paksa IT Solutions — Homepage: What We Do (Capabilities)
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$heading     = paksa_get_option( 'paksa_capabilities_heading',     __( 'AI-Driven & Data-Focused IT Solutions', 'paksa-it-solutions' ) );
$description = paksa_get_option( 'paksa_capabilities_description', __( 'We deliver intelligent, scalable, and data-driven technology solutions that help businesses automate operations, gain actionable insights, and build future-ready digital systems.', 'paksa-it-solutions' ) );

$capabilities = apply_filters( 'paksa_capabilities_items', array(
    array(
        'icon'        => 'ai',
        'title'       => __( 'AI & ML Solutions', 'paksa-it-solutions' ),
        'description' => __( 'Predictive models, NLP, computer vision and intelligent automation built into your business workflows.', 'paksa-it-solutions' ),
        'tag'         => 'AI / ML',
        'color'       => 'blue',
    ),
    array(
        'icon'        => 'automation',
        'title'       => __( 'AI Automation', 'paksa-it-solutions' ),
        'description' => __( 'Eliminate repetitive tasks with intelligent process automation that scales with your operations.', 'paksa-it-solutions' ),
        'tag'         => 'Automation',
        'color'       => 'indigo',
    ),
    array(
        'icon'        => 'analytics',
        'title'       => __( 'Data Science & Analytics', 'paksa-it-solutions' ),
        'description' => __( 'Turn raw data into actionable intelligence with dashboards, pipelines and advanced analytics.', 'paksa-it-solutions' ),
        'tag'         => 'Data',
        'color'       => 'cyan',
    ),
    array(
        'icon'        => 'digital',
        'title'       => __( 'Software Development', 'paksa-it-solutions' ),
        'description' => __( 'Custom enterprise software, ERPs, SaaS platforms and integrations built for scale.', 'paksa-it-solutions' ),
        'tag'         => 'Dev',
        'color'       => 'violet',
    ),
) );


?>
<section class="pk-capabilities section" id="solutions" aria-labelledby="pk-capabilities-heading">
    <div class="container">

        <div class="pk-cap-header pk-animate-on-scroll" data-anim="fade-up">
            <div class="pk-cap-header-left">
                <span class="pk-section-label"><?php esc_html_e( 'What We Do', 'paksa-it-solutions' ); ?></span>
                <h2 id="pk-capabilities-heading"><?php echo esc_html( $heading ); ?></h2>
            </div>
            <p class="pk-cap-header-desc"><?php echo esc_html( $description ); ?></p>
        </div>

        <div class="pk-cap-grid">
            <?php foreach ( $capabilities as $i => $cap ) : ?>
                <article class="pk-cap-card pk-cap-card--<?php echo esc_attr( $cap['color'] ); ?> pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( $i * 80 ); ?>">
                    <div class="pk-cap-card-top">
                        <div class="pk-cap-card-icon" aria-hidden="true">
                            <?php echo paksa_icon( $cap['icon'] ); ?>
                        </div>
                        <span class="pk-cap-tag"><?php echo esc_html( $cap['tag'] ); ?></span>
                    </div>
                    <h3 class="pk-cap-card-title"><?php echo esc_html( $cap['title'] ); ?></h3>
                    <p class="pk-cap-card-desc"><?php echo esc_html( $cap['description'] ); ?></p>
                    <div class="pk-cap-card-arrow" aria-hidden="true">
                        <?php echo paksa_icon( 'arrow', 16 ); ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
