<?php
/**
 * Paksa IT Solutions — About & Contact Page Meta
 *
 * Registers meta boxes for page-about.php and page-contact.php templates.
 * Meta prefix: _paksa_page_
 *
 * About fields:
 *   _paksa_page_hero_eyebrow, _paksa_page_hero_heading, _paksa_page_hero_description
 *   _paksa_page_story_heading, _paksa_page_story_content
 *   _paksa_page_mission, _paksa_page_vision
 *   _paksa_page_values_list  (pipe-delimited: Title | Description)
 *   _paksa_page_cta_heading, _paksa_page_cta_description, _paksa_page_cta_btn1_text,
 *   _paksa_page_cta_btn1_url, _paksa_page_cta_btn2_text, _paksa_page_cta_btn2_url
 *   Section visibility: _paksa_page_show_story, _paksa_page_show_values, _paksa_page_show_cta
 *
 * Contact fields:
 *   _paksa_page_hero_eyebrow, _paksa_page_hero_heading, _paksa_page_hero_description
 *   _paksa_page_contact_intro
 *   _paksa_page_hours
 *   _paksa_page_cta_heading, _paksa_page_cta_description, _paksa_page_cta_btn1_text,
 *   _paksa_page_cta_btn1_url
 *   Section visibility: _paksa_page_show_map, _paksa_page_show_faq, _paksa_page_show_cta
 *
 * Global contact info (phone, email, address, WhatsApp) comes from Customizer:
 *   paksa_phone, paksa_email, paksa_address, paksa_whatsapp_url
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register meta boxes — shown only on the relevant page templates.
 */
