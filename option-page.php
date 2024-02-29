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
        global $wpdb;

        // Replace <your_order_id_here> with the actual order ID
        $order_id = 4297;

        // Prepare the SQL query
        // $query = $wpdb->prepare("
        //     SELECT meta_value
        //     FROM {$wpdb->prefix}woocommerce_order_itemmeta
        //     WHERE order_item_id = (
        //         SELECT order_item_id
        //         FROM {$wpdb->prefix}woocommerce_order_items
        //         WHERE order_id = %d
        //     )
        //     AND meta_key = '_order_total'
        // ", $order_id);

        $query = $wpdb->prepare("

            SELECT order_item_id
            FROM {$wpdb->prefix}woocommerce_order_items
            WHERE order_id = %d
        
    ", $order_id);
        // Execute the query
        $order_fee = $wpdb->get_var($query);

        // Check if the order fee is retrieved successfully
        if ($order_fee !== null) {
            echo "Order Fee: $order_fee";
        } else {
            echo "Order fee not found for order ID: $order_id";
        }

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
