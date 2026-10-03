<?php
/**
 * Paksa Theme — Phase 35 Dynamic Content & Visual Query Builder.
 *
 * Enqueues editor-phase35.js and editor-phase35.css.
 *
 * Adds:
 *  - paksa/dynamic-grid     — server-rendered dynamic content grid that queries
 *                             posts, products, or services via visual configuration
 *  - paksa/dynamic-card     — server-rendered composable card for dynamic content
 *                             (product, service, or post card with region toggles)
 *  - Inspector extensions on core/query for visual query controls (content type,
 *    order, category, featured, etc.)
 *  - Dynamic content state badges (Static / Dynamic / Reusable / Synced)
 *  - Block bindings indicators for dynamic field values
 *  - Empty state editors and error handling for dynamic sources
 *  - Additional pattern compositions (comparison, case-study, dynamic grid presets)
 *
 * Architecture:
 *   - WordPress CPTs and taxonomies remain the source of truth
 *   - Uses existing paksa_get_products() / paksa_get_services() / WP_Query
 *   - Reuses existing card template parts (product-card.php, service-card.php)
 *   - Reuses existing meta keys (_paksa_prod_featured, _paksa_svc_featured)
 *   - Reuses existing responsive attributes (pkMobileCols, pkTabletCols, pkStackMobile)
 *   - Reuses existing motion system (paksa_phase34_motion_classes pattern)
 *   - No custom content database, no custom query language, no Elementor
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue Phase 35 editor assets.
 */
function paksa_enqueue_phase35_editor_assets() {
    if ( ! wp_script_is( 'paksa-editor-phase34', 'enqueued' ) ) {
        return;
    }

    wp_enqueue_script(
        'paksa-editor-phase35',
        PAKSA_THEME_URI . '/assets/js/editor-phase35.js',
        array(
            'paksa-editor-phase34',
            'wp-blocks',
            'wp-block-editor',
            'wp-components',
            'wp-element',
            'wp-hooks',
            'wp-compose',
            'wp-data',
            'wp-plugins',
            'wp-edit-post',
            'wp-dom-ready',
            'wp-i18n',
            'wp-api-fetch',
            'wp-core-data',
            'wp-url',
        ),
        PAKSA_THEME_VERSION,
        true
    );

    wp_enqueue_style(
        'paksa-editor-phase35',
        PAKSA_THEME_URI . '/assets/css/editor-phase35.css',
        array( 'paksa-editor-phase34' ),
        PAKSA_THEME_VERSION
    );

    wp_localize_script( 'paksa-editor-phase35', 'paksaPhase35', array(
        'contentTypes' => array(
            array( 'label' => 'Posts',    'value' => 'post' ),
            array( 'label' => 'Products', 'value' => 'paksa_product' ),
            array( 'label' => 'Services', 'value' => 'paksa_service' ),
            array( 'label' => 'Pages',    'value' => 'page' ),
        ),
        'queryModes' => array(
            array( 'label' => 'Dynamic (query)', 'value' => 'dynamic' ),
            array( 'label' => 'Manual (selected)', 'value' => 'manual' ),
        ),
        'orderOptions' => array(
            array( 'label' => 'Newest first', 'value' => 'DESC|date' ),
            array( 'label' => 'Oldest first', 'value' => 'ASC|date' ),
            array( 'label' => 'Title A–Z',    'value' => 'ASC|title' ),
            array( 'label' => 'Title Z–A',    'value' => 'DESC|title' ),
            array( 'label' => 'Menu order',   'value' => 'ASC|menu_order' ),
        ),
        'layoutPresets' => array(
            array( 'label' => 'Grid',            'value' => 'grid' ),
            array( 'label' => 'Masonry',         'value' => 'masonry' ),
            array( 'label' => 'List',            'value' => 'list' ),
            array( 'label' => 'Featured + Grid', 'value' => 'featured' ),
            array( 'label' => 'Two Column',      'value' => 'two-column' ),
            array( 'label' => 'Three Column',    'value' => 'three-column' ),
            array( 'label' => 'Four Column',     'value' => 'four-column' ),
            array( 'label' => 'Sidebar + Content', 'value' => 'sidebar' ),
        ),
        'cardRegions' => array(
            array( 'label' => 'Image',       'key' => 'image',     'default' => true ),
            array( 'label' => 'Eyebrow',     'key' => 'eyebrow',   'default' => true ),
            array( 'label' => 'Title',       'key' => 'title',     'default' => true ),
            array( 'label' => 'Description', 'key' => 'description', 'default' => true ),
            array( 'label' => 'Metadata',    'key' => 'metadata',  'default' => false ),
            array( 'label' => 'Price',       'key' => 'price',     'default' => false ),
            array( 'label' => 'Category',    'key' => 'category',  'default' => true ),
            array( 'label' => 'CTA',         'key' => 'cta',       'default' => true ),
            array( 'label' => 'Icon',        'key' => 'icon',      'default' => false ),
            array( 'label' => 'Badge',       'key' => 'badge',     'default' => true ),
        ),
        'featuredOptions' => array(
            array( 'label' => 'All items',      'value' => 'all' ),
            array( 'label' => 'Featured only',  'value' => 'featured' ),
            array( 'label' => 'Not featured',   'value' => 'not_featured' ),
        ),
        'postTypes' => array( 'post', 'paksa_product', 'paksa_service', 'page' ),
        'taxonomies' => array(
            'post'         => array( 'category', 'post_tag' ),
            'paksa_product'=> array( 'paksa_product_cat' ),
            'paksa_service'=> array( 'paksa_service_cat' ),
            'page'         => array(),
        ),
        'nonce'   => wp_create_nonce( 'wp_rest' ),
        'restUrl' => rest_url( 'wp/v2' ),
        'version' => PAKSA_THEME_VERSION,
    ) );
}
add_action( 'enqueue_block_editor_assets', 'paksa_enqueue_phase35_editor_assets', 35 );

