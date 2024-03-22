<?php
// Assuming $event_id is the ID of the event for which you want to display tickets
$event_id = get_the_ID(); // Replace with the actual event ID

$args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key' => '_tribe_wooticket_for_event',
            'value' => $event_id,
        ),
    ),
);

$event_tickets = new WP_Query($args);

$overall_tickets_sold = 0;
$overall_capacity = 0;

if ($event_tickets->have_posts()) {
    while ($event_tickets->have_posts()) {
        $event_tickets->the_post();
        $ticket_id = get_the_ID();
        $ticket_capacity = tribe_tickets_get_capacity($ticket_id);

        // Add the capacity of each ticket type to the overall capacity
        $overall_capacity += $ticket_capacity;

        $total_tickets_sold = 0;
        $total_refunded_tickets = 0;

        $orders = wc_get_orders(array(
            'status' => array('completed', 'refunded'),
            'limit' => -1,
            'type' => 'shop_order',
        ));

        foreach ($orders as $order) {
            if (!($order instanceof WC_Order)) {
                continue;
            }

            foreach ($order->get_items() as $item) {
                $product_id = $item->get_product_id();

                if ($product_id == $ticket_id) {
                    $quantity = $item->get_quantity();

                    if ($order->get_status() === 'completed') {
                        $total_tickets_sold += $quantity;
                    } elseif ($order->get_status() === 'refunded') {
                        $total_refunded_tickets += $quantity;
                    }
                }
            }
        }

        $total_tickets_sold = max($total_tickets_sold - $total_refunded_tickets, 0);
        $overall_tickets_sold += $total_tickets_sold;
    }

    wp_reset_postdata();
}

        // echo "XXXXXX</td><td>";
// Display the overall tickets sold and total capacity
echo "<span class='overall-info'> $overall_tickets_sold / $overall_capacity</span>";
?>
