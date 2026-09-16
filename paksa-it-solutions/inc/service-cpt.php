<?php
/**
 * Paksa IT Solutions — Custom Post Type: Service
 *
 * Registers the `paksa_service` CPT and `paksa_service_cat` taxonomy.
 * No plugin dependency — pure WordPress core.
 *
 * URL structure:
 *   Archive:  /services/
 *   Single:   /services/{service-slug}/
 *   Category: /services/category/{term-slug}/
 *
 * Template hierarchy:
 *   Single:  single-paksa_service.php
 *   Archive: archive-paksa_service.php  (Phase 7)
 *   Tax:     taxonomy-paksa_service_cat.php  (Phase 7)
 *
 * Architecture decision:
 *   Services were previously managed as a single Page + post meta (page-services.php).
 *   That page remains as the master Services overview/landing page.
 *   This CPT provides individual service pages at /services/{slug}/ for:
 *     - SEO-friendly individual service URLs
 *     - Admin management of each service independently
 *     - Service → Product relationships via meta
 *     - Future service detail pages with full content
 *
 * Service → Product relationship:
 *   Each service stores related product IDs in _paksa_svc_related_products.
 *   Products store related service IDs in _paksa_prod_related_services.
 *   Both directions are stored to allow queries from either side.
 *   Relationship is managed from the service edit screen.
 *
 * Migration note:
 *   The existing page-services.php and its _paksa_svc_* meta are NOT affected.
 *   No existing data is modified. The master services page continues to function.
 *   Individual service CPT posts are new content — no migration required.
 *
 * Rewrite flush:
 *   Handled by paksa_flush_rewrite_on_activation() in cpt.php (after_switch_theme).
 *   paksa_service CPT is registered before flush_rewrite_rules() is called.
 *   Administrators should visit Settings → Permalinks after any structural change.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register paksa_service post type.
 */
function paksa_register_service_cpt() {
    $labels = array(
        'name'                  => __( 'Services', 'paksa-it-solutions' ),
        'singular_name'         => __( 'Service', 'paksa-it-solutions' ),
        'add_new'               => __( 'Add New Service', 'paksa-it-solutions' ),
        'add_new_item'          => __( 'Add New Service', 'paksa-it-solutions' ),
        'edit_item'             => __( 'Edit Service', 'paksa-it-solutions' ),
        'new_item'              => __( 'New Service', 'paksa-it-solutions' ),
        'view_item'             => __( 'View Service', 'paksa-it-solutions' ),
        'view_items'            => __( 'View Services', 'paksa-it-solutions' ),
        'search_items'          => __( 'Search Services', 'paksa-it-solutions' ),
        'not_found'             => __( 'No services found.', 'paksa-it-solutions' ),
        'not_found_in_trash'    => __( 'No services found in Trash.', 'paksa-it-solutions' ),
        'all_items'             => __( 'All Services', 'paksa-it-solutions' ),
        'menu_name'             => __( 'Services', 'paksa-it-solutions' ),
        'name_admin_bar'        => __( 'Service', 'paksa-it-solutions' ),
        'featured_image'        => __( 'Service Image', 'paksa-it-solutions' ),
        'set_featured_image'    => __( 'Set service image', 'paksa-it-solutions' ),
        'remove_featured_image' => __( 'Remove service image', 'paksa-it-solutions' ),
        'use_featured_image'    => __( 'Use as service image', 'paksa-it-solutions' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array(
            'slug'       => 'services',
            'with_front' => false,
        ),
        'capability_type'    => 'post',
        'has_archive'        => 'services',
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-hammer',
        'supports'           => array(
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'page-attributes',
            'revisions',
        ),
        'taxonomies'         => array( 'paksa_service_cat' ),
    );

    register_post_type( 'paksa_service', $args );
}
add_action( 'init', 'paksa_register_service_cpt' );

/**
 * Register paksa_service_cat taxonomy.
 * Hierarchical — supports grouping services by type (e.g. AI, Software, Data).
 */
function paksa_register_service_taxonomy() {
    $labels = array(
        'name'              => __( 'Service Categories', 'paksa-it-solutions' ),
        'singular_name'     => __( 'Service Category', 'paksa-it-solutions' ),
        'search_items'      => __( 'Search Categories', 'paksa-it-solutions' ),
        'all_items'         => __( 'All Categories', 'paksa-it-solutions' ),
        'parent_item'       => __( 'Parent Category', 'paksa-it-solutions' ),
        'parent_item_colon' => __( 'Parent Category:', 'paksa-it-solutions' ),
        'edit_item'         => __( 'Edit Category', 'paksa-it-solutions' ),
        'update_item'       => __( 'Update Category', 'paksa-it-solutions' ),
        'add_new_item'      => __( 'Add New Category', 'paksa-it-solutions' ),
        'new_item_name'     => __( 'New Category Name', 'paksa-it-solutions' ),
        'menu_name'         => __( 'Categories', 'paksa-it-solutions' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array(
            'slug'       => 'services/category',
            'with_front' => false,
        ),
    );

    register_taxonomy( 'paksa_service_cat', array( 'paksa_service' ), $args );
}
add_action( 'init', 'paksa_register_service_taxonomy' );

/**
 * Register post meta for paksa_service via register_post_meta().
 * Enables REST API access and block editor compatibility for key fields.
 * Only public-facing identity fields are exposed via REST.
 * Internal section-visibility flags are not exposed.
 */
function paksa_register_service_meta() {
    $public_text_fields = array(
        '_paksa_svc_tagline',
        '_paksa_svc_category_label',
        '_paksa_svc_badge',
        '_paksa_svc_hero_heading',
        '_paksa_svc_hero_eyebrow',
    );

    foreach ( $public_text_fields as $key ) {
        register_post_meta( 'paksa_service', $key, array(
            'single'            => true,
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function() {
                return current_user_can( 'edit_posts' );
            },
            'show_in_rest'      => true,
        ) );
    }

    // Internal fields — registered for block editor but not exposed via REST
    $internal_fields = array(
        '_paksa_svc_hero_description',
        '_paksa_svc_overview_content',
        '_paksa_svc_features_list',
        '_paksa_svc_faq_items',
        '_paksa_svc_related_products',
    );

    foreach ( $internal_fields as $key ) {
        register_post_meta( 'paksa_service', $key, array(
            'single'            => true,
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function() {
                return current_user_can( 'edit_posts' );
            },
            'show_in_rest'      => false,
        ) );
    }
}
add_action( 'init', 'paksa_register_service_meta' );

/**
 * Register post meta for paksa_product via register_post_meta().
 * Enables REST API access and block editor compatibility for key fields.
 */
function paksa_register_product_meta_rest() {
    $public_text_fields = array(
        '_paksa_prod_tagline',
        '_paksa_prod_category_label',
        '_paksa_prod_badge',
        '_paksa_prod_hero_heading',
        '_paksa_prod_hero_eyebrow',
    );

    foreach ( $public_text_fields as $key ) {
        register_post_meta( 'paksa_product', $key, array(
            'single'            => true,
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function() {
                return current_user_can( 'edit_posts' );
            },
            'show_in_rest'      => true,
        ) );
    }

    // Related services — internal, not exposed via REST
    register_post_meta( 'paksa_product', '_paksa_prod_related_services', array(
        'single'            => true,
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback'     => function() {
            return current_user_can( 'edit_posts' );
        },
        'show_in_rest'      => false,
    ) );
}
add_action( 'init', 'paksa_register_product_meta_rest' );
