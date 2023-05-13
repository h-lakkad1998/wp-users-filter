<?php
/**
 * YSPL_WP_USR_FLTR_Admin_Action Class
 *
 * Handles the admin functionality.
 *
 * @package WordPress
 * @package Plugin name
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'YSPL_WP_USR_FLTR_Admin_Action' ) ) {
	
	/**
	 *  The YSPL_WP_USR_FLTR_Admin_Action Class
	 */
	class YSPL_WP_USR_FLTR_Admin_Action {

		function __construct()  {
			if(current_user_can( 'administrator' )){
				add_action( 'admin_init', array( $this, 'yspl_wp_usr_fltr_action__admin_init' ) );
				add_action( 'manage_users_extra_tablenav', array( $this, 'yspl_wp_usr_fltr_render_custom_filter_html' ) );
			}
		}

		/*
		   ###     ######  ######## ####  #######  ##    ##  ######
		  ## ##   ##    ##    ##     ##  ##     ## ###   ## ##    ##
		 ##   ##  ##          ##     ##  ##     ## ####  ## ##
		##     ## ##          ##     ##  ##     ## ## ## ##  ######
		######### ##          ##     ##  ##     ## ##  ####       ##
		##     ## ##    ##    ##     ##  ##     ## ##   ### ##    ##
		##     ##  ######     ##    ####  #######  ##    ##  ######
		*/

		/**
		 * Action: admin_init
		 *
		 * - Register admin min js and admin min css
		 *
		 */
		function yspl_wp_usr_fltr_action__admin_init() {
			// wp_register_script( YSPL_WP_USR_FLTR_PREFIX . '_admin_js', YSPL_WP_USR_FLTR_URL . 'assets/js/admin.min.js', array( 'jquery' ), YSPL_WP_USR_FLTR_VERSION, true );
			// wp_register_style( YSPL_WP_USR_FLTR_PREFIX . '_admin_css', YSPL_WP_USR_FLTR_URL . 'assets/css/admin.min.css', array(), YSPL_WP_USR_FLTR_VERSION );
			wp_register_script( YSPL_WP_USR_FLTR_PREFIX . '_admin_js', YSPL_WP_USR_FLTR_URL . 'assets/js/admin.js', array( 'jquery' ), YSPL_WP_USR_FLTR_VERSION, true );
			wp_register_style( YSPL_WP_USR_FLTR_PREFIX . '_admin_css', YSPL_WP_USR_FLTR_URL . 'assets/css/admin.css', array(), YSPL_WP_USR_FLTR_VERSION );
			$yspl_local_array = array(
				    'plugin_prefix' => YSPL_WP_USR_FLTR_PREFIX
			);
			wp_localize_script(YSPL_WP_USR_FLTR_PREFIX . '_admin_js', 'yspl_usr_fltr_obj', $yspl_local_array );
			wp_enqueue_script( YSPL_WP_USR_FLTR_PREFIX . '_admin_js' );
			wp_enqueue_style(  YSPL_WP_USR_FLTR_PREFIX . '_admin_css' );
		}
		/**
		 * admin panel add filter and export button
		*/
		function yspl_wp_usr_fltr_render_custom_filter_html() {	 
				include_once( YSPL_WP_USR_FLTR_DIR . '/inc/admin/html_filter_model_'. YSPL_WP_USR_FLTR_PREFIX .'.php' );
		}
		/****
		 * 
		 * 
		 * **/

		/*
		######## ##     ## ##    ##  ######  ######## ####  #######  ##    ##  ######
		##       ##     ## ###   ## ##    ##    ##     ##  ##     ## ###   ## ##    ##
		##       ##     ## ####  ## ##          ##     ##  ##     ## ####  ## ##
		######   ##     ## ## ## ## ##          ##     ##  ##     ## ## ## ##  ######
		##       ##     ## ##  #### ##          ##     ##  ##     ## ##  ####       ##
		##       ##     ## ##   ### ##    ##    ##     ##  ##     ## ##   ### ##    ##
		##        #######  ##    ##  ######     ##    ####  #######  ##    ##  ######
		*/


	}

	add_action( 'plugins_loaded', function() {
		if(current_user_can( 'administrator' ))
			YSPL_WP_USR_FLTR()->admin->action = new YSPL_WP_USR_FLTR_Admin_Action;
	} );
}
