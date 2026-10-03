<?php
/**
 * Paksa IT Solutions — Single Post Template
 * Modern blog post with dark hero, reading time, related posts.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>
<main id="main-content" tabindex="-1" class="pk-single-post">
<?php while ( have_posts() ) : the_post();

    $cats        = get_the_category();
    $read_time   = max( 1, (int) ceil( str_word_count( strip_tags( get_the_content() ) ) / 200 ) );
    $author_name = get_the_author();
    $post_date   = get_the_date( 'F j, Y' );
?>

    <!-- ── POST HERO ── -->
    <section class="pk-post-hero">
        <div class="pk-post-hero__dots" aria-hidden="true"></div>
        <div class="pk-post-hero__glow" aria-hidden="true"></div>
        <div class="container">
            <div class="pk-post-hero__inner">
                <!-- Breadcrumb -->
                <nav class="pk-post-hero__breadcrumb" aria-label="Breadcrumb">
                    <ol class="pk-breadcrumbs-list">
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                        <span class="pk-breadcrumb-sep" aria-hidden="true">/</span>
                        <li><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">Blog</a></li>
                        <?php if ( $cats ) : ?>
                            <span class="pk-breadcrumb-sep" aria-hidden="true">/</span>
                            <li><a href="<?php echo esc_url( get_category_link( $cats[0]->term_id ) ); ?>"><?php echo esc_html( $cats[0]->name ); ?></a></li>
                        <?php endif; ?>
                    </ol>
                </nav>

                <!-- Meta pills -->
                <div class="pk-post-hero__meta">
                    <?php foreach ( array_slice( $cats, 0, 2 ) as $cat ) : ?>
                        <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="pk-blog-cat-pill"><?php echo esc_html( $cat->name ); ?></a>
                    <?php endforeach; ?>
                    <span class="pk-post-hero__date">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <?php echo esc_html( $post_date ); ?>
                    </span>
                    <span class="pk-post-hero__read-time">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <?php echo esc_html( $read_time ); ?> min read
                    </span>
                </div>

                <h1 class="pk-post-hero__title"><?php the_title(); ?></h1>

                <?php if ( has_excerpt() ) : ?>
                    <p class="pk-post-hero__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
                <?php endif; ?>

                <div class="pk-post-hero__author">
                    <div class="pk-post-hero__avatar" aria-hidden="true">
                        <?php echo esc_html( strtoupper( substr( $author_name, 0, 1 ) ) ); ?>
                    </div>
                    <div>
                        <span class="pk-post-hero__author-name"><?php echo esc_html( $author_name ); ?></span>
                        <span class="pk-post-hero__author-role">Paksa IT Solutions</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── FEATURED IMAGE ── -->
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="pk-post-thumbnail">
            <div class="container">
                <?php the_post_thumbnail( 'paksa-large', ['class' => 'pk-post-thumbnail__img', 'loading' => 'eager'] ); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- ── CONTENT + SIDEBAR ── -->
    <div class="container">
        <div class="pk-post-layout">

            <!-- Main content -->
            <article class="pk-post-content" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="pk-post-body">
                    <?php the_content(); ?>
                </div>

                <!-- Tags -->
                <?php $tags = get_the_tags(); if ( $tags ) : ?>
                    <div class="pk-post-tags">
                        <span class="pk-post-tags__label">Tags:</span>
                        <?php foreach ( $tags as $tag ) : ?>
                            <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="pk-post-tag"><?php echo esc_html( $tag->name ); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Post navigation -->
                <nav class="pk-post-nav" aria-label="Post navigation">
                    <?php
                    $prev = get_previous_post();
                    $next = get_next_post();
                    ?>
                    <?php if ( $prev ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $prev->ID ) ); ?>" class="pk-post-nav__item pk-post-nav__item--prev">
                            <span class="pk-post-nav__dir">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
                                Previous
                            </span>
                            <span class="pk-post-nav__title"><?php echo esc_html( get_the_title( $prev->ID ) ); ?></span>
                        </a>
                    <?php endif; ?>
                    <?php if ( $next ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $next->ID ) ); ?>" class="pk-post-nav__item pk-post-nav__item--next">
                            <span class="pk-post-nav__dir">
                                Next
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
                            </span>
                            <span class="pk-post-nav__title"><?php echo esc_html( get_the_title( $next->ID ) ); ?></span>
                        </a>
                    <?php endif; ?>
                </nav>
            </article>

            <!-- Sidebar -->
            <aside class="pk-post-sidebar">

                <!-- Author card -->
                <div class="pk-post-sidebar__card pk-post-author-card">
                    <div class="pk-post-author-card__avatar" aria-hidden="true">
                        <?php echo esc_html( strtoupper( substr( $author_name, 0, 1 ) ) ); ?>
                    </div>
                    <div class="pk-post-author-card__info">
                        <p class="pk-post-author-card__label">Written by</p>
                        <p class="pk-post-author-card__name"><?php echo esc_html( $author_name ); ?></p>
                        <p class="pk-post-author-card__company">Paksa IT Solutions</p>
                    </div>
                </div>

                <!-- Categories -->
                <?php if ( $cats ) : ?>
                    <div class="pk-post-sidebar__card">
                        <h3 class="pk-post-sidebar__heading">Categories</h3>
                        <ul class="pk-post-sidebar__cat-list">
                            <?php foreach ( $cats as $cat ) : ?>
                                <li>
                                    <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
                                        <?php echo esc_html( $cat->name ); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- CTA card -->
                <div class="pk-post-sidebar__card pk-post-sidebar__cta">
                    <p class="pk-post-sidebar__cta-eyebrow">Get Started</p>
                    <h3 class="pk-post-sidebar__cta-heading">Ready to Transform Your Business?</h3>
                    <p class="pk-post-sidebar__cta-desc">Talk to our team about AI, data science, and software solutions tailored to your needs.</p>
                    <a href="/contact-us/" class="pk-btn-primary pk-btn-primary--full">
                        Contact Us
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>

            </aside>
        </div>
    </div>

    <!-- ── RELATED POSTS ── -->
    <?php
    $related = get_posts([
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post__not_in'   => [ get_the_ID() ],
        'category__in'   => wp_list_pluck( $cats, 'term_id' ),
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
    if ( $related ) :
    ?>
    <section class="pk-related-posts">
        <div class="container">
            <div class="section-header" style="text-align:left;margin-bottom:var(--pk-space-8)">
                <span class="pk-about-eyebrow">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    More Articles
                </span>
                <h2>Related Posts</h2>
            </div>
            <div class="pk-blog-grid pk-blog-grid--3">
                <?php foreach ( $related as $rp ) :
                    $rcats = get_the_category( $rp->ID );
                ?>
                    <article class="pk-blog-card pk-animate-on-scroll" data-anim="fade-up">
                        <?php if ( has_post_thumbnail( $rp->ID ) ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $rp->ID ) ); ?>" class="pk-blog-card__img-wrap" tabindex="-1" aria-hidden="true">
                                <?php echo get_the_post_thumbnail( $rp->ID, 'paksa-medium', ['class' => 'pk-blog-card__img', 'loading' => 'lazy'] ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="pk-blog-card__body">
                            <div class="pk-blog-card__meta">
                                <?php if ( $rcats ) : ?>
                                    <span class="pk-blog-cat-pill pk-blog-cat-pill--sm"><?php echo esc_html( $rcats[0]->name ); ?></span>
                                <?php endif; ?>
                                <span class="pk-blog-date pk-blog-date--sm"><?php echo esc_html( get_the_date( 'M j, Y', $rp->ID ) ); ?></span>
                            </div>
                            <h3 class="pk-blog-card__title">
                                <a href="<?php echo esc_url( get_permalink( $rp->ID ) ); ?>"><?php echo esc_html( get_the_title( $rp->ID ) ); ?></a>
                            </h3>
                            <a href="<?php echo esc_url( get_permalink( $rp->ID ) ); ?>" class="pk-blog-card__link">
                                Read More
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

<?php endwhile; ?>
</main>
<?php get_footer(); ?>
