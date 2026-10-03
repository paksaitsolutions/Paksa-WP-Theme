/* ============================================================
   Phase 25 — Elementor-class Visual Builder Experience
   Upgrades:
   - paksa/section: ColorPalette for bg/overlay, GradientPicker,
     UnitControl for padding, BlockControls toolbar for layout
   - paksa/testimonial: ColorPalette for accent
   - paksa/cta: ColorPalette for overlay
   - BlockEdit filter: ToolsPanel spacing UI on core/group + core/columns
   - BlockEdit filter: image hover/overlay styles on core/image
   - BlockEdit filter: button size/style quick controls on core/button
   - Responsive class application on save (core/columns)
   ============================================================ */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.blocks || ! wp.element || ! wp.blockEditor || ! wp.components ) return;

    var el               = wp.element.createElement;
    var Fragment         = wp.element.Fragment;
    var useState         = wp.element.useState;
    var useCallback      = wp.element.useCallback;
    var registerBlockType = wp.blocks.registerBlockType;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var BlockControls    = wp.blockEditor.BlockControls;
    var InnerBlocks      = wp.blockEditor.InnerBlocks;
    var useBlockProps    = wp.blockEditor.useBlockProps;
    var MediaUpload      = wp.blockEditor.MediaUpload;
    var MediaUploadCheck = wp.blockEditor.MediaUploadCheck;

    var PanelBody        = wp.components.PanelBody;
    var PanelRow         = wp.components.PanelRow;
    var SelectControl    = wp.components.SelectControl;
    var RangeControl     = wp.components.RangeControl;
    var TextControl      = wp.components.TextControl;
    var ToggleControl    = wp.components.ToggleControl;
    var Button           = wp.components.Button;
    var ButtonGroup      = wp.components.ButtonGroup;
    var ColorPalette     = wp.components.ColorPalette;
    var GradientPicker   = wp.components.GradientPicker;
    var ToolbarGroup     = wp.components.ToolbarGroup;
    var ToolbarButton    = wp.components.ToolbarButton;
    var Tooltip          = wp.components.Tooltip;
    var Notice           = wp.components.Notice;

    // UnitControl may not exist in older WP — graceful fallback
    var UnitControl = wp.components.__experimentalUnitControl || wp.components.UnitControl || null;

    var ctrlData  = window.paksaEditorControls || {};
    var p25Data   = window.paksaPhase25 || {};
    var iconData  = window.paksaIconBlock || { icons: [] };

    var palette   = p25Data.palette   || [];
    var gradients = p25Data.gradients  || [];
    var units     = p25Data.units      || [ 'px', 'rem', '%' ];

    var animOptions = ctrlData.animationOptions || [
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

    var shadowTokens = ctrlData.shadowTokens || [
        { label: 'None', value: 'none' },
        { label: 'Small', value: 'sm' },
        { label: 'Medium', value: 'md' },
        { label: 'Large', value: 'lg' },
        { label: 'Extra Large', value: 'xl' },
        { label: 'Blue Glow', value: 'blue' }
    ];

    var radiusTokens = ctrlData.radiusTokens || [
        { label: 'None', value: '0' },
        { label: 'Small', value: 'var(--pk-radius-sm)' },
        { label: 'Medium', value: 'var(--pk-radius-md)' },
        { label: 'Large', value: 'var(--pk-radius-lg)' },
        { label: 'XL', value: 'var(--pk-radius-xl)' },
        { label: 'Full', value: 'var(--pk-radius-full)' }
    ];

    var bgPositions = ctrlData.bgPositions || [
        { label: 'Center', value: 'center center' },
        { label: 'Top', value: 'center top' },
        { label: 'Bottom', value: 'center bottom' },
        { label: 'Left', value: 'left center' },
        { label: 'Right', value: 'right center' },
        { label: 'Top Left', value: 'left top' },
        { label: 'Top Right', value: 'right top' }
    ];

    /* ── Shared: ColorPalette with theme palette ─────────────────────────── */
    function PaletteControl( props ) {
        return el( 'div', { className: 'pk-palette-control' },
            props.label ? el( 'p', { className: 'pk-palette-control__label components-base-control__label' }, props.label ) : null,
            el( ColorPalette, {
                colors: palette,
                value: props.value || '',
                onChange: props.onChange,
                clearable: props.clearable !== false,
                disableCustomColors: false
            } )
        );
    }

    /* ── Shared: UnitControl with fallback ───────────────────────────────── */
    function SpacingControl( props ) {
        if ( UnitControl ) {
            return el( UnitControl, {
                label: props.label,
                value: props.value || '',
                units: units.map( function( u ) { return { value: u, label: u }; } ),
                onChange: props.onChange,
                min: 0
            } );
        }
        return el( TextControl, {
            label: props.label,
            help: props.help || 'e.g. 4rem or 64px',
            value: props.value || '',
            onChange: props.onChange
        } );
    }

    /* ── Shared: BgImagePanel (reuses Phase 18 UI, adds color picker) ────── */
    function BgImagePanelV2( props ) {
        var a = props.attributes;
        var set = props.setAttributes;
        return el( PanelBody, { title: 'Background Image', initialOpen: false },
            el( MediaUploadCheck, {},
                el( MediaUpload, {
                    onSelect: function( media ) { set( { bgImageUrl: media.url, bgImageAlt: media.alt || '' } ); },
                    allowedTypes: [ 'image' ],
                    value: a.bgImageUrl,
                    render: function( ref ) {
                        return el( Fragment, {},
                            a.bgImageUrl
                                ? el( 'div', { style: { marginBottom: '8px' } },
                                    el( 'img', { src: a.bgImageUrl, style: { width: '100%', height: '80px', objectFit: 'cover', borderRadius: '4px' } } ),
                                    el( Button, { isDestructive: true, isSmall: true, onClick: function() { set( { bgImageUrl: '', bgImageAlt: '' } ); } }, 'Remove image' )
                                  )
                                : null,
                            el( Button, { onClick: ref.open, variant: 'secondary', isSmall: true },
                                a.bgImageUrl ? 'Replace image' : 'Select background image'
                            )
                        );
                    }
                } )
            ),
            a.bgImageUrl ? el( Fragment, {},
                el( SelectControl, {
                    label: 'Image position',
                    value: a.bgImagePosition || 'center center',
                    options: bgPositions,
                    onChange: function( v ) { set( { bgImagePosition: v } ); }
                } ),
                el( SelectControl, {
                    label: 'Image size',
                    value: a.bgImageSize || 'cover',
                    options: [
                        { label: 'Cover', value: 'cover' },
                        { label: 'Contain', value: 'contain' },
                        { label: 'Auto', value: 'auto' }
                    ],
                    onChange: function( v ) { set( { bgImageSize: v } ); }
                } ),
                el( PaletteControl, {
                    label: 'Overlay color',
                    value: a.bgOverlayColor || '',
                    onChange: function( v ) { set( { bgOverlayColor: v || '' } ); }
                } ),
                el( RangeControl, {
                    label: 'Overlay opacity (%)',
                    value: a.bgOverlayOpacity !== undefined ? a.bgOverlayOpacity : 50,
                    min: 0, max: 100, step: 5,
                    onChange: function( v ) { set( { bgOverlayOpacity: v } ); }
                } )
            ) : null
        );
    }

    /* ── Shared: AnimationPanel ──────────────────────────────────────────── */
    function AnimationPanelV2( props ) {
        var a = props.attributes;
        var set = props.setAttributes;
        return el( PanelBody, { title: 'Animation', initialOpen: false },
            el( SelectControl, {
                label: 'Entrance animation',
                value: a.animation || 'none',
                options: animOptions,
                onChange: function( v ) { set( { animation: v } ); }
            } ),
            ( a.animation && a.animation !== 'none' ) ? el( Fragment, {},
                el( RangeControl, {
                    label: 'Delay (ms)',
                    value: a.animDelay || 0,
                    min: 0, max: 800, step: 100,
                    onChange: function( v ) { set( { animDelay: v } ); }
                } ),
                a.animDuration !== undefined ? el( RangeControl, {
                    label: 'Duration (ms)',
                    value: a.animDuration || 600,
                    min: 200, max: 1200, step: 100,
                    onChange: function( v ) { set( { animDuration: v } ); }
                } ) : null
            ) : null
        );
    }

    /* ── Shared: HoverPanel ──────────────────────────────────────────────── */
    function HoverPanelV2( props ) {
        var a = props.attributes;
        var set = props.setAttributes;
        var hoverEffects = ctrlData.hoverEffects || [
            { label: 'None', value: 'none' },
            { label: 'Lift', value: 'lift' },
            { label: 'Glow', value: 'glow' },
            { label: 'Scale', value: 'scale' },
            { label: 'Brighten', value: 'brighten' },
            { label: 'Dim', value: 'dim' }
        ];
        return el( PanelBody, { title: 'Hover & Interaction', initialOpen: false },
            el( SelectControl, {
                label: 'Hover effect',
                value: a.hoverEffect || 'none',
                options: hoverEffects,
                onChange: function( v ) { set( { hoverEffect: v } ); }
            } ),
            el( ToggleControl, {
                label: 'Lift on hover',
                checked: !! a.hoverLift,
                onChange: function( v ) { set( { hoverLift: v } ); }
            } ),
            el( ToggleControl, {
                label: 'Deepen shadow on hover',
                checked: !! a.hoverShadow,
                onChange: function( v ) { set( { hoverShadow: v } ); }
            } ),
            el( SelectControl, {
                label: 'Transition speed',
                value: a.transition || 'base',
                options: [
                    { label: 'Fast (150ms)', value: 'fast' },
                    { label: 'Base (250ms)', value: 'base' },
                    { label: 'Slow (400ms)', value: 'slow' }
                ],
                onChange: function( v ) { set( { transition: v } ); }
            } )
        );
    }

    /* ── Shared: BorderShadowPanel with ColorPalette ─────────────────────── */
    function BorderShadowPanelV2( props ) {
        var a = props.attributes;
        var set = props.setAttributes;
        return el( PanelBody, { title: 'Border & Shadow', initialOpen: false },
            el( SpacingControl, {
                label: 'Border width',
                help: 'e.g. 1px or 2px',
                value: a.borderWidth || '',
                onChange: function( v ) { set( { borderWidth: v } ); }
            } ),
            el( SelectControl, {
                label: 'Border style',
                value: a.borderStyle || 'solid',
                options: [
                    { label: 'Solid', value: 'solid' },
                    { label: 'Dashed', value: 'dashed' },
                    { label: 'Dotted', value: 'dotted' },
                    { label: 'None', value: 'none' }
                ],
                onChange: function( v ) { set( { borderStyle: v } ); }
            } ),
            el( PaletteControl, {
                label: 'Border color',
                value: a.borderColor || '',
                onChange: function( v ) { set( { borderColor: v || '' } ); }
            } ),
            el( SelectControl, {
                label: 'Border radius',
                value: a.borderRadius || '',
                options: [ { label: 'Theme default', value: '' } ].concat( radiusTokens ),
                onChange: function( v ) { set( { borderRadius: v } ); }
            } ),
            el( SelectControl, {
                label: 'Shadow',
                value: a.shadowPreset || 'none',
                options: shadowTokens,
                onChange: function( v ) { set( { shadowPreset: v } ); }
            } )
        );
    }

    /* ══════════════════════════════════════════════════════════════════════
       paksa/section — Phase 25 upgraded editor
       Adds: ColorPalette for bgColor, GradientPicker for bgGradient,
             SpacingControl for paddingTop/paddingBot,
             BlockControls toolbar for layout quick-switch,
             live inline style preview in canvas
    ══════════════════════════════════════════════════════════════════════ */
    wp.domReady && wp.domReady( function() {
        try { wp.blocks.unregisterBlockType( 'paksa/section' ); } catch(e) {}

        registerBlockType( 'paksa/section', {
            apiVersion: 3,
            title: 'Paksa Section',
            description: 'Full-width section container with visual background, spacing, animation, hover, and responsive controls.',
            category: 'paksa-components',
            icon: 'layout',
            supports: {
                html: false,
                align: [ 'wide', 'full' ],
                anchor: true,
                color: { text: true, background: true, gradients: true },
                spacing: { padding: true, margin: true, blockGap: true },
                dimensions: { minHeight: true },
                typography: { fontSize: true, lineHeight: true }
            },
            attributes: {
                variant:          { type: 'string',  default: 'default' },
                minHeight:        { type: 'string',  default: '' },
                paddingTop:       { type: 'string',  default: '' },
                paddingBot:       { type: 'string',  default: '' },
                bgColor:          { type: 'string',  default: '' },
                bgGradient:       { type: 'string',  default: '' },
                overlayOpacity:   { type: 'number',  default: 0 },
                animation:        { type: 'string',  default: 'none' },
                animDelay:        { type: 'number',  default: 0 },
                animDuration:     { type: 'number',  default: 600 },
                containerWidth:   { type: 'string',  default: 'default' },
                textAlign:        { type: 'string',  default: 'left' },
                verticalAlign:    { type: 'string',  default: 'top' },
                customId:         { type: 'string',  default: '' },
                bgImageUrl:       { type: 'string',  default: '' },
                bgImageAlt:       { type: 'string',  default: '' },
                bgImagePosition:  { type: 'string',  default: 'center center' },
                bgImageSize:      { type: 'string',  default: 'cover' },
                bgOverlayColor:   { type: 'string',  default: '' },
                bgOverlayOpacity: { type: 'number',  default: 50 },
                hoverEffect:      { type: 'string',  default: 'none' },
                hoverShadow:      { type: 'boolean', default: false },
                hoverLift:        { type: 'boolean', default: false },
                hoverBgColor:     { type: 'string',  default: '' },
                transition:       { type: 'string',  default: 'base' },
                borderWidth:      { type: 'string',  default: '' },
                borderStyle:      { type: 'string',  default: 'solid' },
                borderColor:      { type: 'string',  default: '' },
                borderRadius:     { type: 'string',  default: '' },
                shadowPreset:     { type: 'string',  default: 'none' }
            },
            edit: function( props ) {
                var a   = props.attributes;
                var set = props.setAttributes;

                // Build live inline style for canvas preview
                var canvasStyle = {};
                if ( a.bgColor && ! a.bgGradient && ! a.bgImageUrl ) {
                    canvasStyle.background = a.bgColor;
                }
                if ( a.bgGradient && ! a.bgImageUrl ) {
                    canvasStyle.background = a.bgGradient;
                }
                if ( a.bgImageUrl ) {
                    canvasStyle.backgroundImage = 'url(' + a.bgImageUrl + ')';
                    canvasStyle.backgroundSize = a.bgImageSize || 'cover';
                    canvasStyle.backgroundPosition = a.bgImagePosition || 'center center';
                    canvasStyle.backgroundRepeat = 'no-repeat';
                }
                if ( a.paddingTop ) { canvasStyle.paddingTop = a.paddingTop; }
                if ( a.paddingBot ) { canvasStyle.paddingBottom = a.paddingBot; }
                if ( a.borderRadius ) { canvasStyle.borderRadius = a.borderRadius; }

                var cls = 'pk-section pk-section--' + a.variant;
                if ( a.textAlign !== 'left' ) cls += ' has-text-align-' + a.textAlign;
                if ( a.containerWidth !== 'default' ) cls += ' pk-section--container-' + a.containerWidth;

                var blockProps = useBlockProps
                    ? useBlockProps( { className: cls, style: canvasStyle } )
                    : { className: 'wp-block-paksa-section ' + cls, style: canvasStyle };

                // Toolbar layout quick-switch buttons
                var layoutButtons = el( BlockControls, { group: 'block' },
                    el( ToolbarGroup, {},
                        el( ToolbarButton, {
                            icon: 'align-center',
                            label: 'Default width',
                            isActive: a.containerWidth === 'default',
                            onClick: function() { set( { containerWidth: 'default' } ); }
                        } ),
                        el( ToolbarButton, {
                            icon: 'align-wide',
                            label: 'Wide (1440px)',
                            isActive: a.containerWidth === 'wide',
                            onClick: function() { set( { containerWidth: 'wide' } ); }
                        } ),
                        el( ToolbarButton, {
                            icon: 'align-full-width',
                            label: 'Full bleed',
                            isActive: a.containerWidth === 'full',
                            onClick: function() { set( { containerWidth: 'full' } ); }
                        } ),
                        el( ToolbarButton, {
                            icon: 'editor-contract',
                            label: 'Narrow (720px)',
                            isActive: a.containerWidth === 'narrow',
                            onClick: function() { set( { containerWidth: 'narrow' } ); }
                        } )
                    )
                );

                return el( Fragment, {},
                    layoutButtons,
                    el( InspectorControls, {},

                        /* ── Layout ── */
                        el( PanelBody, { title: 'Layout', initialOpen: true },
                            el( SelectControl, {
                                label: 'Background variant',
                                value: a.variant,
                                options: [
                                    { label: 'Default (white)', value: 'default' },
                                    { label: 'Alt (light gray)', value: 'alt' },
                                    { label: 'Dark', value: 'dark' },
                                    { label: 'Gradient', value: 'gradient' },
                                    { label: 'Transparent', value: 'transparent' }
                                ],
                                onChange: function( v ) { set( { variant: v } ); }
                            } ),
                            el( SelectControl, {
                                label: 'Container width',
                                value: a.containerWidth,
                                options: [
                                    { label: 'Default (1200px)', value: 'default' },
                                    { label: 'Narrow (720px)', value: 'narrow' },
                                    { label: 'Wide (1440px)', value: 'wide' },
                                    { label: 'Full bleed', value: 'full' }
                                ],
                                onChange: function( v ) { set( { containerWidth: v } ); }
                            } ),
                            el( SelectControl, {
                                label: 'Text alignment',
                                value: a.textAlign,
                                options: [
                                    { label: 'Left', value: 'left' },
                                    { label: 'Center', value: 'center' },
                                    { label: 'Right', value: 'right' }
                                ],
                                onChange: function( v ) { set( { textAlign: v } ); }
                            } ),
                            el( SelectControl, {
                                label: 'Vertical alignment',
                                value: a.verticalAlign || 'top',
                                options: [
                                    { label: 'Top', value: 'top' },
                                    { label: 'Center', value: 'center' },
                                    { label: 'Bottom', value: 'bottom' }
                                ],
                                onChange: function( v ) { set( { verticalAlign: v } ); }
                            } )
                        ),

                        /* ── Spacing ── */
                        el( PanelBody, { title: 'Spacing', initialOpen: false },
                            el( SpacingControl, {
                                label: 'Padding top',
                                value: a.paddingTop || '',
                                onChange: function( v ) { set( { paddingTop: v || '' } ); }
                            } ),
                            el( SpacingControl, {
                                label: 'Padding bottom',
                                value: a.paddingBot || '',
                                onChange: function( v ) { set( { paddingBot: v || '' } ); }
                            } )
                        ),

                        /* ── Background ── */
                        el( PanelBody, { title: 'Background', initialOpen: false },
                            el( 'p', { className: 'components-base-control__help', style: { marginTop: 0 } },
                                'Solid color, gradient, or image. Image takes priority.'
                            ),
                            el( PaletteControl, {
                                label: 'Solid background color',
                                value: a.bgColor || '',
                                onChange: function( v ) { set( { bgColor: v || '', bgGradient: '' } ); }
                            } ),
                            el( 'div', { style: { marginTop: '12px' } },
                                el( 'p', { className: 'components-base-control__label' }, 'Gradient background' ),
                                el( GradientPicker, {
                                    value: a.bgGradient || '',
                                    gradients: gradients,
                                    onChange: function( v ) { set( { bgGradient: v || '', bgColor: '' } ); },
                                    clearable: true,
                                    disableCustomGradients: false
                                } )
                            )
                        ),

                        /* ── Background Image ── */
                        el( BgImagePanelV2, { attributes: a, setAttributes: set } ),

                        /* ── Animation ── */
                        el( AnimationPanelV2, { attributes: a, setAttributes: set } ),

                        /* ── Hover ── */
                        el( HoverPanelV2, { attributes: a, setAttributes: set } ),

                        /* ── Border & Shadow ── */
                        el( BorderShadowPanelV2, { attributes: a, setAttributes: set } ),

                        /* ── Advanced ── */
                        el( PanelBody, { title: 'Advanced', initialOpen: false },
                            el( TextControl, {
                                label: 'Custom CSS class',
                                help: 'Added to the section element.',
                                value: a.customId || '',
                                onChange: function( v ) { set( { customId: v } ); }
                            } )
                        )
                    ),
                    el( 'section', blockProps,
                        el( InnerBlocks, { renderAppender: InnerBlocks.ButtonBlockAppender } )
                    )
                );
            },
            deprecated: [
                { save: function() { return el( InnerBlocks.Content ); } }
            ],
            save: function() { return null; }
        } );
    } );

} )( window.wp );