function paksa_register_page_meta_boxes() {
    add_meta_box(
        'paksa_about_content',
        __( 'About Page Content', 'paksa-it-solutions' ),
        'paksa_render_about_meta_box',
        'page',
        'normal',
        'high'
    );
    add_meta_box(
        'paksa_contact_content',
        __( 'Contact Page Content', 'paksa-it-solutions' ),
        'paksa_render_contact_meta_box',
        'page',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'paksa_register_page_meta_boxes' );

/**
 * Conditionally remove meta boxes based on page template.
 */
function paksa_page_meta_box_conditions() {
    global $post;
    if ( ! $post ) {
        return;
    }
    $template = get_post_meta( $post->ID, '_wp_page_template', true );
    if ( $template !== 'page-about.php' ) {
        remove_meta_box( 'paksa_about_content', 'page', 'normal' );
    }
    if ( $template !== 'page-contact.php' ) {
        remove_meta_box( 'paksa_contact_content', 'page', 'normal' );
    }
}
add_action( 'add_meta_boxes', 'paksa_page_meta_box_conditions', 20 );

/**
 * Shared meta box styles (inline, admin only).
 */
function paksa_page_meta_box_styles() {
    echo '<style>
        .pk-mb-section{margin:16px 0 8px;font-weight:600;font-size:13px;color:#1d2327;border-bottom:1px solid #dcdcde;padding-bottom:6px;}
        .pk-mb-row{margin-bottom:12px;}
        .pk-mb-row label{display:block;font-size:12px;color:#50575e;margin-bottom:4px;}
        .pk-mb-row input[type=text],.pk-mb-row textarea,.pk-mb-row select{width:100%;}
        .pk-mb-row textarea{height:80px;resize:vertical;}
        .pk-mb-hint{font-size:11px;color:#8c8f94;margin-top:3px;}
    </style>';
}

/**
 * Render About meta box.
 */
function paksa_render_about_meta_box( $post ) {
    wp_nonce_field( 'paksa_about_meta_save', 'paksa_page_meta_nonce' );
    paksa_page_meta_box_styles();

    $fields          = paksa_about_meta_fields();
    $current_section = '';

    foreach ( $fields as $field ) {
        if ( isset( $field['section'] ) && $field['section'] !== $current_section ) {
            $current_section = $field['section'];
            echo '<p class="pk-mb-section">' . esc_html( $field['section'] ) . '</p>';
        }
        paksa_render_page_meta_field( $post->ID, $field );
    }
}

/**
 * Render Contact meta box.
 */
function paksa_render_contact_meta_box( $post ) {
    wp_nonce_field( 'paksa_contact_meta_save', 'paksa_page_meta_nonce' );
    paksa_page_meta_box_styles();

    $fields          = paksa_contact_meta_fields();
    $current_section = '';

    foreach ( $fields as $field ) {
        if ( isset( $field['section'] ) && $field['section'] !== $current_section ) {
            $current_section = $field['section'];
            echo '<p class="pk-mb-section">' . esc_html( $field['section'] ) . '</p>';
        }
        paksa_render_page_meta_field( $post->ID, $field );
    }
}

/**
 * Render a single meta field row.
 */
function paksa_render_page_meta_field( $post_id, $field ) {
    $meta_key = '_paksa_page_' . $field['key'];
    $value    = get_post_meta( $post_id, $meta_key, true );

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

/**
 * Save page meta box fields.
 */
function paksa_save_page_meta( $post_id ) {
    if ( ! isset( $_POST['paksa_page_meta_nonce'] ) ) {
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
    if ( $template === 'page-about.php' ) {
        if (
            ! isset( $_POST['paksa_page_meta_nonce'] ) ||
            ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['paksa_page_meta_nonce'] ) ), 'paksa_about_meta_save' )
        ) {
            return;
        }
        $fields = paksa_about_meta_fields();
    } elseif ( $template === 'page-contact.php' ) {
        if (
            ! isset( $_POST['paksa_page_meta_nonce'] ) ||
            ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['paksa_page_meta_nonce'] ) ), 'paksa_contact_meta_save' )
        ) {
            return;
        }
        $fields = paksa_contact_meta_fields();
    } else {
        return;
    }

    foreach ( $fields as $field ) {
        $meta_key = '_paksa_page_' . $field['key'];

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
add_action( 'save_post', 'paksa_save_page_meta' );

/**
 * About page meta fields.
 *
 * @return array
 */
function paksa_about_meta_fields() {
    $vis = array(
        ''  => __( 'Yes — show (default)', 'paksa-it-solutions' ),
        '0' => __( 'No — hide', 'paksa-it-solutions' ),
    );
    return array(
        array( 'section' => __( 'Hero', 'paksa-it-solutions' ),
               'key' => 'hero_eyebrow',    'label' => __( 'Eyebrow', 'paksa-it-solutions' ),    'type' => 'text' ),
        array( 'key' => 'hero_heading',    'label' => __( 'Heading', 'paksa-it-solutions' ),    'type' => 'text',
               'hint' => __( 'Defaults to page title if blank.', 'paksa-it-solutions' ) ),
        array( 'key' => 'hero_description','label' => __( 'Description', 'paksa-it-solutions' ),'type' => 'textarea' ),

        array( 'section' => __( 'Company Story', 'paksa-it-solutions' ),
               'key' => 'story_heading', 'label' => __( 'Story Heading', 'paksa-it-solutions' ), 'type' => 'text' ),
        array( 'key' => 'story_content', 'label' => __( 'Story Content (one paragraph per line)', 'paksa-it-solutions' ), 'type' => 'textarea',
               'hint' => __( 'Each line becomes a paragraph. For richer content use the block editor.', 'paksa-it-solutions' ) ),

        array( 'section' => __( 'Mission & Vision', 'paksa-it-solutions' ),
               'key' => 'mission', 'label' => __( 'Mission Statement', 'paksa-it-solutions' ), 'type' => 'textarea' ),
        array( 'key' => 'vision',  'label' => __( 'Vision Statement', 'paksa-it-solutions' ),  'type' => 'textarea' ),

        array( 'section' => __( 'Values', 'paksa-it-solutions' ),
               'key' => 'values_list', 'label' => __( 'Values (one per line: Title | Description)', 'paksa-it-solutions' ), 'type' => 'textarea',
               'hint' => __( 'Format: Value Title | Short description. One item per line.', 'paksa-it-solutions' ) ),

        array( 'section' => __( 'CTA Override', 'paksa-it-solutions' ),
               'key' => 'cta_heading',     'label' => __( 'CTA Heading (overrides global)', 'paksa-it-solutions' ),     'type' => 'text' ),
        array( 'key' => 'cta_description', 'label' => __( 'CTA Description (overrides global)', 'paksa-it-solutions' ), 'type' => 'textarea' ),
        array( 'key' => 'cta_btn1_text',   'label' => __( 'Primary Button Text', 'paksa-it-solutions' ),                'type' => 'text' ),
        array( 'key' => 'cta_btn1_url',    'label' => __( 'Primary Button URL', 'paksa-it-solutions' ),                 'type' => 'url' ),
        array( 'key' => 'cta_btn2_text',   'label' => __( 'Secondary Button Text', 'paksa-it-solutions' ),              'type' => 'text' ),
        array( 'key' => 'cta_btn2_url',    'label' => __( 'Secondary Button URL', 'paksa-it-solutions' ),               'type' => 'url' ),

        array( 'section' => __( 'Section Visibility', 'paksa-it-solutions' ),
               'key' => 'show_story',  'label' => __( 'Show Company Story', 'paksa-it-solutions' ), 'type' => 'select', 'options' => $vis ),
        array( 'key' => 'show_values', 'label' => __( 'Show Values', 'paksa-it-solutions' ),        'type' => 'select', 'options' => $vis ),
        array( 'key' => 'show_cta',    'label' => __( 'Show CTA', 'paksa-it-solutions' ),           'type' => 'select', 'options' => $vis ),
    );
}

/**
 * Contact page meta fields.
 *
 * @return array
 */
function paksa_contact_meta_fields() {
    $vis = array(
        ''  => __( 'Yes — show (default)', 'paksa-it-solutions' ),
        '0' => __( 'No — hide', 'paksa-it-solutions' ),
    );
    return array(
        array( 'section' => __( 'Hero', 'paksa-it-solutions' ),
               'key' => 'hero_eyebrow',    'label' => __( 'Eyebrow', 'paksa-it-solutions' ),    'type' => 'text' ),
        array( 'key' => 'hero_heading',    'label' => __( 'Heading', 'paksa-it-solutions' ),    'type' => 'text',
               'hint' => __( 'Defaults to page title if blank.', 'paksa-it-solutions' ) ),
        array( 'key' => 'hero_description','label' => __( 'Description', 'paksa-it-solutions' ),'type' => 'textarea' ),

        array( 'section' => __( 'Contact Details', 'paksa-it-solutions' ),
               'key' => 'contact_intro', 'label' => __( 'Intro Paragraph', 'paksa-it-solutions' ), 'type' => 'textarea',
               'hint' => __( 'Short paragraph above the contact information. Leave blank to omit.', 'paksa-it-solutions' ) ),
        array( 'key' => 'hours', 'label' => __( 'Business Hours', 'paksa-it-solutions' ), 'type' => 'text',
               'hint' => __( 'e.g. "Monday – Friday, 9am – 6pm PKT". Leave blank to omit.', 'paksa-it-solutions' ) ),

        array( 'section' => __( 'CTA Override', 'paksa-it-solutions' ),
               'key' => 'cta_heading',     'label' => __( 'CTA Heading (overrides global)', 'paksa-it-solutions' ),     'type' => 'text' ),
        array( 'key' => 'cta_description', 'label' => __( 'CTA Description (overrides global)', 'paksa-it-solutions' ), 'type' => 'textarea' ),
        array( 'key' => 'cta_btn1_text',   'label' => __( 'Primary Button Text', 'paksa-it-solutions' ),                'type' => 'text' ),
        array( 'key' => 'cta_btn1_url',    'label' => __( 'Primary Button URL', 'paksa-it-solutions' ),                 'type' => 'url' ),

        array( 'section' => __( 'Section Visibility', 'paksa-it-solutions' ),
               'key' => 'show_faq', 'label' => __( 'Show FAQ', 'paksa-it-solutions' ), 'type' => 'select', 'options' => $vis ),
        array( 'key' => 'show_cta', 'label' => __( 'Show CTA', 'paksa-it-solutions' ), 'type' => 'select', 'options' => $vis ),
    );
}

/**
 * Helper: read a page meta value.
 *
 * @param  string $key      Meta key suffix (without _paksa_page_ prefix).
 * @param  string $fallback Default value.
 * @param  int    $post_id  Post ID. Defaults to current post.
 * @return string
 */
function paksa_page_meta( $key, $fallback = '', $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $value = get_post_meta( $post_id, '_paksa_page_' . $key, true );
    return ( $value !== '' && $value !== false ) ? sanitize_text_field( $value ) : $fallback;
}

/**
 * Helper: read a page meta textarea value.
 *
 * @param  string $key      Meta key suffix.
 * @param  string $fallback Default value.
 * @param  int    $post_id  Post ID.
 * @return string
 */
function paksa_page_meta_textarea( $key, $fallback = '', $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    $value = get_post_meta( $post_id, '_paksa_page_' . $key, true );
    return ( $value !== '' && $value !== false ) ? sanitize_textarea_field( $value ) : $fallback;
}
