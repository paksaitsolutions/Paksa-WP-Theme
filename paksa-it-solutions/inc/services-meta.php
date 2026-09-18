<?php
/**
 * Paksa IT Solutions — Services Page Meta Helper
 *
 * Centralises post meta reads for the Services page template.
 * All functions return sanitized strings. Fallbacks are translatable defaults.
 * No hardcoded business copy — defaults are clearly labelled as placeholders.
 *
 * Usage (inside any template-parts/services/*.php):
 *   $value = paksa_svc_meta( 'hero_heading', __( 'Default', 'paksa-it-solutions' ) );
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Read a services page meta value with fallback.
 * Meta key format: _paksa_svc_{$key}
 *
 * @param  string $key      Meta key suffix (without prefix).
 * @param  string $fallback Default value if meta is empty.
 * @param  int    $page_id  Post ID. Defaults to current post.
 * @return string
 */
function paksa_svc_meta( $key, $fallback = '', $page_id = 0 ) {
    if ( ! $page_id ) {
        $page_id = get_the_ID();
    }
    $value = get_post_meta( $page_id, '_paksa_svc_' . $key, true );
    return ( $value !== '' && $value !== false ) ? sanitize_text_field( $value ) : $fallback;
}

/**
 * Read a services page textarea meta value with fallback.
 * Preserves newlines; sanitizes with sanitize_textarea_field.
 *
 * @param  string $key      Meta key suffix.
 * @param  string $fallback Default value.
 * @param  int    $page_id  Post ID.
 * @return string
 */
function paksa_svc_meta_textarea( $key, $fallback = '', $page_id = 0 ) {
    if ( ! $page_id ) {
        $page_id = get_the_ID();
    }
    $value = get_post_meta( $page_id, '_paksa_svc_' . $key, true );
    return ( $value !== '' && $value !== false ) ? sanitize_textarea_field( $value ) : $fallback;
}

/**
 * Read a services page URL meta value with fallback.
 *
 * @param  string $key      Meta key suffix.
 * @param  string $fallback Default URL.
 * @param  int    $page_id  Post ID.
 * @return string
 */
function paksa_svc_meta_url( $key, $fallback = '', $page_id = 0 ) {
    if ( ! $page_id ) {
        $page_id = get_the_ID();
    }
    $value = get_post_meta( $page_id, '_paksa_svc_' . $key, true );
    return ( $value !== '' && $value !== false ) ? esc_url_raw( $value ) : $fallback;
}

/**
 * Register the Services page meta box in the block editor / classic editor.
 * Provides a native WP meta box — no ACF, no plugin required.
 */
