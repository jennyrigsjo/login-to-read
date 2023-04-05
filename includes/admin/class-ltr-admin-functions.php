<?php

/**
 * Admin functions class.
 *
 * Defines miscellaneous functions used in the admin area of the plugin.
 *
 * @since      1.0.0
 * @package    LTR
 * @subpackage LTR/includes/admin
 */
class LTR_Admin_Functions {


	/**
	 * Get all registered public post types.
	 *
	 * @return array List of names of all currently registered public post types, excluding the 'attachment' post type.
	 *
	 * @since	1.0.0
	 */
	public static function registered_post_types() {

		$args = array(
		   'public'   => true,
		);

		$registered_post_types = get_post_types( $args );

		if ( ( $index = array_search('attachment', $registered_post_types) ) !== false) {
			unset($registered_post_types[$index]); //do not include 'attachment' post type
		}

		return $registered_post_types;
	}


	/**
	 * Return markup to display a tooltip.
	 *
	 * @param string $text					Description that is displayed when user hovers over tooltip.
	 * @param string $tooltip (optional)	The symbol over which user hovers to display the text, default question mark ("?").
	 *
	 * @since	1.0.0
	 */
	public static function tooltip($text, $tooltip = "?") {

		$html = "";

		if ($tooltip === "?") {
			$html = "<span class='ltr_tooltip_default'>$tooltip<span class='ltr_tooltiptext'>$text</span></span>";
		} else {
			$html = "<span class='ltr_tooltip'>$tooltip<span class='ltr_tooltiptext'>$text</span></span>";
		}

		return $html;
	}

}
