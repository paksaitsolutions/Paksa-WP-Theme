( function( wp ) {
    'use strict';

    if ( ! wp || ! wp.blocks || ! wp.element || ! wp.blockEditor || ! wp.components ) {
        return;
    }

    var el              = wp.element.createElement;
    var Fragment        = wp.element.Fragment;
    var registerBlockType = wp.blocks.registerBlockType;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody         = wp.components.PanelBody;
    var SelectControl     = wp.components.SelectControl;
    var RangeControl      = wp.components.RangeControl;
    var TextControl       = wp.components.TextControl;
    var ToggleControl     = wp.components.ToggleControl;
    var BaseControl       = wp.components.BaseControl;

    var phase34 = window.paksaPhase34 || {
        testimonialVariants: [],
        timelineOrientations: [],
        timelineMarkers: [],
        logoLinkOptions: [],
        animationOptions: [],
        version: ''
    };

    var animOpts = phase34.animationOptions || [
        { label: 'None', value: 'none' },
        { label: 'Fade', value: 'fade' },
        { label: 'Fade Up', value: 'fade-up' },
        { label: 'Fade Down', value: 'fade-down' },
        { label: 'Fade Left', value: 'fade-left' },
        { label: 'Fade Right', value: 'fade-right' },
        { label: 'Scale', value: 'scale' },
        { label: 'Reveal', value: 'reveal' },
        { label: 'Stagger Children', value: 'stagger' }
    ];

    /* ── paksa/testimonial-rail ──────────────────────────────────────────────── */
    registerBlockType( 'paksa/testimonial-rail', {
        apiVersion: 3,
        title: 'Paksa Testimonial Rail',
        description: 'A horizontal carousel rail for testimonials with navigation and autoplay.',
        category: 'paksa-components',
        icon: 'testimonial',
        attributes: {
            variant:         { type: 'string',  default: 'standard' },
            autoplay:        { type: 'boolean', default: false },
            showNavigation:  { type: 'boolean', default: true },
            showDots:        { type: 'boolean', default: true },
            itemsToShow:     { type: 'number',  default: 1 },
            animation:       { type: 'string',  default: 'none' },
            animDelay:       { type: 'number',  default: 0 },
            animDuration:    { type: 'number',  default: 600 },
            containerWidth:  { type: 'string',  default: 'default' },
            layout:          { type: 'string',  default: 'grid' },
            hoverEffect:     { type: 'string',  default: 'none' },
            hoverShadow:     { type: 'boolean', default: false },
            hoverLift:       { type: 'boolean', default: false },
            hoverBgColor:    { type: 'string',  default: '' },
            transition:      { type: 'string',  default: 'base' },
            borderWidth:     { type: 'string',  default: '' },
            borderStyle:     { type: 'string',  default: 'solid' },
            borderColor:     { type: 'string',  default: '' },
            borderRadius:    { type: 'string',  default: '' },
            shadowPreset:    { type: 'string',  default: 'none' },
            colsMobile:      { type: 'number', default: 1 },
            colsTablet:      { type: 'number', default: 2 },
            colsDesktop:     { type: 'number', default: 3 },
            stackMobile:     { type: 'boolean', default: true },
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
            var setAttrs = props.setAttrs;
            var InnerBlocks = wp.blockEditor.InnerBlocks;

            var testimonialVariants = phase34.testimonialVariants || [];
            var variantOptions = testimonialVariants.map( function( v ) {
                return { label: v.label, value: v.value };
            } );

            var template = [
                [ 'paksa/testimonial', {
                    quote: 'A genuine testimonial quote.',
                    author: 'Name',
                    role: 'Role',
                    company: 'Company'
                } ],
            ];

            function setAttr( key, val ) {
                var update = {};
                update[ key ] = val;
                setAttrs( update );
            }

            return el(
                Fragment,
                {},
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        { title: 'Testimonial Rail', initialOpen: true },
                        el( SelectControl, {
                            label: 'Variant',
                            value: attrs.variant,
                            options: variantOptions,
                            onChange: function( v ) { setAttr( 'variant', v ); }
                        } ),
                        el( ToggleControl, {
                            label: 'Autoplay',
                            checked: attrs.autoplay,
                            onChange: function( v ) { setAttr( 'autoplay', v ); }
                        } ),
                        el( ToggleControl, {
                            label: 'Show navigation',
                            checked: attrs.showNavigation,
                            onChange: function( v ) { setAttr( 'showNavigation', v ); }
                        } ),
                        el( ToggleControl, {
                            label: 'Show pagination dots',
                            checked: attrs.showDots,
                            onChange: function( v ) { setAttr( 'showDots', v ); }
                        } ),
                        el( RangeControl, {
                            label: 'Items to show',
                            value: attrs.itemsToShow,
                            min: 1,
                            max: 5,
                            step: 1,
                            onChange: function( v ) { setAttr( 'itemsToShow', v ); }
                        } )
                    ),
                    el(
                        PanelBody,
                        { title: 'Motion', initialOpen: false },
                        el( SelectControl, {
                            label: 'Entrance animation',
                            value: attrs.animation,
                            options: animOpts,
                            onChange: function( v ) { setAttr( 'animation', v ); }
                        } ),
                        el( RangeControl, {
                            label: 'Animation delay (ms)',
                            value: attrs.animDelay,
                            min: 0,
                            max: 2000,
                            step: 50,
                            onChange: function( v ) { setAttr( 'animDelay', v ); }
                        } ),
                        el( RangeControl, {
                            label: 'Animation duration (ms)',
                            value: attrs.animDuration,
                            min: 100,
                            max: 2000,
                            step: 50,
                            onChange: function( v ) { setAttr( 'animDuration', v ); }
                        } )
                    ),
                    el(
                        PanelBody,
                        { title: 'Responsive', initialOpen: false },
                        el( RangeControl, {
                            label: 'Desktop items',
                            value: attrs.colsDesktop,
                            min: 1,
                            max: 5,
                            onChange: function( v ) { setAttr( 'colsDesktop', v ); }
                        } ),
                        el( RangeControl, {
                            label: 'Tablet items',
                            value: attrs.colsTablet,
                            min: 1,
                            max: 4,
                            onChange: function( v ) { setAttr( 'colsTablet', v ); }
                        } ),
                        el( RangeControl, {
                            label: 'Mobile items',
                            value: attrs.colsMobile,
                            min: 1,
                            max: 3,
                            onChange: function( v ) { setAttr( 'colsMobile', v ); }
                        } ),
                        el( ToggleControl, {
                            label: 'Stack on mobile',
                            checked: attrs.stackMobile,
                            onChange: function( v ) { setAttr( 'stackMobile', v ); }
                        } )
                    )
                ),
                el(
                    'div',
                    {
                        className: 'wp-block-paksa-testimonial-rail pk-editor-rail-preview is-style-paksa-card-testimonial',
                        style: { '--pk-rail-items': attrs.itemsToShow }
                    },
                    el( InnerBlocks, {
                        template: template,
                        templateLock: 'horizontal'
                    } )
                )
            );
        },
        save: function() { return null; }
    } );

    /* ── paksa/logo-strip ────────────────────────────────────────────────────── */
    registerBlockType( 'paksa/logo-strip', {
        apiVersion: 3,
        title: 'Paksa Logo Strip',
        description: 'A responsive grid of logos with optional grayscale and hover behavior.',
        category: 'paksa-components',
        icon: 'images-alt2',
        attributes: {
            logoSize:     { type: 'number',  default: 120 },
            gap:          { type: 'string',  default: 'var(--wp--preset--spacing--50)' },
            grayscale:    { type: 'boolean', default: false },
            linkBehavior: { type: 'string',  default: 'none' },
            alignment:    { type: 'string',  default: 'center' },
            columns:      { type: 'number',  default: 5 },
            layout:       { type: 'string',  default: 'grid' },
            hoverEffect:  { type: 'string',  default: 'none' },
            hoverShadow:  { type: 'boolean', default: false },
            hoverLift:    { type: 'boolean', default: false },
            hoverBgColor: { type: 'string',  default: '' },
            transition:   { type: 'string',  default: 'base' },
            borderWidth:  { type: 'string',  default: '' },
            borderStyle:  { type: 'string',  default: 'solid' },
            borderColor:  { type: 'string',  default: '' },
            borderRadius: { type: 'string',  default: '' },
            shadowPreset: { type: 'string',  default: 'none' },
            colsMobile:   { type: 'number', default: 2 },
            colsTablet:   { type: 'number', default: 3 },
            colsDesktop:  { type: 'number', default: 5 },
            stackMobile:  { type: 'boolean', default: true },
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
            var InnerBlocks = wp.blockEditor.InnerBlocks;

            var template = [
                [ 'core/image', { url: '', alt: 'Partner logo' } ],
                [ 'core/image', { url: '', alt: 'Partner logo' } ],
                [ 'core/image', { url: '', alt: 'Partner logo' } ],
            ];

            var logoVariants = [
                { label: 'Grid', value: 'grid' },
                { label: 'Marquee', value: 'marquee' },
                { label: 'Inline', value: 'inline' },
            ];
            var alignmentOptions = [
                { label: 'Left',   value: 'left' },
                { label: 'Center', value: 'center' },
                { label: 'Right',  value: 'right' },
            ];

            return el(
                Fragment,
                {},
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        { title: 'Logo Strip Settings', initialOpen: true },
                        el( RangeControl, {
                            label: 'Logo width (px)',
                            value: attrs.logoSize,
                            min: 40,
                            max: 320,
                            step: 4,
                            onChange: function( v ) { props.setAttributes( { logoSize: v } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Gap',
                            value: attrs.gap,
                            options: [
                                { label: '2XS', value: 'var(--wp--preset--spacing--20)' },
                                { label: 'XS',  value: 'var(--wp--preset--spacing--30)' },
                                { label: 'S',   value: 'var(--wp--preset--spacing--40)' },
                                { label: 'M',   value: 'var(--wp--preset--spacing--50)' },
                                { label: 'L',   value: 'var(--wp--preset--spacing--60)' },
                                { label: 'XL',  value: 'var(--wp--preset--spacing--70)' },
                            ],
                            onChange: function( v ) { props.setAttributes( { gap: v } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Alignment',
                            value: attrs.alignment,
                            options: alignmentOptions,
                            onChange: function( v ) { props.setAttributes( { alignment: v } ); }
                        } ),
                        el( RangeControl, {
                            label: 'Columns',
                            value: attrs.columns,
                            min: 2,
                            max: 8,
                            onChange: function( v ) { props.setAttributes( { columns: v } ); }
                        } ),
                        el( ToggleControl, {
                            label: 'Grayscale',
                            help: 'Desaturate logos until hover (when link is set).',
                            checked: attrs.grayscale,
                            onChange: function( v ) { props.setAttributes( { grayscale: v } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Link behavior',
                            value: attrs.linkBehavior,
                            options: phase34.logoLinkOptions || [
                                { label: 'None', value: 'none' },
                                { label: 'Lightbox', value: 'lightbox' },
                                { label: 'New tab', value: 'newtab' }
                            ],
                            onChange: function( v ) { props.setAttributes( { linkBehavior: v } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Layout',
                            value: attrs.layout,
                            options: logoVariants,
                            onChange: function( v ) { props.setAttributes( { layout: v } ); }
                        } )
                    ),
                    el(
                        PanelBody,
                        { title: 'Responsive', initialOpen: false },
                        el( RangeControl, {
                            label: 'Desktop columns',
                            value: attrs.colsDesktop,
                            min: 2,
                            max: 8,
                            onChange: function( v ) { props.setAttributes( { colsDesktop: v } ); }
                        } ),
                        el( RangeControl, {
                            label: 'Tablet columns',
                            value: attrs.colsTablet,
                            min: 2,
                            max: 6,
                            onChange: function( v ) { props.setAttributes( { colsTablet: v } ); }
                        } ),
                        el( RangeControl, {
                            label: 'Mobile columns',
                            value: attrs.colsMobile,
                            min: 1,
                            max: 4,
                            onChange: function( v ) { props.setAttributes( { colsMobile: v } ); }
                        } ),
                        el( ToggleControl, {
                            label: 'Stack on mobile',
                            checked: attrs.stackMobile,
                            onChange: function( v ) { props.setAttributes( { stackMobile: v } ); }
                        } )
                    )
                ),
                el(
                    'div',
                    {
                        className: 'wp-block-paksa-logo-strip pk-editor-logo-strip',
                        style: {
                            '--pk-logo-size': attrs.logoSize + 'px',
                            '--pk-logo-gap': attrs.gap,
                            '--pk-logo-cols': attrs.columns
                        }
                    },
                    el( InnerBlocks, {
                        template: template,
                        templateLock: 'horizontal',
                        className: 'pk-logo-strip__inner'
                    } )
                )
            );
        },
        save: function() { return null; }
    } );

    /* ── paksa/timeline ───────────────────────────────────────────────────────── */
    registerBlockType( 'paksa/timeline', {
        apiVersion: 3,
        title: 'Paksa Timeline',
        description: 'A vertical or horizontal timeline built with composable InnerBlocks items.',
        category: 'paksa-components',
        icon: 'marker',
        attributes: {
            orientation:    { type: 'string',  default: 'vertical' },
            alignment:      { type: 'string',  default: 'left' },
            markerType:     { type: 'string',  default: 'dot' },
            connectorStyle: { type: 'string',  default: 'solid' },
            contentSpacing: { type: 'string',  default: 'var(--wp--preset--spacing--50)' },
            layout:         { type: 'string',  default: 'grid' },
            animation:      { type: 'string',  default: 'none' },
            animDelay:      { type: 'number',  default: 0 },
            borderWidth:    { type: 'string',  default: '' },
            borderStyle:    { type: 'string',  default: 'solid' },
            borderColor:    { type: 'string',  default: '' },
            borderRadius:   { type: 'string',  default: '' },
            shadowPreset:   { type: 'string',  default: 'none' },
            textTransform:  { type: 'string',  default: '' },
            letterSpacing:  { type: 'string',  default: '' },
            fontWeight:     { type: 'string',  default: '' },
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
            var InnerBlocks = wp.blockEditor.InnerBlocks;

            var orientationOpts = phase34.timelineOrientations || [
                { label: 'Vertical', value: 'vertical' },
                { label: 'Horizontal', value: 'horizontal' }
            ];
            var markerOpts = phase34.timelineMarkers || [
                { label: 'Dot', value: 'dot' },
                { label: 'Number', value: 'number' },
                { label: 'Icon', value: 'icon' },
                { label: 'Check', value: 'check' }
            ];
            var alignmentOpts = [
                { label: 'Left', value: 'left' },
                { label: 'Center', value: 'center' },
                { label: 'Right', value: 'right' },
            ];
            var connectorOpts = [
                { label: 'Solid', value: 'solid' },
                { label: 'Dashed', value: 'dashed' },
                { label: 'Dotted', value: 'dotted' },
                { label: 'Double', value: 'double' },
            ];

            var template = [
                [ 'core/group', { className: 'pk-timeline__item' }, [
                    [ 'core/heading', { level: 3, content: 'Timeline item' } ],
                    [ 'core/paragraph', { content: 'Describe this timeline step.' } ]
                ] ]
            ];

            return el(
                Fragment,
                {},
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        { title: 'Timeline Settings', initialOpen: true },
                        el( SelectControl, {
                            label: 'Orientation',
                            value: attrs.orientation,
                            options: orientationOpts,
                            onChange: function( v ) { props.setAttributes( { orientation: v } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Alignment',
                            value: attrs.alignment,
                            options: alignmentOpts,
                            onChange: function( v ) { props.setAttributes( { alignment: v } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Marker type',
                            value: attrs.markerType,
                            options: markerOpts,
                            onChange: function( v ) { props.setAttributes( { markerType: v } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Connector style',
                            value: attrs.connectorStyle,
                            options: connectorOpts,
                            onChange: function( v ) { props.setAttributes( { connectorStyle: v } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Content spacing',
                            value: attrs.contentSpacing,
                            options: [
                                { label: '2XS (0.5rem)', value: 'var(--wp--preset--spacing--20)' },
                                { label: 'XS (0.75rem)', value: 'var(--wp--preset--spacing--30)' },
                                { label: 'S (1rem)',      value: 'var(--wp--preset--spacing--40)' },
                                { label: 'M (1.5rem)',    value: 'var(--wp--preset--spacing--50)' },
                                { label: 'L (2rem)',      value: 'var(--wp--preset--spacing--60)' },
                                { label: 'XL (3rem)',     value: 'var(--wp--preset--spacing--70)' },
                            ],
                            onChange: function( v ) { props.setAttributes( { contentSpacing: v } ); }
                        } )
                    ),
                    el(
                        PanelBody,
                        { title: 'Motion', initialOpen: false },
                        el( SelectControl, {
                            label: 'Entrance animation',
                            value: attrs.animation,
                            options: animOpts,
                            onChange: function( v ) { props.setAttributes( { animation: v } ); }
                        } ),
                        el( RangeControl, {
                            label: 'Animation delay (ms)',
                            value: attrs.animDelay,
                            min: 0,
                            max: 2000,
                            step: 50,
                            onChange: function( v ) { props.setAttributes( { animDelay: v } ); }
                        } )
                    )
                ),
                el(
                    'div',
                    {
                        className: 'wp-block-paksa-timeline pk-editor-timeline',
                        style: { '--pk-timeline-spacing': attrs.contentSpacing }
                    },
                    el( InnerBlocks, {
                        template: template,
                        templateLock: 'horizontal'
                    } )
                )
            );
        },
        save: function() { return null; }
    } );

}( window.wp ) );
