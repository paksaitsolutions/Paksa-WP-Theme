<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Pattern: Newsletter Signup
 *
 * @package paksa-it-solutions
 */
register_block_pattern( 'paksa/newsletter-signup', array(
    'title'      => __( 'Newsletter Signup', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-forms', 'paksa-lead' ),
    'content'    => '<!-- wp:paksa/section {"variant":"dark"} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}}} -->
<!-- wp:columns {"isStackedOnMobile":true,"verticalAlignment":"center"} -->
<!-- wp:column {"width":"55%"} -->
<!-- wp:heading {"level":2,"style":{"color":{"text":"#ffffff"}}} --><h2 class="wp-block-heading" style="color:#ffffff">Stay in the Loop</h2><!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"rgba(255,255,255,0.65)"}}} --><p style="color:rgba(255,255,255,0.65)">Get the latest insights on enterprise software, AI, and digital transformation.</p><!-- /wp:paragraph -->
<!-- /wp:column -->
<!-- wp:column {"width":"45%"} -->
<!-- wp:paksa/form {"variant":"dark","submitLabel":"Subscribe","fields":"[{\"type\":\"text\",\"name\":\"name\",\"label\":\"Name\",\"required\":true,\"width\":100},{\"type\":\"email\",\"name\":\"email\",\"label\":\"Email Address\",\"required\":true,\"width\":100},{\"type\":\"consent\",\"name\":\"consent\",\"label\":\"I agree to receive email updates\",\"required\":true,\"width\":100}]"} /-->
<!-- /wp:column -->
<!-- /wp:columns -->
<!-- /wp:group -->
<!-- /wp:paksa/section -->',
) );
