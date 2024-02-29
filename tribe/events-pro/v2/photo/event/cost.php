<?php
/**
 * View: Photo View - Single Event Cost
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-pro/v2/photo/event/cost.php
 *
 * See more documentation about our views templating system.
 *
 * @link https://evnt.is/1aiy
 *
 * @version 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

if ( empty( $event->cost ) ) {
	return;
}

$prices = explode(' – ', $event->cost); // Split prices by the dash
if (count($prices) > 1) {
    $formatted_price = 'From ' . esc_html($prices[0]) . ' – ' . esc_html($prices[1]); // Add "From" if there is a price range
} else {
    $formatted_price = esc_html($event->cost); // Use the original price if it's a single price
}
?>
<div class="tribe-events-c-small-cta tribe-common-b3 tribe-events-pro-photo__event-cost">
    <span class="tribe-events-c-small-cta__price">
        
    </span>
</div>
