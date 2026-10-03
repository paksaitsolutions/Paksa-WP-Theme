/* ============================================================
   Phase 26 — Visual Builder Interaction & Container System
   IIFE 1: Responsive Visibility panel on all supported blocks
   IIFE 2: Column width preset picker on core/column
   IIFE 3: Flexbox layout controls on core/group
   IIFE 4: Responsive column stacking — apply CSS classes on save
   IIFE 5: Section layout preset inserter toolbar button
   ============================================================ */

/* ── IIFE 1: Responsive Visibility panel ────────────────────────────────── */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var ToggleControl  = wp.components.ToggleControl;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var VISIBILITY_BLOCKS = [
        'core/group', 'core/column', 'core/columns',
        'core/image', 'core/cover', 'paksa/section',
        'core/heading', 'core/paragraph', 'core/buttons'
    ];

    var CLASS_MOBILE  = 'pk-hide-mobile';
    var CLASS_TABLET  = 'pk-hide-tablet';
    var CLASS_DESKTOP = 'pk-hide-desktop';

    function toggleClass( current, cls, add ) {
        var base = ( current || '' ).replace( new RegExp( '\\b' + cls + '\\b', 'g' ), '' ).trim();
        return add ? ( base + ' ' + cls ).trim() : base;
    }

    var withVisibility = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( VISIBILITY_BLOCKS.indexOf( props.name ) === -1 ) {
                return el( BlockEdit, props );
            }
            var a   = props.attributes;
            var set = props.setAttributes;
            var cls = a.className || '';

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {},
                    el( PanelBody, {
                        title: 'Responsive Visibility',
                        initialOpen: false,
                        className: 'pk-visibility-panel'
                    },
                        el( 'p', {
                            className: 'components-base-control__help',
                            style: { marginTop: 0, marginBottom: '12px' }
                        }, 'Choose which devices show this block.' ),
                        el( ToggleControl, {
                            label: 'Visible on Desktop',
                            checked: cls.indexOf( CLASS_DESKTOP ) === -1,
                            onChange: function( v ) {
                                set( { className: toggleClass( cls, CLASS_DESKTOP, ! v ) } );
                            }
                        } ),
                        el( ToggleControl, {
                            label: 'Visible on Tablet',
                            checked: cls.indexOf( CLASS_TABLET ) === -1,
                            onChange: function( v ) {
                                set( { className: toggleClass( cls, CLASS_TABLET, ! v ) } );
                            }
                        } ),
                        el( ToggleControl, {
                            label: 'Visible on Mobile',
                            checked: cls.indexOf( CLASS_MOBILE ) === -1,
                            onChange: function( v ) {
                                set( { className: toggleClass( cls, CLASS_MOBILE, ! v ) } );
                            }
                        } )
                    )
                )
            );
        };
    }, 'withPaksaVisibility' );

    addFilter( 'editor.BlockEdit', 'paksa/visibility-controls', withVisibility );

} )( window.wp );

/* ── IIFE 2: Column width preset picker on core/column ──────────────────── */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var Button         = wp.components.Button;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var p26Data  = window.paksaPhase26 || {};
    var presets  = p26Data.colPresets || [];

    var withColumnWidth = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( props.name !== 'core/column' ) return el( BlockEdit, props );
            var a   = props.attributes;
            var set = props.setAttributes;

            var currentWidth = a.width || '';

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {},
                    el( PanelBody, {
                        title: 'Column Width',
                        initialOpen: false,
                        className: 'pk-column-width-panel'
                    },
                        el( 'p', {
                            className: 'components-base-control__help',
                            style: { marginTop: 0, marginBottom: '8px' }
                        }, 'Quick width presets. Overrides the default equal-width behaviour.' ),
                        el( 'div', { className: 'pk-col-presets' },
                            presets.map( function( preset ) {
                                return el( Button, {
                                    key: preset.label,
                                    variant: currentWidth === preset.value ? 'primary' : 'secondary',
                                    isSmall: true,
                                    onClick: function() {
                                        set( { width: preset.value } );
                                    },
                                    style: { marginRight: '4px', marginBottom: '4px' }
                                }, preset.label );
                            } )
                        )
                    )
                )
            );
        };
    }, 'withPaksaColumnWidth' );

    addFilter( 'editor.BlockEdit', 'paksa/column-width', withColumnWidth );

} )( window.wp );

