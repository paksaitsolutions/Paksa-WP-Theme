<?php
/**
 * Paksa Theme — Phase 31 Visual Canvas Interaction Layer.
 *
 * Enqueues editor-phase31.js and editor-phase31.css.
 *
 * Adds:
 *  - Canvas block targeting: hover outlines + element labels (metadata.name aware)
 *  - Selected block overlay: breadcrumb parent nav, duplicate, delete quick actions
 *  - Spacing visualization: inline padding display with click-to-edit
 *  - Column width feedback badge on core/column selection
 *  - Alignment guides for column/container layouts
 *  - Insertion indicator enhancements
 *  - Drag affordance improvements
 *
 * All interactions are editor-only. No frontend output.
 * Gutenberg block tree remains the single source of truth.
 * Reuses window.paksaVisual (Phase 30), Navigator (Phase 29),
 * spacing system (Phase 29), style clipboard (Phase 27).
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue Phase 31 editor assets.
 */
function paksa_enqueue_phase31_editor_assets() {
    if ( ! wp_script_is( 'paksa-editor-phase30', 'enqueued' ) ) {
        return;
    }

    wp_enqueue_script(
        'paksa-editor-phase31',
        PAKSA_THEME_URI . '/assets/js/editor-phase31.js',
        array(
            'paksa-editor-phase30',
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

    // Block type label map — mirrors Phase 29 Navigator blockLabel()
    $block_labels = array(
        'paksa/section'    => 'Section',
        'core/group'       => 'Container',
        'core/columns'     => 'Columns',
        'core/column'      => 'Column',
        'core/heading'     => 'Heading',
        'core/paragraph'   => 'Paragraph',
        'core/image'       => 'Image',
        'core/buttons'     => 'Buttons',
        'core/button'      => 'Button',
        'core/cover'       => 'Cover',
        'core/list'        => 'List',
        'core/quote'       => 'Quote',
        'core/separator'   => 'Separator',
        'core/spacer'      => 'Spacer',
        'core/navigation'  => 'Navigation',
        'core/query'       => 'Query Loop',
        'core/template-part' => 'Template Part',
        'paksa/testimonial'  => 'Testimonial',
        'paksa/cta'          => 'CTA',
        'paksa/icon'         => 'Icon',
        'paksa/stat'         => 'Stat',
        'paksa/breadcrumbs'  => 'Breadcrumbs',
        'paksa/product-card' => 'Product Card',
        'paksa/service-card' => 'Service Card',
    );

    // Container block types — used for boundary guide logic
    $container_types = array(
        'paksa/section',
        'core/group',
        'core/columns',
        'core/column',
        'core/cover',
    );

    // Column width steps — mirrors Phase 29 STEPS
    $col_width_steps = array(
        array( 'label' => 'Auto', 'value' => '' ),
        array( 'label' => '25%',  'value' => '25%' ),
        array( 'label' => '33%',  'value' => '33.33%' ),
        array( 'label' => '40%',  'value' => '40%' ),
        array( 'label' => '50%',  'value' => '50%' ),
        array( 'label' => '60%',  'value' => '60%' ),
        array( 'label' => '67%',  'value' => '66.66%' ),
        array( 'label' => '75%',  'value' => '75%' ),
    );

    wp_localize_script( 'paksa-editor-phase31', 'paksaPhase31', array(
        'blockLabels'    => $block_labels,
        'containerTypes' => $container_types,
        'colWidthSteps'  => $col_width_steps,
        'version'        => PAKSA_THEME_VERSION,
    ) );
}
add_action( 'enqueue_block_editor_assets', 'paksa_enqueue_phase31_editor_assets', 31 );
