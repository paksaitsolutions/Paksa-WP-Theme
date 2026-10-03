/* ============================================================
   Phase 29 — Visual Canvas, Spacing Handles & Responsive Editing
   v2.9.0

   IIFE 1: Visual spacing drag handles — paksa/section + core/group
   IIFE 2: Container width quick-picker toolbar
   IIFE 3: Navigator v2 — search, filter, auto-scroll, rename, context menu
   IIFE 4: Responsive device bar — Desktop / Tablet / Mobile context
   IIFE 5: Empty-state canvas affordances
   IIFE 6: Column resize — discrete safe steps
   ============================================================ */

/* ── IIFE 1: Visual spacing drag handles ────────────────────────────────── */
/* Adds draggable top/bottom padding handles to paksa/section and core/group.*/
/* Drag updates the native WP spacing attributes (style.spacing.padding).    */
/* Uses rAF throttle during drag; commits a single undo entry on mouseup.    */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose || ! wp.data ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var useState       = wp.element.useState;
    var useRef         = wp.element.useRef;
    var useCallback    = wp.element.useCallback;
    var useEffect      = wp.element.useEffect;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var Button         = wp.components.Button;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;
    var useDispatch    = wp.data.useDispatch;

    var SPACING_BLOCKS = [ 'paksa/section', 'core/group', 'core/columns', 'core/column' ];

    /* Parse a CSS value to px number for display. Returns null if unparseable. */
    function parseToPx( val ) {
        if ( ! val || val === '0' ) return 0;
        var n = parseFloat( val );
        if ( isNaN( n ) ) return null;
        if ( /rem$/.test( val ) ) return Math.round( n * 16 );
        if ( /em$/.test( val ) ) return Math.round( n * 16 );
        if ( /px$/.test( val ) ) return Math.round( n );
        if ( /vw$/.test( val ) ) return null; // can't resolve without viewport
        return Math.round( n );
    }

    /* Format px back to rem (2 decimal places) */
    function pxToRem( px ) {
        return ( px / 16 ).toFixed( 2 ).replace( /\.?0+$/, '' ) + 'rem';
    }

    /* Read padding from native WP style.spacing.padding object */
    function readPadding( attributes ) {
        var sp = attributes.style && attributes.style.spacing && attributes.style.spacing.padding;
        if ( ! sp ) return { top: '', bottom: '' };
        return {
            top:    sp.top    || '',
            bottom: sp.bottom || '',
        };
    }

    /* Write padding back into style.spacing.padding, preserving other style keys */
    function writePadding( attributes, setAttributes, top, bottom ) {
        var existingStyle   = attributes.style || {};
        var existingSpacing = ( existingStyle.spacing ) || {};
        var existingPadding = existingSpacing.padding || {};
        setAttributes( {
            style: Object.assign( {}, existingStyle, {
                spacing: Object.assign( {}, existingSpacing, {
                    padding: Object.assign( {}, existingPadding, {
                        top:    top,
                        bottom: bottom,
                    } )
                } )
            } )
        } );
    }

    /* Spacing handle component — one draggable bar */
    function SpacingHandle( props ) {
        var side        = props.side;       // 'top' | 'bottom'
        var value       = props.value;      // current CSS string
        var onChange    = props.onChange;   // fn( newCssString )
        var onCommit    = props.onCommit;   // fn() — called on mouseup

        var dragging    = useRef( false );
        var startY      = useRef( 0 );
        var startPx     = useRef( 0 );
        var rafId       = useRef( null );
        var pendingPx   = useRef( null );

        var displayState = useState( null ); // null = not dragging
        var displayPx    = displayState[0];
        var setDisplayPx = displayState[1];

        var currentPx = parseToPx( value );
        var showPx    = displayPx !== null ? displayPx : currentPx;

        function onMouseDown( e ) {
            e.preventDefault();
            dragging.current  = true;
            startY.current    = e.clientY;
            startPx.current   = ( currentPx !== null ? currentPx : 0 );
            pendingPx.current = startPx.current;

            function onMouseMove( ev ) {
                if ( ! dragging.current ) return;
                var delta = side === 'top'
                    ? ( startY.current - ev.clientY )   // drag up = more padding
                    : ( ev.clientY - startY.current );  // drag down = more padding
                var raw = Math.max( 0, Math.round( ( startPx.current + delta ) / 4 ) * 4 );
                pendingPx.current = raw;

                if ( rafId.current ) cancelAnimationFrame( rafId.current );
                rafId.current = requestAnimationFrame( function() {
                    setDisplayPx( pendingPx.current );
                    onChange( pxToRem( pendingPx.current ) );
                } );
            }

            function onMouseUp() {
                dragging.current = false;
                if ( rafId.current ) cancelAnimationFrame( rafId.current );
                setDisplayPx( null );
                onCommit();
                window.removeEventListener( 'mousemove', onMouseMove );
                window.removeEventListener( 'mouseup', onMouseUp );
            }

            window.addEventListener( 'mousemove', onMouseMove );
            window.addEventListener( 'mouseup', onMouseUp );
        }

        var label = side === 'top' ? 'Padding Top' : 'Padding Bottom';
        var arrow = side === 'top' ? '↑' : '↓';

        return el( 'div', {
            className: 'pk-spacing-handle pk-spacing-handle--' + side + ( displayPx !== null ? ' is-dragging' : '' ),
            onMouseDown: onMouseDown,
            role: 'slider',
            'aria-label': label + ( showPx !== null ? ': ' + showPx + 'px' : '' ),
            'aria-valuenow': showPx !== null ? showPx : 0,
            'aria-valuemin': 0,
            'aria-valuemax': 320,
            tabIndex: 0,
            onKeyDown: function( e ) {
                var step = e.shiftKey ? 16 : 4;
                var cur  = currentPx !== null ? currentPx : 0;
                if ( e.key === 'ArrowUp' ) {
                    e.preventDefault();
                    onChange( pxToRem( Math.max( 0, cur + step ) ) );
                    onCommit();
                } else if ( e.key === 'ArrowDown' ) {
                    e.preventDefault();
                    onChange( pxToRem( Math.max( 0, cur - step ) ) );
                    onCommit();
                }
            }
        },
            el( 'span', { className: 'pk-spacing-handle__arrow', 'aria-hidden': 'true' }, arrow ),
            el( 'span', { className: 'pk-spacing-handle__label' }, label ),
            showPx !== null
                ? el( 'span', { className: 'pk-spacing-handle__value' }, showPx + 'px' )
                : null
        );
    }

    /* Inspector spacing panel with preset buttons */
    function SpacingPanel( props ) {
        var attributes    = props.attributes;
        var setAttributes = props.setAttributes;
        var onCommit      = props.onCommit;

        var padding = readPadding( attributes );
        var p29     = window.paksaPhase29 || {};
        var presets = p29.spacingPresets || [];

        function setTop( v )    { writePadding( attributes, setAttributes, v, readPadding( attributes ).bottom ); }
        function setBottom( v ) { writePadding( attributes, setAttributes, readPadding( attributes ).top, v ); }

        return el( PanelBody, {
            title: 'Spacing',
            initialOpen: false,
            className: 'pk-spacing-panel'
        },
            el( 'div', { className: 'pk-spacing-handles-wrap' },
                el( SpacingHandle, { side: 'top',    value: padding.top,    onChange: setTop,    onCommit: onCommit } ),
                el( SpacingHandle, { side: 'bottom', value: padding.bottom, onChange: setBottom, onCommit: onCommit } )
            ),
            el( 'p', { className: 'pk-spacing-panel__hint' }, 'Drag handles or use ↑↓ keys (Shift = ×4). Presets:' ),
            el( 'div', { className: 'pk-spacing-presets' },
                presets.map( function( p ) {
                    return el( Button, {
                        key: p.label,
                        isSmall: true,
                        variant: 'secondary',
                        onClick: function() {
                            writePadding( attributes, setAttributes, p.value, p.value );
                            onCommit();
                        },
                        title: 'Set top & bottom padding to ' + p.label
                    }, p.label );
                } )
            )
        );
    }

    var withSpacingHandles = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( SPACING_BLOCKS.indexOf( props.name ) === -1 ) return el( BlockEdit, props );

            var dispatch = useDispatch( 'core/block-editor' );

            /* Commit: mark last change as persistent so continuous drag = 1 undo entry */
            function onCommit() {
                if ( dispatch.__unstableMarkLastChangeAsPersistent ) {
                    dispatch.__unstableMarkLastChangeAsPersistent();
                }
            }

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {},
                    el( SpacingPanel, {
                        attributes:    props.attributes,
                        setAttributes: props.setAttributes,
                        onCommit:      onCommit
                    } )
                )
            );
        };
    }, 'withPaksaSpacingHandles' );

    addFilter( 'editor.BlockEdit', 'paksa/spacing-handles', withSpacingHandles );

} )( window.wp );

