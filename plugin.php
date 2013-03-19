<?php

/*
Plugin Name: HM Gallery
Plugin URI: https://github.com/humanmade/HM-Gallery
Description: Web/Print Gallery plugin
Author: Human Made Limited
Version: 1.1.1
Author URI: http://www.humanmade.co.uk/
*/


define( 'HMG_PLUGIN_URL', WP_PLUGIN_URL . DIRECTORY_SEPARATOR . end( explode( '/', dirname( __FILE__ )  ) ) );
define( 'HMG_URL', str_replace( ABSPATH, trailingslashit(get_bloginfo('wpurl')), dirname( __FILE__ ) ) . '/' );
define( 'HMG_PATH', dirname( __FILE__ ) );

//check comaptibility before anything
hmg_check_plugin_compatibility();

function hmg_check_plugin_compatibility() {

	// check compatibility
	global $wp_version;
	$php_version = phpversion();

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );  
	
	if ( ! defined( 'HM_CORE_SLUG' ) ) {
		die( 'Requires HM Core' );
	} elseif ( version_compare( $wp_version, '3.0', '<') ) {
		deactivate_plugins(HMG_PATH . '/plugin.php'); 
		die('HM Gallery 0.9.7+ requires WordPress 3.0+, please download HM Gallery 0.9.6 <a href="http://downloads.wordpress.org/plugin/hmg-gallery.0.9.6.zip">here</a> for older versions of WordPress. ');
  	} elseif ( version_compare( $php_version, '5', '<') ) {
  		deactivate_plugins(HMG_PATH . '/plugin.php'); 
		die('HM Gallery requires PHP 5+');
  	}
  	
}

//Template rewrite
include_once('hmg.functions.php');
include_once('hmg.admin.php');
include_once('hmg.hooks.php');