/* ── IIFE 3: Flexbox layout controls on core/group ──────────────────────── */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var SelectControl  = wp.components.SelectControl;
    var ToggleControl  = wp.components.ToggleControl;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var UnitControl = wp.components.__experimentalUnitControl || wp.components.UnitControl || null;
    var TextControl = wp.components.TextControl;

    function GapCtrl( props ) {
        if ( UnitControl ) {
            return el( UnitControl, {
                label: props.label,
                value: props.value || '',
                units: [ 'px', 'rem', '%' ].map( function( u ) { return { value: u, label: u }; } ),
                onChange: props.onChange,
                min: 0
            } );
        }
        return el( TextControl, {
            label: props.label,
            help: 'e.g. 1.5rem or 24px',
            value: props.value || '',
            onChange: props.onChange
        } );
    }

    var withFlexLayout = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( props.name !== 'core/group' ) return el( BlockEdit, props );
            var a   = props.attributes;
            var set = props.setAttributes;

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {},
                    el( PanelBody, {
                        title: 'Flex Layout',
                        initialOpen: false,
                        className: 'pk-flex-layout-panel'
                    },
                        el( SelectControl, {
                            label: 'Direction',
                            value: a.pkFlexDir || '',
                            options: [
                                { label: 'Default', value: '' },
                                { label: 'Row (horizontal)', value: 'row' },
                                { label: 'Column (vertical)', value: 'column' },
                                { label: 'Row reverse', value: 'row-reverse' }
                            ],
                            onChange: function( v ) { set( { pkFlexDir: v } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Justify content',
                            value: a.pkJustify || '',
                            options: [
                                { label: 'Default', value: '' },
                                { label: 'Start', value: 'flex-start' },
                                { label: 'Center', value: 'center' },
                                { label: 'End', value: 'flex-end' },
                                { label: 'Space between', value: 'space-between' },
                                { label: 'Space around', value: 'space-around' }
                            ],
                            onChange: function( v ) { set( { pkJustify: v } ); }
                        } ),
                        el( SelectControl, {
                            label: 'Align items',
                            value: a.pkAlignItems || '',
                            options: [
                                { label: 'Default', value: '' },
                                { label: 'Start', value: 'flex-start' },
                                { label: 'Center', value: 'center' },
                                { label: 'End', value: 'flex-end' },
                                { label: 'Stretch', value: 'stretch' },
                                { label: 'Baseline', value: 'baseline' }
                            ],
                            onChange: function( v ) { set( { pkAlignItems: v } ); }
                        } ),
                        el( ToggleControl, {
                            label: 'Wrap items',
                            checked: !! a.pkFlexWrap,
                            onChange: function( v ) { set( { pkFlexWrap: v } ); }
                        } ),
                        el( GapCtrl, {
                            label: 'Gap',
                            value: a.pkFlexGap || '',
                            onChange: function( v ) { set( { pkFlexGap: v || '' } ); }
                        } )
                    )
                )
            );
        };
    }, 'withPaksaFlexLayout' );

    addFilter( 'editor.BlockEdit', 'paksa/flex-layout', withFlexLayout );

    /* Persist flex attributes */
    addFilter( 'blocks.registerBlockType', 'paksa/flex-layout-attrs',
        function( settings, name ) {
            if ( name !== 'core/group' ) return settings;
            settings.attributes = Object.assign( {}, settings.attributes, {
                pkFlexDir:    { type: 'string',  default: '' },
                pkJustify:    { type: 'string',  default: '' },
                pkAlignItems: { type: 'string',  default: '' },
                pkFlexWrap:   { type: 'boolean', default: false },
                pkFlexGap:    { type: 'string',  default: '' }
            } );
            return settings;
        }
    );

    /* Apply flex attributes as inline style on save */
    addFilter( 'blocks.getSaveContent.extraProps', 'paksa/flex-layout-save',
        function( extraProps, blockType, attributes ) {
            if ( blockType.name !== 'core/group' ) return extraProps;
            var style = Object.assign( {}, extraProps.style || {} );
            var hasAny = attributes.pkFlexDir || attributes.pkJustify ||
                         attributes.pkAlignItems || attributes.pkFlexWrap || attributes.pkFlexGap;
            if ( ! hasAny ) return extraProps;
            style.display        = 'flex';
            if ( attributes.pkFlexDir )    style.flexDirection  = attributes.pkFlexDir;
            if ( attributes.pkJustify )    style.justifyContent = attributes.pkJustify;
            if ( attributes.pkAlignItems ) style.alignItems     = attributes.pkAlignItems;
            if ( attributes.pkFlexWrap )   style.flexWrap       = 'wrap';
            if ( attributes.pkFlexGap )    style.gap            = attributes.pkFlexGap;
            extraProps.style = style;
            return extraProps;
        }
    );

} )( window.wp );

