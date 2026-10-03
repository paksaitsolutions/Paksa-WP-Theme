/* ============================================================
   Phase 31 — Visual Canvas Interaction Layer
   v3.1.0

   IIFE 1: Canvas targeting — hover outlines + element labels
   IIFE 2: Selected block overlay — breadcrumb, parent nav, quick actions
   IIFE 3: Spacing visualization — inline padding display + click-to-edit
   IIFE 4: Column width feedback badge + alignment guides
   IIFE 5: Insertion indicator + drag affordance enhancements
   ============================================================ */

/* ── IIFE 1: Canvas targeting — hover outlines + element labels ─────────── */
/* Uses event delegation on the editor canvas root. Tracks the single most   */
/* directly targeted block via data-block attribute. Shows a label badge and  */
/* outline only on the innermost hovered block. No continuous scanning.       */
/* Respects RichText editing — suppresses targeting when text is being edited.*/
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.data || ! wp.domReady ) return;

    var useSelect  = wp.data.useSelect;
    var subscribe  = wp.data.subscribe;

    var p31        = window.paksaPhase31 || {};
    var blockLabels = p31.blockLabels || {};

    /* ── Label resolution — prefers metadata.name (Phase 27 naming) ── */
    function resolveLabel( blockName, clientId ) {
        // Try to get metadata.name from the block store
        try {
            var block = wp.data.select( 'core/block-editor' ).getBlock( clientId );
            if ( block && block.attributes && block.attributes.metadata && block.attributes.metadata.name ) {
                return block.attributes.metadata.name;
            }
        } catch(e) {}
        return blockLabels[ blockName ] || blockName.replace( /^(core|paksa)\//, '' ).replace( /-/g, ' ' ).replace( /\b\w/g, function(c){ return c.toUpperCase(); } );
    }

    /* ── Depth color map — mirrors Phase 27/28 depth system ── */
    var DEPTH_COLORS = [ '#6192f8', '#7c5cfc', '#12b76a', '#f79009', '#8a94a0' ];

    function getDepthColor( depth ) {
        return DEPTH_COLORS[ Math.min( depth, DEPTH_COLORS.length - 1 ) ];
    }

    /* ── Compute block depth from DOM nesting ── */
    function getBlockDepth( node ) {
        var depth = 0;
        var cur   = node.parentElement;
        while ( cur ) {
            if ( cur.dataset && cur.dataset.block ) depth++;
            cur = cur.parentElement;
        }
        return depth;
    }

    /* ── Label element pool — one reused element ── */
    var labelEl = null;

    function ensureLabelEl() {
        if ( labelEl ) return labelEl;
        labelEl = document.createElement( 'div' );
        labelEl.className = 'pk-canvas-label';
        labelEl.setAttribute( 'aria-hidden', 'true' );
        labelEl.style.display = 'none';
        document.body.appendChild( labelEl );
        return labelEl;
    }

    /* ── Active hover target tracking ── */
    var currentHoverNode = null;
    var labelRafId       = null;

    function showLabel( node, label, depth ) {
        var el = ensureLabelEl();
        el.textContent = label;
        el.style.display = '';
        el.style.setProperty( '--pk-label-color', getDepthColor( depth ) );

        if ( labelRafId ) cancelAnimationFrame( labelRafId );
        labelRafId = requestAnimationFrame( function() {
            var rect = node.getBoundingClientRect();
            var scrollY = window.scrollY || document.documentElement.scrollTop;
            var scrollX = window.scrollX || document.documentElement.scrollLeft;
            var top  = rect.top  + scrollY - 22;
            var left = rect.left + scrollX;
            // Clamp to viewport
            if ( top < scrollY + 4 ) top = rect.bottom + scrollY + 4;
            el.style.top  = top  + 'px';
            el.style.left = left + 'px';
        } );
    }

    function hideLabel() {
        if ( labelEl ) labelEl.style.display = 'none';
        if ( labelRafId ) { cancelAnimationFrame( labelRafId ); labelRafId = null; }
    }

    /* ── Hover outline via CSS class on the block node ── */
    function applyHoverOutline( node, depth ) {
        node.classList.add( 'pk-canvas-hover' );
        node.style.setProperty( '--pk-hover-depth-color', getDepthColor( depth ) );
    }

    function removeHoverOutline( node ) {
        if ( node ) {
            node.classList.remove( 'pk-canvas-hover' );
            node.style.removeProperty( '--pk-hover-depth-color' );
        }
    }

    /* ── Is user actively editing RichText? ── */
    function isEditingText() {
        var active = document.activeElement;
        if ( ! active ) return false;
        var tag = active.tagName;
        if ( tag === 'INPUT' || tag === 'TEXTAREA' ) return true;
        if ( active.isContentEditable ) return true;
        return false;
    }

    /* ── Is the node inside a selected block? ── */
    function isInsideSelectedBlock( node ) {
        return node.classList.contains( 'is-selected' ) ||
               node.classList.contains( 'has-child-selected' );
    }

    /* ── Main canvas interaction setup ── */
    wp.domReady( function() {
        // Wait for editor canvas to be available
        var attempts = 0;
        var initInterval = setInterval( function() {
            var canvas = document.querySelector( '.editor-styles-wrapper' );
            if ( ! canvas ) {
                if ( ++attempts > 40 ) clearInterval( initInterval );
                return;
            }
            clearInterval( initInterval );
            attachCanvasListeners( canvas );
        }, 250 );
    } );

    function attachCanvasListeners( canvas ) {
        /* Event delegation — single mouseover/mouseout on canvas root */
        canvas.addEventListener( 'mouseover', function( e ) {
            if ( isEditingText() ) {
                if ( currentHoverNode ) {
                    removeHoverOutline( currentHoverNode );
                    currentHoverNode = null;
                }
                hideLabel();
                return;
            }

            // Walk up from target to find the innermost data-block node
            var node = e.target;
            var blockNode = null;
            while ( node && node !== canvas ) {
                if ( node.dataset && node.dataset.block ) {
                    blockNode = node;
                    break;
                }
                node = node.parentElement;
            }

            if ( ! blockNode ) {
                if ( currentHoverNode ) {
                    removeHoverOutline( currentHoverNode );
                    currentHoverNode = null;
                }
                hideLabel();
                return;
            }

            // Same node — no update needed
            if ( blockNode === currentHoverNode ) return;

            // Remove previous
            if ( currentHoverNode && currentHoverNode !== blockNode ) {
                removeHoverOutline( currentHoverNode );
            }

            currentHoverNode = blockNode;
            var clientId  = blockNode.dataset.block;
            var blockType = blockNode.dataset.type || '';
            var depth     = getBlockDepth( blockNode );
            var label     = resolveLabel( blockType, clientId );

            applyHoverOutline( blockNode, depth );
            showLabel( blockNode, label, depth );
        }, { passive: true } );

        canvas.addEventListener( 'mouseout', function( e ) {
            // Only clear when leaving the block node entirely
            var related = e.relatedTarget;
            if ( currentHoverNode && related && currentHoverNode.contains( related ) ) return;
            if ( currentHoverNode ) {
                removeHoverOutline( currentHoverNode );
                currentHoverNode = null;
            }
            hideLabel();
        }, { passive: true } );

        // Clear on text editing start
        canvas.addEventListener( 'focusin', function() {
            if ( isEditingText() ) {
                if ( currentHoverNode ) {
                    removeHoverOutline( currentHoverNode );
                    currentHoverNode = null;
                }
                hideLabel();
            }
        }, { passive: true } );
    }

} )( window.wp );

