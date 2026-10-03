<?php
/**
 * Paksa Theme — Phase 34 Advanced Visual Content Blocks.
 *
 * Enqueues editor-phase34.js and editor-phase34.css.
 *
 * Adds:
 *  - paksa/testimonial-rail   — server-rendered horizontal testimonial carousel
 *  - paksa/logo-strip        — server-rendered responsive logo grid
 *  - paksa/timeline          — server-rendered vertical/horizontal timeline
 *  - Advanced native block styles for buttons, groups, columns, media/text,
 *    separators, headings, quotes, lists, navigation
 *  - Additional pattern categories (matrix, faq-v2, testimonials-v2, team,
 *    process-v2, mega-menu, content-index)
 *  - Group style variations for dynamic content compositions
 *  - Editor inspector extensions via addFilter('editor.BlockEdit')
 *
 * All blocks are server-rendered where Phase 17/20 established SSR. InnerBlocks
 * is used for composable slide/item content. No new data stores. WordPress CPTs
 * and metadata contracts remain the source of truth.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue Phase 34 editor assets.
 */
function paksa_enqueue_phase34_editor_assets() {
    if ( ! wp_script_is( 'paksa-editor-phase33', 'enqueued' ) ) {
        return;
    }

    wp_enqueue_script(
        'paksa-editor-phase34',
        PAKSA_THEME_URI . '/assets/js/editor-phase34.js',
        array(
            'paksa-editor-phase33',
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
        ),
        PAKSA_THEME_VERSION,
        true
    );

    wp_enqueue_style(
        'paksa-editor-phase34',
        PAKSA_THEME_URI . '/assets/css/editor-phase34.css',
        array( 'paksa-editor-phase33' ),
        PAKSA_THEME_VERSION
    );

    $testimonial_variants = array(
        array( 'label' => 'Standard', 'value' => 'standard' ),
        array( 'label' => 'Compact',  'value' => 'compact' ),
        array( 'label' => 'Card',     'value' => 'card' ),
        array( 'label' => 'Quote',    'value' => 'quote' ),
    );

    $timeline_orientations = array(
        array( 'label' => 'Vertical', 'value' => 'vertical' ),
        array( 'label' => 'Horizontal', 'value' => 'horizontal' ),
    );

    $timeline_markers = array(
        array( 'label' => 'Dot',      'value' => 'dot' ),
        array( 'label' => 'Number',   'value' => 'number' ),
        array( 'label' => 'Icon',     'value' => 'icon' ),
        array( 'label' => 'Check',    'value' => 'check' ),
    );

    $logo_link_options = array(
        array( 'label' => 'None',      'value' => 'none' ),
        array( 'label' => 'Lightbox',  'value' => 'lightbox' ),
        array( 'label' => 'New tab',   'value' => 'newtab' ),
    );

    $layout_presets = array(
        array( 'label' => 'Grid',         'value' => 'grid' ),
        array( 'label' => 'Masonry',      'value' => 'masonry' ),
        array( 'label' => 'List',         'value' => 'list' ),
        array( 'label' => 'Featured + Grid', 'value' => 'featured' ),
        array( 'label' => 'Two Column',   'value' => 'two-column' ),
        array( 'label' => 'Three Column', 'value' => 'three-column' ),
        array( 'label' => 'Four Column',  'value' => 'four-column' ),
        array( 'label' => 'Sidebar + Content', 'value' => 'sidebar' ),
    );

    wp_localize_script( 'paksa-editor-phase34', 'paksaPhase34', array(
        'testimonialVariants' => $testimonial_variants,
        'timelineOrientations' => $timeline_orientations,
        'timelineMarkers'      => $timeline_markers,
        'logoLinkOptions'      => $logo_link_options,
        'layoutPresets'        => $layout_presets,
        'animationOptions'     => array(
            array( 'label' => 'None',           'value' => 'none' ),
            array( 'label' => 'Fade',           'value' => 'fade' ),
            array( 'label' => 'Fade Up',        'value' => 'fade-up' ),
            array( 'label' => 'Fade Down',      'value' => 'fade-down' ),
            array( 'label' => 'Fade Left',      'value' => 'fade-left' ),
            array( 'label' => 'Fade Right',     'value' => 'fade-right' ),
            array( 'label' => 'Scale',          'value' => 'scale' ),
            array( 'label' => 'Reveal',         'value' => 'reveal' ),
            array( 'label' => 'Stagger Children', 'value' => 'stagger' ),
        ),
        'version'              => PAKSA_THEME_VERSION,
        'nonce'                => wp_create_nonce( 'wp_rest' ),
    ) );
}
add_action( 'enqueue_block_editor_assets', 'paksa_enqueue_phase34_editor_assets', 34 );

