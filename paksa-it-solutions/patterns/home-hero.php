<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

register_block_pattern( 'paksa/home-hero', array(
    'title'      => __( 'Home — Hero', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-home' ),
    'content'    => '<!-- wp:group {"className":"pk-hero","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"backgroundColor":"bg-dark","layout":{"type":"constrained"}} -->
<div class="wp-block-group pk-hero has-bg-dark-background-color has-background">

<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"0","left":"var:preset|spacing|10"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center">

<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%">

<!-- wp:paragraph {"className":"eyebrow","textColor":"accent","style":{"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"0.8rem"}}} -->
<p class="eyebrow has-accent-color has-text-color" style="font-weight:600;text-transform:uppercase;letter-spacing:0.1em;font-size:0.8rem">Enterprise Technology Solutions</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"textColor":"white","style":{"typography":{"fontSize":"clamp(2.5rem,5vw,4rem)","fontWeight":"700","lineHeight":"1.15"}}} -->
<h1 class="wp-block-heading has-white-color has-text-color" style="font-size:clamp(2.5rem,5vw,4rem);font-weight:700;line-height:1.15">Technology That Moves Business Forward</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"white","style":{"typography":{"fontSize":"1.25rem","fontWeight":"600"}}} -->
<p class="has-white-color has-text-color" style="font-size:1.25rem;font-weight:600">Build Smarter. Operate Better. Grow With Confidence.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"white","style":{"typography":{"fontSize":"1.05rem"},"spacing":{"margin":{"top":"var:preset|spacing|4"}}}} -->
<p class="has-white-color has-text-color" style="font-size:1.05rem;margin-top:var(--wp--preset--spacing--4)">Paksa IT Solutions builds enterprise software, AI-powered solutions and intelligent digital systems designed around real business challenges.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|6"},"blockGap":"1rem"}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--6)">
<!-- wp:button {"backgroundColor":"accent","textColor":"white","className":"btn btn-primary"} -->
<div class="wp-block-button btn btn-primary"><a class="wp-block-button__link has-white-color has-accent-background-color has-text-color has-background wp-element-button">Get a Free Consultation</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"btn btn-outline","style":{"border":{"color":"#ffffff","width":"2px"},"color":{"text":"#ffffff","background":"transparent"}}} -->
<div class="wp-block-button btn btn-outline"><a class="wp-block-button__link wp-element-button" style="border-color:#ffffff;border-width:2px;color:#ffffff;background-color:transparent">Explore Our Solutions</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">

<!-- wp:group {"className":"pk-hero-visual","style":{"border":{"radius":"12px"},"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}}},"backgroundColor":"primary"} -->
<div class="wp-block-group pk-hero-visual has-primary-background-color has-background" style="border-radius:12px;padding:2rem">

<!-- wp:paragraph {"align":"center","textColor":"white","style":{"typography":{"fontWeight":"700","fontSize":"1rem"}}} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-weight:700;font-size:1rem">Enterprise Platform</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"1rem"},"margin":{"top":"1rem"}}}} -->
<div class="wp-block-columns" style="margin-top:1rem">
<!-- wp:column {"width":"33%"} -->
<div class="wp-block-column" style="flex-basis:33%">
<!-- wp:paragraph {"align":"center","textColor":"accent","style":{"typography":{"fontSize":"2rem","fontWeight":"700"}}} -->
<p class="has-text-align-center has-accent-color has-text-color" style="font-size:2rem;font-weight:700">AI</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"33%"} -->
<div class="wp-block-column" style="flex-basis:33%">
<!-- wp:paragraph {"align":"center","textColor":"accent","style":{"typography":{"fontSize":"2rem","fontWeight":"700"}}} -->
<p class="has-text-align-center has-accent-color has-text-color" style="font-size:2rem;font-weight:700">BI</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"width":"33%"} -->
<div class="wp-block-column" style="flex-basis:33%">
<!-- wp:paragraph {"align":"center","textColor":"accent","style":{"typography":{"fontSize":"2rem","fontWeight":"700"}}} -->
<p class="has-text-align-center has-accent-color has-text-color" style="font-size:2rem;font-weight:700">ERP</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->',
) );