/* ── IIFE 2: Container width quick-picker toolbar ───────────────────────── */
/* Adds a compact toolbar dropdown to paksa/section and core/group that      */
/* lets the user switch containerWidth (section) or a data-width class       */
/* (group) without opening the Inspector.                                    */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var BlockControls  = wp.blockEditor.BlockControls;
    var ToolbarGroup   = wp.components.ToolbarGroup;
    var ToolbarButton  = wp.components.ToolbarButton;
    var Dropdown       = wp.components.Dropdown;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var p29Data = window.paksaPhase29 || {};
    var widths  = p29Data.containerWidths || [
        { label: 'Narrow',  value: 'narrow',  px: '720px',  icon: '▏▕' },
        { label: 'Default', value: 'default', px: '1200px', icon: '◁▷' },
        { label: 'Wide',    value: 'wide',    px: '1440px', icon: '◀▶' },
        { label: 'Full',    value: 'full',    px: '100%',   icon: '⟵⟶' },
    ];

    var WIDTH_BLOCKS = [ 'paksa/section', 'core/group' ];

    var withWidthPicker = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( WIDTH_BLOCKS.indexOf( props.name ) === -1 ) return el( BlockEdit, props );

            var a   = props.attributes;
            var set = props.setAttributes;

            /* paksa/section uses containerWidth attribute directly.
               core/group uses className to carry pk-container-{value}. */
            var isSection   = props.name === 'paksa/section';
            var currentVal  = isSection
                ? ( a.containerWidth || 'default' )
                : ( function() {
                    var cls = a.className || '';
                    var m   = cls.match( /pk-container-(narrow|default|wide|full)/ );
                    return m ? m[1] : 'default';
                } )();

            function applyWidth( val ) {
                if ( isSection ) {
                    set( { containerWidth: val } );
                } else {
                    var cls = ( a.className || '' )
                        .replace( /\bpk-container-(narrow|default|wide|full)\b/g, '' )
                        .trim();
                    if ( val !== 'default' ) {
                        cls = ( cls + ' pk-container-' + val ).trim();
                    }
                    set( { className: cls } );
                }
            }

            var currentLabel = ( widths.find( function( w ) { return w.value === currentVal; } ) || widths[1] ).label;

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( BlockControls, { group: 'block' },
                    el( ToolbarGroup, {},
                        el( Dropdown, {
                            className: 'pk-width-picker-dropdown',
                            renderToggle: function( ref ) {
                                return el( ToolbarButton, {
                                    label: 'Container width: ' + currentLabel,
                                    onClick: ref.onToggle,
                                    isActive: ref.isOpen,
                                    className: 'pk-width-picker-btn'
                                }, '⟷ ' + currentLabel );
                            },
                            renderContent: function( ref ) {
                                return el( 'div', { className: 'pk-width-picker' },
                                    el( 'p', { className: 'pk-width-picker__title' }, 'Container Width' ),
                                    widths.map( function( w ) {
                                        return el( 'button', {
                                            key: w.value,
                                            className: 'pk-width-option' + ( currentVal === w.value ? ' is-active' : '' ),
                                            onClick: function() { applyWidth( w.value ); ref.onClose(); },
                                            'aria-label': w.label + ' — ' + w.px,
                                            'aria-pressed': currentVal === w.value
                                        },
                                            el( 'span', { className: 'pk-width-option__icon', 'aria-hidden': 'true' }, w.icon ),
                                            el( 'span', { className: 'pk-width-option__label' }, w.label ),
                                            el( 'span', { className: 'pk-width-option__px' }, w.px )
                                        );
                                    } )
                                );
                            }
                        } )
                    )
                )
            );
        };
    }, 'withPaksaWidthPicker' );

    addFilter( 'editor.BlockEdit', 'paksa/width-picker', withWidthPicker );

    /* Register pk-container-* classes as saved attributes on core/group */
    wp.hooks.addFilter( 'blocks.registerBlockType', 'paksa/group-container-width',
        function( settings, name ) {
            if ( name !== 'core/group' ) return settings;
            /* className is already a native attribute — no new attribute needed.
               The class is applied via the existing className mechanism. */
            return settings;
        }
    );

} )( window.wp );

