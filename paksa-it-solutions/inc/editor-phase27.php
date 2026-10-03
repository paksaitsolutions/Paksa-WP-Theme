<?php
/**
 * Paksa Theme — Phase 27 Visual Builder Workflow & Navigator.
 *
 * Localizes the paksaPhase27 data payload consumed by the Phase 27 IIFEs
 * that are appended to editor-phase26.js. No separate script file is needed.
 *
 * Adds:
 *  - Block naming suggestions for List View (metadata.name)
 *  - Section variant presets for the quick-toolbar
 *  - Group style presets for the container toolbar
 *  - Safe copyable attribute list for Copy Style / Paste Style
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Localize paksaPhase27 against the already-enqueued paksa-editor-phase26 handle.
 * The Phase 27 IIFEs live inside editor-phase26.js (appended during Phase 27).
 */
function paksa_localize_phase27_data() {
    if ( ! wp_script_is( 'paksa-editor-phase26', 'enqueued' ) ) {
        return;
    }

    // Section variant presets — mirrors paksa/section variant attribute options
    $section_variants = array(
        array( 'label' => 'Default',     'value' => 'default' ),
        array( 'label' => 'Alt',         'value' => 'alt' ),
        array( 'label' => 'Dark',        'value' => 'dark' ),
        array( 'label' => 'Gradient',    'value' => 'gradient' ),
        array( 'label' => 'Transparent', 'value' => 'transparent' ),
    );

    // Group style presets — reuses existing registered block styles
    $group_style_presets = array(
        array( 'label' => 'Default',   'value' => '' ),
        array( 'label' => 'Card',      'value' => 'is-style-paksa-card' ),
        array( 'label' => 'Dark Card', 'value' => 'is-style-paksa-card-dark' ),
        array( 'label' => 'Surface',   'value' => 'is-style-paksa-surface' ),
        array( 'label' => 'Glass',     'value' => 'is-style-paksa-glass' ),
        array( 'label' => 'Bordered',  'value' => 'is-style-paksa-bordered' ),
        array( 'label' => 'Gradient',  'value' => 'is-style-paksa-gradient' ),
        array( 'label' => 'Highlight', 'value' => 'is-style-paksa-highlight-band' ),
    );

    // Styling attributes safe to copy/paste — no content, no IDs, no media URLs
    $copyable_attrs = array(
        'pkPaddingTop', 'pkPaddingBot', 'pkPaddingLeft', 'pkPaddingRight', 'pkGap',
        'pkFlexDir', 'pkJustify', 'pkAlignItems', 'pkFlexWrap', 'pkFlexGap',
        'borderWidth', 'borderStyle', 'borderColor', 'borderRadius', 'shadowPreset',
        'hoverEffect', 'hoverShadow', 'hoverLift', 'transition',
        'animation', 'animDelay', 'animDuration',
        'variant', 'containerWidth', 'textAlign', 'verticalAlign',
        'bgColor', 'bgGradient', 'bgImagePosition', 'bgImageSize',
        'bgOverlayColor', 'bgOverlayOpacity',
        'pkMobileCols', 'pkTabletCols', 'pkStackMobile',
    );

    // Suggested block names shown in the ComboboxControl for List View labelling
    $suggested_names = array(
        array( 'label' => 'Hero Section',  'value' => 'Hero Section' ),
        array( 'label' => 'Features',      'value' => 'Features' ),
        array( 'label' => 'About Us',      'value' => 'About Us' ),
        array( 'label' => 'Services',      'value' => 'Services' ),
        array( 'label' => 'Products',      'value' => 'Products' ),
        array( 'label' => 'Testimonials',  'value' => 'Testimonials' ),
        array( 'label' => 'Pricing',       'value' => 'Pricing' ),
        array( 'label' => 'FAQ',           'value' => 'FAQ' ),
        array( 'label' => 'CTA',           'value' => 'CTA' ),
        array( 'label' => 'Contact',       'value' => 'Contact' ),
        array( 'label' => 'Blog',          'value' => 'Blog' ),
        array( 'label' => 'Team',          'value' => 'Team' ),
        array( 'label' => 'Process',       'value' => 'Process' ),
        array( 'label' => 'Statistics',    'value' => 'Statistics' ),
        array( 'label' => 'Case Studies',  'value' => 'Case Studies' ),
        array( 'label' => 'Partners',      'value' => 'Partners' ),
        array( 'label' => 'Newsletter',    'value' => 'Newsletter' ),
        array( 'label' => 'Footer',        'value' => 'Footer' ),
        array( 'label' => 'Header',        'value' => 'Header' ),
        array( 'label' => 'Container',     'value' => 'Container' ),
        array( 'label' => 'Content',       'value' => 'Content' ),
        array( 'label' => 'Sidebar',       'value' => 'Sidebar' ),
        array( 'label' => 'Card Grid',     'value' => 'Card Grid' ),
        array( 'label' => 'Split Layout',  'value' => 'Split Layout' ),
    );

    wp_localize_script( 'paksa-editor-phase26', 'paksaPhase27', array(
        'sectionVariants'   => $section_variants,
        'groupStylePresets' => $group_style_presets,
        'copyableAttrs'     => $copyable_attrs,
        'suggestedNames'    => $suggested_names,
        'version'           => PAKSA_THEME_VERSION,
    ) );
}
add_action( 'enqueue_block_editor_assets', 'paksa_localize_phase27_data', 27 );
