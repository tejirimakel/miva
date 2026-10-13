/**
 * Call to Action block: editor script.
 *
 * Plain JavaScript on the wp.* globals, so there is no build step. The text is
 * edited in place; render.php builds the frontend markup from the attributes.
 */
( function ( wp ) {
	'use strict';

	var el = wp.element.createElement;
	var Fragment = wp.element.Fragment;
	var __ = wp.i18n.__;
	var useBlockProps = wp.blockEditor.useBlockProps;
	var InspectorControls = wp.blockEditor.InspectorControls;
	var RichText = wp.blockEditor.RichText;
	var PanelBody = wp.components.PanelBody;
	var TextControl = wp.components.TextControl;

	function Edit( props ) {
		var attributes = props.attributes;
		var blockProps = useBlockProps( { className: 'college-cta' } );

		function setter( name ) {
			return function ( value ) {
				var next = {};
				next[ name ] = value;
				props.setAttributes( next );
			};
		}

		return el(
			Fragment,
			null,
			el(
				InspectorControls,
				null,
				el(
					PanelBody,
					{ title: __( 'Button', 'college-programs' ) },
					el( TextControl, {
						label: __( 'Button link', 'college-programs' ),
						type: 'url',
						value: attributes.buttonUrl,
						onChange: setter( 'buttonUrl' ),
						placeholder: 'https://',
						help: __( 'Leave empty to link to the program directory.', 'college-programs' ),
						__next40pxDefaultSize: true,
						__nextHasNoMarginBottom: true,
					} )
				)
			),
			el(
				'div',
				blockProps,
				el(
					'div',
					{ className: 'college-cta__text' },
					el( RichText, {
						tagName: 'h2',
						className: 'college-cta__heading',
						value: attributes.heading,
						onChange: setter( 'heading' ),
						placeholder: __( 'Add a heading', 'college-programs' ),
						allowedFormats: [],
					} ),
					el( RichText, {
						tagName: 'p',
						className: 'college-cta__body',
						value: attributes.text,
						onChange: setter( 'text' ),
						placeholder: __( 'Add a short message', 'college-programs' ),
						allowedFormats: [ 'core/bold', 'core/italic' ],
					} )
				),
				// A span, not a link, so clicking it edits the label instead of navigating.
				el( RichText, {
					tagName: 'span',
					className: 'college-cta__button',
					value: attributes.buttonText,
					onChange: setter( 'buttonText' ),
					placeholder: __( 'Button label', 'college-programs' ),
					allowedFormats: [],
					withoutInteractiveFormatting: true,
				} )
			)
		);
	}

	wp.blocks.registerBlockType( 'college-programs/cta', {
		edit: Edit,
		// Dynamic block: markup comes from render.php on every request.
		save: function () {
			return null;
		},
	} );
} )( window.wp );
