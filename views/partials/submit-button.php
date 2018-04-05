<p>
	<input type="submit" name="db-reset-submit" value="<?php esc_attr_e( 'Reset Tables', 'wordpress-site-reset' ); ?>" id="db-reset-submit" class="button-primary" disabled />
	<img src="<?php echo esc_url( plugins_url( 'assets/images/spinner.gif', dirname( __DIR__ ) ) ); ?>" alt="loader" id="loader" style="display: none" />
</p>
