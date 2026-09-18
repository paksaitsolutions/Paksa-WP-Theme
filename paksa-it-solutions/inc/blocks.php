<?php
/**
 * Paksa Theme — Phase 17 advanced blocks.
 *
 * Registers three new dynamic blocks that extend the existing visual system:
 *   paksa/section    — full-width section container with InnerBlocks and real
 *                      background / spacing / animation controls.
 *   paksa/testimonial — server-rendered testimonial card with quote, author,
 *                       role, rating, and optional avatar.
 *   paksa/cta         — server-rendered CTA with heading, description, variant,
 *                       layout, and InnerBlocks for the button group.
 *
 * All three consume the existing --pk-* token system and share the component
 * CSS already loaded by enqueue.php. No new token system is introduced.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register the Phase 17/18 blocks.
 */
function paksa_register_phase17_blocks() {
    if ( ! function_exists( 'register_block_type' ) ) {
        return;
    }

    /* ── paksa/section ──────────────────────────────────────────────────── */
    register_block_type( 'paksa/section', array(
        'api_version'     => 3,
        'render_callback' => 'paksa_render_section_block',
        'attributes'      => array_merge(
            array(
                'variant'        => array( 'type' => 'string',  'default' => 'default' ),
                'minHeight'      => array( 'type' => 'string',  'default' => '' ),
                'paddingTop'     => array( 'type' => 'string',  'default' => '' ),
                'paddingBot'     => array( 'type' => 'string',  'default' => '' ),
                'bgColor'        => array( 'type' => 'string',  'default' => '' ),
                'bgGradient'     => array( 'type' => 'string',  'default' => '' ),
                'overlayOpacity' => array( 'type' => 'number',  'default' => 0 ),
                'animation'      => array( 'type' => 'string',  'default' => 'none' ),
                'animDelay'      => array( 'type' => 'number',  'default' => 0 ),
                'animDuration'   => array( 'type' => 'number',  'default' => 600 ),
                'containerWidth' => array( 'type' => 'string',  'default' => 'default' ),
                'textAlign'      => array( 'type' => 'string',  'default' => 'left' ),
                'verticalAlign'  => array( 'type' => 'string',  'default' => 'top' ),
                'customId'       => array( 'type' => 'string',  'default' => '' ),
            ),
            paksa_bg_image_attributes(),
            paksa_hover_attributes(),
            paksa_border_shadow_attributes()
        ),
        'supports'        => array(
            'align'   => array( 'wide', 'full' ),
            'anchor'  => true,
            'color'   => array( 'text' => true, 'background' => true, 'gradients' => true ),
            'spacing' => array( 'padding' => true, 'margin' => true, 'blockGap' => true ),
            'dimensions' => array( 'minHeight' => true ),
            'typography' => array( 'fontSize' => true, 'lineHeight' => true ),
        ),
    ) );

    /* ── paksa/testimonial ──────────────────────────────────────────────── */
    register_block_type( 'paksa/testimonial', array(
        'api_version'     => 3,
        'render_callback' => 'paksa_render_testimonial_block',
        'attributes'      => array_merge(
            array(
                'quote'       => array( 'type' => 'string',  'default' => '' ),
                'author'      => array( 'type' => 'string',  'default' => '' ),
                'role'        => array( 'type' => 'string',  'default' => '' ),
                'company'     => array( 'type' => 'string',  'default' => '' ),
                'rating'      => array( 'type' => 'number',  'default' => 5 ),
                'showRating'  => array( 'type' => 'boolean', 'default' => false ),
                'avatarUrl'   => array( 'type' => 'string',  'default' => '' ),
                'avatarAlt'   => array( 'type' => 'string',  'default' => '' ),
                'variant'     => array( 'type' => 'string',  'default' => 'default' ),
                'accentColor' => array( 'type' => 'string',  'default' => '' ),
                'quoteSize'   => array( 'type' => 'string',  'default' => 'normal' ),
            ),
            paksa_hover_attributes(),
            paksa_border_shadow_attributes()
        ),
        'supports'        => array(
            'align'   => array( 'left', 'center', 'right' ),
            'color'   => array( 'text' => true, 'background' => true ),
            'spacing' => array( 'margin' => true, 'padding' => true ),
        ),
    ) );

    /* ── paksa/cta ──────────────────────────────────────────────────────── */
    register_block_type( 'paksa/cta', array(
        'api_version'     => 3,
        'render_callback' => 'paksa_render_cta_block',
        'attributes'      => array_merge(
            array(
                'eyebrow'         => array( 'type' => 'string',  'default' => '' ),
                'heading'         => array( 'type' => 'string',  'default' => '' ),
                'description'     => array( 'type' => 'string',  'default' => '' ),
                'variant'         => array( 'type' => 'string',  'default' => 'dark' ),
                'layout'          => array( 'type' => 'string',  'default' => 'centered' ),
                'primaryLabel'    => array( 'type' => 'string',  'default' => '' ),
                'primaryUrl'      => array( 'type' => 'string',  'default' => '' ),
                'primaryNewTab'   => array( 'type' => 'boolean', 'default' => false ),
                'secondaryLabel'  => array( 'type' => 'string',  'default' => '' ),
                'secondaryUrl'    => array( 'type' => 'string',  'default' => '' ),
                'secondaryNewTab' => array( 'type' => 'boolean', 'default' => false ),
                'primaryIcon'     => array( 'type' => 'string',  'default' => '' ),
                'secondaryIcon'   => array( 'type' => 'string',  'default' => '' ),
                'animation'       => array( 'type' => 'string',  'default' => 'none' ),
                'animDelay'       => array( 'type' => 'number',  'default' => 0 ),
            ),
            paksa_bg_image_attributes(),
            paksa_border_shadow_attributes()
        ),
        'supports'        => array(
            'align'   => array( 'wide', 'full' ),
            'anchor'  => true,
            'color'   => array( 'text' => true, 'background' => true ),
            'spacing' => array( 'padding' => true, 'margin' => true ),
        ),
    ) );

    /* ── Additional block styles for Phase 17 ───────────────────────────── */
    if ( function_exists( 'register_block_style' ) ) {
        // Testimonial card variants
        register_block_style( 'paksa/testimonial', array(
            'name'  => 'bordered',
            'label' => __( 'Bordered', 'paksa-it-solutions' ),
        ) );
        register_block_style( 'paksa/testimonial', array(
            'name'  => 'dark',
            'label' => __( 'Dark', 'paksa-it-solutions' ),
        ) );

        // Section background variants
        register_block_style( 'paksa/section', array(
            'name'  => 'alt',
            'label' => __( 'Alt Background', 'paksa-it-solutions' ),
        ) );
        register_block_style( 'paksa/section', array(
            'name'  => 'dark',
            'label' => __( 'Dark Background', 'paksa-it-solutions' ),
        ) );
        register_block_style( 'paksa/section', array(
            'name'  => 'gradient',
            'label' => __( 'Gradient Background', 'paksa-it-solutions' ),
        ) );

        // Additional block variations for core/columns grid layouts
        register_block_style( 'core/columns', array(
            'name'  => 'paksa-grid-2',
            'label' => __( 'Paksa 2-Column Grid', 'paksa-it-solutions' ),
        ) );
        register_block_style( 'core/columns', array(
            'name'  => 'paksa-grid-3',
            'label' => __( 'Paksa 3-Column Grid', 'paksa-it-solutions' ),
        ) );
        register_block_style( 'core/columns', array(
            'name'  => 'paksa-grid-4',
            'label' => __( 'Paksa 4-Column Grid', 'paksa-it-solutions' ),
        ) );
        register_block_style( 'core/columns', array(
            'name'  => 'paksa-sidebar-left',
            'label' => __( 'Paksa Sidebar Left', 'paksa-it-solutions' ),
        ) );
        register_block_style( 'core/columns', array(
            'name'  => 'paksa-sidebar-right',
            'label' => __( 'Paksa Sidebar Right', 'paksa-it-solutions' ),
        ) );

        // Heading styles
        register_block_style( 'core/heading', array(
            'name'  => 'paksa-display',
            'label' => __( 'Paksa Display', 'paksa-it-solutions' ),
        ) );
        register_block_style( 'core/heading', array(
            'name'  => 'paksa-eyebrow',
            'label' => __( 'Paksa Eyebrow', 'paksa-it-solutions' ),
        ) );

        // Paragraph styles
        register_block_style( 'core/paragraph', array(
            'name'  => 'paksa-lead',
            'label' => __( 'Paksa Lead', 'paksa-it-solutions' ),
        ) );
        register_block_style( 'core/paragraph', array(
            'name'  => 'paksa-muted',
            'label' => __( 'Paksa Muted', 'paksa-it-solutions' ),
        ) );

        // Quote styles
        register_block_style( 'core/quote', array(
            'name'  => 'paksa-testimonial',
            'label' => __( 'Paksa Testimonial', 'paksa-it-solutions' ),
        ) );
        register_block_style( 'core/quote', array(
            'name'  => 'paksa-highlight',
            'label' => __( 'Paksa Highlight', 'paksa-it-solutions' ),
        ) );
    }
}
add_action( 'init', 'paksa_register_phase17_blocks', 14 );

