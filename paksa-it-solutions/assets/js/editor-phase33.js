/* ============================================================
   Phase 33 — Global Style Manager, Design Tokens & Site-Wide Editing
   v3.3.0

   IIFE 1: window.paksaVisual.GLOBAL — Global Styles API bridge
   IIFE 2: Paksa Site Styles PluginSidebar
   IIFE 3: Local override detector + Reset to Global Inspector panel
   IIFE 4: Design token reference panel
   ============================================================ */

/* ── IIFE 1: window.paksaVisual.GLOBAL — Global Styles API bridge ────────── */
/* Extends the existing window.paksaVisual namespace (Phase 30).              */
/* Provides read/write helpers for the WP Global Styles entity so all IIFEs   */
/* share one consistent API. No new global namespace created.                 */
/* Uses: select('core').getEditedEntityRecord / dispatch('core').editEntityRecord */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.data || ! window.paksaVisual ) return;

    var select   = wp.data.select;
    var dispatch = wp.data.dispatch;
    var p33      = window.paksaPhase33 || {};

    /* ── Resolve the current Global Styles post ID ── */
    /* WP 5.9+ exposes __experimentalGetCurrentGlobalStylesId or we fall back  */
    /* to reading the first result from the globalStyles entity records.        */
    function getGlobalStylesId() {
        try {
            var coreStore = select( 'core' );
            if ( coreStore.__experimentalGetCurrentGlobalStylesId ) {
                return coreStore.__experimentalGetCurrentGlobalStylesId();
            }
            // Fallback: read from entity records cache
            var records = coreStore.getEntityRecords( 'root', 'globalStyles' );
            if ( records && records.length ) return records[0].id;
        } catch(e) {}
        return null;
    }

    /* ── Read the current edited Global Styles record ── */
    function readGlobalStyles() {
        var id = getGlobalStylesId();
        if ( ! id ) return null;
        try {
            return select( 'core' ).getEditedEntityRecord( 'root', 'globalStyles', id ) || null;
        } catch(e) { return null; }
    }

    /* ── Write a patch to the Global Styles record ── */
    /* patch is a partial object merged into the existing record.              */
    /* Uses deep merge so callers only need to supply the changed path.        */
    function writeGlobalStyles( patch ) {
        var id = getGlobalStylesId();
        if ( ! id ) return;
        try {
            dispatch( 'core' ).editEntityRecord( 'root', 'globalStyles', id, patch );
        } catch(e) {}
    }

    /* ── Deep-get a value from the Global Styles record by dot-path ── */
    /* e.g. readGlobalStylesPath('styles.elements.button.color.background')   */
    function readGlobalStylesPath( dotPath ) {
        var record = readGlobalStyles();
        if ( ! record ) return undefined;
        var parts = dotPath.split( '.' );
        var cur   = record;
        for ( var i = 0; i < parts.length; i++ ) {
            if ( cur === null || cur === undefined ) return undefined;
            cur = cur[ parts[i] ];
        }
        return cur;
    }

    /* ── Build a nested patch object from a dot-path + value ── */
    /* e.g. buildPatch('styles.elements.button.color.background', '#fff')     */
    function buildPatch( dotPath, value ) {
        var parts  = dotPath.split( '.' );
        var result = {};
        var cur    = result;
        for ( var i = 0; i < parts.length - 1; i++ ) {
            cur[ parts[i] ] = {};
            cur = cur[ parts[i] ];
        }
        cur[ parts[ parts.length - 1 ] ] = value;
        return result;
    }

    /* ── Deep merge two objects (non-destructive) ── */
    function deepMerge( target, source ) {
        var out = Object.assign( {}, target );
        Object.keys( source ).forEach( function( key ) {
            if ( source[key] && typeof source[key] === 'object' && ! Array.isArray( source[key] ) ) {
                out[key] = deepMerge( out[key] || {}, source[key] );
            } else {
                out[key] = source[key];
            }
        } );
        return out;
    }

    /* ── Write a single dot-path value into Global Styles ── */
    function writeGlobalStylesPath( dotPath, value ) {
        var id = getGlobalStylesId();
        if ( ! id ) return;
        var record  = readGlobalStyles() || {};
        var patch   = buildPatch( dotPath, value );
        var merged  = deepMerge( record, patch );
        try {
            dispatch( 'core' ).editEntityRecord( 'root', 'globalStyles', id, merged );
        } catch(e) {}
    }

    /* ── Save Global Styles (triggers WP save) ── */
    function saveGlobalStyles() {
        var id = getGlobalStylesId();
        if ( ! id ) return;
        try {
            dispatch( 'core' ).saveEditedEntityRecord( 'root', 'globalStyles', id );
        } catch(e) {}
    }

    /* ── Check if Global Styles have unsaved changes ── */
    function hasUnsavedGlobalStyles() {
        var id = getGlobalStylesId();
        if ( ! id ) return false;
        try {
            return !! select( 'core' ).hasEditsForEntityRecord( 'root', 'globalStyles', id );
        } catch(e) { return false; }
    }

    /* ── Get theme style variations ── */
    function getThemeStyleVariations() {
        try {
            var coreStore = select( 'core' );
            if ( coreStore.__experimentalGetCurrentThemeGlobalStylesVariations ) {
                return coreStore.__experimentalGetCurrentThemeGlobalStylesVariations() || [];
            }
            if ( coreStore.getThemeStyleVariations ) {
                return coreStore.getThemeStyleVariations() || [];
            }
        } catch(e) {}
        // Fall back to the PHP-provided list — presentation only
        return ( window.paksaPhase33 || {} ).styleVariations || [];
    }

    /* ── Apply a style variation by slug ── */
    /* Uses the WP Global Styles entity to apply the variation's settings/styles. */
    /* Falls back to body class swap (Customizer path) if API unavailable.     */
    function applyStyleVariation( variationSlug ) {
        try {
            var coreStore = select( 'core' );
            var variations = getThemeStyleVariations();
            // WP 6.2+ variations have a __unstableResolvedStyles or settings/styles
            var match = variations.find( function( v ) {
                return ( v.title && v.title.toLowerCase() === variationSlug ) ||
                       ( v.slug  && v.slug  === variationSlug );
            } );
            if ( match ) {
                var id = getGlobalStylesId();
                if ( id ) {
                    var patch = {};
                    if ( match.settings ) patch.settings = match.settings;
                    if ( match.styles )   patch.styles   = match.styles;
                    if ( Object.keys( patch ).length ) {
                        dispatch( 'core' ).editEntityRecord( 'root', 'globalStyles', id, patch );
                        return true;
                    }
                }
            }
        } catch(e) {}
        return false;
    }

    /* ── Detect local overrides on a block ── */
    /* Returns array of override descriptors: { path, label, localValue }     */
    function detectLocalOverrides( blockAttributes, blockName ) {
        var overrides = [];
        if ( ! blockAttributes ) return overrides;

        // Native style object checks
        var styleChecks = [
            { path: 'style.color.text',                    label: 'Text Color' },
            { path: 'style.color.background',              label: 'Background Color' },
            { path: 'style.color.gradient',                label: 'Gradient' },
            { path: 'style.typography.fontFamily',         label: 'Font Family' },
            { path: 'style.typography.fontSize',           label: 'Font Size' },
            { path: 'style.typography.fontWeight',         label: 'Font Weight' },
            { path: 'style.typography.lineHeight',         label: 'Line Height' },
            { path: 'style.typography.letterSpacing',      label: 'Letter Spacing' },
            { path: 'style.typography.textTransform',      label: 'Text Transform' },
            { path: 'style.spacing.padding.top',           label: 'Padding Top' },
            { path: 'style.spacing.padding.bottom',        label: 'Padding Bottom' },
            { path: 'style.spacing.padding.left',          label: 'Padding Left' },
            { path: 'style.spacing.padding.right',         label: 'Padding Right' },
            { path: 'style.border.radius',                 label: 'Border Radius' },
            { path: 'style.shadow',                        label: 'Shadow' },
        ];

        styleChecks.forEach( function( check ) {
            var parts = check.path.split( '.' );
            var cur   = blockAttributes;
            for ( var i = 0; i < parts.length; i++ ) {
                if ( cur === null || cur === undefined ) { cur = undefined; break; }
                cur = cur[ parts[i] ];
            }
            if ( cur !== undefined && cur !== '' && cur !== null ) {
                overrides.push( { path: check.path, label: check.label, localValue: cur } );
            }
        } );

        // Paksa custom attribute checks
        var paksaChecks = [
            { attr: 'bgColor',        label: 'Section Background Color' },
            { attr: 'bgGradient',     label: 'Section Gradient' },
            { attr: 'borderRadius',   label: 'Border Radius (Paksa)' },
            { attr: 'shadowPreset',   label: 'Shadow Preset' },
            { attr: 'hoverEffect',    label: 'Hover Effect' },
            { attr: 'variant',        label: 'Section Variant' },
            { attr: 'containerWidth', label: 'Container Width' },
        ];

        paksaChecks.forEach( function( check ) {
            var val = blockAttributes[ check.attr ];
            if ( val !== undefined && val !== '' && val !== null && val !== 'none' && val !== 'default' ) {
                overrides.push( { path: check.attr, label: check.label, localValue: val, isPaksa: true } );
            }
        } );

        return overrides;
    }

    /* ── Reset a single local override on a block ── */
    /* Removes the value at the given path from block attributes.             */
    function buildResetPatch( path, currentAttributes ) {
        if ( ! path.includes( '.' ) ) {
            // Top-level Paksa attribute
            var patch = {};
            patch[ path ] = undefined;
            return patch;
        }
        // Nested style.* path — rebuild style object without the key
        var parts = path.split( '.' );
        var style = JSON.parse( JSON.stringify( currentAttributes.style || {} ) );
        var cur   = style;
        for ( var i = 1; i < parts.length - 1; i++ ) {
            if ( ! cur[ parts[i] ] ) return null;
            cur = cur[ parts[i] ];
        }
        delete cur[ parts[ parts.length - 1 ] ];
        return { style: style };
    }

    /* ── Expose GLOBAL namespace on window.paksaVisual ── */
    window.paksaVisual.GLOBAL = {
        getGlobalStylesId:       getGlobalStylesId,
        readGlobalStyles:        readGlobalStyles,
        readGlobalStylesPath:    readGlobalStylesPath,
        writeGlobalStyles:       writeGlobalStyles,
        writeGlobalStylesPath:   writeGlobalStylesPath,
        saveGlobalStyles:        saveGlobalStyles,
        hasUnsavedGlobalStyles:  hasUnsavedGlobalStyles,
        getThemeStyleVariations: getThemeStyleVariations,
        applyStyleVariation:     applyStyleVariation,
        detectLocalOverrides:    detectLocalOverrides,
        buildResetPatch:         buildResetPatch,
        deepMerge:               deepMerge,
        p33:                     p33,
    };

} )( window.wp );

