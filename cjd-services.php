<?php

/**
 * SERVICES CUSTOM POST TYPE
 * 
 * @package             CJD_Services
 * @author              Candace Johnson Designs
 * @copyright           2021 Candace Johnson Designs
 * @license             GPL-2.0-or-later
 * 
 *@wordpress-plugin
 * Plugin Name:         Services
 * Description:         A Services package that includes a custom post type and a custom taxonomy for service-category. 
 * Version:             1.0.0
 * Text Domain:         cjd-services
 * Author:              Candace Johnson Designs
 * License:             GPL v2 or later
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
 * Author URI:          http://candacejohnsondesigns.com
 */


defined( 'ABSPATH' ) || exit;

define( 'CJD_SERVICES_VERSION', '1.0.0' );
define( 'CJD_SERVICES_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CJD_SERVICES_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CJD_SERVICES_PLUGIN_FILE', __FILE__ );
define( 'CJD_SERVICES_PLUGIN_BASE', plugin_basename( __FILE__ ) );
define( 'SLUG', 'cjd-services' );

if ( ! class_exists( 'CJD_Services' ) ) :

    /**
     * CJD Services plugin class.
     * 
     * @since 1.0.0
     */
    final class CJD_Services {
        /**
         * This plugin's instance.
         * 
         * @var CJD_Services
         * @since 1.0.0
         */
        private static $instance;

        /**
		 * Main CJD_Services Instance.
		 *
		 * Insures that only one instance of CJD_Services exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since 1.0.0
		 * @static
		 * @return object|CJD_FAQS The one and only CJD_Services
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof CJD_Services ) ) {
				self::$instance = new CJD_Services();
				self::$instance->init();
				self::$instance->includes();
			}
			return self::$instance;
		}

        /**
		 * Throw error on object clone.
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'cjd-services' ), '1.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'cjd-services' ), '1.0' );
		}

        /**
		 * Include required files.
		 *
		 * @access private
		 * @since 1.0.0
		 * @return void
		 */
		private function includes() {
			// Attributes.
			require_once CJD_SERVICES_PLUGIN_DIR . 'includes/attributes/attribute-cjd-services-singleton.php';

			require_once CJD_SERVICES_PLUGIN_DIR . 'includes/class-cjd-services-custom-post-types.php';
			require_once CJD_SERVICES_PLUGIN_DIR . 'includes/class-cjd-services-custom-taxonomies.php';

			// Blocks
			//require_once CJD_SERVICES_PLUGIN_DIR . 'blocks/services-overview/index.php';



			if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
				require_once CJD_SERVICES_PLUGIN_DIR . 'includes/admin/class-cjd-services-install.php';
			}
		}

        /**
		 * Load actions
		 *
		 * @return void
		 */
		private function init() {
			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ), 99 );
			add_action( 'enqueue_block_editor_assets', array( $this, 'block_localization' ) );
			add_action( 'init', array( $this, 'cjd_services_register_services_overview' ) );
		}

        /**
		 * Loads the plugin language files.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'cjd-services', false, basename( CJD_SERVICES_PLUGIN_DIR ) . '/languages' );
		}

		/**
		 * Enqueue localization data for our blocks.
		 *
		 * @access public
		 */
		public function block_localization() {
			if ( function_exists( 'wp_set_script_translations' ) ) {
				wp_set_script_translations( 'cjd-services-editor', 'cjd-services', CJD_SERVICES_PLUGIN_DIR . '/languages' );
			}
		}

		function cjd_blocks_render_block_services_overview( $block_attributes, $content ) {

			// Initialize variables
			$serviceOverviewContent = '';
			$taxonomy = 'service-category';

			$args = array(
				'orderby' => 'meta_value_num',
				'order' => 'ASC',
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key' => 'services_order',
						'compare' => 'NOT EXISTS'
					),
					array(
						'key' => 'services_order',
						'value' => 0,
						'compare' => '>='
					)
				),
				'hide_empty' => true,
				'parent' => 0
			);

			$terms = get_terms($taxonomy, $args); // Get all terms of a taxonomy

			if ( ! $terms || is_wp_error( $terms )) {
				return;
			}

			foreach ( $terms as $term ) { 

				// Initialize variables
				$wrapperTag = 'div';
				$blockClass = '';
				$headingLevel = '3';

				$buttonStyleClass = 'is-style-childhoodhealth-text-link';
				$buttonURL = sprintf('/services/#%1$s', $term->slug);
				$buttonCTA = 'Learn More';

				$header = sprintf( 
					'<h%1$s>%2$s</h%1$s>', 
					$headingLevel, 
					$term->name
				);
				$description = sprintf(
					'<p>%1$s</p>',
					$term->description
				);
				$buttonLink = sprintf(
					'<a class="wp-block-button__link" href="%1$s">%2$s</a>',
					$buttonURL,
					$buttonCTA
				);
				$button = sprintf(
					'<div class="wp-block-buttons"><div class="wp-block-button %1$s">%2$s</div></div>', 
					$buttonStyleClass, 
					$buttonLink
				);

				$content = sprintf( 
					'%1$s%2$s%3$s', 
					$header, 
					$description, 
					$button 
				);

				$serviceOverviewContent .= sprintf(
					'<%1$s class="%2$s">%3$s</%1$s>', 
					$wrapperTag, 
					$blockClass, 
					$content
				);
			} 
			wp_reset_postdata();

			return sprintf( '<section>%1$s</section>', $serviceOverviewContent);
		}
		
		/**
		 * Registers the block using the metadata loaded from the `block.json` file.
		 * Behind the scenes, it registers also all assets so they can be enqueued
		 * through the block editor in the corresponding context.
		 *
		 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/writing-your-first-block-type/
		 */
		function cjd_services_register_services_overview() {
			register_block_type( 
				plugin_dir_path( __FILE__ ) . 'blocks/services-overview/',
				array(
					'render_callback' => array( $this, 'cjd_blocks_render_block_services_overview')
				)
			);
		}
    }
endif;   

/**
 * The main function for that returns CJD Services
 *
 * The main function responsible for returning the only CJD Services
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $CJD_Services = CJD_Services(); ?>
 *
 * @since 1.0.0
 * @return object|CJD_Services The one and only CJD_Services
 */
function CJD_Services() {
	return CJD_Services::instance();
}

// Get the plugin running. Load on plugins_loaded action to avoid issue on multisite.
if ( function_exists( 'is_multisite' ) && is_multisite() ) {
	add_action( 'plugins_loaded', 'cjd-services', 90 );
} else {
	CJD_Services();
}
