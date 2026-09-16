<?php
/**
 * Paksa IT Solutions — Component: Service Card
 *
 * Shared service card for CPT-driven contexts (archive, taxonomy, related services).
 * NOT for the filter-driven portfolio on page-services.php — that uses its own
 * apply_filters() data structure in template-parts/services/portfolio.php.
 *
 * Input contract — $args array:
 *   $args['post_id']     int     Required. paksa_service post ID.
 *   $args['index']       int     Card index for staggered animation delay. Default 0.
 *   $args['heading_tag'] string  'h2'|'h3'. Default 'h3'.
 *   $args['link_label']  string  CTA link text. Default 'Learn More'.
 *
 * Usage:
 *   get_template_part( 'template-parts/components/service-card', null, array(
 *       'post_id' => get_the_ID(),
 *       'index'   => $index,
 *   ) );
 *
 * Requires: paksa_svc_meta() from inc/services-meta.php
 * CSS: .pk-svc-archive-card from archive.css
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$args        = isset( $args ) ? $args : array();
$post_id     = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : 0;
$index       = isset( $args['index'] ) ? absint( $args['index'] ) : 0;
$heading_tag = isset( $args['heading_tag'] ) && in_array( $args['heading_tag'], array( 'h2', 'h3' ), true )
    ? $args['heading_tag'] : 'h3';
$link_label  = isset( $args['link_label'] ) ? $args['link_label'] : __( 'Learn More', 'paksa-it-solutions' );

if ( ! $post_id ) {
    return;
}

$post = get_post( $post_id );
if ( ! $post || $post->post_status !== 'publish' ) {
    return;
}

$tagline     = paksa_svc_meta( 'tagline', '', $post_id );
if ( ! $tagline ) {
    $tagline = has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : '';
}
$cat_label   = paksa_svc_meta( 'category_label', '', $post_id );
$badge       = paksa_svc_meta( 'badge', '', $post_id );
$is_featured = get_post_meta( $post_id, '_paksa_svc_featured', true ) === '1';
$permalink   = get_permalink( $post_id );

// Taxonomy terms for category label fallback
$terms = get_the_terms( $post_id, 'paksa_service_cat' );
if ( ! $cat_label && $terms && ! is_wp_error( $terms ) ) {
    $cat_label = $terms[0]->name;
}

$card_classes = 'pk-svc-archive-card pk-animate-on-scroll';
if ( $is_featured ) {
    $card_classes .= ' pk-svc-archive-card--featured';
}
?>
<article
    class="<?php echo esc_attr( $card_classes ); ?>"
    data-anim="fade-up"
    data-delay="<?php echo esc_attr( ( $index % 3 ) * 80 ); ?>"
    role="listitem"
>
    <?php if ( has_post_thumbnail( $post_id ) ) : ?>
        <div class="pk-svc-archive-card-visual" aria-hidden="true">
            <?php echo get_the_post_thumbnail( $post_id, 'paksa-medium', array(
                'class'   => 'pk-svc-archive-card-thumb',
                'loading' => 'lazy',
                'alt'     => '',
            ) ); ?>
            <?php if ( $badge ) : ?>
                <span class="pk-prod-badge"><?php echo esc_html( $badge ); ?></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="pk-svc-archive-card-body">
        <?php if ( $cat_label ) : ?>
            <span class="pk-product-category"><?php echo esc_html( $cat_label ); ?></span>
        <?php endif; ?>
        <<?php echo $heading_tag; ?> class="pk-svc-archive-card-title"><?php echo esc_html( $post->post_title ); ?></<?php echo $heading_tag; ?>>
        <?php if ( $tagline ) : ?>
            <p class="pk-svc-archive-card-desc"><?php echo esc_html( $tagline ); ?></p>
        <?php endif; ?>
        <a href="<?php echo esc_url( $permalink ); ?>" class="pk-product-link">
            <?php echo esc_html( $link_label ); ?>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="3" y1="8" x2="13" y2="8"></line>
                <polyline points="9,4 13,8 9,12"></polyline>
            </svg>
        </a>
    </div>
</article>
