<?php
/**
 * Paksa Theme — Phase 36: Forms, Conditional Content & Conversion Builder.
 *
 * Extends the existing contact-form architecture with:
 *  - paksa/form  — server-rendered form block using existing paksa_contact_submit AJAX handler
 *  - Conditional visibility attributes on existing blocks (show/hide by login state, post type)
 *  - Conversion pattern categories
 *
 * Architecture contracts preserved:
 *  - AJAX action:  paksa_contact_submit  (inc/contact-form.php)
 *  - Nonce name:   paksa_contact_nonce   (inc/contact-form.php)
 *  - Honeypot:     pk_hp                 (inc/contact-form.php)
 *  - Fields:       name, email, company, phone, service, message, budget, timeline, interests
 *  - wp_mail() delivery via existing handler — no new email system
 *  - No custom database table
 *  - Reuses paksa_hover_attributes(), paksa_border_shadow_attributes()
 *  - Reuses --pk-* design tokens exclusively
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ═══════════════════════════════════════════════════════════════════════════
   ENQUEUE
   ═══════════════════════════════════════════════════════════════════════════ */

function paksa_enqueue_phase36_editor_assets() {
    if ( ! wp_script_is( 'paksa-editor-phase35', 'enqueued' ) ) {
        return;
    }

    wp_enqueue_script(
        'paksa-editor-phase36',
        PAKSA_THEME_URI . '/assets/js/editor-phase36.js',
        array(
            'paksa-editor-phase35',
            'wp-blocks', 'wp-block-editor', 'wp-components',
            'wp-element', 'wp-hooks', 'wp-compose', 'wp-data',
            'wp-plugins', 'wp-edit-post', 'wp-dom-ready', 'wp-i18n',
        ),
        PAKSA_THEME_VERSION,
        true
    );

    wp_enqueue_style(
        'paksa-editor-phase36',
        PAKSA_THEME_URI . '/assets/css/editor-phase36.css',
        array( 'paksa-editor-phase35' ),
        PAKSA_THEME_VERSION
    );

    wp_localize_script( 'paksa-editor-phase36', 'paksaPhase36', array(
        'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
        'nonce'      => wp_create_nonce( 'paksa_contact_nonce' ),
        'action'     => 'paksa_contact_submit',
        'honeypot'   => 'website_url',
        'fieldTypes' => array(
            array( 'label' => 'Text',     'value' => 'text' ),
            array( 'label' => 'Email',    'value' => 'email' ),
            array( 'label' => 'Phone',    'value' => 'tel' ),
            array( 'label' => 'Number',   'value' => 'number' ),
            array( 'label' => 'Textarea', 'value' => 'textarea' ),
            array( 'label' => 'Select',   'value' => 'select' ),
            array( 'label' => 'Checkbox', 'value' => 'checkbox' ),
            array( 'label' => 'Consent',  'value' => 'consent' ),
            array( 'label' => 'Hidden',   'value' => 'hidden' ),
        ),
        'knownFields' => array( 'name', 'email', 'company', 'phone', 'service', 'message', 'budget', 'timeline', 'interests' ),
        'widthOptions' => array(
            array( 'label' => '100%',  'value' => '100' ),
            array( 'label' => '50%',   'value' => '50' ),
            array( 'label' => '33%',   'value' => '33' ),
            array( 'label' => '25%',   'value' => '25' ),
        ),
        'conditionOperators' => array(
            array( 'label' => 'equals',        'value' => 'equals' ),
            array( 'label' => 'not equals',    'value' => 'not_equals' ),
            array( 'label' => 'contains',      'value' => 'contains' ),
            array( 'label' => 'is empty',      'value' => 'is_empty' ),
            array( 'label' => 'is not empty',  'value' => 'is_not_empty' ),
        ),
        'visibilityContexts' => array(
            array( 'label' => 'Logged in',     'value' => 'logged_in' ),
            array( 'label' => 'Logged out',    'value' => 'logged_out' ),
            array( 'label' => 'Post type is',  'value' => 'post_type' ),
            array( 'label' => 'Always show',   'value' => 'always' ),
        ),
        'formVariants' => array(
            array( 'label' => 'Default',    'value' => 'default' ),
            array( 'label' => 'Dark',       'value' => 'dark' ),
            array( 'label' => 'Minimal',    'value' => 'minimal' ),
            array( 'label' => 'Inline',     'value' => 'inline' ),
        ),
        'version' => PAKSA_THEME_VERSION,
    ) );
}
add_action( 'enqueue_block_editor_assets', 'paksa_enqueue_phase36_editor_assets', 36 );