/* ── IIFE 2: Paksa Site Styles PluginSidebar ────────────────────────────── */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.plugins || ! wp.editPost || ! wp.element || ! wp.components || ! wp.data ) return;
    if ( ! window.paksaVisual || ! window.paksaVisual.GLOBAL ) return;

    var registerPlugin  = wp.plugins.registerPlugin;
    var PluginSidebar   = ( wp.editor && wp.editor.PluginSidebar ) ? wp.editor.PluginSidebar : ( wp.editPost && wp.editPost.PluginSidebar );
    var el              = wp.element.createElement;
    var useState        = wp.element.useState;
    var useEffect       = wp.element.useEffect;
    var useMemo         = wp.element.useMemo;
    var useSelect       = wp.data.useSelect;
    var useDispatch     = wp.data.useDispatch;
    var PanelBody       = wp.components.PanelBody;
    var Button          = wp.components.Button;
    var SelectControl   = wp.components.SelectControl;
    var RangeControl    = wp.components.RangeControl;
    var Notice          = wp.components.Notice;

    var G   = window.paksaVisual.GLOBAL;
    var p33 = window.paksaPhase33 || {};

    /* ── Shared: color swatch row ── */
    function ColorRow( props ) {
        var color    = props.color;
        var name     = props.name;
        var slug     = props.slug;
        var isActive = props.isActive;
        var onClick  = props.onClick;
        return el( 'button', {
            className: 'pk-gs-swatch' + ( isActive ? ' is-active' : '' ),
            style: { background: color },
            onClick: onClick,
            title: name,
            'aria-label': name + ( isActive ? ' (active)' : '' ),
            'aria-pressed': isActive
        } );
    }

    /* ── Shared: token chip row ── */
    function ChipRow( props ) {
        var options  = props.options;
        var value    = props.value;
        var onChange = props.onChange;
        var label    = props.label;
        return el( 'div', { className: 'pk-gs-chip-group' },
            label ? el( 'p', { className: 'pk-gs-label' }, label ) : null,
            el( 'div', { className: 'pk-gs-chips' },
                options.map( function( o ) {
                    return el( 'button', {
                        key: o.value || o.slug || o.name,
                        className: 'pk-gs-chip' + ( value === ( o.value || o.slug ) ? ' is-active' : '' ),
                        onClick: function() { onChange( o.value || o.slug ); },
                        'aria-pressed': value === ( o.value || o.slug ),
                        title: o.label || o.name
                    }, o.label || o.name );
                } )
            )
        );
    }

    /* ── Tab: Style Variations ── */
    function VariationsTab() {
        var variations = p33.styleVariations || [];
        var gsId = useSelect( function( select ) {
            try {
                var s = select( 'core' );
                if ( s.__experimentalGetCurrentGlobalStylesId ) return s.__experimentalGetCurrentGlobalStylesId();
            } catch(e) {}
            return null;
        }, [] );

        var saveState = useState( null );
        var saveMsg   = saveState[0];
        var setSaveMsg = saveState[1];

        function applyVariation( slug ) {
            var applied = G.applyStyleVariation( slug );
            setSaveMsg( applied ? 'Variation applied — click Save to persist.' : 'Preview only — save from the Site Editor to persist.' );
            setTimeout( function() { setSaveMsg( null ); }, 4000 );
        }

        return el( 'div', { className: 'pk-gs-tab-content' },
            el( 'p', { className: 'pk-gs-section-hint' },
                'Style variations change the global visual personality — colors, radius, and button treatment. Content is never affected.'
            ),
            saveMsg ? el( Notice, { status: 'info', isDismissible: false, className: 'pk-gs-notice' }, saveMsg ) : null,
            el( 'div', { className: 'pk-gs-variations-grid' },
                variations.map( function( v ) {
                    return el( 'button', {
                        key: v.slug,
                        className: 'pk-gs-variation-card',
                        onClick: function() { applyVariation( v.slug ); },
                        'aria-label': 'Apply ' + v.name + ' variation'
                    },
                        el( 'div', { className: 'pk-gs-variation-preview' },
                            el( 'span', { className: 'pk-gs-variation-swatch', style: { background: v.primary } } ),
                            el( 'span', { className: 'pk-gs-variation-swatch pk-gs-variation-swatch--bg', style: { background: v.bg } } ),
                            el( 'span', { className: 'pk-gs-variation-swatch pk-gs-variation-swatch--text', style: { background: v.text } } )
                        ),
                        el( 'span', { className: 'pk-gs-variation-name' }, v.name ),
                        el( 'span', { className: 'pk-gs-variation-desc' }, v.description )
                    );
                } )
            )
        );
    }

    /* ── Tab: Colors ── */
    function ColorsTab() {
        var palette   = p33.palette   || [];
        var gradients = p33.gradients || [];

        var groups = [ 'brand', 'background', 'text', 'ui', 'status' ];
        var groupLabels = { brand: 'Brand', background: 'Backgrounds', text: 'Text', ui: 'UI', status: 'Status' };

        return el( 'div', { className: 'pk-gs-tab-content' },
            el( 'p', { className: 'pk-gs-section-hint' },
                'These are the theme color tokens from theme.json. To change colors globally, use the Site Editor → Styles → Colors panel, or switch a Style Variation above.'
            ),
            groups.map( function( group ) {
                var groupColors = palette.filter( function( c ) { return c.role === group; } );
                if ( ! groupColors.length ) return null;
                return el( 'div', { key: group, className: 'pk-gs-color-group' },
                    el( 'p', { className: 'pk-gs-label' }, groupLabels[ group ] ),
                    el( 'div', { className: 'pk-gs-color-swatches' },
                        groupColors.map( function( c ) {
                            return el( 'div', { key: c.slug, className: 'pk-gs-color-item' },
                                el( 'span', {
                                    className: 'pk-gs-color-dot',
                                    style: { background: c.color },
                                    title: c.name + ' — ' + c.color,
                                    'aria-label': c.name
                                } ),
                                el( 'span', { className: 'pk-gs-color-name' }, c.name ),
                                el( 'span', { className: 'pk-gs-color-value' }, c.color )
                            );
                        } )
                    )
                );
            } ),
            el( 'p', { className: 'pk-gs-label', style: { marginTop: '12px' } }, 'Gradients' ),
            el( 'div', { className: 'pk-gs-gradient-row' },
                gradients.map( function( g ) {
                    return el( 'div', { key: g.slug, className: 'pk-gs-gradient-item' },
                        el( 'span', {
                            className: 'pk-gs-gradient-swatch',
                            style: { background: g.gradient },
                            title: g.name,
                            'aria-label': g.name
                        } ),
                        el( 'span', { className: 'pk-gs-color-name' }, g.name )
                    );
                } )
            ),
            el( 'p', { className: 'pk-gs-section-hint pk-gs-section-hint--action' },
                'To edit colors: open the ',
                el( 'strong', {}, 'Site Editor → Styles → Colors' ),
                ' panel, or switch a Style Variation.'
            )
        );
    }

    /* ── Tab: Typography ── */
    function TypographyTab() {
        var fontFamilies = p33.fontFamilies || [];
        var fontSizes    = p33.fontSizes    || [];

        return el( 'div', { className: 'pk-gs-tab-content' },
            el( 'p', { className: 'pk-gs-section-hint' },
                'Font families and fluid size scale from theme.json. Edit globally via Site Editor → Styles → Typography.'
            ),
            el( 'p', { className: 'pk-gs-label' }, 'Font Families' ),
            el( 'div', { className: 'pk-gs-font-families' },
                fontFamilies.map( function( f ) {
                    return el( 'div', { key: f.slug, className: 'pk-gs-font-item' },
                        el( 'span', { className: 'pk-gs-font-preview', style: { fontFamily: f.family } }, 'Aa' ),
                        el( 'span', { className: 'pk-gs-font-name' }, f.name ),
                        el( 'code', { className: 'pk-gs-font-slug' }, 'var:preset|font-family|' + f.slug )
                    );
                } )
            ),
            el( 'p', { className: 'pk-gs-label', style: { marginTop: '12px' } }, 'Size Scale' ),
            el( 'div', { className: 'pk-gs-size-scale' },
                fontSizes.map( function( s ) {
                    return el( 'div', { key: s.slug, className: 'pk-gs-size-item' },
                        el( 'span', { className: 'pk-gs-size-name' }, s.name ),
                        el( 'span', { className: 'pk-gs-size-value' }, s.size ),
                        el( 'code', { className: 'pk-gs-font-slug' }, s.slug )
                    );
                } )
            )
        );
    }

    /* ── Tab: Layout & Spacing ── */
    function LayoutTab() {
        var layout       = p33.layout       || {};
        var spacingSizes = p33.spacingSizes  || [];
        var radiusTokens = p33.radiusTokens  || [];

        return el( 'div', { className: 'pk-gs-tab-content' },
            el( 'p', { className: 'pk-gs-label' }, 'Content Widths' ),
            el( 'div', { className: 'pk-gs-layout-widths' },
                el( 'div', { className: 'pk-gs-layout-row' },
                    el( 'span', { className: 'pk-gs-layout-label' }, 'Content' ),
                    el( 'span', { className: 'pk-gs-layout-value' }, layout.contentSize || '1200px' ),
                    el( 'div', { className: 'pk-gs-layout-bar pk-gs-layout-bar--content' } )
                ),
                el( 'div', { className: 'pk-gs-layout-row' },
                    el( 'span', { className: 'pk-gs-layout-label' }, 'Wide' ),
                    el( 'span', { className: 'pk-gs-layout-value' }, layout.wideSize || '1440px' ),
                    el( 'div', { className: 'pk-gs-layout-bar pk-gs-layout-bar--wide' } )
                ),
                el( 'div', { className: 'pk-gs-layout-row' },
                    el( 'span', { className: 'pk-gs-layout-label' }, 'Narrow' ),
                    el( 'span', { className: 'pk-gs-layout-value' }, layout.narrowSize || '720px' ),
                    el( 'div', { className: 'pk-gs-layout-bar pk-gs-layout-bar--narrow' } )
                )
            ),
            el( 'p', { className: 'pk-gs-label', style: { marginTop: '12px' } }, 'Spacing Scale' ),
            el( 'div', { className: 'pk-gs-spacing-scale' },
                spacingSizes.map( function( s ) {
                    return el( 'div', { key: s.slug, className: 'pk-gs-spacing-item' },
                        el( 'span', { className: 'pk-gs-spacing-name' }, s.name ),
                        el( 'span', { className: 'pk-gs-spacing-size' }, s.size ),
                        el( 'div', {
                            className: 'pk-gs-spacing-bar',
                            style: { width: Math.min( 100, ( parseInt( s.size ) || 16 ) * 3 ) + 'px' },
                            'aria-hidden': 'true'
                        } )
                    );
                } )
            ),
            el( 'p', { className: 'pk-gs-label', style: { marginTop: '12px' } }, 'Border Radius Tokens' ),
            el( 'div', { className: 'pk-gs-radius-row' },
                radiusTokens.map( function( r ) {
                    return el( 'div', { key: r.token, className: 'pk-gs-radius-item' },
                        el( 'span', {
                            className: 'pk-gs-radius-preview',
                            style: { borderRadius: r.value },
                            'aria-hidden': 'true'
                        } ),
                        el( 'span', { className: 'pk-gs-radius-name' }, r.name ),
                        el( 'span', { className: 'pk-gs-radius-value' }, r.value )
                    );
                } )
            )
        );
    }

    /* ── Tab: Shadows & Motion ── */
    function ShadowsMotionTab() {
        var shadowPresets    = p33.shadowPresets    || [];
        var transitionTokens = p33.transitionTokens || [];
        var customizerDesign = p33.customizerDesign || {};

        return el( 'div', { className: 'pk-gs-tab-content' },
            el( 'p', { className: 'pk-gs-label' }, 'Shadow Presets' ),
            el( 'div', { className: 'pk-gs-shadow-list' },
                shadowPresets.map( function( s ) {
                    return el( 'div', { key: s.slug, className: 'pk-gs-shadow-item' },
                        el( 'span', {
                            className: 'pk-gs-shadow-preview',
                            style: { boxShadow: s.shadow },
                            'aria-hidden': 'true'
                        } ),
                        el( 'span', { className: 'pk-gs-shadow-name' }, s.name ),
                        el( 'code', { className: 'pk-gs-font-slug' }, 'var(--wp--preset--shadow--' + s.slug + ')' )
                    );
                } )
            ),
            el( 'p', { className: 'pk-gs-label', style: { marginTop: '12px' } }, 'Transition Tokens' ),
            el( 'div', { className: 'pk-gs-transition-list' },
                transitionTokens.map( function( t ) {
                    return el( 'div', { key: t.token, className: 'pk-gs-transition-item' },
                        el( 'span', { className: 'pk-gs-transition-name' }, t.name ),
                        el( 'span', { className: 'pk-gs-transition-value' }, t.value ),
                        el( 'code', { className: 'pk-gs-font-slug' }, t.token )
                    );
                } )
            ),
            el( 'p', { className: 'pk-gs-label', style: { marginTop: '12px' } }, 'Global Design System (Customizer)' ),
            el( 'div', { className: 'pk-gs-customizer-summary' },
                el( 'div', { className: 'pk-gs-customizer-row' },
                    el( 'span', { className: 'pk-gs-customizer-key' }, 'Radius' ),
                    el( 'span', { className: 'pk-gs-customizer-val' }, customizerDesign.radiusPersonality || 'default' )
                ),
                el( 'div', { className: 'pk-gs-customizer-row' },
                    el( 'span', { className: 'pk-gs-customizer-key' }, 'Shadow' ),
                    el( 'span', { className: 'pk-gs-customizer-val' }, customizerDesign.shadowIntensity || 'default' )
                ),
                el( 'div', { className: 'pk-gs-customizer-row' },
                    el( 'span', { className: 'pk-gs-customizer-key' }, 'Motion' ),
                    el( 'span', { className: 'pk-gs-customizer-val' }, customizerDesign.motionPreference || 'full' )
                ),
                el( 'div', { className: 'pk-gs-customizer-row' },
                    el( 'span', { className: 'pk-gs-customizer-key' }, 'Spacing' ),
                    el( 'span', { className: 'pk-gs-customizer-val' }, customizerDesign.sectionSpacing || 'default' )
                )
            ),
            el( 'p', { className: 'pk-gs-section-hint pk-gs-section-hint--action' },
                'To change these values: ',
                el( 'strong', {}, 'Appearance → Customize → Global Design System' )
            )
        );
    }

    /* ── Main Site Styles panel ── */
    function SiteStylesPanel() {
        var tabState  = useState( 'variations' );
        var activeTab = tabState[0];
        var setTab    = tabState[1];

        var hasUnsaved = useSelect( function() {
            return G.hasUnsavedGlobalStyles();
        }, [] );

        var tabs = [
            { key: 'variations', label: 'Style',    icon: '◈' },
            { key: 'colors',     label: 'Colors',   icon: '◉' },
            { key: 'typography', label: 'Type',     icon: 'T' },
            { key: 'layout',     label: 'Layout',   icon: '⊞' },
            { key: 'shadows',    label: 'Effects',  icon: '◫' },
        ];

        return el( 'div', { className: 'pk-gs-panel' },
            /* Header */
            el( 'div', { className: 'pk-gs-header' },
                el( 'span', { className: 'pk-gs-header-title' }, 'Site Design System' ),
                hasUnsaved ? el( 'button', {
                    className: 'pk-gs-save-btn',
                    onClick: function() { G.saveGlobalStyles(); },
                    title: 'Save global style changes',
                    'aria-label': 'Save global styles'
                }, '↑ Save' ) : null
            ),

            /* Tab bar */
            el( 'div', { className: 'pk-gs-tabs', role: 'tablist', 'aria-label': 'Site styles sections' },
                tabs.map( function( tab ) {
                    return el( 'button', {
                        key: tab.key,
                        className: 'pk-gs-tab' + ( activeTab === tab.key ? ' is-active' : '' ),
                        onClick: function() { setTab( tab.key ); },
                        role: 'tab',
                        'aria-selected': activeTab === tab.key
                    },
                        el( 'span', { 'aria-hidden': 'true' }, tab.icon ),
                        el( 'span', { className: 'pk-gs-tab-label' }, tab.label )
                    );
                } )
            ),

            /* Tab content */
            el( 'div', { className: 'pk-gs-tab-panels' },
                activeTab === 'variations' ? el( VariationsTab, {} ) : null,
                activeTab === 'colors'     ? el( ColorsTab,     {} ) : null,
                activeTab === 'typography' ? el( TypographyTab, {} ) : null,
                activeTab === 'layout'     ? el( LayoutTab,     {} ) : null,
                activeTab === 'shadows'    ? el( ShadowsMotionTab, {} ) : null
            )
        );
    }

    registerPlugin( 'paksa-site-styles', {
        render: function() {
            return el( PluginSidebar, {
                name:      'paksa-site-styles',
                title:     'Site Styles',
                icon:      'admin-appearance',
                className: 'pk-gs-sidebar'
            }, el( SiteStylesPanel, {} ) );
        }
    } );

    /* PluginToolbarButton removed in WP 6.6+ — toolbar button omitted */

} )( window.wp );