/**
 * Enqueue Phase 35 frontend CSS.
 */
function paksa_enqueue_phase35_assets() {
    wp_enqueue_style(
        'paksa-phase35-blocks',
        PAKSA_THEME_URI . '/assets/css/editor-phase35.css',
        array( 'paksa-blocks' ),
        PAKSA_THEME_VERSION
    );
}
add_action( 'wp_enqueue_scripts', 'paksa_enqueue_phase35_assets', 35 );

/**
 * Register Phase 35 blocks, block styles, and pattern categories.
 */
function paksa_register_phase35_blocks() {
    if ( ! function_exists( 'register_block_type' ) ) {
        return;
    }

    /* ── paksa/dynamic-grid ──────────────────────────────────────────────── */
    register_block_type( 'paksa/dynamic-grid', array(
        'api_version'     => 3,
        'render_callback' => 'paksa_render_dynamic_grid_block',
        'uses_context'    => array( 'postId', 'postType' ),
        'attributes'      => array_merge(
            array(
                'source'         => array( 'type' => 'string',  'default' => 'paksa_product' ),
                'mode'           => array( 'type' => 'string',  'default' => 'dynamic' ),
                'orderBy'        => array( 'type' => 'string',  'default' => 'date' ),
                'order'          => array( 'type' => 'string',  'default' => 'desc' ),
                'perPage'        => array( 'type' => 'number',  'default' => 9 ),
                'offset'         => array( 'type' => 'number',  'default' => 0 ),
                'category'       => array( 'type' => 'string',  'default' => '' ),
                'author'         => array( 'type' => 'string',  'default' => '' ),
                'featured'       => array( 'type' => 'string',  'default' => 'all' ),
                'selectedIds'    => array( 'type' => 'string',  'default' => '' ),
                'search'         => array( 'type' => 'string',  'default' => '' ),
                'cardVariant'    => array( 'type' => 'string',  'default' => 'default' ),
                'layout'         => array( 'type' => 'string',  'default' => 'grid' ),
                'columns'        => array( 'type' => 'number',  'default' => 3 ),
                'showFilter'     => array( 'type' => 'boolean', 'default' => false ),
                'enableSearch'   => array( 'type' => 'boolean', 'default' => false ),
                'heading'        => array( 'type' => 'string',  'default' => '' ),
                'eyebrow'        => array( 'type' => 'string',  'default' => '' ),
                'description'    => array( 'type' => 'string',  'default' => '' ),
                'emptyMessage'   => array( 'type' => 'string',  'default' => '' ),
                'showReadMore'   => array( 'type' => 'boolean', 'default' => false ),
                'readMoreLabel'  => array( 'type' => 'string',  'default' => __( 'View all', 'paksa-it-solutions' ) ),
                'readMoreUrl'    => array( 'type' => 'string',  'default' => '' ),
                'readMoreNewTab' => array( 'type' => 'boolean', 'default' => false ),
            ),
            paksa_responsive_attributes(),
            paksa_hover_attributes(),
            paksa_border_shadow_attributes(),
            array(
                'animation'    => array( 'type' => 'string',  'default' => 'none' ),
                'animDelay'    => array( 'type' => 'number',  'default' => 0 ),
                'animDuration' => array( 'type' => 'number',  'default' => 600 ),
            )
        ),
        'supports'        => array(
            'align'   => array( 'wide', 'full' ),
            'anchor'  => true,
            'color'   => array( 'text' => true, 'background' => true ),
            'spacing' => array( 'padding' => true, 'margin' => true, 'blockGap' => true ),
        ),
    ) );

    /* ── paksa/dynamic-card ──────────────────────────────────────────────── */
    register_block_type( 'paksa/dynamic-card', array(
        'api_version'     => 3,
        'render_callback' => 'paksa_render_dynamic_card_block',
        'uses_context'    => array( 'postId', 'postType' ),
        'attributes'      => array(
            'source'         => array( 'type' => 'string',  'default' => 'post' ),
            'cardVariant'    => array( 'type' => 'string',  'default' => 'default' ),
            'showImage'      => array( 'type' => 'boolean', 'default' => true ),
            'showEyebrow'    => array( 'type' => 'boolean', 'default' => true ),
            'showTitle'      => array( 'type' => 'boolean', 'default' => true ),
            'showDescription' => array( 'type' => 'boolean', 'default' => true ),
            'showMetadata'   => array( 'type' => 'boolean', 'default' => false ),
            'showPrice'      => array( 'type' => 'boolean', 'default' => false ),
            'showCategory'   => array( 'type' => 'boolean', 'default' => true ),
            'showCta'        => array( 'type' => 'boolean', 'default' => true ),
            'showIcon'       => array( 'type' => 'boolean', 'default' => false ),
            'showBadge'      => array( 'type' => 'boolean', 'default' => true ),
            'linkLabel'      => array( 'type' => 'string',  'default' => '' ),
            'headingTag'     => array( 'type' => 'string',  'default' => 'h3' ),
            'animation'      => array( 'type' => 'string',  'default' => 'none' ),
            'animDelay'      => array( 'type' => 'number',  'default' => 0 ),
        ),
        'supports'        => array(
            'align'   => array( 'left', 'center', 'right' ),
            'color'   => array( 'text' => true, 'background' => true ),
            'spacing' => array( 'margin' => true, 'padding' => true ),
        ),
    ) );

    /* ── Block styles for Phase 35 ──────────────────────────────────────── */
    if ( function_exists( 'register_block_style' ) ) {
        register_block_style( 'paksa/dynamic-grid', array(
            'name'  => 'paksa-grid-dense',
            'label' => __( 'Dense Grid', 'paksa-it-solutions' ),
        ) );
        register_block_style( 'paksa/dynamic-grid', array(
            'name'  => 'paksa-grid-spacious',
            'label' => __( 'Spacious Grid', 'paksa-it-solutions' ),
        ) );
        register_block_style( 'paksa/dynamic-grid', array(
            'name'  => 'paksa-list-bullets',
            'label' => __( 'List with Bullets', 'paksa-it-solutions' ),
        ) );
        register_block_style( 'paksa/dynamic-card', array(
            'name'  => 'paksa-card-dynamic',
            'label' => __( 'Dynamic Card', 'paksa-it-solutions' ),
        ) );
        register_block_style( 'paksa/dynamic-card', array(
            'name'  => 'paksa-card-overlay',
            'label' => __( 'Overlay Card', 'paksa-it-solutions' ),
        ) );
    }
}
add_action( 'init', 'paksa_register_phase35_blocks', 17 );

