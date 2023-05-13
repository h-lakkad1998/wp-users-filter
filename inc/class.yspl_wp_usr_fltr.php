<?php
/**
 * YSPL_WP_USR_FLTR Class
 *
 * Handles the plugin functionality.
 *
 * @package WordPress
 * @package Plugin name
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


if ( !class_exists( 'YSPL_WP_USR_FLTR' ) ) {

	/**
	 * The main YSPL_WP_USR_FLTR class
	 */
	class YSPL_WP_USR_FLTR {

		private static $_instance = null;

		var $admin = null,
		    $front = null,
		    $lib   = null;

		public static function instance() {

			if ( is_null( self::$_instance ) )
				self::$_instance = new self();

			return self::$_instance;
		}

		function __construct() {

			add_action( 'plugins_loaded', array( $this, 'action__plugins_loaded' ), 1 );

			# Register plugin activation hook
			register_activation_hook( YSPL_WP_USR_FLTR_FILE, array( $this, 'action__plugin_activation' ) );

		}

		/**
		 * Action: plugins_loaded
		 *
		 * -
		 *
		 * @return [type] [description]
		 */
		function action__plugins_loaded() {

			# Load Paypal SDK on int action

			# Action to load custom post type
			add_action( 'init', array( $this, 'action__init' ) );

			global $wp_version;

			# Set filter for plugin's languages directory
			$YSPL_WP_USR_FLTR_lang_dir = dirname( YSPL_WP_USR_FLTR_PLUGIN_BASENAME ) . '/languages/';
			$YSPL_WP_USR_FLTR_lang_dir = apply_filters( 'YSPL_WP_USR_FLTR_languages_directory', $YSPL_WP_USR_FLTR_lang_dir );

			# Traditional WordPress plugin locale filter.
			$get_locale = get_locale();

			if ( $wp_version >= 4.7 ) {
				$get_locale = get_user_locale();
			}

			# Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale',  $get_locale, 'plugin-text-domain' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'plugin-text-domain', $locale );

			# Setup paths to current locale file
			$mofile_global = WP_LANG_DIR . '/plugins/' . basename( YSPL_WP_USR_FLTR_DIR ) . '/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				# Look in global /wp-content/languages/plugin-name folder
				load_textdomain( 'plugin-text-domain', $mofile_global );
			} else {
				# Load the default language files
				load_plugin_textdomain( 'plugin-text-domain', false, $YSPL_WP_USR_FLTR_lang_dir );
			}
		}

		/**
		 * Action: init
		 *
		 * - If license found then action run
		 *
		 */
		function action__init() {

			flush_rewrite_rules();

			# Post Type: Here you add your post type

		}

		/**
		 * register_activation_hook
		 *
		 * - When active plugin
		 *
		 */
		function action__plugin_activation() {

		}

	}
}

function YSPL_WP_USR_FLTR() {
	return YSPL_WP_USR_FLTR::instance();
}

YSPL_WP_USR_FLTR();
