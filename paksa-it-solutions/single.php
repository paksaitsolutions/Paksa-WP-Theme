<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Paksa IT Solutions — Index Template
 * Single Post Template
 *
 * @package paksa-it-solutions
 */

get_header();
?>
<main id="main-content" class="pk-single-post">
    <div class="container">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="pk-entry-header">
                        <h1 class="pk-page-title"><?php the_title(); ?></h1>
                        <?php paksa_post_meta(array('show_date' => true, 'show_author' => true)); ?>
                    </header>
                    <?php if (has_post_thumbnail()): ?>
                        <div class="pk-entry-thumbnail">
                            <?php paksa_post_thumbnail('paksa-large'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="pk-entry-content">
                        <?php the_content(); ?>
                    </div>
                    <footer class="pk-entry-footer">
                        <?php paksa_post_navigation(); ?>
                        <?php paksa_render_comments(); ?>
                    </footer>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <p><?php esc_html_e('No content found.', 'paksa-it-solutions'); ?></p>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
