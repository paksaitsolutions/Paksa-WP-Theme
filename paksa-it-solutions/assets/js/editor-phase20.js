/* ============================================================
   Phase 20 — Advanced Site Builder & Editor UX
   Adds:
   - paksa/product-card  composable InnerBlocks card
   - paksa/service-card  composable InnerBlocks card
   - Responsive column controls for core/columns via BlockEdit filter
   - Additional block variations: blog, about, contact, minimal hero
   ============================================================ */
( function( wp ) {
    if ( ! wp || ! wp.blocks || ! wp.element || ! wp.blockEditor || ! wp.components ) return;

    var el               = wp.element.createElement;
    var Fragment         = wp.element.Fragment;
    var registerBlockType = wp.blocks.registerBlockType;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var InnerBlocks      = wp.blockEditor.InnerBlocks;
    var useBlockProps    = wp.blockEditor.useBlockProps;
    var PanelBody        = wp.components.PanelBody;
    var SelectControl    = wp.components.SelectControl;
    var RangeControl     = wp.components.RangeControl;
    var TextControl      = wp.components.TextControl;
    var ToggleControl    = wp.components.ToggleControl;
    var ctrlData         = window.paksaEditorControls || {};
    var iconData         = window.paksaIconBlock || { icons: [] };

    var iconOptionsWithNone = [ { label: 'None', value: '' } ].concat(
        ( iconData.icons || [] ).map( function( i ) { return { label: i.label, value: i.value }; } )
    );

    var animOptions = ctrlData.animationOptions || [
        { label: 'None', value: 'none' },
        { label: 'Fade Up', value: 'fade-up' },
        { label: 'Fade', value: 'fade' },
        { label: 'Scale', value: 'scale' }
    ];

    /* ── paksa/product-card ─────────────────────────────────────────────── */
    wp.domReady && wp.domReady( function() {

        registerBlockType( 'paksa/product-card', {
            apiVersion: 3,
            title: 'Paksa Product Card',
            description: 'A composable product card. Add icon, image, badge, heading, text, list, and buttons as nested blocks.',
            category: 'paksa-components',
            icon: 'products',
            supports: {
                html: false,
                align: [ 'left', 'center', 'right' ],
                color: { text: true, background: true },
                spacing: { margin: true, padding: true }
            },
            attributes: {
                variant:      { type: 'string',  default: 'default' },
                showBadge:    { type: 'boolean', default: false },
                badgeText:    { type: 'string',  default: '' },
                animation:    { type: 'string',  default: 'none' },
                animDelay:    { type: 'number',  default: 0 },
                shadowPreset: { type: 'string',  default: 'sm' },
                hoverEffect:  { type: 'string',  default: 'lift' }
            },
            edit: function( props ) {
                var a = props.attributes;
                var set = props.setAttributes;
                var cls = 'pk-composable-card pk-composable-card--product is-style-paksa-card-product pk-composable-card--' + a.variant;
                if ( a.animation && a.animation !== 'none' ) cls += ' is-style-paksa-motion-' + a.animation;
                var blockProps = useBlockProps ? useBlockProps( { className: cls } ) : { className: 'wp-block-paksa-product-card ' + cls };

                return el( Fragment, {},
                    el( InspectorControls, {},
                        el( PanelBody, { title: 'Card Style', initialOpen: true },
                            el( SelectControl, {
                                label: 'Variant',
                                value: a.variant,
                                options: [
                                    { label: 'Default', value: 'default' },
                                    { label: 'Dark', value: 'dark' },
                                    { label: 'Bordered', value: 'bordered' },
                                    { label: 'Glass', value: 'glass' }
                                ],
                                onChange: function( v ) { set( { variant: v } ); }
                            } ),
                            el( SelectControl, {
                                label: 'Shadow',
                                value: a.shadowPreset,
                                options: [
                                    { label: 'None', value: 'none' },
                                    { label: 'Small', value: 'sm' },
                                    { label: 'Medium', value: 'md' },
                                    { label: 'Large', value: 'lg' }
                                ],
                                onChange: function( v ) { set( { shadowPreset: v } ); }
                            } ),
                            el( SelectControl, {
                                label: 'Hover effect',
                                value: a.hoverEffect,
                                options: [
                                    { label: 'None', value: 'none' },
                                    { label: 'Lift', value: 'lift' },
                                    { label: 'Glow', value: 'glow' },
                                    { label: 'Scale', value: 'scale' }
                                ],
                                onChange: function( v ) { set( { hoverEffect: v } ); }
                            } )
                        ),
                        el( PanelBody, { title: 'Badge', initialOpen: false },
                            el( ToggleControl, {
                                label: 'Show badge',
                                checked: a.showBadge,
                                onChange: function( v ) { set( { showBadge: v } ); }
                            } ),
                            a.showBadge ? el( TextControl, {
                                label: 'Badge text',
                                value: a.badgeText,
                                onChange: function( v ) { set( { badgeText: v } ); }
                            } ) : null
                        ),
                        el( PanelBody, { title: 'Animation', initialOpen: false },
                            el( SelectControl, {
                                label: 'Entrance animation',
                                value: a.animation,
                                options: animOptions,
                                onChange: function( v ) { set( { animation: v } ); }
                            } ),
                            a.animation && a.animation !== 'none' ? el( RangeControl, {
                                label: 'Delay (ms)',
                                value: a.animDelay || 0,
                                min: 0, max: 600, step: 100,
                                onChange: function( v ) { set( { animDelay: v } ); }
                            } ) : null
                        )
                    ),
                    el( 'article', blockProps,
                        a.showBadge && a.badgeText
                            ? el( 'span', { className: 'pk-composable-card__badge pk-component-badge' }, a.badgeText )
                            : null,
                        el( InnerBlocks, {
                            allowedBlocks: [
                                'core/image', 'core/heading', 'core/paragraph',
                                'core/list', 'core/buttons', 'core/button',
                                'paksa/icon', 'paksa/action', 'paksa/stat'
                            ],
                            template: [
                                [ 'paksa/icon', { name: 'products', size: 24 } ],
                                [ 'core/heading', { level: 3, placeholder: 'Product name' } ],
                                [ 'core/paragraph', { placeholder: 'Short product description.' } ],
                                [ 'core/buttons', {}, [
                                    [ 'core/button', { text: 'View product', className: 'is-style-paksa-button-text' } ]
                                ] ]
                            ],
                            renderAppender: InnerBlocks.ButtonBlockAppender
                        } )
                    )
                );
            },
            save: function() {
                return el( 'article', useBlockProps ? useBlockProps.save() : { className: 'wp-block-paksa-product-card' },
                    el( InnerBlocks.Content )
                );
            }
        } );

        /* ── paksa/service-card ─────────────────────────────────────────── */
        registerBlockType( 'paksa/service-card', {
            apiVersion: 3,
            title: 'Paksa Service Card',
            description: 'A composable service card. Add icon, heading, text, list, and buttons as nested blocks.',
            category: 'paksa-components',
            icon: 'admin-tools',
            supports: {
                html: false,
                align: [ 'left', 'center', 'right' ],
                color: { text: true, background: true },
                spacing: { margin: true, padding: true }
            },
            attributes: {
                variant:      { type: 'string',  default: 'default' },
                showCategory: { type: 'boolean', default: false },
                categoryText: { type: 'string',  default: '' },
                animation:    { type: 'string',  default: 'none' },
                animDelay:    { type: 'number',  default: 0 },
                shadowPreset: { type: 'string',  default: 'sm' },
                hoverEffect:  { type: 'string',  default: 'lift' }
            },
            edit: function( props ) {
                var a = props.attributes;
                var set = props.setAttributes;
                var cls = 'pk-composable-card pk-composable-card--service is-style-paksa-card-service pk-composable-card--' + a.variant;
                if ( a.animation && a.animation !== 'none' ) cls += ' is-style-paksa-motion-' + a.animation;
                var blockProps = useBlockProps ? useBlockProps( { className: cls } ) : { className: 'wp-block-paksa-service-card ' + cls };

                return el( Fragment, {},
                    el( InspectorControls, {},
                        el( PanelBody, { title: 'Card Style', initialOpen: true },
                            el( SelectControl, {
                                label: 'Variant',
                                value: a.variant,
                                options: [
                                    { label: 'Default', value: 'default' },
                                    { label: 'Dark', value: 'dark' },
                                    { label: 'Bordered', value: 'bordered' },
                                    { label: 'Glass', value: 'glass' }
                                ],
                                onChange: function( v ) { set( { variant: v } ); }
                            } ),
                            el( SelectControl, {
                                label: 'Shadow',
                                value: a.shadowPreset,
                                options: [
                                    { label: 'None', value: 'none' },
                                    { label: 'Small', value: 'sm' },
                                    { label: 'Medium', value: 'md' },
                                    { label: 'Large', value: 'lg' }
                                ],
                                onChange: function( v ) { set( { shadowPreset: v } ); }
                            } ),
                            el( SelectControl, {
                                label: 'Hover effect',
                                value: a.hoverEffect,
                                options: [
                                    { label: 'None', value: 'none' },
                                    { label: 'Lift', value: 'lift' },
                                    { label: 'Glow', value: 'glow' },
                                    { label: 'Scale', value: 'scale' }
                                ],
                                onChange: function( v ) { set( { hoverEffect: v } ); }
                            } )
                        ),
                        el( PanelBody, { title: 'Category Label', initialOpen: false },
                            el( ToggleControl, {
                                label: 'Show category label',
                                checked: a.showCategory,
                                onChange: function( v ) { set( { showCategory: v } ); }
                            } ),
                            a.showCategory ? el( TextControl, {
                                label: 'Category text',
                                value: a.categoryText,
                                onChange: function( v ) { set( { categoryText: v } ); }
                            } ) : null
                        ),
                        el( PanelBody, { title: 'Animation', initialOpen: false },
                            el( SelectControl, {
                                label: 'Entrance animation',
                                value: a.animation,
                                options: animOptions,
                                onChange: function( v ) { set( { animation: v } ); }
                            } ),
                            a.animation && a.animation !== 'none' ? el( RangeControl, {
                                label: 'Delay (ms)',
                                value: a.animDelay || 0,
                                min: 0, max: 600, step: 100,
                                onChange: function( v ) { set( { animDelay: v } ); }
                            } ) : null
                        )
                    ),
                    el( 'article', blockProps,
                        a.showCategory && a.categoryText
                            ? el( 'span', { className: 'pk-composable-card__category pk-component-eyebrow' }, a.categoryText )
                            : null,
                        el( InnerBlocks, {
                            allowedBlocks: [
                                'core/image', 'core/heading', 'core/paragraph',
                                'core/list', 'core/buttons', 'core/button',
                                'paksa/icon', 'paksa/action'
                            ],
                            template: [
                                [ 'paksa/icon', { name: 'services', size: 24 } ],
                                [ 'core/heading', { level: 3, placeholder: 'Service name' } ],
                                [ 'core/paragraph', { placeholder: 'Short service description.' } ],
                                [ 'core/list', { className: 'is-style-paksa-icon-list', values: '<li>Deliverable one</li><li>Deliverable two</li><li>Deliverable three</li>' } ],
                                [ 'core/buttons', {}, [
                                    [ 'core/button', { text: 'Learn more', className: 'is-style-paksa-button-text' } ]
                                ] ]
                            ],
                            renderAppender: InnerBlocks.ButtonBlockAppender
                        } )
                    )
                );
            },
            save: function() {
                return el( 'article', useBlockProps ? useBlockProps.save() : { className: 'wp-block-paksa-service-card' },
                    el( InnerBlocks.Content )
                );
            }
        } );

    } );

} )( window.wp );

