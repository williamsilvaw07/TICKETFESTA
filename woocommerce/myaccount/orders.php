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
				echo '<h5>' . esc_html(mb_substr($event_post->post_title, 0, 60)) . (mb_strlen($event_post->post_title) > 60 ? '...' : '') . '</h5>';

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
    // Only display the formatted order total without item count.
    echo wp_kses_post( $order->get_formatted_order_total() );
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



<script>
jQuery(document).ready(function($) {
    $('.order_event_image').each(function() {
        var $this = $(this); // Cache the current .order_event_image element
        var imgSrc = $this.find('img').attr('src'); // Get the source of the contained image

        // Check if the glass-effect background already exists to avoid duplicates
        if ($this.children('.glass-effect-background').length === 0) {
            // Create a new div for the glass-effect background
            var glassEffectDiv = $('<div class="glass-effect-background"></div>').css({
                'position': 'absolute',
                'top': 0,
                'left': 0,
                'width': '100%',
                'height': '100%',
                'background-image': 'url(' + imgSrc + ')',
                'background-size': 'cover',
                'background-position': 'center center',
				'background-position': 'center center',
                'filter': 'blur(30px)',
                'z-index': '0',
                'border-radius': '8px', // Optional: adds rounded corners to the glass effect background
                'border': '1px solid rgba(255, 255, 255, 0.18)' // Optional: adds a subtle border for more glass-like realism
            });

            // Insert the glass effect div as the first child of the .order_event_image element
            $this.prepend(glassEffectDiv);

            // Adjust the .order_event_image container styling
            $this.css({
                'position': 'relative',
                'overflow': 'hidden'
            });

            // Ensure the original image remains clear and above the glass effect background
            $this.find('img').css({
                'position': 'relative',
                'z-index': '2'
            });
        }
    });
});




</script>




<style>

tr.woocommerce-orders-table__row , thead tr{
    display: flex;
    width: 100%;
    align-content: center;
    align-items: center;
}

.woocommerce-orders-table__cell-order-number , th.woocommerce-orders-table__header-order-number{
	flex: 0 0 70%
}

.woocommerce-orders-table__cell-order-date , .woocommerce-orders-table__cell-order-total , .woocommerce-orders-table__cell-order-actions , .woocommerce-orders-table__header-order-actions , .woocommerce-orders-table__header-order-date , .woocommerce-orders-table__header-order-total{
	flex: 1
}

.woocommerce-orders-table__cell-order-total .woocommerce-Price-amount{
	font-size: 17px!important;
    font-weight: 600!important;
}
.woocommerce table.shop_table td {
    text-align: center;
}

.woocommerce table.shop_table th{
	padding-right:0!important;
    text-align: center;
}
.woocommerce table.my_account_orders .button {
    white-space: nowrap;
    font-size: 12px!important;
    padding: 5px 15px !important;
    border-radius: 4px!important;
	padding-bottom: 3px!important;
}
.woocommerce table.my_account_orders .button:hover{
	background: #d3fa16!important;
    color: #000000!important;
}
.woocommerce table.shop_table .woocommerce-orders-table__header-order-number{
	text-align: left!important;
}
.oder_nm_link_main{
	display:none
}

.order_event_container{
    display: flex;
    flex-direction: row;
    align-content: center;
    justify-content: flex-start;
    align-items: center;
    gap: 15px;
	padding: 15px 0


}


.order_event_image {
    width: 100%;
    height: 100%;
    max-width: 250px;
    max-height: 200px;
}



.order_event_image::before {

}
.order_event_image{
	border-radius: 6px;
	display: flex;
    align-content: center;
    justify-content: center;
    align-items: center;
	
}

.order_event_image img{
    width: 100%;
    max-width: 200px!important;
	max-height: 150px;
	object-fit: contain;
}

.order_event_details{
	display: flex;
    flex-direction: column;
    align-content: center;
    justify-content: space-between;
    gap: 8px;
	text-align: left;
	
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
.woocommerce-orders-table__header-order-status , .woocommerce-orders-table__cell-order-status{
	display:none!important
}



@media (max-width: 1350x) {
	.order_event_image {
    width: 100%;
    height: 100%;
    max-width: 175px;
    max-height: 130px;
}

}

@media (max-width: 1294px) {
	.woocommerce-orders-table__cell-order-number , th.woocommerce-orders-table__header-order-number{
	flex: 0 0 50%
}

.woocommerce-orders-table__cell-order-date , .woocommerce-orders-table__cell-order-total , .woocommerce-orders-table__cell-order-actions , .woocommerce-orders-table__header-order-actions , .woocommerce-orders-table__header-order-date , .woocommerce-orders-table__header-order-total{
	flex: 1
}

}

@media (max-width: 1180px) {
	.order_event_container {

    flex-wrap: wrap;
}

}


@media (max-width: 950px) {
	tr.woocommerce-orders-table__row {
    display: flex!important
    width: 100%;
    align-content: center;
    flex-direction: column;
}
thead{
display:none!important
}
.woocommerce-orders-table__cell-order-date:before{
	content: "Transaction Date"!important;
    font-size: 15px;
    font-weight: 900;
}
.woocommerce-orders-table__cell-order-total:before{
	content: "Total";
    font-size: 15px;
    font-weight: 900;
}
.woocommerce-orders-table__cell-order-tota , .woocommerce-orders-table__cell-order-date , .woocommerce-orders-table__cell-order-total , .woocommerce-orders-table__cell-order-actions{
	display: flex!important;
    text-align: right!important;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
html .woocommerce-account .woocommerce-orders-table__cell {
	padding-bottom:5px!important;
	padding-top:0!important;
}

.order_event_container {
    justify-content: center;

	padding-bottom: 0px!important;
}
.woocommerce-orders-table__cell-order-number:before , .woocommerce-orders-table__cell-order-actions:before{
	display:none!important
}
.order_event_details {
	align-items: center;
}
body .woocommerce-orders-table__cell-order-total{
	padding-bottom:10px!important
}


.woocommerce table.shop_table td {
    text-align: center;
    font-size: 16px!important;
}

}













	</style>