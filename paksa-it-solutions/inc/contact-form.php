<?php
/**
 * Nexus Business Theme — Contact Form
 *
 * Provides a theme-native contact form with no third-party dependencies.
 *
 * Architecture:
 *   - Rendering:   do_action('paksa_contact_form') in template-parts/contact/info.php
 *   - Submission:  admin-post.php action 'paksa_contact_submit' (works without JS)
 *   - Recipient:   paksa_email Customizer setting (Global Site Settings → Contact Information)
 *   - Security:    nonce, honeypot field, request method check, input sanitization
 *   - Feedback:    redirect with query arg; message rendered in form template
 *
 * No submissions are stored in the database.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Hook the form renderer into the paksa_contact_form action.
 * Priority 10 — plugins/child themes can unhook and replace.
 */
add_action( 'paksa_contact_form', 'paksa_render_contact_form' );

/**
 * Render the contact form HTML.
 * Reads submission status from query args set after redirect.
 */
function paksa_render_contact_form() {
    $status  = isset( $_GET['contact'] ) ? sanitize_key( $_GET['contact'] ) : '';
    $form_id = 'pk-contact-form';
    ?>
    <?php if ( $status === 'success' ) : ?>
        <div class="pk-form-notice pk-form-notice--success" role="alert" aria-live="polite">
            <p><?php esc_html_e( 'Thank you — your message has been sent. We will be in touch shortly.', 'paksa-it-solutions' ); ?></p>
        </div>
    <?php elseif ( $status === 'error' ) : ?>
        <div class="pk-form-notice pk-form-notice--error" role="alert" aria-live="polite">
            <p><?php esc_html_e( 'There was a problem sending your message. Please check the fields below and try again.', 'paksa-it-solutions' ); ?></p>
        </div>
    <?php elseif ( $status === 'mail-error' ) : ?>
        <div class="pk-form-notice pk-form-notice--error" role="alert" aria-live="polite">
            <p><?php esc_html_e( 'Your message could not be delivered. Please contact us directly by email or phone.', 'paksa-it-solutions' ); ?></p>
        </div>
    <?php elseif ( $status === 'spam' ) : ?>
        <div class="pk-form-notice pk-form-notice--error" role="alert" aria-live="polite">
            <p><?php esc_html_e( 'Your submission could not be processed. Please try again.', 'paksa-it-solutions' ); ?></p>
        </div>
    <?php endif; ?>

    <?php if ( $status !== 'success' ) : ?>
    <form
        id="<?php echo esc_attr( $form_id ); ?>"
        class="pk-contact-form"
        method="post"
        action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
        novalidate
    >
        <input type="hidden" name="action" value="paksa_contact_submit">
        <?php wp_nonce_field( 'paksa_contact_submit', 'paksa_contact_nonce' ); ?>

        <!-- Honeypot — hidden from real users, filled by bots -->
        <div class="pk-form-honeypot" aria-hidden="true" style="display:none !important; visibility:hidden; position:absolute; left:-9999px;">
            <label for="pk_website"><?php esc_html_e( 'Website (leave blank)', 'paksa-it-solutions' ); ?></label>
            <input type="text" id="pk_website" name="pk_website" tabindex="-1" autocomplete="off">
        </div>

        <div class="pk-form-group">
            <label class="pk-form-label" for="pk_name">
                <?php esc_html_e( 'Full Name', 'paksa-it-solutions' ); ?>
                <span class="pk-form-required" aria-hidden="true">*</span>
            </label>
            <input
                type="text"
                id="pk_name"
                name="pk_name"
                class="pk-form-input"
                required
                autocomplete="name"
                maxlength="100"
                value="<?php echo esc_attr( isset( $_GET['pk_name'] ) ? sanitize_text_field( wp_unslash( $_GET['pk_name'] ) ) : '' ); ?>"
                aria-required="true"
            >
        </div>

        <div class="pk-form-group">
            <label class="pk-form-label" for="pk_email">
                <?php esc_html_e( 'Email Address', 'paksa-it-solutions' ); ?>
                <span class="pk-form-required" aria-hidden="true">*</span>
            </label>
            <input
                type="email"
                id="pk_email"
                name="pk_email"
                class="pk-form-input"
                required
                autocomplete="email"
                maxlength="254"
                value="<?php echo esc_attr( isset( $_GET['pk_email'] ) ? sanitize_email( wp_unslash( $_GET['pk_email'] ) ) : '' ); ?>"
                aria-required="true"
            >
        </div>

        <div class="pk-form-group">
            <label class="pk-form-label" for="pk_subject">
                <?php esc_html_e( 'Subject', 'paksa-it-solutions' ); ?>
                <span class="pk-form-required" aria-hidden="true">*</span>
            </label>
            <input
                type="text"
                id="pk_subject"
                name="pk_subject"
                class="pk-form-input"
                required
                maxlength="200"
                value="<?php echo esc_attr( isset( $_GET['pk_subject'] ) ? sanitize_text_field( wp_unslash( $_GET['pk_subject'] ) ) : '' ); ?>"
                aria-required="true"
            >
        </div>

        <div class="pk-form-group">
            <label class="pk-form-label" for="pk_message">
                <?php esc_html_e( 'Message', 'paksa-it-solutions' ); ?>
                <span class="pk-form-required" aria-hidden="true">*</span>
            </label>
            <textarea
                id="pk_message"
                name="pk_message"
                class="pk-form-input pk-form-textarea"
                required
                rows="6"
                maxlength="5000"
                aria-required="true"
            ></textarea>
        </div>

        <p class="pk-form-required-note">
            <span aria-hidden="true">*</span> <?php esc_html_e( 'Required fields', 'paksa-it-solutions' ); ?>
        </p>

        <button type="submit" class="btn btn-primary pk-form-submit">
            <?php esc_html_e( 'Send Message', 'paksa-it-solutions' ); ?>
        </button>
    </form>
    <?php endif; ?>
    <?php
}

