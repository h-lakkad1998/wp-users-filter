<?php
/**
 * YSPL_WP_USR_FLTR_Admin_Filter Class
 *
 * Handles the admin functionality.
 *
 * @package WordPress
 * @subpackage Plugin name
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'YSPL_WP_USR_FLTR_Admin_Filter' ) ) {

	/**
	 *  The YSPL_WP_USR_FLTR_Admin_Filter Class
	 */
	class YSPL_WP_USR_FLTR_Admin_Filter {

		function __construct() {
				add_filter('pre_get_users',array( $this, 'filter_users_by_job_role_section')  );
		}
		function filter_users_by_job_role_section($query){
				include_once( YSPL_WP_USR_FLTR_DIR . '/inc/admin/query_filters.'. YSPL_WP_USR_FLTR_PREFIX .'.php' );
		}
		/*
		######## #### ##       ######## ######## ########   ######
		##        ##  ##          ##    ##       ##     ## ##    ##
		##        ##  ##          ##    ##       ##     ## ##
		######    ##  ##          ##    ######   ########   ######
		##        ##  ##          ##    ##       ##   ##         ##
		##        ##  ##          ##    ##       ##    ##  ##    ##
		##       #### ########    ##    ######## ##     ##  ######
		*/


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
			YSPL_WP_USR_FLTR()->admin->filter = new YSPL_WP_USR_FLTR_Admin_Filter;
	} );
}
