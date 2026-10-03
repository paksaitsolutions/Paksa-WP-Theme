/* ============================================================
   Phase 32 — Section Builder, Reusable Design System & Responsive Composition
   v3.2.0

   IIFE 1: Section Builder PluginSidebar
           - Searchable pattern library (actual registered patterns)
           - Visual layout chooser (real Gutenberg blocks)
           - Page starters (existing composition.php patterns)
   IIFE 2: "+ Add Section" toolbar + root empty-state affordance
   IIFE 3: Section quick-settings panel (layout, bg, spacing, responsive)
   IIFE 4: Save as Pattern + reusable section indicator
   ============================================================ */

/* ── IIFE 1: Section Builder PluginSidebar ──────────────────────────────── */
/* Provides a searchable, categorized section library backed entirely by the  */
/* actual WordPress registered pattern registry (wp.blocks.__experimentalGetAllowedPatterns */
/* or wp.data select('core').getBlockPatterns()). No duplicate pattern storage.*/
/* Layout chooser inserts real core/columns + core/column blocks.             */
/* Page starters insert actual registered patterns from paksa-page-starters.  */
( function( wp ) {
    'use strict';

    var plugins    = wp.plugins;
    var editPost   = ( wp.editor && wp.editor.PluginSidebar ) ? wp.editor : wp.editPost;
    var el         = wp.element.createElement;
    var useState   = wp.element.useState;
    var useEffect  = wp.element.useEffect;
    var useMemo    = wp.element.useMemo;
    var useRef     = wp.element.useRef;
    var useSelect  = wp.data.useSelect;
    var useDispatch = wp.data.useDispatch;
    var PluginSidebar = editPost && editPost.PluginSidebar;
    var PluginToolbarButton = editPost && editPost.PluginToolbarButton;
    var registerPlugin = plugins && plugins.registerPlugin;
    var unregisterPlugin = plugins && plugins.unregisterPlugin;

    if ( ! registerPlugin || ! PluginSidebar ) return;

    var p32 = window.paksaPhase32 || {};
    var CATEGORIES   = p32.patternCategories || [];
    var LAYOUTS      = p32.layoutPresets     || [];
    var PAGE_STARTERS = p32.pageStarters     || [];

    /* ── Shared helpers ── */
    function blockLabel( block ) {
        if ( ! block ) return 'Block';
        if ( block.attributes && block.attributes.metadata && block.attributes.metadata.name ) {
            return block.attributes.metadata.name;
        }
        var map = window.paksaPhase31 && window.paksaPhase31.blockLabels || {};
        return map[ block.name ] || block.name.replace( /^(core|paksa)\//, '' ).replace( /-/g, ' ' ).replace( /\b\w/g, function(c){ return c.toUpperCase(); } );
    }

    /* ── Get patterns from the WP registry ── */
    function usePatterns() {
        return useSelect( function( select ) {
            // WP 6.0+ exposes patterns via core store
            var coreStore = select( 'core' );
            if ( coreStore && coreStore.getBlockPatterns ) {
                return coreStore.getBlockPatterns() || [];
            }
            // Fallback: wp.blocks registry
            if ( wp.blocks && wp.blocks.__experimentalGetAllowedPatterns ) {
                return wp.blocks.__experimentalGetAllowedPatterns() || [];
            }
            return [];
        }, [] );
    }

    /* ── Determine safe insert location ── */
    function useInsertContext() {
        return useSelect( function( select ) {
            var store    = select( 'core/block-editor' );
            var clientId = store.getSelectedBlockClientId();
            if ( ! clientId ) {
                return { rootClientId: undefined, insertIndex: undefined };
            }
            var block = store.getBlock( clientId );
            if ( ! block ) return { rootClientId: undefined, insertIndex: undefined };

            // If selected block is a container, insert inside it
            var containers = [ 'paksa/section', 'core/group', 'core/columns', 'core/column' ];
            if ( containers.indexOf( block.name ) !== -1 ) {
                var inner = store.getBlocks( clientId );
                return { rootClientId: clientId, insertIndex: inner ? inner.length : 0 };
            }

            // Otherwise insert after the selected block in its parent
            var parentId = store.getBlockRootClientId( clientId );
            var siblings = store.getBlocks( parentId || undefined );
            var idx      = ( siblings || [] ).findIndex( function( b ) { return b.clientId === clientId; } );
            return { rootClientId: parentId || undefined, insertIndex: idx !== -1 ? idx + 1 : undefined };
        }, [] );
    }

    /* ── Insert a pattern by slug ── */
    function usePatternInserter() {
        var dispatch    = useDispatch( 'core/block-editor' );
        var insertCtx   = useInsertContext();
        var allPatterns = usePatterns();

        return function( patternSlug ) {
            var pattern = allPatterns.find( function( p ) {
                return p.name === patternSlug;
            } );
            if ( ! pattern || ! pattern.content ) return;

            var blocks = wp.blocks.parse( pattern.content );
            if ( ! blocks || ! blocks.length ) return;

            blocks.forEach( function( block, i ) {
                dispatch.insertBlock(
                    block,
                    insertCtx.insertIndex !== undefined ? insertCtx.insertIndex + i : undefined,
                    insertCtx.rootClientId
                );
            } );

            // Select the first inserted block
            if ( blocks[0] ) {
                setTimeout( function() {
                    dispatch.selectBlock( blocks[0].clientId );
                }, 50 );
            }
        };
    }

    /* ── Insert a blank layout ── */
    function useLayoutInserter() {
        var dispatch  = useDispatch( 'core/block-editor' );
        var insertCtx = useInsertContext();

        return function( layout ) {
            var createBlock = wp.blocks && wp.blocks.createBlock;
            if ( ! createBlock ) return;

            var colBlocks = [];
            for ( var i = 0; i < layout.cols; i++ ) {
                var colAttrs = {};
                if ( layout.widths && layout.widths[ i ] ) {
                    colAttrs.width = layout.widths[ i ];
                }
                colBlocks.push( createBlock( 'core/column', colAttrs, [] ) );
            }

            var sectionBlock = createBlock(
                'paksa/section',
                { metadata: { name: layout.label + ' Section' } },
                layout.cols > 0
                    ? [ createBlock( 'core/columns', {}, colBlocks ) ]
                    : []
            );

            dispatch.insertBlock(
                sectionBlock,
                insertCtx.insertIndex,
                insertCtx.rootClientId
            );

            setTimeout( function() {
                dispatch.selectBlock( sectionBlock.clientId );
            }, 50 );
        };
    }

    /* ── Tab: Layout chooser ── */
    function LayoutTab( props ) {
        var onInsert = props.onInsert;

        return el( 'div', { className: 'pk-sb-layout-tab' },
            el( 'p', { className: 'pk-sb-section-title' }, 'Choose a layout' ),
            el( 'p', { className: 'pk-sb-hint' }, 'Inserts a blank paksa/section with the selected column structure.' ),
            el( 'div', { className: 'pk-sb-layout-grid' },
                LAYOUTS.map( function( layout, i ) {
                    return el( 'button', {
                        key: i,
                        className: 'pk-sb-layout-option',
                        onClick: function() { onInsert( layout ); },
                        title: layout.label,
                        'aria-label': 'Insert ' + layout.label + ' layout'
                    },
                        el( 'span', { className: 'pk-sb-layout-diagram', 'aria-hidden': 'true' }, layout.diagram ),
                        el( 'span', { className: 'pk-sb-layout-label' }, layout.label )
                    );
                } )
            )
        );
    }

    /* ── Tab: Pattern library ── */
    function PatternTab( props ) {
        var onInsert    = props.onInsert;
        var allPatterns = usePatterns();

        var searchState = useState( '' );
        var search      = searchState[0];
        var setSearch   = searchState[1];

        var catState    = useState( 'all' );
        var activeCat   = catState[0];
        var setActiveCat = catState[1];

        var searchRef = useRef( null );

        useEffect( function() {
            if ( searchRef.current ) searchRef.current.focus();
        }, [] );

        // Filter patterns to only Paksa patterns
        var paksaPatterns = useMemo( function() {
            return ( allPatterns || [] ).filter( function( p ) {
                return p.name && p.name.indexOf( 'paksa-it-solutions/' ) === 0;
            } );
        }, [ allPatterns ] );

        // Apply category + search filter
        var filtered = useMemo( function() {
            var q = search.toLowerCase().trim();
            return paksaPatterns.filter( function( p ) {
                // Category filter
                if ( activeCat !== 'all' ) {
                    var cats = p.categories || [];
                    if ( cats.indexOf( activeCat ) === -1 ) return false;
                }
                // Search filter
                if ( q ) {
                    var title = ( p.title || '' ).toLowerCase();
                    var desc  = ( p.description || '' ).toLowerCase();
                    var name  = ( p.name || '' ).toLowerCase();
                    return title.indexOf( q ) !== -1 || desc.indexOf( q ) !== -1 || name.indexOf( q ) !== -1;
                }
                return true;
            } );
        }, [ paksaPatterns, activeCat, search ] );

        return el( 'div', { className: 'pk-sb-pattern-tab' },

            /* Search */
            el( 'div', { className: 'pk-sb-search-wrap' },
                el( 'input', {
                    ref: searchRef,
                    type: 'search',
                    className: 'pk-sb-search',
                    placeholder: 'Search sections…',
                    value: search,
                    onChange: function( e ) { setSearch( e.target.value ); },
                    'aria-label': 'Search sections'
                } ),
                search ? el( 'button', {
                    className: 'pk-sb-search-clear',
                    onClick: function() { setSearch( '' ); },
                    'aria-label': 'Clear search',
                    title: 'Clear'
                }, '✕' ) : null
            ),

            /* Category tabs */
            el( 'div', { className: 'pk-sb-cats', role: 'tablist', 'aria-label': 'Pattern categories' },
                el( 'button', {
                    className: 'pk-sb-cat' + ( activeCat === 'all' ? ' is-active' : '' ),
                    onClick: function() { setActiveCat( 'all' ); },
                    role: 'tab',
                    'aria-selected': activeCat === 'all'
                }, 'All' ),
                CATEGORIES.map( function( cat ) {
                    return el( 'button', {
                        key: cat.slug,
                        className: 'pk-sb-cat' + ( activeCat === cat.slug ? ' is-active' : '' ),
                        onClick: function() { setActiveCat( cat.slug ); },
                        role: 'tab',
                        'aria-selected': activeCat === cat.slug,
                        title: cat.label
                    },
                        el( 'span', { 'aria-hidden': 'true' }, cat.icon ),
                        ' ',
                        cat.label
                    );
                } )
            ),

            /* Results */
            filtered.length === 0
                ? el( 'div', { className: 'pk-sb-empty' },
                    el( 'p', {}, search ? 'No sections match "' + search + '".' : 'No sections in this category.' )
                  )
                : el( 'div', { className: 'pk-sb-pattern-list', role: 'list' },
                    filtered.map( function( pattern ) {
                        return el( 'button', {
                            key: pattern.name,
                            className: 'pk-sb-pattern-item',
                            onClick: function() { onInsert( pattern.name ); },
                            role: 'listitem',
                            'aria-label': 'Insert ' + pattern.title
                        },
                            el( 'div', { className: 'pk-sb-pattern-thumb', 'aria-hidden': 'true' },
                                el( 'span', { className: 'pk-sb-pattern-thumb-icon' },
                                    ( function() {
                                        var cat = CATEGORIES.find( function( c ) {
                                            return pattern.categories && pattern.categories.indexOf( c.slug ) !== -1;
                                        } );
                                        return cat ? cat.icon : '▤';
                                    } )()
                                )
                            ),
                            el( 'div', { className: 'pk-sb-pattern-info' },
                                el( 'span', { className: 'pk-sb-pattern-title' }, pattern.title || pattern.name ),
                                pattern.description
                                    ? el( 'span', { className: 'pk-sb-pattern-desc' }, pattern.description )
                                    : null
                            ),
                            el( 'span', { className: 'pk-sb-pattern-insert', 'aria-hidden': 'true' }, '+' )
                        );
                    } )
                  )
        );
    }

    /* ── Tab: Page starters ── */
    function StartersTab( props ) {
        var onInsert    = props.onInsert;
        var allPatterns = usePatterns();
        var blockCount  = useSelect( function( select ) {
            return ( select( 'core/block-editor' ).getBlocks() || [] ).length;
        }, [] );

        var hasContent = blockCount > 0;

        return el( 'div', { className: 'pk-sb-starters-tab' },
            el( 'p', { className: 'pk-sb-section-title' }, 'Full page starters' ),
            el( 'p', { className: 'pk-sb-hint' },
                hasContent
                    ? '⚠ This page already has content. Inserting a starter will add sections after the existing content.'
                    : 'Insert a complete page composition as a starting point. All content is editable.'
            ),
            el( 'div', { className: 'pk-sb-starters-grid' },
                PAGE_STARTERS.map( function( starter ) {
                    var pattern = allPatterns.find( function( p ) { return p.name === starter.slug; } );
                    if ( ! pattern ) return null;
                    return el( 'button', {
                        key: starter.slug,
                        className: 'pk-sb-starter-item',
                        onClick: function() {
                            if ( hasContent ) {
                                if ( ! window.confirm( 'This page already has content. Insert "' + starter.title + '" after the existing content?' ) ) return;
                            }
                            onInsert( starter.slug );
                        },
                        'aria-label': 'Insert ' + starter.title + ' page starter'
                    },
                        el( 'span', { className: 'pk-sb-starter-icon', 'aria-hidden': 'true' }, starter.icon ),
                        el( 'div', { className: 'pk-sb-starter-info' },
                            el( 'span', { className: 'pk-sb-starter-title' }, starter.title ),
                            el( 'span', { className: 'pk-sb-starter-desc' }, starter.description )
                        )
                    );
                } )
            )
        );
    }

    /* ── Main Section Builder panel ── */
    function SectionBuilder() {
        var tabState    = useState( 'layout' );
        var activeTab   = tabState[0];
        var setTab      = tabState[1];

        var insertPattern = usePatternInserter();
        var insertLayout  = useLayoutInserter();

        var tabs = [
            { key: 'layout',   label: 'Layout',   icon: '⊞' },
            { key: 'patterns', label: 'Sections',  icon: '▤' },
            { key: 'starters', label: 'Starters',  icon: '⊡' },
        ];

        return el( 'div', { className: 'pk-section-builder' },

            /* Tab bar */
            el( 'div', { className: 'pk-sb-tabs', role: 'tablist', 'aria-label': 'Section builder' },
                tabs.map( function( tab ) {
                    return el( 'button', {
                        key: tab.key,
                        className: 'pk-sb-tab' + ( activeTab === tab.key ? ' is-active' : '' ),
                        onClick: function() { setTab( tab.key ); },
                        role: 'tab',
                        'aria-selected': activeTab === tab.key,
                        'aria-controls': 'pk-sb-panel-' + tab.key
                    },
                        el( 'span', { 'aria-hidden': 'true' }, tab.icon ),
                        el( 'span', { className: 'pk-sb-tab-label' }, tab.label )
                    );
                } )
            ),

            /* Tab panels */
            el( 'div', {
                id: 'pk-sb-panel-layout',
                className: 'pk-sb-panel',
                role: 'tabpanel',
                hidden: activeTab !== 'layout'
            }, activeTab === 'layout' ? el( LayoutTab, { onInsert: insertLayout } ) : null ),

            el( 'div', {
                id: 'pk-sb-panel-patterns',
                className: 'pk-sb-panel',
                role: 'tabpanel',
                hidden: activeTab !== 'patterns'
            }, activeTab === 'patterns' ? el( PatternTab, { onInsert: insertPattern } ) : null ),

            el( 'div', {
                id: 'pk-sb-panel-starters',
                className: 'pk-sb-panel',
                role: 'tabpanel',
                hidden: activeTab !== 'starters'
            }, activeTab === 'starters' ? el( StartersTab, { onInsert: insertPattern } ) : null )
        );
    }

    registerPlugin( 'paksa-section-builder', {
        render: function() {
            return el( PluginSidebar, {
                name:      'paksa-section-builder',
                title:     'Section Builder',
                icon:      'layout',
                className: 'pk-section-builder-sidebar'
            }, el( SectionBuilder, {} ) );
        }
    } );

    /* PluginToolbarButton removed in WP 6.6+ — toolbar button omitted */

} )( window.wp );

/* ── IIFE 2: "+ Add Section" toolbar button on paksa/section ────────────── */
/* Adds a compact "Add Section" toolbar button to paksa/section that opens   */
/* the Section Builder sidebar. Also improves the Phase 29 empty-state for   */
/* the root canvas by adding a "Start building" affordance when the page is  */
/* completely empty — using the existing Phase 29 empty-state infrastructure. */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose || ! wp.data ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var BlockControls  = wp.blockEditor.BlockControls;
    var ToolbarGroup   = wp.components.ToolbarGroup;
    var ToolbarButton  = wp.components.ToolbarButton;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;
    var useDispatch    = wp.data.useDispatch;
    var useSelect      = wp.data.useSelect;

    /* ── HOC: Add Section toolbar button on paksa/section ── */
    var withAddSectionToolbar = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( props.name !== 'paksa/section' ) return el( BlockEdit, props );

            function openBuilder() {
                try {
                    var dispatch = wp.data.dispatch( 'core/edit-post' ) || wp.data.dispatch( 'core/editor' );
                    if ( dispatch && dispatch.openGeneralSidebar ) {
                        dispatch.openGeneralSidebar( 'paksa-section-builder/paksa-section-builder' );
                    }
                } catch(e) {}
            }

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( BlockControls, { group: 'other' },
                    el( ToolbarGroup, {},
                        el( ToolbarButton, {
                            icon: 'plus-alt2',
                            label: 'Add Section',
                            title: 'Open Section Builder',
                            onClick: openBuilder,
                            className: 'pk-add-section-btn'
                        } )
                    )
                )
            );
        };
    }, 'withPaksaAddSectionToolbar' );

    addFilter( 'editor.BlockEdit', 'paksa/add-section-toolbar', withAddSectionToolbar );

    /* ── Root empty-state: "Start building" affordance ── */
    /* Shown when the page has zero blocks. Complements Phase 29 empty-state  */
    /* which targets empty containers. This targets the root canvas.          */
    wp.domReady( function() {
        var prevCount = -1;

        wp.data.subscribe( function() {
            var store  = wp.data.select( 'core/block-editor' );
            var blocks = store.getBlocks();
            var count  = blocks ? blocks.length : 0;

            if ( count === prevCount ) return;
            prevCount = count;

            var existing = document.querySelector( '.pk-root-empty-state' );

            if ( count > 0 ) {
                if ( existing ) existing.remove();
                return;
            }

            if ( existing ) return; // already shown

            // Wait for canvas to be ready
            var canvas = document.querySelector( '.editor-styles-wrapper, .block-editor-block-list__layout' );
            if ( ! canvas ) return;

            var banner = document.createElement( 'div' );
            banner.className = 'pk-root-empty-state';
            banner.setAttribute( 'role', 'region' );
            banner.setAttribute( 'aria-label', 'Start building your page' );
            banner.innerHTML =
                '<div class="pk-root-empty-state__inner">' +
                    '<p class="pk-root-empty-state__title">Start building your page</p>' +
                    '<p class="pk-root-empty-state__hint">Choose a layout, insert a section pattern, or start with a full page starter.</p>' +
                    '<button class="pk-root-empty-btn pk-root-empty-btn--primary" aria-label="Open Section Builder">+ Add Section</button>' +
                '</div>';

            banner.querySelector( '.pk-root-empty-btn--primary' ).addEventListener( 'click', function() {
                try {
                    var dispatch = wp.data.dispatch( 'core/edit-post' ) || wp.data.dispatch( 'core/editor' );
                    if ( dispatch && dispatch.openGeneralSidebar ) {
                        dispatch.openGeneralSidebar( 'paksa-section-builder/paksa-section-builder' );
                    }
                } catch(e) {}
            } );

            canvas.appendChild( banner );
        } );
    } );

} )( window.wp );

