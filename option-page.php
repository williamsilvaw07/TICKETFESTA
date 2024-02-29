<?php
/**
 * this class calculate and show yearly, monthly and weekly fees for site fees
 */

class TicketSiteFees {
	private $year_site_fees_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'year_site_fees_add_plugin_page' ) );
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

			
		</div>
	<?php }

}
if ( is_admin() )
	$year_site_fees = new TicketSiteFees();

/* 
 * Retrieve this value with:
 * $year_site_fees_options = get_option( 'year_site_fees_option_name' ); // Array of All Options
 * $year_0 = $year_site_fees_options['year_0']; // year
 */