/* ── Phase 20 additional block variations ───────────────────────────────── */
( function( wp ) {
    if ( ! wp || ! wp.blocks || ! wp.blocks.registerBlockVariation ) return;

    var variations = [
        /* Minimal hero — no image, centered, narrow */
        {
            block: 'core/group',
            name: 'paksa-hero-minimal',
            title: 'Paksa Hero — Minimal',
            description: 'A centered, text-only hero with no image.',
            attributes: { align: 'full', className: 'pk-section pk-hero pk-hero--centered', layout: { type: 'constrained', contentSize: '720px' } },
            innerBlocks: [
                [ 'core/paragraph', { content: 'Eyebrow label', className: 'pk-component-eyebrow', textAlign: 'center' } ],
                [ 'core/heading', { level: 1, placeholder: 'Clear, focused headline', textAlign: 'center', fontSize: 'display' } ],
                [ 'core/paragraph', { placeholder: 'One or two sentences that explain the value.', className: 'is-style-paksa-lead', textAlign: 'center' } ],
                [ 'core/buttons', { layout: { type: 'flex', justifyContent: 'center' } }, [
                    [ 'core/button', { text: 'Get started' } ],
                    [ 'core/button', { text: 'Learn more', className: 'is-style-paksa-button-outline' } ]
                ] ]
            ]
        },
        /* About — image + content split */
        {
            block: 'core/group',
            name: 'paksa-about-split',
            title: 'Paksa About — Image + Content',
            description: 'A two-column about section with image on the left and content on the right.',
            attributes: { align: 'full', className: 'pk-section', layout: { type: 'constrained' } },
            innerBlocks: [
                [ 'core/columns', { verticalAlignment: 'center', className: 'pk-builder-feature-media' }, [
                    [ 'core/column', {}, [
                        [ 'core/image', { className: 'is-style-paksa-rounded', sizeSlug: 'large' } ]
                    ] ],
                    [ 'core/column', {}, [
                        [ 'core/paragraph', { content: 'About us', className: 'pk-component-eyebrow' } ],
                        [ 'core/heading', { level: 2, placeholder: 'The story behind the work' } ],
                        [ 'core/paragraph', { placeholder: 'Replace with your company story.' } ],
                        [ 'core/buttons', {}, [
                            [ 'core/button', { text: 'Meet the team' } ]
                        ] ]
                    ] ]
                ] ]
            ]
        },
        /* Blog section with live query */
        {
            block: 'core/group',
            name: 'paksa-blog-section',
            title: 'Paksa Blog Section',
            description: 'A section with eyebrow, heading, and a live 3-column post grid.',
            attributes: { align: 'full', className: 'pk-section', layout: { type: 'constrained' } },
            innerBlocks: [
                [ 'core/paragraph', { content: 'From the blog', className: 'pk-component-eyebrow', textAlign: 'center' } ],
                [ 'core/heading', { level: 2, placeholder: 'Latest articles', textAlign: 'center' } ],
                [ 'core/query', {
                    queryId: 60,
                    query: { perPage: 3, postType: 'post', order: 'desc', orderBy: 'date', inherit: false },
                    className: 'pk-site-editor-resource-grid'
                }, [
                    [ 'core/post-template', { layout: { type: 'grid', columnCount: 3 } }, [
                        [ 'core/group', { className: 'is-style-paksa-card-blog', layout: { type: 'constrained' } }, [
                            [ 'core/post-featured-image', { isLink: true, className: 'is-style-paksa-image-zoom' } ],
                            [ 'core/post-terms', { term: 'category', className: 'pk-component-meta' } ],
                            [ 'core/post-title', { isLink: true, level: 3 } ],
                            [ 'core/post-excerpt', { moreText: 'Read more' } ]
                        ] ]
                    ] ],
                    [ 'core/query-pagination', { layout: { type: 'flex', justifyContent: 'center' } }, [
                        [ 'core/query-pagination-previous' ],
                        [ 'core/query-pagination-numbers' ],
                        [ 'core/query-pagination-next' ]
                    ] ]
                ] ]
            ]
        },
        /* Contact section */
        {
            block: 'core/group',
            name: 'paksa-contact-section',
            title: 'Paksa Contact Section',
            description: 'A two-column contact section with form and contact details.',
            attributes: { align: 'full', className: 'pk-section', layout: { type: 'constrained' } },
            innerBlocks: [
                [ 'core/paragraph', { content: 'Get in touch', className: 'pk-component-eyebrow', textAlign: 'center' } ],
                [ 'core/heading', { level: 2, placeholder: 'Start a conversation', textAlign: 'center' } ],
                [ 'core/columns', {}, [
                    [ 'core/column', {}, [
                        [ 'core/group', { className: 'pk-pattern-contact-card', layout: { type: 'constrained' } }, [
                            [ 'core/heading', { level: 3, content: 'Send a message' } ],
                            [ 'core/paragraph', { content: 'Use the form to share your question or project brief.' } ],
                            [ 'core/shortcode', { text: '[paksa_contact_form]' } ]
                        ] ]
                    ] ],
                    [ 'core/column', {}, [
                        [ 'core/group', { className: 'pk-pattern-contact-card', layout: { type: 'constrained' } }, [
                            [ 'core/heading', { level: 3, content: 'Contact details' } ],
                            [ 'core/paragraph', { content: 'Add your address, phone, email, and support hours here.' } ],
                            [ 'core/buttons', {}, [
                                [ 'core/button', { text: 'Get directions', className: 'is-style-paksa-button-outline' } ]
                            ] ]
                        ] ]
                    ] ]
                ] ]
            ]
        },
        /* FAQ section */
        {
            block: 'core/group',
            name: 'paksa-faq-section',
            title: 'Paksa FAQ Section',
            description: 'A narrow section with accordion FAQ items using native Details blocks.',
            attributes: { align: 'full', className: 'pk-section', layout: { type: 'constrained', contentSize: '720px' } },
            innerBlocks: [
                [ 'core/paragraph', { content: 'FAQ', className: 'pk-component-eyebrow', textAlign: 'center' } ],
                [ 'core/heading', { level: 2, placeholder: 'Common questions', textAlign: 'center' } ],
                [ 'core/details', { className: 'pk-pattern-faq', showContent: true }, [
                    [ 'core/paragraph', { content: 'What can I change after inserting this pattern?' } ],
                    [ 'core/paragraph', { content: 'Everything: content, layout, colors, type, spacing, buttons, and media remain native Gutenberg blocks.' } ]
                ] ],
                [ 'core/details', { className: 'pk-pattern-faq' }, [
                    [ 'core/paragraph', { content: 'Does the design work on smaller screens?' } ],
                    [ 'core/paragraph', { content: 'Yes. The pattern uses responsive WordPress blocks and the theme\'s shared layout rules.' } ]
                ] ],
                [ 'core/details', { className: 'pk-pattern-faq' }, [
                    [ 'core/paragraph', { content: 'Can I reuse this section on other pages?' } ],
                    [ 'core/paragraph', { content: 'Yes. Insert it from the Patterns panel whenever you need the same structure.' } ]
                ] ]
            ]
        },
        /* Newsletter section */
        {
            block: 'core/group',
            name: 'paksa-newsletter-section',
            title: 'Paksa Newsletter Section',
            description: 'A narrow centered newsletter signup section.',
            attributes: { align: 'full', className: 'pk-section pk-section--alt', layout: { type: 'constrained', contentSize: '640px' } },
            innerBlocks: [
                [ 'core/paragraph', { content: 'Newsletter', className: 'pk-component-eyebrow', textAlign: 'center' } ],
                [ 'core/heading', { level: 2, placeholder: 'Stay in the loop', textAlign: 'center' } ],
                [ 'core/paragraph', { placeholder: 'Useful updates, sent with care. No spam.', textAlign: 'center' } ],
                [ 'core/search', { label: 'Email address', showLabel: false, placeholder: 'Your email address', buttonText: 'Subscribe', buttonUseIcon: false } ]
            ]
        },
        /* Composable product card grid */
        {
            block: 'core/columns',
            name: 'paksa-product-card-grid',
            title: 'Paksa Product Card Grid',
            description: 'A 3-column grid of composable Paksa product cards.',
            attributes: { className: 'pk-pattern-card-grid is-style-paksa-grid-3' },
            innerBlocks: [
                [ 'core/column', {}, [ [ 'paksa/product-card', {} ] ] ],
                [ 'core/column', {}, [ [ 'paksa/product-card', {} ] ] ],
                [ 'core/column', {}, [ [ 'paksa/product-card', {} ] ] ]
            ]
        },
        /* Composable service card grid */
        {
            block: 'core/columns',
            name: 'paksa-service-card-grid',
            title: 'Paksa Service Card Grid',
            description: 'A 3-column grid of composable Paksa service cards.',
            attributes: { className: 'pk-pattern-card-grid is-style-paksa-grid-3' },
            innerBlocks: [
                [ 'core/column', {}, [ [ 'paksa/service-card', {} ] ] ],
                [ 'core/column', {}, [ [ 'paksa/service-card', {} ] ] ],
                [ 'core/column', {}, [ [ 'paksa/service-card', {} ] ] ]
            ]
        }
    ];

    variations.forEach( function( v ) {
        wp.blocks.registerBlockVariation( v.block, {
            name: v.name,
            title: v.title,
            description: v.description,
            attributes: v.attributes,
            innerBlocks: v.innerBlocks || [],
            scope: [ 'inserter', 'transform' ]
        } );
    } );

} )( window.wp );

