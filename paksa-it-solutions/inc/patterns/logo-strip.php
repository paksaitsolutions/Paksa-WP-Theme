<?php
/**
 * Paksa — Block Pattern: Logo Strip
 *
 * A responsive logo strip using paksa/logo-strip.
 * Replace placeholder text with logo images from the Media Library.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

register_block_pattern(
    'paksa-it-solutions/logo-strip',
    array(
        'title'      => __( 'Logo Strip — Partner Logos', 'paksa-it-solutions' ),
        'categories' => array( 'paksa-social-proof' ),
        'keywords'   => array( 'logos', 'partners', 'clients', 'trust' ),
        'viewport'   => array( 'width' => 1280, 'height' => 200 ),
        'content'    => '<!-- wp:paksa/logo-strip {"logoSize":120,"grayscale":true,"alignment":"center","columns":5} -->'
        . '<div class="wp-block-paksa-logo-strip">'
        . '<!-- wp:paragraph {"className":"pk-pattern-logo"} -->'
        . '<p class="pk-pattern-logo">Partner One</p>'
        . '<!-- /wp:paragraph -->'
        . '<!-- wp:paragraph {"className":"pk-pattern-logo"} -->'
        . '<p class="pk-pattern-logo">Partner Two</p>'
        . '<!-- /wp:paragraph -->'
        . '<!-- wp:paragraph {"className":"pk-pattern-logo"} -->'
        . '<p class="pk-pattern-logo">Partner Three</p>'
        . '<!-- /wp:paragraph -->'
        . '<!-- wp:paragraph {"className":"pk-pattern-logo"} -->'
        . '<p class="pk-pattern-logo">Partner Four</p>'
        . '<!-- /wp:paragraph -->'
        . '<!-- wp:paragraph {"className":"pk-pattern-logo"} -->'
        . '<p class="pk-pattern-logo">Partner Five</p>'
        . '<!-- /wp:paragraph -->'
        . '</div><!-- /wp:paksa/logo-strip -->',
    )
);