/**
 * Render paksa/section — a full-width section container with InnerBlocks.
 *
 * The block uses native block supports (color, spacing, dimensions) for most
 * visual controls. The custom attributes add variant class, animation, and
 * container-width modifiers that the native supports cannot express.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    InnerBlocks rendered content.
 * @return string
 */
function paksa_render_section_block( $attributes, $content ) {
    $variant    = isset( $attributes['variant'] ) ? sanitize_key( $attributes['variant'] ) : 'default';
    $animation  = isset( $attributes['animation'] ) ? sanitize_key( $attributes['animation'] ) : 'none';
    $delay      = isset( $attributes['animDelay'] ) ? absint( $attributes['animDelay'] ) : 0;
    $duration   = isset( $attributes['animDuration'] ) ? absint( $attributes['animDuration'] ) : 600;
    $container  = isset( $attributes['containerWidth'] ) ? sanitize_key( $attributes['containerWidth'] ) : 'default';
    $text_align = isset( $attributes['textAlign'] ) ? sanitize_key( $attributes['textAlign'] ) : 'left';
    $v_align    = isset( $attributes['verticalAlign'] ) ? sanitize_key( $attributes['verticalAlign'] ) : 'top';
    $custom_id  = isset( $attributes['customId'] ) ? sanitize_html_class( $attributes['customId'] ) : '';

    $allowed_variants   = array( 'default', 'alt', 'dark', 'gradient', 'transparent' );
    $allowed_anims      = array( 'none', 'fade', 'fade-up', 'fade-down', 'fade-left', 'fade-right', 'scale', 'reveal', 'stagger' );
    $allowed_containers = array( 'default', 'narrow', 'wide', 'full' );
    $allowed_valigns    = array( 'top', 'center', 'bottom' );

    $variant    = in_array( $variant, $allowed_variants, true ) ? $variant : 'default';
    $animation  = in_array( $animation, $allowed_anims, true ) ? $animation : 'none';
    $container  = in_array( $container, $allowed_containers, true ) ? $container : 'default';
    $v_align    = in_array( $v_align, $allowed_valigns, true ) ? $v_align : 'top';

    $classes = array( 'pk-section' );
    if ( $variant !== 'default' ) {
        $classes[] = 'pk-section--' . $variant;
    }
    if ( $container !== 'default' ) {
        $classes[] = 'pk-section--container-' . $container;
    }
    if ( $text_align !== 'left' ) {
        $classes[] = 'has-text-align-' . $text_align;
    }
    if ( $v_align !== 'top' ) {
        $classes[] = 'pk-section--valign-' . $v_align;
    }
    if ( $animation !== 'none' ) {
        $classes[] = 'is-style-paksa-motion-' . $animation;
        if ( $delay > 0 ) {
            $classes[] = 'pk-motion-delay-' . $delay;
        }
    }
    // Hover classes from Phase 18 shared helper
    $hover_classes = function_exists( 'paksa_build_hover_classes' ) ? paksa_build_hover_classes( $attributes ) : '';
    if ( $hover_classes ) {
        $classes = array_merge( $classes, explode( ' ', $hover_classes ) );
    }
    if ( $custom_id ) {
        $classes[] = $custom_id;
    }

    $wrapper_attrs = array( 'class' => implode( ' ', array_filter( $classes ) ) );
    if ( $delay > 0 && $animation !== 'none' ) {
        $wrapper_attrs['data-delay'] = (string) $delay;
    }
    if ( $duration !== 600 && $animation !== 'none' ) {
        $wrapper_attrs['data-duration'] = (string) $duration;
    }

    // Inline styles: bg image + border/shadow
    $inline_styles = array();
    if ( function_exists( 'paksa_build_bg_image_style' ) ) {
        $bg_style = paksa_build_bg_image_style( $attributes );
        if ( $bg_style ) {
            $inline_styles[] = $bg_style;
        }
    }
    if ( function_exists( 'paksa_build_border_shadow_style' ) ) {
        $bs_style = paksa_build_border_shadow_style( $attributes );
        if ( $bs_style ) {
            $inline_styles[] = $bs_style;
        }
    }
    if ( $inline_styles ) {
        $wrapper_attrs['style'] = implode( ';', $inline_styles );
    }

    // Background overlay for bg image
    $overlay_html = '';
    if ( ! empty( $attributes['bgImageUrl'] ) && isset( $attributes['bgOverlayOpacity'] ) && $attributes['bgOverlayOpacity'] > 0 ) {
        $opacity = min( 100, max( 0, absint( $attributes['bgOverlayOpacity'] ) ) );
        $overlay_color = isset( $attributes['bgOverlayColor'] ) && $attributes['bgOverlayColor'] ? esc_attr( $attributes['bgOverlayColor'] ) : '#000000';
        $overlay_html = '<span class="pk-section__overlay" aria-hidden="true" style="background:' . $overlay_color . ';opacity:' . ( $opacity / 100 ) . '"></span>';
    }

    $wrapper = function_exists( 'get_block_wrapper_attributes' )
        ? get_block_wrapper_attributes( $wrapper_attrs )
        : 'class="wp-block-paksa-section ' . esc_attr( implode( ' ', $classes ) ) . '"';

    return '<section ' . $wrapper . '>' . $overlay_html . $content . '</section>';
}