/* ── Phase 20 responsive column controls via BlockEdit filter ───────────── */
( function( wp ) {
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var SelectControl  = wp.components.SelectControl;
    var ToggleControl  = wp.components.ToggleControl;
    var createHigherOrderComponent = wp.compose && wp.compose.createHigherOrderComponent;

    if ( ! createHigherOrderComponent ) return;

    var SUPPORTED = [ 'core/columns', 'core/group', 'paksa/section' ];

    var withResponsiveControls = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( SUPPORTED.indexOf( props.name ) === -1 ) {
                return el( BlockEdit, props );
            }

            var a   = props.attributes;
            var set = props.setAttributes;

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {},
                    el( PanelBody, { title: 'Responsive Layout', initialOpen: false, className: 'pk-responsive-panel' },
                        el( SelectControl, {
                            label: 'Mobile columns',
                            value: ( a.pkMobileCols || '1' ),
                            options: [
                                { label: '1 column (stacked)', value: '1' },
                                { label: '2 columns', value: '2' }
                            ],
                            onChange: function( v ) { set( { pkMobileCols: v } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Tablet columns',
                            value: ( a.pkTabletCols || '2' ),
                            options: [
                                { label: '1 column', value: '1' },
                                { label: '2 columns', value: '2' },
                                { label: '3 columns', value: '3' }
                            ],
                            onChange: function( v ) { set( { pkTabletCols: v } ); }
                        } ),
                        el( ToggleControl, {
                            label: 'Stack on mobile',
                            checked: a.pkStackMobile !== false,
                            onChange: function( v ) { set( { pkStackMobile: v } ); }
                        } )
                    )
                )
            );
        };
    }, 'withPaksaResponsiveControls' );

    addFilter(
        'editor.BlockEdit',
        'paksa/responsive-controls',
        withResponsiveControls
    );

    /* Register the custom attributes so they persist */
    addFilter(
        'blocks.registerBlockType',
        'paksa/responsive-attributes',
        function( settings, name ) {
            if ( SUPPORTED.indexOf( name ) === -1 ) return settings;
            settings.attributes = Object.assign( {}, settings.attributes, {
                pkMobileCols:  { type: 'string', default: '1' },
                pkTabletCols:  { type: 'string', default: '2' },
                pkStackMobile: { type: 'boolean', default: true }
            } );
            return settings;
        }
    );

} )( window.wp );