/* ── IIFE 2: Selected block overlay — breadcrumb + quick actions ─────────── */
/* Renders a floating overlay bar above the selected block showing:           */
/*   - Breadcrumb: ancestor chain (click to select parent)                    */
/*   - Quick actions: Duplicate, Delete (via Gutenberg APIs)                  */
/*   - Copy/Paste Style (reuses Phase 27 sessionStorage clipboard)            */
/* Uses getBoundingClientRect() only on selection change + scroll/resize.     */
/* pointer-events: none on the outline; only the bar itself is interactive.   */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.data || ! wp.element || ! wp.domReady ) return;

    var subscribe   = wp.data.subscribe;
    var select      = wp.data.select;
    var dispatch    = wp.data.dispatch;

    var p31         = window.paksaPhase31 || {};
    var blockLabels = p31.blockLabels || {};
    var p27Data     = window.paksaPhase27 || {};
    var copyableAttrs = p27Data.copyableAttrs || [];
    var STORAGE_KEY = 'pk_copied_style';

    /* ── Label helper ── */
    function resolveLabel( block ) {
        if ( ! block ) return 'Block';
        if ( block.attributes && block.attributes.metadata && block.attributes.metadata.name ) {
            return block.attributes.metadata.name;
        }
        return blockLabels[ block.name ] || block.name.replace( /^(core|paksa)\//, '' ).replace( /-/g, ' ' ).replace( /\b\w/g, function(c){ return c.toUpperCase(); } );
    }

    /* ── Build ancestor chain for breadcrumb ── */
    function getAncestors( clientId ) {
        try {
            var store = select( 'core/block-editor' );
            var parents = store.getBlockParents( clientId );
            return ( parents || [] ).map( function( pid ) {
                return store.getBlock( pid );
            } ).filter( Boolean );
        } catch(e) { return []; }
    }

    /* ── Overlay DOM elements ── */
    var overlayBar    = null;
    var overlayOutline = null;
    var resizeObs     = null;
    var scrollHandler = null;
    var rafId         = null;
    var currentClientId = null;

    function ensureOverlay() {
        if ( overlayBar ) return;

        overlayOutline = document.createElement( 'div' );
        overlayOutline.className = 'pk-overlay-outline';
        overlayOutline.setAttribute( 'aria-hidden', 'true' );
        document.body.appendChild( overlayOutline );

        overlayBar = document.createElement( 'div' );
        overlayBar.className = 'pk-overlay-bar';
        overlayBar.setAttribute( 'role', 'toolbar' );
        overlayBar.setAttribute( 'aria-label', 'Block actions' );
        document.body.appendChild( overlayBar );
    }

    function hideOverlay() {
        if ( overlayBar )    { overlayBar.style.display    = 'none'; }
        if ( overlayOutline ){ overlayOutline.style.display = 'none'; }
    }

    /* ── Position overlay relative to selected block DOM node ── */
    function positionOverlay( node ) {
        if ( ! node || ! overlayBar ) return;
        if ( rafId ) cancelAnimationFrame( rafId );
        rafId = requestAnimationFrame( function() {
            var rect    = node.getBoundingClientRect();
            var scrollY = window.scrollY || document.documentElement.scrollTop;
            var scrollX = window.scrollX || document.documentElement.scrollLeft;

            // Outline
            overlayOutline.style.display = '';
            overlayOutline.style.top     = ( rect.top  + scrollY ) + 'px';
            overlayOutline.style.left    = ( rect.left + scrollX ) + 'px';
            overlayOutline.style.width   = rect.width  + 'px';
            overlayOutline.style.height  = rect.height + 'px';

            // Bar — above the block, clamped to viewport
            var barTop = rect.top + scrollY - 32;
            if ( barTop < scrollY + 4 ) barTop = rect.bottom + scrollY + 4;
            var barLeft = rect.left + scrollX;
            // Clamp right edge
            var barWidth = overlayBar.offsetWidth || 240;
            var maxLeft  = scrollX + window.innerWidth - barWidth - 8;
            if ( barLeft > maxLeft ) barLeft = maxLeft;
            if ( barLeft < scrollX + 4 ) barLeft = scrollX + 4;

            overlayBar.style.display = '';
            overlayBar.style.top     = barTop  + 'px';
            overlayBar.style.left    = barLeft + 'px';
        } );
    }

    /* ── Render overlay bar content ── */
    function renderOverlayBar( clientId ) {
        if ( ! overlayBar ) return;
        var store    = select( 'core/block-editor' );
        var block    = store.getBlock( clientId );
        if ( ! block ) { hideOverlay(); return; }

        var ancestors = getAncestors( clientId );
        var label     = resolveLabel( block );

        // Build breadcrumb HTML
        var breadcrumbHtml = '';
        ancestors.forEach( function( anc ) {
            var ancLabel = resolveLabel( anc );
            breadcrumbHtml += '<button class="pk-overlay-crumb" data-clientid="' + anc.clientId + '" title="Select ' + ancLabel + '" aria-label="Select ' + ancLabel + '">' + ancLabel + '</button><span class="pk-overlay-crumb-sep" aria-hidden="true">›</span>';
        } );
        breadcrumbHtml += '<span class="pk-overlay-current" aria-current="true">' + label + '</span>';

        // Actions
        var hasCopied = false;
        try { hasCopied = !! sessionStorage.getItem( STORAGE_KEY ); } catch(e) {}

        overlayBar.innerHTML =
            '<div class="pk-overlay-breadcrumb" role="navigation" aria-label="Block hierarchy">' + breadcrumbHtml + '</div>' +
            '<div class="pk-overlay-actions">' +
                '<button class="pk-overlay-btn pk-overlay-btn--copy" title="Copy style" aria-label="Copy style">⧉</button>' +
                '<button class="pk-overlay-btn pk-overlay-btn--paste' + ( hasCopied ? '' : ' is-disabled' ) + '" title="Paste style" aria-label="Paste style"' + ( hasCopied ? '' : ' disabled' ) + '>⊕</button>' +
                '<button class="pk-overlay-btn pk-overlay-btn--duplicate" title="Duplicate block" aria-label="Duplicate block">⧉</button>' +
                '<button class="pk-overlay-btn pk-overlay-btn--delete" title="Delete block" aria-label="Delete block">✕</button>' +
            '</div>';

        // Breadcrumb click — select ancestor
        overlayBar.querySelectorAll( '.pk-overlay-crumb' ).forEach( function( btn ) {
            btn.addEventListener( 'click', function( e ) {
                e.stopPropagation();
                var cid = btn.getAttribute( 'data-clientid' );
                if ( cid ) dispatch( 'core/block-editor' ).selectBlock( cid );
            } );
        } );

        // Copy style
        overlayBar.querySelector( '.pk-overlay-btn--copy' ).addEventListener( 'click', function( e ) {
            e.stopPropagation();
            try {
                var style = {};
                copyableAttrs.forEach( function( key ) {
                    if ( block.attributes[ key ] !== undefined && block.attributes[ key ] !== '' ) {
                        style[ key ] = block.attributes[ key ];
                    }
                } );
                sessionStorage.setItem( STORAGE_KEY, JSON.stringify( { blockType: block.name, style: style } ) );
            } catch(err) {}
        } );

        // Paste style
        var pasteBtn = overlayBar.querySelector( '.pk-overlay-btn--paste' );
        if ( pasteBtn && hasCopied ) {
            pasteBtn.addEventListener( 'click', function( e ) {
                e.stopPropagation();
                try {
                    var raw = sessionStorage.getItem( STORAGE_KEY );
                    if ( ! raw ) return;
                    var data = JSON.parse( raw );
                    if ( ! data || ! data.style ) return;
                    var safe = {};
                    copyableAttrs.forEach( function( key ) {
                        if ( data.style[ key ] !== undefined ) safe[ key ] = data.style[ key ];
                    } );
                    dispatch( 'core/block-editor' ).updateBlockAttributes( clientId, safe );
                } catch(err) {}
            } );
        }

        // Duplicate
        overlayBar.querySelector( '.pk-overlay-btn--duplicate' ).addEventListener( 'click', function( e ) {
            e.stopPropagation();
            dispatch( 'core/block-editor' ).duplicateBlocks( [ clientId ] );
        } );

        // Delete
        overlayBar.querySelector( '.pk-overlay-btn--delete' ).addEventListener( 'click', function( e ) {
            e.stopPropagation();
            dispatch( 'core/block-editor' ).removeBlock( clientId );
        } );
    }

    /* ── Update overlay on selection change ── */
    function updateOverlay() {
        var store    = select( 'core/block-editor' );
        var clientId = store.getSelectedBlockClientId();

        if ( ! clientId ) {
            currentClientId = null;
            hideOverlay();
            return;
        }

        ensureOverlay();

        var node = document.querySelector( '[data-block="' + clientId + '"]' );
        if ( ! node ) { hideOverlay(); return; }

        // Only re-render bar content when selection changes
        if ( clientId !== currentClientId ) {
            currentClientId = clientId;
            renderOverlayBar( clientId );
        }

        positionOverlay( node );
    }

    /* ── Subscribe to selection changes ── */
    wp.domReady( function() {
        var prevId = null;

        subscribe( function() {
            var store = select( 'core/block-editor' );
            var id    = store.getSelectedBlockClientId();
            if ( id !== prevId ) {
                prevId = id;
                updateOverlay();
            }
        } );

        // Reposition on scroll and resize without re-rendering content
        window.addEventListener( 'scroll', function() {
            if ( ! currentClientId ) return;
            var node = document.querySelector( '[data-block="' + currentClientId + '"]' );
            if ( node ) positionOverlay( node );
        }, { passive: true } );

        window.addEventListener( 'resize', function() {
            if ( ! currentClientId ) return;
            var node = document.querySelector( '[data-block="' + currentClientId + '"]' );
            if ( node ) positionOverlay( node );
        }, { passive: true } );

        // Reposition when sidebar opens/closes (editor layout changes)
        var sidebarObs = new MutationObserver( function() {
            if ( ! currentClientId ) return;
            var node = document.querySelector( '[data-block="' + currentClientId + '"]' );
            if ( node ) positionOverlay( node );
        } );
        var editorRoot = document.querySelector( '.interface-interface-skeleton' ) || document.body;
        sidebarObs.observe( editorRoot, { attributes: true, attributeFilter: [ 'class' ], subtree: false } );
    } );

} )( window.wp );

