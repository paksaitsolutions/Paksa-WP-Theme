<?php
$p = get_posts( array( 'post_type' => 'paksa_product', 'name' => 'paksa-erp', 'numberposts' => 1 ) );
if ( ! $p ) { WP_CLI::error( 'Post not found' ); return; }
$p = $p[0];
$id = $p->ID;

WP_CLI::log( "ID:       $id" );
WP_CLI::log( "Title:    " . $p->post_title );
WP_CLI::log( "Status:   " . $p->post_status );
WP_CLI::log( "URL:      " . get_permalink( $id ) );
WP_CLI::log( "Tagline:  " . get_post_meta( $id, '_paksa_prod_tagline', true ) );
WP_CLI::log( "Badge:    " . get_post_meta( $id, '_paksa_prod_badge', true ) );
WP_CLI::log( "Featured: " . get_post_meta( $id, '_paksa_prod_featured', true ) );

$terms = get_the_terms( $id, 'paksa_product_cat' );
WP_CLI::log( "Category: " . ( $terms && ! is_wp_error( $terms ) ? $terms[0]->name : 'none' ) );

$all_meta = get_post_meta( $id );
$paksa_keys = array_filter( array_keys( $all_meta ), function( $k ) { return strpos( $k, '_paksa_prod_' ) === 0; } );
WP_CLI::log( "Meta keys: " . count( $paksa_keys ) );

$check_keys = array( 'hero_heading', 'overview_heading', 'features_list', 'modules_list', 'benefits_list', 'industries_list', 'faq_items', 'cta_heading' );
foreach ( $check_keys as $k ) {
    $v = get_post_meta( $id, '_paksa_prod_' . $k, true );
    WP_CLI::log( "  $k: " . ( $v ? substr( $v, 0, 60 ) . '...' : 'EMPTY' ) );
}

WP_CLI::success( "Verification complete." );
