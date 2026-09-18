<?php
/**
 * Paksa Theme — Gutenberg visual system.
 *
 * This module deliberately favours core blocks for layouts and content. The
 * icon block is the only bespoke block because it keeps the visual icon
 * language accessible, editable, and in sync with the single PHP icon registry.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add the Paksa component category without replacing editor categories.
 *
 * @param array $categories Existing block categories.
 * @return array
 */
function paksa_visual_block_category( $categories ) {
    foreach ( $categories as $category ) {
        if ( isset( $category['slug'] ) && $category['slug'] === 'paksa-components' ) {
            return $categories;
        }
    }

    array_unshift( $categories, array(
        'slug'  => 'paksa-components',
        'title' => __( 'Paksa Components', 'paksa-it-solutions' ),
        'icon'  => 'layout',
    ) );

    return $categories;
}
add_filter( 'block_categories_all', 'paksa_visual_block_category', 10, 1 );

/**
 * Register the icon block and editor-visible variants for native blocks.
 */
function paksa_register_visual_blocks() {
    if ( function_exists( 'register_block_type' ) ) {
        register_block_type( 'paksa/icon', array(
            'api_version'     => 3,
            'render_callback' => 'paksa_render_icon_block',
            'attributes'      => array(
                'name'  => array( 'type' => 'string', 'default' => 'ai' ),
                'size'  => array( 'type' => 'number', 'default' => 24 ),
                'label' => array( 'type' => 'string', 'default' => '' ),
                'shape' => array( 'type' => 'string', 'default' => 'rounded' ),
                'hover' => array( 'type' => 'string', 'default' => 'none' ),
            ),
            'supports'        => array(
                'align'   => array( 'left', 'center', 'right' ),
                'color'   => array( 'text' => true, 'background' => true ),
                'spacing' => array( 'margin' => true, 'padding' => true ),
            ),
        ) );

        /* The native Button block intentionally remains the default action
         * control. This compact block exists for the one capability it cannot
         * provide from the shared icon registry: a selectable Paksa icon with
         * a stable, accessible link output. */
        register_block_type( 'paksa/action', array(
            'api_version'     => 3,
            'render_callback' => 'paksa_render_action_block',
            'attributes'      => array(
                'label'       => array( 'type' => 'string', 'default' => __( 'Add an action', 'paksa-it-solutions' ) ),
                'url'         => array( 'type' => 'string', 'default' => '' ),
                'variant'     => array( 'type' => 'string', 'default' => 'primary' ),
                'icon'        => array( 'type' => 'string', 'default' => 'arrow' ),
                'iconPosition'=> array( 'type' => 'string', 'default' => 'end' ),
                'newTab'      => array( 'type' => 'boolean', 'default' => false ),
                'ariaLabel'   => array( 'type' => 'string', 'default' => '' ),
            ),
            'supports'        => array(
                'align'   => array( 'left', 'center', 'right' ),
                'color'   => array( 'text' => true, 'background' => true ),
                'spacing' => array( 'margin' => true, 'padding' => true ),
            ),
        ) );

        /* A counter is the other focused custom block: its front-end motion
         * reuses the existing [data-count] observer, while its static value
         * remains visible without JavaScript or with reduced motion. */
        register_block_type( 'paksa/stat', array(
            'api_version'     => 3,
            'render_callback' => 'paksa_render_stat_block',
            'attributes'      => array(
                'number'  => array( 'type' => 'number', 'default' => 0 ),
                'prefix'  => array( 'type' => 'string', 'default' => '' ),
                'suffix'  => array( 'type' => 'string', 'default' => '' ),
                'label'   => array( 'type' => 'string', 'default' => __( 'Add a metric label', 'paksa-it-solutions' ) ),
                'icon'    => array( 'type' => 'string', 'default' => 'chart' ),
                'animate' => array( 'type' => 'boolean', 'default' => true ),
            ),
            'supports'        => array(
                'align'   => array( 'left', 'center', 'right' ),
                'color'   => array( 'text' => true, 'background' => true ),
                'spacing' => array( 'margin' => true, 'padding' => true ),
            ),
        ) );

        /* Core has no breadcrumb block. This thin wrapper deliberately uses
         * the established paksa_breadcrumbs() logic so products, services,
         * taxonomies, archives, search, and 404 pages retain one trail. */
        register_block_type( 'paksa/breadcrumbs', array(
            'api_version'     => 3,
            'render_callback' => 'paksa_render_breadcrumbs_block',
            'supports'        => array(
                'align'   => array( 'wide', 'full' ),
                'color'   => array( 'text' => true, 'background' => true ),
                'spacing' => array( 'margin' => true, 'padding' => true ),
            ),
        ) );

        /* Relationship selections already belong to the product and service
         * editing contracts. This renderer makes that existing relationship
         * reusable in a visual template without introducing a second source
         * of truth or a generic, unrelated-post query. */
        register_block_type( 'paksa/related-content', array(
            'api_version'     => 3,
            'render_callback' => 'paksa_render_related_content_block',
            'uses_context'    => array( 'postId', 'postType' ),
            'attributes'      => array(
                'eyebrow'     => array( 'type' => 'string', 'default' => '' ),
                'heading'      => array( 'type' => 'string', 'default' => '' ),
                'description'  => array( 'type' => 'string', 'default' => '' ),
                'limit'        => array( 'type' => 'number', 'default' => 6 ),
            ),
            'supports'        => array(
                'align'   => array( 'wide', 'full' ),
                'color'   => array( 'text' => true, 'background' => true ),
                'spacing' => array( 'margin' => true, 'padding' => true ),
            ),
        ) );
    }

    if ( ! function_exists( 'register_block_style' ) ) {
        return;
    }

    register_block_style( 'core/button', array(
        'name'  => 'paksa-button-outline',
        'label' => __( 'Paksa Outline', 'paksa-it-solutions' ),
    ) );
    register_block_style( 'core/button', array(
        'name'  => 'paksa-button-ghost',
        'label' => __( 'Paksa Ghost', 'paksa-it-solutions' ),
    ) );
    register_block_style( 'core/button', array(
        'name'  => 'paksa-button-light',
        'label' => __( 'Paksa Light', 'paksa-it-solutions' ),
    ) );
    register_block_style( 'core/button', array(
        'name'  => 'paksa-button-dark',
        'label' => __( 'Paksa Dark', 'paksa-it-solutions' ),
    ) );
    register_block_style( 'core/button', array(
        'name'  => 'paksa-button-secondary',
        'label' => __( 'Paksa Secondary', 'paksa-it-solutions' ),
    ) );
    register_block_style( 'core/button', array(
        'name'  => 'paksa-button-text',
        'label' => __( 'Paksa Text Link', 'paksa-it-solutions' ),
    ) );
    register_block_style( 'core/group', array(
        'name'  => 'paksa-card',
        'label' => __( 'Paksa Card', 'paksa-it-solutions' ),
    ) );
    register_block_style( 'core/group', array(
        'name'  => 'paksa-card-dark',
        'label' => __( 'Paksa Dark Card', 'paksa-it-solutions' ),
    ) );

    $card_styles = array(
        'paksa-card-basic'       => __( 'Paksa Basic Card', 'paksa-it-solutions' ),
        'paksa-card-feature'     => __( 'Paksa Feature Card', 'paksa-it-solutions' ),
        'paksa-card-service'     => __( 'Paksa Service Card', 'paksa-it-solutions' ),
        'paksa-card-product'     => __( 'Paksa Product Card', 'paksa-it-solutions' ),
        'paksa-card-testimonial' => __( 'Paksa Testimonial Card', 'paksa-it-solutions' ),
        'paksa-card-team'        => __( 'Paksa Team Card', 'paksa-it-solutions' ),
        'paksa-card-pricing'     => __( 'Paksa Pricing Card', 'paksa-it-solutions' ),
        'paksa-card-blog'        => __( 'Paksa Blog Card', 'paksa-it-solutions' ),
        'paksa-card-stat'        => __( 'Paksa Stat Card', 'paksa-it-solutions' ),
        'paksa-card-image'       => __( 'Paksa Image Card', 'paksa-it-solutions' ),
    );
    foreach ( $card_styles as $name => $label ) {
        register_block_style( 'core/group', array( 'name' => $name, 'label' => $label ) );
    }

    register_block_style( 'core/image', array(
        'name'  => 'paksa-image-zoom',
        'label' => __( 'Paksa Image Zoom', 'paksa-it-solutions' ),
    ) );
    register_block_style( 'core/separator', array(
        'name'  => 'paksa-divider',
        'label' => __( 'Paksa Accent Divider', 'paksa-it-solutions' ),
    ) );
    register_block_style( 'core/list', array(
        'name'  => 'paksa-icon-list',
        'label' => __( 'Paksa Icon List', 'paksa-it-solutions' ),
    ) );
    register_block_style( 'core/columns', array(
        'name'  => 'paksa-feature-row',
        'label' => __( 'Paksa Feature Row', 'paksa-it-solutions' ),
    ) );
    register_block_style( 'core/cover', array(
        'name'  => 'paksa-media-section',
        'label' => __( 'Paksa Media Section', 'paksa-it-solutions' ),
    ) );

    $motion_styles = array(
        'paksa-motion-fade'       => __( 'Motion: Fade', 'paksa-it-solutions' ),
        'paksa-motion-fade-up'    => __( 'Motion: Fade Up', 'paksa-it-solutions' ),
        'paksa-motion-fade-down'  => __( 'Motion: Fade Down', 'paksa-it-solutions' ),
        'paksa-motion-fade-left'  => __( 'Motion: Fade Left', 'paksa-it-solutions' ),
        'paksa-motion-fade-right' => __( 'Motion: Fade Right', 'paksa-it-solutions' ),
        'paksa-motion-scale'      => __( 'Motion: Scale', 'paksa-it-solutions' ),
        'paksa-motion-reveal'     => __( 'Motion: Reveal', 'paksa-it-solutions' ),
        'paksa-motion-stagger'    => __( 'Motion: Stagger Children', 'paksa-it-solutions' ),
    );
    foreach ( array( 'core/group', 'core/column', 'core/image', 'core/cover' ) as $block_name ) {
        foreach ( $motion_styles as $name => $label ) {
            register_block_style( $block_name, array( 'name' => $name, 'label' => $label ) );
        }
    }
}
add_action( 'init', 'paksa_register_visual_blocks', 12 );