/* ── IIFE 4: Responsive stacking — apply pk-stack-mobile class on save ───── */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks ) return;

    var addFilter = wp.hooks.addFilter;

    /* Phase 20 already adds pkStackMobile attribute to core/columns.
       This filter applies the CSS class to the saved output so it
       actually renders on the frontend. */
    addFilter( 'blocks.getSaveContent.extraProps', 'paksa/responsive-stack-save',
        function( extraProps, blockType, attributes ) {
            if ( blockType.name !== 'core/columns' ) return extraProps;
            if ( attributes.pkStackMobile === false ) return extraProps;
            var cls = ( extraProps.className || '' );
            if ( cls.indexOf( 'pk-stack-mobile' ) === -1 ) {
                extraProps.className = ( cls + ' pk-stack-mobile' ).trim();
            }
            return extraProps;
        }
    );

    /* Apply pkMobileCols / pkTabletCols as data attributes for CSS targeting */
    addFilter( 'blocks.getSaveContent.extraProps', 'paksa/responsive-cols-save',
        function( extraProps, blockType, attributes ) {
            if ( blockType.name !== 'core/columns' ) return extraProps;
            if ( attributes.pkMobileCols && attributes.pkMobileCols !== '1' ) {
                extraProps[ 'data-pk-mobile-cols' ] = attributes.pkMobileCols;
            }
            if ( attributes.pkTabletCols && attributes.pkTabletCols !== '2' ) {
                extraProps[ 'data-pk-tablet-cols' ] = attributes.pkTabletCols;
            }
            return extraProps;
        }
    );

} )( window.wp );