/**
 * Enqueue Phase 34 frontend CSS.
 */
function paksa_enqueue_phase34_assets() {
    wp_enqueue_style(
        'paksa-phase34-blocks',
        PAKSA_THEME_URI . '/assets/css/editor-phase34.css',
        array( 'paksa-blocks' ),
        PAKSA_THEME_VERSION
    );
}
add_action( 'wp_enqueue_scripts', 'paksa_enqueue_phase34_assets', 34 );

/**
 * Register Phase 34 blocks, block styles, and pattern categories.
 */
function paksa_register_phase34_blocks() {
    if ( ! function_exists( 'register_block_type' ) ) {
        return;
    }

    /* ── paksa/testimonial-rail ─────────────────────────────────────────────── */
    register_block_type( 'paksa/testimonial-rail', array(
        'api_version'     => 3,
        'render_callback' => 'paksa_render_testimonial_rail_block',
        'attributes'      => array_merge(
            array(
                'variant'        => array( 'type' => 'string',  'default' => 'standard' ),
                'autoplay'       => array( 'type' => 'boolean', 'default' => false ),
                'showNavigation' => array( 'type' => 'boolean', 'default' => true ),
                'showDots'       => array( 'type' => 'boolean', 'default' => true ),
                'itemsToShow'    => array( 'type' => 'number',  'default' => 1 ),
                'animation'      => array( 'type' => 'string',  'default' => 'none' ),
                'animDelay'      => array( 'type' => 'number',  'default' => 0 ),
                'animDuration'   => array( 'type' => 'number',  'default' => 600 ),
                'containerWidth' => array( 'type' => 'string',  'default' => 'default' ),
                'layout'         => array( 'type' => 'string',  'default' => 'grid' ),
            ),
            paksa_hover_attributes(),
            paksa_border_shadow_attributes(),
            paksa_responsive_attributes()
        ),
        'supports'        => array(
            'align'   => array( 'wide', 'full' ),
            'anchor'  => true,
            'color'   => array( 'text' => true, 'background' => true ),
            'spacing' => array( 'padding' => true, 'margin' => true, 'blockGap' => true ),
        ),
    ) );

    /* ── paksa/logo-strip ──────────────────────────────────────────────────── */
    register_block_type( 'paksa/logo-strip', array(
        'api_version'     => 3,
        'render_callback' => 'paksa_render_logo_strip_block',
        'attributes'      => array_merge(
            array(
                'logoSize'      => array( 'type' => 'number',  'default' => 120 ),
                'gap'           => array( 'type' => 'string',  'default' => 'var(--wp--preset--spacing--50)' ),
                'grayscale'     => array( 'type' => 'boolean', 'default' => false ),
                'linkBehavior'  => array( 'type' => 'string',  'default' => 'none' ),
                'alignment'     => array( 'type' => 'string',  'default' => 'center' ),
                'columns'       => array( 'type' => 'number',  'default' => 5 ),
                'layout'        => array( 'type' => 'string',  'default' => 'grid' ),
            ),
            paksa_hover_attributes(),
            paksa_border_shadow_attributes(),
            paksa_responsive_attributes()
        ),
        'supports'        => array(
            'align'   => array( 'wide', 'full' ),
            'anchor'  => true,
            'color'   => array( 'text' => true, 'background' => true ),
            'spacing' => array( 'padding' => true, 'margin' => true, 'blockGap' => true ),
        ),
    ) );

    /* ── paksa/timeline ─────────────────────────────────────────────────────── */
    register_block_type( 'paksa/timeline', array(
        'api_version'     => 3,
        'render_callback' => 'paksa_render_timeline_block',
        'attributes'      => array_merge(
            array(
                'orientation'     => array( 'type' => 'string',  'default' => 'vertical' ),
                'alignment'       => array( 'type' => 'string',  'default' => 'left' ),
                'markerType'      => array( 'type' => 'string',  'default' => 'dot' ),
                'connectorStyle'  => array( 'type' => 'string',  'default' => 'solid' ),
                'contentSpacing'  => array( 'type' => 'string',  'default' => 'var(--wp--preset--spacing--50)' ),
                'layout'          => array( 'type' => 'string',  'default' => 'grid' ),
                'animation'       => array( 'type' => 'string',  'default' => 'none' ),
                'animDelay'       => array( 'type' => 'number',  'default' => 0 ),
            ),
            paksa_border_shadow_attributes(),
            paksa_typography_attributes()
        ),
        'supports'        => array(
            'align'   => array( 'wide', 'full' ),
            'anchor'  => true,
            'color'   => array( 'text' => true, 'background' => true ),
            'spacing' => array( 'padding' => true, 'margin' => true, 'blockGap' => true ),
        ),
    ) );

    /* ── Block styles for Phase 34 ────────────────────────────────────────── */
    if ( function_exists( 'register_block_style' ) ) {
        /* Style families — no duplicates with existing Phase 14/17/18/20 styles */
        /* Buttons */
        register_block_style( 'core/button', array(
            'name'  => 'paksa-button-cta',
            'label' => __( 'Paksa Call to Action', 'paksa-it-solutions' ),
        ) );

        /* Groups */
        register_block_style( 'core/group', array(
            'name'  => 'paksa-group-surfaces',
            'label' => __( 'Paksa Surface Container', 'paksa-it-solutions' ),
        ) );

        /* Columns */
        register_block_style( 'core/columns', array(
            'name'  => 'paksa-cols-masonry',
            'label' => __( 'Paksa Masonry Columns', 'paksa-it-solutions' ),
        ) );

        /* Media/Text */
        register_block_style( 'core/media-text', array(
            'name'  => 'paksa-media-stacked',
            'label' => __( 'Paksa Stacked Media', 'paksa-it-solutions' ),
        ) );

        /* Separators */
        register_block_style( 'core/separator', array(
            'name'  => 'paksa-divider-dotted',
            'label' => __( 'Paksa Dotted Divider', 'paksa-it-solutions' ),
        ) );

        /* Headings */
        register_block_style( 'core/heading', array(
            'name'  => 'paksa-heading-muted',
            'label' => __( 'Paksa Muted Heading', 'paksa-it-solutions' ),
        ) );

        /* Quotes */
        register_block_style( 'core/quote', array(
            'name'  => 'paksa-quote-bordered',
            'label' => __( 'Paksa Bordered Quote', 'paksa-it-solutions' ),
        ) );

        /* Lists */
        register_block_style( 'core/list', array(
            'name'  => 'paksa-list-check',
            'label' => __( 'Paksa Check List', 'paksa-it-solutions' ),
        ) );

        /* Navigation */
        register_block_style( 'core/navigation', array(
            'name'  => 'paksa-nav-collapsible',
            'label' => __( 'Paksa Collapsible Nav', 'paksa-it-solutions' ),
        ) );

        /* Timeline-specific styles */
        register_block_style( 'paksa/timeline', array(
            'name'  => 'paksa-timeline-compact',
            'label' => __( 'Timeline — Compact', 'paksa-it-solutions' ),
        ) );

        /* Logo strip specific styles */
        register_block_style( 'paksa/logo-strip', array(
            'name'  => 'paksa-logo-marquee',
            'label' => __( 'Logo Strip — Marquee', 'paksa-it-solutions' ),
        ) );

        /* Testimonial rail specific styles */
        register_block_style( 'paksa/testimonial-rail', array(
            'name'  => 'paksa-rail-dots-below',
            'label' => __( 'Testimonial Rail — Dots Below', 'paksa-it-solutions' ),
        ) );
    }
}
add_action( 'init', 'paksa_register_phase34_blocks', 16 );

