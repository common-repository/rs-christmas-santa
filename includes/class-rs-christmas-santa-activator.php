<?php

/**
 * Fired during plugin activation
 *
 * @link       https://therssoftware.com
 * @since      1.0.0
 *
 * @package    Rs_Christmas_Santa
 * @subpackage Rs_Christmas_Santa/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Rs_Christmas_Santa
 * @subpackage Rs_Christmas_Santa/includes
 * @author     Khorshed Alam <robelsust@gmail.com>
 */
class Rs_Christmas_Santa_Activator {

    /**
     * Plugin activation method
     *
     * This method is run during the activation of the plugin.
     * It sets up default options and any necessary functionality.
     *
     * @since    1.0.0
     */
    public static function activate() { 
        flush_rewrite_rules();

        // Default options
        $default = '';

        $options = array( 
            'rs_christmas_santa_pop_up_type' => 'popup_11.png',
            'rs_christmas_santa_pop_up_position' => 1,
            'rs_christmas_santa_awesome_santa' => 0,
            'rs_christmas_santa_music_item' => '0',
            'rs_christmas_santa_music_activation' => $default,
            'rs_christmas_santa_countdown_type' => 'count-down-1.png', 
        );

        foreach ($options as $option => $value) {
            if (!get_option($option)) {
                update_option($option, $value);
            }
        }
    }

    /**
     * Download MP3 files from a specified server
     *
     * This method downloads MP3 files and stores them in the plugin's audio directory.
     *
     * @since 1.0.0
     */
   
}
