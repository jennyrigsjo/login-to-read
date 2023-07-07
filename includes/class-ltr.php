<?php

/**
 * Main plugin class.
 *
 * Defines internationalization, admin hooks and core hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the plugin's current
 * version and its main directory path.
 *
 * @since      1.0.0
 * @package    LTR
 * @subpackage LTR/includes
 */
class LTR {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      LTR_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;


	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;


	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;


	/**
	 * The main directory of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_dir    The path to the main directory of the plugin.
	 */
	protected $plugin_dir;


	/**
	 * Initialize the class and set its properties.
	 *
	 * Set the plugin name and the plugin version.
	 * Load the dependencies, define the locale and add hooks.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = LTR_NAME;
		$this->version = LTR_VERSION;
		$this->plugin_dir = LTR_PATH;

		$this->include_dependencies();
		$this->initiate_loader();
		$this->set_locale();
		$this->register_taxonomy();
		$this->register_settings();
		$this->add_core_functionality();
		$this->configure_ultimate_member();
	}


	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function include_dependencies() {

		/**
		* The class responsible for orchestrating the actions and filters of the
		* plugin.
		*/
		require_once $this->plugin_dir . 'includes/class-ltr-loader.php';


		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once $this->plugin_dir . 'includes/class-ltr-i18n.php';


		/**
		 * The class responsible for registering taxonomies and terms.
		 */
		require_once $this->plugin_dir . 'includes/class-ltr-taxonomy.php';


		/**
		 * The class responsible for defining the core functionality of the
		 * plugin.
		 */
		require_once $this->plugin_dir . 'includes/class-ltr-core.php';


		/**
		 * The class responsible for defining the plugin options.
		 */
		require_once $this->plugin_dir . 'includes/class-ltr-options.php';


		/**
		 * The class responsible for defining miscellaneous supporting functions.
		 */
		require_once $this->plugin_dir . 'includes/class-ltr-functions.php';


		if ( is_admin() ) {

			/**
			* The class responsible for defining all actions that occur in the admin area.
			*/
			require_once $this->plugin_dir . 'includes/admin/class-ltr-admin.php';

			/**
			* The class responsible for defining functions used in the admin area.
			*/
			require_once $this->plugin_dir . 'includes/admin/class-ltr-admin-functions.php';
		}


		if ( is_plugin_active('ultimate-member/ultimate-member.php') ) {

			/**
			 * The class responsible for making the plugin work with the Ultimate Member plugin.
			 */
			require_once $this->plugin_dir . 'includes/compatible/ultimate-member/class-ltr-um.php';
		}

	}


	/**
	 * Initiate the loader.
	 *
	 * Creates a new instance of the LTR_Loader class.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function initiate_loader() {

		$this->loader = new LTR_Loader();

	}


	/**
	 * Enable internationalization of this plugin.
	 *
	 * Uses the LTR_i18n class in order to set the text domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new LTR_i18n($this->get_plugin_name(), $this->get_plugin_directory_path());

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}


	/**
	 * Register the custom taxonomy and term used by this plugin.
	 *
	 * Uses the LTR_Taxonomy class to configure a custom taxonomy and term and register them with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_taxonomy() {

		$plugin_taxonomy = new LTR_Taxonomy();

		$this->loader->add_action( 'init', $plugin_taxonomy, 'register_taxonomy' );
		$this->loader->add_action( 'init', $plugin_taxonomy, 'register_term' );
	}


	/**
	 * Register plugin admin settings.
	 *
	 * Uses the LTR_Admin class to create the plugin's admin interface.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_settings() {

		if ( is_admin() ) {
			$plugin_admin = new LTR_Admin();
			$this->loader->add_action('admin_init', $plugin_admin, 'register_settings');
			$this->loader->add_filter("plugin_action_links", $plugin_admin, 'add_settings_shortcut', 10, 2);
			$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		}
	}


	/**
	 * Set up the core functionality of this plugin.
	 *
	 * Uses the LTR_Core class to control the visibility of posts and related content based on user login status.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function add_core_functionality() {

		$plugin_core = new LTR_Core();

		//$this->loader->add_action( 'pre_get_posts', $plugin_core, 'redirect_to_login' );
		$this->loader->add_action( 'template_redirect', $plugin_core, 'redirect_to_login' );
		$this->loader->add_filter( 'get_the_excerpt', $plugin_core, 'hide_post_excerpt', 999, 2 );
		$this->loader->add_filter( 'login_message', $plugin_core, 'login_message' );
	}


	/**
	 * Make this plugin work with the Ultimate Member (UM) plugin.
	 *
	 * Uses the LTR_UM class to make the plugin coompatible with the UM plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function configure_ultimate_member() {

		if ( is_plugin_active('ultimate-member/ultimate-member.php') ) {
			$plugin_um = new LTR_UM();
			$this->loader->add_action('um_before_login_fields', $plugin_um, 'login_message', 10, 1);
		}

	}


	/**
	 * Run the loader to execute all of the registered hooks.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}


	/**
	 * Get the reference to the class that maintains and orchestrates the hooks registered by the plugin.
	 *
	 * @since     1.0.0
	 * @return    LTR_Loader    The class that orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}


	/**
	 * Get the name of the plugin used to uniquely identify it. Same as the plugin's text domain.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin and plugin's text domain.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}


	/**
	 * Get the current version of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_plugin_version() {
		return $this->version;
	}


	/**
	 * Get the path to the plugin's main directory.
	 *
	 * @since     1.0.0
	 * @return    string    The path to the main directory, with a trailing slash.
	 */
	public function get_plugin_directory_path() {
		return $this->plugin_dir;
	}

}