/* ── Pattern categories ───────────────────────────────────────────────────── */
function paksa_register_phase34_pattern_categories() {
    if ( ! function_exists( 'register_block_pattern_category' ) ) {
        return;
    }

    $categories = array(
        'paksa-mega-menu'     => __( 'Paksa Mega Menu', 'paksa-it-solutions' ),
        'paksa-matrix'        => __( 'Paksa Matrix / Comparison', 'paksa-it-solutions' ),
        'paksa-faq-advanced'  => __( 'Paksa FAQ', 'paksa-it-solutions' ),
        'paksa-testimonials-v2' => __( 'Paksa Testimonials', 'paksa-it-solutions' ),
        'paksa-team-v2'       => __( 'Paksa Team', 'paksa-it-solutions' ),
        'paksa-process-v2'    => __( 'Paksa Process', 'paksa-it-solutions' ),
        'paksa-content-index' => __( 'Paksa Content Index', 'paksa-it-solutions' ),
        'paksa-case-studies'  => __( 'Paksa Case Studies', 'paksa-it-solutions' ),
        'paksa-pricing-v2'    => __( 'Paksa Pricing', 'paksa-it-solutions' ),
    );

    foreach ( $categories as $slug => $label ) {
        register_block_pattern_category( $slug, array( 'label' => $label ) );
    }
}
add_action( 'init', 'paksa_register_phase34_pattern_categories', 9 );