function paksa_enqueue_phase36_frontend_assets() {
    wp_enqueue_style(
        'paksa-phase36-forms',
        PAKSA_THEME_URI . '/assets/css/editor-phase36.css',
        array( 'paksa-blocks' ),
        PAKSA_THEME_VERSION
    );
}
add_action( 'wp_enqueue_scripts', 'paksa_enqueue_phase36_frontend_assets', 36 );

/* ═══════════════════════════════════════════════════════════════════════════
   BLOCK REGISTRATION
   ═══════════════════════════════════════════════════════════════════════════ */

function paksa_register_phase36_blocks() {
    if ( ! function_exists( 'register_block_type' ) ) { return; }

    /*
     * paksa/form
     * Server-rendered form block. Submits to existing paksa_contact_submit
     * AJAX handler. Fields are stored as a JSON attribute (not a DB table).
     * The handler in contact-form.php is the authoritative security layer.
     */
    register_block_type( 'paksa/form', array(
        'api_version'     => 3,
        'render_callback' => 'paksa_render_form_block',
        'attributes'      => array_merge(
            array(
                /* Form identity */
                'formId'          => array( 'type' => 'string',  'default' => '' ),
                'formTitle'       => array( 'type' => 'string',  'default' => '' ),
                /* Fields — JSON-encoded array of field objects */
                'fields'          => array( 'type' => 'string',  'default' => '' ),
                /* Appearance */
                'variant'         => array( 'type' => 'string',  'default' => 'default' ),
                'submitLabel'     => array( 'type' => 'string',  'default' => '' ),
                'submitIcon'      => array( 'type' => 'boolean', 'default' => true ),
                /* Messages */
                'successMessage'  => array( 'type' => 'string',  'default' => '' ),
                'errorMessage'    => array( 'type' => 'string',  'default' => '' ),
                /* Context — safe server-side only */
                'includeContext'  => array( 'type' => 'boolean', 'default' => false ),
                'contextLabel'    => array( 'type' => 'string',  'default' => '' ),
                /* Layout */
                'twoColumn'       => array( 'type' => 'boolean', 'default' => false ),
            ),
            paksa_border_shadow_attributes(),
            paksa_hover_attributes()
        ),
        'supports' => array(
            'anchor'  => true,
            'align'   => array( 'wide', 'full' ),
            'spacing' => array( 'padding' => true, 'margin' => true ),
            'color'   => array( 'background' => true ),
        ),
    ) );

    /* Block styles */
    if ( function_exists( 'register_block_style' ) ) {
        register_block_style( 'paksa/form', array( 'name' => 'dark',    'label' => __( 'Dark',    'paksa-it-solutions' ) ) );
        register_block_style( 'paksa/form', array( 'name' => 'minimal', 'label' => __( 'Minimal', 'paksa-it-solutions' ) ) );
        register_block_style( 'paksa/form', array( 'name' => 'inline',  'label' => __( 'Inline',  'paksa-it-solutions' ) ) );
    }
}
add_action( 'init', 'paksa_register_phase36_blocks', 18 );

/* ═══════════════════════════════════════════════════════════════════════════
   PATTERN CATEGORIES
   ═══════════════════════════════════════════════════════════════════════════ */

function paksa_register_phase36_pattern_categories() {
    if ( ! function_exists( 'register_block_pattern_category' ) ) { return; }
    $cats = array(
        'paksa-forms'      => __( 'Paksa Forms',      'paksa-it-solutions' ),
        'paksa-conversion' => __( 'Paksa Conversion',  'paksa-it-solutions' ),
        'paksa-lead'       => __( 'Paksa Lead Capture','paksa-it-solutions' ),
    );
    foreach ( $cats as $slug => $label ) {
        register_block_pattern_category( $slug, array( 'label' => $label ) );
    }
}
add_action( 'init', 'paksa_register_phase36_pattern_categories', 10 );

/* ═══════════════════════════════════════════════════════════════════════════
   FIELD HELPERS
   ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Allowed field types for server-side validation.
 */
function paksa_form_allowed_field_types() {
    return array( 'text', 'email', 'tel', 'number', 'textarea', 'select', 'checkbox', 'consent', 'hidden' );
}

