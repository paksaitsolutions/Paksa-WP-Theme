<?php
/**
 * Paksa Theme — Phase 18 editor control infrastructure.
 *
 * Provides:
 *  - Shared attribute definitions reused across multiple blocks.
 *  - Phase 18 block style registrations (Image, Group, Heading, Quote extras).
 *  - A localized JS payload (paksaEditorControls) consumed by editor-blocks.js.
 *
 * No new token system is introduced. All values map to existing --pk-* tokens.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ── Shared attribute sets ──────────────────────────────────────────────── */

/**
 * Hover/interaction attributes shared by section, card, and CTA blocks.
 *
 * @return array
 */
function paksa_hover_attributes() {
    return array(
        'hoverEffect'    => array( 'type' => 'string',  'default' => 'none' ),
        'hoverShadow'    => array( 'type' => 'boolean', 'default' => false ),
        'hoverLift'      => array( 'type' => 'boolean', 'default' => false ),
        'hoverBgColor'   => array( 'type' => 'string',  'default' => '' ),
        'transition'     => array( 'type' => 'string',  'default' => 'base' ),
    );
}

/**
 * Responsive layout attributes: per-breakpoint columns and stack direction.
 *
 * @return array
 */
function paksa_responsive_attributes() {
    return array(
        'colsMobile'  => array( 'type' => 'number', 'default' => 1 ),
        'colsTablet'  => array( 'type' => 'number', 'default' => 2 ),
        'colsDesktop' => array( 'type' => 'number', 'default' => 3 ),
        'stackMobile' => array( 'type' => 'boolean', 'default' => true ),
    );
}

/**
 * Background image/overlay attributes for section-level blocks.
 *
 * @return array
 */
function paksa_bg_image_attributes() {
    return array(
        'bgImageUrl'      => array( 'type' => 'string',  'default' => '' ),
        'bgImageAlt'      => array( 'type' => 'string',  'default' => '' ),
        'bgImagePosition' => array( 'type' => 'string',  'default' => 'center center' ),
        'bgImageSize'     => array( 'type' => 'string',  'default' => 'cover' ),
        'bgOverlayColor'  => array( 'type' => 'string',  'default' => '' ),
        'bgOverlayOpacity'=> array( 'type' => 'number',  'default' => 50 ),
    );
}

/**
 * Border/shadow attributes for card-level blocks.
 *
 * @return array
 */
function paksa_border_shadow_attributes() {
    return array(
        'borderWidth'  => array( 'type' => 'string',  'default' => '' ),
        'borderStyle'  => array( 'type' => 'string',  'default' => 'solid' ),
        'borderColor'  => array( 'type' => 'string',  'default' => '' ),
        'borderRadius' => array( 'type' => 'string',  'default' => '' ),
        'shadowPreset' => array( 'type' => 'string',  'default' => 'none' ),
    );
}

/**
 * Typography override attributes for heading/text blocks.
 *
 * @return array
 */
function paksa_typography_attributes() {
    return array(
        'textTransform'  => array( 'type' => 'string', 'default' => '' ),
        'letterSpacing'  => array( 'type' => 'string', 'default' => '' ),
        'fontWeight'     => array( 'type' => 'string', 'default' => '' ),
    );
}

/* ── Phase 18 block style registrations ─────────────────────────────────── */