/* ============================================================
   Phase 25 — BlockEdit filter: Visual Spacing panel
   Adds Padding / Gap controls to core/group and core/columns
   using UnitControl (with TextControl fallback).
   Attributes are persisted via blocks.registerBlockType filter.
   ============================================================ */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var TextControl    = wp.components.TextControl;
    var SelectControl  = wp.components.SelectControl;
    var ColorPalette   = wp.components.ColorPalette;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var UnitControl = wp.components.__experimentalUnitControl || wp.components.UnitControl || null;
    var p25Data     = window.paksaPhase25 || {};
    var palette     = p25Data.palette || [];
    var units       = ( p25Data.units || [ 'px', 'rem', '%' ] ).map( function( u ) { return { value: u, label: u }; } );

    function SpacingCtrl( props ) {
        if ( UnitControl ) {
            return el( UnitControl, {
                label: props.label,
                value: props.value || '',
                units: units,
                onChange: props.onChange,
                min: 0,
                size: '__unstable-large'
            } );
        }
        return el( TextControl, {
            label: props.label,
            help: 'e.g. 2rem or 32px',
            value: props.value || '',
            onChange: props.onChange
        } );
    }

    var SPACING_BLOCKS = [ 'core/group', 'core/columns' ];

    var withVisualSpacing = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( SPACING_BLOCKS.indexOf( props.name ) === -1 ) {
                return el( BlockEdit, props );
            }
            var a   = props.attributes;
            var set = props.setAttributes;

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {},
                    el( PanelBody, { title: 'Visual Spacing', initialOpen: false, className: 'pk-visual-spacing-panel' },
                        el( SpacingCtrl, {
                            label: 'Padding top',
                            value: a.pkPaddingTop || '',
                            onChange: function( v ) { set( { pkPaddingTop: v || '' } ); }
                        } ),
                        el( SpacingCtrl, {
                            label: 'Padding bottom',
                            value: a.pkPaddingBot || '',
                            onChange: function( v ) { set( { pkPaddingBot: v || '' } ); }
                        } ),
                        el( SpacingCtrl, {
                            label: 'Padding left',
                            value: a.pkPaddingLeft || '',
                            onChange: function( v ) { set( { pkPaddingLeft: v || '' } ); }
                        } ),
                        el( SpacingCtrl, {
                            label: 'Padding right',
                            value: a.pkPaddingRight || '',
                            onChange: function( v ) { set( { pkPaddingRight: v || '' } ); }
                        } ),
                        el( SpacingCtrl, {
                            label: 'Column / block gap',
                            value: a.pkGap || '',
                            onChange: function( v ) { set( { pkGap: v || '' } ); }
                        } )
                    )
                )
            );
        };
    }, 'withPaksaVisualSpacing' );

    addFilter( 'editor.BlockEdit', 'paksa/visual-spacing', withVisualSpacing );

    addFilter( 'blocks.registerBlockType', 'paksa/visual-spacing-attrs',
        function( settings, name ) {
            if ( SPACING_BLOCKS.indexOf( name ) === -1 ) return settings;
            settings.attributes = Object.assign( {}, settings.attributes, {
                pkPaddingTop:   { type: 'string', default: '' },
                pkPaddingBot:   { type: 'string', default: '' },
                pkPaddingLeft:  { type: 'string', default: '' },
                pkPaddingRight: { type: 'string', default: '' },
                pkGap:          { type: 'string', default: '' }
            } );
            return settings;
        }
    );

    /* Apply pk spacing attributes as inline style on the block wrapper */
    addFilter( 'blocks.getSaveContent.extraProps', 'paksa/visual-spacing-save',
        function( extraProps, blockType, attributes ) {
            if ( SPACING_BLOCKS.indexOf( blockType.name ) === -1 ) return extraProps;
            var style = Object.assign( {}, extraProps.style || {} );
            if ( attributes.pkPaddingTop )   style.paddingTop    = attributes.pkPaddingTop;
            if ( attributes.pkPaddingBot )   style.paddingBottom = attributes.pkPaddingBot;
            if ( attributes.pkPaddingLeft )  style.paddingLeft   = attributes.pkPaddingLeft;
            if ( attributes.pkPaddingRight ) style.paddingRight  = attributes.pkPaddingRight;
            if ( attributes.pkGap )          style.gap           = attributes.pkGap;
            extraProps.style = style;
            return extraProps;
        }
    );

} )( window.wp );

