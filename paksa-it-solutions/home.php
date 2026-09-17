<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Paksa IT Solutions — Index Template
 * Blog Posts Index
 *
 * @package paksa-it-solutions
 */

get_header();
?>
<main id="main-content" class="pk-blog-index">
    <div class="container">
        <?php if (have_posts()): ?>
            <header class="pk-archive-header">
                <h1 class="pk-page-title"><?php single_post_title(); ?></h1>
            </header>

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
            <p><?php esc_html_e('No posts found.', 'paksa-it-solutions'); ?></p>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