/* ── Pattern categories ───────────────────────────────────────────────────── */
function paksa_register_phase35_pattern_categories() {
    if ( ! function_exists( 'register_block_pattern_category' ) ) {
        return;
    }

    $categories = array(
        'paksa-dynamic-grids'    => __( 'Paksa Dynamic Grids', 'paksa-it-solutions' ),
        'paksa-dynamic-cards'    => __( 'Paksa Dynamic Cards', 'paksa-it-solutions' ),
        'paksa-comparisons'      => __( 'Paksa Comparisons', 'paksa-it-solutions' ),
        'paksa-faq-dynamic'      => __( 'Paksa FAQ', 'paksa-it-solutions' ),
        'paksa-content-showcase' => __( 'Paksa Content Showcase', 'paksa-it-solutions' ),
    );

    foreach ( $categories as $slug => $label ) {
        register_block_pattern_category( $slug, array( 'label' => $label ) );
    }
}
add_action( 'init', 'paksa_register_phase35_pattern_categories', 10 );

/* ── Dynamic query helpers ────────────────────────────────────────────── */

/**
 * Build WP_Query args for a dynamic-grid block from attributes.
 *
 * @param array $attributes Block attributes.
 * @return array WP_Query args.
 */
function paksa_build_dynamic_query_args( $attributes ) {
    $source   = isset( $attributes['source'] ) ? sanitize_key( $attributes['source'] ) : 'post';
    $mode     = isset( $attributes['mode'] ) ? sanitize_key( $attributes['mode'] ) : 'dynamic';
    $per_page = isset( $attributes['perPage'] ) ? max( 1, min( 50, absint( $attributes['perPage'] ) ) ) : 9;
    $offset   = isset( $attributes['offset'] ) ? max( 0, absint( $attributes['offset'] ) ) : 0;
    $category = isset( $attributes['category'] ) ? sanitize_text_field( $attributes['category'] ) : '';
    $featured = isset( $attributes['featured'] ) ? sanitize_key( $attributes['featured'] ) : 'all';
    $selected = isset( $attributes['selectedIds'] ) ? sanitize_text_field( $attributes['selectedIds'] ) : '';
    $search   = isset( $attributes['search'] ) ? sanitize_text_field( $attributes['search'] ) : '';

    $tax_slugs = paksa_get_taxonomy_for_source( $source );
    $tax_field = $tax_slugs ? $tax_slugs[0] : 'category';

    $args = array(
        'post_type'           => $source,
        'post_status'         => 'publish',
        'posts_per_page'      => $per_page,
        'offset'              => $offset,
        'no_found_rows'       => true,
        'ignore_sticky_posts' => true,
    );

    if ( $mode === 'manual' && ! empty( $selected ) ) {
        $ids = array_values( array_filter( array_map( 'absint', explode( ',', $selected ) ) ) );
        if ( ! empty( $ids ) ) {
            $args['post__in']    = $ids;
            $args['orderby']     = 'post__in';
            $args['posts_per_page'] = count( $ids );
            return $args;
        }
    }

    $order_by = isset( $attributes['orderBy'] ) ? sanitize_key( $attributes['orderBy'] ) : 'date';
    $order    = isset( $attributes['order'] ) ? sanitize_key( $attributes['order'] ) : 'desc';
    $order_by = in_array( $order_by, array( 'date', 'title', 'menu_order', 'rand' ), true )
        ? $order_by : 'date';
    $order = in_array( $order, array( 'asc', 'desc' ), true ) ? $order : 'desc';

    if ( $order_by === 'menu_order' ) {
        $args['orderby'] = array( 'menu_order' => strtoupper( $order ), 'title' => strtoupper( $order ) );
    } else {
        $args['orderby'] = $order_by === 'rand' ? 'rand' : $order_by;
        $args['order']   = strtoupper( $order );
    }

    if ( $category && $tax_field ) {
        $args['tax_query'] = array( array(
            'taxonomy' => $tax_field,
            'field'    => 'slug',
            'terms'    => explode( ',', $category ),
        ) );
    }

    if ( $featured !== 'all' ) {
        $meta_key = paksa_get_featured_meta_key( $source );
        if ( $meta_key ) {
            $meta_value = ( $featured === 'featured' ) ? '1' : '0';
            $args['meta_query'] = array( array(
                'key'     => $meta_key,
                'value'   => $meta_value,
                'compare' => '=',
            ) );
        }
    }

    if ( $search ) {
        $args['s'] = $search;
    }

    return $args;
}

