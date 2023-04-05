<?php

/**
 * Uninstall class.
 *
 * Defines code to run during plugin removal/uninstallation.
 *
 * Defines methods to remove all data created by the plugin, including custom taxonomies and terms.
 *
 * @since      1.0.0
 * @package    LTR/includes
 */
class LTR_Uninstaller {

	public static function uninstall() {

		if ( !current_user_can('install_plugins') ) {
			return;
		}

		self::delete_options();
		self::delete_taxonomy();

		//temporary bug fix: delete unknown option 'ltr_visibility_children' that is added to database on plugin activation
		delete_option('ltr_visibility_children');

	}

	private static function delete_options() {

		$option_names = array_keys( LTR_Options::default_options() );

		foreach ($option_names as $name) {
			delete_option($name);
		}
	}

	private static function delete_taxonomy() {

		global $wpdb;
		$taxonomy_name = LTR_Options::get_taxonomy();

		# Delete the relationships between posts and terms.
		#
		# The inner query collects the IDs of the relationships, the outer query deletes them.
		$wpdb->query("DELETE FROM {$wpdb->term_relationships} WHERE term_taxonomy_id IN (SELECT term_taxonomy_id FROM {$wpdb->term_taxonomy} WHERE taxonomy = '{$taxonomy_name}')");

		# Delete all the terms associated with the taxonomy.
		#
		# The inner query collects the IDs of the terms, the outer query deletes them.
		$wpdb->query("DELETE FROM {$wpdb->terms} WHERE term_id IN (SELECT term_id FROM {$wpdb->term_taxonomy} WHERE taxonomy = '{$taxonomy_name}')");

		# Delete the taxonomy itself.
		$wpdb->query("DELETE FROM {$wpdb->term_taxonomy} WHERE taxonomy = '{$taxonomy_name}'");

	}

}
