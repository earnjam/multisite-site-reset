<p>1. <?php esc_html_e( 'Select the database tables you would like to reset', 'wordpress-site-reset' ); ?>:</p>

<div id="select-container">
	<a href='#' id="select-all"><?php esc_html_e( 'Select All', 'wordpress-site-reset' ); ?></a>
	<select id="wp-tables" multiple="multiple" name="db-reset-tables[]">
		<?php foreach ( $this->wp_tables as $key => $value ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_attr( $value ); ?></option>
		<?php endforeach ?>
	</select>
</div>

<p id="reactivate" style="display: none">
	<label for="db-reset-reactivate-theme-data">
		<input type="checkbox" name="db-reset-reactivate-theme-data" id="db-reset-reactivate-theme-data" checked="checked" value="true" />
		<?php esc_html_e( 'Reactivate current theme and plugins after reset?', 'wordpress-site-reset' ); ?>
	</label>
</p>
<p id="uploads" style="display: none">
	<label for="db-reset-delete-uploads">
		<input type="checkbox" name="db-reset-delete-uploads" id="db-reset-delete-uploads" checked="checked" value="true" />
		<?php esc_html_e( 'Delete uploaded files? If this option is not selected, the files will become orphaned and inaccessible through the WordPress admin.', 'wordpress-site-reset' ); ?>
	</label>
</p>

<hr>