/**
 * Get the taxonomy slug for a given post type source.
 *
 * @param string $source Post type.
 * @return array|false Array of taxonomy slugs or false.
 */
function paksa_get_taxonomy_for_source( $source ) {
    switch ( $source ) {
        case 'post':
            return array( 'category' );
        case 'paksa_product':
            return array( 'paksa_product_cat' );
        case 'paksa_service':
            return array( 'paksa_service_cat' );
        default:
            return false;
    }
}

/**
 * Get the featured meta key for a post type.
 *
 * @param string $source Post type.
 * @return string|false Meta key or false.
 */
function paksa_get_featured_meta_key( $source ) {
    switch ( $source ) {
        case 'paksa_product':
            return '_paksa_prod_featured';
        case 'paksa_service':
            return '_paksa_svc_featured';
        default:
            return false;
    }
}

/**
 * Get items for a dynamic-grid block.
 *
 * @param array $attributes Block attributes.
 * @return WP_Post[]
 */
function paksa_get_dynamic_grid_items( $attributes ) {
    $source = isset( $attributes['source'] ) ? sanitize_key( $attributes['source'] ) : 'post';

    if ( $source === 'paksa_product' && function_exists( 'paksa_get_products' ) ) {
        $args = paksa_build_dynamic_query_args( $attributes );
        return paksa_get_products( $args );
    }

    if ( $source === 'paksa_service' && function_exists( 'paksa_get_services' ) ) {
        $args = paksa_build_dynamic_query_args( $attributes );
        return paksa_get_services( $args );
    }

    $args = paksa_build_dynamic_query_args( $attributes );
    $query = new WP_Query( $args );
    return $query->posts;
}

