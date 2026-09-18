<?php
/**
 * Paksa Theme — advanced builder extensions.
 *
 * This file extends the Phase 14 core-block pattern system. It uses its
 * established helpers rather than introducing another markup or persistence
 * architecture.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register focused, task-oriented pattern categories.
 */
function paksa_register_advanced_pattern_categories() {
    if ( ! function_exists( 'register_block_pattern_category' ) ) {
        return;
    }

    $categories = array(
        'paksa-heroes'       => __( 'Paksa Heroes', 'paksa-it-solutions' ),
        'paksa-features'     => __( 'Paksa Features', 'paksa-it-solutions' ),
        'paksa-about'        => __( 'Paksa About', 'paksa-it-solutions' ),
        'paksa-products'     => __( 'Paksa Products', 'paksa-it-solutions' ),
        'paksa-industries'   => __( 'Paksa Industries', 'paksa-it-solutions' ),
        'paksa-process'      => __( 'Paksa Process', 'paksa-it-solutions' ),
        'paksa-stats'        => __( 'Paksa Stats', 'paksa-it-solutions' ),
        'paksa-testimonials' => __( 'Paksa Testimonials', 'paksa-it-solutions' ),
        'paksa-case-studies' => __( 'Paksa Case Studies', 'paksa-it-solutions' ),
        'paksa-pricing'      => __( 'Paksa Pricing', 'paksa-it-solutions' ),
        'paksa-team'         => __( 'Paksa Team', 'paksa-it-solutions' ),
        'paksa-blog'         => __( 'Paksa Blog', 'paksa-it-solutions' ),
        'paksa-headers'      => __( 'Paksa Headers', 'paksa-it-solutions' ),
        'paksa-footers'      => __( 'Paksa Footers', 'paksa-it-solutions' ),
        'paksa-navigation'   => __( 'Paksa Navigation', 'paksa-it-solutions' ),
        'paksa-content'      => __( 'Paksa Content', 'paksa-it-solutions' ),
    );

    foreach ( $categories as $slug => $label ) {
        register_block_pattern_category( $slug, array( 'label' => $label ) );
    }
}
add_action( 'init', 'paksa_register_advanced_pattern_categories', 7 );

function paksa_builder_team_card( $name, $role ) {
    return paksa_visual_group(
        'is-style-paksa-card-team',
        paksa_visual_media_placeholder()
        . paksa_visual_heading( $name, 3 )
        . paksa_visual_paragraph( $role, 'pk-component-meta' )
        . paksa_visual_paragraph( 'Add a short, human introduction that explains this person’s role and expertise.' )
    );
}

function paksa_builder_case_study_card( $title, $description ) {
    return paksa_visual_group(
        'is-style-paksa-card-image',
        paksa_visual_media_placeholder()
        . paksa_visual_group( 'pk-builder-card-content', paksa_visual_heading( $title, 3 ) . paksa_visual_paragraph( $description ) . paksa_visual_actions( 'Read the story', 'View services' ) )
    );
}

function paksa_builder_blog_query() {
    return '<!-- wp:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":""},"className":"pk-builder-blog-query"} -->'
        . '<div class="wp-block-query pk-builder-blog-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->'
        . '<!-- wp:group {"className":"is-style-paksa-card-blog"} --><div class="wp-block-group is-style-paksa-card-blog">'
        . '<!-- wp:post-featured-image {"isLink":true,"className":"is-style-paksa-image-zoom"} /-->'
        . '<!-- wp:post-terms {"term":"category"} /-->'
        . '<!-- wp:post-title {"isLink":true,"level":3} /-->'
        . '<!-- wp:post-excerpt {"moreText":"Read article"} /-->'
        . '</div><!-- /wp:group -->'
        . '<!-- /wp:post-template -->'
        . '<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-query-pagination is-layout-flex is-content-justification-center">'
        . '<!-- wp:query-pagination-previous /--><!-- wp:query-pagination-numbers /--><!-- wp:query-pagination-next /-->'
        . '</div><!-- /wp:query-pagination -->'
        . '</div><!-- /wp:query -->';
}

/**
 * Register additional production-oriented sections that compose native blocks.
 */
