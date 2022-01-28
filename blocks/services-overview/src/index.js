/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import './style.scss';
//import metadata from '../block.json';
import ServicesOverviewEdit from './edit';

// const { name, icon } = metadata;
// export { metadata, name };

// export const settings = {
// 	icon,
// 	ServicesOverviewEdit,
// };

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( 'cjd-blocks/services-overview', {
	/**
	 * @see ./edit.js
	 */
	edit: ServicesOverviewEdit,
} );

