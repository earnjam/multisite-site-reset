<?php
/*
Plugin Name: Multisite Site Reset
Plugin URI: https://github.com/earnjam/multisite-site-reset
Description: A plugin that allows a network administrator to reset a subsite of a multisite network back to its original state. Fork of WordPress Database Reset by Chris Berthe (https://github.com/chrisberthe/wordpress-site-reset)
Version: 1.0
Author: William Earnhardt
Author URI: https://github.com/earnjam
License: GNU General Public License
Text-domain: wp-reset
*/

define( 'DB_RESET_VERSION', '3.0.2' );
define( 'DB_RESET_PATH', dirname( __FILE__ ) );
define( 'DB_RESET_NAME', basename( DB_RESET_PATH ) );
define( 'AUTOLOADER', DB_RESET_PATH . '/lib/class-plugin-autoloader.php' );

require_once DB_RESET_PATH . '/lib/helpers.php';

register_activation_hook( __FILE__, 'db_reset_activate' );

load_plugin_textdomain( 'wordpress-site-reset', false, DB_RESET_NAME . '/languages/' );

if ( file_exists( AUTOLOADER ) ) {
	require_once AUTOLOADER;
	new Plugin_Autoloader( DB_RESET_PATH );

	add_action(
		'wp_loaded',
		array( new DB_Reset_Manager( DB_RESET_VERSION ), 'run' )
	);
}

if ( is_command_line() ) {
	require_once __DIR__ . '/class-db-reset-command.php';
}
