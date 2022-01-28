<?php
/**
 * Registers CJD Services Custom Post Types
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
 * Main @@pkg.title Class
 *
 * @since 1.0.0
 */
class CJD_Services_Custom_Post_Types {

	const CUSTOM_POST_TYPE       = 'services';


	/**
	 * This plugin's instance.
	 *
	 * @var CJD_Services_Custom_Post_Types
	 */
	private static $instance;

	/**
	 * Registers the plugin.
	 *
	 * @return CJD_Services_Custom_Post_Types
	 */
	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new CJD_Services_Custom_Post_Types();
		}

		return self::$instance;
	}

	/**
	 * The Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'create_post_types' ) );

		add_filter( sprintf( 'manage_%s_posts_columns', self::CUSTOM_POST_TYPE),       array( $this, 'edit_admin_columns' ) );
	}

	/**
	 * Registers the custom post types.
	 *
	 * @access public
	 */
	function create_post_types() {

		if ( post_type_exists( self::CUSTOM_POST_TYPE ) ) {
			return;
		}

		// Services Custom Post Type
		register_post_type( self::CUSTOM_POST_TYPE,
			array(
				'labels' => array(
					'name' => __( 'Services' ), 
					'singular_name' => __( 'Service' ), 
					'edit_item' => __( 'Edit Service' ),
					'view_item' => __( 'View Service' ),
					'view_items' => __( 'View Services' ),
					'search_items' => __( 'Search Services' ),
					'not_found' => __( 'No services found.' ),
					'all_items' => __( 'All Services' ),
				),
				'public' => true,
				'supports' => array ( 'title', 'editor', 'custom-fields', 'publicize', 'jetpack_sitemap_post_types' ),
				'taxonomies' => array( 'service-category' ), 
				'hierarchical' => false,
				'menu_position' => 2,
				'capability_type' => 'post',
				'menu_icon' => 'dashicons-clipboard',
				'show_in_rest' => true,
			)
		);
	}

	/**
	 * Change ‘Title’ column label
	 * Add Featured Image column
	 */
	function edit_admin_columns( $columns ) {
		// change 'Title' to 'Service'
		$columns['title'] = __( 'Service', 'cjd-services' );

		return $columns;
	}
}

CJD_Services_Custom_Post_Types::register();