/* ── IIFE 3: Local override detector + Reset to Global Inspector panel ───── */
/* Reads actual block attributes and compares against global defaults.        */
/* Shows a compact "Local overrides" panel in the Inspector when overrides    */
/* are detected. Each override has a Reset button that removes only that      */
/* local value. All resets are undoable via Gutenberg's undo stack.           */
/* Does NOT touch global styles when resetting — only removes local attrs.    */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.hooks || ! wp.element || ! wp.blockEditor || ! wp.components || ! wp.compose || ! wp.data ) return;
    if ( ! window.paksaVisual || ! window.paksaVisual.GLOBAL ) return;

    var addFilter      = wp.hooks.addFilter;
    var el             = wp.element.createElement;
    var Fragment       = wp.element.Fragment;
    var useMemo        = wp.element.useMemo;
    var useState       = wp.element.useState;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody      = wp.components.PanelBody;
    var Button         = wp.components.Button;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;
    var useDispatch    = wp.data.useDispatch;

    var G = window.paksaVisual.GLOBAL;

    /* Blocks where local override detection is meaningful */
    var OVERRIDE_BLOCKS = [
        'core/heading', 'core/paragraph', 'core/button', 'core/buttons',
        'core/image', 'core/group', 'core/columns', 'core/column', 'core/cover',
        'core/list', 'core/quote',
        'paksa/section', 'paksa/testimonial', 'paksa/cta',
        'paksa/product-card', 'paksa/service-card',
    ];

    var withLocalOverrides = createHigherOrderComponent( function( BlockEdit ) {
        return function( props ) {
            if ( OVERRIDE_BLOCKS.indexOf( props.name ) === -1 ) return el( BlockEdit, props );

            var a        = props.attributes;
            var set      = props.setAttributes;
            var dispatch = useDispatch( 'core/block-editor' );

            /* Detect overrides — memoised so it only recalculates when attrs change */
            var overrides = useMemo( function() {
                return G.detectLocalOverrides( a, props.name );
            }, [ a ] );

            if ( ! overrides || overrides.length === 0 ) return el( BlockEdit, props );

            function resetOne( override ) {
                var patch = G.buildResetPatch( override.path, a );
                if ( ! patch ) return;
                set( patch );
                if ( dispatch.__unstableMarkLastChangeAsPersistent ) {
                    dispatch.__unstableMarkLastChangeAsPersistent();
                }
            }

            function resetAll() {
                var combined = {};
                overrides.forEach( function( ov ) {
                    var patch = G.buildResetPatch( ov.path, a );
                    if ( patch ) {
                        combined = G.deepMerge( combined, patch );
                    }
                } );
                if ( Object.keys( combined ).length ) {
                    set( combined );
                    if ( dispatch.__unstableMarkLastChangeAsPersistent ) {
                        dispatch.__unstableMarkLastChangeAsPersistent();
                    }
                }
            }

            var overridePanel = el( PanelBody, {
                title: 'Local Overrides ● ' + overrides.length,
                initialOpen: false,
                className: 'pk-override-panel'
            },
                el( 'p', { className: 'pk-override-hint' },
                    'This block has ' + overrides.length + ' local style override' + ( overrides.length !== 1 ? 's' : '' ) + ' that differ from the global design system.'
                ),
                el( 'div', { className: 'pk-override-list' },
                    overrides.map( function( ov, i ) {
                        var displayVal = typeof ov.localValue === 'object'
                            ? JSON.stringify( ov.localValue )
                            : String( ov.localValue );
                        if ( displayVal.length > 40 ) displayVal = displayVal.slice( 0, 38 ) + '…';
                        return el( 'div', { key: i, className: 'pk-override-item' },
                            el( 'div', { className: 'pk-override-item__info' },
                                el( 'span', { className: 'pk-override-item__label' }, ov.label ),
                                el( 'span', { className: 'pk-override-item__value' }, displayVal )
                            ),
                            el( 'button', {
                                className: 'pk-override-reset-btn',
                                onClick: function() { resetOne( ov ); },
                                title: 'Reset ' + ov.label + ' to global',
                                'aria-label': 'Reset ' + ov.label + ' to global default'
                            }, '↺' )
                        );
                    } )
                ),
                el( Button, {
                    variant: 'secondary',
                    isSmall: true,
                    onClick: resetAll,
                    className: 'pk-override-reset-all-btn'
                }, '↺ Reset All to Global' )
            );

            return el( Fragment, {},
                el( BlockEdit, props ),
                el( InspectorControls, {}, overridePanel )
            );
        };
    }, 'withPaksaLocalOverrides' );

    addFilter( 'editor.BlockEdit', 'paksa/local-overrides', withLocalOverrides, 20 );

} )( window.wp );

