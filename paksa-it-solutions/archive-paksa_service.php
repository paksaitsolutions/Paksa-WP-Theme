<?php
/**
 * Paksa IT Solutions — Service Archive Template
 *
 * Template: archive-paksa_service.php
 * URL: /services/
 *
 * Native WordPress CPT archive. Uses the main WP_Query loop — no custom query.
 * Ordered by menu_order ASC, title ASC (set in CPT registration).
 *
 * Distinct from page-services.php (marketing landing page).
 * This is the structured content listing of all published services.
 *
 * Reuses:
 *   template-parts/components/service-card.php
 *   template-parts/components/breadcrumbs.php
 *   template-parts/products/cta.php  — global CTA
 *   .pk-archive-pagination from products.css
 *   .pk-svc-archive-* from archive.css
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$archive_cats = get_terms( array(
    'taxonomy'   => 'paksa_service_cat',
    'hide_empty' => true,
) );
?>
<main id="main-content" class="pk-service-archive">

    <?php get_template_part( 'template-parts/components/breadcrumbs' ); ?>

    <!-- Archive Hero -->
    <section class="pk-svc-archive-hero" aria-labelledby="pk-svc-archive-heading">
        <div class="container pk-svc-archive-hero-inner">
            <div>
                <span class="eyebrow pk-animate-on-scroll" data-anim="fade-up">
                    <?php esc_html_e( 'IT Services', 'paksa-it-solutions' ); ?>
                </span>
                <h1 id="pk-svc-archive-heading" class="pk-svc-archive-heading pk-animate-on-scroll" data-anim="fade-up" data-delay="80">
                    <?php post_type_archive_title(); ?>
                </h1>
                <?php
                $archive_desc = get_the_archive_description();
                if ( $archive_desc ) :
                ?>
                    <div class="body-large pk-animate-on-scroll" data-anim="fade-up" data-delay="120">
                        <?php echo wp_kses_post( $archive_desc ); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ( ! is_wp_error( $archive_cats ) && ! empty( $archive_cats ) ) : ?>
                <nav class="pk-prod-cat-filter pk-animate-on-scroll" data-anim="fade-up" data-delay="160"
                     aria-label="<?php esc_attr_e( 'Browse services by category', 'paksa-it-solutions' ); ?>">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'paksa_service' ) ); ?>"
                       class="pk-prod-cat-pill<?php echo ! is_tax() ? ' is-active' : ''; ?>"
                       aria-current="<?php echo ! is_tax() ? 'page' : 'false'; ?>">
                        <?php esc_html_e( 'All Services', 'paksa-it-solutions' ); ?>
                    </a>
                    <?php foreach ( $archive_cats as $cat ) : ?>
                        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
                           class="pk-prod-cat-pill"
                           aria-current="false">
                            <?php echo esc_html( $cat->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            <?php endif; ?>
        </div>
    </section>

    <!-- Service Grid — native WP loop -->
    <section class="section pk-svc-grid-section" id="pk-services-grid" aria-labelledby="pk-svc-grid-label">
        <div class="container">
            <h2 id="pk-svc-grid-label" class="screen-reader-text">
                <?php esc_html_e( 'All Services', 'paksa-it-solutions' ); ?>
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

                <p class="pk-prod-empty body-large" style="text-align:center; color: var(--pk-text-muted); padding: var(--pk-space-16) 0;">
                    <?php esc_html_e( 'No services have been published yet.', 'paksa-it-solutions' ); ?>
                </p>

            <?php endif; ?>

        </div>
    </section>

    <?php get_template_part( 'template-parts/products/cta' ); ?>

</main>
<?php
get_footer();
