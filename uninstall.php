<?php

/**
 * Fires when the plugin is uninstalled.
 *
 * @since      1.0.0
 * @package    LTR
 */


// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

require plugin_dir_path( __FILE__ ) . 'includes/class-ltr-options.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-ltr-uninstaller.php';

LTR_Uninstaller::uninstall();
