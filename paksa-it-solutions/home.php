<?php
/**
 * Paksa IT Solutions — Blog Index (home.php)
 * Modern blog listing with hero, featured post, card grid.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

// Collect all posts in the loop
$all_posts = [];
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        $all_posts[] = get_post();
    }
    rewind_posts();
}

$featured = $all_posts[0] ?? null;
$rest     = array_slice( $all_posts, 1 );
?>
<main id="main-content" tabindex="-1" class="pk-blog-index">

    <!-- ── HERO ── -->
    <section class="pk-blog-hero">
        <div class="pk-blog-hero__dots" aria-hidden="true"></div>
        <div class="container">
            <div class="pk-blog-hero__inner">
                <span class="pk-blog-hero__eyebrow">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    Latest News &amp; Insights
                </span>
                <h1 class="pk-blog-hero__heading">The Paksa Blog</h1>
                <p class="pk-blog-hero__desc">Expert insights on AI, data science, enterprise software, and digital transformation from the Paksa IT Solutions team.</p>
            </div>
        </div>
    </section>

    <div class="container pk-blog-container">

        <?php if ( $featured ) : ?>
        <!-- ── FEATURED POST ── -->
        <div class="pk-blog-featured pk-animate-on-scroll" data-anim="fade-up">
            <?php if ( has_post_thumbnail( $featured->ID ) ) : ?>
                <a href="<?php echo esc_url( get_permalink( $featured->ID ) ); ?>" class="pk-blog-featured__img-wrap" tabindex="-1" aria-hidden="true">
                    <?php echo get_the_post_thumbnail( $featured->ID, 'paksa-large', ['class' => 'pk-blog-featured__img', 'loading' => 'eager'] ); ?>
                </a>
            <?php endif; ?>
            <div class="pk-blog-featured__body">
                <div class="pk-blog-featured__meta">
                    <?php
                    $cats = get_the_category( $featured->ID );
                    if ( $cats ) :
                        foreach ( array_slice( $cats, 0, 2 ) as $cat ) :
                    ?>
                        <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="pk-blog-cat-pill"><?php echo esc_html( $cat->name ); ?></a>
                    <?php endforeach; endif; ?>
                    <span class="pk-blog-date">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <?php echo esc_html( get_the_date( 'M j, Y', $featured->ID ) ); ?>
                    </span>
                </div>
                <h2 class="pk-blog-featured__title">
                    <a href="<?php echo esc_url( get_permalink( $featured->ID ) ); ?>"><?php echo esc_html( get_the_title( $featured->ID ) ); ?></a>
                </h2>
                <p class="pk-blog-featured__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $featured->ID ), 30 ) ); ?></p>
                <a href="<?php echo esc_url( get_permalink( $featured->ID ) ); ?>" class="pk-blog-read-more">
                    Read Article
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </div>
        <?php endif; ?>

        <?php if ( ! empty( $rest ) ) : ?>
        <!-- ── POST GRID ── -->
        <div class="pk-blog-grid">
            <?php foreach ( $rest as $i => $post ) :
                setup_postdata( $post );
                $cats = get_the_category( $post->ID );
            ?>
                <article class="pk-blog-card pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>">
                    <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="pk-blog-card__img-wrap" tabindex="-1" aria-hidden="true">
                            <?php echo get_the_post_thumbnail( $post->ID, 'paksa-medium', ['class' => 'pk-blog-card__img', 'loading' => 'lazy'] ); ?>
                        </a>
                    <?php endif; ?>
                    <div class="pk-blog-card__body">
                        <div class="pk-blog-card__meta">
                            <?php if ( $cats ) : ?>
                                <a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>" class="pk-blog-cat-pill pk-blog-cat-pill--sm"><?php echo esc_html( $cats[0]->name ); ?></a>
                            <?php endif; ?>
                            <span class="pk-blog-date pk-blog-date--sm">
                                <?php echo esc_html( get_the_date( 'M j, Y', $post->ID ) ); ?>
                            </span>
                        </div>
                        <h3 class="pk-blog-card__title">
                            <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"><?php echo esc_html( get_the_title( $post->ID ) ); ?></a>
                        </h3>
                        <p class="pk-blog-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt( $post->ID ), 20 ) ); ?></p>
                        <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" class="pk-blog-card__link">
                            Read More
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </article>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>
        <?php endif; ?>

        <!-- ── PAGINATION ── -->
        <?php if ( $GLOBALS['wp_query']->max_num_pages > 1 ) : ?>
        <nav class="pk-blog-pagination" aria-label="<?php esc_attr_e( 'Blog navigation', 'paksa-it-solutions' ); ?>">
            <?php
            echo paginate_links([
                'prev_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg> Previous',
                'next_text' => 'Next <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>',
            ]);
            ?>
        </nav>
        <?php endif; ?>

        <?php if ( empty( $all_posts ) ) : ?>
            <div class="pk-blog-empty">
                <p><?php esc_html_e( 'No posts found.', 'paksa-it-solutions' ); ?></p>
            </div>
        <?php endif; ?>

    </div><!-- .pk-blog-container -->

    <!-- ── CTA BAND ── -->
    <section class="pk-blog-cta">
        <div class="pk-prod-cta-dots" aria-hidden="true"></div>
        <div class="container">
            <div class="pk-blog-cta__inner pk-animate-on-scroll" data-anim="fade-up">
                <div>
                    <p class="pk-prod-cta-eyebrow">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        Work With Us
                    </p>
                    <h2 class="pk-prod-cta-heading">Ready to Transform Your Business?</h2>
                    <p class="pk-prod-cta-desc">Let Paksa IT Solutions help you harness AI, data science, and intelligent software to drive real business outcomes.</p>
                </div>
                <div class="pk-prod-cta-actions">
                    <a href="/contact-us/" class="pk-btn-primary">
                        Get a Free Consultation
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                    <a href="/solutions/" class="pk-btn-ghost-inv">View Our Solutions</a>
                </div>
            </div>
        </div>
    </section>

</main>
<?php get_footer(); ?>