function paksa_register_advanced_builder_patterns() {
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    $features = paksa_visual_columns( array(
        paksa_visual_card( 'analytics', 'Actionable insight', 'Turn the information your team already has into clearer decisions.' ),
        paksa_visual_card( 'automation', 'Intentional automation', 'Reduce repetitive work without losing visibility or control.' ),
        paksa_visual_card( 'shield', 'Built for confidence', 'Make resilience, privacy, and quality part of the core experience.' ),
        paksa_visual_card( 'users', 'Designed around people', 'Keep the experience useful for the people who rely on it every day.' ),
    ), 'pk-builder-feature-grid' );

    $feature_media = paksa_visual_columns( array(
        paksa_visual_media_placeholder(),
        paksa_visual_group( 'pk-builder-feature-copy',
            paksa_visual_paragraph( 'A practical advantage', 'pk-component-eyebrow' )
            . paksa_visual_heading( 'Explain the value with a tangible visual.', 2 )
            . paksa_visual_paragraph( 'Use an image, a product view, or a short video to give the promise context. The content, media, colors, spacing, and actions remain independently editable.' )
            . paksa_visual_group( 'pk-component-feature', paksa_visual_icon( 'check' ) . paksa_visual_group( 'pk-component-feature__content', paksa_visual_heading( 'Useful first', 3 ) . paksa_visual_paragraph( 'Add a focused supporting benefit.' ) ) )
            . paksa_visual_group( 'pk-component-feature', paksa_visual_icon( 'check' ) . paksa_visual_group( 'pk-component-feature__content', paksa_visual_heading( 'Ready to adapt', 3 ) . paksa_visual_paragraph( 'Add another clear supporting benefit.' ) ) )
            . paksa_visual_actions( 'Explore the detail', 'Ask a question' )
        ),
    ), 'pk-builder-feature-media' );

    $alternating = paksa_visual_group( 'pk-builder-alternating-features',
        paksa_visual_columns( array( paksa_visual_group( 'pk-builder-feature-copy', paksa_visual_heading( 'Start with the part that matters most.', 3 ) . paksa_visual_paragraph( 'Use a concise explanation and then pair it with a useful visual or demonstration.' ) . paksa_visual_actions( 'Learn more', 'View options' ) ), paksa_visual_media_placeholder() ), 'pk-builder-alternating-row' )
        . paksa_visual_columns( array( paksa_visual_media_placeholder(), paksa_visual_group( 'pk-builder-feature-copy', paksa_visual_heading( 'Keep the next step easy to understand.', 3 ) . paksa_visual_paragraph( 'The alternating row is still entirely native blocks, so order and content are easy to change.' ) . paksa_visual_actions( 'See the process', 'Contact us' ) ), ), 'pk-builder-alternating-row' )
    );

    $team = paksa_visual_columns( array(
        paksa_builder_team_card( 'Team member', 'Role or specialist area' ),
        paksa_builder_team_card( 'Team member', 'Role or specialist area' ),
        paksa_builder_team_card( 'Team member', 'Role or specialist area' ),
    ), 'pk-builder-team-grid' );

    $case_studies = paksa_visual_columns( array(
        paksa_builder_case_study_card( 'A measurable transformation', 'Describe the challenge, approach, and outcome in a few useful lines.' ),
        paksa_builder_case_study_card( 'A better connected experience', 'Describe the challenge, approach, and outcome in a few useful lines.' ),
        paksa_builder_case_study_card( 'A foundation ready to grow', 'Describe the challenge, approach, and outcome in a few useful lines.' ),
    ), 'pk-builder-case-studies' );

    $patterns = array(
        'hero-product-focus' => array( __( 'Hero — Product Focus', 'paksa-it-solutions' ), 'paksa-heroes', paksa_visual_section( 'pk-hero pk-hero--classic', 'Product overview', 'Show what the product helps people accomplish.', 'Pair a focused promise with a product visual, supporting proof, and a clear next step.', paksa_visual_columns( array( paksa_visual_group( 'pk-builder-hero-copy', paksa_visual_actions( 'Explore product', 'See the details' ) . paksa_visual_stat_grid() ), paksa_visual_media_placeholder() ), 'pk-builder-hero-product' ) ) ),
        'hero-service-focus' => array( __( 'Hero — Service Focus', 'paksa-it-solutions' ), 'paksa-heroes', paksa_visual_section( 'pk-hero pk-hero--dark', 'Service overview', 'Make an expert service easy to understand.', 'Use the supporting points to explain the outcome, approach, and the next conversation.', paksa_visual_columns( array( paksa_visual_group( 'pk-builder-hero-copy', paksa_visual_actions( 'Discuss your needs', 'View services' ) ), paksa_visual_group( 'is-style-paksa-card-dark', paksa_visual_icon( 'services', 32 ) . paksa_visual_heading( 'What is included', 3 ) . paksa_visual_paragraph( 'List the most relevant areas of help, scope, or support.' ) ) ), 'pk-builder-hero-service' ) ) ),
        'features-four-column' => array( __( 'Features — Four Column', 'paksa-it-solutions' ), 'paksa-features', paksa_visual_section( '', 'Designed to support real work', 'Four concise benefits that are easy to scan.', 'Each card uses the shared Paksa card structure and can be restyled, rearranged, or duplicated.', $features ) ),
        'features-media' => array( __( 'Features — Image and Detail', 'paksa-it-solutions' ), 'paksa-features', paksa_visual_section( '', 'Give the feature more context', 'Use image, video, or product media alongside practical benefits.', 'The visual and every supporting item are native blocks.', $feature_media ) ),
        'features-alternating' => array( __( 'Features — Alternating', 'paksa-it-solutions' ), 'paksa-features', paksa_visual_section( '', 'Tell a clearer feature story', 'Alternate visual and explanation without duplicating a custom layout.', 'Use as many rows as the page needs and reorder them freely.', $alternating ) ),
        'team-grid' => array( __( 'Team — Grid', 'paksa-it-solutions' ), 'paksa-team', paksa_visual_section( '', 'The people behind the work', 'Introduce the team in a clear, adaptable card system.', 'Replace every portrait placeholder with an Image or Cover block from your Media Library.', $team ) ),
        'case-studies' => array( __( 'Case Studies — Cards', 'paksa-it-solutions' ), 'paksa-case-studies', paksa_visual_section( '', 'Work with a story to tell', 'Give proof more depth by making the situation and outcome clear.', 'Replace placeholders with approved stories, visual evidence, and links.', $case_studies ) ),
        'blog-query-grid' => array( __( 'Blog — Latest Posts Grid', 'paksa-it-solutions' ), 'paksa-blog', paksa_visual_section( '', 'Latest ideas and updates', 'A live Query Loop that displays the most recent published posts.', 'The cards use native post blocks and update automatically when new posts are published.', paksa_builder_blog_query() ) ),
    );

    foreach ( $patterns as $slug => $pattern ) {
        register_block_pattern( 'paksa-it-solutions/' . $slug, array(
            'title'       => $pattern[0],
            'categories'  => array( $pattern[1] ),
            'description' => __( 'An editable Paksa Theme composition built with native WordPress blocks.', 'paksa-it-solutions' ),
            'content'     => $pattern[2],
        ) );
    }
}
add_action( 'init', 'paksa_register_advanced_builder_patterns', 24 );

