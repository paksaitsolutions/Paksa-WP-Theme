<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Pattern: Contact Section with Form
 *
 * @package paksa-it-solutions
 */
register_block_pattern( 'paksa/contact-section', array(
    'title'      => __( 'Contact Section', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-forms', 'paksa-conversion' ),
    'content'    => '<!-- wp:paksa/section {"variant":"alt"} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<!-- wp:columns {"isStackedOnMobile":true} -->
<!-- wp:column {"width":"45%"} -->
<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Get in Touch</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p class="has-text-color" style="color:#555f6d">Tell us about your project and we\'ll get back to you within one business day.</p><!-- /wp:paragraph -->
<!-- wp:list {"className":"pk-icon-list"} -->
<ul class="wp-block-list pk-icon-list"><li>Free initial consultation</li><li>No obligation quote</li><li>Expert advice</li></ul>
<!-- /wp:list -->
<!-- /wp:column -->
<!-- wp:column {"width":"55%"} -->
<!-- wp:paksa/form {"variant":"default","submitLabel":"Send Message","fields":"[{\"type\":\"text\",\"name\":\"name\",\"label\":\"Full Name\",\"required\":true,\"width\":50},{\"type\":\"email\",\"name\":\"email\",\"label\":\"Email Address\",\"required\":true,\"width\":50},{\"type\":\"tel\",\"name\":\"phone\",\"label\":\"Phone\",\"required\":false,\"width\":50},{\"type\":\"text\",\"name\":\"company\",\"label\":\"Company\",\"required\":false,\"width\":50},{\"type\":\"textarea\",\"name\":\"message\",\"label\":\"Message\",\"required\":true,\"width\":100}]"} /-->
<!-- /wp:column -->
<!-- /wp:columns -->
<!-- /wp:group -->
<!-- /wp:paksa/section -->',
) );
