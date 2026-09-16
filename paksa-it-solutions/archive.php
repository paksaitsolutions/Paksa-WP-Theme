<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Paksa IT Solutions — Index Template
 * Archive Template
 *
 * @package paksa-it-solutions
 */

get_header();
?>
<main id="main-content" class="pk-archive">
    <div class="container">
        <header class="pk-archive-header">
            <h1 class="pk-page-title">
            <?php
            if (is_category()) {
                single_cat_title();
            } elseif (is_tag()) {
                single_tag_title();
            } elseif (is_author()) {
                the_author();
            } elseif (is_date()) {
                the_time('F Y');
            } else {
                esc_html_e('Archives', 'paksa-it-solutions');
            }
            ?>
        </h1>
        <?php if (is_category() || is_tag()): ?>
            <div class="pk-archive-description">
                <?php echo wp_kses_post( term_description() ); ?>
            </div>
        <?php endif; ?>
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
        <p><?php esc_html_e('No posts found.', 'paksa-it-solutions'); ?></p>
    <?php endif; ?>
    </div>
</main>
<?php
get_footer();
