/* ============================================================
   Phase 30 — Inline Styling, Visual Controls & Advanced Canvas Editing
   v3.0.0

   IIFE 1: Shared helpers + block capability registry
   IIFE 2: Contextual style toolbar (BlockControls popovers)
   IIFE 3: Color + typography quick-controls (Inspector panels)
   IIFE 4: Background + border/shadow quick-controls
   IIFE 5: Hover state editor (Normal / Hover toggle)
   ============================================================ */

/* ── IIFE 1: Shared helpers + block capability registry ─────────────────── */
/* Defines window.paksaVisual — a shared namespace consumed by IIFEs 2–5.   */
/* No filters registered here. Pure utility.                                 */
( function( wp ) {
    'use strict';

    var p30 = window.paksaPhase30 || {};

    /* ── Style helpers ── */

    /* Read/write style.color.text and style.color.background */
    function readColor( attributes, prop ) {
        return ( attributes.style && attributes.style.color && attributes.style.color[ prop ] ) || '';
    }

    function writeColor( attributes, setAttributes, prop, value ) {
        var s = attributes.style || {};
        setAttributes( {
            style: Object.assign( {}, s, {
                color: Object.assign( {}, s.color || {}, { [ prop ]: value || undefined } )
            } )
        } );
    }

    /* Read/write style.typography.* */
    function readTypo( attributes, prop ) {
        return ( attributes.style && attributes.style.typography && attributes.style.typography[ prop ] ) || '';
    }

    function writeTypo( attributes, setAttributes, prop, value ) {
        var s = attributes.style || {};
        setAttributes( {
            style: Object.assign( {}, s, {
                typography: Object.assign( {}, s.typography || {}, { [ prop ]: value || undefined } )
            } )
        } );
    }

    /* Read/write style.spacing.padding */
    function readPadding( attributes ) {
        var sp = attributes.style && attributes.style.spacing && attributes.style.spacing.padding;
        return sp || {};
    }

    function writePaddingKey( attributes, setAttributes, key, value ) {
        var s  = attributes.style || {};
        var sp = s.spacing || {};
        var p  = sp.padding || {};
        setAttributes( {
            style: Object.assign( {}, s, {
                spacing: Object.assign( {}, sp, {
                    padding: Object.assign( {}, p, { [ key ]: value || undefined } )
                } )
            } )
        } );
    }

    /* Toggle a single is-style-* class, removing any other from the same group */
    function applyStyleClass( attributes, setAttributes, newClass, groupClasses ) {
        var cls = ( attributes.className || '' );
        // Remove all classes in the group
        ( groupClasses || [] ).forEach( function( c ) {
            if ( c ) cls = cls.replace( new RegExp( '\\b' + c.replace( /[.*+?^${}()|[\]\\]/g, '\\$&' ) + '\\b', 'g' ), '' );
        } );
        cls = cls.trim();
        if ( newClass ) cls = ( cls + ' ' + newClass ).trim();
        setAttributes( { className: cls } );
    }

    function currentStyleClass( attributes, groupClasses ) {
        var cls = attributes.className || '';
        return ( groupClasses || [] ).find( function( c ) { return c && cls.indexOf( c ) !== -1; } ) || '';
    }

    /* ── Block capability registry ──
       Defines which quick-control groups each block type supports.
       Only capabilities that map to real, persisted attributes are listed.   */
    var CAPS = {
        'core/heading': {
            color: true, typography: true, alignment: true, spacing: true
        },
        'core/paragraph': {
            color: true, typography: true, alignment: true, spacing: true
        },
        'core/button': {
            color: true, buttonStyle: true, radius: true, spacing: true
        },
        'core/buttons': {
            alignment: true, spacing: true
        },
        'core/image': {
            imageStyle: true, radius: true, shadow: true
        },
        'core/group': {
            color: true, groupStyle: true, border: true, shadow: true,
            spacing: true, hover: true
        },
        'core/columns': {
            color: true, border: true, shadow: true, spacing: true
        },
        'core/column': {
            color: true, border: true, spacing: true
        },
        'core/cover': {
            color: true, spacing: true
        },
        'core/list': {
            color: true, typography: true, spacing: true
        },
        'paksa/section': {
            color: true, background: true, border: true, shadow: true,
            spacing: true, hover: true, animation: true
        },
        'paksa/testimonial': {
            border: true, shadow: true, hover: true
        },
        'paksa/cta': {
            border: true, shadow: true, background: true
        },
        'paksa/product-card': {
            shadow: true, hover: true
        },
        'paksa/service-card': {
            shadow: true, hover: true
        },
    };

    function hasCap( blockName, cap ) {
        return !! ( CAPS[ blockName ] && CAPS[ blockName ][ cap ] );
    }

    /* Expose shared namespace */
    window.paksaVisual = {
        p30:              p30,
        CAPS:             CAPS,
        hasCap:           hasCap,
        readColor:        readColor,
        writeColor:       writeColor,
        readTypo:         readTypo,
        writeTypo:        writeTypo,
        readPadding:      readPadding,
        writePaddingKey:  writePaddingKey,
        applyStyleClass:  applyStyleClass,
        currentStyleClass: currentStyleClass,
    };

} )( window.wp );