/**
 * Render a single dynamic card for the given post.
 *
 * @param WP_Post $post       The post to render.
 * @param array   $attributes Block attributes (for region toggles).
 * @param int     $index      Card index for animation delay.
 * @return string
 */
function paksa_render_dynamic_card( $post, $attributes, $index = 0 ) {
    $post_id = $post->ID;
    $source  = isset( $attributes['source'] ) ? sanitize_key( $attributes['source'] ) : 'post';
    $post_type = get_post_type( $post_id );
    $index   = absint( $index );

    $show_image      = ! empty( $attributes['showImage'] );
    $show_title      = ! empty( $attributes['showTitle'] );
    $show_description = ! empty( $attributes['showDescription'] );
    $show_category   = ! empty( $attributes['showCategory'] );
    $show_cta        = ! empty( $attributes['showCta'] );
    $show_badge      = ! empty( $attributes['showBadge'] );
    $show_eyebrow    = ! empty( $attributes['showEyebrow'] );
    $show_metadata   = ! empty( $attributes['showMetadata'] );
    $show_price      = ! empty( $attributes['showPrice'] );
    $show_icon       = ! empty( $attributes['showIcon'] );
    $link_label      = isset( $attributes['linkLabel'] ) ? sanitize_text_field( $attributes['linkLabel'] ) : '';
    $heading_tag     = isset( $attributes['headingTag'] ) && in_array( $attributes['headingTag'], array( 'h1','h2','h3','h4','h5','h6' ), true )
        ? $attributes['headingTag'] : 'h3';

    $delay = isset( $attributes['animDelay'] ) ? absint( $attributes['animDelay'] ) : 0;
    $delay += ( $index % 3 ) * 80;

    $card_classes = 'pk-dynamic-card pk-animate-on-scroll';
    if ( $post_type === 'paksa_product' ) {
        $card_classes .= ' is-style-paksa-card-product';
    } elseif ( $post_type === 'paksa_service' ) {
        $card_classes .= ' is-style-paksa-card-service';
    } else {
        $card_classes .= ' is-style-paksa-card-blog';
    }
    if ( $source === 'paksa_product' || $post_type === 'paksa_product' ) {
        $is_featured = get_post_meta( $post_id, '_paksa_prod_featured', true ) === '1';
        if ( $is_featured ) {
            $card_classes .= ' pk-product-card--featured';
        }
    }
    $animation = isset( $attributes['animation'] ) ? sanitize_key( $attributes['animation'] ) : 'none';
    $allowed_anims = array( 'none','fade','fade-up','fade-down','fade-left','fade-right','scale','reveal','stagger' );
    if ( in_array( $animation, $allowed_anims, true ) && $animation !== 'none' ) {
        $card_classes .= ' is-style-paksa-motion-' . $animation;
    }

    if ( function_exists( 'paksa_build_hover_classes' ) ) {
        $hover = paksa_build_hover_classes( $attributes );
        if ( $hover ) {
            $card_classes .= ' ' . $hover;
        }
    }

    $permalink = get_permalink( $post_id );
    $title     = get_the_title( $post_id );
    $badge     = '';
    $cat_label = '';

    if ( $post_type === 'paksa_product' ) {
        if ( $show_badge ) {
            $badge = paksa_prod_meta( 'badge', '', $post_id );
        }
        if ( $show_category ) {
            $cat_label = paksa_prod_meta( 'category_label', '', $post_id );
        }
    } elseif ( $post_type === 'paksa_service' ) {
        if ( $show_badge ) {
            $badge = function_exists( 'paksa_svc_meta' ) ? paksa_svc_meta( 'badge', '', $post_id ) : '';
        }
        if ( $show_category ) {
            $cat_label = function_exists( 'paksa_svc_meta' ) ? paksa_svc_meta( 'category_label', '', $post_id ) : '';
        }
    }

    if ( ! $cat_label ) {
        $tax = paksa_get_taxonomy_for_source( $post_type );
        if ( $tax ) {
            $terms = get_the_terms( $post_id, $tax[0] );
            if ( $terms && ! is_wp_error( $terms ) ) {
                $cat_label = $terms[0]->name;
            }
        }
    }

    $description = '';
    if ( $show_description ) {
        if ( $post_type === 'paksa_product' ) {
            $tagline = paksa_prod_meta( 'tagline', '', $post_id );
            $description = $tagline ?: ( has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : '' );
        } elseif ( $post_type === 'paksa_service' ) {
            $tagline = function_exists( 'paksa_svc_meta' ) ? paksa_svc_meta( 'tagline', '', $post_id ) : '';
            $description = $tagline ?: ( has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : '' );
        } else {
            $description = has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : wp_trim_words( $post->post_content, 24 );
        }
    }

    $default_label = '';
    if ( $post_type === 'paksa_product' ) {
        $default_label = __( 'Explore Product', 'paksa-it-solutions' );
    } elseif ( $post_type === 'paksa_service' ) {
        $default_label = __( 'Learn More', 'paksa-it-solutions' );
    } else {
        $default_label = __( 'Read more', 'paksa-it-solutions' );
    }
    if ( ! $link_label ) {
        $link_label = $default_label;
    }

    ob_start();
    ?>
    <article class="<?php echo esc_attr( $card_classes ); ?>" data-anim="<?php echo $animation !== 'none' ? esc_attr( $animation ) : 'fade-up'; ?>" data-delay="<?php echo esc_attr( $delay ); ?>" role="listitem">
        <?php if ( $show_image && has_post_thumbnail( $post_id ) ) : ?>
            <div class="pk-dynamic-card__image">
                <?php echo get_the_post_thumbnail( $post_id, 'paksa-medium', array( 'class' => 'pk-product-thumb', 'loading' => 'lazy', 'alt' => '' ) ); ?>
                <?php if ( $show_badge && $badge ) : ?>
                    <span class="pk-prod-badge"><?php echo esc_html( $badge ); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="pk-dynamic-card__body">
            <?php if ( $show_eyebrow && $cat_label ) : ?>
                <span class="pk-product-category"><?php echo esc_html( $cat_label ); ?></span>
            <?php endif; ?>

            <?php if ( $show_title ) : ?>
                <<?php echo $heading_tag; ?> class="pk-dynamic-card__title">
                    <a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
                </<?php echo $heading_tag; ?>>
            <?php endif; ?>

            <?php if ( $show_description && $description ) : ?>
                <p class="pk-dynamic-card__desc"><?php echo esc_html( $description ); ?></p>
            <?php endif; ?>

            <?php if ( $show_metadata ) : ?>
                <span class="pk-component-meta"><?php echo esc_html( get_the_date( '', $post_id ) ); ?></span>
            <?php endif; ?>

            <?php if ( $show_cta ) : ?>
                <a href="<?php echo esc_url( $permalink ); ?>" class="pk-product-link">
                    <?php echo esc_html( $link_label ); ?>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="3" y1="8" x2="13" y2="8"></line>
                        <polyline points="9,4 13,8 9,12"></polyline>
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </article>
    <?php
    return trim( ob_get_clean() );
}

