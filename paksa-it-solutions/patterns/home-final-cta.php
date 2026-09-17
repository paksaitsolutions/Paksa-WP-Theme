<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

register_block_pattern( 'paksa/home-final-cta', array(
    'title'      => __( 'Home — Final CTA', 'paksa-it-solutions' ),
    'categories' => array( 'paksa-home' ),
    'content'    => '<!-- wp:group {"className":"pk-final-cta","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"backgroundColor":"primary","layout":{"type":"constrained"}} -->
<div class="wp-block-group pk-final-cta has-primary-background-color has-background" style="padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)">

<!-- wp:group {"style":{"spacing":{"padding":{"top":"3rem","bottom":"3rem","left":"3rem","right":"3rem"},"margin":{"top":"0","bottom":"0"}},"border":{"radius":"16px"},"color":{"background":"rgba(255,255,255,0.06)"}},"layout":{"type":"constrained","contentSize":"720px"}} -->
<div class="wp-block-group has-background" style="border-radius:16px;padding:3rem;background-color:rgba(255,255,255,0.06)">

<!-- wp:paragraph {"align":"center","className":"eyebrow","textColor":"accent","style":{"typography":{"fontWeight":"600","textTransform":"uppercase","letterSpacing":"0.1em","fontSize":"0.8rem"}}} -->
<p class="has-text-align-center eyebrow has-accent-color has-text-color" style="font-weight:600;text-transform:uppercase;letter-spacing:0.1em;font-size:0.8rem">Get Started</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"textAlign":"center","textColor":"white","style":{"typography":{"fontWeight":"700","fontSize":"clamp(2rem,4vw,3rem)"}}} -->
<h2 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="font-weight:700;font-size:clamp(2rem,4vw,3rem)">Have a Business Challenge?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"white","style":{"typography":{"fontSize":"1.1rem"},"spacing":{"margin":{"top":"1rem","bottom":"2rem"}}}} -->
<p class="has-text-align-center has-white-color has-text-color" style="font-size:1.1rem;margin-top:1rem;margin-bottom:2rem">Let&#39;s turn your requirements into a technology solution built for the way your business works.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"blockGap":"1rem"}}} -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"accent","textColor":"white","className":"btn btn-primary"} -->
<div class="wp-block-button btn btn-primary"><a class="wp-block-button__link has-white-color has-accent-background-color has-text-color has-background wp-element-button">Get a Free Consultation</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"btn btn-outline","style":{"border":{"color":"rgba(255,255,255,0.5)","width":"2px"},"color":{"text":"#ffffff","background":"transparent"}}} -->
<div class="wp-block-button btn btn-outline"><a class="wp-block-button__link wp-element-button" style="border-color:rgba(255,255,255,0.5);border-width:2px;color:#ffffff;background-color:transparent">Discuss Your Project</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->',
) );
