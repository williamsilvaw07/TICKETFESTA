<?php
// Don't load directly
defined( 'WPINC' ) or die;

/**
 * My Events Column for Organizer Display
 *
 * Override this template in your own theme by creating a file at
 * [your-theme]/tribe-events/community/columns/organizer.php
 *
 * @link https://evnt.is/1ao4 Help article for Community Events & Tickets template files.
 *
 * @since 4.5
 * @since 4.8.2 Updated template link.
 *
 * @version 4.8.2
 */
		

// Assuming $event->ID is the current event ID
$event_id = $event->ID;
$tickets = Tribe__Tickets__Tickets::get_all_event_tickets( $event_id );
$gross_income = 0;

foreach ( $tickets as $ticket ) {
    $gross_income += $ticket->qty_sold() * $ticket->price;
}

echo '<div class="report_gross_income">' . tribe_format_currency( $gross_income ) . '</div>';
?>
 <div class="report_sales">
 <a class="bold_s_heading_btn" href="<?php echo esc_url( home_url( '/organizer-sales-report/?event_id=' . $event->ID ) ); ?>">View Report</a>
    </div>
		