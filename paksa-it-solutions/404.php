<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Paksa IT Solutions — Index Template
 * 404 Not Found Template
 *
 * @package paksa-it-solutions
 */

get_header();
?>
<main id="main-content" class="pk-error-page">
    <div class="container">
        <section class="pk-error-404">
            <h1 class="pk-page-title"><?php esc_html_e('Page Not Found', 'paksa-it-solutions'); ?></h1>
            <p class="body-large"><?php esc_html_e('The page you are looking for does not exist or has been moved.', 'paksa-it-solutions'); ?></p>
            <div class="pk-error-actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                    <?php esc_html_e('Return to Home', 'paksa-it-solutions'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/?s=')); ?>" class="btn btn-secondary">
                    <?php esc_html_e('Search', 'paksa-it-solutions'); ?>
                </a>
            </div>
        </section>
    </div>
</main>
<?php
get_footer();