/* ── IIFE 5: Section layout preset toolbar on paksa/section ─────────────── */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var BlockControls  = wp.blockEditor.BlockControls;
    var useDispatch    = wp.data && wp.data.useDispatch;
    var useSelect      = wp.data && wp.data.useSelect;
    var ToolbarGroup   = wp.components.ToolbarGroup;
    var ToolbarButton  = wp.components.ToolbarButton;
    var Dropdown       = wp.components.Dropdown;
    var MenuGroup      = wp.components.MenuGroup;
    var MenuItem       = wp.components.MenuItem;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    if ( ! useDispatch || ! useSelect ) return;

    var p26Data = window.paksaPhase26 || {};
    var layouts = p26Data.layoutPresets || [];

    /* Map layout preset name to innerBlocks template */
    function buildColumnsBlock( preset ) {
        var cols = preset.cols || 2;
        var name = preset.name || '';

        // Split-ratio presets — use existing variation widths
        var widthMap = {
            'paksa-split-1-2': [ '33.33%', '66.66%' ],
            'paksa-split-2-1': [ '66.66%', '33.33%' ],
            'paksa-split-1-3': [ '25%', '75%' ],
            'paksa-split-3-1': [ '75%', '25%' ]
        };

        var colBlocks = [];
        if ( widthMap[ name ] ) {
            widthMap[ name ].forEach( function( w ) {
                colBlocks.push( [ 'core/column', { width: w }, [] ] );
            } );
        } else {
            for ( var i = 0; i < cols; i++ ) {
                colBlocks.push( [ 'core/column', {}, [] ] );
            }
        }

        var colAttrs = { className: '' };
        if ( widthMap[ name ] ) {
            colAttrs.className = 'is-style-' + name;
        }

        return [ 'core/columns', colAttrs, colBlocks ];
    }

    var withSectionLayoutToolbar = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( props.name !== 'paksa/section' ) return el( BlockEdit, props );

            var clientId   = props.clientId;
            var insertBlock = useDispatch( 'core/block-editor' ).insertBlock;
            var createBlock = wp.blocks && wp.blocks.createBlock;

            if ( ! createBlock || ! insertBlock ) return el( BlockEdit, props );

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( BlockControls, { group: 'other' },
                    el( ToolbarGroup, {},
                        el( Dropdown, {
                            renderToggle: function( ref ) {
                                return el( ToolbarButton, {
                                    icon: 'columns',
                                    label: 'Insert layout',
                                    onClick: ref.onToggle,
                                    isActive: ref.isOpen
                                } );
                            },
                            renderContent: function( ref ) {
                                return el( MenuGroup, { label: 'Choose a column layout' },
                                    layouts.map( function( preset ) {
                                        return el( MenuItem, {
                                            key: preset.name,
                                            onClick: function() {
                                                var blockDef = buildColumnsBlock( preset );
                                                var block = createBlock( blockDef[0], blockDef[1],
                                                    ( blockDef[2] || [] ).map( function( c ) {
                                                        return createBlock( c[0], c[1], [] );
                                                    } )
                                                );
                                                insertBlock( block, undefined, clientId );
                                                ref.onClose();
                                            }
                                        }, preset.label );
                                    } )
                                );
                            }
                        } )
                    )
                )
            );
        };
    }, 'withPaksaSectionLayoutToolbar' );

    addFilter( 'editor.BlockEdit', 'paksa/section-layout-toolbar', withSectionLayoutToolbar );

} )( window.wp );

/* ── IIFE 6: Block naming — readable List View labels ───────────────────── */
/* Adds a "Block label" text field to paksa/section and core/group so users  */
/* can name sections "Hero Section", "Features", etc. in the List View.      */
/* Uses the native metadata.name attribute supported since WP 6.1.           */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var TextControl    = wp.components.TextControl;
    var ComboboxControl = wp.components.ComboboxControl || null;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var NAMED_BLOCKS = [ 'paksa/section', 'core/group', 'core/columns' ];
    var p27Data      = window.paksaPhase27 || {};
    var suggestions  = ( p27Data.suggestedNames || [] ).map( function( s ) {
        return { value: s.value, label: s.label };
    } );

    var withBlockNaming = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( NAMED_BLOCKS.indexOf( props.name ) === -1 ) return el( BlockEdit, props );

            var a   = props.attributes;
            var set = props.setAttributes;
            // metadata.name is the native WP 6.1+ block label stored in block attributes
            var currentName = ( a.metadata && a.metadata.name ) ? a.metadata.name : '';

            function setName( v ) {
                set( { metadata: Object.assign( {}, a.metadata || {}, { name: v } ) } );
            }

            var nameControl = ( ComboboxControl && suggestions.length )
                ? el( ComboboxControl, {
                    label: 'Block label',
                    help: 'Shown in List View. Does not affect frontend output.',
                    value: currentName,
                    options: suggestions,
                    onChange: function( v ) { setName( v || '' ); },
                    onFilterValueChange: function() {},
                    allowReset: true
                } )
                : el( TextControl, {
                    label: 'Block label',
                    help: 'Shown in List View. Does not affect frontend output.',
                    value: currentName,
                    onChange: setName,
                    placeholder: 'e.g. Hero Section'
                } );

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {},
                    el( PanelBody, {
                        title: 'Block Label',
                        initialOpen: false,
                        className: 'pk-block-label-panel'
                    }, nameControl )
                )
            );
        };
    }, 'withPaksaBlockNaming' );

    addFilter( 'editor.BlockEdit', 'paksa/block-naming', withBlockNaming );

} )( window.wp );

