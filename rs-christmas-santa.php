<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://therssoftware.com
 * @since             1.0.0
 * @package           Rs_Christmas_Santa
 *
 * @wordpress-plugin
 * Plugin Name:       Rs Christmas Santa
 * Plugin URI:        https://therssoftware.com
 * Description:       Celebrate the holiday season with our WordPress plugin that includes Santa Pop-Up, festive Music, a Countdown to Christmas, and a Christmas Schedule to keep your site merry and bright.
 * Version:           1.0.0
 * Author:            khorshed Alam
 * Author URI:        https://therssoftware.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rs-christmas-santa
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RS_CHRISTMAS_SANTA_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rs-christmas-santa-activator.php
 */
function rs_christmas_santa_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rs-christmas-santa-activator.php';
	Rs_Christmas_Santa_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rs-christmas-santa-deactivator.php
 */
function rs_christmas_santa_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rs-christmas-santa-deactivator.php';
	Rs_Christmas_Santa_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'rs_christmas_santa_activate' );
register_deactivation_hook( __FILE__, 'rs_christmas_santa_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rs-christmas-santa.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
add_action('wp_ajax_rs_christmas_santa_music_download', 'rs_christmas_santa_music_download_handler');

function rs_christmas_santa_music_download_handler() {
    // Sanitize and verify nonce for security
    if (!isset($_GET['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['nonce'])), 'rs_christmas_santa_music_download_nonce')) {
        wp_send_json_error('Invalid nonce');
        return;
    }

    // Get the upload directory path
    $upload_dir = wp_upload_dir();
    $path = trailingslashit($upload_dir['basedir']) . 'rs-christmas-santa';
    $mp3_files = ['deck-the-halls.mp3', 'jingle-bells.mp3', 'silent-night.mp3', 'we-wish-you.mp3'];
    
    // Ensure the directory exists in uploads
    if (!is_dir($path)) {
        wp_mkdir_p($path); // Create the directory if it doesn't exist
    }

    global $wp_filesystem;

    // Initialize WP_Filesystem
    if (!function_exists('WP_Filesystem')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }
    WP_Filesystem();

    if (!$wp_filesystem) {
        wp_send_json_error('Filesystem API could not be initialized.');
        return;
    }

    foreach ($mp3_files as $mp3_file) {
        $url = "https://aptest.therssoftware.com/audio/" . $mp3_file;
        $file_path = $path . '/' . $mp3_file; // Save in the uploads directory

        // Download the file using wp_remote_get
        $response = wp_remote_get($url, array('timeout' => 600));

        // Check for errors
        if (is_wp_error($response)) {
            $error_msg = $response->get_error_message();
            custom_log("Failed to download $mp3_file: $error_msg");
        } else {
            $file_contents = wp_remote_retrieve_body($response);
            if (!empty($file_contents)) {
                $wp_filesystem->put_contents($file_path, $file_contents, FS_CHMOD_FILE);
            } else {
                custom_log("Failed to retrieve content for $mp3_file");
            }
        }
    }

    wp_send_json_success('Download completed');
}

 

function rs_christmas_santa_runplugin() {

	$plugin = new Rs_Christmas_Santa();
	$plugin->run();

}
rs_christmas_santa_runplugin();