/* ============================================================
   Phase 25 — BlockEdit filter: Image hover & overlay controls
   Adds hover zoom toggle and overlay color/opacity to core/image.
   ============================================================ */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var ToggleControl  = wp.components.ToggleControl;
    var RangeControl   = wp.components.RangeControl;
    var ColorPalette   = wp.components.ColorPalette;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var p25Data = window.paksaPhase25 || {};
    var palette = p25Data.palette || [];

    var withImageControls = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( props.name !== 'core/image' ) return el( BlockEdit, props );
            var a   = props.attributes;
            var set = props.setAttributes;

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {},
                    el( PanelBody, { title: 'Paksa Image Effects', initialOpen: false },
                        el( ToggleControl, {
                            label: 'Zoom on hover',
                            help: 'Applies the Paksa Image Zoom style.',
                            checked: !! a.pkImageZoom,
                            onChange: function( v ) {
                                set( { pkImageZoom: v } );
                                // Also toggle the block style class
                                var cls = ( a.className || '' ).replace( /\bis-style-paksa-image-zoom\b/g, '' ).trim();
                                if ( v ) cls = ( cls + ' is-style-paksa-image-zoom' ).trim();
                                set( { className: cls } );
                            }
                        } ),
                        el( ToggleControl, {
                            label: 'Rounded corners',
                            checked: !! a.pkImageRounded,
                            onChange: function( v ) {
                                set( { pkImageRounded: v } );
                                var cls = ( a.className || '' ).replace( /\bis-style-paksa-rounded\b/g, '' ).trim();
                                if ( v ) cls = ( cls + ' is-style-paksa-rounded' ).trim();
                                set( { className: cls } );
                            }
                        } ),
                        el( ToggleControl, {
                            label: 'Elevated (shadow)',
                            checked: !! a.pkImageElevated,
                            onChange: function( v ) {
                                set( { pkImageElevated: v } );
                                var cls = ( a.className || '' ).replace( /\bis-style-paksa-elevated\b/g, '' ).trim();
                                if ( v ) cls = ( cls + ' is-style-paksa-elevated' ).trim();
                                set( { className: cls } );
                            }
                        } )
                    )
                )
            );
        };
    }, 'withPaksaImageControls' );

    addFilter( 'editor.BlockEdit', 'paksa/image-controls', withImageControls );

    addFilter( 'blocks.registerBlockType', 'paksa/image-attrs',
        function( settings, name ) {
            if ( name !== 'core/image' ) return settings;
            settings.attributes = Object.assign( {}, settings.attributes, {
                pkImageZoom:    { type: 'boolean', default: false },
                pkImageRounded: { type: 'boolean', default: false },
                pkImageElevated:{ type: 'boolean', default: false }
            } );
            return settings;
        }
    );

} )( window.wp );

