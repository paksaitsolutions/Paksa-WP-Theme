<?php
/**
 * Paksa Theme — Phase 32 Section Builder, Reusable Design System & Responsive Composition.
 *
 * Enqueues editor-phase32.js and editor-phase32.css.
 *
 * Adds:
 *  - Section Builder PluginSidebar: searchable pattern library, layout chooser,
 *    page starters — all backed by the actual registered pattern registry
 *  - "+ Add Section" toolbar action on paksa/section and root-level empty state
 *  - Section quick-settings panel (layout, background, spacing, responsive summary)
 *  - Save as Pattern (wp.blocks.serialize + wp.data reusable blocks API)
 *  - Reusable/synced section indicator in the overlay bar
 *
 * All patterns are sourced from the existing registered pattern registry.
 * No duplicate pattern storage. No custom builder JSON.
 * Gutenberg block tree remains the single source of truth.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue Phase 32 editor assets.
 */
function paksa_enqueue_phase32_editor_assets() {
    if ( ! wp_script_is( 'paksa-editor-phase31', 'enqueued' ) ) {
        return;
    }

    wp_enqueue_script(
        'paksa-editor-phase32',
        PAKSA_THEME_URI . '/assets/js/editor-phase32.js',
        array(
            'paksa-editor-phase31',
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
        ),
        PAKSA_THEME_VERSION,
        true
    );

    // ── Pattern categories — only actual registered categories ──────────────
    // These map to the categories registered in visual-system.php,
    // advanced-builder.php, and composition.php.
    $pattern_categories = array(
        array( 'slug' => 'paksa-heroes',       'label' => 'Heroes',        'icon' => '⬛' ),
        array( 'slug' => 'paksa-features',     'label' => 'Features',      'icon' => '⊞' ),
        array( 'slug' => 'paksa-about',        'label' => 'About',         'icon' => '◎' ),
        array( 'slug' => 'paksa-services',     'label' => 'Services',      'icon' => '⚙' ),
        array( 'slug' => 'paksa-products',     'label' => 'Products',      'icon' => '▣' ),
        array( 'slug' => 'paksa-testimonials', 'label' => 'Testimonials',  'icon' => '"' ),
        array( 'slug' => 'paksa-pricing',      'label' => 'Pricing',       'icon' => '$' ),
        array( 'slug' => 'paksa-team',         'label' => 'Team',          'icon' => '👥' ),
        array( 'slug' => 'paksa-process',      'label' => 'Process',       'icon' => '→' ),
        array( 'slug' => 'paksa-blog',         'label' => 'Blog',          'icon' => '¶' ),
        array( 'slug' => 'paksa-cta',          'label' => 'CTA',           'icon' => '!' ),
        array( 'slug' => 'paksa-contact',      'label' => 'Contact',       'icon' => '✉' ),
        array( 'slug' => 'paksa-faq',          'label' => 'FAQ',           'icon' => '?' ),
        array( 'slug' => 'paksa-stats',        'label' => 'Stats',         'icon' => '#' ),
        array( 'slug' => 'paksa-sections',     'label' => 'Sections',      'icon' => '▤' ),
        array( 'slug' => 'paksa-page-starters','label' => 'Page Starters', 'icon' => '⊡' ),
        array( 'slug' => 'paksa-query',        'label' => 'Query Loops',   'icon' => '⟳' ),
    );

    // ── Layout presets — mirrors Phase 26 layoutPresets + Phase 28 LAYOUTS ──
    // These are the actual column structures the builder can insert.
    $layout_presets = array(
        array(
            'label'   => '1 Column',
            'diagram' => '█████████',
            'cols'    => 1,
            'widths'  => array(),
        ),
        array(
            'label'   => '2 Columns',
            'diagram' => '████ ████',
            'cols'    => 2,
            'widths'  => array(),
        ),
        array(
            'label'   => '3 Columns',
            'diagram' => '███ ███ ███',
            'cols'    => 3,
            'widths'  => array(),
        ),
        array(
            'label'   => '4 Columns',
            'diagram' => '██ ██ ██ ██',
            'cols'    => 4,
            'widths'  => array(),
        ),
        array(
            'label'   => '1/3 + 2/3',
            'diagram' => '███ ██████',
            'cols'    => 2,
            'widths'  => array( '33.33%', '66.66%' ),
        ),
        array(
            'label'   => '2/3 + 1/3',
            'diagram' => '██████ ███',
            'cols'    => 2,
            'widths'  => array( '66.66%', '33.33%' ),
        ),
        array(
            'label'   => '1/4 + 3/4',
            'diagram' => '██ ███████',
            'cols'    => 2,
            'widths'  => array( '25%', '75%' ),
        ),
        array(
            'label'   => '3/4 + 1/4',
            'diagram' => '███████ ██',
            'cols'    => 2,
            'widths'  => array( '75%', '25%' ),
        ),
    );

    // ── Section variants — mirrors paksa/section variant attribute ──────────
    $section_variants = array(
        array( 'label' => 'Default',     'value' => 'default',     'class' => '' ),
        array( 'label' => 'Alt',         'value' => 'alt',         'class' => 'pk-section--alt' ),
        array( 'label' => 'Dark',        'value' => 'dark',        'class' => 'pk-section--dark' ),
        array( 'label' => 'Gradient',    'value' => 'gradient',    'class' => 'pk-section--gradient' ),
        array( 'label' => 'Transparent', 'value' => 'transparent', 'class' => '' ),
    );

    // ── Page starters — actual registered patterns in paksa-page-starters ───
    $page_starters = array(
        array(
            'slug'        => 'paksa-it-solutions/page-about-full',
            'title'       => 'About Page',
            'description' => 'Story, values, and statistics.',
            'icon'        => '◎',
        ),
        array(
            'slug'        => 'paksa-it-solutions/page-contact-full',
            'title'       => 'Contact Page',
            'description' => 'Form, map, and contact details.',
            'icon'        => '✉',
        ),
        array(
            'slug'        => 'paksa-it-solutions/page-services-full',
            'title'       => 'Services Page',
            'description' => 'Hero and live services query.',
            'icon'        => '⚙',
        ),
        array(
            'slug'        => 'paksa-it-solutions/page-products-full',
            'title'       => 'Products Page',
            'description' => 'Hero and live products query.',
            'icon'        => '▣',
        ),
        array(
            'slug'        => 'paksa-it-solutions/page-blog-full',
            'title'       => 'Blog Page',
            'description' => 'Hero and live posts query.',
            'icon'        => '¶',
        ),
    );

    // ── Spacing presets — mirrors Phase 29 spacingPresets ───────────────────
    $spacing_presets = array(
        array( 'label' => '0',   'value' => '0' ),
        array( 'label' => '2XS', 'value' => 'var(--wp--preset--spacing--20)' ),
        array( 'label' => 'XS',  'value' => 'var(--wp--preset--spacing--30)' ),
        array( 'label' => 'S',   'value' => 'var(--wp--preset--spacing--40)' ),
        array( 'label' => 'M',   'value' => 'var(--wp--preset--spacing--50)' ),
        array( 'label' => 'L',   'value' => 'var(--wp--preset--spacing--60)' ),
        array( 'label' => 'XL',  'value' => 'var(--wp--preset--spacing--70)' ),
        array( 'label' => '2XL', 'value' => 'var(--wp--preset--spacing--80)' ),
        array( 'label' => '3XL', 'value' => 'var(--wp--preset--spacing--90)' ),
    );

    // ── Container widths — mirrors Phase 29 containerWidths ─────────────────
    $container_widths = array(
        array( 'label' => 'Narrow',  'value' => 'narrow',  'px' => '720px' ),
        array( 'label' => 'Default', 'value' => 'default', 'px' => '1200px' ),
        array( 'label' => 'Wide',    'value' => 'wide',    'px' => '1440px' ),
        array( 'label' => 'Full',    'value' => 'full',    'px' => '100%' ),
    );

    // ── Section background quick presets ─────────────────────────────────────
    // Only presets backed by actual registered block styles or paksa/section attrs.
    $bg_presets = array(
        array( 'label' => 'Transparent', 'value' => '',         'style' => '' ),
        array( 'label' => 'Surface',     'value' => 'surface',  'style' => 'is-style-paksa-surface' ),
        array( 'label' => 'Dark',        'value' => 'dark',     'style' => '' ),
        array( 'label' => 'Gradient',    'value' => 'gradient', 'style' => '' ),
    );

    wp_localize_script( 'paksa-editor-phase32', 'paksaPhase32', array(
        'patternCategories' => $pattern_categories,
        'layoutPresets'     => $layout_presets,
        'sectionVariants'   => $section_variants,
        'pageStarters'      => $page_starters,
        'spacingPresets'    => $spacing_presets,
        'containerWidths'   => $container_widths,
        'bgPresets'         => $bg_presets,
        'version'           => PAKSA_THEME_VERSION,
        'nonce'             => wp_create_nonce( 'wp_rest' ),
    ) );
}
add_action( 'enqueue_block_editor_assets', 'paksa_enqueue_phase32_editor_assets', 32 );