/* ── IIFE 2: Contextual style toolbar ───────────────────────────────────── */
/* Adds compact BlockControls popovers for supported blocks.                 */
/* Each popover exposes only the capabilities registered in CAPS.            */
/* All changes write to real Gutenberg attributes — nothing is editor-only.  */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;
    if ( ! window.paksaVisual ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var useState       = wp.element.useState;
    var useRef         = wp.element.useRef;
    var useEffect      = wp.element.useEffect;
    var BlockControls  = wp.blockEditor.BlockControls;
    var ToolbarGroup   = wp.components.ToolbarGroup;
    var ToolbarButton  = wp.components.ToolbarButton;
    var Popover        = wp.components.Popover;
    var ColorPicker    = wp.components.ColorPicker;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var pv  = window.paksaVisual;
    var p30 = pv.p30;

    /* ── Shared popover wrapper ── */
    function StylePopover( props ) {
        var title    = props.title;
        var children = props.children;
        var onClose  = props.onClose;
        var ref      = useRef( null );

        useEffect( function() {
            function handleKey( e ) {
                if ( e.key === 'Escape' ) onClose();
            }
            document.addEventListener( 'keydown', handleKey );
            return function() { document.removeEventListener( 'keydown', handleKey ); };
        }, [ onClose ] );

        return el( Popover, {
            className: 'pk-style-popover',
            onClose: onClose,
            focusOnMount: 'container',
            placement: 'bottom-start',
        },
            el( 'div', { className: 'pk-style-popover__inner', ref: ref },
                el( 'div', { className: 'pk-style-popover__header' },
                    el( 'span', { className: 'pk-style-popover__title' }, title ),
                    el( 'button', {
                        className: 'pk-style-popover__close',
                        onClick: onClose,
                        'aria-label': 'Close ' + title + ' panel',
                        title: 'Close'
                    }, '✕' )
                ),
                el( 'div', { className: 'pk-style-popover__body' }, children )
            )
        );
    }

    /* ── Color swatch grid ── */
    function ColorSwatches( props ) {
        var value    = props.value;
        var onChange = props.onChange;
        var label    = props.label;
        var palette  = p30.palette || [];

        return el( 'div', { className: 'pk-color-swatches' },
            el( 'p', { className: 'pk-ctrl-label' }, label ),
            el( 'div', { className: 'pk-color-swatches__grid' },
                palette.map( function( c ) {
                    var isActive = value === c.color || value === 'var(--wp--preset--color--' + c.slug + ')';
                    return el( 'button', {
                        key: c.slug,
                        className: 'pk-swatch' + ( isActive ? ' is-active' : '' ),
                        style: { background: c.color },
                        onClick: function() { onChange( 'var(--wp--preset--color--' + c.slug + ')' ); },
                        title: c.name,
                        'aria-label': c.name + ( isActive ? ' (active)' : '' ),
                        'aria-pressed': isActive
                    } );
                } ),
                /* Reset */
                el( 'button', {
                    className: 'pk-swatch pk-swatch--reset' + ( ! value ? ' is-active' : '' ),
                    onClick: function() { onChange( '' ); },
                    title: 'Reset color',
                    'aria-label': 'Reset color'
                }, '✕' )
            )
        );
    }

    /* ── Gradient swatches ── */
    function GradientSwatches( props ) {
        var value    = props.value;
        var onChange = props.onChange;
        var gradients = p30.gradients || [];

        return el( 'div', { className: 'pk-gradient-swatches' },
            el( 'p', { className: 'pk-ctrl-label' }, 'Gradient' ),
            el( 'div', { className: 'pk-gradient-swatches__grid' },
                gradients.map( function( g ) {
                    var isActive = value === g.gradient || value === 'var(--wp--preset--gradient--' + g.slug + ')';
                    return el( 'button', {
                        key: g.slug,
                        className: 'pk-gradient-swatch' + ( isActive ? ' is-active' : '' ),
                        style: { background: g.gradient },
                        onClick: function() { onChange( g.gradient ); },
                        title: g.name,
                        'aria-label': g.name,
                        'aria-pressed': isActive
                    } );
                } ),
                el( 'button', {
                    className: 'pk-gradient-swatch pk-gradient-swatch--reset' + ( ! value ? ' is-active' : '' ),
                    onClick: function() { onChange( '' ); },
                    title: 'No gradient',
                    'aria-label': 'Remove gradient'
                }, '✕' )
            )
        );
    }

    /* ── Style chip row ── */
    function StyleChips( props ) {
        var options  = props.options;
        var value    = props.value;
        var onChange = props.onChange;
        var label    = props.label;

        return el( 'div', { className: 'pk-style-chips' },
            label ? el( 'p', { className: 'pk-ctrl-label' }, label ) : null,
            el( 'div', { className: 'pk-style-chips__row' },
                options.map( function( o ) {
                    return el( 'button', {
                        key: o.value,
                        className: 'pk-chip' + ( value === o.value ? ' is-active' : '' ),
                        onClick: function() { onChange( o.value ); },
                        'aria-pressed': value === o.value,
                        title: o.label
                    }, o.label );
                } )
            )
        );
    }

    /* ── Color popover content ── */
    function ColorPopoverContent( props ) {
        var a   = props.attributes;
        var set = props.setAttributes;

        var textColor = pv.readColor( a, 'text' );
        var bgColor   = pv.readColor( a, 'background' );
        var bgGrad    = ( a.style && a.style.color && a.style.color.gradient ) || '';

        return el( Fragment, {},
            el( ColorSwatches, {
                label: 'Text Color',
                value: textColor,
                onChange: function( v ) { pv.writeColor( a, set, 'text', v ); }
            } ),
            el( ColorSwatches, {
                label: 'Background Color',
                value: bgColor,
                onChange: function( v ) { pv.writeColor( a, set, 'background', v ); }
            } ),
            el( GradientSwatches, {
                value: bgGrad,
                onChange: function( v ) {
                    var s = a.style || {};
                    set( { style: Object.assign( {}, s, {
                        color: Object.assign( {}, s.color || {}, { gradient: v || undefined } )
                    } ) } );
                }
            } )
        );
    }

    /* ── Typography popover content ── */
    function TypoPopoverContent( props ) {
        var a   = props.attributes;
        var set = props.setAttributes;

        var fontWeight    = pv.readTypo( a, 'fontWeight' );
        var textTransform = pv.readTypo( a, 'textTransform' );
        var letterSpacing = pv.readTypo( a, 'letterSpacing' );

        var weights    = p30.fontWeights    || [];
        var transforms = p30.textTransforms || [];

        return el( Fragment, {},
            el( StyleChips, {
                label: 'Weight',
                options: weights,
                value: fontWeight,
                onChange: function( v ) { pv.writeTypo( a, set, 'fontWeight', v ); }
            } ),
            el( StyleChips, {
                label: 'Transform',
                options: transforms,
                value: textTransform,
                onChange: function( v ) { pv.writeTypo( a, set, 'textTransform', v ); }
            } ),
            el( 'div', { className: 'pk-ctrl-row' },
                el( 'label', { className: 'pk-ctrl-label', htmlFor: 'pk-letter-spacing' }, 'Letter Spacing' ),
                el( 'input', {
                    id: 'pk-letter-spacing',
                    type: 'text',
                    className: 'pk-ctrl-input',
                    value: letterSpacing,
                    placeholder: 'e.g. 0.05em',
                    onChange: function( e ) { pv.writeTypo( a, set, 'letterSpacing', e.target.value ); }
                } )
            )
        );
    }

    /* ── Alignment popover content ── */
    function AlignPopoverContent( props ) {
        var a   = props.attributes;
        var set = props.setAttributes;
        var cur = a.textAlign || '';

        var options = [
            { label: '⬅ Left',   value: 'left' },
            { label: '↔ Center', value: 'center' },
            { label: '➡ Right',  value: 'right' },
        ];

        return el( StyleChips, {
            label: 'Text Alignment',
            options: options,
            value: cur,
            onChange: function( v ) { set( { textAlign: v === cur ? '' : v } ); }
        } );
    }

    /* ── Button style popover ── */
    function ButtonStyleContent( props ) {
        var a   = props.attributes;
        var set = props.setAttributes;

        var btnStyles  = p30.buttonStyles  || [];
        var radPresets = p30.radiusPresets || [];
        var groupClasses = btnStyles.map( function( s ) { return s.value; } );
        var curStyle   = pv.currentStyleClass( a, groupClasses );

        var curRadius = ( a.style && a.style.border && a.style.border.radius ) || '';

        return el( Fragment, {},
            el( StyleChips, {
                label: 'Button Style',
                options: btnStyles,
                value: curStyle,
                onChange: function( v ) { pv.applyStyleClass( a, set, v, groupClasses ); }
            } ),
            el( StyleChips, {
                label: 'Radius',
                options: radPresets,
                value: curRadius,
                onChange: function( v ) {
                    var s = a.style || {};
                    set( { style: Object.assign( {}, s, {
                        border: Object.assign( {}, s.border || {}, { radius: v || undefined } )
                    } ) } );
                }
            } ),
            el( ColorSwatches, {
                label: 'Text Color',
                value: pv.readColor( a, 'text' ),
                onChange: function( v ) { pv.writeColor( a, set, 'text', v ); }
            } ),
            el( ColorSwatches, {
                label: 'Background',
                value: pv.readColor( a, 'background' ),
                onChange: function( v ) { pv.writeColor( a, set, 'background', v ); }
            } )
        );
    }

    /* ── Image style popover ── */
    function ImageStyleContent( props ) {
        var a   = props.attributes;
        var set = props.setAttributes;

        var imgStyles  = p30.imageStyles   || [];
        var radPresets = p30.radiusPresets || [];
        var shadowPres = p30.shadowPresets || [];
        var groupClasses = imgStyles.map( function( s ) { return s.value; } );
        var curStyle   = pv.currentStyleClass( a, groupClasses );

        var curRadius = ( a.style && a.style.border && a.style.border.radius ) || '';
        var curShadow = ( a.style && a.style.shadow ) || '';

        return el( Fragment, {},
            el( StyleChips, {
                label: 'Image Style',
                options: imgStyles,
                value: curStyle,
                onChange: function( v ) { pv.applyStyleClass( a, set, v, groupClasses ); }
            } ),
            el( StyleChips, {
                label: 'Radius',
                options: radPresets,
                value: curRadius,
                onChange: function( v ) {
                    var s = a.style || {};
                    set( { style: Object.assign( {}, s, {
                        border: Object.assign( {}, s.border || {}, { radius: v || undefined } )
                    } ) } );
                }
            } ),
            el( StyleChips, {
                label: 'Shadow',
                options: shadowPres,
                value: curShadow,
                onChange: function( v ) {
                    var s = a.style || {};
                    set( { style: Object.assign( {}, s, { shadow: v || undefined } ) } );
                }
            } )
        );
    }

    /* ── Group style popover ── */
    function GroupStyleContent( props ) {
        var a   = props.attributes;
        var set = props.setAttributes;

        var groupStyles = p30.groupStyles  || [];
        var radPresets  = p30.radiusPresets || [];
        var shadowPres  = p30.shadowPresets || [];
        var groupClasses = groupStyles.map( function( s ) { return s.value; } );
        var curStyle    = pv.currentStyleClass( a, groupClasses );

        var curRadius = ( a.style && a.style.border && a.style.border.radius ) || '';
        var curShadow = ( a.style && a.style.shadow ) || '';

        return el( Fragment, {},
            el( StyleChips, {
                label: 'Container Style',
                options: groupStyles,
                value: curStyle,
                onChange: function( v ) { pv.applyStyleClass( a, set, v, groupClasses ); }
            } ),
            el( StyleChips, {
                label: 'Radius',
                options: radPresets,
                value: curRadius,
                onChange: function( v ) {
                    var s = a.style || {};
                    set( { style: Object.assign( {}, s, {
                        border: Object.assign( {}, s.border || {}, { radius: v || undefined } )
                    } ) } );
                }
            } ),
            el( StyleChips, {
                label: 'Shadow',
                options: shadowPres,
                value: curShadow,
                onChange: function( v ) {
                    var s = a.style || {};
                    set( { style: Object.assign( {}, s, { shadow: v || undefined } ) } );
                }
            } ),
            el( ColorSwatches, {
                label: 'Background',
                value: pv.readColor( a, 'background' ),
                onChange: function( v ) { pv.writeColor( a, set, 'background', v ); }
            } )
        );
    }

    /* ── Main HOC ── */
    var withContextualToolbar = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            var name = props.name;
            var a    = props.attributes;
            var set  = props.setAttributes;

            // Only act on blocks that have at least one capability
            if ( ! window.paksaVisual.CAPS[ name ] ) return el( BlockEdit, props );

            var caps = window.paksaVisual.CAPS[ name ];

            var openState = useState( null );
            var openPanel = openState[0];
            var setOpen   = openState[1];

            function toggle( panel ) {
                setOpen( openPanel === panel ? null : panel );
            }

            function close() { setOpen( null ); }

            /* Build toolbar buttons based on capabilities */
            var buttons = [];

            if ( caps.color ) {
                buttons.push( el( ToolbarButton, {
                    key: 'color',
                    label: 'Color',
                    icon: 'art',
                    isActive: openPanel === 'color',
                    onClick: function() { toggle( 'color' ); },
                    className: 'pk-tb-btn'
                } ) );
            }

            if ( caps.typography ) {
                buttons.push( el( ToolbarButton, {
                    key: 'typo',
                    label: 'Typography',
                    icon: 'editor-textcolor',
                    isActive: openPanel === 'typo',
                    onClick: function() { toggle( 'typo' ); },
                    className: 'pk-tb-btn'
                } ) );
            }

            if ( caps.alignment ) {
                buttons.push( el( ToolbarButton, {
                    key: 'align',
                    label: 'Alignment',
                    icon: 'editor-alignleft',
                    isActive: openPanel === 'align',
                    onClick: function() { toggle( 'align' ); },
                    className: 'pk-tb-btn'
                } ) );
            }

            if ( caps.buttonStyle ) {
                buttons.push( el( ToolbarButton, {
                    key: 'btnstyle',
                    label: 'Button Style',
                    icon: 'button',
                    isActive: openPanel === 'btnstyle',
                    onClick: function() { toggle( 'btnstyle' ); },
                    className: 'pk-tb-btn'
                } ) );
            }

            if ( caps.imageStyle ) {
                buttons.push( el( ToolbarButton, {
                    key: 'imgstyle',
                    label: 'Image Style',
                    icon: 'format-image',
                    isActive: openPanel === 'imgstyle',
                    onClick: function() { toggle( 'imgstyle' ); },
                    className: 'pk-tb-btn'
                } ) );
            }

            if ( caps.groupStyle ) {
                buttons.push( el( ToolbarButton, {
                    key: 'grpstyle',
                    label: 'Style',
                    icon: 'admin-appearance',
                    isActive: openPanel === 'grpstyle',
                    onClick: function() { toggle( 'grpstyle' ); },
                    className: 'pk-tb-btn'
                } ) );
            }

            if ( buttons.length === 0 ) return el( BlockEdit, props );

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( BlockControls, { group: 'other' },
                    el( ToolbarGroup, {},
                        buttons,

                        /* Popovers rendered inside the toolbar group */
                        openPanel === 'color' ? el( StylePopover, {
                            title: 'Color',
                            onClose: close
                        }, el( ColorPopoverContent, { attributes: a, setAttributes: set } ) ) : null,

                        openPanel === 'typo' ? el( StylePopover, {
                            title: 'Typography',
                            onClose: close
                        }, el( TypoPopoverContent, { attributes: a, setAttributes: set } ) ) : null,

                        openPanel === 'align' ? el( StylePopover, {
                            title: 'Alignment',
                            onClose: close
                        }, el( AlignPopoverContent, { attributes: a, setAttributes: set } ) ) : null,

                        openPanel === 'btnstyle' ? el( StylePopover, {
                            title: 'Button Style',
                            onClose: close
                        }, el( ButtonStyleContent, { attributes: a, setAttributes: set } ) ) : null,

                        openPanel === 'imgstyle' ? el( StylePopover, {
                            title: 'Image Style',
                            onClose: close
                        }, el( ImageStyleContent, { attributes: a, setAttributes: set } ) ) : null,

                        openPanel === 'grpstyle' ? el( StylePopover, {
                            title: 'Container Style',
                            onClose: close
                        }, el( GroupStyleContent, { attributes: a, setAttributes: set } ) ) : null
                    )
                )
            );
        };
    }, 'withPaksaContextualToolbar' );

    addFilter( 'editor.BlockEdit', 'paksa/contextual-toolbar', withContextualToolbar, 15 );

} )( window.wp );

