<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Pattern: Product Inquiry Form
 * Uses includeContext to pass current product title server-side.
 *
 * @package paksa-it-solutions
 */
register_block_pattern( 'paksa/product-inquiry', array(
    'title'      => __( 'Product Inquiry', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-forms', 'paksa-conversion' ),
    'content'    => '<!-- wp:paksa/section {"variant":"alt"} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}}} -->
<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Enquire About This Product</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p class="has-text-color" style="color:#555f6d">Have questions or want a demo? Fill in the form and our team will be in touch.</p><!-- /wp:paragraph -->
<!-- wp:paksa/form {"variant":"default","submitLabel":"Send Enquiry","includeContext":true,"contextLabel":"Product","fields":"[{\"type\":\"text\",\"name\":\"name\",\"label\":\"Your Name\",\"required\":true,\"width\":50},{\"type\":\"email\",\"name\":\"email\",\"label\":\"Email Address\",\"required\":true,\"width\":50},{\"type\":\"tel\",\"name\":\"phone\",\"label\":\"Phone\",\"required\":false,\"width\":50},{\"type\":\"text\",\"name\":\"company\",\"label\":\"Company\",\"required\":false,\"width\":50},{\"type\":\"textarea\",\"name\":\"message\",\"label\":\"Your Question\",\"required\":true,\"width\":100}]"} /-->
<!-- /wp:group -->
<!-- /wp:paksa/section -->',
) );
