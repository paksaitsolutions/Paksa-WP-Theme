<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

register_block_pattern( 'paksa-it-solutions/home-process', array(
    'title'      => __( 'Home — How We Work', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-home' ),
    'content'    => '<!-- wp:group {"className":"section pk-process","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group section pk-process" style="padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)">

<!-- wp:group {"className":"section-header","style":{"spacing":{"margin":{"bottom":"3rem"}}}} -->
<div class="wp-block-group section-header" style="margin-bottom:3rem">
<!-- wp:paragraph {"align":"center","className":"eyebrow","textColor":"accent","style":{"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"0.8rem"}}} -->
<p class="has-text-align-center eyebrow has-accent-color has-text-color" style="font-weight:600;text-transform:uppercase;letter-spacing:0.1em;font-size:0.8rem">Our Process</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2,"textAlign":"center","style":{"typography":{"fontWeight":"700"}}} -->
<h2 class="wp-block-heading has-text-align-center" style="font-weight:700">How We Work</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.05rem"}}} -->
<p class="has-text-align-center" style="font-size:1.05rem">A structured approach that moves from business understanding to deployed, evolving technology.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"1.5rem"}}}} -->
<div class="wp-block-columns">

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"1.75rem","bottom":"1.75rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-group" style="border-radius:10px;border:1px solid #e2e8f0;padding:1.75rem 1.5rem">
<!-- wp:paragraph {"textColor":"accent","style":{"typography":{"fontWeight":"800","fontSize":"2.5rem"}}} -->
<p class="has-accent-color has-text-color" style="font-weight:800;font-size:2.5rem">01</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.05rem","fontWeight":"700"}}} -->
<h3 class="wp-block-heading" style="font-size:1.05rem;font-weight:700">Discover</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9rem"}}} -->
<p style="font-size:0.9rem">Understand the business, workflows, data requirements and operational context before any technical decisions.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"1.75rem","bottom":"1.75rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-group" style="border-radius:10px;border:1px solid #e2e8f0;padding:1.75rem 1.5rem">
<!-- wp:paragraph {"textColor":"accent","style":{"typography":{"fontWeight":"800","fontSize":"2.5rem"}}} -->
<p class="has-accent-color has-text-color" style="font-weight:800;font-size:2.5rem">02</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.05rem","fontWeight":"700"}}} -->
<h3 class="wp-block-heading" style="font-size:1.05rem;font-weight:700">Design</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9rem"}}} -->
<p style="font-size:0.9rem">Define the solution architecture, system design and implementation strategy aligned to business objectives.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"1.75rem","bottom":"1.75rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-group" style="border-radius:10px;border:1px solid #e2e8f0;padding:1.75rem 1.5rem">
<!-- wp:paragraph {"textColor":"accent","style":{"typography":{"fontWeight":"800","fontSize":"2.5rem"}}} -->
<p class="has-accent-color has-text-color" style="font-weight:800;font-size:2.5rem">03</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.05rem","fontWeight":"700"}}} -->
<h3 class="wp-block-heading" style="font-size:1.05rem;font-weight:700">Build</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9rem"}}} -->
<p style="font-size:0.9rem">Develop the software, integrations and data layers with quality and maintainability as core requirements.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px","color":"#e2e8f0","width":"1px"},"spacing":{"padding":{"top":"1.75rem","bottom":"1.75rem","left":"1.5rem","right":"1.5rem"}}}} -->
<div class="wp-block-group" style="border-radius:10px;border:1px solid #e2e8f0;padding:1.75rem 1.5rem">
<!-- wp:paragraph {"textColor":"accent","style":{"typography":{"fontWeight":"800","fontSize":"2.5rem"}}} -->
<p class="has-accent-color has-text-color" style="font-weight:800;font-size:2.5rem">04</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"1.05rem","fontWeight":"700"}}} -->
<h3 class="wp-block-heading" style="font-size:1.05rem;font-weight:700">Deploy</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.9rem"}}} -->
<p style="font-size:0.9rem">Test, integrate and deploy the solution with structured handover, training and go-live support.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:group {"style":{"border":{"radius":"10px"},"spacing":{"padding":{"top":"1.75rem","bottom":"1.75rem","left":"1.5rem","right":"1.5rem"}}},"backgroundColor":"primary"} -->
<div class="wp-block-group has-primary-background-color has-background" style="border-radius:10px;padding:1.75rem 1.5rem">
<!-- wp:paragraph {"textColor":"accent","style":{"typography":{"fontWeight":"800","fontSize":"2.5rem"}}} -->
<p class="has-accent-color has-text-color" style="font-weight:800;font-size:2.5rem">05</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"textColor":"white","style":{"typography":{"fontSize":"1.05rem","fontWeight":"700"}}} -->
<h3 class="wp-block-heading has-white-color has-text-color" style="font-size:1.05rem;font-weight:700">Evolve</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"white","style":{"typography":{"fontSize":"0.9rem"}}} -->
<p class="has-white-color has-text-color" style="font-size:0.9rem">Continuously improve the platform as the business grows, requirements change and new opportunities emerge.</p>
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