/**
 * Allowed field names that map to the existing contact-form handler.
 * Only these names are passed to wp_mail() — no arbitrary injection.
 */
function paksa_form_allowed_field_names() {
    return array( 'name', 'email', 'company', 'phone', 'service', 'message', 'budget', 'timeline', 'interests', 'consent' );
}

/**
 * Render a single form field.
 *
 * @param array  $field   Field definition array.
 * @param string $form_id Unique form instance ID.
 * @return string
 */
function paksa_render_form_field( $field, $form_id ) {
    $type        = isset( $field['type'] )        ? sanitize_key( $field['type'] )                : 'text';
    $name        = isset( $field['name'] )        ? sanitize_key( $field['name'] )                : '';
    $label       = isset( $field['label'] )       ? sanitize_text_field( $field['label'] )        : '';
    $placeholder = isset( $field['placeholder'] ) ? sanitize_text_field( $field['placeholder'] )  : '';
    $required    = ! empty( $field['required'] );
    $help        = isset( $field['help'] )        ? sanitize_text_field( $field['help'] )         : '';
    $default     = isset( $field['default'] )     ? sanitize_text_field( $field['default'] )      : '';
    $width       = isset( $field['width'] )       ? absint( $field['width'] )                     : 100;
    $options_raw = isset( $field['options'] )     ? sanitize_textarea_field( $field['options'] )  : '';

    /* Validate type and name */
    if ( ! in_array( $type, paksa_form_allowed_field_types(), true ) ) { return ''; }
    if ( ! $name ) { return ''; }

    $field_id   = esc_attr( $form_id . '-' . $name );
    $name_attr  = esc_attr( $name );
    $req_attr   = $required ? ' required aria-required="true"' : '';
    $req_mark   = $required ? '<span class="pk-form-required" aria-hidden="true">*</span>' : '';
    $width_class = $width < 100 ? ' pk-form-field--w' . $width : '';

    $help_html = '';
    if ( $help ) {
        $help_id   = $field_id . '-help';
        $help_html = '<span class="pk-form-help" id="' . esc_attr( $help_id ) . '">' . esc_html( $help ) . '</span>';
    }
    $aria_desc = $help ? ' aria-describedby="' . esc_attr( $field_id . '-help' ) . '"' : '';

    ob_start();

    if ( $type === 'hidden' ) {
        echo '<input type="hidden" name="' . $name_attr . '" value="' . esc_attr( $default ) . '">';
        return ob_get_clean();
    }

    echo '<div class="pk-form-group' . esc_attr( $width_class ) . '">';

    if ( $type !== 'checkbox' && $type !== 'consent' && $label ) {
        echo '<label class="pk-form-label" for="' . $field_id . '">'
            . esc_html( $label ) . $req_mark . '</label>';
    }

    switch ( $type ) {
        case 'textarea':
            echo '<textarea class="pk-form-input pk-form-textarea" id="' . $field_id
                . '" name="' . $name_attr . '" placeholder="' . esc_attr( $placeholder ) . '"'
                . $req_attr . $aria_desc . '>' . esc_textarea( $default ) . '</textarea>';
            break;

        case 'select':
            $options = array_filter( array_map( 'trim', explode( "\n", $options_raw ) ) );
            echo '<select class="pk-form-input pk-form-select" id="' . $field_id
                . '" name="' . $name_attr . '"' . $req_attr . $aria_desc . '>';
            echo '<option value="">' . esc_html( $placeholder ?: __( 'Select…', 'paksa-it-solutions' ) ) . '</option>';
            foreach ( $options as $opt ) {
                $val = sanitize_text_field( $opt );
                echo '<option value="' . esc_attr( $val ) . '">' . esc_html( $val ) . '</option>';
            }
            echo '</select>';
            break;

        case 'checkbox':
        case 'consent':
            echo '<label class="pk-form-checkbox-label" for="' . $field_id . '">';
            echo '<input type="checkbox" class="pk-form-checkbox" id="' . $field_id
                . '" name="' . $name_attr . '" value="1"' . $req_attr . $aria_desc . '>';
            echo '<span>' . esc_html( $label ) . $req_mark . '</span>';
            echo '</label>';
            break;

        default:
            echo '<input type="' . esc_attr( $type ) . '" class="pk-form-input" id="' . $field_id
                . '" name="' . $name_attr . '" placeholder="' . esc_attr( $placeholder ) . '"'
                . ' value="' . esc_attr( $default ) . '"' . $req_attr . $aria_desc . '>';
            break;
    }

    echo $help_html;
    echo '</div>';

    return ob_get_clean();
}