function paksa_register_phase18_block_styles() {
    if ( ! function_exists( 'register_block_style' ) ) {
        return;
    }

    // Image block styles
    $image_styles = array(
        'paksa-rounded'  => __( 'Paksa Rounded', 'paksa-it-solutions' ),
        'paksa-elevated' => __( 'Paksa Elevated', 'paksa-it-solutions' ),
        'paksa-framed'   => __( 'Paksa Framed', 'paksa-it-solutions' ),
        'paksa-circle'   => __( 'Paksa Circle', 'paksa-it-solutions' ),
    );
    foreach ( $image_styles as $name => $label ) {
        register_block_style( 'core/image', array( 'name' => $name, 'label' => $label ) );
    }

    // Group block — surface/glass variants
    $group_styles = array(
        'paksa-surface'  => __( 'Paksa Surface', 'paksa-it-solutions' ),
        'paksa-glass'    => __( 'Paksa Glass', 'paksa-it-solutions' ),
        'paksa-bordered' => __( 'Paksa Bordered', 'paksa-it-solutions' ),
        'paksa-dark'     => __( 'Paksa Dark', 'paksa-it-solutions' ),
        'paksa-gradient' => __( 'Paksa Gradient', 'paksa-it-solutions' ),
    );
    foreach ( $group_styles as $name => $label ) {
        register_block_style( 'core/group', array( 'name' => $name, 'label' => $label ) );
    }

    // Heading block — gradient + section-heading
    register_block_style( 'core/heading', array(
        'name'  => 'paksa-gradient',
        'label' => __( 'Paksa Gradient Text', 'paksa-it-solutions' ),
    ) );
    register_block_style( 'core/heading', array(
        'name'  => 'paksa-section-heading',
        'label' => __( 'Paksa Section Heading', 'paksa-it-solutions' ),
    ) );

    // Quote block — large quote
    register_block_style( 'core/quote', array(
        'name'  => 'paksa-large',
        'label' => __( 'Paksa Large Quote', 'paksa-it-solutions' ),
    ) );

    // Paragraph — intro style
    register_block_style( 'core/paragraph', array(
        'name'  => 'paksa-intro',
        'label' => __( 'Paksa Intro', 'paksa-it-solutions' ),
    ) );

    // Cover block — hero overlay
    register_block_style( 'core/cover', array(
        'name'  => 'paksa-hero-overlay',
        'label' => __( 'Paksa Hero Overlay', 'paksa-it-solutions' ),
    ) );

    // Buttons block — centered/right aligned
    register_block_style( 'core/buttons', array(
        'name'  => 'paksa-centered',
        'label' => __( 'Paksa Centered', 'paksa-it-solutions' ),
    ) );
    register_block_style( 'core/buttons', array(
        'name'  => 'paksa-stacked',
        'label' => __( 'Paksa Stacked', 'paksa-it-solutions' ),
    ) );

    // Separator — gradient divider
    register_block_style( 'core/separator', array(
        'name'  => 'paksa-gradient',
        'label' => __( 'Paksa Gradient Divider', 'paksa-it-solutions' ),
    ) );

    // Table — clean/striped
    register_block_style( 'core/table', array(
        'name'  => 'paksa-clean',
        'label' => __( 'Paksa Clean', 'paksa-it-solutions' ),
    ) );
    register_block_style( 'core/table', array(
        'name'  => 'paksa-striped',
        'label' => __( 'Paksa Striped', 'paksa-it-solutions' ),
    ) );
}
add_action( 'init', 'paksa_register_phase18_block_styles', 16 );

/* ── Localized editor data payload ──────────────────────────────────────── */

/**
 * Extend the existing paksaIconBlock localization with Phase 18 control data.
 * Runs after visual-system.php enqueues paksa-editor-blocks.
 */
function paksa_localize_phase18_editor_data() {
    if ( ! wp_script_is( 'paksa-editor-blocks', 'enqueued' ) ) {
        return;
    }

    wp_localize_script( 'paksa-editor-blocks', 'paksaEditorControls', array(
        'spacingTokens' => array(
            array( 'label' => '2XS — 0.5rem',  'value' => 'var(--pk-space-2)' ),
            array( 'label' => 'XS — 0.75rem',  'value' => 'var(--pk-space-3)' ),
            array( 'label' => 'S — 1rem',       'value' => 'var(--pk-space-4)' ),
            array( 'label' => 'M — 1.5rem',     'value' => 'var(--pk-space-6)' ),
            array( 'label' => 'L — 2rem',       'value' => 'var(--pk-space-8)' ),
            array( 'label' => 'XL — 3rem',      'value' => 'var(--pk-space-12)' ),
            array( 'label' => '2XL — 4–7rem',   'value' => 'var(--pk-space-16)' ),
            array( 'label' => '3XL — 5–9rem',   'value' => 'var(--pk-space-20)' ),
        ),
        'shadowTokens' => array(
            array( 'label' => 'None',       'value' => 'none' ),
            array( 'label' => 'Small',      'value' => 'sm' ),
            array( 'label' => 'Medium',     'value' => 'md' ),
            array( 'label' => 'Large',      'value' => 'lg' ),
            array( 'label' => 'Extra Large','value' => 'xl' ),
            array( 'label' => 'Blue Glow',  'value' => 'blue' ),
        ),
        'radiusTokens' => array(
            array( 'label' => 'None',    'value' => '0' ),
            array( 'label' => 'Small',   'value' => 'var(--pk-radius-sm)' ),
            array( 'label' => 'Medium',  'value' => 'var(--pk-radius-md)' ),
            array( 'label' => 'Large',   'value' => 'var(--pk-radius-lg)' ),
            array( 'label' => 'XL',      'value' => 'var(--pk-radius-xl)' ),
            array( 'label' => 'Full',    'value' => 'var(--pk-radius-full)' ),
        ),
        'animationOptions' => array(
            array( 'label' => 'None',           'value' => 'none' ),
            array( 'label' => 'Fade',           'value' => 'fade' ),
            array( 'label' => 'Fade Up',        'value' => 'fade-up' ),
            array( 'label' => 'Fade Down',      'value' => 'fade-down' ),
            array( 'label' => 'Fade Left',      'value' => 'fade-left' ),
            array( 'label' => 'Fade Right',     'value' => 'fade-right' ),
            array( 'label' => 'Scale',          'value' => 'scale' ),
            array( 'label' => 'Reveal',         'value' => 'reveal' ),
            array( 'label' => 'Stagger Children','value' => 'stagger' ),
        ),
        'hoverEffects' => array(
            array( 'label' => 'None',      'value' => 'none' ),
            array( 'label' => 'Lift',      'value' => 'lift' ),
            array( 'label' => 'Glow',      'value' => 'glow' ),
            array( 'label' => 'Scale',     'value' => 'scale' ),
            array( 'label' => 'Brighten',  'value' => 'brighten' ),
            array( 'label' => 'Dim',       'value' => 'dim' ),
        ),
        'containerWidths' => array(
            array( 'label' => 'Default (1200px)', 'value' => 'default' ),
            array( 'label' => 'Narrow (720px)',   'value' => 'narrow' ),
            array( 'label' => 'Wide (1440px)',    'value' => 'wide' ),
            array( 'label' => 'Full bleed',       'value' => 'full' ),
        ),
        'bgPositions' => array(
            array( 'label' => 'Center',       'value' => 'center center' ),
            array( 'label' => 'Top',          'value' => 'center top' ),
            array( 'label' => 'Bottom',       'value' => 'center bottom' ),
            array( 'label' => 'Left',         'value' => 'left center' ),
            array( 'label' => 'Right',        'value' => 'right center' ),
            array( 'label' => 'Top Left',     'value' => 'left top' ),
            array( 'label' => 'Top Right',    'value' => 'right top' ),
        ),
    ) );
}
add_action( 'enqueue_block_editor_assets', 'paksa_localize_phase18_editor_data', 20 );

