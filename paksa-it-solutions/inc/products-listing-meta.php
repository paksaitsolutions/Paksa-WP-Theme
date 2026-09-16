<?php
/**
 * Paksa IT Solutions — Products Listing Page Meta
 *
 * Registers a meta box for pages using the "Products / Solutions" template
 * (page-products.php). Covers the _paksa_prod_listing_* fields consumed by
 * template-parts/products/hero.php.
 *
 * Meta prefix: _paksa_prod_listing_
 *
 * Fields:
 *   _paksa_prod_listing_eyebrow
 *   _paksa_prod_listing_heading
 *   _paksa_prod_listing_desc
 *   _paksa_prod_listing_cta1_text
 *   _paksa_prod_listing_cta1_url
 *   _paksa_prod_listing_cta2_text
 *   _paksa_prod_listing_cta2_url
 *   _paksa_prod_listing_show_hero
 *   _paksa_prod_listing_show_grid
 *   _paksa_prod_listing_show_industries
 *   _paksa_prod_listing_show_faq
 *   _paksa_prod_listing_show_cta
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register meta box — shown only on pages using the Products template.
 */
function paksa_register_products_listing_meta_box() {
    add_meta_box(
        'paksa_products_listing_content',
        __( 'Products Page Content', 'paksa-it-solutions' ),
        'paksa_render_products_listing_meta_box',
        'page',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'paksa_register_products_listing_meta_box' );

/**
 * Conditionally remove meta box on non-matching templates.
 */
function paksa_products_listing_meta_box_condition() {
    global $post;
    if ( ! $post ) {
        return;
    }
    $template = get_post_meta( $post->ID, '_wp_page_template', true );
    if ( $template !== 'page-products.php' ) {
        remove_meta_box( 'paksa_products_listing_content', 'page', 'normal' );
    }
}
add_action( 'add_meta_boxes', 'paksa_products_listing_meta_box_condition', 20 );

/**
 * Render the Products listing meta box.
 *
 * @param WP_Post $post Current post object.
 */
function paksa_render_products_listing_meta_box( $post ) {
    wp_nonce_field( 'paksa_prod_listing_meta_save', 'paksa_prod_listing_meta_nonce' );

    $fields          = paksa_products_listing_meta_fields();
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

        $meta_key = '_paksa_prod_listing_' . $field['key'];
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
 * Save Products listing meta box fields.
 *
 * @param int $post_id Post ID being saved.
 */
function paksa_save_products_listing_meta( $post_id ) {
    if (
        ! isset( $_POST['paksa_prod_listing_meta_nonce'] ) ||
        ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['paksa_prod_listing_meta_nonce'] ) ), 'paksa_prod_listing_meta_save' )
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
    if ( $template !== 'page-products.php' ) {
        return;
    }

    $fields = paksa_products_listing_meta_fields();

    foreach ( $fields as $field ) {
        $meta_key = '_paksa_prod_listing_' . $field['key'];

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
add_action( 'save_post', 'paksa_save_products_listing_meta' );

/**
 * Products listing page meta fields — single source of truth.
 *
 * @return array
 */
function paksa_products_listing_meta_fields() {
    $vis = array(
        ''  => __( 'Yes — show (default)', 'paksa-it-solutions' ),
        '0' => __( 'No — hide', 'paksa-it-solutions' ),
    );

    return array(
        // --- Hero ---
        array( 'section' => __( 'Hero Section', 'paksa-it-solutions' ),
               'key' => 'eyebrow',    'label' => __( 'Eyebrow Label', 'paksa-it-solutions' ),    'type' => 'text' ),
        array( 'key' => 'heading',    'label' => __( 'Heading', 'paksa-it-solutions' ),           'type' => 'text',
               'hint' => __( 'Defaults to placeholder if blank.', 'paksa-it-solutions' ) ),
        array( 'key' => 'desc',       'label' => __( 'Description', 'paksa-it-solutions' ),       'type' => 'textarea' ),
        array( 'key' => 'cta1_text',  'label' => __( 'Primary CTA Text', 'paksa-it-solutions' ),  'type' => 'text' ),
        array( 'key' => 'cta1_url',   'label' => __( 'Primary CTA URL', 'paksa-it-solutions' ),   'type' => 'url' ),
        array( 'key' => 'cta2_text',  'label' => __( 'Secondary CTA Text', 'paksa-it-solutions' ),'type' => 'text' ),
        array( 'key' => 'cta2_url',   'label' => __( 'Secondary CTA URL', 'paksa-it-solutions' ), 'type' => 'url' ),

        // --- Section Visibility ---
        array( 'section' => __( 'Section Visibility', 'paksa-it-solutions' ),
               'key' => 'show_hero',       'label' => __( 'Show Hero', 'paksa-it-solutions' ),       'type' => 'select', 'options' => $vis ),
        array( 'key' => 'show_grid',       'label' => __( 'Show Product Grid', 'paksa-it-solutions' ),'type' => 'select', 'options' => $vis ),
        array( 'key' => 'show_industries', 'label' => __( 'Show Industries', 'paksa-it-solutions' ), 'type' => 'select', 'options' => $vis ),
        array( 'key' => 'show_faq',        'label' => __( 'Show FAQ', 'paksa-it-solutions' ),        'type' => 'select', 'options' => $vis ),
        array( 'key' => 'show_cta',        'label' => __( 'Show CTA', 'paksa-it-solutions' ),        'type' => 'select', 'options' => $vis ),
    );
}
