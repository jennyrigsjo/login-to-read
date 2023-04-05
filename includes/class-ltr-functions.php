<?php

/**
 * Functions class.
 *
 * Defines miscellaneous functions used throughout the plugin.
 *
 * @since      1.0.0
 * @package    LTR
 * @subpackage LTR/includes
 */
class LTR_Functions {


	/**
	 * Check if user must log in to view/read a post.
	 *
	 * @param mixed $post (WP_Post | Int) A post object or a post ID.
	 * @return bool True if the post requires login, else false.
	 */
	public static function post_requires_login( $post ) {

		$post_object = get_post($post);
		$post_taxonomies = get_object_taxonomies($post_object);

		$taxonomy = LTR_Options::get_taxonomy();
		$term = LTR_Options::get_term();

		$has_login_taxonomy = in_array($taxonomy, $post_taxonomies);
		$has_login_term = has_term( $term, $taxonomy, $post_object );

		return ($has_login_taxonomy && $has_login_term);
	}


	/**
	 * Return a login message.
	 *
	 * @param string $filter_hook_name (optional) The name of a filter hook that can be used to enable customization of the message.
	 *
	 * @since	1.0.0
	 */
	public static function login_message($filter_hook_name = '') {

		$default_message = esc_html__('Please log in to read this post.', 'login-to-read');
		$message = '';

		if ( !empty($filter_hook_name) ) {
			$custom_message = esc_html( apply_filters( $filter_hook_name, $default_message ), 'login-to-read' );
			$message = "<p>$custom_message</p>";
		} else {
			$message = "<p>$default_message</p>";
		}

		return $message;

	}

}
