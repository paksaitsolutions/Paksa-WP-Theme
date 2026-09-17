<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

register_block_pattern( 'paksa/home-trust-strip', array(
    'title'      => __( 'Home — Trust Strip', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-home' ),
    'content'    => '<!-- wp:group {"className":"pk-trust-strip","backgroundColor":"primary","layout":{"type":"constrained"}} -->
<div class="wp-block-group pk-trust-strip has-primary-background-color has-background">

<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"2rem"},"padding":{"top":"1.25rem","bottom":"1.25rem"}}}} -->
<div class="wp-block-columns" style="padding-top:1.25rem;padding-bottom:1.25rem">

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:paragraph {"align":"center","textColor":"white","style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-weight:600;font-size:0.9rem">⬡ Enterprise Software</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:paragraph {"align":"center","textColor":"white","style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-weight:600;font-size:0.9rem">⬡ AI &amp; Machine Learning</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:paragraph {"align":"center","textColor":"white","style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-weight:600;font-size:0.9rem">⬡ Business Intelligence</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:paragraph {"align":"center","textColor":"white","style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-weight:600;font-size:0.9rem">⬡ Custom Development</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:paragraph {"align":"center","textColor":"white","style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-weight:600;font-size:0.9rem">⬡ System Integration</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:paragraph {"align":"center","textColor":"white","style":{"typography":{"fontWeight":"600","fontSize":"0.9rem"}}} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-weight:600;font-size:0.9rem">⬡ Digital Transformation</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->',
) );
