( function( wp ) {
    if ( ! wp || ! wp.blocks || ! wp.element || ! wp.blockEditor || ! wp.components ) {
        return;
    }

    var el = wp.element.createElement;
    var Fragment = wp.element.Fragment;
    var registerBlockType = wp.blocks.registerBlockType;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody = wp.components.PanelBody;
    var SelectControl = wp.components.SelectControl;
    var RangeControl = wp.components.RangeControl;
    var TextControl = wp.components.TextControl;
    var ToggleControl = wp.components.ToggleControl;
    var ServerSideRender = wp.serverSideRender;
    var iconData = window.paksaIconBlock || { icons: [] };

    /* Native-core variations expose the Paksa visual system without adding a
       second builder or a parallel content format. Their classes are shared
       by the editor and the frontend component CSS. */
    if ( wp.blocks.registerBlockVariation ) {
        [
            {
                block: 'core/group',
                name: 'paksa-section',
                title: 'Paksa Section',
                description: 'A full-width section with token-based responsive spacing.',
                attributes: { align: 'full', className: 'pk-component-section', layout: { type: 'constrained' } }
            },
            {
                block: 'core/group',
                name: 'paksa-container',
                title: 'Paksa Container',
                description: 'A constrained reusable content container.',
                attributes: { align: 'wide', className: 'pk-component-container', layout: { type: 'constrained' } }
            },
            {
                block: 'core/group',
                name: 'paksa-card',
                title: 'Paksa Card',
                description: 'A token-based card that can use any Paksa card style.',
                attributes: { className: 'is-style-paksa-card-basic', layout: { type: 'constrained' } }
            },
            {
                block: 'core/columns',
                name: 'paksa-feature-row',
                title: 'Paksa Feature Row',
                description: 'A responsive, vertically aligned media and content row.',
                attributes: { verticalAlignment: 'center', className: 'is-style-paksa-feature-row' }
            },
            {
                block: 'core/cover',
                name: 'paksa-media-section',
                title: 'Paksa Background Media Section',
                description: 'A full-width Cover block with native media, overlay, and position controls.',
                attributes: { align: 'full', dimRatio: 50, minHeight: 420, className: 'is-style-paksa-media-section' }
            },
            {
                block: 'core/buttons',
                name: 'paksa-action-group',
                title: 'Paksa Action Group',
                description: 'A responsive action group using the shared button system.',
                attributes: { className: 'pk-component-action-group', layout: { type: 'flex', flexWrap: 'wrap' } }
            },
            {
                block: 'core/list',
                name: 'paksa-icon-list',
                title: 'Paksa Icon List',
                description: 'A concise feature list with theme-consistent icon markers.',
                attributes: { className: 'is-style-paksa-icon-list' }
            },
            {
                block: 'core/shortcode',
                name: 'paksa-contact-form',
                title: 'Paksa Contact Form',
                description: 'The existing secure Paksa contact form, ready to place in any editable layout.',
                attributes: { text: '[paksa_contact_form]' }
            }
        ].forEach( function( variation ) {
            wp.blocks.registerBlockVariation( variation.block, {
                name: variation.name,
                title: variation.title,
                description: variation.description,
                attributes: variation.attributes,
                scope: [ 'inserter' ]
            } );
        } );
    }

    registerBlockType( 'paksa/icon', {
        apiVersion: 3,
        title: 'Paksa Icon',
        description: 'A lightweight icon from the Paksa icon system.',
        category: 'paksa-components',
        icon: 'star-filled',
        supports: {
            html: false,
            align: [ 'left', 'center', 'right' ],
            color: { text: true, background: true },
            spacing: { margin: true, padding: true }
        },
        attributes: {
            name: { type: 'string', default: 'ai' },
            size: { type: 'number', default: 24 },
            label: { type: 'string', default: '' },
            shape: { type: 'string', default: 'rounded' },
            hover: { type: 'string', default: 'none' }
        },
        edit: function( props ) {
            var attributes = props.attributes;
            var icons = iconData.icons || [];
            var options = icons.map( function( icon ) {
                return { label: icon.label, value: icon.value };
            } );
            var label = attributes.label || attributes.name.replace( /[-_]/g, ' ' );
            var selectedIcon = icons.filter( function( icon ) { return icon.value === attributes.name; } )[ 0 ] || icons[ 0 ];

            return el(
                Fragment,
                {},
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        { title: 'Icon settings', initialOpen: true },
                        el( SelectControl, {
                            label: 'Icon',
                            value: attributes.name,
                            options: options,
                            onChange: function( name ) { props.setAttributes( { name: name } ); }
                        } ),
                        el( RangeControl, {
                            label: 'Icon size',
                            value: attributes.size,
                            min: 16,
                            max: 64,
                            step: 4,
                            onChange: function( size ) { props.setAttributes( { size: size } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Container shape',
                            value: attributes.shape,
                            options: [
                                { label: 'Rounded square', value: 'rounded' },
                                { label: 'Circle', value: 'circle' },
                                { label: 'Square', value: 'square' },
                                { label: 'No container', value: 'none' }
                            ],
                            onChange: function( shape ) { props.setAttributes( { shape: shape } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Hover effect',
                            value: attributes.hover,
                            options: [
                                { label: 'None', value: 'none' },
                                { label: 'Lift', value: 'lift' },
                                { label: 'Glow', value: 'glow' },
                                { label: 'Scale', value: 'scale' }
                            ],
                            onChange: function( hover ) { props.setAttributes( { hover: hover } ); }
                        } ),
                        el( TextControl, {
                            label: 'Accessible label (optional)',
                            help: 'Leave blank when the icon is decorative.',
                            value: attributes.label,
                            onChange: function( labelValue ) { props.setAttributes( { label: labelValue } ); }
                        } )
                    )
                ),
                el(
                    'span',
                    {
                        className: 'wp-block-paksa-icon pk-editor-icon-preview is-shape-' + attributes.shape + ' is-hover-' + attributes.hover,
                        style: { '--pk-icon-size': attributes.size + 'px' },
                        'aria-label': attributes.label || undefined,
                        role: attributes.label ? 'img' : undefined
                    },
                    selectedIcon ? el( 'span', { 'aria-hidden': true, dangerouslySetInnerHTML: { __html: selectedIcon.svg } } ) : null,
                    el( 'span', { className: 'screen-reader-text' }, label )
                )
            );
        },
        save: function() { return null; }
    } );

    registerBlockType( 'paksa/action', {
        apiVersion: 3,
        title: 'Paksa Action',
        description: 'An accessible action link with a selectable Paksa icon.',
        category: 'paksa-components',
        icon: 'button',
        supports: {
            html: false,
            align: [ 'left', 'center', 'right' ],
            color: { text: true, background: true },
            spacing: { margin: true, padding: true }
        },
        attributes: {
            label: { type: 'string', default: 'Add an action' },
            url: { type: 'string', default: '' },
            variant: { type: 'string', default: 'primary' },
            icon: { type: 'string', default: 'arrow' },
            iconPosition: { type: 'string', default: 'end' },
            newTab: { type: 'boolean', default: false },
            ariaLabel: { type: 'string', default: '' }
        },
        edit: function( props ) {
            var attributes = props.attributes;
            var icons = iconData.icons || [];
            var options = icons.map( function( icon ) { return { label: icon.label, value: icon.value }; } );
            var selectedIcon = icons.filter( function( icon ) { return icon.value === attributes.icon; } )[ 0 ] || icons[ 0 ];
            var iconPreview = selectedIcon ? el( 'span', { className: 'pk-action__icon', 'aria-hidden': true, dangerouslySetInnerHTML: { __html: selectedIcon.svg } } ) : null;

            return el(
                Fragment,
                {},
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        { title: 'Action settings', initialOpen: true },
                        el( TextControl, {
                            label: 'Label',
                            value: attributes.label,
                            onChange: function( label ) { props.setAttributes( { label: label } ); }
                        } ),
                        el( TextControl, {
                            label: 'URL',
                            type: 'url',
                            help: 'The action remains visibly inactive until a URL is set.',
                            value: attributes.url,
                            onChange: function( url ) { props.setAttributes( { url: url } ); }
                        } ),
                        el( ToggleControl, {
                            label: 'Open in a new tab',
                            checked: attributes.newTab,
                            onChange: function( newTab ) { props.setAttributes( { newTab: newTab } ); }
                        } ),
                        el( TextControl, {
                            label: 'Accessible label (optional)',
                            help: 'Use when the action needs more context than its visible label.',
                            value: attributes.ariaLabel,
                            onChange: function( ariaLabel ) { props.setAttributes( { ariaLabel: ariaLabel } ); }
                        } )
                    ),
                    el(
                        PanelBody,
                        { title: 'Appearance', initialOpen: false },
                        el( SelectControl, {
                            label: 'Style',
                            value: attributes.variant,
                            options: [
                                { label: 'Primary', value: 'primary' },
                                { label: 'Secondary', value: 'secondary' },
                                { label: 'Outline', value: 'outline' },
                                { label: 'Ghost', value: 'ghost' },
                                { label: 'Text link', value: 'text' }
                            ],
                            onChange: function( variant ) { props.setAttributes( { variant: variant } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Icon',
                            value: attributes.icon,
                            options: options,
                            onChange: function( icon ) { props.setAttributes( { icon: icon } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Icon position',
                            value: attributes.iconPosition,
                            options: [
                                { label: 'After label', value: 'end' },
                                { label: 'Before label', value: 'start' },
                                { label: 'No icon', value: 'none' }
                            ],
                            onChange: function( iconPosition ) { props.setAttributes( { iconPosition: iconPosition } ); }
                        } )
                    )
                ),
                el(
                    'button',
                    {
                        type: 'button',
                        className: 'wp-block-paksa-action pk-action pk-action--' + attributes.variant + ' pk-action--icon-' + attributes.iconPosition,
                        disabled: ! attributes.url
                    },
                    attributes.iconPosition === 'start' ? iconPreview : null,
                    el( 'span', { className: 'pk-action__label' }, attributes.label || 'Add an action' ),
                    attributes.iconPosition === 'end' ? iconPreview : null
                )
            );
        },
        save: function() { return null; }
    } );

    registerBlockType( 'paksa/stat', {
        apiVersion: 3,
        title: 'Paksa Stat',
        description: 'A responsive metric card with an optional reduced-motion-safe counter.',
        category: 'paksa-components',
        icon: 'chart-bar',
        supports: {
            html: false,
            align: [ 'left', 'center', 'right' ],
            color: { text: true, background: true },
            spacing: { margin: true, padding: true }
        },
        attributes: {
            number: { type: 'number', default: 0 },
            prefix: { type: 'string', default: '' },
            suffix: { type: 'string', default: '' },
            label: { type: 'string', default: 'Add a metric label' },
            icon: { type: 'string', default: 'chart' },
            animate: { type: 'boolean', default: true }
        },
        edit: function( props ) {
            var attributes = props.attributes;
            var icons = iconData.icons || [];
            var options = icons.map( function( icon ) { return { label: icon.label, value: icon.value }; } );
            var selectedIcon = icons.filter( function( icon ) { return icon.value === attributes.icon; } )[ 0 ] || icons[ 0 ];
            var renderedNumber = ( attributes.prefix || '' ) + ( attributes.number || 0 ) + ( attributes.suffix || '' );

            return el(
                Fragment,
                {},
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        { title: 'Metric settings', initialOpen: true },
                        el( TextControl, {
                            label: 'Number',
                            type: 'number',
                            step: 'any',
                            value: attributes.number,
                            onChange: function( number ) { props.setAttributes( { number: Number( number ) || 0 } ); }
                        } ),
                        el( TextControl, {
                            label: 'Prefix',
                            value: attributes.prefix,
                            onChange: function( prefix ) { props.setAttributes( { prefix: prefix } ); }
                        } ),
                        el( TextControl, {
                            label: 'Suffix',
                            value: attributes.suffix,
                            onChange: function( suffix ) { props.setAttributes( { suffix: suffix } ); }
                        } ),
                        el( TextControl, {
                            label: 'Label',
                            value: attributes.label,
                            onChange: function( label ) { props.setAttributes( { label: label } ); }
                        } ),
                        el( ToggleControl, {
                            label: 'Animate when visible',
                            help: 'The final value remains visible when reduced motion is requested.',
                            checked: attributes.animate,
                            onChange: function( animate ) { props.setAttributes( { animate: animate } ); }
                        } )
                    ),
                    el(
                        PanelBody,
                        { title: 'Icon', initialOpen: false },
                        el( SelectControl, {
                            label: 'Icon',
                            value: attributes.icon,
                            options: options,
                            onChange: function( icon ) { props.setAttributes( { icon: icon } ); }
                        } )
                    )
                ),
                el(
                    'div',
                    { className: 'wp-block-paksa-stat pk-stat is-style-paksa-card-stat' },
                    selectedIcon ? el( 'span', { className: 'pk-stat__icon', 'aria-hidden': true, dangerouslySetInnerHTML: { __html: selectedIcon.svg } } ) : null,
                    el( 'div', { className: 'pk-stat__content' },
                        el( 'strong', { className: 'pk-stat__value' }, renderedNumber ),
                        el( 'span', { className: 'pk-stat__label' }, attributes.label || 'Add a metric label' )
                    )
                )
            );
        },
        save: function() { return null; }
    } );

    registerBlockType( 'paksa/breadcrumbs', {
        apiVersion: 3,
        title: 'Paksa Breadcrumbs',
        description: 'The existing context-aware trail for pages, posts, services, products, archives, and taxonomies.',
        category: 'paksa-components',
        icon: 'arrow-left-alt2',
        supports: {
            html: false,
            align: [ 'wide', 'full' ],
            color: { text: true, background: true },
            spacing: { margin: true, padding: true }
        },
        edit: function( props ) {
            if ( ServerSideRender ) {
                return el( ServerSideRender, { block: 'paksa/breadcrumbs', attributes: props.attributes } );
            }
            return el( 'nav', { className: 'wp-block-paksa-breadcrumbs pk-site-editor-breadcrumbs', 'aria-label': 'Breadcrumb preview' },
                el( 'ol', { className: 'pk-breadcrumbs-list' },
                    el( 'li', {}, 'Home' ),
                    el( 'li', { className: 'pk-breadcrumb-sep', 'aria-hidden': true }, '/' ),
                    el( 'li', { 'aria-current': 'page' }, 'Current content' )
                )
            );
        },
        save: function() { return null; }
    } );

    registerBlockType( 'paksa/related-content', {
        apiVersion: 3,
        title: 'Paksa Related Content',
        description: 'Shows only the relationships already selected for the current Product or Service.',
        category: 'paksa-components',
        icon: 'networking',
        supports: {
            html: false,
            align: [ 'wide', 'full' ],
            color: { text: true, background: true },
            spacing: { margin: true, padding: true }
        },
        attributes: {
            eyebrow: { type: 'string', default: '' },
            heading: { type: 'string', default: '' },
            description: { type: 'string', default: '' },
            limit: { type: 'number', default: 6 }
        },
        edit: function( props ) {
            var attributes = props.attributes;
            var preview = ServerSideRender ? el( ServerSideRender, { block: 'paksa/related-content', attributes: attributes } ) : el(
                'div',
                { className: 'pk-editor-related-content-preview' },
                el( 'strong', {}, attributes.heading || 'Related Content' ),
                el( 'p', {}, 'This block displays relationships selected on the current Product or Service.' )
            );

            return el(
                Fragment,
                {},
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        { title: 'Related content settings', initialOpen: true },
                        el( TextControl, {
                            label: 'Eyebrow',
                            help: 'Leave empty to use the appropriate Product or Service label.',
                            value: attributes.eyebrow,
                            onChange: function( eyebrow ) { props.setAttributes( { eyebrow: eyebrow } ); }
                        } ),
                        el( TextControl, {
                            label: 'Heading',
                            help: 'Leave empty to use the appropriate Product or Service heading.',
                            value: attributes.heading,
                            onChange: function( heading ) { props.setAttributes( { heading: heading } ); }
                        } ),
                        el( TextControl, {
                            label: 'Supporting text',
                            value: attributes.description,
                            onChange: function( description ) { props.setAttributes( { description: description } ); }
                        } ),
                        el( RangeControl, {
                            label: 'Maximum items',
                            value: attributes.limit,
                            min: 1,
                            max: 12,
                            onChange: function( limit ) { props.setAttributes( { limit: limit } ); }
                        } )
                    )
                ),
                el(
                    'div',
                    { className: 'pk-editor-related-content' },
                    preview,
                    el( 'p', { className: 'pk-editor-related-content__help' }, 'Set relationships in the Product or Service editor; this block never fills the grid with unrelated posts.' )
                )
            );
        },
        save: function() { return null; }
    } );
} )( window.wp );