/* ── Inline style generation for dynamic block attributes ────────────────── */

/**
 * Build an inline style string from border/shadow attributes.
 * Used by server-side render callbacks.
 *
 * @param array $attributes Block attributes.
 * @return string CSS string (without style="").
 */
function paksa_build_border_shadow_style( $attributes ) {
    $parts = array();

    $border_width  = isset( $attributes['borderWidth'] )  ? sanitize_text_field( $attributes['borderWidth'] )  : '';
    $border_style  = isset( $attributes['borderStyle'] )  ? sanitize_key( $attributes['borderStyle'] )         : 'solid';
    $border_color  = isset( $attributes['borderColor'] )  ? sanitize_text_field( $attributes['borderColor'] )  : '';
    $border_radius = isset( $attributes['borderRadius'] ) ? sanitize_text_field( $attributes['borderRadius'] ) : '';
    $shadow_preset = isset( $attributes['shadowPreset'] ) ? sanitize_key( $attributes['shadowPreset'] )        : 'none';

    if ( $border_width && $border_color ) {
        $parts[] = 'border:' . $border_width . ' ' . $border_style . ' ' . $border_color;
    } elseif ( $border_width ) {
        $parts[] = 'border-width:' . $border_width;
    }

    if ( $border_radius ) {
        $parts[] = 'border-radius:' . $border_radius;
    }

    $shadow_map = array(
        'sm'   => 'var(--pk-shadow-sm)',
        'md'   => 'var(--pk-shadow-md)',
        'lg'   => 'var(--pk-shadow-lg)',
        'xl'   => 'var(--pk-shadow-xl)',
        'blue' => 'var(--pk-shadow-blue)',
    );

    if ( $shadow_preset !== 'none' && isset( $shadow_map[ $shadow_preset ] ) ) {
        $parts[] = 'box-shadow:' . $shadow_map[ $shadow_preset ];
    }

    return implode( ';', $parts );
}

/**
 * Build background image inline style from bg image attributes.
 *
 * @param array $attributes Block attributes.
 * @return string CSS string.
 */
function paksa_build_bg_image_style( $attributes ) {
    $url      = isset( $attributes['bgImageUrl'] )       ? esc_url( $attributes['bgImageUrl'] )                    : '';
    $position = isset( $attributes['bgImagePosition'] )  ? sanitize_text_field( $attributes['bgImagePosition'] )   : 'center center';
    $size     = isset( $attributes['bgImageSize'] )      ? sanitize_key( $attributes['bgImageSize'] )              : 'cover';

    if ( ! $url ) {
        return '';
    }

    return 'background-image:url(' . $url . ');background-position:' . $position . ';background-size:' . $size . ';background-repeat:no-repeat';
}

/**
 * Build hover CSS class string from hover attributes.
 *
 * @param array $attributes Block attributes.
 * @return string Space-separated class string.
 */
function paksa_build_hover_classes( $attributes ) {
    $classes = array();
    $effect  = isset( $attributes['hoverEffect'] ) ? sanitize_key( $attributes['hoverEffect'] ) : 'none';
    $allowed = array( 'lift', 'glow', 'scale', 'brighten', 'dim' );

    if ( in_array( $effect, $allowed, true ) ) {
        $classes[] = 'pk-hover-' . $effect;
    }
    if ( ! empty( $attributes['hoverShadow'] ) ) {
        $classes[] = 'pk-hover-shadow';
    }
    if ( ! empty( $attributes['hoverLift'] ) ) {
        $classes[] = 'pk-hover-lift';
    }

    $transition = isset( $attributes['transition'] ) ? sanitize_key( $attributes['transition'] ) : 'base';
    if ( in_array( $transition, array( 'fast', 'base', 'slow' ), true ) ) {
        $classes[] = 'pk-transition-' . $transition;
    }

    return implode( ' ', $classes );
}