/**
 * Render paksa/dynamic-grid — a server-rendered dynamic content grid.
 *
 * @param array $attributes Block attributes.
 * @param string $content    InnerBlocks content.
 * @param WP_Block|null $block Current block instance.
 * @return string
 */
function paksa_render_dynamic_grid_block( $attributes, $content = '', $block = null ) {
    $items = paksa_get_dynamic_grid_items( $attributes );

    $source     = isset( $attributes['source'] ) ? sanitize_key( $attributes['source'] ) : '';
    $mode       = isset( $attributes['mode'] ) ? sanitize_key( $attributes['mode'] ) : 'dynamic';
    $layout     = isset( $attributes['layout'] ) ? sanitize_key( $attributes['layout'] ) : 'grid';
    $columns    = isset( $attributes['columns'] ) ? max( 1, min( 4, absint( $attributes['columns'] ) ) ) : 3;
    $show_filter = ! empty( $attributes['showFilter'] );
    $enable_search = ! empty( $attributes['enableSearch'] );
    $heading    = isset( $attributes['heading'] ) ? sanitize_text_field( $attributes['heading'] ) : '';
    $eyebrow    = isset( $attributes['eyebrow'] ) ? sanitize_text_field( $attributes['eyebrow'] ) : '';
    $description = isset( $attributes['description'] ) ? sanitize_textarea_field( $attributes['description'] ) : '';
    $show_read_more = ! empty( $attributes['showReadMore'] );
    $read_more_label = isset( $attributes['readMoreLabel'] ) ? sanitize_text_field( $attributes['readMoreLabel'] ) : __( 'View all', 'paksa-it-solutions' );
    $read_more_url = isset( $attributes['readMoreUrl'] ) ? esc_url( $attributes['readMoreUrl'] ) : '';
    $read_more_new_tab = ! empty( $attributes['readMoreNewTab'] );

    $source_label = paksa_get_source_label( $source );

    if ( empty( $items ) ) {
        return paksa_render_dynamic_empty_state( $attributes, $source_label );
    }

    $classes = array( 'pk-dynamic-grid' );
    if ( $layout !== 'grid' ) {
        $classes[] = 'pk-dynamic-grid--layout-' . $layout;
    }
    $classes[] = 'pk-dynamic-grid--columns-' . $columns;

    $motion = paksa_phase34_motion_classes( $attributes );
    if ( $motion ) {
        $classes[] = $motion;
    }
    if ( function_exists( 'paksa_build_hover_classes' ) ) {
        $hover = paksa_build_hover_classes( $attributes );
        if ( $hover ) {
            $classes[] = $hover;
        }
    }

    $wrapper_attrs = array(
        'class' => implode( ' ', array_filter( $classes )),
        'data-source' => $source,
        'data-mode' => $mode,
    );

    $wrapper = function_exists( 'get_block_wrapper_attributes' )
        ? get_block_wrapper_attributes( $wrapper_attrs )
        : 'class="wp-block-paksa-dynamic-grid ' . esc_attr( $wrapper_attrs['class'] ) . '"';

    $filter_html = '';
    if ( $show_filter ) {
        $filter_html = paksa_render_dynamic_filter( $source );
    }

    $search_html = '';
    if ( $enable_search ) {
        $search_html = '<div class="pk-dynamic-grid__search">'
            . '<input type="search" class="pk-dynamic-grid__search-input" placeholder="'
            . esc_attr__( 'Search...', 'paksa-it-solutions' ) . '" aria-label="'
            . esc_attr__( 'Search content', 'paksa-it-solutions' ) . '">'
            . '</div>';
    }

    $index = 0;
    $cards_html = '';
    foreach ( $items as $item ) {
        $cards_html .= paksa_render_dynamic_card( $item, $attributes, $index );
        $index++;
    }

    $read_more_html = '';
    if ( $show_read_more && $read_more_url ) {
        $target = $read_more_new_tab ? ' target="_blank" rel="noopener noreferrer"' : '';
        $read_more_html = '<div class="pk-dynamic-grid__read-more">'
            . '<a href="' . esc_url( $read_more_url ) . '"' . $target . ' class="pk-action pk-action--primary">'
            . esc_html( $read_more_label )
            . '</a></div>';
    }

    ob_start();
    ?>
    <div <?php echo $wrapper; ?>>
        <?php if ( $heading || $eyebrow || $description ) : ?>
            <div class="pk-dynamic-grid__header">
                <?php if ( $eyebrow ) : ?>
                    <span class="pk-component-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>
                <?php if ( $heading ) : ?>
                    <h2 class="pk-dynamic-grid__heading"><?php echo esc_html( $heading ); ?></h2>
                <?php endif; ?>
                <?php if ( $description ) : ?>
                    <p class="pk-dynamic-grid__description"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( $show_filter ) : ?>
            <?php echo $filter_html; ?>
        <?php endif; ?>

        <?php if ( $enable_search ) : ?>
            <?php echo $search_html; ?>
        <?php endif; ?>

        <div class="pk-dynamic-grid__items" role="list">
            <?php echo $cards_html; ?>
        </div>

        <?php if ( $read_more_html ) : ?>
            <?php echo $read_more_html; ?>
        <?php endif; ?>
    </div>
    <?php
    return trim( ob_get_clean() );
}

