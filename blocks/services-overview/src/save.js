/**
 * External dependencies
 */
 import classnames from 'classnames';


/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { select } from '@wordpress/data';
import {
	RichText,
	useBlockProps,
	InnerBlocks
} from '@wordpress/block-editor';

/**
 * Internal dependencies
 */

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#save
 *
 * @return {WPElement} Element to render.
 */
 export default function save( { attributes } ) {
	const { align, citation } = attributes;

	const bubbleQuoteClass =
		classnames(
			{
				[`has-text-align-${ align }`] : align,
				[`has-citation`] : citation,
			}
		);

	const blockProps = useBlockProps.save( {
		className: bubbleQuoteClass
	} );

	return (
		<blockquote { ...blockProps }>
			<InnerBlocks.Content />
			{ ! RichText.isEmpty( citation ) && (
				<RichText.Content tagName="cite" value={ citation } />
			) }
		</blockquote>
	);
}
