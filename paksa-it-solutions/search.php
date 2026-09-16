<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Paksa IT Solutions — Index Template
 * Search Results Template
 *
 * @package paksa-it-solutions
 */

get_header();
?>
<main id="main-content" class="pk-search-results">
    <div class="container">
        <header class="pk-archive-header">
            <h1 class="pk-page-title">
                <?php printf( esc_html__( 'Search Results for: %s', 'paksa-it-solutions' ), esc_html( get_search_query() ) ); ?>
            </h1>
        </header>

        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="pk-entry-header">
                        <h2 class="pk-entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </header>
                    <div class="pk-entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>

            <nav class="pk-post-navigation" aria-label="<?php esc_attr_e('Posts navigation', 'paksa-it-solutions'); ?>">
                <div class="pk-post-nav-prev">
                    <?php previous_posts_link('&larr; Older Posts'); ?>
                </div>
                <div class="pk-post-nav-next">
                    <?php next_posts_link('Newer Posts &rarr;'); ?>
                </div>
            </nav>
        <?php else: ?>
            <p><?php esc_html_e('No results found. Try a different search term.', 'paksa-it-solutions'); ?></p>
            <?php get_search_form(); ?>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
