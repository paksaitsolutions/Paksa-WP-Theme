<?php
/**
 * Paksa IT Solutions — Service CPT Meta Helpers
 *
 * Handles all post meta for the paksa_service CPT.
 * Meta key prefix: _paksa_svc_  (shared with services page meta for consistency)
 *
 * Note on prefix sharing:
 *   The services page (page-services.php) uses _paksa_svc_* on a Page post type.
 *   This CPT uses _paksa_svc_* on paksa_service post type.
 *   There is no collision — meta is stored per post_id, not per post_type.
 *   The existing paksa_svc_meta() helpers in services-meta.php work for both
 *   because they read by post ID.
 *
 * Provides:
 *   - paksa_service_meta_fields()  Single source of truth for all fields
 *   - Meta box registration, rendering, and saving
 *
 * Relationship fields:
 *   _paksa_svc_related_products  Comma-separated paksa_product post IDs
 *   _paksa_prod_related_services Comma-separated paksa_service post IDs (on product)
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register the Service meta box on paksa_service edit screens.
 */
function paksa_register_service_meta_box() {
    add_meta_box(
        'paksa_service_content',
        __( 'Service Details', 'paksa-it-solutions' ),
        'paksa_render_service_meta_box',
        'paksa_service',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'paksa_register_service_meta_box' );

/**
 * Render the Service meta box.
 *
 * @param WP_Post $post Current post object.
 */
function paksa_render_service_meta_box( $post ) {
    wp_nonce_field( 'paksa_service_meta_save', 'paksa_service_meta_nonce' );

    $fields          = paksa_service_meta_fields();
    $current_section = '';

    echo '<style>
        .pk-mb-section{margin:16px 0 8px;font-weight:600;font-size:13px;color:#1d2327;border-bottom:1px solid #dcdcde;padding-bottom:6px;}
        .pk-mb-row{margin-bottom:12px;}
        .pk-mb-row label{display:block;font-size:12px;color:#50575e;margin-bottom:4px;}
        .pk-mb-row input[type=text],.pk-mb-row textarea,.pk-mb-row select{width:100%;}
        .pk-mb-row textarea{height:80px;resize:vertical;}
        .pk-mb-hint{font-size:11px;color:#8c8f94;margin-top:3px;}
    </style>';

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
        } elseif ( $field['type'] === 'relationship' ) {
            // Related products — multi-select from published paksa_product posts
            $products = get_posts( array(
                'post_type'      => 'paksa_product',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
            ) );
            $selected_ids = array_filter( array_map( 'absint', explode( ',', $value ) ) );
            echo '<select id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '[]" multiple style="height:120px;">';
            foreach ( $products as $product ) {
                $sel = in_array( $product->ID, $selected_ids, true ) ? ' selected' : '';
                echo '<option value="' . esc_attr( $product->ID ) . '"' . $sel . '>' . esc_html( $product->post_title ) . '</option>';
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
 * Save Service meta box fields.
 *
 * @param int $post_id Post ID being saved.
 */
function paksa_save_service_meta( $post_id ) {
    if (
        ! isset( $_POST['paksa_service_meta_nonce'] ) ||
        ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['paksa_service_meta_nonce'] ) ), 'paksa_service_meta_save' )
    ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( get_post_type( $post_id ) !== 'paksa_service' ) {
        return;
    }

    $fields = paksa_service_meta_fields();

    foreach ( $fields as $field ) {
        $meta_key = '_paksa_svc_' . $field['key'];

        if ( $field['type'] === 'relationship' ) {
            // Multi-select: save as comma-separated IDs
            $raw_ids = isset( $_POST[ $meta_key ] ) ? (array) $_POST[ $meta_key ] : array();
            $ids     = array_filter( array_map( 'absint', $raw_ids ) );
            update_post_meta( $post_id, $meta_key, implode( ',', $ids ) );
            continue;
        }

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
add_action( 'save_post_paksa_service', 'paksa_save_service_meta' );

/**
 * All service CPT meta fields.
 * Single source of truth for both rendering and saving.
 *
 * @return array
 */
function paksa_service_meta_fields() {
    $vis_options = array(
        ''  => __( 'Yes — show (default)', 'paksa-it-solutions' ),
        '0' => __( 'No — hide', 'paksa-it-solutions' ),
    );

    return array(

        // --- Identity ---
        array( 'section' => __( 'Service Identity', 'paksa-it-solutions' ),
               'key' => 'tagline',        'label' => __( 'Tagline / Positioning Statement', 'paksa-it-solutions' ), 'type' => 'text',
               'hint' => __( 'One-line description shown in cards and listings. Keep under 80 characters.', 'paksa-it-solutions' ) ),
        array( 'key' => 'category_label', 'label' => __( 'Category Label (display)', 'paksa-it-solutions' ),       'type' => 'text',
               'hint' => __( 'e.g. "Artificial Intelligence". Shown on cards. Use taxonomy for filtering.', 'paksa-it-solutions' ) ),
        array( 'key' => 'badge',          'label' => __( 'Badge Text (optional)', 'paksa-it-solutions' ),           'type' => 'text',
               'hint' => __( 'e.g. "New", "Featured". Leave blank for none.', 'paksa-it-solutions' ) ),
        array( 'key' => 'featured',       'label' => __( 'Featured Service', 'paksa-it-solutions' ),                'type' => 'select',
               'options' => array( '' => __( 'No', 'paksa-it-solutions' ), '1' => __( 'Yes — show as featured', 'paksa-it-solutions' ) ) ),

        // --- Hero ---
        array( 'section' => __( 'Hero Section', 'paksa-it-solutions' ),
               'key' => 'hero_eyebrow',     'label' => __( 'Eyebrow Label', 'paksa-it-solutions' ),      'type' => 'text' ),
        array( 'key' => 'hero_heading',     'label' => __( 'Hero Heading', 'paksa-it-solutions' ),       'type' => 'text',
               'hint' => __( 'Defaults to service title if blank.', 'paksa-it-solutions' ) ),
        array( 'key' => 'hero_description', 'label' => __( 'Hero Description', 'paksa-it-solutions' ),   'type' => 'textarea' ),
        array( 'key' => 'hero_cta1_text',   'label' => __( 'Primary CTA Text', 'paksa-it-solutions' ),   'type' => 'text' ),
        array( 'key' => 'hero_cta1_url',    'label' => __( 'Primary CTA URL', 'paksa-it-solutions' ),    'type' => 'url' ),
        array( 'key' => 'hero_cta2_text',   'label' => __( 'Secondary CTA Text', 'paksa-it-solutions' ), 'type' => 'text' ),
        array( 'key' => 'hero_cta2_url',    'label' => __( 'Secondary CTA URL', 'paksa-it-solutions' ),  'type' => 'url' ),

        // --- Overview ---
        array( 'section' => __( 'Overview Section', 'paksa-it-solutions' ),
               'key' => 'overview_eyebrow', 'label' => __( 'Eyebrow', 'paksa-it-solutions' ), 'type' => 'text' ),
        array( 'key' => 'overview_heading', 'label' => __( 'Heading', 'paksa-it-solutions' ), 'type' => 'text' ),
        array( 'key' => 'overview_content', 'label' => __( 'Content (one paragraph per line)', 'paksa-it-solutions' ), 'type' => 'textarea',
               'hint' => __( 'Each line becomes a paragraph. Use the block editor for richer content.', 'paksa-it-solutions' ) ),

        // --- Features / Capabilities ---
        array( 'section' => __( 'Key Capabilities', 'paksa-it-solutions' ),
               'key' => 'features_eyebrow', 'label' => __( 'Eyebrow', 'paksa-it-solutions' ), 'type' => 'text' ),
        array( 'key' => 'features_heading', 'label' => __( 'Heading', 'paksa-it-solutions' ), 'type' => 'text' ),
        array( 'key' => 'features_list',    'label' => __( 'Capability Items (one per line: Title | Description)', 'paksa-it-solutions' ), 'type' => 'textarea',
               'hint' => __( 'Format: Capability Title | Short description. One item per line.', 'paksa-it-solutions' ) ),

        // --- Related Products ---
        array( 'section' => __( 'Related Products', 'paksa-it-solutions' ),
               'key' => 'related_products', 'label' => __( 'Related Products', 'paksa-it-solutions' ), 'type' => 'relationship',
               'hint' => __( 'Hold Ctrl/Cmd to select multiple products. These products will be shown on this service page.', 'paksa-it-solutions' ) ),

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

        // --- Section Visibility ---
        array( 'section' => __( 'Section Visibility', 'paksa-it-solutions' ),
               'key' => 'show_overview',         'label' => __( 'Show Overview', 'paksa-it-solutions' ),         'type' => 'select', 'options' => $vis_options ),
        array( 'key' => 'show_features',         'label' => __( 'Show Capabilities', 'paksa-it-solutions' ),     'type' => 'select', 'options' => $vis_options ),
        array( 'key' => 'show_faq',              'label' => __( 'Show FAQ', 'paksa-it-solutions' ),              'type' => 'select', 'options' => $vis_options ),
        array( 'key' => 'show_related_products', 'label' => __( 'Show Related Products', 'paksa-it-solutions' ), 'type' => 'select', 'options' => $vis_options ),
        array( 'key' => 'show_cta',              'label' => __( 'Show CTA', 'paksa-it-solutions' ),              'type' => 'select', 'options' => $vis_options ),
    );
}

/**
 * Helper: get related product IDs for a service.
 *
 * @param  int $service_id Service post ID. Defaults to current post.
 * @return int[]
 */
function paksa_get_service_related_products( $service_id = 0 ) {
    if ( ! $service_id ) {
        $service_id = get_the_ID();
    }
    $raw = get_post_meta( $service_id, '_paksa_svc_related_products', true );
    if ( empty( $raw ) ) {
        return array();
    }
    return array_filter( array_map( 'absint', explode( ',', $raw ) ) );
}

/**
 * Helper: get related service IDs for a product.
 *
 * @param  int $product_id Product post ID. Defaults to current post.
 * @return int[]
 */
function paksa_get_product_related_services( $product_id = 0 ) {
    if ( ! $product_id ) {
        $product_id = get_the_ID();
    }
    $raw = get_post_meta( $product_id, '_paksa_prod_related_services', true );
    if ( empty( $raw ) ) {
        return array();
    }
    return array_filter( array_map( 'absint', explode( ',', $raw ) ) );
}
