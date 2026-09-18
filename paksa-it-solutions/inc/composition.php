<?php
/**
 * Paksa Theme — Phase 19 full-site composition.
 *
 * Extends the existing pattern/template system with:
 *  - Product & service single-page compositions
 *  - Query loop customization patterns
 *  - Header/footer variant insertion patterns
 *  - Page-building starter compositions
 *  - Unified responsive section patterns
 *
 * Uses only existing paksa_visual_* helpers and --pk-* tokens.
 * No new blocks, no new token system, no new persistence layer.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Phase 19 pattern categories.
 */
function paksa_register_phase19_pattern_categories() {
    if ( ! function_exists( 'register_block_pattern_category' ) ) {
        return;
    }
    $cats = array(
        'paksa-page-starters'  => __( 'Paksa Page Starters', 'paksa-it-solutions' ),
        'paksa-query'          => __( 'Paksa Query Loops', 'paksa-it-solutions' ),
        'paksa-single'         => __( 'Paksa Single Post', 'paksa-it-solutions' ),
        'paksa-template-parts' => __( 'Paksa Template Parts', 'paksa-it-solutions' ),
    );
    foreach ( $cats as $slug => $label ) {
        register_block_pattern_category( $slug, array( 'label' => $label ) );
    }
}
add_action( 'init', 'paksa_register_phase19_pattern_categories', 8 );

/**
 * Build a query loop block string.
 *
 * @param string $post_type
 * @param string $taxonomy
 * @param string $card_style  Existing paksa card style name (without is-style- prefix).
 * @param int    $columns
 * @param int    $per_page
 * @param string $more_text
 * @param bool   $inherit
 * @return string
 */
function paksa_composition_query( $post_type, $taxonomy, $card_style, $columns = 3, $per_page = 9, $more_text = 'Read more', $inherit = false ) {
    static $qid = 40;
    $qid++;
    $post_type  = sanitize_key( $post_type );
    $taxonomy   = sanitize_key( $taxonomy );
    $card_style = sanitize_html_class( $card_style );
    $columns    = max( 1, min( 4, absint( $columns ) ) );
    $per_page   = max( 1, min( 24, absint( $per_page ) ) );
    $more_text  = esc_html( $more_text );
    $inherit_s  = $inherit ? 'true' : 'false';

    return '<!-- wp:query {"queryId":' . $qid . ',"query":{"perPage":' . $per_page . ',"pages":0,"offset":0,"postType":"' . $post_type . '","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":' . $inherit_s . '},"className":"pk-site-editor-resource-grid"} -->'
        . '<div class="wp-block-query pk-site-editor-resource-grid"><!-- wp:post-template {"layout":{"type":"grid","columnCount":' . $columns . '}} -->'
        . '<!-- wp:group {"className":"is-style-' . $card_style . '","layout":{"type":"constrained"}} --><div class="wp-block-group is-style-' . $card_style . '">'
        . '<!-- wp:post-featured-image {"isLink":true,"className":"is-style-paksa-image-zoom"} /-->'
        . '<!-- wp:post-terms {"term":"' . $taxonomy . '","className":"pk-component-meta"} /-->'
        . '<!-- wp:post-title {"isLink":true,"level":3} /-->'
        . '<!-- wp:post-excerpt {"moreText":"' . $more_text . '"} /-->'
        . '</div><!-- /wp:group -->'
        . '<!-- /wp:post-template -->'
        . '<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-query-pagination is-layout-flex is-content-justification-center"><!-- wp:query-pagination-previous /--><!-- wp:query-pagination-numbers /--><!-- wp:query-pagination-next /--></div><!-- /wp:query-pagination -->'
        . '</div><!-- /wp:query -->';
}

/**
 * Build a product single-page hero composition.
 *
 * @return string
 */
