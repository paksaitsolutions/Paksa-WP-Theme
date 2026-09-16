<?php
/**
 * Paksa IT Solutions — About: Values
 *
 * Content: _paksa_page_values_list post meta (pipe-delimited).
 * Parsed by paksa_parse_pipe_list() from inc/product-meta.php.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID();
$raw     = paksa_page_meta_textarea( 'values_list', '', $page_id );
$values  = paksa_parse_pipe_list( $raw );

if ( empty( $values ) ) {
    return;
}
?>
<section class="section pk-about-values" aria-labelledby="pk-about-values-heading">
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'heading' => __( 'Our Values', 'paksa-it-solutions' ),
        ) );
        ?>
        <div class="pk-about-values-grid" role="list">
            <?php foreach ( $values as $i => $value ) : ?>
                <div class="pk-about-value-item pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>" role="listitem">
                    <p class="pk-about-value-title"><?php echo esc_html( $value['title'] ); ?></p>
                    <?php if ( $value['desc'] ) : ?>
                        <p class="pk-about-value-desc"><?php echo esc_html( $value['desc'] ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
