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

        $yearly_site_fees = $this->get_yearly_total_site_fees();
        $monthly_site_fees = $this->get_monthly_total_site_fees();
        $weekly_site_fees = $this->get_weekly_total_site_fees();
        $daily_site_fees = $this->get_daily_total_site_fees();

        ?>
		<div class="wrap">
			<h2> Site Fees</h2>
			<p> Yearly Site Fees:  £<?php  echo $yearly_site_fees;?></p>
			<p> Monthly Site Fees:  £<?php  echo $monthly_site_fees;?></p>
			<p> Weekly Site Fees:  £<?php  echo $weekly_site_fees;?></p>
			<p> Daily Site Fees:  £<?php  echo $daily_site_fees;?></p>
			<?php settings_errors(); ?>
		</div>
	<?php 

}


    // retrive yearly site fees from database
    function get_yearly_total_site_fees(){
    
        // Define the start and end dates for the one-year range
        $start_date = date('Y-m-d', strtotime('-1 year')); // One year ago from today
        $end_date = date('Y-m-d'); // Today's date
        
        $order_ids = $this->get_order_id_by_time_range($start_date, $end_date);
        return $this->get_site_fees_total($order_ids);
    }

    // retrive monthly site fees from database
    function get_monthly_total_site_fees(){
    
        // Define the start and end dates for the one-month range
        $start_date = date('Y-m-d', strtotime('-1 month')); // One month ago from today
        $end_date = date('Y-m-d'); // Today's date
        
        $order_ids = $this->get_order_id_by_time_range($start_date, $end_date);
        return $this->get_site_fees_total($order_ids);
    }


    // retrive weekly site fees from database
    function get_weekly_total_site_fees(){
    
        // Define the start and end dates for the one-week range
        $start_date = date('Y-m-d', strtotime('-1 week')); // One week ago from today
        $end_date = date('Y-m-d'); // Today's date
        
        $order_ids = $this->get_order_id_by_time_range($start_date, $end_date);
        return $this->get_site_fees_total($order_ids);
    }


    function get_daily_total_site_fees(){
    
        // Define the start and end dates for the one-day range
        $start_date = date('Y-m-d', strtotime('-24 hour')); // One day ago from today
        $end_date = date('Y-m-d'); // Today's date
        
        $order_ids = $this->get_order_id_by_time_range($start_date, $end_date);
        return $this->get_site_fees_total($order_ids);
    }
    function get_order_id_by_time_range($start_date, $end_date){
        global $wpdb;
        $order_ids = [];
        // Prepare the SQL query
        $query = $wpdb->prepare("
            SELECT ID
            FROM {$wpdb->prefix}posts
            WHERE post_type = 'shop_order'
            AND post_status IN ('wc-completed', 'wc-processing', 'wc-on-hold')
            AND post_date >= %s
            AND post_date <= %s
        ", $start_date, $end_date);
        
        // Execute the query to get all order IDs within the one-year range
        $order_ids = $wpdb->get_col($query);
        return $order_ids;
    }

    // calculate site fees from order id array
    function get_site_fees_total($order_ids = []){
        $total_fee = 0;
        foreach($order_ids as $order_id){
            $order = wc_get_order($order_id);
            $fees = $order->get_fees();
            if (!empty($fees)) {
                foreach ($fees as $fee) {
                    $total_fee += (float)$fee->get_total();
                }
            }
        } 
        return  $total_fee;  
    }


}
if ( is_admin() ){
	$year_site_fees = new TicketSiteFees();
}
