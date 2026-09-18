/* ============================================================
   Phase 18 — Advanced Gutenberg Editor Controls
   Upgrades paksa/section, paksa/testimonial, paksa/cta with
   organized grouped panels. Adds new block variations with
   innerBlocks templates. Uses paksaEditorControls data payload.
   ============================================================ */
( function( wp ) {
    if ( ! wp || ! wp.blocks || ! wp.element || ! wp.blockEditor || ! wp.components ) {
        return;
    }

    var el               = wp.element.createElement;
    var Fragment         = wp.element.Fragment;
    var useState         = wp.element.useState;
    var registerBlockType = wp.blocks.registerBlockType;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var InnerBlocks      = wp.blockEditor.InnerBlocks;
    var useBlockProps    = wp.blockEditor.useBlockProps;
    var MediaUpload      = wp.blockEditor.MediaUpload;
    var MediaUploadCheck = wp.blockEditor.MediaUploadCheck;
    var PanelBody        = wp.components.PanelBody;
    var PanelRow         = wp.components.PanelRow;
    var SelectControl    = wp.components.SelectControl;
    var RangeControl     = wp.components.RangeControl;
    var TextControl      = wp.components.TextControl;
    var TextareaControl  = wp.components.TextareaControl;
    var ToggleControl    = wp.components.ToggleControl;
    var Button           = wp.components.Button;
    var ServerSideRender = wp.serverSideRender;
    var iconData         = window.paksaIconBlock || { icons: [] };
    var ctrlData         = window.paksaEditorControls || {};

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

    var hoverEffects = ctrlData.hoverEffects || [
        { label: 'None', value: 'none' },
        { label: 'Lift', value: 'lift' },
        { label: 'Glow', value: 'glow' },
        { label: 'Scale', value: 'scale' },
        { label: 'Brighten', value: 'brighten' },
        { label: 'Dim', value: 'dim' }
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
        { label: 'Right', value: 'right center' }
    ];

    var iconOptions = ( iconData.icons || [] ).map( function( i ) {
        return { label: i.label, value: i.value };
    } );
    var iconOptionsWithNone = [ { label: 'None', value: '' } ].concat( iconOptions );

    /* ── Reusable sub-panels ─────────────────────────────────────────────── */

    function AnimationPanel( props ) {
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

    function HoverPanel( props ) {
        var a = props.attributes;
        var set = props.setAttributes;
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

    function BorderShadowPanel( props ) {
        var a = props.attributes;
        var set = props.setAttributes;
        return el( PanelBody, { title: 'Border & Shadow', initialOpen: false },
            el( TextControl, {
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
            el( TextControl, {
                label: 'Border color',
                help: 'CSS color or var(--pk-*)',
                value: a.borderColor || '',
                onChange: function( v ) { set( { borderColor: v } ); }
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

    function BgImagePanel( props ) {
        var a = props.attributes;
        var set = props.setAttributes;
        return el( PanelBody, { title: 'Background Image', initialOpen: false },
            el( MediaUploadCheck, {},
                el( MediaUpload, {
                    onSelect: function( media ) {
                        set( { bgImageUrl: media.url, bgImageAlt: media.alt || '' } );
                    },
                    allowedTypes: [ 'image' ],
                    value: a.bgImageUrl,
                    render: function( ref ) {
                        return el( Fragment, {},
                            a.bgImageUrl
                                ? el( 'div', { style: { marginBottom: '8px' } },
                                    el( 'img', { src: a.bgImageUrl, style: { width: '100%', height: '80px', objectFit: 'cover', borderRadius: '4px' } } ),
                                    el( Button, {
                                        isDestructive: true,
                                        isSmall: true,
                                        onClick: function() { set( { bgImageUrl: '', bgImageAlt: '' } ); }
                                    }, 'Remove image' )
                                  )
                                : null,
                            el( Button, {
                                onClick: ref.open,
                                variant: 'secondary',
                                isSmall: true
                            }, a.bgImageUrl ? 'Replace image' : 'Select background image' )
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
                el( TextControl, {
                    label: 'Overlay color',
                    help: 'CSS color, e.g. #000000',
                    value: a.bgOverlayColor || '',
                    onChange: function( v ) { set( { bgOverlayColor: v } ); }
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

    /* ── paksa/section — Phase 18 upgraded editor ───────────────────────── */
    wp.blocks.unregisterBlockType && wp.domReady && wp.domReady( function() {
        try { wp.blocks.unregisterBlockType( 'paksa/section' ); } catch(e) {}

        registerBlockType( 'paksa/section', {
            apiVersion: 3,
            title: 'Paksa Section',
            description: 'Full-width section container with background, spacing, animation, hover, and responsive controls.',
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
                variant:         { type: 'string',  default: 'default' },
                minHeight:       { type: 'string',  default: '' },
                paddingTop:      { type: 'string',  default: '' },
                paddingBot:      { type: 'string',  default: '' },
                bgColor:         { type: 'string',  default: '' },
                bgGradient:      { type: 'string',  default: '' },
                overlayOpacity:  { type: 'number',  default: 0 },
                animation:       { type: 'string',  default: 'none' },
                animDelay:       { type: 'number',  default: 0 },
                animDuration:    { type: 'number',  default: 600 },
                containerWidth:  { type: 'string',  default: 'default' },
                textAlign:       { type: 'string',  default: 'left' },
                verticalAlign:   { type: 'string',  default: 'top' },
                customId:        { type: 'string',  default: '' },
                bgImageUrl:      { type: 'string',  default: '' },
                bgImageAlt:      { type: 'string',  default: '' },
                bgImagePosition: { type: 'string',  default: 'center center' },
                bgImageSize:     { type: 'string',  default: 'cover' },
                bgOverlayColor:  { type: 'string',  default: '' },
                bgOverlayOpacity:{ type: 'number',  default: 50 },
                hoverEffect:     { type: 'string',  default: 'none' },
                hoverShadow:     { type: 'boolean', default: false },
                hoverLift:       { type: 'boolean', default: false },
                hoverBgColor:    { type: 'string',  default: '' },
                transition:      { type: 'string',  default: 'base' },
                borderWidth:     { type: 'string',  default: '' },
                borderStyle:     { type: 'string',  default: 'solid' },
                borderColor:     { type: 'string',  default: '' },
                borderRadius:    { type: 'string',  default: '' },
                shadowPreset:    { type: 'string',  default: 'none' }
            },
            edit: function( props ) {
                var a = props.attributes;
                var set = props.setAttributes;
                var blockProps = useBlockProps ? useBlockProps( {
                    className: 'pk-section pk-section--' + a.variant + ( a.textAlign !== 'left' ? ' has-text-align-' + a.textAlign : '' )
                } ) : { className: 'wp-block-paksa-section pk-section pk-section--' + a.variant };

                return el( Fragment, {},
                    el( InspectorControls, {},
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
                            } ),
                            el( TextControl, {
                                label: 'Custom CSS class (optional)',
                                help: 'Added to the section element.',
                                value: a.customId || '',
                                onChange: function( v ) { set( { customId: v } ); }
                            } )
                        ),
                        el( BgImagePanel, { attributes: a, setAttributes: set } ),
                        el( AnimationPanel, { attributes: a, setAttributes: set } ),
                        el( HoverPanel, { attributes: a, setAttributes: set } ),
                        el( BorderShadowPanel, { attributes: a, setAttributes: set } )
                    ),
                    el( 'section', blockProps,
                        el( InnerBlocks, { renderAppender: InnerBlocks.ButtonBlockAppender } )
                    )
                );
            },
            save: function() {
                return el( InnerBlocks.Content );
            }
        } );
    } );

} )( window.wp );

/* ── paksa/testimonial — Phase 18 upgraded editor ───────────────────────── */
( function( wp ) {
    if ( ! wp || ! wp.blocks || ! wp.element || ! wp.blockEditor || ! wp.components ) return;

    var el               = wp.element.createElement;
    var Fragment         = wp.element.Fragment;
    var registerBlockType = wp.blocks.registerBlockType;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody        = wp.components.PanelBody;
    var SelectControl    = wp.components.SelectControl;
    var RangeControl     = wp.components.RangeControl;
    var TextControl      = wp.components.TextControl;
    var TextareaControl  = wp.components.TextareaControl;
    var ToggleControl    = wp.components.ToggleControl;
    var ServerSideRender = wp.serverSideRender;
    var ctrlData         = window.paksaEditorControls || {};

    var hoverEffects = ctrlData.hoverEffects || [
        { label: 'None', value: 'none' }, { label: 'Lift', value: 'lift' },
        { label: 'Glow', value: 'glow' }, { label: 'Scale', value: 'scale' }
    ];
    var shadowTokens = ctrlData.shadowTokens || [
        { label: 'None', value: 'none' }, { label: 'Small', value: 'sm' },
        { label: 'Medium', value: 'md' }, { label: 'Large', value: 'lg' }
    ];
    var radiusTokens = ctrlData.radiusTokens || [
        { label: 'Theme default', value: '' }, { label: 'Small', value: 'var(--pk-radius-sm)' },
        { label: 'Medium', value: 'var(--pk-radius-md)' }, { label: 'Large', value: 'var(--pk-radius-lg)' },
        { label: 'XL', value: 'var(--pk-radius-xl)' }, { label: 'Full', value: 'var(--pk-radius-full)' }
    ];

    wp.domReady && wp.domReady( function() {
        try { wp.blocks.unregisterBlockType( 'paksa/testimonial' ); } catch(e) {}

        registerBlockType( 'paksa/testimonial', {
            apiVersion: 3,
            title: 'Paksa Testimonial',
            description: 'Accessible testimonial card with quote, author, rating, avatar, hover, and border controls.',
            category: 'paksa-components',
            icon: 'format-quote',
            supports: {
                html: false,
                align: [ 'left', 'center', 'right' ],
                color: { text: true, background: true },
                spacing: { margin: true, padding: true }
            },
            attributes: {
                quote: { type: 'string', default: '' },
                author: { type: 'string', default: '' },
                role: { type: 'string', default: '' },
                company: { type: 'string', default: '' },
                rating: { type: 'number', default: 5 },
                showRating: { type: 'boolean', default: false },
                avatarUrl: { type: 'string', default: '' },
                avatarAlt: { type: 'string', default: '' },
                variant: { type: 'string', default: 'default' },
                accentColor: { type: 'string', default: '' },
                quoteSize: { type: 'string', default: 'normal' },
                hoverEffect: { type: 'string', default: 'none' },
                hoverShadow: { type: 'boolean', default: false },
                hoverLift: { type: 'boolean', default: false },
                hoverBgColor: { type: 'string', default: '' },
                transition: { type: 'string', default: 'base' },
                borderWidth: { type: 'string', default: '' },
                borderStyle: { type: 'string', default: 'solid' },
                borderColor: { type: 'string', default: '' },
                borderRadius: { type: 'string', default: '' },
                shadowPreset: { type: 'string', default: 'none' }
            },
            edit: function( props ) {
                var a = props.attributes;
                var set = props.setAttributes;
                var preview = ServerSideRender
                    ? el( ServerSideRender, { block: 'paksa/testimonial', attributes: a } )
                    : el( 'div', { className: 'pk-testimonial pk-testimonial--' + a.variant },
                        el( 'p', { style: { fontStyle: 'italic' } }, a.quote || 'Add a quote here.' ),
                        el( 'strong', {}, a.author || 'Author name' )
                      );

                return el( Fragment, {},
                    el( InspectorControls, {},
                        el( PanelBody, { title: 'Quote Content', initialOpen: true },
                            el( TextareaControl, {
                                label: 'Quote',
                                value: a.quote,
                                onChange: function( v ) { set( { quote: v } ); }
                            } ),
                            el( TextControl, {
                                label: 'Author name',
                                value: a.author,
                                onChange: function( v ) { set( { author: v } ); }
                            } ),
                            el( TextControl, {
                                label: 'Role',
                                value: a.role,
                                onChange: function( v ) { set( { role: v } ); }
                            } ),
                            el( TextControl, {
                                label: 'Company',
                                value: a.company,
                                onChange: function( v ) { set( { company: v } ); }
                            } )
                        ),
                        el( PanelBody, { title: 'Appearance', initialOpen: false },
                            el( SelectControl, {
                                label: 'Style variant',
                                value: a.variant,
                                options: [
                                    { label: 'Default', value: 'default' },
                                    { label: 'Bordered', value: 'bordered' },
                                    { label: 'Dark', value: 'dark' }
                                ],
                                onChange: function( v ) { set( { variant: v } ); }
                            } ),
                            el( SelectControl, {
                                label: 'Quote text size',
                                value: a.quoteSize || 'normal',
                                options: [
                                    { label: 'Normal', value: 'normal' },
                                    { label: 'Large', value: 'large' }
                                ],
                                onChange: function( v ) { set( { quoteSize: v } ); }
                            } ),
                            el( TextControl, {
                                label: 'Accent color (top border)',
                                help: 'CSS color or var(--pk-*). Leave empty for theme default.',
                                value: a.accentColor || '',
                                onChange: function( v ) { set( { accentColor: v } ); }
                            } )
                        ),
                        el( PanelBody, { title: 'Rating', initialOpen: false },
                            el( ToggleControl, {
                                label: 'Show star rating',
                                checked: a.showRating,
                                onChange: function( v ) { set( { showRating: v } ); }
                            } ),
                            a.showRating ? el( RangeControl, {
                                label: 'Stars',
                                value: a.rating,
                                min: 1, max: 5,
                                onChange: function( v ) { set( { rating: v } ); }
                            } ) : null
                        ),
                        el( PanelBody, { title: 'Avatar', initialOpen: false },
                            el( TextControl, {
                                label: 'Avatar image URL',
                                type: 'url',
                                value: a.avatarUrl,
                                onChange: function( v ) { set( { avatarUrl: v } ); }
                            } ),
                            el( TextControl, {
                                label: 'Avatar alt text',
                                value: a.avatarAlt,
                                onChange: function( v ) { set( { avatarAlt: v } ); }
                            } )
                        ),
                        el( PanelBody, { title: 'Hover & Interaction', initialOpen: false },
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
                        ),
                        el( PanelBody, { title: 'Border & Shadow', initialOpen: false },
                            el( TextControl, {
                                label: 'Border width',
                                help: 'e.g. 1px',
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
                            el( TextControl, {
                                label: 'Border color',
                                value: a.borderColor || '',
                                onChange: function( v ) { set( { borderColor: v } ); }
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
                        )
                    ),
                    el( 'div', { className: 'pk-editor-testimonial-preview' }, preview )
                );
            },
            save: function() { return null; }
        } );
    } );
} )( window.wp );

/* ── paksa/cta — Phase 18 upgraded editor ───────────────────────────────── */
( function( wp ) {
    if ( ! wp || ! wp.blocks || ! wp.element || ! wp.blockEditor || ! wp.components ) return;

    var el               = wp.element.createElement;
    var Fragment         = wp.element.Fragment;
    var registerBlockType = wp.blocks.registerBlockType;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var MediaUpload      = wp.blockEditor.MediaUpload;
    var MediaUploadCheck = wp.blockEditor.MediaUploadCheck;
    var PanelBody        = wp.components.PanelBody;
    var SelectControl    = wp.components.SelectControl;
    var RangeControl     = wp.components.RangeControl;
    var TextControl      = wp.components.TextControl;
    var TextareaControl  = wp.components.TextareaControl;
    var ToggleControl    = wp.components.ToggleControl;
    var Button           = wp.components.Button;
    var ServerSideRender = wp.serverSideRender;
    var iconData         = window.paksaIconBlock || { icons: [] };
    var ctrlData         = window.paksaEditorControls || {};

    var animOptions = ctrlData.animationOptions || [
        { label: 'None', value: 'none' }, { label: 'Fade', value: 'fade' },
        { label: 'Fade Up', value: 'fade-up' }, { label: 'Scale', value: 'scale' }
    ];
    var shadowTokens = ctrlData.shadowTokens || [
        { label: 'None', value: 'none' }, { label: 'Small', value: 'sm' },
        { label: 'Medium', value: 'md' }, { label: 'Large', value: 'lg' }
    ];
    var radiusTokens = ctrlData.radiusTokens || [
        { label: 'Theme default', value: '' }, { label: 'Medium', value: 'var(--pk-radius-md)' },
        { label: 'Large', value: 'var(--pk-radius-lg)' }, { label: 'XL', value: 'var(--pk-radius-xl)' }
    ];
    var bgPositions = ctrlData.bgPositions || [
        { label: 'Center', value: 'center center' }, { label: 'Top', value: 'center top' },
        { label: 'Bottom', value: 'center bottom' }
    ];
    var iconOptionsWithNone = [ { label: 'None', value: '' } ].concat(
        ( iconData.icons || [] ).map( function( i ) { return { label: i.label, value: i.value }; } )
    );

    wp.domReady && wp.domReady( function() {
        try { wp.blocks.unregisterBlockType( 'paksa/cta' ); } catch(e) {}

        registerBlockType( 'paksa/cta', {
            apiVersion: 3,
            title: 'Paksa CTA',
            description: 'Reusable call-to-action with heading, buttons, background image, animation, and border controls.',
            category: 'paksa-components',
            icon: 'megaphone',
            supports: {
                html: false,
                align: [ 'wide', 'full' ],
                anchor: true,
                color: { text: true, background: true },
                spacing: { padding: true, margin: true }
            },
            attributes: {
                eyebrow: { type: 'string', default: '' },
                heading: { type: 'string', default: '' },
                description: { type: 'string', default: '' },
                variant: { type: 'string', default: 'dark' },
                layout: { type: 'string', default: 'centered' },
                primaryLabel: { type: 'string', default: '' },
                primaryUrl: { type: 'string', default: '' },
                primaryNewTab: { type: 'boolean', default: false },
                secondaryLabel: { type: 'string', default: '' },
                secondaryUrl: { type: 'string', default: '' },
                secondaryNewTab: { type: 'boolean', default: false },
                primaryIcon: { type: 'string', default: '' },
                secondaryIcon: { type: 'string', default: '' },
                animation: { type: 'string', default: 'none' },
                animDelay: { type: 'number', default: 0 },
                bgImageUrl: { type: 'string', default: '' },
                bgImageAlt: { type: 'string', default: '' },
                bgImagePosition: { type: 'string', default: 'center center' },
                bgImageSize: { type: 'string', default: 'cover' },
                bgOverlayColor: { type: 'string', default: '' },
                bgOverlayOpacity: { type: 'number', default: 50 },
                borderWidth: { type: 'string', default: '' },
                borderStyle: { type: 'string', default: 'solid' },
                borderColor: { type: 'string', default: '' },
                borderRadius: { type: 'string', default: '' },
                shadowPreset: { type: 'string', default: 'none' }
            },
            edit: function( props ) {
                var a = props.attributes;
                var set = props.setAttributes;
                var preview = ServerSideRender
                    ? el( ServerSideRender, { block: 'paksa/cta', attributes: a } )
                    : el( 'div', { className: 'pk-cta pk-cta--' + a.variant + ' pk-cta--' + a.layout },
                        el( 'div', { className: 'pk-cta__inner' },
                            el( 'div', { className: 'pk-cta__content' },
                                a.eyebrow ? el( 'span', { className: 'pk-cta__eyebrow pk-component-eyebrow' }, a.eyebrow ) : null,
                                el( 'h2', { className: 'pk-cta__heading' }, a.heading || 'Add a CTA heading' ),
                                a.description ? el( 'p', { className: 'pk-cta__description' }, a.description ) : null
                            )
                        )
                      );

                return el( Fragment, {},
                    el( InspectorControls, {},
                        el( PanelBody, { title: 'Content', initialOpen: true },
                            el( TextControl, {
                                label: 'Eyebrow',
                                value: a.eyebrow,
                                onChange: function( v ) { set( { eyebrow: v } ); }
                            } ),
                            el( TextControl, {
                                label: 'Heading',
                                value: a.heading,
                                onChange: function( v ) { set( { heading: v } ); }
                            } ),
                            el( TextareaControl, {
                                label: 'Description',
                                value: a.description,
                                onChange: function( v ) { set( { description: v } ); }
                            } )
                        ),
                        el( PanelBody, { title: 'Appearance', initialOpen: false },
                            el( SelectControl, {
                                label: 'Background variant',
                                value: a.variant,
                                options: [
                                    { label: 'Dark', value: 'dark' },
                                    { label: 'Gradient', value: 'gradient' },
                                    { label: 'Light', value: 'light' },
                                    { label: 'Alt', value: 'alt' },
                                    { label: 'Transparent', value: 'transparent' }
                                ],
                                onChange: function( v ) { set( { variant: v } ); }
                            } ),
                            el( SelectControl, {
                                label: 'Layout',
                                value: a.layout,
                                options: [
                                    { label: 'Centered', value: 'centered' },
                                    { label: 'Split (text + buttons side by side)', value: 'split' },
                                    { label: 'Left aligned', value: 'left' }
                                ],
                                onChange: function( v ) { set( { layout: v } ); }
                            } )
                        ),
                        el( PanelBody, { title: 'Primary Button', initialOpen: false },
                            el( TextControl, {
                                label: 'Label',
                                value: a.primaryLabel,
                                onChange: function( v ) { set( { primaryLabel: v } ); }
                            } ),
                            el( TextControl, {
                                label: 'URL',
                                type: 'url',
                                value: a.primaryUrl,
                                onChange: function( v ) { set( { primaryUrl: v } ); }
                            } ),
                            el( ToggleControl, {
                                label: 'Open in new tab',
                                checked: !! a.primaryNewTab,
                                onChange: function( v ) { set( { primaryNewTab: v } ); }
                            } ),
                            el( SelectControl, {
                                label: 'Icon',
                                value: a.primaryIcon || '',
                                options: iconOptionsWithNone,
                                onChange: function( v ) { set( { primaryIcon: v } ); }
                            } )
                        ),
                        el( PanelBody, { title: 'Secondary Button', initialOpen: false },
                            el( TextControl, {
                                label: 'Label',
                                value: a.secondaryLabel,
                                onChange: function( v ) { set( { secondaryLabel: v } ); }
                            } ),
                            el( TextControl, {
                                label: 'URL',
                                type: 'url',
                                value: a.secondaryUrl,
                                onChange: function( v ) { set( { secondaryUrl: v } ); }
                            } ),
                            el( ToggleControl, {
                                label: 'Open in new tab',
                                checked: !! a.secondaryNewTab,
                                onChange: function( v ) { set( { secondaryNewTab: v } ); }
                            } ),
                            el( SelectControl, {
                                label: 'Icon',
                                value: a.secondaryIcon || '',
                                options: iconOptionsWithNone,
                                onChange: function( v ) { set( { secondaryIcon: v } ); }
                            } )
                        ),
                        el( PanelBody, { title: 'Background Image', initialOpen: false },
                            el( MediaUploadCheck, {},
                                el( MediaUpload, {
                                    onSelect: function( media ) { set( { bgImageUrl: media.url, bgImageAlt: media.alt || '' } ); },
                                    allowedTypes: [ 'image' ],
                                    value: a.bgImageUrl,
                                    render: function( ref ) {
                                        return el( Fragment, {},
                                            a.bgImageUrl ? el( 'div', { style: { marginBottom: '8px' } },
                                                el( 'img', { src: a.bgImageUrl, style: { width: '100%', height: '60px', objectFit: 'cover', borderRadius: '4px' } } ),
                                                el( Button, { isDestructive: true, isSmall: true, onClick: function() { set( { bgImageUrl: '', bgImageAlt: '' } ); } }, 'Remove' )
                                            ) : null,
                                            el( Button, { onClick: ref.open, variant: 'secondary', isSmall: true }, a.bgImageUrl ? 'Replace' : 'Select image' )
                                        );
                                    }
                                } )
                            ),
                            a.bgImageUrl ? el( Fragment, {},
                                el( SelectControl, {
                                    label: 'Position',
                                    value: a.bgImagePosition || 'center center',
                                    options: bgPositions,
                                    onChange: function( v ) { set( { bgImagePosition: v } ); }
                                } ),
                                el( TextControl, {
                                    label: 'Overlay color',
                                    value: a.bgOverlayColor || '',
                                    onChange: function( v ) { set( { bgOverlayColor: v } ); }
                                } ),
                                el( RangeControl, {
                                    label: 'Overlay opacity (%)',
                                    value: a.bgOverlayOpacity !== undefined ? a.bgOverlayOpacity : 50,
                                    min: 0, max: 100, step: 5,
                                    onChange: function( v ) { set( { bgOverlayOpacity: v } ); }
                                } )
                            ) : null
                        ),
                        el( PanelBody, { title: 'Animation', initialOpen: false },
                            el( SelectControl, {
                                label: 'Entrance animation',
                                value: a.animation || 'none',
                                options: animOptions,
                                onChange: function( v ) { set( { animation: v } ); }
                            } ),
                            ( a.animation && a.animation !== 'none' ) ? el( RangeControl, {
                                label: 'Delay (ms)',
                                value: a.animDelay || 0,
                                min: 0, max: 800, step: 100,
                                onChange: function( v ) { set( { animDelay: v } ); }
                            } ) : null
                        ),
                        el( PanelBody, { title: 'Border & Shadow', initialOpen: false },
                            el( TextControl, {
                                label: 'Border width',
                                value: a.borderWidth || '',
                                onChange: function( v ) { set( { borderWidth: v } ); }
                            } ),
                            el( SelectControl, {
                                label: 'Border style',
                                value: a.borderStyle || 'solid',
                                options: [
                                    { label: 'Solid', value: 'solid' }, { label: 'Dashed', value: 'dashed' },
                                    { label: 'Dotted', value: 'dotted' }, { label: 'None', value: 'none' }
                                ],
                                onChange: function( v ) { set( { borderStyle: v } ); }
                            } ),
                            el( TextControl, {
                                label: 'Border color',
                                value: a.borderColor || '',
                                onChange: function( v ) { set( { borderColor: v } ); }
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
                        )
                    ),
                    el( 'div', { className: 'pk-editor-cta-preview' }, preview )
                );
            },
            save: function() { return null; }
        } );
    } );
} )( window.wp );

/* ── Phase 18 block variations with innerBlocks templates ───────────────── */
( function( wp ) {
    if ( ! wp || ! wp.blocks || ! wp.blocks.registerBlockVariation ) return;

    var variations = [
        /* Section compositions */
        {
            block: 'core/group',
            name: 'paksa-hero-section',
            title: 'Paksa Hero Section',
            description: 'A full-width hero section with heading, paragraph, and buttons.',
            attributes: { align: 'full', className: 'pk-section pk-hero pk-hero--classic', layout: { type: 'constrained' } },
            innerBlocks: [
                [ 'core/heading', { level: 1, placeholder: 'Hero heading' } ],
                [ 'core/paragraph', { placeholder: 'Hero description', className: 'is-style-paksa-lead' } ],
                [ 'core/buttons', { className: 'pk-component-action-group' }, [
                    [ 'core/button', { text: 'Get started' } ],
                    [ 'core/button', { text: 'Learn more', className: 'is-style-paksa-button-outline' } ]
                ] ]
            ]
        },
        {
            block: 'core/group',
            name: 'paksa-feature-section',
            title: 'Paksa Feature Section',
            description: 'A section with eyebrow, heading, description, and a 3-column feature grid.',
            attributes: { align: 'full', className: 'pk-section', layout: { type: 'constrained' } },
            innerBlocks: [
                [ 'core/paragraph', { content: 'Features', className: 'pk-component-eyebrow' } ],
                [ 'core/heading', { level: 2, placeholder: 'Section heading' } ],
                [ 'core/paragraph', { placeholder: 'Section description', className: 'is-style-paksa-lead' } ],
                [ 'core/columns', { className: 'pk-pattern-card-grid' }, [
                    [ 'core/column', {}, [ [ 'core/group', { className: 'pk-pattern-card is-style-paksa-card-feature', layout: { type: 'constrained' } }, [
                        [ 'core/heading', { level: 3, placeholder: 'Feature title' } ],
                        [ 'core/paragraph', { placeholder: 'Feature description' } ]
                    ] ] ] ],
                    [ 'core/column', {}, [ [ 'core/group', { className: 'pk-pattern-card is-style-paksa-card-feature', layout: { type: 'constrained' } }, [
                        [ 'core/heading', { level: 3, placeholder: 'Feature title' } ],
                        [ 'core/paragraph', { placeholder: 'Feature description' } ]
                    ] ] ] ],
                    [ 'core/column', {}, [ [ 'core/group', { className: 'pk-pattern-card is-style-paksa-card-feature', layout: { type: 'constrained' } }, [
                        [ 'core/heading', { level: 3, placeholder: 'Feature title' } ],
                        [ 'core/paragraph', { placeholder: 'Feature description' } ]
                    ] ] ] ]
                ] ]
            ]
        },
        {
            block: 'core/group',
            name: 'paksa-split-section',
            title: 'Paksa Split Section',
            description: 'A two-column section with content on the left and media on the right.',
            attributes: { align: 'full', className: 'pk-section', layout: { type: 'constrained' } },
            innerBlocks: [
                [ 'core/columns', { verticalAlignment: 'center', className: 'is-style-paksa-feature-row' }, [
                    [ 'core/column', {}, [
                        [ 'core/paragraph', { content: 'About', className: 'pk-component-eyebrow' } ],
                        [ 'core/heading', { level: 2, placeholder: 'Section heading' } ],
                        [ 'core/paragraph', { placeholder: 'Section description' } ],
                        [ 'core/buttons', {}, [ [ 'core/button', { text: 'Learn more' } ] ] ]
                    ] ],
                    [ 'core/column', {}, [
                        [ 'core/image', { className: 'is-style-paksa-rounded', sizeSlug: 'large' } ]
                    ] ]
                ] ]
            ]
        },
        {
            block: 'core/group',
            name: 'paksa-stats-section',
            title: 'Paksa Stats Section',
            description: 'A section with a 4-column stat grid.',
            attributes: { align: 'full', className: 'pk-section pk-section--alt', layout: { type: 'constrained' } },
            innerBlocks: [
                [ 'core/heading', { level: 2, placeholder: 'Stats heading', textAlign: 'center' } ],
                [ 'core/columns', { className: 'pk-pattern-stat-grid' }, [
                    [ 'core/column', {}, [ [ 'paksa/stat', { number: 100, suffix: '+', label: 'Projects delivered' } ] ] ],
                    [ 'core/column', {}, [ [ 'paksa/stat', { number: 50, suffix: '+', label: 'Enterprise clients' } ] ] ],
                    [ 'core/column', {}, [ [ 'paksa/stat', { number: 10, suffix: '+', label: 'Years experience' } ] ] ],
                    [ 'core/column', {}, [ [ 'paksa/stat', { number: 98, suffix: '%', label: 'Client satisfaction' } ] ] ]
                ] ]
            ]
        },
        {
            block: 'core/group',
            name: 'paksa-testimonials-section',
            title: 'Paksa Testimonials Section',
            description: 'A section with a 3-column testimonial grid.',
            attributes: { align: 'full', className: 'pk-section pk-section--alt', layout: { type: 'constrained' } },
            innerBlocks: [
                [ 'core/paragraph', { content: 'Social proof', className: 'pk-component-eyebrow' } ],
                [ 'core/heading', { level: 2, placeholder: 'What people say', textAlign: 'center' } ],
                [ 'core/columns', { className: 'pk-pattern-card-grid' }, [
                    [ 'core/column', {}, [ [ 'paksa/testimonial', { quote: 'Add a genuine quote here.', author: 'Author name', role: 'Role', showRating: true } ] ] ],
                    [ 'core/column', {}, [ [ 'paksa/testimonial', { quote: 'Add a genuine quote here.', author: 'Author name', role: 'Role', showRating: true } ] ] ],
                    [ 'core/column', {}, [ [ 'paksa/testimonial', { quote: 'Add a genuine quote here.', author: 'Author name', role: 'Role', showRating: true } ] ] ]
                ] ]
            ]
        },
        {
            block: 'core/group',
            name: 'paksa-pricing-section',
            title: 'Paksa Pricing Section',
            description: 'A section with a 3-column pricing card grid.',
            attributes: { align: 'full', className: 'pk-section', layout: { type: 'constrained' } },
            innerBlocks: [
                [ 'core/paragraph', { content: 'Pricing', className: 'pk-component-eyebrow' } ],
                [ 'core/heading', { level: 2, placeholder: 'Simple, transparent pricing', textAlign: 'center' } ],
                [ 'core/columns', {}, [
                    [ 'core/column', {}, [ [ 'core/group', { className: 'is-style-paksa-card-pricing', layout: { type: 'constrained' } }, [
                        [ 'core/heading', { level: 3, content: 'Starter' } ],
                        [ 'core/paragraph', { content: '$0 / mo' } ],
                        [ 'core/list', { className: 'is-style-paksa-icon-list', values: '<li>Feature one</li><li>Feature two</li>' } ],
                        [ 'core/buttons', {}, [ [ 'core/button', { text: 'Get started' } ] ] ]
                    ] ] ] ],
                    [ 'core/column', {}, [ [ 'core/group', { className: 'is-style-paksa-card-pricing pk-pattern-card--dark', layout: { type: 'constrained' } }, [
                        [ 'core/heading', { level: 3, content: 'Professional' } ],
                        [ 'core/paragraph', { content: '$49 / mo' } ],
                        [ 'core/list', { className: 'is-style-paksa-icon-list', values: '<li>Everything in Starter</li><li>Advanced feature</li>' } ],
                        [ 'core/buttons', {}, [ [ 'core/button', { text: 'Start free trial' } ] ] ]
                    ] ] ] ],
                    [ 'core/column', {}, [ [ 'core/group', { className: 'is-style-paksa-card-pricing', layout: { type: 'constrained' } }, [
                        [ 'core/heading', { level: 3, content: 'Enterprise' } ],
                        [ 'core/paragraph', { content: 'Custom' } ],
                        [ 'core/list', { className: 'is-style-paksa-icon-list', values: '<li>Everything in Professional</li><li>Dedicated support</li>' } ],
                        [ 'core/buttons', {}, [ [ 'core/button', { text: 'Talk to sales' } ] ] ]
                    ] ] ] ]
                ] ]
            ]
        },
        /* Card compositions */
        {
            block: 'core/group',
            name: 'paksa-feature-card',
            title: 'Paksa Feature Card',
            description: 'A feature card with icon, heading, and description.',
            attributes: { className: 'pk-pattern-card is-style-paksa-card-feature', layout: { type: 'constrained' } },
            innerBlocks: [
                [ 'paksa/icon', { name: 'ai', size: 24 } ],
                [ 'core/heading', { level: 3, placeholder: 'Feature title' } ],
                [ 'core/paragraph', { placeholder: 'Feature description' } ]
            ]
        },
        {
            block: 'core/group',
            name: 'paksa-service-card',
            title: 'Paksa Service Card',
            description: 'A service card with icon, heading, description, and link.',
            attributes: { className: 'pk-pattern-card is-style-paksa-card-service', layout: { type: 'constrained' } },
            innerBlocks: [
                [ 'paksa/icon', { name: 'services', size: 24 } ],
                [ 'core/heading', { level: 3, placeholder: 'Service title' } ],
                [ 'core/paragraph', { placeholder: 'Service description' } ],
                [ 'core/buttons', {}, [ [ 'core/button', { text: 'Learn more', className: 'is-style-paksa-button-text' } ] ] ]
            ]
        },
        {
            block: 'core/group',
            name: 'paksa-team-card',
            title: 'Paksa Team Card',
            description: 'A team member card with image, name, and role.',
            attributes: { className: 'is-style-paksa-card-team', layout: { type: 'constrained' } },
            innerBlocks: [
                [ 'core/image', { sizeSlug: 'paksa-medium', className: 'is-style-paksa-rounded' } ],
                [ 'core/heading', { level: 3, placeholder: 'Team member name' } ],
                [ 'core/paragraph', { placeholder: 'Role or title', className: 'pk-component-meta' } ],
                [ 'core/paragraph', { placeholder: 'Short bio or description' } ]
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