/* ── IIFE 7: Section variant quick-toolbar on paksa/section ─────────────── */
/* Adds Default / Alt / Dark / Gradient buttons to the block toolbar so the  */
/* user can switch section background without opening the Inspector.          */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var BlockControls  = wp.blockEditor.BlockControls;
    var ToolbarGroup   = wp.components.ToolbarGroup;
    var ToolbarButton  = wp.components.ToolbarButton;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var p27Data  = window.paksaPhase27 || {};
    var variants = p27Data.sectionVariants || [];

    var withSectionVariantToolbar = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( props.name !== 'paksa/section' ) return el( BlockEdit, props );

            var a   = props.attributes;
            var set = props.setAttributes;

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( BlockControls, { group: 'block' },
                    el( ToolbarGroup, {},
                        variants.map( function( v ) {
                            return el( ToolbarButton, {
                                key: v.value,
                                label: v.label,
                                isActive: ( a.variant || 'default' ) === v.value,
                                onClick: function() { set( { variant: v.value } ); },
                                className: 'pk-variant-btn pk-variant-btn--' + v.value
                            }, v.label.charAt( 0 ) ); // single-char label fits toolbar
                        } )
                    )
                )
            );
        };
    }, 'withPaksaSectionVariantToolbar' );

    addFilter( 'editor.BlockEdit', 'paksa/section-variant-toolbar', withSectionVariantToolbar );

} )( window.wp );

