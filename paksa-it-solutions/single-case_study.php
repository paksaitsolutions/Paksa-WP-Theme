<?php
/**
 * Paksa IT Solutions — Single Case Study Template
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>
<main id="main-content" tabindex="-1" class="pk-cs-single">
<?php while ( have_posts() ) : the_post();

    $id         = get_the_ID();
    $industry   = get_post_meta( $id, '_paksa_cs_industry', true );
    $client     = get_post_meta( $id, '_paksa_cs_client', true );
    $duration   = get_post_meta( $id, '_paksa_cs_duration', true );
    $tags_raw   = get_post_meta( $id, '_paksa_cs_tags', true );
    $tags       = $tags_raw ? array_filter( array_map( 'trim', explode( ',', $tags_raw ) ) ) : [];
    $challenge  = get_post_meta( $id, '_paksa_cs_challenge', true );
    $solution   = get_post_meta( $id, '_paksa_cs_solution', true );
    $results    = get_post_meta( $id, '_paksa_cs_results', true );
    $tech_stack = get_post_meta( $id, '_paksa_cs_tech_stack', true );
    $outcomes   = get_post_meta( $id, '_paksa_cs_outcomes', true );

    // Parse outcomes: "Label | Value" per line
    $outcome_items = [];
    if ( $outcomes ) {
        foreach ( array_filter( array_map( 'trim', explode( "\n", $outcomes ) ) ) as $line ) {
            $parts = explode( '|', $line, 2 );
            if ( count( $parts ) === 2 ) {
                $outcome_items[] = [ 'label' => trim( $parts[0] ), 'val' => trim( $parts[1] ) ];
            }
        }
    }

    // Parse paragraphs from a meta text block
    function pk_cs_paragraphs( $text ) {
        return array_filter( array_map( 'trim', explode( "\n", $text ) ) );
    }
?>

<!-- ══════════════════════════════════════════════════════════
     HERO — dark, matches product single
     ══════════════════════════════════════════════════════════ -->
<section class="pk-cs-hero-dark">
    <div class="pk-cs-hero-dark__dots" aria-hidden="true"></div>
    <div class="pk-cs-hero-dark__glow" aria-hidden="true"></div>
    <div class="container">

        <!-- Breadcrumb -->
        <nav class="pk-cs-hero-dark__breadcrumb" aria-label="Breadcrumb">
            <ol class="pk-breadcrumbs-list">
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                <span class="pk-breadcrumb-sep" aria-hidden="true">/</span>
                <li><a href="<?php echo esc_url( home_url( '/case-studies/' ) ); ?>">Case Studies</a></li>
                <span class="pk-breadcrumb-sep" aria-hidden="true">/</span>
                <li aria-current="page"><?php echo esc_html( wp_trim_words( get_the_title(), 7 ) ); ?></li>
            </ol>
        </nav>

        <div class="pk-cs-hero-dark__inner">
            <div class="pk-cs-hero-dark__content">
                <?php if ( $industry ) : ?>
                    <span class="pk-cs-hero-dark__eyebrow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        <?php echo esc_html( $industry ); ?>
                    </span>
                <?php endif; ?>

                <h1 class="pk-cs-hero-dark__heading"><?php the_title(); ?></h1>

                <?php if ( has_excerpt() ) : ?>
                    <p class="pk-cs-hero-dark__desc"><?php echo esc_html( get_the_excerpt() ); ?></p>
                <?php endif; ?>

                <div class="pk-cs-hero-dark__meta">
                    <?php if ( $client ) : ?>
                        <div class="pk-cs-hero-dark__meta-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                            <?php echo esc_html( $client ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( $duration ) : ?>
                        <div class="pk-cs-hero-dark__meta-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <?php echo esc_html( $duration ); ?>
                        </div>
                    <?php endif; ?>
                    <div class="pk-cs-hero-dark__meta-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <?php echo esc_html( get_the_date( 'F Y' ) ); ?>
                    </div>
                </div>

                <?php if ( $tags ) : ?>
                    <div class="pk-cs-hero-dark__tags">
                        <?php foreach ( $tags as $tag ) : ?>
                            <span class="pk-cs-tag"><?php echo esc_html( $tag ); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Outcome stat cards -->
            <?php if ( $outcome_items ) : ?>
                <div class="pk-cs-hero-dark__stats">
                    <?php foreach ( $outcome_items as $i => $o ) : ?>
                        <div class="pk-cs-hero-dark__stat<?php echo $i === 0 ? ' pk-cs-hero-dark__stat--featured' : ''; ?>">
                            <div class="pk-cs-hero-dark__stat-val"><?php echo esc_html( $o['val'] ); ?></div>
                            <div class="pk-cs-hero-dark__stat-label"><?php echo esc_html( $o['label'] ); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════════
     FEATURED IMAGE — full-width banner
     ══════════════════════════════════════════════════════════ -->
<?php if ( has_post_thumbnail() ) : ?>
    <div class="pk-cs-banner">
        <div class="container">
            <?php the_post_thumbnail( 'full', [ 'class' => 'pk-cs-banner__img', 'loading' => 'eager' ] ); ?>
        </div>
    </div>
<?php endif; ?>

<!-- ══════════════════════════════════════════════════════════
     CHALLENGE SECTION
     ══════════════════════════════════════════════════════════ -->
<?php if ( $challenge ) : ?>
    <section class="pk-cs-section pk-cs-section--challenge">
        <div class="container">
            <div class="pk-cs-section__header">
                <div class="pk-cs-section__icon pk-cs-section__icon--red">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
                <div>
                    <p class="pk-cs-section__eyebrow">Problem Statement</p>
                    <h2 class="pk-cs-section__heading">The Business Challenge</h2>
                </div>
            </div>
            <div class="pk-cs-section__body">
                <?php foreach ( pk_cs_paragraphs( $challenge ) as $para ) : ?>
                    <p><?php echo esc_html( $para ); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- ══════════════════════════════════════════════════════════
     SOLUTION SECTION
     ══════════════════════════════════════════════════════════ -->
<?php if ( $solution ) : ?>
    <section class="pk-cs-section pk-cs-section--solution">
        <div class="container">
            <div class="pk-cs-section__header">
                <div class="pk-cs-section__icon pk-cs-section__icon--blue">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                </div>
                <div>
                    <p class="pk-cs-section__eyebrow">Our Approach</p>
                    <h2 class="pk-cs-section__heading">The Solution</h2>
                </div>
            </div>
            <div class="pk-cs-section__body">
                <?php foreach ( pk_cs_paragraphs( $solution ) as $para ) : ?>
                    <p><?php echo esc_html( $para ); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- ══════════════════════════════════════════════════════════
     MAIN CONTENT + SIDEBAR
     ══════════════════════════════════════════════════════════ -->
<?php if ( trim( get_the_content() ) || $results || $tech_stack ) : ?>
<div class="pk-cs-content-wrap">
    <div class="container">
        <div class="pk-cs-layout">

            <!-- Main column -->
            <div class="pk-cs-main">

                <?php if ( trim( get_the_content() ) ) : ?>
                    <div class="pk-cs-post-body">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>

                <?php if ( $results ) : ?>
                    <div class="pk-cs-results-block">
                        <div class="pk-cs-results-block__header">
                            <div class="pk-cs-section__icon pk-cs-section__icon--green">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                            </div>
                            <div>
                                <p class="pk-cs-section__eyebrow">Outcomes</p>
                                <h2 class="pk-cs-section__heading">Results &amp; Impact</h2>
                            </div>
                        </div>
                        <div class="pk-cs-results-block__body">
                            <?php foreach ( pk_cs_paragraphs( $results ) as $para ) : ?>
                                <p><?php echo esc_html( $para ); ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Post navigation -->
                <?php
                $prev = get_previous_post();
                $next = get_next_post();
                if ( $prev || $next ) :
                ?>
                    <nav class="pk-post-nav" aria-label="Case study navigation">
                        <?php if ( $prev ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $prev->ID ) ); ?>" class="pk-post-nav__item pk-post-nav__item--prev">
                                <span class="pk-post-nav__dir"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg> Previous</span>
                                <span class="pk-post-nav__title"><?php echo esc_html( get_the_title( $prev->ID ) ); ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if ( $next ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $next->ID ) ); ?>" class="pk-post-nav__item pk-post-nav__item--next">
                                <span class="pk-post-nav__dir">Next <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg></span>
                                <span class="pk-post-nav__title"><?php echo esc_html( get_the_title( $next->ID ) ); ?></span>
                            </a>
                        <?php endif; ?>
                    </nav>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <aside class="pk-cs-sidebar">

                <?php if ( $tech_stack ) :
                    $tech_items = array_filter( array_map( 'trim', explode( ',', $tech_stack ) ) );
                ?>
                    <div class="pk-cs-sidebar__card">
                        <h3 class="pk-cs-sidebar__heading">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                            Technology Stack
                        </h3>
                        <div class="pk-cs-tag-cloud">
                            <?php foreach ( $tech_items as $tech ) : ?>
                                <span class="pk-cs-tag pk-cs-tag--tech"><?php echo esc_html( $tech ); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="pk-cs-sidebar__card">
                    <h3 class="pk-cs-sidebar__heading">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                        Project Details
                    </h3>
                    <ul class="pk-cs-details-list">
                        <?php if ( $industry ) : ?>
                            <li>
                                <span class="pk-cs-details-list__label">Industry</span>
                                <strong class="pk-cs-details-list__val"><?php echo esc_html( $industry ); ?></strong>
                            </li>
                        <?php endif; ?>
                        <?php if ( $client ) : ?>
                            <li>
                                <span class="pk-cs-details-list__label">Client</span>
                                <strong class="pk-cs-details-list__val"><?php echo esc_html( $client ); ?></strong>
                            </li>
                        <?php endif; ?>
                        <?php if ( $duration ) : ?>
                            <li>
                                <span class="pk-cs-details-list__label">Duration</span>
                                <strong class="pk-cs-details-list__val"><?php echo esc_html( $duration ); ?></strong>
                            </li>
                        <?php endif; ?>
                        <li>
                            <span class="pk-cs-details-list__label">Published</span>
                            <strong class="pk-cs-details-list__val"><?php echo esc_html( get_the_date( 'M Y' ) ); ?></strong>
                        </li>
                    </ul>
                </div>

                <div class="pk-cs-sidebar__card pk-cs-sidebar__cta">
                    <p class="pk-cs-sidebar__cta-eyebrow">Get Started</p>
                    <h3 class="pk-cs-sidebar__cta-heading">Want Similar Results?</h3>
                    <p class="pk-cs-sidebar__cta-desc">Talk to our team about transforming your business with intelligent technology.</p>
                    <a href="/contact-us/" class="pk-btn-primary pk-btn-primary--full">
                        Contact Us
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>

            </aside>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ══════════════════════════════════════════════════════════
     CTA BAND
     ══════════════════════════════════════════════════════════ -->
<section class="pk-prod-single-cta" aria-labelledby="pk-cs-cta-heading">
    <div class="pk-prod-cta-dots" aria-hidden="true"></div>
    <div class="pk-prod-cta-glow" aria-hidden="true"></div>
    <div class="container">
        <div class="pk-prod-cta-inner pk-animate-on-scroll" data-anim="fade-up">
            <div class="pk-prod-cta-content">
                <p class="pk-prod-cta-eyebrow">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><circle cx="7" cy="7" r="3" fill="currentColor"/><circle cx="7" cy="7" r="6" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>
                    Work With Us
                </p>
                <h2 id="pk-cs-cta-heading" class="pk-prod-cta-heading">Ready to Start Your Transformation?</h2>
                <p class="pk-prod-cta-desc">Let's discuss how Paksa IT Solutions can deliver similar results for your organization.</p>
            </div>
            <div class="pk-prod-cta-actions">
                <a href="/contact-us/" class="pk-btn-primary">
                    Get a Free Consultation
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <a href="/case-studies/" class="pk-btn-ghost-inv">All Case Studies</a>
            </div>
        </div>
    </div>
</section>

<?php endwhile; ?>
</main>
<?php get_footer(); ?>
