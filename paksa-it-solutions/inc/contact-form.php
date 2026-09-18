<?php
/**
 * Paksa IT Solutions — Contact Form AJAX Handler
 * @package paksa-it-solutions
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function paksa_handle_contact_submit() {
    if ( ! check_ajax_referer( 'paksa_contact_nonce', 'nonce', false ) ) {
        wp_send_json_error( 'Invalid nonce' );
    }

    /* Honeypot */
    if ( ! empty( $_POST['pk_hp'] ) ) {
        wp_send_json_success(); /* Silent discard */
    }

    $name     = sanitize_text_field( $_POST['name']     ?? '' );
    $email    = sanitize_email(      $_POST['email']    ?? '' );
    $company  = sanitize_text_field( $_POST['company']  ?? '' );
    $phone    = sanitize_text_field( $_POST['phone']    ?? '' );
    $service  = sanitize_text_field( $_POST['service']  ?? '' );
    $message  = sanitize_textarea_field( $_POST['message']  ?? '' );
    $budget   = sanitize_text_field( $_POST['budget']   ?? '' );
    $timeline = sanitize_text_field( $_POST['timeline'] ?? '' );
    $interests= sanitize_text_field( $_POST['interests']?? '' );

    if ( ! $name || ! is_email( $email ) || ! $message ) {
        wp_send_json_error( 'Required fields missing' );
    }

    $to      = 'info@paksa.com.pk';
    $subject = '[Paksa Website] New Enquiry from ' . $name;

    $body  = "Name: {$name}\n";
    $body .= "Email: {$email}\n";
    if ( $company )   $body .= "Company: {$company}\n";
    if ( $phone )     $body .= "Phone: {$phone}\n";
    if ( $service )   $body .= "Service: {$service}\n";
    if ( $interests ) $body .= "Interests: {$interests}\n";
    if ( $budget )    $body .= "Budget: \${$budget}\n";
    if ( $timeline )  $body .= "Timeline: {$timeline}\n";
    $body .= "\nMessage:\n{$message}\n";
    $body .= "\n---\nSent from: " . get_site_url();

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        wp_send_json_success();
    } else {
        wp_send_json_error( 'Mail failed' );
    }
}
add_action( 'wp_ajax_paksa_contact_submit',        'paksa_handle_contact_submit' );
add_action( 'wp_ajax_nopriv_paksa_contact_submit', 'paksa_handle_contact_submit' );
