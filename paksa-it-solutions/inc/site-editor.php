<?php
/**
 * Paksa Theme — native Site Editor bridge.
 *
 * The visual templates and template parts live in the standard /templates
 * and /parts directories. This file only registers focused pattern entry
 * points, keeping normal composition in Gutenberg rather than a parallel
 * page-builder data model.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Build a native Query Loop pattern for an existing Paksa content type.
 *
 * @param string $post_type Registered post type.
 * @param string $taxonomy  Registered taxonomy.
 * @param string $card      Existing Paksa card style class.
 * @return string
 */
function paksa_site_editor_content_grid( $post_type, $taxonomy, $card ) {
    $post_type = sanitize_key( $post_type );
    $taxonomy  = sanitize_key( $taxonomy );
    $card      = sanitize_html_class( $card );

    return '<!-- wp:query {"queryId":18,"query":{"perPage":6,"pages":0,"offset":0,"postType":"' . $post_type . '","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"pk-site-editor-resource-grid"} -->'
        . '<div class="wp-block-query pk-site-editor-resource-grid"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->'
        . '<!-- wp:group {"className":"is-style-paksa-card-' . $card . '","layout":{"type":"constrained"}} --><div class="wp-block-group is-style-paksa-card-' . $card . '">'
        . '<!-- wp:post-featured-image {"isLink":true,"className":"is-style-paksa-image-zoom"} /-->'
        . '<!-- wp:post-terms {"term":"' . $taxonomy . '","className":"pk-component-meta"} /-->'
        . '<!-- wp:post-title {"isLink":true,"level":3} /-->'
        . '<!-- wp:post-excerpt {"moreText":"View details"} /-->'
        . '</div><!-- /wp:group -->'
        . '<!-- /wp:post-template -->'
        . '<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-query-pagination is-layout-flex is-content-justification-center">'
        . '<!-- wp:query-pagination-previous /--><!-- wp:query-pagination-numbers /--><!-- wp:query-pagination-next /-->'
        . '</div><!-- /wp:query-pagination -->'
        . '</div><!-- /wp:query -->';
}

/**
 * Register Site Editor entry points using native template-part and query blocks.
 */
function paksa_register_site_editor_patterns() {
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    if ( function_exists( 'register_block_pattern_category' ) ) {
        register_block_pattern_category( 'paksa-navigation', array(
            'label' => __( 'Paksa Navigation', 'paksa-it-solutions' ),
        ) );
    }

    $patterns = array(
        'site-editor-header' => array(
            'title'       => __( 'Site Editor — Header Part', 'paksa-it-solutions' ),
            'categories'  => array( 'paksa-headers', 'paksa-navigation' ),
            'description' => __( 'Insert the shared, visually editable Paksa header template part.', 'paksa-it-solutions' ),
            'content'     => '<!-- wp:template-part {"slug":"header","theme":"paksa-it-solutions","tagName":"header"} /-->',
        ),
        'site-editor-footer' => array(
            'title'       => __( 'Site Editor — Footer Part', 'paksa-it-solutions' ),
            'categories'  => array( 'paksa-footers' ),
            'description' => __( 'Insert the shared, visually editable Paksa footer template part.', 'paksa-it-solutions' ),
            'content'     => '<!-- wp:template-part {"slug":"footer","theme":"paksa-it-solutions","tagName":"footer"} /-->',
        ),
        'site-editor-navigation' => array(
            'title'       => __( 'Navigation — Dynamic Page List', 'paksa-it-solutions' ),
            'categories'  => array( 'paksa-navigation' ),
            'description' => __( 'A native responsive Navigation block populated from published pages. Replace it with a saved navigation menu whenever needed.', 'paksa-it-solutions' ),
            'content'     => '<!-- wp:navigation {"overlayMenu":"mobile","className":"pk-site-editor-navigation","layout":{"type":"flex","justifyContent":"right","orientation":"horizontal"}} --><!-- wp:page-list /--><!-- /wp:navigation -->',
        ),
        'site-editor-archive-loop' => array(
            'title'       => __( 'Content — Dynamic Archive Grid', 'paksa-it-solutions' ),
            'categories'  => array( 'paksa-content' ),
            'description' => __( 'An inherited Query Loop for posts, products, services, category, tag, and taxonomy archives.', 'paksa-it-solutions' ),
            'content'     => '<!-- wp:query {"queryId":16,"query":{"perPage":9,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"className":"pk-site-editor-archive-loop"} --><div class="wp-block-query pk-site-editor-archive-loop"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} --><!-- wp:group {"className":"is-style-paksa-card-blog","layout":{"type":"constrained"}} --><div class="wp-block-group is-style-paksa-card-blog"><!-- wp:post-featured-image {"isLink":true,"className":"is-style-paksa-image-zoom"} /--><!-- wp:group {"className":"pk-component-meta","layout":{"type":"flex","flexWrap":"wrap"}} --><div class="wp-block-group pk-component-meta"><!-- wp:post-date /--></div><!-- /wp:group --><!-- wp:post-title {"isLink":true,"level":3} /--><!-- wp:post-excerpt {"moreText":"Read more"} /--></div><!-- /wp:group --><!-- /wp:post-template --><!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-query-pagination is-layout-flex is-content-justification-center"><!-- wp:query-pagination-previous /--><!-- wp:query-pagination-numbers /--><!-- wp:query-pagination-next /--></div><!-- /wp:query-pagination --></div><!-- /wp:query -->',
        ),
        'site-editor-product-grid' => array(
            'title'       => __( 'Products — Dynamic Card Grid', 'paksa-it-solutions' ),
            'categories'  => array( 'paksa-products' ),
            'description' => __( 'A live grid of existing Products & Solutions with native Query Loop controls.', 'paksa-it-solutions' ),
            'content'     => paksa_site_editor_content_grid( 'paksa_product', 'paksa_product_cat', 'product' ),
        ),
        'site-editor-service-grid' => array(
            'title'       => __( 'Services — Dynamic Card Grid', 'paksa-it-solutions' ),
            'categories'  => array( 'paksa-services' ),
            'description' => __( 'A live grid of existing Services with native Query Loop controls.', 'paksa-it-solutions' ),
            'content'     => paksa_site_editor_content_grid( 'paksa_service', 'paksa_service_cat', 'service' ),
        ),
        'site-editor-related-content' => array(
            'title'       => __( 'Related Content — Selected Product or Service Links', 'paksa-it-solutions' ),
            'categories'  => array( 'paksa-content' ),
            'description' => __( 'Shows only the product or service relationships selected for the current item. Add it to a Product or Service visual template.', 'paksa-it-solutions' ),
            'content'     => '<!-- wp:paksa/related-content /-->',
        ),
        'site-editor-contact-part' => array(
            'title'       => __( 'Contact — Secure Form Composition', 'paksa-it-solutions' ),
            'categories'  => array( 'paksa-contact' ),
            'description' => __( 'The editable surrounding composition for the existing secure Paksa contact form.', 'paksa-it-solutions' ),
            'content'     => '<!-- wp:template-part {"slug":"contact-form","theme":"paksa-it-solutions","tagName":"section"} /-->',
        ),
    );

    foreach ( $patterns as $slug => $pattern ) {
        register_block_pattern( 'paksa-it-solutions/' . $slug, $pattern );
    }
}
add_action( 'init', 'paksa_register_site_editor_patterns', 34 );
