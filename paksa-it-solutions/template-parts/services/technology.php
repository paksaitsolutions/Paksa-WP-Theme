<?php
/**
 * Paksa IT Solutions — Services: Technology & Integration
 *
 * Displays verified technologies, platforms and integrations.
 * Default array is EMPTY — do not invent a technology stack.
 * Populate via the paksa_svc_technology_items filter once verified.
 *
 * Each item supports:
 *   name        string  Technology name
 *   category    string  Category label (e.g. 'Language', 'Platform', 'Database')
 *   description string  Optional short description
 *   url         string  Optional URL
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow = apply_filters( 'paksa_svc_technology_eyebrow',     __( 'Technology', 'paksa-it-solutions' ) );
$heading = apply_filters( 'paksa_svc_technology_heading',     __( 'Technology & Integration', 'paksa-it-solutions' ) );
$desc    = apply_filters( 'paksa_svc_technology_description', __( 'We work with the technologies that best fit the business requirement — not a fixed stack applied to every project.', 'paksa-it-solutions' ) );

/**
 * Filter: paksa_svc_technology_items
 * Default is empty. Populate with verified technologies only.
 *
 * Example item:
 *   array(
 *     'name'     => 'Python',
 *     'category' => 'Language',
 *     'desc'     => '',
 *     'url'      => '',
 *   )
 */
$technologies = apply_filters( 'paksa_svc_technology_items', array() );

/**
 * Filter: paksa_svc_technology_categories
 * Optional category grouping. If empty, items render as a flat grid.
 * Each item: array( 'label' => string, 'key' => string )
 */
$categories = apply_filters( 'paksa_svc_technology_categories', array() );

// If no items, render a placeholder state so the section is still useful.
$has_items = ! empty( $technologies );
?>
<section class="section section-alt pk-svc-technology" aria-labelledby="pk-svc-tech-heading">
    <div class="container">

        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow'     => $eyebrow,
            'heading'     => $heading,
            'description' => $desc,
        ) );
        ?>

        <?php if ( $has_items ) : ?>

            <?php if ( ! empty( $categories ) ) : ?>
                <?php foreach ( $categories as $cat ) : ?>
                    <?php
                    $cat_items = array_filter( $technologies, function( $t ) use ( $cat ) {
                        return isset( $t['category'] ) && $t['category'] === $cat['key'];
                    } );
                    if ( empty( $cat_items ) ) continue;
                    ?>
                    <div class="pk-svc-tech-group">
                        <h3 class="pk-svc-tech-group-label"><?php echo esc_html( $cat['label'] ); ?></h3>
                        <ul class="pk-svc-tech-grid" role="list">
                            <?php foreach ( $cat_items as $tech ) : ?>
                                <li class="pk-svc-tech-item">
                                    <?php if ( ! empty( $tech['url'] ) ) : ?>
                                        <a href="<?php echo esc_url( $tech['url'] ); ?>" class="pk-svc-tech-link" target="_blank" rel="noopener noreferrer">
                                            <span class="pk-svc-tech-name"><?php echo esc_html( $tech['name'] ); ?></span>
                                        </a>
                                    <?php else : ?>
                                        <span class="pk-svc-tech-name"><?php echo esc_html( $tech['name'] ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $tech['desc'] ) ) : ?>
                                        <span class="pk-svc-tech-desc"><?php echo esc_html( $tech['desc'] ); ?></span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>

            <?php else : ?>
                <ul class="pk-svc-tech-grid" role="list">
                    <?php foreach ( $technologies as $tech ) : ?>
                        <li class="pk-svc-tech-item pk-animate-on-scroll" data-anim="scale-in">
                            <?php if ( ! empty( $tech['url'] ) ) : ?>
                                <a href="<?php echo esc_url( $tech['url'] ); ?>" class="pk-svc-tech-link" target="_blank" rel="noopener noreferrer">
                                    <span class="pk-svc-tech-name"><?php echo esc_html( $tech['name'] ); ?></span>
                                    <?php if ( ! empty( $tech['category'] ) ) : ?>
                                        <span class="pk-svc-tech-cat"><?php echo esc_html( $tech['category'] ); ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php else : ?>
                                <span class="pk-svc-tech-name"><?php echo esc_html( $tech['name'] ); ?></span>
                                <?php if ( ! empty( $tech['category'] ) ) : ?>
                                    <span class="pk-svc-tech-cat"><?php echo esc_html( $tech['category'] ); ?></span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        <?php else : ?>
            <p class="pk-svc-tech-empty body-small" style="text-align:center; color: var(--pk-text-muted);">
                <?php esc_html_e( 'Technology details will be added here. Use the paksa_svc_technology_items filter to populate this section.', 'paksa-it-solutions' ); ?>
            </p>
        <?php endif; ?>

    </div>
</section>