/* ============================================================
   Phase 17 — paksa/section, paksa/testimonial, paksa/cta editors
   ============================================================ */
( function( wp ) {
    if ( ! wp || ! wp.blocks || ! wp.element || ! wp.blockEditor || ! wp.components ) {
        return;
    }

    var el = wp.element.createElement;
    var Fragment = wp.element.Fragment;
    var registerBlockType = wp.blocks.registerBlockType;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var InnerBlocks = wp.blockEditor.InnerBlocks;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var PanelBody = wp.components.PanelBody;
    var SelectControl = wp.components.SelectControl;
    var RangeControl = wp.components.RangeControl;
    var TextControl = wp.components.TextControl;
    var TextareaControl = wp.components.TextareaControl;
    var ToggleControl = wp.components.ToggleControl;
    var ServerSideRender = wp.serverSideRender;

    /* ── Additional block variations (Phase 17) ─────────────────────────── */
    if ( wp.blocks.registerBlockVariation ) {
        [
            {
                block: 'core/group',
                name: 'paksa-section-dark',
                title: 'Paksa Dark Section',
                description: 'A full-width dark background section.',
                attributes: { align: 'full', className: 'pk-section pk-section--dark', layout: { type: 'constrained' } }
            },
            {
                block: 'core/group',
                name: 'paksa-section-alt',
                title: 'Paksa Alt Section',
                description: 'A full-width section with alternate background.',
                attributes: { align: 'full', className: 'pk-section pk-section--alt', layout: { type: 'constrained' } }
            },
            {
                block: 'core/group',
                name: 'paksa-section-gradient',
                title: 'Paksa Gradient Section',
                description: 'A full-width section with gradient background.',
                attributes: { align: 'full', className: 'pk-section pk-section--gradient', layout: { type: 'constrained' } }
            },
            {
                block: 'core/columns',
                name: 'paksa-two-col',
                title: 'Paksa 2-Column',
                description: 'A responsive 2-column layout.',
                attributes: { className: 'is-style-paksa-grid-2', layout: { type: 'flex', flexWrap: 'wrap' } }
            },
            {
                block: 'core/columns',
                name: 'paksa-three-col',
                title: 'Paksa 3-Column',
                description: 'A responsive 3-column card grid.',
                attributes: { className: 'is-style-paksa-grid-3', layout: { type: 'flex', flexWrap: 'wrap' } }
            },
            {
                block: 'core/columns',
                name: 'paksa-four-col',
                title: 'Paksa 4-Column',
                description: 'A responsive 4-column grid.',
                attributes: { className: 'is-style-paksa-grid-4', layout: { type: 'flex', flexWrap: 'wrap' } }
            },
            {
                block: 'core/columns',
                name: 'paksa-sidebar-left',
                title: 'Paksa Sidebar Left',
                description: 'Narrow sidebar on the left, wide content on the right.',
                attributes: { className: 'is-style-paksa-sidebar-left', verticalAlignment: 'top' }
            },
            {
                block: 'core/columns',
                name: 'paksa-sidebar-right',
                title: 'Paksa Sidebar Right',
                description: 'Wide content on the left, narrow sidebar on the right.',
                attributes: { className: 'is-style-paksa-sidebar-right', verticalAlignment: 'top' }
            }
        ].forEach( function( variation ) {
            wp.blocks.registerBlockVariation( variation.block, {
                name: variation.name,
                title: variation.title,
                description: variation.description,
                attributes: variation.attributes,
                scope: [ 'inserter' ]
            } );
        } );
    }

    /* ── paksa/section ──────────────────────────────────────────────────── */
    registerBlockType( 'paksa/section', {
        apiVersion: 3,
        title: 'Paksa Section',
        description: 'A full-width section container with background, spacing, and animation controls.',
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
            containerWidth:  { type: 'string',  default: 'default' },
            textAlign:       { type: 'string',  default: 'left' }
        },
        edit: function( props ) {
            var attributes = props.attributes;
            var blockProps = useBlockProps ? useBlockProps( {
                className: 'pk-section pk-section--' + attributes.variant
            } ) : { className: 'wp-block-paksa-section pk-section pk-section--' + attributes.variant };

            return el(
                Fragment, {},
                el( InspectorControls, {},
                    el( PanelBody, { title: 'Section', initialOpen: true },
                        el( SelectControl, {
                            label: 'Background variant',
                            value: attributes.variant,
                            options: [
                                { label: 'Default (white)', value: 'default' },
                                { label: 'Alt (light gray)', value: 'alt' },
                                { label: 'Dark', value: 'dark' },
                                { label: 'Gradient', value: 'gradient' },
                                { label: 'Transparent', value: 'transparent' }
                            ],
                            onChange: function( v ) { props.setAttributes( { variant: v } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Container width',
                            value: attributes.containerWidth,
                            options: [
                                { label: 'Default (1200px)', value: 'default' },
                                { label: 'Narrow (720px)', value: 'narrow' },
                                { label: 'Wide (1440px)', value: 'wide' },
                                { label: 'Full bleed', value: 'full' }
                            ],
                            onChange: function( v ) { props.setAttributes( { containerWidth: v } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Text alignment',
                            value: attributes.textAlign,
                            options: [
                                { label: 'Left', value: 'left' },
                                { label: 'Center', value: 'center' },
                                { label: 'Right', value: 'right' }
                            ],
                            onChange: function( v ) { props.setAttributes( { textAlign: v } ); }
                        } )
                    ),
                    el( PanelBody, { title: 'Animation', initialOpen: false },
                        el( SelectControl, {
                            label: 'Entrance animation',
                            value: attributes.animation,
                            options: [
                                { label: 'None', value: 'none' },
                                { label: 'Fade', value: 'fade' },
                                { label: 'Fade Up', value: 'fade-up' },
                                { label: 'Fade Down', value: 'fade-down' },
                                { label: 'Fade Left', value: 'fade-left' },
                                { label: 'Fade Right', value: 'fade-right' },
                                { label: 'Scale', value: 'scale' },
                                { label: 'Reveal', value: 'reveal' },
                                { label: 'Stagger children', value: 'stagger' }
                            ],
                            onChange: function( v ) { props.setAttributes( { animation: v } ); }
                        } ),
                        attributes.animation !== 'none' ? el( RangeControl, {
                            label: 'Delay (ms)',
                            value: attributes.animDelay,
                            min: 0,
                            max: 600,
                            step: 100,
                            onChange: function( v ) { props.setAttributes( { animDelay: v } ); }
                        } ) : null
                    )
                ),
                el( 'section', blockProps,
                    el( InnerBlocks, {
                        renderAppender: InnerBlocks.ButtonBlockAppender
                    } )
                )
            );
        },
        save: function() {
            return el( InnerBlocks.Content );
        }
    } );

    /* ── paksa/testimonial ──────────────────────────────────────────────── */
    registerBlockType( 'paksa/testimonial', {
        apiVersion: 3,
        title: 'Paksa Testimonial',
        description: 'An accessible testimonial card with quote, author, role, rating, and avatar.',
        category: 'paksa-components',
        icon: 'format-quote',
        supports: {
            html: false,
            align: [ 'left', 'center', 'right' ],
            color: { text: true, background: true },
            spacing: { margin: true, padding: true }
        },
        attributes: {
            quote:      { type: 'string',  default: '' },
            author:     { type: 'string',  default: '' },
            role:       { type: 'string',  default: '' },
            company:    { type: 'string',  default: '' },
            rating:     { type: 'number',  default: 5 },
            showRating: { type: 'boolean', default: false },
            avatarUrl:  { type: 'string',  default: '' },
            avatarAlt:  { type: 'string',  default: '' },
            variant:    { type: 'string',  default: 'default' }
        },
        edit: function( props ) {
            var a = props.attributes;
            var preview = ServerSideRender
                ? el( ServerSideRender, { block: 'paksa/testimonial', attributes: a } )
                : el( 'div', { className: 'pk-testimonial pk-testimonial--' + a.variant },
                    el( 'p', { style: { fontStyle: 'italic' } }, a.quote || 'Add a quote here.' ),
                    el( 'strong', {}, a.author || 'Author name' ),
                    a.role ? el( 'span', { style: { color: 'var(--pk-text-muted)', marginLeft: '4px' } }, ', ' + a.role ) : null
                  );

            return el(
                Fragment, {},
                el( InspectorControls, {},
                    el( PanelBody, { title: 'Quote', initialOpen: true },
                        el( TextareaControl, {
                            label: 'Quote',
                            value: a.quote,
                            onChange: function( v ) { props.setAttributes( { quote: v } ); }
                        } ),
                        el( TextControl, {
                            label: 'Author name',
                            value: a.author,
                            onChange: function( v ) { props.setAttributes( { author: v } ); }
                        } ),
                        el( TextControl, {
                            label: 'Role',
                            value: a.role,
                            onChange: function( v ) { props.setAttributes( { role: v } ); }
                        } ),
                        el( TextControl, {
                            label: 'Company',
                            value: a.company,
                            onChange: function( v ) { props.setAttributes( { company: v } ); }
                        } )
                    ),
                    el( PanelBody, { title: 'Appearance', initialOpen: false },
                        el( SelectControl, {
                            label: 'Style',
                            value: a.variant,
                            options: [
                                { label: 'Default', value: 'default' },
                                { label: 'Bordered', value: 'bordered' },
                                { label: 'Dark', value: 'dark' }
                            ],
                            onChange: function( v ) { props.setAttributes( { variant: v } ); }
                        } ),
                        el( ToggleControl, {
                            label: 'Show star rating',
                            checked: a.showRating,
                            onChange: function( v ) { props.setAttributes( { showRating: v } ); }
                        } ),
                        a.showRating ? el( RangeControl, {
                            label: 'Rating (stars)',
                            value: a.rating,
                            min: 1,
                            max: 5,
                            onChange: function( v ) { props.setAttributes( { rating: v } ); }
                        } ) : null
                    ),
                    el( PanelBody, { title: 'Avatar', initialOpen: false },
                        el( TextControl, {
                            label: 'Avatar image URL',
                            help: 'Paste a URL or use the Media Library.',
                            type: 'url',
                            value: a.avatarUrl,
                            onChange: function( v ) { props.setAttributes( { avatarUrl: v } ); }
                        } ),
                        el( TextControl, {
                            label: 'Avatar alt text',
                            value: a.avatarAlt,
                            onChange: function( v ) { props.setAttributes( { avatarAlt: v } ); }
                        } )
                    )
                ),
                el( 'div', { className: 'pk-editor-testimonial-preview' }, preview )
            );
        },
        save: function() { return null; }
    } );

    /* ── paksa/cta ──────────────────────────────────────────────────────── */
    registerBlockType( 'paksa/cta', {
        apiVersion: 3,
        title: 'Paksa CTA',
        description: 'A reusable call-to-action section with heading, description, variant, and layout controls.',
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
            eyebrow:       { type: 'string', default: '' },
            heading:       { type: 'string', default: '' },
            description:   { type: 'string', default: '' },
            variant:       { type: 'string', default: 'dark' },
            layout:        { type: 'string', default: 'centered' },
            primaryLabel:  { type: 'string', default: '' },
            primaryUrl:    { type: 'string', default: '' },
            secondaryLabel: { type: 'string', default: '' },
            secondaryUrl:   { type: 'string', default: '' }
        },
        edit: function( props ) {
            var a = props.attributes;
            var preview = ServerSideRender
                ? el( ServerSideRender, { block: 'paksa/cta', attributes: a } )
                : el( 'div', { className: 'pk-cta pk-cta--' + a.variant + ' pk-cta--' + a.layout },
                    el( 'div', { className: 'pk-cta__inner' },
                        el( 'div', { className: 'pk-cta__content' },
                            a.eyebrow ? el( 'span', { className: 'pk-cta__eyebrow pk-component-eyebrow' }, a.eyebrow ) : null,
                            el( 'h2', { className: 'pk-cta__heading' }, a.heading || 'Add a CTA heading' ),
                            a.description ? el( 'p', { className: 'pk-cta__description' }, a.description ) : null
                        ),
                        ( a.primaryLabel || a.secondaryLabel ) ? el( 'div', { className: 'pk-cta__actions' },
                            a.primaryLabel ? el( 'a', { className: 'pk-cta__btn pk-cta__btn--primary', href: '#' }, a.primaryLabel ) : null,
                            a.secondaryLabel ? el( 'a', { className: 'pk-cta__btn pk-cta__btn--secondary', href: '#' }, a.secondaryLabel ) : null
                        ) : null
                    )
                  );

            return el(
                Fragment, {},
                el( InspectorControls, {},
                    el( PanelBody, { title: 'Content', initialOpen: true },
                        el( TextControl, {
                            label: 'Eyebrow',
                            value: a.eyebrow,
                            onChange: function( v ) { props.setAttributes( { eyebrow: v } ); }
                        } ),
                        el( TextControl, {
                            label: 'Heading',
                            value: a.heading,
                            onChange: function( v ) { props.setAttributes( { heading: v } ); }
                        } ),
                        el( TextareaControl, {
                            label: 'Description',
                            value: a.description,
                            onChange: function( v ) { props.setAttributes( { description: v } ); }
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
                            onChange: function( v ) { props.setAttributes( { variant: v } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Layout',
                            value: a.layout,
                            options: [
                                { label: 'Centered', value: 'centered' },
                                { label: 'Split (text + buttons side by side)', value: 'split' },
                                { label: 'Left aligned', value: 'left' }
                            ],
                            onChange: function( v ) { props.setAttributes( { layout: v } ); }
                        } )
                    ),
                    el( PanelBody, { title: 'Buttons', initialOpen: false },
                        el( TextControl, {
                            label: 'Primary button label',
                            value: a.primaryLabel,
                            onChange: function( v ) { props.setAttributes( { primaryLabel: v } ); }
                        } ),
                        el( TextControl, {
                            label: 'Primary button URL',
                            type: 'url',
                            value: a.primaryUrl,
                            onChange: function( v ) { props.setAttributes( { primaryUrl: v } ); }
                        } ),
                        el( TextControl, {
                            label: 'Secondary button label',
                            value: a.secondaryLabel,
                            onChange: function( v ) { props.setAttributes( { secondaryLabel: v } ); }
                        } ),
                        el( TextControl, {
                            label: 'Secondary button URL',
                            type: 'url',
                            value: a.secondaryUrl,
                            onChange: function( v ) { props.setAttributes( { secondaryUrl: v } ); }
                        } )
                    )
                ),
                el( 'div', { className: 'pk-editor-cta-preview' }, preview )
            );
        },
        save: function() { return null; }
    } );

} )( window.wp );