function paksa_composition_product_hero() {
    return '<!-- wp:group {"tagName":"section","align":"full","className":"pk-site-editor-hero pk-site-editor-hero--product","layout":{"type":"constrained"}} -->'
        . '<section class="wp-block-group pk-site-editor-hero pk-site-editor-hero--product alignfull">'
        . '<!-- wp:paksa/breadcrumbs {"align":"wide"} /-->'
        . '<!-- wp:group {"align":"wide","className":"pk-site-editor-hero__inner","layout":{"type":"constrained"}} -->'
        . '<div class="wp-block-group pk-site-editor-hero__inner alignwide">'
        . '<!-- wp:post-terms {"term":"paksa_product_cat","className":"pk-component-meta"} /-->'
        . '<!-- wp:post-title {"level":1,"fontSize":"display"} /-->'
        . '<!-- wp:post-excerpt {"className":"pk-site-editor-hero__excerpt","fontSize":"body-large"} /-->'
        . '<!-- wp:buttons {"layout":{"type":"flex"}} -->'
        . '<div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#">Get started</a></div><!-- /wp:button -->'
        . '<!-- wp:button {"className":"is-style-paksa-button-outline"} --><div class="wp-block-button is-style-paksa-button-outline"><a class="wp-block-button__link wp-element-button" href="#">Learn more</a></div><!-- /wp:button --></div>'
        . '<!-- /wp:buttons -->'
        . '</div><!-- /wp:group -->'
        . '</section><!-- /wp:group -->';
}

/**
 * Register Phase 19 patterns.
 */
