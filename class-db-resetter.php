<?php

if ( ! class_exists( 'DB_Resetter' ) ) :

	class DB_Resetter {

		private $backup;
		private $saved_options;
		private $selected;
		private $reactivate;
		private $upload_delete;
		private $wp_tables;

		public function __construct() {
			$this->set_wp_tables();
		}

		public function reset( array $tables ) {
			// Needed for the populate_options() call below
			require_once ABSPATH . '/wp-admin/includes/upgrade.php';
			$this->validate_selected( $tables );
			$this->set_backup();
			$this->truncate_wp_tables();
			populate_options();
			$this->assert_upload_delete();
			$this->restore_saved_data();
		}

		private function validate_selected( array $tables ) {
			if ( ! empty( $tables ) && is_array( $tables ) ) {
				$this->selected = array_flip( $tables );
				return;
			}

			throw new Exception( __( 'You did not select any database tables', 'wordpress-site-reset' ) );
		}

		private function set_backup() {
			if ( in_array( $wpdb->options, $this->selected, true ) ) {
				$this->saved_options = array();
				$this->set_blog_data();
				if ( $this->reactivate ) {
					$this->set_theme_plugin_data();
				}
			}
		}

		/**
		 * Store our values that have to be kept to make the site work
		 */
		private function set_blog_data() {
			global $wpdb;
			$this->saved_options = array_merge( array(
				'blogname'    => get_option( 'blogname' ),
				'blog_public' => get_option( 'blog_public' ),
				'admin_email' => get_option( 'admin_email' ),
				'siteurl'     => get_option( 'siteurl' ),
				'home'        => get_option( 'home' ),
				'db_version'  => get_option( 'db_version' ),
			), $this->saved_options );
		}

		private function set_theme_plugin_data() {
			$this->saved_options = array_merge( array(
				'active_plugins' => get_option( 'active_plugins' ),
				'current_theme'  => get_option( 'current_theme' ),
				'stylesheet'     => get_option( 'stylesheet' ),
				'template'       => get_option( 'template' ),
			), $this->saved_options );
		}

		private function truncate_wp_tables() {
			global $wpdb;

			foreach ( $this->selected as $table => $id ) {
				// Confirm again that table belongs to this site
				if ( preg_match( '/' . $wpdb->prefix . '.*/', $table ) ) {
					$sql    = "TRUNCATE TABLE $table";
					$result = $wpdb->query( "TRUNCATE TABLE {$table}" );
				}
			}
		}

		/**
		 * [restore_theme_plugin_data description]
		 * @return [type] [description]
		 * @todo  loop through stored values and set them programmatically
		 */
		private function restore_saved_data() {
			global $wpdb;
			foreach ( $this->saved_options as $key => $value ) {
				$sql = "UPDATE " . $wpdb->options . " SET option_value='" . maybe_serialize( $value ) ."' WHERE option_name='$key'";
				$result = $wpdb->query( $sql );
			}
		}

		public function set_reactivate( $with_theme_plugin_data ) {
			$this->reactivate = $with_theme_plugin_data;
		}

		private function should_restore_theme_plugin_data() {
			return ( true == $this->reactivate );
		}

		public function set_upload_delete( $upload_delete ) {
			$this->upload_delete = $upload_delete;
		}

		private function should_delete_uploads() {
			return ( true == $this->upload_delete );
		}

		private function assert_upload_delete() {
			if ( $this->should_delete_uploads() ) {
				$this->delete_uploads();
			}
		}

		private function delete_uploads() {
			$uploads = wp_upload_dir();
			db_reset_rmdir( $uploads['basedir'] );
		}

		/**
		 * Finds and stores the tables specific to this site
		 */
		private function set_wp_tables() {
			global $wpdb;
			$tables = $wpdb->get_results( 'SHOW TABLES LIKE "' . $wpdb->prefix . '%"' , ARRAY_N );
			foreach ( $tables as $table ) {
				$table_list[] = $table[0];
			}
			$this->wp_tables = $table_list;
		}

		/**
		 * Returns the list of tables specific to this site
		 * @return array List of tables specific to this site
		 */
		public function get_wp_tables() {
			return $this->wp_tables;
		}

	}

endif;
