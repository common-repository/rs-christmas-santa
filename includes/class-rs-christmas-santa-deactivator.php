<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://therssoftware.com
 * @since      1.0.0
 *
 * @package    Rs_Christmas_Santa
 * @subpackage Rs_Christmas_Santa/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Rs_Christmas_Santa
 * @subpackage Rs_Christmas_Santa/includes
 * @author     khorshed Alam <robelsust@gmail.com>
 */
class Rs_Christmas_Santa_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

}