function paksa_register_services_meta_box() {
    add_meta_box(
        'paksa_services_content',
        __( 'Services Page Content', 'paksa-it-solutions' ),
        'paksa_render_services_meta_box',
        'page',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'paksa_register_services_meta_box' );

/**
 * Admin notice on the Services page edit screen.
 * Tells editors where to edit content since the_content() is not used.
 */
function paksa_services_edit_notice() {
    $screen = get_current_screen();
    if ( ! $screen || $screen->base !== 'post' || $screen->post_type !== 'page' ) {
        return;
    }
    global $post;
    if ( ! $post || get_post_meta( $post->ID, '_wp_page_template', true ) !== 'page-services.php' ) {
        return;
    }
    echo '<div class="notice notice-info" style="border-left-color:#6192F8;">';
    echo '<p><strong>Services Page:</strong> This page is built from template parts. ';
    echo 'Edit the <strong>Hero, CTA and section visibility</strong> using the <strong>"Services Page Content"</strong> meta box below. ';
    echo 'To edit individual services, go to <a href="' . esc_url( admin_url( 'edit.php?post_type=paksa_service' ) ) . '">Services &rarr; All Services</a>.</p>';
    echo '</div>';
}
add_action( 'admin_notices', 'paksa_services_edit_notice' );

/**
 * Only show the meta box on pages using the Services template.
 * Hooked to add_meta_boxes — checks current screen template.
 */
function paksa_services_meta_box_condition() {
    global $post;
    if ( ! $post ) {
        return;
    }
    $template = get_post_meta( $post->ID, '_wp_page_template', true );
    if ( $template !== 'page-services.php' ) {
        remove_meta_box( 'paksa_services_content', 'page', 'normal' );
    }
}
add_action( 'add_meta_boxes', 'paksa_services_meta_box_condition', 20 );

/**
 * Render the Services meta box fields.
 *
 * @param WP_Post $post Current post object.
 */
function paksa_render_services_meta_box( $post ) {
    wp_nonce_field( 'paksa_services_meta_save', 'paksa_services_meta_nonce' );

    $fields = paksa_services_meta_fields();
    $current_section = '';

    echo '<style>.pk-mb-section{margin:16px 0 8px;font-weight:600;font-size:13px;color:#1d2327;border-bottom:1px solid #dcdcde;padding-bottom:6px;}.pk-mb-row{margin-bottom:12px;}.pk-mb-row label{display:block;font-size:12px;color:#50575e;margin-bottom:4px;}.pk-mb-row input[type=text],.pk-mb-row textarea,.pk-mb-row select{width:100%;}.pk-mb-row textarea{height:80px;resize:vertical;}.pk-mb-hint{font-size:11px;color:#8c8f94;margin-top:3px;}</style>';

    foreach ( $fields as $field ) {
        if ( isset( $field['section'] ) && $field['section'] !== $current_section ) {
            $current_section = $field['section'];
            echo '<p class="pk-mb-section">' . esc_html( $field['section'] ) . '</p>';
        }

        $meta_key = '_paksa_svc_' . $field['key'];
        $value    = get_post_meta( $post->ID, $meta_key, true );

        echo '<div class="pk-mb-row">';
        echo '<label for="' . esc_attr( $meta_key ) . '">' . esc_html( $field['label'] ) . '</label>';

        if ( $field['type'] === 'textarea' ) {
            echo '<textarea id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '">' . esc_textarea( $value ) . '</textarea>';
        } elseif ( $field['type'] === 'select' ) {
            echo '<select id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '">';
            foreach ( $field['options'] as $opt_val => $opt_label ) {
                echo '<option value="' . esc_attr( $opt_val ) . '"' . selected( $value, $opt_val, false ) . '>' . esc_html( $opt_label ) . '</option>';
            }
            echo '</select>';
        } else {
            echo '<input type="text" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '" value="' . esc_attr( $value ) . '">';
        }

        if ( ! empty( $field['hint'] ) ) {
            echo '<p class="pk-mb-hint">' . esc_html( $field['hint'] ) . '</p>';
        }

        echo '</div>';
    }
}

/**
 * Save Services meta box fields.
 *
 * @param int $post_id Post ID being saved.
 */
function paksa_save_services_meta( $post_id ) {
    if (
        ! isset( $_POST['paksa_services_meta_nonce'] ) ||
        ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['paksa_services_meta_nonce'] ) ), 'paksa_services_meta_save' )
    ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( get_post_type( $post_id ) !== 'page' ) {
        return;
    }

    $template = get_post_meta( $post_id, '_wp_page_template', true );
    if ( $template !== 'page-services.php' ) {
        return;
    }

    $fields = paksa_services_meta_fields();

    foreach ( $fields as $field ) {
        $meta_key = '_paksa_svc_' . $field['key'];

        if ( ! isset( $_POST[ $meta_key ] ) ) {
            continue;
        }

        $raw = wp_unslash( $_POST[ $meta_key ] );

        if ( $field['type'] === 'textarea' ) {
            $value = sanitize_textarea_field( $raw );
        } elseif ( $field['type'] === 'url' ) {
            $value = esc_url_raw( $raw );
        } elseif ( $field['type'] === 'select' ) {
            $allowed = array_keys( $field['options'] );
            $value   = in_array( $raw, $allowed, true ) ? $raw : '';
        } else {
            $value = sanitize_text_field( $raw );
        }

        update_post_meta( $post_id, $meta_key, $value );
    }
}
add_action( 'save_post', 'paksa_save_services_meta' );

/**
 * Define all Services page meta fields.
 * Single source of truth for both rendering and saving.
 *
 * @return array
 */
