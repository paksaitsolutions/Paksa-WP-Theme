/* ============================================================
   Phase 28 — Visual Navigator, Container Workflow & Layout Editing
   v2.8.0

   IIFE 1: Paksa Navigator — PluginSidebar with real block tree,
           selection sync, expand/collapse, drag reorder, contextual actions
   IIFE 2: Visual layout chooser on core/columns toolbar
           (add columns safely, never destroy content)
   IIFE 3: Add Container quick action on paksa/section + core/group
   IIFE 4: Safe column count change (add only, never destructive)
   ============================================================ */

/* ── IIFE 1: Paksa Navigator — superseded by Phase 29 IIFE 3 ────────────── */
/* Registration removed: phase 29 registers paksa-navigator with v2 features */
( function( wp ) {
    'use strict';
    return; // Phase 29 handles this registration

    /* Readable label for a block */
    function blockLabel( block ) {
        if ( ! block ) return 'Block';
        // metadata.name set by Phase 27 block naming
        if ( block.attributes && block.attributes.metadata && block.attributes.metadata.name ) {
            return block.attributes.metadata.name;
        }
        // Friendly type labels
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
            'core/html':       'HTML',
            'core/shortcode':  'Shortcode',
            'core/embed':      'Embed',
            'core/video':      'Video',
            'core/audio':      'Audio',
            'core/file':       'File',
            'core/gallery':    'Gallery',
            'core/table':      'Table',
            'core/code':       'Code',
            'core/preformatted': 'Preformatted',
            'core/pullquote':  'Pullquote',
            'core/verse':      'Verse',
            'core/details':    'Details',
            'core/navigation': 'Navigation',
            'core/site-title': 'Site Title',
            'core/site-logo':  'Site Logo',
            'core/post-title': 'Post Title',
            'core/post-content': 'Post Content',
            'core/post-excerpt': 'Post Excerpt',
            'core/post-featured-image': 'Featured Image',
            'core/query':      'Query Loop',
            'core/query-loop': 'Query Loop',
            'core/template-part': 'Template Part',
            'paksa/testimonial': 'Testimonial',
            'paksa/cta':       'CTA',
            'paksa/icon':      'Icon',
            'paksa/action':    'Action',
            'paksa/stat':      'Stat',
            'paksa/breadcrumbs': 'Breadcrumbs',
            'paksa/related-content': 'Related Content',
            'paksa/product-card': 'Product Card',
            'paksa/service-card': 'Service Card',
        };
        return typeMap[ block.name ] || block.name.replace( /^(core|paksa)\//, '' ).replace( /-/g, ' ' ).replace( /\b\w/g, function(c){ return c.toUpperCase(); } );
    }

    /* Icon for block type */
    function blockIcon( blockName ) {
        var icons = {
            'paksa/section':  '▣',
            'core/group':     '⬜',
            'core/columns':   '⊞',
            'core/column':    '▏',
            'core/heading':   'H',
            'core/paragraph': '¶',
            'core/image':     '🖼',
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
        return icons[ blockName ] || '◦';
    }

    /* Recursive Navigator tree node */
    function NavNode( props ) {
        var block          = props.block;
        var depth          = props.depth || 0;
        var selectedId     = props.selectedId;
        var onSelect       = props.onSelect;
        var onMoveUp       = props.onMoveUp;
        var onMoveDown     = props.onMoveDown;
        var onDuplicate    = props.onDuplicate;
        var onRemove       = props.onRemove;
        var parentId       = props.parentId;
        var index          = props.index;
        var siblingCount   = props.siblingCount;

        var hasChildren = block.innerBlocks && block.innerBlocks.length > 0;
        var isSelected  = block.clientId === selectedId;

        var expanded = useState( depth < 2 );
        var isOpen   = expanded[0];
        var setOpen  = expanded[1];

        var label = blockLabel( block );
        var icon  = blockIcon( block.name );

        var indent = depth * 14;

        return el( 'div', { className: 'pk-nav-node' + ( isSelected ? ' is-selected' : '' ) },
            el( 'div', {
                className: 'pk-nav-node__row',
                style: { paddingLeft: ( 8 + indent ) + 'px' },
                onClick: function( e ) {
                    e.stopPropagation();
                    onSelect( block.clientId );
                },
                role: 'button',
                tabIndex: 0,
                'aria-selected': isSelected,
                onKeyDown: function( e ) {
                    if ( e.key === 'Enter' || e.key === ' ' ) {
                        e.preventDefault();
                        onSelect( block.clientId );
                    }
                }
            },
                /* Expand toggle */
                el( 'button', {
                    className: 'pk-nav-node__toggle',
                    onClick: function( e ) {
                        e.stopPropagation();
                        setOpen( ! isOpen );
                    },
                    'aria-label': isOpen ? 'Collapse' : 'Expand',
                    style: { visibility: hasChildren ? 'visible' : 'hidden' }
                }, isOpen ? '▾' : '▸' ),

                /* Icon + label */
                el( 'span', { className: 'pk-nav-node__icon', 'aria-hidden': 'true' }, icon ),
                el( 'span', { className: 'pk-nav-node__label' }, label ),

                /* Actions */
                isSelected ? el( 'span', { className: 'pk-nav-node__actions' },
                    index > 0 ? el( 'button', {
                        className: 'pk-nav-action',
                        title: 'Move up',
                        'aria-label': 'Move ' + label + ' up',
                        onClick: function( e ) { e.stopPropagation(); onMoveUp( block.clientId, parentId, index ); }
                    }, '↑' ) : null,
                    index < siblingCount - 1 ? el( 'button', {
                        className: 'pk-nav-action',
                        title: 'Move down',
                        'aria-label': 'Move ' + label + ' down',
                        onClick: function( e ) { e.stopPropagation(); onMoveDown( block.clientId, parentId, index ); }
                    }, '↓' ) : null,
                    el( 'button', {
                        className: 'pk-nav-action',
                        title: 'Duplicate',
                        'aria-label': 'Duplicate ' + label,
                        onClick: function( e ) { e.stopPropagation(); onDuplicate( block.clientId ); }
                    }, '⧉' ),
                    el( 'button', {
                        className: 'pk-nav-action pk-nav-action--danger',
                        title: 'Delete',
                        'aria-label': 'Delete ' + label,
                        onClick: function( e ) {
                            e.stopPropagation();
                            if ( window.confirm( 'Delete "' + label + '" and all its contents?' ) ) {
                                onRemove( block.clientId );
                            }
                        }
                    }, '✕' )
                ) : null
            ),

            /* Children */
            ( hasChildren && isOpen ) ? el( 'div', { className: 'pk-nav-node__children' },
                block.innerBlocks.map( function( child, i ) {
                    return el( NavNode, {
                        key: child.clientId,
                        block: child,
                        depth: depth + 1,
                        selectedId: selectedId,
                        onSelect: onSelect,
                        onMoveUp: onMoveUp,
                        onMoveDown: onMoveDown,
                        onDuplicate: onDuplicate,
                        onRemove: onRemove,
                        parentId: block.clientId,
                        index: i,
                        siblingCount: block.innerBlocks.length
                    } );
                } )
            ) : null
        );
    }

    /* Navigator panel content */
    function PaksaNavigator() {
        var blocks = useSelect( function( select ) {
            return select( 'core/block-editor' ).getBlocks();
        }, [] );

        var selectedId = useSelect( function( select ) {
            return select( 'core/block-editor' ).getSelectedBlockClientId();
        }, [] );

        var dispatch = useDispatch( 'core/block-editor' );

        function onSelect( clientId ) {
            dispatch.selectBlock( clientId );
        }

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

        if ( ! blocks || blocks.length === 0 ) {
            return el( 'div', { className: 'pk-navigator-empty' },
                el( 'p', {}, 'No blocks on this page yet.' )
            );
        }

        return el( 'div', { className: 'pk-navigator' },
            el( 'div', { className: 'pk-navigator__header' },
                el( 'span', { className: 'pk-navigator__title' }, 'Page Structure' ),
                el( 'span', { className: 'pk-navigator__hint' }, blocks.length + ' top-level blocks' )
            ),
            el( 'div', { className: 'pk-navigator__tree', role: 'tree' },
                blocks.map( function( block, i ) {
                    return el( NavNode, {
                        key: block.clientId,
                        block: block,
                        depth: 0,
                        selectedId: selectedId,
                        onSelect: onSelect,
                        onMoveUp: onMoveUp,
                        onMoveDown: onMoveDown,
                        onDuplicate: onDuplicate,
                        onRemove: onRemove,
                        parentId: undefined,
                        index: i,
                        siblingCount: blocks.length
                    } );
                } )
            )
        );
    }

    /* Register the sidebar plugin */
    registerPlugin( 'paksa-navigator', {
        render: function() {
            return el( PluginSidebar, {
                name: 'paksa-navigator',
                title: 'Paksa Navigator',
                icon: 'layout',
                className: 'pk-navigator-sidebar'
            },
                el( PaksaNavigator, {} )
            );
        }
    } );

} )( window.wp );

/* ── IIFE 2: Visual layout chooser on core/columns toolbar ──────────────── */
/* Shows a compact visual grid diagram picker. Adds columns safely (never    */
/* removes existing content). Reducing columns is blocked to prevent data    */
/* loss — user must manually delete columns.                                 */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose || ! wp.data ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var BlockControls  = wp.blockEditor.BlockControls;
    var ToolbarGroup   = wp.components.ToolbarGroup;
    var ToolbarButton  = wp.components.ToolbarButton;
    var Dropdown       = wp.components.Dropdown;
    var useSelect      = wp.data.useSelect;
    var useDispatch    = wp.data.useDispatch;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    /* Visual diagram strings for each layout */
    var LAYOUTS = [
        { cols: 1, label: '1 Column',   diagram: '█████████' },
        { cols: 2, label: '2 Columns',  diagram: '████ ████' },
        { cols: 3, label: '3 Columns',  diagram: '███ ███ ███' },
        { cols: 4, label: '4 Columns',  diagram: '██ ██ ██ ██' },
        { cols: 2, label: '1/3 + 2/3',  diagram: '███ ██████', widths: [ '33.33%', '66.66%' ] },
        { cols: 2, label: '2/3 + 1/3',  diagram: '██████ ███', widths: [ '66.66%', '33.33%' ] },
        { cols: 2, label: '1/4 + 3/4',  diagram: '██ ███████', widths: [ '25%', '75%' ] },
        { cols: 2, label: '3/4 + 1/4',  diagram: '███████ ██', widths: [ '75%', '25%' ] },
    ];

    var withColumnsLayoutPicker = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( props.name !== 'core/columns' ) return el( BlockEdit, props );

            var clientId    = props.clientId;
            var innerBlocks = useSelect( function( select ) {
                return select( 'core/block-editor' ).getBlocks( clientId );
            }, [ clientId ] );

            var dispatch    = useDispatch( 'core/block-editor' );
            var createBlock = wp.blocks && wp.blocks.createBlock;

            if ( ! createBlock ) return el( BlockEdit, props );

            var currentCols = innerBlocks ? innerBlocks.length : 0;

            function applyLayout( layout ) {
                if ( ! layout ) return;
                var targetCols = layout.cols;

                if ( targetCols > currentCols ) {
                    /* Safe: add new empty columns */
                    var toAdd = targetCols - currentCols;
                    for ( var i = 0; i < toAdd; i++ ) {
                        var newCol = createBlock( 'core/column', {}, [] );
                        dispatch.insertBlock( newCol, currentCols + i, clientId );
                    }
                } else if ( targetCols < currentCols ) {
                    /* Unsafe: never silently delete — show notice instead */
                    window.alert(
                        'To reduce from ' + currentCols + ' to ' + targetCols + ' columns, ' +
                        'please manually delete the extra columns in the editor. ' +
                        'This prevents accidental content loss.'
                    );
                    return;
                }

                /* Apply widths if specified */
                if ( layout.widths && innerBlocks ) {
                    layout.widths.forEach( function( w, idx ) {
                        var col = innerBlocks[ idx ];
                        if ( col ) {
                            dispatch.updateBlockAttributes( col.clientId, { width: w } );
                        }
                    } );
                }
            }

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( BlockControls, { group: 'block' },
                    el( ToolbarGroup, {},
                        el( Dropdown, {
                            className: 'pk-layout-picker-dropdown',
                            renderToggle: function( ref ) {
                                return el( ToolbarButton, {
                                    icon: 'columns',
                                    label: 'Change layout',
                                    onClick: ref.onToggle,
                                    isActive: ref.isOpen
                                } );
                            },
                            renderContent: function( ref ) {
                                return el( 'div', { className: 'pk-layout-picker' },
                                    el( 'p', { className: 'pk-layout-picker__title' }, 'Choose layout' ),
                                    el( 'p', { className: 'pk-layout-picker__hint' },
                                        'Current: ' + currentCols + ' column' + ( currentCols !== 1 ? 's' : '' ) +
                                        '. Adding columns is safe. To remove, delete manually.'
                                    ),
                                    el( 'div', { className: 'pk-layout-picker__grid' },
                                        LAYOUTS.map( function( layout, i ) {
                                            var isActive = layout.cols === currentCols && ! layout.widths;
                                            return el( 'button', {
                                                key: i,
                                                className: 'pk-layout-option' + ( isActive ? ' is-active' : '' ),
                                                onClick: function() {
                                                    applyLayout( layout );
                                                    ref.onClose();
                                                },
                                                title: layout.label,
                                                'aria-label': layout.label,
                                                'aria-pressed': isActive
                                            },
                                                el( 'span', { className: 'pk-layout-option__diagram', 'aria-hidden': 'true' }, layout.diagram ),
                                                el( 'span', { className: 'pk-layout-option__label' }, layout.label )
                                            );
                                        } )
                                    )
                                );
                            }
                        } )
                    )
                )
            );
        };
    }, 'withPaksaColumnsLayoutPicker' );

    addFilter( 'editor.BlockEdit', 'paksa/columns-layout-picker', withColumnsLayoutPicker );

} )( window.wp );