/* ── IIFE 3: Color + typography quick-controls (Inspector panels) ────────── */
/* Adds compact "Quick Style" Inspector panels for heading, paragraph, list.  */
/* Uses native style.color.* and style.typography.* — no custom attributes.  */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;
    if ( ! window.paksaVisual ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var SelectControl  = wp.components.SelectControl;
    var TextControl    = wp.components.TextControl;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var pv  = window.paksaVisual;
    var p30 = pv.p30;

    var TYPO_BLOCKS = [ 'core/heading', 'core/paragraph', 'core/list' ];

    /* Palette as SelectControl options */
    function paletteOptions( includeEmpty ) {
        var opts = includeEmpty ? [ { label: '— None —', value: '' } ] : [];
        ( p30.palette || [] ).forEach( function( c ) {
            opts.push( { label: c.name, value: 'var(--wp--preset--color--' + c.slug + ')' } );
        } );
        return opts;
    }

    var withQuickTypo = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( TYPO_BLOCKS.indexOf( props.name ) === -1 ) return el( BlockEdit, props );

            var a   = props.attributes;
            var set = props.setAttributes;

            var textColor  = pv.readColor( a, 'text' );
            var fontWeight = pv.readTypo( a, 'fontWeight' );
            var textTrans  = pv.readTypo( a, 'textTransform' );
            var letterSp   = pv.readTypo( a, 'letterSpacing' );
            var lineHeight = pv.readTypo( a, 'lineHeight' );

            var weightOpts = [ { label: '— Default —', value: '' } ].concat(
                ( p30.fontWeights || [] ).map( function( w ) { return { label: w.label, value: w.value }; } )
            );
            var transformOpts = [ { label: '— Default —', value: '' } ].concat(
                ( p30.textTransforms || [] ).map( function( t ) { return { label: t.label, value: t.value }; } )
            );

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {},
                    el( PanelBody, {
                        title: 'Quick Style',
                        initialOpen: false,
                        className: 'pk-quick-style-panel'
                    },
                        el( SelectControl, {
                            label: 'Text Color',
                            value: textColor,
                            options: paletteOptions( true ),
                            onChange: function( v ) { pv.writeColor( a, set, 'text', v ); }
                        } ),
                        el( SelectControl, {
                            label: 'Font Weight',
                            value: fontWeight,
                            options: weightOpts,
                            onChange: function( v ) { pv.writeTypo( a, set, 'fontWeight', v ); }
                        } ),
                        el( SelectControl, {
                            label: 'Text Transform',
                            value: textTrans,
                            options: transformOpts,
                            onChange: function( v ) { pv.writeTypo( a, set, 'textTransform', v ); }
                        } ),
                        el( TextControl, {
                            label: 'Letter Spacing',
                            help: 'e.g. 0.05em or 1px',
                            value: letterSp,
                            onChange: function( v ) { pv.writeTypo( a, set, 'letterSpacing', v ); }
                        } ),
                        el( TextControl, {
                            label: 'Line Height',
                            help: 'e.g. 1.5 or 2rem',
                            value: lineHeight,
                            onChange: function( v ) { pv.writeTypo( a, set, 'lineHeight', v ); }
                        } ),
                        /* Reset button */
                        el( 'button', {
                            className: 'pk-reset-btn',
                            onClick: function() {
                                pv.writeColor( a, set, 'text', '' );
                                pv.writeTypo( a, set, 'fontWeight', '' );
                                pv.writeTypo( a, set, 'textTransform', '' );
                                pv.writeTypo( a, set, 'letterSpacing', '' );
                                pv.writeTypo( a, set, 'lineHeight', '' );
                            },
                            type: 'button'
                        }, 'Reset Typography' )
                    )
                )
            );
        };
    }, 'withPaksaQuickTypo' );

    addFilter( 'editor.BlockEdit', 'paksa/quick-typo', withQuickTypo );

} )( window.wp );

