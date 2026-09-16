<?php
/**
 * Paksa IT Solutions — Homepage: Business Challenge
 * Content: WordPress Customizer
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = paksa_get_option( 'paksa_challenge_eyebrow', __( 'The Problem', 'paksa-it-solutions' ) );
$heading     = paksa_get_option( 'paksa_challenge_heading', __( 'Technology Should Solve Business Problems.', 'paksa-it-solutions' ) );
$description = paksa_get_option( 'paksa_challenge_description', __( 'Most businesses operate with disconnected systems, manual processes and fragmented data. The result is slow decisions, limited visibility and missed opportunities.', 'paksa-it-solutions' ) );
$transition  = paksa_get_option( 'paksa_challenge_transition', __( 'We turn these challenges into connected digital systems.', 'paksa-it-solutions' ) );

$problems = array();
for ( $i = 1; $i <= 6; $i++ ) {
    $val = paksa_get_option( 'paksa_challenge_problem_' . $i, paksa_challenge_problem_default( $i ) );
    if ( $val ) {
        $problems[] = $val;
    }
}

$transformation = array(
    __( 'Fragmented', 'paksa-it-solutions' ),
    __( 'Connected', 'paksa-it-solutions' ),
    __( 'Intelligent', 'paksa-it-solutions' ),
    __( 'Actionable', 'paksa-it-solutions' ),
);
?>
<section class="section pk-challenge" aria-labelledby="pk-challenge-heading">
    <div class="container">
        <div class="pk-challenge-inner">

            <div class="pk-challenge-content pk-animate-on-scroll" data-anim="fade-up">
                <?php
                get_template_part( 'template-parts/components/section-header', null, array(
                    'eyebrow'     => $eyebrow,
                    'heading'     => $heading,
                    'description' => $description,
                    'align'       => 'left',
                    'heading_tag' => 'h2',
                ) );
                ?>

                <?php if ( ! empty( $problems ) ) : ?>
                    <ul class="pk-challenge-problems" role="list">
                        <?php foreach ( $problems as $problem ) : ?>
                            <li class="pk-challenge-problem">
                                <span class="pk-challenge-problem-icon" aria-hidden="true">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                        <circle cx="8" cy="8" r="6"></circle>
                                        <line x1="8" y1="5" x2="8" y2="8"></line>
                                        <line x1="8" y1="11" x2="8" y2="11"></line>
                                    </svg>
                                </span>
                                <?php echo esc_html( $problem ); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ( $transition ) : ?>
                    <p class="pk-challenge-transition"><?php echo esc_html( $transition ); ?></p>
                <?php endif; ?>
            </div>

            <div class="pk-challenge-visual pk-animate-on-scroll" data-anim="fade-in" data-delay="150" aria-hidden="true">
                <div class="pk-transform-flow">
                    <?php foreach ( $transformation as $index => $step ) : ?>
                        <div class="pk-transform-step<?php echo $index === 1 || $index === 2 ? ' is-highlight' : ''; ?>">
                            <span><?php echo esc_html( $step ); ?></span>
                        </div>
                        <?php if ( $index < count( $transformation ) - 1 ) : ?>
                            <div class="pk-transform-arrow" aria-hidden="true">
                                <svg width="16" height="24" viewBox="0 0 16 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="8" y1="0" x2="8" y2="18"></line>
                                    <polyline points="3,13 8,18 13,13"></polyline>
                                </svg>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</section>
