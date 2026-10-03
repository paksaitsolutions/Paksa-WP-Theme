/**
 * Paksa Theme — Phase 36: Form Block + Conditional Visibility
 *
 * Registers:
 *  - paksa/form  block edit UI (fields builder, inspector panels)
 *  - Conditional visibility BlockEdit filter for all blocks
 *  - Frontend form AJAX handler (scoped IIFE, no global pollution)
 *
 * Submits to existing paksa_contact_submit AJAX action.
 * Nonce and ajaxUrl come from paksaPhase36 (wp_localize_script).
 */

/* ── Imports from wp.* globals ── */
(function () {
    'use strict';

    var blocks       = wp.blocks;
    var blockEditor  = wp.blockEditor;
    var components   = wp.components;
    var element      = wp.element;
    var hooks        = wp.hooks;
    var compose      = wp.compose;
    var i18n         = wp.i18n;
    var data         = wp.data;

    if ( ! blocks || ! blockEditor || ! components || ! element ) { return; }

    var el           = element.createElement;
    var Fragment     = element.Fragment;
    var useState     = element.useState;
    var useEffect    = element.useEffect;
    var __           = i18n.__;

    var InspectorControls = blockEditor.InspectorControls;
    var useBlockProps     = blockEditor.useBlockProps;
    var PanelBody         = components.PanelBody;
    var PanelRow          = components.PanelRow;
    var TextControl       = components.TextControl;
    var TextareaControl   = components.TextareaControl;
    var SelectControl     = components.SelectControl;
    var ToggleControl     = components.ToggleControl;
    var Button            = components.Button;
    var Notice            = components.Notice;

    var cfg = window.paksaPhase36 || {};
    var fieldTypes   = cfg.fieldTypes   || [];
    var widthOptions = cfg.widthOptions || [];
    var formVariants = cfg.formVariants || [];

    /* ══════════════════════════════════════════════════════════════════════
       FIELD EDITOR COMPONENT
       ══════════════════════════════════════════════════════════════════════ */

    function FieldEditor( props ) {
        var field   = props.field;
        var index   = props.index;
        var total   = props.total;
        var onChange = props.onChange;
        var onRemove = props.onRemove;
        var onMoveUp = props.onMoveUp;
        var onMoveDn = props.onMoveDn;

        function set( key, val ) {
            var updated = Object.assign( {}, field );
            updated[ key ] = val;
            onChange( updated );
        }

        return el( 'div', { className: 'pk-field-editor' },
            el( 'div', { className: 'pk-field-editor__header' },
                el( 'span', { className: 'pk-field-editor__label' },
                    ( field.label || field.name || __( 'Field', 'paksa-it-solutions' ) )
                    + ' (' + ( field.type || 'text' ) + ')'
                ),
                el( 'div', { className: 'pk-field-editor__actions' },
                    index > 0 && el( Button, { isSmall: true, icon: 'arrow-up-alt2',    onClick: onMoveUp, label: __( 'Move up', 'paksa-it-solutions' ) } ),
                    index < total - 1 && el( Button, { isSmall: true, icon: 'arrow-down-alt2', onClick: onMoveDn, label: __( 'Move down', 'paksa-it-solutions' ) } ),
                    el( Button, { isSmall: true, isDestructive: true, icon: 'trash', onClick: onRemove, label: __( 'Remove field', 'paksa-it-solutions' ) } )
                )
            ),
            el( SelectControl, {
                label: __( 'Type', 'paksa-it-solutions' ),
                value: field.type || 'text',
                options: fieldTypes,
                onChange: function( v ) { set( 'type', v ); },
            } ),
            el( TextControl, {
                label: __( 'Field Name (no spaces)', 'paksa-it-solutions' ),
                value: field.name || '',
                onChange: function( v ) { set( 'name', v.replace( /[^a-z0-9_]/gi, '' ).toLowerCase() ); },
                help: __( 'Maps to: name, email, phone, company, service, message, budget, timeline, interests', 'paksa-it-solutions' ),
            } ),
            field.type !== 'hidden' && el( TextControl, {
                label: __( 'Label', 'paksa-it-solutions' ),
                value: field.label || '',
                onChange: function( v ) { set( 'label', v ); },
            } ),
            field.type !== 'hidden' && field.type !== 'checkbox' && field.type !== 'consent' && el( TextControl, {
                label: __( 'Placeholder', 'paksa-it-solutions' ),
                value: field.placeholder || '',
                onChange: function( v ) { set( 'placeholder', v ); },
            } ),
            field.type === 'hidden' && el( TextControl, {
                label: __( 'Value', 'paksa-it-solutions' ),
                value: field.default || '',
                onChange: function( v ) { set( 'default', v ); },
            } ),
            field.type === 'select' && el( TextareaControl, {
                label: __( 'Options (one per line)', 'paksa-it-solutions' ),
                value: field.options || '',
                onChange: function( v ) { set( 'options', v ); },
            } ),
            field.type !== 'hidden' && el( ToggleControl, {
                label: __( 'Required', 'paksa-it-solutions' ),
                checked: !! field.required,
                onChange: function( v ) { set( 'required', v ); },
            } ),
            field.type !== 'hidden' && el( TextControl, {
                label: __( 'Help text', 'paksa-it-solutions' ),
                value: field.help || '',
                onChange: function( v ) { set( 'help', v ); },
            } ),
            el( SelectControl, {
                label: __( 'Width', 'paksa-it-solutions' ),
                value: String( field.width || '100' ),
                options: widthOptions,
                onChange: function( v ) { set( 'width', parseInt( v, 10 ) ); },
            } )
        );
    }

    /* ══════════════════════════════════════════════════════════════════════
       FORM BLOCK EDIT
       ══════════════════════════════════════════════════════════════════════ */

    function FormEdit( props ) {
        var attributes = props.attributes;
        var setAttributes = props.setAttributes;

        var fields = [];
        try { fields = JSON.parse( attributes.fields || '[]' ); } catch(e) { fields = []; }
        if ( ! Array.isArray( fields ) ) { fields = []; }

        function saveFields( arr ) {
            setAttributes( { fields: JSON.stringify( arr ) } );
        }

        function addField() {
            saveFields( fields.concat( [{
                type: 'text', name: 'field_' + ( fields.length + 1 ),
                label: 'Field ' + ( fields.length + 1 ),
                required: false, width: 100,
            }] ) );
        }

        function updateField( index, updated ) {
            var arr = fields.slice();
            arr[ index ] = updated;
            saveFields( arr );
        }

        function removeField( index ) {
            saveFields( fields.filter( function( _, i ) { return i !== index; } ) );
        }

        function moveField( index, dir ) {
            var arr = fields.slice();
            var target = index + dir;
            if ( target < 0 || target >= arr.length ) { return; }
            var tmp = arr[ index ];
            arr[ index ] = arr[ target ];
            arr[ target ] = tmp;
            saveFields( arr );
        }

        var blockProps = useBlockProps( { className: 'pk-form-block pk-form-block--' + ( attributes.variant || 'default' ) } );

        return el( Fragment, null,

            /* ── Inspector ── */
            el( InspectorControls, null,

                el( PanelBody, { title: __( 'Form Settings', 'paksa-it-solutions' ), initialOpen: true },
                    el( SelectControl, {
                        label: __( 'Variant', 'paksa-it-solutions' ),
                        value: attributes.variant || 'default',
                        options: formVariants,
                        onChange: function( v ) { setAttributes( { variant: v } ); },
                    } ),
                    el( TextControl, {
                        label: __( 'Submit Button Label', 'paksa-it-solutions' ),
                        value: attributes.submitLabel || '',
                        placeholder: __( 'Send Message', 'paksa-it-solutions' ),
                        onChange: function( v ) { setAttributes( { submitLabel: v } ); },
                    } ),
                    el( ToggleControl, {
                        label: __( 'Show arrow icon on submit', 'paksa-it-solutions' ),
                        checked: attributes.submitIcon !== false,
                        onChange: function( v ) { setAttributes( { submitIcon: v } ); },
                    } ),
                    el( ToggleControl, {
                        label: __( 'Two-column layout', 'paksa-it-solutions' ),
                        checked: !! attributes.twoColumn,
                        onChange: function( v ) { setAttributes( { twoColumn: v } ); },
                    } )
                ),

                el( PanelBody, { title: __( 'Messages', 'paksa-it-solutions' ), initialOpen: false },
                    el( TextareaControl, {
                        label: __( 'Success message', 'paksa-it-solutions' ),
                        value: attributes.successMessage || '',
                        placeholder: __( "Thank you! We'll be in touch shortly.", 'paksa-it-solutions' ),
                        onChange: function( v ) { setAttributes( { successMessage: v } ); },
                    } ),
                    el( TextareaControl, {
                        label: __( 'Error message', 'paksa-it-solutions' ),
                        value: attributes.errorMessage || '',
                        placeholder: __( 'Something went wrong. Please try again.', 'paksa-it-solutions' ),
                        onChange: function( v ) { setAttributes( { errorMessage: v } ); },
                    } )
                ),

                el( PanelBody, { title: __( 'Context', 'paksa-it-solutions' ), initialOpen: false },
                    el( ToggleControl, {
                        label: __( 'Include page/post context', 'paksa-it-solutions' ),
                        help: __( 'Adds current page title as the service field (server-side only).', 'paksa-it-solutions' ),
                        checked: !! attributes.includeContext,
                        onChange: function( v ) { setAttributes( { includeContext: v } ); },
                    } ),
                    attributes.includeContext && el( TextControl, {
                        label: __( 'Context label', 'paksa-it-solutions' ),
                        value: attributes.contextLabel || '',
                        placeholder: __( 'Enquiry about', 'paksa-it-solutions' ),
                        onChange: function( v ) { setAttributes( { contextLabel: v } ); },
                    } )
                ),

                el( PanelBody, { title: __( 'Fields (' + fields.length + ')', 'paksa-it-solutions' ), initialOpen: true },
                    fields.map( function( field, i ) {
                        return el( FieldEditor, {
                            key: i,
                            field: field,
                            index: i,
                            total: fields.length,
                            onChange: function( updated ) { updateField( i, updated ); },
                            onRemove: function() { removeField( i ); },
                            onMoveUp: function() { moveField( i, -1 ); },
                            onMoveDn: function() { moveField( i, 1 ); },
                        } );
                    } ),
                    el( Button, {
                        isPrimary: true,
                        onClick: addField,
                        style: { marginTop: '12px', width: '100%' },
                    }, __( '+ Add Field', 'paksa-it-solutions' ) )
                )
            ),

            /* ── Canvas preview ── */
            el( 'div', blockProps,
                el( 'div', { className: 'pk-form-preview-label' },
                    el( 'svg', { width: 16, height: 16, viewBox: '0 0 24 24', fill: 'none', stroke: 'currentColor', strokeWidth: 2, 'aria-hidden': true },
                        el( 'rect', { x: 3, y: 3, width: 18, height: 18, rx: 2 } ),
                        el( 'line', { x1: 3, y1: 9, x2: 21, y2: 9 } ),
                        el( 'line', { x1: 9, y1: 21, x2: 9, y2: 9 } )
                    ),
                    __( 'Paksa Form', 'paksa-it-solutions' ),
                    el( 'span', { className: 'pk-form-preview-variant' }, attributes.variant || 'default' )
                ),
                el( 'div', { className: 'pk-form-fields pk-form-preview' },
                    fields.length === 0
                        ? el( 'p', { className: 'pk-form-preview-empty' },
                            __( 'No fields yet. Add fields in the inspector panel →', 'paksa-it-solutions' ) )
                        : fields.map( function( f, i ) {
                            return el( 'div', {
                                key: i,
                                className: 'pk-form-group pk-form-field--w' + ( f.width || 100 ),
                            },
                                f.type !== 'checkbox' && f.type !== 'consent' && f.type !== 'hidden' &&
                                    el( 'label', { className: 'pk-form-label' },
                                        f.label || f.name,
                                        f.required && el( 'span', { className: 'pk-form-required', 'aria-hidden': true }, '*' )
                                    ),
                                f.type === 'textarea'
                                    ? el( 'textarea', { className: 'pk-form-input pk-form-textarea', placeholder: f.placeholder || '', readOnly: true, rows: 3 } )
                                    : f.type === 'select'
                                    ? el( 'select', { className: 'pk-form-input pk-form-select', disabled: true },
                                        el( 'option', null, f.placeholder || __( 'Select…', 'paksa-it-solutions' ) ) )
                                    : f.type === 'checkbox' || f.type === 'consent'
                                    ? el( 'label', { className: 'pk-form-checkbox-label' },
                                        el( 'input', { type: 'checkbox', className: 'pk-form-checkbox', disabled: true } ),
                                        el( 'span', null, f.label || f.name ) )
                                    : f.type === 'hidden'
                                    ? el( 'span', { className: 'pk-form-hidden-preview' }, __( 'Hidden: ', 'paksa-it-solutions' ) + ( f.name || '' ) )
                                    : el( 'input', { type: f.type || 'text', className: 'pk-form-input', placeholder: f.placeholder || '', readOnly: true } )
                            );
                        } )
                ),
                el( 'div', { className: 'pk-form-footer' },
                    el( 'button', { className: 'pk-form-submit pk-btn-primary', disabled: true },
                        el( 'span', { className: 'pk-form-submit__label' },
                            attributes.submitLabel || __( 'Send Message', 'paksa-it-solutions' )
                        )
                    )
                )
            )
        );
    }

    /* ── Register paksa/form ── */
    blocks.registerBlockType( 'paksa/form', {
        title:       __( 'Paksa Form', 'paksa-it-solutions' ),
        description: __( 'Conversion form using the existing secure contact-form handler.', 'paksa-it-solutions' ),
        category:    'paksa-forms',
        icon:        'feedback',
        keywords:    [ 'form', 'contact', 'lead', 'conversion', 'paksa' ],
        supports: {
            anchor:  true,
            align:   [ 'wide', 'full' ],
            spacing: { padding: true, margin: true },
            color:   { background: true },
        },
        attributes: {
            formId:         { type: 'string',  default: '' },
            formTitle:      { type: 'string',  default: '' },
            fields:         { type: 'string',  default: '' },
            variant:        { type: 'string',  default: 'default' },
            submitLabel:    { type: 'string',  default: '' },
            submitIcon:     { type: 'boolean', default: true },
            successMessage: { type: 'string',  default: '' },
            errorMessage:   { type: 'string',  default: '' },
            includeContext: { type: 'boolean', default: false },
            contextLabel:   { type: 'string',  default: '' },
            twoColumn:      { type: 'boolean', default: false },
        },
        edit: FormEdit,
        save: function() { return null; }, // server-rendered
    } );

    /* ══════════════════════════════════════════════════════════════════════
       CONDITIONAL VISIBILITY — BlockEdit filter
       Adds a "Visibility" panel to every block's inspector.
       ══════════════════════════════════════════════════════════════════════ */

    var visibilityContexts = cfg.visibilityContexts || [];

    hooks.addFilter(
        'editor.BlockEdit',
        'paksa/conditional-visibility',
        compose.createHigherOrderComponent( function( BlockEdit ) {
            return function( props ) {
                var pkVisibility         = props.attributes.pkVisibility         || 'always';
                var pkVisibilityPostType = props.attributes.pkVisibilityPostType || '';

                return el( Fragment, null,
                    el( BlockEdit, props ),
                    el( InspectorControls, null,
                        el( PanelBody, {
                            title: __( 'Visibility', 'paksa-it-solutions' ),
                            initialOpen: false,
                            className: 'pk-visibility-panel',
                        },
                            el( SelectControl, {
                                label: __( 'Show block when', 'paksa-it-solutions' ),
                                value: pkVisibility,
                                options: visibilityContexts,
                                onChange: function( v ) {
                                    props.setAttributes( { pkVisibility: v } );
                                },
                            } ),
                            pkVisibility === 'post_type' && el( TextControl, {
                                label: __( 'Post type slug', 'paksa-it-solutions' ),
                                value: pkVisibilityPostType,
                                placeholder: 'paksa_product',
                                onChange: function( v ) {
                                    props.setAttributes( { pkVisibilityPostType: v } );
                                },
                            } )
                        )
                    )
                );
            };
        }, 'withConditionalVisibility' )
    );

})();