/* ── IIFE 4: Background + border/shadow quick-controls ──────────────────── */
/* For paksa/section: uses existing bgColor, bgGradient, bgImageUrl,         */
/*   bgImagePosition, bgImageSize, bgOverlayColor, bgOverlayOpacity,         */
/*   borderWidth, borderStyle, borderColor, borderRadius, shadowPreset.      */
/* For core/group: uses native style.color.background + style.border.*       */
/*   + style.shadow + existing Phase 18 border/shadow attrs where present.   */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;
    if ( ! window.paksaVisual ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var SelectControl  = wp.components.SelectControl;
    var RangeControl   = wp.components.RangeControl;
    var TextControl    = wp.components.TextControl;
    var ToggleControl  = wp.components.ToggleControl;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var pv  = window.paksaVisual;
    var p30 = pv.p30;

    var BG_BLOCKS     = [ 'paksa/section', 'core/group', 'paksa/cta' ];
    var BORDER_BLOCKS = [ 'paksa/section', 'core/group', 'core/columns', 'core/column', 'paksa/testimonial', 'paksa/cta' ];

    /* Palette as SelectControl options */
    function paletteOpts() {
        return [ { label: '— None —', value: '' } ].concat(
            ( p30.palette || [] ).map( function( c ) {
                return { label: c.name, value: 'var(--wp--preset--color--' + c.slug + ')' };
            } )
        );
    }

    /* ── Background panel for paksa/section ── */
    function SectionBgPanel( props ) {
        var a   = props.attributes;
        var set = props.setAttributes;

        var bgPositions = [
            { label: 'Center',       value: 'center center' },
            { label: 'Top',          value: 'center top' },
            { label: 'Bottom',       value: 'center bottom' },
            { label: 'Left',         value: 'left center' },
            { label: 'Right',        value: 'right center' },
        ];
        var bgSizes = [
            { label: 'Cover',   value: 'cover' },
            { label: 'Contain', value: 'contain' },
            { label: 'Auto',    value: 'auto' },
        ];

        return el( PanelBody, {
            title: 'Background',
            initialOpen: false,
            className: 'pk-bg-panel'
        },
            /* Solid color */
            el( SelectControl, {
                label: 'Background Color',
                value: a.bgColor || '',
                options: paletteOpts(),
                onChange: function( v ) { set( { bgColor: v } ); }
            } ),

            /* Gradient */
            el( SelectControl, {
                label: 'Gradient',
                value: a.bgGradient || '',
                options: [ { label: '— None —', value: '' } ].concat(
                    ( p30.gradients || [] ).map( function( g ) {
                        return { label: g.name, value: g.gradient };
                    } )
                ),
                onChange: function( v ) { set( { bgGradient: v } ); }
            } ),

            /* Background image URL */
            el( TextControl, {
                label: 'Background Image URL',
                help: 'Paste a URL or use the Media Library.',
                value: a.bgImageUrl || '',
                onChange: function( v ) { set( { bgImageUrl: v } ); }
            } ),

            /* Position + size (only shown when image is set) */
            a.bgImageUrl ? el( Fragment, {},
                el( SelectControl, {
                    label: 'Image Position',
                    value: a.bgImagePosition || 'center center',
                    options: bgPositions,
                    onChange: function( v ) { set( { bgImagePosition: v } ); }
                } ),
                el( SelectControl, {
                    label: 'Image Size',
                    value: a.bgImageSize || 'cover',
                    options: bgSizes,
                    onChange: function( v ) { set( { bgImageSize: v } ); }
                } ),
                el( SelectControl, {
                    label: 'Overlay Color',
                    value: a.bgOverlayColor || '',
                    options: paletteOpts(),
                    onChange: function( v ) { set( { bgOverlayColor: v } ); }
                } ),
                el( RangeControl, {
                    label: 'Overlay Opacity',
                    value: a.bgOverlayOpacity !== undefined ? a.bgOverlayOpacity : 50,
                    min: 0, max: 100, step: 5,
                    onChange: function( v ) { set( { bgOverlayOpacity: v } ); }
                } )
            ) : null,

            /* Reset */
            el( 'button', {
                className: 'pk-reset-btn',
                type: 'button',
                onClick: function() {
                    set( { bgColor: '', bgGradient: '', bgImageUrl: '', bgOverlayColor: '', bgOverlayOpacity: 0 } );
                }
            }, 'Reset Background' )
        );
    }

    /* ── Background panel for core/group (native style.color.*) ── */
    function GroupBgPanel( props ) {
        var a   = props.attributes;
        var set = props.setAttributes;

        var bgColor = pv.readColor( a, 'background' );
        var bgGrad  = ( a.style && a.style.color && a.style.color.gradient ) || '';

        return el( PanelBody, {
            title: 'Background',
            initialOpen: false,
            className: 'pk-bg-panel'
        },
            el( SelectControl, {
                label: 'Background Color',
                value: bgColor,
                options: paletteOpts(),
                onChange: function( v ) { pv.writeColor( a, set, 'background', v ); }
            } ),
            el( SelectControl, {
                label: 'Gradient',
                value: bgGrad,
                options: [ { label: '— None —', value: '' } ].concat(
                    ( p30.gradients || [] ).map( function( g ) {
                        return { label: g.name, value: g.gradient };
                    } )
                ),
                onChange: function( v ) {
                    var s = a.style || {};
                    set( { style: Object.assign( {}, s, {
                        color: Object.assign( {}, s.color || {}, { gradient: v || undefined } )
                    } ) } );
                }
            } ),
            el( 'button', {
                className: 'pk-reset-btn',
                type: 'button',
                onClick: function() {
                    pv.writeColor( a, set, 'background', '' );
                    var s = a.style || {};
                    set( { style: Object.assign( {}, s, {
                        color: Object.assign( {}, s.color || {}, { gradient: undefined } )
                    } ) } );
                }
            }, 'Reset Background' )
        );
    }

    /* ── Border + shadow panel ── */
    /* paksa/section uses its own borderWidth/borderStyle/borderColor/borderRadius/shadowPreset attrs.
       core/group and others use native style.border.* and style.shadow.                              */
    function BorderShadowPanel( props ) {
        var a       = props.attributes;
        var set     = props.setAttributes;
        var isSection = props.isSection;

        var radPresets  = p30.radiusPresets || [];
        var shadowPres  = p30.shadowPresets || [];

        if ( isSection ) {
            /* paksa/section — uses Phase 17/18 custom attributes */
            var borderStyles = [
                { label: 'Solid',  value: 'solid' },
                { label: 'Dashed', value: 'dashed' },
                { label: 'Dotted', value: 'dotted' },
                { label: 'None',   value: 'none' },
            ];

            return el( PanelBody, {
                title: 'Border & Shadow',
                initialOpen: false,
                className: 'pk-border-panel'
            },
                el( TextControl, {
                    label: 'Border Width',
                    help: 'e.g. 1px or 2px',
                    value: a.borderWidth || '',
                    onChange: function( v ) { set( { borderWidth: v } ); }
                } ),
                el( SelectControl, {
                    label: 'Border Style',
                    value: a.borderStyle || 'solid',
                    options: borderStyles,
                    onChange: function( v ) { set( { borderStyle: v } ); }
                } ),
                el( SelectControl, {
                    label: 'Border Color',
                    value: a.borderColor || '',
                    options: paletteOpts(),
                    onChange: function( v ) { set( { borderColor: v } ); }
                } ),
                el( SelectControl, {
                    label: 'Border Radius',
                    value: a.borderRadius || '',
                    options: [ { label: '— None —', value: '' } ].concat(
                        radPresets.map( function( r ) { return { label: r.label, value: r.value }; } )
                    ),
                    onChange: function( v ) { set( { borderRadius: v } ); }
                } ),
                el( SelectControl, {
                    label: 'Shadow',
                    value: a.shadowPreset || 'none',
                    options: shadowPres.map( function( s ) { return { label: s.label, value: s.value }; } ),
                    onChange: function( v ) { set( { shadowPreset: v } ); }
                } ),
                el( 'button', {
                    className: 'pk-reset-btn',
                    type: 'button',
                    onClick: function() {
                        set( { borderWidth: '', borderStyle: 'solid', borderColor: '', borderRadius: '', shadowPreset: 'none' } );
                    }
                }, 'Reset Border & Shadow' )
            );
        }

        /* core/group, core/columns, core/column — native style.border.* */
        var curRadius = ( a.style && a.style.border && a.style.border.radius ) || '';
        var curShadow = ( a.style && a.style.shadow ) || '';

        return el( PanelBody, {
            title: 'Border & Shadow',
            initialOpen: false,
            className: 'pk-border-panel'
        },
            el( SelectControl, {
                label: 'Border Radius',
                value: curRadius,
                options: [ { label: '— None —', value: '' } ].concat(
                    radPresets.map( function( r ) { return { label: r.label, value: r.value }; } )
                ),
                onChange: function( v ) {
                    var s = a.style || {};
                    set( { style: Object.assign( {}, s, {
                        border: Object.assign( {}, s.border || {}, { radius: v || undefined } )
                    } ) } );
                }
            } ),
            el( SelectControl, {
                label: 'Shadow',
                value: curShadow,
                options: [ { label: '— None —', value: '' } ].concat(
                    shadowPres.map( function( s ) { return { label: s.label, value: s.value }; } )
                ),
                onChange: function( v ) {
                    var s = a.style || {};
                    set( { style: Object.assign( {}, s, { shadow: v || undefined } ) } );
                }
            } ),
            el( 'button', {
                className: 'pk-reset-btn',
                type: 'button',
                onClick: function() {
                    var s = a.style || {};
                    set( { style: Object.assign( {}, s, {
                        border: Object.assign( {}, s.border || {}, { radius: undefined } ),
                        shadow: undefined
                    } ) } );
                }
            }, 'Reset Border & Shadow' )
        );
    }

    var withBgBorder = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            var name = props.name;
            var a    = props.attributes;
            var set  = props.setAttributes;

            var hasBg     = BG_BLOCKS.indexOf( name ) !== -1;
            var hasBorder = BORDER_BLOCKS.indexOf( name ) !== -1;

            if ( ! hasBg && ! hasBorder ) return el( BlockEdit, props );

            var isSection = name === 'paksa/section' || name === 'paksa/cta';

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {},
                    hasBg && name === 'paksa/section'
                        ? el( SectionBgPanel, { attributes: a, setAttributes: set } )
                        : null,
                    hasBg && name === 'core/group'
                        ? el( GroupBgPanel, { attributes: a, setAttributes: set } )
                        : null,
                    hasBorder
                        ? el( BorderShadowPanel, { attributes: a, setAttributes: set, isSection: isSection } )
                        : null
                )
            );
        };
    }, 'withPaksaBgBorder' );

    addFilter( 'editor.BlockEdit', 'paksa/bg-border', withBgBorder );

} )( window.wp );

