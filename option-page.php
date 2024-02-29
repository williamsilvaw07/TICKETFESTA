<?php
/**
 * this class calculate and show yearly, monthly and weekly fees for site fees
 */

class TicketSiteFees {
	private $year_site_fees_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'year_site_fees_add_plugin_page' ) );
		// add_action( 'admin_init', array( $this, 'year_site_fees_page_init' ) );
	}

	public function year_site_fees_add_plugin_page() {
		add_management_page(
			'Site Fees', // page_title
			'Site Fees', // menu_title
			'manage_options', // capability
			'site-fees', // menu_slug
			array( $this, 'site_fees_create_admin_page' ) // function
		);
	}

	public function site_fees_create_admin_page() {
        ?>
		<div class="wrap">
			<h2> Site Fees</h2>
			<p></p>
			<?php settings_errors(); ?>

			<!-- <form method="post" action="options.php">
				<?php
					// settings_fields( 'year_site_fees_option_group' );
					// do_settings_sections( 'year-site-fees-admin' );
					// submit_button();
				?>
			</form> -->
		</div>
	<?php }

	public function year_site_fees_page_init() {
		register_setting(
			'year_site_fees_option_group', // option_group
			'year_site_fees_option_name', // option_name
			array( $this, 'year_site_fees_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'year_site_fees_setting_section', // id
			'Settings', // title
			array( $this, 'year_site_fees_section_info' ), // callback
			'year-site-fees-admin' // page
		);

		add_settings_field(
			'year_0', // id
			'year', // title
			array( $this, 'year_0_callback' ), // callback
			'year-site-fees-admin', // page
			'year_site_fees_setting_section' // section
		);
	}

	public function year_site_fees_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['year_0'] ) ) {
			$sanitary_values['year_0'] = sanitize_text_field( $input['year_0'] );
		}

		return $sanitary_values;
	}

	public function year_site_fees_section_info() {
		
	}

	public function year_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="year_site_fees_option_name[year_0]" id="year_0" value="%s">',
			isset( $this->year_site_fees_options['year_0'] ) ? esc_attr( $this->year_site_fees_options['year_0']) : ''
		);
	}

}
if ( is_admin() )
	$year_site_fees = new TicketSiteFees();

/* 
 * Retrieve this value with:
 * $year_site_fees_options = get_option( 'year_site_fees_option_name' ); // Array of All Options
 * $year_0 = $year_site_fees_options['year_0']; // year
 */