/**
 * Register Phase 16 patterns: About, Pricing, Blog, Newsletter, Footer, Navigation.
 * All use the established paksa_visual_* helpers — no new markup contracts.
 */
function paksa_register_phase16_patterns() {
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    // ---- About patterns ----
    $about_stats = paksa_visual_group( 'pk-pattern-stat-grid',
        paksa_visual_group( 'pk-pattern-stat', '<!-- wp:paragraph --><p><strong>10+</strong><span>Years of experience</span></p><!-- /wp:paragraph -->' )
        . paksa_visual_group( 'pk-pattern-stat', '<!-- wp:paragraph --><p><strong>200+</strong><span>Projects delivered</span></p><!-- /wp:paragraph -->' )
        . paksa_visual_group( 'pk-pattern-stat', '<!-- wp:paragraph --><p><strong>50+</strong><span>Enterprise clients</span></p><!-- /wp:paragraph -->' )
        . paksa_visual_group( 'pk-pattern-stat', '<!-- wp:paragraph --><p><strong>98%</strong><span>Client satisfaction</span></p><!-- /wp:paragraph -->' ),
        array( 'layout' => array( 'type' => 'grid', 'minimumColumnWidth' => '12rem' ) )
    );

    $about_image_text = paksa_visual_columns( array(
        paksa_visual_media_placeholder(),
        paksa_visual_group( 'pk-builder-feature-copy',
            paksa_visual_paragraph( 'Our story', 'pk-component-eyebrow' )
            . paksa_visual_heading( 'Built on a clear purpose.', 2 )
            . paksa_visual_paragraph( 'Replace this with your company origin story. Explain the problem you set out to solve, the people behind the work, and the values that guide every decision.' )
            . paksa_visual_actions( 'Meet the team', 'View our work' )
        ),
    ), 'pk-builder-feature-media' );

    // ---- Pricing patterns ----
    $pricing_three = paksa_visual_columns( array(
        paksa_visual_group( 'is-style-paksa-card-pricing',
            paksa_visual_paragraph( 'Starter', 'pk-component-eyebrow' )
            . paksa_visual_heading( '$0 / mo', 3 )
            . paksa_visual_paragraph( 'For individuals and small teams getting started.' )
            . '<!-- wp:list {"className":"is-style-paksa-icon-list"} --><ul class="is-style-paksa-icon-list"><li>Feature one</li><li>Feature two</li><li>Feature three</li></ul><!-- /wp:list -->'
            . paksa_visual_actions( 'Get started free', '' )
        ),
        paksa_visual_group( 'is-style-paksa-card-pricing pk-pattern-card--dark',
            paksa_visual_paragraph( 'Professional', 'pk-component-eyebrow' )
            . paksa_visual_heading( '$49 / mo', 3 )
            . paksa_visual_paragraph( 'For growing teams that need more power and flexibility.' )
            . '<!-- wp:list {"className":"is-style-paksa-icon-list"} --><ul class="is-style-paksa-icon-list"><li>Everything in Starter</li><li>Advanced feature</li><li>Priority support</li><li>Custom integrations</li></ul><!-- /wp:list -->'
            . paksa_visual_actions( 'Start free trial', '' )
        ),
        paksa_visual_group( 'is-style-paksa-card-pricing',
            paksa_visual_paragraph( 'Enterprise', 'pk-component-eyebrow' )
            . paksa_visual_heading( 'Custom', 3 )
            . paksa_visual_paragraph( 'For organisations with specific requirements and scale.' )
            . '<!-- wp:list {"className":"is-style-paksa-icon-list"} --><ul class="is-style-paksa-icon-list"><li>Everything in Professional</li><li>Dedicated support</li><li>SLA guarantee</li><li>Custom contract</li></ul><!-- /wp:list -->'
            . paksa_visual_actions( 'Talk to sales', '' )
        ),
    ) );

    // ---- Blog patterns ----
    $blog_featured = paksa_visual_columns( array(
        paksa_visual_group( 'is-style-paksa-card-image',
            paksa_visual_media_placeholder()
            . paksa_visual_group( 'pk-builder-card-content',
                paksa_visual_paragraph( 'Category', 'pk-component-meta' )
                . paksa_visual_heading( 'Featured article title goes here', 3 )
                . paksa_visual_paragraph( 'A short excerpt that gives readers enough context to decide whether to read the full article.' )
                . paksa_visual_actions( 'Read article', '' )
            )
        ),
        paksa_visual_group( 'pk-builder-feature-copy',
            paksa_visual_card( 'calendar', 'Recent article title', 'A short excerpt for this article.' )
            . paksa_visual_card( 'calendar', 'Another article title', 'A short excerpt for this article.' )
            . paksa_visual_card( 'calendar', 'Third article title', 'A short excerpt for this article.' )
        ),
    ), 'pk-builder-feature-media' );

    // ---- Newsletter patterns ----
    $newsletter_inline = paksa_visual_group( 'pk-pattern-newsletter',
        paksa_visual_group( 'pk-builder-feature-copy',
            paksa_visual_heading( 'Stay informed.', 2 )
            . paksa_visual_paragraph( 'Get practical updates on the topics that matter to your work. No noise, no spam — just useful content when there is something worth sharing.' )
        )
        . '<!-- wp:search {"label":"Email address","showLabel":false,"placeholder":"Your email address","buttonText":"Subscribe","buttonUseIcon":false,"className":"pk-newsletter-form"} /-->'
    );

    $newsletter_split = paksa_visual_columns( array(
        paksa_visual_group( 'pk-builder-feature-copy',
            paksa_visual_paragraph( 'Newsletter', 'pk-component-eyebrow' )
            . paksa_visual_heading( 'Useful updates, sent with care.', 2 )
            . paksa_visual_paragraph( 'Describe the value, frequency, and privacy expectation in plain language. Replace this with your own newsletter description.' )
        ),
        paksa_visual_group( 'pk-pattern-newsletter',
            '<!-- wp:search {"label":"Email address","showLabel":true,"placeholder":"Your email address","buttonText":"Subscribe","buttonUseIcon":false} /-->'
            . paksa_visual_paragraph( 'We respect your privacy. Unsubscribe at any time.', 'pk-component-meta' )
        ),
    ), 'pk-builder-feature-media' );

    // ---- Footer patterns ----
    $footer_minimal = paksa_visual_group( 'pk-site-editor-footer',
        paksa_visual_group( 'pk-site-editor-footer__inner',
            '<!-- wp:site-title {"level":0,"isLink":true,"fontSize":"large"} /-->'
            . paksa_visual_paragraph( '© ' . date( 'Y' ) . ' Your Company. All rights reserved.', '' )
            . '<!-- wp:navigation {"overlayMenu":"never","layout":{"type":"flex","orientation":"horizontal"}} --><!-- wp:page-list /--><!-- /wp:navigation -->',
            array( 'layout' => array( 'type' => 'flex', 'flexWrap' => 'wrap', 'justifyContent' => 'space-between', 'verticalAlignment' => 'center' ) )
        ),
        array( 'align' => 'full', 'layout' => array( 'type' => 'constrained' ) )
    );

    $footer_cta = paksa_visual_group( 'pk-site-editor-footer',
        paksa_visual_group( 'pk-pattern-cta pk-footer-cta__inner',
            paksa_visual_group( '',
                paksa_visual_heading( 'Ready to make the next step clear?', 2 )
                . paksa_visual_paragraph( 'Use this footer CTA to give every page a consistent, low-friction invitation to continue the conversation.' )
            )
            . paksa_visual_actions( 'Contact us', 'View services' ),
            array( 'layout' => array( 'type' => 'flex', 'flexWrap' => 'wrap', 'justifyContent' => 'space-between', 'verticalAlignment' => 'center' ) )
        )
        . paksa_visual_group( 'pk-site-editor-footer__bottom',
            paksa_visual_paragraph( '© ' . date( 'Y' ) . ' Your Company. All rights reserved.', '' ),
            array( 'align' => 'wide', 'layout' => array( 'type' => 'flex', 'justifyContent' => 'center' ) )
        ),
        array( 'align' => 'full', 'layout' => array( 'type' => 'constrained' ) )
    );

    // ---- Navigation patterns ----
    $nav_with_cta = '<!-- wp:group {"align":"wide","className":"pk-site-editor-header__inner","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->'
        . '<!-- wp:group {"className":"pk-site-editor-brand","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->'
        . '<!-- wp:site-logo {"width":40} /-->'
        . '<!-- wp:site-title {"level":0,"isLink":true,"fontSize":"large"} /-->'
        . '<!-- /wp:group -->'
        . '<!-- wp:navigation {"overlayMenu":"mobile","className":"pk-site-editor-navigation","layout":{"type":"flex","justifyContent":"right","orientation":"horizontal"}} --><!-- wp:page-list /--><!-- /wp:navigation -->'
        . '<!-- wp:buttons {"className":"pk-site-editor-header__actions pk-component-action-group","layout":{"type":"flex","flexWrap":"nowrap"}} -->'
        . '<!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/contact/">Contact Us</a></div><!-- /wp:button -->'
        . '<!-- /wp:buttons -->'
        . '<!-- /wp:group -->';

    $patterns = array(
        'about-image-text' => array( __( 'About — Image and Story', 'paksa-it-solutions' ), 'paksa-about',
            paksa_visual_section( '', 'About us', 'The story behind the work.', 'Use this section to introduce your company, its origin, and the values that guide your decisions.', $about_image_text ) ),
        'about-statistics' => array( __( 'About — Statistics', 'paksa-it-solutions' ), 'paksa-about',
            paksa_visual_section( '', 'By the numbers', 'Proof that speaks for itself.', 'Replace each metric with a verified figure and a short label that gives it context.', $about_stats ) ),
        'pricing-three-tier' => array( __( 'Pricing — Three Tiers', 'paksa-it-solutions' ), 'paksa-pricing',
            paksa_visual_section( '', 'Simple, transparent pricing', 'Choose the plan that fits your needs.', 'Edit each card\'s name, price, features, and call to action directly in the editor.', $pricing_three ) ),
        'blog-featured' => array( __( 'Blog — Featured and Recent', 'paksa-it-solutions' ), 'paksa-blog',
            paksa_visual_section( '', 'From the blog', 'Ideas and updates worth reading.', 'Replace the placeholders with real articles. Connect the buttons to your published posts.', $blog_featured ) ),
        'blog-query-latest' => array( __( 'Blog — Latest Posts (Live)', 'paksa-it-solutions' ), 'paksa-blog',
            paksa_visual_section( '', 'Latest articles', 'A live feed of your most recent posts.', 'This Query Loop updates automatically when new posts are published.', paksa_builder_blog_query() ) ),
        'newsletter-inline' => array( __( 'Newsletter — Inline', 'paksa-it-solutions' ), 'paksa-contact',
            paksa_visual_section( 'pk-pattern-section--narrow', 'Stay in the loop', 'Useful updates, sent with care.', 'Connect the search block to your newsletter provider. Edit the heading and description freely.', $newsletter_inline ) ),
        'newsletter-split' => array( __( 'Newsletter — Split Layout', 'paksa-it-solutions' ), 'paksa-contact',
            paksa_visual_section( '', 'Get useful updates', 'Subscribe to the newsletter.', 'A two-column layout that pairs the newsletter value proposition with the signup form.', $newsletter_split ) ),
        'footer-minimal' => array( __( 'Footer — Minimal', 'paksa-it-solutions' ), 'paksa-footers', $footer_minimal ),
        'footer-cta' => array( __( 'Footer — With CTA', 'paksa-it-solutions' ), 'paksa-footers', $footer_cta ),
        'nav-with-cta' => array( __( 'Navigation — With CTA Button', 'paksa-it-solutions' ), 'paksa-navigation', $nav_with_cta ),
    );

    foreach ( $patterns as $slug => $pattern ) {
        register_block_pattern( 'paksa-it-solutions/' . $slug, array(
            'title'       => $pattern[0],
            'categories'  => array( $pattern[1] ),
            'description' => __( 'An editable Paksa Theme composition built with native WordPress blocks.', 'paksa-it-solutions' ),
            'content'     => $pattern[2],
        ) );
    }
}
add_action( 'init', 'paksa_register_phase16_patterns', 26 );

