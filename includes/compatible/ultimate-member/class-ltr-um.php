<?php

/**
 * Ultimate Member configuration class.
 *
 * Defines functionality to make the plugin work with the Ultimate Member plugin.
 *
 *
 * @since      1.0.0
 * @package    LTR
 * @subpackage LTR/includes/compatible/ultimate-member
 */
class LTR_UM {

	/**
	 * Initialize the class.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

	}


	/**
	* Display a message asking the user to log in.
	*
	*/
	public function login_message( $args ) {

		$login_required = $_GET['login_required'] ?? 'false';

		if ( $login_required === 'true' ) {
			$filter_hook_name = 'ltr_um_login_message';
			$message = LTR_Functions::login_message($filter_hook_name);
			echo $message;
		}

	}


}
