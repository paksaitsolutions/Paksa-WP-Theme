<?php
/**
 * Paksa IT Solutions — Product Meta Helpers
 *
 * Handles all post meta for the paksa_product CPT.
 * Meta key prefix: _paksa_prod_
 *
 * Provides:
 *   - paksa_prod_meta()          Read text meta
 *   - paksa_prod_meta_textarea() Read textarea meta
 *   - paksa_prod_meta_url()      Read URL meta
 *   - Meta box registration, rendering, and saving
 *   - paksa_product_meta_fields() Single source of truth for all fields
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// =========================================================
// META READER HELPERS
// =========================================================

/**
 * Read a product meta text value with fallback.
 * Meta key: _paksa_prod_{$key}
 *
 * @param  string $key      Meta key suffix.
 * @param  string $fallback Default if empty.
 * @param  int    $post_id  Post ID. Defaults to current post.
 * @return string
 */
function paksa_prod_meta( $key, $fallback = '', $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $value = get_post_meta( $post_id, '_paksa_prod_' . $key, true );
    return ( $value !== '' && $value !== false ) ? sanitize_text_field( $value ) : $fallback;
}

/**
 * Read a product meta textarea value with fallback.
 *
 * @param  string $key      Meta key suffix.
 * @param  string $fallback Default if empty.
 * @param  int    $post_id  Post ID.
 * @return string
 */
function paksa_prod_meta_textarea( $key, $fallback = '', $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $value = get_post_meta( $post_id, '_paksa_prod_' . $key, true );
    return ( $value !== '' && $value !== false ) ? sanitize_textarea_field( $value ) : $fallback;
}

/**
 * Read a product meta URL value with fallback.
 *
 * @param  string $key      Meta key suffix.
 * @param  string $fallback Default URL.
 * @param  int    $post_id  Post ID.
 * @return string
 */
function paksa_prod_meta_url( $key, $fallback = '', $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $value = get_post_meta( $post_id, '_paksa_prod_' . $key, true );
    return ( $value !== '' && $value !== false ) ? esc_url_raw( $value ) : $fallback;
}

// =========================================================
// META BOX REGISTRATION
// =========================================================

/**
 * Register the Product meta box on paksa_product edit screens.
 */
