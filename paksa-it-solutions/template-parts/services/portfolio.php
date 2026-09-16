<?php
/**
 * Paksa IT Solutions — Services: Service Portfolio
 *
 * Displays the service card grid.
 * Content source: apply_filters( 'paksa_svc_portfolio_items', $defaults )
 *
 * Each service item supports:
 *   title       string  Service name
 *   description string  Short description
 *   icon        string  Icon key for paksa_get_capability_icon()
 *   url         string  Link to service detail page (empty = no link)
 *   category    string  Optional category label
 *   featured    bool    Visually highlighted card
 *
 * Architecture note:
 *   In Phase 6, this filter can be replaced with a CPT query:
 *   $items = get_posts( array( 'post_type' => 'paksa_service', 'numberposts' => -1 ) );
 *   The template markup does not need to change.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Filter: paksa_svc_portfolio_eyebrow
 * Filter: paksa_svc_portfolio_heading
 * Filter: paksa_svc_portfolio_description
 */
$eyebrow = apply_filters( 'paksa_svc_portfolio_eyebrow',     __( 'What We Do', 'paksa-it-solutions' ) );
$heading = apply_filters( 'paksa_svc_portfolio_heading',     __( 'Our Service Portfolio', 'paksa-it-solutions' ) );
$desc    = apply_filters( 'paksa_svc_portfolio_description', __( 'A focused set of technology services built around real business requirements.', 'paksa-it-solutions' ) );

/**
 * Content source: paksa_service CPT if published services exist;
 * otherwise falls back to filter-based static array.
 */
$cpt_query = new WP_Query( array(
    'post_type'      => 'paksa_service',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
) );

if ( $cpt_query->have_posts() ) {
    // Build service items from CPT.
    $services = array();
    while ( $cpt_query->have_posts() ) {
        $cpt_query->the_post();
        $svc_id     = get_the_ID();
        $cat_label  = paksa_svc_meta( 'category_label', '', $svc_id );
        if ( ! $cat_label ) {
            $terms = get_the_terms( $svc_id, 'paksa_service_cat' );
            if ( $terms && ! is_wp_error( $terms ) ) {
                $cat_label = $terms[0]->name;
            }
        }
        $services[] = array(
            'icon'        => 'enterprise',
            'title'       => get_the_title(),
            'description' => paksa_svc_meta( 'tagline', get_the_excerpt(), $svc_id ),
            'category'    => $cat_label,
            'url'         => get_permalink(),
            'featured'    => get_post_meta( $svc_id, '_paksa_svc_featured', true ) === '1',
        );
    }
    wp_reset_postdata();
} else {
    /**
     * Filter: paksa_svc_portfolio_items
     * Fallback when no CPT services are published.
     */
    $services = apply_filters( 'paksa_svc_portfolio_items', array(
        array(
            'icon'        => 'enterprise',
            'title'       => __( 'Enterprise Software', 'paksa-it-solutions' ),
            'description' => __( 'Business platforms designed around operational requirements — finance, inventory, HR, procurement and more.', 'paksa-it-solutions' ),
            'category'    => __( 'Software', 'paksa-it-solutions' ),
            'url'         => '',
            'featured'    => false,
        ),
        array(
            'icon'        => 'ai',
            'title'       => __( 'AI & ML Solutions', 'paksa-it-solutions' ),
            'description' => __( 'Predictive intelligence, automation and intelligent decision support built into your business systems.', 'paksa-it-solutions' ),
            'category'    => __( 'Artificial Intelligence', 'paksa-it-solutions' ),
            'url'         => '',
            'featured'    => true,
        ),
        array(
            'icon'        => 'ai',
            'title'       => __( 'AI Automation Services', 'paksa-it-solutions' ),
            'description' => __( 'Intelligent process automation that reduces manual work and accelerates operational throughput.', 'paksa-it-solutions' ),
            'category'    => __( 'Artificial Intelligence', 'paksa-it-solutions' ),
            'url'         => '',
            'featured'    => false,
        ),
        array(
            'icon'        => 'bi',
            'title'       => __( 'Data Science & Analytics', 'paksa-it-solutions' ),
            'description' => __( 'Dashboards, analytics and decision intelligence that turn operational data into clear business insight.', 'paksa-it-solutions' ),
            'category'    => __( 'Data', 'paksa-it-solutions' ),
            'url'         => '',
            'featured'    => false,
        ),
        array(
            'icon'        => 'custom',
            'title'       => __( 'Custom Software Development', 'paksa-it-solutions' ),
            'description' => __( 'Purpose-built applications for unique workflows and processes that off-the-shelf software cannot address.', 'paksa-it-solutions' ),
            'category'    => __( 'Software', 'paksa-it-solutions' ),
            'url'         => '',
            'featured'    => false,
        ),
        array(
            'icon'        => 'integration',
            'title'       => __( 'System Integration', 'paksa-it-solutions' ),
            'description' => __( 'Connect ERP, ecommerce, APIs and business applications so data and workflows move without friction.', 'paksa-it-solutions' ),
            'category'    => __( 'Integration', 'paksa-it-solutions' ),
            'url'         => '',
            'featured'    => false,
        ),
        array(
            'icon'        => 'ecommerce',
            'title'       => __( 'Ecommerce Solutions', 'paksa-it-solutions' ),
            'description' => __( 'Connected commerce platforms and operational systems that integrate with your wider business infrastructure.', 'paksa-it-solutions' ),
            'category'    => __( 'Commerce', 'paksa-it-solutions' ),
            'url'         => '',
            'featured'    => false,
        ),
    ) );
}

