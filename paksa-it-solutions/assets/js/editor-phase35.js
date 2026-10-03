( function( wp ) {
    'use strict';

    if ( ! wp || ! wp.blocks || ! wp.element || ! wp.blockEditor || ! wp.components ) {
        return;
    }

    var el              = wp.element.createElement;
    var Fragment        = wp.element.Fragment;
    var registerBlockType = wp.blocks.registerBlockType;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var BlockControls     = wp.blockEditor.BlockControls;
    var ToolbarGroup      = wp.blockEditor.ToolbarGroup;
    var ToolbarButton     = wp.blockEditor.ToolbarButton;
    var PanelBody         = wp.components.PanelBody;
    var SelectControl     = wp.components.SelectControl;
    var RangeControl      = wp.components.RangeControl;
    var TextControl       = wp.components.TextControl;
    var TextareaControl   = wp.components.TextareaControl;
    var ToggleControl     = wp.components.ToggleControl;
    var Notice          = wp.components.Notive;
    var addFilter        = wp.hooks && wp.hooks.addFilter;

    var phase35 = window.paksaPhase35 || {
        contentTypes: [],
        queryModes: [],
        orderOptions: [],
        layoutPresets: [],
        cardRegions: [],
        featuredOptions: [],
        postTypes: [],
        taxonomies: [],
        nonce: '',
        restUrl: '',
        version: ''
    };

    function getOptions( key, fallback ) {
        return phase35[ key ] && phase35[ key ].length ? phase35[ key ] : fallback;
    }

    var contentTypeOpts = getOptions( 'contentTypes', [
        { label: 'Posts', value: 'post' },
        { label: 'Products', value: 'paksa_product' },
        { label: 'Services', value: 'paksa_service' }
    ] );

    var queryModeOpts = getOptions( 'queryModes', [
        { label: 'Dynamic (query)', value: 'dynamic' },
        { label: 'Manual (selected)', value: 'manual' }
    ] );

    var orderOpts = getOptions( 'orderOptions', [
        { label: 'Newest first', value: 'DESC|date' },
        { label: 'Oldest first', value: 'ASC|date' },
        { label: 'Title A–Z', value: 'ASC|title' },
        { label: 'Title Z–A', value: 'DESC|title' }
    ] );

    var layoutOpts = getOptions( 'layoutPresets', [
        { label: 'Grid', value: 'grid' },
        { label: 'List', value: 'list' },
        { label: 'Featured + Grid', value: 'featured' }
    ] );

    var featuredOpts = getOptions( 'featuredOptions', [
        { label: 'All items', value: 'all' },
        { label: 'Featured only', value: 'featured' }
    ] );

    var animOpts = phase35.animationOptions || [
        { label: 'None', value: 'none' },
        { label: 'Fade', value: 'fade' },
        { label: 'Fade Up', value: 'fade-up' },
        { label: 'Fade Left', value: 'fade-left' },
        { label: 'Fade Right', value: 'fade-right' },
        { label: 'Scale', value: 'scale' },
        { label: 'Reveal', value: 'reveal' },
        { label: 'Stagger', value: 'stagger' }
    ];

    /* ── paksa/dynamic-grid ──────────────────────────────────────────────────── */

    function DynamicGridInspector( props ) {
        var attrs = props.attributes;
        var setAttrs = props.setAttrs;

        function set( key, val ) {
            var u = {}; u[ key ] = val; setAttrs( u );
        }

        var sourceTaxKey = 'sourceTax_' + attrs.source;
        var cachedTax = window.paksaPhase35_taxCache = window.paksaPhase35_taxCache || {};
        var taxTerms = cachedTax[ attrs.source ] || [];

        var taxField = attrs.source === 'post' ? 'category' :
            ( attrs.source === 'paksa_product' ? 'paksa_product_cat' :
            ( attrs.source === 'paksa_service' ? 'paksa_service_cat' : '' ) );

        if ( ! cachedTax[ attrs.source ] && taxField ) {
            cachedTax[ attrs.source ] = [];
            wp.apiFetch( { path: '/wp/v2/' + ( attrs.source === 'post' ? 'categories' :
                ( attrs.source === 'paksa_product' ? 'paksa_product_cat' :
                ( attrs.source === 'paksa_service' ? 'paksa_service_cat' : '' ) ) ) + '?per_page=100&hide_empty=true' } )
                .then( function( response ) {
                    if ( response && ! response.code ) {
                        cachedTax[ attrs.source ] = response;
                        set( 'taxCacheVersion', ( attrs.taxCacheVersion || 0 ) + 1 );
                    }
                } )
                .catch( function() {} );
        }

        var categoryOptions = [ { label: 'All categories', value: '' } ];
        if ( taxField && taxTerms && taxTerms.length ) {
            taxTerms.forEach( function( term ) {
                categoryOptions.push( { label: term.name, value: term.slug } );
            } );
        }

        return el(
            Fragment,
            {},
            el(
                PanelBody,
                { title: 'Content Source', initialOpen: true },
                el( SelectControl, {
                    label: 'Content type',
                    value: attrs.source,
                    options: contentTypeOpts,
                    onChange: function( v ) { set( 'source', v ); }
                } ),
                el( SelectControl, {
                    label: 'Query mode',
                    value: attrs.mode,
                    options: queryModeOpts,
                    onChange: function( v ) { set( 'mode', v ); }
                } )
            ),
            el(
                PanelBody,
                { title: 'Query Settings', initialOpen: attrs.mode === 'dynamic' },
                el( SelectControl, {
                    label: 'Order by',
                    value: attrs.order + '|' + attrs.orderBy,
                    options: orderOpts,
                    onChange: function( v ) {
                        var parts = v.split( '|' );
                        set( 'order', parts[ 0 ] );
                        set( 'orderBy', parts[ 1 ] );
                    }
                } ),
                el( RangeControl, {
                    label: 'Items per page',
                    value: attrs.perPage,
                    min: 1,
                    max: 50,
                    onChange: function( v ) { set( 'perPage', v ); }
                } ),
                el( RangeControl, {
                    label: 'Offset',
                    value: attrs.offset,
                    min: 0,
                    max: 50,
                    onChange: function( v ) { set( 'offset', v ); }
                } ),
                attrs.mode === 'dynamic' && taxField ?
                    el( SelectControl, {
                        label: 'Category filter',
                        value: attrs.category,
                        options: categoryOptions,
                        onChange: function( v ) { set( 'category', v ); }
                    } ) : null,
                el( SelectControl, {
                    label: 'Featured',
                    value: attrs.featured,
                    options: featuredOpts,
                    onChange: function( v ) { set( 'featured', v ); }
                } ),
                attrs.mode === 'dynamic' ?
                    el( TextControl, {
                        label: 'Search keyword',
                        value: attrs.search || '',
                        placeholder: 'Filter by search term',
                        onChange: function( v ) { set( 'search', v ); }
                    } ) : null,
                attrs.mode === 'manual' ?
                    el( TextControl, {
                        label: 'Selected IDs (comma-separated)',
                        value: attrs.selectedIds || '',
                        placeholder: 'e.g. 12, 34, 56',
                        onChange: function( v ) { set( 'selectedIds', v ); }
                    } ) : null
            ),
            el(
                PanelBody,
                { title: 'Layout & Design', initialOpen: false },
                el( SelectControl, {
                    label: 'Layout',
                    value: attrs.layout,
                    options: layoutOpts,
                    onChange: function( v ) { set( 'layout', v ); }
                } ),
                el( RangeControl, {
                    label: 'Columns',
                    value: attrs.columns,
                    min: 1,
                    max: 4,
                    onChange: function( v ) { set( 'columns', v ); }
                } ),
                el( ToggleControl, {
                    label: 'Show category filter',
                    checked: attrs.showFilter,
                    onChange: function( v ) { set( 'showFilter', v ); }
                } ),
                el( ToggleControl, {
                    label: 'Enable search',
                    checked: attrs.enableSearch,
                    onChange: function( v ) { set( 'enableSearch', v ); }
                } )
            ),
            el(
                PanelBody,
                { title: 'Content', initialOpen: false },
                el( TextControl, {
                    label: 'Eyebrow',
                    value: attrs.eyebrow || '',
                    onChange: function( v ) { set( 'eyebrow', v ); }
                } ),
                el( TextControl, {
                    label: 'Heading',
                    value: attrs.heading || '',
                    placeholder: 'Section heading',
                    onChange: function( v ) { set( 'heading', v ); }
                } ),
                el( TextareaControl, {
                    label: 'Description',
                    value: attrs.description || '',
                    placeholder: 'Section description',
                    onChange: function( v ) { set( 'description', v ); }
                } )
            ),
            el(
                PanelBody,
                { title: 'Read More Link', initialOpen: false },
                el( ToggleControl, {
                    label: 'Show "View all" link',
                    checked: attrs.showReadMore,
                    onChange: function( v ) { set( 'showReadMore', v ); }
                } ),
                attrs.showReadMore ?
                    el( TextControl, {
                        label: 'Link label',
                        value: attrs.readMoreLabel || '',
                        onChange: function( v ) { set( 'readMoreLabel', v ); }
                    } ) : null,
                attrs.showReadMore ?
                    el( TextControl, {
                        label: 'Link URL',
                        value: attrs.readMoreUrl || '',
                        placeholder: 'https://example.com/archive',
                        onChange: function( v ) { set( 'readMoreUrl', v ); }
                    } ) : null,
                attrs.showReadMore ?
                    el( ToggleControl, {
                        label: 'Open in new tab',
                        checked: attrs.readMoreNewTab,
                        onChange: function( v ) { set( 'readMoreNewTab', v ); }
                    } ) : null
            ),
            el(
                PanelBody,
                { title: 'Empty State', initialOpen: false },
                el( TextareaControl, {
                    label: 'Empty message (optional)',
                    value: attrs.emptyMessage || '',
                    placeholder: 'No matching items found. Adjust your query settings.',
                    help: 'Overrides the default empty-state message.',
                    onChange: function( v ) { set( 'emptyMessage', v ); }
                } )
            )
        );
    }

    registerBlockType( 'paksa/dynamic-grid', {
        apiVersion: 3,
        title: 'Paksa Dynamic Grid',
        description: 'Query and display posts, products, or services with visual controls.',
        category: 'paksa-components',
        icon: 'media-grid',
        attributes: {
            source:         { type: 'string', default: 'paksa_product' },
            mode:           { type: 'string', default: 'dynamic' },
            orderBy:        { type: 'string', default: 'date' },
            order:          { type: 'string', default: 'desc' },
            perPage:        { type: 'number', default: 9 },
            offset:         { type: 'number', default: 0 },
            category:       { type: 'string', default: '' },
            author:         { type: 'string', default: '' },
            featured:       { type: 'string', default: 'all' },
            selectedIds:    { type: 'string', default: '' },
            search:         { type: 'string', default: '' },
            cardVariant:    { type: 'string', default: 'default' },
            layout:         { type: 'string', default: 'grid' },
            columns:        { type: 'number', default: 3 },
            showFilter:     { type: 'boolean', default: false },
            enableSearch:   { type: 'boolean', default: false },
            heading:        { type: 'string', default: '' },
            eyebrow:        { type: 'string', default: '' },
            description:    { type: 'string', default: '' },
            emptyMessage:   { type: 'string', default: '' },
            showReadMore:   { type: 'boolean', default: false },
            readMoreLabel:  { type: 'string', default: 'View all' },
            readMoreUrl:    { type: 'string', default: '' },
            readMoreNewTab: { type: 'boolean', default: false },
            taxCacheVersion:{ type: 'number', default: 0 },
            colsMobile:     { type: 'number', default: 1 },
            colsTablet:     { type: 'number', default: 2 },
            colsDesktop:    { type: 'number', default: 3 },
            stackMobile:    { type: 'boolean', default: true },
            hoverEffect:    { type: 'string', default: 'none' },
            hoverShadow:    { type: 'boolean', default: false },
            hoverLift:      { type: 'boolean', default: false },
            hoverBgColor:   { type: 'string', default: '' },
            transition:     { type: 'string', default: 'base' },
            borderWidth:    { type: 'string', default: '' },
            borderStyle:    { type: 'string', default: 'solid' },
            borderColor:    { type: 'string', default: '' },
            borderRadius:   { type: 'string', default: '' },
            shadowPreset:   { type: 'string', default: 'none' },
            animation:      { type: 'string', default: 'none' },
            animDelay:      { type: 'number', default: 0 },
            animDuration:   { type: 'number', default: 600 },
        },
        supports: {
            align: [ 'wide', 'full' ],
            anchor: true,
            color: { text: true, background: true },
            spacing: { padding: true, margin: true, blockGap: true },
            html: false,
        },
        edit: function( props ) {
            var attrs = props.attributes;

            var sourceIcon = 'media-grid';
            var sourceLabel = 'Dynamic Content';
            if ( attrs.source === 'paksa_product' ) sourceLabel = 'Products';
            else if ( attrs.source === 'paksa_service' ) sourceLabel = 'Services';
            else if ( attrs.source === 'post' ) sourceLabel = 'Posts';
            else if ( attrs.source === 'page' ) sourceLabel = 'Pages';

            var modeLabel = attrs.mode === 'manual' ? 'Manual' : 'Dynamic';

            var previewLabel = el( 'div',
                { className: 'pk-dynamic-grid-preview-label' },
                el( 'span', { className: 'pk-dynamic-badge is-dynamic' }, 'Dynamic' ),
                el( 'span', { className: 'pk-dynamic-source' },
                    sourceLabel + ' • ' + modeLabel )
            );

            return el(
                Fragment,
                {},
                el(
                    BlockControls,
                    { controls: 'top' },
                    el( ToolbarGroup, {},
                        el( ToolbarButton, {
                            icon: 'edit',
                            label: 'Configure query',
                            isPreferred: true
                        } ),
                        el( ToolbarButton, {
                            icon: 'edit-large',
                            label: 'Edit layout',
                            isPreferred: true
                        } )
                    )
                ),
                el( InspectorControls, {}, el( DynamicGridInspector, { attributes: attrs, setAttrs: props.setAttributes } ) ),
                el(
                    'div',
                    { className: 'pk-dynamic-grid-editor-placeholder' },
                    previewLabel,
                    el( 'div', { className: 'pk-dynamic-grid-placeholder-content' },
                        el( 'p', { className: 'pk-dynamic-grid-placeholder-text' },
                            'Dynamic ' + sourceLabel + ' grid — ' + modeLabel + ' mode' ),
                        el( 'p', { className: 'pk-dynamic-grid-placeholder-hint' },
                            'Configure in the inspector or use the toolbar buttons.' )
                    )
                )
            );
        },
        save: function() { return null; }
    } );

    /* ── paksa/dynamic-card ──────────────────────────────────────────────────── */

    registerBlockType( 'paksa/dynamic-card', {
        apiVersion: 3,
        title: 'Paksa Dynamic Card',
        description: 'A composable card that renders dynamic post, product, or service data.',
        category: 'paksa-components',
        icon: 'media-document',
        attributes: {
            source:          { type: 'string', default: 'post' },
            cardVariant:     { type: 'string', default: 'default' },
            showImage:       { type: 'boolean', default: true },
            showEyebrow:     { type: 'boolean', default: true },
            showTitle:       { type: 'boolean', default: true },
            showDescription: { type: 'boolean', default: true },
            showMetadata:    { type: 'boolean', default: false },
            showPrice:       { type: 'boolean', default: false },
            showCategory:    { type: 'boolean', default: true },
            showCta:         { type: 'boolean', default: true },
            showIcon:        { type: 'boolean', default: false },
            showBadge:       { type: 'boolean', default: true },
            linkLabel:       { type: 'string', default: '' },
            headingTag:      { type: 'string', default: 'h3' },
            animation:       { type: 'string', default: 'none' },
            animDelay:       { type: 'number', default: 0 },
        },
        supports: {
            align: [ 'left', 'center', 'right' ],
            color: { text: true, background: true },
            spacing: { margin: true, padding: true },
            html: false,
        },
        edit: function( props ) {
            var attrs = props.attributes;
            var setAttrs = props.setAttrs;

            function set( key, val ) {
                var u = {}; u[ key ] = val; setAttrs( u );
            }

            var cardRegionDefaults = phase35.cardRegions || [];

            return el(
                Fragment,
                {},
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        { title: 'Content Source', initialOpen: true },
                        el( SelectControl, {
                            label: 'Source',
                            value: attrs.source,
                            options: contentTypeOpts,
                            onChange: function( v ) { set( 'source', v ); }
                        } )
                    ),
                    el(
                        PanelBody,
                        { title: 'Card Regions', initialOpen: true },
                        el( BaseControl, {
                            id: 'pk-dynamic-card-regions',
                            label: 'Visible card regions',
                            help: 'Toggle which fields this card renders. Only fields that exist in the content type will appear.'
                        },
                            el( 'div', { className: 'pk-card-region-toggles' },
                                cardRegionDefaults.map( function( region ) {
                                    var attrKey = 'show' + region.key.charAt( 0 ).toUpperCase() + region.key.slice( 1 );
                                    return el( ToggleControl, {
                                        key: region.key,
                                        label: region.label,
                                        checked: attrs[ attrKey ] !== undefined ? attrs[ attrKey ] : region.default,
                                        onChange: function( v ) {
                                            set( attrKey, v );
                                        }
                                    } );
                                } )
                            )
                        )
                    ),
                    el(
                        PanelBody,
                        { title: 'Text', initialOpen: false },
                        el( TextControl, {
                            label: 'Link label',
                            value: attrs.linkLabel || '',
                            placeholder: 'Default label based on source',
                            onChange: function( v ) { set( 'linkLabel', v ); }
                        } ),
                        el( SelectControl, {
                            label: 'Heading tag',
                            value: attrs.headingTag,
                            options: [
                                { label: 'H1', value: 'h1' },
                                { label: 'H2', value: 'h2' },
                                { label: 'H3', value: 'h3' },
                                { label: 'H4', value: 'h4' }
                            ],
                            onChange: function( v ) { set( 'headingTag', v ); }
                        } )
                    ),
                    el(
                        PanelBody,
                        { title: 'Motion', initialOpen: false },
                        el( SelectControl, {
                            label: 'Entrance animation',
                            value: attrs.animation,
                            options: animOpts,
                            onChange: function( v ) { set( 'animation', v ); }
                        } ),
                        el( RangeControl, {
                            label: 'Animation delay (ms)',
                            value: attrs.animDelay,
                            min: 0,
                            max: 2000,
                            step: 50,
                            onChange: function( v ) { set( 'animDelay', v ); }
                        } )
                    )
                ),
                el(
                    'div',
                    { className: 'pk-dynamic-card-editor-placeholder' },
                    el( 'span', { className: 'pk-dynamic-badge is-dynamic' }, 'Dynamic' ),
                    el( 'div', { className: 'pk-dynamic-card-preview' },
                        el( 'div', { className: 'pk-dynamic-card__image-placeholder' }, '[Image]' ),
                        el( 'div', { className: 'pk-dynamic-card__body' },
                            el( 'span', { className: 'pk-product-category' }, '[Category]' ),
                            el( 'h3', { className: 'pk-dynamic-card__title' }, '[Title]' ),
                            el( 'p', { className: 'pk-dynamic-card__desc' }, '[Description]' )
                        )
                    )
                )
            );
        },
        save: function() { return null; }
    } );

    /* ── Dynamic content state badges ───────────────────────────────────────── */

    if ( addFilter ) {
        var withDynamicBadge = function( OriginalComponent ) {
            var DynamicBadge = function( props ) {
                var InnerBlocks = wp.blockEditor.InnerBlocks;
                var isDynamicBlock = [ 'paksa/dynamic-grid', 'paksa/dynamic-card' ].indexOf( props.name ) !== -1;

                if ( props.name && ! isDynamicBlock ) {
                    var isReusable = props?.attributes?.className &&
                        ( props.attributes.className.indexOf( 'wp-block-template-part' ) !== -1 ||
                          ( window.paksaPhase27 && window.paksaPhase27.copyableAttrs ) );
                    var isSynced = props.attributes?.className &&
                        props.attributes.className.indexOf( 'wp-block-reusable' ) !== -1;

                    if ( ! isReusable && ! isSynced ) {
                        return el( OriginalComponent, props );
                    }
                }

                var enhancedProps = Object.assign( {}, props );

                if ( isDynamicBlock ) {
                    enhancedProps = Object.assign( {}, props, {
                        className: ( props.className || '' ) + ' pk-is-dynamic-block'
                    } );
                }

                return el(
                    Fragment,
                    {},
                    el( OriginalComponent, enhancedProps ),
                    isDynamicBlock ?
                        el( 'div', {
                            className: 'pk-dynamic-content-badge',
                            'aria-label': 'Dynamic content'
                        }, 'Dynamic' ) : null
                );
            };

            return DynamicBadge;
        };

        addFilter( 'editor.BlockEdit', 'paksa/dynamic-content-badge', withDynamicBadge, 10 );
    }

    /* ── Inspector extension for core/query ─────────────────────────────────── */

    if ( addFilter ) {
        var withQueryInspector = function( OriginalComponent ) {
            return function( props ) {
                if ( props.name !== 'core/query' ) {
                    return el( OriginalComponent, props );
                }

                var InnerBlocks = wp.blockEditor.InnerBlocks;
                var InspectorControls = wp.blockEditor.InspectorControls;
                var PanelBody = wp.components.PanelBody;
                var SelectControl = wp.components.SelectControl;
                var ToggleControl = wp.components.ToggleControl;

                var enhancedProps = Object.assign( {}, props );

                var originalEdit = enhancedProps.edit;
                enhancedProps.edit = function( editProps ) {
                    var enhancedEditProps = Object.assign( {}, editProps );
                    var originalInspector = enhancedEditProps.children;

                    enhancedEditProps.children = function( childProps ) {
                        var originalChildren = typeof originalInspector === 'function'
                            ? originalInspector( childProps )
                            : originalInspector;

                        return el(
                            Fragment,
                            {},
                            originalChildren,
                            el(
                                InspectorControls,
                                {},
                                el(
                                    PanelBody,
                                    { title: 'Paksa Dynamic Controls', initialOpen: false },
                                    el( SelectControl, {
                                        label: 'Layout preset',
                                        value: editProps.attributes?.layout || 'grid',
                                        options: layoutOpts,
                                        onChange: function( v ) {
                                            editProps.setAttributes( { layout: v } );
                                        }
                                    } ),
                                    el( ToggleControl, {
                                        label: 'Show category filter',
                                        checked: editProps.attributes?.showFilter || false,
                                        onChange: function( v ) {
                                            editProps.setAttributes( { showFilter: v } );
                                        }
                                    } )
                                )
                            )
                        );
                    };

                    return el( OriginalComponent.prototype.edit, enhancedEditProps );
                };

                return el( OriginalComponent, enhancedProps );
            };
        };

        addFilter( 'editor.BlockEdit', 'paksa/query-inspector', withQueryInspector, 20 );
    }

    /* ── Dynamic content source indicator for inner blocks ──────────────────── */

    if ( addFilter ) {
        var withSourceIndicator = function( OriginalCreate ) {
            return function() {
                var createProps = arguments[ 0 ];
                if ( createProps && createProps.name && createProps.name.indexOf( 'paksa/' ) === 0 ) {
                    return el( OriginalCreate, createProps );
                }
                return el( OriginalCreate, createProps );
            };
        };
    }

    /* ── Expose Phase 35 API on window.paksaVisual ──────────────────────────── */

    if ( window.paksaVisual ) {
        window.paksaVisual.DYNAMIC = {
            getSourceLabel: function( source ) {
                var map = {
                    'post': 'Posts',
                    'paksa_product': 'Products',
                    'paksa_service': 'Services',
                    'page': 'Pages'
                };
                return map[ source ] || 'Content';
            },
            isDynamicBlock: function( blockName ) {
                return [ 'paksa/dynamic-grid', 'paksa/dynamic-card' ].indexOf( blockName ) !== -1;
            },
            getDynamicBlocks: function() {
                return [ 'paksa/dynamic-grid', 'paksa/dynamic-card' ];
            }
        };
    }

}( window.wp ) );