/* ── IIFE 4: Design token reference panel ───────────────────────────────── */
/* Adds a compact "Design Tokens" PluginDocumentSettingPanel that shows the  */
/* full token reference: colors, spacing, radius, shadows, transitions.      */
/* Read-only reference — no writes. Helps users pick the right token when    */
/* setting local values in block controls.                                   */
( function( wp ) {
    'use strict';
    if ( ! wp || ! wp.plugins || ! wp.editPost || ! wp.element || ! wp.components ) return;
    if ( ! window.paksaVisual || ! window.paksaVisual.GLOBAL ) return;

    var registerPlugin = wp.plugins.registerPlugin;
    var PluginDocumentSettingPanel = ( wp.editor && wp.editor.PluginDocumentSettingPanel ) ? wp.editor.PluginDocumentSettingPanel : ( wp.editPost && wp.editPost.PluginDocumentSettingPanel );
    var el             = wp.element.createElement;
    var useState       = wp.element.useState;

    if ( ! PluginDocumentSettingPanel ) return;

    var p33 = window.paksaPhase33 || {};

    function TokenSection( props ) {
        var title    = props.title;
        var children = props.children;
        var openState = useState( false );
        var isOpen    = openState[0];
        var setOpen   = openState[1];

        return el( 'div', { className: 'pk-token-section' },
            el( 'button', {
                className: 'pk-token-section__toggle',
                onClick: function() { setOpen( ! isOpen ); },
                'aria-expanded': isOpen,
                type: 'button'
            },
                el( 'span', {}, title ),
                el( 'span', { 'aria-hidden': 'true' }, isOpen ? '▾' : '▸' )
            ),
            isOpen ? el( 'div', { className: 'pk-token-section__body' }, children ) : null
        );
    }

    function DesignTokensPanel() {
        var palette      = p33.palette      || [];
        var spacingSizes = p33.spacingSizes  || [];
        var radiusTokens = p33.radiusTokens  || [];
        var shadowPresets = p33.shadowPresets || [];

        return el( 'div', { className: 'pk-token-panel' },

            el( TokenSection, { title: 'Colors (' + palette.length + ')' },
                el( 'div', { className: 'pk-token-color-grid' },
                    palette.map( function( c ) {
                        return el( 'div', { key: c.slug, className: 'pk-token-color-item', title: c.color },
                            el( 'span', { className: 'pk-token-dot', style: { background: c.color } } ),
                            el( 'span', { className: 'pk-token-name' }, c.name ),
                            el( 'code', { className: 'pk-token-code' }, '--wp--preset--color--' + c.slug )
                        );
                    } )
                )
            ),

            el( TokenSection, { title: 'Spacing (' + spacingSizes.length + ')' },
                el( 'div', { className: 'pk-token-list' },
                    spacingSizes.map( function( s ) {
                        return el( 'div', { key: s.slug, className: 'pk-token-row' },
                            el( 'span', { className: 'pk-token-name' }, s.name ),
                            el( 'span', { className: 'pk-token-val' }, s.size ),
                            el( 'code', { className: 'pk-token-code' }, '--wp--preset--spacing--' + s.slug )
                        );
                    } )
                )
            ),

            el( TokenSection, { title: 'Radius' },
                el( 'div', { className: 'pk-token-list' },
                    radiusTokens.map( function( r ) {
                        return el( 'div', { key: r.token, className: 'pk-token-row' },
                            el( 'span', { className: 'pk-token-name' }, r.name ),
                            el( 'span', { className: 'pk-token-val' }, r.value ),
                            el( 'code', { className: 'pk-token-code' }, r.token )
                        );
                    } )
                )
            ),

            el( TokenSection, { title: 'Shadows' },
                el( 'div', { className: 'pk-token-list' },
                    shadowPresets.map( function( s ) {
                        return el( 'div', { key: s.slug, className: 'pk-token-row' },
                            el( 'span', { className: 'pk-token-name' }, s.name ),
                            el( 'code', { className: 'pk-token-code' }, '--wp--preset--shadow--' + s.slug )
                        );
                    } )
                )
            )
        );
    }

    registerPlugin( 'paksa-design-tokens', {
        render: function() {
            return el( PluginDocumentSettingPanel, {
                name:  'paksa-design-tokens',
                title: 'Design Tokens',
                icon:  'admin-appearance',
                className: 'pk-token-doc-panel'
            }, el( DesignTokensPanel, {} ) );
        }
    } );

} )( window.wp );
