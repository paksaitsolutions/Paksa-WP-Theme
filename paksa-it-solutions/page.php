<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Paksa IT Solutions — Index Template
 * Default Page Template
 *
 * @package paksa-it-solutions
 */

get_header();
?>
<main id="main-content" class="pk-page">
    <div class="container">
        <?php if (have_posts()): ?>
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
        <?php else: ?>
            <p><?php esc_html_e('No content found.', 'paksa-it-solutions'); ?></p>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