/**
 * Phase 17 patterns: testimonial grid, CTA block variants, section compositions.
 */
function paksa_register_phase17_patterns() {
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    // Testimonial grid using paksa/testimonial blocks
    $t1 = '<!-- wp:paksa/testimonial {"quote":"A thoughtful process from the first conversation to launch. The team understood what we needed before we did.","author":"Team member","role":"Director","company":"Company name","showRating":true,"rating":5} /-->';
    $t2 = '<!-- wp:paksa/testimonial {"quote":"The work made a complicated offer feel simple and approachable. Our conversion rate improved immediately.","author":"Team member","role":"Head of Marketing","company":"Company name","showRating":true,"rating":5} /-->';
    $t3 = '<!-- wp:paksa/testimonial {"quote":"An adaptable foundation our team can now own and extend. Exactly what we asked for.","author":"Team member","role":"CTO","company":"Company name","showRating":true,"rating":5} /-->';

    $testimonial_grid = '<!-- wp:columns {"className":"pk-pattern-card-grid"} --><div class="wp-block-columns pk-pattern-card-grid">'
        . '<div class="wp-block-column">' . $t1 . '</div>'
        . '<div class="wp-block-column">' . $t2 . '</div>'
        . '<div class="wp-block-column">' . $t3 . '</div>'
        . '</div><!-- /wp:columns -->';

    // CTA block patterns
    $cta_dark     = '<!-- wp:paksa/cta {"heading":"Ready to make the next step clear?","description":"Use this CTA wherever a page needs a concise, editable invitation to continue the conversation.","variant":"dark","layout":"split","primaryLabel":"Contact us","primaryUrl":"/contact/","secondaryLabel":"View services","secondaryUrl":"/services/"} /-->';
    $cta_gradient = '<!-- wp:paksa/cta {"eyebrow":"Get started","heading":"Build the next version with intent.","description":"Use concise copy and one strong next step.","variant":"gradient","layout":"centered","primaryLabel":"Start a project","primaryUrl":"/contact/","secondaryLabel":"See our work","secondaryUrl":"/services/"} /-->';
    $cta_light    = '<!-- wp:paksa/cta {"heading":"Have a question?","description":"We are happy to help. Reach out and we will get back to you within one business day.","variant":"light","layout":"centered","primaryLabel":"Get in touch","primaryUrl":"/contact/"} /-->';

    // Section block compositions
    $section_dark = '<!-- wp:paksa/section {"variant":"dark","animation":"fade-up"} -->'
        . paksa_visual_intro( 'Our approach', 'A process built around your goals.', 'Replace this with a concise description of how you work and what makes your approach different.' )
        . paksa_visual_actions( 'Learn more', 'See our work' )
        . '<!-- /wp:paksa/section -->';

    $section_gradient = '<!-- wp:paksa/section {"variant":"gradient","textAlign":"center","animation":"fade"} -->'
        . paksa_visual_intro( 'Why choose us', 'Technology built around your business.', 'Use this gradient section for a high-impact introduction or a key differentiator.', 'center' )
        . paksa_visual_columns( array(
            paksa_visual_card( 'check', 'Benefit one', 'A concise statement of the first key advantage.' ),
            paksa_visual_card( 'check', 'Benefit two', 'A concise statement of the second key advantage.' ),
            paksa_visual_card( 'check', 'Benefit three', 'A concise statement of the third key advantage.' ),
        ) )
        . '<!-- /wp:paksa/section -->';

    $patterns = array(
        'testimonials-block-grid' => array(
            __( 'Testimonials — Block Grid', 'paksa-it-solutions' ),
            'paksa-testimonials',
            paksa_visual_section( '', 'What people say', 'Real words from the people you help.', 'Replace every placeholder with a genuine, permissioned quote and attribution.', $testimonial_grid )
        ),
        'cta-block-dark' => array(
            __( 'CTA Block — Dark Split', 'paksa-it-solutions' ),
            'paksa-cta',
            $cta_dark
        ),
        'cta-block-gradient' => array(
            __( 'CTA Block — Gradient Centered', 'paksa-it-solutions' ),
            'paksa-cta',
            $cta_gradient
        ),
        'cta-block-light' => array(
            __( 'CTA Block — Light', 'paksa-it-solutions' ),
            'paksa-cta',
            $cta_light
        ),
        'section-dark-intro' => array(
            __( 'Section — Dark with Intro', 'paksa-it-solutions' ),
            'paksa-sections',
            $section_dark
        ),
        'section-gradient-features' => array(
            __( 'Section — Gradient with Features', 'paksa-it-solutions' ),
            'paksa-sections',
            $section_gradient
        ),
    );

    foreach ( $patterns as $slug => $pattern ) {
        register_block_pattern( 'paksa-it-solutions/' . $slug, array(
            'title'       => $pattern[0],
            'categories'  => array( $pattern[1] ),
            'description' => __( 'An editable Paksa Theme composition built with native WordPress blocks.', 'paksa-it-solutions' ),
            'content'     => $pattern[2],
        ) );
    }
}
add_action( 'init', 'paksa_register_phase17_patterns', 28 );