function paksa_services_meta_fields() {
    return array(

        // --- Hero ---
        array( 'section' => __( 'Hero Section', 'paksa-it-solutions' ), 'key' => 'hero_eyebrow',       'label' => __( 'Eyebrow Label', 'paksa-it-solutions' ),       'type' => 'text' ),
        array( 'key' => 'hero_heading',      'label' => __( 'Hero Heading', 'paksa-it-solutions' ),      'type' => 'text' ),
        array( 'key' => 'hero_description',  'label' => __( 'Hero Description', 'paksa-it-solutions' ),  'type' => 'textarea' ),
        array( 'key' => 'hero_cta1_text',    'label' => __( 'Primary CTA Text', 'paksa-it-solutions' ),  'type' => 'text' ),
        array( 'key' => 'hero_cta1_url',     'label' => __( 'Primary CTA URL', 'paksa-it-solutions' ),   'type' => 'url' ),
        array( 'key' => 'hero_cta2_text',    'label' => __( 'Secondary CTA Text', 'paksa-it-solutions' ),'type' => 'text' ),
        array( 'key' => 'hero_cta2_url',     'label' => __( 'Secondary CTA URL', 'paksa-it-solutions' ), 'type' => 'url' ),

        // --- Overview ---
        array( 'section' => __( 'Overview Section', 'paksa-it-solutions' ), 'key' => 'overview_eyebrow',     'label' => __( 'Eyebrow', 'paksa-it-solutions' ),     'type' => 'text' ),
        array( 'key' => 'overview_heading',    'label' => __( 'Heading', 'paksa-it-solutions' ),    'type' => 'text' ),
        array( 'key' => 'overview_content',    'label' => __( 'Content (paragraphs, one per line)', 'paksa-it-solutions' ), 'type' => 'textarea', 'hint' => __( 'Each line becomes a paragraph.', 'paksa-it-solutions' ) ),

        // --- Section Visibility ---
        array( 'section' => __( 'Section Visibility', 'paksa-it-solutions' ), 'key' => 'show_hero',         'label' => __( 'Show Hero', 'paksa-it-solutions' ),         'type' => 'select', 'options' => array( '' => __( 'Yes (default)', 'paksa-it-solutions' ), '0' => __( 'No — hide', 'paksa-it-solutions' ) ) ),
        array( 'key' => 'show_overview',     'label' => __( 'Show Overview', 'paksa-it-solutions' ),     'type' => 'select', 'options' => array( '' => __( 'Yes (default)', 'paksa-it-solutions' ), '0' => __( 'No — hide', 'paksa-it-solutions' ) ) ),
        array( 'key' => 'show_portfolio',    'label' => __( 'Show Service Portfolio', 'paksa-it-solutions' ), 'type' => 'select', 'options' => array( '' => __( 'Yes (default)', 'paksa-it-solutions' ), '0' => __( 'No — hide', 'paksa-it-solutions' ) ) ),
        array( 'key' => 'show_capabilities', 'label' => __( 'Show Capabilities', 'paksa-it-solutions' ), 'type' => 'select', 'options' => array( '' => __( 'Yes (default)', 'paksa-it-solutions' ), '0' => __( 'No — hide', 'paksa-it-solutions' ) ) ),
        array( 'key' => 'show_process',      'label' => __( 'Show Process', 'paksa-it-solutions' ),      'type' => 'select', 'options' => array( '' => __( 'Yes (default)', 'paksa-it-solutions' ), '0' => __( 'No — hide', 'paksa-it-solutions' ) ) ),
        array( 'key' => 'show_industries',   'label' => __( 'Show Industries', 'paksa-it-solutions' ),   'type' => 'select', 'options' => array( '' => __( 'Yes (default)', 'paksa-it-solutions' ), '0' => __( 'No — hide', 'paksa-it-solutions' ) ) ),
        array( 'key' => 'show_technology',   'label' => __( 'Show Technology', 'paksa-it-solutions' ),   'type' => 'select', 'options' => array( '' => __( 'Yes (default)', 'paksa-it-solutions' ), '0' => __( 'No — hide', 'paksa-it-solutions' ) ) ),
        array( 'key' => 'show_faq',          'label' => __( 'Show FAQ', 'paksa-it-solutions' ),          'type' => 'select', 'options' => array( '' => __( 'Yes (default)', 'paksa-it-solutions' ), '0' => __( 'No — hide', 'paksa-it-solutions' ) ) ),
        array( 'key' => 'show_cta',          'label' => __( 'Show CTA', 'paksa-it-solutions' ),          'type' => 'select', 'options' => array( '' => __( 'Yes (default)', 'paksa-it-solutions' ), '0' => __( 'No — hide', 'paksa-it-solutions' ) ) ),

        // --- CTA Override ---
        array( 'section' => __( 'CTA Section Override', 'paksa-it-solutions' ), 'key' => 'cta_heading',   'label' => __( 'CTA Heading (overrides global)', 'paksa-it-solutions' ),   'type' => 'text', 'hint' => __( 'Leave blank to use global CTA heading from Customizer.', 'paksa-it-solutions' ) ),
        array( 'key' => 'cta_description', 'label' => __( 'CTA Description (overrides global)', 'paksa-it-solutions' ), 'type' => 'textarea' ),
        array( 'key' => 'cta_btn1_text',   'label' => __( 'Primary Button Text', 'paksa-it-solutions' ),  'type' => 'text' ),
        array( 'key' => 'cta_btn1_url',    'label' => __( 'Primary Button URL', 'paksa-it-solutions' ),   'type' => 'url' ),
        array( 'key' => 'cta_btn2_text',   'label' => __( 'Secondary Button Text', 'paksa-it-solutions' ),'type' => 'text' ),
        array( 'key' => 'cta_btn2_url',    'label' => __( 'Secondary Button URL', 'paksa-it-solutions' ), 'type' => 'url' ),
    );
}