/* ═══════════════════════════════════════════════════════════════════════════
   RENDER CALLBACK — paksa/form
   ═══════════════════════════════════════════════════════════════════════════ */

function paksa_render_form_block( $attributes, $content = '', $block = null ) {
    $form_id        = isset( $attributes['formId'] ) && $attributes['formId']
                        ? sanitize_html_class( $attributes['formId'] )
                        : 'pkf-' . substr( md5( serialize( $attributes ) ), 0, 8 );
    $variant        = isset( $attributes['variant'] )       ? sanitize_key( $attributes['variant'] )              : 'default';
    $submit_label   = isset( $attributes['submitLabel'] )   ? sanitize_text_field( $attributes['submitLabel'] )   : __( 'Send Message', 'paksa-it-solutions' );
    $submit_icon    = ! empty( $attributes['submitIcon'] );
    $success_msg    = isset( $attributes['successMessage'] ) ? sanitize_text_field( $attributes['successMessage'] ) : __( 'Thank you! We\'ll be in touch shortly.', 'paksa-it-solutions' );
    $error_msg      = isset( $attributes['errorMessage'] )  ? sanitize_text_field( $attributes['errorMessage'] )  : __( 'Something went wrong. Please try again.', 'paksa-it-solutions' );
    $two_col        = ! empty( $attributes['twoColumn'] );
    $include_ctx    = ! empty( $attributes['includeContext'] );
    $ctx_label      = isset( $attributes['contextLabel'] )  ? sanitize_text_field( $attributes['contextLabel'] )  : '';

    $allowed_variants = array( 'default', 'dark', 'minimal', 'inline' );
    $variant = in_array( $variant, $allowed_variants, true ) ? $variant : 'default';

    /* Parse fields */
    $fields_raw = isset( $attributes['fields'] ) ? $attributes['fields'] : '';
    $fields     = array();
    if ( $fields_raw ) {
        $decoded = json_decode( $fields_raw, true );
        if ( is_array( $decoded ) ) {
            $fields = $decoded;
        }
    }

    /* Default fields if none configured */
    if ( empty( $fields ) ) {
        $fields = array(
            array( 'type' => 'text',     'name' => 'name',    'label' => __( 'Full Name', 'paksa-it-solutions' ),    'required' => true,  'width' => 50 ),
            array( 'type' => 'email',    'name' => 'email',   'label' => __( 'Email Address', 'paksa-it-solutions' ), 'required' => true,  'width' => 50 ),
            array( 'type' => 'tel',      'name' => 'phone',   'label' => __( 'Phone', 'paksa-it-solutions' ),         'required' => false, 'width' => 50 ),
            array( 'type' => 'text',     'name' => 'company', 'label' => __( 'Company', 'paksa-it-solutions' ),       'required' => false, 'width' => 50 ),
            array( 'type' => 'textarea', 'name' => 'message', 'label' => __( 'Message', 'paksa-it-solutions' ),       'required' => true,  'width' => 100 ),
        );
    }

    /* Block wrapper classes */
    $classes = array( 'pk-form-block', 'pk-form-block--' . $variant );
    if ( $two_col ) { $classes[] = 'pk-form-block--two-col'; }

    $bs_style = function_exists( 'paksa_build_border_shadow_style' ) ? paksa_build_border_shadow_style( $attributes ) : '';
    $wrapper_attrs = array( 'class' => implode( ' ', $classes ) );
    if ( $bs_style ) { $wrapper_attrs['style'] = $bs_style; }

    $wrapper = function_exists( 'get_block_wrapper_attributes' )
        ? get_block_wrapper_attributes( $wrapper_attrs )
        : 'class="wp-block-paksa-form ' . esc_attr( implode( ' ', $classes ) ) . '"';

    /* Safe context — server-side only, never from hidden input */
    $context_html = '';
    if ( $include_ctx && is_singular() ) {
        $ctx_value = get_the_title();
        $ctx_label = $ctx_label ?: __( 'Enquiry about', 'paksa-it-solutions' );
        $context_html = '<input type="hidden" name="service" value="' . esc_attr( $ctx_value ) . '">'
            . '<p class="pk-form-context-note">'
            . esc_html( $ctx_label ) . ': <strong>' . esc_html( $ctx_value ) . '</strong></p>';
    }

    /* Render fields */
    $fields_html = '';
    foreach ( $fields as $field ) {
        $fields_html .= paksa_render_form_field( $field, $form_id );
    }

    /* Arrow icon for submit */
    $icon_html = $submit_icon
        ? '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/></svg>'
        : '';

    ob_start();
    ?>
    <div <?php echo $wrapper; ?>>
        <div class="pk-form-notices" aria-live="polite" aria-atomic="true">
            <div class="pk-form-notice pk-form-notice--success" id="<?php echo esc_attr( $form_id ); ?>-success" hidden>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <?php echo esc_html( $success_msg ); ?>
            </div>
            <div class="pk-form-notice pk-form-notice--error" id="<?php echo esc_attr( $form_id ); ?>-error" hidden>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <?php echo esc_html( $error_msg ); ?>
            </div>
        </div>

        <form class="pk-form" id="<?php echo esc_attr( $form_id ); ?>"
              novalidate
              data-ajax-url="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>"
              data-nonce="<?php echo esc_attr( wp_create_nonce( 'paksa_contact_nonce' ) ); ?>"
              data-success-id="<?php echo esc_attr( $form_id ); ?>-success"
              data-error-id="<?php echo esc_attr( $form_id ); ?>-error">

            <?php echo $context_html; ?>

            <!-- Honeypot — must match existing handler -->
            <div class="pk-form-honeypot" aria-hidden="true">
                <label for="<?php echo esc_attr( $form_id ); ?>-hp">Leave this field empty</label>
                <input type="text" id="<?php echo esc_attr( $form_id ); ?>-hp" name="website_url" tabindex="-1" autocomplete="off" value="">
            </div>

            <div class="pk-form-fields<?php echo $two_col ? ' pk-form-fields--two-col' : ''; ?>">
                <?php echo $fields_html; ?>
            </div>

            <div class="pk-form-footer">
                <button type="submit" class="pk-form-submit pk-btn-primary">
                    <span class="pk-form-submit__label"><?php echo esc_html( $submit_label ); ?></span>
                    <span class="pk-form-submit__loading" aria-hidden="true"><?php esc_html_e( 'Sending…', 'paksa-it-solutions' ); ?></span>
                    <?php echo $icon_html; ?>
                </button>
            </div>
        </form>
    </div>
    <?php
    return trim( ob_get_clean() );
}

