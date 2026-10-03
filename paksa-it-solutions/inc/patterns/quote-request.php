<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Pattern: Request a Quote
 *
 * @package paksa-it-solutions
 */
register_block_pattern( 'paksa/quote-request', array(
    'title'      => __( 'Request a Quote', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-forms', 'paksa-conversion' ),
    'content'    => '<!-- wp:paksa/section {"variant":"default"} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Request a Quote</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p class="has-text-color" style="color:#555f6d">Fill in the form below and we\'ll prepare a tailored proposal for your project.</p><!-- /wp:paragraph -->
<!-- wp:paksa/form {"variant":"default","submitLabel":"Get My Quote","includeContext":false,"fields":"[{\"type\":\"text\",\"name\":\"name\",\"label\":\"Full Name\",\"required\":true,\"width\":50},{\"type\":\"email\",\"name\":\"email\",\"label\":\"Email\",\"required\":true,\"width\":50},{\"type\":\"tel\",\"name\":\"phone\",\"label\":\"Phone\",\"required\":false,\"width\":50},{\"type\":\"text\",\"name\":\"company\",\"label\":\"Company\",\"required\":false,\"width\":50},{\"type\":\"select\",\"name\":\"service\",\"label\":\"Service Required\",\"required\":true,\"width\":100,\"options\":\"Software Development\\nERP Implementation\\nBusiness Intelligence\\nAI & Automation\\nOther\"},{\"type\":\"textarea\",\"name\":\"message\",\"label\":\"Project Details\",\"required\":true,\"width\":100,\"placeholder\":\"Describe your project, goals, and timeline...\"}]"} /-->
<!-- /wp:group -->
<!-- /wp:paksa/section -->',
) );