/* ── IIFE 3: Add Container quick action on paksa/section + core/group ────── */
/* Toolbar Dropdown with 10 layout presets. Inserts real Gutenberg blocks.   */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose || ! wp.data ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var BlockControls  = wp.blockEditor.BlockControls;
    var ToolbarGroup   = wp.components.ToolbarGroup;
    var ToolbarButton  = wp.components.ToolbarButton;
    var Dropdown       = wp.components.Dropdown;
    var useDispatch    = wp.data.useDispatch;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var CONTAINER_BLOCKS = [ 'paksa/section', 'core/group' ];

    var CONTAINER_PRESETS = [
        { label: 'Empty Container',  icon: '⬜', cols: 0 },
        { label: '1 Column',         icon: '█', cols: 1 },
        { label: '2 Columns',        icon: '█ █', cols: 2 },
        { label: '3 Columns',        icon: '█ █ █', cols: 3 },
        { label: '4 Columns',        icon: '█ █ █ █', cols: 4 },
        { label: '1/2 + 1/2',        icon: '▌▐', cols: 2, widths: [ '50%', '50%' ] },
        { label: '1/3 + 2/3',        icon: '▎▊', cols: 2, widths: [ '33.33%', '66.66%' ] },
        { label: '2/3 + 1/3',        icon: '▊▎', cols: 2, widths: [ '66.66%', '33.33%' ] },
        { label: '1/4 + 3/4',        icon: '▏▉', cols: 2, widths: [ '25%', '75%' ] },
        { label: '3/4 + 1/4',        icon: '▉▏', cols: 2, widths: [ '75%', '25%' ] },
    ];

    var withAddContainer = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( CONTAINER_BLOCKS.indexOf( props.name ) === -1 ) return el( BlockEdit, props );

            var clientId    = props.clientId;
            var dispatch    = useDispatch( 'core/block-editor' );
            var createBlock = wp.blocks && wp.blocks.createBlock;

            if ( ! createBlock ) return el( BlockEdit, props );

            function insertContainer( preset ) {
                var innerBlocks = [];

                if ( preset.cols === 0 ) {
                    /* Empty group container */
                    var container = createBlock( 'core/group', {
                        metadata: { name: 'Container' }
                    }, [] );
                    dispatch.insertBlock( container, undefined, clientId );
                    return;
                }

                /* Build columns */
                var colBlocks = [];
                for ( var i = 0; i < preset.cols; i++ ) {
                    var colAttrs = {};
                    if ( preset.widths && preset.widths[ i ] ) {
                        colAttrs.width = preset.widths[ i ];
                    }
                    colBlocks.push( createBlock( 'core/column', colAttrs, [] ) );
                }

                var columnsBlock = createBlock( 'core/columns', {}, colBlocks );
                dispatch.insertBlock( columnsBlock, undefined, clientId );
            }

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( BlockControls, { group: 'other' },
                    el( ToolbarGroup, {},
                        el( Dropdown, {
                            className: 'pk-add-container-dropdown',
                            renderToggle: function( ref ) {
                                return el( ToolbarButton, {
                                    icon: 'plus-alt2',
                                    label: 'Add container',
                                    onClick: ref.onToggle,
                                    isActive: ref.isOpen
                                } );
                            },
                            renderContent: function( ref ) {
                                return el( 'div', { className: 'pk-add-container-menu' },
                                    el( 'p', { className: 'pk-add-container-menu__title' }, '+ Add Container' ),
                                    CONTAINER_PRESETS.map( function( preset, i ) {
                                        return el( 'button', {
                                            key: i,
                                            className: 'pk-add-container-option',
                                            onClick: function() {
                                                insertContainer( preset );
                                                ref.onClose();
                                            },
                                            'aria-label': preset.label
                                        },
                                            el( 'span', { className: 'pk-add-container-option__icon', 'aria-hidden': 'true' }, preset.icon ),
                                            el( 'span', { className: 'pk-add-container-option__label' }, preset.label )
                                        );
                                    } )
                                );
                            }
                        } )
                    )
                )
            );
        };
    }, 'withPaksaAddContainer' );

    addFilter( 'editor.BlockEdit', 'paksa/add-container', withAddContainer );

} )( window.wp );

/* ── IIFE 4: Navigator toolbar button — removed (PluginToolbarButton removed in WP 6.6+) ── */
( function() {} )();
