<?php
/**
 * Trait for our Singleton pattern.
 *
 * @package CJD_Services
 */

/**
 * Trait for our Singleton pattern.
 *
 * @since 1.0.0
 */
trait CJD_Services_Singleton_Attribute {
	/**
	 * The object instance.
	 *
	 * @var Object
	 */
	private static $instance = null;

	/**
	 * Return the plugin instance.
	 *
	 * @return Object
	 */
	public static function register() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Reset the plugin instance.
	 */
	public static function reset() {
		self::$instance = null;
	}
}
