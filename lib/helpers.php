<?php

/**
 * Check for command line constant
 */
function is_command_line() {
	return ( defined( 'WP_CLI' ) && WP_CLI );
}

/**
 * Activation process
 * @return bool Should we proceed with plugin activation?
 */
function db_reset_activate() {
	$status = db_reset_activation_checks();

	if ( is_string( $status ) ) {
		db_reset_cancel_activation( $status );
	}
}

/**
 * Check for minimum plugin requirements
 * @return string|bool Error message if fails or boolean true if passes
 */
function db_reset_activation_checks() {
	if ( ! function_exists( 'spl_autoload_register' ) &&
				version_compare( phpversion(), '5.3', '<' ) ) {
		return __( 'The WordPress Database Reset plugin requires at least PHP 5.3!', 'wordpress-site-reset' );
	}

	if ( version_compare( get_bloginfo( 'version' ), '3.0', '<' ) ) {
		return __( 'The WordPress Database Reset plugin requires at least WordPress 3.0!', 'wordpress-site-reset' );
	}

	return true;
}

/**
 * Cancel activation and kill process
 * @param  string $message Error message
 * @return void
 */
function db_reset_cancel_activation( $message ) {
	deactivate_plugins( __FILE__ );
	wp_die( esc_html( $message ) );
}


/**
 * Recursively delete a directory and files
 * @param  [type] $dir [description]
 * @return [type]      [description]
 */
function db_reset_rmdir( $dir ) {
	if ( is_dir( $dir ) ) {
		$objects = scandir( $dir );
		foreach ( $objects as $object ) {
			if ( '.' !== $object && '..' !== $object ) {
				if ( is_dir( $dir . '/' . $object ) ) {
					db_reset_rmdir( $dir . '/' . $object );
				} else {
					unlink( $dir . '/' . $object );
				}
			}
		}
		rmdir( $dir );
	}
}