/* ── IIFE 3: Section quick-settings panel ───────────────────────────────── */
/* Adds a compact "Section" Inspector panel to paksa/section with:           */
/*   - Layout quick-switch (insert columns, safe — warns before destructive) */
/*   - Background variant chips (reuses existing variant attribute)          */
/*   - Spacing presets (reuses Phase 29 style.spacing.padding path)          */
/*   - Responsive summary (reads pkMobileCols/pkTabletCols from child cols)  */
/*   - Container width quick-switch (reuses Phase 29 containerWidth attr)    */
/* All writes use existing registered attributes. No new attributes.         */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose || ! wp.data ) return;
    if ( ! window.paksaVisual ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var useState       = wp.element.useState;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var Button         = wp.components.Button;
    var SelectControl  = wp.components.SelectControl;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;
    var useSelect      = wp.data.useSelect;
    var useDispatch    = wp.data.useDispatch;

    var p32 = window.paksaPhase32 || {};
    var SPACING_PRESETS   = p32.spacingPresets   || [];
    var CONTAINER_WIDTHS  = p32.containerWidths  || [];
    var SECTION_VARIANTS  = p32.sectionVariants  || [];
    var LAYOUTS           = p32.layoutPresets    || [];

    /* ── Layout quick-switch ── */
    function LayoutQuickSwitch( props ) {
        var clientId  = props.clientId;
        var dispatch  = useDispatch( 'core/block-editor' );
        var innerBlocks = useSelect( function( select ) {
            return select( 'core/block-editor' ).getBlocks( clientId ) || [];
        }, [ clientId ] );

        var createBlock = wp.blocks && wp.blocks.createBlock;
        if ( ! createBlock ) return null;

        function applyLayout( layout ) {
            // Find existing core/columns child
            var existingCols = innerBlocks.find( function( b ) { return b.name === 'core/columns'; } );

            if ( existingCols ) {
                var currentColCount = ( existingCols.innerBlocks || [] ).length;
                if ( layout.cols < currentColCount ) {
                    if ( ! window.confirm(
                        'Changing to ' + layout.label + ' will remove ' + ( currentColCount - layout.cols ) + ' column(s) and their content. Continue?'
                    ) ) return;
                }
            }

            // Build new columns block
            var colBlocks = [];
            for ( var i = 0; i < layout.cols; i++ ) {
                var colAttrs = {};
                if ( layout.widths && layout.widths[ i ] ) colAttrs.width = layout.widths[ i ];
                // Preserve existing column content where possible
                if ( existingCols && existingCols.innerBlocks && existingCols.innerBlocks[ i ] ) {
                    colBlocks.push( wp.blocks.cloneBlock( existingCols.innerBlocks[ i ], colAttrs ) );
                } else {
                    colBlocks.push( createBlock( 'core/column', colAttrs, [] ) );
                }
            }

            var newCols = createBlock( 'core/columns', {}, colBlocks );

            if ( existingCols ) {
                dispatch.replaceBlock( existingCols.clientId, newCols );
            } else {
                dispatch.insertBlock( newCols, 0, clientId );
            }
        }

        return el( 'div', { className: 'pk-qs-layout' },
            el( 'p', { className: 'pk-qs-label' }, 'Layout' ),
            el( 'div', { className: 'pk-qs-layout-grid' },
                LAYOUTS.map( function( layout, i ) {
                    return el( 'button', {
                        key: i,
                        className: 'pk-qs-layout-btn',
                        onClick: function() { applyLayout( layout ); },
                        title: layout.label,
                        'aria-label': layout.label
                    },
                        el( 'span', { className: 'pk-qs-layout-diagram', 'aria-hidden': 'true' }, layout.diagram ),
                        el( 'span', { className: 'pk-qs-layout-label' }, layout.label )
                    );
                } )
            )
        );
    }

    /* ── Spacing presets ── */
    function SpacingPresets( props ) {
        var a   = props.attributes;
        var set = props.setAttributes;

        function applySpacing( value ) {
            var s  = a.style || {};
            var sp = s.spacing || {};
            set( {
                style: Object.assign( {}, s, {
                    spacing: Object.assign( {}, sp, {
                        padding: Object.assign( {}, sp.padding || {}, { top: value, bottom: value } )
                    } )
                } )
            } );
        }

        var curTop = ( a.style && a.style.spacing && a.style.spacing.padding && a.style.spacing.padding.top ) || '';

        return el( 'div', { className: 'pk-qs-spacing' },
            el( 'p', { className: 'pk-qs-label' }, 'Spacing' ),
            el( 'div', { className: 'pk-qs-spacing-presets' },
                SPACING_PRESETS.map( function( p ) {
                    return el( Button, {
                        key: p.label,
                        isSmall: true,
                        variant: curTop === p.value ? 'primary' : 'secondary',
                        onClick: function() { applySpacing( p.value ); },
                        title: 'Set padding to ' + p.label
                    }, p.label );
                } )
            )
        );
    }

    /* ── Responsive summary ── */
    function ResponsiveSummary( props ) {
        var clientId = props.clientId;

        var colsInfo = useSelect( function( select ) {
            var store = select( 'core/block-editor' );
            var inner = store.getBlocks( clientId ) || [];
            var colsBlock = inner.find( function( b ) { return b.name === 'core/columns'; } );
            if ( ! colsBlock ) return null;
            var desktopCols = ( colsBlock.innerBlocks || [] ).length;
            var tabletCols  = parseInt( colsBlock.attributes.pkTabletCols, 10 ) || 2;
            var mobileCols  = parseInt( colsBlock.attributes.pkMobileCols, 10 ) || 1;
            var stackMobile = colsBlock.attributes.pkStackMobile !== false;
            return { desktop: desktopCols, tablet: tabletCols, mobile: stackMobile ? 1 : mobileCols };
        }, [ clientId ] );

        var visClass = props.attributes.className || '';
        var hideDesktop = visClass.indexOf( 'pk-hide-desktop' ) !== -1;
        var hideTablet  = visClass.indexOf( 'pk-hide-tablet' )  !== -1;
        var hideMobile  = visClass.indexOf( 'pk-hide-mobile' )  !== -1;

        return el( 'div', { className: 'pk-qs-responsive' },
            el( 'p', { className: 'pk-qs-label' }, 'Responsive' ),
            el( 'div', { className: 'pk-qs-responsive-rows' },
                [
                    { key: 'desktop', icon: '🖥', label: 'Desktop', hidden: hideDesktop, cols: colsInfo && colsInfo.desktop },
                    { key: 'tablet',  icon: '▣',  label: 'Tablet',  hidden: hideTablet,  cols: colsInfo && colsInfo.tablet },
                    { key: 'mobile',  icon: '📱', label: 'Mobile',  hidden: hideMobile,  cols: colsInfo && colsInfo.mobile },
                ].map( function( row ) {
                    return el( 'div', { key: row.key, className: 'pk-qs-responsive-row' },
                        el( 'span', { className: 'pk-qs-responsive-icon', 'aria-hidden': 'true' }, row.icon ),
                        el( 'span', { className: 'pk-qs-responsive-label' }, row.label ),
                        row.cols ? el( 'span', { className: 'pk-qs-responsive-cols' }, row.cols + ' col' + ( row.cols !== 1 ? 's' : '' ) ) : null,
                        el( 'span', {
                            className: 'pk-qs-responsive-vis pk-qs-responsive-vis--' + ( row.hidden ? 'hidden' : 'visible' )
                        }, row.hidden ? '✕ Hidden' : '✓ Visible' )
                    );
                } )
            )
        );
    }

    /* ── Main HOC ── */
    var withSectionQuickSettings = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( props.name !== 'paksa/section' ) return el( BlockEdit, props );

            var a        = props.attributes;
            var set      = props.setAttributes;
            var clientId = props.clientId;

            var variantOpts = [ { label: '— Default —', value: '' } ].concat(
                SECTION_VARIANTS.map( function( v ) { return { label: v.label, value: v.value }; } )
            );
            var widthOpts = CONTAINER_WIDTHS.map( function( w ) {
                return { label: w.label + ' (' + w.px + ')', value: w.value };
            } );

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {},
                    el( PanelBody, {
                        title: 'Section',
                        initialOpen: true,
                        className: 'pk-section-qs-panel'
                    },
                        /* Variant */
                        el( SelectControl, {
                            label: 'Background Variant',
                            value: a.variant || '',
                            options: variantOpts,
                            onChange: function( v ) { set( { variant: v } ); }
                        } ),

                        /* Container width */
                        el( SelectControl, {
                            label: 'Container Width',
                            value: a.containerWidth || 'default',
                            options: widthOpts,
                            onChange: function( v ) { set( { containerWidth: v } ); }
                        } ),

                        /* Spacing presets */
                        el( SpacingPresets, { attributes: a, setAttributes: set } ),

                        /* Layout quick-switch */
                        el( LayoutQuickSwitch, { clientId: clientId } ),

                        /* Responsive summary */
                        el( ResponsiveSummary, { clientId: clientId, attributes: a } )
                    )
                )
            );
        };
    }, 'withPaksaSectionQuickSettings' );

    addFilter( 'editor.BlockEdit', 'paksa/section-quick-settings', withSectionQuickSettings );

} )( window.wp );

