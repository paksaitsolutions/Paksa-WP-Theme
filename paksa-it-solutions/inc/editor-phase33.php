<?php
/**
 * Paksa Theme — Phase 33 Global Style Manager, Design Tokens & Site-Wide Editing.
 *
 * Enqueues editor-phase33.js and editor-phase33.css.
 *
 * Adds:
 *  - Paksa Site Styles PluginSidebar backed by WP Global Styles API
 *    (wp.data select/dispatch 'core' — getEditedEntityRecord / editEntityRecord)
 *  - Style variation switcher using getThemeStyleVariations() / setGlobalStylesId()
 *  - Colors, Typography, Layout, Spacing, Buttons, Borders, Shadows, Motion panels
 *  - Local override detector + Reset to Global on selected blocks
 *  - Design token reference panel (actual theme.json values)
 *  - Extends window.paksaVisual.GLOBAL — no new namespace
 *
 * All token values sourced from theme.json. No parallel token system.
 * No custom style database. Gutenberg Global Styles remains source of truth.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue Phase 33 editor assets.
 */
function paksa_enqueue_phase33_editor_assets() {
    if ( ! wp_script_is( 'paksa-editor-phase32', 'enqueued' ) ) {
        return;
    }

    wp_enqueue_script(
        'paksa-editor-phase33',
        PAKSA_THEME_URI . '/assets/js/editor-phase33.js',
        array(
            'paksa-editor-phase32',
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

    // ── Color palette — full 25 colors from theme.json ──────────────────────
    // Organised into semantic role groups for the UI.
    $palette = array(
        // Brand
        array( 'name' => 'Primary',         'slug' => 'primary',        'color' => '#6192f8', 'role' => 'brand' ),
        array( 'name' => 'Primary Hover',   'slug' => 'primary-hover',  'color' => '#4a7ef5', 'role' => 'brand' ),
        array( 'name' => 'Secondary',       'slug' => 'secondary',      'color' => '#121619', 'role' => 'brand' ),
        array( 'name' => 'Accent',          'slug' => 'accent',         'color' => '#6192f8', 'role' => 'brand' ),
        array( 'name' => 'Accent Light',    'slug' => 'accent-light',   'color' => '#eef3fe', 'role' => 'brand' ),
        // Backgrounds
        array( 'name' => 'Background',      'slug' => 'bg',             'color' => '#ffffff',  'role' => 'background' ),
        array( 'name' => 'Background Alt',  'slug' => 'bg-alt',         'color' => '#f8f9fc',  'role' => 'background' ),
        array( 'name' => 'Background Dark', 'slug' => 'bg-dark',        'color' => '#121619',  'role' => 'background' ),
        array( 'name' => 'Surface',         'slug' => 'surface',        'color' => '#ffffff',  'role' => 'background' ),
        array( 'name' => 'Surface Alt',     'slug' => 'surface-alt',    'color' => '#f8f9fc',  'role' => 'background' ),
        array( 'name' => 'Dark',            'slug' => 'dark',           'color' => '#121619',  'role' => 'background' ),
        array( 'name' => 'Light',           'slug' => 'light',          'color' => '#f8f9fc',  'role' => 'background' ),
        // Text
        array( 'name' => 'Text Primary',    'slug' => 'text',           'color' => '#1d1d1d',  'role' => 'text' ),
        array( 'name' => 'Text Secondary',  'slug' => 'text-secondary', 'color' => '#555f6d',  'role' => 'text' ),
        array( 'name' => 'Text Muted',      'slug' => 'text-muted',     'color' => '#8a94a0',  'role' => 'text' ),
        array( 'name' => 'Muted',           'slug' => 'muted',          'color' => '#8a94a0',  'role' => 'text' ),
        array( 'name' => 'Text Inverse',    'slug' => 'text-inverse',   'color' => '#ffffff',  'role' => 'text' ),
        // UI
        array( 'name' => 'Border',          'slug' => 'border',         'color' => '#e6e8ea',  'role' => 'ui' ),
        array( 'name' => 'White',           'slug' => 'white',          'color' => '#ffffff',  'role' => 'ui' ),
        array( 'name' => 'Black',           'slug' => 'black',          'color' => '#000000',  'role' => 'ui' ),
        // Status
        array( 'name' => 'Success',         'slug' => 'success',        'color' => '#12b76a',  'role' => 'status' ),
        array( 'name' => 'Warning',         'slug' => 'warning',        'color' => '#f79009',  'role' => 'status' ),
        array( 'name' => 'Error',           'slug' => 'error',          'color' => '#f04438',  'role' => 'status' ),
        array( 'name' => 'Danger',          'slug' => 'danger',         'color' => '#f04438',  'role' => 'status' ),
        array( 'name' => 'Info',            'slug' => 'info',           'color' => '#6192f8',  'role' => 'status' ),
    );

    // ── Gradients — from theme.json ──────────────────────────────────────────
    $gradients = array(
        array( 'name' => 'Primary Flow', 'slug' => 'primary-flow', 'gradient' => 'linear-gradient(135deg, #6192f8 0%, #7c5cfc 100%)' ),
        array( 'name' => 'Deep Surface', 'slug' => 'deep-surface', 'gradient' => 'linear-gradient(135deg, #121619 0%, #252d36 100%)' ),
        array( 'name' => 'Soft Accent',  'slug' => 'soft-accent',  'gradient' => 'linear-gradient(135deg, #eef3fe 0%, #f8f9fc 100%)' ),
    );

    // ── Font families — from theme.json ──────────────────────────────────────
    $font_families = array(
        array( 'name' => 'Poppins',    'slug' => 'poppins',    'family' => "'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif" ),
        array( 'name' => 'Serif',      'slug' => 'serif',      'family' => 'serif' ),
        array( 'name' => 'Monospace',  'slug' => 'monospace',  'family' => 'monospace' ),
    );

    // ── Font sizes — from theme.json (fluid sizes preserved) ─────────────────
    $font_sizes = array(
        array( 'name' => 'Caption',    'slug' => 'caption',    'size' => '0.75rem' ),
        array( 'name' => 'Small',      'slug' => 'small',      'size' => '0.875rem' ),
        array( 'name' => 'Label',      'slug' => 'label',      'size' => '0.8125rem' ),
        array( 'name' => 'Normal',     'slug' => 'normal',     'size' => '1rem' ),
        array( 'name' => 'Body Large', 'slug' => 'body-large', 'size' => 'clamp(1.0625rem, 1vw + 0.8rem, 1.25rem)' ),
        array( 'name' => 'Large',      'slug' => 'large',      'size' => '1.125rem' ),
        array( 'name' => 'Heading',    'slug' => 'heading',    'size' => '1.5rem' ),
        array( 'name' => 'H5',         'slug' => 'h5',         'size' => '1.125rem' ),
        array( 'name' => 'H4',         'slug' => 'h4',         'size' => '1.25rem' ),
        array( 'name' => 'H3',         'slug' => 'h3',         'size' => 'clamp(1.5rem, 1.5vw + 1rem, 2rem)' ),
        array( 'name' => 'H2',         'slug' => 'h2',         'size' => 'clamp(2rem, 2.5vw + 1rem, 3rem)' ),
        array( 'name' => 'H1',         'slug' => 'h1',         'size' => 'clamp(2.5rem, 4vw + 1rem, 4.5rem)' ),
        array( 'name' => 'Display',    'slug' => 'display',    'size' => 'clamp(3rem, 5vw + 1rem, 5.5rem)' ),
    );

    // ── Spacing sizes — from theme.json ──────────────────────────────────────
    $spacing_sizes = array(
        array( 'name' => '2XS', 'slug' => '20', 'size' => '0.5rem',                    'var' => 'var(--wp--preset--spacing--20)' ),
        array( 'name' => 'XS',  'slug' => '30', 'size' => '0.75rem',                   'var' => 'var(--wp--preset--spacing--30)' ),
        array( 'name' => 'S',   'slug' => '40', 'size' => '1rem',                      'var' => 'var(--wp--preset--spacing--40)' ),
        array( 'name' => 'M',   'slug' => '50', 'size' => '1.5rem',                    'var' => 'var(--wp--preset--spacing--50)' ),
        array( 'name' => 'L',   'slug' => '60', 'size' => '2rem',                      'var' => 'var(--wp--preset--spacing--60)' ),
        array( 'name' => 'XL',  'slug' => '70', 'size' => '3rem',                      'var' => 'var(--wp--preset--spacing--70)' ),
        array( 'name' => '2XL', 'slug' => '80', 'size' => 'clamp(4rem, 7vw, 7rem)',    'var' => 'var(--wp--preset--spacing--80)' ),
        array( 'name' => '3XL', 'slug' => '90', 'size' => 'clamp(5rem, 10vw, 9rem)',   'var' => 'var(--wp--preset--spacing--90)' ),
    );

    // ── Shadow presets — from theme.json ─────────────────────────────────────
    $shadow_presets = array(
        array( 'name' => 'Small',     'slug' => 'sm',        'shadow' => '0 1px 3px rgba(18,22,25,.06), 0 1px 2px rgba(18,22,25,.04)' ),
        array( 'name' => 'Medium',    'slug' => 'md',        'shadow' => '0 4px 16px rgba(18,22,25,.08)' ),
        array( 'name' => 'Large',     'slug' => 'lg',        'shadow' => '0 8px 32px rgba(18,22,25,.1)' ),
        array( 'name' => 'Blue Glow', 'slug' => 'blue-glow', 'shadow' => '0 8px 32px rgba(97,146,248,.25)' ),
    );

    // ── Layout — from theme.json settings.layout ─────────────────────────────
    $layout = array(
        'contentSize' => '1200px',
        'wideSize'    => '1440px',
        'narrowSize'  => '720px',
    );

    // ── Radius tokens — from theme.json settings.custom ──────────────────────
    $radius_tokens = array(
        array( 'name' => 'Small',  'token' => '--pk-radius-sm',   'value' => '6px',    'var' => 'var(--wp--custom--radius-sm)' ),
        array( 'name' => 'Medium', 'token' => '--pk-radius-md',   'value' => '10px',   'var' => 'var(--wp--custom--radius-md)' ),
        array( 'name' => 'Large',  'token' => '--pk-radius-lg',   'value' => '16px',   'var' => 'var(--wp--custom--radius-lg)' ),
        array( 'name' => 'XL',     'token' => '--pk-radius-xl',   'value' => '24px',   'var' => 'var(--wp--custom--radius-xl)' ),
        array( 'name' => 'Pill',   'token' => '--pk-radius-full', 'value' => '9999px', 'var' => '9999px' ),
    );

    // ── Transition tokens — from theme.json settings.custom ──────────────────
    $transition_tokens = array(
        array( 'name' => 'Fast', 'token' => '--pk-transition-fast', 'value' => '150ms ease',                       'var' => 'var(--wp--custom--transition-fast)' ),
        array( 'name' => 'Base', 'token' => '--pk-transition-base', 'value' => '250ms ease',                       'var' => 'var(--wp--custom--transition-base)' ),
        array( 'name' => 'Slow', 'token' => '--pk-transition-slow', 'value' => '400ms cubic-bezier(.16,1,.3,1)',   'var' => 'var(--wp--custom--transition-slow)' ),
    );

    // ── Style variations — actual files in styles/ ────────────────────────────
    $style_variations = array(
        array(
            'name'        => 'Modern',
            'slug'        => 'modern',
            'description' => 'Default — blue primary, Poppins, balanced radius.',
            'primary'     => '#6192f8',
            'bg'          => '#ffffff',
            'text'        => '#1d1d1d',
        ),
        array(
            'name'        => 'Corporate',
            'slug'        => 'corporate',
            'description' => 'Deep navy, formal typography, sharp radius.',
            'primary'     => '#174c78',
            'bg'          => '#ffffff',
            'text'        => '#1a2a3a',
        ),
        array(
            'name'        => 'Creative',
            'slug'        => 'creative',
            'description' => 'Vibrant accent, expressive layout.',
            'primary'     => '#7c3aed',
            'bg'          => '#ffffff',
            'text'        => '#1a1a2e',
        ),
        array(
            'name'        => 'Elegant',
            'slug'        => 'elegant',
            'description' => 'Serif headings, refined spacing.',
            'primary'     => '#8b6914',
            'bg'          => '#fdfaf5',
            'text'        => '#1c1a14',
        ),
        array(
            'name'        => 'Minimal',
            'slug'        => 'minimal',
            'description' => 'Reduced color, maximum whitespace.',
            'primary'     => '#255fc4',
            'bg'          => '#ffffff',
            'text'        => '#111827',
        ),
    );

    // ── Global Styles entity path — used by JS to read/write via WP data API ─
    // The JS reads: select('core').getEditedEntityRecord('root','globalStyles', globalStylesId)
    // and dispatches: dispatch('core').editEntityRecord('root','globalStyles', id, patch)
    // We pass the REST base so JS can resolve the current globalStyles post ID.
    $global_styles_rest_base = rest_url( 'wp/v2/global-styles' );

    // ── Attributes that constitute a "local override" on a block ─────────────
    // These are the style-related attributes checked against global defaults.
    $override_attrs = array(
        // Native WP style object paths
        'style.color.text',
        'style.color.background',
        'style.color.gradient',
        'style.typography.fontFamily',
        'style.typography.fontSize',
        'style.typography.fontWeight',
        'style.typography.lineHeight',
        'style.typography.letterSpacing',
        'style.typography.textTransform',
        'style.spacing.padding.top',
        'style.spacing.padding.bottom',
        'style.spacing.padding.left',
        'style.spacing.padding.right',
        'style.border.radius',
        'style.shadow',
        // Paksa custom attributes
        'bgColor',
        'bgGradient',
        'borderRadius',
        'shadowPreset',
        'hoverEffect',
        'variant',
        'containerWidth',
    );

    // ── Global design system Customizer values (read-only reference for JS) ──
    $customizer_design = array(
        'radiusPersonality' => sanitize_key( get_theme_mod( 'paksa_radius_personality', 'default' ) ),
        'shadowIntensity'   => sanitize_key( get_theme_mod( 'paksa_shadow_intensity', 'default' ) ),
        'motionPreference'  => sanitize_key( get_theme_mod( 'paksa_motion_preference', 'full' ) ),
        'sectionSpacing'    => sanitize_key( get_theme_mod( 'paksa_section_spacing', 'default' ) ),
        'styleVariation'    => sanitize_key( get_theme_mod( 'paksa_style_variation', 'modern' ) ),
    );

    wp_localize_script( 'paksa-editor-phase33', 'paksaPhase33', array(
        'palette'             => $palette,
        'gradients'           => $gradients,
        'fontFamilies'        => $font_families,
        'fontSizes'           => $font_sizes,
        'spacingSizes'        => $spacing_sizes,
        'shadowPresets'       => $shadow_presets,
        'layout'              => $layout,
        'radiusTokens'        => $radius_tokens,
        'transitionTokens'    => $transition_tokens,
        'styleVariations'     => $style_variations,
        'overrideAttrs'       => $override_attrs,
        'customizerDesign'    => $customizer_design,
        'globalStylesRestBase'=> $global_styles_rest_base,
        'nonce'               => wp_create_nonce( 'wp_rest' ),
        'version'             => PAKSA_THEME_VERSION,
    ) );
}
add_action( 'enqueue_block_editor_assets', 'paksa_enqueue_phase33_editor_assets', 33 );
