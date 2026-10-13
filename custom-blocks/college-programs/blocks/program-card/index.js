/**
 * Program Card block: editor script.
 *
 * Plain JavaScript on the wp.* globals, so there is no build step. The card
 * itself is rendered by render.php; the editor previews that same output.
 */
( function ( wp ) {
	'use strict';

	var el = wp.element.createElement;
	var Fragment = wp.element.Fragment;
	var __ = wp.i18n.__;
	var useSelect = wp.data.useSelect;
	var useBlockProps = wp.blockEditor.useBlockProps;
	var InspectorControls = wp.blockEditor.InspectorControls;
	var PanelBody = wp.components.PanelBody;
	var SelectControl = wp.components.SelectControl;
	var Placeholder = wp.components.Placeholder;
	var Spinner = wp.components.Spinner;
	var Disabled = wp.components.Disabled;
	var ServerSideRender = wp.serverSideRender;
	var decodeEntities = wp.htmlEntities.decodeEntities;

	var QUERY = {
		per_page: 100,
		status: 'publish',
		orderby: 'title',
		order: 'asc',
		_fields: 'id,title',
	};

	function Edit( props ) {
		var programId = props.attributes.programId;
		var blockProps = useBlockProps();

		// null while the request is in flight, then an array.
		var programs = useSelect( function ( select ) {
			return select( 'core' ).getEntityRecords( 'postType', 'program', QUERY );
		}, [] );

		var options = [ { label: __( 'Select a program', 'college-programs' ), value: 0 } ].concat(
			( programs || [] ).map( function ( program ) {
				return {
					label: decodeEntities( program.title.rendered ) || __( '(no title)', 'college-programs' ),
					value: program.id,
				};
			} )
		);

		function picker( hideLabel ) {
			return el( SelectControl, {
				label: __( 'Program', 'college-programs' ),
				hideLabelFromVision: hideLabel,
				value: programId,
				options: options,
				onChange: function ( value ) {
					props.setAttributes( { programId: parseInt( value, 10 ) || 0 } );
				},
				__next40pxDefaultSize: true,
				__nextHasNoMarginBottom: true,
			} );
		}

		var body;
		if ( ! programId ) {
			var noPrograms = Array.isArray( programs ) && programs.length === 0;
			body = el(
				Placeholder,
				{
					icon: 'welcome-learn-more',
					label: __( 'Program Card', 'college-programs' ),
					instructions: noPrograms
						? __( 'No published programs yet. Add one under Programs, then pick it here.', 'college-programs' )
						: __( 'Choose the program this card should show.', 'college-programs' ),
				},
				programs === null ? el( Spinner ) : ! noPrograms && picker( true )
			);
		} else {
			// Disabled stops the preview's links navigating away from the editor.
			body = el(
				Disabled,
				null,
				el( ServerSideRender, {
					block: 'college-programs/program-card',
					attributes: props.attributes,
				} )
			);
		}

		return el(
			Fragment,
			null,
			el(
				InspectorControls,
				null,
				el( PanelBody, { title: __( 'Program', 'college-programs' ) }, picker( false ) )
			),
			el( 'div', blockProps, body )
		);
	}

	wp.blocks.registerBlockType( 'college-programs/program-card', {
		edit: Edit,
		// Dynamic block: markup comes from render.php on every request.
		save: function () {
			return null;
		},
	} );
} )( window.wp );