/**
 * Render paksa/dynamic-card — a single dynamic card.
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function paksa_render_dynamic_card_block( $attributes ) {
    $post_id = get_the_ID();
    if ( ! $post_id ) {
        return '<!-- dynamic-card: no post context -->';
    }

    $post = get_post( $post_id );
    if ( ! $post ) {
        return '<!-- dynamic-card: post not found -->';
    }

    $index = isset( $attributes['animDelay'] ) ? absint( $attributes['animDelay'] ) : 0;
    return paksa_render_dynamic_card( $post, $attributes, $index );
}

/**
 * Get a human-readable label for a content source.
 *
 * @param string $source Post type.
 * @return string
 */
function paksa_get_source_label( $source ) {
    switch ( $source ) {
        case 'post':
            return __( 'Posts', 'paksa-it-solutions' );
        case 'paksa_product':
            return __( 'Products', 'paksa-it-solutions' );
        case 'paksa_service':
            return __( 'Services', 'paksa-it-solutions' );
        case 'page':
            return __( 'Pages', 'paksa-it-solutions' );
        default:
            return __( 'Content', 'paksa-it-solutions' );
    }
}

/**
 * Render an empty state for a dynamic grid.
 *
 * @param array  $attributes Block attributes.
 * @param string $source_label Human-readable source label.
 * @return string
 */
