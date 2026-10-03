<?php
/**
 * Paksa IT Solutions — Case Studies Listing Page
 *
 * Template Name: Case Studies
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$case_studies = get_posts([
    'post_type'              => 'case_study',
    'posts_per_page'         => -1,
    'post_status'            => 'publish',
    'orderby'                => 'date',
    'order'                  => 'DESC',
    'no_found_rows'          => true,
    'update_post_term_cache' => false,
]);

$palettes = [
    [ 'bg' => '#eef3fe', 'icon' => '#6192f8', 'accent' => '#6192f8' ],
    [ 'bg' => '#edfaf3', 'icon' => '#12b76a', 'accent' => '#12b76a' ],
    [ 'bg' => '#fff8ec', 'icon' => '#f79009', 'accent' => '#f79009' ],
    [ 'bg' => '#f3f0ff', 'icon' => '#7c3aed', 'accent' => '#7c3aed' ],
    [ 'bg' => '#e8f9fb', 'icon' => '#0891b2', 'accent' => '#0891b2' ],
    [ 'bg' => '#fdf2f8', 'icon' => '#e11d8f', 'accent' => '#e11d8f' ],
];
?>
<main id="main-content" tabindex="-1" class="pk-cs-page">

    <!-- ── HERO ── -->
    <section class="pk-cs-hero">
        <div class="pk-cs-hero__dots" aria-hidden="true"></div>
        <div class="pk-cs-hero__glow" aria-hidden="true"></div>
        <div class="container">
            <div class="pk-cs-hero__inner">
                <span class="pk-cs-hero__eyebrow">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Real Results
                </span>
                <h1 class="pk-cs-hero__heading pk-animate-on-scroll" data-anim="fade-up">Case Studies</h1>
                <p class="pk-cs-hero__desc pk-animate-on-scroll" data-anim="fade-up" data-delay="80">
                    Discover how Paksa IT Solutions has helped organizations transform their operations through intelligent, data-driven technology solutions.
                </p>
            </div>
        </div>
    </section>

    <!-- ── CASE STUDIES GRID ── -->
    <section class="section pk-cs-listing" aria-label="Case Studies">
        <div class="container">
            <?php if ( $case_studies ) : ?>
                <div class="pk-cs-grid">
                    <?php foreach ( $case_studies as $i => $cs ) :
                        $pal       = $palettes[ $i % count( $palettes ) ];
                        $industry  = get_post_meta( $cs->ID, '_paksa_cs_industry', true );
                        $challenge = get_post_meta( $cs->ID, '_paksa_cs_challenge_short', true );
                        $solution  = get_post_meta( $cs->ID, '_paksa_cs_solution_short', true );
                        $result    = get_post_meta( $cs->ID, '_paksa_cs_result_short', true );
                        $tags      = get_post_meta( $cs->ID, '_paksa_cs_tags', true );
                        $tag_arr   = $tags ? array_map( 'trim', explode( ',', $tags ) ) : [];
                    ?>
                        <article class="pk-cs-card pk-animate-on-scroll" data-anim="fade-up"
                                 data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>"
                                 style="--cs-accent:<?php echo esc_attr( $pal['accent'] ); ?>;--cs-icon:<?php echo esc_attr( $pal['icon'] ); ?>;--cs-bg:<?php echo esc_attr( $pal['bg'] ); ?>">

                            <?php if ( has_post_thumbnail( $cs->ID ) ) : ?>
                                <a href="<?php echo esc_url( get_permalink( $cs->ID ) ); ?>" class="pk-cs-card__img-wrap" tabindex="-1" aria-hidden="true">
                                    <?php echo get_the_post_thumbnail( $cs->ID, 'paksa-medium', ['class' => 'pk-cs-card__img', 'loading' => 'lazy'] ); ?>
                                </a>
                            <?php endif; ?>

                            <div class="pk-cs-card__body">
                                <?php if ( $industry ) : ?>
                                    <span class="pk-cs-card__industry"><?php echo esc_html( $industry ); ?></span>
                                <?php endif; ?>

                                <h2 class="pk-cs-card__title">
                                    <a href="<?php echo esc_url( get_permalink( $cs->ID ) ); ?>"><?php echo esc_html( get_the_title( $cs->ID ) ); ?></a>
                                </h2>

                                <p class="pk-cs-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $cs->ID ), 25 ) ); ?></p>

                                <?php if ( $challenge || $solution || $result ) : ?>
                                    <div class="pk-cs-card__metrics">
                                        <?php if ( $challenge ) : ?>
                                            <div class="pk-cs-metric">
                                                <span class="pk-cs-metric__label">Challenge</span>
                                                <span class="pk-cs-metric__val"><?php echo esc_html( $challenge ); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ( $solution ) : ?>
                                            <div class="pk-cs-metric">
                                                <span class="pk-cs-metric__label">Solution</span>
                                                <span class="pk-cs-metric__val"><?php echo esc_html( $solution ); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ( $result ) : ?>
                                            <div class="pk-cs-metric pk-cs-metric--result">
                                                <span class="pk-cs-metric__label">Result</span>
                                                <span class="pk-cs-metric__val"><?php echo esc_html( $result ); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( $tag_arr ) : ?>
                                    <div class="pk-cs-card__tags">
                                        <?php foreach ( array_slice( $tag_arr, 0, 4 ) as $tag ) : ?>
                                            <span class="pk-cs-tag"><?php echo esc_html( $tag ); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <a href="<?php echo esc_url( get_permalink( $cs->ID ) ); ?>" class="pk-cs-card__link">
                                    Read Case Study
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="pk-cs-empty">
                    <p><?php esc_html_e( 'Case studies coming soon.', 'paksa-it-solutions' ); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ── CTA ── -->
    <section class="pk-prod-single-cta" id="contact" aria-labelledby="pk-cs-cta-heading">
        <div class="pk-prod-cta-dots" aria-hidden="true"></div>
        <div class="pk-prod-cta-glow" aria-hidden="true"></div>
        <div class="container">
            <div class="pk-prod-cta-inner pk-animate-on-scroll" data-anim="fade-up">
                <div class="pk-prod-cta-content">
                    <p class="pk-prod-cta-eyebrow">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><circle cx="7" cy="7" r="3" fill="currentColor"/><circle cx="7" cy="7" r="6" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>
                        Get Started
                    </p>
                    <h2 id="pk-cs-cta-heading" class="pk-prod-cta-heading">Ready to Transform Your Business?</h2>
                    <p class="pk-prod-cta-desc">Let's discuss how Paksa IT Solutions can help your organization achieve similar results through intelligent, data-driven technology.</p>
                </div>
                <div class="pk-prod-cta-actions">
                    <a href="/contact-us/" class="pk-btn-primary">
                        Get a Free Consultation
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="/about-us/" class="pk-btn-ghost-inv">About Us</a>
                </div>
            </div>
        </div>
    </section>

</main>
<?php get_footer(); ?>