/* ── IIFE 3: Spacing visualization — inline padding display + click-to-edit  */
/* Adds a "Show Spacing" toggle to the Inspector for paksa/section + group.   */
/* When active, renders inline padding indicators on the canvas block node.   */
/* Clicking a value opens a small inline input to edit it directly.           */
/* Reads/writes style.spacing.padding — same path as Phase 29 drag handles.  */
/* No new attributes. No new spacing model.                                   */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose || ! wp.data ) return;
    if ( ! window.paksaVisual ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var useState       = wp.element.useState;
    var useEffect      = wp.element.useEffect;
    var useRef         = wp.element.useRef;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var ToggleControl  = wp.components.ToggleControl;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;
    var useDispatch    = wp.data.useDispatch;

    var SPACING_VIZ_BLOCKS = [ 'paksa/section', 'core/group' ];

    /* Parse CSS value to display string */
    function parseDisplay( val ) {
        if ( ! val || val === '0' ) return '0px';
        if ( /var\(--wp--preset--spacing--(\d+)\)/.test( val ) ) {
            var slug = val.match( /--spacing--(\d+)/ )[1];
            var map  = { '20':'8px','30':'12px','40':'16px','50':'24px','60':'32px','70':'48px','80':'64px','90':'80px' };
            return map[ slug ] ? map[ slug ] + ' (' + slug + ')' : val;
        }
        return val;
    }

    /* Inline spacing indicator component — rendered into the block DOM node */
    function SpacingVizOverlay( props ) {
        var clientId      = props.clientId;
        var padding       = props.padding;
        var onEdit        = props.onEdit;

        var editState = useState( null ); // 'top' | 'bottom' | null
        var editSide  = editState[0];
        var setEdit   = editState[1];

        var inputState = useState( '' );
        var inputVal   = inputState[0];
        var setInput   = inputState[1];

        var inputRef = useRef( null );

        useEffect( function() {
            if ( editSide && inputRef.current ) {
                inputRef.current.focus();
                inputRef.current.select();
            }
        }, [ editSide ] );

        function startEdit( side ) {
            setEdit( side );
            setInput( padding[ side ] || '' );
        }

        function commitEdit() {
            if ( editSide ) {
                onEdit( editSide, inputVal );
                setEdit( null );
            }
        }

        var topDisplay    = parseDisplay( padding.top );
        var bottomDisplay = parseDisplay( padding.bottom );

        return el( 'div', { className: 'pk-spacing-viz', 'aria-label': 'Spacing visualization' },
            /* Top padding indicator */
            el( 'div', { className: 'pk-spacing-viz__band pk-spacing-viz__band--top' },
                editSide === 'top'
                    ? el( 'input', {
                        ref: inputRef,
                        className: 'pk-spacing-viz__input',
                        value: inputVal,
                        onChange: function( e ) { setInput( e.target.value ); },
                        onKeyDown: function( e ) {
                            if ( e.key === 'Enter' ) { e.preventDefault(); commitEdit(); }
                            if ( e.key === 'Escape' ) { e.preventDefault(); setEdit( null ); }
                        },
                        onBlur: commitEdit,
                        'aria-label': 'Padding top value',
                        placeholder: 'e.g. 4rem'
                    } )
                    : el( 'button', {
                        className: 'pk-spacing-viz__value',
                        onClick: function() { startEdit( 'top' ); },
                        title: 'Click to edit padding top',
                        'aria-label': 'Padding top: ' + topDisplay + '. Click to edit.'
                    },
                        el( 'span', { className: 'pk-spacing-viz__arrow', 'aria-hidden': 'true' }, '↑' ),
                        topDisplay
                    )
            ),
            /* Bottom padding indicator */
            el( 'div', { className: 'pk-spacing-viz__band pk-spacing-viz__band--bottom' },
                editSide === 'bottom'
                    ? el( 'input', {
                        ref: inputRef,
                        className: 'pk-spacing-viz__input',
                        value: inputVal,
                        onChange: function( e ) { setInput( e.target.value ); },
                        onKeyDown: function( e ) {
                            if ( e.key === 'Enter' ) { e.preventDefault(); commitEdit(); }
                            if ( e.key === 'Escape' ) { e.preventDefault(); setEdit( null ); }
                        },
                        onBlur: commitEdit,
                        'aria-label': 'Padding bottom value',
                        placeholder: 'e.g. 4rem'
                    } )
                    : el( 'button', {
                        className: 'pk-spacing-viz__value',
                        onClick: function() { startEdit( 'bottom' ); },
                        title: 'Click to edit padding bottom',
                        'aria-label': 'Padding bottom: ' + bottomDisplay + '. Click to edit.'
                    },
                        el( 'span', { className: 'pk-spacing-viz__arrow', 'aria-hidden': 'true' }, '↓' ),
                        bottomDisplay
                    )
            )
        );
    }

    var withSpacingViz = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( SPACING_VIZ_BLOCKS.indexOf( props.name ) === -1 ) return el( BlockEdit, props );

            var a         = props.attributes;
            var set       = props.setAttributes;
            var clientId  = props.clientId;
            var dispatch  = useDispatch( 'core/block-editor' );

            var showState = useState( false );
            var showViz   = showState[0];
            var setShowViz = showState[1];

            /* Read padding from native style.spacing.padding */
            var sp      = a.style && a.style.spacing && a.style.spacing.padding;
            var padding = { top: ( sp && sp.top ) || '', bottom: ( sp && sp.bottom ) || '' };

            /* Apply/remove viz class on the block DOM node */
            useEffect( function() {
                var node = document.querySelector( '[data-block="' + clientId + '"]' );
                if ( ! node ) return;
                if ( showViz ) {
                    node.classList.add( 'pk-spacing-viz-active' );
                } else {
                    node.classList.remove( 'pk-spacing-viz-active' );
                }
                return function() {
                    if ( node ) node.classList.remove( 'pk-spacing-viz-active' );
                };
            }, [ showViz, clientId ] );

            function onEdit( side, value ) {
                var existingStyle   = a.style || {};
                var existingSpacing = existingStyle.spacing || {};
                var existingPadding = existingSpacing.padding || {};
                set( {
                    style: Object.assign( {}, existingStyle, {
                        spacing: Object.assign( {}, existingSpacing, {
                            padding: Object.assign( {}, existingPadding, { [ side ]: value || undefined } )
                        } )
                    } )
                } );
                if ( dispatch.__unstableMarkLastChangeAsPersistent ) {
                    dispatch.__unstableMarkLastChangeAsPersistent();
                }
            }

            return el( Fragment, {},
                el( BlockEdit, props ),

                /* Inspector toggle */
                el( InspectorControls, {},
                    el( PanelBody, {
                        title: 'Spacing Visualization',
                        initialOpen: false,
                        className: 'pk-spacing-viz-panel'
                    },
                        el( ToggleControl, {
                            label: 'Show spacing',
                            help: 'Display padding values on the canvas. Click a value to edit.',
                            checked: showViz,
                            onChange: setShowViz
                        } ),
                        showViz ? el( SpacingVizOverlay, {
                            clientId: clientId,
                            padding:  padding,
                            onEdit:   onEdit
                        } ) : null
                    )
                )
            );
        };
    }, 'withPaksaSpacingViz' );

    addFilter( 'editor.BlockEdit', 'paksa/spacing-viz', withSpacingViz );

} )( window.wp );