function paksa_render_dynamic_empty_state( $attributes, $source_label = '' ) {
    $message = isset( $attributes['emptyMessage'] ) && $attributes['emptyMessage']
        ? sanitize_textarea_field( $attributes['emptyMessage'] )
        : sprintf(
            __( 'No matching %s found.', 'paksa-it-solutions' ),
            strtolower( $source_label )
        ) . ' ' . __( 'Adjust your query settings or add content.', 'paksa-it-solutions' );

    $wrapper_attrs = array(
        'class' => 'pk-dynamic-grid pk-dynamic-grid--empty',
        'data-empty' => 'true',
    );

    $wrapper = function_exists( 'get_block_wrapper_attributes' )
        ? get_block_wrapper_attributes( $wrapper_attrs )
        : 'class="wp-block-paksa-dynamic-grid pk-dynamic-grid pk-dynamic-grid--empty"';

    return '<div ' . $wrapper . '>'
        . '<p class="pk-dynamic-grid__empty-text">' . esc_html( $message ) . '</p>'
        . '</div>';
}

/**
 * Render a category filter toolbar for a dynamic grid.
 *
 * @param string $source Post type.
 * @return string
 */
function paksa_render_dynamic_filter( $source ) {
    $tax = paksa_get_taxonomy_for_source( $source );
    if ( ! $tax ) {
        return '';
    }

    $terms = get_terms( array(
        'taxonomy'   => $tax[0],
        'hide_empty' => true,
    ) );

    if ( is_wp_error( $terms ) || empty( $terms ) ) {
        return '';
    }

    $html = '<div class="pk-dynamic-grid__filter" role="toolbar" aria-label="'
        . esc_attr__( 'Filter content', 'paksa-it-solutions' ) . '">';
    $html .= '<button class="pk-filter-btn is-active" data-filter="all">'
        . esc_html__( 'All', 'paksa-it-solutions' ) . '</button>';

    foreach ( $terms as $term ) {
        $html .= '<button class="pk-filter-btn" data-filter="' . esc_attr( $term->slug ) . '">'
            . esc_html( $term->name ) . '</button>';
    }

    $html .= '</div>';
    return $html;
}
