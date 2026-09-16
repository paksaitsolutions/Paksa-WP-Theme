<?php
/**
 * Paksa IT Solutions — Homepage: AI & Business Intelligence
 * Content: Filter-extensible static array
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$intelligence_cards = apply_filters( 'paksa_intelligence_cards', array(
    array(
        'title' => __( 'KPI Monitoring', 'paksa-it-solutions' ),
        'desc'  => __( 'Real-time visibility into the metrics that matter most to your business operations.', 'paksa-it-solutions' ),
        'icon'  => 'kpi',
    ),
    array(
        'title' => __( 'Predictive Analytics', 'paksa-it-solutions' ),
        'desc'  => __( 'Machine learning models that identify patterns and forecast future business outcomes.', 'paksa-it-solutions' ),
        'icon'  => 'predict',
    ),
    array(
        'title' => __( 'Anomaly Detection', 'paksa-it-solutions' ),
        'desc'  => __( 'Automated identification of unusual patterns in operational data before they become problems.', 'paksa-it-solutions' ),
        'icon'  => 'anomaly',
    ),
    array(
        'title' => __( 'Intelligent Recommendations', 'paksa-it-solutions' ),
        'desc'  => __( 'AI-driven suggestions that support better operational and strategic decisions.', 'paksa-it-solutions' ),
        'icon'  => 'recommend',
    ),
) );

$data_flow = array(
    __( 'Data', 'paksa-it-solutions' ),
    __( 'Analytics', 'paksa-it-solutions' ),
    __( 'Patterns', 'paksa-it-solutions' ),
    __( 'Predictions', 'paksa-it-solutions' ),
    __( 'Decisions', 'paksa-it-solutions' ),
);

$eyebrow = paksa_get_option( 'paksa_intelligence_eyebrow', __( 'AI & Business Intelligence', 'paksa-it-solutions' ) );
$heading = paksa_get_option( 'paksa_intelligence_heading', __( 'Turn Business Data Into Intelligence.', 'paksa-it-solutions' ) );
$desc    = paksa_get_option( 'paksa_intelligence_description', __( 'We apply AI and analytics where they create genuine business value — not as a feature, but as a capability embedded in your operations.', 'paksa-it-solutions' ) );
?>
<section class="section section-alt pk-intelligence" aria-labelledby="pk-intelligence-heading">
    <div class="container">
        <div class="pk-intelligence-inner">

            <div class="pk-intelligence-content pk-animate-on-scroll" data-anim="fade-up">
                <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <h2 id="pk-intelligence-heading"><?php echo esc_html( $heading ); ?></h2>
                <p class="body-large"><?php echo esc_html( $desc ); ?></p>

                <div class="pk-data-flow" aria-label="<?php esc_attr_e( 'Data to decisions flow', 'paksa-it-solutions' ); ?>">
                    <?php foreach ( $data_flow as $index => $step ) : ?>
                        <div class="pk-data-flow-step<?php echo $index === 4 ? ' pk-data-flow-step--end' : ''; ?>">
                            <span><?php echo esc_html( $step ); ?></span>
                        </div>
                        <?php if ( $index < count( $data_flow ) - 1 ) : ?>
                            <div class="pk-data-flow-arrow" aria-hidden="true">→</div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="pk-intelligence-cards pk-animate-on-scroll" data-anim="fade-in" data-delay="150">
                <?php foreach ( $intelligence_cards as $index => $card ) : ?>
                    <div class="pk-intel-card" data-delay="<?php echo esc_attr( $index * 60 ); ?>">
                        <div class="pk-intel-card-icon" aria-hidden="true">
                            <?php echo paksa_get_intelligence_icon( $card['icon'] ); ?>
                        </div>
                        <div class="pk-intel-card-body">
                            <h3 class="pk-intel-card-title"><?php echo esc_html( $card['title'] ); ?></h3>
                            <p class="pk-intel-card-desc"><?php echo esc_html( $card['desc'] ); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>
