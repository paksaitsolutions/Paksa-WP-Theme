<?php
/**
 * Paksa IT Solutions — About: Company Story
 *
 * Content: _paksa_page_story_* post meta.
 * Falls back to block editor content (the_content) if no meta content.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID();
$heading = paksa_page_meta( 'story_heading', '', $page_id );
$content = paksa_page_meta_textarea( 'story_content', '', $page_id );

$has_post_content = trim( get_the_content() ) !== '';

if ( ! $heading && ! $content && ! $has_post_content ) {
    return;
}
?>
<section class="section pk-about-story" aria-labelledby="pk-about-story-heading">
    <div class="container">
        <div class="pk-about-content">
            <?php if ( $heading ) : ?>
                <h2 id="pk-about-story-heading"><?php echo esc_html( $heading ); ?></h2>
            <?php endif; ?>

            <?php if ( $content ) :
                foreach ( array_filter( array_map( 'trim', explode( "\n", $content ) ) ) as $para ) :
            ?>
                <p><?php echo esc_html( $para ); ?></p>
            <?php
                endforeach;
            elseif ( $has_post_content ) : ?>
                <?php the_content(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>