/* ── IIFE 4: Column width feedback badge + alignment guides ─────────────── */
/* On core/column selection: shows a floating width badge near the column.   */
/* On core/columns selection: shows subtle vertical center-line guide.       */
/* Width badge reads the actual width attribute — no invented values.        */
/* Alignment guide is editor-only CSS, shown only when columns are selected. */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose || ! wp.data ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var useEffect      = wp.element.useEffect;
    var BlockControls  = wp.blockEditor.BlockControls;
    var ToolbarGroup   = wp.components.ToolbarGroup;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var p31 = window.paksaPhase31 || {};
    var colWidthSteps = p31.colWidthSteps || [];

    /* Resolve display label for a width value */
    function widthLabel( val ) {
        if ( ! val ) return 'Auto';
        var step = colWidthSteps.find( function( s ) { return s.value === val; } );
        return step ? step.label : val;
    }

    /* ── Width badge DOM element ── */
    var widthBadge = null;
    var widthRafId = null;

    function ensureWidthBadge() {
        if ( widthBadge ) return widthBadge;
        widthBadge = document.createElement( 'div' );
        widthBadge.className = 'pk-width-badge';
        widthBadge.setAttribute( 'aria-hidden', 'true' );
        widthBadge.style.display = 'none';
        document.body.appendChild( widthBadge );
        return widthBadge;
    }

    function showWidthBadge( node, label ) {
        var badge = ensureWidthBadge();
        badge.textContent = 'Width ' + label;
        badge.style.display = '';
        if ( widthRafId ) cancelAnimationFrame( widthRafId );
        widthRafId = requestAnimationFrame( function() {
            var rect    = node.getBoundingClientRect();
            var scrollY = window.scrollY || document.documentElement.scrollTop;
            var scrollX = window.scrollX || document.documentElement.scrollLeft;
            badge.style.top  = ( rect.top  + scrollY + 4 ) + 'px';
            badge.style.left = ( rect.left + scrollX + 4 ) + 'px';
        } );
    }

    function hideWidthBadge() {
        if ( widthBadge ) widthBadge.style.display = 'none';
        if ( widthRafId ) { cancelAnimationFrame( widthRafId ); widthRafId = null; }
    }

    /* ── HOC for core/column — width badge + alignment guide class ── */
    var withColumnFeedback = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( props.name !== 'core/column' ) return el( BlockEdit, props );

            var a        = props.attributes;
            var clientId = props.clientId;
            var isSelected = props.isSelected;
            var width    = a.width || '';
            var label    = widthLabel( width );

            /* Show/hide width badge when selected */
            useEffect( function() {
                if ( ! isSelected ) { hideWidthBadge(); return; }
                var node = document.querySelector( '[data-block="' + clientId + '"]' );
                if ( node ) showWidthBadge( node, label );
                return function() { hideWidthBadge(); };
            }, [ isSelected, clientId, label ] );

            /* Add alignment guide class to parent columns block */
            useEffect( function() {
                if ( ! isSelected ) return;
                var node = document.querySelector( '[data-block="' + clientId + '"]' );
                if ( ! node ) return;
                var parent = node.closest( '.wp-block-columns' );
                if ( parent ) parent.classList.add( 'pk-alignment-guides-active' );
                return function() {
                    if ( parent ) parent.classList.remove( 'pk-alignment-guides-active' );
                };
            }, [ isSelected, clientId ] );

            return el( BlockEdit, props );
        };
    }, 'withPaksaColumnFeedback' );

    addFilter( 'editor.BlockEdit', 'paksa/column-feedback', withColumnFeedback );

    /* ── HOC for core/columns — alignment guide class on selection ── */
    var withColumnsFeedback = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( props.name !== 'core/columns' ) return el( BlockEdit, props );

            var clientId   = props.clientId;
            var isSelected = props.isSelected;

            useEffect( function() {
                var node = document.querySelector( '[data-block="' + clientId + '"]' );
                if ( ! node ) return;
                if ( isSelected ) {
                    node.classList.add( 'pk-alignment-guides-active' );
                } else {
                    node.classList.remove( 'pk-alignment-guides-active' );
                }
                return function() {
                    if ( node ) node.classList.remove( 'pk-alignment-guides-active' );
                };
            }, [ isSelected, clientId ] );

            return el( BlockEdit, props );
        };
    }, 'withPaksaColumnsFeedback' );

    addFilter( 'editor.BlockEdit', 'paksa/columns-feedback', withColumnsFeedback );

} )( window.wp );