/**
 * Render one icon from the shared icon registry.
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function paksa_render_icon_block( $attributes ) {
    $name  = isset( $attributes['name'] ) ? sanitize_key( $attributes['name'] ) : 'ai';
    $size  = isset( $attributes['size'] ) ? absint( $attributes['size'] ) : 24;
    $label = isset( $attributes['label'] ) ? sanitize_text_field( $attributes['label'] ) : '';
    $shape = isset( $attributes['shape'] ) ? sanitize_key( $attributes['shape'] ) : 'rounded';
    $hover = isset( $attributes['hover'] ) ? sanitize_key( $attributes['hover'] ) : 'none';
    $size  = max( 12, min( 96, $size ) );
    $shape = in_array( $shape, array( 'rounded', 'circle', 'square', 'none' ), true ) ? $shape : 'rounded';
    $hover = in_array( $hover, array( 'none', 'lift', 'glow', 'scale' ), true ) ? $hover : 'none';

    $attributes = array(
        'class' => 'pk-icon is-shape-' . $shape . ' is-hover-' . $hover,
        'style' => '--pk-icon-size:' . $size . 'px',
    );
    if ( $label ) {
        $attributes['role']       = 'img';
        $attributes['aria-label'] = $label;
    } else {
        $attributes['aria-hidden'] = 'true';
    }

    if ( function_exists( 'get_block_wrapper_attributes' ) ) {
        $wrapper = get_block_wrapper_attributes( $attributes );
    } else {
        $wrapper = 'class="wp-block-paksa-icon pk-icon"';
    }

    return '<span ' . $wrapper . '>' . paksa_icon( $name, $size ) . '</span>';
}

/**
 * Render the focused action block from the shared button and icon system.
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function paksa_render_action_block( $attributes ) {
    $label         = isset( $attributes['label'] ) ? sanitize_text_field( $attributes['label'] ) : __( 'Add an action', 'paksa-it-solutions' );
    $url           = isset( $attributes['url'] ) ? esc_url( $attributes['url'] ) : '';
    $variant       = isset( $attributes['variant'] ) ? sanitize_key( $attributes['variant'] ) : 'primary';
    $icon          = isset( $attributes['icon'] ) ? sanitize_key( $attributes['icon'] ) : 'arrow';
    $icon_position = isset( $attributes['iconPosition'] ) ? sanitize_key( $attributes['iconPosition'] ) : 'end';
    $new_tab       = ! empty( $attributes['newTab'] );
    $aria_label    = isset( $attributes['ariaLabel'] ) ? sanitize_text_field( $attributes['ariaLabel'] ) : '';
    $variants      = array( 'primary', 'secondary', 'outline', 'ghost', 'text' );

    $variant       = in_array( $variant, $variants, true ) ? $variant : 'primary';
    $icon_position = in_array( $icon_position, array( 'start', 'end', 'none' ), true ) ? $icon_position : 'end';
    $label         = $label ? $label : __( 'Add an action', 'paksa-it-solutions' );

    $wrapper_attributes = array(
        'class' => 'pk-action pk-action--' . $variant . ' pk-action--icon-' . $icon_position,
    );
    $wrapper = function_exists( 'get_block_wrapper_attributes' )
        ? get_block_wrapper_attributes( $wrapper_attributes )
        : 'class="wp-block-paksa-action ' . esc_attr( $wrapper_attributes['class'] ) . '"';

    $icon_markup = $icon_position === 'none'
        ? ''
        : '<span class="pk-action__icon" aria-hidden="true">' . paksa_icon( $icon, 18 ) . '</span>';
    $content = ( $icon_position === 'start' ? $icon_markup : '' )
        . '<span class="pk-action__label">' . esc_html( $label ) . '</span>'
        . ( $icon_position === 'end' ? $icon_markup : '' );

    if ( ! $url ) {
        return '<span ' . $wrapper . '><span class="pk-action__button" aria-disabled="true">' . $content . '</span></span>';
    }

    $link_attributes = $new_tab ? ' target="_blank" rel="noopener noreferrer"' : '';
    if ( $aria_label ) {
        $link_attributes .= ' aria-label="' . esc_attr( $aria_label ) . '"';
    }

    return '<span ' . $wrapper . '><a class="pk-action__button" href="' . $url . '"' . $link_attributes . '>' . $content . '</a></span>';
}

/**
 * Render an accessible stat value with optional progressive counter motion.
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function paksa_render_stat_block( $attributes ) {
    $number  = isset( $attributes['number'] ) && is_numeric( $attributes['number'] ) ? (float) $attributes['number'] : 0;
    $prefix  = isset( $attributes['prefix'] ) ? sanitize_text_field( $attributes['prefix'] ) : '';
    $suffix  = isset( $attributes['suffix'] ) ? sanitize_text_field( $attributes['suffix'] ) : '';
    $label   = isset( $attributes['label'] ) ? sanitize_text_field( $attributes['label'] ) : __( 'Add a metric label', 'paksa-it-solutions' );
    $icon    = isset( $attributes['icon'] ) ? sanitize_key( $attributes['icon'] ) : 'chart';
    $animate = ! isset( $attributes['animate'] ) || ! empty( $attributes['animate'] );
    $value   = floor( $number ) === $number ? (string) (int) $number : rtrim( rtrim( number_format( $number, 2, '.', '' ), '0' ), '.' );

    $wrapper_attributes = array( 'class' => 'pk-stat is-style-paksa-card-stat' );
    $wrapper = function_exists( 'get_block_wrapper_attributes' )
        ? get_block_wrapper_attributes( $wrapper_attributes )
        : 'class="wp-block-paksa-stat ' . esc_attr( $wrapper_attributes['class'] ) . '"';
    $counter_attributes = $animate
        ? ' data-count="' . esc_attr( $value ) . '" data-prefix="' . esc_attr( $prefix ) . '" data-suffix="' . esc_attr( $suffix ) . '"'
        : '';

    return '<div ' . $wrapper . '><span class="pk-stat__icon" aria-hidden="true">' . paksa_icon( $icon, 22 ) . '</span><div class="pk-stat__content"><strong class="pk-stat__value"' . $counter_attributes . ' aria-live="off">' . esc_html( $prefix . $value . $suffix ) . '</strong><span class="pk-stat__label">' . esc_html( $label ) . '</span></div></div>';
}

/**
 * Render the established breadcrumb trail inside a Gutenberg-compatible wrapper.
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function paksa_render_breadcrumbs_block( $attributes ) {
    if ( ! function_exists( 'paksa_breadcrumbs' ) || is_front_page() ) {
        return '';
    }

    ob_start();
    paksa_breadcrumbs();
    $breadcrumbs = trim( ob_get_clean() );
    if ( ! $breadcrumbs ) {
        return '';
    }

    $wrapper_attributes = array( 'class' => 'pk-site-editor-breadcrumbs' );
    $wrapper = function_exists( 'get_block_wrapper_attributes' )
        ? get_block_wrapper_attributes( $wrapper_attributes )
        : 'class="wp-block-paksa-breadcrumbs pk-site-editor-breadcrumbs"';

    return '<div ' . $wrapper . '>' . $breadcrumbs . '</div>';
}

/**
 * Resolve the established relationship data for the current visual-template post.
 *
 * @param WP_Block|null $block Current dynamic block instance when available.
 * @return array|false
 */
