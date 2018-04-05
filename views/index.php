<div class="wrap card">
	<h2><?php esc_html_e( 'Database Reset', 'wordpress-site-reset' ); ?></h2>
	<p class="danger"><strong>Warning: This tool is designed to delete data. Once deleted, it is unrecoverable.</strong></p>

	<?php require 'partials/notice.php'; ?>

	<form method="post" id="db-reset-form">
		<?php require 'partials/select-tables.php'; ?>
		<?php require 'partials/security-code.php'; ?>
		<?php require 'partials/submit-button.php'; ?>
	</form>

</div>