/* ── IIFE 8: Copy Style / Paste Style toolbar buttons ───────────────────── */
/* Copies only safe styling attributes (no content, no IDs, no URLs) to      */
/* sessionStorage. Paste applies them to the currently selected block.        */
/* Works on paksa/section, core/group, core/columns, core/column.             */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var BlockControls  = wp.blockEditor.BlockControls;
    var ToolbarGroup   = wp.components.ToolbarGroup;
    var ToolbarButton  = wp.components.ToolbarButton;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var STYLE_BLOCKS = [ 'paksa/section', 'core/group', 'core/columns', 'core/column' ];
    var STORAGE_KEY  = 'pk_copied_style';

    var p27Data       = window.paksaPhase27 || {};
    var copyableAttrs = p27Data.copyableAttrs || [
        'pkPaddingTop','pkPaddingBot','pkPaddingLeft','pkPaddingRight','pkGap',
        'pkFlexDir','pkJustify','pkAlignItems','pkFlexWrap','pkFlexGap',
        'borderWidth','borderStyle','borderColor','borderRadius','shadowPreset',
        'hoverEffect','hoverShadow','hoverLift','transition',
        'animation','animDelay','animDuration',
        'variant','containerWidth','textAlign','verticalAlign',
        'bgColor','bgGradient','bgImagePosition','bgImageSize',
        'bgOverlayColor','bgOverlayOpacity'
    ];

    function extractStyle( attributes ) {
        var out = {};
        copyableAttrs.forEach( function( key ) {
            if ( attributes[ key ] !== undefined && attributes[ key ] !== '' && attributes[ key ] !== null ) {
                out[ key ] = attributes[ key ];
            }
        } );
        return out;
    }

    var withCopyPasteStyle = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( STYLE_BLOCKS.indexOf( props.name ) === -1 ) return el( BlockEdit, props );

            var a   = props.attributes;
            var set = props.setAttributes;

            function onCopy() {
                try {
                    sessionStorage.setItem( STORAGE_KEY, JSON.stringify( {
                        blockType: props.name,
                        style: extractStyle( a )
                    } ) );
                } catch(e) {}
            }

            function onPaste() {
                try {
                    var raw = sessionStorage.getItem( STORAGE_KEY );
                    if ( ! raw ) return;
                    var data = JSON.parse( raw );
                    if ( ! data || ! data.style ) return;
                    // Only paste attrs that exist on this block type
                    var safe = {};
                    copyableAttrs.forEach( function( key ) {
                        if ( data.style[ key ] !== undefined ) safe[ key ] = data.style[ key ];
                    } );
                    set( safe );
                } catch(e) {}
            }

            var hasCopied = false;
            try { hasCopied = !! sessionStorage.getItem( STORAGE_KEY ); } catch(e) {}

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( BlockControls, { group: 'other' },
                    el( ToolbarGroup, {},
                        el( ToolbarButton, {
                            icon: 'admin-customizer',
                            label: 'Copy style',
                            onClick: onCopy,
                            className: 'pk-copy-style-btn'
                        } ),
                        el( ToolbarButton, {
                            icon: 'editor-paste-text',
                            label: 'Paste style',
                            onClick: onPaste,
                            disabled: ! hasCopied,
                            className: 'pk-paste-style-btn'
                        } )
                    )
                )
            );
        };
    }, 'withPaksaCopyPasteStyle' );

    addFilter( 'editor.BlockEdit', 'paksa/copy-paste-style', withCopyPasteStyle );

} )( window.wp );

/* ── IIFE 9: Improved Responsive Visibility UX ──────────────────────────── */
/* Replaces the plain ToggleControl row in the Phase 26 visibility panel     */
/* with a compact icon-badge row showing ✓ / ✕ per device so state is        */
/* immediately obvious without reading toggle labels.                         */
/* Overrides the Phase 26 panel by registering at higher priority.           */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;

    var addFilter      = wp.hooks.addFilter;
    var removeFilter   = wp.hooks.removeFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var Button         = wp.components.Button;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var VISIBILITY_BLOCKS = [
        'core/group', 'core/column', 'core/columns',
        'core/image', 'core/cover', 'paksa/section',
        'core/heading', 'core/paragraph', 'core/buttons'
    ];

    var CLASS_MOBILE  = 'pk-hide-mobile';
    var CLASS_TABLET  = 'pk-hide-tablet';
    var CLASS_DESKTOP = 'pk-hide-desktop';

    function toggleClass( current, cls, add ) {
        var base = ( current || '' ).replace( new RegExp( '\\b' + cls + '\\b', 'g' ), '' ).trim();
        return add ? ( base + ' ' + cls ).trim() : base;
    }

    // Remove the Phase 26 plain-toggle version so we don't double-render
    removeFilter( 'editor.BlockEdit', 'paksa/visibility-controls' );

    var withVisibilityV2 = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( VISIBILITY_BLOCKS.indexOf( props.name ) === -1 ) return el( BlockEdit, props );

            var a   = props.attributes;
            var set = props.setAttributes;
            var cls = a.className || '';

            var devices = [
                { key: CLASS_DESKTOP, label: 'Desktop', icon: '🖥' },
                { key: CLASS_TABLET,  label: 'Tablet',  icon: '▣' },
                { key: CLASS_MOBILE,  label: 'Mobile',  icon: '📱' }
            ];

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {},
                    el( PanelBody, {
                        title: 'Responsive Visibility',
                        initialOpen: false,
                        className: 'pk-visibility-panel'
                    },
                        el( 'p', {
                            className: 'components-base-control__help',
                            style: { marginTop: 0, marginBottom: '10px' }
                        }, 'Toggle which devices show this block.' ),
                        el( 'div', { className: 'pk-visibility-badges' },
                            devices.map( function( d ) {
                                var hidden  = cls.indexOf( d.key ) !== -1;
                                var visible = ! hidden;
                                return el( 'button', {
                                    key: d.key,
                                    type: 'button',
                                    className: 'pk-visibility-badge' + ( visible ? ' is-visible' : ' is-hidden' ),
                                    onClick: function() {
                                        set( { className: toggleClass( cls, d.key, visible ) } );
                                    },
                                    'aria-label': ( visible ? 'Hide on ' : 'Show on ' ) + d.label,
                                    title: ( visible ? 'Visible on ' : 'Hidden on ' ) + d.label
                                },
                                    el( 'span', { className: 'pk-visibility-badge__icon', 'aria-hidden': 'true' }, d.icon ),
                                    el( 'span', { className: 'pk-visibility-badge__label' }, d.label ),
                                    el( 'span', { className: 'pk-visibility-badge__state', 'aria-hidden': 'true' }, visible ? '✓' : '✕' )
                                );
                            } )
                        )
                    )
                )
            );
        };
    }, 'withPaksaVisibilityV2' );

    addFilter( 'editor.BlockEdit', 'paksa/visibility-controls', withVisibilityV2, 11 );

} )( window.wp );

