<?php

/**
 * Core class.
 *
 * Defines the plugin's core functionality.
 *
 * Defines methods to control access to post content based on current user's login status.
 *
 * @since      1.0.0
 * @package    LTR
 * @subpackage LTR/includes
 */
class LTR_Core {

	/**
	 * Initialize the class.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

	}


	/**
	* Redirect to login page if a non-authenticated user is trying to view a restricted post.
	*
	* @uses LTR_Functions::post_requires_login()
	*/
	public function redirect_to_login() {

		$selected_post_types = LTR_Options::selected_post_types();

	    if ( is_singular($selected_post_types) && !is_user_logged_in() ) {

			$current_post_id = get_the_id();
			$post_requires_login = LTR_Functions::post_requires_login( $current_post_id );

			if ( $post_requires_login ) {

				$redirect_after_login = get_permalink( $current_post_id );
				$login_url = wp_login_url( $redirect_after_login );
				$login_required = add_query_arg('login_required', 'true', $login_url);

				wp_safe_redirect( $login_required );
				exit;
			}

	    }

	}


	/**
	* Replace post excerpt with a login message if a non-authenticated user is trying to view a restricted post.
	*
	* @uses LTR_Functions::post_requires_login()
	*/
	public function hide_post_excerpt( $post_excerpt, $post ) {

		$post_requires_login = LTR_Functions::post_requires_login( $post );

		if ( $post_requires_login && !is_user_logged_in() ) {
			$default_message = esc_html__('Log in to read this post.', 'login-to-read');
			$custom_message = esc_html( apply_filters( 'ltr_post_excerpt', $default_message ) );
			$post_excerpt = $custom_message;
		}

		return $post_excerpt;
	}


	/**
	* Display a message on the login screen if login is required.
	*
	* @uses LTR_Functions::login_message()
	*/
	public function login_message ( $message ) {

		$login_required = $_GET['login_required'] ?? 'false';

		if ( $login_required === 'true' ) {
			$filter_hook_name = 'ltr_login_message';
			$message = LTR_Functions::login_message($filter_hook_name);
		}

		return $message;
	}


}
