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

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>

	<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
		<thead>
			<tr>
				<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
					<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<?php
			foreach ( $customer_orders->orders as $customer_order ) {
				$order      = wc_get_order( $customer_order ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				$item_count = $order->get_item_count() - $order->get_item_count_refunded();
				?>
				<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order">
					<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
						<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
								<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

						






								

								<?php elseif ( 'order-number' === $column_id ) : ?>
    <a class="oder_nm_link_main"href="<?php echo esc_url( $order->get_view_order_url() ); ?>">
        <?php echo esc_html( _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number() ); ?>
    </a>
    <?php
    // Loop through each order item
    $items = $order->get_items();
    foreach ($items as $item_id => $item) {
        // Retrieve the associated event ID for the product
        $product_id = $item->get_product_id();
        $event_id = get_post_meta($product_id, '_tribe_wooticket_for_event', true);

        if (!empty($event_id)) {
            // Optionally, fetch and display the event title or other information
            $event_post = get_post($event_id);
            if ($event_post) {
                // Display the event title inside the same div as h4
                echo '<div class="order_event_container">';
                echo '<div class="order_event_image">';
                // If an event ID is found, fetch and display the event's featured image
                $event_image_id = get_post_thumbnail_id($event_id);
                if ($event_image_id) {
                    $event_image_url = wp_get_attachment_image_url($event_image_id, 'full');
                    if ($event_image_url) {
                        echo '<img src="' . esc_url($event_image_url) . '" alt="Event Image" style="width:100%;max-width:300px;">';
                    }
                }
                echo '</div>'; // Close the order_event_image div

                echo '<div class="order_event_details">';
				echo '<h5>' . esc_html($event_post->post_title) . '</h5>';
                // Display the order number
                echo '<p><span class="event_order_number_title">order number: </span>' . esc_html( _x( '#', 'order number label', 'woocommerce' ) . $order->get_order_number() ) . '</p>';
                // Fetch the event start date and time
                $event_start_date = get_post_meta($event_id, '_EventStartDate', true);
                // Format the date and time for display
                // Adjust the date format string as needed
                if ($event_start_date) {
					$formatted_date = date_i18n('d M Y, H:i', strtotime($event_start_date));

                    echo '<p><span class="event_date_title">Event Date: </span>' . esc_html($formatted_date) . '</p>';
                }
                // Display the product name and quantity together
				echo '<p><span class="ticket_type_title">Ticket Type: </span>' . esc_html($item->get_name()) . ' x ' . esc_html($item->get_quantity()) . '</p>';

               
                echo '</div>'; // Close the order_event_details div

                echo '</div>'; // Close the order_event_container div
            }
        } else {
            // If no event ID is found, optionally display a placeholder or message
            echo '<p>No associated event found.</p>';
        }
    }
    ?>








							<?php elseif ( 'order-date' === $column_id ) : ?>
								<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>

							<?php elseif ( 'order-status' === $column_id ) : ?>
								<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>

							<?php elseif ( 'order-total' === $column_id ) : ?>
								<?php
								/* translators: 1: formatted order total 2: total order items */
								echo wp_kses_post( sprintf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ) );
								?>

							<?php elseif ( 'order-actions' === $column_id ) : ?>
								<?php
								$actions = wc_get_account_orders_actions( $order );

								if ( ! empty( $actions ) ) {
									foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
										echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button' . esc_attr( $wp_button_class ) . ' button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
									}
								}
								?>
							<?php endif; ?>
						</td>
					<?php endforeach; ?>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>

	<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

	<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
		<div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
			<?php if ( 1 !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button<?php echo esc_attr( $wp_button_class ); ?>" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'woocommerce' ); ?></a>
			<?php endif; ?>

			<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
				<a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button<?php echo esc_attr( $wp_button_class ); ?>" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php else : ?>

	<?php wc_print_notice( esc_html__( 'No order has been made yet.', 'woocommerce' ) . ' <a class="woocommerce-Button wc-forward button' . esc_attr( $wp_button_class ) . '" href="' . esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ) . '">' . esc_html__( 'Browse products', 'woocommerce' ) . '</a>', 'notice' ); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment ?>

<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>








<style>


.oder_nm_link_main{
	display:none
}

.order_event_container{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-content: center;
    justify-content: flex-start;
    align-items: center;
    gap: 15px;


}


.order_event_image img{
    width: 100%;
    max-width: 200px!important;
    border-radius: 6px
}

.order_event_details{
	display: flex;
    flex-direction: column;
    align-content: center;
    justify-content: space-between;
    gap: 11px;
}

.order_event_details h5{
	font-weight: 600;
    font-size: 17px;
    margin: 0;
}


.order_event_details p{
    margin: 0;
}
.order_event_details span{
	font-weight: 600;
    text-transform: capitalize;
}

	</style>