/* ── Frontend render callbacks ────────────────────────────────────────────── */

/**
 * Resolve the allowed animation classes for motion attributes.
 */
function paksa_phase34_allowed_anims() {
    return array(
        'none', 'fade', 'fade-up', 'fade-down', 'fade-left',
        'fade-right', 'scale', 'reveal', 'stagger',
    );
}

/**
 * Build the animation class string from block attributes.
 *
 * @param array $attributes Block attributes.
 * @return string Space-separated class string.
 */
function paksa_phase34_motion_classes( $attributes ) {
    $animation = isset( $attributes['animation'] ) ? sanitize_key( $attributes['animation'] ) : 'none';
    $allowed   = paksa_phase34_allowed_anims();
    if ( ! in_array( $animation, $allowed, true ) ) {
        $animation = 'none';
    }
    if ( $animation === 'none' ) {
        return '';
    }

    $classes = 'is-style-paksa-motion-' . $animation;
    $delay = isset( $attributes['animDelay'] ) ? absint( $attributes['animDelay'] ) : 0;
    if ( $delay > 0 ) {
        $classes .= ' pk-motion-delay-' . $delay;
    }

    return $classes;
}

/**
 * Build data attributes for animation timing.
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function paksa_phase34_motion_data_attrs( $attributes ) {
    $output = '';
    $animation = isset( $attributes['animation'] ) ? sanitize_key( $attributes['animation'] ) : 'none';
    $delay = isset( $attributes['animDelay'] ) ? absint( $attributes['animDelay'] ) : 0;
    $duration = isset( $attributes['animDuration'] ) ? absint( $attributes['animDuration'] ) : 600;

    if ( $animation !== 'none' ) {
        if ( $delay > 0 ) {
            $output .= ' data-delay="' . $delay . '"';
        }
        if ( $duration !== 600 ) {
            $output .= ' data-duration="' . $duration . '"';
        }
    }

    return $output;
}

/**
 * Render paksa/testimonial-rail — a server-rendered horizontal rail.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    InnerBlocks content (testimonial slides).
 * @return string
 */
