<p>
	2. <?php esc_html_e( 'Enter the security code into the text box', 'wordpress-site-reset' ); ?>:
	<span id="security-code"><?php echo esc_html( $this->code ); ?></span>
</p>

<input type="hidden" name="db-reset-code" value="<?php echo esc_html( $this->code ); ?>" />
<input type="text" name="db-reset-code-confirm" id="db-reset-code-confirm" value="" placeholder="*****" />
