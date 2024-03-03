<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders );

// Display the shortcode content.
echo do_shortcode('[user_order_tickets]');

if ( $has_orders ) : 
    // Your code for displaying orders goes here.
    // This typically involves a loop through each order and displaying its details.

    // Example:
    /*
    foreach ( $customer_orders->orders as $customer_order ) {
        $order      = wc_get_order( $customer_order ); // Get the order object.
        $item_count = $order->get_item_count(); // Get item count in order.

        echo '<div class="order">';
        echo '<h3>Order Number: ' . $order->get_order_number() . '</h3>';
        echo '<p>Order Date: ' . wc_format_datetime( $order->get_date_created() ) . '</p>';
        echo '<p>Order Status: ' . wc_get_order_status_name( $order->get_status() ) . '</p>';
        echo '<p>Items: ' . $item_count . '</p>';
        echo '</div>';
    }
    */
endif;

do_action( 'woocommerce_after_account_orders', $has_orders );
?>
