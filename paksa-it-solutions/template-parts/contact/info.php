<?php
/**
 * Paksa IT Solutions — Contact: Information
 *
 * Displays contact information from global Customizer settings.
 * Page-specific intro and hours from post meta.
 *
 * Global data sources (Customizer — Global Site Settings > Contact Information):
 *   paksa_phone, paksa_email, paksa_address, paksa_whatsapp_url
 *
 * Page-specific data (post meta):
 *   _paksa_page_contact_intro, _paksa_page_hours
 *
 * Form area: presentation layer only.
 * Form processing requires a separate plugin or future implementation.
 * See SNAPSHOT.md — Known Limitations for details.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID();
$intro   = paksa_page_meta_textarea( 'contact_intro', '', $page_id );
$hours   = paksa_page_meta( 'hours', '', $page_id );

// Global contact data from Customizer
$phone     = paksa_get_option( 'paksa_phone', '' );
$email     = paksa_get_option( 'paksa_email', '' );
$address   = paksa_get_option( 'paksa_address', '' );
$whatsapp  = paksa_get_option( 'paksa_whatsapp_url', '' );
?>
<section class="section pk-contact-info-section" aria-labelledby="pk-contact-info-heading">
    <div class="container">
        <h2 id="pk-contact-info-heading" class="screen-reader-text">
            <?php esc_html_e( 'Contact Information', 'paksa-it-solutions' ); ?>
        </h2>

        <?php if ( $intro ) : ?>
            <p class="body-large" style="max-width: 600px; margin-bottom: var(--pk-space-10);">
                <?php echo esc_html( $intro ); ?>
            </p>
        <?php endif; ?>

        <div class="pk-contact-layout">

            <!-- Contact information -->
            <div>
                <ul class="pk-contact-info-list" role="list">

                    <?php if ( $phone ) : ?>
                        <li class="pk-contact-info-item">
                            <div class="pk-contact-info-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.69h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10.09a16 16 0 0 0 6 6l1.27-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 17.42z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="pk-contact-info-label"><?php esc_html_e( 'Phone', 'paksa-it-solutions' ); ?></p>
                                <p class="pk-contact-info-value">
                                    <a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>">
                                        <?php echo esc_html( $phone ); ?>
                                    </a>
                                </p>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ( $email ) : ?>
                        <li class="pk-contact-info-item">
                            <div class="pk-contact-info-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                            <div>
                                <p class="pk-contact-info-label"><?php esc_html_e( 'Email', 'paksa-it-solutions' ); ?></p>
                                <p class="pk-contact-info-value">
                                    <a href="mailto:<?php echo esc_attr( $email ); ?>">
                                        <?php echo esc_html( $email ); ?>
                                    </a>
                                </p>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ( $address ) : ?>
                        <li class="pk-contact-info-item">
                            <div class="pk-contact-info-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div>
                                <p class="pk-contact-info-label"><?php esc_html_e( 'Address', 'paksa-it-solutions' ); ?></p>
                                <p class="pk-contact-info-value"><?php echo esc_html( $address ); ?></p>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ( $whatsapp ) : ?>
                        <li class="pk-contact-info-item">
                            <div class="pk-contact-info-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="pk-contact-info-label"><?php esc_html_e( 'WhatsApp', 'paksa-it-solutions' ); ?></p>
                                <p class="pk-contact-info-value">
                                    <a href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener noreferrer">
                                        <?php esc_html_e( 'Message us on WhatsApp', 'paksa-it-solutions' ); ?>
                                    </a>
                                </p>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ( $hours ) : ?>
                        <li class="pk-contact-info-item">
                            <div class="pk-contact-info-icon" aria-hidden="true">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12,6 12,12 16,14"></polyline>
                                </svg>
                            </div>
                            <div>
                                <p class="pk-contact-info-label"><?php esc_html_e( 'Business Hours', 'paksa-it-solutions' ); ?></p>
                                <p class="pk-contact-info-value"><?php echo esc_html( $hours ); ?></p>
                            </div>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

            <!-- Form area — presentation layer only -->
            <div class="pk-contact-form-area">
                <?php
                /**
                 * Hook: paksa_contact_form
                 *
                 * Plugins or child themes can hook here to output a contact form.
                 * Example: add_action( 'paksa_contact_form', 'paksa_contact_form_shortcode' );
                 *
                 * If no form is hooked, a neutral placeholder is shown.
                 */
                if ( has_action( 'paksa_contact_form' ) ) :
                    do_action( 'paksa_contact_form' );
                else : ?>
                    <div class="pk-contact-form-placeholder">
                        <p><?php esc_html_e( 'To send us a message, please use the contact details on this page or reach us via WhatsApp.', 'paksa-it-solutions' ); ?></p>
                        <?php if ( $email ) : ?>
                            <a href="mailto:<?php echo esc_attr( $email ); ?>" class="btn btn-primary">
                                <?php esc_html_e( 'Send an Email', 'paksa-it-solutions' ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