/**
 * Render paksa/testimonial — an accessible testimonial card.
 *
 * @param array $attributes Block attributes.
 * @return string
 */
function paksa_render_testimonial_block( $attributes ) {
    $quote       = isset( $attributes['quote'] )   ? sanitize_textarea_field( $attributes['quote'] )   : '';
    $author      = isset( $attributes['author'] )  ? sanitize_text_field( $attributes['author'] )  : '';
    $role        = isset( $attributes['role'] )    ? sanitize_text_field( $attributes['role'] )    : '';
    $company     = isset( $attributes['company'] ) ? sanitize_text_field( $attributes['company'] ) : '';
    $rating      = isset( $attributes['rating'] )  ? max( 1, min( 5, absint( $attributes['rating'] ) ) ) : 5;
    $show_rating = ! empty( $attributes['showRating'] );
    $avatar_url  = isset( $attributes['avatarUrl'] ) ? esc_url( $attributes['avatarUrl'] ) : '';
    $avatar_alt  = isset( $attributes['avatarAlt'] ) ? sanitize_text_field( $attributes['avatarAlt'] ) : '';
    $variant     = isset( $attributes['variant'] )  ? sanitize_key( $attributes['variant'] ) : 'default';
    $quote_size  = isset( $attributes['quoteSize'] ) ? sanitize_key( $attributes['quoteSize'] ) : 'normal';
    $accent      = isset( $attributes['accentColor'] ) ? sanitize_text_field( $attributes['accentColor'] ) : '';

    if ( ! $quote && ! $author ) {
        return '';
    }

    $allowed_variants = array( 'default', 'bordered', 'dark' );
    $variant = in_array( $variant, $allowed_variants, true ) ? $variant : 'default';

    $classes = array( 'pk-testimonial', 'is-style-paksa-card-testimonial', 'pk-testimonial--' . $variant );
    if ( $quote_size === 'large' ) {
        $classes[] = 'pk-testimonial--large';
    }
    $hover_classes = function_exists( 'paksa_build_hover_classes' ) ? paksa_build_hover_classes( $attributes ) : '';
    if ( $hover_classes ) {
        $classes = array_merge( $classes, explode( ' ', $hover_classes ) );
    }

    $inline_style = '';
    if ( $accent ) {
        $inline_style = 'border-top-color:' . esc_attr( $accent );
    }
    if ( function_exists( 'paksa_build_border_shadow_style' ) ) {
        $bs = paksa_build_border_shadow_style( $attributes );
        if ( $bs ) {
            $inline_style = $inline_style ? $inline_style . ';' . $bs : $bs;
        }
    }

    $wrapper_attrs = array( 'class' => implode( ' ', array_filter( $classes ) ) );
    if ( $inline_style ) {
        $wrapper_attrs['style'] = $inline_style;
    }
    $wrapper = function_exists( 'get_block_wrapper_attributes' )
        ? get_block_wrapper_attributes( $wrapper_attrs )
        : 'class="wp-block-paksa-testimonial ' . esc_attr( $wrapper_attrs['class'] ) . '"';

    $stars = '';
    if ( $show_rating ) {
        $stars = '<div class="pk-testimonial__rating" aria-label="' . esc_attr( sprintf( __( '%d out of 5 stars', 'paksa-it-solutions' ), $rating ) ) . '" role="img">';
        for ( $i = 1; $i <= 5; $i++ ) {
            $stars .= '<span class="pk-testimonial__star' . ( $i <= $rating ? ' is-filled' : '' ) . '" aria-hidden="true">★</span>';
        }
        $stars .= '</div>';
    }

    $quote_icon  = paksa_icon( 'quote', 20 );
    $attribution = '';
    if ( $author ) {
        $attribution .= '<strong class="pk-testimonial__author">' . esc_html( $author ) . '</strong>';
    }
    if ( $role || $company ) {
        $meta = array_filter( array( $role, $company ) );
        $attribution .= '<span class="pk-testimonial__meta">' . esc_html( implode( ', ', $meta ) ) . '</span>';
    }

    $avatar_html = '';
    if ( $avatar_url ) {
        $avatar_html = '<img class="pk-testimonial__avatar" src="' . $avatar_url . '" alt="' . esc_attr( $avatar_alt ?: $author ) . '" width="48" height="48" loading="lazy">';
    }

    ob_start();
    ?>
    <figure <?php echo $wrapper; ?>>
        <?php echo $stars; ?>
        <span class="pk-testimonial__icon" aria-hidden="true"><?php echo $quote_icon; ?></span>
        <blockquote class="pk-testimonial__quote">
            <p><?php echo esc_html( $quote ?: __( 'Add a genuine, permissioned quote here.', 'paksa-it-solutions' ) ); ?></p>
        </blockquote>
        <?php if ( $attribution || $avatar_html ) : ?>
        <figcaption class="pk-testimonial__footer">
            <?php echo $avatar_html; ?>
            <div class="pk-testimonial__attribution"><?php echo $attribution; ?></div>
        </figcaption>
        <?php endif; ?>
    </figure>
    <?php
    return trim( ob_get_clean() );
}