/* ── IIFE 4: Save as Pattern + reusable section indicator ───────────────── */
/* Save as Pattern: uses wp.data dispatch('core').saveEntityRecord to create  */
/* a wp_block (reusable block) from the selected section. This is the native  */
/* WordPress reusable block infrastructure — no custom database.              */
/* Reusable indicator: reads the block's reusableBlock context and shows a    */
/* "Reusable" badge in the Inspector when the block is synced.                */
/* Both features are editor-only. No frontend output.                         */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose || ! wp.data ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var useState       = wp.element.useState;
    var useEffect      = wp.element.useEffect;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var BlockControls  = wp.blockEditor.BlockControls;
    var PanelBody      = wp.components.PanelBody;
    var Button         = wp.components.Button;
    var TextControl    = wp.components.TextControl;
    var Notice         = wp.components.Notice;
    var ToolbarGroup   = wp.components.ToolbarGroup;
    var ToolbarButton  = wp.components.ToolbarButton;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;
    var useDispatch    = wp.data.useDispatch;
    var useSelect      = wp.data.useSelect;

    var SAVE_BLOCKS = [ 'paksa/section', 'core/group' ];

    /* ── Save as Pattern HOC ── */
    var withSaveAsPattern = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( SAVE_BLOCKS.indexOf( props.name ) === -1 ) return el( BlockEdit, props );

            var a        = props.attributes;
            var clientId = props.clientId;

            var saveState   = useState( 'idle' ); // 'idle' | 'naming' | 'saving' | 'saved' | 'error'
            var status      = saveState[0];
            var setStatus   = saveState[1];

            var nameState   = useState( '' );
            var patternName = nameState[0];
            var setName     = nameState[1];

            var coreDispatch = useDispatch( 'core' );

            /* Detect if this block is already a reusable block */
            var isReusable = useSelect( function( select ) {
                var store = select( 'core/block-editor' );
                var block = store.getBlock( clientId );
                return block && block.name === 'core/block';
            }, [ clientId ] );

            /* Default name from metadata.name */
            useEffect( function() {
                if ( status === 'naming' && ! patternName ) {
                    var label = ( a.metadata && a.metadata.name ) ? a.metadata.name : 'My Section';
                    setName( label );
                }
            }, [ status ] );

            function doSave() {
                if ( ! patternName.trim() ) return;
                setStatus( 'saving' );

                var store = wp.data.select( 'core/block-editor' );
                var block = store.getBlock( clientId );
                if ( ! block ) { setStatus( 'error' ); return; }

                var serialized = wp.blocks.serialize( [ block ] );

                coreDispatch.saveEntityRecord( 'postType', 'wp_block', {
                    title:   patternName.trim(),
                    content: serialized,
                    status:  'publish',
                } ).then( function() {
                    setStatus( 'saved' );
                    setTimeout( function() { setStatus( 'idle' ); }, 3000 );
                } ).catch( function() {
                    setStatus( 'error' );
                    setTimeout( function() { setStatus( 'idle' ); }, 4000 );
                } );
            }

            var savePanel = el( PanelBody, {
                title: 'Reuse & Save',
                initialOpen: false,
                className: 'pk-save-pattern-panel'
            },
                isReusable
                    ? el( 'div', { className: 'pk-reusable-badge' },
                        el( 'span', { className: 'pk-reusable-badge__icon', 'aria-hidden': 'true' }, '⟳' ),
                        el( 'span', { className: 'pk-reusable-badge__label' }, 'Synced / Reusable block' ),
                        el( 'p', { className: 'pk-reusable-badge__hint' }, 'Edits here update all instances. Use "Detach" in the block toolbar to make it independent.' )
                      )
                    : null,

                status === 'saved'
                    ? el( Notice, { status: 'success', isDismissible: false },
                        'Pattern saved to Reusable Blocks.'
                      )
                    : null,

                status === 'error'
                    ? el( Notice, { status: 'error', isDismissible: false },
                        'Could not save pattern. Check your permissions.'
                      )
                    : null,

                status === 'idle' || status === 'saved' || status === 'error'
                    ? el( Button, {
                        variant: 'secondary',
                        isSmall: true,
                        onClick: function() { setStatus( 'naming' ); setName( '' ); },
                        className: 'pk-save-pattern-btn'
                    }, '⊕ Save as Reusable Pattern' )
                    : null,

                status === 'naming'
                    ? el( Fragment, {},
                        el( TextControl, {
                            label: 'Pattern name',
                            value: patternName,
                            onChange: setName,
                            placeholder: 'e.g. Hero Section',
                            help: 'Saved to Reusable Blocks. Available on all pages.'
                        } ),
                        el( 'div', { className: 'pk-save-pattern-actions' },
                            el( Button, {
                                variant: 'primary',
                                isSmall: true,
                                onClick: doSave,
                                disabled: ! patternName.trim()
                            }, 'Save' ),
                            el( Button, {
                                variant: 'tertiary',
                                isSmall: true,
                                onClick: function() { setStatus( 'idle' ); }
                            }, 'Cancel' )
                        )
                      )
                    : null,

                status === 'saving'
                    ? el( 'p', { className: 'pk-save-pattern-saving' }, 'Saving…' )
                    : null
            );

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {}, savePanel )
            );
        };
    }, 'withPaksaSaveAsPattern' );

    addFilter( 'editor.BlockEdit', 'paksa/save-as-pattern', withSaveAsPattern );

    /* ── Extend window.paksaVisual.CANVAS with Phase 32 capabilities ── */
    if ( window.paksaVisual && window.paksaVisual.CANVAS ) {
        var canvas = window.paksaVisual.CANVAS;
        if ( canvas[ 'paksa/section' ] ) {
            canvas[ 'paksa/section' ].saveAsPattern  = true;
            canvas[ 'paksa/section' ].layoutSwitch   = true;
            canvas[ 'paksa/section' ].quickSettings  = true;
            canvas[ 'paksa/section' ].addSection      = true;
        }
        if ( canvas[ 'core/group' ] ) {
            canvas[ 'core/group' ].saveAsPattern = true;
        }
    }

} )( window.wp );
