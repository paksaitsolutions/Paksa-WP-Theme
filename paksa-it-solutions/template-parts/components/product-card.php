<?php
/**
 * Paksa IT Solutions — Component: Product Card
 *
 * Shared product card used across all product listing contexts.
 *
 * Input contract — $args array:
 *   $args['post_id']      int     Required. Product post ID.
 *   $args['index']        int     Card index for staggered animation delay. Default 0.
 *   $args['show_filter']  bool    Whether to output data-categories attribute (JS filter). Default false.
 *   $args['heading_tag']  string  'h2'|'h3'. Default 'h3'.
 *   $args['link_label']   string  CTA link text. Default 'Explore Product'.
 *
 * Usage:
 *   get_template_part( 'template-parts/components/product-card', null, array(
 *       'post_id'     => get_the_ID(),
 *       'index'       => $index,
 *       'show_filter' => true,
 *   ) );
 *
 * Requires: paksa_prod_meta(), paksa_parse_pipe_list() from inc/product-meta.php
 * CSS: .pk-product-card from home.css, .pk-prod-badge/.pk-product-thumb from products.css
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$args        = isset( $args ) ? $args : array();
$post_id     = isset( $args['post_id'] ) ? absint( $args['post_id'] ) : 0;
$index       = isset( $args['index'] ) ? absint( $args['index'] ) : 0;
$show_filter = ! empty( $args['show_filter'] );
$heading_tag = isset( $args['heading_tag'] ) && in_array( $args['heading_tag'], array( 'h2', 'h3' ), true )
    ? $args['heading_tag'] : 'h3';
$link_label  = isset( $args['link_label'] ) ? $args['link_label'] : __( 'Explore Product', 'paksa-it-solutions' );

if ( ! $post_id ) {
    return;
}

$post = get_post( $post_id );
if ( ! $post || $post->post_status !== 'publish' ) {
    return;
}

$tagline     = paksa_prod_meta( 'tagline', '', $post_id );
if ( ! $tagline ) {
    $tagline = has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : '';
}
$cat_label   = paksa_prod_meta( 'category_label', '', $post_id );
$badge       = paksa_prod_meta( 'badge', '', $post_id );
$is_featured = get_post_meta( $post_id, '_paksa_prod_featured', true ) === '1';
$permalink   = get_permalink( $post_id );

// Taxonomy terms
$terms      = get_the_terms( $post_id, 'paksa_product_cat' );
$term_slugs = '';
if ( $terms && ! is_wp_error( $terms ) ) {
    $term_slugs = implode( ' ', wp_list_pluck( $terms, 'slug' ) );
    if ( ! $cat_label ) {
        $cat_label = $terms[0]->name;
    }
}

$card_classes = 'pk-product-card pk-animate-on-scroll';
if ( $is_featured ) {
    $card_classes .= ' pk-product-card--featured';
}

$filter_attr = $show_filter && $term_slugs
    ? ' data-categories="' . esc_attr( $term_slugs ) . '"'
    : '';
?>
<article
    class="<?php echo esc_attr( $card_classes ); ?>"
    data-anim="fade-up"
    data-delay="<?php echo esc_attr( ( $index % 3 ) * 80 ); ?>"
    <?php echo $filter_attr; ?>
    role="listitem"
>
    <div class="pk-product-card-inner">

        <div class="pk-product-visual" aria-hidden="true">
            <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                <?php echo get_the_post_thumbnail( $post_id, 'paksa-medium', array(
                    'class'   => 'pk-product-thumb',
                    'loading' => 'lazy',
                    'alt'     => '',
                ) ); ?>
            <?php else : ?>
                <div class="pk-product-ui-mock" aria-hidden="true">
                    <div class="pk-mock-bar"></div>
                    <div class="pk-mock-content">
                        <div class="pk-mock-line pk-mock-line--wide"></div>
                        <div class="pk-mock-line"></div>
                        <div class="pk-mock-line pk-mock-line--short"></div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ( $badge ) : ?>
                <span class="pk-prod-badge"><?php echo esc_html( $badge ); ?></span>
            <?php endif; ?>
        </div>

        <div class="pk-product-body">
            <?php if ( $cat_label ) : ?>
                <span class="pk-product-category"><?php echo esc_html( $cat_label ); ?></span>
            <?php endif; ?>
            <<?php echo $heading_tag; ?> class="pk-product-title"><?php echo esc_html( $post->post_title ); ?></<?php echo $heading_tag; ?>>
            <?php if ( $tagline ) : ?>
                <p class="pk-product-description"><?php echo esc_html( $tagline ); ?></p>
            <?php endif; ?>
            <a href="<?php echo esc_url( $permalink ); ?>" class="pk-product-link">
                <?php echo esc_html( $link_label ); ?>
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="3" y1="8" x2="13" y2="8"></line>
                    <polyline points="9,4 13,8 9,12"></polyline>
                </svg>
            </a>
        </div>

    </div>
</article>