function paksa_get_related_content_context( $block = null ) {
    $post_id   = 0;
    $post_type = '';

    if ( is_object( $block ) && isset( $block->context ) && is_array( $block->context ) ) {
        $post_id   = ! empty( $block->context['postId'] ) ? absint( $block->context['postId'] ) : 0;
        $post_type = ! empty( $block->context['postType'] ) ? sanitize_key( $block->context['postType'] ) : '';
    }

    if ( ! $post_id ) {
        $post_id = absint( get_queried_object_id() );
    }
    if ( ! $post_id ) {
        $post_id = absint( get_the_ID() );
    }
    if ( ! $post_type && $post_id ) {
        $post_type = get_post_type( $post_id );
    }

    if ( $post_type === 'paksa_service' && function_exists( 'paksa_get_service_related_products' ) ) {
        return array(
            'ids'         => paksa_get_service_related_products( $post_id ),
            'post_type'   => 'paksa_product',
            'taxonomy'    => 'paksa_product_cat',
            'card_type'   => 'product',
            'eyebrow'     => apply_filters( 'paksa_svc_related_products_eyebrow', __( 'Related Solutions', 'paksa-it-solutions' ), $post_id ),
            'heading'     => apply_filters( 'paksa_svc_related_products_heading', __( 'Products That Support This Service', 'paksa-it-solutions' ), $post_id ),
        );
    }

    if ( $post_type === 'paksa_product' && function_exists( 'paksa_get_product_related_services' ) ) {
        return array(
            'ids'         => paksa_get_product_related_services( $post_id ),
            'post_type'   => 'paksa_service',
            'taxonomy'    => 'paksa_service_cat',
            'card_type'   => 'service',
            'eyebrow'     => apply_filters( 'paksa_product_related_services_eyebrow', __( 'Related Expertise', 'paksa-it-solutions' ), $post_id ),
            'heading'     => apply_filters( 'paksa_product_related_services_heading', __( 'Services That Support This Product', 'paksa-it-solutions' ), $post_id ),
        );
    }

    return false;
}

/**
 * Render configured product/service relationships as a reusable visual block.
 *
 * @param array         $attributes Block attributes.
 * @param string        $content    Block content (unused for dynamic output).
 * @param WP_Block|null $block      Current dynamic block instance when available.
 * @return string
 */
