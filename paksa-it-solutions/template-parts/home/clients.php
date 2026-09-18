<?php
/**
 * Paksa IT Solutions — Homepage: Client Logos
 * Auto-scrolling carousel matching live site
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$logos = apply_filters( 'paksa_client_logos', array(
    array( 'src' => 'https://paksa.com.pk/wp-content/uploads/2025/12/Logo-11-1-150x150.png', 'alt' => 'Riyalux' ),
    array( 'src' => 'https://paksa.com.pk/wp-content/uploads/2025/12/Logo-6-150x150.png',    'alt' => 'Client' ),
    array( 'src' => 'https://paksa.com.pk/wp-content/uploads/2025/12/Logo-7-150x150.png',    'alt' => 'Client' ),
    array( 'src' => 'https://paksa.com.pk/wp-content/uploads/2025/12/Logo-8-150x150.png',    'alt' => 'Client' ),
    array( 'src' => 'https://paksa.com.pk/wp-content/uploads/2025/12/Logo-10-150x150.png',   'alt' => 'Client' ),
    array( 'src' => 'https://paksa.com.pk/wp-content/uploads/2025/12/Logo-9-150x150.png',    'alt' => 'Client' ),
    array( 'src' => 'https://paksa.com.pk/wp-content/uploads/2025/12/Logo-4-150x150.png',    'alt' => 'Client' ),
    array( 'src' => 'https://paksa.com.pk/wp-content/uploads/2025/12/Logo-3-150x150.png',    'alt' => 'Shapewearpk' ),
    array( 'src' => 'https://paksa.com.pk/wp-content/uploads/2025/12/Logo-2-150x150.png',    'alt' => 'Client' ),
    array( 'src' => 'https://paksa.com.pk/wp-content/uploads/2025/12/Logo-1-150x150.png',    'alt' => 'Client' ),
    array( 'src' => 'https://paksa.com.pk/wp-content/uploads/2025/12/Logo-12-150x150.png',   'alt' => 'Client' ),
    array( 'src' => 'https://paksa.com.pk/wp-content/uploads/2025/12/Logo-5-150x150.png',    'alt' => 'Client' ),
) );

if ( empty( $logos ) ) return;

$all = array_merge( $logos, $logos );
?>
<section class="pk-clients section" aria-label="<?php esc_attr_e( 'Trusted by leading businesses', 'paksa-it-solutions' ); ?>">
    <div class="container">
        <p class="pk-clients-label"><?php esc_html_e( 'Trusted by businesses across industries', 'paksa-it-solutions' ); ?></p>
    </div>
    <div class="pk-clients-marquee-wrap">
        <div class="pk-clients-marquee" aria-hidden="true">
            <?php foreach ( $all as $logo ) : ?>
                <div class="pk-client-logo">
                    <img
                        src="<?php echo esc_url( $logo['src'] ); ?>"
                        alt="<?php echo esc_attr( $logo['alt'] ); ?>"
                        width="80"
                        height="80"
                        loading="lazy"
                        decoding="async"
                    >
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