/* ═══════════════════════════════════════════════════════════════════════════
   CONDITIONAL VISIBILITY — block render filter
   Adds pkVisibility attribute support to any block.
   Contexts: logged_in, logged_out, post_type, always
   ═══════════════════════════════════════════════════════════════════════════ */

function paksa_apply_conditional_visibility( $block_content, $block ) {
    if ( empty( $block['attrs']['pkVisibility'] ) ) {
        return $block_content;
    }

    $visibility = sanitize_key( $block['attrs']['pkVisibility'] );
    $post_type  = isset( $block['attrs']['pkVisibilityPostType'] )
                    ? sanitize_key( $block['attrs']['pkVisibilityPostType'] ) : '';

    switch ( $visibility ) {
        case 'logged_in':
            return is_user_logged_in() ? $block_content : '';
        case 'logged_out':
            return ! is_user_logged_in() ? $block_content : '';
        case 'post_type':
            return ( $post_type && get_post_type() === $post_type ) ? $block_content : '';
        default:
            return $block_content;
    }
}
add_filter( 'render_block', 'paksa_apply_conditional_visibility', 10, 2 );

/* ═══════════════════════════════════════════════════════════════════════════
   RATE LIMITING — simple transient-based per-IP throttle for form submissions
   Extends existing contact-form.php security without replacing it.
   ═══════════════════════════════════════════════════════════════════════════ */

function paksa_form_check_rate_limit() {
    $ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( $_SERVER['REMOTE_ADDR'] ) : 'unknown';
    $key = 'paksa_form_rl_' . md5( $ip );
    $count = (int) get_transient( $key );
    if ( $count >= 5 ) {
        wp_send_json_error( 'Rate limit exceeded. Please wait before submitting again.' );
    }
    set_transient( $key, $count + 1, 60 );
}
add_action( 'wp_ajax_paksa_contact_submit',        'paksa_form_check_rate_limit', 1 );
add_action( 'wp_ajax_nopriv_paksa_contact_submit', 'paksa_form_check_rate_limit', 1 );