/* ============================================================
   Phase 25 — BlockEdit filter: Button quick-style controls
   Adds size preset and style variant quick-select to core/button.
   ============================================================ */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var SelectControl  = wp.components.SelectControl;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var BUTTON_STYLES = [
        { label: 'Default (filled)', value: '' },
        { label: 'Outline',          value: 'is-style-paksa-button-outline' },
        { label: 'Ghost',            value: 'is-style-paksa-button-ghost' },
        { label: 'Light',            value: 'is-style-paksa-button-light' },
        { label: 'Dark',             value: 'is-style-paksa-button-dark' },
        { label: 'Text link',        value: 'is-style-paksa-button-text' },
        { label: 'Large',            value: 'is-style-paksa-button-large' }
    ];

    var STYLE_CLASSES = BUTTON_STYLES.map( function( s ) { return s.value; } ).filter( Boolean );

    var withButtonControls = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( props.name !== 'core/button' ) return el( BlockEdit, props );
            var a   = props.attributes;
            var set = props.setAttributes;

            // Detect current style from className
            var currentStyle = '';
            STYLE_CLASSES.forEach( function( cls ) {
                if ( ( a.className || '' ).indexOf( cls ) !== -1 ) currentStyle = cls;
            } );

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {},
                    el( PanelBody, { title: 'Paksa Button Style', initialOpen: false },
                        el( SelectControl, {
                            label: 'Style variant',
                            value: currentStyle,
                            options: BUTTON_STYLES,
                            onChange: function( v ) {
                                var cls = ( a.className || '' );
                                STYLE_CLASSES.forEach( function( s ) {
                                    cls = cls.replace( new RegExp( '\\b' + s.replace( /[-\/\\^$*+?.()|[\]{}]/g, '\\$&' ) + '\\b', 'g' ), '' );
                                } );
                                cls = cls.trim();
                                if ( v ) cls = ( cls + ' ' + v ).trim();
                                set( { className: cls } );
                            }
                        } )
                    )
                )
            );
        };
    }, 'withPaksaButtonControls' );

    addFilter( 'editor.BlockEdit', 'paksa/button-controls', withButtonControls );

} )( window.wp );
