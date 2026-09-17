<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

register_block_pattern( 'paksa-it-solutions/home-faq', array(
    'title'      => __( 'Home — FAQ', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-home' ),
    'content'    => '<!-- wp:group {"className":"section pk-faq","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group section pk-faq" style="padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)">

<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|10"}}}} -->
<div class="wp-block-columns">

<!-- wp:column {"width":"35%"} -->
<div class="wp-block-column" style="flex-basis:35%">
<!-- wp:paragraph {"className":"eyebrow","textColor":"accent","style":{"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"0.8rem"}}} -->
<p class="eyebrow has-accent-color has-text-color" style="font-weight:600;text-transform:uppercase;letter-spacing:0.1em;font-size:0.8rem">FAQ</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2,"style":{"typography":{"fontWeight":"700"}}} -->
<h2 class="wp-block-heading" style="font-weight:700">Common Questions</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"1rem"}}} -->
<p style="font-size:1rem">Everything you need to know about working with Paksa IT Solutions.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->

<!-- wp:column {"width":"65%"} -->
<div class="wp-block-column" style="flex-basis:65%">

<!-- wp:details {"className":"pk-faq-item","style":{"border":{"bottom":{"color":"#e2e8f0","width":"1px"}},"spacing":{"padding":{"top":"1.25rem","bottom":"1.25rem"}}}} -->
<details class="wp-block-details pk-faq-item" style="border-bottom:1px solid #e2e8f0;padding-top:1.25rem;padding-bottom:1.25rem" open>
<summary style="font-weight:600;font-size:1rem;cursor:pointer">What does Paksa IT Solutions do?</summary>
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0.75rem"}},"typography":{"fontSize":"0.95rem"}}} -->
<p style="margin-top:0.75rem;font-size:0.95rem">Paksa IT Solutions builds enterprise software, custom applications, AI-powered systems and business intelligence platforms for businesses that need serious, purpose-built technology.</p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->

<!-- wp:details {"className":"pk-faq-item","style":{"border":{"bottom":{"color":"#e2e8f0","width":"1px"}},"spacing":{"padding":{"top":"1.25rem","bottom":"1.25rem"}}}} -->
<details class="wp-block-details pk-faq-item" style="border-bottom:1px solid #e2e8f0;padding-top:1.25rem;padding-bottom:1.25rem">
<summary style="font-weight:600;font-size:1rem;cursor:pointer">What types of software does Paksa build?</summary>
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0.75rem"}},"typography":{"fontSize":"0.95rem"}}} -->
<p style="margin-top:0.75rem;font-size:0.95rem">We build ERP systems, custom business applications, AI and machine learning solutions, business intelligence dashboards, ecommerce platforms and system integrations — all designed around specific business requirements.</p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->

<!-- wp:details {"className":"pk-faq-item","style":{"border":{"bottom":{"color":"#e2e8f0","width":"1px"}},"spacing":{"padding":{"top":"1.25rem","bottom":"1.25rem"}}}} -->
<details class="wp-block-details pk-faq-item" style="border-bottom:1px solid #e2e8f0;padding-top:1.25rem;padding-bottom:1.25rem">
<summary style="font-weight:600;font-size:1rem;cursor:pointer">Do you build custom enterprise software?</summary>
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0.75rem"}},"typography":{"fontSize":"0.95rem"}}} -->
<p style="margin-top:0.75rem;font-size:0.95rem">Yes. Custom enterprise software is a core capability. We design and build platforms tailored to your specific operational workflows, data requirements and business processes.</p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->

<!-- wp:details {"className":"pk-faq-item","style":{"border":{"bottom":{"color":"#e2e8f0","width":"1px"}},"spacing":{"padding":{"top":"1.25rem","bottom":"1.25rem"}}}} -->
<details class="wp-block-details pk-faq-item" style="border-bottom:1px solid #e2e8f0;padding-top:1.25rem;padding-bottom:1.25rem">
<summary style="font-weight:600;font-size:1rem;cursor:pointer">Does Paksa provide AI and machine learning solutions?</summary>
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0.75rem"}},"typography":{"fontSize":"0.95rem"}}} -->
<p style="margin-top:0.75rem;font-size:0.95rem">Yes. We apply AI and machine learning where they create genuine business value — including predictive analytics, intelligent automation, anomaly detection and recommendation systems.</p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->

<!-- wp:details {"className":"pk-faq-item","style":{"border":{"bottom":{"color":"#e2e8f0","width":"1px"}},"spacing":{"padding":{"top":"1.25rem","bottom":"1.25rem"}}}} -->
<details class="wp-block-details pk-faq-item" style="border-bottom:1px solid #e2e8f0;padding-top:1.25rem;padding-bottom:1.25rem">
<summary style="font-weight:600;font-size:1rem;cursor:pointer">Can Paksa integrate existing business systems?</summary>
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0.75rem"}},"typography":{"fontSize":"0.95rem"}}} -->
<p style="margin-top:0.75rem;font-size:0.95rem">Yes. System integration is a core service. We connect ERP systems, ecommerce platforms, APIs and business applications so data and workflows move without friction across your operations.</p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->

<!-- wp:details {"className":"pk-faq-item","style":{"spacing":{"padding":{"top":"1.25rem","bottom":"1.25rem"}}}} -->
<details class="wp-block-details pk-faq-item" style="padding-top:1.25rem;padding-bottom:1.25rem">
<summary style="font-weight:600;font-size:1rem;cursor:pointer">How do we start a project with Paksa?</summary>
<!-- wp:paragraph {"style":{"spacing":{"margin":{"top":"0.75rem"}},"typography":{"fontSize":"0.95rem"}}} -->
<p style="margin-top:0.75rem;font-size:0.95rem">The first step is a consultation to understand your business, requirements and objectives. Contact us to arrange an initial discussion — there is no obligation and no cost for the initial conversation.</p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->

</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->',
) );
