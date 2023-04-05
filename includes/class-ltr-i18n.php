<?php

/**
 * Internationalization class.
 *
 * Defines the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    LTR
 * @subpackage LTR/includes
 */
class LTR_i18n {

	/**
	 * The text domain of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $text_domain   The name of the text domain of this plugin.
	 */
	private $text_domain;


	/**
	 * The main directory of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_dir   The path to the main directory of this plugin.
	 */
	private $plugin_dir;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $text_domain   The name of the text domain of this plugin.
	 * @param      string    $plugin_dir   	The path to the main directory of this plugin.
	 */
	public function __construct( $text_domain, $plugin_dir ) {
		$this->text_domain = $text_domain;
		$this->plugin_dir = $plugin_dir;
	}


	/**
	 * Load the plugin text domain used for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain( $this->text_domain, false, $this->plugin_dir . 'languages/' );

	}



}