function paksa_register_product_meta_box() {
    add_meta_box(
        'paksa_product_content',
        __( 'Product Details', 'paksa-it-solutions' ),
        'paksa_render_product_meta_box',
        'paksa_product',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'paksa_register_product_meta_box' );

/**
 * Render the Product meta box.
 *
 * @param WP_Post $post Current post object.
 */
function paksa_render_product_meta_box( $post ) {
    wp_nonce_field( 'paksa_product_meta_save', 'paksa_product_meta_nonce' );

    $fields          = paksa_product_meta_fields();
    $current_section = '';

    echo '<style>
        .pk-mb-section{margin:16px 0 8px;font-weight:600;font-size:13px;color:#1d2327;border-bottom:1px solid #dcdcde;padding-bottom:6px;}
        .pk-mb-row{margin-bottom:12px;}
        .pk-mb-row label{display:block;font-size:12px;color:#50575e;margin-bottom:4px;}
        .pk-mb-row input[type=text],.pk-mb-row textarea,.pk-mb-row select{width:100%;}
        .pk-mb-row textarea{height:80px;resize:vertical;}
        .pk-mb-hint{font-size:11px;color:#8c8f94;margin-top:3px;}
        .pk-mb-row-half{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
    </style>';

    foreach ( $fields as $field ) {
        if ( isset( $field['section'] ) && $field['section'] !== $current_section ) {
            $current_section = $field['section'];
            echo '<p class="pk-mb-section">' . esc_html( $field['section'] ) . '</p>';
        }

        $meta_key = '_paksa_prod_' . $field['key'];
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
        } elseif ( $field['type'] === 'relationship_service' ) {
            $services     = get_posts( array(
                'post_type'      => 'paksa_service',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
            ) );
            $selected_ids = array_filter( array_map( 'absint', explode( ',', $value ) ) );
            echo '<select id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '[]" multiple style="height:120px;">';
            foreach ( $services as $service ) {
                $sel = in_array( $service->ID, $selected_ids, true ) ? ' selected' : '';
                echo '<option value="' . esc_attr( $service->ID ) . '"' . $sel . '>' . esc_html( $service->post_title ) . '</option>';
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

// =========================================================
// META BOX SAVE
// =========================================================

/**
 * Save product meta box fields.
 *
 * @param int $post_id Post ID being saved.
 */
function paksa_save_product_meta( $post_id ) {
    if (
        ! isset( $_POST['paksa_product_meta_nonce'] ) ||
        ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['paksa_product_meta_nonce'] ) ), 'paksa_product_meta_save' )
    ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( get_post_type( $post_id ) !== 'paksa_product' ) {
        return;
    }

    $fields = paksa_product_meta_fields();

    foreach ( $fields as $field ) {
        $meta_key = '_paksa_prod_' . $field['key'];

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
        } elseif ( $field['type'] === 'relationship_service' ) {
            $raw_ids = isset( $_POST[ $meta_key ] ) ? (array) $_POST[ $meta_key ] : array();
            $ids     = array_filter( array_map( 'absint', $raw_ids ) );
            update_post_meta( $post_id, $meta_key, implode( ',', $ids ) );
            continue;
        } else {
            $value = sanitize_text_field( $raw );
        }

        update_post_meta( $post_id, $meta_key, $value );
    }
}
add_action( 'save_post_paksa_product', 'paksa_save_product_meta' );

// =========================================================
// FIELD DEFINITIONS — single source of truth
// =========================================================

/**
 * All product meta fields.
 * Used by both the meta box renderer and the save handler.
 *
 * @return array
 */
function paksa_product_meta_fields() {
    $vis_options = array(
        ''  => __( 'Yes — show (default)', 'paksa-it-solutions' ),
        '0' => __( 'No — hide', 'paksa-it-solutions' ),
    );

    return array(

        // --- Identity ---
        array( 'section' => __( 'Product Identity', 'paksa-it-solutions' ),
               'key' => 'tagline',      'label' => __( 'Tagline / Positioning Statement', 'paksa-it-solutions' ), 'type' => 'text',
               'hint' => __( 'One-line description shown in cards and hero. Keep under 80 characters.', 'paksa-it-solutions' ) ),
        array( 'key' => 'category_label', 'label' => __( 'Category Label (display)', 'paksa-it-solutions' ), 'type' => 'text',
               'hint' => __( 'e.g. "Enterprise Resource Planning". Shown on cards. Use taxonomy for filtering.', 'paksa-it-solutions' ) ),
        array( 'key' => 'badge',         'label' => __( 'Badge Text (optional)', 'paksa-it-solutions' ),       'type' => 'text',
               'hint' => __( 'e.g. "New", "Featured". Leave blank for none.', 'paksa-it-solutions' ) ),
        array( 'key' => 'featured',      'label' => __( 'Featured Product', 'paksa-it-solutions' ),            'type' => 'select',
               'options' => array( '' => __( 'No', 'paksa-it-solutions' ), '1' => __( 'Yes — show as featured', 'paksa-it-solutions' ) ) ),

        // --- Hero ---
        array( 'section' => __( 'Hero Section', 'paksa-it-solutions' ),
               'key' => 'hero_eyebrow',      'label' => __( 'Eyebrow Label', 'paksa-it-solutions' ),      'type' => 'text' ),
        array( 'key' => 'hero_heading',      'label' => __( 'Hero Heading', 'paksa-it-solutions' ),       'type' => 'text',
               'hint' => __( 'Defaults to product title if blank.', 'paksa-it-solutions' ) ),
        array( 'key' => 'hero_description',  'label' => __( 'Hero Description', 'paksa-it-solutions' ),   'type' => 'textarea' ),
        array( 'key' => 'hero_cta1_text',    'label' => __( 'Primary CTA Text', 'paksa-it-solutions' ),   'type' => 'text' ),
        array( 'key' => 'hero_cta1_url',     'label' => __( 'Primary CTA URL', 'paksa-it-solutions' ),    'type' => 'url' ),
        array( 'key' => 'hero_cta2_text',    'label' => __( 'Secondary CTA Text', 'paksa-it-solutions' ), 'type' => 'text' ),
        array( 'key' => 'hero_cta2_url',     'label' => __( 'Secondary CTA URL', 'paksa-it-solutions' ),  'type' => 'url' ),

        // --- Overview ---
        array( 'section' => __( 'Overview Section', 'paksa-it-solutions' ),
               'key' => 'overview_eyebrow',  'label' => __( 'Eyebrow', 'paksa-it-solutions' ),  'type' => 'text' ),
        array( 'key' => 'overview_heading',  'label' => __( 'Heading', 'paksa-it-solutions' ),  'type' => 'text' ),
        array( 'key' => 'overview_content',  'label' => __( 'Content (one paragraph per line)', 'paksa-it-solutions' ), 'type' => 'textarea',
               'hint' => __( 'Each line becomes a paragraph. Use the block editor for richer content.', 'paksa-it-solutions' ) ),

        // --- Features ---
        array( 'section' => __( 'Key Features', 'paksa-it-solutions' ),
               'key' => 'features_eyebrow', 'label' => __( 'Eyebrow', 'paksa-it-solutions' ), 'type' => 'text' ),
        array( 'key' => 'features_heading', 'label' => __( 'Heading', 'paksa-it-solutions' ), 'type' => 'text' ),
        array( 'key' => 'features_desc',    'label' => __( 'Description', 'paksa-it-solutions' ), 'type' => 'textarea' ),
        array( 'key' => 'features_list',    'label' => __( 'Feature Items (one per line: Title | Description)', 'paksa-it-solutions' ), 'type' => 'textarea',
               'hint' => __( 'Format: Feature Title | Short description. One item per line.', 'paksa-it-solutions' ) ),

        // --- Modules ---
        array( 'section' => __( 'Modules / Components', 'paksa-it-solutions' ),
               'key' => 'modules_eyebrow', 'label' => __( 'Eyebrow', 'paksa-it-solutions' ), 'type' => 'text' ),
        array( 'key' => 'modules_heading', 'label' => __( 'Heading', 'paksa-it-solutions' ), 'type' => 'text' ),
        array( 'key' => 'modules_desc',    'label' => __( 'Description', 'paksa-it-solutions' ), 'type' => 'textarea' ),
        array( 'key' => 'modules_list',    'label' => __( 'Module Items (one per line: Name | Description)', 'paksa-it-solutions' ), 'type' => 'textarea',
               'hint' => __( 'Format: Module Name | Short description. One item per line.', 'paksa-it-solutions' ) ),

        // --- Benefits ---
        array( 'section' => __( 'Business Benefits', 'paksa-it-solutions' ),
               'key' => 'benefits_eyebrow', 'label' => __( 'Eyebrow', 'paksa-it-solutions' ), 'type' => 'text' ),
        array( 'key' => 'benefits_heading', 'label' => __( 'Heading', 'paksa-it-solutions' ), 'type' => 'text' ),
        array( 'key' => 'benefits_list',    'label' => __( 'Benefit Items (one per line: Title | Description)', 'paksa-it-solutions' ), 'type' => 'textarea',
               'hint' => __( 'Format: Benefit Title | Description. One item per line.', 'paksa-it-solutions' ) ),

        // --- Industries ---
        array( 'section' => __( 'Industries / Use Cases', 'paksa-it-solutions' ),
               'key' => 'industries_list', 'label' => __( 'Industries (one per line: Name | icon-key)', 'paksa-it-solutions' ), 'type' => 'textarea',
               'hint' => __( 'Format: Industry Name | icon-key. Icon keys: manufacturing, distribution, retail, ecommerce, agriculture, healthcare, hospitality, services, trading, enterprise.', 'paksa-it-solutions' ) ),

        // --- FAQ ---
        array( 'section' => __( 'FAQ', 'paksa-it-solutions' ),
               'key' => 'faq_items', 'label' => __( 'FAQ Items (one per line: Question | Answer)', 'paksa-it-solutions' ), 'type' => 'textarea',
               'hint' => __( 'Format: Question | Answer. One item per line. Leave blank to hide the FAQ section.', 'paksa-it-solutions' ) ),

        // --- CTA Override ---
        array( 'section' => __( 'CTA Override', 'paksa-it-solutions' ),
               'key' => 'cta_heading',     'label' => __( 'CTA Heading (overrides global)', 'paksa-it-solutions' ),     'type' => 'text',
               'hint' => __( 'Leave blank to use global CTA heading from Customizer.', 'paksa-it-solutions' ) ),
        array( 'key' => 'cta_description', 'label' => __( 'CTA Description (overrides global)', 'paksa-it-solutions' ), 'type' => 'textarea' ),
        array( 'key' => 'cta_btn1_text',   'label' => __( 'Primary Button Text', 'paksa-it-solutions' ),                'type' => 'text' ),
        array( 'key' => 'cta_btn1_url',    'label' => __( 'Primary Button URL', 'paksa-it-solutions' ),                 'type' => 'url' ),
        array( 'key' => 'cta_btn2_text',   'label' => __( 'Secondary Button Text', 'paksa-it-solutions' ),              'type' => 'text' ),
        array( 'key' => 'cta_btn2_url',    'label' => __( 'Secondary Button URL', 'paksa-it-solutions' ),               'type' => 'url' ),

        // --- Related Services ---
        array( 'section' => __( 'Related Services', 'paksa-it-solutions' ),
               'key' => 'related_services', 'label' => __( 'Related Services', 'paksa-it-solutions' ), 'type' => 'relationship_service',
               'hint' => __( 'Hold Ctrl/Cmd to select multiple services. These services will be shown on this product page.', 'paksa-it-solutions' ) ),

        // --- Section Visibility ---
        array( 'section' => __( 'Section Visibility', 'paksa-it-solutions' ),
               'key' => 'show_overview',   'label' => __( 'Show Overview', 'paksa-it-solutions' ),   'type' => 'select', 'options' => $vis_options ),
        array( 'key' => 'show_features',   'label' => __( 'Show Features', 'paksa-it-solutions' ),   'type' => 'select', 'options' => $vis_options ),
        array( 'key' => 'show_modules',    'label' => __( 'Show Modules', 'paksa-it-solutions' ),    'type' => 'select', 'options' => $vis_options ),
        array( 'key' => 'show_benefits',   'label' => __( 'Show Benefits', 'paksa-it-solutions' ),   'type' => 'select', 'options' => $vis_options ),
        array( 'key' => 'show_industries', 'label' => __( 'Show Industries', 'paksa-it-solutions' ), 'type' => 'select', 'options' => $vis_options ),
        array( 'key' => 'show_faq',        'label' => __( 'Show FAQ', 'paksa-it-solutions' ),        'type' => 'select', 'options' => $vis_options ),
        array( 'key' => 'show_cta',        'label' => __( 'Show CTA', 'paksa-it-solutions' ),        'type' => 'select', 'options' => $vis_options ),
    );
}

// =========================================================
// HELPER: Parse pipe-delimited textarea into structured array
// =========================================================

/**
 * Parse a textarea field where each line is "Title | Description".
 * Returns array of arrays with 'title' and 'desc' keys.
 *
 * @param  string $raw Raw textarea value.
 * @return array
 */
function paksa_parse_pipe_list( $raw ) {
    if ( empty( $raw ) ) {
        return array();
    }
    $items = array();
    $lines = array_filter( array_map( 'trim', explode( "\n", $raw ) ) );
    foreach ( $lines as $line ) {
        $parts = array_map( 'trim', explode( '|', $line, 2 ) );
        if ( ! empty( $parts[0] ) ) {
            $items[] = array(
                'title' => sanitize_text_field( $parts[0] ),
                'desc'  => isset( $parts[1] ) ? sanitize_text_field( $parts[1] ) : '',
            );
        }
    }
    return $items;
}

/**
 * Parse a textarea field where each line is "Name | icon-key".
 * Returns array of arrays with 'name' and 'icon' keys.
 *
 * @param  string $raw Raw textarea value.
 * @return array
 */
function paksa_parse_industry_list( $raw ) {
    if ( empty( $raw ) ) {
        return array();
    }
    $items = array();
    $lines = array_filter( array_map( 'trim', explode( "\n", $raw ) ) );
    foreach ( $lines as $line ) {
        $parts = array_map( 'trim', explode( '|', $line, 2 ) );
        if ( ! empty( $parts[0] ) ) {
            $items[] = array(
                'name' => sanitize_text_field( $parts[0] ),
                'icon' => isset( $parts[1] ) ? sanitize_key( $parts[1] ) : 'enterprise',
            );
        }
    }
    return $items;
}