function paksa_render_testimonial_rail_block( $attributes, $content ) {
    $variant    = isset( $attributes['variant'] ) ? sanitize_key( $attributes['variant'] ) : 'standard';
    $autoplay   = ! empty( $attributes['autoplay'] );
    $nav        = ! empty( $attributes['showNavigation'] );
    $dots       = ! empty( $attributes['showDots'] );
    $items      = isset( $attributes['itemsToShow'] ) ? max( 1, min( 5, absint( $attributes['itemsToShow'] ) ) ) : 1;
    $layout     = isset( $attributes['layout'] ) ? sanitize_key( $attributes['layout'] ) : 'grid';

    $allowed_variants = array( 'standard', 'compact', 'card', 'quote' );
    $variant = in_array( $variant, $allowed_variants, true ) ? $variant : 'standard';

    $classes = array( 'pk-testimonial-rail', 'pk-testimonial-rail--' . $variant );
    if ( $autoplay ) {
        $classes[] = 'is-autoplay';
    }
    if ( $items > 1 ) {
        $classes[] = 'pk-rail-items-' . $items;
    }

    $motion = paksa_phase34_motion_classes( $attributes );
    if ( $motion ) {
        $classes[] = $motion;
    }
    $hover = function_exists( 'paksa_build_hover_classes' )
        ? paksa_build_hover_classes( $attributes ) : '';
    if ( $hover ) {
        $classes[] = $hover;
    }

    $wrapper_attrs = array( 'class' => implode( ' ', array_filter( $classes )) );
    $data_attrs = paksa_phase34_motion_data_attrs( $attributes );
    if ( $data_attrs ) {
        $wrapper_attrs[' data-motion' ] = 'true';
    }

    $wrapper = function_exists( 'get_block_wrapper_attributes' )
        ? get_block_wrapper_attributes( $wrapper_attrs )
        : 'class="wp-block-paksa-testimonial-rail ' . esc_attr( $wrapper_attrs['class'] ) . '"';

    $nav_html = '';
    if ( $nav ) {
        $nav_html = '<button class="pk-rail-nav pk-rail-nav--prev" aria-label="'
            . esc_attr__( 'Previous testimonial', 'paksa-it-solutions' ) . '" aria-controls="pk-rail-' . esc_attr( uniqid() ) . '">'
            . paksa_icon( 'arrow-left', 20 ) . '</button>';
    }

    $dots_html = '';
    if ( $dots ) {
        $dots_html = '<div class="pk-rail-dots" role="tablist" aria-label="'
            . esc_attr__( 'Testimonial navigation', 'paksa-it-solutions' ) . '"></div>';
    }

    return '<div ' . $wrapper . '>' . $nav_html . $content . $dots_html
        . ( $nav ? '<button class="pk-rail-nav pk-rail-nav--next" aria-label="'
            . esc_attr__( 'Next testimonial', 'paksa-it-solutions' ) . '">'
            . paksa_icon( 'arrow-right', 20 ) . '</button>' : '' )
        . '</div>';
}

/**
 * Render paksa/logo-strip — a server-rendered responsive logo grid.
 *
 * @param array  $attributes Block attributes.
 * @param string $content    InnerBlocks content (logo items).
 * @return string
 */
