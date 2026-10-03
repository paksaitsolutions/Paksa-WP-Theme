<?php
$p = get_posts( array( 'post_type' => 'paksa_product', 'name' => 'paksa-erp', 'numberposts' => 1 ) );
if ( ! $p ) { WP_CLI::error( 'Post not found' ); return; }
$id = $p[0]->ID;
WP_CLI::log( "Post ID: $id" );
WP_CLI::log( "post_content length: " . strlen( $p[0]->post_content ) );
WP_CLI::log( "post_content raw:" );
WP_CLI::log( $p[0]->post_content );
