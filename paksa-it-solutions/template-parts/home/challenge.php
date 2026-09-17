<?php
/**
 * Paksa IT Solutions — Homepage: Business Challenge
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$eyebrow     = paksa_get_option( 'paksa_challenge_eyebrow',     __( 'The Problem', 'paksa-it-solutions' ) );
$heading     = paksa_get_option( 'paksa_challenge_heading',     __( 'Technology Should Solve Business Problems.', 'paksa-it-solutions' ) );
$description = paksa_get_option( 'paksa_challenge_description', __( 'Most businesses operate with disconnected systems, manual processes and fragmented data. The result is slow decisions, limited visibility and missed opportunities.', 'paksa-it-solutions' ) );
$transition  = paksa_get_option( 'paksa_challenge_transition',  __( 'We turn these challenges into connected digital systems.', 'paksa-it-solutions' ) );

$problems = array();
for ( $i = 1; $i <= 6; $i++ ) {
    $val = paksa_get_option( 'paksa_challenge_problem_' . $i, paksa_challenge_problem_default( $i ) );
    if ( $val ) $problems[] = $val;
}

$transformation = array(
    array( 'label' => __( 'Fragmented',  'paksa-it-solutions' ), 'state' => 'bad' ),
    array( 'label' => __( 'Connected',   'paksa-it-solutions' ), 'state' => 'mid' ),
    array( 'label' => __( 'Intelligent', 'paksa-it-solutions' ), 'state' => 'mid' ),
    array( 'label' => __( 'Actionable',  'paksa-it-solutions' ), 'state' => 'good' ),
);
?>
<section class="section pk-challenge" aria-labelledby="pk-challenge-heading">
    <div class="container">
        <div class="pk-challenge-inner">

            <div class="pk-challenge-content pk-animate-on-scroll" data-anim="fade-up">
                <?php get_template_part( 'template-parts/components/section-header', null, array(
                    'eyebrow'     => $eyebrow,
                    'heading'     => $heading,
                    'description' => $description,
                    'align'       => 'left',
                    'heading_tag' => 'h2',
                    'heading_id'  => 'pk-challenge-heading',
                ) ); ?>

                <?php if ( ! empty( $problems ) ) : ?>
                    <ul class="pk-challenge-problems" role="list">
                        <?php foreach ( $problems as $i => $problem ) : ?>
                            <li class="pk-challenge-problem pk-animate-on-scroll" data-anim="slide-right" data-delay="<?php echo esc_attr( $i * 60 ); ?>">
                                <span class="pk-challenge-problem-icon" aria-hidden="true">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                </span>
                                <?php echo esc_html( $problem ); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ( $transition ) : ?>
                    <p class="pk-challenge-transition pk-animate-on-scroll" data-anim="fade-up" data-delay="400">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        <?php echo esc_html( $transition ); ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="pk-challenge-visual pk-animate-on-scroll" data-anim="slide-left" data-delay="150" aria-hidden="true">
                <div class="pk-transform-flow">
                    <div class="pk-transform-label"><?php esc_html_e( 'The Transformation', 'paksa-it-solutions' ); ?></div>
                    <?php foreach ( $transformation as $index => $step ) : ?>
                        <div class="pk-transform-step pk-transform-step--<?php echo esc_attr( $step['state'] ); ?> pk-animate-on-scroll" data-anim="scale-in" data-delay="<?php echo esc_attr( 200 + $index * 100 ); ?>">
                            <span class="pk-transform-step-icon" aria-hidden="true">
                                <?php if ( $step['state'] === 'bad' ) : ?>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                <?php elseif ( $step['state'] === 'good' ) : ?>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                                <?php else : ?>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83"/></svg>
                                <?php endif; ?>
                            </span>
                            <?php echo esc_html( $step['label'] ); ?>
                        </div>
                        <?php if ( $index < count( $transformation ) - 1 ) : ?>
                            <div class="pk-transform-arrow" aria-hidden="true">
                                <svg width="16" height="20" viewBox="0 0 16 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="0" x2="8" y2="14"/><polyline points="3,9 8,14 13,9"/></svg>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</section>