function paksa_render_related_content_block( $attributes, $content = '', $block = null ) {
    $context = paksa_get_related_content_context( $block );
    if ( ! $context || empty( $context['ids'] ) ) {
        return '';
    }

    $ids = array_values( array_unique( array_filter( array_map( 'absint', (array) $context['ids'] ) ) ) );
    if ( empty( $ids ) ) {
        return '';
    }

    $limit       = isset( $attributes['limit'] ) ? absint( $attributes['limit'] ) : 6;
    $limit       = max( 1, min( 12, $limit ) );
    $ids         = array_slice( $ids, 0, $limit );
    $eyebrow     = isset( $attributes['eyebrow'] ) && $attributes['eyebrow'] !== '' ? sanitize_text_field( $attributes['eyebrow'] ) : $context['eyebrow'];
    $heading     = isset( $attributes['heading'] ) && $attributes['heading'] !== '' ? sanitize_text_field( $attributes['heading'] ) : $context['heading'];
    $description = isset( $attributes['description'] ) ? sanitize_textarea_field( $attributes['description'] ) : '';
    $query       = new WP_Query( array(
        'post_type'      => $context['post_type'],
        'post_status'    => 'publish',
        'post__in'       => $ids,
        'orderby'        => 'post__in',
        'posts_per_page' => count( $ids ),
        'no_found_rows'  => true,
    ) );

    if ( ! $query->have_posts() ) {
        return '';
    }

    $wrapper_attributes = array( 'class' => 'pk-related-content pk-related-content--' . $context['card_type'] );
    $wrapper = function_exists( 'get_block_wrapper_attributes' )
        ? get_block_wrapper_attributes( $wrapper_attributes )
        : 'class="wp-block-paksa-related-content ' . esc_attr( $wrapper_attributes['class'] ) . '"';
    $heading_id = function_exists( 'wp_unique_id' ) ? wp_unique_id( 'pk-related-content-heading-' ) : 'pk-related-content-heading';

    ob_start();
    ?>
    <section <?php echo $wrapper; ?><?php echo $heading ? ' aria-labelledby="' . esc_attr( $heading_id ) . '"' : ''; ?>>
        <div class="pk-related-content__inner">
            <?php if ( $heading || $eyebrow || $description ) : ?>
                <header class="pk-related-content__header">
                    <?php if ( $eyebrow ) : ?>
                        <span class="pk-related-content__eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                    <?php endif; ?>
                    <?php if ( $heading ) : ?>
                        <h2 id="<?php echo esc_attr( $heading_id ); ?>"><?php echo esc_html( $heading ); ?></h2>
                    <?php endif; ?>
                    <?php if ( $description ) : ?>
                        <p><?php echo esc_html( $description ); ?></p>
                    <?php endif; ?>
                </header>
            <?php endif; ?>
            <div class="pk-related-content__grid" role="list">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <?php
                    $related_id   = get_the_ID();
                    $permalink    = get_permalink( $related_id );
                    $terms        = get_the_terms( $related_id, $context['taxonomy'] );
                    $term_label   = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
                    $excerpt      = get_the_excerpt( $related_id );
                    $excerpt      = wp_trim_words( wp_strip_all_tags( $excerpt ), 24 );
                    ?>
                    <article class="pk-related-content__card" role="listitem">
                        <?php if ( has_post_thumbnail( $related_id ) ) : ?>
                            <a class="pk-related-content__image" href="<?php echo esc_url( $permalink ); ?>" aria-hidden="true" tabindex="-1">
                                <?php echo get_the_post_thumbnail( $related_id, 'paksa-medium', array( 'loading' => 'lazy', 'alt' => '' ) ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="pk-related-content__body">
                            <?php if ( $term_label ) : ?>
                                <span class="pk-related-content__term"><?php echo esc_html( $term_label ); ?></span>
                            <?php endif; ?>
                            <h3><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( get_the_title( $related_id ) ); ?></a></h3>
                            <?php if ( $excerpt ) : ?>
                                <p><?php echo esc_html( $excerpt ); ?></p>
                            <?php endif; ?>
                            <a class="pk-related-content__link" href="<?php echo esc_url( $permalink ); ?>">
                                <span><?php esc_html_e( 'View details', 'paksa-it-solutions' ); ?></span>
                                <span aria-hidden="true"><?php echo paksa_icon( 'arrow', 16 ); ?></span>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <?php
    wp_reset_postdata();

    return trim( ob_get_clean() );
}

/**
 * Extend the existing icon registry with the editor-facing utility set.
 * The registry remains the only place icon markup is produced.
 *
 * @param array $icons Current icon map.
 * @return array
 */
function paksa_extend_visual_icon_library( $icons ) {
    $outline = static function( $paths ) {
        return '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $paths . '</svg>';
    };

    $icons['plus']       = $outline( '<path d="M12 5v14M5 12h14"/>' );
    $icons['minus']      = $outline( '<path d="M5 12h14"/>' );
    $icons['menu']       = $outline( '<path d="M4 7h16M4 12h16M4 17h16"/>' );
    $icons['close']      = $outline( '<path d="m6 6 12 12M18 6 6 18"/>' );
    $icons['search']     = $outline( '<circle cx="11" cy="11" r="6"/><path d="m16 16 4 4"/>' );
    $icons['phone']      = $outline( '<path d="M6.6 3.5 9 3l1.5 4.5-2.1 1.8a15.4 15.4 0 0 0 6.3 6.3l1.8-2.1L21 15l-.5 2.4A3 3 0 0 1 17.6 20C9.5 20 4 14.5 4 6.4a3 3 0 0 1 2.6-2.9Z"/>' );
    $icons['email']      = $outline( '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/>' );
    $icons['location']   = $outline( '<path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/>' );
    $icons['calendar']   = $outline( '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4m8-4v4M3 10h18"/>' );
    $icons['clock']      = $outline( '<circle cx="12" cy="12" r="8"/><path d="M12 7v5l3 2"/>' );
    $icons['globe']      = $outline( '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.4 2.5 3.6 5.5 3.6 9S14.4 18.5 12 21c-2.4-2.5-3.6-5.5-3.6-9S9.6 5.5 12 3"/>' );
    $icons['cloud']      = $outline( '<path d="M7 18h10a4 4 0 0 0 .6-8A6 6 0 0 0 6.4 8.2 4.9 4.9 0 0 0 7 18Z"/>' );
    $icons['compass']    = $outline( '<circle cx="12" cy="12" r="9"/><path d="m15.5 8.5-2.1 4.9-4.9 2.1 2.1-4.9 4.9-2.1Z"/>' );
    $icons['question']   = $outline( '<circle cx="12" cy="12" r="9"/><path d="M9.5 9a2.7 2.7 0 1 1 4.3 2.1c-1 .8-1.8 1.3-1.8 2.9M12 17h.01"/>' );
    $icons['quote']      = $outline( '<path d="M8.5 10H6a3 3 0 0 0-3 3v3h5.5V10Zm10 0H16a3 3 0 0 0-3 3v3h5.5V10Z"/>' );
    $icons['sparkles']   = $outline( '<path d="m12 3 1.3 4.7L18 9l-4.7 1.3L12 15l-1.3-4.7L6 9l4.7-1.3L12 3Zm6 12 .7 2.3L21 18l-2.3.7L18 21l-.7-2.3L15 18l2.3-.7L18 15Z"/>' );
    $icons['warning']    = $outline( '<path d="M12 4 2.8 20h18.4L12 4Z"/><path d="M12 9v4m0 3h.01"/>' );

    $icons['technology'] = $icons['gear'];
    $icons['products']   = $icons['enterprise'];
    $icons['process']    = $icons['connected'];
    $icons['success']    = $icons['check'];
    $icons['facebook']   = $outline( '<circle cx="12" cy="12" r="9"/><path d="M13.5 8.5h2V6.2c-.4-.1-1.1-.2-2-.2-2 0-3.2 1.2-3.2 3.4v1.9H8v2.6h2.3V20h3v-6.1h2.1l.3-2.6h-2.4v-1.6c0-.8.2-1.2 1.2-1.2Z"/>' );
    $icons['linkedin']   = $outline( '<rect x="4" y="4" width="16" height="16" rx="2"/><path d="M8 10v6m0-9v.01M11 16v-3.3a2.7 2.7 0 0 1 5.4 0V16"/>' );
    $icons['twitter']    = $outline( '<path d="M20 7.2c-.6.3-1.2.4-1.9.5a3.3 3.3 0 0 0 1.4-1.8 6.7 6.7 0 0 1-2.1.8 3.3 3.3 0 0 0-5.7 3c-2.8-.1-5.3-1.5-7-3.5a3.3 3.3 0 0 0 1 4.4 3.2 3.2 0 0 1-1.5-.4v.1c0 1.6 1.1 3 2.7 3.3-.3.1-.7.1-1 .1-.2 0-.5 0-.7-.1.5 1.4 1.8 2.4 3.4 2.4a6.7 6.7 0 0 1-4.1 1.4H4a9.5 9.5 0 0 0 5.1 1.5c6.2 0 9.6-5.1 9.6-9.6v-.4c.6-.5 1.1-1 1.5-1.7Z"/>' );
    $icons['github']     = $outline( '<path d="M15.5 21v-3.4c0-1-.4-1.6-.8-1.9 2.8-.3 4.8-1.3 4.8-5a3.9 3.9 0 0 0-1-2.7c.1-.3.4-1.3-.1-2.7 0 0-.8-.3-2.7 1a9.3 9.3 0 0 0-4.9 0c-1.9-1.3-2.7-1-2.7-1-.5 1.4-.2 2.4-.1 2.7a3.9 3.9 0 0 0-1 2.7c0 3.7 2 4.7 4.8 5-.4.3-.8 1-.8 1.9V21"/><path d="M8.5 18.5c-2 .6-2.7-.9-2.7-.9-.4-.8-.9-1- .9-1"/>' );

    return $icons;
}
add_filter( 'paksa_icon_library', 'paksa_extend_visual_icon_library' );

/**
 * Make the visual system available in the editor without depending on a build step.
 */
function paksa_enqueue_visual_editor_assets() {
    wp_enqueue_style(
        'paksa-editor-variables',
        PAKSA_THEME_URI . '/assets/css/variables.css',
        array(),
        PAKSA_THEME_VERSION
    );
    wp_enqueue_style(
        'paksa-editor-components',
        PAKSA_THEME_URI . '/assets/css/components.css',
        array( 'paksa-editor-variables' ),
        PAKSA_THEME_VERSION
    );
    wp_enqueue_style(
        'paksa-blocks',
        PAKSA_THEME_URI . '/assets/css/blocks.css',
        array( 'paksa-editor-variables', 'paksa-editor-components' ),
        PAKSA_THEME_VERSION
    );
    wp_enqueue_style(
        'paksa-editor',
        PAKSA_THEME_URI . '/assets/css/editor.css',
        array( 'paksa-blocks' ),
        PAKSA_THEME_VERSION
    );
    wp_enqueue_script(
        'paksa-editor-blocks',
        PAKSA_THEME_URI . '/assets/js/editor-blocks.js',
        array( 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element', 'wp-i18n', 'wp-server-side-render' ),
        PAKSA_THEME_VERSION,
        true
    );
    wp_enqueue_script(
        'paksa-editor-phase18',
        PAKSA_THEME_URI . '/assets/js/editor-phase18.js',
        array( 'paksa-editor-blocks', 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element', 'wp-dom-ready', 'wp-server-side-render' ),
        PAKSA_THEME_VERSION,
        true
    );
    wp_enqueue_script(
        'paksa-editor-phase20',
        PAKSA_THEME_URI . '/assets/js/editor-phase20.js',
        array( 'paksa-editor-phase18', 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element', 'wp-dom-ready', 'wp-hooks', 'wp-compose' ),
        PAKSA_THEME_VERSION,
        true
    );

    $icons = array();
    foreach ( array_keys( paksa_icon_library() ) as $icon ) {
        $icons[] = array(
            'label' => ucwords( str_replace( array( '-', '_' ), ' ', $icon ) ),
            'value' => $icon,
            'svg'   => paksa_icon( $icon ),
        );
    }
    wp_localize_script( 'paksa-editor-blocks', 'paksaIconBlock', array( 'icons' => $icons ) );
}
add_action( 'enqueue_block_editor_assets', 'paksa_enqueue_visual_editor_assets' );

/**
 * Register the Phase 14 pattern categories.
 */
function paksa_register_visual_pattern_categories() {
    if ( ! function_exists( 'register_block_pattern_category' ) ) {
        return;
    }

    $categories = array(
        'paksa-sections'     => __( 'Paksa Sections', 'paksa-it-solutions' ),
        'paksa-cta'          => __( 'Paksa Calls to Action', 'paksa-it-solutions' ),
        'paksa-social-proof' => __( 'Paksa Social Proof', 'paksa-it-solutions' ),
        'paksa-faq'          => __( 'Paksa FAQs', 'paksa-it-solutions' ),
        'paksa-contact'      => __( 'Paksa Contact', 'paksa-it-solutions' ),
        'paksa-layouts'      => __( 'Paksa Layouts', 'paksa-it-solutions' ),
    );

    foreach ( $categories as $slug => $label ) {
        register_block_pattern_category( $slug, array( 'label' => $label ) );
    }
}
add_action( 'init', 'paksa_register_visual_pattern_categories', 6 );

/**
 * Small markup helpers used only while registering static block patterns.
 */
function paksa_visual_group( $class_name, $content, $attributes = array() ) {
    $attributes['className'] = trim( ( isset( $attributes['className'] ) ? $attributes['className'] . ' ' : '' ) . $class_name );
    $classes = 'wp-block-group ' . $attributes['className'];
    if ( ! empty( $attributes['align'] ) ) {
        $classes .= ' align' . $attributes['align'];
    }

    return '<!-- wp:group ' . wp_json_encode( $attributes ) . ' -->'
        . '<div class="' . esc_attr( $classes ) . '">' . $content . '</div>'
        . '<!-- /wp:group -->';
}

function paksa_visual_heading( $text, $level = 2, $class_name = '' ) {
    $level      = max( 1, min( 6, absint( $level ) ) );
    $attributes = array( 'level' => $level );
    if ( $class_name ) {
        $attributes['className'] = $class_name;
    }

    return '<!-- wp:heading ' . wp_json_encode( $attributes ) . ' -->'
        . '<h' . $level . ( $class_name ? ' class="' . esc_attr( $class_name ) . '"' : '' ) . '>' . esc_html( $text ) . '</h' . $level . '>'
        . '<!-- /wp:heading -->';
}

function paksa_visual_paragraph( $text, $class_name = '' ) {
    $attributes = $class_name ? array( 'className' => $class_name ) : array();
    return '<!-- wp:paragraph' . ( $attributes ? ' ' . wp_json_encode( $attributes ) : '' ) . ' -->'
        . '<p' . ( $class_name ? ' class="' . esc_attr( $class_name ) . '"' : '' ) . '>' . esc_html( $text ) . '</p>'
        . '<!-- /wp:paragraph -->';
}

function paksa_visual_icon( $name, $size = 24 ) {
    return '<!-- wp:paksa/icon ' . wp_json_encode( array( 'name' => sanitize_key( $name ), 'size' => absint( $size ) ) ) . ' /-->';
}

function paksa_visual_actions( $primary = 'Get started', $secondary = 'Learn more' ) {
    $primary_button = '<!-- wp:button -->'
        . '<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#">' . esc_html( $primary ) . '</a></div>'
        . '<!-- /wp:button -->';
    $secondary_button = '<!-- wp:button {"className":"is-style-paksa-button-outline"} -->'
        . '<div class="wp-block-button is-style-paksa-button-outline"><a class="wp-block-button__link wp-element-button" href="#">' . esc_html( $secondary ) . '</a></div>'
        . '<!-- /wp:button -->';

    return '<!-- wp:buttons {"className":"pk-pattern-actions"} -->'
        . '<div class="wp-block-buttons pk-pattern-actions">' . $primary_button . $secondary_button . '</div>'
        . '<!-- /wp:buttons -->';
}

function paksa_visual_card( $icon, $title, $description, $modifier = '' ) {
    return paksa_visual_group(
        trim( 'pk-pattern-card ' . $modifier ),
        paksa_visual_icon( $icon )
        . paksa_visual_heading( $title, 3 )
        . paksa_visual_paragraph( $description )
    );
}

function paksa_visual_columns( $cards, $class_name = 'pk-pattern-card-grid' ) {
    $columns = '';
    foreach ( $cards as $card ) {
        $columns .= '<!-- wp:column -->'
            . '<div class="wp-block-column">' . $card . '</div>'
            . '<!-- /wp:column -->';
    }

    return '<!-- wp:columns {"className":"' . esc_attr( $class_name ) . '"} -->'
        . '<div class="wp-block-columns ' . esc_attr( $class_name ) . '">' . $columns . '</div>'
        . '<!-- /wp:columns -->';
}

function paksa_visual_intro( $eyebrow, $title, $description, $align = 'left' ) {
    return paksa_visual_group(
        'pk-pattern-intro' . ( $align === 'left' ? ' align-left' : '' ),
        paksa_visual_paragraph( $eyebrow, 'pk-pattern-eyebrow' )
        . paksa_visual_heading( $title, 2 )
        . paksa_visual_paragraph( $description, 'has-body-large-font-size' )
    );
}

function paksa_visual_section( $class_name, $eyebrow, $title, $description, $content, $align = 'left' ) {
    $inner = paksa_visual_intro( $eyebrow, $title, $description, $align ) . $content;

    return paksa_visual_group(
        trim( 'pk-pattern-section ' . $class_name ),
        paksa_visual_group( 'pk-pattern-container', $inner, array(
            'layout' => array( 'type' => 'constrained', 'contentSize' => '1200px' ),
        ) ),
        array( 'align' => 'full', 'layout' => array( 'type' => 'constrained' ) )
    );
}

function paksa_visual_stat_grid() {
    $stats = array(
        array( '01', 'Clear starting point' ),
        array( '02', 'Repeatable system' ),
        array( '03', 'Measurable progress' ),
    );
    $content = '';
    foreach ( $stats as $stat ) {
        $content .= paksa_visual_group(
            'pk-pattern-stat',
            '<!-- wp:paragraph --><p><strong>' . esc_html( $stat[0] ) . '</strong><span>' . esc_html( $stat[1] ) . '</span></p><!-- /wp:paragraph -->'
        );
    }

    return paksa_visual_group( 'pk-pattern-stat-grid', $content, array( 'layout' => array( 'type' => 'grid', 'minimumColumnWidth' => '14rem' ) ) );
}

function paksa_visual_logo_strip() {
    $content = '';
    foreach ( array( 'Partner One', 'Partner Two', 'Partner Three', 'Partner Four', 'Partner Five' ) as $name ) {
        $content .= paksa_visual_paragraph( $name, 'pk-pattern-logo' );
    }
    return paksa_visual_group( 'pk-pattern-logo-strip', $content, array( 'layout' => array( 'type' => 'default' ) ) );
}

function paksa_visual_faq_item( $question, $answer, $open = false ) {
    $attributes = array( 'className' => 'pk-pattern-faq' );
    if ( $open ) {
        $attributes['showContent'] = true;
    }
    return '<!-- wp:details ' . wp_json_encode( $attributes ) . ' -->'
        . '<details class="wp-block-details pk-pattern-faq"' . ( $open ? ' open' : '' ) . '><summary>' . esc_html( $question ) . '</summary>'
        . paksa_visual_paragraph( $answer ) . '</details><!-- /wp:details -->';
}

function paksa_visual_faq_list() {
    return paksa_visual_faq_item( 'What can I change after inserting this pattern?', 'Everything: content, layout, colors, type, spacing, buttons, and media remain native Gutenberg blocks.', true )
        . paksa_visual_faq_item( 'Does the design work on smaller screens?', 'Yes. The pattern uses responsive WordPress blocks and the theme’s shared layout rules.' )
        . paksa_visual_faq_item( 'Can I reuse the section on other pages?', 'Yes. Insert it from the Patterns panel whenever you need the same structure.' );
}

function paksa_visual_media_placeholder() {
    return '<!-- wp:cover {"overlayColor":"dark","minHeight":360,"className":"pk-pattern-media"} -->'
        . '<div class="wp-block-cover pk-pattern-media" style="min-height:360px"><span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim-70 has-background-dim"></span><div class="wp-block-cover__inner-container is-layout-flow wp-block-cover-is-layout-flow">'
        . paksa_visual_paragraph( 'Replace this cover with an image or video from your Media Library.', 'has-text-align-center has-white-color has-text-color' )
        . '</div></div><!-- /wp:cover -->';
}

/**
 * Register a broad but composable pattern library built only from editable blocks.
 */
function paksa_register_phase_14_patterns() {
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    $hero_cards = paksa_visual_columns( array(
        paksa_visual_card( 'analytics', 'Insight', 'Turn information into a clear next action.' ),
        paksa_visual_card( 'automation', 'Flow', 'Remove friction from the work that matters.' ),
        paksa_visual_card( 'shield', 'Confidence', 'Build a system designed to last.' ),
    ) );

    $hero_split = paksa_visual_columns( array(
        paksa_visual_group( 'pk-pattern-hero-copy', paksa_visual_intro( 'A flexible start', 'Build a clearer digital experience.', 'Use this split layout when your message needs room to breathe.' ) . paksa_visual_actions() ),
        paksa_visual_group( 'pk-pattern-hero-visual', paksa_visual_media_placeholder() )
    ), 'pk-pattern-hero-split' );

    $service_cards = paksa_visual_columns( array(
        paksa_visual_card( 'services', 'Strategy & discovery', 'Frame the problem, prioritise the opportunity, and plan the next move.' ),
        paksa_visual_card( 'technology', 'Design & delivery', 'Create a useful experience with an adaptable implementation.' ),
        paksa_visual_card( 'analytics', 'Optimisation', 'Learn from performance and keep improving what you ship.' ),
    ) );

    $process = paksa_visual_group( 'pk-pattern-process',
        paksa_visual_group( 'pk-pattern-process-step', paksa_visual_paragraph( '01', 'pk-pattern-step-number' ) . paksa_visual_heading( 'Discover', 3 ) . paksa_visual_paragraph( 'Align on goals, users, and opportunity.' ) )
        . paksa_visual_group( 'pk-pattern-process-step', paksa_visual_paragraph( '02', 'pk-pattern-step-number' ) . paksa_visual_heading( 'Create', 3 ) . paksa_visual_paragraph( 'Design and build the essential experience.' ) )
        . paksa_visual_group( 'pk-pattern-process-step', paksa_visual_paragraph( '03', 'pk-pattern-step-number' ) . paksa_visual_heading( 'Improve', 3 ) . paksa_visual_paragraph( 'Measure the outcome and iterate with confidence.' ) )
    );

    $testimonial_cards = paksa_visual_columns( array(
        paksa_visual_card( 'quote', '“A thoughtful process from the first workshop to launch.”', 'Name, role and company' ),
        paksa_visual_card( 'quote', '“The work made a complicated offer feel simple.”', 'Name, role and company' ),
        paksa_visual_card( 'quote', '“An adaptable foundation our team can now own.”', 'Name, role and company' ),
    ), 'pk-pattern-card-grid pk-testimonials-grid' );

    $testimonial_rail = paksa_visual_group( 'pk-testimonial-rail',
        paksa_visual_card( 'quote', '“A thoughtful process from the first workshop to launch.”', 'Name, role and company' )
        . paksa_visual_card( 'quote', '“The work made a complicated offer feel simple.”', 'Name, role and company' )
        . paksa_visual_card( 'quote', '“An adaptable foundation our team can now own.”', 'Name, role and company' )
    );

    $comparison = paksa_visual_columns( array(
        paksa_visual_card( 'check', 'Foundation', 'A focused option for getting the essentials in place.' ) . paksa_visual_actions( 'Choose foundation', 'Compare' ),
        paksa_visual_card( 'sparkles', 'Growth', 'An expanded option for teams with evolving requirements.', 'pk-pattern-card--dark' ) . paksa_visual_actions( 'Choose growth', 'Compare' ),
        paksa_visual_card( 'globe', 'Custom', 'A tailored scope shaped around your systems and objectives.' ) . paksa_visual_actions( 'Talk to us', 'Compare' ),
    ) );

    $contact_form = '<!-- wp:shortcode -->[paksa_contact_form]<!-- /wp:shortcode -->';
    $contact_layout = paksa_visual_columns( array(
        paksa_visual_group( 'pk-pattern-contact-card', paksa_visual_heading( 'Start a conversation', 3 ) . paksa_visual_paragraph( 'Use the existing theme contact form. Its delivery settings remain managed in Global Site Settings.' ) . $contact_form ),
        paksa_visual_group( 'pk-pattern-contact-card', paksa_visual_icon( 'location' ) . paksa_visual_heading( 'Contact details', 3 ) . paksa_visual_paragraph( 'Add your location, support hours, phone number, and email here.' ) . paksa_visual_actions( 'Get directions', 'Email us' ) )
    ) );

    $patterns = array(
        'hero-classic' => array( __( 'Hero — Classic', 'paksa-it-solutions' ), 'paksa-hero', paksa_visual_section( 'pk-hero pk-hero--classic', 'Start with clarity', 'A focused message for the people you serve.', 'Introduce the value of your offer in a few readable lines, then guide visitors to a clear next step.', paksa_visual_actions() ) ),
        'hero-split-modern' => array( __( 'Hero — Split', 'paksa-it-solutions' ), 'paksa-hero', paksa_visual_section( 'pk-hero pk-hero--split', 'Designed to adapt', 'Pair your story with an editable visual.', 'This layout keeps the copy and media independently editable.', $hero_split ) ),
        'hero-media' => array( __( 'Hero — Image or Video', 'paksa-it-solutions' ), 'paksa-hero', paksa_visual_section( 'pk-hero pk-hero--media', 'Visual storytelling', 'Make your first impression more tangible.', 'Replace the cover block with an image or video from your Media Library.', paksa_visual_media_placeholder() ) ),
        'hero-dark-modern' => array( __( 'Hero — Dark', 'paksa-it-solutions' ), 'paksa-hero', paksa_visual_section( 'pk-hero pk-hero--dark', 'Confident direction', 'A bold introduction with calm hierarchy.', 'Use a high-contrast hero when the message needs extra emphasis.', paksa_visual_actions( 'Explore options', 'See how it works' ) ) ),
        'hero-gradient' => array( __( 'Hero — Gradient', 'paksa-it-solutions' ), 'paksa-hero', paksa_visual_section( 'pk-hero pk-hero--gradient', 'Built for momentum', 'A flexible gradient hero for a modern launch.', 'The background, colors, spacing, and call to action can all be tailored in the editor.', paksa_visual_actions() ) ),
        'hero-centered' => array( __( 'Hero — Centered', 'paksa-it-solutions' ), 'paksa-hero', paksa_visual_section( 'pk-hero pk-hero--centered', 'Make it simple', 'One strong idea, one clear action.', 'Use this centered pattern when the page has a single primary goal.', paksa_visual_actions(), 'center' ) ),
        'hero-statistics' => array( __( 'Hero — Statistics', 'paksa-it-solutions' ), 'paksa-hero', paksa_visual_section( 'pk-hero pk-hero--classic', 'Progress you can explain', 'Connect a clear promise to meaningful proof.', 'Use the labels for achievements, dates, customers, or any other contextual proof.', paksa_visual_actions() . paksa_visual_stat_grid() ) ),
        'hero-cards' => array( __( 'Hero — Cards', 'paksa-it-solutions' ), 'paksa-hero', paksa_visual_section( 'pk-hero pk-hero--classic', 'A useful starting point', 'Introduce your offer and the pillars behind it.', 'Each card is a native Group block you can rearrange, duplicate, or restyle.', $hero_cards ) ),
        'hero-trust' => array( __( 'Hero — CTA and Trust', 'paksa-it-solutions' ), 'paksa-hero', paksa_visual_section( 'pk-hero pk-hero--classic', 'Ready when you are', 'Make the next step feel low-risk.', 'Pair an immediate action with recognizable trust signals.', paksa_visual_actions( 'Start a project', 'See our approach' ) . paksa_visual_logo_strip() ) ),
        'hero-background-video' => array( __( 'Hero — Video Background', 'paksa-it-solutions' ), 'paksa-hero', paksa_visual_section( 'pk-hero pk-hero--dark', 'Make the moment tangible', 'A visual hero that is ready for your video.', 'Replace the Cover block with a background video or image from your Media Library, then edit the message and actions.', paksa_visual_media_placeholder() . paksa_visual_actions( 'Watch the story', 'Explore more' ) ) ),
        'about-story' => array( __( 'About — Company Story', 'paksa-it-solutions' ), 'paksa-sections', paksa_visual_section( '', 'About your organisation', 'Share the story behind the work.', 'Use this section to explain where you started, what you have learned, and how those ideas guide your work today.', paksa_visual_columns( array( paksa_visual_card( 'globe', 'Your beginning', 'Describe the original opportunity or reason for starting.' ), paksa_visual_card( 'users', 'Your direction', 'Describe the people, principles, or future you are building toward.' ) ) ) ) ),
        'about-values' => array( __( 'About — Mission and Values', 'paksa-it-solutions' ), 'paksa-sections', paksa_visual_section( '', 'What guides you', 'State the mission, then make values visible.', 'Use the cards to turn principles into practical commitments.', paksa_visual_columns( array( paksa_visual_card( 'compass', 'Purpose', 'A concise statement of the change you want to create.' ), paksa_visual_card( 'shield', 'Integrity', 'A clear commitment that helps people know what to expect.' ), paksa_visual_card( 'sparkles', 'Curiosity', 'The habit of learning, testing, and improving together.' ) ) ) ) ),
        'services-grid-modern' => array( __( 'Services — Card Grid', 'paksa-it-solutions' ), 'paksa-sections', paksa_visual_section( '', 'What you offer', 'Make a broad service offer easy to scan.', 'Each card is a reusable structure with editable icon, title, text, color, and link.', $service_cards ) ),
        'services-featured' => array( __( 'Services — Featured', 'paksa-it-solutions' ), 'paksa-sections', paksa_visual_section( 'pk-pattern-section--narrow', 'Featured capability', 'Give one important offer more room to speak.', 'Explain the problem it solves, who it helps, and why the outcome matters.', paksa_visual_columns( array( paksa_visual_group( 'pk-pattern-card pk-pattern-card--dark', paksa_visual_icon( 'technology', 32 ) . paksa_visual_heading( 'A capability worth highlighting', 3 ) . paksa_visual_paragraph( 'Add a concise benefit statement and a focused visual or product screenshot.' ) ), paksa_visual_group( 'pk-pattern-card', paksa_visual_heading( 'What is included', 3 ) . paksa_visual_paragraph( 'Use a list, a short process, or supporting proof points in this editable column.' ) . paksa_visual_actions( 'Explore the service', 'Ask a question' ) ) ) ) ) ),
        'services-comparison' => array( __( 'Services — Comparison', 'paksa-it-solutions' ), 'paksa-sections', paksa_visual_section( '', 'Find the right fit', 'Compare paths without forcing a one-size-fits-all decision.', 'Edit the titles, inclusions, and calls to action for your own service tiers.', $comparison ) ),
        'products-grid' => array( __( 'Products — Grid', 'paksa-it-solutions' ), 'paksa-sections', paksa_visual_section( '', 'Explore the product range', 'A modular collection that users can browse quickly.', 'Swap each icon for an image, keep the cards, or connect the buttons to product pages.', paksa_visual_columns( array( paksa_visual_card( 'products', 'Product one', 'A short statement describing its most important job.' ), paksa_visual_card( 'analytics', 'Product two', 'A short statement describing its most important job.' ), paksa_visual_card( 'cloud', 'Product three', 'A short statement describing its most important job.' ) ) ) ) ),
        'industries-grid' => array( __( 'Industries — Grid', 'paksa-it-solutions' ), 'paksa-sections', paksa_visual_section( '', 'Who you help', 'Adapt your expertise to the context of each industry.', 'Keep the copy specific enough to be useful without repeating every service.', paksa_visual_columns( array( paksa_visual_card( 'manufacturing', 'Manufacturing', 'Build a short industry-specific outcome statement.' ), paksa_visual_card( 'healthcare', 'Healthcare', 'Build a short industry-specific outcome statement.' ), paksa_visual_card( 'retail', 'Retail', 'Build a short industry-specific outcome statement.' ) ) ) ) ),
        'technology-stack' => array( __( 'Technology — Stack', 'paksa-sections' ), 'paksa-sections', paksa_visual_section( '', 'Technology that fits', 'Show the tools, platforms, and practices behind the experience.', 'Use this space for technologies, integrations, platforms, or delivery principles.', paksa_visual_columns( array( paksa_visual_card( 'cloud', 'Reliable foundation', 'Name a platform, environment, or hosting principle.' ), paksa_visual_card( 'analytics', 'Useful insight', 'Name a data, analytics, or reporting capability.' ), paksa_visual_card( 'shield', 'Built-in resilience', 'Name a security, privacy, or governance consideration.' ) ) ) ) ),
        'technology-matrix' => array( __( 'Technology — Capability Matrix', 'paksa-sections' ), 'paksa-sections', paksa_visual_section( '', 'Capabilities at a glance', 'Use cards to compare what is available across an offer.', 'Replace the placeholder labels with your own platforms, services, or capability levels.', $comparison ) ),
        'process-steps' => array( __( 'Process — Numbered Steps', 'paksa-sections' ), 'paksa-sections', paksa_visual_section( '', 'A process people can follow', 'Show what happens from the first conversation to the next milestone.', 'The numbered steps are easy to reorder or extend in the editor.', $process ) ),
        'process-timeline' => array( __( 'Process — Timeline', 'paksa-sections' ), 'paksa-sections', paksa_visual_section( '', 'Move from idea to outcome', 'A simple timeline keeps expectations visible.', 'Use each step for an important decision, milestone, or handoff.', $process ) ),
        'statistics-grid' => array( __( 'Statistics — Metric Grid', 'paksa-sections' ), 'paksa-sections', paksa_visual_section( '', 'Proof in context', 'Give key metrics a clear visual hierarchy.', 'Replace the placeholders with verified figures and enough context to understand them.', paksa_visual_stat_grid() ) ),
        'logo-strip' => array( __( 'Trust — Client Logo Strip', 'paksa-it-solutions' ), 'paksa-social-proof', paksa_visual_section( '', 'Trusted by teams like yours', 'Use recognisable signals to build confidence.', 'Replace each text placeholder with a Logo block or a linked image from your Media Library.', paksa_visual_logo_strip(), 'center' ) ),
        'testimonials' => array( __( 'Trust — Testimonials', 'paksa-it-solutions' ), 'paksa-social-proof', paksa_visual_section( '', 'What people remember', 'Share real words from the people you help.', 'Replace every placeholder with a genuine, permissioned quote and attribution.', $testimonial_cards ) ),
        'testimonial-slider' => array( __( 'Trust — Testimonial Slider', 'paksa-it-solutions' ), 'paksa-social-proof', paksa_visual_section( '', 'Stories you can browse', 'A touch-friendly, scroll-snap testimonial rail with no heavy dependency.', 'Replace the placeholders with genuine, permissioned quotes; visitors can scroll the cards naturally.', $testimonial_rail ) ),
        'pricing-cards' => array( __( 'Pricing — Cards', 'paksa-it-solutions' ), 'paksa-sections', paksa_visual_section( '', 'Make the choice clearer', 'Present offer levels with room for the details that matter.', 'Edit names, inclusions, prices, and calls to action in the native blocks.', $comparison ) ),
        'comparison-cards' => array( __( 'Comparison — Cards', 'paksa-it-solutions' ), 'paksa-sections', paksa_visual_section( '', 'Compare options side by side', 'Use a consistent layout to show the differences that matter.', 'Add lists, buttons, or feature details inside each editable card.', $comparison ) ),
        'faq-accordion' => array( __( 'FAQ — Accordion', 'paksa-it-solutions' ), 'paksa-faq', paksa_visual_section( 'pk-pattern-section--narrow', 'Helpful answers', 'Answer the questions that keep people moving.', 'The native Details blocks provide keyboard-accessible disclosure without custom JavaScript.', paksa_visual_faq_list() ) ),
        'faq-two-column' => array( __( 'FAQ — Two Column', 'paksa-it-solutions' ), 'paksa-faq', paksa_visual_section( '', 'Common questions', 'Keep related topics together for faster scanning.', 'Duplicate, remove, or reorder each accessible FAQ block.', paksa_visual_columns( array( paksa_visual_group( 'pk-pattern-faq-list', paksa_visual_faq_item( 'How do we get started?', 'Begin with the information you already have and refine from there.', true ) . paksa_visual_faq_item( 'Can this scale later?', 'Yes. Start with a clear foundation and extend it as requirements evolve.' ) ), paksa_visual_group( 'pk-pattern-faq-list', paksa_visual_faq_item( 'Who can edit this?', 'Anyone with WordPress editing permission can change the blocks.' ) . paksa_visual_faq_item( 'Can we use our own design?', 'Yes. Global Styles and the pattern blocks are intentionally adaptable.' ) ) ) ) ) ),
        'faq-cards' => array( __( 'FAQ — Cards', 'paksa-it-solutions' ), 'paksa-faq', paksa_visual_section( '', 'Quick answers', 'Use cards when each response needs more space or a different visual weight.', 'Turn the placeholders into questions, support notes, or short explainers.', paksa_visual_columns( array( paksa_visual_card( 'question', 'Question one', 'Write a concise, practical answer here.' ), paksa_visual_card( 'question', 'Question two', 'Write a concise, practical answer here.' ), paksa_visual_card( 'question', 'Question three', 'Write a concise, practical answer here.' ) ) ) ) ),
        'faq-sidebar' => array( __( 'FAQ — With Sidebar', 'paksa-it-solutions' ), 'paksa-faq', paksa_visual_section( '', 'Support at the right moment', 'Keep contact help visible alongside detailed answers.', 'Edit the supporting text, action, and all native Details blocks directly in the editor.', paksa_visual_columns( array( paksa_visual_group( 'pk-pattern-card pk-pattern-card--dark', paksa_visual_icon( 'phone' ) . paksa_visual_heading( 'Still need help?', 3 ) . paksa_visual_paragraph( 'Give visitors a helpful alternate way to get an answer.' ) . paksa_visual_actions( 'Contact support', 'View resources' ) ), paksa_visual_group( 'pk-pattern-faq-list', paksa_visual_faq_list() ) ) ) ) ),
        'cta-simple' => array( __( 'CTA — Simple', 'paksa-it-solutions' ), 'paksa-cta', paksa_visual_section( '', 'A clear next step', 'End a page with one action that is easy to understand.', 'Use the text to make the expected outcome of clicking the button explicit.', paksa_visual_group( 'pk-pattern-cta', paksa_visual_heading( 'Ready to move forward?', 2 ) . paksa_visual_paragraph( 'Give visitors one concise reason to take the next step now.' ) . paksa_visual_actions( 'Start a conversation', 'See the details' ) ) ) ),
        'cta-split' => array( __( 'CTA — Split', 'paksa-it-solutions' ), 'paksa-cta', paksa_visual_section( '', 'Keep the conversation open', 'Pair a strong call to action with supporting reassurance.', 'Use the second column for an image, response-time promise, or short checklist.', paksa_visual_columns( array( paksa_visual_group( 'pk-pattern-cta', paksa_visual_heading( 'Bring the next idea into focus.', 2 ) . paksa_visual_paragraph( 'A short, calm invitation to talk through the opportunity.' ) . paksa_visual_actions( 'Start a project', 'Ask a question' ) ), paksa_visual_group( 'pk-pattern-card', paksa_visual_icon( 'clock' ) . paksa_visual_heading( 'What happens next', 3 ) . paksa_visual_paragraph( 'Explain your first step, expected response time, or who will be in touch.' ) ) ) ) ) ),
        'cta-dark' => array( __( 'CTA — Dark', 'paksa-it-solutions' ), 'paksa-cta', paksa_visual_section( '', 'Decide with confidence', 'A high-contrast call to action for the end of a high-intent page.', 'Use this variation when the next step needs a confident visual anchor.', paksa_visual_group( 'pk-pattern-cta', paksa_visual_heading( 'Let’s make the next step practical.', 2 ) . paksa_visual_paragraph( 'Add a simple explanation of what happens after someone gets in touch.' ) . paksa_visual_actions( 'Contact us', 'Read more' ) ) ) ),
        'cta-gradient' => array( __( 'CTA — Gradient', 'paksa-it-solutions' ), 'paksa-cta', paksa_visual_section( '', 'An invitation with energy', 'Use a gradient CTA to create focus without leaving the design system.', 'Adjust the background in the block controls or keep the theme preset.', paksa_visual_group( 'pk-pattern-cta pk-pattern-cta--gradient', paksa_visual_heading( 'Build the next version with intent.', 2 ) . paksa_visual_paragraph( 'Use concise copy and one strong next step.' ) . paksa_visual_actions( 'Get started', 'View services' ) ) ) ),
        'cta-icons' => array( __( 'CTA — With Icons', 'paksa-it-solutions' ), 'paksa-cta', paksa_visual_section( '', 'Choose a way forward', 'Give visitors more than one helpful option without overwhelming them.', 'Keep every option clear, intentional, and connected to a real destination.', paksa_visual_columns( array( paksa_visual_card( 'calendar', 'Book a call', 'Choose a time to discuss the opportunity.' ) . paksa_visual_actions( 'Choose a time', 'Learn more' ), paksa_visual_card( 'email', 'Send a brief', 'Share enough context for a useful response.' ) . paksa_visual_actions( 'Send details', 'What to include' ), paksa_visual_card( 'phone', 'Talk to a person', 'Use a direct channel for a quick conversation.' ) . paksa_visual_actions( 'Call now', 'View hours' ) ) ) ) ),
        'cta-image' => array( __( 'CTA — With Image', 'paksa-it-solutions' ), 'paksa-cta', paksa_visual_section( '', 'Make the invitation more concrete', 'Pair the next action with a meaningful image or video.', 'Replace the visual with your own media and use the content blocks to clarify the next step.', paksa_visual_columns( array( paksa_visual_group( 'pk-pattern-cta', paksa_visual_heading( 'Make the next step visible.', 2 ) . paksa_visual_paragraph( 'Use this space for a crisp value statement and an inviting action.' ) . paksa_visual_actions( 'Start now', 'See examples' ) ), paksa_visual_media_placeholder() ) ) ) ),
        'cta-multiple-actions' => array( __( 'CTA — Multiple Actions', 'paksa-it-solutions' ), 'paksa-cta', paksa_visual_section( '', 'There is more than one useful path', 'Offer clear choices for visitors with different needs.', 'Change each label and destination so every option reflects a real next step.', paksa_visual_group( 'pk-pattern-cta pk-pattern-cta--gradient', paksa_visual_heading( 'Choose the conversation that suits you.', 2 ) . paksa_visual_paragraph( 'Use two or more actions when each route is genuinely useful.' ) . paksa_visual_actions( 'Book a call', 'Send an enquiry' ) ) ) ),
        'contact-form-info' => array( __( 'Contact — Form and Information', 'paksa-it-solutions' ), 'paksa-contact', paksa_visual_section( '', 'Start a conversation', 'Use the existing, secure Paksa contact form in an editable layout.', 'Keep form delivery in Global Site Settings; edit the surrounding content directly in Gutenberg.', $contact_layout ) ),
        'contact-map' => array( __( 'Contact — Map and Support', 'paksa-it-solutions' ), 'paksa-contact', paksa_visual_section( '', 'Find or contact us', 'Pair practical contact information with a map or directions.', 'Replace the media placeholder with an Embed block or map supplied by your preferred provider.', paksa_visual_columns( array( paksa_visual_group( 'pk-pattern-contact-card', paksa_visual_icon( 'location' ) . paksa_visual_heading( 'Visit or connect', 3 ) . paksa_visual_paragraph( 'Add your address, opening hours, phone, and support information.' ) . $contact_form ), paksa_visual_media_placeholder() ) ) ) ),
        'contact-cards' => array( __( 'Contact — Cards', 'paksa-it-solutions' ), 'paksa-contact', paksa_visual_section( '', 'Choose the right contact route', 'Let people choose a focused channel instead of searching for details.', 'Use the icon, title, text, and button blocks to tailor each contact path.', paksa_visual_columns( array( paksa_visual_card( 'phone', 'Call', 'Add the hours and number for the right team.' ) . paksa_visual_actions( 'Call now', 'View hours' ), paksa_visual_card( 'email', 'Email', 'Set expectations about response time and next steps.' ) . paksa_visual_actions( 'Send an email', 'Get support' ), paksa_visual_card( 'location', 'Visit', 'Share an address or add a map block to the page.' ) . paksa_visual_actions( 'Get directions', 'Contact us' ) ) ) ) ),
        'newsletter' => array( __( 'Newsletter — Signup', 'paksa-it-solutions' ), 'paksa-contact', paksa_visual_section( '', 'Stay in the loop', 'Invite people to hear from you when there is something useful to share.', 'Connect the search placeholder to a newsletter form block supplied by your chosen provider.', paksa_visual_group( 'pk-pattern-newsletter', paksa_visual_heading( 'Useful updates, sent with care.', 2 ) . paksa_visual_paragraph( 'Describe the value, frequency, and privacy expectation in plain language.' ) . '<!-- wp:search {"label":"Email address","showLabel":false,"placeholder":"Add your form block here","buttonText":"Subscribe","buttonUseIcon":false} /-->' ) ) ),
    );

    foreach ( $patterns as $slug => $pattern ) {
        register_block_pattern( 'paksa-it-solutions/' . $slug, array(
            'title'       => $pattern[0],
            'categories'  => array( $pattern[1] ),
            'description' => __( 'An editable Paksa Theme section built with native WordPress blocks.', 'paksa-it-solutions' ),
            'content'     => $pattern[2],
        ) );
    }
}
add_action( 'init', 'paksa_register_phase_14_patterns', 20 );
