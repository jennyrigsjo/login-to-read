<?php

/*
Plugin Name:		Log In To Read
Description:		Restrict access to selected posts to logged-in users.
Author:				Jenny Rigsjö
Author URI:			https://jennyrigsjo.se
Tags:				post, visibility, access, restrict, login
Version:			1.0.1
Requires PHP:		7.4
Requires at least:	6.2
Tested up to:		6.2
Text Domain:		login-to-read
Domain Path:		/languages
License:			GPL v2 or later
License URI:		https://www.gnu.org/licenses/gpl-2.0.txt
*/


// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Plugin name.
 */
define( 'LTR_NAME', basename( __FILE__ ) );


/**
 * Current plugin version.
 */
define( 'LTR_VERSION', '1.0.1' );


/**
 * Plugin file path.
 */
define( 'LTR_PATH', plugin_dir_path( __FILE__ ) );


require LTR_PATH . 'includes/class-ltr.php';


function run_ltr() {

	$plugin = new LTR();
	$plugin->run();

}

run_ltr();
