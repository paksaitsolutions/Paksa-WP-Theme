<?php
/**
 * Paksa IT Solutions — Single Product: Modules / Components
 *
 * Content: _paksa_prod_modules_list meta (pipe-delimited: Name | Description)
 * Parsed by paksa_parse_pipe_list().
 * Supports any number of modules — no fixed count.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$prod_id  = get_the_ID();
$eyebrow  = paksa_prod_meta( 'modules_eyebrow', __( 'Modules', 'paksa-it-solutions' ), $prod_id );
$heading  = paksa_prod_meta( 'modules_heading', __( 'Product Modules', 'paksa-it-solutions' ), $prod_id );
$desc     = paksa_prod_meta_textarea( 'modules_desc', '', $prod_id );
$raw_list = paksa_prod_meta_textarea( 'modules_list', '', $prod_id );
$modules  = paksa_parse_pipe_list( $raw_list );

/**
 * Filter: paksa_product_modules
 * Allows programmatic override of modules for a specific product.
 *
 * @param array $modules  Parsed module items.
 * @param int   $prod_id  Product post ID.
 */
$modules = apply_filters( 'paksa_product_modules', $modules, $prod_id );

if ( empty( $modules ) ) {
    return;
}
?>
<section class="section section-alt pk-prod-modules" aria-labelledby="pk-prod-modules-heading">
    <div class="container">

        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow'     => $eyebrow,
            'heading'     => $heading,
            'description' => $desc,
        ) );
        ?>

        <div class="pk-prod-modules-grid" role="list">
            <?php foreach ( $modules as $i => $module ) : ?>
                <div class="pk-prod-module-item pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>" role="listitem">
                    <div class="pk-prod-module-number" aria-hidden="true">
                        <?php echo esc_html( str_pad( $i + 1, 2, '0', STR_PAD_LEFT ) ); ?>
                    </div>
                    <div class="pk-prod-module-body">
                        <h3 class="pk-prod-module-title"><?php echo esc_html( $module['title'] ); ?></h3>
                        <?php if ( $module['desc'] ) : ?>
                            <p class="pk-prod-module-desc"><?php echo esc_html( $module['desc'] ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
