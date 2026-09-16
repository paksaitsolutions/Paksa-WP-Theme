<?php
/**
 * Paksa IT Solutions — Custom Post Type: Product / Solution
 *
 * Registers the `paksa_product` CPT and `paksa_product_cat` taxonomy.
 * No plugin dependency — pure WordPress core register_post_type() /
 * register_taxonomy().
 *
 * URL structure:
 *   Archive:  /solutions/
 *   Single:   /solutions/{product-slug}/
 *   Category: /solutions/category/{term-slug}/
 *
 * Template hierarchy:
 *   Single:  single-paksa_product.php
 *   Archive: archive-paksa_product.php  (Phase 6)
 *   Tax:     taxonomy-paksa_product_cat.php  (Phase 6)
 *
 * Migration path to Phase 6:
 *   The listing page (page-products.php) currently queries this CPT.
 *   In Phase 6, archive-paksa_product.php can replace or supplement it.
 *   No template markup needs to change — only the data source.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register paksa_product post type.
 */
function paksa_register_product_cpt() {
    $labels = array(
        'name'                  => __( 'Products & Solutions', 'paksa-it-solutions' ),
        'singular_name'         => __( 'Product', 'paksa-it-solutions' ),
        'add_new'               => __( 'Add New Product', 'paksa-it-solutions' ),
        'add_new_item'          => __( 'Add New Product', 'paksa-it-solutions' ),
        'edit_item'             => __( 'Edit Product', 'paksa-it-solutions' ),
        'new_item'              => __( 'New Product', 'paksa-it-solutions' ),
        'view_item'             => __( 'View Product', 'paksa-it-solutions' ),
        'view_items'            => __( 'View Products', 'paksa-it-solutions' ),
        'search_items'          => __( 'Search Products', 'paksa-it-solutions' ),
        'not_found'             => __( 'No products found.', 'paksa-it-solutions' ),
        'not_found_in_trash'    => __( 'No products found in Trash.', 'paksa-it-solutions' ),
        'all_items'             => __( 'All Products', 'paksa-it-solutions' ),
        'menu_name'             => __( 'Products', 'paksa-it-solutions' ),
        'name_admin_bar'        => __( 'Product', 'paksa-it-solutions' ),
        'featured_image'        => __( 'Product Image', 'paksa-it-solutions' ),
        'set_featured_image'    => __( 'Set product image', 'paksa-it-solutions' ),
        'remove_featured_image' => __( 'Remove product image', 'paksa-it-solutions' ),
        'use_featured_image'    => __( 'Use as product image', 'paksa-it-solutions' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'show_in_rest'       => true,   // Block editor support
        'query_var'          => true,
        'rewrite'            => array(
            'slug'       => 'solutions',
            'with_front' => false,
        ),
        'capability_type'    => 'post',
        'has_archive'        => 'solutions',
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-grid-view',
        'supports'           => array(
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'page-attributes',  // Enables menu_order for display ordering
            'revisions',
        ),
        'taxonomies'         => array( 'paksa_product_cat' ),
    );

    register_post_type( 'paksa_product', $args );
}
add_action( 'init', 'paksa_register_product_cpt' );

/**
 * Register paksa_product_cat taxonomy.
 * Hierarchical (like categories) — supports grouping products by type.
 */
function paksa_register_product_taxonomy() {
    $labels = array(
        'name'              => __( 'Product Categories', 'paksa-it-solutions' ),
        'singular_name'     => __( 'Product Category', 'paksa-it-solutions' ),
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
            'slug'       => 'solutions/category',
            'with_front' => false,
        ),
    );

    register_taxonomy( 'paksa_product_cat', array( 'paksa_product' ), $args );
}
add_action( 'init', 'paksa_register_product_taxonomy' );

/**
 * Flush rewrite rules on theme activation only.
 * Prevents performance hit on every request.
 * Registers all CPTs and taxonomies before flushing.
 *
 * Administrators should visit Settings → Permalinks after any
 * structural change to CPT slugs or taxonomy slugs.
 */
function paksa_flush_rewrite_on_activation() {
    paksa_register_product_cpt();
    paksa_register_product_taxonomy();
    // paksa_service CPT is registered via its own init hook in service-cpt.php
    // but we call it directly here to ensure it is registered before flush.
    if ( function_exists( 'paksa_register_service_cpt' ) ) {
        paksa_register_service_cpt();
    }
    if ( function_exists( 'paksa_register_service_taxonomy' ) ) {
        paksa_register_service_taxonomy();
    }
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'paksa_flush_rewrite_on_activation' );