/* ══════════════════════════════════════════════════════════════════════════
   FRONTEND FORM HANDLER
   Scoped IIFE — handles all .pk-form elements on the page.
   Submits to existing paksa_contact_submit AJAX action.
   ══════════════════════════════════════════════════════════════════════════ */
(function () {
    'use strict';

    function initForm( form ) {
        if ( form.dataset.pkInit ) { return; }
        form.dataset.pkInit = '1';

        var ajaxUrl   = form.dataset.ajaxUrl   || '/wp-admin/admin-ajax.php';
        var nonce     = form.dataset.nonce     || '';
        var successId = form.dataset.successId || '';
        var errorId   = form.dataset.errorId   || '';

        var successEl = successId ? document.getElementById( successId ) : null;
        var errorEl   = errorId   ? document.getElementById( errorId )   : null;
        var submitBtn = form.querySelector( '.pk-form-submit' );

        /* Client-side required validation */
        function validateForm() {
            var valid = true;
            form.querySelectorAll( '[required]' ).forEach( function( field ) {
                var err = field.parentElement.querySelector( '.pk-form-field-error' );
                var empty = field.type === 'checkbox' ? ! field.checked : ! field.value.trim();
                if ( empty ) {
                    valid = false;
                    field.setAttribute( 'aria-invalid', 'true' );
                    if ( ! err ) {
                        var msg = document.createElement( 'span' );
                        msg.className = 'pk-form-field-error';
                        msg.textContent = field.type === 'email'
                            ? 'Please enter a valid email address.'
                            : 'This field is required.';
                        field.parentElement.appendChild( msg );
                    }
                } else {
                    field.removeAttribute( 'aria-invalid' );
                    if ( err ) { err.remove(); }
                }
            } );
            return valid;
        }

        form.addEventListener( 'submit', function( e ) {
            e.preventDefault();

            /* Honeypot */
            var hp = form.querySelector( '[name="website_url"]' );
            if ( hp && hp.value ) { return; }

            if ( ! validateForm() ) { return; }

            if ( submitBtn ) {
                submitBtn.classList.add( 'is-loading' );
                submitBtn.disabled = true;
            }
            if ( successEl ) { successEl.hidden = true; }
            if ( errorEl )   { errorEl.hidden   = true; }

            var data = new FormData( form );
            data.set( 'action', 'paksa_contact_submit' );
            data.set( 'nonce',  nonce );

            fetch( ajaxUrl, { method: 'POST', body: data } )
                .then( function( r ) { return r.json(); } )
                .then( function( res ) {
                    if ( submitBtn ) { submitBtn.classList.remove( 'is-loading' ); submitBtn.disabled = false; }
                    if ( res.success ) {
                        if ( successEl ) { successEl.hidden = false; }
                        form.reset();
                    } else {
                        if ( errorEl ) { errorEl.hidden = false; }
                    }
                } )
                .catch( function() {
                    if ( submitBtn ) { submitBtn.classList.remove( 'is-loading' ); submitBtn.disabled = false; }
                    if ( errorEl ) { errorEl.hidden = false; }
                } );
        } );

        /* Live validation on blur */
        form.querySelectorAll( '[required]' ).forEach( function( field ) {
            field.addEventListener( 'blur', function() {
                var err = field.parentElement.querySelector( '.pk-form-field-error' );
                var empty = field.type === 'checkbox' ? ! field.checked : ! field.value.trim();
                if ( empty ) {
                    field.setAttribute( 'aria-invalid', 'true' );
                } else {
                    field.removeAttribute( 'aria-invalid' );
                    if ( err ) { err.remove(); }
                }
            } );
        } );
    }

    /* Init all forms on DOMContentLoaded */
    function initAll() {
        document.querySelectorAll( '.pk-form' ).forEach( initForm );
    }

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', initAll );
    } else {
        initAll();
    }

})();