/* ── IIFE 3: Navigator v2 — search, filter, auto-scroll, rename, context menu */
/* Replaces the Phase 28 Navigator plugin with an enhanced version.           */
/* Uses the same plugin name so only one sidebar is registered.               */
( function( wp ) {
    'use strict';

    var plugins    = wp.plugins;
    var editPost   = ( wp.editor && wp.editor.PluginSidebar ) ? wp.editor : wp.editPost;
    var el         = wp.element.createElement;
    var useState   = wp.element.useState;
    var useEffect  = wp.element.useEffect;
    var useRef     = wp.element.useRef;
    var useMemo    = wp.element.useMemo;
    var useCallback = wp.element.useCallback;
    var useSelect  = wp.data.useSelect;
    var useDispatch = wp.data.useDispatch;
    var PluginSidebar = editPost && editPost.PluginSidebar;
    var registerPlugin = plugins && plugins.registerPlugin;
    var unregisterPlugin = plugins && plugins.unregisterPlugin;

    if ( ! registerPlugin || ! PluginSidebar ) return;

    /* Phase 28 Navigator replaced by this registration below */

    var p29Data    = window.paksaPhase29 || {};
    var NAV_FILTERS = p29Data.navFilters || [
        { label: 'All',        value: 'all' },
        { label: 'Sections',   value: 'sections' },
        { label: 'Containers', value: 'containers' },
        { label: 'Columns',    value: 'columns' },
        { label: 'Content',    value: 'content' },
    ];

    /* ── Helpers ── */
    function blockLabel( block ) {
        if ( ! block ) return 'Block';
        if ( block.attributes && block.attributes.metadata && block.attributes.metadata.name ) {
            return block.attributes.metadata.name;
        }
        var typeMap = {
            'paksa/section':   'Section',
            'core/group':      'Container',
            'core/columns':    'Columns',
            'core/column':     'Column',
            'core/heading':    'Heading',
            'core/paragraph':  'Paragraph',
            'core/image':      'Image',
            'core/buttons':    'Buttons',
            'core/button':     'Button',
            'core/cover':      'Cover',
            'core/list':       'List',
            'core/quote':      'Quote',
            'core/separator':  'Separator',
            'core/spacer':     'Spacer',
            'core/navigation': 'Navigation',
            'core/query':      'Query Loop',
            'core/template-part': 'Template Part',
            'paksa/testimonial': 'Testimonial',
            'paksa/cta':       'CTA',
            'paksa/icon':      'Icon',
            'paksa/stat':      'Stat',
            'paksa/breadcrumbs': 'Breadcrumbs',
            'paksa/product-card': 'Product Card',
            'paksa/service-card': 'Service Card',
        };
        return typeMap[ block.name ] || block.name.replace( /^(core|paksa)\//, '' ).replace( /-/g, ' ' ).replace( /\b\w/g, function(c){ return c.toUpperCase(); } );
    }

    function blockIcon( name ) {
        var icons = {
            'paksa/section':  '▣',
            'core/group':     '⬜',
            'core/columns':   '⊞',
            'core/column':    '▏',
            'core/heading':   'H',
            'core/paragraph': '¶',
            'core/image':     '⬚',
            'core/buttons':   '⬡',
            'core/button':    '⬡',
            'core/cover':     '◼',
            'core/list':      '≡',
            'core/quote':     '"',
            'core/separator': '—',
            'core/spacer':    '↕',
            'core/navigation':'☰',
            'core/query':     '⟳',
            'paksa/testimonial': '"',
            'paksa/cta':      '→',
            'paksa/icon':     '★',
            'paksa/stat':     '#',
        };
        return icons[ name ] || '◦';
    }

    function filterCategory( blockName ) {
        if ( blockName === 'paksa/section' ) return 'sections';
        if ( blockName === 'core/group' ) return 'containers';
        if ( blockName === 'core/columns' || blockName === 'core/column' ) return 'columns';
        return 'content';
    }

    /* Flatten block tree for search */
    function flattenBlocks( blocks, result ) {
        result = result || [];
        ( blocks || [] ).forEach( function( b ) {
            result.push( b );
            if ( b.innerBlocks && b.innerBlocks.length ) {
                flattenBlocks( b.innerBlocks, result );
            }
        } );
        return result;
    }

    /* Check if block or any descendant matches search query */
    function blockMatchesSearch( block, query ) {
        if ( ! query ) return true;
        var q = query.toLowerCase();
        var label = blockLabel( block ).toLowerCase();
        var type  = block.name.toLowerCase();
        return label.indexOf( q ) !== -1 || type.indexOf( q ) !== -1;
    }

    /* ── Rename inline component ── */
    function RenameInput( props ) {
        var block    = props.block;
        var onSave   = props.onSave;
        var onCancel = props.onCancel;
        var inputRef = useRef( null );
        var current  = ( block.attributes && block.attributes.metadata && block.attributes.metadata.name ) || '';
        var state    = useState( current );
        var val      = state[0];
        var setVal   = state[1];

        useEffect( function() {
            if ( inputRef.current ) {
                inputRef.current.focus();
                inputRef.current.select();
            }
        }, [] );

        return el( 'input', {
            ref: inputRef,
            className: 'pk-nav-rename-input',
            value: val,
            onChange: function( e ) { setVal( e.target.value ); },
            onKeyDown: function( e ) {
                if ( e.key === 'Enter' ) { e.preventDefault(); onSave( val ); }
                if ( e.key === 'Escape' ) { e.preventDefault(); onCancel(); }
            },
            onBlur: function() { onSave( val ); },
            'aria-label': 'Rename block',
            placeholder: 'Block label…'
        } );
    }

    /* ── Context menu ── */
    function ContextMenu( props ) {
        var block        = props.block;
        var parentId     = props.parentId;
        var index        = props.index;
        var siblingCount = props.siblingCount;
        var onClose      = props.onClose;
        var onSelect     = props.onSelect;
        var onRename     = props.onRename;
        var onDuplicate  = props.onDuplicate;
        var onMoveUp     = props.onMoveUp;
        var onMoveDown   = props.onMoveDown;
        var onRemove     = props.onRemove;
        var onCopyStyle  = props.onCopyStyle;
        var onPasteStyle = props.onPasteStyle;
        var hasCopied    = props.hasCopied;
        var label        = blockLabel( block );

        var menuRef = useRef( null );
        useEffect( function() {
            function handleClick( e ) {
                if ( menuRef.current && ! menuRef.current.contains( e.target ) ) {
                    onClose();
                }
            }
            document.addEventListener( 'mousedown', handleClick );
            return function() { document.removeEventListener( 'mousedown', handleClick ); };
        }, [ onClose ] );

        function item( text, action, disabled, danger ) {
            return el( 'button', {
                className: 'pk-ctx-item' + ( danger ? ' pk-ctx-item--danger' : '' ),
                disabled: !! disabled,
                onClick: function() { action(); onClose(); },
                type: 'button'
            }, text );
        }

        return el( 'div', { className: 'pk-ctx-menu', ref: menuRef, role: 'menu' },
            item( 'Select', function() { onSelect( block.clientId ); } ),
            item( 'Rename', function() { onRename( block.clientId ); } ),
            el( 'div', { className: 'pk-ctx-divider' } ),
            item( 'Duplicate', function() { onDuplicate( block.clientId ); } ),
            item( 'Copy Style', function() { onCopyStyle( block ); } ),
            item( 'Paste Style', function() { onPasteStyle( block.clientId ); }, ! hasCopied ),
            el( 'div', { className: 'pk-ctx-divider' } ),
            item( 'Move Up',   function() { onMoveUp( block.clientId, parentId, index ); },   index <= 0 ),
            item( 'Move Down', function() { onMoveDown( block.clientId, parentId, index ); }, index >= siblingCount - 1 ),
            el( 'div', { className: 'pk-ctx-divider' } ),
            item( 'Delete', function() {
                if ( window.confirm( 'Delete "' + label + '" and all its contents?' ) ) {
                    onRemove( block.clientId );
                }
            }, false, true )
        );
    }

    /* ── NavNode v2 ── */
    function NavNode( props ) {
        var block        = props.block;
        var depth        = props.depth || 0;
        var selectedId   = props.selectedId;
        var renamingId   = props.renamingId;
        var contextId    = props.contextId;
        var onSelect     = props.onSelect;
        var onMoveUp     = props.onMoveUp;
        var onMoveDown   = props.onMoveDown;
        var onDuplicate  = props.onDuplicate;
        var onRemove     = props.onRemove;
        var onRename     = props.onRename;
        var onRenameSave = props.onRenameSave;
        var onRenameCancel = props.onRenameCancel;
        var onContextMenu = props.onContextMenu;
        var onCopyStyle  = props.onCopyStyle;
        var onPasteStyle = props.onPasteStyle;
        var hasCopied    = props.hasCopied;
        var parentId     = props.parentId;
        var index        = props.index;
        var siblingCount = props.siblingCount;
        var nodeRef      = props.nodeRef;
        var searchQuery  = props.searchQuery;
        var activeFilter = props.activeFilter;

        var hasChildren = block.innerBlocks && block.innerBlocks.length > 0;
        var isSelected  = block.clientId === selectedId;
        var isRenaming  = block.clientId === renamingId;
        var showContext = block.clientId === contextId;

        var expandedState = useState( depth < 2 );
        var isOpen  = expandedState[0];
        var setOpen = expandedState[1];

        /* Auto-expand ancestors when a child is selected */
        useEffect( function() {
            if ( isSelected && depth > 0 ) setOpen( true );
        }, [ isSelected ] );

        var label  = blockLabel( block );
        var icon   = blockIcon( block.name );
        var indent = depth * 14;

        /* Filter: hide node if it doesn't match (but always show if it has matching descendants) */
        var cat = filterCategory( block.name );
        var passesFilter = activeFilter === 'all' || cat === activeFilter;
        var passesSearch = ! searchQuery || blockMatchesSearch( block, searchQuery );
        var hasMatchingDescendant = searchQuery && flattenBlocks( block.innerBlocks ).some( function( d ) {
            return blockMatchesSearch( d, searchQuery );
        } );

        if ( ! passesFilter && ! passesSearch && ! hasMatchingDescendant ) return null;
        if ( searchQuery && ! passesSearch && ! hasMatchingDescendant ) return null;

        return el( 'div', {
            className: 'pk-nav-node' + ( isSelected ? ' is-selected' : '' ),
            ref: isSelected ? nodeRef : null
        },
            el( 'div', {
                className: 'pk-nav-node__row',
                style: { paddingLeft: ( 8 + indent ) + 'px' },
                onClick: function( e ) { e.stopPropagation(); onSelect( block.clientId ); },
                onContextMenu: function( e ) {
                    e.preventDefault();
                    e.stopPropagation();
                    onContextMenu( block.clientId );
                },
                role: 'treeitem',
                tabIndex: 0,
                'aria-selected': isSelected,
                'aria-expanded': hasChildren ? isOpen : undefined,
                onKeyDown: function( e ) {
                    if ( e.key === 'Enter' || e.key === ' ' ) { e.preventDefault(); onSelect( block.clientId ); }
                    if ( e.key === 'ArrowRight' && hasChildren ) { e.preventDefault(); setOpen( true ); }
                    if ( e.key === 'ArrowLeft' ) { e.preventDefault(); setOpen( false ); }
                    if ( e.key === 'F2' ) { e.preventDefault(); onRename( block.clientId ); }
                }
            },
                el( 'button', {
                    className: 'pk-nav-node__toggle',
                    onClick: function( e ) { e.stopPropagation(); setOpen( ! isOpen ); },
                    'aria-label': isOpen ? 'Collapse' : 'Expand',
                    tabIndex: -1,
                    style: { visibility: hasChildren ? 'visible' : 'hidden' }
                }, isOpen ? '▾' : '▸' ),

                el( 'span', { className: 'pk-nav-node__icon pk-nav-depth-' + Math.min( depth, 3 ), 'aria-hidden': 'true' }, icon ),

                isRenaming
                    ? el( RenameInput, {
                        block: block,
                        onSave: function( v ) { onRenameSave( block.clientId, v ); },
                        onCancel: onRenameCancel
                    } )
                    : el( 'span', { className: 'pk-nav-node__label' }, label ),

                ! isRenaming ? el( 'span', { className: 'pk-nav-node__actions' },
                    el( 'button', {
                        className: 'pk-nav-action pk-nav-action--rename',
                        title: 'Rename (F2)',
                        'aria-label': 'Rename ' + label,
                        tabIndex: -1,
                        onClick: function( e ) { e.stopPropagation(); onRename( block.clientId ); }
                    }, '✎' ),
                    el( 'button', {
                        className: 'pk-nav-action pk-nav-action--more',
                        title: 'More actions',
                        'aria-label': 'More actions for ' + label,
                        tabIndex: -1,
                        onClick: function( e ) { e.stopPropagation(); onContextMenu( block.clientId ); }
                    }, '⋯' )
                ) : null,

                showContext ? el( ContextMenu, {
                    block:        block,
                    parentId:     parentId,
                    index:        index,
                    siblingCount: siblingCount,
                    onClose:      function() { onContextMenu( null ); },
                    onSelect:     onSelect,
                    onRename:     onRename,
                    onDuplicate:  onDuplicate,
                    onMoveUp:     onMoveUp,
                    onMoveDown:   onMoveDown,
                    onRemove:     onRemove,
                    onCopyStyle:  onCopyStyle,
                    onPasteStyle: onPasteStyle,
                    hasCopied:    hasCopied
                } ) : null
            ),

            ( hasChildren && isOpen ) ? el( 'div', { className: 'pk-nav-node__children' },
                block.innerBlocks.map( function( child, i ) {
                    return el( NavNode, {
                        key: child.clientId,
                        block: child,
                        depth: depth + 1,
                        selectedId: selectedId,
                        renamingId: renamingId,
                        contextId: contextId,
                        onSelect: onSelect,
                        onMoveUp: onMoveUp,
                        onMoveDown: onMoveDown,
                        onDuplicate: onDuplicate,
                        onRemove: onRemove,
                        onRename: onRename,
                        onRenameSave: onRenameSave,
                        onRenameCancel: onRenameCancel,
                        onContextMenu: onContextMenu,
                        onCopyStyle: onCopyStyle,
                        onPasteStyle: onPasteStyle,
                        hasCopied: hasCopied,
                        parentId: block.clientId,
                        index: i,
                        siblingCount: block.innerBlocks.length,
                        nodeRef: props.nodeRef,
                        searchQuery: searchQuery,
                        activeFilter: activeFilter
                    } );
                } )
            ) : null
        );
    }

    /* ── Navigator v2 panel ── */
    function PaksaNavigatorV2() {
        var blocks = useSelect( function( select ) {
            return select( 'core/block-editor' ).getBlocks();
        }, [] );

        var selectedId = useSelect( function( select ) {
            return select( 'core/block-editor' ).getSelectedBlockClientId();
        }, [] );

        var dispatch = useDispatch( 'core/block-editor' );

        var searchState  = useState( '' );
        var search       = searchState[0];
        var setSearch    = searchState[1];

        var filterState  = useState( 'all' );
        var activeFilter = filterState[0];
        var setFilter    = filterState[1];

        var renamingState = useState( null );
        var renamingId    = renamingState[0];
        var setRenamingId = renamingState[1];

        var contextState = useState( null );
        var contextId    = contextState[0];
        var setContextId = contextState[1];

        var selectedNodeRef = useRef( null );
        var prevSelectedId  = useRef( null );

        /* Auto-scroll selected node into view — only on meaningful change */
        useEffect( function() {
            if ( selectedId && selectedId !== prevSelectedId.current ) {
                prevSelectedId.current = selectedId;
                if ( selectedNodeRef.current ) {
                    selectedNodeRef.current.scrollIntoView( { block: 'nearest', behavior: 'smooth' } );
                }
            }
        }, [ selectedId ] );

        var STORAGE_KEY = 'pk_copied_style';
        var p27Data     = window.paksaPhase27 || {};
        var copyableAttrs = p27Data.copyableAttrs || [];

        var hasCopied = false;
        try { hasCopied = !! sessionStorage.getItem( STORAGE_KEY ); } catch(e) {}

        function onSelect( clientId ) { dispatch.selectBlock( clientId ); }

        function onMoveUp( clientId, parentId, index ) {
            if ( index <= 0 ) return;
            dispatch.moveBlockToPosition( clientId, parentId, parentId, index - 1 );
        }

        function onMoveDown( clientId, parentId, index ) {
            dispatch.moveBlockToPosition( clientId, parentId, parentId, index + 1 );
        }

        function onDuplicate( clientId ) {
            dispatch.duplicateBlocks( [ clientId ] );
        }

        function onRemove( clientId ) {
            dispatch.removeBlock( clientId );
        }

        function onRename( clientId ) {
            setRenamingId( clientId );
            setContextId( null );
        }

        function onRenameSave( clientId, value ) {
            var allBlocks = flattenBlocks( blocks );
            var block = allBlocks.find( function( b ) { return b.clientId === clientId; } );
            if ( block ) {
                dispatch.updateBlockAttributes( clientId, {
                    metadata: Object.assign( {}, ( block.attributes && block.attributes.metadata ) || {}, { name: value || undefined } )
                } );
            }
            setRenamingId( null );
        }

        function onRenameCancel() { setRenamingId( null ); }

        function onContextMenu( clientId ) { setContextId( clientId ); }

        function onCopyStyle( block ) {
            try {
                var style = {};
                copyableAttrs.forEach( function( key ) {
                    if ( block.attributes[ key ] !== undefined && block.attributes[ key ] !== '' ) {
                        style[ key ] = block.attributes[ key ];
                    }
                } );
                sessionStorage.setItem( STORAGE_KEY, JSON.stringify( { blockType: block.name, style: style } ) );
            } catch(e) {}
        }

        function onPasteStyle( clientId ) {
            try {
                var raw = sessionStorage.getItem( STORAGE_KEY );
                if ( ! raw ) return;
                var data = JSON.parse( raw );
                if ( ! data || ! data.style ) return;
                var safe = {};
                copyableAttrs.forEach( function( key ) {
                    if ( data.style[ key ] !== undefined ) safe[ key ] = data.style[ key ];
                } );
                dispatch.updateBlockAttributes( clientId, safe );
            } catch(e) {}
        }

        var totalBlocks = flattenBlocks( blocks ).length;

        return el( 'div', { className: 'pk-navigator' },
            /* Header */
            el( 'div', { className: 'pk-navigator__header' },
                el( 'span', { className: 'pk-navigator__title' }, 'Page Structure' ),
                el( 'span', { className: 'pk-navigator__hint' }, totalBlocks + ' blocks' )
            ),

            /* Search */
            el( 'div', { className: 'pk-navigator__search-wrap' },
                el( 'input', {
                    type: 'search',
                    className: 'pk-navigator__search',
                    placeholder: 'Search blocks…',
                    value: search,
                    onChange: function( e ) { setSearch( e.target.value ); },
                    'aria-label': 'Search blocks'
                } ),
                search ? el( 'button', {
                    className: 'pk-navigator__search-clear',
                    onClick: function() { setSearch( '' ); },
                    'aria-label': 'Clear search',
                    title: 'Clear'
                }, '✕' ) : null
            ),

            /* Filter tabs */
            el( 'div', { className: 'pk-navigator__filters', role: 'tablist', 'aria-label': 'Filter blocks' },
                NAV_FILTERS.map( function( f ) {
                    return el( 'button', {
                        key: f.value,
                        className: 'pk-nav-filter' + ( activeFilter === f.value ? ' is-active' : '' ),
                        onClick: function() { setFilter( f.value ); },
                        role: 'tab',
                        'aria-selected': activeFilter === f.value,
                        title: 'Show ' + f.label
                    }, f.label );
                } )
            ),

            /* Tree */
            ( ! blocks || blocks.length === 0 )
                ? el( 'div', { className: 'pk-navigator-empty' }, el( 'p', {}, 'No blocks on this page yet.' ) )
                : el( 'div', { className: 'pk-navigator__tree', role: 'tree' },
                    blocks.map( function( block, i ) {
                        return el( NavNode, {
                            key: block.clientId,
                            block: block,
                            depth: 0,
                            selectedId: selectedId,
                            renamingId: renamingId,
                            contextId: contextId,
                            onSelect: onSelect,
                            onMoveUp: onMoveUp,
                            onMoveDown: onMoveDown,
                            onDuplicate: onDuplicate,
                            onRemove: onRemove,
                            onRename: onRename,
                            onRenameSave: onRenameSave,
                            onRenameCancel: onRenameCancel,
                            onContextMenu: onContextMenu,
                            onCopyStyle: onCopyStyle,
                            onPasteStyle: onPasteStyle,
                            hasCopied: hasCopied,
                            parentId: undefined,
                            index: i,
                            siblingCount: blocks.length,
                            nodeRef: selectedNodeRef,
                            searchQuery: search,
                            activeFilter: activeFilter
                        } );
                    } )
                )
        );
    }

    registerPlugin( 'paksa-navigator', {
        render: function() {
            return el( PluginSidebar, {
                name: 'paksa-navigator',
                title: 'Paksa Navigator',
                icon: 'layout',
                className: 'pk-navigator-sidebar'
            }, el( PaksaNavigatorV2, {} ) );
        }
    } );

} )( window.wp );

/* ── IIFE 4: Responsive device bar ─────────────────────────────────────── */
/* Adds a PluginSidebar panel with Desktop/Tablet/Mobile device context.     */
/* The active device drives a body data-attribute that CSS can target.       */
/* Displays current block's responsive visibility state per device.          */
/* Exposes pkMobileCols / pkTabletCols / pkStackMobile for core/columns.     */
( function( wp ) {
    'use strict';

    var plugins    = wp.plugins;
    var editPost   = ( wp.editor && wp.editor.PluginSidebar ) ? wp.editor : wp.editPost;
    var el         = wp.element.createElement;
    var useState   = wp.element.useState;
    var useEffect  = wp.element.useEffect;
    var useSelect  = wp.data.useSelect;
    var useDispatch = wp.data.useDispatch;
    var PluginSidebar = editPost && editPost.PluginSidebar;
    var registerPlugin = plugins && plugins.registerPlugin;
    var RangeControl   = wp.components.RangeControl;
    var ToggleControl  = wp.components.ToggleControl;
    var Button         = wp.components.Button;

    if ( ! registerPlugin || ! PluginSidebar ) return;

    var DEVICES = [
        { key: 'desktop', label: 'Desktop', icon: '🖥',  hideClass: 'pk-hide-desktop' },
        { key: 'tablet',  label: 'Tablet',  icon: '▣',   hideClass: 'pk-hide-tablet'  },
        { key: 'mobile',  label: 'Mobile',  icon: '📱',  hideClass: 'pk-hide-mobile'  },
    ];

    function DeviceBar() {
        var deviceState  = useState( 'desktop' );
        var activeDevice = deviceState[0];
        var setDevice    = deviceState[1];

        var selectedBlock = useSelect( function( select ) {
            return select( 'core/block-editor' ).getSelectedBlock();
        }, [] );

        var dispatch = useDispatch( 'core/block-editor' );

        /* Sync active device to editor body data-attribute for CSS targeting */
        useEffect( function() {
            var body = document.querySelector( '.editor-styles-wrapper' );
            if ( body ) {
                body.setAttribute( 'data-pk-device', activeDevice );
            }
            return function() {
                var b = document.querySelector( '.editor-styles-wrapper' );
                if ( b ) b.removeAttribute( 'data-pk-device' );
            };
        }, [ activeDevice ] );

        var cls = selectedBlock ? ( selectedBlock.attributes.className || '' ) : '';

        function toggleClass( current, key, add ) {
            var base = ( current || '' ).replace( new RegExp( '\\b' + key + '\\b', 'g' ), '' ).trim();
            return add ? ( base + ' ' + key ).trim() : base;
        }

        function setVisibility( hideClass, visible ) {
            if ( ! selectedBlock ) return;
            dispatch.updateBlockAttributes( selectedBlock.clientId, {
                className: toggleClass( cls, hideClass, ! visible )
            } );
        }

        /* Responsive columns state (core/columns only) */
        var isCols     = selectedBlock && selectedBlock.name === 'core/columns';
        var mobileCols = isCols ? ( parseInt( selectedBlock.attributes.pkMobileCols, 10 ) || 1 ) : 1;
        var tabletCols = isCols ? ( parseInt( selectedBlock.attributes.pkTabletCols, 10 ) || 2 ) : 2;
        var stackMob   = isCols ? ( selectedBlock.attributes.pkStackMobile !== false ) : true;

        return el( 'div', { className: 'pk-device-bar' },

            /* Device switcher */
            el( 'div', { className: 'pk-device-switcher', role: 'group', 'aria-label': 'Preview device' },
                DEVICES.map( function( d ) {
                    return el( 'button', {
                        key: d.key,
                        className: 'pk-device-btn' + ( activeDevice === d.key ? ' is-active' : '' ),
                        onClick: function() { setDevice( d.key ); },
                        'aria-pressed': activeDevice === d.key,
                        title: d.label
                    },
                        el( 'span', { 'aria-hidden': 'true' }, d.icon ),
                        el( 'span', { className: 'pk-device-btn__label' }, d.label )
                    );
                } )
            ),

            /* Selected block visibility per device */
            selectedBlock ? el( 'div', { className: 'pk-device-visibility' },
                el( 'p', { className: 'pk-device-section-title' }, 'Visibility — ' + ( selectedBlock.attributes.metadata && selectedBlock.attributes.metadata.name ? selectedBlock.attributes.metadata.name : selectedBlock.name.replace( /^(core|paksa)\//, '' ) ) ),
                el( 'div', { className: 'pk-device-vis-rows' },
                    DEVICES.map( function( d ) {
                        var hidden  = cls.indexOf( d.hideClass ) !== -1;
                        var isActive = activeDevice === d.key;
                        return el( 'div', {
                            key: d.key,
                            className: 'pk-device-vis-row' + ( isActive ? ' is-active-device' : '' )
                        },
                            el( 'span', { className: 'pk-device-vis-row__icon', 'aria-hidden': 'true' }, d.icon ),
                            el( 'span', { className: 'pk-device-vis-row__label' }, d.label ),
                            el( 'span', {
                                className: 'pk-device-vis-row__state pk-device-vis-row__state--' + ( hidden ? 'hidden' : 'visible' )
                            }, hidden ? '✕ Hidden' : '✓ Visible' ),
                            el( 'button', {
                                className: 'pk-device-vis-toggle',
                                onClick: function() { setVisibility( d.hideClass, hidden ); },
                                'aria-label': ( hidden ? 'Show on ' : 'Hide on ' ) + d.label,
                                title: ( hidden ? 'Show on ' : 'Hide on ' ) + d.label
                            }, hidden ? 'Show' : 'Hide' )
                        );
                    } )
                )
            ) : el( 'p', { className: 'pk-device-no-selection' }, 'Select a block to see its responsive visibility.' ),

            /* Responsive columns (core/columns only) */
            isCols ? el( 'div', { className: 'pk-device-cols-section' },
                el( 'p', { className: 'pk-device-section-title' }, 'Responsive Columns' ),
                el( RangeControl, {
                    label: '📱 Mobile',
                    value: mobileCols,
                    min: 1, max: 4, step: 1,
                    onChange: function( v ) {
                        dispatch.updateBlockAttributes( selectedBlock.clientId, { pkMobileCols: String( v ) } );
                    }
                } ),
                el( RangeControl, {
                    label: '▣ Tablet',
                    value: tabletCols,
                    min: 1, max: 4, step: 1,
                    onChange: function( v ) {
                        dispatch.updateBlockAttributes( selectedBlock.clientId, { pkTabletCols: String( v ) } );
                    }
                } ),
                el( ToggleControl, {
                    label: 'Stack on mobile',
                    checked: stackMob,
                    onChange: function( v ) {
                        dispatch.updateBlockAttributes( selectedBlock.clientId, { pkStackMobile: v } );
                    }
                } )
            ) : null
        );
    }

    registerPlugin( 'paksa-device-bar', {
        render: function() {
            return el( PluginSidebar, {
                name: 'paksa-device-bar',
                title: 'Responsive',
                icon: 'smartphone',
                className: 'pk-device-bar-sidebar'
            }, el( DeviceBar, {} ) );
        }
    } );

} )( window.wp );

/* ── IIFE 5: Empty-state canvas affordances ─────────────────────────────── */
/* Adds richer empty-state hints to paksa/section, core/group, core/columns. */
/* All insertion uses Gutenberg APIs — nothing is saved as placeholder text.  */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose || ! wp.data ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var useSelect      = wp.data.useSelect;
    var useDispatch    = wp.data.useDispatch;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var EMPTY_BLOCKS = [ 'paksa/section', 'core/group', 'core/columns' ];

    var withEmptyState = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( EMPTY_BLOCKS.indexOf( props.name ) === -1 ) return el( BlockEdit, props );

            var clientId    = props.clientId;
            var innerBlocks = useSelect( function( select ) {
                return select( 'core/block-editor' ).getBlocks( clientId );
            }, [ clientId ] );

            var dispatch    = useDispatch( 'core/block-editor' );
            var createBlock = wp.blocks && wp.blocks.createBlock;

            var isEmpty = ! innerBlocks || innerBlocks.length === 0;

            if ( ! isEmpty || ! createBlock ) return el( BlockEdit, props );

            function insertGroup() {
                dispatch.insertBlock(
                    createBlock( 'core/group', { metadata: { name: 'Container' } }, [] ),
                    0, clientId
                );
            }

            function insertColumns( n ) {
                var cols = [];
                for ( var i = 0; i < n; i++ ) cols.push( createBlock( 'core/column', {}, [] ) );
                dispatch.insertBlock( createBlock( 'core/columns', {}, cols ), 0, clientId );
            }

            function insertColumn() {
                dispatch.insertBlock( createBlock( 'core/column', {}, [] ), undefined, clientId );
            }

            var isSection = props.name === 'paksa/section';
            var isGroup   = props.name === 'core/group';
            var isCols    = props.name === 'core/columns';

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( 'div', { className: 'pk-empty-state pk-empty-state--' + props.name.replace( /\//g, '-' ) },
                    el( 'span', { className: 'pk-empty-state__label' },
                        isSection ? 'Empty Section' : isGroup ? 'Empty Container' : 'Empty Columns'
                    ),
                    isSection ? el( 'div', { className: 'pk-empty-state__actions' },
                        el( 'button', {
                            className: 'pk-empty-btn',
                            onClick: insertGroup,
                            title: 'Add a container group'
                        }, '+ Container' ),
                        el( 'button', {
                            className: 'pk-empty-btn',
                            onClick: function() { insertColumns( 2 ); },
                            title: 'Add 2 columns'
                        }, '+ 2 Columns' ),
                        el( 'button', {
                            className: 'pk-empty-btn',
                            onClick: function() { insertColumns( 3 ); },
                            title: 'Add 3 columns'
                        }, '+ 3 Columns' )
                    ) : null,
                    isGroup ? el( 'div', { className: 'pk-empty-state__actions' },
                        el( 'button', {
                            className: 'pk-empty-btn',
                            onClick: function() { insertColumns( 2 ); },
                            title: 'Add 2 columns'
                        }, '+ 2 Columns' ),
                        el( 'button', {
                            className: 'pk-empty-btn',
                            onClick: function() { insertColumns( 3 ); },
                            title: '+ 3 Columns'
                        }, '+ 3 Columns' )
                    ) : null,
                    isCols ? el( 'div', { className: 'pk-empty-state__actions' },
                        el( 'button', {
                            className: 'pk-empty-btn',
                            onClick: insertColumn,
                            title: 'Add a column'
                        }, '+ Add Column' )
                    ) : null
                )
            );
        };
    }, 'withPaksaEmptyState' );

    addFilter( 'editor.BlockEdit', 'paksa/empty-state', withEmptyState );

} )( window.wp );

