<?php
/**
 * Paksa Theme — Phase 28 Visual Navigator, Container Workflow & Layout Editing.
 *
 * Enqueues editor-phase28.js and editor-phase28.css.
 *
 * Adds:
 *  - Paksa Navigator PluginSidebar (real block tree, selection sync,
 *    expand/collapse, move up/down, duplicate, delete)
 *  - Visual layout chooser on core/columns toolbar (safe add-only)
 *  - Add Container quick action on paksa/section + core/group
 *  - Navigator toolbar button
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue Phase 28 editor assets.
 */
function paksa_enqueue_phase28_editor_assets() {
    if ( ! wp_script_is( 'paksa-editor-phase26', 'enqueued' ) ) {
        return;
    }

    wp_enqueue_script(
        'paksa-editor-phase28',
        PAKSA_THEME_URI . '/assets/js/editor-phase28.js',
        array(
            'paksa-editor-phase26',
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
        ),
        PAKSA_THEME_VERSION,
        true
    );

}
add_action( 'enqueue_block_editor_assets', 'paksa_enqueue_phase28_editor_assets', 28 );