/**
 * Move both existing and Phase 14 patterns into a task-oriented browser.
 * Pattern identifiers are retained so existing content and references remain
 * stable; only their editor category is refined.
 */
function paksa_organize_registered_patterns() {
    if ( ! class_exists( 'WP_Block_Patterns_Registry' ) || ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    $categories = array(
        'hero-standard' => 'paksa-heroes', 'hero-split' => 'paksa-heroes', 'hero-dark' => 'paksa-heroes', 'hero-minimal' => 'paksa-heroes',
        'heading-display' => 'paksa-content', 'heading-section' => 'paksa-content', 'heading-section-left' => 'paksa-content', 'heading-compact' => 'paksa-content',
        'paragraph-lead' => 'paksa-content', 'paragraph-callout' => 'paksa-content', 'paragraph-highlight' => 'paksa-content', 'paragraph-cta' => 'paksa-content',
        'heading-paragraph-hero' => 'paksa-content', 'heading-paragraph-section' => 'paksa-content',
        'services-grid' => 'paksa-services', 'services-process' => 'paksa-process', 'services-tabs' => 'paksa-services', 'services-features' => 'paksa-features', 'services-stats' => 'paksa-stats', 'services-cta' => 'paksa-cta', 'services-categories' => 'paksa-services', 'services-categories-grid' => 'paksa-services', 'service-detail' => 'paksa-services',
        'home-hero' => 'paksa-heroes', 'home-trust-strip' => 'paksa-social-proof', 'home-challenge' => 'paksa-features', 'home-capabilities' => 'paksa-features', 'home-technology' => 'paksa-features', 'home-process' => 'paksa-process', 'home-why-us' => 'paksa-about', 'home-intelligence' => 'paksa-features', 'home-differentiation' => 'paksa-features', 'home-industries' => 'paksa-industries', 'home-outcomes' => 'paksa-stats', 'home-faq' => 'paksa-faq', 'home-final-cta' => 'paksa-cta',
        'hero-classic' => 'paksa-heroes', 'hero-split-modern' => 'paksa-heroes', 'hero-media' => 'paksa-heroes', 'hero-dark-modern' => 'paksa-heroes', 'hero-gradient' => 'paksa-heroes', 'hero-centered' => 'paksa-heroes', 'hero-statistics' => 'paksa-heroes', 'hero-cards' => 'paksa-heroes', 'hero-trust' => 'paksa-heroes', 'hero-background-video' => 'paksa-heroes', 'hero-product-focus' => 'paksa-heroes', 'hero-service-focus' => 'paksa-heroes',
        'about-story' => 'paksa-about', 'about-values' => 'paksa-about', 'about-image-text' => 'paksa-about', 'about-statistics' => 'paksa-about',
        'services-grid-modern' => 'paksa-services', 'services-featured' => 'paksa-services', 'services-comparison' => 'paksa-services',
        'products-grid' => 'paksa-products',
        'industries-grid' => 'paksa-industries',
        'technology-stack' => 'paksa-features', 'technology-matrix' => 'paksa-features',
        'process-steps' => 'paksa-process', 'process-timeline' => 'paksa-process',
        'statistics-grid' => 'paksa-stats',
        'logo-strip' => 'paksa-social-proof', 'testimonials' => 'paksa-testimonials', 'testimonial-slider' => 'paksa-testimonials',
        'pricing-cards' => 'paksa-pricing', 'comparison-cards' => 'paksa-pricing', 'pricing-three-tier' => 'paksa-pricing',
        'faq-accordion' => 'paksa-faq', 'faq-two-column' => 'paksa-faq', 'faq-cards' => 'paksa-faq', 'faq-sidebar' => 'paksa-faq',
        'cta-simple' => 'paksa-cta', 'cta-split' => 'paksa-cta', 'cta-dark' => 'paksa-cta', 'cta-gradient' => 'paksa-cta', 'cta-icons' => 'paksa-cta', 'cta-image' => 'paksa-cta', 'cta-multiple-actions' => 'paksa-cta',
        'contact-form-info' => 'paksa-contact', 'contact-map' => 'paksa-contact', 'contact-cards' => 'paksa-contact', 'newsletter' => 'paksa-contact', 'newsletter-inline' => 'paksa-contact', 'newsletter-split' => 'paksa-contact',
        'blog-featured' => 'paksa-blog', 'blog-query-latest' => 'paksa-blog',
        'footer-minimal' => 'paksa-footers', 'footer-cta' => 'paksa-footers',
        'nav-with-cta' => 'paksa-navigation',
        'features-four-column' => 'paksa-features', 'features-media' => 'paksa-features', 'features-alternating' => 'paksa-features',
        'team-grid' => 'paksa-team', 'case-studies' => 'paksa-case-studies', 'blog-query-grid' => 'paksa-blog',
    );

    $registry = WP_Block_Patterns_Registry::get_instance();
    foreach ( $categories as $slug => $category ) {
        $name    = 'paksa-it-solutions/' . $slug;
        $pattern = $registry->get_registered( $name );
        if ( ! $pattern ) {
            continue;
        }

        $registry->unregister( $name );
        unset( $pattern['name'] );
        $pattern['categories'] = array( $category );
        register_block_pattern( $name, $pattern );
    }
}
add_action( 'init', 'paksa_organize_registered_patterns', 32 );
