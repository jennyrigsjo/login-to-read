<?php

/**
 * Options class.
 *
 * Defines default options and settings for the plugin.
 *
 * Defines default values for the options and settings used throughout the plugin, as well as methods to access those values.
 *
 * @since      1.0.0
 * @package    LTR
 * @subpackage LTR/includes
 */
class LTR_Options {

	/**
	 * The taxonomy used by this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $taxonomy    The name of the taxonomy.
	 */
	private static $taxonomy = 'ltr_visibility';


	/**
	 * The term used by this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $term    The name of the term.
	 */
	private static $term = 'login';


	/**
	 * The default post types used by this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $default_post_types    The names of the post types.
	 */
	private static $default_post_types =  array('post', 'page');


	/**
	 * Get the name of the custom taxonomy used by this plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the taxonomy.
	 */
	public static function get_taxonomy() {
		return self::$taxonomy;
	}


	/**
	 * Get the name of the custom term used by this plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the term.
	 */
	public static function get_term() {
		return self::$term;
	}


	/**
	 * Get the plugin's default selected post types.
	 *
	 * @return array List of post type names.
	 *
	 * @since	1.0.0
	 */
	public static function default_post_types() {
		return self::$default_post_types;
	}


	/**
	 * Get the currently selected post types.
	 *
	 * @return array List of post type names currently selected by the user.
	 *
	 * @since	1.0.0
	 */
	public static function selected_post_types() {

		$selected_post_types = get_option( 'ltr_post_types', self::default_post_types() );

		if ( empty($selected_post_types) ) {
			return self::default_post_types(); //return default post types if get_option returns empty string
		} elseif ( is_string($selected_post_types) ) {
			return array($selected_post_types); //return array if get_option returns a single string
		} else {
			return $selected_post_types;
		}

	}


	/**
	 * Get the plugin's default options.
	 *
	 * @return array List of available options and their default values.
	 *
	 * @since	1.0.0
	 */
	public static function default_options() {
		return array(
			'ltr_post_types' => self::default_post_types(),
			'ltr_show_admin_column' => 'enable',
		);
	}


	/**
	 * Get the valid values for the 'ltr_show_admin_column' option.
	 *
	 * @return array List of option values and their corresponding labels.
	 *
	 * @since	1.0.0
	 */
	public static function admin_column_options() {

		$options = array(
			'enable'  => esc_html__('Show admin column', 'login-to-read'),
			'disable' => esc_html__('Do not show admin column', 'login-to-read'),
		);

		return $options;
	}


	/**
	 * Get the current value of the 'ltr_show_admin_column' option.
	 *
	 * @return string The current value selected by the user, default 'enable' if no value has been selected.
	 *
	 * @since	1.0.0
	 */
	public static function selected_admin_column_option() {

		$default_selected = 'enable';
		$selected_option = get_option( 'ltr_show_admin_column', $default_selected );

		if ( empty($selected_option) ) {
			return $default_selected;
		} else {
			return $selected_option;
		}
	}

}