/* ── IIFE 5: Container boundary guide + canvas interaction registry ─────── */
/* Container boundary: when a child block is selected, subtly highlights its  */
/* containing section/group/column boundary using CSS class toggling.         */
/* Insertion indicator: enhances the native Gutenberg inserter with a more    */
/* visible drop-zone indicator class on empty containers.                     */
/* Canvas interaction registry: extends window.paksaVisual with Phase 31      */
/* interaction definitions — consumed by future phases and tooling.           */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.compose || ! wp.data || ! wp.domReady ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var useEffect      = wp.element.useEffect;
    var subscribe      = wp.data.subscribe;
    var select         = wp.data.select;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;

    var p31 = window.paksaPhase31 || {};
    var containerTypes = p31.containerTypes || [ 'paksa/section', 'core/group', 'core/columns', 'core/column' ];

    /* ── Container boundary guide ── */
    /* When a block is selected, walk its ancestors and add a boundary class  */
    /* to each container ancestor. Remove on deselect.                        */

    var prevBoundaryNodes = [];

    function clearBoundaryGuides() {
        prevBoundaryNodes.forEach( function( node ) {
            node.classList.remove( 'pk-container-boundary' );
        } );
        prevBoundaryNodes = [];
    }

    function applyBoundaryGuides( clientId ) {
        clearBoundaryGuides();
        if ( ! clientId ) return;

        try {
            var store   = select( 'core/block-editor' );
            var parents = store.getBlockParents( clientId ) || [];
            parents.forEach( function( pid ) {
                var block = store.getBlock( pid );
                if ( ! block ) return;
                if ( containerTypes.indexOf( block.name ) === -1 ) return;
                var node = document.querySelector( '[data-block="' + pid + '"]' );
                if ( node ) {
                    node.classList.add( 'pk-container-boundary' );
                    prevBoundaryNodes.push( node );
                }
            } );
        } catch(e) {}
    }

    wp.domReady( function() {
        var prevId = null;
        subscribe( function() {
            var id = select( 'core/block-editor' ).getSelectedBlockClientId();
            if ( id !== prevId ) {
                prevId = id;
                applyBoundaryGuides( id );
            }
        } );
    } );

    /* ── Empty container drop-zone enhancement ── */
    /* Adds pk-drop-zone-ready class to empty containers when a block is being
       dragged. Uses the native Gutenberg isDraggingBlocks selector.          */
    wp.domReady( function() {
        var wasDragging = false;
        subscribe( function() {
            var store      = select( 'core/block-editor' );
            var isDragging = store.isDraggingBlocks ? store.isDraggingBlocks() : false;

            if ( isDragging === wasDragging ) return;
            wasDragging = isDragging;

            // Find all empty container blocks and toggle the drop-zone class
            containerTypes.forEach( function( blockType ) {
                var selector = '[data-type="' + blockType + '"]';
                document.querySelectorAll( selector ).forEach( function( node ) {
                    var clientId = node.dataset.block;
                    if ( ! clientId ) return;
                    try {
                        var innerBlocks = select( 'core/block-editor' ).getBlocks( clientId );
                        var isEmpty = ! innerBlocks || innerBlocks.length === 0;
                        if ( isDragging && isEmpty ) {
                            node.classList.add( 'pk-drop-zone-ready' );
                        } else {
                            node.classList.remove( 'pk-drop-zone-ready' );
                        }
                    } catch(e) {}
                } );
            } );
        } );
    } );

    /* ── HOC: container boundary class on selected container blocks ── */
    /* Adds pk-container-selected to the block's own node when selected,     */
    /* giving a stronger visual identity to the active container.            */
    var withContainerSelected = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( containerTypes.indexOf( props.name ) === -1 ) return el( BlockEdit, props );

            var clientId   = props.clientId;
            var isSelected = props.isSelected;

            useEffect( function() {
                var node = document.querySelector( '[data-block="' + clientId + '"]' );
                if ( ! node ) return;
                if ( isSelected ) {
                    node.classList.add( 'pk-container-selected' );
                } else {
                    node.classList.remove( 'pk-container-selected' );
                }
                return function() {
                    if ( node ) node.classList.remove( 'pk-container-selected' );
                };
            }, [ isSelected, clientId ] );

            return el( BlockEdit, props );
        };
    }, 'withPaksaContainerSelected' );

    addFilter( 'editor.BlockEdit', 'paksa/container-selected', withContainerSelected );

    /* ── Canvas interaction registry — extends window.paksaVisual ── */
    /* Documents which interaction capabilities each block type supports.     */
    /* Consumed by tooling and future phases. Does not duplicate CAPS.        */
    if ( window.paksaVisual ) {
        window.paksaVisual.CANVAS = {
            'paksa/section': {
                hover: true, select: true, spacing: true, background: true,
                layout: true, boundary: true, label: true, breadcrumb: true,
                duplicate: true, delete: true, copyStyle: true
            },
            'core/group': {
                hover: true, select: true, spacing: true, layout: true,
                boundary: true, label: true, breadcrumb: true,
                duplicate: true, delete: true, copyStyle: true
            },
            'core/columns': {
                hover: true, select: true, layout: true, boundary: true,
                label: true, breadcrumb: true, alignmentGuide: true,
                duplicate: true, delete: true
            },
            'core/column': {
                hover: true, select: true, widthFeedback: true, boundary: true,
                label: true, breadcrumb: true, alignmentGuide: true,
                duplicate: true, delete: true
            },
            'core/heading': {
                hover: true, select: true, label: true, breadcrumb: true,
                typography: true, color: true
            },
            'core/paragraph': {
                hover: true, select: true, label: true, breadcrumb: true,
                typography: true, color: true
            },
            'core/image': {
                hover: true, select: true, label: true, breadcrumb: true,
                effects: true
            },
            'core/button': {
                hover: true, select: true, label: true, breadcrumb: true,
                buttonStyle: true, color: true
            },
            'core/cover': {
                hover: true, select: true, label: true, breadcrumb: true,
                boundary: true
            },
            'paksa/testimonial': {
                hover: true, select: true, label: true, breadcrumb: true,
                border: true, shadow: true
            },
            'paksa/cta': {
                hover: true, select: true, label: true, breadcrumb: true,
                background: true, border: true
            },
            'paksa/product-card': {
                hover: true, select: true, label: true, breadcrumb: true
            },
            'paksa/service-card': {
                hover: true, select: true, label: true, breadcrumb: true
            },
        };

        /* Helper: check canvas capability */
        window.paksaVisual.hasCanvasCap = function( blockName, cap ) {
            return !! ( window.paksaVisual.CANVAS[ blockName ] && window.paksaVisual.CANVAS[ blockName ][ cap ] );
        };
    }

} )( window.wp );
