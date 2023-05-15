<?php
/**
 * Plugin Name: WP Users Filter
 * Plugin URL: 
 * Description: This plugin helps the admin to filter the users with various ranges of filters.
 * Version: 1.0
 * Author: Hardik Lakkad/Hardik Patel
 * Author URI: https://in.linkedin.com/in/hardik-lakkad-097b12147
 * Developer: Hardik Patel
 * Developer E-Mail: hardiklakkad2@gmail.com
 * Text Domain: wp-users-filter
 * Domain Path: /languages
 *
 * Copyright: © 2009-2019 Plugin author name.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Basic plugin definitions
 *
 * @package WP Users filter
 * @since 1.0
 *  YSPL_WP_USR_FLTR will be prefix for everyfile, GLOBAL VARIABLE, Class
 */

if ( !defined( 'YSPL_WP_USR_FLTR_VERSION' ) ) {
	define( 'YSPL_WP_USR_FLTR_VERSION', '1.0' ); // Version of plugin
}

if ( !defined( 'YSPL_WP_USR_FLTR_FILE' ) ) {
	define( 'YSPL_WP_USR_FLTR_FILE', __FILE__ ); // Plugin File
}

if ( !defined( 'YSPL_WP_USR_FLTR_DIR' ) ) {
	define( 'YSPL_WP_USR_FLTR_DIR', dirname( __FILE__ ) ); // Plugin dir
}

if ( !defined( 'YSPL_WP_USR_FLTR_URL' ) ) {
	define( 'YSPL_WP_USR_FLTR_URL', plugin_dir_url( __FILE__ ) ); // Plugin url
}

if ( !defined( 'YSPL_WP_USR_FLTR_PLUGIN_BASENAME' ) ) {
	define( 'YSPL_WP_USR_FLTR_PLUGIN_BASENAME', plugin_basename( __FILE__ ) ); // Plugin base name
}

if ( !defined( 'YSPL_WP_USR_FLTR_META_PREFIX' ) ) {
	define( 'YSPL_WP_USR_FLTR_META_PREFIX', 'yspl_wp_usr_fltr_' ); // Plugin metabox prefix
}

if ( !defined( 'YSPL_WP_USR_FLTR_PREFIX' ) ) {
	define( 'YSPL_WP_USR_FLTR_PREFIX', 'yspl_wp_usr_fltr' ); // Plugin prefix
}

/**
 * Initialize the main class
 */

global $pagenow;
if ( is_admin() && $pagenow == "users.php" ) {
	require_once( YSPL_WP_USR_FLTR_DIR . '/inc/admin/class.' . YSPL_WP_USR_FLTR_PREFIX . '.admin.php' );
	require_once( YSPL_WP_USR_FLTR_DIR . '/inc/admin/class.' . YSPL_WP_USR_FLTR_PREFIX . '.admin.action.php' );
	require_once( YSPL_WP_USR_FLTR_DIR . '/inc/admin/class.' . YSPL_WP_USR_FLTR_PREFIX . '.admin.filter.php' );
	require_once( YSPL_WP_USR_FLTR_DIR . '/inc/lib/class.' . YSPL_WP_USR_FLTR_PREFIX . '.lib.php' );
	//Initialize all the things.
	require_once( YSPL_WP_USR_FLTR_DIR . '/inc/class.' . YSPL_WP_USR_FLTR_PREFIX . '.php' );
}
