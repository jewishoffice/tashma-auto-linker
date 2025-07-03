<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://tashma.jewishoffice.co.il
 * @since      1.0.0
 *
 * @package    Tashma_Auto_Linker
 * @subpackage Tashma_Auto_Linker/admin/partials
 */
?>

<div class="wrap">
	<h2><?php echo esc_html(get_admin_page_title()); ?></h2>
	<form action="options.php" method="post">
		<?php
		settings_fields($this->plugin_name);
		do_settings_sections($this->plugin_name);

		//	            var_dump(get_option( $this->option_name . '_mode' ));

		submit_button();
		?>
	</form>
</div>