/* ── IIFE 5: Hover state editor ─────────────────────────────────────────── */
/* Adds a "Hover State" Inspector panel to blocks that carry                 */
/* paksa_hover_attributes(): hoverEffect, hoverShadow, hoverLift,           */
/* hoverBgColor, transition.                                                 */
/* Also adds a Normal/Hover preview toggle that applies a CSS class to the  */
/* block's wrapper in the editor only — no saved HTML is altered.           */
/* All attribute writes use the existing registered attributes.              */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;
    if ( ! window.paksaVisual ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var useState       = wp.element.useState;
    var useEffect      = wp.element.useEffect;
    var useRef         = wp.element.useRef;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var BlockControls  = wp.blockEditor.BlockControls;
    var PanelBody      = wp.components.PanelBody;
    var SelectControl  = wp.components.SelectControl;
    var ToggleControl  = wp.components.ToggleControl;
    var ToolbarGroup   = wp.components.ToolbarGroup;
    var ToolbarButton  = wp.components.ToolbarButton;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var pv  = window.paksaVisual;
    var p30 = pv.p30;

    /* Blocks that have paksa_hover_attributes() registered */
    var HOVER_BLOCKS = [
        'paksa/section',
        'core/group',
        'paksa/testimonial',
        'paksa/cta',
        'paksa/product-card',
        'paksa/service-card',
    ];

    /* Palette as SelectControl options */
    function paletteOpts() {
        return [ { label: '— None —', value: '' } ].concat(
            ( p30.palette || [] ).map( function( c ) {
                return { label: c.name, value: 'var(--wp--preset--color--' + c.slug + ')' };
            } )
        );
    }

    var withHoverEditor = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( HOVER_BLOCKS.indexOf( props.name ) === -1 ) return el( BlockEdit, props );

            var a   = props.attributes;
            var set = props.setAttributes;

            var hoverState = useState( 'normal' );
            var editState  = hoverState[0];
            var setEditState = hoverState[1];

            var isHoverPreview = editState === 'hover';

            var hoverEffects = p30.hoverEffects || [];
            var effectOpts   = [ { label: '— None —', value: 'none' } ].concat(
                hoverEffects.map( function( e ) { return { label: e.label, value: e.value }; } )
            );

            var transitionOpts = [
                { label: 'Base (250ms)', value: 'base' },
                { label: 'Fast (150ms)', value: 'fast' },
                { label: 'Slow (400ms)', value: 'slow' },
            ];

            /* Apply/remove editor-only hover preview class on the block DOM node.
               We target the block by clientId data attribute — editor-only, not saved. */
            useEffect( function() {
                var node = document.querySelector(
                    '[data-block="' + props.clientId + '"]'
                );
                if ( ! node ) return;
                if ( isHoverPreview ) {
                    node.classList.add( 'pk-hover-preview' );
                } else {
                    node.classList.remove( 'pk-hover-preview' );
                }
                return function() {
                    if ( node ) node.classList.remove( 'pk-hover-preview' );
                };
            }, [ isHoverPreview, props.clientId ] );

            return el( Fragment, {},
                el( BlockEdit, props ),

                /* Toolbar: Normal / Hover state toggle */
                el( BlockControls, { group: 'other' },
                    el( ToolbarGroup, {},
                        el( ToolbarButton, {
                            label: 'Normal state',
                            isActive: editState === 'normal',
                            onClick: function() { setEditState( 'normal' ); },
                            className: 'pk-state-btn pk-state-btn--normal'
                        }, 'Normal' ),
                        el( ToolbarButton, {
                            label: 'Hover state preview',
                            isActive: editState === 'hover',
                            onClick: function() { setEditState( editState === 'hover' ? 'normal' : 'hover' ); },
                            className: 'pk-state-btn pk-state-btn--hover'
                        }, 'Hover' )
                    )
                ),

                /* Inspector: Hover State panel */
                el( InspectorControls, {},
                    el( PanelBody, {
                        title: 'Hover State',
                        initialOpen: false,
                        className: 'pk-hover-panel'
                    },
                        el( 'div', { className: 'pk-hover-state-switcher' },
                            el( 'button', {
                                className: 'pk-state-chip' + ( editState === 'normal' ? ' is-active' : '' ),
                                onClick: function() { setEditState( 'normal' ); },
                                type: 'button',
                                'aria-pressed': editState === 'normal'
                            }, 'Normal' ),
                            el( 'button', {
                                className: 'pk-state-chip' + ( editState === 'hover' ? ' is-active' : '' ),
                                onClick: function() { setEditState( editState === 'hover' ? 'normal' : 'hover' ); },
                                type: 'button',
                                'aria-pressed': editState === 'hover'
                            }, 'Hover' )
                        ),

                        isHoverPreview
                            ? el( 'p', { className: 'pk-hover-preview-notice' },
                                '👁 Hover preview active — canvas shows approximate hover state.'
                              )
                            : null,

                        el( SelectControl, {
                            label: 'Hover Effect',
                            value: a.hoverEffect || 'none',
                            options: effectOpts,
                            onChange: function( v ) { set( { hoverEffect: v } ); }
                        } ),

                        el( ToggleControl, {
                            label: 'Hover Shadow',
                            help: 'Adds a shadow on hover.',
                            checked: !! a.hoverShadow,
                            onChange: function( v ) { set( { hoverShadow: v } ); }
                        } ),

                        el( ToggleControl, {
                            label: 'Hover Lift',
                            help: 'Translates the block upward on hover.',
                            checked: !! a.hoverLift,
                            onChange: function( v ) { set( { hoverLift: v } ); }
                        } ),

                        el( SelectControl, {
                            label: 'Hover Background',
                            value: a.hoverBgColor || '',
                            options: paletteOpts(),
                            onChange: function( v ) { set( { hoverBgColor: v } ); }
                        } ),

                        el( SelectControl, {
                            label: 'Transition Speed',
                            value: a.transition || 'base',
                            options: transitionOpts,
                            onChange: function( v ) { set( { transition: v } ); }
                        } ),

                        /* Reset hover */
                        el( 'button', {
                            className: 'pk-reset-btn',
                            type: 'button',
                            onClick: function() {
                                set( {
                                    hoverEffect:  'none',
                                    hoverShadow:  false,
                                    hoverLift:    false,
                                    hoverBgColor: '',
                                    transition:   'base',
                                } );
                                setEditState( 'normal' );
                            }
                        }, 'Reset Hover' )
                    )
                )
            );
        };
    }, 'withPaksaHoverEditor' );

    addFilter( 'editor.BlockEdit', 'paksa/hover-editor', withHoverEditor );

    /* Apply hover preview CSS class styles in the editor.
       The actual hover classes (pk-hover-lift, pk-hover-glow, etc.) already
       exist in blocks.css and are applied by the PHP render callback.
       The editor preview just forces the hover visual state via CSS.         */

} )( window.wp );