/* ── IIFE 10: Responsive column workflow — unified Desktop/Tablet/Mobile ── */
/* Adds a single "Responsive Columns" panel to core/columns with three       */
/* number inputs (Desktop / Tablet / Mobile) that write to the existing      */
/* pkMobileCols and pkTabletCols attributes from Phase 20, plus pkStackMobile*/
/* The desktop value is informational only (native WP controls column count).*/
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var RangeControl   = wp.components.RangeControl;
    var ToggleControl  = wp.components.ToggleControl;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var withResponsiveCols = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( props.name !== 'core/columns' ) return el( BlockEdit, props );

            var a   = props.attributes;
            var set = props.setAttributes;

            // pkMobileCols / pkTabletCols are strings from Phase 20
            var mobileCols = parseInt( a.pkMobileCols, 10 ) || 1;
            var tabletCols = parseInt( a.pkTabletCols, 10 ) || 2;

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {},
                    el( PanelBody, {
                        title: 'Responsive Columns',
                        initialOpen: false,
                        className: 'pk-responsive-cols-panel'
                    },
                        el( 'p', {
                            className: 'components-base-control__help',
                            style: { marginTop: 0, marginBottom: '10px' }
                        }, 'Set how many columns appear per device. Desktop uses the native column count above.' ),
                        el( RangeControl, {
                            label: '📱 Mobile columns',
                            value: mobileCols,
                            min: 1,
                            max: 4,
                            step: 1,
                            onChange: function( v ) {
                                set( { pkMobileCols: String( v ) } );
                            }
                        } ),
                        el( RangeControl, {
                            label: '▣ Tablet columns',
                            value: tabletCols,
                            min: 1,
                            max: 4,
                            step: 1,
                            onChange: function( v ) {
                                set( { pkTabletCols: String( v ) } );
                            }
                        } ),
                        el( ToggleControl, {
                            label: 'Stack on mobile',
                            help: 'Forces single column on screens below 640px.',
                            checked: a.pkStackMobile !== false,
                            onChange: function( v ) { set( { pkStackMobile: v } ); }
                        } )
                    )
                )
            );
        };
    }, 'withPaksaResponsiveCols' );

    addFilter( 'editor.BlockEdit', 'paksa/responsive-cols-panel', withResponsiveCols );

} )( window.wp );