if ( empty( $services ) ) {
    return;
}
?>
<section class="section pk-svc-portfolio" id="pk-services-portfolio" aria-labelledby="pk-svc-portfolio-heading">
    <div class="container">

        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow'     => $eyebrow,
            'heading'     => $heading,
            'description' => $desc,
        ) );
        ?>

        <div class="pk-svc-grid" role="list">
            <?php foreach ( $services as $index => $svc ) :
                $is_featured = ! empty( $svc['featured'] );
                $has_link    = ! empty( $svc['url'] );
                $card_tag    = $has_link ? 'a' : 'div';
                $card_attrs  = $has_link
                    ? ' href="' . esc_url( $svc['url'] ) . '"'
                    : '';
                $card_class  = 'pk-svc-card' . ( $is_featured ? ' pk-svc-card--featured' : '' ) . ' pk-animate-on-scroll';
            ?>
                <<?php echo $card_tag; ?> class="<?php echo esc_attr( $card_class ); ?>"<?php echo $card_attrs; ?> data-anim="fade-up" data-delay="<?php echo esc_attr( ( $index % 3 ) * 80 ); ?>" role="listitem">

                    <?php if ( ! empty( $svc['category'] ) ) : ?>
                        <span class="pk-svc-card-category"><?php echo esc_html( $svc['category'] ); ?></span>
                    <?php endif; ?>

                    <div class="pk-svc-card-icon" aria-hidden="true">
                        <?php echo paksa_get_capability_icon( $svc['icon'] ); ?>
                    </div>

                    <h3 class="pk-svc-card-title"><?php echo esc_html( $svc['title'] ); ?></h3>

                    <p class="pk-svc-card-desc"><?php echo esc_html( $svc['description'] ); ?></p>

                    <?php if ( $has_link ) : ?>
                        <span class="pk-svc-card-arrow" aria-hidden="true">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="3" y1="8" x2="13" y2="8"></line>
                                <polyline points="9,4 13,8 9,12"></polyline>
                            </svg>
                        </span>
                    <?php endif; ?>

                </<?php echo $card_tag; ?>>
            <?php endforeach; ?>
        </div>

    </div>
</section>
