<?php
/**
 * Run on plugin install.
 *
 * @package CDJ_Services
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CJD_Services_Install Class
 */
class CJD_Services_Install {

	/**
	 * Constructor
	 */
	public function __construct() {
		register_activation_hook( CJD_SERVICES_PLUGIN_FILE, array( $this, 'register_defaults' ) );
		register_deactivation_hook( CJD_SERVICES_PLUGIN_FILE, array( $this, 'deactivate_services' ) );
	}

	/**
	 * Register plugin defaults.
	 */
	public function register_defaults() {
		if ( is_admin() ) {
			if ( ! get_option( 'cjd_services_date_installed' ) ) {
				add_option( 'cjd_services_date_installed', gmdate( 'Y-m-d h:i:s' ) );
			}
		}
	}

    /**
	 * Remove post types and taxonomies from memory
	 */
	public function deactivate_services() {
	    unregister_taxonomy_from_object_type( 'service-category', 'services' );

	    // Unregister the post type, so the rules are no longer in memory.
		unregister_post_type( 'services' );

        // If taxonomy no longer has any post types associated with it,
        // remove from memory as well
        $taxonomy = get_taxonomy( 'service-category' );
        if ( !$taxonomy->object_type ) {
		    unregister_taxonomy( 'service-category' );
		}

		// Clear the permalinks to remove our post type's rules from the database.
        flush_rewrite_rules();
	}
}

return new CJD_Services_Install();
