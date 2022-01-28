<?php
/**
 * Registers CJD Services Custom Taxonomies
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
class CJD_Services_Custom_Taxonomies {
	/**
	 * This plugin's instance.
	 *
	 * @var CJD_Services_Custom_Taxonomies
	 */
	private static $instance;

	/**
	 * Registers the plugin.
	 *
	 * @return CJD_Services_Custom_Taxonomies
	 */
	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new CJD_Services_Custom_Taxonomies();
		}

		return self::$instance;
	}

	/**
	 * The Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'create_custom_taxonomies' ), 0 );
	}

	/**
	 * Registers the taxonomies.
	 *
	 * @access public
	 */
	function create_custom_taxonomies() {

		// Add new "Service Categories" taxonomy to Posts 
	    // This array of options controls the labels displayed in the WordPress Admin UI
	    $labels = array(
			'name' => _x( 'Service Categories', 'taxonomy general name' ),
			'singular_name' => _x( 'Service Category', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Service Categories' ),
			'all_items' => __( 'All Service Categories' ),
			'parent_item' => __( 'Parent Service Category' ),
			'parent_item_colon' => __( 'Parent Service Category:' ),
			'edit_item' => __( 'Edit Service Category' ),
			'update_item' => __( 'Update Service Category' ),
			'add_new_item' => __( 'Add New Service Category' ),
			'new_item_name' => __( 'New Service Category Name' ),
			'no_terms' => __( 'No service categories' ),
			'menu_name' => __( 'Service Categories' ),
			'back_to_items' => __( '&larr; Back to Service Categories' ),
		  );
	  
		  $args = array(
			  'hierarchical' => true, // Hierarchical taxonomy (like categories)
			  'labels'	=> $labels,
			  'public'	=>	true,
			  'show_in_rest'	=> true,
			  'rewrite' => array(
				'slug' => 'service-categories', // This controls the base slug that will display before each term
				'with_front' => false, // Don't display the category base before "/service-categories/"
				'hierarchical' => true // This will allow URL's like "/service-categories/preventative-care/diet/"
			  ),
			  'show_admin_column' => true,
			  'args' => array( 'orderby' => 'term_order' ),
		  );
		
		  register_taxonomy('service-category', 'service', $args);
	}
}

CJD_Services_Custom_Taxonomies::register();
