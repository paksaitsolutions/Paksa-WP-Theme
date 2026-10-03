<?php
global $wpdb;

$search = 'pk-pattern-media';

$results = $wpdb->get_results( $wpdb->prepare(
    "SELECT ID, post_title, post_type, post_status, LENGTH(post_content) as content_len
     FROM {$wpdb->posts}
     WHERE post_content LIKE %s
     AND post_status NOT IN ('auto-draft','inherit')",
    '%' . $wpdb->esc_like( $search ) . '%'
) );

if ( ! $results ) {
    // Also check revisions
    $results = $wpdb->get_results( $wpdb->prepare(
        "SELECT ID, post_title, post_type, post_status, LENGTH(post_content) as content_len
         FROM {$wpdb->posts}
         WHERE post_content LIKE %s",
        '%' . $wpdb->esc_like( $search ) . '%'
    ) );
    WP_CLI::log( "Found in revisions/all:" );
}

if ( ! $results ) {
    WP_CLI::log( "Not found by pk-pattern-media. Searching wp-block-cover..." );
    $results = $wpdb->get_results( $wpdb->prepare(
        "SELECT ID, post_title, post_type, post_status, LENGTH(post_content) as content_len
         FROM {$wpdb->posts}
         WHERE post_content LIKE %s
         AND post_status NOT IN ('auto-draft')",
        '%' . $wpdb->esc_like( 'wp-block-cover' ) . '%'
    ) );
}

foreach ( $results as $r ) {
    WP_CLI::log( "ID:{$r->ID} | type:{$r->post_type} | status:{$r->post_status} | len:{$r->content_len} | title:{$r->post_title}" );
}

if ( ! $results ) {
    WP_CLI::log( "No posts found. Checking all non-empty post_content..." );
    $all = $wpdb->get_results(
        "SELECT ID, post_title, post_type, post_status, LENGTH(post_content) as content_len
         FROM {$wpdb->posts}
         WHERE post_content != ''
         AND post_status NOT IN ('auto-draft','inherit')
         ORDER BY ID DESC LIMIT 20"
    );
    foreach ( $all as $r ) {
        WP_CLI::log( "ID:{$r->ID} | type:{$r->post_type} | status:{$r->post_status} | len:{$r->content_len} | title:{$r->post_title}" );
    }
}

WP_CLI::success( "Done." );