/**
 * Render paksa/cta — a reusable call-to-action section.
 *
 * @param array  $attributes Block attributes.
 * @param string $content    InnerBlocks content (button group).
 * @return string
 */
function paksa_render_cta_block( $attributes, $content ) {
    $eyebrow          = isset( $attributes['eyebrow'] )         ? sanitize_text_field( $attributes['eyebrow'] )         : '';
    $heading          = isset( $attributes['heading'] )         ? sanitize_text_field( $attributes['heading'] )         : '';
    $description      = isset( $attributes['description'] )     ? sanitize_textarea_field( $attributes['description'] ) : '';
    $variant          = isset( $attributes['variant'] )         ? sanitize_key( $attributes['variant'] )                : 'dark';
    $layout           = isset( $attributes['layout'] )          ? sanitize_key( $attributes['layout'] )                 : 'centered';
    $primary_label    = isset( $attributes['primaryLabel'] )    ? sanitize_text_field( $attributes['primaryLabel'] )    : '';
    $primary_url      = isset( $attributes['primaryUrl'] )      ? esc_url( $attributes['primaryUrl'] )                  : '';
    $primary_new_tab  = ! empty( $attributes['primaryNewTab'] );
    $secondary_label  = isset( $attributes['secondaryLabel'] )  ? sanitize_text_field( $attributes['secondaryLabel'] )  : '';
    $secondary_url    = isset( $attributes['secondaryUrl'] )    ? esc_url( $attributes['secondaryUrl'] )                : '';
    $secondary_new_tab = ! empty( $attributes['secondaryNewTab'] );
    $primary_icon     = isset( $attributes['primaryIcon'] )     ? sanitize_key( $attributes['primaryIcon'] )            : '';
    $secondary_icon   = isset( $attributes['secondaryIcon'] )   ? sanitize_key( $attributes['secondaryIcon'] )          : '';
    $animation        = isset( $attributes['animation'] )       ? sanitize_key( $attributes['animation'] )              : 'none';
    $anim_delay       = isset( $attributes['animDelay'] )       ? absint( $attributes['animDelay'] )                    : 0;

    $allowed_variants = array( 'dark', 'gradient', 'light', 'alt', 'transparent' );
    $allowed_layouts  = array( 'centered', 'split', 'left' );
    $variant = in_array( $variant, $allowed_variants, true ) ? $variant : 'dark';
    $layout  = in_array( $layout, $allowed_layouts, true ) ? $layout : 'centered';

    $classes = array( 'pk-cta', 'pk-cta--' . $variant, 'pk-cta--' . $layout );
    if ( $animation !== 'none' ) {
        $classes[] = 'is-style-paksa-motion-' . $animation;
    }

    $wrapper_attrs = array( 'class' => implode( ' ', $classes ) );

    // Inline styles: bg image + border/shadow
    $inline_styles = array();
    if ( function_exists( 'paksa_build_bg_image_style' ) ) {
        $bg = paksa_build_bg_image_style( $attributes );
        if ( $bg ) {
            $inline_styles[] = $bg;
        }
    }
    if ( function_exists( 'paksa_build_border_shadow_style' ) ) {
        $bs = paksa_build_border_shadow_style( $attributes );
        if ( $bs ) {
            $inline_styles[] = $bs;
        }
    }
    if ( $inline_styles ) {
        $wrapper_attrs['style'] = implode( ';', $inline_styles );
    }
    if ( $anim_delay > 0 && $animation !== 'none' ) {
        $wrapper_attrs['data-delay'] = (string) $anim_delay;
    }

    $wrapper = function_exists( 'get_block_wrapper_attributes' )
        ? get_block_wrapper_attributes( $wrapper_attrs )
        : 'class="wp-block-paksa-cta ' . esc_attr( implode( ' ', $classes ) ) . '"';

    // Build button markup with optional icon support
    $buttons = trim( $content );
    if ( ! $buttons && ( $primary_label || $secondary_label ) ) {
        $buttons = '<div class="pk-cta__buttons pk-component-action-group">';
        if ( $primary_label && $primary_url ) {
            $p_target = $primary_new_tab ? ' target="_blank" rel="noopener noreferrer"' : '';
            $p_icon   = $primary_icon ? '<span class="pk-cta__btn-icon" aria-hidden="true">' . paksa_icon( $primary_icon, 16 ) . '</span>' : '';
            $buttons .= '<a class="pk-cta__btn pk-cta__btn--primary" href="' . $primary_url . '"' . $p_target . '>' . $p_icon . esc_html( $primary_label ) . '</a>';
        }
        if ( $secondary_label && $secondary_url ) {
            $s_target = $secondary_new_tab ? ' target="_blank" rel="noopener noreferrer"' : '';
            $s_icon   = $secondary_icon ? '<span class="pk-cta__btn-icon" aria-hidden="true">' . paksa_icon( $secondary_icon, 16 ) . '</span>' : '';
            $buttons .= '<a class="pk-cta__btn pk-cta__btn--secondary" href="' . $secondary_url . '"' . $s_target . '>' . $s_icon . esc_html( $secondary_label ) . '</a>';
        }
        $buttons .= '</div>';
    }

    // Background overlay
    $overlay_html = '';
    if ( ! empty( $attributes['bgImageUrl'] ) && isset( $attributes['bgOverlayOpacity'] ) && $attributes['bgOverlayOpacity'] > 0 ) {
        $opacity       = min( 100, max( 0, absint( $attributes['bgOverlayOpacity'] ) ) );
        $overlay_color = isset( $attributes['bgOverlayColor'] ) && $attributes['bgOverlayColor'] ? esc_attr( $attributes['bgOverlayColor'] ) : '#000000';
        $overlay_html  = '<span class="pk-cta__overlay" aria-hidden="true" style="background:' . $overlay_color . ';opacity:' . ( $opacity / 100 ) . '"></span>';
    }

    ob_start();
    ?>
    <div <?php echo $wrapper; ?>>
        <?php echo $overlay_html; ?>
        <div class="pk-cta__inner">
            <div class="pk-cta__content">
                <?php if ( $eyebrow ) : ?>
                    <span class="pk-cta__eyebrow pk-component-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>
                <?php if ( $heading ) : ?>
                    <h2 class="pk-cta__heading"><?php echo esc_html( $heading ); ?></h2>
                <?php endif; ?>
                <?php if ( $description ) : ?>
                    <p class="pk-cta__description"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>
            </div>
            <?php if ( $buttons ) : ?>
                <div class="pk-cta__actions"><?php echo $buttons; ?></div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return trim( ob_get_clean() );
}
