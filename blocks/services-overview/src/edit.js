/**
 * External dependencies
 */
 import classnames from 'classnames';

/**
 * WordPress dependencies
 */
 import { __ } from '@wordpress/i18n';
 import { useSelect } from '@wordpress/data';
 import {
	 AlignmentControl,
	 BlockControls,
	 RichText,
	 useBlockProps
 } from '@wordpress/block-editor';
 import { BlockQuotation } from '@wordpress/components';
 import { createBlock } from '@wordpress/blocks';
 import { Platform } from '@wordpress/element';

 const isWebPlatform = Platform.OS === 'web';

/**
 * Internal dependencies
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
 export default function ServicesOverviewEdit( {
	clientId,
	attributes,
	setAttributes,
	isSelected,
	insertBlocksAfter,
} ) {
	const { align } = attributes;

	const serviceCategories = useSelect( ( select ) => select( 'core' ).getEntityRecords('taxonomy', 'service-category') );

	const servicesOverviewClass =
		classnames(
			{
				[`has-text-align-${ align }`] : align
			}
		);

	const blockProps = useBlockProps( {
		className: servicesOverviewClass,
	} );

	const controls = (
		<>
			<BlockControls group="block">
				<AlignmentControl
					value={ align }
					onChange={ ( nextAlign ) => {
						setAttributes( { align: nextAlign } );
					} }
				/>
			</BlockControls>
		</>
	);

	return (
		<>
			{ controls }
			{ ! serviceCategories && 'Loading' }
			{ serviceCategories && serviceCategories.length === 0 && 'No Service Categories' }
			{ serviceCategories && serviceCategories.length > 0 && (
				<div>
					<h3>{ serviceCategories[0].name }</h3>
					<p>{ serviceCategories[0].description }</p>
					<div className="wp_block_button is-style-childhoodhealth-text-link">
						<a className="wp-block-button__link">Learn More</a>
					</div>
				</div>
			)}
		</>
	);
}
