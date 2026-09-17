<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

register_block_pattern( 'paksa-it-solutions/home-why-us', array(
    'title'      => __( 'Home — Why Us', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-home' ),
    'content'    => '<!-- wp:group {"className":"section section-alt pk-why","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group section section-alt pk-why" style="padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)">

<!-- wp:group {"className":"section-header","style":{"spacing":{"margin":{"bottom":"3rem"}}}} -->
<div class="wp-block-group section-header" style="margin-bottom:3rem">
<!-- wp:paragraph {"align":"center","className":"eyebrow","textColor":"accent","style":{"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"0.8rem"}}} -->
<p class="has-text-align-center eyebrow has-accent-color has-text-color" style="font-weight:600;text-transform:uppercase;letter-spacing:0.1em;font-size:0.8rem">Why Us</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2,"textAlign":"center","style":{"typography":{"fontWeight":"700"}}} -->
<h2 class="wp-block-heading has-text-align-center" style="font-weight:700">Technology With Business Thinking Behind It.</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.05rem"}}} -->
<p class="has-text-align-center" style="font-size:1.05rem">We combine deep technical capability with genuine understanding of how businesses operate.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"1.5rem","left":"1.5rem"}}}} -->
<div class="wp-block-columns">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"1.75rem","bottom":"1.75rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-group" style="border-radius:10px;border:1px solid #e2e8f0;padding:1.75rem 1.5rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1rem","fontWeight":"700"}}} --><h3 class="wp-block-heading" style="font-size:1rem;font-weight:700">Business-First Engineering</h3><!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9rem"}}} --><p style="font-size:0.9rem">Technology decisions begin with understanding the business — its operations, constraints and objectives.</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"1.75rem","bottom":"1.75rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-group" style="border-radius:10px;border:1px solid #e2e8f0;padding:1.75rem 1.5rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1rem","fontWeight":"700"}}} --><h3 class="wp-block-heading" style="font-size:1rem;font-weight:700">Intelligent by Design</h3><!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9rem"}}} --><p style="font-size:0.9rem">AI is applied where it creates meaningful, measurable value — not as a marketing feature.</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"1.75rem","bottom":"1.75rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-group" style="border-radius:10px;border:1px solid #e2e8f0;padding:1.75rem 1.5rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1rem","fontWeight":"700"}}} --><h3 class="wp-block-heading" style="font-size:1rem;font-weight:700">Scalable Architecture</h3><!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9rem"}}} --><p style="font-size:0.9rem">Solutions are designed to evolve as the business grows, without requiring complete rebuilds.</p><!-- /wp:paragraph -->
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
<!-- wp:group {"style":{"border":{"radius":"10px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"1.75rem","bottom":"1.75rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-group" style="border-radius:10px;border:1px solid #e2e8f0;padding:1.75rem 1.5rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1rem","fontWeight":"700"}}} --><h3 class="wp-block-heading" style="font-size:1rem;font-weight:700">Connected Systems</h3><!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9rem"}}} --><p style="font-size:0.9rem">Data and workflows are designed to work together rather than remaining isolated in separate systems.</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"1.75rem","bottom":"1.75rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-group" style="border-radius:10px;border:1px solid #e2e8f0;padding:1.75rem 1.5rem">
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1rem","fontWeight":"700"}}} --><h3 class="wp-block-heading" style="font-size:1rem;font-weight:700">Security &amp; Governance</h3><!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9rem"}}} --><p style="font-size:0.9rem">Security, permissions and accountability are considered from the architecture level — not added later.</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px"},"spacing":{"padding":{"top":"1.75rem","bottom":"1.75rem","left":"1.5rem","right":"1.5rem"}}},"backgroundColor":"primary"} -->
<div class="wp-block-group has-primary-background-color has-background" style="border-radius:10px;padding:1.75rem 1.5rem">
<!-- wp:heading {"level":3,"textColor":"white","style":{"typography":{"fontSize":"1rem","fontWeight":"700"}}} --><h3 class="wp-block-heading has-white-color has-text-color" style="font-size:1rem;font-weight:700">Long-Term Partnership</h3><!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"white","style":{"typography":{"fontSize":"0.9rem"}}} --><p class="has-white-color has-text-color" style="font-size:0.9rem">We build for sustainable use and ongoing evolution — not just initial deployment and handover.</p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->',
) );
