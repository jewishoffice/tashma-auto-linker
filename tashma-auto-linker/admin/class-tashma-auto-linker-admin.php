<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://tashma.jewishoffice.co.il
 * @since      1.0.0
 * @package    Tashma_Auto_Linker
 * @subpackage Tashma_Auto_Linker/admin
 */

class Tashma_Auto_Linker_Admin {
	private $plugin_name;
	private $version;
	private $option_name;
	private $plugin_screen_hook_suffix;

	public function __construct($plugin_name, $version) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->option_name = 'tashma_auto_linker';
	}

	public function enqueue_styles() {
		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url(__FILE__) . 'css/tashma-auto-linker-admin.css',
			array(),
			$this->version,
			'all'
		);
	}

	public function enqueue_scripts() {
		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url(__FILE__) . 'js/tashma-auto-linker-admin.js',
			array('jquery'),
			$this->version,
			false
		);
	}

	public function register_setting() {
		add_settings_section(
			$this->option_name . '_general',
			esc_html__('General', 'tashma-auto-linker'),
			array($this, '_general_cb'),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_mode',
			esc_html__('Mode', 'tashma-auto-linker'),
			array($this, '_mode_cb'),
			$this->plugin_name,
			$this->option_name . '_general',
			array('label_for' => esc_attr($this->option_name . '_mode'))
		);

		register_setting(
			$this->plugin_name,
			$this->option_name . '_mode',
			array('sanitize_callback' => 'sanitize_text_field')
		);
	}

	public function _general_cb() {
		echo '<p>' . esc_html__('Please change the settings accordingly.', 'tashma-auto-linker') . '</p>';
	}

	public function _mode_cb() {
		$mode = get_option($this->option_name . '_mode');
		$input_name = esc_attr($this->option_name . '_mode');
		?>
		<fieldset>
			<label>
				<input type="radio" name="<?php echo esc_attr($input_name); ?>" id="<?php echo esc_attr($input_name); ?>" value="popup-hover" <?php checked($mode, 'popup-hover'); ?> />
				<?php echo esc_html__('popup-hover: when the user\'s mouse hovers over a reference, a popup with the textual content is displayed. A click on the reference goes to the content in Tashma.', 'tashma-auto-linker'); ?>
			</label>
			<br>
			<label>
				<input type="radio" name="<?php echo esc_attr($input_name); ?>" value="popup-click" <?php checked($mode, 'popup-click'); ?> />
				<?php echo esc_html__('popup-click: when the user clicks on a reference, a popup is displayed with the textual content. Within the popup is a link to Tashma.', 'tashma-auto-linker'); ?>
			</label>
			<br>
			<label>
				<input type="radio" name="<?php echo esc_attr($input_name); ?>" value="link" <?php checked($mode, 'link'); ?> />
				<?php echo esc_html__('link: The references are turned into links, which open in a new browser tab when clicked. There is no popup with textual content.', 'tashma-auto-linker'); ?>
			</label>
		</fieldset>
		<?php
	}

	public function add_options_page() {
		$this->plugin_screen_hook_suffix = add_options_page(
			esc_html__('Tashma Auto Linker Settings', 'tashma-auto-linker'),
			esc_html__('Tashma Auto Linker', 'tashma-auto-linker'),
			'manage_options',
			$this->plugin_name,
			array($this, 'display_options_page')
		);
	}

	public function display_options_page() {
		include_once plugin_dir_path(__FILE__) . 'partials/tashma-auto-linker-admin-display.php';
	}
}
