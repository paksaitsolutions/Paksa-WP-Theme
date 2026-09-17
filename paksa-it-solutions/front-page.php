<?php
/**
 * Paksa IT Solutions — Front Page
 *
 * Renders the static front page set in Settings → Reading.
 * Content is edited via the block editor (Pages → Home → Edit).
 * Global settings (contact, social, WhatsApp) remain in Appearance → Customize.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>
<main id="main-content" class="pk-front-page">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
    endif;
    ?>
</main>
<?php
get_footer();
