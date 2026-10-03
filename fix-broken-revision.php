<?php
global $wpdb;

// Show the revision content
$rev = get_post( 113 );
WP_CLI::log( "Revision ID: 113" );
WP_CLI::log( "Parent post ID: " . $rev->post_parent );
WP_CLI::log( "Revision content:" );
WP_CLI::log( $rev->post_content );
WP_CLI::log( "---" );

// Get parent post
$parent_id = $rev->post_parent;
$parent    = get_post( $parent_id );
WP_CLI::log( "Parent: [{$parent->post_type}] {$parent->post_title} (ID {$parent_id})" );
WP_CLI::log( "Parent post_content length: " . strlen( $parent->post_content ) );

// Delete all revisions for this post
$revisions = $wpdb->get_col( $wpdb->prepare(
    "SELECT ID FROM {$wpdb->posts} WHERE post_parent = %d AND post_type = 'revision'",
    $parent_id
) );

WP_CLI::log( "Revisions found: " . count( $revisions ) );

foreach ( $revisions as $rid ) {
    wp_delete_post_revision( (int) $rid );
    WP_CLI::log( "Deleted revision ID: $rid" );
}

WP_CLI::success( "All revisions deleted for post ID $parent_id." );
