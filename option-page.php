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

// Define the start and end dates for the one-year range
$start_date = date('Y-m-d', strtotime('-1 year')); // One year ago from today
$end_date = date('Y-m-d'); // Today's date

// Prepare the SQL query
$query = $wpdb->prepare("
    SELECT ID
    FROM {$wpdb->prefix}posts
    WHERE post_type = 'shop_order'
    AND post_status IN ('wc-completed', 'wc-processing', 'wc-on-hold') -- You can adjust the post statuses as needed
    AND post_date >= %s
    AND post_date <= %s
", $start_date, $end_date);

// Execute the query to get all order IDs within the one-year range
$order_ids = $wpdb->get_col($query);

// Output the order IDs
if (!empty($order_ids)) {
    echo "Order IDs within the one-year range: " . implode(', ', $order_ids);
} else {
    echo "No orders found within the one-year range.";
}


        ?>
		<div class="wrap">
			<h2> Site Fees</h2>
			<p></p>
			<?php settings_errors(); ?>

			
		</div>
	<?php 
    
    $order_id = 4297;

    // Get order meta
    $order_meta = get_post_meta($order_id);
    
    // Output order meta
    if (!empty($order_meta)) {
        echo "Order Meta for Order ID $order_id:<br>";
        foreach ($order_meta as $meta_key => $meta_values) {
            echo "$meta_key: " . implode(', ', $meta_values) . "<br>";
        }
    } else {
        echo "No order meta found for order ID: $order_id";
    }
    

}

    // Replace <your_order_id_here> with the actual order ID


}
if ( is_admin() )
	$year_site_fees = new TicketSiteFees();

/* 
 * Retrieve this value with:
 * $year_site_fees_options = get_option( 'year_site_fees_option_name' ); // Array of All Options
 * $year_0 = $year_site_fees_options['year_0']; // year
 */