function paksa_render_logo_strip_block( $attributes, $content ) {
    $size       = isset( $attributes['logoSize'] ) ? max( 40, min( 320, absint( $attributes['logoSize'] ) ) ) : 120;
    $gap        = isset( $attributes['gap'] ) ? sanitize_text_field( $attributes['gap'] ) : 'var(--wp--preset--spacing--50)';
    $grayscale  = ! empty( $attributes['grayscale'] );
    $link       = isset( $attributes['linkBehavior'] ) ? sanitize_key( $attributes['linkBehavior'] ) : 'none';
    $alignment  = isset( $attributes['alignment'] ) ? sanitize_key( $attributes['alignment'] ) : 'center';
    $cols       = isset( $attributes['columns'] ) ? max( 2, min( 8, absint( $attributes['columns'] ) ) ) : 5;

    $classes = array( 'pk-logo-strip', 'pk-logo-strip--align-' . $alignment );
    if ( $grayscale ) {
        $classes[] = 'is-grayscale';
    }
    if ( $link !== 'none' ) {
        $classes[] = 'pk-logo-strip--link-' . $link;
    }

    $wrapper_attrs = array( 'class' => implode( ' ', array_filter( $classes )) );

    $wrapper = function_exists( 'get_block_wrapper_attributes' )
        ? get_block_wrapper_attributes( $wrapper_attrs )
        : 'class="wp-block-paksa-logo-strip ' . esc_attr( $wrapper_attrs['class'] ) . '"';

    $style_parts = array(
        '--pk-logo-size:' . $size . 'px',
        '--pk-logo-gap:' . $gap,
        '--pk-logo-cols:' . $cols,
    );
    $wrapper_attrs['style'] = isset( $wrapper_attrs['style'] )
        ? $wrapper_attrs['style'] . ';' . implode( ';', $style_parts )
        : implode( ';', $style_parts );

    $wrapper = function_exists( 'get_block_wrapper_attributes' )
        ? get_block_wrapper_attributes( $wrapper_attrs )
        : 'class="wp-block-paksa-logo-strip ' . esc_attr( $wrapper_attrs['class'] ) . '" style="' . esc_attr( $wrapper_attrs['style'] ) . '"';

    return '<div ' . $wrapper . '>' . $content . '</div>';
}

/**
 * Render paksa/timeline — a server-rendered vertical or horizontal timeline.
 *
 * @param array  $attributes Block attributes.
 * @param string $content    InnerBlocks content (timeline items).
 * @return string
 */
function paksa_render_timeline_block( $attributes, $content ) {
    $orientation = isset( $attributes['orientation'] ) ? sanitize_key( $attributes['orientation'] ) : 'vertical';
    $alignment   = isset( $attributes['alignment'] ) ? sanitize_key( $attributes['alignment'] ) : 'left';
    $marker      = isset( $attributes['markerType'] ) ? sanitize_key( $attributes['markerType'] ) : 'dot';
    $connector   = isset( $attributes['connectorStyle'] ) ? sanitize_key( $attributes['connectorStyle'] ) : 'solid';
    $spacing     = isset( $attributes['contentSpacing'] ) ? sanitize_text_field( $attributes['contentSpacing'] ) : 'var(--wp--preset--spacing--50)';

    $allowed_ors = array( 'vertical', 'horizontal' );
    $orientation = in_array( $orientation, $allowed_ors, true ) ? $orientation : 'vertical';

    $allowed_markers = array( 'dot', 'number', 'icon', 'check' );
    $marker = in_array( $marker, $allowed_markers, true ) ? $marker : 'dot';

    $allowed_connectors = array( 'solid', 'dashed', 'dotted', 'double' );
    $connector = in_array( $connector, $allowed_connectors, true ) ? $connector : 'solid';

    $classes = array(
        'pk-timeline',
        'pk-timeline--orientation-' . $orientation,
        'pk-timeline--marker-' . $marker,
        'pk-timeline--connector-' . $connector,
        'pk-timeline--align-' . $alignment,
    );

    $motion = paksa_phase34_motion_classes( $attributes );
    if ( $motion ) {
        $classes[] = $motion;
    }

    $wrapper_attrs = array( 'class' => implode( ' ', array_filter( $classes )) );
    $wrapper_attrs['style'] = '--pk-timeline-spacing:' . $spacing;

    $wrapper = function_exists( 'get_block_wrapper_attributes' )
        ? get_block_wrapper_attributes( $wrapper_attrs )
        : 'class="wp-block-paksa-timeline ' . esc_attr( $wrapper_attrs['class'] ) . '"';

    return '<div ' . $wrapper . '>' . $content . '</div>';
}
