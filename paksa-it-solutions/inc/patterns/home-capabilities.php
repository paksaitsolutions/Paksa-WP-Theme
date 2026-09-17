<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

register_block_pattern( 'paksa-it-solutions/home-capabilities', array(
    'title'      => __( 'Home — Capabilities', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-home' ),
    'content'    => '<!-- wp:group {"className":"section section-alt pk-capabilities","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group section section-alt pk-capabilities" style="padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)">

<!-- wp:group {"className":"section-header","style":{"spacing":{"margin":{"bottom":"3rem"}}}} -->
<div class="wp-block-group section-header" style="margin-bottom:3rem">
<!-- wp:paragraph {"align":"center","className":"eyebrow","textColor":"accent","style":{"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"0.8rem"}}} -->
<p class="has-text-align-center eyebrow has-accent-color has-text-color" style="font-weight:600;text-transform:uppercase;letter-spacing:0.1em;font-size:0.8rem">What We Build</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2,"textAlign":"center","style":{"typography":{"fontWeight":"700"}}} -->
<h2 class="wp-block-heading has-text-align-center" style="font-weight:700">Technology Built Around Your Business</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.05rem"}}} -->
<p class="has-text-align-center" style="font-size:1.05rem">From enterprise platforms to intelligent automation — we build the systems that power serious business operations.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"1.5rem","left":"1.5rem"}}}} -->
<div class="wp-block-columns">

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pk-cap-card pk-cap-card--featured","style":{"border":{"radius":"12px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"1.75rem","right":"1.75rem"}}},"backgroundColor":"primary"} -->
<div class="wp-block-group pk-cap-card pk-cap-card--featured has-primary-background-color has-background" style="border-radius:12px;padding:2rem 1.75rem">
<!-- wp:heading {"level":3,"textColor":"white","style":{"typography":{"fontSize":"1.1rem","fontWeight":"700"}}} -->
<h3 class="wp-block-heading has-white-color has-text-color" style="font-size:1.1rem;font-weight:700">Enterprise Software</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"white","style":{"typography":{"fontSize":"0.95rem"}}} -->
<p class="has-white-color has-text-color" style="font-size:0.95rem">Business platforms designed around operational requirements — finance, inventory, HR, procurement and more.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pk-cap-card","style":{"border":{"radius":"12px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"1.75rem","right":"1.75rem"}}}} -->
<div class="wp-block-group pk-cap-card" style="border-radius:12px;border:1px solid #e2e8f0;padding:2rem 1.75rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.1rem","fontWeight":"700"}}} -->
<h3 class="wp-block-heading" style="font-size:1.1rem;font-weight:700">Custom Software</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.95rem"}}} -->
<p style="font-size:0.95rem">Purpose-built applications for unique workflows and processes that off-the-shelf software cannot address.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pk-cap-card pk-cap-card--featured","style":{"border":{"radius":"12px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"1.75rem","right":"1.75rem"}}},"backgroundColor":"primary"} -->
<div class="wp-block-group pk-cap-card pk-cap-card--featured has-primary-background-color has-background" style="border-radius:12px;padding:2rem 1.75rem">
<!-- wp:heading {"level":3,"textColor":"white","style":{"typography":{"fontSize":"1.1rem","fontWeight":"700"}}} -->
<h3 class="wp-block-heading has-white-color has-text-color" style="font-size:1.1rem;font-weight:700">AI &amp; Machine Learning</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"white","style":{"typography":{"fontSize":"0.95rem"}}} -->
<p class="has-white-color has-text-color" style="font-size:0.95rem">Predictive intelligence, automation and intelligent decision support built into your business systems.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"1.5rem","left":"1.5rem"},"margin":{"top":"1.5rem"}}}} -->
<div class="wp-block-columns" style="margin-top:1.5rem">

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pk-cap-card","style":{"border":{"radius":"12px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"1.75rem","right":"1.75rem"}}}} -->
<div class="wp-block-group pk-cap-card" style="border-radius:12px;border:1px solid #e2e8f0;padding:2rem 1.75rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.1rem","fontWeight":"700"}}} -->
<h3 class="wp-block-heading" style="font-size:1.1rem;font-weight:700">Business Intelligence</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.95rem"}}} -->
<p style="font-size:0.95rem">Dashboards, analytics and decision intelligence that turn operational data into clear business insight.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pk-cap-card","style":{"border":{"radius":"12px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"1.75rem","right":"1.75rem"}}}} -->
<div class="wp-block-group pk-cap-card" style="border-radius:12px;border:1px solid #e2e8f0;padding:2rem 1.75rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.1rem","fontWeight":"700"}}} -->
<h3 class="wp-block-heading" style="font-size:1.1rem;font-weight:700">Ecommerce Solutions</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.95rem"}}} -->
<p style="font-size:0.95rem">Connected commerce platforms and operational systems that integrate with your wider business infrastructure.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"className":"pk-cap-card","style":{"border":{"radius":"12px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"1.75rem","right":"1.75rem"}}}} -->
<div class="wp-block-group pk-cap-card" style="border-radius:12px;border:1px solid #e2e8f0;padding:2rem 1.75rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.1rem","fontWeight":"700"}}} -->
<h3 class="wp-block-heading" style="font-size:1.1rem;font-weight:700">System Integration</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.95rem"}}} -->
<p style="font-size:0.95rem">Connect ERP, ecommerce, APIs and business applications so data and workflows move without friction.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->',
) );
