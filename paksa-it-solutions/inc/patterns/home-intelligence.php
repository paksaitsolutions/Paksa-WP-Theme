<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

register_block_pattern( 'paksa/home-intelligence', array(
    'title'      => __( 'Home — AI & Business Intelligence', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-home' ),
    'content'    => '<!-- wp:group {"className":"section section-alt pk-intelligence","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group section section-alt pk-intelligence" style="padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)">

<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|10"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center">

<!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">
<!-- wp:paragraph {"className":"eyebrow","textColor":"accent","style":{"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"0.8rem"}}} -->
<p class="eyebrow has-accent-color has-text-color" style="font-weight:600;text-transform:uppercase;letter-spacing:0.1em;font-size:0.8rem">AI &amp; Business Intelligence</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2,"style":{"typography":{"fontWeight":"700"}}} -->
<h2 class="wp-block-heading" style="font-weight:700">Turn Business Data Into Intelligence.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.05rem"}}} -->
<p style="font-size:1.05rem">We apply AI and analytics where they create genuine business value — not as a feature, but as a capability embedded in your operations.</p>
<!-- /wp:paragraph -->
<!-- wp:group {"style":{"spacing":{"margin":{"top":"2rem"},"blockGap":"0.5rem"}}} -->
<div class="wp-block-group" style="margin-top:2rem">
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.85rem","fontWeight":"600"}}} -->
<p style="font-size:0.85rem;font-weight:600">Data → Analytics → Patterns → Predictions → Decisions</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%">
<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"1rem","left":"1rem"}}}} -->
<div class="wp-block-columns">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"1.25rem","right":"1.25rem"}}}} -->
<div class="wp-block-group" style="border-radius:10px;border:1px solid #e2e8f0;padding:1.5rem 1.25rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"0.95rem","fontWeight":"700"}}} --><h3 class="wp-block-heading" style="font-size:0.95rem;font-weight:700">KPI Monitoring</h3><!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.85rem"}}} --><p style="font-size:0.85rem">Real-time visibility into the metrics that matter most to your business operations.</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"1.25rem","right":"1.25rem"}}}} -->
<div class="wp-block-group" style="border-radius:10px;border:1px solid #e2e8f0;padding:1.5rem 1.25rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"0.95rem","fontWeight":"700"}}} --><h3 class="wp-block-heading" style="font-size:0.95rem;font-weight:700">Predictive Analytics</h3><!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.85rem"}}} --><p style="font-size:0.85rem">Machine learning models that identify patterns and forecast future business outcomes.</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"1rem","left":"1rem"},"margin":{"top":"1rem"}}}} -->
<div class="wp-block-columns" style="margin-top:1rem">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"1.25rem","right":"1.25rem"}}}} -->
<div class="wp-block-group" style="border-radius:10px;border:1px solid #e2e8f0;padding:1.5rem 1.25rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"0.95rem","fontWeight":"700"}}} --><h3 class="wp-block-heading" style="font-size:0.95rem;font-weight:700">Anomaly Detection</h3><!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.85rem"}}} --><p style="font-size:0.85rem">Automated identification of unusual patterns in operational data before they become problems.</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px"},"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"1.25rem","right":"1.25rem"}}},"backgroundColor":"primary"} -->
<div class="wp-block-group has-primary-background-color has-background" style="border-radius:10px;padding:1.5rem 1.25rem">
<!-- wp:heading {"level":3,"textColor":"white","style":{"typography":{"fontSize":"0.95rem","fontWeight":"700"}}} --><h3 class="wp-block-heading has-white-color has-text-color" style="font-size:0.95rem;font-weight:700">Intelligent Recommendations</h3><!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"white","style":{"typography":{"fontSize":"0.85rem"}}} --><p class="has-white-color has-text-color" style="font-size:0.85rem">AI-driven suggestions that support better operational and strategic decisions.</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->',
) );
