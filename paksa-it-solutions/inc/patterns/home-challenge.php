<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

register_block_pattern( 'paksa-it-solutions/home-challenge', array(
    'title'      => __( 'Home — Business Challenge', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-home' ),
    'content'    => '<!-- wp:group {"className":"section pk-challenge","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group section pk-challenge" style="padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)">

<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|10"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center">

<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%">

<!-- wp:paragraph {"className":"eyebrow","textColor":"accent","style":{"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"0.8rem"}}} -->
<p class="eyebrow has-accent-color has-text-color" style="font-weight:600;text-transform:uppercase;letter-spacing:0.1em;font-size:0.8rem">The Problem</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"style":{"typography":{"fontWeight":"700"}}} -->
<h2 class="wp-block-heading" style="font-weight:700">Technology Should Solve Business Problems.</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.05rem"}}} -->
<p style="font-size:1.05rem">Most businesses operate with disconnected systems, manual processes and fragmented data. The result is slow decisions, limited visibility and missed opportunities.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"pk-challenge-problems","style":{"spacing":{"margin":{"top":"1.5rem"}}}} -->
<ul class="wp-block-list pk-challenge-problems" style="margin-top:1.5rem">
<!-- wp:list-item --><li>Disconnected systems</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>Manual processes</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>Fragmented data</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>Inefficient workflows</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>Limited reporting</li><!-- /wp:list-item -->
<!-- wp:list-item --><li>Slow decision-making</li><!-- /wp:list-item -->
</ul>
<!-- /wp:list -->

<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600","fontSize":"1.05rem"},"spacing":{"margin":{"top":"1.5rem"}}}} -->
<p style="font-weight:600;font-size:1.05rem;margin-top:1.5rem">We turn these challenges into connected digital systems.</p>
<!-- /wp:paragraph -->

</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">

<!-- wp:group {"style":{"border":{"radius":"12px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}}},"backgroundColor":"bg-alt"} -->
<div class="wp-block-group has-bg-alt-background-color has-background" style="border-radius:12px;padding:2rem">

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontWeight":"700","fontSize":"1rem"},"spacing":{"margin":{"bottom":"1.5rem"}}}} -->
<p class="has-text-align-center" style="font-weight:700;font-size:1rem;margin-bottom:1.5rem">The Transformation</p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"blockGap":"0.75rem"}}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"align":"center","style":{"border":{"radius":"8px"},"spacing":{"padding":{"top":"0.75rem","bottom":"0.75rem"}},"color":{"background":"#fee2e2","text":"#991b1b"},"typography":{"fontWeight":"600"}}} -->
<p class="has-text-align-center has-text-color has-background" style="border-radius:8px;padding-top:0.75rem;padding-bottom:0.75rem;background-color:#fee2e2;color:#991b1b;font-weight:600">Fragmented</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.25rem"}}} --><p class="has-text-align-center" style="font-size:1.25rem">↓</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"align":"center","style":{"border":{"radius":"8px"},"spacing":{"padding":{"top":"0.75rem","bottom":"0.75rem"}},"color":{"background":"#dbeafe","text":"#1e40af"},"typography":{"fontWeight":"600"}}} -->
<p class="has-text-align-center has-text-color has-background" style="border-radius:8px;padding-top:0.75rem;padding-bottom:0.75rem;background-color:#dbeafe;color:#1e40af;font-weight:600">Connected</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.25rem"}}} --><p class="has-text-align-center" style="font-size:1.25rem">↓</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"align":"center","style":{"border":{"radius":"8px"},"spacing":{"padding":{"top":"0.75rem","bottom":"0.75rem"}},"color":{"background":"#d1fae5","text":"#065f46"},"typography":{"fontWeight":"600"}}} -->
<p class="has-text-align-center has-text-color has-background" style="border-radius:8px;padding-top:0.75rem;padding-bottom:0.75rem;background-color:#d1fae5;color:#065f46;font-weight:600">Intelligent</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.25rem"}}} --><p class="has-text-align-center" style="font-size:1.25rem">↓</p><!-- /wp:paragraph -->
<!-- wp:paragraph {"align":"center","style":{"border":{"radius":"8px"},"spacing":{"padding":{"top":"0.75rem","bottom":"0.75rem"}},"backgroundColor":"accent","textColor":"white","typography":{"fontWeight":"700"}}} -->
<p class="has-text-align-center has-white-color has-accent-background-color has-text-color has-background" style="border-radius:8px;padding-top:0.75rem;padding-bottom:0.75rem;font-weight:700">Actionable</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->',
) );