function paksa_register_phase19_patterns() {
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    /* ── Template part insertion patterns ─────────────────────────────── */
    $part_patterns = array(
        'part-header-standard' => array(
            __( 'Header — Standard (with CTA)', 'paksa-it-solutions' ),
            'paksa-template-parts',
            '<!-- wp:template-part {"slug":"header","theme":"paksa-it-solutions","tagName":"header"} /-->',
        ),
        'part-header-minimal' => array(
            __( 'Header — Minimal (logo + nav)', 'paksa-it-solutions' ),
            'paksa-template-parts',
            '<!-- wp:template-part {"slug":"header-minimal","theme":"paksa-it-solutions","tagName":"header"} /-->',
        ),
        'part-header-dark' => array(
            __( 'Header — Dark', 'paksa-it-solutions' ),
            'paksa-template-parts',
            '<!-- wp:template-part {"slug":"header-dark","theme":"paksa-it-solutions","tagName":"header"} /-->',
        ),
        'part-header-centered' => array(
            __( 'Header — Centered Logo', 'paksa-it-solutions' ),
            'paksa-template-parts',
            '<!-- wp:template-part {"slug":"header-centered","theme":"paksa-it-solutions","tagName":"header"} /-->',
        ),
        'part-footer-standard' => array(
            __( 'Footer — Multi-column', 'paksa-it-solutions' ),
            'paksa-template-parts',
            '<!-- wp:template-part {"slug":"footer","theme":"paksa-it-solutions","tagName":"footer"} /-->',
        ),
        'part-footer-minimal' => array(
            __( 'Footer — Minimal', 'paksa-it-solutions' ),
            'paksa-template-parts',
            '<!-- wp:template-part {"slug":"footer-minimal","theme":"paksa-it-solutions","tagName":"footer"} /-->',
        ),
        'part-footer-cta' => array(
            __( 'Footer — With CTA', 'paksa-it-solutions' ),
            'paksa-template-parts',
            '<!-- wp:template-part {"slug":"footer-cta","theme":"paksa-it-solutions","tagName":"footer"} /-->',
        ),
        'part-cta-global' => array(
            __( 'Global CTA Band', 'paksa-it-solutions' ),
            'paksa-template-parts',
            '<!-- wp:template-part {"slug":"cta-global","theme":"paksa-it-solutions","tagName":"section"} /-->',
        ),
        'part-announcement' => array(
            __( 'Announcement Bar', 'paksa-it-solutions' ),
            'paksa-template-parts',
            '<!-- wp:template-part {"slug":"announcement","theme":"paksa-it-solutions","tagName":"div"} /-->',
        ),
    );

    foreach ( $part_patterns as $slug => $p ) {
        register_block_pattern( 'paksa-it-solutions/' . $slug, array(
            'title'       => $p[0],
            'categories'  => array( $p[1] ),
            'description' => __( 'Insert this editable Paksa template part into any template or page.', 'paksa-it-solutions' ),
            'content'     => $p[2],
        ) );
    }

    /* ── Query loop patterns ───────────────────────────────────────────── */
    $query_patterns = array(
        'query-posts-3col' => array(
            __( 'Query — Posts 3-column grid', 'paksa-it-solutions' ),
            'paksa-query',
            paksa_visual_section( '', 'Latest articles', 'A live feed of your most recent posts.', 'This Query Loop updates automatically when new posts are published.',
                paksa_composition_query( 'post', 'category', 'paksa-card-blog', 3, 9, 'Read more', true )
            ),
        ),
        'query-posts-2col' => array(
            __( 'Query — Posts 2-column grid', 'paksa-it-solutions' ),
            'paksa-query',
            paksa_visual_section( '', 'From the blog', 'Ideas and updates worth reading.', 'A two-column live post grid. Adjust columns, per-page count, and ordering in the Query block settings.',
                paksa_composition_query( 'post', 'category', 'paksa-card-blog', 2, 6, 'Read more', false )
            ),
        ),
        'query-products-grid' => array(
            __( 'Query — Products live grid', 'paksa-it-solutions' ),
            'paksa-query',
            paksa_visual_section( '', 'Our products', 'Browse the full product range.', 'A live Query Loop for the Products & Solutions post type. Filter by category using the Query block settings.',
                paksa_composition_query( 'paksa_product', 'paksa_product_cat', 'paksa-card-product', 3, 9, 'View product', false )
            ),
        ),
        'query-services-grid' => array(
            __( 'Query — Services live grid', 'paksa-it-solutions' ),
            'paksa-query',
            paksa_visual_section( '', 'Our services', 'Explore what we offer.', 'A live Query Loop for the Services post type. Filter by category using the Query block settings.',
                paksa_composition_query( 'paksa_service', 'paksa_service_cat', 'paksa-card-service', 3, 9, 'View service', false )
            ),
        ),
        'query-products-2col' => array(
            __( 'Query — Products 2-column', 'paksa-it-solutions' ),
            'paksa-query',
            paksa_visual_section( '', 'Featured products', 'A focused view of selected products.', 'Limit to 2 columns for a more spacious product showcase.',
                paksa_composition_query( 'paksa_product', 'paksa_product_cat', 'paksa-card-product', 2, 4, 'View product', false )
            ),
        ),
        'query-services-2col' => array(
            __( 'Query — Services 2-column', 'paksa-it-solutions' ),
            'paksa-query',
            paksa_visual_section( '', 'Featured services', 'A focused view of selected services.', 'Limit to 2 columns for a more spacious service showcase.',
                paksa_composition_query( 'paksa_service', 'paksa_service_cat', 'paksa-card-service', 2, 4, 'View service', false )
            ),
        ),
    );

    foreach ( $query_patterns as $slug => $p ) {
        register_block_pattern( 'paksa-it-solutions/' . $slug, array(
            'title'       => $p[0],
            'categories'  => array( $p[1] ),
            'description' => __( 'A live Query Loop composition using native WordPress blocks and Paksa card styles.', 'paksa-it-solutions' ),
            'content'     => $p[2],
        ) );
    }

    /* ── Product single-page compositions ─────────────────────────────── */
    $product_features = paksa_visual_columns( array(
        paksa_visual_group( 'pk-component-feature',
            paksa_visual_icon( 'check' )
            . paksa_visual_group( 'pk-component-feature__content',
                paksa_visual_heading( 'Key capability', 3 )
                . paksa_visual_paragraph( 'Describe the most important thing this product does for the user.' )
            )
        ),
        paksa_visual_group( 'pk-component-feature',
            paksa_visual_icon( 'check' )
            . paksa_visual_group( 'pk-component-feature__content',
                paksa_visual_heading( 'Second capability', 3 )
                . paksa_visual_paragraph( 'Describe another concrete benefit or feature.' )
            )
        ),
        paksa_visual_group( 'pk-component-feature',
            paksa_visual_icon( 'check' )
            . paksa_visual_group( 'pk-component-feature__content',
                paksa_visual_heading( 'Third capability', 3 )
                . paksa_visual_paragraph( 'Describe a third benefit that supports the purchase decision.' )
            )
        ),
    ) );

    $product_benefits = paksa_visual_columns( array(
        paksa_visual_card( 'analytics', 'Measurable results', 'Describe a specific, verifiable outcome the product delivers.' ),
        paksa_visual_card( 'shield', 'Built-in reliability', 'Describe how the product handles scale, security, or uptime.' ),
        paksa_visual_card( 'users', 'Designed for teams', 'Describe how the product fits into an existing workflow.' ),
    ) );

    $product_single = paksa_visual_section( '', 'Product overview', 'Everything you need to know.', 'Use this composition as a starting point for a product page. Replace every placeholder with real product content.',
        paksa_visual_media_placeholder()
        . paksa_visual_section( '', 'Key features', 'What makes this product different.', 'Replace each feature with a real capability.', $product_features )
        . paksa_visual_section( 'pk-section--alt', 'Why it works', 'Proof behind the promise.', 'Use verified outcomes, not marketing language.', $product_benefits )
        . '<!-- wp:paksa/related-content /-->'
    );

    $service_process = paksa_visual_group( 'pk-pattern-process',
        paksa_visual_group( 'pk-pattern-process-step',
            paksa_visual_paragraph( '01', 'pk-pattern-step-number' )
            . paksa_visual_heading( 'Discovery', 3 )
            . paksa_visual_paragraph( 'Understand the problem, the people affected, and the constraints.' )
        )
        . paksa_visual_group( 'pk-pattern-process-step',
            paksa_visual_paragraph( '02', 'pk-pattern-step-number' )
            . paksa_visual_heading( 'Design', 3 )
            . paksa_visual_paragraph( 'Create a clear plan and validate the approach before building.' )
        )
        . paksa_visual_group( 'pk-pattern-process-step',
            paksa_visual_paragraph( '03', 'pk-pattern-step-number' )
            . paksa_visual_heading( 'Delivery', 3 )
            . paksa_visual_paragraph( 'Build, test, and ship with quality and speed.' )
        )
        . paksa_visual_group( 'pk-pattern-process-step',
            paksa_visual_paragraph( '04', 'pk-pattern-step-number' )
            . paksa_visual_heading( 'Support', 3 )
            . paksa_visual_paragraph( 'Measure outcomes and keep improving after launch.' )
        )
    );

    $service_single = paksa_visual_section( '', 'Service overview', 'How we help.', 'Use this composition as a starting point for a service page. Replace every placeholder with real service content.',
        paksa_visual_columns( array(
            paksa_visual_group( 'pk-builder-feature-copy',
                paksa_visual_paragraph( 'What we do', 'pk-component-eyebrow' )
                . paksa_visual_heading( 'A clear description of the service.', 2 )
                . paksa_visual_paragraph( 'Explain the problem this service solves, who it is for, and what the outcome looks like. Keep it specific and honest.' )
                . paksa_visual_actions( 'Start a conversation', 'See our work' )
            ),
            paksa_visual_group( 'is-style-paksa-surface',
                paksa_visual_icon( 'services', 32 )
                . paksa_visual_heading( 'What is included', 3 )
                . '<!-- wp:list {"className":"is-style-paksa-icon-list"} --><ul class="is-style-paksa-icon-list"><li>Deliverable or scope item one</li><li>Deliverable or scope item two</li><li>Deliverable or scope item three</li><li>Deliverable or scope item four</li></ul><!-- /wp:list -->'
            ),
        ), 'pk-builder-feature-media' )
        . paksa_visual_section( '', 'How we work', 'A process built around your goals.', 'Replace each step with your actual delivery process.', $service_process )
        . '<!-- wp:paksa/related-content /-->'
    );

    $single_patterns = array(
        'product-single-composition' => array(
            __( 'Product — Full Page Composition', 'paksa-it-solutions' ),
            'paksa-single',
            $product_single,
        ),
        'service-single-composition' => array(
            __( 'Service — Full Page Composition', 'paksa-it-solutions' ),
            'paksa-single',
            $service_single,
        ),
        'product-hero-section' => array(
            __( 'Product — Hero Section', 'paksa-it-solutions' ),
            'paksa-products',
            paksa_visual_section( 'pk-hero pk-hero--classic', 'Product name', 'The one-line promise.', 'Replace with the product tagline. Keep it specific and outcome-focused.',
                paksa_visual_columns( array(
                    paksa_visual_group( 'pk-builder-hero-copy',
                        paksa_visual_actions( 'Get started', 'See features' )
                        . paksa_visual_stat_grid()
                    ),
                    paksa_visual_media_placeholder(),
                ), 'pk-builder-hero-product' )
            ),
        ),
        'service-hero-section' => array(
            __( 'Service — Hero Section', 'paksa-it-solutions' ),
            'paksa-services',
            paksa_visual_section( 'pk-hero pk-hero--dark', 'Service name', 'The one-line promise.', 'Replace with the service tagline. Keep it specific and outcome-focused.',
                paksa_visual_columns( array(
                    paksa_visual_group( 'pk-builder-hero-copy',
                        paksa_visual_actions( 'Discuss your needs', 'View services' )
                    ),
                    paksa_visual_group( 'is-style-paksa-card-dark',
                        paksa_visual_icon( 'services', 32 )
                        . paksa_visual_heading( 'What is included', 3 )
                        . paksa_visual_paragraph( 'List the most relevant areas of help, scope, or support.' )
                    ),
                ), 'pk-builder-hero-service' )
            ),
        ),
        'product-features-section' => array(
            __( 'Product — Features Section', 'paksa-it-solutions' ),
            'paksa-products',
            paksa_visual_section( '', 'Key features', 'What makes this product different.', 'Replace each feature with a real, verifiable capability.', $product_features ),
        ),
        'product-benefits-section' => array(
            __( 'Product — Benefits Section', 'paksa-it-solutions' ),
            'paksa-products',
            paksa_visual_section( 'pk-section--alt', 'Why it works', 'Proof behind the promise.', 'Use verified outcomes, not marketing language.', $product_benefits ),
        ),
        'service-process-section' => array(
            __( 'Service — Process Section', 'paksa-it-solutions' ),
            'paksa-services',
            paksa_visual_section( '', 'How we work', 'A process built around your goals.', 'Replace each step with your actual delivery process.', $service_process ),
        ),
        'related-content-block' => array(
            __( 'Related Content — Dynamic Block', 'paksa-it-solutions' ),
            'paksa-single',
            '<!-- wp:paksa/related-content /-->',
        ),
    );

    foreach ( $single_patterns as $slug => $p ) {
        register_block_pattern( 'paksa-it-solutions/' . $slug, array(
            'title'       => $p[0],
            'categories'  => array( $p[1] ),
            'description' => __( 'An editable Paksa Theme composition for product and service pages.', 'paksa-it-solutions' ),
            'content'     => $p[2],
        ) );
    }

    /* ── Page starter compositions ─────────────────────────────────────── */
    $about_full = paksa_visual_section( '', 'About us', 'The story behind the work.', 'Use this full about-page composition as a starting point. Replace every placeholder with real content.',
        paksa_visual_columns( array(
            paksa_visual_media_placeholder(),
            paksa_visual_group( 'pk-builder-feature-copy',
                paksa_visual_paragraph( 'Our story', 'pk-component-eyebrow' )
                . paksa_visual_heading( 'Built on a clear purpose.', 2 )
                . paksa_visual_paragraph( 'Replace this with your company origin story. Explain the problem you set out to solve, the people behind the work, and the values that guide every decision.' )
                . paksa_visual_actions( 'Meet the team', 'View our work' )
            ),
        ), 'pk-builder-feature-media' )
    )
    . paksa_visual_section( 'pk-section--alt', 'What guides us', 'Mission, vision, and values.', 'Use the cards to turn principles into practical commitments.',
        paksa_visual_columns( array(
            paksa_visual_card( 'compass', 'Mission', 'A concise statement of the change you want to create.' ),
            paksa_visual_card( 'sparkles', 'Vision', 'Where you are headed and what success looks like.' ),
            paksa_visual_card( 'shield', 'Values', 'The principles that guide every decision and interaction.' ),
        ) )
    )
    . paksa_visual_section( '', 'By the numbers', 'Proof that speaks for itself.', 'Replace each metric with a verified figure and a short label that gives it context.', paksa_visual_stat_grid() );

    $contact_full = paksa_visual_section( '', 'Get in touch', 'Start a conversation.', 'Use this contact page composition as a starting point.',
        paksa_visual_columns( array(
            paksa_visual_group( 'pk-pattern-contact-card',
                paksa_visual_heading( 'Send us a message', 3 )
                . paksa_visual_paragraph( 'Use the form to share your question, project brief, or enquiry. We respond within one business day.' )
                . '<!-- wp:shortcode -->[paksa_contact_form]<!-- /wp:shortcode -->'
            ),
            paksa_visual_group( 'pk-pattern-contact-card',
                paksa_visual_icon( 'location' )
                . paksa_visual_heading( 'Contact details', 3 )
                . paksa_visual_paragraph( 'Add your address, phone, email, and support hours here.' )
                . paksa_visual_actions( 'Get directions', 'Email us' )
            ),
        ) )
    );

    $page_starters = array(
        'page-about-full' => array(
            __( 'Page Starter — About', 'paksa-it-solutions' ),
            'paksa-page-starters',
            $about_full,
        ),
        'page-contact-full' => array(
            __( 'Page Starter — Contact', 'paksa-it-solutions' ),
            'paksa-page-starters',
            $contact_full,
        ),
        'page-services-full' => array(
            __( 'Page Starter — Services', 'paksa-it-solutions' ),
            'paksa-page-starters',
            paksa_visual_section( 'pk-hero pk-hero--classic', 'Our services', 'What we offer.', 'Replace with your services headline.',
                paksa_visual_actions( 'Get started', 'Contact us' )
            )
            . paksa_visual_section( '', 'What we do', 'A clear overview of our service areas.', 'Each card links to a dedicated service page.',
                paksa_composition_query( 'paksa_service', 'paksa_service_cat', 'paksa-card-service', 3, 9, 'View service', false )
            ),
        ),
        'page-products-full' => array(
            __( 'Page Starter — Products', 'paksa-it-solutions' ),
            'paksa-page-starters',
            paksa_visual_section( 'pk-hero pk-hero--classic', 'Our products', 'Solutions built for your business.', 'Replace with your products headline.',
                paksa_visual_actions( 'Explore products', 'Contact us' )
            )
            . paksa_visual_section( '', 'Product range', 'Browse the full collection.', 'Each card links to a dedicated product page.',
                paksa_composition_query( 'paksa_product', 'paksa_product_cat', 'paksa-card-product', 3, 9, 'View product', false )
            ),
        ),
        'page-blog-full' => array(
            __( 'Page Starter — Blog', 'paksa-it-solutions' ),
            'paksa-page-starters',
            paksa_visual_section( 'pk-hero pk-hero--classic', 'From the blog', 'Ideas and updates worth reading.', 'Replace with your blog headline.',
                paksa_visual_paragraph( '', '' )
            )
            . paksa_visual_section( '', 'Latest articles', 'A live feed of your most recent posts.', 'This Query Loop updates automatically.',
                paksa_composition_query( 'post', 'category', 'paksa-card-blog', 3, 9, 'Read more', false )
            ),
        ),
    );

    foreach ( $page_starters as $slug => $p ) {
        register_block_pattern( 'paksa-it-solutions/' . $slug, array(
            'title'       => $p[0],
            'categories'  => array( $p[1] ),
            'description' => __( 'A complete page starter composition built with native WordPress blocks and Paksa patterns.', 'paksa-it-solutions' ),
            'content'     => $p[2],
        ) );
    }
}
add_action( 'init', 'paksa_register_phase19_patterns', 36 );
