<?php
/**
 * Paksa IT Solutions — Index Template
 * Fallback template for WordPress
 *
 * @package paksa-it-solutions
 */

get_header();

if (have_posts()): ?>
    <div class="container">
        <?php while (have_posts()): the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="pk-entry-header">
                    <h1 class="pk-page-title"><?php the_title(); ?></h1>
                </header>
                <div class="pk-entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <div class="container">
        <p><?php esc_html_e('No content found.', 'paksa-it-solutions'); ?></p>
    </div>
<?php endif;

get_footer();
