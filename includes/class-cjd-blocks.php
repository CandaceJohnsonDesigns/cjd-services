<?php
/**
 * Registers CJD Services Blocks
 *
 * @package   @@pkg.title
 * @author    @@pkg.author
 * @link      @@pkg.author_uri
 * @license   @@pkg.license
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register and manage blocks within a plugin. Used to manage block registration, enqueues, and more.
 *
 * @since 1.0.0
 */
class CJD_Blocks {

		/**
		 * This plugin's instance.
		 *
		 * @var CJD_Blocks
		 */
		private static $instance;

		/**
		 * Registers the plugin.
		 *
		 * @return CJD_Blocks
		 */
		public static function register() {
			if ( null === self::$instance ) {
				self::$instance = new CJD_Blocks();
			}

			return self::$instance;
		}

		/**
		 * The Constructor.
		 */
		public function __construct() {
			add_action( 'init', array($this, 'cjd_services_blocks_init') );
		}

	/**
	 * Registers the block using the metadata loaded from the `block.json` file.
	 * Behind the scenes, it registers also all assets so they can be enqueued
	 * through the block editor in the corresponding context.
	 *
	 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/writing-your-first-block-type/
	 */
	function cjd_services_blocks_init() {
		register_block_type( plugin_dir_path( __FILE__ ) . 'blocks/services-overview/' );
	}

	function cjd_blocks_services_overview_render_callback( $block_attributes, $content ) {
		return sprintf('<p>%1$s</p>', "I'm rendered!");
	}
	 
}

CJD_Blocks::register();
