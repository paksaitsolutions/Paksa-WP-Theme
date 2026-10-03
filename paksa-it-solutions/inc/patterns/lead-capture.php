<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Pattern: Lead Capture Section
 *
 * @package paksa-it-solutions
 */
register_block_pattern( 'paksa/lead-capture', array(
    'title'      => __( 'Lead Capture Section', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-forms', 'paksa-lead' ),
    'content'    => '<!-- wp:paksa/section {"variant":"dark"} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<!-- wp:heading {"textAlign":"center","level":2,"style":{"color":{"text":"#ffffff"}}} --><h2 class="wp-block-heading has-text-align-center" style="color:#ffffff">Ready to Get Started?</h2><!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","style":{"color":{"text":"rgba(255,255,255,0.65)"}}} --><p class="has-text-align-center" style="color:rgba(255,255,255,0.65)">Leave your details and we\'ll reach out within 24 hours.</p><!-- /wp:paragraph -->
<!-- wp:paksa/form {"variant":"dark","submitLabel":"Request a Callback","twoColumn":true,"fields":"[{\"type\":\"text\",\"name\":\"name\",\"label\":\"Your Name\",\"required\":true,\"width\":50},{\"type\":\"email\",\"name\":\"email\",\"label\":\"Email Address\",\"required\":true,\"width\":50},{\"type\":\"tel\",\"name\":\"phone\",\"label\":\"Phone Number\",\"required\":false,\"width\":50},{\"type\":\"text\",\"name\":\"company\",\"label\":\"Company\",\"required\":false,\"width\":50},{\"type\":\"consent\",\"name\":\"consent\",\"label\":\"I agree to be contacted about my enquiry\",\"required\":true,\"width\":100}]"} /-->
<!-- /wp:group -->
<!-- /wp:paksa/section -->',
) );
