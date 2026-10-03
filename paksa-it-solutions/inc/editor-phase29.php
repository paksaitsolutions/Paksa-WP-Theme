<?php
/**
 * Paksa Theme — Phase 29 Visual Canvas, Spacing Handles & Responsive Editing.
 *
 * Enqueues editor-phase29.js and editor-phase29.css.
 *
 * Adds:
 *  - Visual spacing drag handles on paksa/section and core/group
 *  - Container width quick-picker toolbar
 *  - Navigator search, filter, auto-scroll, rename, context menu
 *  - Responsive device bar (Desktop / Tablet / Mobile context)
 *  - Empty-state canvas affordances for section / group / columns
 *  - Column resize (discrete safe steps)
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue Phase 29 editor assets.
 */
function paksa_enqueue_phase29_editor_assets() {
    if ( ! wp_script_is( 'paksa-editor-phase28', 'enqueued' ) ) {
        return;
    }

    wp_enqueue_script(
        'paksa-editor-phase29',
        PAKSA_THEME_URI . '/assets/js/editor-phase29.js',
        array(
            'paksa-editor-phase28',
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

    // Container width options — reuse existing containerWidth values from blocks.php
    $container_widths = array(
        array( 'label' => 'Narrow',  'value' => 'narrow',  'px' => '720px',  'icon' => '▏▕' ),
        array( 'label' => 'Default', 'value' => 'default', 'px' => '1200px', 'icon' => '◁▷' ),
        array( 'label' => 'Wide',    'value' => 'wide',    'px' => '1440px', 'icon' => '◀▶' ),
        array( 'label' => 'Full',    'value' => 'full',    'px' => '100%',   'icon' => '⟵⟶' ),
    );

    // Spacing presets — map to existing theme.json spacingSizes
    $spacing_presets = array(
        array( 'label' => '0',    'value' => '0' ),
        array( 'label' => '2XS',  'value' => 'var(--wp--preset--spacing--20)' ),
        array( 'label' => 'XS',   'value' => 'var(--wp--preset--spacing--30)' ),
        array( 'label' => 'S',    'value' => 'var(--wp--preset--spacing--40)' ),
        array( 'label' => 'M',    'value' => 'var(--wp--preset--spacing--50)' ),
        array( 'label' => 'L',    'value' => 'var(--wp--preset--spacing--60)' ),
        array( 'label' => 'XL',   'value' => 'var(--wp--preset--spacing--70)' ),
        array( 'label' => '2XL',  'value' => 'var(--wp--preset--spacing--80)' ),
        array( 'label' => '3XL',  'value' => 'var(--wp--preset--spacing--90)' ),
    );

    // Navigator filter categories
    $nav_filters = array(
        array( 'label' => 'All',        'value' => 'all' ),
        array( 'label' => 'Sections',   'value' => 'sections' ),
        array( 'label' => 'Containers', 'value' => 'containers' ),
        array( 'label' => 'Columns',    'value' => 'columns' ),
        array( 'label' => 'Content',    'value' => 'content' ),
    );

    wp_localize_script( 'paksa-editor-phase29', 'paksaPhase29', array(
        'containerWidths' => $container_widths,
        'spacingPresets'  => $spacing_presets,
        'navFilters'      => $nav_filters,
        'version'         => PAKSA_THEME_VERSION,
    ) );
}
add_action( 'enqueue_block_editor_assets', 'paksa_enqueue_phase29_editor_assets', 29 );