/* ── IIFE 6: Column resize — discrete safe steps ────────────────────────── */
/* Adds a compact visual column-width stepper to core/column toolbar.        */
/* Uses discrete preset steps (25/33/40/50/60/67/75/auto) — no fragile      */
/* continuous drag that could corrupt column layout. All changes update the  */
/* native core/column width attribute and are fully undoable.                */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var BlockControls  = wp.blockEditor.BlockControls;
    var ToolbarGroup   = wp.components.ToolbarGroup;
    var ToolbarButton  = wp.components.ToolbarButton;
    var Dropdown       = wp.components.Dropdown;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var STEPS = [
        { label: 'Auto', value: '' },
        { label: '25%',  value: '25%' },
        { label: '33%',  value: '33.33%' },
        { label: '40%',  value: '40%' },
        { label: '50%',  value: '50%' },
        { label: '60%',  value: '60%' },
        { label: '67%',  value: '66.66%' },
        { label: '75%',  value: '75%' },
    ];

    var withColumnResize = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( props.name !== 'core/column' ) return el( BlockEdit, props );

            var a   = props.attributes;
            var set = props.setAttributes;
            var cur = a.width || '';

            var curLabel = ( STEPS.find( function( s ) { return s.value === cur; } ) || STEPS[0] ).label;

            function narrower() {
                var idx = STEPS.findIndex( function( s ) { return s.value === cur; } );
                if ( idx <= 0 ) return;
                set( { width: STEPS[ idx - 1 ].value } );
            }

            function wider() {
                var idx = STEPS.findIndex( function( s ) { return s.value === cur; } );
                if ( idx === -1 ) idx = 0;
                if ( idx >= STEPS.length - 1 ) return;
                set( { width: STEPS[ idx + 1 ].value } );
            }

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( BlockControls, { group: 'block' },
                    el( ToolbarGroup, {},
                        el( ToolbarButton, {
                            icon: 'arrow-left-alt2',
                            label: 'Narrower',
                            onClick: narrower,
                            disabled: cur === '' || cur === STEPS[0].value
                        } ),
                        el( Dropdown, {
                            className: 'pk-col-resize-dropdown',
                            renderToggle: function( ref ) {
                                return el( ToolbarButton, {
                                    label: 'Column width: ' + curLabel,
                                    onClick: ref.onToggle,
                                    isActive: ref.isOpen,
                                    className: 'pk-col-resize-btn'
                                }, curLabel );
                            },
                            renderContent: function( ref ) {
                                return el( 'div', { className: 'pk-col-resize-menu' },
                                    el( 'p', { className: 'pk-col-resize-menu__title' }, 'Column Width' ),
                                    STEPS.map( function( s ) {
                                        return el( 'button', {
                                            key: s.label,
                                            className: 'pk-col-resize-option' + ( cur === s.value ? ' is-active' : '' ),
                                            onClick: function() { set( { width: s.value } ); ref.onClose(); },
                                            'aria-label': s.label,
                                            'aria-pressed': cur === s.value
                                        }, s.label );
                                    } )
                                );
                            }
                        } ),
                        el( ToolbarButton, {
                            icon: 'arrow-right-alt2',
                            label: 'Wider',
                            onClick: wider,
                            disabled: cur === STEPS[ STEPS.length - 1 ].value
                        } )
                    )
                )
            );
        };
    }, 'withPaksaColumnResize' );

    addFilter( 'editor.BlockEdit', 'paksa/column-resize', withColumnResize );

} )( window.wp );
