<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

register_block_pattern( 'paksa-it-solutions/home-differentiation', array(
    'title'      => __( 'Home — How We Are Different', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-home' ),
    'content'    => '<!-- wp:group {"className":"section pk-differentiation","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group section pk-differentiation" style="padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)">

<!-- wp:group {"className":"section-header","style":{"spacing":{"margin":{"bottom":"3rem"}}}} -->
<div class="wp-block-group section-header" style="margin-bottom:3rem">
<!-- wp:paragraph {"align":"center","className":"eyebrow","textColor":"accent","style":{"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"0.8rem"}}} -->
<p class="has-text-align-center eyebrow has-accent-color has-text-color" style="font-weight:600;text-transform:uppercase;letter-spacing:0.1em;font-size:0.8rem">Our Difference</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2,"textAlign":"center","style":{"typography":{"fontWeight":"700"}}} -->
<h2 class="wp-block-heading has-text-align-center" style="font-weight:700">More Than Software Development.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.05rem"}}} -->
<p class="has-text-align-center" style="font-size:1.05rem">The difference between a technology vendor and a technology partner.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"0"}}}} -->
<div class="wp-block-columns">

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px 0 0 10px"},"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"1.5rem","right":"1.5rem"}},"color":{"background":"#f1f5f9"}}} -->
<div class="wp-block-group has-background" style="border-radius:10px 0 0 10px;padding:1.5rem;background-color:#f1f5f9">
<!-- wp:heading {"level":4,"style":{"typography":{"fontSize":"0.85rem","fontWeight":"700","textTransform":"uppercase","letterSpacing":"0.05em"},"color":{"text":"#64748b"}}} -->
<h4 class="wp-block-heading has-text-color" style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:#64748b">Traditional Approach</h4>
<!-- /wp:heading -->
<!-- wp:list {"style":{"spacing":{"margin":{"top":"1rem"}},"color":{"text":"#64748b"}}} -->
<ul class="wp-block-list has-text-color" style="margin-top:1rem;color:#64748b">
<!-- wp:list-item --><li>Software delivery</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>Static reporting</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>Manual workflows</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>Disconnected systems</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>Historical data</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>Fixed implementation</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>Project completion</li><!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"0 10px 10px 0"},"spacing":{"padding":{"top":"1.5rem","bottom":"1.5rem","left":"1.5rem","right":"1.5rem"}}},"backgroundColor":"primary"} -->
<div class="wp-block-group has-primary-background-color has-background" style="border-radius:0 10px 10px 0;padding:1.5rem">
<!-- wp:heading {"level":4,"textColor":"accent","style":{"typography":{"fontSize":"0.85rem","fontWeight":"700","textTransform":"uppercase","letterSpacing":"0.05em"}}} -->
<h4 class="wp-block-heading has-accent-color has-text-color" style="font-size:0.85rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em">Paksa Approach</h4>
<!-- /wp:heading -->
<!-- wp:list {"textColor":"white","style":{"spacing":{"margin":{"top":"1rem"}}}} -->
<ul class="wp-block-list has-white-color has-text-color" style="margin-top:1rem">
<!-- wp:list-item --><li>✓ Business solution</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>✓ Intelligent analytics</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>✓ Intelligent automation</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>✓ Integrated ecosystem</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>✓ Predictive intelligence</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>✓ Modular architecture</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>✓ Long-term evolution</li><!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->',
) );
