<?php
/**
 * CoCart - Cart API Enhanced core setup.
 *
 * @author  Sébastien Dumont
 * @package Cart API Enhanced
 * @version 4.0.0
 * @license GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main CoCart Cart API Enhanced class.
 *
 * @class CoCart_Cart_API_Enhanced
 */
final class CoCart_Cart_API_Enhanced {

	/**
	 * Plugin Version
	 *
	 * @access public
	 *
	 * @static
	 *
	 * @var string
	 */
	public static $version = '4.0.3';

	/**
	 * Initiate CoCart Cart API Enhanced.
	 *
	 * @access public
	 *
	 * @static
	 */
	public static function init() {
		// Load filters.
		add_action( 'init', array( __CLASS__, 'include_filters' ) );

		// Load translation files.
		add_action( 'init', array( __CLASS__, 'load_plugin_textdomain' ), 0 );
	} // END init()

	/**
	 * Return the name of the package.
	 *
	 * @access public
	 *
	 * @static
	 *
	 * @return string
	 */
	public static function get_name() {
		return 'CoCart - Cart API Enhanced';
	} // END get_name()

	/**
	 * Return the version of the package.
	 *
	 * @access public
	 *
	 * @static
	 *
	 * @return string
	 */
	public static function get_version() {
		return self::$version;
	} // END get_version()

	/**
	 * Return the path to the package.
	 *
	 * @access public
	 *
	 * @static
	 *
	 * @return string
	 */
	public static function get_path() {
		return dirname( __DIR__ );
	} // END get_path()

	/**
	 * Load filters to enhance the cart and items.
	 *
	 * @access public
	 *
	 * @static
	 */
	public static function include_filters() {
		include_once __DIR__ . '/filters/filter-v1.php';
		include_once __DIR__ . '/filters/filter-v2.php';

		// If enabled, cart will enhance API v1.
		if ( apply_filters( 'cocart_preview_api_v2', false ) ) {
			include_once __DIR__ . '/filters/filter-v2-preview.php';
		}
	} // include_filters()

	/**
	 * Load the plugin translations if any ready.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 *
	 * Locales found in:
	 *      - WP_LANG_DIR/cocart-get-cart-enhanced/cocart-get-cart-enhanced-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/cocart-get-cart-enhanced-LOCALE.mo
	 *
	 * @access public
	 *
	 * @static
	 */
	public static function load_plugin_textdomain() {
		if ( function_exists( 'determine_locale' ) ) {
			$locale = determine_locale();
		} else {
			$locale = is_admin() ? get_user_locale() : get_locale();
		}

		$locale = apply_filters( 'plugin_locale', $locale, 'cocart-get-cart-enhanced' );

		unload_textdomain( 'cocart-get-cart-enhanced' );
		load_textdomain( 'cocart-get-cart-enhanced', WP_LANG_DIR . '/cocart-get-cart-enhanced/cocart-get-cart-enhanced-' . $locale . '.mo' );
		load_plugin_textdomain( 'cocart-get-cart-enhanced', false, plugin_basename( dirname( COCART_GET_CART_ENHANCED ) ) . '/languages' );
	} // END load_plugin_textdomain()
} // END class
