<?php

/**
 * Admin class.
 *
 * Defines the admin-specific functionality of the plugin.
 *
 * Defines methods responsible for setting up and displaying the administrative interface of the plugin, including methods to register settings and setting callbacks.
 *
 * @since      1.0.0
 * @package    LTR
 * @subpackage LTR/includes/admin
 */
class LTR_Admin {

	/**
	 * Initialize the class.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

	}


	/**
	 * Register plugin settings.
	 *
	 * @uses LTR_Admin_Functions::tooltip()
	 *
	 * @since	1.0.0
	 */
	public function register_settings() {

		if ( !current_user_can('manage_options') ) {
			return;
		}

		$option_group = 'reading';
		$option1_name = 'ltr_post_types';
		$option2_name = 'ltr_show_admin_column';

		$option1_tooltip = LTR_Admin_Functions::tooltip("Post types for which login requirement will be enabled, but not enforced. In order to apply login requirement to a particular post, check the 'Require user login' option in the 'Log In To Read' metabox in the editor sidebar or quick edit panel.");
		$option2_tooltip = LTR_Admin_Functions::tooltip("Hide or show the 'Log In To Read' column in the admin posts list.");

		$settings_page = 'reading';
		$section_name = 'ltr-settings';

		register_setting(
			$option_group,
			$option1_name,
			array( $this, 'validate_post_types' ),
		);

		register_setting(
			$option_group,
			$option2_name,
			array( $this, 'validate_admin_column_option' ),
		);

	    add_settings_section(
	        $section_name,
	        esc_html__('Log In To Read', 'login-to-read'),
			array( $this, 'settings_description_html' ),
	        $settings_page,
	    );

	    add_settings_field(
			$option1_name,
			esc_html__("Enable login requirement for the following post types:", 'login-to-read') . ' ' . $option1_tooltip,
			array( $this, 'select_post_types_html' ),
	        $settings_page,
	        $section_name,
	    );

		add_settings_field(
			$option2_name,
			esc_html__("Show 'Log In To Read' admin column:", 'login-to-read') . ' ' . $option2_tooltip,
			array( $this, 'show_admin_column_html' ),
			$settings_page,
			$section_name,
		);

	}


	/**
	 * Validate the selected values for option 'ltr_post_types'.
	 *
	 * @uses LTR_Admin_Functions::registered_post_types()
	 *
	 * @since	1.0.0
	 */
	private function validate_post_types( $post_types ) {

		$registered_post_types = LTR_Admin_Functions::registered_post_types();

		foreach ($post_types as $name) {

			if ( !in_array($name, $registered_post_types) ) {
				$post_types = null;
				break;
			}

		}

		return $post_types;
	}


	/**
	 * Validate the selected value for option 'ltr_show_admin_column'.
	 *
	 * @uses LTR_Options::admin_column_options()
	 *
	 * @since	1.0.0
	 */
	private function validate_admin_column_option( $option ) {

		$valid_options = array_keys( LTR_Options::admin_column_options() );

		if ( !in_array($option, $valid_options) ) {
			$option = null;
		}

		return $option;
	}


	/**
	 * Print settings description markup.
	 *
	 * @since	1.0.0
	 */
	public function settings_description_html() {

		$description = esc_html__('Customize settings for the "Log in To Read" plugin', 'login-to-read');
		$anchor_link_id = 'ltr-settings'; // Section name. Used to link to settings from shortcut on plugins page.
		echo "<p id='$anchor_link_id'>$description.</p>";

	}


	/**
	 * Print markup for 'ltr_post_types' setting.
	 *
	 * @uses LTR_Admin_Functions::registered_post_types()
	 * @uses LTR_Options::selected_post_types()
	 *
	 * @since	1.0.0
	 */
	public function select_post_types_html() {

		$registered_post_types = LTR_Admin_Functions::registered_post_types();
		$selected_post_types = LTR_Options::selected_post_types();

		foreach ($registered_post_types as $post_type) {
			$checked = checked( in_array($post_type, $selected_post_types), true, false );
			echo "<input type='checkbox' name='ltr_post_types[]' value='$post_type' $checked >$post_type<br>";
		}

	}


	/**
	 * Print markup for 'ltr_show_admin_column' setting.
	 *
	 * @uses LTR_Options::admin_column_options()
	 * @uses LTR_Options::selected_admin_column_option()
	 *
	 * @since	1.0.0
	 */
	public function show_admin_column_html() {

		$options = LTR_Options::admin_column_options();
		$selected_option = LTR_Options::selected_admin_column_option();

		foreach ( $options as $value => $label ) {
			$checked = checked( $selected_option === $value, true, false );
			$input = "<input type='radio' name='ltr_show_admin_column' value='$value' $checked>";
			echo "<label>$input<span> $label</span></label><br>";
		}

	}


	/**
	* Add link/shortcut to plugin settings page.
	*
	* @since	1.0.0
	*/
	public function add_settings_shortcut( $actions, $plugin_file ) {

		if ( $plugin_file !== 'login-to-read/login-to-read.php' ) {
			return $actions;
		}

		$anchor_link_id = 'ltr-settings';
		$href = admin_url( "options-reading.php#$anchor_link_id" );
		$text = esc_html__('Settings', 'login-to-read');

		$link = "<a href='$href'>$text</a>";
		$actions[] = $link;

		return $actions;
	}


	/**
	 * Include admin-specific CSS.
	 *
	 * @since	1.0.0
	 */
	public function enqueue_styles( $hook_suffix ) {

		if ( 'options-reading.php' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style( 'ltr_admin_css', plugin_dir_url( __FILE__ ).'css/ltr-admin.css' );
	}

}
