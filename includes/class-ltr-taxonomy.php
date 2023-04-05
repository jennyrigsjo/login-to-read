<?php

/**
 * Taxonomy class.
 *
 * Defines the custom taxonomy and term used by the plugin.
 *
 * Defines methods to register the custom taxonomy and its associated term.
 *
 * @since      1.0.0
 * @package    LTR
 * @subpackage LTR/includes
 */
class LTR_Taxonomy {


	/**
	 * Initialize the class.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

	}


	/**
	 * Create the taxonomy 'ltr_visibility'.
	 *
	 * @since	1.0.0
	 */
	public function register_taxonomy() {

		$labels = [
	    	"name" => esc_html__( "Log In To Read", "login-to-read" ), // column name on edit.php screen
	    	"singular_name" => esc_html__( "Log In To Read", "login-to-read" ),
	    	"menu_name" => esc_html__( "Log In To Read", "login-to-read" ), // menu name in editor sidebar
	    	"all_items" => esc_html__( "All Log In To Read options", "login-to-read" ),
	    	"edit_item" => esc_html__( "Edit Log In To Read option", "login-to-read" ),
	    	"view_item" => esc_html__( "View Log In To Read option", "login-to-read" ),
	    	"update_item" => esc_html__( "Update Log In To Read option", "login-to-read" ),
	    	"add_new_item" => esc_html__( "Add new Log In To Read option", "login-to-read" ),
	    	"new_item_name" => esc_html__( "New Log In To Read option name", "login-to-read" ),
	    	"parent_item" => esc_html__( "Parent Log In To Read option", "login-to-read" ),
	    	"parent_item_colon" => esc_html__( "Parent Log In To Read option:", "login-to-read" ),
	    	"search_items" => esc_html__( "Search Log In To Read options", "login-to-read" ),
	    	"popular_items" => esc_html__( "Popular Log In To Read options", "login-to-read" ),
	    	"separate_items_with_commas" => esc_html__( "Separate Log In To Read options with commas", "login-to-read" ),
	    	"add_or_remove_items" => esc_html__( "Add or remove Log In To Read options", "login-to-read" ),
	    	"choose_from_most_used" => esc_html__( "Choose among most used Log In To Read options", "login-to-read" ),
	    	"not_found" => esc_html__( "No Log In To Read options found", "login-to-read" ),
	    	"no_terms" => esc_html__( "No Log In To Read options", "login-to-read" ),
	    	"items_list_navigation" => esc_html__( "Navigate list of Log In To Read options", "login-to-read" ),
	    	"items_list" => esc_html__( "List of Log In To Read options", "login-to-read" ),
	    ];

	    $args = [
	    	"label" => esc_html__( "Log In To Read", "login-to-read" ),
	    	"labels" => $labels,
	        "description" => esc_html__( "Log In To Read options for post types", "login-to-read" ),
	    	"public" => false, // not intended for public use
	    	"publicly_queryable" => false, // not publicly queryable (archives etc.)
	    	"hierarchical" => true, // enable "checkbox layout" of terms in editor sidebar
	    	"show_ui" => true, // needed for taxonomy to show up in editor sidebar
	        "show_in_menu" => false, // do not show in admin menu
	    	"show_in_nav_menus" => false, // do not enable for selection in nav menus
	    	"show_admin_column" => LTR_Options::selected_admin_column_option() === 'enable' ? true : false, // show on associated post type screens
	    	"show_in_rest" => true, // show in editor sidebar
	    	"show_in_quick_edit" => true, // show in quick/bulk edit panel
	        "capabilities" => array( // disable editing and deleting terms for all user roles
	            'manage_terms' => '',
	            'edit_terms' => '',
	            'delete_terms' => '',
	            'assign_terms' => 'edit_posts',
	        ),
	    ];

		$taxonomy_name = LTR_Options::get_taxonomy();
		$selected_post_types = LTR_Options::selected_post_types();

		register_taxonomy( $taxonomy_name, $selected_post_types, $args );

		foreach( $selected_post_types as $post_type ) {
			register_taxonomy_for_object_type( $taxonomy_name, $post_type );
		}

	}


	/**
	* Create the term 'login' and add it to the taxonomy 'ltr_visibility'.
	*/
	public function register_term() {

	    $term_name = esc_html__('Require user login', 'login-to-read');
	    $term_slug = LTR_Options::get_term();
		$taxonomy_name = LTR_Options::get_taxonomy();

	    $args = array(
	        'alias_of' => '',
	        'description' => esc_html__('Please log in to view this post', 'login-to-read'),
	        'parent' => 0,
	        'slug' => $term_slug,
	    );

	    if ( null === term_exists($term_slug, $taxonomy_name) ) {
	        wp_insert_term( $term_name, $taxonomy_name, $args );
	    }
	}

}
