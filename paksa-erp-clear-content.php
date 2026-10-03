<?php
$p = get_posts( array( 'post_type' => 'paksa_product', 'name' => 'paksa-erp', 'numberposts' => 1 ) );
if ( ! $p ) { WP_CLI::error( 'Post not found' ); return; }
$id = $p[0]->ID;

wp_update_post( array(
    'ID'           => $id,
    'post_content' => '',
) );

WP_CLI::success( "post_content cleared for post ID $id." );