/**
 * Process the contact form submission.
 * Hooked to admin-post.php action 'paksa_contact_submit'.
 * Works for both logged-in and non-logged-in users.
 */
function paksa_process_contact_form() {
    // Verify nonce
    if (
        ! isset( $_POST['paksa_contact_nonce'] ) ||
        ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['paksa_contact_nonce'] ) ), 'paksa_contact_submit' )
    ) {
        paksa_contact_redirect( 'error' );
        return;
    }

    // Method check
    if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
        paksa_contact_redirect( 'error' );
        return;
    }

    // Honeypot check — bots fill this field, humans don't
    if ( ! empty( $_POST['pk_website'] ) ) {
        paksa_contact_redirect( 'spam' );
        return;
    }

    // Sanitize inputs
    $name    = isset( $_POST['pk_name'] )    ? sanitize_text_field( wp_unslash( $_POST['pk_name'] ) )    : '';
    $email   = isset( $_POST['pk_email'] )   ? sanitize_email( wp_unslash( $_POST['pk_email'] ) )        : '';
    $subject = isset( $_POST['pk_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['pk_subject'] ) ) : '';
    $message = isset( $_POST['pk_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['pk_message'] ) ) : '';

    // Validate required fields
    if ( empty( $name ) || empty( $email ) || empty( $subject ) || empty( $message ) ) {
        paksa_contact_redirect( 'error' );
        return;
    }

    // Validate email format
    if ( ! is_email( $email ) ) {
        paksa_contact_redirect( 'error' );
        return;
    }

    // Enforce length limits
    if ( strlen( $name ) > 100 || strlen( $subject ) > 200 || strlen( $message ) > 5000 ) {
        paksa_contact_redirect( 'error' );
        return;
    }

    // Recipient — from Customizer, falls back to admin email
    $recipient = paksa_get_option( 'paksa_email', '' );
    if ( empty( $recipient ) || ! is_email( $recipient ) ) {
        $recipient = get_option( 'admin_email' );
    }

    // Build email
    $site_name    = get_bloginfo( 'name', 'display' );
    $mail_subject = sprintf(
        /* translators: 1: site name, 2: subject from form */
        __( '[%1$s] %2$s', 'paksa-it-solutions' ),
        $site_name,
        $subject
    );

    $mail_body  = sprintf( __( 'Name: %s', 'paksa-it-solutions' ), $name ) . "\n";
    $mail_body .= sprintf( __( 'Email: %s', 'paksa-it-solutions' ), $email ) . "\n\n";
    $mail_body .= sprintf( __( 'Message:', 'paksa-it-solutions' ) ) . "\n" . $message . "\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        sprintf( 'Reply-To: %s <%s>', $name, $email ),
    );

    $sent = wp_mail( $recipient, $mail_subject, $mail_body, $headers );

    if ( $sent ) {
        paksa_contact_redirect( 'success' );
    } else {
        paksa_contact_redirect( 'mail-error' );
    }
}
add_action( 'admin_post_paksa_contact_submit',        'paksa_process_contact_form' );
add_action( 'admin_post_nopriv_paksa_contact_submit', 'paksa_process_contact_form' );

/**
 * Redirect back to the referring page with a status query arg.
 * Falls back to home URL if no referer is available.
 *
 * @param string $status One of: success, error, mail-error, spam.
 */
function paksa_contact_redirect( $status ) {
    $referer = wp_get_referer();
    if ( ! $referer ) {
        $referer = home_url( '/' );
    }
    // Strip any existing contact query arg before adding the new one
    $referer = remove_query_arg( array( 'contact', 'pk_name', 'pk_email', 'pk_subject' ), $referer );
    $redirect = add_query_arg( 'contact', $status, $referer );
    wp_safe_redirect( $redirect );
    exit;
}
