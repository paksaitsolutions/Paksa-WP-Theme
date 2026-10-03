<?php
/**
 * Paksa Theme — Phase 30 Inline Styling, Visual Controls & Advanced Canvas Editing.
 *
 * Enqueues editor-phase30.js and editor-phase30.css.
 *
 * Adds:
 *  - Contextual style toolbar (BlockControls popovers) for heading, paragraph,
 *    image, button, section, group, columns, column
 *  - Color quick-controls using native style.color.text / style.color.background
 *  - Typography quick-controls using native style.typography.*
 *  - Background + border/shadow quick-controls for paksa/section + core/group
 *    (reuses existing Phase 17/18 attributes — no new attributes introduced)
 *  - Hover state editor (Normal / Hover) for blocks that carry paksa_hover_attributes()
 *  - Button style quick-picker (existing is-style-paksa-button-* classes)
 *  - Image effects quick-picker (existing is-style-paksa-* classes)
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue Phase 30 editor assets.
 */
function paksa_enqueue_phase30_editor_assets() {
    if ( ! wp_script_is( 'paksa-editor-phase29', 'enqueued' ) ) {
        return;
    }

    wp_enqueue_script(
        'paksa-editor-phase30',
        PAKSA_THEME_URI . '/assets/js/editor-phase30.js',
        array(
            'paksa-editor-phase29',
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
        ),
        PAKSA_THEME_VERSION,
        true
    );

    // Theme palette — sourced from theme.json (25 colors)
    $palette = array(
        array( 'name' => 'Primary',         'slug' => 'primary',        'color' => '#6192f8' ),
        array( 'name' => 'Primary Hover',   'slug' => 'primary-hover',  'color' => '#4a7ef5' ),
        array( 'name' => 'Secondary',       'slug' => 'secondary',      'color' => '#121619' ),
        array( 'name' => 'Accent Light',    'slug' => 'accent-light',   'color' => '#eef3fe' ),
        array( 'name' => 'Background',      'slug' => 'bg',             'color' => '#ffffff' ),
        array( 'name' => 'Background Alt',  'slug' => 'bg-alt',         'color' => '#f8f9fc' ),
        array( 'name' => 'Background Dark', 'slug' => 'bg-dark',        'color' => '#121619' ),
        array( 'name' => 'Text',            'slug' => 'text',           'color' => '#1d1d1d' ),
        array( 'name' => 'Text Secondary',  'slug' => 'text-secondary', 'color' => '#555f6d' ),
        array( 'name' => 'Text Muted',      'slug' => 'text-muted',     'color' => '#8a94a0' ),
        array( 'name' => 'Text Inverse',    'slug' => 'text-inverse',   'color' => '#ffffff' ),
        array( 'name' => 'Border',          'slug' => 'border',         'color' => '#e6e8ea' ),
        array( 'name' => 'Success',         'slug' => 'success',        'color' => '#12b76a' ),
        array( 'name' => 'Warning',         'slug' => 'warning',        'color' => '#f79009' ),
        array( 'name' => 'Error',           'slug' => 'error',          'color' => '#f04438' ),
    );

    // Theme gradients — sourced from theme.json
    $gradients = array(
        array( 'name' => 'Primary Flow',  'slug' => 'primary-flow',  'gradient' => 'linear-gradient(135deg, #6192f8 0%, #7c5cfc 100%)' ),
        array( 'name' => 'Deep Surface',  'slug' => 'deep-surface',  'gradient' => 'linear-gradient(135deg, #121619 0%, #252d36 100%)' ),
        array( 'name' => 'Soft Accent',   'slug' => 'soft-accent',   'gradient' => 'linear-gradient(135deg, #eef3fe 0%, #f8f9fc 100%)' ),
    );

    // Shadow presets — from paksaEditorControls (editor-controls.php)
    $shadow_presets = array(
        array( 'label' => 'None',       'value' => 'none' ),
        array( 'label' => 'Small',      'value' => 'sm' ),
        array( 'label' => 'Medium',     'value' => 'md' ),
        array( 'label' => 'Large',      'value' => 'lg' ),
        array( 'label' => 'Extra Large','value' => 'xl' ),
        array( 'label' => 'Blue Glow',  'value' => 'blue' ),
    );

    // Radius presets — from paksaEditorControls
    $radius_presets = array(
        array( 'label' => 'None',   'value' => '0' ),
        array( 'label' => 'Small',  'value' => 'var(--pk-radius-sm)' ),
        array( 'label' => 'Medium', 'value' => 'var(--pk-radius-md)' ),
        array( 'label' => 'Large',  'value' => 'var(--pk-radius-lg)' ),
        array( 'label' => 'XL',     'value' => 'var(--pk-radius-xl)' ),
        array( 'label' => 'Pill',   'value' => '9999px' ),
    );

    // Button styles — existing registered is-style-paksa-button-* classes
    $button_styles = array(
        array( 'label' => 'Default',   'value' => '' ),
        array( 'label' => 'Outline',   'value' => 'is-style-paksa-button-outline' ),
        array( 'label' => 'Ghost',     'value' => 'is-style-paksa-button-ghost' ),
        array( 'label' => 'Light',     'value' => 'is-style-paksa-button-light' ),
        array( 'label' => 'Dark',      'value' => 'is-style-paksa-button-dark' ),
        array( 'label' => 'Secondary', 'value' => 'is-style-paksa-button-secondary' ),
        array( 'label' => 'Text Link', 'value' => 'is-style-paksa-button-text' ),
    );

    // Image styles — existing registered is-style-paksa-* classes
    $image_styles = array(
        array( 'label' => 'Default',      'value' => '' ),
        array( 'label' => 'Rounded',      'value' => 'is-style-paksa-rounded' ),
        array( 'label' => 'Elevated',     'value' => 'is-style-paksa-elevated' ),
        array( 'label' => 'Framed',       'value' => 'is-style-paksa-framed' ),
        array( 'label' => 'Circle',       'value' => 'is-style-paksa-circle' ),
        array( 'label' => 'Zoom Hover',   'value' => 'is-style-paksa-image-zoom' ),
        array( 'label' => 'Overlay Hover','value' => 'is-style-paksa-overlay-hover' ),
    );

    // Hover effects — from paksa_hover_attributes()
    $hover_effects = array(
        array( 'label' => 'None',     'value' => 'none' ),
        array( 'label' => 'Lift',     'value' => 'lift' ),
        array( 'label' => 'Glow',     'value' => 'glow' ),
        array( 'label' => 'Scale',    'value' => 'scale' ),
        array( 'label' => 'Brighten', 'value' => 'brighten' ),
        array( 'label' => 'Dim',      'value' => 'dim' ),
    );

    // Font weight options
    $font_weights = array(
        array( 'label' => 'Normal',      'value' => '400' ),
        array( 'label' => 'Medium',      'value' => '500' ),
        array( 'label' => 'Semi-Bold',   'value' => '600' ),
        array( 'label' => 'Bold',        'value' => '700' ),
        array( 'label' => 'Extra Bold',  'value' => '800' ),
    );

    // Text transform options
    $text_transforms = array(
        array( 'label' => 'None',       'value' => 'none' ),
        array( 'label' => 'Uppercase',  'value' => 'uppercase' ),
        array( 'label' => 'Lowercase',  'value' => 'lowercase' ),
        array( 'label' => 'Capitalize', 'value' => 'capitalize' ),
    );

    // Group card styles — existing registered classes
    $group_styles = array(
        array( 'label' => 'Default',        'value' => '' ),
        array( 'label' => 'Card',           'value' => 'is-style-paksa-card' ),
        array( 'label' => 'Dark Card',      'value' => 'is-style-paksa-card-dark' ),
        array( 'label' => 'Surface',        'value' => 'is-style-paksa-surface' ),
        array( 'label' => 'Glass',          'value' => 'is-style-paksa-glass' ),
        array( 'label' => 'Bordered',       'value' => 'is-style-paksa-bordered' ),
        array( 'label' => 'Dark',           'value' => 'is-style-paksa-dark' ),
        array( 'label' => 'Gradient',       'value' => 'is-style-paksa-gradient' ),
        array( 'label' => 'Highlight Band', 'value' => 'is-style-paksa-highlight-band' ),
    );

    wp_localize_script( 'paksa-editor-phase30', 'paksaPhase30', array(
        'palette'       => $palette,
        'gradients'     => $gradients,
        'shadowPresets' => $shadow_presets,
        'radiusPresets' => $radius_presets,
        'buttonStyles'  => $button_styles,
        'imageStyles'   => $image_styles,
        'hoverEffects'  => $hover_effects,
        'fontWeights'   => $font_weights,
        'textTransforms' => $text_transforms,
        'groupStyles'   => $group_styles,
        'version'       => PAKSA_THEME_VERSION,
    ) );
}
add_action( 'enqueue_block_editor_assets', 'paksa_enqueue_phase30_editor_assets', 30 );
