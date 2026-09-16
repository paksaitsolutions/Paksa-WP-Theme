<?php
/**
 * Paksa IT Solutions — Service Taxonomy Archive
 *
 * Template: taxonomy-paksa_service_cat.php
 * URL: /services/category/{term-slug}/
 *
 * Displays services belonging to a single paksa_service_cat term.
 * Uses native WP loop. Reuses service-card.php component.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$term        = get_queried_object();
$term_name   = $term ? $term->name : '';
$term_desc   = $term ? $term->description : '';
$archive_url = get_post_type_archive_link( 'paksa_service' );

$sibling_cats = get_terms( array(
    'taxonomy'   => 'paksa_service_cat',
    'hide_empty' => true,
) );
?>
<main id="main-content" class="pk-service-taxonomy">

    <?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>

    <!-- Taxonomy Hero -->
    <section class="pk-svc-archive-hero" aria-labelledby="pk-svc-tax-heading">
        <div class="container pk-svc-archive-hero-inner">
            <div>
                <span class="eyebrow pk-animate-on-scroll" data-anim="fade-up">
                    <?php esc_html_e( 'IT Services', 'paksa-it-solutions' ); ?>
                </span>
                <h1 id="pk-svc-tax-heading" class="pk-svc-archive-heading pk-animate-on-scroll" data-anim="fade-up" data-delay="80">
                    <?php echo esc_html( $term_name ); ?>
                </h1>
                <?php if ( $term_desc ) : ?>
                    <p class="body-large pk-animate-on-scroll" data-anim="fade-up" data-delay="120">
                        <?php echo esc_html( $term_desc ); ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php if ( ! is_wp_error( $sibling_cats ) && ! empty( $sibling_cats ) ) : ?>
                <nav class="pk-prod-cat-filter pk-animate-on-scroll" data-anim="fade-up" data-delay="160"
                     aria-label="<?php esc_attr_e( 'Browse services by category', 'paksa-it-solutions' ); ?>">
                    <a href="<?php echo esc_url( $archive_url ); ?>"
                       class="pk-prod-cat-pill"
                       aria-current="false">
                        <?php esc_html_e( 'All Services', 'paksa-it-solutions' ); ?>
                    </a>
                    <?php foreach ( $sibling_cats as $cat ) :
                        $is_current = $term && $cat->term_id === $term->term_id;
                    ?>
                        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
                           class="pk-prod-cat-pill<?php echo $is_current ? ' is-active' : ''; ?>"
                           aria-current="<?php echo $is_current ? 'page' : 'false'; ?>">
                            <?php echo esc_html( $cat->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>
        </div>
    </section>

    <!-- Service Grid -->
    <section class="section pk-svc-grid-section" id="pk-services-grid" aria-labelledby="pk-svc-tax-grid-label">
        <div class="container">
            <h2 id="pk-svc-tax-grid-label" class="screen-reader-text">
                <?php
                /* translators: %s: category name */
                printf( esc_html__( 'Services in %s', 'paksa-it-solutions' ), esc_html( $term_name ) );
                ?>
            </h2>

            <?php if ( have_posts() ) : ?>

                <div class="pk-svc-archive-grid" role="list">
                    <?php
                    $index = 0;
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/components/service-card', null, array(
                            'post_id' => get_the_ID(),
                            'index'   => $index,
                        ) );
                        $index++;
                    endwhile;
                    ?>
                </div>

                <?php
                the_posts_pagination( array(
                    'mid_size'           => 2,
                    'prev_text'          => __( '&larr; Previous', 'paksa-it-solutions' ),
                    'next_text'          => __( 'Next &rarr;', 'paksa-it-solutions' ),
                    'screen_reader_text' => __( 'Services navigation', 'paksa-it-solutions' ),
                    'class'              => 'pk-archive-pagination',
                ) );
                ?>

            <?php else : ?>

                <div style="text-align:center; padding: var(--pk-space-16) 0;">
                    <p class="body-large" style="color: var(--pk-text-muted);">
                        <?php
                        /* translators: %s: category name */
                        printf( esc_html__( 'No services are currently listed under %s.', 'paksa-it-solutions' ), '<strong>' . esc_html( $term_name ) . '</strong>' );
                        ?>
                    </p>
                    <?php if ( $archive_url ) : ?>
                        <a href="<?php echo esc_url( $archive_url ); ?>" class="btn btn-outline" style="margin-top: var(--pk-space-6);">
                            <?php esc_html_e( 'View All Services', 'paksa-it-solutions' ); ?>
                        </a>
                    <?php endif; ?>
                </div>

            <?php endif; ?>

        </div>
    </section>

    <?php get_template_part( 'template-parts/products/cta' ); ?>

</main>
<?php
get_footer();
